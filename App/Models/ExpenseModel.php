<?php

namespace App\Models;

use PDO;
use \Core\View;
use App\Models\User;



class ExpenseModel extends \Core\Model
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
	
	public function saveExpense($id)
	{
		
		if (empty($this->errors)) {
			
			$sql = 'INSERT INTO expenses (user_id, expense_category_assigned_to_user, payment_method_assigned_to_user, amount, date_of_expense, expense_comment) VALUES (:user_id, :category, :payment_method, :amount, :date_of_expense, :expense_comment)';
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':category', $this->category, PDO::PARAM_STR);
			$stmt->bindValue(':payment_method', $this->payment_method, PDO::PARAM_STR);
			$stmt->bindValue(':amount', $this->amount, PDO::PARAM_INT);
			$stmt->bindValue(':date_of_expense', $this->date, PDO::PARAM_STR);
			$stmt->bindValue(':expense_comment', $this->comment, PDO::PARAM_STR);
			
			return $stmt->execute();
			
		}
		
		return false;
	}
	
	public static function findExpenseCategoryById($id)
	{
		$sql = 'SELECT * FROM expenses_category_assigned_to_users WHERE user_id = :id';
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
		
}