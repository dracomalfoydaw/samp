<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendanceinfomodel extends CI_Model {

	public function insertAttendanceDetails($attendanceID, $profileID, $remarks) {
        $query = "CALL InsertAttendanceDetails(?, ?, ?)";

        $result = $this->db->query($query, array($attendanceID, $profileID, $remarks));

        if ($result) {
            return $result->row(); // Return the result as an object
        } else {
            return false; // Return false if the query fails
        }
    }

	function getAttendanceInfo($EntryID)
	{
		$query = $this->db->query("select * from viewattendancelist where EntryID='$EntryID' limit 1");
		return $query->row();
	}

	function getAttendancePersonneList($EntryID,$UniqueID)
	{
		$sql = "CALL getAttendancePersonneList(?, ?)";
    
		$params = array(
		
			$EntryID,
			$UniqueID,     
		);

		$query = $this->db->query($sql, $params);
		$result = $query->result();

		mysqli_next_result( $this->db->conn_id );

		return $result;  // Assuming you expect a single result row
	}

	function setAttendancePersonnel($EntryID,$UniqueID)
	{

	}

	function getAttendanceData($searchValue)
	{
		if($searchValue =="")
		{
			$query = $this->db->query("select * from viewattendancelist limit 1000");
		}
		else
		{
			
			$columns = array(
			    'Name',
			    'Fines',
			    'Description',
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
			$query_string = "SELECT * FROM viewattendancelist WHERE " . implode(" OR ", $whereClause) . "limit 1000";

			$query = $this->db->query($query_string);


			


		}
		
		
		return $query->result();
	}

	public function insertProfile($Name, $Description, $Fines,$mysqldate) {
    $sql = "CALL InsertAttendance(?, ?, ?,?)";
    
    $params = array(
       
        $Name,
        $Description,
        $Fines,       
        $mysqldate,
    );

    $query = $this->db->query($sql, $params);
    $result = $query->row();

    mysqli_next_result( $this->db->conn_id );

    return $result;  // Assuming you expect a single result row
}


}
