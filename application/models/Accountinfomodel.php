<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accountinfomodel extends CI_Model {

	
	function getMembersData($searchValue)
	{
		if($searchValue =="")
		{
			$query = $this->db->query("select * from viewuserprofile order by LastName  limit 1000");
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
			$query_string = "SELECT * FROM viewuserprofile WHERE " . implode(" OR ", $whereClause) . " order by LastName  limit 1000";
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

	public function updateProfile($uniqueID, $firstName, $middleName, $lastName,  $email,$groupID) {
	    $sql = "CALL updateSystemUsers(?, ?, ?, ?, ?, ?)";
	    
	    $params = array(
	        $uniqueID,
	        $firstName,
	        $middleName,
	        $lastName,
	        $email,
	       $groupID,
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

	        'tb_users',
	        'id',
	        $userID,
	        'is_del',
	        '1',
	        '0',
	       	'id'
	    );

	    $query = $this->db->query($sql, $params);
	    $result = $query->row();

	    mysqli_next_result( $this->db->conn_id );

	    return $result;  // Assuming you expect a single result row
	}

	public function accountunlockinfo($userID)
	{
		$sql = "CALL unlockAccount(?,?)";
		$params = array(

	        $userID,
	        '0',
	    );

	    $query = $this->db->query($sql, $params);
	    $result = $query->row();

	    mysqli_next_result( $this->db->conn_id );

	    return $result;  // Assuming you expect a single result row
	}

	public function accountchangenewpasswordinfo($userID,$password)
	{
		$sql = "CALL changePassword(?,?)";
		$params = array(

	        $userID,
	        $password,
	    );

	    $query = $this->db->query($sql, $params);
	    $result = $query->row();

	    mysqli_next_result( $this->db->conn_id );

	    return $result;  // Assuming you expect a single result row
	}
}
