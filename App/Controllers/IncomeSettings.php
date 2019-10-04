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
			
			$this->redirect('/income/success');
		
		} else {
			
			Flash::addMessage('Wystąpił problem z dodaniem kategorii. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/income/failed');
		}
	}
	
	public function deleteIncomeCategoryAction()
	{
		$newCategory = new SettingsModel($_POST);
		
		if ($newCategory->deleteIncomeCategory ($_SESSION['user_id'])) {
			
			Flash::addMessage('Kategoria została usunięta.');
			
			$this->redirect('/income/success');
		
		} else {
			
			Flash::addMessage('Wystąpił problem z dodaniem kategorii. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/income/failed');
		}
	}
	
	public function successAction()
	{View::renderTemplate('Settings/income_settings.html');}
	
	public function failedAction()
	{View::renderTemplate('Settings/income_settings.html');}
}