<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('logged_in_session')) :
			redirect('login',301);

		endif;
		if($this->session->userdata('gid')==1 or $this->session->userdata('gid')==2):
			$this->load->model('Accountinfomodel','account');
			$this->load->model('User_model','user_model');
		else:
			redirect('home',301);
		endif;
		
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
	
}
