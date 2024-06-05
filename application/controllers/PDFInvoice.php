<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PDFInvoice extends CI_Controller {

    function __construct() { 
        parent::__construct();
        $this->load->library('Pdf'); // Load the Pdf library

       
        
    }

    // Load table data from file
    public function LoadData() {
        $d = $this->telegraphicInvoiceHisModel->fetchInvoiceDataToPdf();
        // Read file lines
        $lines = file($d);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }

    // public function generatePdf()
    // {
    //     $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    //     $pdf->SetTitle('Telegraphic Transfer Invoice'); // Set the title

    //     $pdf->AddPage('L');
    //     $pdf->SetFont('helvetica', '', 12);

    //     // Get the width of the page
    //     $pageWidth = $pdf->getPageWidth();

    //     // Get the width of the title
    //     $titleWidth = $pdf->GetStringWidth('Telegraphic Transfer Invoice');

    //     // Calculate the X coordinate to center the title
    //     $xCoordinate = ($pageWidth - $titleWidth) / 15;

    //     // Set the X coordinate and write the title
    //     $pdf->SetX($xCoordinate);
        
    //     $pdf->Cell(0, 10, 'Telegraphic Transfer Invoice', 0, 1, 'C');

    //     $d = $this->telegraphicInvoiceHisModel->fetchInvoiceDataToPdf();


    //     $pdf->Output('pdfexample.pdf', 'I');

        
    // }

    public function generatePdf()
    {
        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        // $pdf->SetCreator(PDF_CREATOR);
        // $pdf->SetAuthor('Nicola Asuni');
        // $pdf->SetTitle('TCPDF Example 001');
        // $pdf->SetSubject('TCPDF Tutorial');
        // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



        // ---------------------------------------------------------

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 12, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();

        // set text shadow effect
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        



      // Set some content to print
$html = <<<EOD
    <h1 style="text-align:center;">test</h1>

    <h4 style="text-align:right;">Date: test</h4>
    
    <table style="padding-bottom: 50px;">
        <thead>
            <tr>
                <th >Currency:</th>
                <th ></th>
                <th >Sample Currency</th>
            </tr>
        </thead>
    </table>

    <div style="margin-top: 50px;">
        <table cellspacing="" cellpadding="15">
       
            <thead>
                <tr>
                    <th style="border-bottom: 1px solid black; border-top: 1px solid black;">Invoice Number</th>
                    <th style="border-bottom: 1px solid black; border-top: 1px solid black;">PO Amount</th>
                    <th style="border-bottom: 1px solid black; border-top: 1px solid black;">Paid Amount</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>test</td>
                    <td>test</td>
                    <td>test</td>
                </tr>
            </tbody>

        </table>
    </div>

    <div style="margin-top: 50px;">
        <table cellspacing="" cellpadding="4">
    
            <thead>
                <tr>
                    <th style="border-bottom: 1px solid black; border-top: 1px solid black;"></th>
                    <th style="border-bottom: 1px solid black; border-top: 1px solid black;">Total: </th>
                    <th style="border-bottom: 1px solid black; border-top: 1px solid black;"></th>
                    <th style="border-bottom: 1px solid black; border-top: 1px solid black;"></th>
                </tr>
            </thead>


        </table>
    </div>

    <div>
        <table>
            <thead>
                <tr>
                    <th>Prepared by: <br>test</th>
                    <th></th>
                    <th>Checked by: </th>
                    <th></th>
                    <th>Approved by:</th>
                    <th></th>
                    <th>Payment received by:</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
EOD;



        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);




        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('PO_Transfer.pdf', 'I');
    }



    public function do_upload()
    {
            $config['upload_path'] = FCPATH . 'imageUpload/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 100;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile'))
            {
                    $error = array('error' => $this->upload->display_errors());

                    echo json_encode($error);
            }
            else
            {
                    $data = array('upload_data' => $this->upload->data());

                    $this->telegraphicInvoiceHisModel->insertUrl($data);

                    echo json_encode($data);
                    
            }
    }




}


// $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
// $pdf->SetTitle('Telegraphic Transfer Invoice'); // Set the title

// $pdf->AddPage('L');
// $pdf->SetFont('helvetica', '', 12);

// // Get the width of the page
// $pageWidth = $pdf->getPageWidth();

// // Get the width of the title
// $titleWidth = $pdf->GetStringWidth('Telegraphic Transfer Invoice');

// // Calculate the X coordinate to center the title
// $xCoordinate = ($pageWidth - $titleWidth) / 2;

// // Set the X coordinate and write the title
// $pdf->SetX($xCoordinate);
// $pdf->Cell(0, 10, 'Telegraphic Transfer Invoice', 0, 1, 'C');

// $pdf->Output('pdfexample.pdf', 'I');
