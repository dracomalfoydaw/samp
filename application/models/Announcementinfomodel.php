<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcementinfomodel extends CI_Model {

	function getDataforDashboard()
	{
		$query = $this->db->query("SELECT
			* 
		FROM
			getdatafordashboard 
		WHERE
			DATE( `date posted` ) BETWEEN DATE_SUB( CURDATE(), INTERVAL 1 WEEK ) 
			AND CURDATE();");
		return $query->result();
	}

	/*function getMembersInfo($searchValue)
	{
		$query = $this->db->query("select * from Viewprofile where UserID ='$searchValue'");
		return $query->result();
	}*/

	public function insert($TitleName, $Description, $entryBy ) {
	    $sql = "CALL InsertAnnouncement(?, ?, ?)";
	    
	    $params = array(
	        $TitleName,
	        $Description,
	        $entryBy,
	       
	    );

	    $query = $this->db->query($sql, $params);
	    $result = $query->row();

	    mysqli_next_result( $this->db->conn_id );

	    return $result;  // Assuming you expect a single result row
	}
	function getData($searchValue)
	{
		if($searchValue =="")
		{
			$query = $this->db->query("select * from viewannouncementlist order by EntryID desc limit 1000");
		}
		else
		{
			
			$columns = array(
			    'title',
			    'description',
			    // Add more columns as needed
			);

			$whereClause = array();

			foreach ($columns as $column) {
			    $escapedColumn = "`" . $this->db->escape_str($column) . "`"; // Use backticks and escape the column name
			    $escapedValue = $this->db->escape("%$searchValue%"); // Using % for a partial match
			    $whereClause[] = "$escapedColumn LIKE $escapedValue";
			}

			// Constructing the final query
			$query_string = "SELECT * FROM viewannouncementlist WHERE " . implode(" OR ", $whereClause) . " order by EntryID desc limit 1000";

			$query = $this->db->query($query_string);


			


		}
		
		
		return $query->result();
	}

	public function newAnnouncement($TitleAnnouncement, $TitleDescription, $EntryByID) {
    $sql = "CALL newAnnouncement(?, ?, ?)";
    
    $params = array(
        $TitleAnnouncement,
        $TitleDescription,
        $EntryByID,
       
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

	        'tb_announcement',
	        'EntryID',
	        $userID,
	        'is_del',
	        '1',
	        '0',
	       	'EntryID'
	    );

	    $query = $this->db->query($sql, $params);
	    $result = $query->row();

	    mysqli_next_result( $this->db->conn_id );

	    return $result;  // Assuming you expect a single result row
	}

	public function updateProfile($uniqueID, $TitleName, $Description) {
	    $sql = "CALL updateAnnouncement(?, ?, ?)";
	    
	    $params = array(
	        $uniqueID,
	        $TitleName,
	        $Description,
	    );

	    $query = $this->db->query($sql, $params);
	    $result = $query->row();

	    mysqli_next_result( $this->db->conn_id );

	    return $result;  // Assuming you expect a single result row
	}


}
