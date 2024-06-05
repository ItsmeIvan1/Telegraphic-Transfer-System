<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class telegraphicTransferModel extends CI_Model {

    function fetchVendorCode()
    {
        $query = "SELECT * FROM tblVendor WHERE vendorStatus = 1 AND vendor_approval_status = 1";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchAccCode()
    {
        $query = "SELECT * FROM tblAccounts WHERE status = 1 AND account_approval_status = 1";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchCompany()
    {
        $query = "SELECT * FROM tblCompany";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchPaymentTerms()
    {
        $query = "SELECT * FROM tblPaymentTerms WHERE paymentStatus = 1";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchTransaction2()
    {
        $query = "SELECT * FROM transact_2";

        $res = $this->db->query($query);

        return $res->result_array();

    }

    function insertTelegraphicTransfer_tempTBL($id)
    {
       return $this->db->insert('tblTelegraphicTransfer_temp', $id);
    }
    
    function insertTelegraphicTransfer_mainTBL($id)
    {
       return $this->db->insert('tblTelegraphicTransfer', $id);
    }

    function insertHistoryTBL($id)
    {
        return $this->db->insert('tblTelegraphicTransferHis', $id);
    }

    function insertTelegraphicTransfer_historyTBL($id)
    {
        return $this->db->insert('tblTelegraphicTransferHIS', $id);
    }

    function checkIfPoNumAndDateExistDB($PONumber, $vendorCode)
    {
        // $query = "SELECT PONumber, vendorCode FROM tblTelegraphicTransfer 
        // WHERE PONumber = '$PONumber' AND vendorCode = '$vendorCode'";

        $query1 = "SELECT PONumber, vendorCode 
        FROM tblTelegraphicTransfer 
        WHERE PONumber = '$PONumber' AND vendorCode = '$vendorCode'
        UNION
        SELECT PONumber, vendorCode 
        FROM tblTelegraphicTransferHis 
        WHERE PONumber = '$PONumber' AND vendorCode = '$vendorCode'";
        
        $result = $this->db->query($query1);

        return $result->row_array();

    }

    function fetchTTSdata()
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
        b.vendorName, c.accountNumber, d.currency, a.accountCurrency, f.paymentName, a.PONumber,
        FORMAT(a.PODate, 'MM-dd-yyyy') AS PODate, FORMAT(CAST(a.POAmount AS DECIMAL(10,2)), 'N2') AS POAmount, a.proformaInvoice, a.commercialInvoice,
        e.company_name, a.finalInvoice, a.creditNote, a.debitNote, a.wireTransferFee, g.tts_stats, a.remarks
        FROM tblTelegraphicTransfer AS a
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

    function fetchTTSdataInModal($telCode)
    {
        $query = "SELECT a.*, b.vendorName, c.accountNumber, d.company_name FROM tblTelegraphicTransfer AS a
        INNER JOIN tblVendor as b ON a.vendorCode = b.vendorCode 
        INNER JOIN tblAccounts as c ON a.accountCode = c.accountCode
        INNER JOIN tblCompany as d ON a.compCode = d.company_id
        WHERE a.telCode = '$telCode'";

        $result = $this->db->query($query);

        return $result->row_array();
    }

    function updateTTSdata($telCode, $tblTelegraphicTransfer)
    {
        $this->db->where('telCode', $telCode);

        $result = $this->db->update('tblTelegraphicTransfer', $tblTelegraphicTransfer);

        return $result;
    }
    
    function getValueAcc($vendorCode)
    {
        $query = "SELECT a.accountCode,a.vendorAccountCode, a.vendorCode, b.vendorName, c.accountNumber, d.currency, a.account_currency FROM tblVendorAccount AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.account_currency = d.currency_id
        WHERE a.vendorCode ='$vendorCode' AND c.status = '1'";

        $query1 = "SELECT a.accountCode,a.vendorAccountCode, a.account_currency, a.vendorCode, b.vendorName, c.accountNumber, d.currency, e.stats FROM tblVendorAccount AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.account_currency = d.currency_id
		LEFT JOIN tblStatus AS e ON a.status = e.status_id
        WHERE a.vendorCode ='$vendorCode' AND a.status = '1' AND approval_status = 1";

        $result = $this->db->query($query1);

        return $result->result_array();
    }

    // function getValueCurrency($vendorAccountCode)
    // {
      
    //     $query4 = "SELECT a.vendorAccountCode, b.vendorCode, b.vendorName, c.accountNumber, d.currency, a.account_currency FROM tblVendorAccount AS a
    //     LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
    //     LEFT JOIN tblAccounts as c ON a.accountCode = c.accountCode
    //     LEFT JOIN tblCurrency AS d On a.account_currency = d.currency_id
    //     WHERE a.vendorAccountCode = $vendorAccountCode";

    //     $result = $this->db->query($query4);

    //     return $result->row();
    // }
    
    function generateExcel()
    {
        $query = "SELECT
        b.vendorName, c.accountNumber, d.account_currency, f.paymentName, a.PONumber,
        a.PODate, a.POAmount, a.proformaInvoice, a.commercialInvoice, a.rfpReference,
        e.company_name, a.finalInvoice, a.creditNote, a.debitNote, a.wireTransferFee 
        FROM tblTelegraphicTransfer AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblVendorAccount AS d ON a.paymentTermCode = d.account_currency
        LEFT JOIN tblCompany AS e ON a.compCode = e.company_id
		LEFT JOIN tblPaymentTerms AS f on a.accountCurrency = f.paymentTermCode";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function readExcelFile($file_id)
    {
        return $this->db->insert('tblTelegraphicTransfer_temp', $file_id);
    }

    function checkIfExistInDB($id)
    {
        $query = "SELECT * FROM tblTelegraphicTransfer_temp WHERE id='$id'";
        $res = $this->db->query($query);

        return $res->row_array();
    }

    function fetchTTSDataforPayment($telcode)
    {
        $query = "SELECT a.telCode, b.vendorName, a.PONumber, a.POAmount, c.paymentName FROM tblTelegraphicTransfer AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblPaymentTerms AS c ON a.paymentTermCode = c.paymentTermCode
        WHERE a.telcode = '$telcode'";

        $result = $this->db->query($query);

        return $result->row_array();
    }

    function insertPaymentTbl($id)
    {
        return $this->db->insert('tblPayment', $id);
    }

    function fetchtblPayment($PO_number, $vendorCode)
    {
        $query = "SELECT a.payment_id,
                a.Vendor,
                b.vendorName,
                a.PO_number, 
                FORMAT(a.PO_date, 'MM-dd-yyyy') AS PO_date, 
                a.PO_amount,
                a.total_payment, 
                a.amount, 
                a.total_balance,
                a.change,
                a.remarks, 
                a.rfp,
                c.paymentName FROM tblPayment AS a
                LEFT JOIN tblVendor AS b ON a.Vendor = b.vendorCode
                LEFT JOIN tblPaymentTerms AS c ON a.payment_type = c.paymentTermCode
                WHERE a.PO_number = '$PO_number' AND a.Vendor = '$vendorCode'";

        $result = $this->db->query($query);

        return $result->row_array();
    }

    function fetchInitialPaymentModel($PO_number, $vendor)
    {
        // $query = "SELECT a.Vendor, a.PO_number, a.PO_date, a.PO_amount, a.total_payment, a.total_balance, a.payment_type, b.paymentName, a.date_created
		// FROM tblPayment AS a
		// LEFT JOIN  tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
		// WHERE a.PO_number ='$PO_number' AND payment_type = 1";

        $query2 = "SELECT
        a.payment_id,
        a.Vendor,
        a.PO_number,
        a.PO_date,
        a.PO_amount,
        a.total_balance,
        a.total_payment,
        a.amount,
        -- FORMAT(CAST(a.PO_amount AS DECIMAL(10,2)), 'N2') AS PO_amount,
        -- FORMAT(CAST(a.total_payment AS DECIMAL(10,2)), 'N2') AS total_payment,
        -- FORMAT(CAST(a.total_balance AS DECIMAL(10,2)), 'N2') AS total_balance,
        a.payment_type,
        b.paymentName,
        a.rfp,
        a.remarks,
        FORMAT(a.date, 'MM-dd-yyyy') AS date,
       
        FORMAT(a.date_created, 'MM-dd-yyyy HH:mm:ss') AS date_created,
        a.updateRemainBal,
        a.updated_total_payment,
        a.total_paid_initial,
        -- FORMAT(CAST(a.updated_total_payment AS DECIMAL(10,2)), 'N2') AS updated_total_payment,
        
        -- FORMAT(
        -- (SELECT SUM(CAST(total_payment AS DECIMAL(10, 2)))
        -- FROM tblPayment
        -- WHERE PO_number = '$PO_number' AND Vendor = '$vendor' AND payment_type = 1),
        -- 'N2'
        -- ) AS sum_total_payment

      (SELECT SUM(CAST(total_payment AS DECIMAL(10, 2))) FROM tblPayment WHERE PO_number = '$PO_number' AND Vendor = '$vendor') AS sum_total_payment
        FROM
        tblPayment AS a
        LEFT JOIN tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
        WHERE
        a.PO_number = '$PO_number' AND a.Vendor = '$vendor'";

        $result = $this->db->query($query2);

        return $result->result_array();
    }

    function fetchTTSDataForInitial($PO_number, $vendorCode)
    {
        $query3 = "SELECT a.telCode, a.vendorCode,
        b.vendorName, a.accountCode, c.accountNumber, a.paymentTermCode, d.currency, a.accountCurrency, f.paymentName, a.PONumber,
        a.PODate, a.POAmount, a.proformaInvoice, a.compCode, 
        e.company_name, a.remarks, a.finalInvoice, a.status, g.tts_stats
        FROM tblTelegraphicTransfer AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblCompany AS e ON a.compCode = e.company_id
        LEFT JOIN tblPaymentTerms AS f ON a.accountCurrency = f.paymentTermCode
        LEFT JOIN tbl_ttsStatus AS g ON a.status = g.tts_symbol
        WHERE a.PONumber = '$PO_number' AND a.vendorCode = '$vendorCode'";

        $result = $this->db->query($query3);

        return $result->row_array();
    }

    function updateInitialPayment($PO_number)
    {   
        return $this->db->insert('tblPayment', $PO_number);
    }


    function ViewFullPayment($PO_number)
    {
        $query = "SELECT a.PO_number, a.PO_date, a.PO_amount, a.total_payment, a.total_balance, a.change, a.payment_type, b.paymentName, a.date_created
		FROM tblPayment AS a
		LEFT JOIN  tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
		WHERE a.PO_number ='$PO_number' AND payment_type = 2";

        $result = $this->db->query($query);

        return $result->row();
    }

    function sumTotalPayment($PO_number)
    {
        $query = "SELECT SUM(CAST(total_payment AS DECIMAL(10, 4))) FROM tblPayment WHERE PO_number = '$PO_number'";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function updateStatusOfTTS($PO_number, $vendorCode)
    {
        $query = "UPDATE tblTelegraphicTransfer SET status = 'C' WHERE PONumber = '$PO_number' AND vendorCode = '$vendorCode'";

        $result = $this->db->query($query);

        return $result;
    }

    function truncateTBLTelegraphicTransfer($PO_number, $vendorCode)
    {
        $query = "DELETE FROM tblTelegraphicTransfer WHERE PONumber = '$PO_number' AND vendorCode = '$vendorCode'";

        $result = $this->db->query($query);

        return $result;
    }

    function checkProformaAndFinalInvoice($proformaInvoice, $finalInvoice, $poNumber)
    {
        // $query = "SELECT proformaInvoice, finalInvoice FROM tblTelegraphicTransfer
        //         WHERE proformaInvoice = '$proformaInvoice' OR finalInvoice = '$finalInvoice'";
        
        $query2 = "SELECT proformaInvoice, finalInvoice 
        FROM tblTelegraphicTransfer
        WHERE (proformaInvoice = '$proformaInvoice' OR finalInvoice = '$finalInvoice') AND PONumber = '$poNumber'";

        $result = $this->db->query($query2);

        return $result->row_array();
    }   

    function fetchOtherTransactType()
    {
        $query = "SELECT * FROM tblOtherTransactionType";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchDeduction()
    {
        $query = "SELECT * FROM tblTransactionType";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function insertOtherPayment($id)
    {
        return $this->db->insert('tblOtherTransactionPO', $id);
    }

    function fetchOtherPaymentModel($po_number, $referenceNumber)
    {
        $query = "SELECT a.otherTransTypeCode,
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
                    a.referenceNumber,
                    FORMAT(a.dateCreated, 'MM-dd-yyyy') AS dateCreated,
                    a.updated_deduct_adjustment FROM tblOtherTransactionPO AS a
                    LEFT JOIN tblOtherTransactionType AS b ON a.otherTransTypeCode = b.otherTransacTypeCode
                    LEFT JOIN transact_2 AS d ON a.transactionCode = d.id
                    WHERE a.otherPONumber = '$po_number' AND a.referenceNumber = '$referenceNumber'";

        $result = $this->db->query($query);

        return $result->row_array();
    }

    function fetchOtherPaymentModelTbl($po_number, $vendorCode)
    {
        $query = "SELECT 
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
        -- FORMAT(CAST(a.otherTotalDeduc AS DECIMAL(10,2)), 'N2') AS otherTotalDeduc,
        (SELECT SUM(CAST(otherTotalDeduc AS DECIMAL(10, 2))) FROM tblOtherTransactionPO WHERE otherPONumber = '$po_number' AND otherVendorCode = '$vendorCode') AS sumTotalDeduct,
        a.referenceNumber,
        a.updateRemainBal,
        -- a.dateCreated,
        FORMAT(a.dateCreated, 'MM-dd-yyyy') AS dateCreated,
        a.updated_deduct_adjustment,
        a.amount,
        a.total
        -- FORMAT(CAST(a.updated_deduct_adjustment AS DECIMAL(10,2)), 'N2') AS updated_deduct_adjustment
        FROM tblOtherTransactionPO AS a
        LEFT JOIN tblOtherTransactionType AS b ON a.otherTransTypeCode = b.otherTransacTypeCode
        LEFT JOIN transact_2 AS d ON a.transactionCode =  d.id
        WHERE a.otherPONumber = '$po_number' AND a.otherVendorCode = '$vendorCode'";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchInitialOtherTransaction($otherPONumber)
    {
        $query = "SELECT a.transCodePO, a.otherTransTypeCode, b.otherTransacTypeName, a.otherPONumber, a.transactionCode, d.transactionName, a.transAmt, a.Remarks, a.otherPODate, a.otherPOAmount,
        a.otherTotalDeduc FROM tblOtherTransactionPO AS a
        LEFT JOIN tblOtherTransactionType AS b ON a.otherTransTypeCode = b.otherTransacTypeCode
        LEFT JOIN tblTransactionType AS d ON a.transactionCode = d.transactionCode
		WHERE a.otherPONumber = '$otherPONumber'";

        $result = $this->db->query($query);

        return $result->row();
    }

    function checkIfReferenceNoExisting($referenceNumber, $otherPONumber)
    {
        $query ="SELECT referenceNumber FROM tblOtherTransactionPO WHERE referenceNumber = '$referenceNumber' AND otherPONumber = '$otherPONumber'";

        $result = $this->db->query($query);

        return $result->row();
    }

    function updateTotalBalanceIfAddOtherPayment($PO_number, $tblPayment, $vendorCode)
    {
        $this->db->where('PO_number', $PO_number);
        $this->db->where('Vendor', $vendorCode);
        $result = $this->db->update('tblPayment', $tblPayment);

        return $result;
    }

    function updateTotalBalanceInOtherPayment($PO_number, $vendor, $tblOtherPayment)
    {   
        $this->db->where('otherPONumber', $PO_number);
        $this->db->where('otherVendorCode', $vendor);
        $result = $this->db->update('tblOtherTransactionPO', $tblOtherPayment);

        return $result;
    }

    function insertCurrentBalanceToOtherPaymentTbl($id)
    {
        return $this->db->insert('tblOtherTransactionPO', $id);
    }
    
    function updateTotalBalancedMainTbl($PO_number, $vendor, $tblTelegraphicTransfer)
    {
        $this->db->where('PONumber', $PO_number);
        $this->db->where('vendorCode', $vendor);
        $result = $this->db->update('tblTelegraphicTransfer', $tblTelegraphicTransfer);

        return $result;
    }

    function updateTotalPaymentMainTbl($PO_number, $vendor, $tblTelegraphicTransfer)
    {
        $this->db->where('PONumber', $PO_number);
        $this->db->where('vendorCode', $vendor);
        $result = $this->db->update('tblTelegraphicTransfer', $tblTelegraphicTransfer);

        return $result;
    }

    function updatedAdjustmentDeductionMainTbl($PO_number, $vendor, $tblTelegraphicTransfer)
    {
        $this->db->where('PONumber', $PO_number);
        $this->db->where('vendorCode', $vendor);
        $result = $this->db->update('tblTelegraphicTransfer', $tblTelegraphicTransfer);

        return $result;
    }

    function insertTBLOtherPaymentNONPO($id)
    {
        return $this->db->insert('tblOtherTransactNonePO', $id);
    }

    function fetchDataOtherPaymentNONPO($po_number, $vendor)
    {
        $query = "SELECT FORMAT(a.date, 'MM-dd-yyyy') AS date, b.otherTransacTypeName, c.transactionName,  a.reference_no, a.remarks, a.amount, a.amount2, a.total, a.rfp FROM tblOtherTransactNonePO AS a
        LEFT JOIN tblOtherTransactionType AS b ON a.transact_type = b.otherTransacTypeCode
        LEFT JOIN tblTransactionType AS c ON a.[transaction] = c.transactionCode
        WHERE a.po_number = '$po_number' AND a.vendor = '$vendor'";

        $res = $this->db->query($query);

        return $res->row_array();
    }

    function checkReferenceNoExistInNONPO($referenceNumber, $po_num, $vendor)
    {
        $qry = "SELECT reference_no FROM tblOtherTransactNonePO 
        WHERE reference_no = '$referenceNumber' AND po_number ='$po_num' AND vendor = '$vendor'";

        $res = $this->db->query($qry);

        return $res->row();
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
}
