<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Signup extends \Core\Controller
{
	//Sign up new user
	public function createAction()
	{
		$user = new User($_POST);
		
		if ($user->save()) {
			
			$user->sendActivationEmail();
			
			$this->redirect('/signup/success');
			/*header('Location: http://' . $_SERVER['HTTP_HOST'] . '/signup/success', true, 303);
			exit;*/
		
		} else {
			
			View::renderTemplate('Home/index.html', [
				'user' => $user
			]);
			
		}
	}
	
	public function successAction()
	{
		View::renderTemplate('Signup/success.html');
	}
	
	public function activateAction()
	{
		User::activate($this->route_params['token']);
		
		$this->redirect('/signup/activated');
	}
	
	public function activatedAction()
	{
		View::renderTemplate('Signup/activated.html');
	}
	
}