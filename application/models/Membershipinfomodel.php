<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Membershipinfomodel extends CI_Model {

	function getMembers()
	{
		$query = $this->db->query("select * from viewprofile where RecordStatus='Record active' and RecordDeleted='Not Deleted' ");
		return $query->result();
	}

	function getMembersInfo($searchValue)
	{
		$query = $this->db->query("select * from viewprofile where UserID ='$searchValue' ");
		return $query->result();
	}

	

	function getMembersData($searchValue)
	{
		if($searchValue =="")
		{
			$query = $this->db->query("select * from viewprofile order by ProfileID desc limit 1000");
		}
		else
		{
			$searchValue = $searchValue;
			$columns = array(
			    'UserID',
			    'LastName',
			    'FirstName',
			    'MiddleName',
			    'Email'
			    // Add more columns as needed
			);

			$whereClause = array();

			foreach ($columns as $column) {
			    $escapedColumn = "`" . $this->db->escape_str($column) . "`"; // Use backticks and escape the column name
			    $escapedValue = $this->db->escape("%$searchValue%"); // Using % for a partial match
			    $whereClause[] = "$escapedColumn LIKE $escapedValue";
			}

			// Constructing the final query
			$query_string = "SELECT * FROM viewprofile WHERE " . implode(" OR ", $whereClause) . " order by ProfileID desc limit 1000";
			$query = $this->db->query($query_string);

		}
		
		
		return $query->result();
	}

	public function insertProfile($uniqueID, $firstName, $middleName, $lastName, $nameExtension, $email) {
	    $sql = "CALL InsertProfile(?, ?, ?, ?, ?, ?)";
	    
	    $params = array(
	        $uniqueID,
	        $firstName,
	        $middleName,
	        $lastName,
	        $nameExtension,
	        $email,
	       
	    );

	    $query = $this->db->query($sql, $params);
	    $result = $query->row();

	    mysqli_next_result( $this->db->conn_id );

	    return $result;  // Assuming you expect a single result row
	}

	public function updateProfile($uniqueID, $firstName, $middleName, $lastName, $nameExtension, $email) {
	    $sql = "CALL updateProfile(?, ?, ?, ?, ?, ?)";
	    
	    $params = array(
	        $uniqueID,
	        $firstName,
	        $middleName,
	        $lastName,
	        $nameExtension,
	        $email,
	       
	    );

	    $query = $this->db->query($sql, $params);
	    $result = $query->row();

	    mysqli_next_result( $this->db->conn_id );

	    return $result;  // Assuming you expect a single result row
	}

	public function deleteProfile($userID)
	{
		$sql = "CALL DeleteRecordProcedure(?, ?, ?, ?, ?, ?, ?)";
		$params = array(

	        'tb_profile',
	        'UniqueID',
	        $userID,
	        'is_del',
	        '1',
	        '0',
	       	'ProfileID'
	    );

	    $query = $this->db->query($sql, $params);
	    $result = $query->row();

	    mysqli_next_result( $this->db->conn_id );

	    return $result;  // Assuming you expect a single result row
	}


	//new code inserted

	function get_data_details($search)
	{
		$entryBy =  $this->encryption->decrypt($this->session->userdata('uid'));
		
		$this->db->where('UniqueID', $search); // Add the is_active condition
        $this->db->where('is_del', 0 ); // Add the is_active condition

        $query = $this->db->get('tb_profile');
        $data = $query->result();


        $obj ="";
        foreach ( $data as $row) {
        	if($row->is_del== 0) //data is not deleted
        	{
        		$deleted = "Not Deleted";
        	}
        	elseif($row->is_del==1) //data is deleted
        	{
        		$deleted = "Record Deleted";
        	}
        	else
        	{
        		$deleted = "Unknown Status";
        	}

        	if( $row->is_active== 1 ) //data is not deleted
        	{
        		$active = "Active";
        	}
        	elseif($row->is_active== 0 ) //data is deleted
        	{
        		$active = "Inactive";
        	}
        	else
        	{
        		$active = "Unknown Status";
        	}

        	if(!($active =="Unknown Status" or  $deleted == "Unknown Status"))
        	{
        		$obj = array(
	                'TransID' => $this->encryption->encrypt($row->ProfileID),
	                'Avatar' => $this->htmlpurifier_lib->purify_decode($row->avatar),
	                'EmailAddress' => $this->htmlpurifier_lib->purify_decode($row->email),
	                'FirstName' => $this->htmlpurifier_lib->purify_decode($row->FirstName),
	                'MiddleName' => $this->htmlpurifier_lib->purify_decode($row->MiddleName),
	                'LastName' => $this->htmlpurifier_lib->purify_decode($row->LastName),
	                'NameExtension' => $this->htmlpurifier_lib->purify_decode($row->NameExtension),
	                'AccountID' => $this->htmlpurifier_lib->purify_decode($row->UniqueID),

	                'HomePurok' => $this->htmlpurifier_lib->purify_decode($row->home_purok),
	                'HomeBaranggay' => $this->htmlpurifier_lib->purify_decode($row->home_baranggay),
	                'HomeMuncity' => $this->htmlpurifier_lib->purify_decode($row->home_muncity),
	                'HomeProvince' => $this->htmlpurifier_lib->purify_decode($row->home_province),
	                'zipcode' => $this->htmlpurifier_lib->purify_decode($row->zipcode),
	                'Country' => $this->htmlpurifier_lib->purify_decode($row->Country),

	                'Sex' => $this->htmlpurifier_lib->purify_decode($row->sex),
	                'DateofBirth' => $row->dateofbirth,
	                'PlaceofBirth' => $this->htmlpurifier_lib->purify_decode($row->placeofbirth),
	                'Bloodtype' => $this->htmlpurifier_lib->purify_decode($row->bloodtype),

	                'ContactNumber' => $this->htmlpurifier_lib->purify_decode($row->contactno),
	                'FaxNumber' => $this->htmlpurifier_lib->purify_decode($row->faxno),
	                'HomeNumber' => $this->htmlpurifier_lib->purify_decode($row->homeno),
	                'OfficeNumber' => $this->htmlpurifier_lib->purify_decode($row->officeno),

	                'Occupation' => $this->htmlpurifier_lib->purify_decode($row->Occupation),
	                'Education' => $this->htmlpurifier_lib->purify_decode($row->Education),
	                'Employment' => $this->htmlpurifier_lib->purify_decode($row->Employment),
	                'EmploymentAddress' => $this->htmlpurifier_lib->purify_decode($row->EmploymentAddress),

	                'familykin' => $this->htmlpurifier_lib->purify_decode($row->familykin),
	                'familyrelation' => $this->htmlpurifier_lib->purify_decode($row->familyrelation),
	                'familyaddress' => $this->htmlpurifier_lib->purify_decode($row->familyaddress),
	                'familynokids' => $this->htmlpurifier_lib->purify_decode($row->familynokids),
	                'familykidsname' => $this->htmlpurifier_lib->purify_decode($row->familykidsname),


	                'recordStat' => $this->htmlpurifier_lib->purify_decode($row->recordStat),
	                'LodgeNo' => $this->htmlpurifier_lib->purify_decode($row->LodgeNo),
	                'LodgeName' => $this->htmlpurifier_lib->purify_decode($row->LodgeName),
	                'MasonDistrict' => $this->htmlpurifier_lib->purify_decode($row->MasonDistrict),
	                'initiated' => $this->htmlpurifier_lib->purify_decode($row->initiated),
	                'passed' => $this->htmlpurifier_lib->purify_decode($row->passed),
	                'raised' => $this->htmlpurifier_lib->purify_decode($row->raised),
	                'memberstatus' => $this->htmlpurifier_lib->purify_decode($row->memberstatus),

	                'RecordStatus' => $deleted,
	                'RecordActive' => $active,
	            );
        	}

        	
        }
       
	    $note = "View Value: ".$search;
	    //$this->user_model->insertLog($note,"View" ,$entryBy ,"tb_profile", $entryBy,'');
    	

		return $obj;
	}

	function search_data($start,$limit,$sortColumn,$sortOrder,$search,$session_log)
	{
		$entryBy =  $this->encryption->decrypt($this->session->userdata('uid'));
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
			$this->db->or_group_start(); 
			$this->db->or_like('UniqueID', $search);
			$this->db->or_like('firstname', $search);
			$this->db->or_like('middlename', $search);
			$this->db->or_like('lastname', $search);
			$this->db->or_like('nameextension', $search);
			$this->db->or_like('email', $search);
			$this->db->group_end(); // Close the group
		}
		//end of option 2 for query

        // Apply sorting if sortColumn is provided
        if ($sortColumn) {
        	if($sortOrder !="asc")
        	{
        		$sortOrder = "desc";
        	}
        	switch ($sortColumn) {
			    case "AccountID":			        
            		$this->db->order_by("UniqueID", $sortOrder);
			        break;
			    case "FirstName":
			        $this->db->order_by("FirstName", $sortOrder);
			        break;
			    case "MiddleName":
			        $this->db->order_by("MiddleName", $sortOrder);
			        break;
			    case "LastName":
			        $this->db->order_by("LastName", $sortOrder);
			        break;
			    // more cases...
			    default:
			        $this->db->order_by("UniqueID", $sortOrder);
			}

        }

        if(CNF_VIEW_DELETE_RECORD!=true)
        {
        	$this->db->where('is_del',0); // Add the is_active condition
        }

        $query = $this->db->get('tb_profile', $limit, $start);
        $data = $query->result();


        $obj = [];
        foreach ( $data as $row) {
        	if($row->is_del== 0) //data is not deleted
        	{
        		$deleted = "Not Deleted";
        	}
        	elseif($row->is_del== 1) //data is deleted
        	{
        		$deleted = "Record Deleted";
        	}
        	else
        	{
        		$deleted = "Unknown Status";
        	}

        	if( $row->is_active== 1 ) //data is not deleted
        	{
        		$active = "Active";
        	}
        	elseif($row->is_active== 0 ) //data is deleted
        	{
        		$active = "Inactive";
        	}
        	else
        	{
        		$active = "Unknown Status";
        	}

        	if(!($active =="Unknown Status" or  $deleted == "Unknown Status"))
        	{
        		array_push($obj,[
	                'TransID' => $this->encryption->encrypt($row->ProfileID),
	                'Avatar' => $this->htmlpurifier_lib->purify_decode($row->avatar),
	                'EmailAddress' => $this->htmlpurifier_lib->purify_decode($row->email),
	                'FirstName' => $this->htmlpurifier_lib->purify_decode($row->FirstName),
	                'MiddleName' => $this->htmlpurifier_lib->purify_decode($row->MiddleName),
	                'LastName' => $this->htmlpurifier_lib->purify_decode($row->LastName),
	                'NameExtension' => $this->htmlpurifier_lib->purify_decode($row->NameExtension),
	                'AccountID' => $this->htmlpurifier_lib->purify_decode($row->UniqueID),
	                'RecordStatus' => $deleted,
	                'RecordActive' => $active,
	            ]);
        	}

        	
        }
        if($search !=''):
	        $note = "Search Value: ".$search;
	       // $this->user_model->insertLog($note,"search" ,$entryBy ,"tb_profile", $entryBy,'');
    	endif;

		return array('session_log' => $session_log ,'data' => $obj , 'success' => true,);
	}


	function delete($temp_id_res,$session_log)
	{	    
		$entryBy = $this->encryption->decrypt($this->session->userdata('uid'));
		$count = 0;
		$transid = "";
        foreach ($temp_id_res as $data) {
        	$count++;
            // Assuming $this->encryption->decrypt() works as expected
            $temp_id =  $this->htmlpurifier_lib->purify($this->encryption->decrypt($data));
            
            // Example operations on database based on your conditions
            if (CNF_DELETE_RECORD_PERMANENTLY == true) {
                $this->db->where('ProfileID', $temp_id);
                $this->db->delete('tb_profile');
            } else {
                $data = array('is_del' => 1, );
                $this->db->where('ProfileID', $temp_id);
                $this->db->update('tb_profile', $data);
            }

        	if($count==1)
        	{
        		$transid = $temp_id;
        	}
        	else
        	{
        		$transid .= ','.$temp_id;
        	}
        }

        $note = "Record Deleted";
        //$this->user_model->insertLog($note,"delete" ,$entryBy ,"tb_profile", $entryBy,$transid);

        // Prepare response data
		return array('session_log' => $session_log , 'success' => true,);
	}


	function add_get_id($session_log,$data )
	{
		$entryBy = $this->encryption->decrypt($this->session->userdata('uid')) ;
		isset($data['entry_by']) ;
		isset($data['is_active']) ;
		isset($data['is_del']) ;
		$data['entry_by'] = $entryBy;
		$data['is_active'] = 1 ;
		$data['is_del'] = 0;
        $this->db->insert('tb_profile',$data);
		$transid = $this->db->insert_id();

		$res = $this->db->query("select UniqueID from tb_profile where ProfileID='$transid'");
		$UniqueID = "";
		foreach ($res->result() as $key ) {
			$UniqueID = $key->UniqueID;
		}
		$note = "New Record Added";
        //$this->user_model->insertLog($note,"add" ,$entryBy ,"tb_profile", $entryBy,$transid);

        // Prepare response data
		return array('session_log' => $session_log , 'data' => $UniqueID, 'message_details' => '', 'success' => true,);
	}

	function add($session_log,$data )
	{
		$entryBy = $this->encryption->decrypt($this->session->userdata('uid')) ;
		isset($data['entry_by']) ;
		isset($data['is_active']) ;
		isset($data['is_del']) ;
		$data['entry_by'] = $entryBy;
		$data['is_active'] = 1 ;
		$data['is_del'] = 0;
        $this->db->insert('tb_profile',$data);
		$transid = $this->db->insert_id();

		$note = "New Record Added";
        //$this->user_model->insertLog($note,"add" ,$entryBy ,"tb_profile", $entryBy,$transid);

        // Prepare response data
		return array('session_log' => $session_log , 'data' => '', 'message_details' => '', 'success' => true,);
	}


	function update($transid,$session_log,$data )
	{
		
		$isUpdate = false;
		$email_error_message = "";
		$entryBy =  $this->encryption->decrypt($this->session->userdata('uid'));
		$this->db->where('email', $data['email']); // Add the is_active condition
        $query = $this->db->get('tb_profile');
        $result = $query->result();

        if(count($result)==1){
        	foreach ($result  as $key ) {
        		if($key->ProfileID==$transid)
        		{
        			$isUpdate = true;
        		}
        		else
        		{
        			$email_error_message = "<li>Can't Proceed on Registration. Email already registered on Profile Members</li>";
        		}
        	}
        }
        elseif(count($result)>1){
        	$email_error_message = "<li>Can't Proceed on Registration. Email already registered on Profile Members</li>";
        }
        else
        {
        	$isUpdate = true;	        	
        }

        if($isUpdate == true)
        {        	
			$this->db->where('ProfileID', $transid);
	        $this->db->update('tb_profile', $data);
	        $note = "Record Updated";
	        //$this->user_model->insertLog($note,"update" ,$entryBy ,"tb_profile", $entryBy,$transid);
	        // Prepare response data
			return array('session_log' => $session_log ,   'success' => true,);
        }
        else
        {
        	return array('session_log' => $session_log , 'message_details' => $email_error_message, 'success' => false,);
        }

	}

	function updateinfo($transid,$session_log,$data )
	{
		
		$isUpdate = false;
		$email_error_message = "";
		$entryBy =  $this->encryption->decrypt($this->session->userdata('uid'));        	
		$this->db->where('ProfileID', $transid);
        $this->db->update('tb_profile', $data);
        $note = "Record Updated";
        //$this->user_model->insertLog($note,"update" ,$entryBy ,"tb_profile", $entryBy,$transid);
        // Prepare response data
		return array('session_log' => $session_log ,   'success' => true,);

	}
}
