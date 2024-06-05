<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class telegraphicInvoiceHisModel extends CI_Model { 

    function fetchTTSInvoiceDataHistory()
    {
        $query1 = "SELECT a.telCode, a.vendorCode,
        b.vendorName, c.accountNumber, d.currency, a.accountCurrency, f.paymentName, a.InvoiceNumber,
        FORMAT(a.InvoiceDate, 'MM-dd-yyyy') AS InvoiceDate, FORMAT(CAST(a.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS InvoiceAmount, a.proformaInvoice, a.commercialInvoice, a.rfpReference,
        e.company_name, a.finalInvoice, a.creditNote, a.debitNote, a.wireTransferFee, g.tts_stats, a.remarks
        FROM tblTelegraphicTransferInvoice_his AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblCompany AS e ON a.compCode = e.company_id
				LEFT JOIN tblPaymentTerms AS f ON a.accountCurrency = f.paymentTermCode
        LEFT JOIN tbl_ttsStatus AS g ON a.status = g.tts_symbol
        WHERE a.status = 'C'";

        $result = $this->db->query($query1);

        return $result->result_array();
    }

    function fetchType()
    {
        $query = "SELECT * FROM tblOtherTransactionType";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchTransactType()
    {
        $query = "SELECT * FROM tblTransactionType";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchInitialPaymentDetails($InvoiceNumber, $Vendor)
    {
        $query2 = "SELECT
        a.Vendor,
        a.InvoiceNumber,
        FORMAT(a.InvoiceDate, 'MM-dd-yyyy') AS InvoiceDate,
        a.InvoiceAmount,
        a.total_payment,
        a.total_balance,
        a.payment_type,
        b.paymentName,
        FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created,
        a.rfp,
        FORMAT(a.date, 'MM-dd-yyyy') AS date,
        a.updated_Initial_payment,
        (SELECT SUM(CAST(total_payment AS DECIMAL(10, 2))) FROM tblPayment_invoices WHERE InvoiceNumber = a.InvoiceNumber) AS sum_total_payment
        FROM
        tblPayment_invoices AS a
        LEFT JOIN tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
        WHERE
        a.InvoiceNumber = '$InvoiceNumber' AND a.Vendor = '$Vendor'";

        $result = $this->db->query($query2);

        return $result->result_array();
    }   

    function fetchFullPayment($InvoiceNumber, $Vendor)
    {
        $query = "SELECT
        a.Vendor,
        a.InvoiceNumber,
        FORMAT(a.InvoiceDate, 'MM-dd-yyyy') AS InvoiceDate,
        a.InvoiceAmount,
        a.total_payment,
        a.total_balance,
        a.payment_type,
        b.paymentName,
        FORMAT(a.date_created, 'MM-dd-yyyy HH:mm:ss') AS date_created,
        a.updated_Initial_payment,
        a.remarks,
        FORMAT(a.date, 'MM-dd-yyyy') AS date,
        a.rfp
        FROM
        tblPayment_invoices AS a
        LEFT JOIN tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
        WHERE
        a.InvoiceNumber = '$InvoiceNumber' AND a.Vendor = '$Vendor' AND a.payment_type = 2";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchOtherPaymentHisFunc($invoice_number, $otherVendorCode)
    {
        $query = "SELECT 
        b.otherTransacTypeName,
        a.otherInvoiceNumber,
        d.transact_name,
        a.transAmt,
        a.Remarks,
        FORMAT(a.otherInvoiceDate, 'MM-dd-yyyy') AS otherInvoiceDate,
        a.otherInvoiceAmount,
        a.otherTotalDeduc, 
        a.referenceNumber, 
        a.updateRemainBal,
        FORMAT(a.dateCreated, 'MM-dd-yyyy') AS dateCreated,
        a.rfp,
        a.amount,
        a.total
        FROM tblOtherTransactionInvoice AS a
        LEFT JOIN tblOtherTransactionType AS b ON a.otherTransTypeCode = b.otherTransacTypeCode
        LEFT JOIN transact_2 AS d ON a.transactionCode = d.id
        WHERE a.otherInvoiceNumber = '$invoice_number' AND a.otherVendorCode = '$otherVendorCode'";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function checkIfReferenceNoExisting($referenceNumber)
    {
        $query ="SELECT referenceNumber FROM tblOtherTransactionInvoice WHERE referenceNumber = '$referenceNumber'";

        $result = $this->db->query($query);

        return $result->row();
    }

    function updateTotalBalanceIfAddOtherPayment($PO_number, $tblPayment)
    {
        $this->db->where('PO_number', $PO_number);

        $result = $this->db->update('tblPayment', $tblPayment);

        return $result;
    }

    
    function insertOtherPayment($id)
    {
        return $this->db->insert('tblOtherTransactionInvoice', $id);
    }

    function checkReferenceNonInvoice($referenceNumber, $invoice_number, $vendor)
    {
        $qry = "SELECT reference_no, invoice_number, vendor FROM tblOtherTransactNoneInvoice
        WHERE reference_no = '$referenceNumber' AND invoice_number = '$invoice_number' AND vendor = '$vendor'";

        $res = $this->db->query($qry);

        return $res->row();
    }

    function fetchNonInvoiceDataToTableModel($invoice_number, $vendor)
    {
        $qry = "SELECT 
        a.invoice_number,
        a.vendor,
        FORMAT(a.date, 'MM-dd-yyyy') AS date,
        b.otherTransacTypeName,
        c.transactionName,
        a.reference_no,
        a.amount,
        a.amount2,
        a.total,
        a.rfp
        FROM tblOtherTransactNoneInvoice AS a
        LEFT JOIN tblOtherTransactionType AS b ON a.transact_type = b.otherTransacTypeCode
        LEFT JOIN tblTransactionType AS c ON a.[transaction] = c.transactionCode
        WHERE a.invoice_number = '$invoice_number' AND a.vendor = '$vendor'";

        

        $result = $this->db->query($qry);
        
        return $result->result_array();
    }


    function InsertNonInvoice($id)
    {
       return $this->db->insert('tblOtherTransactNoneInvoice', $id);
    }

    function transact_2()
    {
        $qry = "SELECT * FROM transact_2";

        $result = $this->db->query($qry);

        return $result->result_array();
    }

    function fetchInvoiceDataToPdf()
    {
        $query = "SELECT
        a.Vendor,
		c.vendorName,
        a.InvoiceNumber,
        a.InvoiceDate,
        a.InvoiceAmount,
        a.total_payment,
        a.total_balance,
        a.payment_type,
        b.paymentName,
        a.date_created,
        (SELECT SUM(CAST(total_payment AS DECIMAL(10, 2))) FROM tblPayment_invoices WHERE InvoiceNumber = a.InvoiceNumber AND payment_type = 1) AS sum_total_payment
        FROM
        tblPayment_invoices AS a
        LEFT JOIN tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
		LEFT JOIN tblVendor AS c ON a.vendor = c.vendorCode";
        // WHERE a.InvoiceNumber = '$InvoiceNumber' AND a.payment_type = 1";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function insertUrl($data)
    {
        $file_data = array(
            'file_name' => $data['upload_data']['file_name'],
            'file_size' => $data['upload_data']['file_size'],
            'file_url'  => base_url('imageUpload/' . $data['upload_data']['file_name']),
            'file_type' => $data['upload_data']['file_type'],
        );


         $this->db->insert('tbl_fileUpload', $file_data);
    }

    function updatedPaidAmount($InvoiceNumber, $vendorCode, $tblInvoiceHis)
    {
        $this->db->where('InvoiceNumber', $InvoiceNumber);
        $this->db->where('vendorCode', $vendorCode);
        $result = $this->db->update('tblTelegraphicTransferInvoice_his', $tblInvoiceHis);

        return $result;
    }

    function updatedPaidAmountTblPaymentInvoice($InvoiceNumber, $vendorCode, $tblPayment_invoices)
    {
        $this->db->where('InvoiceNumber', $InvoiceNumber);
        $this->db->where('Vendor', $vendorCode);
        $result = $this->db->update('tblPayment_invoices', $tblPayment_invoices);

        return $result;
    }

    


}