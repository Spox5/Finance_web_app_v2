<?php

namespace App;

use App\Models\IncomeModel;
use App\Models\ExpenseModel;
use App\Models\PaymentMethodsModel;


class ShowRadioButtons
{
	public static function getIncomeCategory()
	{
		if (isset($_SESSION['user_id'])) {return IncomeModel::findIncomeCategoryById($_SESSION['user_id']);} 
	}
	
	public static function getExpenseCategory()
	{
		if (isset($_SESSION['user_id'])) {return ExpenseModel::findExpenseCategoryById($_SESSION['user_id']);}
	}
	
	public static function getPaymentMethods()
	{
		if (isset($_SESSION['user_id'])) {return PaymentMethodsModel::findPaymentMethodsById($_SESSION['user_id']);}
	}
	
}