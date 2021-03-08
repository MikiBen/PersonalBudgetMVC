<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class ViewBalance extends Authenticated
{
		public $arg=[];
		
		
		public function newAction()
		{
			View::renderTemplate('ViewBalance/chooseDate.html');
		}
		
		public function showAction($date_begin, $date_end)
		{	
			
			$userID = $_SESSION['user_id'];

			$sql = "SELECT expenses_category_assigned_to_users.name, payment_methods_assigned_to_users.name AS payment_name, expenses.amount, expenses.date_of_expense, expenses.expense_comment  FROM expenses_category_assigned_to_users, payment_methods_assigned_to_users, expenses 
							WHERE expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id 
							AND expenses.payment_method_assigned_to_user_id=payment_methods_assigned_to_users.id 
							AND expenses.user_id='$userID' AND expenses.date_of_expense>='$date_begin' AND expenses.date_of_expense<='$date_end'";
		
			$arg['expenses'] = User::getNameCategory($sql);
			
			$sql = "SELECT  incomes_category_assigned_to_users.name, 
						incomes.amount, 
						incomes.date_of_income,
						incomes.income_comment 
						FROM incomes_category_assigned_to_users,
						incomes
						WHERE incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id 
						AND incomes.user_id='$userID' AND incomes.date_of_income>='$date_begin' AND incomes.date_of_income<='$date_end'";	
		
			$arg['incomes'] = User::getNameCategory($sql);
			
			View::renderTemplate('ViewBalance/new.html', $arg);
		}
		
		public function showCurrentMonthAction()
		{		
			$date_begin =  date('Y-m')."-01";
			$date_end =  date('Y-m')."-31";
			$this->showAction($date_begin, $date_end);
		}
		
		public function showLastMonthAction()
		{	
			$date_begin = date('Y-m',strtotime("- 1 Month"))."-01";
			$date_end = date('Y-m',strtotime("- 1 Month"))."-31";
			$this->showAction($date_begin, $date_end);
		}
		
			public function showChoosePerriodAction()
		{	
			$date_begin = $_POST['date_begin'];
			$date_end = $_POST['date_end'];
			
			$this->showAction($date_begin, $date_end);
		}

}