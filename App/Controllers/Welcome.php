<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

class Welcome extends Authenticated
{
	
	
	public function welcomeAction()
	{
		View::renderTemplate('Welcome/welcome.html', [
			//get object of logged in user to display his name
			'user' => Auth::getUser()
		]);
	}
}