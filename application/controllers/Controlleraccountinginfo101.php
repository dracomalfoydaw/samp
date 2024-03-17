<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controlleraccountinginfo101 extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_session')) :
			redirect('login',301);

		endif;
		$this->load->model('Membershipinfomodel','members');
		$this->load->model('User_model');
		$this->load->model('Accountinginfomodel','accounting_model');
		$this->load->model('cashieringinfomodel','cashiering_model');
	}


	public function index()
	{
		redirect('accounting/assessment',301);
	}

	public function individual_assessment()
	{
		$this->data = [];
		$this->data['pageTitle'] = "Accounting";
		$this->data['pageSubtitle'] = "Assessment/Billing Module";
		
		$this->data['content'] = $this->load->view('accounting/assessment/home',$this->data, true );
		$this->data['home_script'] = $this->load->view('accounting/assessment/home_script',$this->data, true );
		$this->load->view('layouts/main', $this->data );
	}
	public function individual_ledger($memberID = null)
	{
	    if ($memberID === null) {
	        // Handle the case where $memberID is null, perhaps redirect to another page or display an error message
	    } else {
	        // Proceed with the normal function logic
	       
	    }
	     $this->data = [];
	        $this->data['pageTitle'] = "Accounting";
	        $this->data['pageSubtitle'] = "Ledger Module";
	        
	        $this->data['content'] = $this->load->view('accounting/ledger/home', $this->data, true);
	        $this->data['home_script'] = $this->load->view('accounting/ledger/home_script', $this->data, true);
	        $this->load->view('layouts/main', $this->data);
	}


	public function findinfo($category = '')
	{
		$category = $this->htmlpurifier_lib->purify($category);


		if(isset($_POST['searchTerm']))
		{
			$fieldValue = $this->htmlpurifier_lib->purify($this->input->post('searchTerm')) ;
		}
		else
		{
			$fieldValue = "" ;
		}
		echo json_encode($this->cashiering_model->getMembersData($fieldValue, $category)) ;
	}

	

	function loadGetLedgerEntries()
	{
		if(isset($_POST['memberID']))
		{
			
			$memberID  = $this->htmlpurifier_lib->purify($this->input->post('memberID'));

			$data = array(
					'memberID' => $memberID,
			);	
			$query = $this->accounting_model->GetLedgerEntries($data);
			header('Content-Type: application/json');
			echo json_encode($query);	
		}
	}
	function loadGetAssestmentEntries()
	{
		if(isset($_POST['memberID']))
		{
			
			$memberID  = $this->htmlpurifier_lib->purify($this->input->post('memberID'));

			$data = array(
					'memberID' => $memberID,
			);	
			$query = $this->accounting_model->GetAssestmentEntries($data);
			header('Content-Type: application/json');
			echo json_encode($query);	
		}
	}
}



