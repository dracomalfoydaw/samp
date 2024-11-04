<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashieringinfomodel extends CI_Model {

	public function saveTransaction($data) {
        $query = $this->db->query(
            "CALL SaveTransactionPayment(
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?
            )", $data
        );
        $result = $query->row_array();
        mysqli_next_result( $this->db->conn_id );
        return $result; // Assuming you want to return the result
    }

    public function saveTransactionDetails($data) {
        $query = $this->db->query(
            "CALL SaveTransactionPaymentDetails(
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?
            )", $data
        );

        $result = $query->result();
        mysqli_next_result( $this->db->conn_id );
        return $result; // Assuming you want to return the result
    }

    function getChartAccountID($code)
    {
    	$query = $this->db->query("SELECT
			viewchartaccountprofile.ChartID 
		FROM
			viewchartaccountprofile 
		WHERE
			chartcode = '$code' 
			LIMIT 1");
    	return $query->row_array();
    }


	function checkornumber($params)
	{
		$sql = "CALL CheckIfORNumberExists(?)";
    
	   

	    $query = $this->db->query($sql, $params);
	    $result = $query->row();

	    mysqli_next_result( $this->db->conn_id );

	    return $result;  // Assuming you expect a single result row
	}

	function loadRemainingBalance($params)
	{
		$sql = "CALL getlistofpayment(?)";
    
	   

	    $query = $this->db->query($sql, $params);
	    $result = $query->result();

	    mysqli_next_result( $this->db->conn_id );

	    return $result;  // Assuming you expect a single result row
	}

	function getMembersData($searchValue)
	{
		if($searchValue =="")
		{
			$query = $this->db->query("select * from viewprofile order by LastName asc limit 100 ");
		}
		else
		{
			
			$columns = array(
			    'UserID',
			    'LastName',
			    'FirstName',
			    'MiddleName'
			    // Add more columns as needed
			);

			$whereClause = array();

			foreach ($columns as $column) {
			    $escapedColumn = "`" . $this->db->escape_str($column) . "`"; // Use backticks and escape the column name
			    $escapedValue = $this->db->escape("%$searchValue%"); // Using % for a partial match
			    $whereClause[] = "$escapedColumn LIKE $escapedValue";
			}

			// Constructing the final query
			$query_string = "SELECT * FROM viewprofile WHERE " . implode(" OR ", $whereClause) . " order by LastName asc limit 1000";

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


}
