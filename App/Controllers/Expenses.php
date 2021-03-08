<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;

class Expenses extends Authenticated
{
		public $arg=[];
		
		public function newAction()
		{
			$userID = $_SESSION['user_id'];
			$arg['date'] = date('Y-m-d');
			
			$sql = "SELECT * FROM expenses_category_assigned_to_users WHERE expenses_category_assigned_to_users.user_id='$userID'";
			$arg['expensesCategory'] = User::getNameCategory($sql);
			
			$sql = "SELECT * FROM payment_methods_assigned_to_users WHERE payment_methods_assigned_to_users.user_id='$userID'";
			
			$arg['paymentCategory'] = User::getNameCategory($sql);
			View::renderTemplate('Expenses/new.html', $arg);
		
		}

		public function addAction()
		{
			User::addExpense($_POST['category_expenses'], $_POST['amount_expense'], $_POST['date_expense'],$_POST['payment_methods'], $_POST['expense_coment']);
			
			Flash::addMessage('Expense added');
			$this->redirect('/menu/new');
		}
	
}