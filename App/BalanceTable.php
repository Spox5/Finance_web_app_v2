<?php

namespace App;

use App\Models\Balance;

class BalanceTable
{
	
	public static function getIncomesCurrentMonth()
	{
		if (isset($_SESSION['user_id'])) {
			return Balance::showIncomesCurrentMonth($_SESSION['user_id']);
		}
	}
	public static function getExpensesCurrentMonth()
	{
		if (isset($_SESSION['user_id'])) {
			return Balance::showExpensesCurrentMonth($_SESSION['user_id']);
		}
	}
	
	
	public static function getIncomesPreviousMonth()
	{
		if (isset($_SESSION['user_id'])) {
			return Balance::showIncomesPreviousMonth($_SESSION['user_id']);
		}
	}
	public static function getExpensesPreviousMonth()
	{
		if (isset($_SESSION['user_id'])) {
			return Balance::showExpensesPreviousMonth($_SESSION['user_id']);
		}
	}
	
	
	public static function getIncomesPresentYear()
	{
		if (isset($_SESSION['user_id'])) {
			return Balance::showIncomesPresentYear($_SESSION['user_id']);
		}
	}
	public static function getExpensesPresentYear()
	{
		if (isset($_SESSION['user_id'])) {
			return Balance::showExpensesPresentYear($_SESSION['user_id']);
		}
	}
	
	
	public static function getIncomesUserPeriod()
	{
		if (isset($_SESSION['user_id'], $_SESSION['date1'], $_SESSION['date2'])) {
			return Balance::showIncomesUserPeriod($_SESSION['user_id'], $_SESSION['date1'], $_SESSION['date2']);
		}
	}
	public static function getExpensesUserPeriod()
	{
		if (isset($_SESSION['user_id'], $_SESSION['date1'], $_SESSION['date2'])) {
			return Balance::showExpensesUserPeriod($_SESSION['user_id'], $_SESSION['date1'], $_SESSION['date2']);
		}
	}
	
}