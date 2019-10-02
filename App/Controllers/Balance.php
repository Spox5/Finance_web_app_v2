<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Auth;

class Balance extends Authenticated
{	
	public function currentMonthAction()
	{
		View::renderTemplate('Balance/current_month.html');
	}
	
	public function previousMonthAction()
	{
		View::renderTemplate('Balance/previous_month.html');
	}
	
	public function presentYearAction()
	{
		View::renderTemplate('Balance/present_year.html');
	}
	
	public function userPeriodAction()
	{
		$_SESSION['date1'] = $_POST['date1'];
		$_SESSION['date2'] = $_POST['date2'];
		
		if ($_SESSION['date1'] < $_SESSION['date2']) {
			
			View::renderTemplate('Balance/user_period.html');	
			}
		else {
			
			Flash::addMessage('Nieprawidłowa kolejność dat.', Flash::WARNING);
			
			View::renderTemplate('Welcome/welcome.html', [
				'user' => Auth::getUser()
			]);
		}
	}
		
}