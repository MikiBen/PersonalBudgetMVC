<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */
ini_set('session.cookie_lifetime',  '86400'); //10 dni w sekundach
/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


//Rozpoczęcie sesji

 session_start();

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Signup', 'action' => 'new']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']); //można usatwć "skrót: po wpisaniu w przeglądarkę. tzn jeści ktoś wpisze login to przeniesie  na login/new
//$router->add('menu', ['controller' => 'Menu', 'action' => 'new']); //do zmiany


$router->add('addIncome', ['controller' => 'Incomes', 'action' => 'add']); //do zmiany
$router->add('addExpense', ['controller' => 'Expenses', 'action' => 'add']); //do zmiany

$router->add('showCurrentMonth', ['controller' => 'ViewBalance', 'action' => 'showCurrentMonth']); //do zmiany
$router->add('showLastMonth', ['controller' => 'ViewBalance', 'action' => 'showLastMonth']); //do zmiany
//$router->add('addExpense', ['controller' => 'Expenses', 'action' => 'add']); //do zmiany



$router->add('menu', ['controller' => 'Menu', 'action' => 'index']); //do zmiany
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']); //jeśli ktoś wpiszę  logout to przeniesie to strony login/destroy
$router->add('{controller}/{action}'); //podział adresu na akcje o kontrole


    
$router->dispatch($_SERVER['QUERY_STRING']);
