<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contributioninfomodel extends CI_Model {


	function profilecollectionlist($id)
	{
		$query = $this->db->query("select * from viewcontributionsummaryprofile where ContributionID='$id' limit 1000");
		return $query->result();
	}

	function synccollection($id)
	{
		$query = $this->db->query("select EntryId from tb_contribution_account where ContributionID='$id' ");
		foreach($query->result() as $key)
		{
			$query2 = $this->db->query("select ActualPayment,Credit,BalanceFee,Discount from tb_journal where TransactionTypeID='1' and ReferenceID='".$key->EntryId."'");
			foreach($query2->result() as $key2)
			{
				if($key2->ActualPayment>0)
				{
					$ActualPayment = $key2->ActualPayment;
				}
				else
				{
					$ActualPayment =0;
				}

				if($key2->Credit>0)
				{
					$Credit = $key2->Credit;
				}
				else
				{
					$Credit =0;
				}

				if($key2->BalanceFee>0)
				{
					$BalanceFee = $key2->BalanceFee;
				}
				else
				{
					$BalanceFee =0;
				}

				if($key2->Discount>0)
				{
					$Discount = $key2->Discount;
				}
				else
				{
					$Discount =0;
				}

				$data = array(
					'Debit' => $ActualPayment , 
					'BalanceFee' => $BalanceFee ,
					'Discount' => $Discount ,
				);

                $this->db->where('EntryId', $key->EntryId);
                $this->db->update('tb_contribution_account', $data);
			}
		}
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
				$query = $this->db->query("select * from viewcontribution order by EntryID desc limit 1000");
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
				$query_string = "SELECT * FROM viewcontribution WHERE " . implode(" OR ", $whereClause) . " EntryID desc limit 1000";

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

    public function deleteProfile($userID)
	{
		$sql = "CALL DeleteRecordProcedure(?, ?, ?, ?, ?, ?, ?)";
		$params = array(

	        'tb_contribution',
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
}
