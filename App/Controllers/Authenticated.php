<?php

namespace App\Controllers;

abstract class Authenticated extends \Core\Controller
{
	//this metod will run before every Action method (in framework MVC)
	protected function before()
	{
		$this->requireLogin();
	}
}