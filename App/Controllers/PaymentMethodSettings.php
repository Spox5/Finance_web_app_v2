<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Models\SettingsModel;

class PaymentMethodSettings extends Authenticated
{
	
	public function showPaymentMethodSettingsAction()
	{
		View::renderTemplate('Settings/payment_method_settings.html', [
		]);
	}
	
	public function addPaymentMethodCategoryAction()
	{
		$newCategory = new SettingsModel($_POST);
		
		if ($newCategory->saveNewPaymentMethodCategory ($_SESSION['user_id'])) {
			
			Flash::addMessage('Kategoria została dodana.');
			
			$this->redirect('/paymentmethodsettings/success');
		
		} else {
			
			Flash::addMessage('Wystąpił problem z dodaniem kategorii. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/paymentmethodsettings/failed');
		}
	}
	
	public function deletePaymentMethodCategoryAction()
	{
		$newCategory = new SettingsModel($_POST);
		
		if ($newCategory->deletePaymentMethodCategory ($_SESSION['user_id'])) {
			
			Flash::addMessage('Kategoria została usunięta.');
			
			$this->redirect('/paymentmethodsettings/success');
		
		} else {
			
			Flash::addMessage('Wystąpił problem z usunięciem kategorii. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/paymentmethodsettings/failed');
		}
	}
	
	public function editPaymentMethodCategoryAction()
	{
		$editCategory = new SettingsModel($_POST);
		
		if ($editCategory->editPaymentMethodCategory ($_SESSION['user_id'])) {
			
			Flash::addMessage('Kategoria została edytowana.');
			
			$this->redirect('/paymentmethodsettings/success');
			
		} else {
			
			Flash::addMessage('Wystąpił problem z edytowaniem kategorii. Spróbuj ponownie.', Flash::WARNING);
			
			$this->redirect('/paymentmethodsettings/failed');
			
		}
	}
	
	public function successAction()
	{View::renderTemplate('Settings/payment_method_settings.html');}
	
	public function failedAction()
	{View::renderTemplate('Settings/payment_method_settings.html');}
}