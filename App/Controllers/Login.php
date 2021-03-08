<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth;
use \App\Flash;

class Login extends \Core\Controller
{
	public function newAction()
	{
		if(!isset($_SESSION['user_id']))
		{
			View::renderTemplate('Login/new.html');
			
		}
		else{
		$this->redirect('/menu/new');
		}
	}

	public function createAction()
	{	
		$user = User::authenticate($_POST['email'], $_POST['password']);
		
		$remember_me = isset($_POST['remember_me']);
		
			if($user) {
				
				Auth::login($user,$remember_me);
				Flash::addMessage('Login successful');
				$_SESSION['user_id'] = $user->id;
				
				$this->redirect('/menu/new');
			}else {
				
				Flash::addMessage('Login unsuccesfull. please try again', Flash::WARNING);
				View::renderTemplate('Login/new.html',[ 
				'email' => $_POST['email'],
				'remember_me' => $remember_me
				]);
			}
	}

	public function destroyAction()
	{
		Auth::logout();  
		$this->redirect('/login/show-logout-message');
	}
	
	public function showLogoutMessageAction()
	{
		Flash::addMessage('Logout successul');
		$this->redirect('/');
	}
	
}