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
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
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
			$query = $this->db->query("select * from Viewprofile order by LastName asc limit 100 ");
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
			$query_string = "SELECT * FROM Viewprofile WHERE " . implode(" OR ", $whereClause) . " order by LastName asc limit 1000";

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
