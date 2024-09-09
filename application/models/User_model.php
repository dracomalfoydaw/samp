
<?php
class User_model extends CI_Model {

    public function insertUser($username, $password, $email, $groupID, $profileID, $firstName, $lastName, $active, $entryBy) {
        $sql = "CALL InsertUser(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $password = md5(md5(sha1(sha1($password))));
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

    function getUserAccount($EmailAddress)
    {
        $sql = "Call getUserAccount(?)";
        $params = array('EmailAddress' => $EmailAddress, );
        $query = $this->db->query($sql, $params);
        $result = $query->result();

        mysqli_next_result( $this->db->conn_id );

        return $result;  // Assuming you expect a single result row
    }

    //new code
    function registration_form_profile($username,$email,$firstname,$middlename,$lastname,$password)
      {
         $data = array(
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'group_id' => CNF_GROUP,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'entry_by' => $this->encryption->decrypt($this->session->userdata('uid')),
            'is_del' => 0,
            'is_active' =>  1,
            'verify' => 1,
            'to_way_auth_status' => 0 ,
            'profileID' =>  $username,
         );

         $result = $this->user_model->create_account_profileID($data);
         if($result->SuccessMessage=="success"):
            return "success";
         else:
            return "error";
         endif;
      }

      function create_account_profileID($data)
      {

         $category = "add";
         $username ="";
         $middlename ="";
         $nameext ="";
         if(isset($data['username']))
         {
            $username = $data['username'] ;
         }
         $email = $data['email'] ;
         $firstname = $data['firstname'] ;
         if(isset($data['middlename']))
         {
            $middlename = $data['middlename'] ;
         }
         $lastname = $data['lastname'] ;
         if(isset($data['nameext']))
         {
            $nameext = $data['nameext'] ;
         }

         //isset($data['profileID']);

         //$data['profileID'] =  $this->profile_update($category,$username,$email,$firstname,$middlename,$lastname,$nameext );


         $sql = "CALL InsertUserwProfileID(?, ?, ?,  ?, ?, ?, ?, ?, ?,?,?,?)";
         $query = $this->db->query($sql, $data);

         $result = $query->row();

         mysqli_next_result( $this->db->conn_id );

         return $result;  // Assuming you expect a single result row
      }

}
