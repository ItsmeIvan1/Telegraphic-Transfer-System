<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class bankInformationController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        // $this->load->helper(array('form', 'url'));
        $this->load->library('pdf');
        
    }

    public function InsertingBankInfoData()
    {
        $bankName =         $this->input->post('bankName');
        $bankStatus =       1;
        $bankAddress =      $this->input->post('bankAddress');
        $bankAddress1 =     $this->input->post('bankAddress1');
        $bankProvince =     $this->input->post('bankProvince');
        $bankMunicipality = $this->input->post('bankMunicipality');
        $bankBarangay =     $this->input->post('bankBarangay');
        $bankNumber =       $this->input->post('bankNumber');

        if($this->session->userdata('empName')){

            $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }

        $inputs = array(
            $bankName,
            //$bankAddress,
            // $bankAddress1,
            // $bankBarangay,
            // $bankMunicipality,
            // $bankProvince
        );

        if(in_array('', $inputs))
        {
            $alert = array(
                'stat_empty'   => 0,
                'stat_message' => 'Please input required fields.'
            );

            echo json_encode($alert);
        }

        else
        {
            $checkFirstbankNameifExist = $this->bankInformationModel->checkbankNameifExist($bankName);

            if($checkFirstbankNameifExist)
            {
                $response = array(
                    's' => 3,
                    'm' => 'Bank already exist in the database.'
                );
    
                echo json_encode($response);
            }

            else
            {
                $data = array (
                    'bankName'        => $bankName,
                    'bank_number'      => $bankNumber,
                    'bankStatus'      => trim($bankStatus),
                    'bankAddress2'    => trim($bankAddress),
                    'bankAddress1'    => $bankAddress1,
                    'bankAddress'     => trim($bankBarangay),
                    'bankMunicipality'=> trim($bankMunicipality),
                    'bankProvince'    => trim($bankProvince),
                    'userCreated'     => $session_user,
                    'dateCreated'     => date("Y/m/d")
                );
    
                $result = $this->bankInformationModel->insertBankInfoData($data);
    
                if($result)
                {
                    $response = array(
                        'status'  => 1,
                        'message' => 'Successfully created.'
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

    public function AlertDisabledBankInfo()
    {
        $vendorCode = $this->input->post('bankID');

        if($vendorCode)
        {
            $d = array(
                'stat' => 0,
                'mess' => 'You want to disable bank?',
            );

            echo json_encode($d);
        }
    }

    public function DisabledBankInfo()
    {
        $vendorCode = $this->input->post('bankID');

        $result = $this->bankInformationModel->disableBankInfo($vendorCode);

        if($result)
        {
                $response = array(
                    'status'  => 1,
                    'message' => 'Bank has been disabled!'
                );

                echo json_encode($response);
            }
    }

    public function AlertRetrieveBankInfo()
    {
        $vendorCode = $this->input->post('bankID');

        if($vendorCode)
        {
            $d = array(
                'stat' => 0,
                'mess' => 'You want to retrieve bank?',
            );

            echo json_encode($d);
        }
    }

    public function retrieveBankInfo()
    {
        $vendorCode = $this->input->post('bankID');

        $result = $this->bankInformationModel->retrieveBankInfo($vendorCode);

        if($result)
        {
            $response = array(
                'status'  => 1,
                'message' => 'Bank has been retrieved!'
            );

            echo json_encode($response);
        }
    }

    public function fetchBankInformationInModal()
    {
        $bank   =   $this->input->post('bankID');
        $result =   $this->bankInformationModel->fetchBankInfoModal($bank);

        // var_dump($result);
        // exit();
                
        $populateMunicipality = $this->bankInformationModel->fetchMunicipalityBasedOnProvince($result->bankProvince);
        $populateBarangay = $this->bankInformationModel->fetchBarangayBasedOnMunicipality($result->bankMunicipality);
    
        $arr = array(
            'data'             => $result,
            'bankMunicipality' => $populateMunicipality,
            'bankAddress'      => $populateBarangay,
    
        );

        echo json_encode($arr);
    }

    public function updateBank()
    {   
        $bankCode =         $this->input->post('bankCode');

        $bankName =         $this->input->post('bankName');
        // $bankStatus =       $this->input->post('bankStatus');
        $bankAddress =      $this->input->post('bankAddress');
        $bankAddress1 =     $this->input->post('bankAddress1');
        $bankAddress2 =     $this->input->post('bankAddress2');
        $bankMunicipality = $this->input->post('bankMunicipality');
        $bankProvince =     $this->input->post('bankProvince');

        if($this->session->userdata('empName')){

            $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }

        $inputs = array(
            $bankName,
            // $bankStatus,
            // $bankAddress1,
            // $bankAddress2,
            // $bankMunicipality,
            // $bankProvince
        );


        if(in_array('', $inputs))
        {
            $resp = array(
                's' => 6,
                'm' => 'Please input all fields.'
            );

            echo json_encode($resp);
        }

        else
        {
            $data = array (
                'bankName'        => str_replace(' ', '', $bankName),
                // 'bankStatus'      => trim($bankStatus),
                'bankAddress2'    => trim($bankAddress),
                'bankAddress1'    => trim($bankAddress1),
                'bankAddress'    => trim($bankAddress2),
                'bankMunicipality'=> trim($bankMunicipality),
                'bankProvince'    => trim($bankProvince),
                'userUpdated'     => $session_user,
                'dateUpdated'     => date("Y-m-d"),     
            );

            $UpdateBankInfo = $this->bankInformationModel->updateBankInformation($bankCode, $data);
            
            if($UpdateBankInfo)
            {
                $response = array(
                    'status'  => 1,
                    'message' => 'Successfully Updated.'
                );

                echo json_encode($response);
            }

            else
            {
                $response = array(
                    'status'  => 2,
                    'message' => 'Error Updating.'
                );

                echo json_encode($response);
            }
        }

    }

    public function populateMunicipalityToProvince()
    {
        $province = $this->input->post('provinces');
        
        $populate = $this->bankInformationModel->fetchMunicipalityBasedOnProvince($province);

        echo json_encode($populate); 
    }

    public function populateBarangayToMunicipality()
    {
        $municipality = $this->input->post('municipalities');

        $populate = $this->bankInformationModel->fetchBarangayBasedOnMunicipality($municipality);

        echo json_encode($populate);
    }

    public function generateBankInfoExcel()
    {
 
        // Obtain data from the model
        $data = $this->bankInformationModel->generateBankInfo();
    
        // Set up Excel sheet
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Bank Details');
    
        // Define the header
        $header = array(
            'VENDOR NAME', 'VENDOR ADDRESS', 'COUNTRY', 'BANK ACCOUNT NUMBER', 'ACCOUNT NAME',
            'BANK ADDRESS', 'CURRENCY', 'SWIFT CODE', 'IBAN #','ABA NO.', 'ROUTING NO.', 'CIF NO', 'BSB NO',
            'INTERMEDIARY BANK', 'INTER BANK ADDRESS', 'NUMBER', 'SWIFT', 'ABA', 'CHIPS'
        );
    
        $this->excel->getActiveSheet()->fromArray([$header]);
    
        $headerRange = 'A1:S1';

        $headerStyleArray = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '2db83d'),
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'FFFFFF'),
            ),
        );
        $this->excel->getActiveSheet()->getStyle($headerRange)->applyFromArray($headerStyleArray);
    
        $rowNumber = 2; 

        foreach ($data as $row) {

            $column = 'A';

            foreach ($row as $value) {
                  $this->excel->getActiveSheet()->setCellValue('A' . $rowNumber, $row['vendorName']);
                  $this->excel->getActiveSheet()->setCellValue('B' . $rowNumber, $row['vendorAddress2']);
                  $this->excel->getActiveSheet()->setCellValue('C' . $rowNumber, $row['country']);
                  $this->excel->getActiveSheet()->setCellValue('D' . $rowNumber, $row['bank_number']);
                  $this->excel->getActiveSheet()->setCellValue('E' . $rowNumber, $row['bankName']);
                  $this->excel->getActiveSheet()->setCellValue('F' . $rowNumber, $row['bankAddress2']);
                  $this->excel->getActiveSheet()->setCellValue('G' . $rowNumber, $row['currency']);
                  $this->excel->getActiveSheet()->setCellValue('H' . $rowNumber, $row['swiftCode']);
                  $this->excel->getActiveSheet()->setCellValue('I' . $rowNumber, $row['ibanNo']);
                  $this->excel->getActiveSheet()->setCellValue('J' . $rowNumber, $row['abaNo']);
                  $this->excel->getActiveSheet()->setCellValue('K' . $rowNumber, $row['routingNo']);
                  $this->excel->getActiveSheet()->setCellValue('L' . $rowNumber, $row['cifNo']);
                  $this->excel->getActiveSheet()->setCellValue('M' . $rowNumber, $row['bsbNo']);
                  $this->excel->getActiveSheet()->setCellValue('N' . $rowNumber, $row['intermediaryBank']);
                  $this->excel->getActiveSheet()->setCellValue('O' . $rowNumber, $row['interbankAddress']);
                  $this->excel->getActiveSheet()->setCellValue('P' . $rowNumber, $row['number']);
                  $this->excel->getActiveSheet()->setCellValue('Q' . $rowNumber, $row['swift']);
                  $this->excel->getActiveSheet()->setCellValue('R' . $rowNumber, $row['aba']);
                  $this->excel->getActiveSheet()->setCellValue('S' . $rowNumber, $row['chips']);



                $column++;
            }
            $rowNumber++;
        }
    
       
        $lastColumn = 'S';
        $lastRow = count($data) + 1; 
        $range = "A1:{$lastColumn}{$lastRow}";
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );
        $this->excel->getActiveSheet()->getStyle($range)->applyFromArray($styleArray);
    
        // Output Excel file
        $filename = 'TTS_PO.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    
        ob_start();
        $objWriter->save('php://output');
        $excelOutput = ob_get_clean();
    
   
        $this->session->set_userdata('excel_data_bank', base64_encode($excelOutput));
    
        echo json_encode(array('success' => true));
        exit();
    }

    public function downloadExcelFile()
    {
        // Retrieve the Excel data from the session
        $excelData = $this->session->userdata('excel_data_bank');
    
        // Output Excel file for download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Bank Details.xls"');
        header('Cache-Control: max-age=0');
    
        echo base64_decode($excelData);
        exit();
    }
}
