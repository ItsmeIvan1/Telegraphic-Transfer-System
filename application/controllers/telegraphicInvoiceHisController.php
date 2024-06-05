<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class telegraphicInvoiceHisController extends CI_Controller { 

    public function InitialPaymentDetails()
    {
        $invoice_num = $this->input->post('invoice_num');
        $vendor_code = $this->input->post('vendor_code');

        $fetchInitial = $this->telegraphicInvoiceHisModel->fetchInitialPaymentDetails($invoice_num, $vendor_code);

        echo json_encode($fetchInitial); 
    }

    public function FullPaymentDetails()
    {
        $invoice_num = $this->input->post('invoice_num');
        $vendor_code = $this->input->post('vendor_code');

        $fetchFullPayment = $this->telegraphicInvoiceHisModel->fetchFullPayment($invoice_num, $vendor_code);

        echo json_encode($fetchFullPayment); 
    }

    public function fetchOtherPaymentHis()
    {
        $invoice_num = $this->input->post('invoice_num');
        $vendor_code = $this->input->post('vendor_code');

        $fetch = $this->telegraphicInvoiceHisModel->fetchOtherPaymentHisFunc($invoice_num, $vendor_code);

        echo json_encode($fetch);
    }


    public function updateOtherPaymentTBLHis()
    {
        $type = $this->input->post('type');
        $vendor = $this->input->post('vendor_code');
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

        //overpayment - less
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
                $checkIfReferenceNoFirst = $this->telegraphicInvoiceHisModel->checkIfReferenceNoExisting($referenceNo);

                if($checkIfReferenceNoFirst)
                {
                    $resp = array(
                        'stats'     => '4',
                        'message'   => 'Reference No. already exist in database'
                    );
    
                    echo json_encode($resp); 
                }

                        // if amount is bigger than PO amount
                // else if($amt > $updateRemainBal)
                // {
                //     $resp = array(
                //         'stats'     => 2,
                //         'message'   => 'Invalid amount'
                //     );

                //     echo json_encode($resp);
                // }
                

                else
                {

                    $total = $updateRemainBal - $amt;

                    $totals = $amts - $amt;

                    // var_dump($total);
                    // exit();

                    $data = array(
                    'otherTransTypeCode'    => $type,
                    'otherVendorCode'       => $vendor,
                    'otherInvoiceNumber'    => $InvoiceNum,
                    'transactionCode'       => $TransactType,
                    // 'transAmt'              => $total,
                    'referenceNumber'       => $referenceNo,
                    'Remarks'               => $remarks,
                    'otherInvoiceDate'      => $InvoiceDate,
                    'otherInvoiceAmount'    => $InvoiceAmt,
                    'otherTotalDeduc'       => $amt,
                    'amount'                => $amts,
                    'total'                 => $totals,
                    'rfp'                   => $rfp,
                    'userCreated'           => $session_user,
                    'dateCreated'           => date('Y-m-d')
                    );


                    $totalBal = array(
                        'total_balance' => $totals
                    );

                    $update_paid_amount_HisTbl = array(
                        'updated_paid_amount' =>  $totals
                    );

                    $Update_paid_amt_tblPaymentInvoice = array(
                        'updated_Initial_payment'  => $totals
                    );

                    // update the tbl payment
                    $updateTotalBalanceTblPayment = $this->telegraphicInvoiceHisModel->updateTotalBalanceIfAddOtherPayment($InvoiceNum, $totalBal);

                    //update Paid Amt in historical tbl
                    $updatePaidAmtHisTbl = $this->telegraphicInvoiceHisModel->updatedPaidAmount($InvoiceNum, $vendor, $update_paid_amount_HisTbl);

                    //update paid amt in tbl payment
                    $updatePaidAmtTblPaymentInvoice = $this->telegraphicInvoiceHisModel->updatedPaidAmountTblPaymentInvoice($InvoiceNum, $vendor, $Update_paid_amt_tblPaymentInvoice);

                    $insert = $this->telegraphicInvoiceHisModel->insertOtherPayment($data);

                    if($insert)
                    {
                        $resp = array(
                            'stats'     => 5,
                            'message'   => 'Success'
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

        //Shortpayment - add
        else if($TransactType == 2)
        {

            //make sure the type is deduction
            if($type == 2)
            {
                $resp = array(
                    'stats'     => '3',
                    'message'   => 'Make sure you choose Additional type'
                );

                echo json_encode($resp);
            }

            else
            {
                // check if reference no is existing
                $checkIfReferenceNoFirst = $this->telegraphicInvoiceHisModel->checkIfReferenceNoExisting($referenceNo);

                if($checkIfReferenceNoFirst)
                {
                    $resp = array(
                        'stats'     => '4',
                        'message'   => 'Reference No. already exist in database'
                    );
    
                    echo json_encode($resp); 
                }

                        // if amount is bigger than PO amount
                // else if($amt > $updateRemainBal)
                // {
                //     $resp = array(
                //         'stats'     => 2,
                //         'message'   => 'Invalid amount'
                //     );

                //     echo json_encode($resp);
                // }

                else
                {   

                    $total = $updateRemainBal + $amt;

                    $totals = $amts + $amt;


                    $data = array(
                        'otherTransTypeCode'    => $type,
                        'otherVendorCode'       => $vendor,
                        'otherInvoiceNumber'    => $InvoiceNum,
                        'transactionCode'       => $TransactType,
                        'transAmt'              => $total,
                        'referenceNumber'       => $referenceNo,
                        'Remarks'               => $remarks,
                        'otherInvoiceDate'      => $InvoiceDate,
                        'otherInvoiceAmount'    => $InvoiceAmt,
                        'otherTotalDeduc'       => $amt,
                        'amount'                => $amts,
                        'total'                 => $totals,
                        'rfp'                   => $rfp,
                        'userCreated'           => $session_user,
                        'dateCreated'           => date('Y-m-d')
                        );
    

                    $totalBal = array(
                        'total_balance' => $totals
                    );

                    $update_paid_amount_HisTbl = array(
                        'updated_paid_amount' =>  $totals
                    );
                    
                    // update the tbl payment
                    $updateTotalBalanceTblPayment = $this->telegraphicInvoiceHisModel->updateTotalBalanceIfAddOtherPayment($InvoiceNum, $totalBal);

                    //update Paid Amt in historical tbl
                    $updatePaidAmtHisTbl = $this->telegraphicInvoiceHisModel->updatedPaidAmount($InvoiceNum, $vendor, $update_paid_amount_HisTbl);

                    $insert = $this->telegraphicInvoiceHisModel->insertOtherPayment($data);

                    if($insert)
                    {
                        $resp = array(
                            'stats'     => 5,
                            'message'   => 'Success'
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

        // //DEBIT NOTE - add
        // else if($TransactType == 3)
        // {
        //     //make sure the type is deduction
        //     if($type == 2)
        //     {
        //         $resp = array(
        //             'stats'     => '3',
        //             'message'   => 'Make sure you choose Adjustment type'
        //         );

        //         echo json_encode($resp);
        //     }

        //     else
        //     {
        //         // check if reference no is existing
        //         $checkIfReferenceNoFirst = $this->telegraphicInvoiceHisModel->checkIfReferenceNoExisting($referenceNo);

        //         if($checkIfReferenceNoFirst)
        //         {
        //             $resp = array(
        //                 'stats'     => '4',
        //                 'message'   => 'Reference No. already exist in database'
        //             );
    
        //             echo json_encode($resp); 
        //         }

        //         else
        //         {

        //                 $total =  $amt + $updateRemainBal;

        //                 $data = array(
        //                     'otherTransTypeCode'    => $type,
        //                     'otherVendorCode'       => $vendor,
        //                     'otherInvoiceNumber'    => $InvoiceNum,
        //                     'transactionCode'       => $TransactType,
        //                     'transAmt'              => $total,
        //                     'referenceNumber'       => $referenceNo,
        //                     'Remarks'               => $remarks,
        //                     'otherInvoiceDate'      => $InvoiceDate,
        //                     'otherInvoiceAmount'    => $InvoiceAmt,
        //                     'otherTotalDeduc'       => $amt,
        //                     'rfp'                   => $rfp,
        //                     'userCreated'           => $this->session->userdata('empName'),
        //                     'dateCreated'           => date('Y-m-d')
        //                     );    
    
        //                 $totalBal = array(
        //                     'total_balance' => $total
        //                 );

        //                 $update_paid_amount_HisTbl = array(
        //                     'updated_paid_amount' =>  $total
        //                 );
                        
        //                 // update the tbl payment
        //                 $updateTotalBalanceTblPayment = $this->telegraphicInvoiceHisModel->updateTotalBalanceIfAddOtherPayment($InvoiceNum, $totalBal);
    
        //                 //update Paid Amt in historical tbl
        //                 $updatePaidAmtHisTbl = $this->telegraphicInvoiceHisModel->updatedPaidAmount($InvoiceNum, $vendor, $update_paid_amount_HisTbl);

        //                 $insert = $this->telegraphicInvoiceHisModel->insertOtherPayment($data);
    
        //                 if($insert)
        //                 {
        //                     $resp = array(
        //                         'stats'     => 5,
        //                         'message'   => 'Success adjustment of debit note'
        //                     );
    
        //                     echo json_encode($resp);
        //                 }
    
        //                 else
        //                 {
        //                     $resp = array(
        //                         'message'   => 'Something wrong.'
        //                     );
    
        //                     echo json_encode($resp);
        //                 }
                    


        //         }
                
        //     }
        // }

        // //REBATE - less
        // else if($TransactType == 4)
        // {
        //     //make sure the type is deduction
        //     if($type == 1)
        //     {
        //         $resp = array(
        //             'stats'     => '3',
        //             'message'   => 'Make sure you choose Deduction type'
        //         );

        //         echo json_encode($resp);
        //     }

        //             // if amount is bigger than PO amount
        //     // else if($amt > $updateRemainBal)
        //     // {
        //     //     $resp = array(
        //     //         'stats'     => 2,
        //     //         'message'   => 'Invalid amount'
        //     //     );

        //     //     echo json_encode($resp);
        //     // }

        //     else
        //     {
        //         // check if reference no is existing
        //         $checkIfReferenceNoFirst = $this->telegraphicInvoiceHisModel->checkIfReferenceNoExisting($referenceNo);

        //         if($checkIfReferenceNoFirst)
        //         {
        //             $resp = array(
        //                 'stats'     => '4',
        //                 'message'   => 'Reference No. already exist in database'
        //             );
    
        //             echo json_encode($resp); 
        //         }

        //         else
        //         {
        //             $total = $updateRemainBal - $amt;

        //             $data = array(
        //                 'otherTransTypeCode'    => $type,
        //                 'otherVendorCode'       => $vendor,
        //                 'otherInvoiceNumber'    => $InvoiceNum,
        //                 'transactionCode'       => $TransactType,
        //                 'transAmt'              => $total,
        //                 'referenceNumber'       => $referenceNo,
        //                 'Remarks'               => $remarks,
        //                 'otherInvoiceDate'      => $InvoiceDate,
        //                 'otherInvoiceAmount'    => $InvoiceAmt,
        //                 'otherTotalDeduc'       => $amt,
        //                 'rfp'                   => $rfp,
        //                 'userCreated'           => $this->session->userdata('empName'),
        //                 'dateCreated'           => date('Y-m-d')
        //                 ); 

        //             $totalBal = array(
        //                 'total_balance' => $total
        //             );
                    
        //             $update_paid_amount_HisTbl = array(
        //                 'updated_paid_amount' =>  $total
        //             );

        //             // update the tbl payment
        //             $updateTotalBalanceTblPayment = $this->telegraphicInvoiceHisModel->updateTotalBalanceIfAddOtherPayment($InvoiceNum, $totalBal);

        //             //update Paid Amt in historical tbl
        //             $updatePaidAmtHisTbl = $this->telegraphicInvoiceHisModel->updatedPaidAmount($InvoiceNum, $vendor, $update_paid_amount_HisTbl);


        //             $insert = $this->telegraphicInvoiceHisModel->insertOtherPayment($data);

        //             if($insert)
        //             {
        //                 $resp = array(
        //                     'stats'     => 5,
        //                     'message'   => 'Success deduction of rebate'
        //                 );

        //                 echo json_encode($resp);
        //             }

        //             else
        //             {
        //                 $resp = array(
        //                     'message'   => 'Something wrong.'
        //                 );

        //                 echo json_encode($resp);
        //             }
                    
        //         }
                
        //     } 
        // }

        // //ADDBACK - add
        // else if($TransactType == 5)
        // {
        //     //make sure the type is deduction
        //     if($type == 2)
        //     {
        //         $resp = array(
        //             'stats'     => '3',
        //             'message'   => 'Make sure you choose Adjustment type'
        //         );

        //         echo json_encode($resp);
        //     }

        //     else
        //     {
        //         // check if reference no is existing
        //         $checkIfReferenceNoFirst = $this->telegraphicInvoiceHisModel->checkIfReferenceNoExisting($referenceNo);

        //         if($checkIfReferenceNoFirst)
        //         {
        //             $resp = array(
        //                 'stats'     => '4',
        //                 'message'   => 'Reference No. already exist in database'
        //             );
    
        //             echo json_encode($resp); 
        //         }

        //         else
        //         {
        //             $total =  $amt + $updateRemainBal;

        //             $data = array(
        //             'otherTransTypeCode'    => $type,
        //             'otherVendorCode'       => $vendor,
        //             'otherInvoiceNumber'    => $InvoiceNum,
        //             'transactionCode'       => $TransactType,
        //             'transAmt'              => $total,
        //             'referenceNumber'       => $referenceNo,
        //             'Remarks'               => $remarks,
        //             'otherInvoiceDate'      => $InvoiceDate,
        //             'otherInvoiceAmount'    => $InvoiceAmt,
        //             'otherTotalDeduc'       => $amt,
        //             'rfp'                   => $rfp,
        //             'userCreated'           => $this->session->userdata('empName'),
        //             'dateCreated'           => date('Y-m-d')
        //             ); 

        //             $totalBal = array(
        //                 'total_balance' => $total
        //             );

        //             $update_paid_amount_HisTbl = array(
        //                 'updated_paid_amount' =>  $total
        //             );
                    
        //             // update the tbl payment
        //             $updateTotalBalanceTblPayment = $this->telegraphicInvoiceHisModel->updateTotalBalanceIfAddOtherPayment($InvoiceNum, $totalBal);

        //             //update Paid Amt in historical tbl
        //             $updatePaidAmtHisTbl = $this->telegraphicInvoiceHisModel->updatedPaidAmount($InvoiceNum, $vendor, $update_paid_amount_HisTbl);


        //             $insert = $this->telegraphicInvoiceHisModel->insertOtherPayment($data);

        //             if($insert)
        //             {
        //                 $resp = array(
        //                     'stats'     => 5,
        //                     'message'   => 'Success Adjustment of AddBack'
        //                 );

        //                 echo json_encode($resp);
        //             }

        //             else
        //             {
        //                 $resp = array(
        //                     'message'   => 'Something wrong.'
        //                 );

        //                 echo json_encode($resp);
        //             }

        //         }
                
        //     } 
        // }

        // //WIRE TRANSFER - add
        // else if($TransactType == 6)
        // {
        //     //make sure the type is deduction
        //     if($type == 2)
        //     {
        //         $resp = array(
        //             'stats'     => '3',
        //             'message'   => 'Make sure you choose Adjustment type'
        //         );

        //         echo json_encode($resp);
        //     }

        //     else
        //     {
        //         // check if reference no is existing
        //         $checkIfReferenceNoFirst = $this->telegraphicInvoiceHisModel->checkIfReferenceNoExisting($referenceNo);

        //         if($checkIfReferenceNoFirst)
        //         {
        //             $resp = array(
        //                 'stats'     => '4',
        //                 'message'   => 'Reference No. already exist in database'
        //             );
    
        //             echo json_encode($resp); 
        //         }

        //         else
        //         {
        //             $total =  $amt + $updateRemainBal;

        //             $data = array(
        //             'otherTransTypeCode'    => $type,
        //             'otherVendorCode'       => $vendor,
        //             'otherInvoiceNumber'    => $InvoiceNum,
        //             'transactionCode'       => $TransactType,
        //             'transAmt'              => $total,
        //             'referenceNumber'       => $referenceNo,
        //             'Remarks'               => $remarks,
        //             'otherInvoiceDate'      => $InvoiceDate,
        //             'otherInvoiceAmount'    => $InvoiceAmt,
        //             'otherTotalDeduc'       => $amt,
        //             'rfp'                   => $rfp,
        //             'userCreated'           => $this->session->userdata('empName'),
        //             'dateCreated'           => date('Y-m-d')
        //             ); 

        //             $totalBal = array(
        //                 'total_balance' => $total
        //             );
                    
        //             $update_paid_amount_HisTbl = array(
        //                 'updated_paid_amount' =>  $total
        //             );

        //             // update the tbl payment
        //             $updateTotalBalanceTblPayment = $this->telegraphicInvoiceHisModel->updateTotalBalanceIfAddOtherPayment($InvoiceNum, $totalBal);

        //             //update Paid Amt in historical tbl
        //             $updatePaidAmtHisTbl = $this->telegraphicInvoiceHisModel->updatedPaidAmount($InvoiceNum, $vendor, $update_paid_amount_HisTbl);


        //             $insert = $this->telegraphicInvoiceHisModel->insertOtherPayment($data);

        //             if($insert)
        //             {
        //                 $resp = array(
        //                     'stats'     => 5,
        //                     'message'   => 'Success Adjustment of Wire transfer'
        //                 );

        //                 echo json_encode($resp);
        //             }

        //             else
        //             {
        //                 $resp = array(
        //                     'message'   => 'Something wrong.'
        //                 );

        //                 echo json_encode($resp);
        //             }

        //         }
                
        //     } 
        // }

        // //FREIGHT - add
        // else if($TransactType == 7)
        // {
        //     //make sure the type is deduction
        //     if($type == 2)
        //     {
        //         $resp = array(
        //             'stats'     => '3',
        //             'message'   => 'Make sure you choose Adjustment type'
        //         );

        //         echo json_encode($resp);
        //     }

        //     else
        //     {
        //         // check if reference no is existing
        //         $checkIfReferenceNoFirst = $this->telegraphicInvoiceHisModel->checkIfReferenceNoExisting($referenceNo);

        //         if($checkIfReferenceNoFirst)
        //         {
        //             $resp = array(
        //                 'stats'     => '4',
        //                 'message'   => 'Reference No. already exist in database'
        //             );
    
        //             echo json_encode($resp); 
        //         }

        //         else
        //         {
        //             $total =  $amt + $updateRemainBal;

        //             $data = array(
        //             'otherTransTypeCode'    => $type,
        //             'otherVendorCode'       => $vendor,
        //             'otherInvoiceNumber'    => $InvoiceNum,
        //             'transactionCode'       => $TransactType,
        //             'transAmt'              => $total,
        //             'referenceNumber'       => $referenceNo,
        //             'Remarks'               => $remarks,
        //             'otherInvoiceDate'      => $InvoiceDate,
        //             'otherInvoiceAmount'    => $InvoiceAmt,
        //             'otherTotalDeduc'       => $amt,
        //             'rfp'                   => $rfp,
        //             'userCreated'           => $this->session->userdata('empName'),
        //             'dateCreated'           => date('Y-m-d')
        //             ); 

        //             $totalBal = array(
        //                 'total_balance' => $total
        //             );

        //             $update_paid_amount_HisTbl = array(
        //                 'updated_paid_amount' =>  $total
        //             );
                    
        //             // update the tbl payment
        //             $updateTotalBalanceTblPayment = $this->telegraphicInvoiceHisModel->updateTotalBalanceIfAddOtherPayment($InvoiceNum, $totalBal);

        //             //update Paid Amt in historical tbl
        //             $updatePaidAmtHisTbl = $this->telegraphicInvoiceHisModel->updatedPaidAmount($InvoiceNum, $vendor, $update_paid_amount_HisTbl);

        //             $insert = $this->telegraphicInvoiceHisModel->insertOtherPayment($data);

        //             if($insert)
        //             {
        //                 $resp = array(
        //                     'stats'     => 5,
        //                     'message'   => 'Success Adjustment of Freight'
        //                 );

        //                 echo json_encode($resp);
        //             }

        //             else
        //             {
        //                 $resp = array(
        //                     'message'   => 'Something wrong.'
        //                 );

        //                 echo json_encode($resp);
        //             }

        //         }
                
        //     } 
        // }

 

    

    




        
    }

    public function InsertInitialNonInvoicePay()
    {
        $NonInvoiceVendor = $this->input->post('NonInvoiceVendor');
        $NonInvoiceNumber = $this->input->post('NonInvoiceNumber');

        $NonInvoiceDate = $this->input->post('NonInvoiceDate');
        $NonInvoiceType = $this->input->post('NonInvoiceType'); // TYPE
        $NonInvoiceTransaction = $this->input->post('NonInvoiceTransaction'); //CLAIMS, CREDITS ETC.
        $NonInvoiceAmount = $this->input->post('NonInvoiceAmount');
        $nonInvoiceAmounts = $this->input->post('nonInvoiceAmounts');
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

        if($NonInvoiceDate == '' || $NonInvoiceAmount == '' || $NonInvoiceReference == '' || $NonInvoiceRfp == '' || $nonInvoiceAmounts == '')
        {
            $response = array(
                'status'    => 0,
                'message'   => 'Please input all required fields'
            );


            echo json_encode($response);
        }

        //claims less
        else if($NonInvoiceTransaction == 1)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceHisModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

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
                $total = $nonInvoiceAmounts - $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $nonInvoiceAmounts,
                    'total'             => $total,
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceHisModel->InsertNonInvoice($data);

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

        //credit invoice les
        else if($NonInvoiceTransaction == 2)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceHisModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

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
                $total = $nonInvoiceAmounts - $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $nonInvoiceAmounts,
                    'total'             => $total,
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                // var_dump($data);
                // exit();

                $insert = $this->telegraphicInvoiceHisModel->InsertNonInvoice($data);

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

        //debit invoice less or add depends on user
        else if($NonInvoiceTransaction == 3)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceHisModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

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
                $total = $nonInvoiceAmounts - $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $nonInvoiceAmounts,
                    'total'             => $total,
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceHisModel->InsertNonInvoice($data);

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

        //Rebate less
        else if($NonInvoiceTransaction == 4)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceHisModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

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
                $total = $nonInvoiceAmounts - $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $nonInvoiceAmounts,
                    'total'             => $total,
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceHisModel->InsertNonInvoice($data);

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

        //Addback add
        else if($NonInvoiceTransaction == 5)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceHisModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

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
                $total = $nonInvoiceAmounts + $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $nonInvoiceAmounts,
                    'total'             => $total,
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceHisModel->InsertNonInvoice($data);

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

        //Wire transfer add
        else if($NonInvoiceTransaction == 6)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceHisModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

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
                $total = $nonInvoiceAmounts + $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $nonInvoiceAmounts,
                    'total'             => $total,
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceHisModel->InsertNonInvoice($data);

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
 
        //Freight add
        else if($NonInvoiceTransaction == 7)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceHisModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

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
                $total = $nonInvoiceAmounts + $NonInvoiceAmount;

                $data = array(
                    'invoice_number'    => $NonInvoiceNumber,
                    'vendor'            => $NonInvoiceVendor,
                    'date'              => $NonInvoiceDate,
                    'transaction'       => $NonInvoiceTransaction,
                    'transact_type'     => $NonInvoiceType,
                    'amount'            => $NonInvoiceAmount,
                    'amount2'           => $nonInvoiceAmounts,
                    'total'             => $total,
                    'reference_no'      => $NonInvoiceReference,
                    'remarks'           => $NonInvoiceRemarks,
                    'rfp'               => $NonInvoiceRfp,
                    'date_created'      => date('Y-m-d H:i:s'),
                    'user_created'      => $session_user,
                );

                $insert = $this->telegraphicInvoiceHisModel->InsertNonInvoice($data);

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

        //Commission fee add
        else if($NonInvoiceTransaction == 10)
        {
            //check reference no exist in db
            $checkReferenceInDb = $this->telegraphicInvoiceHisModel->checkReferenceNonInvoice($NonInvoiceReference, $NonInvoiceNumber, $NonInvoiceVendor);

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

                $total = $nonInvoiceAmounts + $NonInvoiceAmount;

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

                $insert = $this->telegraphicInvoiceHisModel->InsertNonInvoice($data);

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

        $fetch = $this->telegraphicInvoiceHisModel->fetchNonInvoiceDataToTableModel($invoice_num, $vendor);
        
        echo json_encode($fetch);
    }

    
  
}