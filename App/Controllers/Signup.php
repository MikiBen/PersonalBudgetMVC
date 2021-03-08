<?php

namespace App\Controllers;
use \App\Models\User;
use \App\Flash;
use \Core\View;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function newAction()
    {
		if(!isset($_SESSION['user_id']))
		{
        View::renderTemplate('Signup/new.html');
		}
		else{
		Flash::addMessage('Please logout first');
		$this->redirect('/menu/new');
		}
    }
	
	    /**
     * Show the index page
     *
     * @return void
     */
    public function createAction() 
    {
		
		$user = new User($_POST);
		
		if($user->save()){
			$user->addCategories();	
			Flash::addMessage('Registration successul');
			$this->redirect('/login/new');
			
		}else{
			View::renderTemplate('Signup/new.html',[
			'user' => $user]);
		}
    }
	
	public function successAction()
	{
		View::renderTemplate('Signup/success.html');
	}
}
