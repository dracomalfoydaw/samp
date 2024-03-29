<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accountinginfomodel extends CI_Model {


	public function UpdateCreditonJournal($entryid, $new_credit,$Remarks) {
       
        $query = $this->db->query("CALL UpdateCreditonJournal(?, ?,?)", array($entryid, $new_credit,$Remarks));
        if ($query->num_rows() > 0) {
            return $query->row(); // Assuming you expect only one row as a result
        } else {
            return null; // No result found
        }
        // If you need to return data or handle success/error messages, you can do so here
    }

	 function getListofPaymenttoAdd($typePayment, $searchvalue) {
        $query = $this->db->query("CALL getListofPaymenttoAdd(?, ?)", array($typePayment, $searchvalue));
        return $query->result_array();
    }

    public function addNewPayment($typePayment, $v_EntryID, $v_ProfileID, $p_EntryBy, $p_Name) {
        $query = $this->db->query("CALL AddNewPayment(?, ?, ?, ?, ?)", array(
            $typePayment,
            $v_EntryID,
            $v_ProfileID,
            $p_EntryBy,
            $p_Name
        ));

        if ($query->num_rows() > 0) {
            return $query->row(); // Assuming you expect only one row as a result
        } else {
            return null; // No result found
        }
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

	public function GetLedgerEntries($uniqueID) {
    $sql = "CALL GetLedgerEntries(?)";
    
    $params = array(
        $uniqueID,
       
    );

    $query = $this->db->query($sql, $params);
    $result = $query->result();

    mysqli_next_result( $this->db->conn_id );

    return $result;  // Assuming you expect a single result row
}
public function GetAssestmentEntries($uniqueID) {
    $sql = "CALL GetAssestmentEntries(?)";
    
    $params = array(
        $uniqueID,
       
    );

    $query = $this->db->query($sql, $params);
    $result = $query->result();

    mysqli_next_result( $this->db->conn_id );

    return $result;  // Assuming you expect a single result row
}

public function deleteListofPayment($EntryID,$memberID){

		$sql = "CALL DeleteRecordProcedure(?, ?, ?, ?, ?, ?, ?)";
			$params = array(

		        'tb_journal',
		        'EntryID',
		        $EntryID,
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

	
}
