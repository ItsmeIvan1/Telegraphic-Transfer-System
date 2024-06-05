<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class telegraphicTransferHistoryController extends CI_Controller {

    public function InitialPaymentDetails()
    {
        $PO_number = $this->input->post('PO_number');
        $vendor =   $this->input->post('vendor');

        $fetchInitial = $this->telegraphicTransferHistoryModel->fetchInitialPaymentDetails($PO_number, $vendor);

        echo json_encode($fetchInitial); 
    }

    public function viewFullpayments()
    { 
        $PO_number = $this->input->post('PO_number');
        $vendor =   $this->input->post('vendor');

        $viewFullPayment = $this->telegraphicTransferHistoryModel->ViewFullPaymentDetails($PO_number, $vendor);

        echo json_encode($viewFullPayment);
        
    }

    public function fetchOtherPaymentHis()
    {
        $po_num = $this->input->post('po_num');
        $vendor =   $this->input->post('vendor');

        $fetch = $this->telegraphicTransferHistoryModel->fetchOtherPaymentHisFunc($po_num, $vendor);

        echo json_encode($fetch);
    }

    public function updateOtherPaymentTBLHis()
    {
        $type = $this->input->post('type');
        $POnum = $this->input->post('POnum');
        $vendor_code = $this->input->post('vendor');
        $POamt = $this->input->post('POamt');
        $POdate = $this->input->post('POdate');
        $TransactType = $this->input->post('TransactType');
        $referenceNo = $this->input->post('referenceNo');
        $remarks = $this->input->post('remarks');
        $amt = $this->input->post('amt');

        $amts = $this->input->post('amts');

        $total_paid = $this->input->post('totalPaid');

        $updateRemainBal = $this->input->post('remainBal');

        $updatedInitialPay = $this->input->post('updatedInitialPay');

        $rfp = $this->input->post('rfp');

        
        if($this->session->userdata('empName')){

        $session_user = $this->session->userdata('empName');

        }else if($this->session->userdata('username'))
        {
            $session_user = $this->session->userdata('username');
        }


        //check if amount or reference if have a value
        if($amt == '' || $referenceNo == '' || $TransactType == '' || $amts == '')
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
                        'message'   => 'Reference No. already exist in database'
                    );

                    echo json_encode($resp); 
                }

                else
                {
                    $total =  $amt + $updatedInitialPay;

                    $updatedPaid = $total_paid + $amt;

                    // var_dump($total);
                    // var_dump($updatedPaid);

                    // exit();

                    $totals = $amt + $amts;

                    $data = array(
                    'otherTransTypeCode'    => $type,
                    'otherVendorCode'       => $vendor_code,
                    'otherPONumber'         => $POnum,
                    'transactionCode'       => $TransactType,
                    // 'transAmt'              => $updateRemainBal,
                    'referenceNumber'       => $referenceNo,
                    'Remarks'               => $remarks,
                    'otherPODate'           => $POdate,
                    'otherPOAmount'         => $POamt,
                    'otherTotalDeduc'       => $amt,
                    'total_paid_amount'     => $updatedPaid,
                    'updated_deduct_adjustment' => $total,
                    'amount'                => $amts,
                    'total'                 => $totals,
                    'rfp'                   => $rfp,
                    'userCreated'           => $session_user,
                    'dateCreated'           => date('Y-m-d H:i:s')
                    );

                    $totalBal = array(
                        'updated_total_payment' => $total
                    );

                    $updateTotalPaymentTblPayment = array(
                        'total_payment' => $updatedPaid
                    );

                    $updatePaidPaymentTblPayment = array(
                        'updated_paid_amount'  => $updatedPaid
                    );

                    $updatePaidPaymentOther = array(
                        'total_paid_amount'  => $updatedPaid
                    );

                    $UpdatedBalance = array(
                        'updated_balanced' => $total
                    );
                    
                    // update the tbl payment
                    $updateTotalBalanceTblPayment = $this->telegraphicTransferModel->updateTotalBalanceIfAddOtherPayment($POnum, $totalBal, $vendor_code);

                    $updateTotalBalanceTblPayment = $this->telegraphicTransferHistoryModel->updateTotalBalanceTblPayment($POnum, $vendor_code, $updateTotalPaymentTblPayment);

                    $updatePaidAmountHisTbl = $this->telegraphicTransferHistoryModel->updateTotalBalancedHisTbl($POnum, $vendor_code, $updatePaidPaymentTblPayment);

                    $updatePaidPaymentOtherTbl = $this->telegraphicTransferHistoryModel->updateTotalPaidAmountOtherTbl($POnum, $vendor_code, $updatePaidPaymentOther);
                  
                    $updateTotalBalanceMainHisTbl = $this->telegraphicTransferHistoryModel->updateTotalBalancedHisTbl($POnum, $vendor_code, $UpdatedBalance);

                    $insert = $this->telegraphicTransferModel->insertOtherPayment($data);

                    if($insert)
                    {
                        $resp = array(
                            'stats'     => 5,
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
                        'message'   => 'Reference No. already exist in database'
                    );
    
                    echo json_encode($resp); 
                }

                else
                { 
                    // check if amount is higher than remaining balance
                    // if($amt > $updateRemainBal)
                    // {
                    //     $resp = array(
                    //         'stats'     => 2,
                    //         'message'   => 'Your amount is higher than your balance, please input right amount.'
                    //     );

                    //     echo json_encode($resp);
                    // }

                
                        $total =  $updatedInitialPay - $amt;

                        $update_total_payment = $total_paid - $amt;

                        // var_dump($total);
                        // var_dump($update_total_payment);

                        // exit();

                        $totals = $amts - $amt;

                        $data = array(
                        'otherTransTypeCode'    => $type,
                        'otherVendorCode'       => $vendor_code,
                        'otherPONumber'         => $POnum,
                        'transactionCode'       => $TransactType,
                        // 'transAmt'              => $updateRemainBal,
                        'referenceNumber'       => $referenceNo,
                        'Remarks'               => $remarks,
                        'otherPODate'           => $POdate,
                        'otherPOAmount'         => $POamt,
                        'otherTotalDeduc'       => $amt,
                        'total_paid_amount'     => $update_total_payment,
                        'updated_deduct_adjustment' => $total,
                        'amount'                => $amts,
                        'total'                 => $totals,
                        'rfp'                   => $rfp,
                        'userCreated'           => $session_user,
                        'dateCreated'           => date('Y-m-d H:i:s')
                        );

                        $totalBal = array(
                            'updated_total_payment' => $total
                        );

                        $updateTotalPaymentTblPayment = array(
                            'total_payment' => $update_total_payment
                        );

                        $updatePaidPaymentTblPayment = array(
                            'updated_paid_amount'  => $update_total_payment
                        );

                        $updatePaidPaymentOther = array(
                            'total_paid_amount'  => $update_total_payment
                        );

                        $UpdatedBalance = array(
                            'updated_balanced' => $total
                        );

                        $update = array(
                            'total_paid_initial'    => $update_total_payment
                        );

            
                        // update the tbl payment
                        $updateTotalBalanceTblPayment = $this->telegraphicTransferModel->updateTotalBalanceIfAddOtherPayment($POnum, $totalBal, $vendor_code);

                        $updateTotalBalanceTblPayment = $this->telegraphicTransferHistoryModel->updateTotalBalanceTblPayment($POnum, $vendor_code, $updateTotalPaymentTblPayment);

                        $updatePaidAmountHisTbl = $this->telegraphicTransferHistoryModel->updateTotalBalancedHisTbl($POnum, $vendor_code, $updatePaidPaymentTblPayment);

                        $updatePaidPaymentOtherTbl = $this->telegraphicTransferHistoryModel->updateTotalPaidAmountOtherTbl($POnum, $vendor_code, $updatePaidPaymentOther);
                      
                        $updateTotalBalanceMainHisTbl = $this->telegraphicTransferHistoryModel->updateTotalBalancedHisTbl($POnum, $vendor_code, $UpdatedBalance);

                        $pagbabago = $this->telegraphicTransferHistoryModel->updateTotalBalanceTblPaymentTotalPaid($POnum, $vendor_code, $update);

                        $insert = $this->telegraphicTransferModel->insertOtherPayment($data);

                        if($insert)
                        {
                            $resp = array(
                                'stats'     => 5,
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
                    

                }
                
            }


        }
        
    }

    public function fetchNONPOdataToTBL()
    {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');

        $fetchData = $this->telegraphicTransferHistoryModel->fetchDataOtherPaymentNONPOToTBL($po, $vendor);

        echo json_encode($fetchData);
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

        $amountt = $this->input->post('amountt');


        
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
            $amountt
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
        
        //CLAIMS - DEDUCTION
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
      
                $checkIfExistRefNo = $this->telegraphicTransferHistoryModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
        
           
                if($checkIfExistRefNo)
                {
                    $resp = array(
                        'status'    => 1.3,
                        'message'   => 'Reference No. exist in database'
                    );
    
                    echo json_encode($resp);
    
                }

                else
                {       
                    $tot = $amountt - $amount;

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
                        'amount2'       => $amountt,
                        'total'         => $tot,
                        'date_created'  => date('Y-m-d H:i:s'),
                        'user_created'  => $session_user
                    );

                    // var_dump($data);
                    // exit();

                    $insertTblOtherTransactNonPO = $this->telegraphicTransferHistoryModel->insertTBLOtherPaymentNONPO($data);

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

        //CREDIT INVOICE - DEDUCTION
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
                $checkIfExistRefNo = $this->telegraphicTransferHistoryModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);

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

                else
                {
                    $tot = $amountt - $amount;

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
                        'amount2'       => $amountt,
                        'total'         => $tot,
                        'date_created'  => date('Y-m-d H:i:s'),
                        'user_created'  => $session_user
                    );
        
                    // var_dump($data);
                    // exit();
        
                    $insertTblOtherTransactNonPO = $this->telegraphicTransferHistoryModel->insertTBLOtherPaymentNONPO($data);
        
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

        //DEBIT NOTE - DEDUCTION OR ADDITIONAL DEPENDS USER
        else if($transaction == 3)
        {
            $checkIfExistRefNo = $this->telegraphicTransferHistoryModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
        
            
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
            
            else
            {   
                $tot = $amountt - $amount;

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
                    'amount2'       => $amountt,
                    'total'         => $tot,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user
                );
    
                // var_dump($data);
                // exit();
    
                $insertTblOtherTransactNonPO = $this->telegraphicTransferHistoryModel->insertTBLOtherPaymentNONPO($data);
    
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

        //REBATE - DEDUCTION
        else if($transaction == 4)
        {
            $checkIfExistRefNo = $this->telegraphicTransferHistoryModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
            
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
            
            else
            {
                $tot = $amountt - $amount;

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
                    'amount2'       => $amountt,
                    'total'         => $tot,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user
                );
    
                // var_dump($data);
                // exit();
    
                $insertTblOtherTransactNonPO = $this->telegraphicTransferHistoryModel->insertTBLOtherPaymentNONPO($data);
    
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

        //ADDBACK - ADDITION
        else if($transaction == 5)
        {
            $checkIfExistRefNo = $this->telegraphicTransferHistoryModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
        
           
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
                $tot = $amountt + $amount;

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
                    'amount2'       => $amountt,
                    'total'         => $tot,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user
                );
    
                // var_dump($data);
                // exit();
    
                $insertTblOtherTransactNonPO = $this->telegraphicTransferHistoryModel->insertTBLOtherPaymentNONPO($data);
    
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

        //WIRE TRANSFER - ADDITION
        else if($transaction == 6)
        {
            $checkIfExistRefNo = $this->telegraphicTransferHistoryModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
        
           
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
                $tot = $amountt + $amount;

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
                    'amount2'       => $amountt,
                    'total'         => $tot,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user
                );
    
                // var_dump($data);
                // exit();
    
                $insertTblOtherTransactNonPO = $this->telegraphicTransferHistoryModel->insertTBLOtherPaymentNONPO($data);
    
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

        //FREIGHT - ADDITION
        else if($transaction == 7)
        {
            $checkIfExistRefNo = $this->telegraphicTransferHistoryModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
        
            
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
                $tot = $amountt + $amount;

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
                    'amount2'       => $amountt,
                    'total'         => $tot,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user
                );
    
                // var_dump($data);
                // exit();
    
                $insertTblOtherTransactNonPO = $this->telegraphicTransferHistoryModel->insertTBLOtherPaymentNONPO($data);
    
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

        //COMMISSION FEE - ADDITION
        else if($transaction == 10)
        {
            $checkIfExistRefNo = $this->telegraphicTransferHistoryModel->checkReferenceNoExistInNONPO($reference_no, $po_number, $vendor);
        
            
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
                $tot = $amountt + $amount;

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
                    'amount2'       => $amountt,
                    'total'         => $tot,
                    'date_created'  => date('Y-m-d H:i:s'),
                    'user_created'  => $session_user
                );
    
                // var_dump($data);
                // exit();
    
                $insertTblOtherTransactNonPO = $this->telegraphicTransferHistoryModel->insertTBLOtherPaymentNONPO($data);
    
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
    

  
}