<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class telegraphicTransferController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->helper(array('form', 'url'));
        
    }

    public function insertTelegraphicTransfer()
    {   
   
        $vendorCode =        $this->input->post('vendorCode');
        $accterm =           $this->input->post('accCode'); //accountCode

        $PONumber =          $this->input->post('PONumber');
        $PODate =            $this->input->post('PODate');
        $POAmount =          $this->input->post('POAmount');
        $ProformaInvoice =   $this->input->post('ProformaInvoice');

        $CommercialInvoice = $this->input->post('CommercialInvoice');
       
        $CompanyCode =       $this->input->post('CompanyCode');
        $FinalInvoice =      $this->input->post('FinalInvoice');

        $CreditNote =        $this->input->post('CreditNote');
        $DebitNote =         $this->input->post('DebitNote');
        $WireTransferFee =   $this->input->post('WireTransferFee');

        $remarks = $this->input->post('remarks');

        $RFP = $this->input->post('rfp');

        

        $terms = $this->input->post('accCurrency');//paymentTerms

        if($this->session->userdata('empName')){

            $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }




        
        $ex = explode(',',$accterm);
        $accCode = $ex[0]; //actCode
        $accCurrency = $ex[1];
        $paymentTermCode = $ex[2]; //currency

  

        $inputs = array (
            $vendorCode,
            $accCode,
            $paymentTermCode,
            $accCurrency,
            $PONumber,
            $PODate,
            $POAmount,
            // $terms,
            $CompanyCode,
            $RFP
        );
        
        //check if it has value the required fields
        if(in_array('', $inputs))
        {
              $resp = array(
                'status'  => 0,
                'message' => 'Please input all fields'
              );

              echo json_encode($resp);
        }

        // if blank the final invoice and proforma
        else if($FinalInvoice == '' && $ProformaInvoice == '')
        {
            $checkPOnumberAndDateExistDB = $this->telegraphicTransferModel->checkIfPoNumAndDateExistDB($PONumber, $vendorCode);

            if($checkPOnumberAndDateExistDB)
            {
                $resp = array(
                    'status'  => 1,
                    'message' => 'Vendor and PO number is already exist in database'
                );

                echo json_encode($resp);
            }

            else
            {
                $data = array(
                    'vendorCode'        => $vendorCode,
                    'accountCode'       => $accCode,
                    'paymentTermCode'   => $paymentTermCode,
                    'accountCurrency'   => $terms,
                    'PONumber'          => $PONumber,
                    'PODate'            => $PODate,
                    'POAmount'          => $POAmount,
                    'proformaInvoice'   => $ProformaInvoice,
                    'commercialInvoice' => $CommercialInvoice,
                    'compCode'          => $CompanyCode,
                    'finalInvoice'      => $FinalInvoice,
                    'creditNote'        => $CreditNote,
                    'debitNote'         => $DebitNote,
                    'wireTransferFee'   => $WireTransferFee,
                    'remarks'           => $remarks,
                    'rfp'               => $RFP,
                    'userCreated'       => $session_user,
                    'dateCreated'       => date('Y-m-d'),
                    'status'            => 'O'
                );

                // var_dump($data);
                // exit();
    
                $insertToDB = $this->telegraphicTransferModel->insertTelegraphicTransfer_tempTBL($data);
    
                if($insertToDB)
                {
                    $resp = array(
                        'status'  => 3,
                        'message' => 'Successfully Inserted!',
                        'data' => $data
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

        //if blank once
        else if($FinalInvoice == '' || $ProformaInvoice == '')
        {
            $checkPOnumberAndDateExistDB = $this->telegraphicTransferModel->checkIfPoNumAndDateExistDB($PONumber, $vendorCode);
            
            if($checkPOnumberAndDateExistDB)
            {
                $resp = array(
                    'status'  => 1,
                    'message' => 'Vendor and PO number is already exist in database'
                );

                echo json_encode($resp);
            }

            else
            {
                $checkProformaFinalInvoices = $this->telegraphicTransferModel->checkProformaAndFinalInvoice($ProformaInvoice, $FinalInvoice, $PONumber);

                if($checkProformaFinalInvoices)
                {
                    $resp = array(
                        'status'    => 2,
                        'message'   => 'Proforma Invoice or Final Invoice already exist in Database'
                    );
    
                    echo json_encode($resp);
                }

                else
                {
                    $data = array(
    
                        'vendorCode'        => $vendorCode,
                        'accountCode'       => $accCode,
                        'paymentTermCode'   => $paymentTermCode,
                        'accountCurrency'   => $terms,
                        'PONumber'          => $PONumber,
                        'PODate'            => $PODate,
                        'POAmount'          => $POAmount,
                        'proformaInvoice'   => $ProformaInvoice,
                        'commercialInvoice' => $CommercialInvoice,
                        'compCode'          => $CompanyCode,
                        'finalInvoice'      => $FinalInvoice,
                        'creditNote'        => $CreditNote,
                        'debitNote'         => $DebitNote,
                        'wireTransferFee'   => $WireTransferFee,
                        'remarks'           => $remarks,
                        'rfp'               => $RFP,
                        'userCreated'       => $session_user,
                        'dateCreated'       => date('Y-m-d'),
                        'status'            => 'O'
                    );

    
        
                    $insertToDB = $this->telegraphicTransferModel->insertTelegraphicTransfer_tempTBL($data);
        
                    if($insertToDB)
                    {
                        $resp = array(
                            'status'  => 3,
                            'message' => 'Successfully Inserted!',
                            'data' => $data
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
        } 
        
        else
        {
            $checkPOnumberAndDateExistDB = $this->telegraphicTransferModel->checkIfPoNumAndDateExistDB($PONumber, $vendorCode);

            if($checkPOnumberAndDateExistDB)
            {
                $resp = array(
                    'status'  => 1,
                    'message' => 'Vendor and PO number is already exist in database'
                );

                echo json_encode($resp);
            }

            else
            {
                $data = array(
                    'vendorCode'        => $vendorCode,
                    'accountCode'       => $accCode,
                    'paymentTermCode'   => $paymentTermCode,
                    'accountCurrency'   => $terms,
                    'PONumber'          => $PONumber,
                    'PODate'            => $PODate,
                    'POAmount'          => $POAmount,
                    'proformaInvoice'   => $ProformaInvoice,
                    'commercialInvoice' => $CommercialInvoice,
                    'compCode'          => $CompanyCode,
                    'finalInvoice'      => $FinalInvoice,
                    'creditNote'        => $CreditNote,
                    'debitNote'         => $DebitNote,
                    'wireTransferFee'   => $WireTransferFee,
                    'remarks'           => $remarks,
                    'rfp'               => $RFP,
                    'userCreated'       => $session_user,
                    'dateCreated'       => date('Y-m-d'),
                    'status'            => 'O'
                );

    
                $insertToDB = $this->telegraphicTransferModel->insertTelegraphicTransfer_tempTBL($data);
                
    
                if($insertToDB)
                {
                    $resp = array(
                        'status'  => 3,
                        'message' => 'Successfully Inserted!',
                        'data' => $data
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

  


        
    }

    public function fetchTTSDATAmodal()
    {
        $telCode =      $this->input->post('code');

        $fetchInModal = $this->telegraphicTransferModel->fetchTTSdataInModal($telCode);

        echo json_encode($fetchInModal);
    }

    public function fetchTTSDataPayment()
    {
        $telcode = $this->input->post('telCode');

        $fetch = $this->telegraphicTransferModel->fetchTTSDataforPayment($telcode);

        echo json_encode($fetch);
    }

    public function updateTTSDATA()
    {
        $telcode = $this->input->post('updateTelCode');

        $vendorCode =           $this->input->post('updateVendorCode');
        $accCode =              $this->input->post('updateaccCode');
        $paymentTermCode =      $this->input->post('updatepaymentTermCode');
        $accCurrency =          $this->input->post('updateaccCurrency');
        $PONumber =             $this->input->post('updatePONumber');
        $PODate =               $this->input->post('updatePODate');
        $POAmount =             $this->input->post('updatePOAmount');
        $ProformaInvoice =      $this->input->post('updateProformaInvoice');
        $CommercialInvoice =    $this->input->post('updateCommercialInvoice');
        $RFPreference =         $this->input->post('updateRFPreference');
        $CompanyCode =          $this->input->post('updateCompanyCode');
        $FinalInvoice =         $this->input->post('updateFinalInvoice');
        $CreditNote =           $this->input->post('updateCreditNote');
        $DebitNote =            $this->input->post('updateDebitNote');
        $WireTransferFee =      $this->input->post('updateWireTransferFee');

        $inputs = array (
            $vendorCode,
            $accCode,
            $paymentTermCode,
            $accCurrency,
            $PONumber,
            $PODate,
            $POAmount,
            $ProformaInvoice,
            $CommercialInvoice,
            $RFPreference,
            $CompanyCode,
            $FinalInvoice,
            $CreditNote,
            $DebitNote,
            $WireTransferFee
        );

        if(in_array('', $inputs))
        {
            $resp = array(
                'stat' => 0,
                'mess' => 'Please input all fields'
            );

            echo json_encode($resp);
        }

        else
        {
            $data = array(
                'vendorCode'        => $vendorCode,
                'accountCode'       => $accCode,
                'paymentTermCode'   => $paymentTermCode,
                'accountCurrency'   => $accCurrency,
                'PONumber'          => $PONumber,
                'PODate'            => $PODate,
                'POAmount'          => $POAmount,
                'proformaInvoice'   => $ProformaInvoice,
                'commercialInvoice' => $CommercialInvoice,
                'rfpReference'      => $RFPreference,
                'compCode'          => $CompanyCode,
                'finalInvoice'      => $FinalInvoice,
                'creditNote'        => $CreditNote,
                'debitNote'         => $DebitNote,
                'wireTransferFee'   => $WireTransferFee
            );

            $updateTTS = $this->telegraphicTransferModel->updateTTSdata($telcode, $data);

            if($updateTTS)
            {
                $resp = array(
                    'status' => 1,
                    'message' => 'Successfully updated'
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

    public function populateVendorToAccount()
    {
        $vendor = $this->input->post('v');

        $populate = $this->telegraphicTransferModel->getValueAcc($vendor);


        echo json_encode($populate);
   
    }

    public function populateAccToCurrency()
    {
        $accCode = $this->input->post('a');

        $populate = $this->telegraphicTransferModel->getValueCurrency($accCode);


        echo json_encode($populate);
    }

    public function generateExel()
    {
        $this->excel->setActiveSheetIndex(0);

        $this->excel->getActiveSheet()->setTitle('Telegraphic Transfer');

            // Define the header
            $header = array(
            'Vendor Name',
            'Account Code',
            'Currency',
            'Payment term',
            'PO Number',
            'PO Date',
            'PO Amount',
            'Proforma Invoice',
            'Commercial Invoice',
            'RFP Reference',
            'Company',
            'Final Invoice',
            'Credit Note',
            'Debit Note',
            'Wire Transfer Fee',
            );

        $data = $this->telegraphicTransferModel->generateExcel();

        $this->excel->getActiveSheet()->fromArray([$header]);

        $this->excel->getActiveSheet()->fromArray($data, null, 'A2'); // Start from cell A2

        $filename='TTS.xls';

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="'.$filename.'"');
        
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

        $objWriter->save('php://output');

        exit();
    }

    public function upload_file()
    {
        $config['upload_path'] = FCPATH . 'uploadExcelFile/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|xls|csv';

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload('userfile'))
        {
            $error = $this->upload->display_errors();
            
            $response = array(
                's' => 0,
                'm' => $error
            );

            echo json_encode($response);
        }

        else
        {  
             $upload_data = $this->upload->data();

             $file_data = array(
                'file_name' => $upload_data['file_name'],
                'file_path' => 'uploadExcelFile/' . $upload_data['file_name']
             );
            
            $insert = $this->telegraphicTransferModel->uploadFile($file_data);

            if ($insert)
            {
                $response = array(
                    'status'    => 1,
                    'message'   => 'File successfully uploaded and saved in the database.'
                );
                
                echo json_encode($response);
            } 
            
            else
            {
                $response = array(
                    'status'    => 2,
                    'message'   => 'File uploaded, but database insertion failed.'
                );
                
                echo json_encode($response);
            }
        }


    }
    
    public function readExcelFile()
    {
        if ($_FILES['userfile']['error'] == UPLOAD_ERR_OK)
        {
            $file_path = $_FILES['userfile']['tmp_name'];

            // Load the Excel file
            $objPHPExcel = PHPExcel_IOFactory::load($file_path);

            $worksheet = $objPHPExcel->getActiveSheet();

            $file_data = $worksheet->toArray();

            array_shift($file_data);

            foreach ($file_data as $data) {
                $record = array(
                    'vendorName'        => $data[0],
                    'account'           => $data[1],
                    'paymentTerm'       => $data[2],
                    'currency'          => $data[3],
                    'PoNumber'          => $data[4],
                    'PoDate'            => $data[5],
                    'PoAmount'          => $data[6],
                    'proformaInvoice'   => $data[7],
                    'commercialInvoice' => $data[8],
                    'rfpReference'      => $data[9],
                    'compCode'          => $data[10],
                    'finalInvoice'      => $data[11],
                    'creditNote'        => $data[12],
                    'debitNote'         => $data[13],
                    'wireTransferFee'   => $data[14]
                );

                $res = $this->telegraphicTransferModel->readExcelFile($record);

                }

                if($res)
                {
                    $response = array(
                        'status'  => 1,
                        'message' => 'Data inserted successfully.'
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
            
            else 
            {
                echo '<script>alert(error")</script>';
            }
    }

    public function InsertPayment()
    {

        
        if($this->session->userdata('empName')){

        $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }

        $paymentVendor = $this->input->post('Pvendor');
        $paymentPONumber = $this->input->post('PPONum');
        $paymentPODate = $this->input->post('PPODate');
        $paymentPOAmount = $this->input->post('PPOAmount');
        $paymentType = $this->input->post('PpaymentType');
        $amount = $this->input->post('amount');
        $total = $this->input->post('balance');
        $rfpPayment = $this->input->post('rfpPayments');

        $date = $this->input->post('date');

        $PaymentAccountCode = $this->input->post('AccountCode');
        $PaymentCurrency = $this->input->post('Currency');
        $PaymentProformaInvoice = $this->input->post('ProformaInvoice');
        $PaymentFinalInvoice = $this->input->post('FinalInvoice');
        $PaymentCompCode = $this->input->post('CompCode');

        $remarks = $this->input->post('remarks');

        $remarksInitialPay = $this->input->post('remarksFirstPay');

        $rfp = $this->input->post('rfps');

        

        if($amount == '' || $rfpPayment == '')
        {
            $response = array(
                'status'    => 0,
                'message'   => 'Please input required fields'
            );

            echo json_encode($response);
        }


        //if amount is higher than po amount
        else if($amount > $paymentPOAmount)
        {
            $response = array(
                'status'    => 1,
                'message'   => 'Your amount is higher than your PO Amount'
            );

            echo json_encode($response);
        }

        //initial payment
        else if($amount < $paymentPOAmount)
        {
                $total = $paymentPOAmount - $amount;
    
                $data = array(
                    'Vendor'        => $paymentVendor,
                    'PO_number'     => $paymentPONumber,
                    'PO_date'       => ($paymentPODate),
                    'PO_amount'     => $paymentPOAmount,
                    'payment_type'  => 1,
                    'amount'        => $amount,
                    'change'        => 0,
                    'updated_total_payment' => $amount,
                    'total_balance' => $total,
                    'total_payment' => $amount,
                    'total_paid_initial'  => $total,
                    'rfp'           => $rfpPayment,
                    'remarks'       => $remarksInitialPay,
                    'date'          => date('Y-m-d H:i:s', strtotime($date)),
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user,
                );

                // var_dump($data);
                // exit();
             

                //insert tbl payment
                $insert = $this->telegraphicTransferModel->insertPaymentTbl($data);



                $dataToMainTable = array(
                    'vendorCode'        => $paymentVendor,
                    'accountCode'       => $PaymentAccountCode,
                    'paymentTermCode'   => $PaymentCurrency,
                    'accountCurrency'   => 1,
                    'PONumber'          => $paymentPONumber,
                    'PODate'            => $paymentPODate,
                    'POAmount'          => $paymentPOAmount,
                    'proformaInvoice'   => $PaymentProformaInvoice,
                    'finalInvoice'      => $PaymentFinalInvoice,
                    'compCode'          => $PaymentCompCode,
                    'rfp'               => $rfp,
                    'remarks'           => $remarks,
                    'userCreated'       => $session_user,
                    'dateCreated'       => date('Y-m-d'),
                    'status'            => 'O',
                    'updated_balanced'   => $total,
                    'updated_adjustment_deduction_amt'  => 0,
                    'updated_paid_amount'  => $amount,
              
                );

                // var_dump($dataToMainTable);
                // exit();

                // $d = array(
                //     'otherPONumber' => $paymentPONumber,
                //     'transAmt' => $total
                // );

                //insert to other tbl 
                // $insertOtherPaymentTBL = $this->telegraphicTransferModel->insertCurrentBalanceToOtherPaymentTbl($d);

                // insert to main tbl
                $insertToMainTable = $this->telegraphicTransferModel->insertTelegraphicTransfer_mainTBL($dataToMainTable);

                if($insert)
                {
                    $response = array(
                        'status'  => 2,
                        'message' => 'Initial payment success',
                        // 'data_set'  => $insertToMainTable
                    );

                    echo json_encode($response);
                }

                else
                {
                    $response = array(
                        'message' => 'something wrong'
                    );

                    echo json_encode($response);
                }
            
        }

        //full payment
        else if($amount == $paymentPOAmount)
        {
                $total = $paymentPOAmount - $amount;
    
                $data = array(
                    'Vendor'        => $paymentVendor,
                    'PO_number'     => $paymentPONumber,
                    'PO_date'       => date('Y-m-d H:i:s', strtotime($paymentPODate)),
                    'PO_amount'     => $paymentPOAmount,
                    'payment_type'  => 2,
                    'amount'        => $amount,
                    'updated_total_payment' => $total,
                    'change'        => 0,
                    'total_balance' => $total,
                    'total_payment' => $amount,
                    'total_paid_initial'    => $total,
                    'rfp'           => $rfpPayment,
                    'date'          => date('Y-m-d H:i:s', strtotime($date)),
                    'remarks'       => $remarksInitialPay,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user,
                
                );

                // var_dump($data);
                // exit();

                //insert tbl payment
                $insert = $this->telegraphicTransferModel->insertPaymentTbl($data);
              
                $dataToMainTable = array(
                    'vendorCode'        => $paymentVendor,
                    'accountCode'       => $PaymentAccountCode,
                    'paymentTermCode'   => $PaymentCurrency,
                    'accountCurrency'   => 2,
                    'PONumber'          => $paymentPONumber,
                    'PODate'            => $paymentPODate,
                    'POAmount'          => $paymentPOAmount,
                    'proformaInvoice'   => $PaymentProformaInvoice,
                    'finalInvoice'      => $PaymentFinalInvoice,
                    'compCode'          => $PaymentCompCode,
                    'rfp'               => $rfp,
                    'remarks'           => $remarks,
                    'userCreated'       => $session_user,
                    'dateCreated'       => date('Y-m-d'),
                    'status'            => 'C',
                    'updated_adjustment_deduction_amt'  => 0,
                    'updated_balanced'  => $total,
                    'updated_paid_amount'  => $amount,
                );

                // var_dump($dataToMainTable);
                // exit();


                //after full payment it will transfer to history tbl
                $insertToHistoryTBL = $this->telegraphicTransferModel->insertHistoryTBL($dataToMainTable);

                // insert to main tbl
                // $insertToMainTable = $this->telegraphicTransferModel->insertTelegraphicTransfer_mainTBL($dataToMainTable);

                if($insert)
                {
                    $response = array(
                        'status'    => 3,
                        // 'message'   => 'Success'
                        'message' => 'Paid. This transaction is automatically tag as closed and transfer to historical data.',
                        // 'data_set'  => $insertToMainTable
                    );

                    echo json_encode($response);
                }

                else
                {
                    $response = array(
                        'message' => 'something wrong'
                    );

                    echo json_encode($response);
                }

        }

        else
        {

            $response = array(
                'status'  => 4,
                'message' => 'Opss Something wrong, please check your payment',
                // 'data_set'  => $insertToMainTable
            );

            echo json_encode($response);
        }



    }

    public function fetchdataPayment()
    {
        $PONumber = $this->input->post('ponumber');
        $vendorCode = $this->input->post('vendorCode');

        $fetch = $this->telegraphicTransferModel->fetchtblPayment($PONumber, $vendorCode);


        echo json_encode($fetch);
    }

    public function firstcompute()
    {
        $PONumber = $this->input->post('poNum');

        $total = $this->telegraphicTransferModel->firstComputation($PONumber);

        echo json_encode($total);
    }

    public function fetchInitialPayment()
    {
        $PO_number = $this->input->post('PO_number');

        $vendorCode = $this->input->post('vendorCode');

        $fetchInitial = $this->telegraphicTransferModel->fetchInitialPaymentModel($PO_number, $vendorCode);

        echo json_encode($fetchInitial); 
    }

    public function fetchInitialPaymentData()
    {
        $PO_number = $this->input->post('ponumber');

        $vendorCode = $this->input->post('vendorCode');

        $fetchInitial = $this->telegraphicTransferModel->fetchTTSDataForInitial($PO_number, $vendorCode);

        echo json_encode($fetchInitial); 
    }

    public function updateInitialPay()
    {   
        $vendor         = $this->input->post('vendor');
        $PO_number      = $this->input->post('PO_number');
        $PO_date        = $this->input->post('PO_date');
        $PO_amount      = $this->input->post('PO_amount');
        $total_payment  = $this->input->post('total_payment');
        $total_balance  = $this->input->post('total_balance');
        $paymentType    = $this->input->post('paymentType');
        $amount         = $this->input->post('amount');

        $totalPaymentIfAddAnother = $this->input->post('totalInitial');
        
        $InitialPaymentLatest = $this->input->post('InitialPaymentL');

        $remarks = $this->input->post('remarks');

        $date = $this->input->post('date');

        $rfp = $this->input->post('rfp');


        //history
        $vendor = $this->input->post('historyvendor');
        $account = $this->input->post('historyaccount');
        $currency = $this->input->post('historycurrency');
        $accountCurrency = $this->input->post('historyaccountCurrency');
        $POnumber = $this->input->post('historyPOnumber');
        $POdate = $this->input->post('historyPOdate');
        $POamt = $this->input->post('historyPOamt');
        $proformaInvoice = $this->input->post('historyproformaInvoice');
        $company_name = $this->input->post('historycompany_name');
        $finalInvoice = $this->input->post('historyfinalInvoice');
        $historyRemarks = $this->input->post('hisRemarks');
        $status = 'C';


        if($this->session->userdata('empName')){

            $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }
 
        // IF DONT HAVE VALUE THE AMOUNT
        if($amount == '')
        {
            $response = array(
                'status'  => 3,
                'message' => 'Please input amount'
            );

            echo json_encode($response);
        }

        else if(empty($rfp))
        {
            $response = array(
                'status'  => 3.1,
                'message' => 'Please input rfp'
            );

            echo json_encode($response);
        }

        else
        {   
            // IF TOTAL BALANCE ALREADY 0
            if($total_balance == "0")
            {
                $response = array(
                    'status'  => 0,
                    'message' => 'You already paid all your balance.'
                );
    
                echo json_encode($response);
            }
    
            else
            {   
                //IF AMOUNT IS HIGHER THAN YOOUR BALANCE
                if($amount > $total_balance)
                {
                    $response = array(
                        'status'  => 5,
                        'message' => 'Your amount is higher than your balance.'
                    );
        
                    echo json_encode($response);
                }

                // IF AMOUNT IS EQUAL TO BALANCE
                else if($amount == $total_balance)
                {
                    $paid = $total_balance - $amount;

                    $updateInitialPayment = $amount + $InitialPaymentLatest;

                    $tot1 = $totalPaymentIfAddAnother + $amount;

                    // var_dump($paid);
                    // var_dump($updateInitialPayment);
                    // var_dump($tot1);
                    // exit();

                    $data = array(
                        'Vendor'        => $vendor,
                        'PO_number'     => $PO_number,
                        'PO_date'       => $PO_date,
                        'PO_amount'     => $PO_amount,
                        'total_payment' => $amount,
                        'total_balance' => $paid,
                        'updated_total_payment' => $updateInitialPayment,
                        'change'        => 0,
                        'payment_type'  => 2,
                        'amount'        => $amount,
                        'total_paid_initial'    => $tot1,
                        'updated_total_payment' => 0,
                        'remarks'       => $remarks,
                        'date'          => date('Y-m-d H:i:s', strtotime($date)),
                        'rfp'           => $rfp,
                        'date_created'  => date('Y-m-d H:i:s'),
                        'user_created'  => $session_user
                    );

                    $insertTBLhistory = array(
                        'vendorCode'        => $vendor,
                        'accountCode'       => $account,
                        'paymentTermCode'   => $currency,
                        'accountCurrency'   => $accountCurrency,
                        'PONumber'          => $POnumber,
                        'PODate'            => $POdate,
                        'POAmount'          => $POamt,
                        'proformaInvoice'   => $proformaInvoice,
                        'compCode'          => $company_name,
                        'finalInvoice'      => $finalInvoice,
                        'rfp'               => $rfp,
                        'status'            => $status,
                        'userCreated'       => $session_user,
                        'dateCreated'       => date('Y-m-d'),
                        'updated_balanced'  =>  $paid,
                        'updated_paid_amount' => $updateInitialPayment,
                        'remarks'           => $historyRemarks
                    );

                    // var_dump($data);
                    // var_dump($insertTBLhistory);
                    // exit();

                    //update payment
                    $updateInitialPayment = $this->telegraphicTransferModel->updateInitialPayment($data);

                    $d = array(
                        'transAmt' => $paid
                    );

                    //updateTotalBalancedMainTBL
                    $e = array(
                        'updated_balanced' => $paid
                    );

                    $f = array(
                        'updated_paid_amount' => $paid
                    );




                    //updateRemaining balance in other payment tbl after full payment
                    $updateTotalBalanceInOtherPayment = $this->telegraphicTransferModel->updateTotalBalanceInOtherPayment($POnumber, $vendor, $d);

                    $updateTotalBalancedMaintbl = $this->telegraphicTransferModel->updateTotalBalancedMainTbl($PO_number, $vendor, $e);
                    
                    $updateTotalPaymentMainTbl = $this->telegraphicTransferModel->updateTotalPaymentMainTbl($PO_number, $vendor, $f);

                    //insert to tbl history
                    $insertTBLhist = $this->telegraphicTransferModel->insertHistoryTBL($insertTBLhistory);

                    //truncate the data from the main tbl
                    $deleteToMainTBL = $this->telegraphicTransferModel->truncateTBLTelegraphicTransfer($PO_number, $vendor);

                    $updateStats = $this->telegraphicTransferModel->updateStatusOfTTS($PO_number, $vendor);


                    $response = array(
                        'status'  => 'D',
                        'message' => 'Paid. This transaction is automatically tag as closed and transfer to historical data.'
                    );

                    echo json_encode($response);
                }

                else
                {
                    // less the total balance to amount
                    $tot = $total_balance - $amount;

                    $updateInitialPayment = $amount + $InitialPaymentLatest;
                    
                 
                    // update the initial payment
                    $tot1 = $totalPaymentIfAddAnother + $amount;

                    // var_dump($tot);
                    // var_dump($updateInitialPayment);
                    // var_dump($tot1);
                    // exit();
              
                    $data = array(
                        'Vendor'        => $vendor,
                        'PO_number'     => $PO_number,
                        'PO_date'       => $PO_date,
                        'PO_amount'     => $PO_amount,
                        'total_payment' => $amount,
                        'total_balance' => $tot,
                        'updated_total_payment' => $updateInitialPayment,
                        'change'        => 0,
                        'payment_type'  => $paymentType,
                        'amount'        => $amount,
                        'total_paid_initial'    => $tot1,
                        'remarks'       => $remarks,
                        'date'          => date('Y-m-d H:i:s', strtotime($date)),
                        'rfp'           => $rfp,
                        'date_created'  => date('Y-m-d H:i:s'),
                        'user_created'  => $session_user
                    );

                    // var_dump($data);
                    // exit();

                    $d = array(
                        'transAmt' => $tot
                    );

                    //updateTotalBalancedMainTBL
                    $e = array(
                        'updated_balanced' => $tot
                    );

                    $f = array(
                        'updated_paid_amount' => floatval($updateInitialPayment)
                    );

                    
                    $updateRemainBal = $this->telegraphicTransferModel->updateTotalBalanceInOtherPayment($PO_number, $vendor, $d);

                    $updateTotalBalancedMaintbl = $this->telegraphicTransferModel->updateTotalBalancedMainTbl($PO_number, $vendor, $e);
                    
                    $updateTotalPaymentMainTbl = $this->telegraphicTransferModel->updateTotalPaymentMainTbl($PO_number, $vendor, $f);

                    //update tbl payment
                    $updateInitialPayment = $this->telegraphicTransferModel->updateInitialPayment($data);
       

                                        
                    if($updateInitialPayment)
                    {
                        $response = array(
                            'status'  => 1,
                            'message' => 'Payment done.'
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
            }
        }
    }

    public function viewFullpayment()
    { 
        $PO_number = $this->input->post('PO_number');

        $viewFullPayment = $this->telegraphicTransferModel->ViewFullPayment($PO_number);

        echo json_encode($viewFullPayment);
        
    }

    public function insertInitialOtherTransaction()
    {

        
        if($this->session->userdata('empName')){

            $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }

        $trans_type = $this->input->post('trans_type');
        $vendor = $this->input->post('vendor');
        $po_number = $this->input->post('po_number');
        $po_date = $this->input->post('po_date');
        $referenceNo = $this->input->post('referenceNo');
        $po_amount = $this->input->post('po_amount');
        $remarks = $this->input->post('remarks');
        $deduc_type = $this->input->post('deduc_type');
        $amount = $this->input->post('amount');

        $transact2 = $this->input->post('transact2');

        $rfp = $this->input->post('rfp');

        $total_balance_initialPay = $this->input->post('total_balance_initialPay');
        
        $PaymentAccountCode = $this->input->post('AccountCode');
        $PaymentCurrency = $this->input->post('Currency');
        $PaymentProformaInvoice = $this->input->post('ProformaInvoice');
        $PaymentFinalInvoice = $this->input->post('FinalInvoice');
        $PaymentCompCode = $this->input->post('CompCode');

        //check if amount has value
        if($amount == '' || $referenceNo == '' || $rfp == '')
        {
            $resp = array(
                'stats'     => '1',
                'message'   => 'Please input required fields'
            );

            echo json_encode($resp);
        }


        //if amount higher than po amount
   

        //Over payment -less
        else if($transact2 == 1)
        {
            //make sure the type is adjustment
            if($trans_type == 1)
            {
                $resp = array(
                    'stats'     => '4',
                    'message'   => 'Make sure you choose Deduction type'
                );

                echo json_encode($resp);
            }

            else
            {

                $checkIfReferenceNoFirst = $this->telegraphicTransferModel->checkIfReferenceNoExisting($referenceNo, $po_number);


                //check if reference no is already exist in database
                if($checkIfReferenceNoFirst)
                {
                    $resp = array(
                        'stats'     => '5',
                        'message'   => 'The Vendor and Reference No. already exist in the database.'
                    );
    
                    echo json_encode($resp); 
                }

                else if ($amount == 0)
                {
                    $resp = array(
                        'stats'     => '2',
                        'message'   => 'Your amount is 0'
                    );
        
                    echo json_encode($resp);
                }

                else
                {
                    $total = $po_amount - $amount;


                    $dataInsertOtherPayment = array(
                    'otherTransTypeCode'    => $trans_type,
                    'otherVendorCode'       => $vendor,
                    'otherPOAmount'         => $po_amount,
                    'otherPONumber'         => $po_number,
                    'otherPODate'           => date('Y-m-d', strtotime($po_date)),
                    'referenceNumber'       => $referenceNo,
                    'transactionCode'       => $transact2,
                    'transAmt'              => $total_balance_initialPay,
                    'Remarks'               => $remarks,
                    'otherTotalDeduc'       => $amount,
                    'updated_deduct_adjustment' => $total,
                    'amount'               => $po_amount,
                    'total'                 => $total,
                    'rfp'                   => $rfp,
                    'userCreated'           => $session_user,
                    'dateCreated'           => date('Y-m-d H:i:s'),
                    );

                    // var_dump($dataInsertOtherPayment);
                    // exit();
      

                    $d = array(
                        'updated_total_payment' => $total
                        );

                    $updatePaidAmt = array(
                        'updated_paid_amount'  => $total
                        );
                    
                    $updateAdjustment_deduction = array(
                        'updated_adjustment_deduction_amt' => $amount
                        );

                    //update total balance in tbl payment
                    $updateTotalBalanceTblPayment = $this->telegraphicTransferModel->updateTotalBalanceIfAddOtherPayment($po_number, $d, $vendor);
                    
                    $updatePaidAmtTblPayment = $this->telegraphicTransferModel->updateTotalPaymentMainTbl($po_number, $vendor, $updatePaidAmt);

                    $updatedAdjustmentDeductionMainTbl = $this->telegraphicTransferModel->updatedAdjustmentDeductionMainTbl($po_number, $vendor, $updateAdjustment_deduction);
    
                    $inserOtherPayment = $this->telegraphicTransferModel->insertOtherPayment($dataInsertOtherPayment);
    
    
                    if($inserOtherPayment)
                    {
                        $resp = array(
                            'stats'     => '6',
                            'message'   => 'Success deduction of Over payment'
                        );

                        echo json_encode($resp);
                    }
                    
                    else
                    {
                        $resp = array(
                            'message'   => 'error'
                        );

                        echo json_encode($resp);
                    }

                }

                
            }
        }

        //Short payment -add
        else if($transact2 == 2)
        {
            //make sure the type is adjustment
            if($trans_type == 2)
            {
                $resp = array(
                    'stats'     => '4',
                    'message'   => 'Make sure you choose Additional type'
                );

                echo json_encode($resp);
            }

            else
            {

                $checkIfReferenceNoFirst = $this->telegraphicTransferModel->checkIfReferenceNoExisting($referenceNo, $po_number);


                //check if reference no is already exist in database
                if($checkIfReferenceNoFirst)
                {
                    $resp = array(
                        'stats'     => '5',
                        'message'   => 'The Vendor and Reference No. already exist in the database.'
                    );
    
                    echo json_encode($resp); 
                }

                else if ($amount > $po_amount)
                {
                    $resp = array(
                        'stats'     => '3',
                        'message'   => 'Invalid amount'
                    );
        
                    echo json_encode($resp);
                }

                else if ($amount == 0)
                {
                    $resp = array(
                        'stats'     => '2',
                        'message'   => 'Your amount is 0'
                    );
        
                    echo json_encode($resp);
                }

                else
                {
                    $total = $po_amount + $amount;

                    $dataInsertOtherPayment = array(
                    'otherTransTypeCode'    => $trans_type,
                    'otherVendorCode'       => $vendor,
                    'otherPOAmount'         => $po_amount,
                    'otherPONumber'         => $po_number,
                    'otherPODate'           => date('Y-m-d', strtotime($po_date)),
                    'referenceNumber'       => $referenceNo,
                    'transactionCode'       => $transact2,
                    'transAmt'              => $total_balance_initialPay,
                    'Remarks'               => $remarks,
                    'otherTotalDeduc'       => $amount,
                    'updated_deduct_adjustment' => $total,
                    'amount'                => $po_amount,
                    'total'                 => $total,
                    'rfp'                   => $rfp,
                    'userCreated'           =>  $session_user,
                    'dateCreated'           => date('Y-m-d H:i:s'),
                    );

                        
                    $d = array(
                        'updated_total_payment' => $total
                        );

                    $updatePaidAmt = array(
                        'updated_paid_amount'  => $total
                    );
                    
                    $updateAdjustment_deduction = array(
                        'updated_adjustment_deduction_amt' => $amount
                        );

                    //update total balance in tbl payment
                    $updateTotalBalanceTblPayment = $this->telegraphicTransferModel->updateTotalBalanceIfAddOtherPayment($po_number, $d, $vendor);

                    $updatePaidAmtTblPayment = $this->telegraphicTransferModel->updateTotalPaymentMainTbl($po_number, $vendor, $updatePaidAmt);

                    $updatedAdjustmentDeductionMainTbl = $this->telegraphicTransferModel->updatedAdjustmentDeductionMainTbl($po_number, $vendor, $updateAdjustment_deduction);
    
                    $inserOtherPayment = $this->telegraphicTransferModel->insertOtherPayment($dataInsertOtherPayment);
    
    
                    if($inserOtherPayment)
                    {
                        $resp = array(
                            'stats'     => '6',
                            'message'   => 'Success Adjustment of short payment'
                        );

                        echo json_encode($resp);
                    }
                    
                    else
                    {
                        $resp = array(
                            'message'   => 'error'
                        );

                        echo json_encode($resp);
                    }

                }

                
            }
        }


    }

    public function insertInitialOtherTransactNONPO()
    {
        $vendor = $this->input->post('VendorPaymentNONPO');
        $po_number = $this->input->post('PaymentNONPO');
        $date = $this->input->post('DateNONPO');
        $transact_type = $this->input->post('TransactTypeNONPO');
        $transaction = $this->input->post('TrasactionNONPO');
        $reference_no = $this->input->post('ReferenceNoNONPO');
        $remarks = $this->input->post('RemarksNONPO');
        $rfp = $this->input->post('RFPNONPO');
        $amount = $this->input->post('AmountNONPO');
        $amount2 = $this->input->post('Amount2');


        if($this->session->userdata('empName')){

            $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }

          

        $inputs = array(
          
            $date,
            $transact_type,
            $transaction,
            $reference_no,
            $rfp,
            $amount,
            $amount2
        );
        
        //check if it has value the required fields
        if(in_array('', $inputs))
        {
            $response = array(
                'status'    => 1,
                'message'   => 'Please input all required fields'
            );

            echo json_encode($response);
        }

        else if($amount == 0)
        {
            $response = array(
                'status'    => 1.1,
                'message'   => 'Your amount is 0'
            );

            echo json_encode($response);
        }
        

        //CLAIMS - LESS
        else if($transaction == 1)
        {
            if($transact_type == 1)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Opps please select deduction type'
                );

                echo json_encode($resp);
            }

            else
            {
      
                $checkIfExistRefNo = $this->telegraphicTransferModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
        
           
                if($checkIfExistRefNo)
                {
                    $resp = array(
                        'status'    => 1.3,
                        'message'   => 'Reference No. exist in database'
                    );
    
                    echo json_encode($resp);
    
                }

                else if($amount > $amount2)
                {
                    $resp = array(
                        'status'    => 1.4,
                        'message'   => 'Your payment is higher than your amount'
                    );
    
                    echo json_encode($resp);
    
                }

                else
                {
                    $totals = $amount2 - $amount;

                    $data = array(
                        'po_number'     => $po_number,
                        'vendor'        => $vendor,
                        'date'          => $date,
                        'transact_type' => $transact_type,
                        'transaction'   => $transaction,
                        'reference_no'  => $reference_no,
                        'remarks'       =>  $remarks,
                        'rfp'           => $rfp,
                        'amount'        => $amount,
                        'amount2'       => $amount2,
                        'total'         => $totals,
                        'date_created'  => date('Y-m-d H:i:s'),
                        'user_created'  => $session_user
                    );

                    // var_dump($data);
                    // exit();

                    $insertTblOtherTransactNonPO = $this->telegraphicTransferModel->insertTBLOtherPaymentNONPO($data);

                    if($insertTblOtherTransactNonPO)
                    {
                        $response = array(
                            'status'    => 2,
                            'message'   => 'Success'
                        );

                        echo json_encode($response);
                    }

                    else
                    {
                        $response = array(

                            'message'   => 'Error'
                        );

                        echo json_encode($response);
                    }
                }

            
            }


        }

        //CREDIT INVOICE - LESS
        else if($transaction == 2)
        {

            if($transact_type == 1)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Opps please select deduction type'
                );

                echo json_encode($resp);
            }

            else
            {
                $checkIfExistRefNo = $this->telegraphicTransferModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);

                // var_dump($checkIfExistRefNo);
                // exit();
                
                if($checkIfExistRefNo)
                {
                    $resp = array(
                        'status'    => 1.3,
                        'message'   => 'Reference No. exist in database'
                    );
    
                    echo json_encode($resp);
    
                }

                else if($amount > $amount2)
                {
                    $resp = array(
                        'status'    => 1.4,
                        'message'   => 'Your payment is higher than your amount'
                    );
    
                    echo json_encode($resp);
    
                }

                else
                {
                    $totals = $amount2 - $amount;

                    $data = array(
                        'po_number'     => $po_number,
                        'vendor'        => $vendor,
                        'date'          => $date,
                        'transact_type' => $transact_type,
                        'transaction'   => $transaction,
                        'reference_no'  => $reference_no,
                        'remarks'       =>  $remarks,
                        'rfp'           => $rfp,
                        'amount'        => $amount,
                        'amount2'       => $amount2,
                        'total'         => $totals,
                        'date_created'  => date('Y-m-d H:i:s'),
                        'user_created'  => $session_user
                    );
        
                    // var_dump($data);
                    // exit();
        
                    $insertTblOtherTransactNonPO = $this->telegraphicTransferModel->insertTBLOtherPaymentNONPO($data);
        
                    if($insertTblOtherTransactNonPO)
                    {
                        $response = array(
                            'status'    => 2,
                            'message'   => 'Success'
                        );
        
                        echo json_encode($response);
                    }
        
                    else
                    {
                        $response = array(
        
                            'message'   => 'Error'
                        );
        
                        echo json_encode($response);
                    }
                }

            }


        }

        //DEBIT NOTE - LESS 
        else if($transaction == 3)
        {
            $checkIfExistRefNo = $this->telegraphicTransferModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
        
            
            if($checkIfExistRefNo)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Reference No. exist in database'
                );

                echo json_encode($resp);

            }

            else if($transact_type == 1)
            {
                $resp = array(
                    'status'    => 1.3,
                    'message'   => 'Opps please select deduction type'
                );

                echo json_encode($resp);
            }   
            
            else if($amount > $amount2)
            {
                $resp = array(
                    'status'    => 1.4,
                    'message'   => 'Your payment is higher than your amount'
                );

                echo json_encode($resp);

            }

            
            else
            {   
                $totals = $amount2 - $amount;

                $data = array(
                    'po_number'     => $po_number,
                    'vendor'        => $vendor,
                    'date'          => $date,
                    'transact_type' => $transact_type,
                    'transaction'   => $transaction,
                    'reference_no'  => $reference_no,
                    'remarks'       =>  $remarks,
                    'rfp'           => $rfp,
                    'amount'        => $amount,
                    'amount2'       => $amount2,
                    'total'         => $totals,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user
                );
    
                // var_dump($data);
                // exit();
    
                $insertTblOtherTransactNonPO = $this->telegraphicTransferModel->insertTBLOtherPaymentNONPO($data);
    
                if($insertTblOtherTransactNonPO)
                {
                    $response = array(
                        'status'    => 2,
                        'message'   => 'Success'
                    );
    
                    echo json_encode($response);
                }
    
                else
                {
                    $response = array(
    
                        'message'   => 'Error'
                    );
    
                    echo json_encode($response);
                }
            }


        }

        //REBATE - LESS
        else if($transaction == 4)
        {
            $checkIfExistRefNo = $this->telegraphicTransferModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
            
            if($checkIfExistRefNo)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Reference No. exist in database'
                );

                echo json_encode($resp);

            }

            else if($transact_type == 1)
            {
                $resp = array(
                    'status'    => 1.3,
                    'message'   => 'Opps please select deduction type'
                );

                echo json_encode($resp);
            }    

            else if($amount > $amount2)
            {
                $resp = array(
                    'status'    => 1.4,
                    'message'   => 'Your payment is higher than your amount'
                );

                echo json_encode($resp);

            }

            
            else
            {
                $totals = $amount2 - $amount;

                $data = array(
                    'po_number'     => $po_number,
                    'vendor'        => $vendor,
                    'date'          => $date,
                    'transact_type' => $transact_type,
                    'transaction'   => $transaction,
                    'reference_no'  => $reference_no,
                    'remarks'       =>  $remarks,
                    'rfp'           => $rfp,
                    'amount'        => $amount,
                    'amount2'       => $amount2,
                    'total'         => $totals,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user
                );
    
                // var_dump($data);
                // exit();
    
                $insertTblOtherTransactNonPO = $this->telegraphicTransferModel->insertTBLOtherPaymentNONPO($data);
    
                if($insertTblOtherTransactNonPO)
                {
                    $response = array(
                        'status'    => 2,
                        'message'   => 'Success'
                    );
    
                    echo json_encode($response);
                }
    
                else
                {
                    $response = array(
    
                        'message'   => 'Error'
                    );
    
                    echo json_encode($response);
                }
            }


        }

        //ADDBACK - ADD
        else if($transaction == 5)
        {
            $checkIfExistRefNo = $this->telegraphicTransferModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
        
           
           if($checkIfExistRefNo)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Reference No. exist in database'
                );

                echo json_encode($resp);

            }

            else if($transact_type == 2)
            {
                $resp = array(
                    'status'    => 1.3,
                    'message'   => 'Opps please select additional type'
                );

                echo json_encode($resp);
            }    
            
            else
            {
                $totals = $amount2 + $amount;


                $data = array(
                    'po_number'     => $po_number,
                    'vendor'        => $vendor,
                    'date'          => $date,
                    'transact_type' => $transact_type,
                    'transaction'   => $transaction,
                    'reference_no'  => $reference_no,
                    'remarks'       =>  $remarks,
                    'rfp'           => $rfp,
                    'amount'        => $amount,
                    'amount2'       => $amount2,
                    'total'         => $totals,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user
                );
    
                // var_dump($data);
                // exit();
    
                $insertTblOtherTransactNonPO = $this->telegraphicTransferModel->insertTBLOtherPaymentNONPO($data);
    
                if($insertTblOtherTransactNonPO)
                {
                    $response = array(
                        'status'    => 2,
                        'message'   => 'Success'
                    );
    
                    echo json_encode($response);
                }
    
                else
                {
                    $response = array(
    
                        'message'   => 'Error'
                    );
    
                    echo json_encode($response);
                }
            }


        }

        //WIRE TRANSFER - ADD
        else if($transaction == 6)
        {
            $checkIfExistRefNo = $this->telegraphicTransferModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
        
           
           if($checkIfExistRefNo)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Reference No. exist in database'
                );

                echo json_encode($resp);

            }

            else if($transact_type == 2)
            {
                $resp = array(
                    'status'    => 1.3,
                    'message'   => 'Opps please select additional type'
                );

                echo json_encode($resp);
            }    
            
            else
            {
                $totals = $amount2 + $amount;

                $data = array(
                    'po_number'     => $po_number,
                    'vendor'        => $vendor,
                    'date'          => $date,
                    'transact_type' => $transact_type,
                    'transaction'   => $transaction,
                    'reference_no'  => $reference_no,
                    'remarks'       =>  $remarks,
                    'rfp'           => $rfp,
                    'amount'        => $amount,
                    'amount2'       => $amount2,
                    'total'         => $totals,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user
                );
    
                // var_dump($data);
                // exit();
    
                $insertTblOtherTransactNonPO = $this->telegraphicTransferModel->insertTBLOtherPaymentNONPO($data);
    
                if($insertTblOtherTransactNonPO)
                {
                    $response = array(
                        'status'    => 2,
                        'message'   => 'Success'
                    );
    
                    echo json_encode($response);
                }
    
                else
                {
                    $response = array(
    
                        'message'   => 'Error'
                    );
    
                    echo json_encode($response);
                }
            }


        }

        //FREIGHT - ADD
        else if($transaction == 7)
        {
            $checkIfExistRefNo = $this->telegraphicTransferModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
        
            
            if($checkIfExistRefNo)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Reference No. exist in database'
                );

                echo json_encode($resp);

            }

            else if($transact_type == 2)
            {
                $resp = array(
                    'status'    => 1.3,
                    'message'   => 'Opps please select additional type'
                );

                echo json_encode($resp);
            }    
            
            else
            {    
                $totals = $amount2 + $amount;

                $data = array(
                    'po_number'     => $po_number,
                    'vendor'        => $vendor,
                    'date'          => $date,
                    'transact_type' => $transact_type,
                    'transaction'   => $transaction,
                    'reference_no'  => $reference_no,
                    'remarks'       =>  $remarks,
                    'rfp'           => $rfp,
                    'amount'        => $amount,
                    'amount2'       => $amount2,
                    'total'         => $totals,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user
                );
    
                // var_dump($data);
                // exit();
    
                $insertTblOtherTransactNonPO = $this->telegraphicTransferModel->insertTBLOtherPaymentNONPO($data);
    
                if($insertTblOtherTransactNonPO)
                {
                    $response = array(
                        'status'    => 2,
                        'message'   => 'Success'
                    );
    
                    echo json_encode($response);
                }
    
                else
                {
                    $response = array(
    
                        'message'   => 'Error'
                    );
    
                    echo json_encode($response);
                }
            }


        }

        //COMMISSION FEE - ADD
        else if($transaction == 10)
        {
            $checkIfExistRefNo = $this->telegraphicTransferModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
        
            
            if($checkIfExistRefNo)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Reference No. exist in database'
                );

                echo json_encode($resp);

            }

            else if($transact_type == 2)
            {
                $resp = array(
                    'status'    => 1.3,
                    'message'   => 'Opps please select additional type'
                );

                echo json_encode($resp);
            }    
            
            else
            {

                $totals = $amount2 + $amount;

                $data = array(
                    'po_number'     => $po_number,
                    'vendor'        => $vendor,
                    'date'          => $date,
                    'transact_type' => $transact_type,
                    'transaction'   => $transaction,
                    'reference_no'  => $reference_no,
                    'remarks'       =>  $remarks,
                    'rfp'           => $rfp,
                    'amount'        => $amount,
                    'amount2'       => $amount2,
                    'total'         => $totals,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user
                );
    
                // var_dump($data);
                // exit();
    
                $insertTblOtherTransactNonPO = $this->telegraphicTransferModel->insertTBLOtherPaymentNONPO($data);
    
                if($insertTblOtherTransactNonPO)
                {
                    $response = array(
                        'status'    => 2,
                        'message'   => 'Success'
                    );
    
                    echo json_encode($response);
                }
    
                else
                {
                    $response = array(
    
                        'message'   => 'Error'
                    );
    
                    echo json_encode($response);
                }
            }


        }



    }
    public function fetchOtherPaymentData()
    {
        $po_number = $this->input->post('po_num');
        $reference_num = $this->input->post('reference_num');

        $fetch = $this->telegraphicTransferModel->fetchOtherPaymentModel($po_number, $reference_num);

        // var_dump($fetch);
        // exit();

        echo json_encode($fetch);
    }
    
    public function fetchOtherPaymentDatatoTBL()
    {
        $po_number = $this->input->post('po_num');
        $vendor_Code = $this->input->post('vendorCode');


        $fetch = $this->telegraphicTransferModel->fetchOtherPaymentModelTbl($po_number, $vendor_Code);

        // var_dump($fetch);
        // exit();

        echo json_encode($fetch);
    }

    public function updateOtherPaymentTBL()
    {
        $type = $this->input->post('type');
        $VendorCode = $this->input->post('vendor');
        $POnum = $this->input->post('POnum');
        $POamt = $this->input->post('POamt');
        $POdate = $this->input->post('POdate');
        $TransactType = $this->input->post('TransactType');
        $referenceNo = $this->input->post('referenceNo');
        $remarks = $this->input->post('remarks');
        $amt = $this->input->post('amt');

        $amts = $this->input->post('amts');
        

        $rfp = $this->input->post('rfp');

        $adjustment_deduction = $this->input->post('adjustment_deductionOther');

        $updateRemainBal = $this->input->post('remainBal');

        $updated_adjustment_deduction = $this->input->post('updated_adjustment_deductions');

        //history
        $vendor = $this->input->post('historyvendor');
        $account = $this->input->post('historyaccount');
        $currency = $this->input->post('historycurrency');
        $accountCurrency = $this->input->post('historyaccountCurrency');
        $proformaInvoice = $this->input->post('historyproformaInvoice');
        $company_name = $this->input->post('historycompany_name');
        $finalInvoice = $this->input->post('historyfinalInvoice');
        $status = 'C';

        if($this->session->userdata('empName')){

            $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }

        //check if amount or reference if have a value
        if($amt == '' || $referenceNo == '')
        {
            $resp = array(
                'stats'     => 1,
                'message'   => 'Please input required fields'
            );

            echo json_encode($resp);
        }

 

        //SHORT PAYMENT - add
        else if($TransactType == 2)
        {
            //make sure the type is deduction
            if($type == 2)
            {
                $resp = array(
                    'stats'     => '3',
                    'message'   => 'Make sure you choose Adjustment type'
                );

                echo json_encode($resp);
            }

            else
            {
                // check if reference no is existing
                $checkIfReferenceNoFirst = $this->telegraphicTransferModel->checkIfReferenceNoExisting($referenceNo, $POnum);

                if($checkIfReferenceNoFirst)
                {
                    $resp = array(
                        'stats'     => '4',
                        'message'   => 'The Vendor and Reference No. already exist in the database.'
                    );
    
                    echo json_encode($resp); 
                }

                else
                {
                
                        $total = $updated_adjustment_deduction + $amt;

                        $updated_deduct_adjustment = $adjustment_deduction - $amt;

                        $totals = $amt + $amts;

                        $data = array(
                        'otherTransTypeCode'    => $type,
                        'otherVendorCode'       => $VendorCode,
                        'otherPONumber'         => $POnum,
                        'transactionCode'       => $TransactType,
                        'transAmt'              => $updateRemainBal,
                        'referenceNumber'       => $referenceNo,
                        'Remarks'               => $remarks,
                        'otherPODate'           => $POdate,
                        'otherPOAmount'         => $POamt,
                        'otherTotalDeduc'       => $amt,
                        'updated_deduct_adjustment' => $total,
                        'rfp'                   => $rfp,
                        'amount'                => $amts,
                        'total'                 => $totals,
                        'userCreated'           => $session_user,
                        'dateCreated'           => date('Y-m-d H:i:s')
                        );

                        // var_dump($data);
                        // exit();
    
                        $totalBal = array(
                            'updated_total_payment' => $total
                        );

                        
                        $updatePaidAmt = array(
                            'updated_paid_amount'  => $total
                        );

                        $updateTotalPaymentMainTbl = array(
                            'updated_adjustment_deduction_amt' => $updated_deduct_adjustment
                        );
                        
                        // update the tbl payment
                        $updateTotalBalanceTblPayment = $this->telegraphicTransferModel->updateTotalBalanceIfAddOtherPayment($POnum, $totalBal, $vendor);
    
                        $updatePaidAmtTblPayment = $this->telegraphicTransferModel->updateTotalPaymentMainTbl($POnum, $VendorCode, $updatePaidAmt);

                        $updatedAdjustmentDeduction = $this->telegraphicTransferModel->updatedAdjustmentDeductionMainTbl($POnum, $VendorCode, $updateTotalPaymentMainTbl);

                        $insert = $this->telegraphicTransferModel->insertOtherPayment($data);
    
                        if($insert)
                        {
                            $resp = array(
                                'stats'     => 6,
                                'message'   => 'Success Adjustment of Short payment'
                            );
    
                            echo json_encode($resp);
                        }
    
                        else
                        {
                            $resp = array(
                                'message'   => 'Something wrong.'
                            );
    
                            echo json_encode($resp);
                        }
                    


                }
                
            } 
        }

        //OVER PAYMENT - less
        else if($TransactType == 1)
        {
            //make sure the type is deduction
            if($type == 1)
            {
                $resp = array(
                    'stats'     => '3',
                    'message'   => 'Make sure you choose Deduction type'
                );

                echo json_encode($resp);
            }

            else
            {
                // check if reference no is existing
                $checkIfReferenceNoFirst = $this->telegraphicTransferModel->checkIfReferenceNoExisting($referenceNo, $POnum);

                if($checkIfReferenceNoFirst)
                {
                    $resp = array(
                        'stats'     => '4',
                        'message'   => 'The Vendor and Reference No. already exist in the database.'
                    );
    
                    echo json_encode($resp); 
                }

                //if remaining balance match to payment
                // if($updated_adjustment_deduction == $amt)
                // {
                //     // check if reference no is existing
                //     $checkIfReferenceNoFirst = $this->telegraphicTransferModel->checkIfReferenceNoExisting($referenceNo, $POnum);

                //     if($checkIfReferenceNoFirst)
                //     {
                //         $resp = array(
                //             'stats'     => '4',
                //             'message'   => 'The Vendor and Reference No. already exist in the database.'
                //         );
        
                //         echo json_encode($resp); 
                //     }

                //     else
                //     {
                //         $total = $updated_adjustment_deduction - $amt;

                //         $data = array(
                //         'otherTransTypeCode'    => $type,
                //         'otherVendorCode'       => $VendorCode,
                //         'otherPONumber'         => $POnum,
                //         'transactionCode'       => $TransactType,
                //         'transAmt'              => $updateRemainBal,
                //         'referenceNumber'       => $referenceNo,
                //         'Remarks'               => $remarks,
                //         'otherPODate'           => date('Y-m-d', strtotime($POdate)),
                //         'otherPOAmount'         => $POamt,
                //         'otherTotalDeduc'       => $amt,
                //         'updated_deduct_adjustment' => $total,
                //         'userCreated'           => $this->session->userdata('empName'),
                //         'dateCreated'           => date('Y-m-d'),
                //         );

                //         $totalBal = array(
                //             'updated_total_payment' => $total
                //         );

                //         $dataTohistory = array(
                //         'vendorCode'        => $vendor,
                //         'accountCode'       => $account,
                //         'paymentTermCode'   => $currency,
                //         'accountCurrency'   => $accountCurrency,
                //         'PONumber'          => $POnum,
                //         'PODate'            => date('Y-m-d', strtotime($POdate)),
                //         'POAmount'          => $POamt,
                //         'proformaInvoice'   => $proformaInvoice,
                //         'finalInvoice'      => $finalInvoice,
                //         'compCode'          => $company_name,
                //         'status'            => $status,
                //         'userCreated'       => $this->session->userdata('empName'),
                //         'dateCreated'       => date('Y-m-d'),
                //         );

                //         //insert to History
                //         $insertToHistoryTbl = $this->telegraphicTransferModel->insertHistoryTBL($dataTohistory);

                //         //truncate the data from the main tbl
                //         $deleteToMainTBL = $this->telegraphicTransferModel->truncateTBLTelegraphicTransfer($POnum, $VendorCode);

                //         // update the tbl payment total balance
                //         $updateTotalBalanceTblPayment = $this->telegraphicTransferModel->updateTotalBalanceIfAddOtherPayment($POnum, $totalBal, $vendor);

                //         //insert to tblOtherPayment
                //         $insert = $this->telegraphicTransferModel->insertOtherPayment($data);



                //         if($insert)
                //         {
                //             $resp = array(
                //                 'stats'     => 5,
                //                 'message'   => 'Paid. This transaction is automatically tag as closed and transfer to historical data.'
                //             );

                //             echo json_encode($resp);
                //         }

                //         else
                //         {
                //             $resp = array(
                //                 'message'   => 'Something wrong.'
                //             );

                //             echo json_encode($resp);
                //         }
                //     }

                    
                // }
                

                else
                {   

                    // if($amt > $updateRemainBal)
                    // {
                    //     $resp = array(
                    //         'stats'    => 7,
                    //         'message'   => 'Your amount is higher than your balance'
                    //     );
    
                    //     echo json_encode($resp);
                    // }

                    // else
                    // {
                        
                        $total = $updated_adjustment_deduction - $amt;

                        $updated_deduct_adjustment = $adjustment_deduction + $amt;
                        
                        // var_dump($updateRemainBal);
                        // var_dump($updated_adjustment_deduction);
                        // var_dump($total);
                        // var_dump($updated_deduct_adjustment);

                        // exit();

                        $totals = $amts - $amt;

                        $data = array(
                        'otherTransTypeCode'    => $type,
                        'otherVendorCode'       => $VendorCode,
                        'otherPONumber'         => $POnum,
                        'transactionCode'       => $TransactType,
                        'transAmt'              => $total,
                        'referenceNumber'       => $referenceNo,
                        'Remarks'               => $remarks,
                        'otherPODate'           => $POdate,
                        'otherPOAmount'         => $POamt,
                        'otherTotalDeduc'       => $amt,
                        'updated_deduct_adjustment' => $total,
                        'updateRemainBal'       => $updateRemainBal,
                        'rfp'                   => $rfp,
                        'amount'                => $amts,
                        'total'                 => $totals,
                        'userCreated'           => $session_user,
                        'dateCreated'           => date('Y-m-d H:i:s')
                        );

                        // var_dump($data);
                        // exit();
    
                        $totalBal = array(
                            'updated_total_payment' => $total
                        );

                        $updatePaidAmt = array(
                            'updated_paid_amount'  => $total
                        );

                        $updateTotalPaymentMainTbl = array(
                            'updated_adjustment_deduction_amt' => $updated_deduct_adjustment
                        );
                        
                        // update the tbl payment
                        $updateTotalBalanceTblPayment = $this->telegraphicTransferModel->updateTotalBalanceIfAddOtherPayment($POnum, $totalBal, $vendor);
                        
                        $updatePaidAmtTblPayment = $this->telegraphicTransferModel->updateTotalPaymentMainTbl($POnum, $VendorCode, $updatePaidAmt);

                        $updatedAdjustmentDeduction = $this->telegraphicTransferModel->updatedAdjustmentDeductionMainTbl($POnum, $VendorCode, $updateTotalPaymentMainTbl);
    
                        $insert = $this->telegraphicTransferModel->insertOtherPayment($data);
    
                        if($insert)
                        {
                            $resp = array(
                                'stats'     => 6,
                                'message'   => 'Success Deduction of Over payment'
                            );
    
                            echo json_encode($resp);
                        }
    
                        else
                        {
                            $resp = array(
                                'message'   => 'Something wrong.'
                            );
    
                            echo json_encode($resp);
                        }
                    // }

                }
                
            } 
        }
        
    }

    public function fetchNONPOdata()
    {
        $po_num = $this->input->post('po');
        $vendor = $this->input->post('vendor');

        $data = $this->telegraphicTransferModel->fetchDataOtherPaymentNONPO($po_num, $vendor);

        // var_dump($data);
        // exit();

        echo json_encode($data);
    }

    public function fetchNONPOdataToTBL()
    {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');

        $fetchData = $this->telegraphicTransferModel->fetchDataOtherPaymentNONPOToTBL($po, $vendor);

        echo json_encode($fetchData);
    }


}


