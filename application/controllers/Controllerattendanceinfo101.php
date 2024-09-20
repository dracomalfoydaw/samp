<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controllerattendanceinfo101 extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_session')) :
			redirect('login',301);

		endif;
		
		$this->load->model('Attendanceinfomodel','attendance');
		$this->load->model('Membershipinfomodel','members');
		$this->load->model('Announcementinfomodel','announcement');
	}




	public function index()
	{
		$this->data = [];
		$this->data['pageTitle'] = "Attendance Information";
		$this->data['pageSubtitle'] = "Profile";
		$this->data['pageSubtitleTable'] = "List of Attendance Create";
		$this->data['custom_css'] = $this->load->view('attendance/home/css_script',$this->data,true);
		$this->data['content'] = $this->load->view('attendance/home/home',$this->data, true );
		$this->data['home_script'] = $this->load->view('attendance/home/home_script',$this->data, true );
		$this->load->view('layouts/main', $this->data );
	}

	public function view_attendance($EntryID = null) {
        // Check if $EntryID is not null
        if ($EntryID !== null) {
            // Echo the value
			$EntryID  = $this->htmlpurifier_lib->purify($EntryID);
        } else {
            // Handle the case where $EntryID is null
           redirect("attendance");
        }
		$result = $this->attendance->getAttendanceInfo($EntryID);
		$this->data = [];
		$this->data['AttendanceEntryID'] = $EntryID ;
		$this->data['pageTitle'] = "Attendance Information: ". $result->Name ;
		$this->data['pageSubtitle'] =  $result->Description;
		$this->data['pageSubtitleTable'] = "List of Attendance";
		$this->data['content'] = $this->load->view('attendance/details/home',$this->data, true );
		$this->data['home_script'] = $this->load->view('attendance/details/home_script',$this->data, true );
		$this->load->view('layouts/main', $this->data );
	}

	function check_attendance()
	{
		$this->form_validation->set_rules('AttendanceEntryID', 'AttendanceEntryID', 'required|trim|htmlspecialchars');
		$this->form_validation->set_rules('memberID', 'Member ID', 'required|trim|htmlspecialchars');

		if ($this->form_validation->run()) {
			$AttendanceEntryID  = $this->htmlpurifier_lib->purify($this->input->post('AttendanceEntryID'));
			$memberID  = $this->htmlpurifier_lib->purify($this->input->post('memberID'));

			$res = $this->members->getMembersInfo($memberID);
			if(count($res)==1)
			{
				$ProfileID = "";
				foreach ($res as $key ) {
					$ProfileID = $key->ProfileID;
				}
				$result = $this->attendance->insertAttendanceDetails($AttendanceEntryID, $ProfileID, 1);
				 $data = array(
					        'message' =>  $result->SuccessMessage,  // Assuming success when validation passes
					        'message_details' => '',
					        
					    );
			}
			else
			{
				$message_details = '<li> Error </li>';//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
		    	$data = array(
			        'message' => "error",
			        'message_details' => $message_details,
			        'id' => '',
			    );
			    
			}
			echo json_encode($data);
			
			
		}
		else
		{
			$message_details = validation_errors('<li>', '</li>');//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
		    $data = array(
		        'message' => "error",
		        'message_details' => $message_details,
		        'id' => '',
		    );
		    echo json_encode($data);
		}
	}

	function findprofileinfoAttendee($EntryID = null)
	{
		// Check if $EntryID is not null
       /* if ($EntryID !== null) {
            // Echo the value
			$EntryID  = $this->htmlpurifier_lib->purify($EntryID);
        } else {
            // Handle the case where $EntryID is null
           redirect("attendance");
        }*/

		if(isset($this->input->post('search')['value']))
		{
			$fieldValue = $this->htmlpurifier_lib->purify($this->input->post('search')['value']) ;
		}
		else
		{
			$fieldValue = "" ;
		}
		
		echo json_encode($this->attendance->getAttendancePersonneList($EntryID ,$fieldValue)) ;
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
		
		echo json_encode($this->attendance->getAttendanceData($fieldValue)) ;
	}

	public function savetransactioninfo()
	{

		$this->form_validation->set_rules('Name', 'Name', 'required|trim|htmlspecialchars');
		
		//$this->form_validation->set_rules('Fines', 'Fines Imposed', 'isnumeric|htmlspecialchars');

		// Check if form validation passed
		if ($this->form_validation->run()) {
		    // Form validation passed, no errors
		    		$EntryByID = 1; //session id of encoder
                    $Name  = $this->htmlpurifier_lib->purify($this->input->post('Name'));
                    $Description = $this->htmlpurifier_lib->purify($this->input->post('Description'));
                    $Fines = $this->htmlpurifier_lib->purify($this->input->post('Fines'));
                    $datescheduled = $this->htmlpurifier_lib->purify($this->input->post('datescheduled'));
                    $createannoucement = $this->htmlpurifier_lib->purify($this->input->post('createannoucement'));
                    $phpdate = strtotime( $datescheduled );
                    $mysqldate = date( 'Y-m-d', $phpdate );
                    $system_user = 1;
                
                    $result = $this->attendance->insertProfile($Name, $Description, $Fines, $mysqldate);
                    if($result->SuccessMessage=="success" and $createannoucement=='createannoucement')
                    {
                    	$TitleAnnouncement = "Activity Name: ".$Name;
                    	$TitleDescription = $Description. ". Corresponding Fines: ".$Fines. ".  Date : ". $mysqldate;
                    	$this->announcement->newAnnouncement($TitleAnnouncement, $TitleDescription , $EntryByID);
                    }
                    

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
}



