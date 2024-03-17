<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controllerlogin101 extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

		function __construct() {
			parent::__construct();
			
			
			$this->load->model('User_model','user_model');
		}




	public function index()
	{
		if($this->session->userdata('logged_in_session')) redirect('home',301);
		$this->data = [];
		$this->load->view('login/main', $this->data );
	}

	public function searchaccount()
	{
		if($this->session->userdata('logged_in_session')) redirect('home',301);

		
			$this->form_validation->set_rules('email', 'Email Address', 'required|trim|htmlspecialchars');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|htmlspecialchars');
			if ($this->form_validation->run()) {
				$email = $this->htmlpurifier_lib->purify($this->input->post('email'));
				$password = $this->htmlpurifier_lib->purify($this->input->post('password'));

				$result = $this->user_model->getUserAccount($email);
				$error = "";
				if(count($result)==1)
				{
					foreach ($result as $row) {
						if(md5(md5(sha1(sha1($password)))) ==$row->password)
						{
							$this->session->set_userdata(array(
				                'logged_in_session'  => true,
				                'uid'    => $row->id,
				                'ProfileID'    => $row->ProfileID,
				                'username'    => $row->username,
				                'email'    => $row->email,
				                'gid'    => $row->group_id,
				                  
				                 
				                'fid'    => $row->first_name.'  '.$row->last_name,
				                'lname'    =>  $row->last_name,
				                'fname'    => $row->first_name ,
				                
			                ));

							$error = "success";
							$message_details = '';
						}
						else
						{
							$error = "error";
							$message_details = '<li> Invalid Email or Password </li>';
						}
					}
				}
				else
				{
					$error = "error";
					$message_details = '<li> No Account Found </li>';	
				}

				$data = array(
				        'message' => $error,
				        'message_details' => $message_details,
				 );
			}
			else
			{
				$message_details = '<li> Error </li>';//'The following errors occurred <br>' . validation_errors('<li>', '</li>');
		    	$data = array(
			        'message' => "error",
			        'message_details' => $message_details,
			    );
			}

			echo json_encode($data);
		
	}
}
