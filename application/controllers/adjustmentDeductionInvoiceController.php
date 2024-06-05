<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class adjustmentDeductionInvoiceController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        // $this->load->helper(array('form', 'url'));
        $this->load->library('pdf');
        
    }

    public function generateExcelReportsInvoice()
    {
        
        // Retrieve input data
        $company = $this->input->post('company');
        $vendor = $this->input->post('vendor');
        $reference = $this->input->post('referenceNo');
        // $transaction = $this->input->post('transaction');
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');
    
        
        
    
        // Set up Excel sheet
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Telegraphic Transfer Invoice');
    
  
        $header = array(
            'DATE',
            'VENDOR',
            'INVOICE NUMBER', 
            'INVOICE DATE',
            'COMPANY', 
            'PRO-FORMA INVOICE',
            'COMMERCIAL INVOICE',
            'CURRENCY',
            'AMOUNT',
            'PAID AMOUNT',
            'BALANCE',
            'PAYMENT TYPE',
            'DATE CREATED',
            'REFERENCE NO', 
            'REMARKS',
            'RFP'
        );
    
       
        $this->excel->getActiveSheet()->fromArray([$header]);
    
        
        $headerRange = 'A1:P1';
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
    
        $data = $this->adjustmentDeductionReportInvoiceModel->generateReportInvoices($company, $vendor, $reference, $dateFrom, $dateTo);


        $rowNumber = 2; 

        foreach ($data as $row)
        {

            $column = 'A';

                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['dateCreated']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['vendorName']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['InvoiceNumber']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['InvoiceDate']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['company_name']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['proformaInvoice']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['commercialInvoice']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['currency']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['InvoiceAmount']);
                $column++;

                // $cellCoordinate = $column . $rowNumber; // Get the cell coordinate

                // $headerRange2 = $cellCoordinate;

                // $headerStyleArray2 = array(
                //     'fill' => array(
                //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //         'color' => array('rgb' => 'FF0000'),
                //     ),

                //     'font' => array(
                //         'bold' => true,
                //         'color' => array('rgb' => 'FFFFFF'), // Set your desired font color
                //     ),
                // ); 

                // $this->excel->getActiveSheet()->getStyle($headerRange2)->applyFromArray($headerStyleArray2);

                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                $column++;

                // $cellCoordinate = $column . $rowNumber; // Get the cell coordinate

                // $headerRange1 = $cellCoordinate;

                // $headerStyleArray1 = array(
                //     'fill' => array(
                //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //         'color' => array('rgb' => 'FFFF00'),
                //     ),
                // ); 

                // $this->excel->getActiveSheet()->getStyle($headerRange1)->applyFromArray($headerStyleArray1);

                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber,  $row['remarks']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['rfp']);
            
                // Increment rowNumber here, outside of the inner loop
                $rowNumber++;


                $generatePayment = $this->adjustmentDeductionReportInvoiceModel->generateInvoicePayment($company, $vendor, $row['InvoiceNumber']);

                $total = 0;
                
                foreach($generatePayment as $generatePayments)
                {

                    $column1 = 'A';

                    //sum of total initial payment
                    $total += floatval($generatePayments['origTotalPayment']);

                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, $generatePayments['total_payment']);
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, $generatePayments['total_balance']);
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber,  $generatePayments['paymentName']);
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber,  $generatePayments['date_created']);
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, $generatePayments['remarks']);
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, $generatePayments['rfp']);
                    $column1++;

                    $rowNumber++;

                }
                
                // $rowNumber++;

                $otherPayment = $this->adjustmentDeductionReportInvoiceModel->generateOtherPaymentInvoice($company, $reference, $vendor, $row['InvoiceNumber']);

                $totalOtherPayment = 0;
                
                foreach($otherPayment AS $otherPayments)
                {
                    $column2 = 'A';

                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    if($otherPayments['otherTransTypeCode'] == 2)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '('. number_format($otherPayments['amount'], 2, '.', ',') . ')');
                        $column2++;
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, number_format($otherPayments['amount'], 2, '.', ','));
                        $column2++;
                    }

                    if($otherPayments['otherTransTypeCode'] == 2)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '(' . number_format($otherPayments['origTotalDeduc'], 2, '.', ',') . ')');
                        $column2++;

                        $totalOtherPayment += floatval((-$otherPayments['origTotalDeduc']));
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, number_format($otherPayments['origTotalDeduc'], 2, '.', ','));
                        $column2++;

                        $totalOtherPayment += floatval($otherPayments['origTotalDeduc']);
                    }

                    if($otherPayments['total'] == 0)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, number_format($otherPayments['total'], 2, '.', ','));
                        $column2++;
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '(' . number_format($otherPayments['total'], 2, '.', ',') . ')');
                        $column2++;
                    }
                    


                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber,  $otherPayments['transact_name']);
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber,  $otherPayments['dateCreated']);
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, $otherPayments['referenceNumber']);
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, $otherPayments['remarks']);
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, $otherPayments['rfp']);
                    $column2++;

                    $rowNumber++;
                    
                }

                // $rowNumber++;

                $nonInvoicePayment = $this->adjustmentDeductionReportInvoiceModel->generateNonInvoiceRelatedPayment($company, $reference, $vendor, $row['InvoiceNumber']);

                $totalDeduc = 0;   
                foreach($nonInvoicePayment as $nonInvoicePayments)
                {
                    $column3 = 'A';

                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;

                    if($nonInvoicePayments['transact_type'] == 2)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '('. number_format($nonInvoicePayments['amount2'], 2, '.', ',') . ')');
                        $column3++;
                    }
                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber,  number_format($nonInvoicePayments['amount2'], 2, '.', ',') );
                        $column3++;
                    }


                    if($nonInvoicePayments['transact_type'] == 2)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '('. number_format($nonInvoicePayments['amount'], 2, '.', ',') . ')');
                        $column3++;

                        $totalDeduc += floatval((-$nonInvoicePayments['amount']));
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, number_format($nonInvoicePayments['amount'], 2, '.', ',') );
                        $column3++;

                        $totalDeduc += floatval($nonInvoicePayments['amount']);
                    }

                    if($nonInvoicePayments['total'] == 0)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, number_format($nonInvoicePayments['total'], 2, '.', ',') );
                        $column3++;
                    }
                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '('. number_format($nonInvoicePayments['total'], 2, '.', ',') . ')');
                        $column3++;
                    }

                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber,  $nonInvoicePayments['transactionName']);
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber,  $nonInvoicePayments['date_created']);
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, $nonInvoicePayments['reference_no']);
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, $nonInvoicePayments['remarks']);
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, $nonInvoicePayments['rfp']);
                    $column3++;

                    $rowNumber++;
                }


                if($generatePayments['total_balance'] == 0)
                {
                    $finalPayment = $totalOtherPayment + $totalDeduc;
                }
                else
                {
                    $finalPayment = $total + $totalOtherPayment + $totalDeduc;
                }

          
                $column4 = 'I';

                $this->excel->getActiveSheet()->setCellValue($column4 . $rowNumber, 'Total: ');
                $column4++;

                $column5 = 'J';

                $this->excel->getActiveSheet()->setCellValue($column5 . $rowNumber, number_format(abs($finalPayment), 2, '.', ','));
                $column5++;

                $rowNumber++;
        }
    
        // $lastColumn = 'M';
        // $lastRow = count($data) + 1; 
        // $range = "A1:{$lastColumn}{$lastRow}";
        // $styleArray = array(
        //     'borders' => array(
        //         'allborders' => array(
        //             'style' => PHPExcel_Style_Border::BORDER_THIN,
        //         ),
        //     ),
        // );
        // $this->excel->getActiveSheet()->getStyle($range)->applyFromArray($styleArray);
    

        $filename = 'TTS_PO.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    
        ob_start();
        $objWriter->save('php://output');
        $excelOutput = ob_get_clean();
    
       
        $this->session->set_userdata('excel_data_Invoice', base64_encode($excelOutput));
    
        echo json_encode(array('success' => true));
        exit();
        
    }
    

    public function downloadExcelFileInvoice()
    {
        // Retrieve the Excel data from the session
        $excelDataAll = $this->session->userdata('excel_data_Invoice');
    
        // Output Excel file for download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Invoice Report '.time().'.xls"');
        header('Cache-Control: max-age=0');
    
        echo base64_decode($excelDataAll);
        exit();
    }

    public function generateAllInvoice()
    {
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');
    
        $data2 = $this->adjustmentDeductionReportInvoiceModel->generateALLInvoice($dateFrom, $dateTo);
        
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Invoice ALL');
        
            $header = array(
                'COMPANY',
                'VENDOR',
                'INVOICE DATE',
                'INVOICE NUMBER',
                'INVOICE AMOUNT',
                'TOTAL PAID',
                'REMAINING BALANCE',
                'CURRENCY',
                'TRANSACTION TYPE',
                'ADJUSTMENT / DEDUCTION',
                'REFERENCE NUMBER',
                'REMARKS',
                'UPDATED PAID AMOUNT',
                'DATE CREATED',
                'POSTED BY'
            );
    
        

            
            $this->excel->getActiveSheet()->fromArray([$header]);
    
            
            $headerRange = 'A1:O1'; 
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
    
            // $this->excel->getActiveSheet()->fromArray($data2, null, 'A2'); 


            $rowNumber = 2; 

            foreach ($data2 as $row) {

            $column = 'A';

            foreach ($row as $value) {
                  $this->excel->getActiveSheet()->setCellValue('A' . $rowNumber, $row['company_name']);
                  $this->excel->getActiveSheet()->setCellValue('B' . $rowNumber, $row['vendorName']);
                  $this->excel->getActiveSheet()->setCellValue('C' . $rowNumber, $row['formattedInvoiceDate']);
                  $this->excel->getActiveSheet()->setCellValue('D' . $rowNumber, $row['InvoiceNumber']);
                  $this->excel->getActiveSheet()->setCellValue('E' . $rowNumber, $row['formattedInvoiceAmount']);
                  $this->excel->getActiveSheet()->setCellValue('F' . $rowNumber, $row['formattedtotal_payment']);
                  $this->excel->getActiveSheet()->setCellValue('G' . $rowNumber, $row['formattedtotal_balance']);
                  $this->excel->getActiveSheet()->setCellValue('H' . $rowNumber, $row['currency']);
                  $this->excel->getActiveSheet()->setCellValue('I' . $rowNumber, $row['transactionName']);
                  $this->excel->getActiveSheet()->setCellValue('J' . $rowNumber, $row['totalFormattedTotalDeduc']);
                  $this->excel->getActiveSheet()->setCellValue('K' . $rowNumber, $row['referenceNumber']);
                  $this->excel->getActiveSheet()->setCellValue('L' . $rowNumber, $row['remarks']);
                  $this->excel->getActiveSheet()->setCellValue('M' . $rowNumber, $row['totalFormattedUpdate_Initial_deduction']);
                  $this->excel->getActiveSheet()->setCellValue('N' . $rowNumber, $row['formattedDateCreated']);
                  $this->excel->getActiveSheet()->setCellValue('O' . $rowNumber, $row['userCreated']);

                $column++;
            }
            $rowNumber++;
        }
            
            $lastColumn = 'O'; 
            $lastRow = count($data2) + 1; 
            $range = "A1:{$lastColumn}{$lastRow}";
    
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    ),
                ),
            );
            $this->excel->getActiveSheet()->getStyle($range)->applyFromArray($styleArray);
    
    
            $filename = 'INVOICE_ALL.xls';
        
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
    
            header('Content-Type: application/json');
        
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    
            ob_start();
    
            $objWriter->save('php://output');
    
            $excelOutput = ob_get_clean();
    
           
            $this->session->set_userdata('excel_invoice_data_all', base64_encode($excelOutput));
            
            
            echo json_encode(array('success' => true));
    
            exit();
        
    }

    
    public function downloadExcelFileInvoiceAll()
    {
        // Retrieve the Excel data from the session
        $excelDataAll = $this->session->userdata('excel_invoice_data_all');
    
        // Output Excel file for download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="All invoice '.time().'.xls"');
        header('Cache-Control: max-age=0');
    
        echo base64_decode($excelDataAll);
        exit();
    }

    public function generateExcelReportsPaidAmountInvoice()
    {
        $company = $this->input->post('compCode');
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');
    

            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('INVOICE PAID SUMMARY');
        
       
            $header = array(
                'DATE',
                'COMPANY',
                'VENDOR',
                'INVOICE NUMBER',
                'CURRENCY',
                'AMOUNT',
                'PAID AMOUNT',
                'DEDUCTION',
                'BALANCE',
                'RFP',
                'USER CREATED',
                
            );
        
            $data1 = $this->adjustmentDeductionReportInvoiceModel->fetchdailyTotalInvoice($company, $dateFrom);

            $rowNumber = '2';

            foreach($data1 as $data1s)
            {
                $column = 'A';

                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['dateCreated']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['company_name']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['vendorName']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['InvoiceNumber']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['currency']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['InvoiceAmount']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['updated_paid_amount']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['updated_adjustment_deduction_amt']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['updated_balanced']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['rfp']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['userCreated']);
                $column++;

                $rowNumber++;
            }

            $total = $this->adjustmentDeductionReportInvoiceModel->TotalAmt($company, $dateFrom);

            foreach($total as $totals)
            {   
                $column1 = 'E';
                $column2 = 'F';
                $column3 = 'G';
                $column4 = 'H';
                $column5 = 'I';


                $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, 'Total');
                $column1++;

                $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, $totals['grandTotalInvoiceAmt']);
                $column2++;

                $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, $totals['grandPaidAmt']);
                $column3++;

                $this->excel->getActiveSheet()->setCellValue($column4 . $rowNumber, $totals['grandTotalDeductAmt']);
                $column4++;

                $this->excel->getActiveSheet()->setCellValue($column5 . $rowNumber, $totals['grandTotalBalanced']);
                $column5++;

                  // Add borders to the cells
                $styleArray = [
                    'borders' => [
                        'allborders' => [
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ],
                    ],
                ];

                $this->excel->getActiveSheet()->getStyle('E' . $rowNumber . ':' . 'I' . $rowNumber)->applyFromArray($styleArray);


                $rowNumber++;
            }

          
            $this->excel->getActiveSheet()->fromArray([$header]);

            $headerRange = 'A1:K1'; 
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
    
    
            $lastColumn = 'K';
            $lastRow = count($data1) + 1;
            $range = "A1:{$lastColumn}{$lastRow}";
    
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    ),
                ),
            );
            $this->excel->getActiveSheet()->getStyle($range)->applyFromArray($styleArray);
    
            $filename = 'TTS_INVOICE_ALL.xls';
        
            // Output Excel file
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
    
            header('Content-Type: application/json');
        
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    
            ob_start();
    
            $objWriter->save('php://output');
    
            $excelOutput = ob_get_clean();
    
            // Store the Excel data in the session for later retrieval
            $this->session->set_userdata('excel_data_all_Invoice_PAID', base64_encode($excelOutput));
            
            
            echo json_encode(array('success' => true));
    
            exit();
        

        

    }

    public function downloadExcelFilesInvoice()
    {
        // Retrieve the Excel data from the session
        $excelDataAll = $this->session->userdata('excel_data_all_Invoice_PAID');
    
        // Output Excel file for download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Daily Invoice Report '.time().'.xls"');
        header('Cache-Control: max-age=0');
    
        echo base64_decode($excelDataAll);
        exit();
    }

    public function generateExcelReportsAllPaidAmountInvoice()
    {
            $dateFrom = $this->input->post('dateFrom');
            
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('INVOICE PAID SUMMARY');
        
       
            $header = array(
                'DATE VALIDATED',
                'COMPANY',
                'VENDOR',
                'INVOICE NUMBER',
                'PO AMOUNTS',
                'TOTAL DEDUCTIONS',
                'UPDATED BALANCE',
                'CURRENCY',
                'USER CREATED',
                
            );
        
            $data1 = $this->adjustmentDeductionReportInvoiceModel->fetchAllDailyReport($dateFrom);

            // var_dump($data1);
            // exit();
          
            $this->excel->getActiveSheet()->fromArray([$header]);
    
           
            $headerRange = 'A1:I1'; 
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
    
            $this->excel->getActiveSheet()->fromArray($data1, null, 'A2');
    
            
            $lastColumn = 'I';
            $lastRow = count($data1) + 1;
            $range = "A1:{$lastColumn}{$lastRow}";
    
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    ),
                ),
            );
            $this->excel->getActiveSheet()->getStyle($range)->applyFromArray($styleArray);
    
            $filename = 'TTS_INVOICE_ALL.xls';
        
            // Output Excel file
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
    
            header('Content-Type: application/json');
        
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    
            ob_start();
    
            $objWriter->save('php://output');
    
            $excelOutput = ob_get_clean();
    
            // Store the Excel data in the session for later retrieval
            $this->session->set_userdata('excel_data_all_Invoice', base64_encode($excelOutput));
            
            
            echo json_encode(array('success' => true));
    
            exit();
        
        

        

    }

    public function downloadAllExcelFilesInvoice()
    {
       
        $excelDataAll = $this->session->userdata('excel_data_all_Invoice');
    

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="All paid Invoice '.time().'.xls"');
        header('Cache-Control: max-age=0');
    
        echo base64_decode($excelDataAll);
        exit();
    }

    public function generatePdfInvoice()
    {

        $compCode = $this->input->post('compCode');

        $currency = $this->input->post('currency');

        $h['header'] = $this->adjustmentDeductionReportInvoiceModel->getHeader($compCode, $currency);

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage('L');

        //Start of pdf file
            $html = '';
            
            $html .= '<font size="8" face="Courier New" >
                        <table style=" padding: 3px;">
                            <thead>
                                <tr>
                            
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Vendor</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Invoice Number</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Company</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Commercial Invoice</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Pro-forma Invoice</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Currency</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Amount</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Balance</th> 
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Paid Amount</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Rfp</th>
                                 
                                </tr>
                            </thead>
                        <tbody>';
        
                            foreach ($h['header'] as $headers)
                            {
                                $html .= '<tr>
                                    <td style="text-align: center;">' . $headers['vendorName'] . '</td>
                                    <td style="text-align: center;">' . $headers['InvoiceNumber'] . '</td>
                                    <td style="text-align: center;">' . $headers['company_name'] . '</td>
                                    <td style="text-align: center;">' . $headers['commercialInvoice'] . '</td>
                                    <td style="text-align: center;">' . $headers['proformaInvoice'] . '</td>
                                    <td style="text-align: center;">' . $headers['currency'] . '</td>
                                    <td style="text-align: center;">' . $headers['InvoiceAmount'] . '</td>
                                    <td style="text-align: center;">' . $headers['updated_balanced'] . '</td>
                                    <td style="text-align: center;">' . $headers['updated_paid_amount'] . '</td>
                                    <td style="text-align: center;">'  . $headers['rfp'] . '</td>
                                </tr>';
                            
                            $initialPay = $this->adjustmentDeductionReportInvoiceModel->generateInvoicePaymentPdf($compCode, $currency,  $headers['InvoiceNumber']);

                            foreach($initialPay as $initialPays)
                            {
                                $html .= '<tr>
                                    <td style="text-align: center;">-</td>
                                    <td style="text-align: center;">-</td>
                                    <td style="text-align: center;">-</td>
                                    <td style="text-align: center;">-</td>
                                    <td style="text-align: center;">-</td>
                                    <td style="text-align: center;">-</td>
                                    <td style="text-align: center;">-</td>
                                    <td style="text-align: center;">-</td>
                                    <td style="text-align: center;">'.$initialPays['total_payment'].'</td>
                                    <td style="text-align: center;">'.$initialPays['paymentName']. '</td>
                                </tr>';
                            }

                                
                                $html .= '<h6 style="text-align: center;">Invoice Related</h6>
                                <tr>
                                    
                                <th style="  text-align: center; "></th>
                                <th style="  text-align: center; "></th>
                                <th style="  text-align: center; "></th>
                                <th style="  text-align: center; font-weight: bold; ">Type</th>
                                <th style="  text-align: center; font-weight: bold; ">Transaction</th>
                                <th style="  text-align: center; font-weight: bold; ">Reference</th>
                                <th style="  text-align: center; font-weight: bold; ">Amount</th>
                                <th style="  text-align: center; font-weight: bold; ">Balance</th>
                                <th style="  text-align: center; font-weight: bold; ">Date</th>
                                <th style="  text-align: center; font-weight: bold; ">RFP</th> 
            
                                </tr>
                                ';

                                $other['otherTransact'] = $this->adjustmentDeductionReportInvoiceModel->getOtherInvoicePayment($compCode, $currency, $headers['InvoiceNumber']);

                                foreach($other['otherTransact'] as $OtherPayments)
                                {

                                    $html .= '
                                    <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: center;">' . $OtherPayments['otherTransacTypeName'] . '</td>
                                            <td style="text-align: center;">' . $OtherPayments['transact_name'] . '</td>
                                            <td style="text-align: center;">' . $OtherPayments['referenceNumber'] . '</td>
                                            <td style="text-align: center;">' . $OtherPayments['otherInvoiceAmount'] . '</td>
                                            <td style="text-align: center;">' . $OtherPayments['otherTotalDeduc'] . '</td>
                                            <td style="text-align: center;">' . $OtherPayments['dateCreated'] . '</td>
                                            <td style="text-align: center;">' . $OtherPayments['rfp'] . '</td>
                                    </tr>
                                    ';

                                }

                                $html .= '<h6 style="text-align: center;">Non Invoice Related</h6>
                                <tr>
                                    
                              
                                <th style="  text-align: center; "></th>
                                <th style="  text-align: center; "></th>
                                <th style="  text-align: center; "></th>
                                <th style="  text-align: center; font-weight: bold; ">Type</th>
                                <th style="  text-align: center; font-weight: bold; ">Transaction</th>
                                <th style="  text-align: center; font-weight: bold; ">Reference</th>
                                <th style="  text-align: center; font-weight: bold; ">Amount</th>
                                <th style="  text-align: center; font-weight: bold; ">Remarks</th>
                                <th style="  text-align: center; font-weight: bold; ">Date</th>
                                <th style="  text-align: center; font-weight: bold; ">RFP</th> 
            
                                </tr>
                                ';

                                $nonInvoice['NonRelatedInvoice'] = $this->adjustmentDeductionReportInvoiceModel->getNonInvoicePayment($compCode, $currency, $headers['InvoiceNumber']);

                                foreach($nonInvoice['NonRelatedInvoice'] as $nonInvoices)
                                {

                                    
                                    $html .= '
                                    <tr>    
                                          
                                   
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: center;">' . $nonInvoices['otherTransacTypeName'] . '</td>
                                            <td style="text-align: center;">' . $nonInvoices['transactionName'] . '</td>
                                            <td style="text-align: center;">' . $nonInvoices['reference_no'] . '</td>
                                            <td style="text-align: center;">' . $nonInvoices['amount'] . '</td>
                                            <td style="text-align: center;">' . $nonInvoices['remarks'] . '</td>
                                            <td style="text-align: center;">' . $nonInvoices['date'] . '</td>
                                            <td style="text-align: center;">' . $nonInvoices['rfp'] . '</td>
                                    </tr>
                                    ';

                          
                                }

                                    $html .= '
                                    <div>
                                    </div>
                                    <hr>
                                    <div>
                                    </div>
                                    ';
                            

                            }
                        
            $html .= '</tbody>
                    </table>
                </font>';

                

            $pdf->writeHTML($html, true, false, true, false, '');

            // Generate a unique filename for the PDF
            $pdfFilename = 'Invoice_report_pdf' . time() . '.pdf';
            $pdfFilePath = FCPATH . 'uploadPdfFile/'. $pdfFilename;

            $pdf->Output($pdfFilePath, 'F');

            $result = array(
                'message'   => 'Successfully generated.',
                'pdfPath'   => base_url('uploadPdfFile/' . $pdfFilename)
            );

            echo json_encode($result);
    }

    public function generatePdfInvoice_2()
    {
        $company = $this->input->post('company');
        $vendor = $this->input->post('vendor');
        $reference = $this->input->post('reference_no');
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetTitle('PDF');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage('L');

        $imgPath = 'assets/images/Puregold_logo.jpg';

        $html = '';

        $html .= '
            
        <img src="' . $imgPath . '" alt="test alt attribute" width="100" height="" border="0" />
        
        <font size="8.5" face="Courier New">
        <p style="text-align: right;">Rundate: <b>'.date("Y-m-d H:i:s").'</b></p>
        </font>
        
        ';


         $data = $this->adjustmentDeductionReportInvoiceModel->generateReportInvoices($company, $vendor, $reference, $dateFrom, $dateTo);

        //  var_dump($data);
        //  exit();

         foreach($data as $datas)
         {
            
            $html .= '<font size="9" face="Courier New">
                    <dl>
                        <dt><b>Invoice number</b>: '.$datas['InvoiceNumber'].'</dt>
                        <dt><b>PO date</b>: '.$datas['InvoiceDate'].'</dt>
                        <dt><b>Company</b>: '.$datas['company_name'].'</dt> 
                        <dt><b>Vendor</b>:'.$datas['vendorName'].'</dt>
                        <dt><b>Vendor Address:</b> '.$datas['vendorAddress1'].'</dt>
                        <dt><b>Bank:</b> '.$datas['bankName'].'</dt>
                        <dt><b>Bank Address:</b> '.$datas['bankAddress2'].'</dt>
                        <dt><b>Account:</b> '.$datas['accountNumber'].'</dt>
                        <dt><b>Swift Code:</b> '.$datas['swiftCode'].'</dt>
                        <dt><b>IBAN:</b> '.$datas['ibanNo'].'</dt>
                        <dt><b>ABA Number:</b> '.$datas['abaNo'].'</dt>
                    </dl> 
                </font>
            ';


            $html .= '<font size="8" face="Courier New" >
                <table>
                    <thead>
            
                    <tr>
                        <th style="font-weight: bold; ">PROFORMA</th>
                        <th style="font-weight: bold; ">COMMERCIAL</th>
                        <th style="font-weight: bold; ">CURRENCY</th>
                        <th style="font-weight: bold; ">AMOUNT</th>
                        <th style="font-weight: bold; ">PAID AMOUNT</th> 
                        <th style="font-weight: bold; ">BALANCE</th> 
                        <th style="font-weight: bold; ">PAYMENT TYPE</th> 
                        <th style="font-weight: bold; ">DATE CREATED</th> 
                        <th style="font-weight: bold; ">REFERENCE NO.</th> 
                        <th style="font-weight: bold; ">REMARKS</th> 
                        <th style="font-weight: bold; ">RFP</th> 
    
                    </tr>
        
                    </thead>

                        <tbody>
                        </tbody>
                    </table>
                    </font>';

                    // <td ><span style="background-color: rgb(255, 255, 0); color: rgb(0, 0, 0);">' . $datas['updated_paid_amount'] . '</span></td>
                    // <td ><span style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255); padding: 2px;">' . $datas['updated_balanced'] . '</span></td>
    
                    $html .= '<font size="8" face="Courier New" >
                    <table>
                        <tr>
                        <td >' . $datas['proformaInvoice'] . '</td>
                        <td >' . $datas['commercialInvoice'] . '</td>
                        <td >' . $datas['currency'] . '</td>
                        <td >' . $datas['InvoiceAmount'] . '</td>
                        <td></td>
                        <td></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td >' . $datas['remarks'] . '</td>
                        <td >' . $datas['rfp'] . '</td>
                        </tr>'; 

          

                $generatePayment = $this->adjustmentDeductionReportInvoiceModel->generateInvoicePayment($company, $vendor, $datas['InvoiceNumber']);

                // var_dump($generatePayment);
                // exit();

                $totalInitialPay = 0;

                foreach($generatePayment as $payments)
                {
                    $totalInitialPay += floatval($payments['origTotalPayment']);

                    $html .= '<tr>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td >' . $payments['total_payment'] . '</td>
                    <td >' . $payments['total_balance'] . '</td>
                    <td >' . $payments['paymentName'] . '</td>
                    <td >' . $payments['date_created'] . '</td>
                    <td ></td>
                    <td >' . $payments['remarks'] . '</td>
                    <td >' . $payments['rfp'] . '</td>
                    </tr>';
                }

                // $html .= '<tr>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //         </tr>';

                $otherPayment = $this->adjustmentDeductionReportInvoiceModel->generateOtherPaymentInvoice($company, $reference, $vendor, $datas['InvoiceNumber']);

                $totalOtherpayment = 0;

                 foreach($otherPayment as $otherPayments)
                 {
                    $html .= '<tr>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td >';
                    
                    if($otherPayments['otherTransTypeCode'] == 2)
                    {
                        $html .= '('.number_format($otherPayments['amount'], 2, '.', ',') . ')';
                    }
                    else
                    {
                        $html .= number_format($otherPayments['amount'], 2, '.', ',');
                    }
                
                    $html .= '</td>
                    <td >';
                   
                   if($otherPayments['otherTransTypeCode'] == 2)
                   { 
                        $html .= '('.number_format($otherPayments['origTotalDeduc'], 2, '.', ',') . ')';

                        $totalOtherpayment += floatval((-$otherPayments['origTotalDeduc']));
                   }
                   else
                   {
                        $html .= number_format($otherPayments['origTotalDeduc'], 2, '.', ',');

                        $totalOtherpayment += floatval($otherPayments['origTotalDeduc']);
                   }
 
                   $html .= '</td>
                            <td >';
                    if($otherPayments['total'] == 0)
                    {
                        $html .= number_format($otherPayments['total'], 2, '.', ',') ;
                    }
                      
                    else
                    {
                        $html .= '('.number_format($otherPayments['total'], 2, '.', ',') . ')';
                    }
                    
                   $html .= '</td>
                    <td >' . $otherPayments['transact_name'] . '</td>
                    <td >' . $otherPayments['dateCreated'] . '</td>
                    <td >' . $otherPayments['referenceNumber'] . '</td>
                    <td >' . $otherPayments['remarks'] . '</td>
                    <td >' . $otherPayments['rfp'] . '</td>
                    </tr>';
                 }

                $nonInvoicePayment = $this->adjustmentDeductionReportInvoiceModel->generateNonInvoiceRelatedPayment($company, $reference, $vendor, $datas['InvoiceNumber']);
                

                // $html .= '<tr>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //             <td ></td>
                //     </tr>';

                $totalDeduction = 0;

                foreach($nonInvoicePayment as $nonInvoicePayments)
                {
                    $html .= '<tr>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td >';

                    if($nonInvoicePayments['transact_type'] == 2)
                    {
                        $html .= '('. number_format($nonInvoicePayments['amount2'], 2, '.', ',') .')';
                    }

                    else
                    {
                        $html .= number_format($nonInvoicePayments['amount2'], 2, '.', ',');
                    }
                    
                  $html .= '</td>
                            <td >';
                    
                    if($nonInvoicePayments['transact_type'] == 2)
                    {
                        $html .= '('. number_format($nonInvoicePayments['amount'], 2, '.', ',') .')';

                        $totalDeduction += floatval((-$nonInvoicePayments['amount']));
                    }

                    else
                    {
                        $html .= number_format($nonInvoicePayments['amount'], 2, '.', ',');

                        $totalDeduction += floatval($nonInvoicePayments['amount']);
                    }

                    
                    $html .= '</td>
                    <td >';
                    if($nonInvoicePayments['total'] == 0)
                    {
                        $html .= number_format($nonInvoicePayments['total'], 2, '.', ',');
                    }

                    else
                    {
                        
                        $html .= '('. number_format($nonInvoicePayments['total'], 2, '.', ',') .')';
                    }
                    
                    
                   $html .= '</td>  
                    <td >' . $nonInvoicePayments['transactionName'] . '</td>
                    <td >' . $nonInvoicePayments['date_created'] . '</td>
                    <td >' . $nonInvoicePayments['reference_no'] . '</td>
                    <td >' . $nonInvoicePayments['remarks'] . '</td>
                    <td >' . $nonInvoicePayments['rfp'] . '</td>
                    </tr>';
                }

                //condition if full payment

                if($payments['total_balance'] == 0)
                {
                    $finalTotal = $totalOtherpayment + $totalDeduction;
                }

                else
                {
                    $finalTotal = $totalInitialPay + $totalOtherpayment + $totalDeduction;
                }


                

                $line = '<hr>';

                $html .= '<tr>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                <td >'.$line.' Total:</td>
                <td >'.$line. number_format(abs($finalTotal), 2, '.', ',').'</td>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                </tr>';

         }
        
        $pdf->writeHTML($html, true, false, true, false, '');

        // Generate a unique filename for the PDF
        $pdfFilename = 'Invoice_report_pdf' . time() . '.pdf';
        $pdfFilePath = FCPATH . 'uploadPdfFile/'. $pdfFilename;

        $pdf->Output($pdfFilePath, 'F');

        $result = array(
            'message'   => 'Successfully generated.',
            'pdfPath'   => base_url('uploadPdfFile/' . $pdfFilename)
        );

        echo json_encode($result);
    }

    public function generatePDFInvoiceByRfp()
    {
        $rfp = $this->input->post('rfp');
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetTitle('PDF');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage('L');

        $imgPath = 'assets/images/Puregold_logo.jpg';

        $html = '';

        $html .= '
            
        <img src="' . $imgPath . '" alt="test alt attribute" width="100" height="" border="0" />
        
        <font size="8.5" face="Courier New">
        <p style="text-align: right;">Rundate: <b>'.date("Y-m-d H:i:s").'</b></p>
        </font>
        
        ';


         $data = $this->adjustmentDeductionReportInvoiceModel->generateReportByRFPInvoice($rfp, $dateFrom, $dateTo);

        //  var_dump($data);
        //  exit();

         foreach($data as $datas)
         {
            
            $html .= '<font size="9" face="Courier New">
                    <dl>
                        <dt><b>RFP</b>: '.$datas['rfp'].'</dt>
                        <dt><b>Vendor</b>:'.$datas['vendorName'].'</dt>
                        <dt><b>Invoice date</b>: '.$datas['InvoiceDate'].'</dt>
                        <dt><b>Company</b>: '.$datas['company_name'].'</dt>
                        <dt><b>Vendor:</b> '.$datas['vendorName'].'</dt>
                        <dt><b>Vendor Address:</b> '.$datas['vendorAddress1'].'</dt>
                        <dt><b>Bank:</b> '.$datas['bankName'].'</dt>
                        <dt><b>Bank Address:</b> '.$datas['bankAddress2'].'</dt>
                        <dt><b>Account:</b> '.$datas['accountNumber'].'</dt>
                        <dt><b>Swift Code:</b> '.$datas['swiftCode'].'</dt>
                        <dt><b>IBAN:</b> '.$datas['ibanNo'].'</dt>
                        <dt><b>ABA Number:</b> '.$datas['abaNo'].'</dt>
                    </dl> 
                </font>
            ';


            $html .= '<font size="8" face="Courier New" >
                <table>
                    <thead>
            
                    <tr>
                        <th style="font-weight: bold; ">PROFORMA</th>
                        <th style="font-weight: bold; ">COMMERCIAL</th>
                        <th style="font-weight: bold; ">CURRENCY</th>
                        <th style="font-weight: bold; ">AMOUNT</th>
                        <th style="font-weight: bold; ">PAID AMOUNT</th> 
                        <th style="font-weight: bold; ">BALANCE</th> 
                        <th style="font-weight: bold; ">PAYMENT TYPE</th> 
                        <th style="font-weight: bold; ">DATE CREATED</th> 
                        <th style="font-weight: bold; ">REFERENCE NO.</th> 
                        <th style="font-weight: bold; ">REMARKS</th> 
                        <th style="font-weight: bold; ">INVOICE #</th> 
    
                    </tr>
        
                    </thead>

                        <tbody>
                        </tbody>
                    </table>
                    </font>';

                    $html .= '<font size="8" face="Courier New" >
                    <table>
                        <tr>
                        <td >' . $datas['proformaInvoice'] . '</td>
                        <td >' . $datas['commercialInvoice'] . '</td>
                        <td >' . $datas['currency'] . '</td>
                        <td >' . $datas['InvoiceAmount'] . '</td>
                        <td></td>
                        <td></td>
                        <td ></td>
                        <td ></td>
                        <td ></td>
                        <td >' . $datas['remarks'] . '</td>
                        <td >' . $datas['InvoiceNumber'] . '</td>
                        </tr>'; 

          

                $generatePayment = $this->adjustmentDeductionReportInvoiceModel->generateInvoicePaymentByRFP($datas['InvoiceNumber'], $datas['rfp']);

                // var_dump($generatePayment);
                // exit();

                $totalInitialPay = 0;

                foreach($generatePayment as $payments)
                {
                    $totalInitialPay += floatval($payments['origTotalPayment']);

                    $html .= '<tr>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td >' . $payments['total_payment'] . '</td>
                    <td >' . $payments['total_balance'] . '</td>
                    <td >' . $payments['paymentName'] . '</td>
                    <td >' . $payments['date_created'] . '</td>
                    <td ></td>
                    <td >' . $payments['remarks'] . '</td>
                    <td >' . $payments['InvoiceNumber'] . '</td>
                    </tr>';
                }

                $otherPayment = $this->adjustmentDeductionReportInvoiceModel->generateOtherPaymentInvoiceRFP($datas['rfp']);

                $totalOtherPayment = 0;

                 foreach($otherPayment as $otherPayments)
                 {
                    $html .= '<tr>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td >';
                    if($otherPayments['otherTransTypeCode'] == 2)
                    { 
                     $html .= '(' . number_format($otherPayments['amount'], 2, '.', ',') . ')';
                    }
                    else
                    {
                         $html .= number_format($otherPayments['amount'], 2, '.', ',');
                    }

                    $html .= '</td>
                    <td >';
                   
                   if($otherPayments['otherTransTypeCode'] == 2)
                   { 

                    $html .= '(' . number_format($otherPayments['origTotalDeduc'], 2, '.', ',') . ')';

                    $totalOtherPayment += floatval(-$otherPayments['origTotalDeduc']);
                   }
                   else
                   {
                        $html .= number_format($otherPayments['origTotalDeduc'], 2, '.', ',');

                        $totalOtherPayment += floatval($otherPayments['origTotalDeduc']);
                   }
 
                   $html .= '</td>
                    <td >';
                    if($otherPayments['total'] == 0)
                    { 
                        $html .= number_format($otherPayments['total'], 2, '.', ',');
                    
                    }
                    else
                    {
                        $html .= '(' . number_format($otherPayments['total'], 2, '.', ',') . ')';
                    }
                    
                   $html .= '</td>
                    <td >' . $otherPayments['transact_name'] . '</td>
                    <td >' . $otherPayments['dateCreated'] . '</td>
                    <td >' . $otherPayments['referenceNumber'] . '</td>
                    <td >' . $otherPayments['remarks'] . '</td>
                    <td >' . $otherPayments['otherInvoiceNumber'] . '</td>
                    </tr>';
                 }

                $nonInvoicePayment = $this->adjustmentDeductionReportInvoiceModel->generateNonInvoiceRelatedPaymentRFP($datas['InvoiceNumber'], $datas['rfp']);

                $totalDeduction = 0;

                foreach($nonInvoicePayment as $nonInvoicePayments)
                {
                    $html .= '<tr>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td >';

                    if($nonInvoicePayments['transact_type'] == 2)
                    {
                        $html .= '('. number_format($nonInvoicePayments['amount2'], 2, '.', ',') .')';
                       
                    }

                    else
                    {
                        $html .= number_format($nonInvoicePayments['amount2'], 2, '.', ',') ;

                    }
                    
                  $html .= '</td>     
                    <td >';
                    
                    if($nonInvoicePayments['transact_type'] == 2)
                    {
                        $html .= '('. number_format($nonInvoicePayments['amount'], 2, '.', ',') .')';

                        $totalDeduction += floatval((-$nonInvoicePayments['amount']));
                    }

                    else
                    {
                        $html .= number_format($nonInvoicePayments['amount'], 2, '.', ',') ;

                        $totalDeduction += floatval($nonInvoicePayments['amount']);
                    }

                    
                    $html .= '</td>
                    <td >';
                    
                    if($nonInvoicePayments['total'] == 0)
                    {
                        $html .= number_format($nonInvoicePayments['total'], 2, '.', ',') ;
                    }else
                    {
                        $html .= '('. number_format($nonInvoicePayments['total'], 2, '.', ',') .')';
                    }

                   $html .= '</td>
                    <td >' . $nonInvoicePayments['transactionName'] . '</td>
                    <td >' . $nonInvoicePayments['date_created'] . '</td>
                    <td >' . $nonInvoicePayments['reference_no'] . '</td>
                    <td >' . $nonInvoicePayments['remarks'] . '</td>
                    <td >' . $nonInvoicePayments['invoice_number'] . '</td>
                    </tr>';
                }

                if($payments['total_balance'] == 0)
                {
                    $finalTotal = $totalOtherPayment + $totalDeduction;
                }
                else
                {
                    $finalTotal = $totalInitialPay + $totalOtherPayment + $totalDeduction;
  
                }

                // var_dump($totalInitialPay);
                // var_dump($totalOtherPayment);
                // var_dump($totalDeduction);
                // var_dump($finalTotal);
                // exit();

                $line = '<hr>';

                $html .= '<tr>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                <td >'.$line.' Total:</td>
                <td >'.$line. number_format(abs($finalTotal), 2, '.', ',').'</td>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                <td >'.$line.'</td>
                </tr>';

         }
        
        $pdf->writeHTML($html, true, false, true, false, '');

        // Generate a unique filename for the PDF
        $pdfFilename = 'Invoice_report_pdf' . time() . '.pdf';
        $pdfFilePath = FCPATH . 'uploadPdfFile/'. $pdfFilename;

        $pdf->Output($pdfFilePath, 'F');

        $result = array(
            'message'   => 'Successfully generated.',
            'pdfPath'   => base_url('uploadPdfFile/' . $pdfFilename)
        );

        echo json_encode($result);
    }

    public function searchRFPfromDB()
    {
        $search = $this->input->post('rfp');

        $data = $this->adjustmentDeductionReportInvoiceModel->getRFP($search);

        // var_dump($data);
        // exit();

        echo json_encode($data);
    }

    public function generateReportByRFPExcel()
    {
        $rfp = $this->input->post('rfp');
        $dateFrom = $this->input->post('dateFrom');
        $dateTo = $this->input->post('dateTo');

          // Set up Excel sheet
          $this->excel->setActiveSheetIndex(0);
          $this->excel->getActiveSheet()->setTitle('Telegraphic Transfer Invoice');


          $header = array(
            'DATE',
            'VENDOR',
            'INVOICE NUMBER', 
            'INVOICE DATE',
            'COMPANY', 
            'PRO-FORMA INVOICE',
            'COMMERCIAL INVOICE',
            'CURRENCY',
            'AMOUNT',
            'PAID AMOUNT',
            'BALANCE',
            'PAYMENT TYPE',
            'DATE CREATED',
            'REFERENCE NO', 
            'REMARKS',
            'RFP'
        );
    
       
        $this->excel->getActiveSheet()->fromArray([$header]);

        $headerRange = 'A1:P1';
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

        $dataRfp = $this->adjustmentDeductionReportInvoiceModel->generateReportByRFPInvoice($rfp, $dateFrom, $dateTo);

        $rowNumber = 2;

        foreach ($dataRfp as $row) 
        {

            $column = 'A';

                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['dateCreated']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['vendorName']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['InvoiceNumber']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['InvoiceDate']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['company_name']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['proformaInvoice']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['commercialInvoice']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['currency']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['InvoiceAmount']);
                $column++;

                // $cellCoordinate = $column . $rowNumber; // Get the cell coordinate

                // $headerRange2 = $cellCoordinate;

                // $headerStyleArray2 = array(
                //     'fill' => array(
                //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //         'color' => array('rgb' => 'FF0000'),
                //     ),

                //     'font' => array(
                //         'bold' => true,
                //         'color' => array('rgb' => 'FFFFFF'), // Set your desired font color
                //     ),
                // ); 

                // $this->excel->getActiveSheet()->getStyle($headerRange2)->applyFromArray($headerStyleArray2);

                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                $column++;

                // $cellCoordinate = $column . $rowNumber; // Get the cell coordinate

                // $headerRange1 = $cellCoordinate;

                // $headerStyleArray1 = array(
                //     'fill' => array(
                //         'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //         'color' => array('rgb' => 'FFFF00'),
                //     ),
                // ); 

                // $this->excel->getActiveSheet()->getStyle($headerRange1)->applyFromArray($headerStyleArray1);

                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber,  $row['remarks']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['rfp']);
            
                // Increment rowNumber here, outside of the inner loop
                $rowNumber++;


                $generatePayment = $this->adjustmentDeductionReportInvoiceModel->generateInvoicePaymentByRFP($row['InvoiceNumber'], $row['rfp']);

                $total = 0;
                
                foreach($generatePayment as $generatePayments)
                {

                    $column1 = 'A';

                    //sum of total initial payment
                    $total += floatval($generatePayments['origTotalPayment']);

                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, $generatePayments['total_payment']);
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, $generatePayments['total_balance']);
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber,  $generatePayments['paymentName']);
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber,  $generatePayments['date_created']);
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, '');
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, $generatePayments['remarks']);
                    $column1++;
                    $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, $generatePayments['rfp']);
                    $column1++;

                    $rowNumber++;

                }
                
                // $rowNumber++;

                $otherPayment = $this->adjustmentDeductionReportInvoiceModel->generateOtherPaymentInvoiceRFP($row['rfp']);

                $totalOtherPayment = 0;

                foreach($otherPayment AS $otherPayments)
                {
                    $column2 = 'A';

                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++; 
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '');
                    $column2++;

                    if($otherPayments['otherTransTypeCode'] == 2)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '(' . $otherPayments['origTotalDeduc'] . ')');
                        $column2++;

                        $totalOtherPayment += floatval(-$otherPayments['origTotalDeduc']);
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, $otherPayments['origTotalDeduc']);
                        $column2++;

                        $totalOtherPayment += floatval($otherPayments['origTotalDeduc']);
                    }
                    

                    if($otherPayments['total'] == 0)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber,  $otherPayments['total'] );
                        $column2++;
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, '('.  $otherPayments['total'] . ')');
                        $column2++;
                    }

                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber,  $otherPayments['transact_name']);
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber,  $otherPayments['dateCreated']);
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, $otherPayments['referenceNumber']);
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, $otherPayments['remarks']);
                    $column2++;
                    $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, $otherPayments['rfp']);
                    $column2++;

                    $rowNumber++;
                    
                }

                // $rowNumber++;

                $nonInvoicePayment = $this->adjustmentDeductionReportInvoiceModel->generateNonInvoiceRelatedPaymentRFP($row['InvoiceNumber'], $row['rfp']);

                $totalDeduc = 0;   

                foreach($nonInvoicePayment as $nonInvoicePayments)
                {
                    $column3 = 'A';

                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '');
                    $column3++;

                    if($nonInvoicePayments['transact_type'] == 2)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '('. number_format($nonInvoicePayments['amount2'], 2, '.', ',') . ')');
                        $column3++;
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, number_format($nonInvoicePayments['amount2'], 2, '.', ',') );
                        $column3++;
                    }

 

                    if($nonInvoicePayments['transact_type'] == 2)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber,  '(' . number_format($nonInvoicePayments['amount'], 2, '.', ',') . ')' );
                        $column3++;

                        $totalDeduc += floatval($nonInvoicePayments['amount']);
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber,  number_format($nonInvoicePayments['amount'], 2, '.', ',')  );
                        $column3++;

                        $totalDeduc += floatval($nonInvoicePayments['amount']);
                    }

                    if($nonInvoicePayments['total'] == 0)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, number_format($nonInvoicePayments['total'], 2, '.', ','));
                        $column3++;
                    }
                    
                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, '(' . number_format($nonInvoicePayments['total'], 2, '.', ',') . ')');
                        $column3++;
                    }


                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber,  $nonInvoicePayments['transactionName']);
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber,  $nonInvoicePayments['date_created']);
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, $nonInvoicePayments['reference_no']);
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, $nonInvoicePayments['remarks']);
                    $column3++;
                    $this->excel->getActiveSheet()->setCellValue($column3 . $rowNumber, $nonInvoicePayments['rfp']);
                    $column3++;

                    $rowNumber++;
                }

                if($generatePayments['total_balance'] == 0)
                {
                    $finalPayment = $totalOtherPayment + $totalDeduc;
                }else
                {
                    $finalPayment = $total + $totalOtherPayment + $totalDeduc;
                }

                
          
                $column4 = 'H';

                $this->excel->getActiveSheet()->setCellValue($column4 . $rowNumber, 'Total: ');
                $column4++;

                $column5 = 'J';

                $this->excel->getActiveSheet()->setCellValue($column5 . $rowNumber, number_format($finalPayment, 2, '.', ','));
                $column5++;

                $rowNumber++;
                $rowNumber++;
        }
    

        $filename = 'TTS_PO.xls';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    
        ob_start();
        $objWriter->save('php://output');
        $excelOutput = ob_get_clean();
    
       
        $this->session->set_userdata('excel_data_Invoice_rfp', base64_encode($excelOutput));
    
        echo json_encode(array('success' => true));
        exit();

    }

    public function downloadExcelFileInvoiceRFP()
    {
        // Retrieve the Excel data from the session
        $excelDataAll = $this->session->userdata('excel_data_Invoice_rfp');
    
        // Output Excel file for download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Invoice Report '.time().'.xls"');
        header('Cache-Control: max-age=0');
    
        echo base64_decode($excelDataAll);
        exit();
    }

    public function generateDailyReportInvoice_2()
    {
        $company = $this->input->post('compCode');
        $dateFrom = $this->input->post('dateFrom');
    

            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('PO PAID SUMMARY');
        
            // Define the header
            $header = array(
                'DATE',
                'COMPANY',
                'VENDOR',
                'INVOICE NUMBER',
                'CURRENCY',
                'AMOUNT',
                'PAID AMOUNT',
                'DEDUCTION',
                'BALANCE',
                'RFP',
            );

            $data = $this->adjustmentDeductionReportInvoiceModel->generateDailyReportExcel($company, $dateFrom);

            $rowNumber = 2;

            foreach($data as $data1s)
            {       
                    $column = 'A';

                    $total = 0;

                    $bal = '';

                    $totalDaily = $this->adjustmentDeductionReportInvoiceModel->generateDailyPaymentReport($data1s['compCode'], $data1s['InvoiceNumber']);

                    foreach($totalDaily as $totalDailys)
                    {
                        $total += floatval($totalDailys['origTotalPayment']);

                        $bal = $totalDailys['origBal'];
                    }

                    $NonRelateDaily = $this->adjustmentDeductionReportInvoiceModel->generateNonPaymentDailyReport($data1s['compCode'], $data1s['InvoiceNumber']);

                    $tot = 0;

                    foreach($NonRelateDaily as $NonRelateDailys)
                    {
                        if($NonRelateDailys['transact_type'] == 2)
                        {
                            $tot += floatval((-$NonRelateDailys['amount']));
                        }

                        else
                        {
                            $tot += floatval($NonRelateDailys['amount']);
                        }
                    }

                    $finalTotal = $total + $tot;

                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['dateCreated']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['company_name']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['vendorName']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['InvoiceNumber']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['currency']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['InvoiceAmount']);
                    $column++;
                    
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, number_format($finalTotal, 2, '.', ','));
                    $column++;

                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, number_format(abs($tot), 2, '.', ','));
                    $column++;

                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber,  number_format($bal, 2, '.', ','));
                    $column++;

                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['rfp']);
                    $column++;
                    
                   
                    $rowNumber++;
            }


                    $this->excel->getActiveSheet()->fromArray([$header]);

                   // Set background color for the header
                   $headerRange = 'A1:J1'; // Assuming your table has 10 columns, adjust as needed
                   $headerStyleArray = array(
                       'fill' => array(
                           'type' => PHPExcel_Style_Fill::FILL_SOLID,
                           'color' => array('rgb' => '2db83d'), // Set your desired background color
                       ),
                       'font' => array(
                           'bold' => true,
                           'color' => array('rgb' => 'FFFFFF'), // Set your desired font color
                       ), 
                   ); 
                   
                   $this->excel->getActiveSheet()->getStyle($headerRange)->applyFromArray($headerStyleArray);
           
                   // $this->excel->getActiveSheet()->fromArray($data1, null, 'A2'); // Start from cell A2
           
                   // Add borders to the entire table (including header)
                   $lastColumn = 'J'; // Assuming your table has 10 columns, adjust as needed
                   $lastRow = count($data) + 1; // Add 1 for the header row
                   $range = "A1:{$lastColumn}{$lastRow}";
           
                   $styleArray = array(
                       'borders' => array(
                           'allborders' => array(
                               'style' => PHPExcel_Style_Border::BORDER_THIN,
                           ),
                       ),
                   );
                   $this->excel->getActiveSheet()->getStyle($range)->applyFromArray($styleArray);
           
                   $filename = 'TTS_INVOICE_ALL.xls';
               
                   // Output Excel file
                   header('Content-Type: application/vnd.ms-excel');
                   header('Content-Disposition: attachment;filename="' . $filename . '"');
                   header('Cache-Control: max-age=0');
           
                   header('Content-Type: application/json');
               
                   $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
           
                   ob_start();
           
                   $objWriter->save('php://output');
           
                   $excelOutput = ob_get_clean();
           
                   // Store the Excel data in the session for later retrieval
                   $this->session->set_userdata('excel_data_Invoice', base64_encode($excelOutput));
                   
                   
                   echo json_encode(array('success' => true));
           
                   exit();
    }

    public function downloadExcelFilesPOS()
    {
        // Retrieve the Excel data from the session
        $excelDataAll = $this->session->userdata('excel_data_Invoice');
    
        // Output Excel file for download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Paid Invoice '.time().'.xls"');
        header('Cache-Control: max-age=0');
    
        echo base64_decode($excelDataAll);
        exit();
    }


}