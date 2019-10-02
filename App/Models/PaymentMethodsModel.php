<?php

namespace App\Models;

use PDO;
use \Core\View;
use App\Models\User;



class PaymentMethodsModel extends \Core\Model
{
	public static function findPaymentMethodsById($id)
	{
		$sql = 'SELECT id, payment_name FROM payment_methods_assigned_to_users WHERE user_id = :id';
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}	
}


	