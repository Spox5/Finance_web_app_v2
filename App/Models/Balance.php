<?php

namespace App\Models;

use PDO;
use \Core\View;
use App\Models\User;
use \App\BalanceSummaryMessage;

class Balance extends \Core\Model
{
	//error messages
	public $errors = [];
	
	public static function showIncomesCurrentMonth($id)
	{
		$current_month = date('m');
		
		$sql = "SELECT * FROM incomes AS i, incomes_category_assigned_to_users AS i_c WHERE i.user_id = i_c.user_id AND i.income_category_assigned_to_user_id = i_c.id AND i.user_id = :id AND (MONTH (i.date_of_income) = $current_month) ORDER BY date_of_income DESC";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public static function showExpensesCurrentMonth($id)
	{
		$current_month = date('m');
		
		$sql = "SELECT * FROM expenses AS e, expenses_category_assigned_to_users AS e_c, payment_methods_assigned_to_users AS p_m WHERE e.user_id = p_m.user_id AND e.user_id = e_c.user_id AND e.expense_category_assigned_to_user = e_c.id AND e.payment_method_assigned_to_user = p_m.id AND e.user_id = :id AND (MONTH (e.date_of_expense) = $current_month) ORDER BY date_of_expense DESC";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public static function showIncomesPreviousMonth($id)
	{
		$current_month = date('m');
		
		$sql = "SELECT * FROM incomes AS i, incomes_category_assigned_to_users AS i_c WHERE i.user_id = i_c.user_id AND i.income_category_assigned_to_user_id = i_c.id AND i.user_id = :id AND (MONTH (i.date_of_income) = $current_month - 1) ORDER BY date_of_income DESC";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public static function showExpensesPreviousMonth($id)
	{
		$current_month = date('m');
		
		$sql = "SELECT * FROM expenses AS e, expenses_category_assigned_to_users AS e_c, payment_methods_assigned_to_users AS p_m WHERE e.user_id = p_m.user_id AND e.user_id = e_c.user_id AND e.expense_category_assigned_to_user = e_c.id AND e.payment_method_assigned_to_user = p_m.id AND e.user_id = :id AND (MONTH (e.date_of_expense) = $current_month - 1) ORDER BY date_of_expense DESC";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public static function showIncomesPresentYear($id)
	{
		$present_year = date('Y');
		
		$sql = "SELECT * FROM incomes AS i, incomes_category_assigned_to_users AS i_c WHERE i.user_id = i_c.user_id AND i.income_category_assigned_to_user_id = i_c.id AND i.user_id = :id AND (YEAR (i.date_of_income) = $present_year) ORDER BY date_of_income DESC";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public static function showExpensesPresentYear($id)
	{
		$present_year = date('Y');
		
		$sql = "SELECT * FROM expenses AS e, expenses_category_assigned_to_users AS e_c, payment_methods_assigned_to_users AS p_m WHERE e.user_id = p_m.user_id AND e.user_id = e_c.user_id AND e.expense_category_assigned_to_user = e_c.id AND e.payment_method_assigned_to_user = p_m.id AND e.user_id = :id AND (YEAR (e.date_of_expense) = $present_year) ORDER BY date_of_expense DESC";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public static function showIncomesUserPeriod($id, $date1, $date2)
	{
		
		
		$sql = "SELECT i.user_id, i.amount, i.date_of_income, i.id, i.income_comment, i_c.name FROM incomes AS i, incomes_category_assigned_to_users AS i_c WHERE i.user_id = i_c.user_id AND i.income_category_assigned_to_user_id = i_c.id AND i.date_of_income >= :date1 AND i.date_of_income <= :date2 AND i.user_id = :id ORDER BY date_of_income DESC";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':date1', $date1, PDO::PARAM_STR);
		$stmt->bindValue(':date2', $date2, PDO::PARAM_STR);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public static function showExpensesUserPeriod($id, $date1, $date2)
	{
		
		
		$sql = "SELECT e_c.name, p_m.payment_name, e.amount, e.date_of_expense, e.expense_comment FROM expenses as e, payment_methods_assigned_to_users as p_m, expenses_category_assigned_to_users as e_c WHERE e.user_id = p_m.user_id AND e.user_id = e_c.user_id AND e.expense_category_assigned_to_user = e_c.id AND e.payment_method_assigned_to_user = p_m.id AND e.user_id = :id AND e.date_of_expense >= :date1 AND e.date_of_expense <= :date2 ORDER BY date_of_expense DESC";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':date1', $date1, PDO::PARAM_STR);
		$stmt->bindValue(':date2', $date2, PDO::PARAM_STR);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	

	
	public static function showBalanceSummary($id)
	{
		$current_month = date('m');
		
		$sql_income = "SELECT SUM(amount) as income_summary FROM incomes WHERE user_id = :id AND (MONTH (incomes.date_of_income) = $current_month)";
		
		$sql_expense = "SELECT SUM(amount) as expense_summary FROM expenses WHERE user_id = :id AND (MONTH (expenses.date_of_expense) = $current_month)";
		
		$db = static::getDB();
		
		$stmt_income = $db->prepare($sql_income);
		$stmt_income->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt_income->execute();
		$income_result = $stmt_income->fetch(PDO::FETCH_ASSOC);
		
		$stmt_expense = $db->prepare($sql_expense);
		$stmt_expense->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt_expense->execute();
		$expense_result = $stmt_expense->fetch(PDO::FETCH_ASSOC);
		
		$balance = $income_result['income_summary'] - $expense_result['expense_summary'];
		
		unset($_SESSION['summary_message']);
		
		if ($balance > 0)
		{
			
			BalanceSummaryMessage::addMessageCurrent('Gratulacje! Świetnie zarządzasz finansami!', BalanceSummaryMessage::GOOD);
		}
		else if ($balance == 0)
		{
			BalanceSummaryMessage::addMessageCurrent('W tym okresie nie masz żadnych wydatków.');
		}
		else 
			BalanceSummaryMessage::addMessageCurrent('Uważaj! Popadasz w długi!', BalanceSummaryMessage::BAD);
		
		return $balance;
	}
	
	public static function showBalancePreviousMonthSummary($id)
	{
		$current_month = date('m');
		
		$sql_income = "SELECT SUM(amount) as income_summary FROM incomes WHERE user_id = :id AND (MONTH (incomes.date_of_income) = $current_month - 1)";
		
		$sql_expense = "SELECT SUM(amount) as expense_summary FROM expenses WHERE user_id = :id AND (MONTH (expenses.date_of_expense) = $current_month - 1)";
		
		$db = static::getDB();
		
		$stmt_income = $db->prepare($sql_income);
		$stmt_income->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt_income->execute();
		$income_result = $stmt_income->fetch(PDO::FETCH_ASSOC);
		
		$stmt_expense = $db->prepare($sql_expense);
		$stmt_expense->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt_expense->execute();
		$expense_result = $stmt_expense->fetch(PDO::FETCH_ASSOC);
		
		$balance = $income_result['income_summary'] - $expense_result['expense_summary'];
		
		if ($balance > 0)
			BalanceSummaryMessage::addMessagePrevious('Gratulacje! Świetnie zarządzasz finansami!', BalanceSummaryMessage::GOOD);
		else if ($balance == 0)
			BalanceSummaryMessage::addMessagePrevious('W tym okresie nie masz żadnych wydatków.');
		else 
			BalanceSummaryMessage::addMessagePrevious('Uważaj! Popadasz w długi!', BalanceSummaryMessage::BAD);
		
		return $balance;
	}
	
	public static function showBalancePresentYearSummary($id)
	{
		$present_year = date('Y');
		
		$sql_income = "SELECT SUM(amount) as income_summary FROM incomes WHERE user_id = :id AND (YEAR (incomes.date_of_income) = $present_year)";
		
		$sql_expense = "SELECT SUM(amount) as expense_summary FROM expenses WHERE user_id = :id AND (YEAR (expenses.date_of_expense) = $present_year)";
		
		$db = static::getDB();
		
		$stmt_income = $db->prepare($sql_income);
		$stmt_income->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt_income->execute();
		$income_result = $stmt_income->fetch(PDO::FETCH_ASSOC);
		
		$stmt_expense = $db->prepare($sql_expense);
		$stmt_expense->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt_expense->execute();
		$expense_result = $stmt_expense->fetch(PDO::FETCH_ASSOC);
		
		$balance = $income_result['income_summary'] - $expense_result['expense_summary'];
		
		if ($balance > 0)
			BalanceSummaryMessage::addMessagePresentYear('Gratulacje! Świetnie zarządzasz finansami!', BalanceSummaryMessage::GOOD);
		else if ($balance == 0)
			BalanceSummaryMessage::addMessagePresentYear('W tym okresie nie masz żadnych wydatków.');
		else 
			BalanceSummaryMessage::addMessagePresentYear('Uważaj! Popadasz w długi!', BalanceSummaryMessage::BAD);
		
		return $balance;
	}
	
	public static function showBalanceUserPeriodSummary($id, $date1, $date2)
	{
		
		
		$sql_income = "SELECT SUM(amount) as income_summary FROM incomes WHERE user_id = :id AND incomes.date_of_income >= :date1 AND incomes.date_of_income <= :date2";
		
		$sql_expense = "SELECT SUM(amount) as expense_summary FROM expenses WHERE user_id=:id AND expenses.date_of_expense >= :date1 AND expenses.date_of_expense <= :date2";
		
		$db = static::getDB();
		
		$stmt_income = $db->prepare($sql_income);
		$stmt_income->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt_income->bindValue(':date1', $date1, PDO::PARAM_STR);
		$stmt_income->bindValue(':date2', $date2, PDO::PARAM_STR);
		$stmt_income->execute();
		$income_result = $stmt_income->fetch(PDO::FETCH_ASSOC);
		
		$stmt_expense = $db->prepare($sql_expense);
		$stmt_expense->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt_expense->bindValue(':date1', $date1, PDO::PARAM_STR);
		$stmt_expense->bindValue(':date2', $date2, PDO::PARAM_STR);
		$stmt_expense->execute();
		$expense_result = $stmt_expense->fetch(PDO::FETCH_ASSOC);
		
		$balance = $income_result['income_summary'] - $expense_result['expense_summary'];
		
		if ($balance > 0)
			BalanceSummaryMessage::addMessageUserPeriod('Gratulacje! Świetnie zarządzasz finansami!', BalanceSummaryMessage::GOOD);
		else if ($balance == 0)
			BalanceSummaryMessage::addMessageUserPeriod('W tym okresie nie masz żadnych wydatków.');
		else 
			BalanceSummaryMessage::addMessageUserPeriod('Uważaj! Popadasz w długi!', BalanceSummaryMessage::BAD);
		
		return $balance;
	}
	
	
	public static function showPieChartCurrentMonth($id)
	{
		$current_month = date('m');
		
		$sql = "SELECT e_c.name, SUM(e.amount) AS sum FROM expenses_category_assigned_to_users AS e_c, expenses AS e WHERE e.user_id = e_c.user_id AND e.expense_category_assigned_to_user = e_c.id AND e.user_id = :id AND (MONTH (e.date_of_expense) = $current_month) GROUP BY e_c.name";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public static function showPieChartPreviousMonth($id)
	{
		$current_month = date('m');
		
		$sql = "SELECT e_c.name, SUM(e.amount) AS sum FROM expenses_category_assigned_to_users AS e_c, expenses AS e WHERE e.user_id = e_c.user_id AND e.expense_category_assigned_to_user = e_c.id AND e.user_id = :id AND (MONTH (e.date_of_expense) = $current_month - 1) GROUP BY e_c.name";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public static function showPieChartPresentYear($id)
	{
		$present_year = date('Y');
		
		$sql = "SELECT e_c.name, SUM(e.amount) AS sum FROM expenses_category_assigned_to_users AS e_c, expenses AS e WHERE e.user_id = e_c.user_id AND e.expense_category_assigned_to_user = e_c.id AND e.user_id = :id AND (YEAR (e.date_of_expense) = $present_year) GROUP BY e_c.name";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}
	
	public static function showPieChartUserPeriod($id, $date1, $date2)
	{
		$sql = "SELECT e_c.name, SUM(e.amount) AS sum FROM expenses_category_assigned_to_users AS e_c, expenses AS e WHERE e.user_id = e_c.user_id AND e.expense_category_assigned_to_user = e_c.id AND e.user_id = :id AND e.date_of_expense >= :date1 AND e.date_of_expense <= :date2 GROUP BY e_c.name";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':date1', $date1, PDO::PARAM_STR);
		$stmt->bindValue(':date2', $date2, PDO::PARAM_STR);
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetchAll();
	}

}
