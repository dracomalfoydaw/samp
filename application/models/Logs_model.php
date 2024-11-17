<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs_model extends CI_Model {

	function __construct() {
		parent::__construct();		
	}
		

	function search_data($start,$limit,$sortColumn,$sortOrder,$search,$session_log)
	{
		$entryBy = $this->encryption->decrypt($this->session->userdata('uid'));
	    if($start <0 or !is_numeric($start))
        {
            $start = 0;
        }
        if($limit <5 or !is_numeric($start))
        {
            $limit = 5;
        }

        //option 1 for query
            /*// Fetch data from the database with the given limit and search query
        if ($search) {
		    $this->db->group_start(); // Open a group to combine the `like` conditions
		    $this->db->like('OfficeName', $search);
		    $this->db->or_like('OfficeDesc', $search);
		    $this->db->group_end(); // Close the group
		}
		

		$this->db->where('is_active', md5(sha1(sha1(md5(sha1("active")))))); // Add the is_active condition
		//end of option 1 for query*/

		//option 2 for query
		if ($search) {
			$this->db->group_start(); 
			$this->db->like('note', $search);
			$this->db->group_end(); // Close the group
		}
		//end of option 2 for query
		//$this->db->where('entry_by',  $this->session->userdata('uid')); // Add the is_active condition
        // Apply sorting if sortColumn is provided
        if ($sortColumn) {
            $this->db->order_by($sortColumn, $sortOrder);
        }

        

        $query = $this->db->get('tb_logs', $limit, $start);

        $data = $query->result();


        $obj = [];
        foreach ( $data as $row) {
        		array_push($obj,[
	                'Details' => $this->htmlpurifier_lib->purify_decode($row->note),
	                'LogDate' => $this->htmlpurifier_lib->purify_decode($row->logdate),
	            ]);

        	
        }
        if($search !=''):
	        $note = "Search Value on My Logs: ".$search;
	        $this->user_model->insertLog($note,"search" ,$entryBy ,"template", $entryBy,'');
    	endif;

		return array('session_log' => $session_log ,'data' => $obj , 'success' => true,);
	}

}
