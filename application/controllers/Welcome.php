<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	public function index()
	{
		$query = $this->db->query("select count(UniqueID) as res,UniqueID  from tb_profile GROUP BY UniqueID");
		foreach ($query->result() as $key) {
			if($key->res >1)
			{
				$count=0;
				$query2 = $this->db->query("select * from tb_profile where UniqueID='".$key->UniqueID ."' ");
				foreach ($query2->result() as $key2) {
					$count++;
					if($count==$key->res)
					{
						$this->db->query("DELETE FROM `tb_profile` WHERE `ProfileID` = '".$key2->ProfileID."' ");
					}
				}
			}
		}
	}
}
