<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class approvalVendorAccountController extends CI_Controller {
    
    public function alertIfApproved()
    {
        $id = $this->input->post('id');

        if($id)
        {
            $resp = array(
                'status'  => 0,
                'message' => 'Do you want to approved this Vendor account?'
            );

            echo json_encode($resp);
        }

        else
        {
            $resp = array(

                'message' => 'Something went wrong'
            );

            echo json_encode($resp);
        }
    }

    public function ApprovedVC()
    {
        $id = $this->input->post('id');

        $approved = $this->approvalVendorAccountModel->approveApprovalVendorAcc($id);

        if($approved)
        {
            $resp = array(
                'status'    => 1,
                'message'   => 'This vendor account already approved'
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

    public function alertIfDisApproved()
    {
        $id = $this->input->post('id');

        if($id)
        {
            $resp = array(
                'status'  => 0,
                'message' => 'Do you want to Disapproved this Vendor account?'
            );

            echo json_encode($resp);
        }

        else
        {
            $resp = array(

                'message' => 'Something went wrong'
            );

            echo json_encode($resp);
        }
    }

    public function DisApprovedVC()
    {
        $id = $this->input->post('id');

        $approved = $this->approvalVendorAccountModel->disapproveApprovalVendorAcc($id);

        if($approved)
        {
            $resp = array(
                'status'    => 1,
                'message'   => 'This vendor account already Disapproved'
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