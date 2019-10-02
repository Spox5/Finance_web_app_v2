<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Models\ExpenseModel;

class Expense extends Authenticated
{	
	public function expenseAction()
	{
		View::renderTemplate('Expense/expense.html');
	}
	
	public function createAction()
	{
		$expense = new ExpenseModel($_POST);
		
		if ($expense->saveExpense($_SESSION['user_id'])) {
			
			Flash::addMessage('Wydatek został dodany.');
			
			$this->redirect('/expense/success');
		
		} else {
			
			Flash::addMessage('Wystąpił problem z dodaniem wydatku. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/expense/failed');
			
			
		}
	}
	
	public function successAction()
	{
		View::renderTemplate('Expense/expense.html');
	}
	
	public function failedAction()
	{
		View::renderTemplate('Expense/expense.html');
	}
}