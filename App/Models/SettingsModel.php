<?php

namespace App\Models;

use PDO;

class SettingsModel extends \Core\Model
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
	
	public function saveNewIncomeCategory($id)
	{
		if (empty($this->errors)) {
			
			$sql = 'INSERT INTO incomes_category_assigned_to_users (user_id, name) VALUES (:user_id, :name)';
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':name', $this->new_category, PDO::PARAM_STR);
			
			return $stmt->execute();
			
		}
		
		return false;
	}
	
	public function deleteIncomeCategory($id)
	{
		if (empty($this->errors)) {
			
			$sql = 'DELETE FROM incomes_category_assigned_to_users WHERE id=:id';
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':id', $this->category, PDO::PARAM_INT);
			
			return $stmt->execute();
			
		}
		
		return false;
	}
	
	public function editIncomeCategory($id)
	{
		if (empty($this->errors)) {
			
			$sql = 'UPDATE incomes_category_assigned_to_users SET name = :new_name WHERE user_id = :user_id AND id = :id';
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':new_name', $this->new_name, PDO::PARAM_STR);
			$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':id', $this->category_id, PDO::PARAM_INT);
			
			return $stmt->execute();
			
		}
		
		return false;
	}
	
	public function saveNewExpenseCategory($id)
	{
		if (empty($this->errors)) {
			
			$sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name) VALUES (:user_id, :name)';
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':name', $this->new_category, PDO::PARAM_STR);
			
			return $stmt->execute();
			
		}
		
		return false;
	}
	
	public function deleteExpenseCategory($id)
	{
		if (empty($this->errors)) {
			
			$sql = 'DELETE FROM expenses_category_assigned_to_users WHERE id=:id';
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':id', $this->category, PDO::PARAM_INT);
			
			return $stmt->execute();
			
		}
		
		return false;
	}
	
	public function editExpenseCategory($id)
	{
		if ($this->new_name != '' && isset($this->amount_limit))
		{
			if (empty($this->errors)) {
				
				$sql = 'UPDATE expenses_category_assigned_to_users SET name = :new_name, amount_limit = :limit WHERE user_id = :user_id AND id = :id';
						
				$db = static::getDB();
				$stmt = $db->prepare($sql);
				
				$stmt->bindValue(':new_name', $this->new_name, PDO::PARAM_STR);
				$stmt->bindValue(':limit', $this->amount_limit, PDO::PARAM_INT);
				$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
				$stmt->bindValue(':id', $this->category_id, PDO::PARAM_INT);
				
				return $stmt->execute();
				
			}
			
			return false;
		}
		
		else if ($this->new_name != '' && !isset($this->amount_limit))
		{
			if (empty($this->errors)) {
			
			$sql = 'UPDATE expenses_category_assigned_to_users SET name = :new_name WHERE user_id = :user_id AND id = :id';
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':new_name', $this->new_name, PDO::PARAM_STR);
			$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':id', $this->category_id, PDO::PARAM_INT);
			
			return $stmt->execute();
			
			}
		
		return false;
		}
		else if ($this->new_name == '' && isset($this->amount_limit))
		{
		
			if (empty($this->errors)) {
				
				$sql = 'UPDATE expenses_category_assigned_to_users SET amount_limit = :limit WHERE user_id = :user_id AND id = :id';
						
				$db = static::getDB();
				$stmt = $db->prepare($sql);
				
				$stmt->bindValue(':limit', $this->amount_limit, PDO::PARAM_INT);
				$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
				$stmt->bindValue(':id', $this->category_id, PDO::PARAM_INT);
				
				return $stmt->execute();
				
			}
			
			return false;
		}
		else
		{
			if (empty($this->errors)) {
				
				$sql = 'UPDATE expenses_category_assigned_to_users SET amount_limit = NULL WHERE user_id = :user_id AND id = :id';
						
				$db = static::getDB();
				$stmt = $db->prepare($sql);
				
				$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
				$stmt->bindValue(':id', $this->category_id, PDO::PARAM_INT);
				
				return $stmt->execute();
				
			}
			
			return false;
		}
	}
		
	public function saveNewPaymentMethodCategory($id)
	{
		if (empty($this->errors)) {
			
			$sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, payment_name) VALUES (:user_id, :name)';
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':name', $this->new_category, PDO::PARAM_STR);
			
			return $stmt->execute();
			
		}
		
		return false;
	}
	
	public function deletePaymentMethodCategory($id)
	{
		if (empty($this->errors)) {
			
			$sql = 'DELETE FROM payment_methods_assigned_to_users WHERE id=:id';
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':id', $this->category, PDO::PARAM_INT);
			
			return $stmt->execute();
			
		}
		
		return false;
	}
	
	public function editPaymentMethodCategory($id)
	{
		if (empty($this->errors)) {
			
			$sql = 'UPDATE payment_methods_assigned_to_users SET payment_name = :new_name WHERE user_id = :user_id AND id = :id';
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':new_name', $this->new_name, PDO::PARAM_STR);
			$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':id', $this->category_id, PDO::PARAM_INT);
			
			return $stmt->execute();
			
		}
		
		return false;
	}
}