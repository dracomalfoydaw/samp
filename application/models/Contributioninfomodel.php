<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contributioninfomodel extends CI_Model {


	function profilecollectionlist($id)
	{
		$query = $this->db->query("select * from viewcontributionsummaryprofile where ContributionID='$id' limit 1000");
		return $query->result();
	}

	function getData($searchValue,$category)
	{
		if($category=="collection")
		{
			if($searchValue =="")
			{
				$query = $this->db->query("select * from viewcontributionsummary limit 1000");
			}
			else
			{
				
				$columns = array(
				    'Name',
				    'BalanceFee',
				    'Description'
				    // Add more columns as needed
				);

				$whereClause = array();

				foreach ($columns as $column) {
				    $escapedColumn = "`" . $this->db->escape_str($column) . "`"; // Use backticks and escape the column name
				    $escapedValue = $this->db->escape("%$searchValue%"); // Using % for a partial match
				    $whereClause[] = "$escapedColumn LIKE $escapedValue";
				}

				// Constructing the final query
				$query_string = "SELECT * FROM viewcontributionsummary WHERE " . implode(" OR ", $whereClause) . "limit 1000";

				$query = $this->db->query($query_string);


				


			}
		}
		else
		{
			if($searchValue =="")
			{
				$query = $this->db->query("select * from viewcontribution limit 1000");
			}
			else
			{
				
				$columns = array(
				    'Name',
				    'BalanceFee',
				    'Description'
				    // Add more columns as needed
				);

				$whereClause = array();

				foreach ($columns as $column) {
				    $escapedColumn = "`" . $this->db->escape_str($column) . "`"; // Use backticks and escape the column name
				    $escapedValue = $this->db->escape("%$searchValue%"); // Using % for a partial match
				    $whereClause[] = "$escapedColumn LIKE $escapedValue";
				}

				// Constructing the final query
				$query_string = "SELECT * FROM viewcontribution WHERE " . implode(" OR ", $whereClause) . "limit 1000";

				$query = $this->db->query($query_string);


				


			}
		}
		
		
		
		return $query->result();
	}

	public function insertData($applyrecord,$name, $balanceFee, $description, $active, $isDeleted, $entryBy) {

		if($applyrecord=="applyrecord")
		{
			$sql = "CALL InsertContributionProfileAuto(?, ?, ?, ?, ?, ?)";
		}
		else
		{
			$sql = "CALL InsertContributionProfile(?, ?, ?, ?, ?, ?)";
		}

        $params = array(
            $name,
            $balanceFee,
            $description,
            $active,
            $isDeleted,
            $entryBy
        );

        $query = $this->db->query($sql, $params);

        $result = $query->row();
        mysqli_next_result( $this->db->conn_id );
        return $result; // Assuming you expect a single result row
    }


}
