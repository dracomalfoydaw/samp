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

	public function updateListofPayment()
	{
		$this->form_validation->set_rules('amount', 'Amount Fees', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('EntryID', 'Fees', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('memberID', 'memberID', 'required|trim|htmlspecialchars');
		if ($this->form_validation->run()) {
				$amount = $this->htmlpurifier_lib->purify($this->input->post('amount')) ;
				$EntryID = $this->htmlpurifier_lib->purify($this->input->post('EntryID')) ;
				$memberID = $this->htmlpurifier_lib->purify($this->input->post('memberID')) ;
				$Remarks = $this->htmlpurifier_lib->purify($this->input->post('Remarks')) ;

				$payments = $this->accounting_model->UpdateCreditonJournal($EntryID, $amount,$Remarks);
				
				$message_details = "";
				$data = array(
			        'message' => $payments->SuccessMessage,
			        'message_details' => '',
			    );
		}
		else
		{
			$message_details = validation_errors('<li>', '</li>');
		    	$data = array(
			        'message' => "error",
			        'message_details' => $message_details,
			        'message_result' => '',
			    );


		}
		echo json_encode($data);			
	}

	public function insertnewpayment()
	{
		$this->form_validation->set_rules('data', 'Fees', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('typePayment', 'Category', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('memberID', 'memberID', 'required|trim|htmlspecialchars');
		if ($this->form_validation->run()) {
				$typePayment = $this->htmlpurifier_lib->purify($this->input->post('typePayment')) ;
				$data = $this->htmlpurifier_lib->purify($this->input->post('data')) ;
				$remarks = $this->htmlpurifier_lib->purify($this->input->post('remarks')) ;
				$memberID = $this->htmlpurifier_lib->purify($this->input->post('memberID')) ;

				$payments = $this->accounting_model->addNewPayment($typePayment, $data,$memberID, $this->session->userdata('uid'),$remarks);
				$message_details = "";
				$data = array(
			        'message' => $payments->SuccessMessage,
			        'message_details' => $typePayment,
			        'message_result' => $payments ,
			    );
		}
		else
		{
			$message_details = validation_errors('<li>', '</li>');
		    	$data = array(
			        'message' => "error",
			        'message_details' => $message_details,
			        'message_result' => '',
			    );


		}
		echo json_encode($data);
	}

	public function removeListofPayment()
	{
		$this->form_validation->set_rules('selectedTransactions', 'Fees', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('memberID', 'memberID', 'required|trim|htmlspecialchars');
		if ($this->form_validation->run()) {
			$memberID = $this->htmlpurifier_lib->purify($this->input->post('memberID')) ;
			if(isset($_POST['selectedTransactions'])) {
			    // Split the comma-separated string into an array
			    $selectedTransactions = explode(',', $_POST['selectedTransactions']);

			    // Iterate over the array
			    foreach ($selectedTransactions as $EntryID ) {
			        // Assuming $this->htmlpurifier_lib->purify() and $memberID are defined elsewhere
			        $EntryID = $this->htmlpurifier_lib->purify($EntryID);
			        $this->accounting_model->deleteListofPayment($EntryID, $memberID);
			    }

			    $message = "success";
			    $message_details = "";
			}
			else
			{
				$message = "error";
				$message_details = "<li> No transaction occured</li>";
			}
			$data = array(
			        'message' => $message,
			        'message_details' => $message_details,
			        'message_result' => '',
			    );
		}
		else
		{
			$message_details = validation_errors('<li>', '</li>');
		    	$data = array(
			        'message' => "error",
			        'message_details' => $message_details,
			        'message_result' => '',
			    );


		}
		echo json_encode($data);

	}

	public function getListofPaymenttoAdd()
	{
		$this->form_validation->set_rules('typePayment', 'Category', 'required|trim|htmlspecialchars');
		if ($this->form_validation->run()) {
				$typePayment = $this->htmlpurifier_lib->purify($this->input->post('typePayment')) ;
				$searchvalue = $this->htmlpurifier_lib->purify($this->input->post('searchvalue')) ;

				$payments = $this->accounting_model->getListofPaymenttoAdd($typePayment, $searchvalue);
				$message_details = "";
				$data = array(
			        'message' => "success",
			        'message_details' => $typePayment,
			        'message_result' => $payments ,
			    );
		}
		else
		{
			$message_details = validation_errors('<li>', '</li>');
		    	$data = array(
			        'message' => "error",
			        'message_details' => $message_details,
			        'message_result' => '',
			    );


		}
		echo json_encode($data);
	}

	public function individual_assessment()
	{
		$this->data = [];
		$this->data['pageTitle'] = "Accounting";
		$this->data['pageSubtitle'] = "Account balances Module";
		if( $this->session->userdata('gid')==3 )
		{
			$this->data['custom_css'] = $this->load->view('accounting/individual/assessment/css_script',$this->data,true);
			$this->data['content'] = $this->load->view('accounting/individual/assessment/home',$this->data, true );
			$this->data['home_script'] = $this->load->view('accounting/individual/assessment/home_script',$this->data, true );
		}
		else
		{
			$this->data['custom_css'] = $this->load->view('accounting/overall/assessment/css_script',$this->data,true);
			$this->data['content'] = $this->load->view('accounting/overall/assessment/home',$this->data, true );
			$this->data['home_script'] = $this->load->view('accounting/overall/assessment/home_script',$this->data, true );
		}
		
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

	        if( $this->session->userdata('gid')==3 )
        	{
        		$this->data['custom_css'] = $this->load->view('accounting/individual/ledger/css_script',$this->data,true);
		        $this->data['content'] = $this->load->view('accounting/individual/ledger/home', $this->data, true);
		        $this->data['home_script'] = $this->load->view('accounting/individual/ledger/home_script', $this->data, true);
        	}
        	else
        	{
        		$this->data['custom_css'] = $this->load->view('accounting/overall/ledger/css_script',$this->data,true);
		        $this->data['content'] = $this->load->view('accounting/overall/ledger/home', $this->data, true);
		        $this->data['home_script'] = $this->load->view('accounting/overall/ledger/home_script', $this->data, true);
        	}


	        
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
		$limit = $this->input->post('limit');
		if (empty($limit) || !is_numeric($limit)) {
		    $limit = 10;
		} else {
		    $limit = $this->htmlpurifier_lib->purify($limit);
		}

		$start = $this->input->post('offset');
		if (empty($start) || !is_numeric($start)) {
		    $start = 0;
		} else {
		    $start = $this->htmlpurifier_lib->purify($start);
		}

		if($this->session->userdata('gid')==3)
		{
			$memberID = $this->session->userdata('ProfileID');//$this->htmlpurifier_lib->purify($this->input->post('memberID'));
		}
		else
		{
			if(isset($_POST['memberID']) && $_POST['memberID'] !='')
			{
				$memberID  = $this->htmlpurifier_lib->purify($this->input->post('memberID'));
			}
			else
			{
				redirect('accounting/assessment',301);
			}
		}
		

		$query = $this->accounting_model->GetLedgerEntries($memberID,$start,$limit);
		header('Content-Type: application/json');
		echo json_encode($query);	
	}
	function loadGetAssestmentEntries()
	{
		if($this->session->userdata('gid')==3)
		{
			$memberID = $this->session->userdata('ProfileID');
			//echo $memberID;
			$data = array(
					'memberID' => $memberID,
			);	
			$query = $this->cashiering_model->loadRemainingBalance($data);
			header('Content-Type: application/json');
			echo json_encode($query);	
		}
		else
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
}



