<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controllercontributionreport101 extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_session')) :
			redirect('login',301);

		endif;
		$this->load->model('Contributioninfomodel','contribution_model');
		$this->load->model('Announcementinfomodel','announcement');
		$this->load->model('Email_model','email_model');
		$this->load->model('Membershipinfomodel','members');
	}




	public function index()
	{
		$this->data = [];
		if($this->session->userdata('gid')==3):
			$this->data['category']  = "members";
		else:
			$this->data['category']  = "";
		endif; 
		$this->data['pageTitle'] = "Contribution";
		$this->data['pageSubtitle'] = "Contribution Profile";
		$this->data['custom_css'] = $this->load->view('contribution/profile/css_script',$this->data,true);
		$this->data['content'] = $this->load->view('contribution/profile/home',$this->data, true );
		$this->data['home_script'] = $this->load->view('contribution/profile/home_script',$this->data, true );
		$this->load->view('layouts/main', $this->data );
	}

	/*public function synccollection()
	{
		$this->contribution_model->synccollection(1);
	}
*/
	public function collection($category = '')
	{
		if($this->session->userdata('gid')==3):
			redirect('home',301);
		endif; 
		if($category == "profilecollectionlist")
		{
			$searchvalue = $this->htmlpurifier_lib->purify($this->input->post('searchvalue'));
			if($searchvalue !='')
			{
				$val = $this->contribution_model->profilecollectionlist($searchvalue);
			}
			else
			{
				$val = "";
			}
			header('Content-Type: application/json');
			echo json_encode($val) ;
		}
		elseif($category == "synccollection")
		{
			//$this->contribution_model->synccollection(2);
			$searchvalue = $this->htmlpurifier_lib->purify($this->input->post('searchvalue'));
			if($searchvalue !='')
			{
				$val = $this->contribution_model->synccollection($searchvalue);
			}
			else
			{
				$val = "";
			}
			header('Content-Type: application/json');
			echo json_encode($val) ;
		}
		else
		{			
			$this->data = [];
			$this->data['pageTitle'] = "Contribution";
			$this->data['pageSubtitle'] = "Contribution Collection";
			$this->data['custom_css'] = $this->load->view('contribution/collection/css_script',$this->data,true);
			$this->data['content'] = $this->load->view('contribution/collection/home',$this->data, true );
			$this->data['home_script'] = $this->load->view('contribution/collection/home_script',$this->data, true );
			$this->load->view('layouts/main', $this->data );
		}
	}

	public function findinfo($category = '')
	{
		$category = $this->htmlpurifier_lib->purify($category);


		if(isset($this->input->post('search')['value']))
		{
			$fieldValue = $this->htmlpurifier_lib->purify($this->input->post('search')['value']) ;
		}
		else
		{
			$fieldValue = "" ;
		}
		
		echo json_encode($this->contribution_model->getData($fieldValue, $category)) ;
	}

	public function savetransactioninfo()
	{

		$this->form_validation->set_rules('contributionname', 'First Name', 'required|trim|htmlspecialchars');
		
		$this->form_validation->set_rules('amountofcontribution', 'Last Name', 'required|trim|htmlspecialchars');

		// Check if form validation passed
		if ($this->form_validation->run()) {
		    // Form validation passed, no errors
		    		$createannoucement = $this->htmlpurifier_lib->purify($this->input->post('createannoucement'));
                    $contributionname  = $this->htmlpurifier_lib->purify($this->input->post('contributionname'));
                    $amountofcontribution = $this->filtering_process->test_input($this->input->post('amountofcontribution'));
                    $desccontribution = $this->htmlpurifier_lib->purify($this->input->post('desccontribution'));
                    $SendAnnouncement = $this->htmlpurifier_lib->purify($this->input->post('sendannouncement'));

                    $applyrecord = $this->htmlpurifier_lib->purify($this->input->post('applyrecord'));



                     $system_user = $this->session->userdata('uid');
                
                    $result = $this->contribution_model->insertData($applyrecord,$contributionname, $amountofcontribution , $desccontribution , 1, 0, $system_user);

                    if($result->SuccessMessage=="success" and $createannoucement=='true')
                    {
                    	$TitleAnnouncement = "Contribution Name: ".$contributionname;
                    	$TitleDescription = $desccontribution. ". Corresponding Contribution Amount: ".$amountofcontribution. ".  ";
                    	$this->announcement->newAnnouncement($TitleAnnouncement, $TitleDescription , $system_user);
                    }

                    $error_send = "";
                    if($SendAnnouncement==true)
                    {
                    	$memberActiveList = $this->members->getMembers();

                    	foreach ($memberActiveList as $key) { 
                    		$TitleAnnouncement = "Contribution Name: ".$contributionname;
                    		$TitleDescription = $desccontribution. ". Corresponding Contribution Amount: ".$amountofcontribution. ".  ";

                    		$email_status = $this->email_model->send_announcement($TitleAnnouncement, $TitleDescription,$key->Fullname, $key->Email);
                    		if($email_status=="error")
                    		{
                    			$error_send = "error";
                    			break;
                    		}
                    	}
                    }

                    
                	$data = array(
				        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
				        'message_details' => $createannoucement,
				        
				    );
                   

		    
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
		$this->form_validation->set_rules('userID', 'Data ', 'required|trim|htmlspecialchars');
		if ($this->form_validation->run()) {
			$userID  = $this->htmlpurifier_lib->purify($this->input->post('userID'));
			$result = $this->contribution_model->deleteProfile($userID);
			$data = array(
		        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
		        'message_details' => $userID,
		        
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



