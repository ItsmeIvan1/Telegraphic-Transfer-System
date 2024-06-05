<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class vendorController extends CI_Controller {

        public function InsertingVendorData()
        {
            $vendorName =         $this->input->post('vendorName');
            $vendorAddress =      $this->input->post('vendorAddress');
            $vendorAddress1 =     $this->input->post('vendorAddress1');
            $baranggay =          $this->input->post('baranggay');
            $province =           $this->input->post('province');
            $municipality =       $this->input->post('municipality');
            $country =            $this->input->post('country');
            $vendorStatus =       1;
            $approvalStats =      2;

            if($this->session->userdata('empName')){

                $session_user = $this->session->userdata('empName');
    
            }else if($this->session->userdata('username'))
            {
                $session_user = $this->session->userdata('username');
            }

            $inputs = array(
                $vendorName,
                // $vendorAddress,
                // $vendorAddress1,
                // $baranggay,
                // $province,
                // $municipality,
                $vendorStatus
            );

            if(in_array('', $inputs))
            {
                $alert = array(
                    'stat_empty'   => 0,
                    'stat_message' => 'Please input required fields!'
                );

                echo json_encode($alert);
            }

            else
            {
                $checkFirstVendorName = $this->VendorModel->checkVendorifExist($vendorName);

                if($checkFirstVendorName)
                {
                    $response = array(
                        's' => 3,
                        'm' => 'Vendor already exist in the database'
                    );
        
                    echo json_encode($response);
                }

                else
                {
                    $data = array (
                        'vendorName'        => $vendorName,
                        'vendorStatus'      => $vendorStatus,
                        'vendor_approval_status'    => $approvalStats,
                        'vendorAddress1'    => $vendorAddress1,
                        'vendorAddress2'    => $vendorAddress,
                        'baranggay'         => $baranggay,
                        'province'          => $province,
                        'municipality'      => $municipality,
                        'country'           => $country,
                        'userCreated'       => $session_user,
                        'dateCreated'       => date("Y/m/d"),
                    );
        
                    $result = $this->VendorModel->insertVendorData($data);
        
                    if($result)
                    {
                        $response = array(
                            'status'  => 1,
                            'message' => 'Successfully created!'
                        );
        
                        echo json_encode($response);
                    }
        
                    else
                    {
                        $response = array(
                            'status'  => 2,
                            'message' => 'Something wrong!'
                        );
        
                        echo json_encode($response);
                    }
                }
            }
        }

        public function AlertDisabledVendor()
        {
            $vendorCode = $this->input->post('vendorID');

            if($vendorCode)
            {
                $d = array(
                    'stat' => 0,
                    'mess' => 'Disable vendor?',
                );

                echo json_encode($d);
            }
        }

        public function DisabledVendor()
        {
            $vendorCode = $this->input->post('vendorID');

            $result = $this->VendorModel->disableVendor($vendorCode);

            if($result)
            {
                $response = array(
                    'status'  => 1,
                    'message' => 'Vendor has been disabled!'
                );

                echo json_encode($response);
            }
        }

        public function AlertRetrieveVendor()
        {
            $vendorCode = $this->input->post('vendorID');

            if($vendorCode)
            {
                $d = array(
                    'stat' => 0,
                    'mess' => 'You want to retrieve vendor?',
                );

                echo json_encode($d);
            }
        }

        public function retrieveVendor()
        {
            $vendorCode = $this->input->post('vendorID');

            $result = $this->VendorModel->retrieveVendor($vendorCode);

            if($result)
            {
                $response = array(
                    'status'  => 1,
                    'message' => 'Vendor has been disabled!'
                );
                
                echo json_encode($response);
            }
        }

         public function fetchVendor()
        {
            $vendor = $this->input->post('vendorID');
            $result = $this->VendorModel->fetchVendorInModal($vendor);

            // var_dump($result);
            // exit();
         
            $populateMunicipality = $this->VendorModel->fetchMunicipalityBasedOnProvince($result->province);
            $populateBarangay = $this->VendorModel->fetchBarangayBasedOnMunicipality($result->municipality);
       
            $arr = array(
                'data'         => $result,
                'municipality' => $populateMunicipality,
                'baranggay'    => $populateBarangay,
            );

            echo json_encode($arr);
        }

        public function updateVendor()
        {   
            $vendorCode = $this->input->post('vendorCode');

            $vendorName =     $this->input->post('vendorName');
            // $vendorStatus =   $this->input->post('vendorStatus');
            $vendorAddress =  $this->input->post('vendorAddress');
            $vendorAddress1 = $this->input->post('vendorAddress1');
            $baranggay =      $this->input->post('baranggay');
            $municipality =   $this->input->post('municipality');
            $province =       $this->input->post('province');

            if($this->session->userdata('empName')){

                $session_user = $this->session->userdata('empName');
    
            }else if($this->session->userdata('username'))
            {
                $session_user = $this->session->userdata('username');
            }

            $inputs = array(
                $vendorName,
                // $vendorStatus,
                // $vendorAddress,
                // $vendorAddress1,
                // $baranggay,
                // $municipality,
                // $province
            );

            if(in_array('', $inputs))
            {
                $alert = array(
                    'stat_empty'   => 0,
                    'stat_message' => 'Please input required fields!'
                );

                echo json_encode($alert);
            }

            else
            {
                $data = array (
                    'vendorName'        => str_replace(' ', '', $vendorName),
                    // 'vendorStatus'      => trim($vendorStatus),
                    'vendorAddress2'     => trim($vendorAddress),
                    'vendorAddress1'    => trim($vendorAddress1),
                    'baranggay'         => trim($baranggay),
                    'municipality'      => trim($municipality),
                    'province'          => trim($province),
                    'userUpdated'       => $session_user,
                    'dateUpdated'       => date("Y-m-d h:i:s"),
                );
    
                $UpdateVendor = $this->VendorModel->updateVendor($vendorCode, $data);
    
                if($UpdateVendor)
                {
                    $response = array(
                        'status'  => 1,
                        'message' => 'Successfully Updated'
                    );

                    echo json_encode($response);
                }
    
                else
                {
                    $response = array(
                        'status' => 2,
                        'message' => 'Error Updating'
                    );
    
                    echo json_encode($response);
                }
            }
        }

        public function populateMunicipalityToProvince()
        {
           $province = $this->input->post('provinces');
            
            $populate = $this->VendorModel->fetchMunicipalityBasedOnProvince($province);

            echo json_encode($populate); 
        }

        public function populateBarangayToMunicipality()
        {
            $municipality = $this->input->post('municipalities');

            $populate = $this->VendorModel->fetchBarangayBasedOnMunicipality($municipality);

            echo json_encode($populate);
        }

        
}
