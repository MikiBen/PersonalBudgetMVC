<?php

namespace App\Controllers;

use \App\Models\User;

/**
 * Home controller
 *
 * PHP version 7.0
 */
	class Account extends \Core\Controller
	{
					/**
			 * Walidacja maila
			 *
			 * @ retunr void
			 */
			 public function validateEmailAction()
			 {
				 $is_valid = !User::emailExists($_GET['email']);
				 header ('Content-Type: application/json');
				 echo json_encode($is_valid);
			 }
	}