<?php

namespace App\Models;

use PDO;
use \App\Token;
use \App\Mail;
use \Core\View;


/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{
	//error messages
	public $errors = [];
	
	//constructor that bind values from form to sql query to database
	public function __construct($data = [])
	{
		foreach ($data as $key => $value) {
			$this->$key = $value;
		};
	}
	
	//Save the user with values (password, nick, email)
	public function save()
	{
		$this->validate();
		
		if (empty($this->errors)) {
		
			$password_hash = password_hash($this->password, PASSWORD_DEFAULT);
			
			$token = new Token();
			$hashed_token = $token->getHash();
			$this->activation_token = $token->getValue();
			
			$sql = 'INSERT INTO users (name, email, password_hash, activation_hash)
					VALUES (:name, :email, :password_hash, :activation_hash)';
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
			$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
			$stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
			$stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);
			
			$stmt->execute();
			
			if ($this->copy_default_expenses() && $this->copy_default_incomes() && $this->copy_default_payment_methods())
				return true;
			
		}
		
		return false;
	}
	
	public function validate()
	{
		//name
		if ($this->name == '') {
			$this->errors[] = 'Należy podać imię';
		}
		
		//email
		if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
			$this->errors[] = 'Niepoprawny adres e-mail';
		}
		if (static::emailExists($this->email, $this->id ?? null)) {
			$this->errors[] = 'Ten adres e-mail jest aktualnie zajęty';
		}
		
		//password
		/* if want password confirmation field uncomment thit
		if ($this->password != $this->password_confirmation) {
			$this->errors[] = 'Hasło oraz hasło potwierdzające muszą być takie same';
		}*/
		
		if (isset($this->password)) {
			
			if (strlen($this->password) < 6) {
				$this->errors[] = 'Hasło musi posiadać przynajmniej 6 znaków';
			}
			
			if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
				$this->errors[] = 'Hasło musi posiadać przynajmniej jedną literę';
			}
			
			if (preg_match('/.*\d+.*/i', $this->password) == 0) {
				$this->errors[] = 'Hasło musi posiadać przynajmniej jedną cyfrę';
			}
		}
	}
	
	public static function emailExists($email, $ignore_id = null)
	{
		$user = static::findByEmail($email);
		
		if ($user) {
			if ($user->id != $ignore_id) {
				return true;
			}
		}
		
		return false;
	}
	
	//find user by email to log in (check password etc.)
	public static function findByEmail($email)
	{
		$sql = 'SELECT * FROM users WHERE email = :email';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetch();
	}
	
	//autjenticate email and password of finding user
	public static function authenticate($email, $password)
	{
		//find user by email
		$user = static::findByEmail($email);
		
		//if we find user, then check password
		if ($user && $user->is_active) {
			if (password_verify($password, $user->password_hash)) {
				return $user;
			}
		}
		
		return false;
	}
	
	//find user from db to use his name or other info
	public static function findByID($id)
	{
		$sql = 'SELECT * FROM users WHERE id = :id';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetch();
	}
	
	//for remember me function
	public function rememberLogin()
	{
		$token = new Token();
		$hashed_token = $token->getHash();
		$this->remember_token = $token->getValue();
		
		$this->expiry_timestamp = time() + 60 * 60 * 24 * 30;//30 days from now
		
		$sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at)
				VALUES (:token_hash, :user_id, :expires_at)';
				
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
		$stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
		$stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);
		
		return $stmt->execute();
	}
	
	public static function sendPasswordReset($email)
	{
		$user = static::findByEmail($email);
		
		if ($user) {
			
			if ($user->startPasswordReset()) {
				
				$user->sendPasswordResetEmail();
				
			}
		}
	}
	
	public function startPasswordReset()
	{
		$token = new Token();
		$hashed_token = $token->getHash();
		$this->password_reset_token = $token->getValue();
		
		$expiry_timestamp = time() + 60 * 60 * 2; //2 hourd after now
		
		$sql = 'UPDATE users
				SET password_reset_hash = :token_hash,
					password_reset_expires_at = :expires_at
				WHERE id = :id';
				
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
		$stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);
		$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
		
		return $stmt->execute();
	}
	
	protected function sendPasswordResetEmail()
	{
		$url = 'http://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $this->password_reset_token;
		
		$text = View::getTemplate('Password/reset_email_content.txt', ['url' => $url]);
		$html = View::getTemplate('Password/reset_email_content.html', ['url' => $url]);
		
		Mail::send($this->email, 'Reset hasła', $text, $html);
	}
	
	public static function findByPasswordReset($token)
	{
		$token = new Token($token);
		$hashed_token = $token->getHash();
		
		$sql = 'SELECT * FROM users
				WHERE password_reset_hash = :token_hash';
				
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		$user = $stmt->fetch();
		
		if ($user) {
			
			//check password reset token hasnt expired
			if (strtotime($user->password_reset_expires_at) > time()) {
				
				return $user;
			}
		}
	}
	
	public function resetPassword($password)
	{
		$this->password = $password;
		
		$this->validate();
		
		if (empty($this->errors)) {
			
			$password_hash = password_hash($this->password, PASSWORD_DEFAULT);
			
			$sql = 'UPDATE users
					SET password_hash = :password_hash,
						password_reset_hash = NULL,
						password_reset_expires_at = NULL
					WHERE id = :id';
			
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
			$stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
			
			return $stmt->execute();
		}
		
		return false;	
	}
	
	public function sendActivationEmail()
	{
		$url = 'http://' . $_SERVER['HTTP_HOST'] . '/signup/activate/' . $this->activation_token;
		
		$text = View::getTemplate('Signup/activation_email_content.txt', ['url' => $url]);
		$html = View::getTemplate('Signup/activation_email_content.html', ['url' => $url]);
		
		Mail::send($this->email, 'Aktywacja konta', $text, $html);
	}
	
	public static function activate($value)
	{
		$token = new Token($value);
		$hashed_token = $token->getHash();
		
		$sql = 'UPDATE users
				SET is_active = 1,
					activation_hash = null
				WHERE activation_hash = :hashed_token';
				
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);
		
		$stmt->execute();
	}
	
	public function updateProfile($data)
	{
		$this->name = $data['name'];
		$this->email = $data['email'];
		
		if ($data['password'] != '') {
			$this->password = $data['password'];
		}
		
		$this->validate();
		
		if (empty($this->errors)) {
			
			$sql = 'UPDATE users
					SET name = :name,
						email = :email';
						
			if (isset($this->password)) {
				$sql .= ', password_hash = :password_hash';
			}
				
			$sql .= "\nWHERE id = :id";
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
			$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
			$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
			
			if (isset($this->password)) {
				$password_hash = password_hash($this->password, PASSWORD_DEFAULT);
				$stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
			}
			
			return $stmt->execute();
		}
		
		return false;
	}
	
	protected function copy_default_expenses()
	{
		$sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name) SELECT users.id, expenses_category_default.name FROM users, expenses_category_default WHERE users.id = (SELECT max(id) FROM users)';
					
		$db = static::getDB();
		$stmt = $db->prepare($sql);
			
		return $stmt->execute();
	}
	
	protected function copy_default_incomes()
	{
		$sql = 'INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT users.id, incomes_category_default.name FROM users, incomes_category_default WHERE users.id = (SELECT max(id) FROM users)';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
			
		return $stmt->execute();
	}
	
	protected function copy_default_payment_methods()
	{
		$sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, payment_name) SELECT users.id, payment_methods_default.payment_name FROM users, payment_methods_default WHERE users.id = (SELECT max(id) FROM users)';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
			
		return $stmt->execute();
	}
}
