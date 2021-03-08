<?php

namespace App\Models;

use PDO;
use \App\Token;
//use \App\Mail;
use \Core\View;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{
  /**
   * Wiadomość error
   *
   * @var array
   */
   
   //nadanie zmiennej z błędami
  public $errors = [];


  
  /**
   * Class constructor
   *
   * @param array $data  Initial property values
   *
   * @return void
   */
  public function __construct($data = [])
  {
    foreach ($data as $key => $value) {
      $this->$key = $value;
    };
  }

  /**
   * Save the user model with the current property values
   *
   * @return void
   */
	  public function save()
	  {
		  $this->validate();
		  if(empty($this->errors))
		  {	  
					$password_hash = password_hash($this->password, PASSWORD_DEFAULT);

					$sql = 'INSERT INTO users (name, email, password_hash)
							VALUES (:name, :email, :password_hash)';

					$db = static::getDB();
					$stmt = $db->prepare($sql);

					$stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
					$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
					$stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);


					return $stmt->execute();
					
		  }
		  
		  return false;
	  }
  
		  
		  public static function addIncome($category, $amount, $date_income, $income_comment )
		  {
		  
				$userID = $_SESSION['user_id'];
		  
				$sql = 'INSERT INTO incomes (user_id, income_category_assigned_to_user_id, amount, date_of_income, income_comment ) VALUES (:user_id, :income_category_assigned_to_user_id, :amount, :date_of_income, :income_comment )';
			
				$db = static::getDB();
				$stmt = $db->prepare($sql);
				
				$stmt->bindValue(':user_id', $userID, PDO::PARAM_INT);
				$stmt->bindValue(':income_category_assigned_to_user_id', $category, PDO::PARAM_INT);
				$stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
				$stmt->bindValue(':date_of_income',  $date_income, PDO::PARAM_STR);
				$stmt->bindValue(':income_comment',  $income_comment, PDO::PARAM_STR);
				
				$stmt->execute();
				
		  }

		  public static function addExpense($category, $amount, $date_expense, $payment, $expense_comment)
		  {
			  
					$userID = $_SESSION['user_id'];
		  
				$sql = 'INSERT INTO expenses (user_id, expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment ) VALUES (:user_id, :expense_category_assigned_to_user_id, :payment_method_assigned_to_user_id,  :amount, :date_of_expense, :expense_comment )';
			
				$db = static::getDB();
				$stmt = $db->prepare($sql);
				
				$stmt->bindValue(':user_id', $userID, PDO::PARAM_INT);
				$stmt->bindValue(':expense_category_assigned_to_user_id', $category, PDO::PARAM_INT);
				$stmt->bindValue(':payment_method_assigned_to_user_id', $payment, PDO::PARAM_INT);
				$stmt->bindValue(':amount', $amount, PDO::PARAM_INT);
				$stmt->bindValue(':date_of_expense',  $date_expense, PDO::PARAM_STR);
				$stmt->bindValue(':expense_comment',  $expense_comment, PDO::PARAM_STR);
				
				$stmt->execute();

		  }

	public static function getNameCategory($sql)
  	  {

		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->execute();

		$categoryName = $stmt->fetchAll();

		return $categoryName;
		}	

  
  public function addCategories()
{
	$this->addCategoriesIncomes();
	$this->addCategoriesExpenses();
	$this->addCategoriesPaymentMethods();
}	

public function addCategoriesPaymentMethods()
{
			$sql = 'SELECT name FROM payment_methods_default';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute();
		
		$user = static::findByEmail($this->email); 
		
		$sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name) 
		VALUES (:user_id, :name)';
		
		while ($name =  $stmt->fetchColumn())  { 

		$this->addCategoriesToUser($user->id, $name,$sql);
		}
}	


public function addCategoriesIncomes()
{
			$sql = 'SELECT name FROM incomes_category_default';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute();
		
		$user = static::findByEmail($this->email); 
		$sql = 'INSERT INTO incomes_category_assigned_to_users (user_id, name) 
		VALUES (:user_id, :name)';

		while ($name =  $stmt->fetchColumn())  { 

		$this->addCategoriesToUser($user->id, $name,$sql );
		}
}	

  
public function addCategoriesExpenses()
{
			$sql = 'SELECT name FROM expenses_category_default';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$stmt->execute();
		
		$user = static::findByEmail($this->email); 
		$sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name) 
		VALUES (:user_id, :name)';	
		
		while ($name =  $stmt->fetchColumn())  { 

			$this->addCategoriesToUser($user->id, $name,$sql);
		}
}	

	public static  function addCategoriesToUser($user_id, $name, $sql)
	{
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
	
		 $stmt->execute();
	}



    /**
   * Walidacja zmiennych
   *
   * @return void
   */
	public function validate()
	{
		//Name
		if($this->name == ' '){
			$this->errors[] = 'Name is required';
		}
		
		//Email
		if(filter_var($this->email, FILTER_VALIDATE_EMAIL) === false){
			$this->errors[] = 'Invalid email';
		}
		
		if(static::emailExists($this->email, $this->id ?? null))
		{
			$this->errors[] = 'Email exist';
		}
		/**
		//Password
		if ($this->password != $this->password_confirmation){
			$this->errors[] = 'Password must be the same';
		}
		
		*/
		if(strlen($this->password)<6){
			$this->errors[] = 'please enter ay least 6 character for the password';
		}
		
		if (preg_match('/.*[a-z]+.*/i', $this->password)==0){
			$this->errors[] = 'Password needs least one letter';
		}
		
		if (preg_match('/.*\d+.*/i', $this->password)==0){
			$this->errors[] = 'Password needs least one number';
		}
		
	}
	
	//sprawdzenie czy email istnieje (połączono z funkcja findByEmail
	public static function emailExists ($email, $ignore_id=null)
	{
		$user = static::findByEmail($email);
		
		if($user){
			if($user->id!=$ignore_id){
				return true;
			}
		}
		return false;
	}
	
	
	//Wyszukanie po mailu
	public static function findByEmail($email)
	{
		$sql = 'SELECT * FROM users WHERE email = :email';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetch();
	}
	
	
	/*
		Sprawdzenie poprawności hasła i maila
	*/
		public static function authenticate($email, $password)
		{
			$user = static::findByEmail($email); 
				if($user){
					if(password_verify($password, $user->password_hash)){
						return $user;
					}
				}
				return false;
		}
		
		//wyszukanie id użytkownika
	public static function findByID($id)
	{
		$sql = 'SELECT * FROM users WHERE id = :id';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		
		$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		
		$stmt->execute();
		
		return $stmt->fetch();
	}
	
	public function rememberLogin()
	{
		$token = new Token();
		$hashed_token =$token->getHash();
		$this->remember_token = $token->getValue();
		
		//$expiry_timestamp = time() +60 * 60 *24 *30; //ustawienie 30 dni od teraz
		$this->expiry_timestamp = time() +60 * 60 *24 *30;
		//dodanie do bazy tokena
		$sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at) VALUES (:token_hash, :user_id, :expires_at)';
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
		$stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
		$stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);
		
		return $stmt->execute();
	}
	



	
}
