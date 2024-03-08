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

	
}