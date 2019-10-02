<?php

namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
		//\App\Mail::send('mateusz.musiela@gmail.com', 'Test', 'Testowanie', '<h1>Testowanie</h1>');
		
        View::renderTemplate('Home/index.html');
    }
}
