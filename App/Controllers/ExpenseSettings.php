<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Models\SettingsModel;

class ExpenseSettings extends Authenticated
{
	
	public function showExpenseSettingsAction()
	{
		View::renderTemplate('Settings/expense_settings.html', [
		]);
	}
	
	public function addExpenseCategoryAction()
	{
		$newCategory = new SettingsModel($_POST);
		
		if ($newCategory->saveNewExpenseCategory ($_SESSION['user_id'])) {
			
			Flash::addMessage('Kategoria została dodana.');
			
			$this->redirect('/expensesettings/success');
		
		} else {
			
			Flash::addMessage('Wystąpił problem z dodaniem kategorii. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/expensesettings/failed');
		}
	}
	
	public function deleteExpenseCategoryAction()
	{
		$newCategory = new SettingsModel($_POST);
		
		if ($newCategory->deleteExpenseCategory ($_SESSION['user_id'])) {
			
			Flash::addMessage('Kategoria została usunięta.');
			
			$this->redirect('/expensesettings/success');
		
		} else {
			
			Flash::addMessage('Wystąpił problem z usunięciem kategorii. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/expensesettings/failed');
		}
	}
	
	public function editExpenseCategoryAction()
	{
		$editCategory = new SettingsModel($_POST);
		
		if ($editCategory->editExpenseCategory ($_SESSION['user_id'])) {
			
			Flash::addMessage('Kategoria została edytowana.');
			
			$this->redirect('/expensesettings/success');
			
		} else {
			
			Flash::addMessage('Wystąpił problem z edytowaniem kategorii. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/expensesettings/failed');
			
		}
	}
	
	public function successAction()
	{View::renderTemplate('Settings/expense_settings.html');}
	
	public function failedAction()
	{View::renderTemplate('Settings/expense_settings.html');}
}