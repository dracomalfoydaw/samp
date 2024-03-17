<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controllermembershipinfo101 extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_session')) :
			redirect('login',301);

		endif;
		$this->load->model('Membershipinfomodel','members');
		$this->load->model('User_model');
		
	}




	public function index()
	{
		$this->data = [];
		$this->data['pageTitle'] = "Members Information";
		$this->data['pageSubtitle'] = "Profile";
		$this->data['content'] = $this->load->view('members/profile/home',$this->data, true );
		$this->data['home_script'] = $this->load->view('members/profile/home_script',$this->data, true );
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
		
		echo json_encode($this->members->getMembersData($fieldValue)) ;
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
}



