<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SSOController extends CI_Controller {

	function __construct()
    {
        parent:: __construct();
        $this->load->library('ClientSSO');

        $this->load->library('session');

    }

    public function SSOlogin()
    {

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if($username == '' || $password == '')
        {
            $res = array(
                'status'  => 2,
                'message' => 'Please Input all fields',
            );

            echo json_encode($res);
        }

        else
        {
            $response = $this->LoginModel->checkPGUsername($username);

            if ($response) 
            {      
                $sso = new ClientSSO($username, $password, '', $_SERVER['REMOTE_ADDR'], 1);
    
                $verify = $sso->validateEmployee();

                
                
                if ($verify['status'] == '1')
                {
    
                    $empInfo = $sso->getEmployeeInfo($verify["api_key"], $username);

                    //    var_dump($sess);
                    //     exit();
    
                    $sess = [
                        "api_key"           => $verify["api_key"], 
                        "signin_location"   => $verify["signin_location"], 
                        "loggedStatus"      => $verify["status"],
                        "empNo"             => $username,
                        "empName"           => $empInfo['empName'],
                        'roleMenu'          => $response['roleMenu'],

                    ];

                    // var_dump($sess);
                    // exit();
    
                    $this->session->set_userdata($sess);
                    
                    echo json_encode($sess);
    
                } 
                
                else
                {
    
                    $sess = [
                        'loggedErrorMsg'    => $verify["msg"],
                        'loggedStatus'      => $verify['status']
                    ];
    
                    $this->session->set_userdata($sess);

                    echo json_encode($sess);
                }
    
              
            }

            else
            {
                $sess = [
                    'loggedErrorMsg'    => 'Account is not Registered',
                    'loggedStatus'      => 0
                ];
    
                $this->session->set_userdata($sess);

                echo json_encode($sess);
            }
        }  
    }

          
    public function getInfo()
    {
        $empNo = $this->input->post('empNo');

        $sso = new ClientSSO();

        $data = $sso->getEmployeeInfo($_SESSION['api_key'],$empNo);

        echo json_encode($data);  
    }

    public function createAccSR()
    {   
        $firstName = $this->input->post('firstname');
        $lastName = $this->input->post('lastName');
        $user = $this->input->post('user');
        $pass = $this->input->post('pass');
        $rePassword = $this->input->post('reTypePassword');
        $securityQuestion = $this->input->post('securityQues');
        $securityAnswer = $this->input->post('securityAnswer');

        if($user == '' || $pass == '' || $rePassword == '' || $securityQuestion == '' || $securityAnswer == '')
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
                'username'          => $user,
                'password'          => sha1($pass),
                'retype_password'   => sha1($rePassword),
                'status'            => 1,
                'security_ans_id'   => $securityQuestion,
                'security_answer'   => $securityAnswer
            );
    
            $insertDB = $this->LoginModel->createSRAcc($data);
    
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

    public function resetPassword()
    {
        $user = $this->session->userdata('username');
        $newpass = $this->input->post('newpass');
        $retypenewpass = $this->input->post('retypenewpass');

        $credentials = array(
            'password'          => sha1($newpass),
            'status'            => 1,
            'firstLoginStatus'  => 2
        );


            $update = $this->LoginModel->changepassword($user, $credentials);

            if($update)
            {
                $resp = array(
                    'status'    => 1,
                    'message'   => 'Successfully updated'
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

    public function checkUserExistInDB()
    {
        $user = $this->input->post('username');

        $checkUsername = $this->LoginModel->checkUserNameExistInDb($user);

        if($checkUsername)
        {
            $resp = array(
                'status'    => 1,
                'message'   => 'Username already exist!'
            );

        }

        else
        {
            {
                $resp = array(
                    'message'   => 'username not found'
                );
    
       
            }
        }

        echo json_encode($resp);
    }

    public function loginSR()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $login = $this->LoginModel->loginSREmp($username, sha1($password));

         if($username == '' || $password == '')
        {
            $resp = array(
                'status'    => 1,
                'message'   => 'Input all fields',
            );

            echo json_encode($resp);
        }
        
        
        else
        {
            if($login)
            {
                    $this->session->set_userdata('username', $username);
                    $this->session->set_userdata('roleMenu', $login->roleMenu);
    
    
                    $resp = array(
                        'status'    => 2,
                        'message'   => 'Successfully login',
                        'username'   => $username,
                        'roleMenu'  => $login->roleMenu 
                    );

                    echo json_encode($resp);
                
            }
    
            else
            {
                $resp = array(
                    'message'   => 'Incorrect Credentials',
                );
    
    
                echo json_encode($resp);
            }
        }




    }

    public function checkIfFirstLogin()
    {
        $user = $this->session->userdata('username');

        $check = $this->LoginModel->checkIfFirstLogin($user);

        if($check)
        {
            $resp = array(
                'status'    => 1,
                'message'   => 'nice'
            );

        }

        else
        {
            $resp = array(
        
                'message'   => 'error'
            );
        }

        echo json_encode($resp);
    }

    public function checkUserAndPassExist()
    {
        $user = $this->session->userdata('username');
        $pass = $this->input->post('pass');

        $checkIfExist = $this->LoginModel->checkPassword($user, sha1($pass));

        if($checkIfExist)
        {
            $resp = array(
                'status'    => 1,
            );
        }

        else
        {
            $resp = array(
                'message'   => 'password is incorrect'
            );
        }

        echo json_encode($resp);
    }


}
