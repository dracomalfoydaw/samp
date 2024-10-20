<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controlleraccountinfo101 extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_session')) :
			redirect('login',301);

		endif;
		if($this->session->userdata('gid')==1 or $this->session->userdata('gid')==2):
			$this->load->model('Accountinfomodel','account');
			$this->load->model('User_model','user_model');
		else:
			redirect('home',301);
		endif;
		
	}




	public function index()
	{
		$this->data = [];
		$this->data['pageTitle'] = "Utilities";
		$this->data['pageSubtitle'] = "User Account";
		$this->data['pageSubtitleTable'] = "User Account List";
		$this->data['custom_css'] = $this->load->view('utilities/accounts/css_script',$this->data,true);
		$this->data['content'] = $this->load->view('utilities/accounts/home',$this->data, true );
		$this->data['home_script'] = $this->load->view('utilities/accounts/home_script',$this->data, true );
		$this->load->view('layouts/main', $this->data );
	}

	public function findprofileinfo()
	{
		if(isset($this->input->post('search')['value']))
		{
			$fieldValue = $this->htmlpurifier_lib->purify($this->input->post('search')['value']) ;
		}
		else
		{
			$fieldValue = "" ;
		}
		
		echo json_encode($this->account->getMembersData($fieldValue)) ;
	}

	public function updatetransactioninfo()
	{
		$this->form_validation->set_rules('firstName', 'First Name', 'required|trim|htmlspecialchars');
		
		$this->form_validation->set_rules('lastName', 'Last Name', 'required|trim|htmlspecialchars');
		/*$this->form_validation->set_rules('email', 'Email', 'required|trim|htmlspecialchars|valid_email');*/
		//$this->form_validation->set_rules('email', 'Email', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('userID', 'ID Number', 'required|trim|htmlspecialchars');
		if ($this->form_validation->run()) {
			$firstName  = $this->htmlpurifier_lib->purify($this->input->post('firstName'));
            $middleName = $this->htmlpurifier_lib->purify($this->input->post('middleName'));
            $lastName = $this->htmlpurifier_lib->purify($this->input->post('lastName'));
            $nameExtension = $this->htmlpurifier_lib->purify($this->input->post('nameExtension'));
            
            $email = $this->htmlpurifier_lib->purify($this->input->post('email'));
            $userID = $this->htmlpurifier_lib->purify($this->input->post('userID'));

            $groupID = $this->htmlpurifier_lib->purify($this->input->post('groupID'));

	        // Call the model method to update the profile
	        $result = $this->account->updateProfile($userID, $firstName, $middleName, $lastName,  $email,$groupID);

	        $data = array(
		        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
		        'message_details' => '',
		        
		    );
		
		} else {
		    // Form validation failed, there are errors
		    $message_details = validation_errors('<li>', '</li>');//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
		    $data = array(
		        'message' => "error",
		        'message_details' =>  $message_details ,//$message_details,
		        'id' => '',
		    );
		}

		echo json_encode($data);
	}



	public function savetransactioninfo()
	{

		$this->form_validation->set_rules('firstName', 'First Name', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('lastName', 'Last Name', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|htmlspecialchars|valid_email|is_unique[tb_users.email]');
		$this->form_validation->set_rules('username', 'Username', 'required|trim|htmlspecialchars|is_unique[tb_users.username]');
		$this->form_validation->set_rules('idnumber', 'ID Number', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('group', 'Group', 'required');


		// Check if form validation passed
		if ($this->form_validation->run()) {
		    // Form validation passed, no errors
					$password =	$this->input->post('password');
		    		$password_status = $this->filtering_process->password_check($password);
		    		if($password_status['status']==true)
		    		{
		    				$firstName  = $this->htmlpurifier_lib->purify($this->input->post('firstName'));
		                    $middleName = $this->htmlpurifier_lib->purify($this->input->post('middleName'));
		                    $lastName = $this->htmlpurifier_lib->purify($this->input->post('lastName'));
		                    $group = $this->htmlpurifier_lib->purify($this->input->post('group'));
		                    if($group=="Superadmin")
		                    {
		                    	$group = 1;
		                    }
		                    elseif($group=="Admin")
		                    {
		                    	$group = 2;
		                    }elseif($group=="Cashier")
		                    {
		                    	$group = 4;
		                    }elseif($group=="Encoder")
		                    {
		                    	$group = 5;
		                    }elseif($group=="Accounting")
		                    {
		                    	$group = 6;
		                    }
		                    else
		                    {
		                    	$group = 3;
		                    }
		                    $username = $this->htmlpurifier_lib->purify($this->input->post('username'));
		                    $email = $this->htmlpurifier_lib->purify($this->input->post('email'));
		                    $idnumber = $this->htmlpurifier_lib->purify($this->input->post('idnumber'));
		                    $password = md5(md5(sha1(sha1($password))));

		                    $result = $this->user_model->insertUser($username, $password,  $email , $group , $idnumber,  $firstName  , $lastName, 1, $this->session->userdata('uid'));
	                    	$data = array(
						        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
						        'message_details' => '',
						        
						    );
		    		}
		    		else
		    		{
		    			$data = array(
					        'message' =>  "error",  // Assuming success when validation passes
					        'message_details' => $password_status->status_details,					        
					    );
		    		}

		    
		} else {
		    // Form validation failed, there are errors
		    $message_details = validation_errors('<li>', '</li>');//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
		    $data = array(
		        'message' => "error",
		        'message_details' => $message_details,
		        'id' => '',
		    );
		}

		echo json_encode($data);

	}

	public function deletetransactioninfo()
	{
		$this->form_validation->set_rules('userID', 'User ID', 'required|trim|htmlspecialchars');
		if ($this->form_validation->run()) {
			$userID  = $this->htmlpurifier_lib->purify($this->input->post('userID'));
			$result = $this->account->deleteProfile($userID);
			$data = array(
		        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
		        'message_details' => '',
		        
		    );
		}
		else
		{
			// Form validation failed, there are errors
		    $message_details = validation_errors('<li>', '</li>');//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
		    $data = array(
		        'message' => "error",
		        'message_details' => $message_details,
		        'id' => '',
		    );
		}
		echo json_encode($data);
	}

	public function accountunlockinfo()
	{
		$this->form_validation->set_rules('userID', 'User ID', 'required|trim|htmlspecialchars');
		if ($this->form_validation->run()) {
			$userID  = $this->htmlpurifier_lib->purify($this->input->post('userID'));
			$result = $this->account->accountunlockinfo($userID);
			$data = array(
		        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
		        'message_details' => '',
		        
		    );
		}
		else
		{
			// Form validation failed, there are errors
		    $message_details = validation_errors('<li>', '</li>');//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
		    $data = array(
		        'message' => "error",
		        'message_details' => $message_details,
		        'id' => '',
		    );
		}
		echo json_encode($data);
	}
	public function accountchangenewpasswordinfo()
	{
		$this->form_validation->set_rules('userID', 'User ID', 'required|trim|htmlspecialchars');		
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
		if ($this->form_validation->run()) {
			$userID  = $this->htmlpurifier_lib->purify($this->input->post('userID'));

			$password = md5(md5(sha1(sha1($this->input->post('password')))));
			$result = $this->account->accountchangenewpasswordinfo($userID, $password);
			$data = array(
		        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
		        'message_details' => '',
		        
		    );
		}
		else
		{
			// Form validation failed, there are errors
		    $message_details = validation_errors('<li>', '</li>');//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
		    $data = array(
		        'message' => "error",
		        'message_details' => $message_details,
		        'id' => '',
		    );
		}
		echo json_encode($data);
	}
}



