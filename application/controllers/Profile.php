<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_session')) :
			redirect('login',301);

		endif;
		//if($this->session->userdata('gid')==1 or $this->session->userdata('gid')==2):
			$this->load->model('Accountinfomodel','account');
			$this->load->model('User_model','user_model');
			$this->load->model('Logs_model','logs_model');
			$this->load->model('Membershipinfomodel','members');
		/*else:
			redirect('home',301);
		endif;*/
		
	}
	public function index()
	{
		$this->data = [];
		$this->data['pageTitle'] = "My Account";
		$this->data['pageSubtitle'] = "Profile";
		$this->data['pageSubtitleTable'] = "List of Attendance Create";
		$this->data['pageTitleOption'] = "Template";
		$this->data['content'] = $this->load->view('profile/home',$this->data,true);
		$this->data['home_script'] = $this->load->view('profile/script',$this->data,true);
		$this->data['custom_css'] = $this->load->view('profile/css_script',$this->data,true);
		$this->load->view('layouts/main', $this->data );
	}

	public function logout()
	{
		$this->session->set_userdata(array(
            'logged_in_session'  => "",
            'uid'    => "",
            'ProfileID'    => "",
            'username'    => "",
            'email'    =>  "",
            'gid'    => "",
              
             
            'fid'    => "",
            'lname'    =>  "",
            'fname'    => "",
            'mname'    => "",
        ));

        redirect("login");
	}

	 public function save_info() {
		//$this->user_model->check_session_status();
		//$entryBy =   $this->encryption->decrypt($this->session->userdata('uid'));
		$entryBy =   $this->session->userdata('uid');
		$data = json_decode(file_get_contents('php://input'), true);
		$session_log  = $this->encryption->decrypt($data['session_log']);
		if($session_log==CNF_SESSION_LOG): // session for ajax is active

			// Debugging: Check if data is received correctly
	        if (!$data) :
	            $this->output
	                ->set_content_type('application/json')
	                ->set_output(json_encode(['success' => false, 'message' => 'No data received']));
	            return;
	        endif;
	        // Set validation rules
	        $email_error_message = "Can't Proceed on Registration. Email already registered on Profile Members";
	        $email_error_message_2 = "Invalid Email Address!";

	        
        	$this->form_validation->set_data($data);
			$this->form_validation->set_rules('username', 'Username', 'required|trim|htmlspecialchars');
	        $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|htmlspecialchars');
	        $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|htmlspecialchars');
	        $this->form_validation->set_rules('email', 'Email Address', 'required|trim|htmlspecialchars|htmlspecialchars', array('valid_email' => $email_error_message_2,) );


			if ($this->form_validation->run() == FALSE) :
				/* $errors = $this->form_validation->error_array();
            	$formatted_errors = $this->format_errors_with_br($errors);*/

	            $this->output
	                ->set_content_type('application/json')
	                ->set_output(json_encode([
	                    'success' => false,
	                    'message' => validation_errors('<li>', '</li>'),
	                ]));
        	else :
				$username = $this->htmlpurifier_lib->purify($data['username']);
				$firstname = $this->htmlpurifier_lib->purify($data['firstname']);
				$middlename = $this->htmlpurifier_lib->purify($data['middlename']);
				$lastname =  $this->htmlpurifier_lib->purify($data['lastname']);
				$nameExtension =  $this->htmlpurifier_lib->purify($data['nameExtension']);
				$email =  $this->htmlpurifier_lib->purify($data['email']);
				if($this->session->userdata('username')==$username and $this->session->userdata('fname')==$firstname and $this->session->userdata('mname')==$middlename and $this->session->userdata('lname')==$lastname and $this->session->userdata('nameext')==$nameExtension and $this->session->userdata('eid')==$email ):					
	        		$this->output
	                    ->set_content_type('application/json')
	                    ->set_output(json_encode(['success' => true]));
				else:
					
					$change_email_status = null;
					$data = array(
						'first_name' => $firstname,
						'middle_name' => $middlename,
						'last_name' => $lastname,
						'nameext' => $nameExtension,
						 );

					if($this->session->userdata('username')!=$username): //check if new email is not equal on existing email
						$result = $this->user_model->check_username_exist($username, $entryBy);
						if(count($result)> 0 ): //check if email is existed on other account
							$this->output
			                ->set_content_type('application/json')
			                ->set_output(json_encode([
			                    'success' => false,
			                    'message' => "Username already used.",
			                    'error_code' =>"duplicate_username",
			                ]));
						return;
						else:
							$data['username'] =$username ;
						endif;
					endif;

					if($this->session->userdata('eid')!=$email): //check if new email is not equal on existing email
						$result = $this->user_model->check_email_exist($email, $entryBy);
						if(count($result)> 0 ): //check if email is existed on other account
							$this->output
			                ->set_content_type('application/json')
			                ->set_output(json_encode([
			                    'success' => false,
			                    'message' => "Email Address already registered",
			                    'error_code' =>"duplicate_email",
			                ]));
							return;
			            else:
			            	$currentDateTime = new DateTime();
			            	$currentDateTime->modify('+'.CNF_SET_CODE_EXPIRATION_MINUTES.' minutes');
               				$activation_expiry = $currentDateTime->format('Y-m-d H:i:s');

			            	$change_email_status  = 1;
			            	$code = rand(100000,100000000);

			            	$data['email'] =$email ;
					        $data['change_email_status'] =1 ;
					        $data['verify'] =0 ;
					        $data['activation'] = $code  ;
					        $data['activation_expiry'] = $activation_expiry;
					        $this->session->set_userdata(array('ChangeEmailStatus' => 1,));
						endif;
					endif;
					


				
					$this->db->where( array( 'id' =>  $entryBy));
			 		$this->db->update( "tb_users" , $data );

			 		$note = "Update Profile Information";
        			//$this->user_model->insertLog($note,"profile" ,$entryBy ,"users", $entryBy,$entryBy);

			 		if($middlename) :// check middle name is blank                  
			            $Fullname = $firstname . ' '. $lastname;                  
			         else:                  
			            $Fullname = $firstname . ' '. $middlename . ' '. $lastname;                  
			         endif;

			 		$this->session->set_userdata(array(
		               'eid'    => $email,
		               'fid'    => $Fullname,
		               'lname'    =>  $lastname,
		               'fname'    => $firstname ,
		               'mname'    => $middlename,
		               'nameext'    => $nameExtension ,
		               'username'    => $username ,
		            ));

			 		if($change_email_status  == 1):

			 			$this->session->set_userdata(array(
			               'ChangeEmailStatus'    =>  1,
			            ));

			            $this->email_model->process_2_way_auth($Fullname,$email,$randCode);
			            
			 			$this->output
			                ->set_content_type('application/json')
			                ->set_output(json_encode([
			                    'success' => false,
			                    'error_code' =>"email_confirmation_code",
			                    'message' => "Form submitted successfully!",
			                ]));
			 		else:
				 		$this->output
		                    ->set_content_type('application/json')
		                    ->set_output(json_encode(['success' => true]));
	                endif;

	                    
				endif;
        	endif;
		else:
        	redirect('home',301);
        endif;
    }

	public function uploadImage() {
		//$this->user_model->check_session_status();
		$entryBy =   $this->session->userdata('uid');//$this->encryption->decrypt($this->session->userdata('uid'));
		$session_log  = $this->encryption->decrypt($this->input->post('session_log'));
		if($session_log==CNF_SESSION_LOG): // session for ajax is active

        $config['upload_path'] = './uploads/users/';
        $config['allowed_types'] = 'jpg';
        $config['max_size'] = 5120; // 5MB limit

        // Load upload library
        $this->load->library('upload', $config);

        // Check if the file was uploaded
        if (!$this->upload->do_upload('file')) {
            $response = array('success' => false, 'error' => $this->upload->display_errors());
        } else {
            $data = $this->upload->data();
            $file_ext = $data['file_ext'];
            $new_filename = uniqid() . '-' . substr(md5(mt_rand()), 0, 5).date("YYmmddhhss") . $file_ext;
            rename($data['full_path'], $data['file_path'] . $new_filename);
            $data = array('avatar' => $new_filename, );
            $this->db->where( array( "id" =>  $this->session->userdata('uid') ));
           //  $this->db->where( array( "id" =>  $this->encryption->decrypt($this->session->userdata('uid')) ));
			$this->db->update( "tb_users" , $data );
			$this->session->set_userdata(array(
				 'avatar'    => $new_filename ,
			));
            $response = array('success' => true, 'file_name' => $new_filename);
        }

        $note = "Update Profile Picture";
        //$this->user_model->insertLog($note,"profile" ,$entryBy ,"users", $entryBy,$entryBy);
        echo json_encode($response);
        else:
        	redirect('home',301);
        endif;
    }


	public function logs()
	{
		//$this->user_model->check_session_status();
		$system_user_login = $this->session->userdata('logged_in_session');

		$session_log  = $this->encryption->decrypt($this->input->get('session_log'));
		if($session_log==CNF_SESSION_LOG): // session for ajax is active

		    if($system_user_login == true):
        		$session_log = true;
        	else:
        		$session_log = false;
        	endif;

            // Get the start and limit parameters from the request
            $start = $this->input->get('start');
            $limit = $this->input->get('limit');
            $search = $this->htmlpurifier_lib->purify($this->input->get('search'));
            $sortColumn = $this->htmlpurifier_lib->purify($this->input->get('sortColumn'));
            $sortOrder = $this->htmlpurifier_lib->purify($this->input->get('sortOrder'));  

            $data = $this->logs_model->search_data($start,$limit,$sortColumn,$sortOrder,$search,$session_log); 
            // Return the data as JSON
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
   

        else:
        	redirect('home',301);
        endif;
		
	}

	public function membership($category = null,$type=null)
	{
		$ProfileID =   $this->session->userdata('ProfileID');//$this->encryption->decrypt($this->session->userdata('uid'));

		$data = $this->members->get_data_details($this->htmlpurifier_lib->purify($ProfileID));

    	if($data !='')
    	{
    		
    	}
    	else
    	{
    		redirect('profile',301);
    	}

		if($category=="uploadImage")
		{
			$entryBy = $this->session->userdata('uid');// $this->encryption->decrypt($this->session->userdata('uid'));
			$session_log  = $this->encryption->decrypt($this->input->post('session_log'));
			//$ProfileID  = $this->htmlpurifier_lib->purify($this->input->post('ini_username'));

			if($session_log==CNF_SESSION_LOG): // session for ajax is active

				$config['upload_path'] = './uploads/users/';
		        $config['allowed_types'] = 'jpg';
		        $config['max_size'] = 5120; // 5MB limit

		        // Load upload library
		        $this->load->library('upload', $config);


				$data = $this->members->get_data_details($ProfileID);

		    	if($data !='')
		    	{
		    		$primaryID = $this->encryption->decrypt($data['TransID']);

		    		// Check if the file was uploaded
			        if (!$this->upload->do_upload('file')) {
			            $response = array('success' => false, 'error' => $this->upload->display_errors());
			        } else {
			            $data = $this->upload->data();
			            $file_ext = $data['file_ext'];
			            $new_filename = uniqid() . '-' . substr(md5(mt_rand()), 0, 5).date("YYmmddhhss") . $file_ext;
			            rename($data['full_path'], $data['file_path'] . $new_filename);
			            $data = array('avatar' => $new_filename, );
			            $this->db->where( array( "ProfileID" => $primaryID));
						$this->db->update( "tb_profile" , $data );

			            $response = array('success' => true, 'file_name' => $new_filename,'primaryID' => $primaryID, );
			        }

			        $note = "Update Members Picture";
			        //$this->user_model->insertLog($note,"profile" ,$entryBy ,"users", $entryBy,$entryBy);
		    	}
		    	else
		    	{
		    		$response = array('success' => false, 'file_name' => '');
		    	}
		        
		        echo json_encode($response);
	        else:
	        	redirect('home',301);
	        endif;
		}
		elseif($category=="officerrecord"){
			$system_user_login = $this->session->userdata('logged_in_session') ;
			if($type =="delete" or $type =="add" ):
				$session_log  = $this->encryption->decrypt($this->input->post('session_log'));
			else:
	        	$session_log  = $this->encryption->decrypt($this->input->get('session_log'));
			endif;
	        if($session_log==CNF_SESSION_LOG): // session for ajax is active
	        	if($system_user_login == true):
	        		$session_log = true;
	        	else:
	        		$session_log = true;
	        	endif;

	        	if($type =="add" ):
	        		$this->form_validation->set_rules('Remarks', 'Remarks', 'required|trim|htmlspecialchars');
	        		$this->form_validation->set_rules('LodgeNo', 'Lodge Number', 'required|trim|htmlspecialchars');
	        		$this->form_validation->set_rules('LodgeName', 'Lodge Name', 'required|trim|htmlspecialchars');
	        		$this->form_validation->set_rules('Type', 'Type', 'required|trim|htmlspecialchars');
	        		$this->form_validation->set_rules('Position', 'Position Name', 'required|trim|htmlspecialchars');

	        		$Remarks  =  $this->htmlpurifier_lib->purify($this->input->post('Remarks'));
			    	$DateTransaction  =  $this->htmlpurifier_lib->purify($this->input->post('DateTransaction'));
			    	$LodgeNo  =  $this->htmlpurifier_lib->purify($this->input->post('LodgeNo'));		    	
			    	$LodgeName  =  $this->htmlpurifier_lib->purify($this->input->post('LodgeName'));
			    	$Type  =  $this->htmlpurifier_lib->purify($this->input->post('Type'));
			    	$Position  =  $this->htmlpurifier_lib->purify($this->input->post('Position'));
			    	$UniqueID  =  $ProfileID;

			    	if ($this->form_validation->run()) {
	        			$form_validation_status = true;
	        		}
	        		else
	        		{
	        			$form_validation_status = false;
	        			$message_details = validation_errors('<li>', '</li>');//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
	        		}
	        		if($form_validation_status == true):

	        			$ProfileID	 = "";
						$query_res = $this->db->query("select * from tb_profile where UniqueID='$UniqueID'");
						foreach ( $query_res->result() as $row) {
							$ProfileID = $row->ProfileID;
						}
	        			$data_transaction = array(
				    		'Remarks' => $Remarks,
				    		'DateTransaction' => $DateTransaction,
				    		'LodgeNo' => $LodgeNo,
				    		'LodgeName' => $LodgeName,
				    		'LodgeName' => $LodgeName,
				    		'Type' => $Type,
				    		'Position' => $Position,
				    		'UniqueID' => $UniqueID,
				    		'ProfileID' => $ProfileID,
				    	);
				    	$data = $this->members->add_officer_remarks($session_log,$data_transaction);
	        		else:
		        		$data = array('session_log' => $session_log ,'data' => '' , 'message_details' => $message_details, 'success' => false,);
		        	endif;

				   

			    	
	        	elseif($type =="delete" ):
	        		// Check if 'data' is set in $_POST and is not empty
					if (isset($_POST['data']) && !empty($_POST['data'])) {
					    // Decode JSON data from Vue.js
					    $temp_id_res = json_decode($_POST['data'], true);

					    if ($temp_id_res !== null) { // Check if decoding was successful

					    	$data = $this->members->delete_officer_remarks($temp_id_res,$session_log);
					    } else {
					        // Handle case where JSON decoding failed
					        $data = array('session_log' => $session_log,  'success' => false);
					    }
					} else {
					    // Handle case where 'data' is not set or empty
					    $data = array('session_log' => $session_log,'success' => false);
					}
	        	elseif($type =="table" ):
	        		
		        	$id = $this->htmlpurifier_lib->purify($ProfileID);
		            // Get the start and limit parameters from the request
		            $start = $this->input->get('start');
		            $limit = $this->input->get('limit');
		            $search = $this->htmlpurifier_lib->purify($this->input->get('search'));
		            $sortColumn = $this->htmlpurifier_lib->purify($this->input->get('sortColumn'));
		            $sortOrder = $this->htmlpurifier_lib->purify($this->input->get('sortOrder'));  

		            $data = $this->members->search_data_officerrecord($start,$limit,$sortColumn,$sortOrder,$search,$session_log,$id ); 

		        else:
		        	$data = "";
	        	endif;
	        	
	            // Return the data as JSON
	            $this->output
	                ->set_content_type('application/json')
	                ->set_output(json_encode($data));
	   

	        else:
	            redirect('home',301);
	        endif;
		}
		elseif($category=="remarks"){
			$system_user_login = $this->session->userdata('logged_in_session') ;
			if($type =="delete" or $type =="add" ):
				$session_log  = $this->encryption->decrypt($this->input->post('session_log'));
			else:
	        	$session_log  = $this->encryption->decrypt($this->input->get('session_log'));
			endif;

			if($session_log==CNF_SESSION_LOG): // session for ajax is active
	        	if($system_user_login == true):
	        		$session_log = true;
	        	else:
	        		$session_log = true;
	        	endif;

	        	if($type =="add" ):
	        		$this->form_validation->set_rules('Remarks', 'Remarks', 'required|trim|htmlspecialchars');

	        		$Remarks  =  $this->htmlpurifier_lib->purify($this->input->post('Remarks'));
			    	$DateTransaction  =  $this->htmlpurifier_lib->purify($this->input->post('DateTransaction'));		    	
			    	$UniqueID  =  $ProfileID;

			    	if ($this->form_validation->run()) {
	        			$form_validation_status = true;
	        		}
	        		else
	        		{
	        			$form_validation_status = false;
	        			$message_details = validation_errors('<li>', '</li>');//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
	        		}
	        		if($form_validation_status == true):

	        			$ProfileID	 = "";
						$query_res = $this->db->query("select * from tb_profile where UniqueID='$UniqueID'");
						foreach ( $query_res->result() as $row) {
							$ProfileID = $row->ProfileID;
						}
	        			$data_transaction = array(
				    		'Remarks' => $Remarks,
				    		'DateTransaction' => $DateTransaction,
				    		'UniqueID' => $UniqueID,
				    		'ProfileID' => $ProfileID,
				    	);
				    	$data = $this->members->add_remarks($session_log,$data_transaction);
	        		else:
		        		$data = array('session_log' => $session_log ,'data' => '' , 'message_details' => $message_details, 'success' => false,);
		        	endif;

				   

			    	
	        	elseif($type =="delete" ):
	        		// Check if 'data' is set in $_POST and is not empty
					if (isset($_POST['data']) && !empty($_POST['data'])) {
					    // Decode JSON data from Vue.js
					    $temp_id_res = json_decode($_POST['data'], true);

					    if ($temp_id_res !== null) { // Check if decoding was successful

					    	$data = $this->members->delete_remarks($temp_id_res,$session_log);
					    } else {
					        // Handle case where JSON decoding failed
					        $data = array('session_log' => $session_log,  'success' => false);
					    }
					} else {
					    // Handle case where 'data' is not set or empty
					    $data = array('session_log' => $session_log,'success' => false);
					}
	        	elseif($type =="table" ):
	        		
		        	$id = $this->htmlpurifier_lib->purify($ProfileID);
		            // Get the start and limit parameters from the request
		            $start = $this->input->get('start');
		            $limit = $this->input->get('limit');
		            $search = $this->htmlpurifier_lib->purify($this->input->get('search'));
		            $sortColumn = $this->htmlpurifier_lib->purify($this->input->get('sortColumn'));
		            $sortOrder = $this->htmlpurifier_lib->purify($this->input->get('sortOrder'));  

		            $data = $this->members->search_data_remarks($start,$limit,$sortColumn,$sortOrder,$search,$session_log,$id ); 
		        else:
		        	$data = "";
	        	endif;
	        	
	            // Return the data as JSON
	            $this->output
	                ->set_content_type('application/json')
	                ->set_output(json_encode($data));
	   

	        else:
	            redirect('home',301);
	        endif;
		}
		elseif($category=="updatemasoninfo")
		{
			$system_user_login = $this->session->userdata('logged_in_session') ;
		   	$session_key  = $this->encryption->decrypt($this->input->post('session_log'));
	        if($session_key==CNF_SESSION_LOG): // session for ajax is active

	        	if($system_user_login == true):
	        		$session_log = true;
	        	else:
	        		$session_log = false;
	        	endif;
	        	
				/*$this->form_validation->set_rules('homeaddress', 'Home Address', 'required|trim|htmlspecialchars');
		    	$this->form_validation->set_rules('Province', 'Province Name', 'required|trim|htmlspecialchars');
		    	$this->form_validation->set_rules('Municipality', 'Municipality Name', 'required|trim|htmlspecialchars');
		    	$this->form_validation->set_rules('Barangay', 'Barangay Name', 'required|trim|htmlspecialchars');
		    	$this->form_validation->set_rules('ZipCode', 'ZipCode', 'required|trim|htmlspecialchars');*/
	        	$form_validation_status = true;
	        	$message_details = "";
	        	/*if($system_user_login == true):
	        		$session_log = true;
	        		if ($this->form_validation->run()) {
	        			$form_validation_status = true;
	        		}
	        		else
	        		{
	        			$form_validation_status = false;
	        			$message_details = validation_errors('<li>', '</li>');//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
	        		}
	        	else:
	        		$form_validation_status = false;
	        		$session_log = false;
	        	endif;*/
	        	$UniqueID  =  $ProfileID;
	        
	        	$recordStat  =  $this->htmlpurifier_lib->purify($this->input->post('recordStat'));
		    	$LodgeNo  =  $this->htmlpurifier_lib->purify($this->input->post('LodgeNo'));
		    	$LodgeName  =  $this->htmlpurifier_lib->purify($this->input->post('LodgeName'));
		    	$MasonDistrict  =  $this->htmlpurifier_lib->purify($this->input->post('MasonDistrict'));
		    	$initiated  =  $this->htmlpurifier_lib->purify($this->input->post('initiated'));
		    	$passed  =  $this->htmlpurifier_lib->purify($this->input->post('passed'));
		    	$raised  =  $this->htmlpurifier_lib->purify($this->input->post('raised'));
		    	$memberstatus  =  $this->htmlpurifier_lib->purify($this->input->post('memberstatus'));

		    	$data_transaction = array(
		    		'recordStat' => $recordStat ,
		    		'LodgeNo' => $LodgeNo ,
		    		'LodgeName' => $LodgeName ,
		    		'MasonDistrict' => $MasonDistrict ,
		    		'initiated' => $initiated ,
		    		'passed' => $passed ,
		    		'raised' => $raised ,
		    		'memberstatus' => $memberstatus ,
		    		  );

		        $this->db->where('UniqueID', $UniqueID); // Add the is_active condition
				$query = $this->db->get('tb_profile');
				$result = $query->result();
				$temp_id = "";

				if (count($result) > 0) {
				    foreach ($result as $row) {
				        $temp_id = $row->ProfileID; // Ensure ProfileID is a string or convertible to a string
				    }
				}


				if ($form_validation_status == true && $temp_id != '') {
				    // Assuming $data_transaction and $session_log are defined
				    $data = $this->members->updateinfo($temp_id, $session_log, $data_transaction);
				} else {
				    $data = array(
				        'session_log' => $session_log,
				        'data' => $temp_id,
				        'message_details' => $message_details,
				        'success' => false,
				    );
				}

				$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($data));

	        else:            
				redirect('template',301);
	        endif;
		}
		elseif($category=="updateinfo")
		{
			$system_user_login = $this->session->userdata('logged_in_session') ;
		   	$session_key  = $this->encryption->decrypt($this->input->post('session_log'));
	        if($session_key==CNF_SESSION_LOG): // session for ajax is active

	        	if($system_user_login == true):
	        		$session_log = true;
	        	else:
	        		$session_log = false;
	        	endif;
	        	
				$this->form_validation->set_rules('homeaddress', 'Home Address', 'required|trim|htmlspecialchars');
		    	$this->form_validation->set_rules('Province', 'Province Name', 'required|trim|htmlspecialchars');
		    	$this->form_validation->set_rules('Municipality', 'Municipality Name', 'required|trim|htmlspecialchars');
		    	$this->form_validation->set_rules('Barangay', 'Barangay Name', 'required|trim|htmlspecialchars');
		    	$this->form_validation->set_rules('ZipCode', 'ZipCode', 'required|trim|htmlspecialchars');
	        	$form_validation_status = false;
	        	$message_details = "";
	        	if($system_user_login == true):
	        		$session_log = true;
	        		if ($this->form_validation->run()) {
	        			$form_validation_status = true;
	        		}
	        		else
	        		{
	        			$form_validation_status = false;
	        			$message_details = validation_errors('<li>', '</li>');//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
	        		}
	        	else:
	        		$form_validation_status = false;
	        		$session_log = false;
	        	endif;

	        
	        	$homeaddress  =  $this->htmlpurifier_lib->purify($this->input->post('homeaddress'));
		    	$Province  =  $this->htmlpurifier_lib->purify($this->input->post('Province'));
		    	$Municipality  =  $this->htmlpurifier_lib->purify($this->input->post('Municipality'));
		    	$Barangay  =  $this->htmlpurifier_lib->purify($this->input->post('Barangay'));
		    	$ZipCode  =  $this->htmlpurifier_lib->purify($this->input->post('ZipCode'));
		    	$UniqueID  =  $ProfileID;

		    	$sex  =  $this->htmlpurifier_lib->purify($this->input->post('sex'));
		    	$dateofbirth  =  $this->htmlpurifier_lib->purify($this->input->post('dateofbirth'));
		    	$placeofbirth  =  $this->htmlpurifier_lib->purify($this->input->post('placeofbirth'));
		    	$bloodtype  =  $this->htmlpurifier_lib->purify($this->input->post('bloodtype'));

		    	$Country  =  $this->htmlpurifier_lib->purify($this->input->post('Country'));

		    	$contactno  =  $this->htmlpurifier_lib->purify($this->input->post('contactno'));
		    	$faxno  =  $this->htmlpurifier_lib->purify($this->input->post('faxno'));
		    	$homeno  =  $this->htmlpurifier_lib->purify($this->input->post('homeno'));
		    	$officeno  =  $this->htmlpurifier_lib->purify($this->input->post('officeno'));

		    	$Occupation  =  $this->htmlpurifier_lib->purify($this->input->post('Occupation'));
		    	$Education  =  $this->htmlpurifier_lib->purify($this->input->post('Education'));
		    	$Employment  =  $this->htmlpurifier_lib->purify($this->input->post('Employment'));
		    	$EmploymentAddress  =  $this->htmlpurifier_lib->purify($this->input->post('EmploymentAddress'));

		    	$familykin  =  $this->htmlpurifier_lib->purify($this->input->post('familykin'));
		    	$familyrelation  =  $this->htmlpurifier_lib->purify($this->input->post('familyrelation'));
		    	$familyaddress  =  $this->htmlpurifier_lib->purify($this->input->post('familyaddress'));
		    	$familynokids  =  $this->htmlpurifier_lib->purify($this->input->post('familynokids'));
		    	$familykidsname  =  $this->htmlpurifier_lib->purify($this->input->post('familykidsname'));

		    	$data_transaction = array(
		    		'home_purok'=>$homeaddress ,
		    		'home_baranggay' => $Barangay,
		    		'home_muncity' => $Municipality,
		    		'home_province' => $Province,
		    		'zipcode' => $ZipCode, 

		    		'sex' => $sex ,
		    		'dateofbirth' => $dateofbirth ,
		    		'placeofbirth' => $ZipCode ,
		    		'bloodtype' => $bloodtype ,

		    		'Country' => $Country ,

		    		'contactno' => $contactno ,
		    		'faxno' => $faxno ,
		    		'homeno' => $homeno ,
		    		'officeno' => $officeno ,

		    		'Occupation' => $Occupation ,
		    		'Education' => $Education ,
		    		'Employment' => $Employment ,
		    		'EmploymentAddress' => $EmploymentAddress ,

		    		'familykin' => $familykin ,
		    		'familyrelation' => $familyrelation ,
		    		'familyaddress' => $familyaddress ,
		    		'familynokids' => $familynokids ,
		    		'familykidsname' => $familykidsname ,
		    		  );

		        $this->db->where('UniqueID', $UniqueID); // Add the is_active condition
				$query = $this->db->get('tb_profile');
				$result = $query->result();
				$temp_id = "";

				if (count($result) > 0) {
				    foreach ($result as $row) {
				        $temp_id = $row->ProfileID; // Ensure ProfileID is a string or convertible to a string
				    }
				}


				if ($form_validation_status == true && $temp_id != '') {
				    // Assuming $data_transaction and $session_log are defined
				    $data = $this->members->updateinfo($temp_id, $session_log, $data_transaction);
				} else {
				    $data = array(
				        'session_log' => $session_log,
				        'data' => $temp_id,
				        'message_details' => $message_details,
				        'success' => false,
				    );
				}

				$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($data));

	        else:            
				redirect('template',301);
	        endif;
		}

		elseif($category=="updateinfo")
		{
			$system_user_login = $this->session->userdata('logged_in_session') ;
		   	$session_key  = $this->encryption->decrypt($this->input->post('session_log'));
	        if($session_key==CNF_SESSION_LOG): // session for ajax is active

	        	if($system_user_login == true):
	        		$session_log = true;
	        	else:
	        		$session_log = false;
	        	endif;
	        	
	        	$email_error_message = "Can't Proceed on Registration. Email already registered on Members' Profile";
		        $email_error_message_2 = "Invalid Email Address!";

		       
		    	$this->form_validation->set_rules('FirstName', 'First Name', 'required|trim|htmlspecialchars');
		    	$this->form_validation->set_rules('LastName', 'Last Name', 'required|trim|htmlspecialchars');
		    	$this->form_validation->set_rules('email', 'Email Address', 'required|trim|htmlspecialchars|htmlspecialchars', array('valid_email' => $email_error_message_2,) );
	        	$form_validation_status = false;
	        	$message_details = "";
	        	if($system_user_login == true):
	        		$session_log = true;
	        		if ($this->form_validation->run()) {
	        			$form_validation_status = true;
	        		}
	        		else
	        		{
	        			$form_validation_status = false;
	        			$message_details = validation_errors('<li>', '</li>');//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
	        		}
	        	else:
	        		$form_validation_status = false;
	        		$session_log = false;
	        	endif;

	        	if($this->input->post('ProfileStatus')=="Active")
	        	{
	        		$ProfileStatus = 1 ;
	        	}
	        	else
	        	{
	        		$ProfileStatus = 0 ;
	        	}
	        	$FirstName  =  $this->htmlpurifier_lib->purify($this->input->post('FirstName'));
		    	$LastName  =  $this->htmlpurifier_lib->purify($this->input->post('LastName'));
		    	$MiddleName  =  $this->htmlpurifier_lib->purify($this->input->post('MiddleName'));
		    	$nameExtension  =  $this->htmlpurifier_lib->purify($this->input->post('nameExtension'));
		    	$UniqueID  = $ProfileID;
		    	$email  =  $this->htmlpurifier_lib->purify($this->input->post('email'));
		    	$defaultuseraccount = $this->htmlpurifier_lib->purify($this->input->post('defaultuseraccount'));
		    	$data_transaction = array('is_active'=>$ProfileStatus , 'MiddleName' => $MiddleName,'nameExtension' => $nameExtension,'FirstName' => $FirstName,'LastName' => $LastName, 'email' => $email );

		        $this->db->where('UniqueID', $UniqueID); // Add the is_active condition
				$query = $this->db->get('tb_profile');
				$result = $query->result();
				$temp_id = "";

				if (count($result) > 0) {
				    foreach ($result as $row) {
				        $temp_id = $row->ProfileID; // Ensure ProfileID is a string or convertible to a string
				    }
				}


				if ($form_validation_status == true && $temp_id != '') {
				    // Assuming $data_transaction and $session_log are defined
				    $data = $this->members->update($temp_id, $session_log, $data_transaction);
				} else {
				    $data = array(
				        'session_log' => $session_log,
				        'data' => $temp_id,
				        'message_details' => $message_details,
				        'success' => false,
				    );
				}

				$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($data));

	        else:            
				redirect('template',301);
	        endif;
		}
		else
		{
			$this->data['data'] = $data;
	    	$this->data['pageTitle'] = "Members Information";
			$this->data['pageSubtitle'] = "Profile Detail";
			$this->data['pageSubtitleTable'] = "";
			$this->data['pageTitleOption'] = "";
			$this->data['content'] = $this->load->view('profile/members/home',$this->data,true);
			$this->data['home_script'] = $this->load->view('profile/members/script',$this->data,true);
			$this->data['custom_css'] = $this->load->view('profile/members/css_script',$this->data,true);
			$this->load->view('layouts/main', $this->data );
		}
		
	}
	
}
