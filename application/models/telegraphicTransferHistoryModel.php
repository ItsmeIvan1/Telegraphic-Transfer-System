<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class telegraphicTransferHistoryModel extends CI_Model {

    function inserTelegraphicTransferHistory($id)
    {
        return $this->db->insert('tblTelegraphicTransferHis', $id);
    }

    function fetchTTSDATAHistory()
    {
        $query1 = "SELECT a.telCode, a.vendorCode,
        b.vendorName, c.accountNumber, d.currency, a.accountCurrency, f.paymentName, a.PONumber,
        FORMAT(a.PODate, 'MM-dd-yyyy') AS PODate, FORMAT(CAST(a.POAmount AS DECIMAL(10,2)), 'N2') AS POAmount, a.proformaInvoice, a.commercialInvoice, a.rfpReference,
        e.company_name, a.finalInvoice, a.creditNote, a.debitNote, a.wireTransferFee, g.tts_stats, a.remarks
        FROM tblTelegraphicTransferHis AS a
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

    function fetchInitialPaymentDetails($PO_number, $vendor)
    {
        $query2 = "SELECT
        a.Vendor,
        a.PO_number,
        FORMAT(a.PO_date, 'MM-dd-yyyy') AS PO_date,
        a.PO_amount,
        a.total_payment,
        a.total_balance,
        a.payment_type,
        b.paymentName,
        a.date_created,
        a.total_paid_initial,
        a.updated_total_payment,
        a.rfp,
        a.remarks,
        (SELECT SUM(CAST(total_payment AS DECIMAL(10, 2))) FROM tblPayment WHERE PO_number = a.PO_number) AS sum_total_payment
        FROM
        tblPayment AS a
        LEFT JOIN tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
        WHERE
        a.PO_number = '$PO_number' AND a.Vendor = '$vendor'";

        $result = $this->db->query($query2);

        return $result->result_array();
    }

    function ViewFullPaymentDetails($PO_number, $vendor)
    {
        $query = "SELECT a.PO_number, a.Vendor, a.PO_date, a.PO_amount, a.total_payment, a.total_balance, a.change, a.payment_type, b.paymentName, a.date_created, FORMAT(a.date, 'MM-dd-yyyy') AS date, a.rfp,
        a.remarks
		FROM tblPayment AS a
		LEFT JOIN  tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
		WHERE a.PO_number ='$PO_number' AND a.Vendor = '$vendor' AND payment_type = 2";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchOtherPaymentHisFunc($po_number, $vendor_code)
    {
        // $query = "SELECT a.otherTransTypeCode, a.otherVendorCode, b.otherTransacTypeName, a.otherPONumber, a.transactionCode, d.transactionName, a.transAmt, a.Remarks, a.otherPODate, a.otherPOAmount,
        // a.otherTotalDeduc, a.referenceNumber, a.updateRemainBal, a.dateCreated, a.updated_deduct_adjustment, a.total_paid_amount FROM tblOtherTransactionPO AS a
        // LEFT JOIN tblOtherTransactionType AS b ON a.otherTransTypeCode = b.otherTransacTypeCode
        // LEFT JOIN tblTransactionType AS d ON a.transactionCode = d.transactionCode
        // WHERE a.otherPONumber = '$po_number' AND a.otherVendorCode = '$vendor_code'";

        $query1 = "SELECT 
        a.otherTransTypeCode,
        a.otherVendorCode,
        b.otherTransacTypeName,
        a.otherPONumber,
        a.transactionCode,
        d.transact_name, 
        a.transAmt,
        a.Remarks,
        a.otherPODate,
        a.otherPOAmount,
        a.otherTotalDeduc,
        a.rfp,
        a.total_paid_amount,
        -- FORMAT(CAST(a.otherTotalDeduc AS DECIMAL(10,2)), 'N2') AS otherTotalDeduc,
        (SELECT SUM(CAST(otherTotalDeduc AS DECIMAL(10, 2))) FROM tblOtherTransactionPO WHERE otherPONumber = '$po_number' AND otherVendorCode = '$vendor_code') AS sumTotalDeduct,
        a.referenceNumber,
        a.updateRemainBal,
        a.amount,
        a.total,
        -- a.dateCreated,
        FORMAT(a.dateCreated, 'MM-dd-yyyy HH:mm:ss') AS dateCreated,
        a.updated_deduct_adjustment
        -- FORMAT(CAST(a.updated_deduct_adjustment AS DECIMAL(10,2)), 'N2') AS updated_deduct_adjustment
        FROM tblOtherTransactionPO AS a
        LEFT JOIN tblOtherTransactionType AS b ON a.otherTransTypeCode = b.otherTransacTypeCode
        LEFT JOIN transact_2 AS d ON a.transactionCode =  d.id
        WHERE a.otherPONumber = '$po_number' AND a.otherVendorCode = '$vendor_code'";

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

    function updateTotalBalanceTblPayment($PO_number, $vendorCode, $tblPayment)
    {
        $this->db->where('PO_number', $PO_number);
        $this->db->where('Vendor', $vendorCode);
        $result = $this->db->update('tblPayment', $tblPayment);

        return $result;
    }

    function updateTotalBalanceTblPaymentTotalPaid($PO_number, $vendorCode, $tblPayment)
    {
        $this->db->where('PO_number', $PO_number);
        $this->db->where('Vendor', $vendorCode);
        $result = $this->db->update('tblPayment', $tblPayment);

        return $result;
    }



    function updateTotalBalancedHisTbl($PO_number, $vendor, $tblTelegraphicTransfer)
    {
        $this->db->where('PONumber', $PO_number);
        $this->db->where('vendorCode', $vendor);
        $result = $this->db->update('tblTelegraphicTransferHis', $tblTelegraphicTransfer);

        return $result;
    }

    function updateTotalPaidAmountOtherTbl($PO_number, $vendor, $tblOtherTransactionPO)
    {
        $this->db->where('otherPONumber', $PO_number);
        $this->db->where('otherVendorCode', $vendor);
        $result = $this->db->update('tblOtherTransactionPO', $tblOtherTransactionPO);

        return $result;
    }

    function fetchDataOtherPaymentNONPOToTBL($po_number, $vendor)
    {
        $query = "SELECT a.po_number, a.vendor, FORMAT(a.date, 'yyyy-MM-dd') AS formattedDate, b.otherTransacTypeName, c.transactionName, a.reference_no, a.remarks, a.amount, a.amount2, a.total, a.rfp
        FROM tblOtherTransactNonePO AS a
        LEFT JOIN tblOtherTransactionType AS b ON a.transact_type = b.otherTransacTypeCode
        LEFT JOIN tblTransactionType AS c ON a.[transaction] = c.transactionCode
        WHERE a.po_number = '$po_number' AND a.vendor = '$vendor'";
        

        $res = $this->db->query($query);

        return $res->result_array();
    }

    function fetchTransaction2()
    {
        $query = "SELECT * FROM transact_2";

        $res = $this->db->query($query);

        return $res->result_array();

    }

    function insertTBLOtherPaymentNONPO($id)
    {
        return $this->db->insert('tblOtherTransactNonePO', $id);
    }

    function checkReferenceNoExistInNONPO($referenceNumber, $po_num, $vendor)
    {
        $qry = "SELECT reference_no FROM tblOtherTransactNonePO 
        WHERE reference_no = '$referenceNumber' AND po_number ='$po_num' AND vendor = '$vendor'";

        $res = $this->db->query($qry);

        return $res->row();
    }




}