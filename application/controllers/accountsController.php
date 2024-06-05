<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class accountsController extends CI_Controller {

    public function insertAccount()
    {
        $accountNumber =    $this->input->post('accountNumber');
        $bankCode =         $this->input->post('bankCode');
        $swiftCode =        $this->input->post('swiftCode');


        $abaNo =            $this->input->post('abaNo');
        $routingNo =        $this->input->post('routingNo');
        $ibanNo =           $this->input->post('ibanNo');


        $cifNo =            $this->input->post('cifNo');
        $bsbNo =            $this->input->post('bsbNo');
        $intermediaryBank = $this->input->post('IntermediaryBank');


        $interBankAddress = $this->input->post('interBankAddress');
        $number =           $this->input->post('number');
        $swift =            $this->input->post('swift');
       
        $aba =              $this->input->post('aba');
        $chips =            $this->input->post('chips');
        $status =           1;
        $approvalStats =    2;

        if($this->session->userdata('empName')){

            $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }

        $inputs = array(
            $accountNumber,
            // $bankCode,
            // $swiftCode,
            // $abaNo,
            // $routingNo,
            // $ibanNo,
            // $cifNo,
            // $bsbNo,
            // $intermediaryBank,
            // $interBankAddress,
            // $number,
            // $swift,
            // $aba,
            // $chips,
            $status,
        );

        if(in_array('', $inputs))
        {
             $resp = array(
                'status'  => 1,
                'message' => 'Please input all fields'
             );
             
             echo json_encode($resp);
        }

        else
        {
            $checkAccountNumberFirst = $this->accountsModel->checkAccountIfExistDB($accountNumber);

            if($checkAccountNumberFirst)
            {
                $resp = array(
                    's' => 6,
                    'm' => 'Account number is already exist in the database'
                );

                echo json_encode($resp);
            }

            else
            {
                $data = array(
                    'accountNumber'     => $accountNumber,
                    'bankCode'          => $bankCode,
                    'swiftCode'         => $swiftCode,
                    'abaNo'             => $abaNo,
                    'routingNo'         => $routingNo,
                    'ibanNo'            => $ibanNo,
                    'cifNo'             => $cifNo,      
                    'bsbNo'             => $bsbNo,
                    'intermediaryBank'  => $intermediaryBank,
                    'interbankAddress'  => $interBankAddress,
                    'number'            => $number,
                    'swift'             => $swift,
                    'aba'               => $aba,
                    'chips'             => $chips,
                    'status'            => $status,
                    'account_approval_status'   => $approvalStats,
                    'userCreated'       => $session_user,
                    'dateCreated'       => date('Y-m-d'),
                );
    
                $insertAccounts = $this->accountsModel->insertAccount($data);
    
                if($insertAccounts)
                {
                    $resp = array(
                        'stats' => 2,
                        'mess'  => 'Successfully created'
                    );
    
                    echo json_encode($resp);
                }
    
                else
                {
                    $resp = array(
                        'stats' => 3,
                        'mess'  => 'Something went wrong'
                    );
    
                    echo json_encode($resp);
                }
            }
        }
    }

    public function alertIfDisable()
    {
        $accCode = $this->input->post('accCode');

        if($accCode)
        {
            $resp = array(
                'status'    => 0,
                'message'   => 'Do you want to disabled?'
            );

            echo json_encode($resp);
        }
    }

    public function disableAccount()
    {
        $accCode = $this->input->post('accCode');

        $disable = $this->accountsModel->disableAccountModel($accCode);

        if($disable)
        {
            $resp = array(
                'stat' => 1,
                'mess' => 'Successfully disabled!'
            );

            echo json_encode($resp);
        }

        else
        {
            $resp = array(
                'stat' => 2,
                'mess' => 'Something went wrong'
            );

            echo json_encode($resp);
        }

    }

    public function alertIfRetrieved()
    {
        $accCode = $this->input->post('accCode');

        if($accCode)
        {
            $resp = array(
                'status'    => 0,
                'message'   => 'Do you want to retrieve?'
            );

            echo json_encode($resp);
        }
    }

    public function retrieveAccount()
    {
        $accCode = $this->input->post('accCode');

        $disable = $this->accountsModel->retrieveAccountModel($accCode);

        if($disable)
        {
            $resp = array(
                'stat' => 1,
                'mess' => 'Successfully retrieved!'
            );

            echo json_encode($resp);
        }

        else
        {
            $resp = array(
                'stat' => 2,
                'mess' => 'Something went wrong'
            );

            echo json_encode($resp);
        }
    }
    
    public function fetchDataInModal()
    {
        $accCode = $this->input->post('accCode');

        $fetchData = $this->accountsModel->fetchDataInModal($accCode);

        echo json_encode($fetchData);
    }

    public function updateAccountController()
    {
        $updateAccountCode =      $this->input->post('accountCode');
        $updateAccountName =      $this->input->post('accName');
        $updateAccountNumber =    $this->input->post('accountNumber');
        $updateBankCode =         $this->input->post('bankCode');
        $updateSwiftCode =        $this->input->post('swiftCode');
        $updateABAno =            $this->input->post('abaNo');
        $updateRoutingNo =        $this->input->post('routingNo');
        $updateIbanNo =           $this->input->post('ibanNo');
        $updateCifNo =            $this->input->post('cifNo');
        $updateBsbNo =            $this->input->post('bsbNo');
        $updateIntermediaryBank = $this->input->post('intermediaryBank');
        $updateInterbankAddress = $this->input->post('interBankAddress');
        $updateNumber =           $this->input->post('number');
        $updateSwift =            $this->input->post('swift');
        $updateAba =              $this->input->post('aba');
        $updateChips =            $this->input->post('chips');
        // $updateStatus =           $this->input->post('status');

        if($this->session->userdata('empName')){

            $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }

        $inputs = array(
            $updateAccountNumber,
            $updateAccountName,
            $updateBankCode,
            // $updateSwiftCode,
            // $updateABAno,
            // $updateRoutingNo,
            // $updateIbanNo,
            // $updateCifNo,
            // $updateBsbNo,
            // $updateIntermediaryBank,
            // $updateInterbankAddress,
            // $updateNumber,
            // $updateSwift,
            // $updateAba,
            // $updateChips,
            // $updateStatus,
        );

        if(in_array('', $inputs))
        {

            $response = array(
                's'   => 1,
                'm'   => 'Please input all fields'
            );

            echo json_encode($response);
        }

        else
        {
            $data = array(
                'accountNumber'    => $updateAccountNumber,
                'account_name'     => $updateAccountName,
                'bankCode'         => $updateBankCode,
                'swiftCode'        => $updateSwiftCode,
                'abaNo'            => $updateABAno,
                'routingNo'        => $updateRoutingNo,
                'ibanNo'           => $updateIbanNo,
                'cifNo'            => $updateCifNo,
                'bsbNo'            => $updateBsbNo,
                'intermediaryBank' => $updateIntermediaryBank,
                'interbankAddress' => $updateInterbankAddress,
                'number'           => $updateNumber,
                'swift'            => $updateSwift,
                'aba'              => $updateAba,
                'chips'            => $updateChips,
                // 'status'           => $updateStatus,
                'userUpdated'      => $session_user,
                'dateUpdated'      => date('Y-m-d'),
            );
    
            $update = $this->accountsModel->updateAccount($updateAccountCode, $data);
            
            if($update)
            {
                $resp = array(
                    'status'  => 0,
                    'message' => 'Successfully updated!'
                );
    
                echo json_encode($resp);
            }
    
            else
            {
                $resp = array(
                    'status'  => 1,
                    'message' => 'Something wrong!'
                );
    
                echo json_encode($resp);
            }

        }



    }
}
