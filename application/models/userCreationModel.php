<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class userCreationModel extends CI_Model {

    function fetchUser()
    {
        $query = "SELECT 
        a.emp_id,
        a.emp_number,
        a.empStat,
        a.last_name,
        a.first_name,
        a.middle_name,
        b.roleName,
        a.dateAdded,
        a.empDepartment,
        c.stats
        FROM pg_empUser AS a
        INNER JOIN tblRoles AS b ON a.roleMenu = b.roles
        INNER JOIN tblStatus AS c ON a.empStat = c.status_id";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchModules1()
    {
        $query = "SELECT * FROM tblRoles";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function insertUser($pg_empUser)
    {
      return $this->db->insert('pg_empUser', $pg_empUser);
    }

    function checkEmpNoExisting($emp_number)
    {
        $query = "SELECT emp_number FROM pg_empUser WHERE emp_number = '$emp_number'";
        $result = $this->db->query($query);

        return $result->row_array();
    }

    function fetchUserInModal($emp_id)
    {
        $query = "SELECT 
        a.emp_id,
        a.emp_number,
        a.last_name,
        a.first_name,
        a.middle_name,
        a.roleMenu,
        a.empDepartment
        FROM pg_empUser AS a
        INNER JOIN tblRoles AS b ON a.roleMenu = b.roles WHERE a.emp_id = '$emp_id'";

        $result = $this->db->query($query);

        return $result->row_array();
    }

    function updateUserModel($emp_id, $pg_empUser)
    {
        $this->db->where('emp_id', $emp_id);

        $result = $this->db->update('pg_empUser', $pg_empUser);

        return $result;  
    }

    function disabledUser($emp_id)
    {
        $query = "UPDATE pg_empUser SET empStat = 2 WHERE emp_id = '$emp_id'";
        $result = $this->db->query($query);

        return $result;
    }

    function retrievedUser($emp_id)
    {
        $query = "UPDATE pg_empUser SET empStat = 1 WHERE emp_id = '$emp_id'";
        $result = $this->db->query($query);

        return $result;
    }

    function createSRAcc($data)
    {
        $query = $this->db->insert('SR_empUser', $data);

        return $query;
    }

    function checkUserNameExistInDb($username)
    {
        $query = "SELECT username FROM SR_empUser WHERE username = '$username' AND status = 1";
        $result = $this->db->query($query);

        // echo $query;
        // exit();

        return $result->row();
    }

    function SelectSREmps()
    {
        $query = "SELECT 
        a.id,
         a.firstName, 
         a.lastName,
          a.username,
           b.roleName,
            a.status,
             c.stats,
              FORMAT(a.datecreated, 'MM-dd-yyy') AS datecreated,
               a.userCreated FROM SR_empUser AS a
        LEFT JOIN tblRoles AS b ON a.roleMenu = b.roles 
        LEFT JOIN tblStatus AS c ON a.status = status_id";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function SelectSRempsEmp($id)
    {
        $query = "SELECT 
        a.id,
         a.firstName, 
         a.lastName,
          a.username,
          a.roleMenu,
           b.roleName,
            a.status,
             c.stats,
              FORMAT(a.datecreated, 'MM-dd-yyy') AS datecreated,
               a.userCreated FROM SR_empUser AS a
        LEFT JOIN tblRoles AS b ON a.roleMenu = b.roles
        LEFT JOIN tblStatus AS c ON a.status = status_id
        WHERE a.id = '$id'";

        $result = $this->db->query($query);

        return $result->row();
    }

    function updateSRempUser($username, $SR_empUser)
    {
                 $this->db->where('username', $username);
        $query = $this->db->update('SR_empUser', $SR_empUser);

        // echo $query;
        // exit();

        return $query;
    }

    function updateStatSREmp($username)
    {
        $query = "UPDATE SR_empUser SET status = 2 WHERE id = '$username'";
        $result = $this->db->query($query);

        return $result;
    }

    function updateStatSREmpEnabled($username)
    {
        $query = "UPDATE SR_empUser SET status = 1 WHERE id = '$username'";
        $result = $this->db->query($query);

        return $result;
    }


}
