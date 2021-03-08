<?php

namespace App;

use App\Models\User;
use App\Models\RememberedLogin;
/*
Stworzenie klasy do indetyfikacji
*/

class Auth
{
	//Logowanie
	public static function login($user,$remember_me)
	{
	session_regenerate_id(true); //zmiana numeru sesji
	$_SESSION['user_id'] = $user->id;
		if($remember_me){
			if($user->rememberLogin())
			{
				setcookie('remember_me',$user->remember_token, $user->expiry_timestamp, '/');
			}
		}
	
	}
	
	public static function logout()
	{
			$_SESSION = array();

			if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
			session_destroy();
			static::forgetLogin();
	}
	/*Funkcja nie jest już nam potrzebna to funkcję już sprawdza getUser
	//sprawdzenie czy ktoś jest zalogowany
	public static function isLoggedIn()
	{
		return isset($_SESSION['user_id']);
	}
	*/
	
	//zapamiętanie strony na którą się wchodziło
	public static function rememberRequestedPage()
	{
		$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
	}
	
	public static function getReturnToPage()
	{
		return $_SESSION['return_to'] ?? '/';
	}
	
	public static function getUser()
	{
		if(isset($_SESSION['user_id'])){
			return User::findByID($_SESSION['user_id']);
		} else{
			
			return static::loginFromRememberCookie();
		}
	}
	//funkcja która zaloguje się po sprawdzeniu ciasteczek
	protected static function loginFromRememberCookie()
	{
		$cookie = $_COOKIE['remember_me'] ?? false;
		
		if($cookie){
			$remembered_login = RememberedLogin::findByToken($cookie);
			
				if($remembered_login && !$remembered_login->hasExpired()){//jeśli istnie to się zaloguj i nie wygasł token
					$user = $remembered_login->getUser();
					static::login($user, false);
					return $user;
					
				}
		}	
	}
	
	protected static function forgetLogin()
	{
		$cookie = $_COOKIE['remember_me'] ?? false;
		//jeśli ciasteczka istnieją to:
		if ($cookie){
			$remembered_login = RememberedLogin::findByToken($cookie);
			//znajdź login zalogowanego użytkownia
			
			if($remembered_login){ //jeśli istnieje to go usuń
					$remembered_login->delete();
			}
			
			setcookie('remember_me', ' ', time()-3600); //usunięcie ciasteczek
		}
	}
}