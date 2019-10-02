<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Models\IncomeModel;

class Income extends Authenticated
{	
	public function incomeAction()
	{
		View::renderTemplate('Income/income.html');
	}
	
	public function createAction()
	{
		$income = new IncomeModel($_POST);
		
		if ($income->saveIncome($_SESSION['user_id'])) {
			
			Flash::addMessage('Przychód został dodany.');
			
			$this->redirect('/income/success');
		
		} else {
			
			Flash::addMessage('Wystąpił problem z dodaniem przychodu. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/income/failed');
			
		}
	}
	
	public function successAction()
	{View::renderTemplate('Income/income.html');}
	
	public function failedAction()
	{View::renderTemplate('Income/income.html');}
}