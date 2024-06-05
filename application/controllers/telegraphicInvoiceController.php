<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class telegraphicInvoiceController extends CI_Controller {

    public function populateVendorToAccountInvoice()
    {
        $vendor = $this->input->post('v');

        $populate = $this->telegraphicInvoiceModel->getValueAccInvoice($vendor);


        echo json_encode($populate);
   
    }

    public function insertTelegraphicTransferInvoice()
    {
        $vendorCodeInvoice = $this->input->post('vendorCodeInvoice');
        $accCodeInvoice = $this->input->post('accCodeInvoice');
        $CompanyCodeInvoice = $this->input->post('CompanyCodeInvoice');
        $InvoiceNumber = $this->input->post('InvoiceNumber');
        $PODateInvoice = $this->input->post('PODateInvoice');
        $POAmountInvoice = $this->input->post('POAmountInvoice');
        $ProformaInvoiceInvoice = $this->input->post('ProformaInvoiceInvoice');
        $CommercialInvoiceInvoice = $this->input->post('CommercialInvoiceInvoice');
        $remarks = $this->input->post('RemarksInvoice');
        $rfp = $this->input->post('RFPInvoice');

        
        if($this->session->userdata('empName')){

        $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }


        $ex = explode(',',$accCodeInvoice);

        $accCode = $ex[0];
        $nigga = $ex[1];
        $paymentTerm = $ex[2];

        $inputs = array(
            $vendorCodeInvoice,
            $accCode,
            $nigga,
            $paymentTerm,
            $CompanyCodeInvoice,
            $InvoiceNumber,
            $PODateInvoice,
            $POAmountInvoice,
            $rfp
        );

        if(in_array('', $inputs))
        {
            $resp = array(
                'stat' => 0,
                'mess' => 'Please input all required fields'
              );

              echo json_encode($resp);
        }

        else if($ProformaInvoiceInvoice == '' && $CommercialInvoiceInvoice == '')
        {
            $checkInvoiceNumberFirst = $this->telegraphicInvoiceModel->checkInvoiceNumberandPO($InvoiceNumber, $vendorCodeInvoice);

            if($checkInvoiceNumberFirst)
            {
                $resp = array(
                    's' => 4,
                    'm' => 'Invoice Number and Vendor is already exist in database'
                );

                echo json_encode($resp);
            }

            else
            {
                $data = array(
                    'vendorCode'            =>$vendorCodeInvoice,
                    'accountCode'           =>$accCode,
                    'paymentTermCode'       =>$paymentTerm,
                    'InvoiceNumber'         =>$InvoiceNumber,
                    'InvoiceDate'            =>$PODateInvoice,
                    'InvoiceAmount'         =>$POAmountInvoice,
                    'proformaInvoice'       =>$ProformaInvoiceInvoice,
                    'commercialInvoice'     =>$CommercialInvoiceInvoice,
                    'rfp'                   => $rfp,
                    'remarks'               => $remarks,
                    'compCode'              =>$CompanyCodeInvoice,
                    'userCreated'           =>$session_user,
                    'dateCreated'           =>date('Y-m-d'),
                    'status'                => 'O',
                );

                // var_dump($data);
                // exit();

                $insertToDBTemp = $this->telegraphicInvoiceModel->insertTelegraphicTransfer_tempTBLInvoice($data);
                    
                if($insertToDBTemp)
                {
                    $resp = array(
                        'status'  => 1,
                        'message' => 'Successfully Inserted!',
                        'data' => $data
                    );
        
                    echo json_encode($resp);
                    
                    
                }
        
                else
                {
                    $resp = array(
                        'status'  => 2,
                        'message' => 'Something went wrong.'
                    );
        
                    echo json_encode($resp);
                }
            }
        }

        else if($ProformaInvoiceInvoice == '' || $CommercialInvoiceInvoice == '')
        {

            $checkInvoiceNumberFirst = $this->telegraphicInvoiceModel->checkInvoiceNumberandPO($InvoiceNumber, $vendorCodeInvoice);

            if($checkInvoiceNumberFirst)
            {
                $resp = array(
                    's' => 4,
                    'm' => 'Invoice Number and Vendor already exist'
                );

                echo json_encode($resp);
            }


            else
            {
                $checkProformaCommercialInvoices = $this->telegraphicInvoiceModel->checkProformaAndCommercial($ProformaInvoiceInvoice, $CommercialInvoiceInvoice, $InvoiceNumber);

                if($checkProformaCommercialInvoices)
                {
                    $resp = array(
                        'stats' => 9,
                        'm' => 'Proforma Invoice or Final Invoice already exist in Database'
                    );
    
                    echo json_encode($resp);
                }

                else
                {
                    $data = array(
                        'vendorCode'            =>$vendorCodeInvoice,
                        'accountCode'           =>$accCode,
                        'paymentTermCode'       =>$paymentTerm,
                        'InvoiceNumber'         =>$InvoiceNumber,
                        'InvoiceDate'           =>$PODateInvoice,
                        'InvoiceAmount'         =>$POAmountInvoice,
                        'proformaInvoice'       =>$ProformaInvoiceInvoice,
                        'commercialInvoice'     =>$CommercialInvoiceInvoice,
                        'rfp'                   => $rfp,
                        'remarks'               => $remarks,
                        'compCode'              =>$CompanyCodeInvoice,
                        'userCreated'           =>$session_user,
                        'dateCreated'           =>date('Y-m-d'),
                        'status'                => 'O',
                    );
        
                    $insertToDBTemp = $this->telegraphicInvoiceModel->insertTelegraphicTransfer_tempTBLInvoice($data);
                        
                    if($insertToDBTemp)
                    {
                        $resp = array(
                            'status'  => 1,
                            'message' => 'Successfully Inserted!',
                            'data' => $data
                        );
            
                        echo json_encode($resp);
                        
                        
                    }
            
                    else
                    {
                        $resp = array(
                            'status'  => 2,
                            'message' => 'Something went wrong.'
                        );
            
                        echo json_encode($resp);
                    }
                }

                
            }
        }  
        
        else
        {
            $checkInvoiceNumberFirst = $this->telegraphicInvoiceModel->checkInvoiceNumberandPO($InvoiceNumber, $vendorCodeInvoice);

            if($checkInvoiceNumberFirst)
            {
                $resp = array(
                    's' => 4,
                    'm' => 'Invoice Number and Vendor is already exist in database'
                );

                echo json_encode($resp);
            }

            else
            {

                $checkProformaCommercialInvoices = $this->telegraphicInvoiceModel->checkProformaAndCommercial($ProformaInvoiceInvoice, $CommercialInvoiceInvoice, $InvoiceNumber);

                if($checkProformaCommercialInvoices)
                {
                    $resp = array(
                        'stats' => 9,
                        'm' => 'Proforma Invoice or Final Invoice already exist in Database'
                    );
    
                    echo json_encode($resp);
                }

                else
                {
                    $data = array(
                        'vendorCode'            =>$vendorCodeInvoice,
                        'accountCode'           =>$accCode,
                        'paymentTermCode'       =>$paymentTerm,
                        'InvoiceNumber'         =>$InvoiceNumber,
                        'InvoiceDate'            =>$PODateInvoice,
                        'InvoiceAmount'         =>$POAmountInvoice,
                        'proformaInvoice'       =>$ProformaInvoiceInvoice,
                        'commercialInvoice'     =>$CommercialInvoiceInvoice,
                        'rfp'                   => $rfp,
                        'remarks'               => $remarks,
                        'compCode'              =>$CompanyCodeInvoice,
                        'userCreated'           =>$session_user,
                        'dateCreated'           =>date('Y-m-d'),
                        'status'                => 'O',
                    );
    
                    // var_dump($data);
                    // exit();
                        

                    $insertToDBTemp = $this->telegraphicInvoiceModel->insertTelegraphicTransfer_tempTBLInvoice($data);

                    
                    if($insertToDBTemp)
                    {
                        $resp = array(
                            'status'  => 1,
                            'message' => 'Successfully Inserted!',
                            'data' => $data
                        );
            
                        echo json_encode($resp);
                        
                    }
            
                    else
                    {
                        $resp = array(
                            'status'  => 2,
                            'message' => 'Something went wrong.'
                        );
            
                        echo json_encode($resp);
                    }
                }
                
            }
        }

        
    }

    public function insertPaymentInvoice()
    {   
        //payment
        $VendorP = $this->input->post('VendorP');
        $InvoiceP = $this->input->post('InvoiceP');
        $PODateP = $this->input->post('PODateP');
        $POAmountP = $this->input->post('POAmountP');
        $AmountP = $this->input->post('AmountP');
        $rfp = $this->input->post('rfp');
        $date = $this->input->post('date');
        $remarks = $this->input->post('remarks');

        //data
        $accountCodeP  = $this->input->post('accountCodeP');
        $currencyP  = $this->input->post('currencyP');
        $proformaP  = $this->input->post('proformaP');
        $commercialP  = $this->input->post('commercialP');
        $companyP  = $this->input->post('companyP');
        $rfpP = $this->input->post('rfpP');
        $remarksP = $this->input->post('remarksP');

        $paymentTermP = $this->input->post('paymentTermP');

        
        if($this->session->userdata('empName')){

            $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }



        if($AmountP == '')
        {
            $response = array(
                'status'    => 0,
                'message'   => 'Please input amount.'
            );

            echo json_encode($response);
        }

        else if($rfp == '' || $rfp == null)
        {
            $response = array(
                'status'    => 0.1,
                'message'   => 'Please input rfp'
            );

            echo json_encode($response);
        }
        
        else if($AmountP == 0)
        {
            $response = array(
                'status'    => 1,
                'messages'   => 'Your amount is 0'
            );

            echo json_encode($response);
        }

        else if($AmountP > $POAmountP)
        {
            $response = array(
                'status'    => 1.1,
                'messages'   => 'Opps your Amount higher than your balance'
            );

            echo json_encode($response);
        }

        //initial payment
        else if($AmountP < $POAmountP)
        {   

                $totalP = $POAmountP - $AmountP;

                $data = array(
                    'Vendor'            => $VendorP,
                    'InvoiceNumber'     => $InvoiceP,
                    'InvoiceDate'       => $PODateP,
                    'InvoiceAmount'     => $POAmountP,
                    'payment_type'      => 1,
                    'amount'            => $AmountP,
                    'change'            => 0,
                    'total_balance'     => $totalP,
                    'total_payment'     => $AmountP,
                    'updated_Initial_payment' => $AmountP,
                    'update_initial_payment2' => $AmountP,
                    'rfp'               => $rfp,
                    'date'              => date('Y-m-d H:i:s', strtotime($date)),
                    'remarks'           => $remarks,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                
                );

                // var_dump($data);
                // exit();

                //insert tbl payment
                $insert = $this->telegraphicInvoiceModel->insertPaymentTblInvoices($data);

           
                $dataToMainTable = array(
                    'vendorCode'        => $VendorP,
                    'accountCode'       => $accountCodeP,
                    'paymentTermCode'   => $currencyP,
                    'accountCurrency'   => 1,
                    'InvoiceNumber'     => $InvoiceP,
                    'InvoiceDate'       => $PODateP,
                    'InvoiceAmount'     => $POAmountP,
                    'proformaInvoice'   => $proformaP,
                    'commercialInvoice' => $commercialP,
                    'compCode'          => $companyP,
                    'rfp'               => $rfpP,
                    'remarks'           => $remarksP,
                    'userCreated'       => $session_user,
                    'dateCreated'       => date('Y-m-d'),
                    'status'            => 'O',
                    'updated_balanced'   => $totalP,
                    'updated_paid_amount'  => $AmountP
                );

                // var_dump($data);
                // var_dump($dataToMainTable);
                // exit();

                //insert to main tbl
                $insertToMainTable = $this->telegraphicInvoiceModel->insertTelegraphicInvoices_mainTBL($dataToMainTable);
                

                if($insert)
                {
                    $response = array(
                        'status'  => 2,
                        'message' => 'Initial payment success',
                        'data_set'  => $insertToMainTable
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
        else if($AmountP == $POAmountP)
        {   

                $totalP = $POAmountP - $AmountP;

                $data = array(
                    'Vendor'            => $VendorP,
                    'InvoiceNumber'     => $InvoiceP,
                    'InvoiceDate'       => $PODateP,
                    'InvoiceAmount'     => $POAmountP,
                    'payment_type'      => 2,
                    'amount'            => $AmountP,
                    'change'            => 0,
                    'total_balance'     => $totalP,
                    'total_payment'     => $AmountP,
                    'updated_Initial_payment' => $totalP,
                    'update_initial_payment2' => $AmountP,
                    'remarks'           => $remarks,
                    'date'              => date('Y-m-d H:i:s', strtotime($date)),
                    'rfp'               => $rfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                
                );

                $dataToMainTable = array(
                    'vendorCode'        => $VendorP,
                    'accountCode'       => $accountCodeP,
                    'paymentTermCode'   => $currencyP,
                    'accountCurrency'   => 2,
                    'InvoiceNumber'     => $InvoiceP,
                    'InvoiceDate'       => $PODateP,
                    'InvoiceAmount'     => $POAmountP,
                    'proformaInvoice'   => $proformaP,
                    'commercialInvoice' => $commercialP,
                    'compCode'          => $companyP,
                    'userCreated'       => $session_user,
                    'dateCreated'       => date('Y-m-d'),
                    'status'            => 'C',
                    'updated_balanced'  => $totalP,
                    'updated_paid_amount'  => $AmountP,
                    'remarks'           => $remarksP,
                    'rfp'               => $rfpP,
                );

                // var_dump($dataToMainTable);
                // var_dump($data);
                // exit();


                 //insert tbl payment
                $insert = $this->telegraphicInvoiceModel->insertPaymentTblInvoices($data);
                //insert to history
                $insertToMainTable = $this->telegraphicInvoiceModel->insertTelegraphicInvoices_his($dataToMainTable);

                if($insert)
                {
                    $response = array(
                        'status'  => 3,
                        'message' => 'Paid. This transaction is automatically tag as closed and transfer to historical data.',
                        'data_set'  => $insertToMainTable
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


    }

    public function fetchdataPaymentInvoice()
    {
        $InvoiceNumber = $this->input->post('invoiceNum');
        $vendor_code = $this->input->post('vendor_code');

        $fetch = $this->telegraphicInvoiceModel->fetchtblPaymentInvoice($InvoiceNumber, $vendor_code);


        echo json_encode($fetch);
    }

    public function fetchOtherPaymentInvoice()
    {
        $InvoiceNumber = $this->input->post('invoiceNum');
        $vendor_code = $this->input->post('vendor_code');

        $fetch = $this->telegraphicInvoiceModel->fetchtblOtherPaymentInvoice($InvoiceNumber, $vendor_code);


        echo json_encode($fetch);
    }

    public function insertOtherPaymentInvoice()
    {
        $trans_type = $this->input->post('trans_type');
        $vendor = $this->input->post('vendor');
        $invoiceNumber = $this->input->post('invoiceNumber');
        $invoiceDate = $this->input->post('invoiceDate');
        $referenceNo = $this->input->post('referenceNo');
        $invoiceAmount = $this->input->post('invoiceAmount');
        $remarks = $this->input->post('remarks');
        $deduc_type = $this->input->post('deduc_type');
        $amount = $this->input->post('amount');
        $rfp = $this->input->post('rfp');

        $insertTotalBal = $this->input->post('insertTotalBal');

        
        if($this->session->userdata('empName')){

        $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }

        //check if amount has value
        if($amount == '' || $referenceNo == '' || $rfp == '')
        {
            $resp = array(
                'stats'     => '1',
                'message'   => 'Please input required fields'
            );

            echo json_encode($resp);
        }

        //Shortpayment - add
        else if($deduc_type == 2)
        {
            //make sure the type is adjustment type
            if($trans_type == 2)
            {
                $resp = array(
                    'stats'     => '4',
                    'message'   => 'Make sure you choose Adjustment type'
                );

                echo json_encode($resp);
            }

            else
            {   

                $checkIfReferenceNoFirst = $this->telegraphicInvoiceModel->checkIfReferenceNoExisting($referenceNo, $invoiceNumber);


                //check if reference no is already exist in database
                if($checkIfReferenceNoFirst)
                {
                    $resp = array(
                        'stats'     => '5',
                        'message'   => 'Reference No. already exist in database'
                    );
    
                    echo json_encode($resp); 
                }

                else
                {
                    $total = $invoiceAmount + $amount;

                    $dataInsertOtherPayment = array(
                        'otherTransTypeCode'    => $trans_type,
                        'otherVendorCode'       => $vendor,
                        'otherInvoiceAmount'    => $invoiceAmount,
                        'otherInvoiceNumber'    => $invoiceNumber,
                        'otherInvoiceDate'      => $invoiceDate,
                        'referenceNumber'       => $referenceNo,
                        'transactionCode'       => $deduc_type,
                        'transAmt'              => $insertTotalBal,
                        'update_Initial_deduction'  => $total,
                        'Remarks'               => $remarks,
                        'rfp'                   => $rfp,
                        'otherTotalDeduc'       => $amount,
                        'amount'                => $invoiceAmount,
                        'total'                 => $total,
                        'userCreated'           => $session_user,
                        'dateCreated'           => date('Y-m-d'),                                                                                                                                                                                                                                
                    );
        
                    $inserOtherPayment = $this->telegraphicInvoiceModel->insertOtherPayment($dataInsertOtherPayment);

                    $totalBal = array(
                        'update_initial_payment2' => $total
                    );

                    $updatePaidAmt = array(
                        'updated_paid_amount'  => $total
                    );

                    $updateAdjustment_deduction = array(
                        'updated_adjustment_deduction_amt' => $amount
                    );
                    

                    $updateTotalBalanceTblPayment = $this->telegraphicInvoiceModel->updateTotalBalanceIfAddOtherPayment($invoiceNumber, $vendor, $totalBal);

                    $updatePaidAmtTblPayment = $this->telegraphicInvoiceModel->updateTotalPaymentMainTbl($invoiceNumber, $vendor, $updatePaidAmt);

                    $updatedAdjustmentDeductionMainTbl = $this->telegraphicInvoiceModel->updatedAdjustmentDeductionMainTbl($invoiceNumber, $vendor, $updateAdjustment_deduction);

                    if($inserOtherPayment)
                    {
                        $resp = array(
                            'stats'     => '6',
                            'message'   => 'Success Adjustment of Short payment'
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

        //Overpayment - less
        else if($deduc_type == 1)
        {   

            //make sure the type is deduction
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

                $checkIfReferenceNoFirst = $this->telegraphicInvoiceModel->checkIfReferenceNoExisting($referenceNo, $invoiceNumber);


                //check if reference no is already exist in database
                if($checkIfReferenceNoFirst)
                {
                    $resp = array(
                        'stats'     => '5',
                        'message'   => 'Reference No. already exist in database'
                    );
    
                    echo json_encode($resp); 
                }

                     //if amount higher than po amount
                else if ($amount > $invoiceAmount)
                {
                    $resp = array(
                        'stats'     => '3',
                        'message'   => 'Invalid amount'
                    );

                    echo json_encode($resp);
                }

                else
                {
                    $total = $invoiceAmount - $amount;

                    $dataInsertOtherPayment = array(
                        'otherTransTypeCode'    => $trans_type,
                        'otherVendorCode'       => $vendor,
                        'otherInvoiceAmount'    => $invoiceAmount,
                        'otherInvoiceNumber'    => $invoiceNumber,
                        'otherInvoiceDate'      => $invoiceDate,
                        'referenceNumber'       => $referenceNo,
                        'transactionCode'       => $deduc_type,
                        'transAmt'              => $insertTotalBal,
                        'update_Initial_deduction'  => $total,
                        'Remarks'               => $remarks,
                        'rfp'                   => $rfp,
                        'otherTotalDeduc'       => $amount,
                        'amount'                => $invoiceAmount,
                        'total'                 => $total,
                        'userCreated'           => $session_user,
                        'dateCreated'           => date('Y-m-d'),                                                                                                                                                                                                                                
                    );

        
                    $inserOtherPayment = $this->telegraphicInvoiceModel->insertOtherPayment($dataInsertOtherPayment);

                    $totalBal = array(
                        'update_initial_payment2' => $total
                    );

                    
                    $updatePaidAmt = array(
                        'updated_paid_amount'  => $total
                    );

                    $updateAdjustment_deduction = array(
                        'updated_adjustment_deduction_amt' => $amount
                    );
                    

                    $updateTotalBalanceTblPayment = $this->telegraphicInvoiceModel->updateTotalBalanceIfAddOtherPayment($invoiceNumber, $vendor, $totalBal);

                    $updatePaidAmtTblPayment = $this->telegraphicInvoiceModel->updateTotalPaymentMainTbl($invoiceNumber, $vendor, $updatePaidAmt);

                    $updatedAdjustmentDeductionMainTbl = $this->telegraphicInvoiceModel->updatedAdjustmentDeductionMainTbl($invoiceNumber, $vendor, $updateAdjustment_deduction);


                    if($inserOtherPayment)
                    {
                        $resp = array(
                            'stats'     => '6',
                            'message'   => 'Success Deduction of Over payment'
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

    public function fetchInitialPayInvoice()
    {
        $invoice_num = $this->input->post('invoice_num');
        $vendor_code = $this->input->post('vendor_code');

        $fetch = $this->telegraphicInvoiceModel->fetchInitialPaymentInvoiceModal($invoice_num, $vendor_code);

        echo json_encode($fetch);

    }

    public function fetchInitialPaymentData()
    {
        $invoice_num = $this->input->post('invoice_num');
        $vendor_code = $this->input->post('vendor_code');

        $fetchInitial = $this->telegraphicInvoiceModel->fetchTTSDataForInitial($invoice_num, $vendor_code);

        echo json_encode($fetchInitial); 
    }

    public function updateInitialPay()
    {   
        $vendor         = $this->input->post('vendor');

        $InvoiceNum     = $this->input->post('InvoiceNum');
        $InvoiceDate    = $this->input->post('InvoiceDate');
        $InvoiceAmount  = $this->input->post('InvoiceAmount');
        $total_payment  = $this->input->post('total_payment');
        $total_balance  = $this->input->post('total_balance');
        $paymentType    = $this->input->post('paymentType');
        $amount         = $this->input->post('amount');
        $rfp            = $this->input->post('rfp');
        $remarks        = $this->input->post('remarks');

        $date           = $this->input->post('date');

        $update_initial_pay = $this->input->post('update_initial_p');

        //history
        $vendor = $this->input->post('historyvendor');
        $account = $this->input->post('historyaccount');
        $currency = $this->input->post('historycurrency');
        $accountCurrency = $this->input->post('historyaccountCurrency');
        $Invoicenumber = $this->input->post('historyInvoiceNumber');
        $Invoicedate = $this->input->post('historyInvoiceDate');
        $Invoiceamt = $this->input->post('historyInvoiceAmt');
        $proformaInvoice = $this->input->post('historyproformaInvoice');
        $company_name = $this->input->post('historycompany_name');
        $commercialInvoice = $this->input->post('historycommercialInvoice');
        $hisRfp = $this->input->post('hisRfp');
        $hisRemarks = $this->input->post('hisRemarks');
        $status = 'C';

        
        if($this->session->userdata('empName')){

        $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }
 

        if($amount == '')
        {
            $response = array(
                'status'  => 3,
                'message' => 'Please input amount'
            );

            echo json_encode($response);
        }

        else
        {
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
                if($amount > $total_balance)
                {
                    $response = array(
                        'status'  => 5,
                        'message' => 'Your amount is higher than your balance.'
                    );
        
                    echo json_encode($response);
                }

                else if($amount == $total_balance)
                {
                    $totalPayment = $total_balance - $amount;

                    $totPay = $update_initial_pay + $amount;

                    $data = array(
                        'Vendor'        => $vendor,
                        'InvoiceNumber' => $Invoicenumber,
                        'InvoiceDate'   => $Invoicedate,
                        'InvoiceAmount' => $Invoiceamt,
                        'total_payment' => $amount,
                        'total_balance' => $totalPayment,
                        'change'        => 0,
                        'payment_type'  => 2,
                        'amount'        => $amount,
                        'updated_Initial_payment'   => $totPay,
                        'update_initial_payment2'   => $totPay,
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
                        'InvoiceNumber'     => $Invoicenumber,
                        'InvoiceDate'       => $Invoicedate,
                        'InvoiceAmount'     => $Invoiceamt,
                        'proformaInvoice'   => $proformaInvoice,
                        'compCode'          => $company_name,
                        'commercialInvoice' => $commercialInvoice,
                        'remarks'           => $hisRemarks,
                        'rfp'               => $hisRfp,
                        'status'            => $status,
                        'updated_balanced'  => $totalPayment,
                        'updated_paid_amount' => $totPay,
                        'userCreated'       => $session_user,
                        'dateCreated'      => date('Y-m-d'),
                    );

                    // var_dump($data);
                    // var_dump($insertTBLhistory);
                    // exit();
                   
                    //update payment
                    $updateInitialPayment = $this->telegraphicInvoiceModel->updateInitialPayment($data);

                    $d = array(
                        'transAmt' => $totalPayment
                    );

                    //updateRemaining balance in other payment tbl after full payment
                    $updateTotalBalanceInOtherPayment = $this->telegraphicInvoiceModel->updateTotalBalanceInOtherPayment($Invoicenumber, $vendor, $d);

                    //insert to tbl history
                    $insertTBLhist = $this->telegraphicInvoiceModel->insertHistoryTBL($insertTBLhistory);

                    //truncate the data from the main tbl
                    $deleteToMainTBL = $this->telegraphicInvoiceModel->truncateTBLTelegraphicTransferInvoice($Invoicenumber, $vendor);

                    $updateStats = $this->telegraphicInvoiceModel->updateStatusOfTTS($Invoicenumber);


                    $response = array(
                        'status'  => 'D',
                        'message' => 'Paid. This transaction is automatically tag as closed and transfer to historical data.'
                    );

                    echo json_encode($response);
                }

                else
                {
                    $totalPayment = $total_balance - $amount;

                    $totPay = $update_initial_pay + $amount;

                    // var_dump($totalPayment);
                    // var_dump($totPay);
                    // exit();


                    $data = array(
                        'Vendor'        => $vendor,
                        'InvoiceNumber' => $Invoicenumber,
                        'InvoiceDate'   => $Invoicedate,
                        'InvoiceAmount' => $Invoiceamt,
                        'total_payment' => $amount,
                        'total_balance' => $totalPayment,
                        'change'        => 0,
                        'updated_Initial_payment'   => $totPay,
                        'update_initial_payment2'    => $totPay,
                        'payment_type'  => $paymentType,
                        'amount'        => $amount,
                        'remarks'       => $remarks,
                        'date'          => date('Y-m-d H:i:s', strtotime($date)),
                        'rfp'           => $rfp,
                        'date_created'  => date('Y-m-d H:i:s'),
                        'user_created'  => $session_user
                    );

                    // var_dump($data);
                    // exit();

                    $d = array(
                        'transAmt' => $totalPayment
                    );

                    $e = array(
                        'updated_balanced' => $totalPayment
                    );

                    $f = array(
                        'updated_paid_amount' => $totPay
                    );


                    $updateRemainBal = $this->telegraphicInvoiceModel->updateTotalBalanceInOtherPayment($Invoicenumber, $vendor, $d);

                    $updateTotalBalancedMaintbl = $this->telegraphicInvoiceModel->updateTotalBalancedMainTbl($Invoicenumber, $vendor, $e);

                    $updateTotalPaymentMainTbl = $this->telegraphicInvoiceModel->updateTotalPaymentMainTbl($Invoicenumber, $vendor, $f);
            
                    $updateInitialPayment = $this->telegraphicInvoiceModel->updateInitialPayment($data);
            
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

    public function fetchInvoiceOtherPayment()
    {
        $invoice_num = $this->input->post('invoice_num');
        $vendor_code = $this->input->post('vendor_code');

        $fetch = $this->telegraphicInvoiceModel->fetchOtherPaymentModelTbl($invoice_num, $vendor_code);

        echo json_encode($fetch);
    }

    public function updateOtherPaymentInvoiceTBL()
    {
        $type = $this->input->post('type');
        $vendor_code = $this->input->post('vendor_code');
        $InvoiceNum = $this->input->post('InvoiceNum');
        $InvoiceAmt = $this->input->post('InvoiceAmt');
        $InvoiceDate = $this->input->post('InvoiceDate');
        $TransactType = $this->input->post('TransactType');
        $referenceNo = $this->input->post('referenceNo');
        $remarks = $this->input->post('remarks');
        $amt = $this->input->post('amt');

        $amts = $this->input->post('amts');
        $rfp = $this->input->post('rfp');

        $updateRemainBal = $this->input->post('remainBal');

        $initialP = $this->input->post('initialP');

        $remainBalance = $this->input->post('remainBalafterPay');

        $updated_adjustment_deduction = $this->input->post('updated_adjustment_deductions');

        //history
        $vendor = $this->input->post('historyvendor');
        $account = $this->input->post('historyaccount');
        $currency = $this->input->post('historycurrency');
        $accountCurrency = $this->input->post('historyaccountCurrency');
        $proformaInvoice = $this->input->post('historyproformaInvoice');
        $company_name = $this->input->post('historycompany_name');
        $commercialInvoice = $this->input->post('commercialInvoice');
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

        // if amount is bigger than PO amount
        // else if($amt > $InvoiceAmt)
        // {
        //     $resp = array(
        //         'stats'     => 2,
        //         'message'   => 'Invalid amount'
        //     );

        //     echo json_encode($resp);
        // }

        //Short payment - add
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
                $checkIfReferenceNoFirst = $this->telegraphicInvoiceModel->checkIfReferenceNoExisting($referenceNo, $InvoiceNum);

                if($checkIfReferenceNoFirst)
                {
                    $resp = array(
                        'stats'     => '4',
                        'message'   => 'Reference No. already exist in database'
                    );

                    echo json_encode($resp); 
                }

                else
                {
                
                        // $total = $initialP + $amt;

                        $updatedDeductAdjust = $updated_adjustment_deduction - $amt;


                        $totals = $amt + $amts;



                        $data = array(
                        'otherTransTypeCode'    => $type,
                        'otherVendorCode'       => $vendor_code,
                        'otherInvoiceNumber'    => $InvoiceNum,
                        'transactionCode'       => $TransactType,
                        'transAmt'              => $updateRemainBal,
                        'update_Initial_deduction'  => $totals,
                        'referenceNumber'       => $referenceNo,
                        'Remarks'               => $remarks,
                        'otherInvoiceDate'      => date('Y-m-d', strtotime($InvoiceDate)),
                        'otherInvoiceAmount'    => $InvoiceAmt,
                        'otherTotalDeduc'       => $amt,
                        'amount'                => $amts,
                        'total'                 => $totals,
                        'rfp'                   => $rfp,
                        'userCreated'           => $session_user,
                        'dateCreated'           => date('Y-m-d H:i:s'),
                        );


                        $totalBal = array(
                            'update_initial_payment2' => $totals
                        );

                        // $updatePaidAmt = array(
                        //     'updated_paid_amount'  => $total
                        // );

                        $updateTotalPaymentMainTbl = array(
                            'updated_adjustment_deduction_amt' => $updatedDeductAdjust
                        );
                        
                        // update the tbl payment
                        $updateTotalBalanceTblPayment = $this->telegraphicInvoiceModel->updateTotalBalanceIfAddOtherPayment($InvoiceNum, $vendor_code, $totalBal);

                        // $updatePaidAmtTblPayment = $this->telegraphicInvoiceModel->updateTotalPaymentMainTbl($InvoiceNum, $vendor_code, $updatePaidAmt);

                        $updatedAdjustmentDeduction = $this->telegraphicInvoiceModel->updatedAdjustmentDeductionMainTbl($InvoiceNum, $vendor_code, $updateTotalPaymentMainTbl);
   
                        $insert = $this->telegraphicInvoiceModel->insertOtherPayment($data);

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

        //Overpayment - less
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
                $checkIfReferenceNoFirst = $this->telegraphicInvoiceModel->checkIfReferenceNoExisting($referenceNo, $InvoiceNum);

                if($checkIfReferenceNoFirst)
                {
                    $resp = array(
                        'stats'     => '4',
                        'message'   => 'Reference No. already exist in database'
                    );
    
                    echo json_encode($resp); 
                }

                // else if($amt > $initialP)
                // {
                //     $resp = array(
                //         'stats'     => '7',
                //         'message'   => 'Your amount is higher than your balance'
                //     );
    
                //     echo json_encode($resp);
                // }

                else
                {
                    
                    // if($amt == $initialP)
                    // {
                    //     $total = $initialP - $amt;

                    //     $data = array(
                    //     'otherTransTypeCode'    => $type,
                    //     'otherVendorCode'       => $vendor_code,
                    //     'otherInvoiceNumber'    => $InvoiceNum,
                    //     'transactionCode'       => $TransactType,
                    //     'transAmt'              => $updateRemainBal,
                    //     'update_Initial_deduction'  => $total,
                    //     'referenceNumber'       => $referenceNo,
                    //     'Remarks'               => $remarks,
                    //     'otherInvoiceDate'      => date('Y-m-d', strtotime($InvoicDate)),
                    //     'otherInvoiceAmount'    => $InvoiceAmt,
                    //     'otherTotalDeduc'       => $amt,
                    //     'rfp'                   => $rfp,
                    //     'userCreated'           => $this->session->userdata('empName'),
                    //     'dateCreated'           => date('Y-m-d H:i:s'),
                    //     );

                    //     $dataTohistory = array(
                    //     'vendorCode'        => $vendor,
                    //     'accountCode'       => $account,
                    //     'paymentTermCode'   => $currency,
                    //     'accountCurrency'   => $accountCurrency,
                    //     'InvoiceNumber'     => $InvoiceNum,
                    //     'InvoiceDate'       => date('Y-m-d', strtotime($InvoiceDate)),
                    //     'InvoiceAmount'     => $InvoiceAmt,
                    //     'proformaInvoice'   => $proformaInvoice,
                    //     'commercialInvoice' => $commercialInvoice,
                    //     'compCode'          => $company_name,
                    //     'status'            => $status,
                    //     'userCreated'       => $this->session->userdata('empName'),
                    //     'dateCreated'       => date('Y-m-d'),
                    //     );

                    //     //insert to History
                    //     $insertToHistoryTbl = $this->telegraphicInvoiceModel->insertHistoryTBL($dataTohistory);

                    //     //truncate the data from the main tbl
                    //     $deleteToMainTBL = $this->telegraphicInvoiceModel->truncateTBLTelegraphicTransferInvoice($InvoiceNum, $vendor_code);

                    //     $totalBal = array(
                    //         'updated_Initial_payment' => $total
                    //     );
                        
                    //     // update the tbl payment
                    //     $updateTotalBalanceTblPayment = $this->telegraphicInvoiceModel->updateTotalBalanceIfAddOtherPayment($InvoiceNum, $vendor_code, $totalBal);
    
    
                    //     $insert = $this->telegraphicInvoiceModel->insertOtherPayment($data);
    
                    //     if($insert)
                    //     {
                    //         $resp = array(
                    //             'stats'     => 5,
                    //             'message'   => 'Paid. This transaction is automatically tag as closed and transfer to historical data.'
                    //         );
    
                    //         echo json_encode($resp);
                    //     }
    
                    //     else
                    //     {
                    //         $resp = array(
                    //             'message'   => 'Something wrong.'
                    //         );
    
                    //         echo json_encode($resp);
                    //     }      
                    // }
                    

                    //if has a value
                    // else
                    // {

                        // var_dump($initialP);

                        // $total = $amt - $initialP ;

                        
                        // var_dump($total);
                        // exit();

                        $updatedDeductAdjust = $updated_adjustment_deduction + $amt;
                        
                        $totals = $amts - $amt;

                        $data = array(
                            'otherTransTypeCode'    => $type,
                            'otherVendorCode'       => $vendor_code,
                            'otherInvoiceNumber'    => $InvoiceNum,
                            'transactionCode'       => $TransactType,
                            'transAmt'              => $updateRemainBal,
                            'update_Initial_deduction'  => $totals,
                            'referenceNumber'       => $referenceNo,
                            'Remarks'               => $remarks,
                            'otherInvoiceDate'      => date('Y-m-d', strtotime($InvoiceDate)),
                            'otherInvoiceAmount'    => $InvoiceAmt,
                            'otherTotalDeduc'       => $amt,
                            'amount'                => $amts,
                            'total'                 => $totals,
                            'rfp'                   => $rfp,
                            'userCreated'           => $session_user,
                            'dateCreated'           => date('Y-m-d H:i:s'),
                            );

                            // var_dump($data);
                            // exit();
    
                        $totalBal = array(
                            'update_initial_payment2' => $totals
                        );

                        // $updatePaidAmt = array(
                        //     'updated_paid_amount'  => $total
                        // );

                        $updateTotalPaymentMainTbl = array(
                            'updated_adjustment_deduction_amt' => $updatedDeductAdjust
                        );
                        
                        // update the tbl payment
                        $updateTotalBalanceTblPayment = $this->telegraphicInvoiceModel->updateTotalBalanceIfAddOtherPayment($InvoiceNum, $vendor_code, $totalBal);
    
                        // $updatePaidAmtTblPayment = $this->telegraphicInvoiceModel->updateTotalPaymentMainTbl($InvoiceNum, $vendor_code, $updatePaidAmt);

                        $updatedAdjustmentDeduction = $this->telegraphicInvoiceModel->updatedAdjustmentDeductionMainTbl($InvoiceNum, $vendor_code, $updateTotalPaymentMainTbl);
   
                        $insert = $this->telegraphicInvoiceModel->insertOtherPayment($data);
    
                        if($insert)
                        {
                            $resp = array(
                                'stats'     => 6,
                                'message'   => 'Success deduction of Over payment'
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

    public function InsertInitialNonInvoicePay()
    {
        $NonInvoiceVendor = $this->input->post('NonInvoiceVendor');
        $NonInvoiceNumber = $this->input->post('NonInvoiceNumber');
        $NonInvoiceDate = $this->input->post('NonInvoiceDate');
        $NonInvoiceType = $this->input->post('NonInvoiceType'); // TYPE
        $NonInvoiceTransaction = $this->input->post('NonInvoiceTransaction'); //CLAIMS, CREDITS ETC.
        $NonInvoiceAmount = $this->input->post('NonInvoiceAmount');
        $NonInvoiceAmounts = $this->input->post('NonInvoiceAmounts');
        $NonInvoiceReference = $this->input->post('NonInvoiceReference');
        $NonInvoiceRemarks = $this->input->post('NonInvoiceRemarks');
        $NonInvoiceRfp = $this->input->post('NonInvoiceRfp');

        // $inputs = array(
        //     $NonInvoiceDate,
        //     $NonInvoiceAmount,
        //     $NonInvoiceReference,
        //     $NonInvoiceRfp
        // );

        
        if($this->session->userdata('empName')){

            $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }

        if($NonInvoiceDate == '' || $NonInvoiceAmount == '' || $NonInvoiceReference == '' || $NonInvoiceRfp == '' || $NonInvoiceAmounts == '')
        {
            $response = array(
                'status'    => 0,
                'message'   => 'Please input all required fields'
            );


            echo json_encode($response);
        }

        //claims LESS
        else if($NonInvoiceTransaction == 1)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

            if($checkReferenceInDb)
            {
                $resp = array(
                    'status'    => 1.1,
                    'message'   => 'Reference No. already exist'
                );

                echo json_encode($resp);
            }

            //check if match the type and transaction
            else if($NonInvoiceType == 1)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Please choose deduction type'
                );

                echo json_encode($resp);
            }


            else
            {

                $total = $NonInvoiceAmounts - $NonInvoiceAmount;
                    
                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $NonInvoiceAmounts,
                    'total'             => $total,   
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceModel->InsertNonInvoice($data);

                // var_dump($insert);
                // exit();

                if($insert)
                {
                    $resp = array(
                        'status'    => 1.3,
                        'message'   => 'Successfully inserted'
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

        //credit invoice LESS
        else if($NonInvoiceTransaction == 2)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

            if($checkReferenceInDb)
            {
                $resp = array(
                    'status'    => 1.1,
                    'message'   => 'Reference No. already exist'
                );

                echo json_encode($resp);
            }

            //check if match the type and transaction
            else if($NonInvoiceType == 1)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Please choose deduction type'
                );

                echo json_encode($resp);
            }

            else
            {
                $total = $NonInvoiceAmounts - $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $NonInvoiceAmounts,
                    'total'             => $total,
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceModel->InsertNonInvoice($data);

                if($insert)
                {
                    $resp = array(
                        'status'    => 1.3,
                        'message'   => 'Successfully inserted'
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

        //debit invoice LESS OR ADD DEPENDS ON USER
        else if($NonInvoiceTransaction == 3)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

            if($checkReferenceInDb)
            {
                $resp = array(
                    'status'    => 1.1,
                    'message'   => 'Reference No. already exist'
                );

                echo json_encode($resp);
            }

            //check if match the type and transaction
            else if($NonInvoiceType == 1)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Please choose Deduction type'
                );

                echo json_encode($resp);
            }

            else
            {
                $total = $NonInvoiceAmounts - $NonInvoiceAmount;


                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $NonInvoiceAmounts,
                    'total'             => $total, 
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceModel->InsertNonInvoice($data);

                if($insert)
                {
                    $resp = array(
                        'status'    => 1.3,
                        'message'   => 'Successfully inserted'
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

        //Rebate LESS
        else if($NonInvoiceTransaction == 4)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

            if($checkReferenceInDb)
            {
                $resp = array(
                    'status'    => 1.1,
                    'message'   => 'Reference No. already exist'
                );

                echo json_encode($resp);
            }

            //check if match the type and transaction
            else if($NonInvoiceType == 1)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Please choose Deduction type'
                );

                echo json_encode($resp);
            }

            else
            {
                $total = $NonInvoiceAmounts - $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $NonInvoiceAmounts,
                    'total'             => $total, 
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceModel->InsertNonInvoice($data);

                if($insert)
                {
                    $resp = array(
                        'status'    => 1.3,
                        'message'   => 'Successfully inserted'
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

        //Addback ADD
        else if($NonInvoiceTransaction == 5)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

            if($checkReferenceInDb)
            {
                $resp = array(
                    'status'    => 1.1,
                    'message'   => 'Reference No. already exist'
                );

                echo json_encode($resp);
            }

            //check if match the type and transaction
            else if($NonInvoiceType == 2)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Please choose Additional type'
                );

                echo json_encode($resp);
            }

            else
            {
                $total = $NonInvoiceAmounts + $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $NonInvoiceAmounts,
                    'total'             => $total, 
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceModel->InsertNonInvoice($data);

                if($insert)
                {
                    $resp = array(
                        'status'    => 1.3,
                        'message'   => 'Successfully inserted'
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

        //Wire transfer ADD
        else if($NonInvoiceTransaction == 6)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

            if($checkReferenceInDb)
            {
                $resp = array(
                    'status'    => 1.1,
                    'message'   => 'Reference No. already exist'
                );

                echo json_encode($resp);
            }

            //check if match the type and transaction
            else if($NonInvoiceType == 2)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Please choose Additional type'
                );

                echo json_encode($resp);
            }

            else
            {
                $total = $NonInvoiceAmounts + $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $NonInvoiceAmounts,
                    'total'             => $total, 
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceModel->InsertNonInvoice($data);

                if($insert)
                {
                    $resp = array(
                        'status'    => 1.3,
                        'message'   => 'Successfully inserted'
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

        //Freight ADD
        else if($NonInvoiceTransaction == 7)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

            if($checkReferenceInDb)
            {
                $resp = array(
                    'status'    => 1.1,
                    'message'   => 'Reference No. already exist'
                );

                echo json_encode($resp);
            }

            //check if match the type and transaction
            else if($NonInvoiceType == 2)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Please choose Additional type'
                );

                echo json_encode($resp);
            }

            else
            {
                $total = $NonInvoiceAmounts + $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceModel->InsertNonInvoice($data);

                if($insert)
                {
                    $resp = array(
                        'status'    => 1.3,
                        'message'   => 'Successfully inserted'
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
    
        //COMMISSION FEE ADD
        else if($NonInvoiceTransaction == 10)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

            if($checkReferenceInDb)
            {
                $resp = array(
                    'status'    => 1.1,
                    'message'   => 'Reference No. already exist'
                );

                echo json_encode($resp);
            }

            //check if match the type and transaction
            else if($NonInvoiceType == 2)
            {
                $resp = array(
                    'status'    => 1.2,
                    'message'   => 'Please choose Additional type'
                );

                echo json_encode($resp);
            }

            else
            {
                $total = $NonInvoiceAmounts + $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $NonInvoiceAmounts,
                    'total'             => $total,
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceModel->InsertNonInvoice($data);

                if($insert)
                {
                    $resp = array(
                        'status'    => 1.3,
                        'message'   => 'Successfully inserted'
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
    }

    public function fetchNONInvoiceDataToTable()
    {
        $invoice_num = $this->input->post('invoice_num');
        $vendor = $this->input->post('vendor');

        $fetch = $this->telegraphicInvoiceModel->fetchNonInvoiceDataToTableModel($invoice_num, $vendor);

        echo json_encode($fetch);
    }

    public function fetchNONInvoiceData()
    {
        $invoice_num = $this->input->post('invoice_num');
        $vendor = $this->input->post('vendor');

        $fetch = $this->telegraphicInvoiceModel->fetchNonInvoiceData($invoice_num, $vendor);

        echo json_encode($fetch);
    }


}