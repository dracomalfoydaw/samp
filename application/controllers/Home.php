<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		if(!$this->session->userdata('logged_in_session')) :
			redirect('login',301);

		endif;
		
	}

	public function index()
	{
		
		$this->data = [];			
		$this->load->model('Announcementinfomodel','announcement');
		$this->data['pageTitle'] = "Home";
		$this->data['pageSubtitle'] = "Dashboard";
		$this->data['pageSubtitleTable'] = "";
		$this->data['custom_css'] = "";
		$this->data['announcementlist'] = $this->announcement->getDataforDashboard();
		$this->data['content'] = $this->load->view('dashboard/home',$this->data, true );
		$this->data['home_script'] = $this->load->view('dashboard/home_script',$this->data, true );
		$this->load->view('layouts/main', $this->data );
	}

	
}
