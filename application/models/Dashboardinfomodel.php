<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboardinfomodel extends CI_Model {

	function getMembersInfo($searchValue)
	{
		$query = $this->db->query("select * from Viewprofile where UserID ='$searchValue'");
		return $query->result();
	}
	function getMembersData($searchValue)
	{
		if($searchValue =="")
		{
			$query = $this->db->query("select * from Viewprofile limit 1000");
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
			$query_string = "SELECT * FROM Viewprofile WHERE " . implode(" OR ", $whereClause) . "limit 1000";

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


}
