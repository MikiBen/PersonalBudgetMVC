<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
/**
 * Home controller
 *
 * PHP version 7.0
 */
class Menu extends Authenticated
{

    /**
     * Show the index page
     *
     * @return void
     */
	 //
    public function newAction()
    {
        View::renderTemplate('Menu/new.html');

    }
}
