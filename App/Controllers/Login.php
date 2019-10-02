<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth;
use \App\Flash;

class Login extends \Core\Controller
{
	public function createAction()
	{
		$user = User::authenticate($_POST['email'], $_POST['password']);
		
		$remember_me = isset($_POST['remember_me']);
		
		if ($user) {
			
			Auth::login($user, $remember_me);
			
			Flash::addMessage('Logowanie udane');
			
			$this->redirect('/login/success');
			/*header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login/success', true, 303);
			//exit;*/
		
		} else {
			
			Flash::addMessage('Logowanie nieudane, spróbuj ponownie', Flash::WARNING);
			
			View::renderTemplate('Home/index.html', [
				'email' => $_POST['email'],
				'remember_me' => $remember_me
			]);
		}
	}
	
	public function successAction()
	{
		View::renderTemplate('Welcome/welcome.html');
	}
	
	public function destroyAction()
	{
		Auth::logout();
		
		$this->redirect('/login/show-logout-message');
	}
	
	public function showLogoutMessageAction()
	{
		Flash::addMessage('Wylogowanie udane');
		
		$this->redirect('/');
	}
}