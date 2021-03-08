<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;

class Incomes extends Authenticated
{
		public $arg=[];
		
		public function newAction()
		{
			$userID = $_SESSION['user_id'];
			$arg['date'] = date('Y-m-d');
			
			$sql = "SELECT * FROM incomes_category_assigned_to_users WHERE incomes_category_assigned_to_users.user_id='$userID'";
			$arg['incomesCategory'] = User::getNameCategory($sql);
			View::renderTemplate('Incomes/new.html', $arg );
		}

		public function addAction()
		{
			
			User::addIncome($_POST['category_incomes'],$_POST['amount_income'], $_POST['date_income'],$_POST['income_coment']);
			
			Flash::addMessage('Income added');
			$this->redirect('/menu/new');

		}

}