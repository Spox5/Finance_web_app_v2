<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Models\SettingsModel;

class IncomeSettings extends Authenticated
{
	
	public function showIncomeSettingsAction()
	{
		View::renderTemplate('Settings/income_settings.html', [
		]);
	}
	
	public function addIncomeCategoryAction()
	{
		$newCategory = new SettingsModel($_POST);
		
		if ($newCategory->saveNewIncomeCategory ($_SESSION['user_id'])) {
			
			Flash::addMessage('Kategoria została dodana.');
			
			$this->redirect('/incomesettings/success');
		
		} else {
			
			Flash::addMessage('Wystąpił problem z dodaniem kategorii. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/incomesettings/failed');
		}
	}
	
	public function deleteIncomeCategoryAction()
	{
		$deleteCategory = new SettingsModel($_POST);
		
		if ($deleteCategory->deleteIncomeCategory ($_SESSION['user_id'])) {
			
			Flash::addMessage('Kategoria została usunięta.');
			
			$this->redirect('/incomesettings/success');
		
		} else {
			
			Flash::addMessage('Wystąpił problem z usunięciem kategorii. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/incomesettings/failed');
		}
	}
	
	public function editIncomeCategoryAction()
	{
		$editCategory = new SettingsModel($_POST);
		
		if ($editCategory->editIncomeCategory ($_SESSION['user_id'])) {
			
			Flash::addMessage('Kategoria została edytowana.');
			
			$this->redirect('/incomesettings/success');
			
		} else {
			
			Flash::addMessage('Wystąpił problem z edytowaniem kategorii. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/incomesettings/failed');
			
		}
	}
	
	public function successAction()
	{View::renderTemplate('Settings/income_settings.html');}
	
	public function failedAction()
	{View::renderTemplate('Settings/income_settings.html');}
}