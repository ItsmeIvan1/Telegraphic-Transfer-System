<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class adjustmentDeductionReportController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        // $this->load->helper(array('form', 'url'));
        $this->load->library('pdf');
        
    }


        public function generateExcelReports()
        {
            // Retrieve input data
            $company = $this->input->post('company');
            $vendor = $this->input->post('vendor');
            // $transact = $this->input->post('transaction');
            $reference = $this->input->post('reference');
            $dateFrom = $this->input->post('dateFrom');
            $dateTo = $this->input->post('dateTo');
   
            // Set up Excel sheet
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Telegraphic Transfer PO');
        
            // Define the header
            $header = array(
                'DATE',
                'VENDOR',
                'PO NUMBER',
                'PO DATE',
                'COMPANY',
                'PRO-FORMA INVOICE',
                'FINAL INVOICE',
                'CURRENCY',
                'AMOUNT',
                'PAID AMOUNT',
                'BALANCE',
                'PAYMENT TYPE',
                'DATE CREATED',
                'REFERENCE NO.',
                'REMARKS',
                'RFP'
            );
        
            // Generate Excel file
            $this->excel->getActiveSheet()->fromArray([$header]);
        
            // Set background color for the header
            $headerRange = 'A1:P1';
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
            
            $h = $this->adjustmentDeductionReportModel->generatePOExcel($company, $vendor, $reference, $dateFrom, $dateTo);

            // Iterate through the data and set cell values
            $rowNumber = 2; // Start from row 2 (after the header)
            
            foreach ($h as $row)
            {
                $column = 'A';
            
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['dateCreated']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['vendorName']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['PONumber']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['PODate']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['company_name']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['proformaInvoice']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['finalInvoice']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['currency']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['POAmount']);
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

                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
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

                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['remarks']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['rfp']);
            
                // Increment rowNumber here, outside of the inner loop
                $rowNumber++;

                $i = $this->adjustmentDeductionReportModel->generateTBLPaymentExcel($company, $vendor, $row['PONumber']);
            
                // var_dump($i);
                // exit();

                $total = 0;


                foreach ($i as $ii) 
                {
                    $amount = $ii['origAmt']; 

                    $total +=  floatval($amount); 

                    $column = 'A'; // Reset column for inner loop
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $ii['amount']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $ii['total_balance']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $ii['paymentName']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber,  $ii['date_created']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $ii['remarks']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $ii['rfp']);
                    $column++;


                    // Increment rowNumber for the next iteration of the inner loop
                    $rowNumber++;
                    
                }


                $j = $this->adjustmentDeductionReportModel->generateOtherPaymentExcel($company, $reference, $vendor, $row['PONumber']);

                // var_dump($j);
                // exit();

                $totalAmtPORelated = 0;

                foreach($j as $jj)
                {
                    $column = 'A';
         
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;


                    if($jj['transactionCode'] == 1)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '(' . number_format($jj['amount'], 2, '.', ',') . ')');
                        $column++;
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, number_format($jj['amount'], 2, '.', ','));
                        $column++;
                    }


                    if($jj['transactionCode'] == 1)
                    {
                       
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '(' . number_format($jj['origOtherTotalDeduc'], 2, '.', ',') . ')');
                        $column++;

                        $totalAmtPORelated += floatval(-$jj['origOtherTotalDeduc']);

                     
                    }

                    else
                    {
                        
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, number_format($jj['origOtherTotalDeduc'], 2, '.', ','));
                        $column++;

                        $totalAmtPORelated += floatval($jj['origOtherTotalDeduc']);

             
                    }

                    if($jj['total'] == 0)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '' . number_format($jj['total'], 2, '.', ',') . '');
                        $column++;
                    }
                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '('. number_format($jj['total'], 2, '.', ',') . ')');
                        $column++;
                    }

                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $jj['transact_name']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $jj['dateCreated']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $jj['referenceNumber']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $jj['Remarks']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $jj['rfp']);
                    $column++;


                    // Increment rowNumber for the next iteration of the inner loop
                    $rowNumber++;
                    

                }

             

                $k = $this->adjustmentDeductionReportModel->generateNonRelatedPOExcel($company, $reference, $vendor,  $row['PONumber']);
                
                $tot = 0;

                foreach($k as $kk)
                {   
                    $column = 'A';

                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;

                    if($kk['transact_type'] == 2)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '(' . number_format(floatval($kk['amount2']), 2, '.', ','). ')');
                        $column++;
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, number_format(floatval($kk['amount2'])), 2, '.', ',');
                        $column++;
                    }


                    if($kk['transact_type'] == 2)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '(' . number_format(floatval($kk['newAmt']), 2, '.', ','). ')');
                        $column++;

                        $tot += floatval(-$kk['newAmt']);
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, number_format(floatval($kk['newAmt']), 2, '.', ','));
                        $column++;

                        $tot += floatval($kk['newAmt']);
                    }
                   
                    if($kk['total'] == 0)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, number_format(floatval($kk['total']), 2, '.', ','));
                        $column++;
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '('. number_format(floatval($kk['total']), 2, '.', ',') . ')');
                        $column++;
                    }


                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $kk['transactionName']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $kk['date_created']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $kk['reference_no']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $kk['remarks']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $kk['rfp']);
                    $column++;


                    // Increment rowNumber for the next iteration of the inner loop
                    $rowNumber++;
                    
                }

                $columnTotal = 'I';
                $this->excel->getActiveSheet()->setCellValue($columnTotal . $rowNumber, 'Total ');
                $columnTotal++;

                // var_dump($totalAmtPORelated);
                // var_dump($tot);
                // var_dump($total);
                // exit();


                $kokey = 0;

                //condition if balance is 0
                if($ii['total_balance'] == 0)
                {
                    $kokey =  $totalAmtPORelated + $tot;
                    
                }

                else
                {
                    $kokey =  $total + $totalAmtPORelated + $tot;
                  
                }

                

                $column2 = 'J';
                $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, number_format($kokey, 2, '.', ','));
                $column2++;
            
                // Increment rowNumber for the next iteration of the outer loop
                $rowNumber++;
                $rowNumber++;
            }


                // // Add borders to the entire table (including header)
                // $lastColumn = 'J';
                // $lastColumn1 = 'J';
                // $lastColumn2 = 'J';

                // $lastRow = count($h) + 1; // Add 1 for the header row
                // $lastRow1 = count($i) + 1;
                // $lastRow2 = count($k) + 1;
                

                // $range = "A1:{$lastColumn}{$lastRow}";
                // $range1 = "A" . ($lastRow + 2) . ":{$lastColumn1}" . ($lastRow + $lastRow1 + 1);
                // $range2 = "A" . ($lastRow1 + 2) . ":{$lastColumn1}" . ($lastRow + $lastRow1 + 1);
                // $range3 = "A" . ($lastRow2 + 2) . ":{$lastColumn2}" . ($lastRow + $lastRow2 + 1); // Update the lastColumn2
                
                // $styleArray = array(
                //     'borders' => array(
                //         'allborders' => array(
                //             'style' => PHPExcel_Style_Border::BORDER_THIN,
                //         ),
                //     ),
                // );

                // $this->excel->getActiveSheet()->getStyle($range)->applyFromArray($styleArray);
                // $this->excel->getActiveSheet()->getStyle($range1)->applyFromArray($styleArray);
                // $this->excel->getActiveSheet()->getStyle($range2)->applyFromArray($styleArray);
                // $this->excel->getActiveSheet()->getStyle($range3)->applyFromArray($styleArray);

        
            // Output Excel file
            $filename = 'TTS_PO.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
        
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        
            ob_start();
            $objWriter->save('php://output');
            $excelOutput = ob_get_clean();
        
            // Store the Excel data in the session for later retrieval
            $this->session->set_userdata('excel_data', base64_encode($excelOutput));
        
            echo json_encode(array('success' => true));
            exit();
        }
        
        public function downloadExcelFile()
        {
            // Retrieve the Excel data from the session
            $excelData = $this->session->userdata('excel_data');
        
            // Output Excel file for download
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="PO REPORT '.time().'.xls"');
            header('Cache-Control: max-age=0');
        
            echo base64_decode($excelData);
            exit();
        }

        public function rfpReportExcel()
        {
            // Retrieve input data
            $company = $this->input->post('company');
            $rfp = $this->input->post('rfp');
            $dateFrom = $this->input->post('dateFrom');
            $dateTo = $this->input->post('dateTo');
   
            // Set up Excel sheet
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getActiveSheet()->setTitle('Telegraphic Transfer PO');
        
            // Define the header
            $header = array(
                'DATE',
                'VENDOR',
                'PO NUMBER',
                'PO DATE',
                'COMPANY',
                'PRO-FORMA INVOICE',
                'FINAL INVOICE',
                'CURRENCY',
                'AMOUNT',
                'PAID AMOUNT',
                'BALANCE',
                'PAYMENT TYPE',
                'DATE',
                'REFERENCE NO.',
                'REMARKS',
                'RFP'
            );
        
            // Generate Excel file
            $this->excel->getActiveSheet()->fromArray([$header]);
        
            // Set background color for the header
            $headerRange = 'A1:P1';
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
            
            $h = $this->adjustmentDeductionReportModel->generateReportByRFP($rfp, $dateFrom, $dateTo);

            // Iterate through the data and set cell values
            $rowNumber = 2; // Start from row 2 (after the header)
            
            foreach ($h as $row)
            {
                $column = 'A';
            
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['dateCreated']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['vendorName']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['PONumber']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['PODate']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['company_name']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['proformaInvoice']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['finalInvoice']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['currency']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['POAmount']);
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

                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
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

                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['remarks']);
                $column++;
                $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $row['rfp']);
            
                // Increment rowNumber here, outside of the inner loop
                $rowNumber++;

                $i = $this->adjustmentDeductionReportModel->generateTBLPaymentExcelRFP($row['PONumber'], $row['rfp']);
            
                // // // var_dump($i);
                // // // exit();

                $total = 0;

                foreach ($i as $ii) 
                {
                    $amount = $ii['origAmt']; 

                    // add the total of payment amount
                    $total +=  floatval($amount); 

                    $column = 'A'; // Reset column for inner loop
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $ii['amount']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $ii['total_balance']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $ii['paymentName']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber,  $ii['date_created']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $ii['remarks']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $ii['rfp']);
                    $column++;


                    // Increment rowNumber for the next iteration of the inner loop
                    $rowNumber++;
                    
                }

          
                // $rowNumber++;

                $j = $this->adjustmentDeductionReportModel->generateOtherPaymentExcelRFP($row['PONumber'], $row['rfp']);

                // var_dump($j);
                // exit();

                foreach($j as $jj)
                {
                    $column = 'A';
         
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;

                    if($jj['transactionCode'] == 1)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '(' . $jj['otherTotalDeduc'] . ')');
                        $column++;
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $jj['otherTotalDeduc']);
                        $column++;
                    }

                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, ' ');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $jj['transact_name']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $jj['dateCreated']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $jj['referenceNumber']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $jj['Remarks']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $jj['rfp']);
                    $column++;


                    // Increment rowNumber for the next iteration of the inner loop
                    $rowNumber++;
                    

                }

                // $rowNumber++;
                // // // $column2 = 'A';
                // // // $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, 'NON PO RELATED PAYMENT');
                // // // $column2++;

                $rowNumber++;

                $k = $this->adjustmentDeductionReportModel->generateNonRelatedPOExcelRFP($row['PONumber'], $row['rfp']);

                // var_dump($k);
                // exit();
                
                $tot = 0;

                foreach($k as $kk)
                {   
                    $column = 'A';

                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '');
                    $column++;

                    if($kk['transact_type'] == 2)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '('. number_format($kk['amount2'], 2, '.', ',') .')');
                        $column++;
                    }

                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, number_format($kk['amount2'], 2, '.', ','));
                        $column++;
                    }

                    // condition if the type is deduction
                    if($kk['transact_type'] == 2)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '(' . number_format(floatval($kk['newAmt']), 2, '.', ','). ')');
                        $column++;

                        $tot += floatval((-$kk['newAmt']));
                    }

                    //or the type is additional
                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, number_format(floatval($kk['newAmt'])), 2, '.', ',');
                        $column++;

                        $tot += floatval($kk['newAmt']);
                    }
                   
                    if($kk['total'] == 0)
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber,  number_format(floatval($kk['total']), 2, '.', ',') );
                        $column++;
                    }
                    else
                    {
                        $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, '(' .  number_format(floatval($kk['total']), 2, '.', ',') . ')' );
                        $column++;
                    }


                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $kk['transactionName']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $kk['date_created']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $kk['reference_no']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $kk['remarks']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $kk['rfp']);
                    $column++;


                    // Increment rowNumber for the next iteration of the inner loop
                    $rowNumber++;
                    
                }

                $columnTotal = 'I';
                $this->excel->getActiveSheet()->setCellValue($columnTotal . $rowNumber, 'Total ');
                $columnTotal++;

                $kokey = $total + $tot;

                $column2 = 'J';
                $this->excel->getActiveSheet()->setCellValue($column2 . $rowNumber, number_format(floatval($kokey), 2, '.', ','));
                $column2++;
            
                // Increment rowNumber for the next iteration of the outer loop
                $rowNumber++;
                $rowNumber++;
            }


                // // Add borders to the entire table (including header)
                // $lastColumn = 'J';
                // $lastColumn1 = 'J';
                // $lastColumn2 = 'J';

                // $lastRow = count($h) + 1; // Add 1 for the header row
                // $lastRow1 = count($i) + 1;
                // $lastRow2 = count($k) + 1;
                

                // $range = "A1:{$lastColumn}{$lastRow}";
                // $range1 = "A" . ($lastRow + 2) . ":{$lastColumn1}" . ($lastRow + $lastRow1 + 1);
                // $range2 = "A" . ($lastRow1 + 2) . ":{$lastColumn1}" . ($lastRow + $lastRow1 + 1);
                // $range3 = "A" . ($lastRow2 + 2) . ":{$lastColumn2}" . ($lastRow + $lastRow2 + 1); // Update the lastColumn2
                
                // $styleArray = array(
                //     'borders' => array(
                //         'allborders' => array(
                //             'style' => PHPExcel_Style_Border::BORDER_THIN,
                //         ),
                //     ),
                // );

                // $this->excel->getActiveSheet()->getStyle($range)->applyFromArray($styleArray);
                // $this->excel->getActiveSheet()->getStyle($range1)->applyFromArray($styleArray);
                // $this->excel->getActiveSheet()->getStyle($range2)->applyFromArray($styleArray);
                // $this->excel->getActiveSheet()->getStyle($range3)->applyFromArray($styleArray);

        
            // Output Excel file
            $filename = 'TTS_PO.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
        
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        
            ob_start();
            $objWriter->save('php://output');
            $excelOutput = ob_get_clean();
        
            // Store the Excel data in the session for later retrieval
            $this->session->set_userdata('excel_data_rfp', base64_encode($excelOutput));
        
            echo json_encode(array('success' => true));
            exit();
        }

        public function downloadExcelFileRFP()
        {
            // Retrieve the Excel data from the session
            $excelData = $this->session->userdata('excel_data_rfp');
        
            // Output Excel file for download
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="PO REPORT RFP'.time().'.xls"');
            header('Cache-Control: max-age=0');
        
            echo base64_decode($excelData);
            exit();
        }

        public function generateExcelReportsAllPO()
        {
    
            $dateFrom = $this->input->post('dateFrom');
            $dateTo = $this->input->post('dateTo');
            
        
            // Output Excel file
            $filename = 'TTS_PO.xls';
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
        
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        
            ob_start();
            $objWriter->save('php://output');
            $excelOutput = ob_get_clean();
        
            // Store the Excel data in the session for later retrieval
            $this->session->set_userdata('excel_data_all', base64_encode($excelOutput));
        
            echo json_encode(array('success' => true));
            exit();
        }
        
        public function downloadExcelFilesALLPO()
        {
            // Retrieve the Excel data from the session
            $excelDataAll = $this->session->userdata('excel_data_all');
        
            // Output Excel file for download
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="ALL PO REPORT '.time().'.xls"');
            header('Cache-Control: max-age=0');
        
            echo base64_decode($excelDataAll);
            exit();
        }

        public function generatePdfPO_2()
        {
            $compCode = $this->input->post('compCode');
            $vendor = $this->input->post('vendor');
            $reference = $this->input->post('reference');
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

                $data = $this->adjustmentDeductionReportModel->generatePOExcel($compCode, $vendor, $reference, $dateFrom, $dateTo);

                foreach($data as $datas)
                {
                    $html .= '<font size="9" face="Courier New"><dl>
                    
                    <dt><b>PO number: </b>'.$datas['PONumber'].'</dt>
                    <dt><b>PO date:</b> '.$datas['PODate'].'</dt>
                    <dt><b>Company:</b> '.$datas['company_name'].'</dt>
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

                    $html .= '<font size="8.5" face="Courier New" >
                        <table >
                            <thead>
                                <tr>
                                    <th style="font-weight: bold; ">PROFORMA</th>
                                    <th style="font-weight: bold; ">FINAL INVOICE</th>
                                    <th style="font-weight: bold; ">CURRENCY</th>
                                    <th style="font-weight: bold; ">AMOUNT</th>
                                    <th style="font-weight: bold; ">PAYMENT</th> 
                                    <th style="font-weight: bold; ">BALANCE</th> 
                                    <th style="font-weight: bold; ">PAYMENT TYPE</th> 
                                    <th style="font-weight: bold; ">DATE</th> 
                                    <th style="font-weight: bold; ">REFERENCE NO.</th> 
                                    <th style="font-weight: bold; ">REMARKS</th> 
                                    <th style="font-weight: bold; ">RFP</th> 
                                </tr>
                            </thead>
        
                            <tbody>
                            </tbody>
                        </table>
                    </font>';

                    $html .= '
                        <font size="8.5" face="Courier New">
                            <table>
                                <tr>
                                    <td >'.$datas['proformaInvoice'].'</td>
                                    <td >'.$datas['finalInvoice'].'</td>
                                    <td >'.$datas['currency'].'</td>
                                    <td >'.$datas['POAmount'].'</td>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td >'.$datas['remarks'].'</td>
                                    <td >'.$datas['rfp'].'</td>
                                </tr>
                        ';
                        

                        $e = $this->adjustmentDeductionReportModel->generateTBLPaymentExcel($compCode, $vendor, $datas['PONumber']);

                        // var_dump($e);
                        // exit();

                        $totalOfInitialPayment = 0;

                        foreach($e as $ee)
                        {
                            $amount = $ee['origAmt']; 
                            
                            $totalOfInitialPayment +=  floatval($amount);  // Use += to add the amount to the total

                            $html .= '
                                <tr>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td >'.$ee['amount'].'</td>
                                    <td >'.$ee['total_balance'].'</td>
                                    <td>'.$ee['paymentName'].'</td>
                                    <td>'.$ee['date_created'].'</td>
                                    <td></td>
                                    <td >'.$ee['remarks'].'</td>
                                    <td >'.$ee['rfp'].'</td>
                                </tr>';
                        }

                        
                        $f = $this->adjustmentDeductionReportModel->generateOtherPaymentExcel($compCode, $reference, $vendor, $datas['PONumber']);

                        $tott = 0;

                        $totalOfPORelatedPayment = 0;

                        $totalAmt = 0;

                        $totalPayment = 0;
                        
                        foreach($f as $ff)
                        {

                            $html .= '
                                <tr>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td >';

                                    
                                    if($ff['transactionCode'] == 1)
                                    {
                                        $html .='('.number_format($ff['amount'], 2, '.', ',') .')';
                                        $totalAmt += floatval((-$ff['amount']));
                                    }
                                    else
                                    {
                                        $html .= ''.number_format($ff['amount'], 2, '.', ',') .'';
                                        $totalAmt += floatval($ff['amount']);
                                    }

                                    
                                 $html .= '</td>
                                           <td >';

                                    if($ff['transactionCode'] == 1)
                                    {   
                                        $html .='('.number_format($ff['origOtherTotalDeduc'], 2, '.', ',') .')';

                                        $totalOfPORelatedPayment += floatval((-$ff['origOtherTotalDeduc']));
                                        $totalPayment += floatval(-$ff['origOtherTotalDeduc']);
                                    }

                                    else
                                    {
                                        $html .= ''.number_format($ff['origOtherTotalDeduc'], 2, '.', ',') .'';

                                        $totalOfPORelatedPayment += floatval($ff['origOtherTotalDeduc']);
                                        $totalPayment += floatval($ff['origOtherTotalDeduc']);
                                    }
                                    
                                $html .= '</td>
                                    <td >';

                                    
                                    if($ff['transactionCode'] == 1)
                                    {   
                                        if($ff['total'] == 0)
                                        {
                                            $html .=''.number_format($ff['total'], 2, '.', ',').'';
                                        }

                                        else
                                        {
                                            $html .='('.number_format($ff['total'], 2, '.', ',').')';
                                        }
                                        
                                        
                                    }

                                    else
                                    {
                                        $html .=''.number_format(abs($ff['total']), 2, '.', ',').'';
                                    }

                                        
                                   
                               $html .='</td>
                                    <td >'.$ff['transact_name'].'</td>
                                    <td >'.$ff['dateCreated'].'</td>
                                    <td >'.$ff['referenceNumber'] .'</td>
                                    <td >'.$ff['Remarks']. '</td>
                                    <td >'.$ff['rfp'] . '</td>
                                </tr>';
                        }


                        $g = $this->adjustmentDeductionReportModel->generateNonRelatedPOExcel($compCode, $reference, $vendor, $datas['PONumber']);

                        // var_dump($g);
                        // exit();
                        $tote = 0;

                        $totalOfNonPORelated = 0;

                        $totaldulo = 0;

                        foreach ($g as $gg) 
                        {
                            $html .= '
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>';
                               if($gg['transact_type'] == 2)
                               {
                                  $html .= '(' . number_format($gg['amount2'], 2, '.', ',') . ')';
                                  
                                  $tote += floatval((-$gg['amount2']));
                               }
                               
                               else
                               {
                                    $html .= '' . number_format($gg['amount2'], 2, '.', ',') . '';

                                    $tote += floatval($gg['amount2']);
                               }
                                     
                                    
                            $html .='</td>
                                    <td>';
                        
                                    if ($gg['transact_type'] == 2)
                                    {

                                        $html .='('.number_format(floatval($gg['newAmt']), 2, '.', ',' ).')';
                                        $totalOfNonPORelated += floatval(-$gg['newAmt']);
                                    }

                                    else 
                                    {
                                        $html .=number_format(floatval($gg['newAmt']), 2, '.', ',');
                                        $totalOfNonPORelated += floatval($gg['newAmt']);
                                    }
                            
                            $html .= '</td>
                                    <td>';
                                    
                                    if($gg['transact_type'] == 2)
                                    {
                                        if($gg['total'] == 0)
                                        {
                                            $html .= ''. number_format($gg['total'], 2, '.', ',') . '';
                                        }

                                        else
                                        {
                                            $html .= '('. number_format($gg['total'], 2, '.', ',') . ')';
                                        }

                                        // $totaldulo += floatval((-$gg['total']));
                                    }

                                    else
                                    {
                                        $html .= ''. number_format($gg['total'], 2, '.', ',') . '';

                                        $totaldulo += floatval($gg['total']);
                                    }
      
                            $html .='</td>
                                    <td>' . $gg['transactionName'] . '</td>
                                    <td>' . $gg['date'] . '</td>
                                    <td>' . $gg['reference_no'] . '</td>
                                    <td>' . $gg['remarks'] . '</td>
                                    <td>' . $gg['rfp'] . '</td>
                                </tr>';
                        }
                    

                        $totalOfInitialOther= 0;

                        // check if balance = 0;
                        // if($ee['total_balance'] == 0)
                        // {
                        //     $totalOfInitialOther = $tottt + $totaldulo;
                        
                        // }

                        // else
                        // {
                        //     $totalOfInitialOther = $total + $tot;
                         
                        // }
                        
                        //condition of balance is 0
                        if($ee['total_balance'] == 0)
                        {
                            $finalTotal = $totalPayment + $totalOfNonPORelated;
                        }
                        
                        else
                        {
                            $finalTotal = $totalOfInitialPayment + $totalPayment + $totalOfNonPORelated;
                        }


                        $line = '<hr>';

                        $html .= '
                        <tr>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'Total: </td>
                        <td>'.$line. number_format($finalTotal, 2, '.', ',').'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        </tr>';

                }
          
           

                $pdf->writeHTML($html, true, false, true, false, '');
    
                // Generate a unique filename for the PDF
                $pdfFilename = 'po_report_' . time() . '.pdf';
                $pdfFilePath = FCPATH . 'uploadPdfFile/'. $pdfFilename;
    
                $pdf->Output($pdfFilePath, 'F');

                $result = array(
                    'message'   => 'Successfully generated.',
                    'pdfPath'   => base_url('uploadPdfFile/' . $pdfFilename)
                );
    
                echo json_encode($result);

                


        }

        public function generatePdfRFP()
        {
            $compCode = $this->input->post('compCode');
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

                $data = $this->adjustmentDeductionReportModel->generateReportByRFP($rfp, $dateFrom, $dateTo);

                foreach($data as $datas)
                {
                    $html .= '<font size="9" face="Courier New"><dl>
                    
                    <dt><b>RFP: </b>'.$datas['rfp'].'</dt>
                    <dt><b>PO date:</b> '.$datas['PODate'].'</dt>
                    <dt><b>Company:</b> '.$datas['company_name'].'</dt>
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

                    $html .= '<font size="8.5" face="Courier New" >
                        <table >
                            <thead>
                                <tr>
                                    <th style="font-weight: bold; ">PROFORMA</th>
                                    <th style="font-weight: bold; ">FINAL INVOICE</th>
                                    <th style="font-weight: bold; ">CURRENCY</th>
                                    <th style="font-weight: bold; ">AMOUNT</th>
                                    <th style="font-weight: bold; ">PAYMENT</th> 
                                    <th style="font-weight: bold; ">BALANCE</th> 
                                    <th style="font-weight: bold; ">PAYMENT TYPE</th> 
                                    <th style="font-weight: bold; ">DATE</th> 
                                    <th style="font-weight: bold; ">REFERENCE NO.</th> 
                                    <th style="font-weight: bold; ">REMARKS</th> 
                                    <th style="font-weight: bold; ">PO #</th> 
                                </tr>
                            </thead>
        
                            <tbody>
                            </tbody>
                        </table>
                    </font>';

                    $html .= '
                        <font size="8.5" face="Courier New">
                            <table>
                                <tr>
                                    <td >'.$datas['proformaInvoice'].'</td>
                                    <td >'.$datas['finalInvoice'].'</td>
                                    <td >'.$datas['currency'].'</td>
                                    <td >'.$datas['POAmount'].'</td>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td >'.$datas['remarks'].'</td>
                                    <td >'.$datas['PONumber'].'</td>
                                </tr>
                        ';
                        

                        $e = $this->adjustmentDeductionReportModel->generateTBLPaymentExcelRFP($datas['PONumber'], $datas['rfp']);

                        // var_dump($e);
                        // exit();

                        $total = 0;

                        foreach($e as $ee)
                        {
                            $amount = $ee['origAmt']; 
                            
                            $total +=  floatval($amount);  // Use += to add the amount to the total

                            $html .= '
                                <tr>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td >'.$ee['amount'].'</td>
                                    <td >'.$ee['total_balance'].'</td>
                                    <td>'.$ee['paymentName'].'</td>
                                    <td>'.$ee['date_created'].'</td>
                                    <td></td>
                                    <td >'.$ee['remarks'].'</td>
                                    <td >'.$ee['PO_number'].'</td>
                                </tr>';
                        }

                        
                        $f = $this->adjustmentDeductionReportModel->generateOtherPaymentExcelRFP($datas['rfp']);

                        $totalPORelated = 0;

                        foreach($f as $ff)
                        {

                            $html .= '
                                <tr>
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                    <td >';

                                    if($ff['transactionCode'] == 1)
                                    {
                                        $html .='('.number_format($ff['amount'], 2, '.', ',').')';
                                    }

                                    else
                                    {
                                        $html .= ''.number_format($ff['amount'], 2, '.', ',').'';
                                    }
                                    
                            $html .='</td>
                                    <td >';

                                    if($ff['transactionCode'] == 1)
                                    {
                                        $html .='('.number_format($ff['origTotalDeduc'], 2, '.', ',').')';

                                        $totalPORelated += floatval(-$ff['origTotalDeduc']);
                                    }

                                    else
                                    {
                                        $html .= ''.number_format($ff['origTotalDeduc'], 2, '.', ',').'';

                                        $totalPORelated += floatval($ff['origTotalDeduc']);
                                    }
                                    
                            $html .= '</td>
                                    <td >';

                                    if($ff['transactionCode'] == 1)
                                    {
                                        if($ff['total'] == 0)
                                        {
                                            $html .=''.number_format($ff['total'], 2, '.', ',').'';
                                        }

                                        else
                                        {
                                            $html .='('.number_format($ff['total'], 2, '.', ',').')';
                                        }
                                    }

                                    else
                                    {
                                        $html .= ''.number_format($ff['total'], 2, '.', ',').'';

                               
                                    }
                                    
                                    
                            $html  .= '</td>
                                    <td >'.$ff['transact_name'].'</td>
                                    <td >'.$ff['dateCreated'].'</td>
                                    <td >'.$ff['referenceNumber'] .'</td>
                                    <td >'.$ff['Remarks']. '</td>
                                    <td >'.$ff['otherPONumber'] . '</td>
                                </tr>';
                        }

                        $g = $this->adjustmentDeductionReportModel->generateNonRelatedPOExcelRFP($datas['PONumber'], $datas['rfp']);


                        $tot = 0;

                        foreach ($g as $gg) 
                        {
                            $html .= '
                          
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>';
                                    if ($gg['transact_type'] == 2)
                                    {
                                        $html .='('.number_format(floatval($gg['amount2']), 2, '.', ',' ).')';
                                    }
                                    
                                    else 
                                    {
                                        $html .=number_format(floatval($gg['amount2']), 2, '.', ',');
                                    }
                                    
                              $html .='</td>
                                    <td>';
                        
                            if ($gg['transact_type'] == 2)
                            {
                                $html .='('.number_format(floatval($gg['newAmt']), 2, '.', ',' ).')';

                                $tot += floatval(-$gg['newAmt']);

                            }
                            
                            else 
                            {
                                $html .=number_format(floatval($gg['newAmt']), 2, '.', ',');

                                $tot += floatval($gg['newAmt']);
                             
                            }

                            
                            $html .= '</td>
                                    <td>';
                            if ($gg['transact_type'] == 2)
                            {
                                if($gg['total'] == 0)
                                {
                                    $html .=''.number_format(floatval($gg['total']), 2, '.', ',' ).'';
                                }
                                else
                                {
                                    $html .='('.number_format(floatval($gg['total']), 2, '.', ',' ).')';
                                }
                               
                            }
                            
                            else 
                            {
                                $html .=number_format(floatval($gg['total']), 2, '.', ',');
                            }
                            $html .='</td>
                                    <td>' . $gg['transactionName'] . '</td>
                                    <td>' . $gg['date_created'] . '</td>
                                    <td>' . $gg['reference_no'] . '</td>
                                    <td>' . $gg['remarks'] . '</td>
                                    <td>' . $gg['po_number'] .'</td>
                                </tr>
                                
                                ';
                        }
                        
                        if($ee['total_balance'] == 0)
                        {
                            $kokey = $totalPORelated + $tot;
                        }
                        else
                        {
                            $kokey = $total + $totalPORelated + $tot;
                        }

                        $line = '<hr>';

                        $html .= '
                        <tr>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'Total: </td>
                        <td>'.$line.number_format($kokey, 2, '.', ',').'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        <td>'.$line.'</td>
                        </tr>';


                }
          

            $pdf->writeHTML($html, true, false, true, false, '');
    
                // Generate a unique filename for the PDF
                $pdfFilename = 'po_report_' . time() . '.pdf';
                $pdfFilePath = FCPATH . 'uploadPdfFile/'. $pdfFilename;
    
                $pdf->Output($pdfFilePath, 'F');

                $result = array(
                    'message'   => 'Successfully generated.',
                    'pdfPath'   => base_url('uploadPdfFile/' . $pdfFilename)
                );
    
                echo json_encode($result);

        }

        public function generatePdfPO()
        {
    
            $compCode = $this->input->post('compCode');
            
            $currency = $this->input->post('currency');
    
            $dateFrom = $this->input->post('dateFrom');
    
          
            
            $d['poData'] = $this->adjustmentDeductionReportModel->generatePdfAllPo($compCode, $currency);

            $d['mainData'] = $this->adjustmentDeductionReportModel->generatePOBoth();

            $r['header'] = $this->adjustmentDeductionReportModel->generatePO($compCode, $currency);
            
           

            // var_dump($d);

            // $tot['total'] = $this->adjustmentDeductionReportModel->sumTotalPaidPO($compCode, $currency, $dateFrom);
            
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            $pdf->SetTitle('PO_REPORT');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
    
            // $pdf->SetMargins(PDF_MARGIN_TOP);
    
            $pdf->AddPage('L');
    

            
      
                $html = "";

                
                $html .= '<font size="8" face="Courier New" >
                <table style=" padding-top: 5px; padding-bottom: 1px;">
                        <thead>
                       
                            <tr>
                                
                                <th style="  text-align: center; font-weight: bold;  border-bottom: 1px solid black; border-top: 1px solid black;">Vendor</th>
                                <th style="  text-align: center; font-weight: bold; border-bottom: 1px solid black; border-top: 1px solid black;">PO Number</th>
                                <th style="  text-align: center; font-weight: bold; border-bottom: 1px solid black; border-top: 1px solid black;">Company</th>
                                <th style="  text-align: center; font-weight: bold; border-bottom: 1px solid black; border-top: 1px solid black;">Final Invoice</th>
                                <th style="  text-align: center; font-weight: bold; border-bottom: 1px solid black; border-top: 1px solid black;">Pro-forma</th>
                                <th style="  text-align: center; font-weight: bold; border-bottom: 1px solid black; border-top: 1px solid black;">Currency</th>
                                <th style="  text-align: center; font-weight: bold; border-bottom: 1px solid black; border-top: 1px solid black;">Amount</th>
                                <th style="  text-align: center; font-weight: bold; border-bottom: 1px solid black; border-top: 1px solid black;">Balance</th>
                                <th style="  text-align: center; font-weight: bold; border-bottom: 1px solid black; border-top: 1px solid black;">Paid Amount</th>
                                <th style="  text-align: center; font-weight: bold; border-bottom: 1px solid black; border-top: 1px solid black;">RFP</th> 
              
                            </tr>
                  
                        </thead>

                        <tbody>';


                        foreach ($r['header'] as $headers)
                        {

                            $html .= '<tr>
                                        <td style="text-align: center;">' . $headers['vendorName'] . '</td>
                                        <td style="text-align: center;">' . $headers['PONumber'] . '</td>
                                        <td style="text-align: center;">' . $headers['company_name'] . '</td>
                                        <td style="text-align: center;">' . $headers['finalInvoice'] . '</td>
                                        <td style="text-align: center;">' . $headers['proformaInvoice'] . '</td>
                                        <td style="text-align: center;">' . $headers['currency'] . '</td>
                                        <td style="text-align: center;">' . $headers['POAmount'] . '</td>
                                        <td style="text-align: center;">' . $headers['updated_balanced'] . '</td>
                                        <td style="text-align: center;">' . $headers['updated_paid_amount'] . '</td>
                                        <td style="text-align: center;">' . $headers['rfp'] . '</td>
                                       </tr>';


                                       $pay['pays'] = $this->adjustmentDeductionReportModel->fetchPerPaymentPO($compCode, $currency, $headers['PONumber']);

                                       foreach($pay['pays'] as $payees)
                                       {
                                           $html .= '
                                           <tr >
                                               <td>-</td>
                                               <td>-</td>
                                               <td>-</td>
                                               <td>-</td>
                                               <td>-</td>
                                               <td>-</td>
                                               <td>-</td>
                                               <td>-</td>
                                               <td style="text-align: center;">' . $payees['total_payment'] . '</td>
                                               <td style="text-align: center;">' . $payees['paymentName'] . '</td>
                                           
                                           </tr>';
       
                                       }



                                        $html .= '<h6 style="text-align: center;">PO Related</h6>
                                        
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

                                $q['OtherPayment'] = $this->adjustmentDeductionReportModel->generateTBLPayment($compCode, $currency, $headers['PONumber']);

                                foreach($q['OtherPayment'] as $OtherPayments)
                                {

                    
                                        $html .= '
                                        <tr >
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: center;">' . $OtherPayments['otherTransacTypeName'] . '</td>
                                            <td style="text-align: center;">' . $OtherPayments['transact_name'] . '</td>
                                            <td style="text-align: center;">' . $OtherPayments['referenceNumber'] . '</td>
                                            <td style="text-align: center;">' . $OtherPayments['otherTotalDeduc'] . '</td>
                                            <td style="text-align: center;">' . $OtherPayments['updated_deduct_adjustment'] . '</td>
                                            <td style="text-align: center;">' . $OtherPayments['dateCreated'] . '</td>
                                            <td style="text-align: center;">' . $OtherPayments['otherPaymentRfp'] . '</td>
                                        </tr>';

                           

                                }

                                $html .= '<h6 style="text-align: center;">Non PO Related</h6>

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

                                $t['NONPO'] = $this->adjustmentDeductionReportModel->generateNonRelatedPO($compCode, $currency, $headers['PONumber']);

                                foreach($t['NONPO'] as $NONPOS)
                                {
                                    $html .= '
                                    <tr >
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align: center;">' . $NONPOS['otherTransacTypeName'] . '</td>
                                        <td style="text-align: center;">' . $NONPOS['transactionName'] . '</td>
                                        <td style="text-align: center;">' . $NONPOS['reference_no'] . '</td>
                                        <td style="text-align: center;">' . $NONPOS['amount'] . '</td>
                                        <td style="text-align: center;">' . $NONPOS['remarks'] . '</td>
                                        <td style="text-align: center;">' . $NONPOS['date'] . '</td>
                                        <td style="text-align: center;">' . $NONPOS['rfp'] . '</td>
                                       
                                    </tr>';
                                }



                                $html .= '<hr>
                                <hr>
                              ';
                                
                              
   
                        }



                             
                $html .= '  </tbody>
                        </table>
                        </font>';

                    
  

    
                // $html .= '<font size="8" face="Courier New" >
                //     <table style=" padding-top: 5px; padding-bottom: 1px;">
                //             <thead>
                           
                //                 <tr>
                                    
                //                     <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Vendor</th>
                //                     <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">PO Number</th>
                //                     <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Company</th>
                //                     <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Final Invoice</th>
                //                     <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Pro-forma</th>
                //                     <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Currency</th>
                //                     <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Amount</th>
                //                     <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Balance</th>
                //                     <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Paid Amount</th>
                //                     <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">RFP</th> 
                  
                //                 </tr>
                      
                //             </thead>
                //             <tbody>';

                
                //             $arrData = array();
                //             $arr = array();



                //         foreach ($d['poData'] as $pdfDatas)
                //         {

                       
                            
                //             if(in_array($pdfDatas['PONumber'], $arrData))
                //             {

                            
                //                     $html .= '
                                    

                //                     <tr>
                //                         <td style="text-align: center;">-</td>
                //                         <td style="text-align: center;">-</td>
                //                         <td style="text-align: center;">-</td>
                //                         <td style="text-align: center;">' . $pdfDatas['otherTransacTypeName'] . '</td>
                //                         <td style="text-align: center;">' . $pdfDatas['transact_name'] . '</td>
                //                         <td style="text-align: center;">' . $pdfDatas['referenceNumber'] . '</td>
                //                         <td style="text-align: center;">' . $pdfDatas['otherTotalDeduc'] . '</td>
                //                         <td style="text-align: center;">' . $pdfDatas['updated_deduct_adjustment'] . '</td>
                                        
                //                         <td style="text-align: center;">' . $pdfDatas['dateCreated'] . '</td>
                //                         <td style="text-align: center;">' . $pdfDatas['otherPaymentRfp'] . '</td>
                //                     </tr>'; 
                              
                                

                //             }
                            
                            
                //             else
                //             {
                //                 $html .= '
                                
                //                 <hr>
                  

                //                 <tr>
                //                     <td >' . $pdfDatas['vendorName'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['PONumber'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['company_name'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['finalInvoice'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['proformaInvoice'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['currency'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['POAmount'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['updated_balanced'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['updated_paid_amount'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['rfp'] . '</td>
                               
                //                 </tr>';


                //                 $html .= '<h6 style="text-align: center;">Other Payment</h6>';

                //                 $html .= '
                                    

                //                 <tr>
                //                     <td style="text-align: center;">-</td>
                //                     <td style="text-align: center;">-</td>
                //                     <td style="text-align: center;">-</td>
                //                     <td style="text-align: center;">' . $pdfDatas['otherTransacTypeName'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['transact_name'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['referenceNumber'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['otherTotalDeduc'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['updated_deduct_adjustment'] . '</td>
                                    
                //                     <td style="text-align: center;">' . $pdfDatas['dateCreated'] . '</td>
                //                     <td style="text-align: center;">' . $pdfDatas['otherPaymentRfp'] . '</td>
                //                 </tr>'; 

                //                 $html .= '<h6 style="text-align: center;">NON PO Payment</h6>';

             

                //                  array_push($arrData, $pdfDatas['PONumber']);

      
 
                //             } 
                            
                            
                //         }


        
                        
            
                // $html .= '  </tbody>
                //         </table>
                //         </font>';





             
    
       
    
                $pdf->writeHTML($html, true, false, true, false, '');
    
                // Generate a unique filename for the PDF
                $pdfFilename = 'po_report_' . time() . '.pdf';
                $pdfFilePath = FCPATH . 'uploadPdfFile/'. $pdfFilename;
    
                $pdf->Output($pdfFilePath, 'F');

                $result = array(
                    'message'   => 'Successfully generated.',
                    'pdfPath'   => base_url('uploadPdfFile/' . $pdfFilename)
                );
    
                echo json_encode($result);

                

            
    
        }

        public function ALLgeneratePdfPO()
        {
    
            $dateFrom = $this->input->post('dateFrom');
    
            $dateTo = $this->input->post('dateTo');
            
            $d['poData'] = $this->adjustmentDeductionReportModel->ALLgeneratePdfAllPo($dateFrom, $dateTo);

            $tot['total'] = $this->adjustmentDeductionReportModel->ALLsumTotalPaidPO($dateFrom, $dateTo);
            
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            $pdf->SetTitle('PO_REPORT');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
    
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    
            $pdf->AddPage('L');
    
            //Start of pdf file
    
      
                $html = "";
    
                // $html .= '<img src="'.base_url().'/assets/images/Puregold_logo.svg.png" alt="" style="width: 250px;">';
    
    
                $html .= '<font size="9" face="Courier New" >
                    <table style=" padding: 3px;">
                            <thead>
                           
                                <tr>
                                    <th style="  border-bottom: 1px solid black; border-top: 1px solid black;">Date Created</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Vendor</th>
                                    <th style="  border-bottom: 1px solid black; border-top: 1px solid black;">PO Number</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Company</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Final Invoice</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Pro-forma</th>
                                    <th style="  text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">Currency</th>
                                    <th style="  border-bottom: 1px solid black; border-top: 1px solid black;">Original Amount</th>
                                    <th style="  border-bottom: 1px solid black; border-top: 1px solid black;">Deduction</th>
                                    <th style="  border-bottom: 1px solid black; border-top: 1px solid black;">Paid Amount</th>
                                    <th style="  border-bottom: 1px solid black; border-top: 1px solid black;">Balance</th>
                                </tr>
                      
                            </thead>
                            <tbody>';
            
                        foreach ($d['poData'] as $pdfDatas)
                        {
                            $html .= '<tr>
                                <td style="">' . $pdfDatas['formattedDateCreated'] . '</td>
                                <td style="text-align: center;">' . $pdfDatas['vendorName'] . '</td>
                                <td style="">' . $pdfDatas['PONumber'] . '</td>
                                <td style="text-align: center;">' . $pdfDatas['company_name'] . '</td>
                                <td style="text-align: center;">' . $pdfDatas['finalInvoice'] . '</td>
                                <td style="text-align: center;">' . $pdfDatas['proformaInvoice'] . '</td>
                                <td style="text-align: center;">' . $pdfDatas['currency'] . '</td>
                                <td style="">' . $pdfDatas['POAmount'] . '</td>
                                <td style="">' . $pdfDatas['formattedupdated_adjustment_deduction_amt'] . '</td>
                                <td style="">' . $pdfDatas['formattedupdated_paid_amount'] . '</td>
                                <td style="">' . $pdfDatas['formatted_updated_balance'] . '</td>
                            </tr>';
                        }
            
                $html .= '  </tbody>
                        </table>
                        </font>';
    
                $html .= '  <font size="9" face="Courier New" >
                            <table style="padding: 3px;">
                            <thead>';
    
                         foreach ($tot['total'] as $getTotals)
                         {
                            $html .= '<tr>
                                        <th style="text-align: center;  border-top: 1px solid black;"></th>
                                        <th style="text-align: center;  border-top: 1px solid black;"></th>
                                        <th style="text-align: center;  border-top: 1px solid black;"></th>
                                        <th style="text-align: center;  border-top: 1px solid black;"></th>
                                        <th style="text-align: center;  border-top: 1px solid black;"></th>
                                        <th style="text-align: center;  border-top: 1px solid black;"></th>
                                        <th style="text-align: center;  border-top: 1px solid black;">Total: </th>
                                        <th style="text-align: center;  border-top: 1px solid black;">'.$getTotals['currency'].'</th>
                                        <th style="border-top: 1px solid black;">'.$getTotals['total_payment_sum'].'</th>
                                        <th style="border-top: 1px solid black;"></th>
                                        <th style="border-top: 1px solid black;">'.$getTotals['totalPaidAmount'].'</th>
                                        <th style="border-top: 1px solid black;">'.$getTotals['totalBalance'].'</th>

                                    </tr>';      
                         }
                $html .= '  </thead>
                        </table>
                        </font>';
    
       
    
                $pdf->writeHTML($html, true, false, true, false, '');
    
                // Generate a unique filename for the PDF
                $pdfFilename = 'All_po_report_' . time() . '.pdf';
                $pdfFilePath = FCPATH . 'uploadPdfFile/'. $pdfFilename;
    
                $pdf->Output($pdfFilePath, 'F');

                $result = array(
                    'message'   => 'Successfully generated.',
                    'pdfPath'   => base_url('uploadPdfFile/' . $pdfFilename)
                );
    
                echo json_encode($result);
            
    
        }

        public function generateExcelReportsPaidAmount()
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
                    'PO NUMBER',
                    'CURRENCY',
                    'AMOUNT',
                    'PAID AMOUNT',
                    'DEDUCTION',
                    'BALANCE',
                    'RFP',
                    
                    
                );
            
                $data1 = $this->adjustmentDeductionReportModel->fetchdailyTotalPO($company, $dateFrom);

                // var_dump($data1);
                // exit();

                $rowNumber = 2;

                foreach($data1 as $data1s)
                {
                    $column = 'A';
                  
                    $total = 0;

                    $payment = $this->adjustmentDeductionReportModel->generatePaymentDaily($data1s['compCode'], $data1s['PONumber']);

                    
                    $bal = '';

                    foreach($payment as $payments)
                    {
                        $total += floatval($payments['origAmt']);

                        $bal = $payments['origBal'];
                    }

                    $nonrelated = $this->adjustmentDeductionReportModel->NonRelatedPODaily($data1s['compCode'], $data1s['PONumber']);
                    
                    $tot = 0;

                    foreach($nonrelated as $nonrelateds)
                    {
                        // condition if the type is deduction
                        if($nonrelateds['transact_type'] == 2)
                        {

                            $tot += floatval((-$nonrelateds['newAmt']));

                        }

                        else
                        {
                            $tot += floatval($nonrelateds['newAmt']);
                            
                        }

                       
                    }

                    $kokey = $total + $tot;

                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['dateCreated']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['company_name']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['vendorName']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['PONumber']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['currency']);
                    $column++;
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['POAmount']);
                    $column++;
                    
                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, number_format($kokey, 2, '.', ','));
                    $column++;

                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, number_format(abs($tot), 2, '.', ','));
                    $column++;

                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber,  number_format($bal, 2, '.', ','));
                    $column++;

                    $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, $data1s['rfp']);
                    $column++;
                    
                   
                    $rowNumber++;

              

                    // var_dump($payment);
                    // exit();

                   
              
                }

                

                // $totals = $this->adjustmentDeductionReportModel->totalDailyReport($company, $dateFrom);

                // foreach($totals as $tots)
                // {   
                //     $column = 'E';
                //     $column1 = 'F';

                //     $this->excel->getActiveSheet()->setCellValue($column . $rowNumber, 'Total');
                //     $column++;
                //     $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, $tots['grandTotalPOAmt']);
                //     $column1++;
                //     $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, $tots['grandTotalPaidAmt']);
                //     $column1++;
                //     $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, $tots['grandTotalDeducAmt']);
                //     $column1++;
                //     $this->excel->getActiveSheet()->setCellValue($column1 . $rowNumber, $tots['grandTotalBalance']);
                //     $column1++;

                //     // Add borders to the cells
                //     $styleArray = [
                //         'borders' => [
                //             'allborders' => [
                //                 'style' => PHPExcel_Style_Border::BORDER_THIN,
                //             ],
                //         ],
                //     ];

                //     $this->excel->getActiveSheet()->getStyle('E' . $rowNumber . ':' . 'I' . $rowNumber)->applyFromArray($styleArray);

                //     $rowNumber++;
                // }

                
            
                // Generate Excel file
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
                $lastRow = count($data1) + 1; // Add 1 for the header row
                $range = "A1:{$lastColumn}{$lastRow}";
        
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
                    ),
                );
                $this->excel->getActiveSheet()->getStyle($range)->applyFromArray($styleArray);
        
                $filename = 'TTS_PO_ALL.xls';
            
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
                $this->session->set_userdata('excel_data_PO_PAID', base64_encode($excelOutput));
                
                
                echo json_encode(array('success' => true));
        
                exit();
            
    
            
    
        }

        public function downloadExcelFilesPOS()
        {
            // Retrieve the Excel data from the session
            $excelDataAll = $this->session->userdata('excel_data_PO_PAID');
        
            // Output Excel file for download
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Paid PO '.time().'.xls"');
            header('Cache-Control: max-age=0');
        
            echo base64_decode($excelDataAll);
            exit();
        }

        public function generateExcelReportsAllPaidAmount()
        {
            $dateFrom = $this->input->post('dateFrom');
            $dateTo = $this->input->post('dateTo');
        
    
            // if(empty($company) || empty($vendor))
            // {
            //     $response = array(
            //         'stats'     => 1,
            //         'message'   => 'Select generate all if you want to generate all data'
            //     );
    
            //     echo json_encode($response);
            // }
    
            // else
            // {
            
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->setTitle('ALL PAID PO');
            
                // Define the header
                $header = array(
                    'DATE VALIDATED',
                    'COMPANY',
                    'VENDOR',
                    'PO NUMBER',
                    'PO AMOUNTS',
                    'TOTAL DEDUCTIONS',
                    'UPDATED BALANCE',
                    'CURRENCY',
                    'USER CREATED',
                    
                );
            
                $data1 = $this->adjustmentDeductionReportModel->fetchdailyAllTotalPO($dateFrom);
                
                // var_dump($data1);
                // exit();
            
                // Generate Excel file
                $this->excel->getActiveSheet()->fromArray([$header]);
        
                // Set background color for the header
                $headerRange = 'A1:I1'; // Assuming your table has 10 columns, adjust as needed
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
        
                $this->excel->getActiveSheet()->fromArray($data1, null, 'A2'); // Start from cell A2
        
                // Add borders to the entire table (including header)
                $lastColumn = 'I'; // Assuming your table has 10 columns, adjust as needed
                $lastRow = count($data1) + 1; // Add 1 for the header row
                $range = "A1:{$lastColumn}{$lastRow}";
        
                $styleArray = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                        ),
                    ),
                );
                $this->excel->getActiveSheet()->getStyle($range)->applyFromArray($styleArray);
        
                $filename = 'TTS_PO_ALL.xls';
            
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
                $this->session->set_userdata('excel_data_all_PO_PAID', base64_encode($excelOutput));
                
                
                echo json_encode(array('success' => true));
        
                exit();
            
    
            // }
    
        }

        public function downloadExcelFilesALLPOS()
        {
            // Retrieve the Excel data from the session
            $excelDataAll = $this->session->userdata('excel_data_all_PO_PAID');
        
            // Output Excel file for download
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="All Paid PO '.time().'.xls"');
            header('Cache-Control: max-age=0');
        
            echo base64_decode($excelDataAll);
            exit();
        }

        public function searchRFPTODB()
        {
            $rfp = $this->input->post('rfp');

            $search = $this->adjustmentDeductionReportModel->searchRFPToDB($rfp);

            echo json_encode($search);
        }
        
}
