<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controllercashiermodule101 extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_session')) :
			redirect('login',301);

		endif;
		$this->load->model('cashieringinfomodel','cashiering_model');
		
	}




	public function index()
	{
		$this->data = [];
		$this->data['pageTitle'] = "Cashiering";
		$this->data['pageSubtitle'] = "Cashiering Module";
		if($this->session->userdata('issetORnumber') !=true)
		{
			$this->data['issetORnumber'] ="";
			$this->data['ORnumber'] = "";
		}
		else
		{
			$this->data['issetORnumber'] ="set";
			$this->data['ORnumber'] = $this->session->userdata('ORnumber');
		}
		$this->data['content'] = $this->load->view('cashiering/home',$this->data, true );
		$this->data['home_script'] = $this->load->view('cashiering/home_script',$this->data, true );
		$this->load->view('layouts/main', $this->data );
	}

	function paymenttransaction()
	{
		$TotalCashToBePaid = 0;
		$TotalDiscount = 0;
		$loadRemainingBalanceArray = json_decode($_POST['loadRemainingBalanceArray']) ;
		
		
		/**/


		//$category = $this->htmlpurifier_lib->purify($category);
		$TotalCashToBePaid = $this->htmlpurifier_lib->purify($_POST['TotalCashToBePaid']);
		$TotalCashReceived = $this->htmlpurifier_lib->purify($_POST['TotalCashReceived']);
		$TotalCashChanged = $this->htmlpurifier_lib->purify($_POST['TotalCashChanged']);
		$TotalDiscount = $this->htmlpurifier_lib->purify($_POST['TotalDiscount']);
		$payorID = $this->htmlpurifier_lib->purify($_POST['memberID']);
		$payorFullname = $this->htmlpurifier_lib->purify($_POST['memberFullname']);
		$data = array(
			$this->session->userdata('ORnumber'),  // replace with actual ORNUmber
		    date("Y-m-d") , // replace with actual date
		    $payorID ,             // replace with actual PayorID
		    $payorFullname ,    // replace with actual PayorName
		    $TotalCashToBePaid,        // replace with actual AmountDue
		    $TotalCashReceived,        // replace with actual CashReceive
		    $TotalCashChanged,         // replace with actual Change
		    $TotalDiscount,         // replace with actual Discount
		    convertNumberToWord($TotalCashReceived), // replace with actual AmountinWords
		    123,           // replace with actual CashierID
		   1,        // replace with actual entry_by
		);


		

		$result = $this->cashiering_model->saveTransaction($data);

		// Access the result
		$currentId = $result['CurrentID'];
		$message = $result['SuccessMessage'];
		if($message=="success")
		{
			if (is_array($loadRemainingBalanceArray)) {
			    foreach ($loadRemainingBalanceArray as $key) {
			        $Debit = $key->Debit;
			        if(isset($key->Discount))
			        {
			        	$Discount = $this->htmlpurifier_lib->purify($key->Discount);
			        }
			        else
			        {
			        	$Discount=0;
			        }

			        if(isset($key->Remarks))
			        {
			        	$Remarks = $this->htmlpurifier_lib->purify($key->Remarks);
			        }
			        else
			        {
			        	$Remarks='';
			        }
			        if(isset($key->EntryID))
			        {
			        	$EntryID = $this->htmlpurifier_lib->purify($key->EntryID);
			        }
			        else
			        {
			        	$EntryID='';
			        }

			        if(isset($key->ChartCode))
			        {
			        	$ChartCode = $this->htmlpurifier_lib->purify($key->ChartCode);
			        }
			        else
			        {
			        	$ChartCode='';
			        }
			        
			        $referenceID = $currentId;
			        $ChartAccountID = $this->cashiering_model->getChartAccountID($ChartCode);
			        
			        $data2 = array(
			        	'entryID' => $EntryID, // EntryID of person balance
			        	'TransactionTypeID' => 2, //TransactionTypeID of Payment
			        	'ReferenceID' => $referenceID, //ReferenceID
			        	'ChartAccountID' => $ChartAccountID['ChartID'] , //ChartAccountID
			        	'description' => $Remarks , //description
			        	'amountPaid' => $Debit , //amountPaid
			        	'payorFullname' => $payorFullname , //amountPaid
			        	'payorID' => $payorID , //amountPaid
			        	'Discount' => $Discount , //Discount
			        	'TransRefNo' => $EntryID . ";". $currentId, //TransRefNo

			        	 );
			        //echo json_encode($data2);

			        $this->cashiering_model->saveTransactionDetails($data2);


			    }
			    $SetORnumber =  $this->session->userdata('ORnumber')+1;
			    $this->session->set_userdata(array(
					'ORnumber' => $SetORnumber  , 
				));
				$data_res = array('message' => "success", );
			}
			else
			{
				$data_res = array('message' => "success", );
			}
		}

		echo json_encode($data_res);
	}

	public function findinfo($category = '')
	{
		$category = $this->htmlpurifier_lib->purify($category);


		/*if(isset($this->input->post('searchTerm')))
		{
			$fieldValue = $this->htmlpurifier_lib->purify($this->input->post('search')) ;
		}
		else
		{
			$fieldValue = "" ;
		}*/
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

	public function savetransactioninfo()
	{

		$this->form_validation->set_rules('cashieringname', 'First Name', 'required|trim|htmlspecialchars');
		
		$this->form_validation->set_rules('amountofcashiering', 'Last Name', 'required|trim|htmlspecialchars');

		// Check if form validation passed
		if ($this->form_validation->run()) {
		    // Form validation passed, no errors
		    
                    $cashieringname  = $this->htmlpurifier_lib->purify($this->input->post('cashieringname'));
                    $amountofcashiering = $this->filtering_process->test_input($this->input->post('amountofcashiering'));
                    $desccashiering = $this->htmlpurifier_lib->purify($this->input->post('desccashiering'));

                    $applyrecord = $this->htmlpurifier_lib->purify($this->input->post('applyrecord'));


                     $system_user = 1;
                
                    $result = $this->cashiering_model->insertData($applyrecord,$cashieringname, $amountofcashiering , $desccashiering , 1, 0, $system_user);

                    
                	$data = array(
				        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
				        'message_details' => '',
				        
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

	function loadRemainingBalance()
	{
		if(isset($_POST['memberID']))
		{
			
			$memberID  = $this->htmlpurifier_lib->purify($this->input->post('memberID'));

			$data = array(
					'memberID' => $memberID,
			);	
			$query = $this->cashiering_model->loadRemainingBalance($data);
			header('Content-Type: application/json');
			echo json_encode($query);	
		}
	}
	function checkornumber()
	{
		$this->form_validation->set_rules('ornumber', 'OR Number', 'required|trim|htmlspecialchars');
		// Check if form validation passed
		if ($this->form_validation->run()) {
		    // Form validation passed, no errors		    
            $ornumber  = $this->htmlpurifier_lib->purify($this->input->post('ornumber'));
            $data = array(
					'ornumber' => $ornumber,
			);	
			$result = $this->cashiering_model->checkornumber($data);
			if($result->SuccessMessage=="not exist")
			{
				$this->session->set_userdata(array(
					'issetORnumber' => true , 
					'ORnumber' => $ornumber  , 
				));
			}
			else
			{
				$this->session->set_userdata(array(
					'issetORnumber' => false , 
					'ORnumber' => "" , 
				));
			}
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
		        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
		        'message_details' => '',
		        
		    );
        }

        echo json_encode($data);



	}
}



