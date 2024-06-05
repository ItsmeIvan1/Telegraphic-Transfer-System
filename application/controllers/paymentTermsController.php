<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class paymentTermsController extends CI_Controller {

 public function addPayment()
 {
    $paymentName =   $this->input->post('paymentName');
    $paymentStatus = 1;

    
    if($this->session->userdata('empName')){

        $session_user = $this->session->userdata('empName');

    }else if($this->session->userdata('username'))
    {
        $session_user = $this->session->userdata('username');
    }


    if($paymentName == "")
    {
        $resp = array(
            's' => 1,
            'm' => 'Input all required fields'
        );

        echo json_encode($resp);
    }

    else
    {
        $checkPaymentNameIfExisting = $this->paymentTermsModel->checkPaymentIfExisting($paymentName);

        if($checkPaymentNameIfExisting)
        {
            $resp = array(
                'stat' => 2,
                'mes'  => 'Payment name already exist in the database'
            );

            echo json_encode($resp);
        }

        else
        {
            $data = array(
                'paymentName'   => $paymentName,
                'paymentStatus' => $paymentStatus,
                'userCreated'   => $session_user,
                'dateCreated'   => date("Y-m-d"),   
            );

            $addPayment = $this->paymentTermsModel->addPaymentTerms($data);

            if($addPayment)
            {
                $alert = array(
                    'status' => 0,
                    'message' => 'Successfully created!'
                );
        
                echo json_encode($alert);
            }
        
            else
            {
                $alert = array(
                    'status'=> 1,
                    'message' => 'Something went wrong'
                );
        
                echo json_encode($alert);
            }
        }
    }
 
 }

 public function alertIfDisable()
 {
    $paymentID = $this->input->post('paymentCode');

    if($paymentID)
    {
        $resp = array(
            'stat' => 2,
            'mess' => "Are you sure to disable this?"
        );
        
        echo json_encode($resp);
    }   
 }

 public function disabledPayment()
 {
    $paymentID = $this->input->post('paymentCode');

    $disable = $this->paymentTermsModel->disabledPayment($paymentID);

    if($disable)
    {
        $resp = array(
            'status'  => 1,
            'message' => 'Successfully disabled!'
        );

        echo json_encode($resp);
    }

    else
    {
        $resp = array(
            'status' => 2,
            'message' => 'Something went wrong!'
        );

        echo json_encode($resp);
    }
 }

 public function alertIfRetrieve()
 {
    $paymentID = $this->input->post('paymentCode');

    if($paymentID)
    {
        $resp = array(
            'stat' => 2,
            'mess' => "Are you sure to retrieve this?"
        );
    
        echo json_encode($resp);
    }   
 }

 public function retrievedPayment()
 {
    $paymentID = $this->input->post('paymentCode');

    $disable = $this->paymentTermsModel->retrievePayment($paymentID);

    if($disable)
    {
        $resp = array(
            'status'  => 1,
            'message' => 'Successfully retrieved!'
        );

        echo json_encode($resp);
    }

    else
    {
        $resp = array(
            'status'  => 2,
            'message' => 'Something went wrong!'
        );

        echo json_encode($resp);
    }
 }

 public function fetchPaymentInModal()
 {
    $paymentTermCode = $this->input->post('paymentID');
    
    $result = $this->paymentTermsModel->fetchpaymentData($paymentTermCode);

    echo json_encode($result);
 }

 public function updatePaymentInModal()
 {
    $paymentTermCode = $this->input->post('paymentTermCode');

    $paymentName =     $this->input->post('paymentName');
    $paymentStatus =   $this->input->post('paymentStatus');

    
    if($this->session->userdata('empName')){

        $session_user = $this->session->userdata('empName');

    }else if($this->session->userdata('username'))
    {
        $session_user = $this->session->userdata('username');
    }

    if($paymentName == '')
    {
        $resp = array(
            'status'  => 1,
            'message' => 'Please input all fields'
        );

        echo json_encode($resp);
    }

    else
    {

        $checkPaymentIfExisting = $this->paymentTermsModel->checkPaymentIfExisting($paymentName);

        if($checkPaymentIfExisting)
        {
            $response = array(
                's'  => 2,
                'm' => 'Payment already exist in database'
            );

            echo json_encode($response);
        }

        else
        {
            $data = array(
                'paymentName'   => $paymentName,
                // 'paymentStatus' => $paymentStatus,
                'userUpdated'   => $session_user,
                'dateUpdated'   => date("Y/m/d"),
            );
    
            $update = $this->paymentTermsModel->updatePaymentInModal($paymentTermCode, $data);
    
            if($update)
            {
                $resp = array(
                    'stat' => 2,
                    'mess' => 'Successfully updated'
                );
    
                echo json_encode($resp);
            }
    
            else
            {
                $resp = array(
                    'stat' => 3,
                    'mess' => 'Something went wrong'
                );
    
                echo json_encode($resp);
            }
        }


    }
 }

}
