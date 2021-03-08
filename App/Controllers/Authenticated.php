<?php

namespace App\Controllers;

abstract class Authenticated extends \Core\Controller
{
		//Funkcja która jest uruchamiana przed każdą funkcją, blokuje metody przed nie zalogowanym użytkownikiem
	protected function before()
	{
		$this ->requireLogin(); // sprawdzenie czy ktoś jest zalogowany
	}
}