<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;

class Profile extends Authenticated
{
	//before filter - calling before each action method
	protected function before()
	{
		parent::before();
		
		$this->user = Auth::getUser();
	}
	
	public function showAction()
	{
		View::renderTemplate('Profile/show_profile_data.html', [
			'user' => $this->user
		]);
	}
	
	public function editAction()
	{
		View::renderTemplate('Profile/edit_profile.html', [
			'user' => $this->user
		]);
	}
	
	public function updateAction()
	{	
		if ($this->user->updateProfile($_POST)) {
			
			Flash::addMessage('Zmiany zostały zapisane');
			
			$this->redirect('/profile/show');
			
		} else {
			
			View::renderTemplate('Profile/edit_profile.html', [
				'user' => $this->user
			]);
		}
	}
}