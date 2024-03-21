<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controlleraccountinfo101 extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_session')) :
			redirect('login',301);

		endif;
		$this->load->model('Accountinfomodel','account');
		$this->load->model('User_model','user_model');
		
	}




	public function index()
	{
		$this->data = [];
		$this->data['pageTitle'] = "Utilities";
		$this->data['pageSubtitle'] = "User Account";
		$this->data['pageSubtitleTable'] = "User Account List";
		$this->data['content'] = $this->load->view('utilities/accounts/home',$this->data, true );
		$this->data['home_script'] = $this->load->view('utilities/accounts/home_script',$this->data, true );
		$this->load->view('layouts/main', $this->data );
	}

	public function findprofileinfo()
	{
		if(isset($this->input->post('search')['value']))
		{
			$fieldValue = trim($this->htmlpurifier_lib->purify($this->input->post('search')['value'])) ;
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



	        // Call the model method to update the profile
	        $result = $this->members->updateProfile($userID, $firstName, $middleName, $lastName, $nameExtension, $email);

	        $data = array(
		        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
		        'message_details' => '',
		        
		    );
		
		} else {
		    // Form validation failed, there are errors
		    $message_details = validation_errors('<li>', '</li>');//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
		    $data = array(
		        'message' => "error",
		        'message_details' =>  json_encode($_POST),//$message_details,
		        'id' => '',
		    );
		}

		echo json_encode($data);
	}

	public function savetransactioninfo()
	{

		$this->form_validation->set_rules('firstName', 'First Name', 'required|trim|htmlspecialchars');
		
		$this->form_validation->set_rules('lastName', 'Last Name', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('nameextension', 'Name Extension', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|htmlspecialchars|valid_email|is_unique[tb_profile.email]');
		//$this->form_validation->set_rules('email', 'Email', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('idnumber', 'ID Number', 'required|trim|htmlspecialchars|is_unique[tb_profile.UniqueID]');

		// Check if form validation passed
		if ($this->form_validation->run()) {
		    // Form validation passed, no errors
		    
                    $firstName  = $this->htmlpurifier_lib->purify($this->input->post('firstName'));
                    $middleName = $this->htmlpurifier_lib->purify($this->input->post('middleName'));
                    $lastName = $this->htmlpurifier_lib->purify($this->input->post('lastName'));
                    $nameExtension = $this->htmlpurifier_lib->purify($this->input->post('nameExtension'));
                    
                    $email = $this->htmlpurifier_lib->purify($this->input->post('email'));
                    $idnumber = $this->htmlpurifier_lib->purify($this->input->post('idnumber'));
                    $defaultuseraccount = $this->htmlpurifier_lib->purify($this->input->post('defaultuseraccount'));


                    $system_user = 1;
                
                    $result = $this->members->insertProfile($idnumber, $firstName, $middleName, $lastName, $nameExtension, $email);
                    if($defaultuseraccount=="defaultsystemuser")
                    {
                    	$result = $this->User_model->insertUser($idnumber, $idnumber,  $email , 1, $result->ProfileID ,  $firstName  , $lastName, 1, $system_user);
                    	$data = array(
					        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
					        'message_details' => '',
					        
					    );
                    }
                    else
                    {
                    	$data = array(
					        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
					        'message_details' => '',
					        
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
			$result = $this->members->deleteProfile($userID);
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



