<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class adjustmentDeductionReportInvoiceModel extends CI_Model {

    function selectCompany()
    {
        $query = "SELECT * FROM tblCompany";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function selectVendor()
    {
        $query = "SELECT * FROM tblVendor WHERE vendorStatus = 1 AND vendor_approval_status = 1";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function selectTransactions()
    {
        $query = "SELECT * FROM tblTransactionType";
        
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function selectCurrency()
    {
        $query = "SELECT * FROM tblCurrency";

        $res = $this->db->query($query);

        return $res->result_array();
    }

    function generateReportInvoices($compCode, $vendorCode, $reference, $dateFrom, $dateTo)
    {
        $whereComp_A = "";
        $whereComp_B = "";

        //if walang laman ang company, vendor and reference
        if(($compCode == '' OR $compCode == null) AND ($vendorCode == '' OR $vendorCode == null) AND ($reference == '' OR $reference == null))
        {
            $whereComp_A = "";
            $whereComp_B = "";
        }

        //if may laman ang company at walang laman ang vendor at reference
        else if(($compCode !== '' OR $compCode !== null) AND ($vendorCode == '' OR $vendorCode == null) AND ($reference == '' OR $reference == null))
        {
            $whereComp_A = "AND a.compCode = '$compCode'";
            $whereComp_B = "AND x.compCode = '$compCode'";
        }   

        //if may laman ang vendor at walang laman ang company at reference
        else if(($vendorCode !== '' OR $vendorCode !== null) AND ($compCode == '' OR $compCode == null) AND ($reference == '' OR $reference == null))
        {
            $whereComp_A = "AND a.vendorCode = '$vendorCode'";
            $whereComp_B = "AND x.vendorCode = '$vendorCode'";
        }

        //if may laman ang reference at walang laman ang company at vendor
        else if(($reference !== '' OR $reference !== null) AND ($compCode == '' OR $compCode == null) AND ($vendorCode == '' OR $vendorCode == null))
        {
            $whereComp_A = "AND (i.referenceNumber = '$reference' OR l.reference_no = '$reference')";
            $whereComp_B = "AND (i.referenceNumber = '$reference' OR l.reference_no = '$reference')";
        }

        //pag pareho may laman
        else
        {
            $whereComp_A = "AND a.compCode = '$compCode' AND a.vendorCode = '$vendorCode' AND i.referenceNumber = '$reference' AND l.reference_no = '$reference'";
            $whereComp_B = "AND x.compCode = '$compCode' AND x.vendorCode = '$vendorCode' AND i.referenceNumber = '$reference' AND l.reference_no = '$reference'";
        }

       $query = "SELECT 
        b.vendorName,
        b.vendorAddress1,
        c.accountNumber,
        d.currency,
        f.paymentName,
        a.InvoiceNumber,
        FORMAT(a.InvoiceDate, 'MM-dd-yyyy') AS InvoiceDate,  
        FORMAT(CAST(a.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS InvoiceAmount,
        a.proformaInvoice,
        a.commercialInvoice,
        e.company_name,
        FORMAT(CAST(a.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
        FORMAT(CAST(a.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
        a.remarks,
        a.rfp,
        FORMAT(a.dateCreated, 'yyyy-MM-dd') AS dateCreated,
        i.referenceNumber,
		l.reference_no,
        o.bankName,
        o.bankAddress2,
        c.swiftCode,
        c.ibanNo,
        c.abaNo
        
        FROM tblTelegraphicTransferInvoice AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblCompany AS e ON a.compCode = e.company_id
        LEFT JOIN tblPaymentTerms AS f ON a.accountCurrency = f.paymentTermCode
        LEFT JOIN tblOtherTransactionInvoice AS i ON a.vendorCode = i.otherVendorCode AND a.InvoiceNumber = i.otherInvoiceNumber
        LEFT JOIN tblOtherTransactNoneInvoice AS l ON a.vendorCode = l.vendor AND a.InvoiceNumber = l.invoice_number
        LEFT JOIN tblBankInformation as o ON c.bankCode = o.bankCode

        WHERE 
       
        a.dateCreated BETWEEN '$dateFrom' AND '$dateTo' $whereComp_A
        
        UNION ALL
        
        SELECT 
        
        b.vendorName, 
        b.vendorAddress1,
        c.accountNumber,
        d.currency,
        f.paymentName,
        x.InvoiceNumber,
        FORMAT(x.InvoiceDate, 'MM-dd-yyyy') AS InvoiceDate,  
        FORMAT(CAST(x.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS InvoiceAmount,
        x.proformaInvoice,
        x.commercialInvoice,
        e.company_name,
        FORMAT(CAST(x.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
        FORMAT(CAST(x.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
        x.remarks,
        x.rfp,
        FORMAT(x.dateCreated, 'yyyy-MM-dd') AS dateCreated,
        i.referenceNumber,
		l.reference_no,
        o.bankName,
        o.bankAddress2,
        c.swiftCode,
        c.ibanNo,
        c.abaNo
        
        FROM tblTelegraphicTransferInvoice_his AS x
        LEFT JOIN tblVendor AS b ON x.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON x.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON x.paymentTermCode = d.currency_id
        LEFT JOIN tblCompany AS e ON x.compCode = e.company_id
        LEFT JOIN tblPaymentTerms AS f ON x.accountCurrency = f.paymentTermCode
        LEFT JOIN tblOtherTransactionInvoice AS i ON x.vendorCode = i.otherVendorCode AND x.InvoiceNumber = i.otherInvoiceNumber
        LEFT JOIN tblOtherTransactNoneInvoice AS l ON x.vendorCode = l.vendor AND x.InvoiceNumber = l.invoice_number
        LEFT JOIN tblBankInformation as o ON c.bankCode = o.bankCode

        WHERE 

        x.dateCreated BETWEEN '$dateFrom' AND '$dateTo' $whereComp_B
        
        ORDER BY dateCreated";
        
        // echo $query;
        // exit();

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function generateALLInvoice($dateFrom, $dateTo)
    {
        $query ="SELECT
        b.company_name,
        c.vendorName,
        FORMAT(a.InvoiceDate, 'MM-dd-yyyy') AS formattedInvoiceDate,
        a.InvoiceNumber,
        FORMAT(CAST(a.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS formattedInvoiceAmount,
        FORMAT(CAST(e.total_payment AS DECIMAL(10,2)), 'N2') AS formattedtotal_payment,
        FORMAT(CAST(e.total_balance AS DECIMAL(10,2)), 'N2') AS formattedtotal_balance,
        d.currency,
        g.transactionName,  
        FORMAT(SUM(CAST(f.otherTotalDeduc AS DECIMAL(10,2))), 'N2') AS totalFormattedTotalDeduc,
        f.referenceNumber,
        f.remarks,
        FORMAT(CAST(f.update_Initial_deduction AS DECIMAL(10,2)), 'N2') AS totalFormattedUpdate_Initial_deduction,
        FORMAT(a.dateCreated, 'MM-dd-yyyy') AS formattedDateCreated,
        FORMAT(e.date_created, 'MM-dd-yyyy HH:mm:ss') AS formattedDateCreatedInitialPayment,
        FORMAT(f.dateCreated, 'MM-dd-yyyy HH:mm:ss') AS formattedDateCreatedOtherPayment,
        a.userCreated
        FROM tblTelegraphicTransferInvoice AS a
        LEFT JOIN tblCompany AS b ON a.compCode = b.company_id
        LEFT JOIN tblVendor AS c ON a.vendorCode = c.vendorCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblPayment_invoices AS e ON a.vendorCode = e.Vendor AND a.InvoiceNumber = e.InvoiceNumber
        LEFT JOIN tblOtherTransactionInvoice AS f ON a.vendorCode = f.otherVendorCode AND a.InvoiceNumber = f.otherInvoiceNumber
        LEFT JOIN tblTransactionType AS g ON f.transactionCode = g.transactionCode
        WHERE a.dateCreated BETWEEN '$dateFrom' AND '$dateTo'
        GROUP BY
        b.company_name,
        c.vendorName,
        FORMAT(a.InvoiceDate, 'MM-dd-yyyy'),
        a.InvoiceNumber,
        f.referenceNumber,
        f.remarks,
        g.transactionName,
        FORMAT(CAST(a.InvoiceAmount AS DECIMAL(10,2)), 'N2'),
        FORMAT(CAST(e.total_payment AS DECIMAL(10,2)), 'N2'),
        FORMAT(CAST(e.total_balance AS DECIMAL(10,2)), 'N2'),
        d.currency,
        FORMAT(a.dateCreated, 'MM-dd-yyyy'),
        FORMAT(e.date_created, 'MM-dd-yyyy HH:mm:ss'),
        FORMAT(f.dateCreated, 'MM-dd-yyyy HH:mm:ss'),
        a.userCreated,
        f.update_Initial_deduction
    
        UNION ALL
        
        SELECT
        b.company_name,
        c.vendorName,
        FORMAT(h.InvoiceDate, 'MM-dd-yyyy') AS formattedInvoiceDate,
        h.InvoiceNumber,
        FORMAT(CAST(h.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS formattedInvoiceAmount,
        FORMAT(CAST(e.total_payment AS DECIMAL(10,2)), 'N2') AS formattedtotal_payment,
        FORMAT(CAST(e.total_balance AS DECIMAL(10,2)), 'N2') AS formattedtotal_balance,
        d.currency,
        g.transactionName,  
        FORMAT(SUM(CAST(f.otherInvoiceAmount AS DECIMAL(10,2))), 'N2') AS totalFormattedTotalDeduc,
        f.referenceNumber,
        f.remarks,
        FORMAT(CAST(f.update_Initial_deduction AS DECIMAL(10,2)), 'N2') AS totalFormattedUpdate_Initial_deduction,
        FORMAT(h.dateCreated, 'MM-dd-yyyy') AS formattedDateCreated,
        FORMAT(e.date_created, 'MM-dd-yyyy HH:mm:ss') AS formattedDateCreatedInitialPayment,
        FORMAT(f.dateCreated, 'MM-dd-yyyy HH:mm:ss') AS formattedDateCreatedOtherPayment,
        h.userCreated
        FROM tblTelegraphicTransferInvoice_his AS h
        LEFT JOIN tblCompany AS b ON h.compCode = b.company_id
        LEFT JOIN tblVendor AS c ON h.vendorCode = c.vendorCode
        LEFT JOIN tblCurrency AS d ON h.paymentTermCode = d.currency_id
        LEFT JOIN tblPayment_invoices AS e ON h.vendorCode = e.Vendor AND h.InvoiceNumber = e.InvoiceNumber
        LEFT JOIN tblOtherTransactionInvoice AS f ON h.vendorCode = f.otherVendorCode AND h.InvoiceNumber = f.otherInvoiceNumber
        LEFT JOIN tblTransactionType AS g ON f.transactionCode = g.transactionCode
        WHERE h.dateCreated BETWEEN '$dateFrom' AND '$dateTo'
        GROUP BY
        b.company_name,
        c.vendorName,
        FORMAT(h.InvoiceDate, 'MM-dd-yyyy'),
        h.InvoiceNumber,
        f.referenceNumber,
        f.remarks,
        g.transactionName,
        FORMAT(CAST(h.InvoiceAmount AS DECIMAL(10,2)), 'N2'),
        FORMAT(CAST(e.total_payment AS DECIMAL(10,2)), 'N2'),
        FORMAT(CAST(e.total_balance AS DECIMAL(10,2)), 'N2'),
        d.currency,
        FORMAT(h.dateCreated, 'MM-dd-yyyy'),
        FORMAT(e.date_created, 'MM-dd-yyyy HH:mm:ss'),
        FORMAT(f.dateCreated, 'MM-dd-yyyy HH:mm:ss'),
        h.userCreated,
        f.update_Initial_deduction
        ORDER BY 
        formattedDateCreatedInitialPayment ASC, formattedDateCreatedOtherPayment ASC";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchdailyTotalInvoice($compCode, $dateFrom)
    {

        $whereComp_A = "";
        $whereComp_B = "";

        if($compCode != '' AND $compCode != null)
        {
            $whereComp_A = "AND a.compCode = '$compCode'";
            $whereComp_B = "AND g.compCode = '$compCode'";
        }

        $query = "SELECT a.dateCreated,
        d.company_name,
        b.vendorName,
        a.InvoiceNumber,
        c.currency,
        FORMAT(CAST(a.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS InvoiceAmount,
        FORMAT(CAST(a.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
        FORMAT(CAST(a.updated_adjustment_deduction_amt AS DECIMAL(10,2)), 'N2') AS updated_adjustment_deduction_amt,
        FORMAT(CAST(a.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
        a.rfp,
        a.userCreated
        FROM tblTelegraphicTransferInvoice AS a
        
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblCurrency AS c ON a.paymentTermCode = c.currency_id
        LEFT JOIN tblCompany AS d ON a.compCode = d.company_id
        WHERE
        ((a.dateCreated ='$dateFrom' $whereComp_A))
      
        UNION ALL
    
        SELECT g.dateCreated,
        d.company_name,
        b.vendorName,
        g.InvoiceNumber,
        c.currency,
        FORMAT(CAST(g.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS InvoiceAmount,
        FORMAT(CAST(g.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
        FORMAT(CAST(g.updated_adjustment_deduction_amt AS DECIMAL(10,2)), 'N2') AS updated_adjustment_deduction_amt,
        FORMAT(CAST(g.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
        g.rfp,
        g.userCreated
        FROM tblTelegraphicTransferInvoice_his AS g
        
        LEFT JOIN tblVendor AS b ON g.vendorCode = b.vendorCode
        LEFT JOIN tblCurrency AS c ON g.paymentTermCode = c.currency_id
        LEFT JOIN tblCompany AS d ON g.compCode = d.company_id
        WHERE
        ((g.dateCreated ='$dateFrom' $whereComp_B))
        ";

        $result = $this->db->query($query);

        return $result->result_array();
                    
    }

    function fetchAllDailyReport($dateFrom)
    {
        $query = "WITH PaymentSumPerInvoice AS (
            SELECT
            a.InvoiceNumber,
            SUM(CAST(e.total_payment AS DECIMAL(10, 2))) AS total_payment_per_po
            FROM
            tblTelegraphicTransferInvoice AS a
            LEFT JOIN tblPayment_invoices AS e ON a.vendorCode = e.Vendor AND a.InvoiceNumber = e.InvoiceNumber
            WHERE 
            a.dateCreated = '$dateFrom'
            GROUP BY
            a.InvoiceNumber
            ),
    
            PaymentSumPerInvoiceHIS AS (
            SELECT
            h.InvoiceNumber,
            SUM(CAST(e.total_payment AS DECIMAL(10, 2))) AS total_payment_per_po
            FROM
            tblTelegraphicTransferInvoice_his AS h
            LEFT JOIN tblPayment_invoices AS e ON h.vendorCode = e.Vendor AND h.InvoiceNumber = e.InvoiceNumber
            WHERE
            h.dateCreated = '$dateFrom'
            GROUP BY
            h.InvoiceNumber
            )
    
            SELECT DISTINCT
            formattedDateCreated,
            vendorName,
            company_name,
            InvoiceNumber,
            formatedInvoiceAmount AS InvoiceAmount,
            formattedtotal_payment,
            subtractedAmount,
            currency,
            userCreated
            FROM (
            SELECT
            formattedDateCreated,
            vendorName,
            company_name,
            InvoiceNumber,
            formatedInvoiceAmount,
            formattedtotal_payment,
            subtractedAmount,
            currency,
            userCreated
            FROM (
            SELECT
            FORMAT(a.dateCreated, 'MM-dd-yyyy') AS formattedDateCreated,
            c.vendorName,
            b.company_name,
            a.InvoiceNumber,
            FORMAT(SUM(CAST(a.InvoiceAmount AS DECIMAL(10, 2))), 'N2') AS formatedInvoiceAmount,
            FORMAT(SUM(total_payment_per_po), 'N2') AS formattedtotal_payment,
            FORMAT(SUM(CAST(a.InvoiceAmount AS DECIMAL(10, 2)) - COALESCE(total_payment_per_po, 0)), 'N2') AS subtractedAmount,
            d.currency,
            a.userCreated
            FROM tblTelegraphicTransferInvoice AS a
            LEFT JOIN tblCompany AS b ON a.compCode = b.company_id
            LEFT JOIN tblVendor AS c ON a.vendorCode = c.vendorCode
            LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
            LEFT JOIN PaymentSumPerInvoice AS e ON a.InvoiceNumber = e.InvoiceNumber
            WHERE
            a.dateCreated = '$dateFrom'
            GROUP BY
            FORMAT(a.dateCreated, 'MM-dd-yyyy'),
            c.vendorName,
            b.company_name,
            a.InvoiceNumber,
            d.currency,
            a.userCreated
    
            UNION ALL
    
            SELECT
            FORMAT(i.dateCreated, 'MM-dd-yyyy') AS formattedDateCreated,
            c.vendorName,
            b.company_name,
            i.InvoiceNumber,
            FORMAT(SUM(CAST(i.InvoiceAmount AS DECIMAL(10, 2))), 'N2') AS formatedInvoiceAmount,
            FORMAT(SUM(total_payment_per_po), 'N2') AS formattedtotal_payment,
            FORMAT(SUM(CAST(i.InvoiceAmount AS DECIMAL(10, 2)) - COALESCE(total_payment_per_po, 0)), 'N2') AS subtractedAmount,
            d.currency,
            i.userCreated
            FROM tblTelegraphicTransferInvoice_his AS i
            LEFT JOIN tblCompany AS b ON i.compCode = b.company_id
            LEFT JOIN tblVendor AS c ON i.vendorCode = c.vendorCode
            LEFT JOIN tblCurrency AS d ON i.paymentTermCode = d.currency_id
            LEFT JOIN PaymentSumPerInvoiceHIS AS e ON i.InvoiceNumber = e.InvoiceNumber
            WHERE
            i.dateCreated = '$dateFrom'
            GROUP BY
            FORMAT(i.dateCreated, 'MM-dd-yyyy'),
            c.vendorName,
            b.company_name,
            i.InvoiceNumber,
            d.currency,
            i.userCreated
            ) AS Subquery
            ) AS CombinedResult";

            $result = $this->db->query($query);
            
            // var_dump($result);
            // exit();

            return $result->result_array();

    }

    function generatePdfAllInvoices($compCode, $currency, $dateFrom)
    {
        $query ="WITH PaymentSumPerPO AS (
            SELECT
            a.InvoiceNumber,
            SUM(CAST(e.updated_Initial_payment AS DECIMAL(10, 2))) AS total_payment_per_invoice
            FROM
            tblTelegraphicTransferInvoice AS a
            LEFT JOIN tblPayment_invoices AS e ON a.vendorCode = e.Vendor AND a.InvoiceNumber = e.InvoiceNumber
            WHERE
            a.compCode = '$compCode' AND a.paymentTermCode = '$currency' AND a.dateCreated = '$dateFrom'
            GROUP BY
            a.InvoiceNumber
            ),
    
            PaymentSumPerPOHIS AS (
            SELECT
            h.InvoiceNumber,
            SUM(CAST(e.updated_Initial_payment AS DECIMAL(10, 2))) AS total_payment_per_invoice
            FROM
            tblTelegraphicTransferInvoice_his AS h
            LEFT JOIN tblPayment_invoices AS e ON h.vendorCode = e.Vendor AND h.InvoiceNumber = e.InvoiceNumber
            WHERE
            h.compCode = '$compCode' AND h.paymentTermCode = '$currency'  AND h.dateCreated = '$dateFrom'
            GROUP BY
            h.InvoiceNumber
            )
    
            SELECT DISTINCT				
            formattedDateCreated,
            vendorName,
            InvoiceNumber,
            company_name,
            commercialInvoice,
            proformaInvoice,
            currency,
            formatedInvoiceAmount AS InvoiceAmount,
            formattedtotal_payment,
            subtractedAmount,
            formatted_updated_balance,
            formattedupdated_paid_amount,
            formattedupdated_adjustment_deduction_amt,
            userCreated
                    
            FROM (
            SELECT
            formattedDateCreated,
            vendorName,
            InvoiceNumber,
            company_name,
            commercialInvoice,
            proformaInvoice,
            currency,
            formatedInvoiceAmount,
            formattedtotal_payment,
            subtractedAmount,
            formatted_updated_balance,
            formattedupdated_paid_amount,
            formattedupdated_adjustment_deduction_amt,
            userCreated
                    
            FROM (
            SELECT
            FORMAT(a.dateCreated, 'MM-dd-yyyy') AS formattedDateCreated,
            c.vendorName,	
            a.InvoiceNumber,
            b.company_name,
            commercialInvoice,
            proformaInvoice,
            FORMAT(CAST(a.updated_balanced AS DECIMAL(10, 2)), 'N2') AS formatted_updated_balance,
            FORMAT(CAST(a.updated_paid_amount AS DECIMAL(10, 2)), 'N2') AS formattedupdated_paid_amount,
            FORMAT(CAST(a.updated_adjustment_deduction_amt AS DECIMAL(10, 2)), 'N2') AS formattedupdated_adjustment_deduction_amt,
            d.currency,
            FORMAT(SUM(CAST(a.InvoiceAmount AS DECIMAL(10, 2))), 'N2') AS formatedInvoiceAmount,
            FORMAT(SUM(total_payment_per_invoice), 'N2') AS formattedtotal_payment,
            FORMAT(SUM(CAST(a.InvoiceAmount AS DECIMAL(10, 2)) - COALESCE(total_payment_per_invoice, 0)), 'N2') AS subtractedAmount,
    
            a.userCreated
            FROM tblTelegraphicTransferInvoice AS a
            LEFT JOIN tblCompany AS b ON a.compCode = b.company_id
            LEFT JOIN tblVendor AS c ON a.vendorCode = c.vendorCode
            LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
            LEFT JOIN PaymentSumPerPO AS e ON a.InvoiceNumber = e.InvoiceNumber
            WHERE a.compCode = '$compCode' AND a.paymentTermCode = '$currency' AND a.dateCreated = '$dateFrom'
            GROUP BY
            FORMAT(a.dateCreated, 'MM-dd-yyyy'),
            c.vendorName,
            a.InvoiceNumber,
            b.company_name,
            a.commercialInvoice,
            a.proformaInvoice,
            FORMAT(CAST(a.updated_balanced AS DECIMAL(10, 2)), 'N2'),
            FORMAT(CAST(a.updated_paid_amount AS DECIMAL(10, 2)), 'N2'),
            FORMAT(CAST(a.updated_adjustment_deduction_amt AS DECIMAL(10, 2)), 'N2'),
            d.currency,
            a.userCreated
    
            UNION ALL
    
            SELECT
            FORMAT(i.dateCreated, 'MM-dd-yyyy') AS formattedDateCreated,
            c.vendorName,
            i.InvoiceNumber,
            b.company_name, 
            i.commercialInvoice,
            i.proformaInvoice,
            FORMAT(CAST(i.updated_balanced AS DECIMAL(10, 2)), 'N2') AS formatted_updated_balance,
            FORMAT(CAST(i.updated_paid_amount AS DECIMAL(10, 2)), 'N2') AS formattedupdated_paid_amount,
            FORMAT(CAST(i.updated_adjustment_deduction_amt AS DECIMAL(10, 2)), 'N2') AS formattedupdated_adjustment_deduction_amt,
            d.currency,
            FORMAT(SUM(CAST(i.InvoiceAmount AS DECIMAL(10, 2))), 'N2') AS formatedInvoiceAmount,
            FORMAT(SUM(total_payment_per_invoice), 'N2') AS formattedtotal_payment,
            FORMAT(SUM(CAST(i.InvoiceAmount AS DECIMAL(10, 2)) - COALESCE(total_payment_per_invoice, 0)), 'N2') AS subtractedAmount,
    
            i.userCreated
            FROM tblTelegraphicTransferInvoice_his AS i
            LEFT JOIN tblCompany AS b ON i.compCode = b.company_id
            LEFT JOIN tblVendor AS c ON i.vendorCode = c.vendorCode
            LEFT JOIN tblCurrency AS d ON i.paymentTermCode = d.currency_id
            LEFT JOIN PaymentSumPerPOHIS AS e ON i.InvoiceNumber = e.InvoiceNumber
            WHERE i.compCode = '$compCode' AND i.paymentTermCode = '$currency'  AND i.dateCreated = '$dateFrom'
            GROUP BY
            FORMAT(i.dateCreated, 'MM-dd-yyyy'),
            c.vendorName,
            i.InvoiceNumber,				
            b.company_name,
            i.commercialInvoice,
            i.proformaInvoice,
            FORMAT(CAST(i.updated_balanced AS DECIMAL(10, 2)), 'N2'),
            FORMAT(CAST(i.updated_paid_amount AS DECIMAL(10, 2)), 'N2'),
            FORMAT(CAST(i.updated_adjustment_deduction_amt AS DECIMAL(10, 2)), 'N2'),
            d.currency,
            i.userCreated
                    
            ) AS Subquery
            ) AS CombinedResult";

      $result = $this->db->query($query);

      return $result->result_array();
    }

    function sumTotalPaidInvoices($compCode, $currency, $dateFrom)
    {
        // $query = "SELECT

        //             FORMAT(SUM(total_payment), 'N') AS total_payment_sum
                        
        //             FROM

        //             (SELECT
                        
        //                 SUM(CASE WHEN (a.compCode = '$compCode' AND a.paymentTermCode = '$currency') OR (a.compCode = '$compCode' OR a.paymentTermCode = '$currency') AND a.dateCreated BETWEEN '$dateFrom' AND '$dateTo' THEN CAST(POAmount AS DECIMAL(10, 2)) ELSE 0 END) AS total_payment
                                
        //                         FROM
                                
        //                                 tblTelegraphicTransfer AS a
                                        
        //                         WHERE
                                
        //                         (a.compCode = '$compCode' AND a.paymentTermCode = '$currency') OR (a.compCode = '$compCode' OR a.paymentTermCode = '$currency') AND a.dateCreated BETWEEN '$dateFrom' AND '$dateTo'
                                
        //                         UNION ALL
                                
        //                         SELECT
        //                                 SUM(CASE WHEN h.compCode = '$compCode' AND h.paymentTermCode = '$currency') OR (h.compCode = '$compCode' OR h.paymentTermCode = '$currency') AND h.dateCreated BETWEEN '$dateFrom' AND '$dateTo' THEN CAST(POAmount AS DECIMAL(10, 2)) ELSE 0 END) AS total_payment
                                        
        //                         FROM
                                
        //                                 tblTelegraphicTransferHis AS h
                                        
        //                         WHERE
                        
        //                         (h.compCode = '$compCode' AND h.paymentTermCode = '$currency') OR (h.compCode = '$compCode' OR h.paymentTermCode = '$currency') AND h.dateCreated BETWEEN '$dateFrom' AND '$dateTo'
                                
        //             ) AS combined_results";


        $query1 = "SELECT
        FORMAT(SUM(total_payment), 'N') AS total_payment_sum,
        FORMAT(SUM(updatedBalanced), 'N') AS totalBalance,
        FORMAT(SUM(updatedPaidAmount), 'N') AS totalPaidAmount,
        currency,
        currency_sign
        FROM
        (
            SELECT
            a.compCode,
            a.paymentTermCode,
            CAST(InvoiceAmount AS DECIMAL(10, 2)) AS total_payment,
            CAST(updated_balanced AS DECIMAL(10, 2)) AS updatedBalanced,
            CAST(updated_paid_amount AS DECIMAL(10, 2)) AS updatedPaidAmount,
            b.currency,
            b.currency_sign
            FROM
            tblTelegraphicTransferInvoice AS a
            LEFT JOIN tblCurrency AS b ON a.paymentTermCode = b.currency_id
            WHERE
                (a.compCode = '$compCode' AND a.paymentTermCode = '$currency') AND a.dateCreated = '$dateFrom'

            UNION ALL

            SELECT
            h.compCode,
            h.paymentTermCode,
            CAST(InvoiceAmount AS DECIMAL(10, 2)) AS total_payment,
            CAST(updated_balanced AS DECIMAL(10, 2)) AS updatedBalanced,
            CAST(updated_paid_amount AS DECIMAL(10, 2)) AS updatedPaidAmount,
            b.currency,
            b.currency_sign
            FROM
                tblTelegraphicTransferInvoice_his AS h
                LEFT JOIN tblCurrency AS b ON h.paymentTermCode = b.currency_id
            WHERE
                (h.compCode = '$compCode' AND h.paymentTermCode = '$currency') AND h.dateCreated = '$dateFrom'
            ) AS combined_results
            GROUP BY
            currency,
            currency_sign";

            $result = $this->db->query($query1);

            return $result->result_array();
    }

    function getHeader($compCode, $currency)
    {

        $qry = "SELECT 
        b.vendorName,
        c.accountNumber,
        d.currency,
        f.paymentName,
        a.InvoiceNumber,
        a.InvoiceDate, 
        FORMAT(CAST(a.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS InvoiceAmount,
        a.proformaInvoice,
        a.commercialInvoice,
        e.company_name,
        
        FORMAT(CAST(a.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
        FORMAT(CAST(a.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
   
        a.rfp
        
        FROM tblTelegraphicTransferInvoice AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblCompany AS e ON a.compCode = e.company_id
        LEFT JOIN tblPaymentTerms AS f ON a.accountCurrency = f.paymentTermCode
        
        WHERE a.compCode = '$compCode' AND a.paymentTermCode = '$currency'
        
        UNION
        
        SELECT 
        
        b.vendorName, 
        c.accountNumber,
        d.currency,
        f.paymentName,
        x.InvoiceNumber,
        x.InvoiceDate,
        FORMAT(CAST(x.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS InvoiceAmount,
        x.proformaInvoice,
        x.commercialInvoice,
        e.company_name,
        
        FORMAT(CAST(x.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
        FORMAT(CAST(x.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
        x.rfp
        
        FROM tblTelegraphicTransferInvoice_his AS x
        LEFT JOIN tblVendor AS b ON x.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON x.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON x.paymentTermCode = d.currency_id
        LEFT JOIN tblCompany AS e ON x.compCode = e.company_id
        LEFT JOIN tblPaymentTerms AS f ON x.accountCurrency = f.paymentTermCode
        
        WHERE x.compCode = '$compCode' AND x.paymentTermCode = '$currency'";

        $result = $this->db->query($qry);

        return $result->result_array();
    }

    function getOtherInvoicePayment($compCode, $currency, $invoice_number)
    {
        $qry = "SELECT 
                -- a.otherVendorCode,
                b.otherTransacTypeName,
                -- a.otherInvoiceNumber,
                d.transact_name,
                FORMAT(CAST(a.transAmt AS DECIMAL(10,2)), 'N2') AS transAmt,
                -- a.Remarks,
                a.otherInvoiceDate,
                FORMAT(CAST(a.otherInvoiceAmount AS DECIMAL(10,2)), 'N2') AS otherInvoiceAmount,
                FORMAT(CAST(a.otherTotalDeduc AS DECIMAL(10,2)), 'N2') AS otherTotalDeduc,
                a.referenceNumber, 
                FORMAT(a.dateCreated, 'yyyy-MM-dd') AS dateCreated,
                a.rfp,

                y.InvoiceNumber,
                x.InvoiceNumber

                FROM tblOtherTransactionInvoice AS a
                LEFT JOIN tblOtherTransactionType AS b ON a.otherTransTypeCode = b.otherTransacTypeCode
                LEFT JOIN transact_2 AS d ON a.transactionCode = d.id
                
                LEFT JOIN tblTelegraphicTransferInvoice AS y ON a.otherVendorCode = y.vendorCode AND a.otherInvoiceNumber = y.InvoiceNumber
                LEFT JOIN tblTelegraphicTransferInvoice_his AS x ON a.otherVendorCode = x.vendorCode AND a.otherInvoiceNumber = x.InvoiceNumber
                WHERE
                ((y.compCode = '$compCode' AND y.paymentTermCode = '$currency') OR (x.compCode = '$compCode' AND x.paymentTermCode = '$currency')) 
                AND
                (y.InvoiceNumber = '$invoice_number' OR x.InvoiceNumber = '$invoice_number')";

        
        $result = $this->db->query($qry);

        return $result->result_array();
    }

    function getNonInvoicePayment($compCode, $currency, $invoice_number)
    {
        $qry = "SELECT 
                a.invoice_number,
                a.vendor,
                FORMAT(a.date, 'yyyy-MM-dd') AS date,
                b.otherTransacTypeName,
                c.transactionName,
                a.reference_no,
                FORMAT(CAST(a.amount AS DECIMAL(10,2)), 'N2') AS amount,
                a.remarks,
                a.rfp,
				
				y.InvoiceNumber,
				y.vendorCode,
				
				(x.InvoiceNumber) AS InvoiceNumberHis,
				(x.vendorCode) AS vendorCodeHis
				
                FROM tblOtherTransactNoneInvoice AS a
                LEFT JOIN tblOtherTransactionType AS b ON a.transact_type = b.otherTransacTypeCode
                LEFT JOIN tblTransactionType AS c ON a.[transaction] = c.transactionCode
				
				LEFT JOIN tblTelegraphicTransferInvoice AS y ON a.invoice_number = y.InvoiceNumber AND a.vendor = y.vendorCode
				LEFT JOIN tblTelegraphicTransferInvoice_his AS x ON a.invoice_number = x.InvoiceNumber AND a.vendor = x.vendorCode
				
				WHERE ((y.compCode = '$compCode' AND y.paymentTermCode = '$currency') OR (x.compCode = '$compCode' AND x.paymentTermCode = '$currency')) 
				
				AND 
				
				(y.InvoiceNumber = '$invoice_number' OR x.InvoiceNumber = '$invoice_number')";

        $result = $this->db->query($qry);

        return $result->result_array();
    }

    function generateInvoicePayment($compCode, $vendor, $InvoiceNum)
    {
        $whereComp_A = "";
       
        if($compCode != '' OR $compCode != null)
        {
            $whereComp_A = "AND (x.compCode = '$compCode' OR y.compCode = '$compCode') ";
      
        }

        else if($vendor != '' OR $vendor != null)
        {
            $whereComp_A = "AND (x.vendorCode = '$vendor' OR y.vendorCode = '$vendor')";
        }


    


        $qry = "SELECT 
        a.Vendor, 
        a.InvoiceNumber,
        FORMAT(a.InvoiceDate, 'yyyy-MM-dd') AS InvoiceDate,
        a.InvoiceAmount, 
        FORMAT(CAST(a.total_payment AS DECIMAL(10,2)), 'N2') AS total_payment,
        (a.total_payment) AS origTotalPayment,
        a.amount,
        FORMAT(CAST(a.total_balance AS DECIMAL(10,2)), 'N2') AS total_balance,
        b.paymentName,
        FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created,
        a.payment_type,
        a.remarks,
        a.rfp
       
        FROM tblPayment_invoices AS a
        LEFT JOIN tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
        LEFT JOIN tblTelegraphicTransferInvoice AS x ON a.Vendor = x.vendorCode AND a.InvoiceNumber = x.InvoiceNumber
        LEFT JOIN tblTelegraphicTransferInvoice_his AS y ON a.Vendor = y.vendorCode AND a.InvoiceNumber = y.InvoiceNumber
        WHERE
        
        (x.InvoiceNumber = '$InvoiceNum' OR y.InvoiceNumber = '$InvoiceNum') $whereComp_A";

        // echo $qry;
        // exit();

        $res = $this->db->query($qry);

        return $res->result_array();
    }

    function generateInvoicePaymentByRFP($InvoiceNumber, $rfp)
    {
        $whereComp_A = "";
       
        if($rfp != '' AND $rfp != null)
        {
            $whereComp_A = "AND (x.InvoiceNumber='$InvoiceNumber' OR y.InvoiceNumber = '$InvoiceNumber')";
        }

        $qry = "SELECT 
        a.Vendor, 
        a.InvoiceNumber,
        FORMAT(a.InvoiceDate, 'yyyy-MM-dd') AS InvoiceDate,
        a.InvoiceAmount, 
        FORMAT(CAST(a.total_payment AS DECIMAL(10,2)), 'N2') AS total_payment,
        (a.total_payment) AS origTotalPayment,
        a.amount,
        FORMAT(CAST(a.total_balance AS DECIMAL(10,2)), 'N2') AS total_balance,
        b.paymentName,
        FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created,
        a.payment_type,
        a.remarks,
        a.rfp
       
        FROM tblPayment_invoices AS a
        LEFT JOIN tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
        LEFT JOIN tblTelegraphicTransferInvoice AS x ON a.Vendor = x.vendorCode AND a.InvoiceNumber = x.InvoiceNumber
        LEFT JOIN tblTelegraphicTransferInvoice_his AS y ON a.Vendor = y.vendorCode AND a.InvoiceNumber = y.InvoiceNumber
        WHERE
    
        (a.rfp = '$rfp') $whereComp_A";

        // echo $qry;
        // exit();

        $res = $this->db->query($qry);

        return $res->result_array();
    }

    function generateOtherPaymentInvoice($compCode, $reference, $vendorCode, $InvoiceNumber)
    {

        $whereComp_A = "";
       
        if($compCode != '' OR $compCode != null )
        {
            $whereComp_A = "AND (x.compCode = '$compCode' OR y.compCode = '$compCode') ";
      
        }

        else if($vendorCode != '' OR $vendorCode != null)
        {
            $whereComp_A = "AND (x.vendorCode = '$vendorCode' OR y.vendorCode = '$vendorCode')";
        }

        //not empty the reference
        else if($reference != '' OR $reference != null)
        {
            $whereComp_A = " AND a.referenceNumber = '$reference'";
        }

        $qry = "SELECT
        a.otherTransTypeCode,
        b.otherTransacTypeName, 
        a.otherInvoiceNumber,
        d.transact_name,
        a.Remarks,
        a.referenceNumber,
        FORMAT(a.dateCreated, 'MM-dd-yyyy') AS dateCreated,
        FORMAT(CAST(a.update_Initial_deduction AS DECIMAL(10,2)), 'N2') AS update_Initial_deduction,
        FORMAT(CAST(a.otherTotalDeduc AS DECIMAL(10,2)), 'N2') AS otherTotalDeduc,
        (a.otherTotalDeduc) AS origTotalDeduc,
        a.remarks,
        a.rfp,
        a.amount,
        a.total
        
        FROM tblOtherTransactionInvoice AS a
        LEFT JOIN tblOtherTransactionType AS b ON a.otherTransTypeCode = b.otherTransacTypeCode
        LEFT JOIN tblVendor AS c ON a.otherVendorCode = c.vendorCode
        LEFT JOIN transact_2 AS d ON a.transactionCode = d.id
        
        LEFT JOIN tblTelegraphicTransferInvoice AS x ON a.otherVendorCode = x.vendorCode AND a.otherInvoiceNumber = x.InvoiceNumber
        LEFT JOIN tblTelegraphicTransferInvoice_his AS y ON a.otherVendorCode = y.vendorCode AND a.otherInvoiceNumber = y.InvoiceNumber
        
        WHERE
        
        (x.InvoiceNumber = '$InvoiceNumber' OR y.InvoiceNumber = '$InvoiceNumber') $whereComp_A";

        // echo $qry;
        // exit();

        $res = $this->db->query($qry);

        return $res->result_array();
    }

    function generateOtherPaymentInvoiceRFP($rfp)
    {
        $whereComp_A = "";
       
        // if($rfp != '' AND $rfp != null)
        // {
        //     $whereComp_A = "AND (x.InvoiceNumber='$InvoiceNumber' OR y.InvoiceNumber = '$InvoiceNumber')";
      
        // }

        $qry = "SELECT
        a.otherTransTypeCode,
        b.otherTransacTypeName, 
        a.otherInvoiceNumber,
        d.transact_name,
        a.Remarks,
        a.referenceNumber,
        FORMAT(a.dateCreated, 'MM-dd-yyyy') AS dateCreated,
        FORMAT(CAST(a.update_Initial_deduction AS DECIMAL(10,2)), 'N2') AS update_Initial_deduction,
        FORMAT(CAST(a.otherTotalDeduc AS DECIMAL(10,2)), 'N2') AS otherTotalDeduc,
        (a.otherTotalDeduc) AS origTotalDeduc,
        a.remarks,
        a.rfp,
        a.amount,
        a.total
        
        FROM tblOtherTransactionInvoice AS a
        LEFT JOIN tblOtherTransactionType AS b ON a.otherTransTypeCode = b.otherTransacTypeCode
        LEFT JOIN tblVendor AS c ON a.otherVendorCode = c.vendorCode
        LEFT JOIN transact_2 AS d ON a.transactionCode = d.id
        
        LEFT JOIN tblTelegraphicTransferInvoice AS x ON a.otherVendorCode = x.vendorCode AND a.otherInvoiceNumber = x.InvoiceNumber
        LEFT JOIN tblTelegraphicTransferInvoice_his AS y ON a.otherVendorCode = y.vendorCode AND a.otherInvoiceNumber = y.InvoiceNumber
        
        WHERE
        
        (a.rfp = '$rfp')";

        // echo $qry;
        // exit();

        $res = $this->db->query($qry);

        return $res->result_array();
    }

    function generateNonInvoiceRelatedPayment($compCode, $reference, $vendorCode, $invoice_number)
    {
        $whereComp_A = "";
       
        if($compCode != '' OR $compCode != null)
        {
            $whereComp_A = "AND (x.compCode = '$compCode' OR y.compCode = '$compCode')";
      
        }

        else if($vendorCode != '' OR $vendorCode != null)
        {
            $whereComp_A = " AND (x.vendorCode = '$vendorCode' OR y.vendorCode = '$vendorCode')";
        }

        else if($reference != '' OR $reference != null)
        {
            $whereComp_A = "AND a.reference_no = '$reference'";
        }


        $qry = "SELECT 
                a.invoice_number,
                a.vendor,
                a.date,
                a.transact_type,
                b.otherTransacTypeName,
                c.transactionName,
                a.reference_no,
                a.amount,
                a.amount2,
                a.total,
                a.remarks,
                a.rfp,
                FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created
                FROM tblOtherTransactNoneInvoice AS a
                LEFT JOIN tblOtherTransactionType AS b ON a.transact_type = b.otherTransacTypeCode
                LEFT JOIN tblTransactionType AS c ON a.[transaction] = c.transactionCode
                
                LEFT JOIN tblTelegraphicTransferInvoice AS x ON a.vendor = x.vendorCode AND a.invoice_number = x.InvoiceNumber
                LEFT JOIN tblTelegraphicTransferInvoice_his AS y ON a.vendor = y.vendorCode AND a.invoice_number = y.InvoiceNumber
                WHERE
              
                (x.InvoiceNumber = '$invoice_number' OR y.InvoiceNumber = '$invoice_number') $whereComp_A";

        // echo $qry;
        // exit();

        $res = $this->db->query($qry);

        

        return $res->result_array();
    }

    function generateNonInvoiceRelatedPaymentRFP($InvoiceNumber, $rfp)
    {
        $whereComp_A = "";
       
        if($rfp != '' AND $rfp != null)
        {
            $whereComp_A = "AND (x.InvoiceNumber='$InvoiceNumber' OR y.InvoiceNumber = '$InvoiceNumber')";
      
        }


        $qry = "SELECT 
                a.invoice_number,
                a.vendor,
                a.date,
                a.transact_type,
                b.otherTransacTypeName,
                c.transactionName,
                a.reference_no,
                a.amount,
                a.amount2,
                a.total,
                a.remarks,
                a.rfp,
                FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created
                FROM tblOtherTransactNoneInvoice AS a
                LEFT JOIN tblOtherTransactionType AS b ON a.transact_type = b.otherTransacTypeCode
                LEFT JOIN tblTransactionType AS c ON a.[transaction] = c.transactionCode
                
                LEFT JOIN tblTelegraphicTransferInvoice AS x ON a.vendor = x.vendorCode AND a.invoice_number = x.InvoiceNumber
                LEFT JOIN tblTelegraphicTransferInvoice_his AS y ON a.vendor = y.vendorCode AND a.invoice_number = y.InvoiceNumber
                WHERE
              
                (a.rfp = '$rfp') $whereComp_A";

        // echo $qry;
        // exit();

        $res = $this->db->query($qry);

        

        return $res->result_array();
    }

    function generateInvoicePaymentPdf($company, $currency, $InvoiceNum)
    {
        $qry = "SELECT 
        a.Vendor, 
        a.InvoiceNumber,
        FORMAT(a.InvoiceDate, 'yyyy-MM-dd') AS InvoiceDate,
        a.InvoiceAmount, 
        FORMAT(CAST(a.total_payment AS DECIMAL(10,2)), 'N2') AS total_payment,
        a.amount,
        FORMAT(CAST(a.total_balance AS DECIMAL(10,2)), 'N2') AS total_balance,
        b.paymentName,
        a.date_created,
        a.payment_type,
        a.rfp
       
        FROM tblPayment_invoices AS a
        LEFT JOIN tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
        LEFT JOIN tblTelegraphicTransferInvoice AS x ON a.Vendor = x.vendorCode AND a.InvoiceNumber = x.InvoiceNumber
        LEFT JOIN tblTelegraphicTransferInvoice_his AS y ON a.Vendor = y.vendorCode AND a.InvoiceNumber = y.InvoiceNumber
        WHERE
        ((x.compCode = '$company' OR  x.paymentTermCode = '$currency') OR (y.compCode = '$company' OR y.paymentTermCode = '$currency'))
        
        AND
        
        (x.InvoiceNumber = '$InvoiceNum' OR y.InvoiceNumber = '$InvoiceNum')";

        $res = $this->db->query($qry);

        return $res->result_array();
    }

    function TotalAmt($company, $date)
    { 

        $whereComp = "";
   
        if($company != '' AND $company != null)
        {
            $whereComp = "AND compCode = '$company'";
            
        }

        $query ="SELECT 
        FORMAT( CAST ( SUM (totalInvoiceAmt) AS DECIMAL(10,2)), 'N2') AS grandTotalInvoiceAmt,
        FORMAT( CAST ( SUM ( totalPaidAmt ) AS DECIMAL ( 10, 2 )), 'N2' ) AS grandPaidAmt,
	    FORMAT( CAST ( SUM ( totalBalanced ) AS DECIMAL ( 10, 2 )), 'N2' ) AS grandTotalBalanced,
        FORMAT( CAST ( SUM ( totalDeductAmt ) AS DECIMAL ( 10, 2 )), 'N2' ) AS grandTotalDeductAmt

        FROM (
            SELECT 
            SUM (CAST(InvoiceAmount AS DECIMAL(10,2))) AS totalInvoiceAmt,
            SUM (CAST(updated_paid_amount AS DECIMAL(10,2))) AS totalPaidAmt,
            SUM (CAST(updated_balanced AS DECIMAL(10,2))) AS totalBalanced,
            SUM (CAST(updated_adjustment_deduction_amt AS DECIMAL(10,2))) AS totalDeductAmt
                        
            FROM tblTelegraphicTransferInvoice
            WHERE (dateCreated = '$date' $whereComp)
                
            GROUP BY InvoiceNumber
        
            UNION ALL
        
            SELECT 
            SUM (CAST(InvoiceAmount AS DECIMAL(10,2))) AS totalInvoiceAmt,
            SUM (CAST(updated_paid_amount AS DECIMAL(10,2))) AS totalPaidAmt,
            SUM (CAST(updated_balanced AS DECIMAL(10,2))) AS totalBalanced,
            SUM (CAST(updated_adjustment_deduction_amt AS DECIMAL(10,2))) AS totalDeductAmt
                        
            FROM tblTelegraphicTransferInvoice_his
            WHERE (dateCreated = '$date' $whereComp)
                
            GROUP BY InvoiceNumber
        )

        AS subquery";

        // echo $query;
        // exit();

        $res = $this->db->query($query);

        return $res->result_array();

    }

    function getRFP($rfp)
    {
        $query ="SELECT rfp FROM tblTelegraphicTransferInvoice
        WHERE rfp LIKE '%$rfp%'
        
        UNION ALL 
        
        SELECT rfp FROM tblTelegraphicTransferInvoice_his
        WHERE rfp LIKE '%$rfp%'";


        $result = $this->db->query($query);

        return $result->result_array();
    }

    function generateReportByRFPInvoice($rfp, $dateFrom, $dateTo)
    {

        $whereComp_A = "";
        $whereComp_B = "";

        //if compcode not equal to '' and not equal to null
        if($rfp != '' AND $rfp != null)
        {
            $whereComp_A = "AND a.rfp = '$rfp'";
            $whereComp_B = "AND x.rfp = '$rfp'";
        }

         $query = "SELECT 
            b.vendorName,
            b.vendorAddress1,
            c.accountNumber,
            d.currency,
            f.paymentName,
            a.InvoiceNumber,
            FORMAT(a.InvoiceDate, 'MM-dd-yyyy') AS InvoiceDate,  
            FORMAT(CAST(a.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS InvoiceAmount,
            a.proformaInvoice,
            a.commercialInvoice,
            e.company_name,
            FORMAT(CAST(a.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
            FORMAT(CAST(a.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
            a.remarks,
            a.rfp,
            FORMAT(a.dateCreated, 'yyyy-MM-dd') AS dateCreated,
            l.bankName,
            l.bankAddress2,
            c.swiftCode,
            c.ibanNo,
            c.abaNo
            
            FROM tblTelegraphicTransferInvoice AS a
            LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
            LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
            LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
            LEFT JOIN tblCompany AS e ON a.compCode = e.company_id
            LEFT JOIN tblPaymentTerms AS f ON a.accountCurrency = f.paymentTermCode
            LEFT JOIN tblBankInformation as l ON c.bankCode = l.bankCode 
            
            WHERE 
        
            a.dateCreated BETWEEN '$dateFrom' AND '$dateTo' $whereComp_A
            
            UNION
            
            SELECT 
            
            b.vendorName, 
            b.vendorAddress1,
            c.accountNumber,
            d.currency,
            f.paymentName,
            x.InvoiceNumber,
            FORMAT(x.InvoiceDate, 'MM-dd-yyyy') AS InvoiceDate,  
            FORMAT(CAST(x.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS InvoiceAmount,
            x.proformaInvoice,
            x.commercialInvoice,
            e.company_name,
            FORMAT(CAST(x.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
            FORMAT(CAST(x.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
            x.remarks,
            x.rfp,
            FORMAT(x.dateCreated, 'yyyy-MM-dd') AS dateCreated,
            l.bankName,
            l.bankAddress2,
            c.swiftCode,
            c.ibanNo,
            c.abaNo
            
            FROM tblTelegraphicTransferInvoice_his AS x
            LEFT JOIN tblVendor AS b ON x.vendorCode = b.vendorCode
            LEFT JOIN tblAccounts AS c ON x.accountCode = c.accountCode
            LEFT JOIN tblCurrency AS d ON x.paymentTermCode = d.currency_id
            LEFT JOIN tblCompany AS e ON x.compCode = e.company_id
            LEFT JOIN tblPaymentTerms AS f ON x.accountCurrency = f.paymentTermCode
            LEFT JOIN tblBankInformation as l ON c.bankCode = l.bankCode 
            WHERE 

            x.dateCreated BETWEEN '$dateFrom' AND '$dateTo' $whereComp_B
            
            ORDER BY dateCreated";
            
            // echo $query;
            // exit();

        $result = $this->db->query($query);

        return $result->result_array();

    }

    function generateDailyReportExcel($compCode, $dateFrom)
    {
        $whereComp_A = "";
        $whereComp_B = "";

        //if compcode not equal to '' and not equal to null
        if($compCode != '' AND $compCode != null)
        {
            $whereComp_A = "AND a.compCode = '$compCode'";
            $whereComp_B = "AND x.compCode = '$compCode'";
        }

         $query = "SELECT 
        b.vendorName,
        d.currency,
        f.paymentName,
        a.InvoiceNumber,
        FORMAT(a.InvoiceDate, 'MM-dd-yyyy') AS InvoiceDate,  
        FORMAT(CAST(a.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS InvoiceAmount,
        a.compCode,
        e.company_name,
        a.rfp,
        FORMAT(a.dateCreated, 'yyyy-MM-dd') AS dateCreated
        
        FROM tblTelegraphicTransferInvoice AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblCompany AS e ON a.compCode = e.company_id
        LEFT JOIN tblPaymentTerms AS f ON a.accountCurrency = f.paymentTermCode
        
        WHERE 
       
        a.dateCreated = '$dateFrom'  $whereComp_A
        
        UNION
        
        SELECT 
        
        b.vendorName,
        d.currency,
        f.paymentName,
        x.InvoiceNumber,
        FORMAT(x.InvoiceDate, 'MM-dd-yyyy') AS InvoiceDate,  
        FORMAT(CAST(x.InvoiceAmount AS DECIMAL(10,2)), 'N2') AS InvoiceAmount,
        x.compCode,
        e.company_name,
        x.rfp,
        FORMAT(x.dateCreated, 'yyyy-MM-dd') AS dateCreated
        
        FROM tblTelegraphicTransferInvoice_his AS x
        LEFT JOIN tblVendor AS b ON x.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON x.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON x.paymentTermCode = d.currency_id
        LEFT JOIN tblCompany AS e ON x.compCode = e.company_id
        LEFT JOIN tblPaymentTerms AS f ON x.accountCurrency = f.paymentTermCode
        WHERE 

        x.dateCreated = '$dateFrom'  $whereComp_B
        
        ORDER BY dateCreated";

        // echo $query;
        // exit();

        $res = $this->db->query($query);

        return $res->result_array();
    }

    function generateDailyPaymentReport($company, $InvoiceNumber)
    {
        $whereComp_A = "";
       
        if($company != '' AND $company != null)
        {
            $whereComp_A = "AND (x.InvoiceNumber='$InvoiceNumber' OR y.InvoiceNumber = '$InvoiceNumber')";
        }

        $qry = "SELECT 
        a.Vendor, 
        a.InvoiceNumber,
        FORMAT(a.InvoiceDate, 'yyyy-MM-dd') AS InvoiceDate,
        a.InvoiceAmount, 
        FORMAT(CAST(a.total_payment AS DECIMAL(10,2)), 'N2') AS total_payment,
        (a.total_payment) AS origTotalPayment,
        a.amount,
        FORMAT(CAST(a.total_balance AS DECIMAL(10,2)), 'N2') AS total_balance,
        (a.total_balance) AS origBal,
        b.paymentName,
        FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created,
        a.payment_type,
        a.remarks,
        a.rfp
       
        FROM tblPayment_invoices AS a
        LEFT JOIN tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
        LEFT JOIN tblTelegraphicTransferInvoice AS x ON a.Vendor = x.vendorCode AND a.InvoiceNumber = x.InvoiceNumber
        LEFT JOIN tblTelegraphicTransferInvoice_his AS y ON a.Vendor = y.vendorCode AND a.InvoiceNumber = y.InvoiceNumber
        WHERE
    
        (x.compCode = '$company' OR y.compCode = '$company')  $whereComp_A";

        // echo $qry;
        // exit();

        $res = $this->db->query($qry);

        return $res->result_array();
    }

    function generateNonPaymentDailyReport($company, $InvoiceNumber)
    {
        $whereComp_A = "";
       
        if($company != '' AND $company != null)
        {
            $whereComp_A = "AND (x.InvoiceNumber='$InvoiceNumber' OR y.InvoiceNumber = '$InvoiceNumber')";
      
        }


        $qry = "SELECT 
                a.invoice_number,
                a.vendor,
                a.date,
                a.transact_type,
                b.otherTransacTypeName,
                c.transactionName,
                a.reference_no,
                a.amount,
                a.remarks,
                a.rfp,
                FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created
                FROM tblOtherTransactNoneInvoice AS a
                LEFT JOIN tblOtherTransactionType AS b ON a.transact_type = b.otherTransacTypeCode
                LEFT JOIN tblTransactionType AS c ON a.[transaction] = c.transactionCode
                
                LEFT JOIN tblTelegraphicTransferInvoice AS x ON a.vendor = x.vendorCode AND a.invoice_number = x.InvoiceNumber
                LEFT JOIN tblTelegraphicTransferInvoice_his AS y ON a.vendor = y.vendorCode AND a.invoice_number = y.InvoiceNumber
                WHERE
              
                (x.compCode = '$company' OR y.compCode = '$company') $whereComp_A";

        // echo $qry;
        // exit();

        $res = $this->db->query($qry);

        return $res->result_array();
    }
}