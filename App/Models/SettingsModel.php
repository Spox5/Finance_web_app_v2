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
		
}