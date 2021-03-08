<?php

namespace App;


class Token
{
		protected $token;
	
	//tworzymy konstruktow aby przy każdym tworzeniu obiketu wywołać tą funckję, domyślnie jest ustawiony pusty token
	public function __construct($token_value =null)
	{
		//jeśli otrzymaliśmy jakąś wartość to ma zamienić ją w tokeny, jeśli nie to utwórz nowego tokena
		if($token_value){
			$this->token = $token_value;
		}else{
		$this->token = bin2hex(random_bytes(16)); // stworzenie randomowego tokena 32 znaki	
		}
	}
	
	//fukcja która zwraca utworzyny token
	public function getValue()
	{
		return $this->token;
	}
	
	//zwraca hasha
	public function getHash()
	{
		return hash_hmac('sha256', $this->token, \App\Config::SECRET_KEY); //Słowo sekret jest domyślnie  sekret najlepiej trzymać w innym pliku łatwo jest go zmieniać dla różnych projektów - może być confiq file
	}
	
}

