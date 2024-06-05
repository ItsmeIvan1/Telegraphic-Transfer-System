<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {

    function checkPGUsername($empNo)
    {
        $query1 = "SELECT a.emp_id,
         a.emp_number,
         a.first_name,
         a.last_name,
         a.middle_name,
         a.roleMenu,
         a.empStat,
         b.roles,
         b.roles_desc
        FROM pg_empUser a 
        INNER JOIN tblRoles b ON a.roleMenu = b.roles
        WHERE a.emp_number='$empNo' AND a.empStat = 1";

        $res = $this->db->query($query1);

        return $res->row_array();
    }


    function selectSecurityQuestion()
    {
        $query = $this->db->get('tblSecurityQue');
        return $query->result_array();

    }

    
    function checkUsername($user, $securityAnsID, $security_answer)
    {
        $query = "SELECT username,
                         security_ans_id,
                         security_answer FROM SR_empUser
        WHERE username = '$user' AND security_ans_id = '$securityAnsID' AND security_answer = '$security_answer'";

        $result = $this->db->query($query);

        // echo $query;
        // exit();

        return $result->row();
    }


    function changepassword($username, $data)
    {        
                $this->db->where('username', $username);
       $query = $this->db->update('SR_empUser', $data);

       return $query;

    }


    
    function loginSREmp($username, $password)
    {
        $query = "SELECT username, password, roleMenu FROM SR_empUser WHERE username COLLATE Latin1_General_CS_AS = ? AND password = ? AND status = 1";
        $result = $this->db->query($query, array($username, $password));
    
        return $result->row();
    }
    

    function checkIfFirstLogin($username)
    {
        $query = "SELECT username, firstLoginStatus FROM SR_empUser WHERE username = '$username' AND firstLoginStatus = 1";

        $result = $this->db->query($query);

        return $result->row();
    }

    function checkPassword($username, $password)
    {
        $query = "SELECT  username, password FROM SR_empUser WHERE username = '$username' AND password = '$password' AND status = 1";

        $result = $this->db->query($query);

        return $result->row();
    }






}
