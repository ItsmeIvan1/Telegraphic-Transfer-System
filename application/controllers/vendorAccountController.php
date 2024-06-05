<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class vendorAccountController extends CI_Controller {

    public function insertVendorAcc()
    {
        $vendorCode =       $this->input->post('vendorCode');
        $accountCode =      $this->input->post('accountCode');
        $accountCurrency =  $this->input->post('accCurrency');
        $status = 1;
        $approval_status = 2;

        
        if($this->session->userdata('empName')){

        $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }

        if($vendorCode == '' || $accountCode == '' || $accountCurrency == '')
        {
            $resp = array(
                'stat' => 2,
                'mess' => 'Please input all fields!'
            );

            echo json_encode($resp);
        }

        else
        {
            $checkIfExistInDB = $this->VendorAccountModel->checkIfExistingInDB($vendorCode, $accountCode, $accountCurrency);

            if($checkIfExistInDB)
            {
                $response = array(
                    's' => 0,
                    'm' => 'Vendor name, account code and currency are already exist in database.'
                );

                echo json_encode($response);
            }

            else
            {
                $data = array(
                    'vendorCode'        => $vendorCode,
                    'accountCode'       => $accountCode,
                    'account_currency'  => $accountCurrency,
                    'status'            => $status,
                    'approval_status'   => $approval_status,
                    'user_created'      => $session_user
                );
        
                $insertAccController = $this->VendorAccountModel->insertVendorAccount($data);
        
                if($insertAccController)
                {
                    $resp = array(
                        'status'  => 1,
                        'message' => 'Succesfully Inserted'
                    );
        
                    echo json_encode($resp);
                }
        
                else
                {
                    $resp = array(
                        'status'  => 2,
                        'message' => 'Something wrong'
                    );
        
                    echo json_encode($resp);
                }
            }
        }
    }

    public function fetchVendorAccountInModal()
    {
        $vendorAccountCode = $this->input->post('vendorAccCode');

        $fetch = $this->VendorAccountModel->fetchVendorAccInModal($vendorAccountCode);
     
        echo json_encode($fetch);
    }

    public function updateVendorAccountInModal()
    {
        $vendorAccCode = $this->input->post('vendorAccCode');

        $updateVendorCode = $this->input->post('vendorCode');
        $updateAccountCode = $this->input->post('accountCode');
        $updateAccountCurrency = $this->input->post('accountCurrency');

        
         if($this->session->userdata('empName')){

        $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }


        if($updateVendorCode == '' || $updateAccountCode == '' || $updateAccountCurrency == '')
        {
            $resp = array(
                'stat' => 2,
                'mess' => 'Please input all fields'
            );

            echo json_encode($resp);
        }

        else
        {

            $checkIfExistingInDB = $this->VendorAccountModel->checkIfExistingInDB($updateVendorCode, $updateAccountCode, $updateAccountCurrency);
    
            if($checkIfExistingInDB)
            {
                $response = array(
                    's' => 0,
                    'm' => 'Already Exist in database'
                );
    
                echo json_encode($response);
            }

            else
            {
                $data = array(
                    'vendorCode' => $updateVendorCode,
                    'accountCode' => $updateAccountCode,
                    'account_currency' => $updateAccountCurrency,
                    'user_created' => $session_user
                );
        
                $update = $this->VendorAccountModel->updateAccountsVendor($vendorAccCode, $data);

                if($update)
                {
                    $resp = array(
                        'status' => 1,
                        'message' => 'Successfully updated!'
                    );
        
                    echo json_encode($resp);
                }
        
                else
                {
                    $resp = array(
                        'status' => 2,
                        'message' => 'Something went wrong'
                    );
        
                    echo json_encode($resp);
                } 
            }

            
        }
    }

    public function alertDisabled()
    {
        $btn = $this->input->post('btn');

        if($btn)
        {
            $res = array(
                's' => 0,
                'm' => 'Do you want to disable?'
            );

            echo json_encode($res);
        }

    }

    public function disableVendorAcc()
    {
        $btn = $this->input->post('btn');

        $disable = $this->VendorAccountModel->disabledVendorAcc($btn);

        if($disable)
        {
            $response = array(
                'status'  => 1,
                'message' => 'Vendor account is disabled.'
            );

            echo json_encode($response);
        }

        else
        {
            $response = array(
                'message' => 'Something went wrong'
            );

            echo json_encode($response);
        }

    }

    public function alertRetrieved()
    {
        $btn = $this->input->post('btn');

        if($btn)
        {
            $resp = array(
                'stat' => 0,
                'mess' => 'Do you want to retrieved?'
            );

            echo json_encode($resp);
        }
        
        else
        {
            $resp = array(
                'mess' => 'Something error.'
            );

            echo json_encode($resp);
        }
        
    }
    
    public function retrievedVendorAcc()
    {
        $btn = $this->input->post('btn');

        $retrieved = $this->VendorAccountModel->retrieveVendorAcc($btn);

        if($retrieved)
        {
            $resp = array(
                'status'  => 1,
                'message' => 'Vendor account is retrieved.'
            );

            echo json_encode($resp);
        }

        else
        {
            $resp = array(
                'message' => 'Something went wrong.'
            );

            echo json_encode($resp);
        }

    }
}
