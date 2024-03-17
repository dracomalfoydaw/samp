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
	}




	public function index()
	{
		$this->data = [];
		$this->data['pageTitle'] = "Contribution";
		$this->data['pageSubtitle'] = "Contribution Profile";
		$this->data['content'] = $this->load->view('contribution/profile/home',$this->data, true );
		$this->data['home_script'] = $this->load->view('contribution/profile/home_script',$this->data, true );
		$this->load->view('layouts/main', $this->data );
	}

	public function collection($category = '')
	{
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
		else
		{			
			$this->data = [];
			$this->data['pageTitle'] = "Contribution";
			$this->data['pageSubtitle'] = "Contribution Collection";
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

                    $applyrecord = $this->htmlpurifier_lib->purify($this->input->post('applyrecord'));


                     $system_user = $this->session->userdata('uid');
                
                    $result = $this->contribution_model->insertData($applyrecord,$contributionname, $amountofcontribution , $desccontribution , 1, 0, $system_user);

                    if($result->SuccessMessage=="success" and $createannoucement=='true')
                    {
                    	$TitleAnnouncement = "Contribution Name: ".$contributionname;
                    	$TitleDescription = $desccontribution. ". Corresponding Contribution Amount: ".$amountofcontribution. ".  ";
                    	$this->announcement->newAnnouncement($TitleAnnouncement, $TitleDescription , $system_user);
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
}



