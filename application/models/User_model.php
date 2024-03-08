
<?php
class User_model extends CI_Model {

    public function insertUser($username, $password, $email, $groupID, $profileID, $firstName, $lastName, $active, $entryBy) {
        $sql = "CALL InsertUser(?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = array(
            $username,
            $password,
            $email,
            $groupID,
            $profileID,
            $firstName,
            $lastName,
            $active,
            $entryBy
        );

        $query = $this->db->query($sql, $params);

        $result = $query->row();

        mysqli_next_result( $this->db->conn_id );

        return $result;  // Assuming you expect a single result row
    }

}
