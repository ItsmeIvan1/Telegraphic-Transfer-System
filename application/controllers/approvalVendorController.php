<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class approvalVendorController extends CI_Controller {

    public function alertApprovalFirst()
    {
        $vendorCode = $this->input->post('vendor');

        if($vendorCode)
        {
            $resp = array(
                'stats'   => 2,
                'message' => 'Do you want to approved this vendor?'
            );

            echo json_encode($resp);
        }
    }

    public function updateApprovalStat()
    {
        $vendorCode = $this->input->post('vendor');

        $update = $this->approvalVendorModel->updateVendorApproval($vendorCode);

        if($update)
        {
            $resp = array(
                'stats'   => 1,
                'message' => 'Vendor has been approved'
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


    public function alertDissapprove()
    {
        $vendorCode = $this->input->post('vendor');

        if($vendorCode)
        {
            $resp = array(
                'stats'   => 2,
                'message' => 'Do you want to disapproved this vendor?'
            );

            echo json_encode($resp);
        }
    }

    public function disApprovedVendor()
    {
        $vendorCode = $this->input->post('vendor');

        $update = $this->approvalVendorModel->disableVendorApproval($vendorCode);

        if($update)
        {
            $resp = array(
                'stats'   => 1,
                'message' => 'Vendor has been disapproved.'
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

}