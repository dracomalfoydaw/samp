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
			$query_string = "SELECT * FROM Viewprofile WHERE " . implode(" OR ", $whereClause) . " order by ProfileID desc limit 1000";
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
}
