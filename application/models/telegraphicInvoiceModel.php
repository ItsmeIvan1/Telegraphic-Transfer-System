<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class telegraphicInvoiceModel extends CI_Model {

    function fetchVendorCodeInvoice()
    {
        $query = "SELECT * FROM tblVendor WHERE vendorStatus = 1 AND vendor_approval_status = 1";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchCompanyInvoice()
    {
        $query = "SELECT * FROM tblCompany";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function getValueAccInvoice($vendorCode)
    {
        // $query = "SELECT a.accountCode,a.vendorAccountCode, a.vendorCode, b.vendorName, c.accountNumber, d.currency, a.account_currency FROM tblVendorAccount AS a
        // LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        // LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        // LEFT JOIN tblCurrency AS d ON a.account_currency = d.currency_id
        // WHERE a.vendorCode ='$vendorCode' AND c.status = '1'";

        $query1 = "SELECT a.accountCode,a.vendorAccountCode, a.account_currency, a.vendorCode, b.vendorName, c.accountNumber, d.currency, e.stats FROM tblVendorAccount AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.account_currency = d.currency_id
		LEFT JOIN tblStatus AS e ON a.status = e.status_id
        WHERE a.vendorCode ='$vendorCode' AND a.status = '1' AND approval_status = 1";

        $result = $this->db->query($query1);

        return $result->result_array();
    }

    function fetchTTSInvoicedata()
    {
        // $query = "SELECT a.telCode,
        // b.vendorName, c.accountNumber, d.account_currency, f.paymentName, a.PONumber,
        // a.PODate, a.POAmount, a.proformaInvoice, a.commercialInvoice, a.rfpReference,
        // e.company_name, a.finalInvoice, a.creditNote, a.debitNote, a.wireTransferFee 
        // FROM tblTelegraphicTransfer AS a
        // LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        // LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        // LEFT JOIN tblVendorAccount AS d ON a.paymentTermCode = d.account_currency
        // LEFT JOIN tblCompany AS e ON a.compCode = e.company_id
		// LEFT JOIN tblPaymentTerms AS f on a.accountCurrency = f.paymentTermCode";

        $query1 = "SELECT a.telCode, a.vendorCode,
        b.vendorName, c.accountNumber, d.currency, a.accountCurrency, f.paymentName, a.InvoiceNumber,
        FORMAT(a.InvoiceDate, 'MM-dd-yyyy') AS InvoiceDate, FORMAT(CAST(a.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS InvoiceAmount, a.proformaInvoice, a.commercialInvoice, a.rfpReference,
        e.company_name, a.finalInvoice, a.creditNote, a.debitNote, a.wireTransferFee, g.tts_stats, a.remarks
        FROM tblTelegraphicTransferInvoice AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblCompany AS e ON a.compCode = e.company_id
        LEFT JOIN tblPaymentTerms AS f ON a.accountCurrency = f.paymentTermCode
        LEFT JOIN tbl_ttsStatus AS g ON a.status = g.tts_symbol
        WHERE a.status = 'O'";

        $result = $this->db->query($query1);

        return $result->result_array();
    }

    function insertTelegraphicTransfer_tempTBLInvoice($id)
    {
       return $this->db->insert('tblTelegraphicTransferInvoice_temp', $id);
    }

    function checkInvoiceNumberandPO($InvoiceNumber, $vendorCode)
    {
        $query = "SELECT InvoiceNumber, vendorCode FROM tblTelegraphicTransferInvoice WHERE
        InvoiceNumber = '$InvoiceNumber' AND vendorCode = '$vendorCode'";

        $query1 = "SELECT InvoiceNumber, vendorCode 
        FROM tblTelegraphicTransferInvoice 
        WHERE InvoiceNumber = '$InvoiceNumber' AND vendorCode = '$vendorCode'
        UNION
        SELECT InvoiceNumber, vendorCode 
        FROM tblTelegraphicTransferInvoice_his 
        WHERE InvoiceNumber = '$InvoiceNumber' AND vendorCode = '$vendorCode'";

        $result = $this->db->query($query1);

        return $result->row();
    }

    function checkProformaAndCommercial($proformaInvoice, $commercialInvoice, $invoiceNumber)
    {
        // $query = "SELECT proformaInvoice, commercialInvoice FROM tblTelegraphicTransferInvoice WHERE
        // proformaInvoice = '$proformaInvoice' AND commercialInvoice = '$commercialInvoice'";

        $query2 = "SELECT proformaInvoice, commercialInvoice 
        FROM tblTelegraphicTransferInvoice
        WHERE (proformaInvoice = '$proformaInvoice' OR commercialInvoice = '$commercialInvoice') AND InvoiceNumber = '$invoiceNumber'";

        $result = $this->db->query($query2);

        return $result->row();
    }

    function insertPaymentTblInvoices($id)
    {
        return $this->db->insert('tblPayment_invoices', $id);
    }

    function insertTelegraphicInvoices_mainTBL($id)
    {
       return $this->db->insert('tblTelegraphicTransferInvoice', $id);
    }

    function insertTelegraphicInvoices_his($id)
    {
        return $this->db->insert('tblTelegraphicTransferInvoice_his', $id);
    }

    function fetchtblPaymentInvoice($InvoiceNum, $vendor)
    {
        $query = "SELECT a.payment_id, a.vendor, b.vendorName, a.InvoiceNumber, FORMAT(a.InvoiceDate, 'MM-dd-yyyy') AS InvoiceDate, a.InvoiceAmount, a.total_payment, a.amount, a.total_balance, a.change, a.updated_Initial_payment, c.paymentName, a.rfp,
        a.remarks FROM tblPayment_invoices AS a
		LEFT JOIN tblVendor AS b ON a.Vendor = b.vendorCode
		LEFT JOIN tblPaymentTerms AS c ON a.payment_type = c.paymentTermCode
        WHERE a.InvoiceNumber = '$InvoiceNum' AND a.vendor = '$vendor'";

        $result = $this->db->query($query);

        return $result->row_array();
    }

    function fetchtblOtherPaymentInvoice($InvoiceNum, $vendorCode)
    {
        $query = "SELECT
        a.transCodeInvoice,
        b.otherTransacTypeName,
        a.otherVendorCode,
        a.otherInvoiceDate,
        c.vendorName,
        a.otherInvoiceNumber,
        d.transact_name,
        a.transAmt, 
        a.Remarks, 
        a.rfp,
        a.dateCreated,
        a.otherInvoiceAmount,
        a.otherTotalDeduc,
        a.referenceNumber,
        a.update_Initial_deduction FROM tblOtherTransactionInvoice AS a
        LEFT JOIN tblOtherTransactionType AS b ON a.otherTransTypeCode = b.otherTransacTypeCode
        LEFT JOIN tblVendor AS c ON a.otherVendorCode = c.vendorCode
        LEFT JOIN transact_2 AS d ON a.transactionCode = d.id
		WHERE a.otherInvoiceNumber = '$InvoiceNum' AND a.otherVendorCode = '$vendorCode'";

        $result = $this->db->query($query);

        return $result->row_array();
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

    function insertTblOtherPayment($id)
    {
        return $this->db->insert('tblOtherTransactionInvoice', $id);
    }

    function checkIfReferenceNoExisting($referenceNumber, $invoiceNumber)
    {
        $query ="SELECT referenceNumber, otherInvoiceNumber FROM tblOtherTransactionInvoice WHERE referenceNumber = '$referenceNumber' AND otherInvoiceNumber = '$invoiceNumber'";

        $result = $this->db->query($query);

        return $result->row();
    }

    function insertOtherPayment($id)
    {
        return $this->db->insert('tblOtherTransactionInvoice', $id);
    }

    function updateTotalBalanceIfAddOtherPayment($InvoiceNumber, $vendor, $tblPayment_invoices)
    {
        $this->db->where('InvoiceNumber', $InvoiceNumber);
        $this->db->where('Vendor', $vendor);
        $result = $this->db->update('tblPayment_invoices', $tblPayment_invoices);

        return $result;
    }

    
    function fetchPaymentTerms()
    {
        $query = "SELECT * FROM tblPaymentTerms WHERE paymentStatus = 1";

        $result = $this->db->query($query);

        return $result->result_array();
    }


    function fetchInitialPaymentInvoiceModal($InvoiceNumber, $vendor)
    {
        $query = "SELECT 
        a.Vendor, 
        a.InvoiceNumber,
        a.InvoiceDate,
        a.InvoiceAmount, 
        a.total_payment,
        a.amount,
        a.total_balance,
        b.paymentName,
        a.InvoiceDate,
        FORMAT(a.date_created, 'MM-dd-yyyy HH:mm:ss') AS date_created,
        a.payment_type,
        a.updated_Initial_payment,
        a.update_initial_payment2,
        FORMAT(a.date, 'MM-dd-yyyy') AS date,
        a.rfp,
        a.remarks,
        (SELECT SUM(CAST(total_payment AS DECIMAL(10, 2))) FROM tblPayment_invoices WHERE InvoiceNumber = a.InvoiceNumber)
        AS sum_total_payment FROM tblPayment_invoices AS a
        LEFT JOIN tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
        WHERE a.InvoiceNumber = '$InvoiceNumber' AND a.Vendor = '$vendor'";

        $result = $this->db->query($query);

        return $result->result_array();
    }


    function fetchTTSDataForInitial($InvoiceNumber, $vendorCode)
    {
        $query3 = "SELECT a.telCode, a.vendorCode,
        b.vendorName, a.accountCode, c.accountNumber, a.paymentTermCode, d.currency, a.accountCurrency, f.paymentName, a.InvoiceNumber,
        a.InvoiceDate, a.InvoiceAmount, a.proformaInvoice, a.compCode, 
        e.company_name, a.commercialInvoice, a.status, g.tts_stats,
        a.rfp, a.remarks
        FROM tblTelegraphicTransferInvoice AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblCompany AS e ON a.compCode = e.company_id
        LEFT JOIN tblPaymentTerms AS f ON a.accountCurrency = f.paymentTermCode
        LEFT JOIN tbl_ttsStatus AS g ON a.status = g.tts_symbol
        WHERE a.InvoiceNumber = '$InvoiceNumber' AND a.vendorCode = '$vendorCode'";

        $result = $this->db->query($query3);

        return $result->row_array();
    }

    function updateInitialPayment($invoices_number)
    {
        return $this->db->insert('tblPayment_invoices', $invoices_number);
    }

    function updateTotalBalanceInOtherPayment($otherInvoiceNumber, $otherVendorCode, $tblOtherTransactionInvoice)
    {
        $this->db->where('otherInvoiceNumber', $otherInvoiceNumber);
        $this->db->where('otherVendorCode', $otherVendorCode);
        $result = $this->db->update('tblOtherTransactionInvoice', $tblOtherTransactionInvoice);

        return $result;
    }

    function insertHistoryTBL($id)
    {
        return $this->db->insert('tblTelegraphicTransferInvoice_his', $id);
    }

    function truncateTBLTelegraphicTransferInvoice($InvoiceNumber, $vendorCode)
    {
        $query = "DELETE FROM tblTelegraphicTransferInvoice WHERE InvoiceNumber = '$InvoiceNumber' AND vendorCode = '$vendorCode'";

        $result = $this->db->query($query);

        return $result;
    }

    function updateStatusOfTTS($InvoiceNumber)
    {
        $query = "UPDATE tblTelegraphicTransferInvoice SET status = 'C' WHERE InvoiceNumber = '$InvoiceNumber'";

        $result = $this->db->query($query);

        return $result;
    }

    function fetchOtherPaymentModelTbl($InvoiceNum, $vendorCode)
    {
        $query = "SELECT
        a.transCodeInvoice,
        a.update_Initial_deduction,
        a.otherTransTypeCode,
        b.otherTransacTypeName, 
        a.otherVendorCode, 
        c.vendorName,
        a.otherInvoiceNumber,
        a.transactionCode, 
        d.transact_name,
        a.transAmt, 
        a.Remarks,
        FORMAT(a.dateCreated, 'MM-dd-yyyy HH:mm:ss') AS dateCreated,
        a.otherInvoiceAmount,
        a.otherTotalDeduc,
        a.amount,
        a.total,
        a.rfp,
        (SELECT SUM(CAST(otherTotalDeduc AS DECIMAL(10, 2))) FROM tblOtherTransactionInvoice WHERE otherInvoiceNumber = '$InvoiceNum' AND otherVendorCode = '$vendorCode') AS sumTotalDeduct,
        a.referenceNumber FROM tblOtherTransactionInvoice AS a
        LEFT JOIN tblOtherTransactionType AS b ON a.otherTransTypeCode = b.otherTransacTypeCode
        LEFT JOIN tblVendor AS c ON a.otherVendorCode = c.vendorCode
        LEFT JOIN transact_2 AS d ON a.transactionCode = d.id
		WHERE a.otherInvoiceNumber = '$InvoiceNum' AND a.otherVendorCode = '$vendorCode'";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function updateTotalBalancedMainTbl($InvoiceNumber, $vendor, $tblTelegraphicTransferInvoice)
    {
        $this->db->where('InvoiceNumber', $InvoiceNumber);
        $this->db->where('vendorCode', $vendor);
        $result = $this->db->update('tblTelegraphicTransferInvoice', $tblTelegraphicTransferInvoice);

        return $result;
    }

    function updateTotalPaymentMainTbl($InvoiceNumber, $vendor, $tblTelegraphicTransferInvoice)
    {
        $this->db->where('InvoiceNumber', $InvoiceNumber);
        $this->db->where('vendorCode', $vendor);
        $result = $this->db->update('tblTelegraphicTransferInvoice', $tblTelegraphicTransferInvoice);

        return $result;
    }

    function updatedAdjustmentDeductionMainTbl($InvoiceNumber, $vendor, $tblTelegraphicTransferInvoice)
    {
        $this->db->where('InvoiceNumber', $InvoiceNumber);
        $this->db->where('vendorCode', $vendor);
        $result = $this->db->update('tblTelegraphicTransferInvoice', $tblTelegraphicTransferInvoice);

        return $result;
    }

    function selectOtherTransact()
    {
        $query = "SELECT * FROM transact_2";

        $res = $this->db->query($query);

        return $res->result_array();
    }

    function InsertNonInvoice($id)
    {
       return $this->db->insert('tblOtherTransactNoneInvoice', $id);
    }

    function checkReferenceNonInvoice($referenceNumber, $invoice_number, $vendor)
    {
        $qry = "SELECT reference_no, invoice_number, vendor FROM tblOtherTransactNoneInvoice
        WHERE reference_no = '$referenceNumber' AND invoice_number = '$invoice_number' AND vendor = '$vendor'";

        $res = $this->db->query($qry);

        return $res->row();
    }

    function fetchNonInvoiceData($invoice_number, $vendor)
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
        
        return $result->row_array();
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

        // echo $qry;
        // exit();

        $result = $this->db->query($qry);
        
        return $result->result_array();
    }


    


}