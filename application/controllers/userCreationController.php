<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class userCreationController extends CI_Controller {


	function __construct()
    {
        parent:: __construct();
        $this->load->library('ClientSSO');

    }

    public function checkEmpNameInSSO()
    {   
        $empNumber = $this->input->post('employeeNumber');
     

        $sso = new ClientSSO($empNumber);

        $empInfo = $sso->getEmployeeInfo($_SESSION['api_key'],$empNumber);
        
        if($empNumber == '')
        {
            $resp = array(
                'stat'  => 1,
                'mes' => 'Please input Employee number first!'
            );

            echo json_encode($resp);
        }

        else
        {
            if ($empInfo)
            {
                echo json_encode($empInfo);
            } 
    
            else
            {
                echo json_encode($empInfo);
            }
        }
    }

    public function insertUserPG()
    {   
        $empNumber =     $this->input->post('empNumber');
        $lastname =      $this->input->post('lastname');
        $firstname =     $this->input->post('firstname');
        $middlename =    $this->input->post('middlename');
        $department =    $this->input->post('department');
        $selectModules = $this->input->post('selectModules');
        $empStatus = 1;
        
        if($empNumber == '' || $selectModules == '')
        {
            $response = array(
                'stats' => 0,
                'mess'  => 'Please input required fields'
            );

            echo json_encode($response);
        }

        else
        {
            $checkEmpNumberExistingInDB = $this->userCreationModel->checkEmpNoExisting($empNumber);

            if($checkEmpNumberExistingInDB)
            {
                $resp = array(
                    's' => 3,
                    'm' => 'Employee No. is already exist in database'
                );

                echo json_encode($resp);
            }

            else
            {
                $data = array(
                    'emp_number'     => $empNumber,
                    'last_name'      => $lastname,
                    'first_name'     => $firstname,
                    'middle_name'    => $middlename,
                    'roleMenu'       => $selectModules, 
                    'empDepartment'  => $department,
                    'empStat'        => $empStatus,             
                    'addedBy'        => $this->session->userdata('empName'),
                    'dateAdded'      => date('Y-m-d'),
                );
        
                $insertDB = $this->userCreationModel->insertUser($data);
           
                if($insertDB)
                {
                    $resp = array(
                        'status' => 1,
                        'message' => 'success'
                    );
        
                    echo json_encode($resp);
                }
        
                else
                {
                    $resp = array(
                        'status' => 2,
                        'message' => 'error'
                    );
        
                    echo json_encode($resp);
                }
            }   
        }
    }

    public function fetchUsersInModalController()
    {
        $id = $this->input->post('id');

        $fetch = $this->userCreationModel->fetchUserInModal($id);
        
        echo json_encode($fetch);
    }

    public function updateUsersInModalController()
    {
        $emp_id = $this->input->post('emp_id');

        $updateRoleMenu = $this->input->post('roleMenu');

        if($updateRoleMenu == '')
        {
            $response = array(
                'stat'  => 0,
                'mess'  => 'Please select role.'
            );

            echo json_encode($response);
        }

        else
        {
            $data = array (
                'roleMenu'      => $updateRoleMenu,
                'updatedBy'     => $this->session->userdata('empName'),
                'updateDate'    => date('Y-m-d')
            );
    
            $update = $this->userCreationModel->updateUserModel($emp_id, $data);
    
            if($update)
            {
                $response = array(
                    'status'  => 1,
                    'message' => 'Successfully updated'
                );
    
                echo json_encode($response);
            }
    
            else
            {
                $response = array(
                    'status'  => 2,
                    'message' => 'Something went wrong'
                );
    
                echo json_encode($response);
            }
        }

    }

    public function alertDisableUser()
    {   
        $userId = $this->input->post('userID');

        if($userId)
        {
            $response = array(
                'stat' => 0,
            );

            echo json_encode($response);
        }
    }

    public function disabledUserController()
    {
        $userId = $this->input->post('userID');

        $result = $this->userCreationModel->disabledUser($userId);

        if($result)
        {
            $response = array(
                'status' => 1
            );

            echo json_encode($response);
        }
    }

    public function alertRetrievedUser()
    {
        $userId = $this->input->post('userID');

        if($userId)
        {
            $response = array(
                'stat' => 0,
            );

            echo json_encode($response);
        }
    }

    public function retrievedUser()
    {
        $userId = $this->input->post('userID');

        $result = $this->userCreationModel->retrievedUser($userId);

        if($result)
        {
            $response = array(
                'status' => 1
            );

            echo json_encode($response);
        }
    }

    public function createAccSR()
    {   
        $firstName = $this->input->post('firstname');
        $lastName = $this->input->post('lastName');
        $user = $this->input->post('user');
        $pass = $this->input->post('pass');
        $modules = $this->input->post('access');

        if($this->session->userdata('empName'))
        {
            $session_user = $this->session->userdata('empName');
        }

        else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }

        

        if($firstName == '' || $lastName == '' || $user == '' || $pass == '' || $modules == '')
        {
            $resp = array(
                'status'    => 0.1,
                'message'   => 'Please input required fields'
            );

            echo json_encode($resp);
        }

        else
        {
            $data = array(
                'firstname'         => $firstName,
                'lastname'          => $lastName,
                'username'          => $user,
                'password'          => sha1($pass),
                'status'            => 1,
                'roleMenu'          => $modules,
                'firstLoginStatus'  => 1,
                'datecreated'       => date("Y-m-d H:i:s"),
                'userCreated'       => $session_user
            );

            // var_dump($data);
            // exit();
    
            $insertDB = $this->userCreationModel->createSRAcc($data);
    
            if($insertDB)
            {
                $resp = array(
                    'status'    => 1,
                    'message'   => 'Successfully created'
                );
    
                echo json_encode($resp);
    
            }
    
            else
            {
                $resp = array(
                    'message'   => 'Error'
                );
    
                echo json_encode($resp);
            }
    
        }


        
    }

    public function checkUsernameFirst()
    {
        $username = $this->input->post('user');
        
        $check = $this->userCreationModel->checkUserNameExistInDb($username);

        if($check)
        {
            $resp = array(
                'status'    => 1,
                'message'   => 'Username already exist!'
            );

        }

        else
        {
            $resp = array(
        
                'message'   => 'tits'
            );
        }

        echo json_encode($resp);

        
    }

    public function fetchEmpUserToTable()
    {
        $id = $this->input->post('empSR_id');

        $fetch = $this->userCreationModel->SelectSRempsEmp($id);

        echo json_encode($fetch);
    }

    public function updateSRInTBL()
    {   
        $username = $this->input->post('user');
        $modules = $this->input->post('modules');

        if($this->session->userdata('empName'))
        {
            $session_user = $this->session->userdata('empName');
        }

        else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }



        if($modules == '')
        {
            $resp = array(
                'status'    => 1,
                'message'   => 'Please select modules'
            );

            echo json_encode($resp);
        }

        else
        {
            $data = array(
                'roleMenu'      => $modules,
                'userUpdated'   => $session_user,
                'dateUpdated'   => date("Y-m-d H:i:s")
            );

            // var_dump($data);
            // exit();

            $update = $this->userCreationModel->updateSRempUser($username, $data);

            if($update)
            {
                $resp = array(
                    'status'    => 1.5,
                    'message'   => 'Successfully updated!'
                );

                echo json_encode($resp);
            }

            else
            {
                $resp = array(
                    'message'   => 'Error'
                );

                echo json_encode($resp);
            }
        }

        
    }

    public function alertDisabledSRUser()
    {
        $d = $this->input->post('alert');
        
        if($d)
        {
            $resp = array(
                'status' => 0.1
            );

            echo json_encode($resp);

        }
    }


    public function disabledSRUser()
    {
        $d = $this->input->post('d');

        $disable = $this->userCreationModel->updateStatSREmp($d);

        if($disable)
        {
            $resp = array(
                'status'    => 1,
                'message'   => 'Successfully disabled'
            );

        }

        else
        {
            $resp = array(
                'message'   => 'Something went wrong'
            );
        }

        echo json_encode($resp);
    }


    public function alertRetrievedSRUser()
    {
        $d = $this->input->post('alert');
        
        if($d)
        {
            $resp = array(
                'status' => 0.1
            );

            echo json_encode($resp);

        }
    }


    public function retrievedSRUser()
    {
        $d = $this->input->post('d');

        $disable = $this->userCreationModel->updateStatSREmpEnabled($d);

        if($disable)
        {
            $resp = array(
                'status'    => 1,
                'message'   => 'Successfully retrieved'
            );

        }

        else
        {
            $resp = array(
                'message'   => 'Something went wrong'
            );
        }

        echo json_encode($resp);
    }
}
