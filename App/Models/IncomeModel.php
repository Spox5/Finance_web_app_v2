<?php

namespace App\Models;

use PDO;
use \Core\View;
use App\Models\User;



class IncomeModel extends \Core\Model
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
	
	public function saveIncome($id)
	{
		
		if (empty($this->errors)) {
			
			$sql = 'INSERT INTO incomes (user_id, income_category_assigned_to_user_id, amount, 		date_of_income, income_comment) VALUES (:user_id, :category, :amount, :date_of_income, :income_comment)';
					
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':category', $this->category, PDO::PARAM_STR);
			$stmt->bindValue(':amount', $this->amount, PDO::PARAM_INT);
			$stmt->bindValue(':date_of_income', $this->date, PDO::PARAM_STR);
			$stmt->bindValue(':income_comment', $this->comment, PDO::PARAM_STR);
			
			return $stmt->execute();
			
		}
		
		return false;
	}
	
	public static function findIncomeCategoryById($id)
	{
		$sql = 'SELECT id, name FROM incomes_category_assigned_to_users WHERE user_id = :id';
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
		
}