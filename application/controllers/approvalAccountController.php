<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class approvalAccountController extends CI_Controller {


    public function alertAccountApproval()
    {
        $account_code = $this->input->post('acc_code');

        if($account_code)
        {
            $resp = array(
                'status'    => 0,
                'message'   => 'You want to approved this account?' 
            );

            echo json_encode($resp);
        }
    }

    public function updateAccountApproval()
    {
        $account_code = $this->input->post('acc_code');

        $update = $this->approvalAccountModel->updateDisapproved($account_code);

        if($update)
        {
            $resp = array(
                'status'    => 1,
                'message'   => 'Account has been approved.' 
            );

            echo json_encode($resp);
        }

        else
        {
            $resp = array(
                'message'   => 'Something went wrong' 
            );

            echo json_encode($resp);
        }
    }

    public function alertAccountDisapproved()
    {
        $account_code = $this->input->post('acc_code');

        if($account_code)
        {
            $resp = array(
                'status'    => 0,
                'message'   => 'You want to disapproved this account?' 
            );

            echo json_encode($resp);
        }
    }

    public function updateDisapproved()
    {
        $account_code = $this->input->post('acc_code');

        $update = $this->approvalAccountModel->disApprovedUpdate($account_code);

        if($update)
        {
            $resp = array(
                'status'    => 1,
                'message'   => 'Account has been Disapproved.' 
            );

            echo json_encode($resp);
        }

        else
        {
            $resp = array(
                'message'   => 'Something went wrong' 
            );

            echo json_encode($resp);
        }
    }
}