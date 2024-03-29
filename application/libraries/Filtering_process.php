<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class filtering_process {

	function test_input($data) {
		//$data = preg_replace('/[^a-zA-Z0-9-_.@!=+$() ]/', '', $data);
		//$data = preg_replace('/[^a-zA-Z0-9-#@:_(),.!@"\/Ññ ]/', '', $data);
		if($data !='')
		{
			$data = preg_replace('/[^a-zA-Z0-9-#@:_,.!@"\/Ññ ]/', '', $data);
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);	
			$data = utf8_decode($data);	  			
		}
		return $data;
	}

	function password($data)
	{
		$data = trim($data);

		$data = htmlspecialchars($data);	  
		return $data;
	}

	function password_check($password) {
	    // Regular expression to match special characters
	    $specialCharactersRegex = '/[!@#$%^&*()_+\-=\[\]{};:\'"\|,.<>\/?]/';

	    if (!preg_match($specialCharactersRegex, $password) || strlen($password) < 8) {
	        // Password does not meet requirements
	        $data	 = array(
	        	'status' => false,
	        	'status_details' => 'The {field} must contain special characters and be at least 8 characters long.',
	        	 );
	        return $data;
	    } else {
	    	$data	 = array(
	        	'status' => true,
	        	'status_details' => '',
	        	 );
	        return $data;
	    }
	}

}