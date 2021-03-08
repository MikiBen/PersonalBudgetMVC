<?php
namespace App\Controllers;

use \Core\View;
use \App\Auth;

//to klasa rozbudowana z Authenticated
class Items extends Authenticated
{

	public function indexAction()
	{

		View::renderTemplate( 'Items/index.html' );	
	}
	
	public function newAction()
	{
		echo "new Action";
	}
	
	public function showAction()
	{
		echo "show Action";
	}
	
}
