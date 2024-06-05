<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class adjustmentDeductionReportModel extends CI_Model {


    function selectVendor()
    {
        $query = "SELECT * FROM tblVendor WHERE vendorStatus = 1 AND vendor_approval_status = 1";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function selectCompany()
    {
        $query = "SELECT * FROM tblCompany";

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
        
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function generateReport($compCode, $vendorCode, $transactionCode, $dateTo, $dateFrom)
    {   
        
        // $query3 = "SELECT
        // b.company_name,
        // c.vendorName,
        // FORMAT(a.PODate, 'MM-dd-yyyy') AS formattedPODate,
        // a.PONumber,
        // FORMAT(CAST(a.POAmount AS DECIMAL(10,2)), 'N2') AS formattedPOAmount,
        // FORMAT(CAST(e.total_payment AS DECIMAL(10,2)), 'N2') AS formattedtotal_payment,
        // FORMAT(CAST(e.total_balance AS DECIMAL(10,2)), 'N2') AS formattedtotal_balance,
        // d.currency,
        // g.transactionName,  
        // FORMAT(SUM(CAST(f.otherTotalDeduc AS DECIMAL(10,2))), 'N2') AS totalFormattedTotalDeduc,
        // f.referenceNumber,
        // f.remarks,
        // FORMAT(CAST(f.updated_deduct_adjustment AS DECIMAL(10,2)), 'N2') AS totalFormattedUpdated_deduct_adjustment,
        // FORMAT(a.dateCreated, 'MM-dd-yyyy') AS formattedDateCreated,
        // a.userCreated
        // FROM tblTelegraphicTransfer AS a
        // LEFT JOIN tblCompany AS b ON a.compCode = b.company_id
        // LEFT JOIN tblVendor AS c ON a.vendorCode = c.vendorCode
        // LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        // LEFT JOIN tblPayment AS e ON a.vendorCode = e.Vendor AND a.PONumber = e.PO_number
        // LEFT JOIN tblOtherTransactionPO AS f ON a.vendorCode = f.otherVendorCode AND a.PONumber = f.otherPONumber
        // LEFT JOIN tblTransactionType AS g ON f.transactionCode = g.transactionCode
        // WHERE a.compCode = '$compCode' AND a.vendorCode = '$vendorCode' AND (a.dateCreated = '$dateCreated' OR a.dateCreated = '$dateCreated')
        // GROUP BY
        // b.company_name,
        // c.vendorName,
        // FORMAT(a.PODate, 'MM-dd-yyyy'),
        // a.PONumber,
        // f.referenceNumber,
        // f.remarks,
        // g.transactionName,
        // FORMAT(CAST(a.POAmount AS DECIMAL(10,2)), 'N2'),
        // FORMAT(CAST(e.total_payment AS DECIMAL(10,2)), 'N2'),
        // FORMAT(CAST(e.total_balance AS DECIMAL(10,2)), 'N2'),
        // d.currency,
        // FORMAT(a.dateCreated, 'MM-dd-yyyy'),
        // a.userCreated,
        // f.updated_deduct_adjustment";


        $query4 = "SELECT
        b.company_name,
        c.vendorName,
        FORMAT(a.PODate, 'MM-dd-yyyy') AS formattedPODate,
        a.PONumber,
        FORMAT(CAST(a.POAmount AS DECIMAL(10,2)), 'N2') AS formattedPOAmount,
        FORMAT(CAST(e.total_payment AS DECIMAL(10,2)), 'N2') AS formattedtotal_payment,
        FORMAT(CAST(e.total_balance AS DECIMAL(10,2)), 'N2') AS formattedtotal_balance,
        d.currency,
        g.transactionName,  
        FORMAT(SUM(CAST(f.otherTotalDeduc AS DECIMAL(10,2))), 'N2') AS totalFormattedTotalDeduc,
        f.referenceNumber,
        f.remarks,
        FORMAT(CAST(f.updated_deduct_adjustment AS DECIMAL(10,2)), 'N2') AS totalFormattedUpdated_deduct_adjustment,
        FORMAT(a.dateCreated, 'MM-dd-yyyy HH:mm:ss') AS formattedDateCreated,
        FORMAT(e.date_created, 'MM-dd-yyyy HH:mm:ss') AS formattedDateCreatedInitialPayment,
        FORMAT(f.dateCreated, 'MM-dd-yyyy HH:mm:ss') AS formattedDateCreatedOtherPayment,
        a.userCreated
        FROM tblTelegraphicTransfer AS a
        LEFT JOIN tblCompany AS b ON a.compCode = b.company_id
        LEFT JOIN tblVendor AS c ON a.vendorCode = c.vendorCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblPayment AS e ON a.vendorCode = e.Vendor AND a.PONumber = e.PO_number
        LEFT JOIN tblOtherTransactionPO AS f ON a.vendorCode = f.otherVendorCode AND a.PONumber = f.otherPONumber
        LEFT JOIN tblTransactionType AS g ON f.transactionCode = g.transactionCode
        WHERE 

        (
            (a.compCode = '$compCode' AND a.vendorCode = '$vendorCode' OR f.transactionCode = '$transactionCode')
            OR 
            (a.compCode = '$compCode' OR a.vendorCode = '$vendorCode' AND f.transactionCode = '$transactionCode')
            OR
            (a.compCode = '$compCode' OR a.vendorCode = '$vendorCode' OR f.transactionCode = '$transactionCode')
            OR
            (a.compCode = '$compCode' AND a.vendorCode = '$vendorCode' AND f.transactionCode = '$transactionCode')
        )
        
        AND a.dateCreated BETWEEN '$dateFrom' AND '$dateTo'

        GROUP BY
        b.company_name,
        c.vendorName,
        FORMAT(a.PODate, 'MM-dd-yyyy'),
        a.PONumber,
        f.referenceNumber,
        f.remarks,
        g.transactionName,
        FORMAT(CAST(a.POAmount AS DECIMAL(10,2)), 'N2'),
        FORMAT(CAST(e.total_payment AS DECIMAL(10,2)), 'N2'),
        FORMAT(CAST(e.total_balance AS DECIMAL(10,2)), 'N2'),
        d.currency,
        FORMAT(a.dateCreated, 'MM-dd-yyyy HH:mm:ss'),
        FORMAT(e.date_created, 'MM-dd-yyyy HH:mm:ss'),
        FORMAT(f.dateCreated, 'MM-dd-yyyy HH:mm:ss'),
        a.userCreated,
        f.updated_deduct_adjustment

        UNION ALL

        SELECT
        b.company_name,
        c.vendorName,
        FORMAT(h.PODate, 'MM-dd-yyyy') AS formattedPODate,
        h.PONumber,
        FORMAT(CAST(h.POAmount AS DECIMAL(10,2)), 'N2') AS formattedPOAmount,
        FORMAT(CAST(e.total_payment AS DECIMAL(10,2)), 'N2') AS formattedtotal_payment,
        FORMAT(CAST(e.total_balance AS DECIMAL(10,2)), 'N2') AS formattedtotal_balance,
        d.currency,
        g.transactionName,  
        FORMAT(SUM(CAST(f.otherTotalDeduc AS DECIMAL(10,2))), 'N2') AS totalFormattedTotalDeduc,
        f.referenceNumber,
        f.remarks,

        FORMAT(CAST(f.updated_deduct_adjustment AS DECIMAL(10,2)), 'N2') AS totalFormattedUpdated_deduct_adjustment,
        FORMAT(h.dateCreated, 'MM-dd-yyyy HH:mm:ss') AS formattedDateCreated,
        FORMAT(e.date_created, 'MM-dd-yyyy HH:mm:ss') AS formattedDateCreatedInitialPayment,
        FORMAT(f.dateCreated, 'MM-dd-yyyy HH:mm:ss') AS formattedDateCreatedOtherPayment,
        h.userCreated
        FROM tblTelegraphicTransferHis AS h
        LEFT JOIN tblCompany AS b ON h.compCode = b.company_id
        LEFT JOIN tblVendor AS c ON h.vendorCode = c.vendorCode
        LEFT JOIN tblCurrency AS d ON h.paymentTermCode = d.currency_id
        LEFT JOIN tblPayment AS e ON h.vendorCode = e.Vendor AND h.PONumber = e.PO_number
        LEFT JOIN tblOtherTransactionPO AS f ON h.vendorCode = f.otherVendorCode AND h.PONumber = f.otherPONumber
        LEFT JOIN tblTransactionType AS g ON f.transactionCode = g.transactionCode
        WHERE     

        (
            (h.compCode = '$compCode' AND h.vendorCode = '$vendorCode' OR f.transactionCode = '$transactionCode')
            OR 
            (h.compCode = '$compCode' OR h.vendorCode = '$vendorCode' AND f.transactionCode = '$transactionCode')
            OR
            (h.compCode = '$compCode' OR h.vendorCode = '$vendorCode' OR f.transactionCode = '$transactionCode')
            OR
            (h.compCode = '$compCode' AND h.vendorCode = '$vendorCode' AND f.transactionCode = '$transactionCode')
        )

        AND h.dateCreated BETWEEN '$dateFrom' AND '$dateTo'
        
        GROUP BY
        b.company_name,
        c.vendorName,
        FORMAT(h.PODate, 'MM-dd-yyyy'),
        h.PONumber,
        f.referenceNumber,	
        f.remarks,
        g.transactionName,
        FORMAT(CAST(h.POAmount AS DECIMAL(10,2)), 'N2'),
        FORMAT(CAST(e.total_payment AS DECIMAL(10,2)), 'N2'),
        FORMAT(CAST(e.total_balance AS DECIMAL(10,2)), 'N2'),
        d.currency,
        FORMAT(h.dateCreated, 'MM-dd-yyyy HH:mm:ss'),
        FORMAT(e.date_created, 'MM-dd-yyyy HH:mm:ss'),
        FORMAT(f.dateCreated, 'MM-dd-yyyy HH:mm:ss'),
        h.userCreated,
        f.updated_deduct_adjustment
        ORDER BY 
        formattedDateCreatedInitialPayment ASC, formattedDateCreatedOtherPayment ASC
       ";

        //  ORDER BY f.transCodePO ASC
        $result = $this->db->query($query4);

        return $result->result_array();

    }

    function selectAllPO($dateFrom, $dateTo)
    {
        $qry = "SELECT 
            FORMAT(a.dateCreated, 'yyyy-MM-dd') AS dateCreated,
            b.vendorName,
            c.accountNumber,
            d.currency,
            e.paymentName,
            a.PONumber,
            a.PODate,
            FORMAT(a.POAmount, 'N2') AS POAmount,
            a.proformaInvoice,
            a.finalInvoice,
            a.rfp,
            h.company_name,
            FORMAT(CAST(a.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
            FORMAT(CAST(a.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount

            FROM tblTelegraphicTransfer AS a
            LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
            LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
            LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
            LEFT JOIN tblPaymentTerms AS e ON a.accountCurrency = e.paymentTermCode
            LEFT JOIN tblCompany AS h ON a.compCode = h.company_id
            WHERE 
            a.dateCreated BETWEEN '$dateFrom' AND '$dateTo'

            UNION ALL

            SELECT
            FORMAT(g.dateCreated, 'yyyy-MM-dd') AS dateCreated,
            b.vendorName,
            c.accountNumber,
            d.currency,
            e.paymentName,
            g.PONumber,
            g.PODate,
            FORMAT(g.POAmount, 'N2') AS POAmount,
            g.proformaInvoice,
            g.finalInvoice,
            g.rfp,
			h.company_name,
            FORMAT(CAST(g.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
            FORMAT(CAST(g.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount
         
            FROM tblTelegraphicTransferHis AS g
            LEFT JOIN tblVendor AS b ON g.vendorCode = b.vendorCode
            LEFT JOIN tblAccounts AS c ON g.accountCode = c.accountCode
            LEFT JOIN tblCurrency AS d ON g.paymentTermCode = d.currency_id
            LEFT JOIN tblPaymentTerms AS e ON g.accountCurrency = e.paymentTermCode
            LEFT JOIN tblCompany AS h ON g.compCode = h.company_id
            WHERE 
            a.dateCreated BETWEEN '$dateFrom' AND '$dateTo'";


            $res = $this->db->query($qry);

            return $res->result_array();

    }

    function generatePOBoth()
    {
        $query = "SELECT 
        b.vendorName,
        c.accountNumber,
        d.currency,
        e.paymentName,
        a.PONumber,
        a.PODate,
        FORMAT(a.POAmount, 'N2') AS POAmount,
        a.proformaInvoice,
        a.finalInvoice,
        a.rfp,
        h.company_name,
        a.updated_balanced,
        a.updated_paid_amount
        
        
        
        FROM tblTelegraphicTransfer AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblPaymentTerms AS e ON a.accountCurrency = e.paymentTermCode
        LEFT JOIN tblCompany AS h ON a.compCode = h.company_id
        
        
        
        WHERE a.CompCode = '3' AND a.paymentTermCode = '2' 
        
        
        
        UNION
        
        SELECT b.vendorName,
        c.accountNumber,
        d.currency,
        e.paymentName,
        g.PONumber,
        g.PODate,
        FORMAT(g.POAmount, 'N2') AS POAmount,
        g.proformaInvoice,
        g.finalInvoice,
        g.rfp,
        
        h.company_name,
        g.updated_balanced,
        g.updated_paid_amount

        
        FROM tblTelegraphicTransferHis AS g
        LEFT JOIN tblVendor AS b ON g.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON g.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON g.paymentTermCode = d.currency_id
        LEFT JOIN tblPaymentTerms AS e ON g.accountCurrency = e.paymentTermCode
        LEFT JOIN tblCompany AS h ON g.compCode = h.company_id
        
        
        
        WHERE g.CompCode = '3' AND g.paymentTermCode = '2'";

        $res = $this->db->query($query);

        return $res->result_array();
    }
    function generatePdfAllPo($compCode, $currency)
    {
            $testQry = "SELECT 
            b.vendorName,
            c.accountNumber,
            d.currency,
            e.paymentName,
            a.PONumber,
            a.PODate,
            FORMAT(a.POAmount, 'N2') AS POAmount,
            a.proformaInvoice,
            a.finalInvoice,
            a.rfp,
            h.company_name,
            FORMAT(CAST(a.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
            FORMAT(CAST(a.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
             
            f.date_created,

            (f.rfp) AS paymentRfp,
            
            i.otherTransacTypeName,
            j.transact_name,
            z.referenceNumber,
            FORMAT(CAST(z.updated_deduct_adjustment AS DECIMAL(10,2)), 'N2') AS updated_deduct_adjustment,
            FORMAT(CAST(z.otherTotalDeduc AS DECIMAL(10,2)), 'N2') AS otherTotalDeduc,
            FORMAT(z.dateCreated, 'yyyy-MM-dd') AS dateCreated,
            (z.rfp) AS otherPaymentRfp,

            (p.otherTransacTypeName) AS NonPOTransactType,
            (l.transactionName) AS NonPOTransaction,
            (m.reference_no) AS NONPOReferenceNo,
            (m.remarks) AS NONPORemarks,
            (m.rfp) AS NONPORfp,
            (m.amount) AS NONPOAmount,
            FORMAT(m.date_created, 'yyyy-MM-dd') AS NONPODateCreated

            FROM tblTelegraphicTransfer AS a
            LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
            LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
            LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
            LEFT JOIN tblPaymentTerms AS e ON a.accountCurrency = e.paymentTermCode
            LEFT JOIN tblCompany AS h ON a.compCode = h.company_id
            
            LEFT JOIN tblPayment AS f ON a.vendorCode = f.Vendor AND a.PONumber = f.PO_number
            LEFT JOIN tblOtherTransactionPO AS z ON a.vendorCode = z.otherVendorCode AND a.PONumber = z.otherPONumber
            
            LEFT JOIN tblOtherTransactionType AS i ON z.otherTransTypeCode = i.otherTransacTypeCode
            LEFT JOIN transact_2 AS j ON z.transactionCode = j.id

            LEFT JOIN tblOtherTransactNonePO AS m ON a.vendorCode = m.vendor AND a.PONumber = m.po_number
						
            LEFT JOIN tblOtherTransactionType AS p ON m.transact_type = p.otherTransacTypeCode
            LEFT JOIN tblTransactionType AS l ON m.[transaction] = l.transactionCode
            
            WHERE a.CompCode = '$compCode' AND a.paymentTermCode = '$currency' 

            UNION ALL
            
            SELECT b.vendorName,
            c.accountNumber,
            d.currency,
            e.paymentName,
            g.PONumber,
            g.PODate,
            FORMAT(g.POAmount, 'N2') AS POAmount,
            g.proformaInvoice,
            g.finalInvoice,
            g.rfp,  
            h.company_name,
            FORMAT(CAST(g.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
            FORMAT(CAST(g.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,


            f.date_created,

            (f.rfp) AS paymentRfp,
            
            i.otherTransacTypeName,
            j.transact_name,
            z.referenceNumber,
            FORMAT(CAST(z.updated_deduct_adjustment AS DECIMAL(10,2)), 'N2') AS updated_deduct_adjustment,
            FORMAT(CAST(z.otherTotalDeduc AS DECIMAL(10,2)), 'N2') AS otherTotalDeduc,
            FORMAT(z.dateCreated, 'yyyy-MM-dd') AS dateCreated,
            (z.rfp) AS otherPaymentRfp,

            (p.otherTransacTypeName) AS NonPOTransactType,
            (l.transactionName) AS NonPOTransaction,
            (m.reference_no) AS NONPOReferenceNo,
            (m.remarks) AS NONPORemarks,
            (m.rfp) AS NONPORfp,
            (m.amount) AS NONPOAmount,
            FORMAT(m.date_created, 'yyyy-MM-dd') AS NONPODateCreated

            
            FROM tblTelegraphicTransferHis AS g
            LEFT JOIN tblVendor AS b ON g.vendorCode = b.vendorCode
            LEFT JOIN tblAccounts AS c ON g.accountCode = c.accountCode
            LEFT JOIN tblCurrency AS d ON g.paymentTermCode = d.currency_id
            LEFT JOIN tblPaymentTerms AS e ON g.accountCurrency = e.paymentTermCode
            LEFT JOIN tblCompany AS h ON g.compCode = h.company_id
            
            LEFT JOIN tblPayment AS f ON g.vendorCode = f.Vendor AND g.PONumber = f.PO_number
            LEFT JOIN tblOtherTransactionPO AS z ON g.vendorCode = z.otherVendorCode AND g.PONumber = z.otherPONumber
            
            LEFT JOIN tblOtherTransactionType AS i ON z.otherTransTypeCode = i.otherTransacTypeCode
            LEFT JOIN transact_2 AS j ON z.transactionCode = j.id

            LEFT JOIN tblOtherTransactNonePO AS m ON g.vendorCode = m.vendor AND g.PONumber = m.po_number
            LEFT JOIN tblOtherTransactionType AS p ON m.transact_type = p.otherTransacTypeCode
            LEFT JOIN tblTransactionType AS l ON m.[transaction] = l.transactionCode
            
            WHERE g.CompCode = '$compCode' AND g.paymentTermCode = '$currency' 
            
            ORDER BY f.date_created, dateCreated, NONPODateCreated";

            // $query2 = "SELECT 
            //         b.vendorName,
            //         c.accountNumber,
            //         d.currency,
            //         e.paymentName,
            //         a.PONumber,
            //         a.PODate,
            //         FORMAT(CAST(a.POAmount AS DECIMAL(10,2)), 'N2') AS POAmount,
            //         a.proformaInvoice,
            //         a.finalInvoice,
            //         a.rfp,
            //         h.company_name,
            //         f.date_created,
            //         FORMAT(CAST(f.total_balance AS DECIMAL(10,2)), 'N2') AS total_balance,
            //         FORMAT(CAST(f.amount AS DECIMAL(10,2)), 'N2') AS amount,
            //         (f.rfp) AS paymentRfp
                    
            //         FROM tblTelegraphicTransfer AS a
            //         LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
            //         LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
            //         LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
            //         LEFT JOIN tblPaymentTerms AS e ON a.accountCurrency = e.paymentTermCode
            //         LEFT JOIN tblCompany AS h ON a.compCode = h.company_id
                    
            //         LEFT JOIN tblPayment AS f ON a.vendorCode = f.Vendor AND a.PONumber = f.PO_number
                
            //         WHERE a.compCode = '$compCode' AND a.paymentTermCode = '$currency'
                    
            //         UNION
                    
            //         SELECT b.vendorName,
            //         c.accountNumber,
            //         d.currency,
            //         e.paymentName,
            //         g.PONumber,
            //         g.PODate,
            //         FORMAT(CAST(g.POAmount AS DECIMAL(10,2)), 'N2') AS POAmount,
            //         g.proformaInvoice,
            //         g.finalInvoice,
            //         g.rfp,
                    
            //         h.company_name,
            //         f.date_created,
            //         FORMAT(CAST(f.total_balance AS DECIMAL(10,2)), 'N2') AS total_balance,
            //         FORMAT(CAST(f.amount AS DECIMAL(10,2)), 'N2') AS amount,
            //         (f.rfp) AS paymentRfp
                    
            //         FROM tblTelegraphicTransferHis AS g
            //         LEFT JOIN tblVendor AS b ON g.vendorCode = b.vendorCode
            //         LEFT JOIN tblAccounts AS c ON g.accountCode = c.accountCode
            //         LEFT JOIN tblCurrency AS d ON g.paymentTermCode = d.currency_id
            //         LEFT JOIN tblPaymentTerms AS e ON g.accountCurrency = e.paymentTermCode
            //         LEFT JOIN tblCompany AS h ON g.compCode = h.company_id
                    
            //         LEFT JOIN tblPayment AS f ON g.vendorCode = f.Vendor AND g.PONumber = f.PO_number
                    
            //         WHERE g.compCode = '$compCode' AND g.paymentTermCode = '$currency'

            //         ORDER BY f.date_created
            //         ";

      $result = $this->db->query($testQry);

      return $result->result_array();
    }

    function generatePO($compCode, $currency)
    {
        $qry = "SELECT 
        b.vendorName,
        c.accountNumber,
        d.currency,
        e.paymentName,
        a.PONumber,
        a.PODate,
        FORMAT(a.POAmount, 'N2') AS POAmount,
        a.proformaInvoice,
        a.finalInvoice,
        a.rfp,
        h.company_name,

        FORMAT(CAST(a.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
        FORMAT(CAST(a.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount

        FROM tblTelegraphicTransfer AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblPaymentTerms AS e ON a.accountCurrency = e.paymentTermCode
        LEFT JOIN tblCompany AS h ON a.compCode = h.company_id
        
        LEFT JOIN tblPayment AS f ON a.vendorCode = f.Vendor AND a.PONumber = f.PO_number
        LEFT JOIN tblOtherTransactionPO AS i ON a.vendorCode = i.otherVendorCode AND a.PONumber = i.otherPONumber
        
        WHERE a.compCode = '$compCode' AND a.paymentTermCode = '$currency' 

        UNION

        SELECT
            b.vendorName,
            c.accountNumber,
            d.currency,
            e.paymentName,
            g.PONumber,
            g.PODate,
            FORMAT(g.POAmount, 'N2') AS POAmount,
            g.proformaInvoice,
            g.finalInvoice,
            g.rfp,
			h.company_name,
            FORMAT(CAST(g.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
            FORMAT(CAST(g.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount
         
            FROM tblTelegraphicTransferHis AS g
            LEFT JOIN tblVendor AS b ON g.vendorCode = b.vendorCode
            LEFT JOIN tblAccounts AS c ON g.accountCode = c.accountCode
            LEFT JOIN tblCurrency AS d ON g.paymentTermCode = d.currency_id
            LEFT JOIN tblPaymentTerms AS e ON g.accountCurrency = e.paymentTermCode
            LEFT JOIN tblCompany AS h ON g.compCode = h.company_id
            
            LEFT JOIN tblPayment AS f ON g.vendorCode = f.Vendor AND g.PONumber = f.PO_number
            LEFT JOIN tblOtherTransactionPO AS i ON g.vendorCode = i.otherVendorCode AND g.PONumber = i.otherPONumber

            WHERE g.compCode = '$compCode' AND g.paymentTermCode = '$currency'";

            $res = $this->db->query($qry);

            return $res->result_array();
            
            
    }

    function generatePOExcel($compCode, $vendorCode, $reference, $dateFrom, $dateTo)
    {
        // $whereComp_A = "";
        // $whereComp_B = "";

        //if walang laman ang company vendor and reference no
        if(($compCode == '' OR $compCode == null) AND ($vendorCode == '' OR $vendorCode == null) AND ($reference == '' OR $reference == null))
        {
            $whereComp_A = "";
            $whereComp_B = "";
        }

        //if walang laman ang company, reference no and may laman ang vendor
        else if(($compCode !== '' OR $compCode !== null) AND ($vendorCode == '' OR $vendorCode == null) AND ($reference == '' OR $reference == null))
        {
            $whereComp_A = "AND a.compCode = '$compCode'";
            $whereComp_B = "AND g.compCode = '$compCode'";
        }   

        //if may laman ang vendor at walang laman ang company at reference
        else if(($vendorCode !== '' OR $vendorCode !== null) AND ($compCode == '' OR $compCode == null) AND ($reference == '' OR $reference == null))
        {
            $whereComp_A = "AND a.vendorCode = '$vendorCode'";
            $whereComp_B = "AND g.vendorCode = '$vendorCode'";
        }

        //if may laman ang reference no at walang laman ang vendor at company
        else if(($reference !== '' OR $reference !== null) AND ($vendorCode == '' OR $vendorCode == null) AND ($compCode == '' OR $compCode == null))
        {   
            $whereComp_A = "AND (i.referenceNumber = '$reference' OR j.reference_no = '$reference')";
            $whereComp_B = "AND (i.referenceNumber = '$reference' OR j.reference_no = '$reference')";
        }

        //pag pareho may laman lahat
        else
        {
            $whereComp_A = "AND a.compCode = '$compCode' AND a.vendorCode = '$vendorCode' AND i.referenceNumber = '$reference' AND j.reference_no = '$reference'";
            $whereComp_B = "AND g.compCode = '$compCode' AND g.vendorCode = '$vendorCode' AND j.reference_no = '$reference' AND i.referenceNumber = '$reference'";
        }

    


        $qry = "SELECT 
        FORMAT(a.dateCreated, 'yyyy-MM-dd') AS dateCreated,
        b.vendorName,
        b.vendorAddress1,
        c.accountNumber,
        d.currency,
        e.paymentName,
        a.PONumber,
        FORMAT(a.PODate, 'yyyy-MM-dd') AS PODate,
        FORMAT (CAST(a.POAmount AS DECIMAL (10,2)), 'N2') AS POAmount,
        a.proformaInvoice,
        a.finalInvoice,
        a.rfp,
        a.remarks,
        h.company_name,
        FORMAT(CAST(a.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
        FORMAT(CAST(a.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
        i.referenceNumber,
	    j.reference_no,
        l.bankName,
        l.bankAddress2,
        c.swiftCode,
        c.ibanNo,
        c.abaNo

        FROM tblTelegraphicTransfer AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblPaymentTerms AS e ON a.accountCurrency = e.paymentTermCode
        LEFT JOIN tblCompany AS h ON a.compCode = h.company_id
        LEFT JOIN tblOtherTransactionPO AS i ON a.vendorCode = i.otherVendorCode AND a.PONumber = i.otherPONumber
		LEFT JOIN tblOtherTransactNonePO AS j ON a.vendorCode = j.vendor AND a.PONumber = j.po_number 
        LEFT JOIN tblBankInformation as l ON c.bankCode = l.bankCode

        WHERE 
        a.dateCreated BETWEEN '$dateFrom' AND '$dateTo' $whereComp_A

        UNION ALL

        SELECT
            FORMAT(g.dateCreated, 'yyyy-MM-dd') AS dateCreated,
            b.vendorName,         
            b.vendorAddress1,
            c.accountNumber,
            d.currency,
            e.paymentName,
            g.PONumber,
            FORMAT(g.PODate, 'yyyy-MM-dd') AS PODate,
            FORMAT (CAST(g.POAmount AS DECIMAL (10,2)), 'N2') AS POAmount,
            g.proformaInvoice,
            g.finalInvoice,
            g.rfp,
            g.remarks,
			h.company_name,
            FORMAT(CAST(g.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
            FORMAT(CAST(g.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
            i.referenceNumber,
	        j.reference_no,
            l.bankName,
            l.bankAddress2,
            c.swiftCode,
            c.ibanNo,
            c.abaNo
         
            FROM tblTelegraphicTransferHis AS g
            LEFT JOIN tblVendor AS b ON g.vendorCode = b.vendorCode
            LEFT JOIN tblAccounts AS c ON g.accountCode = c.accountCode
            LEFT JOIN tblCurrency AS d ON g.paymentTermCode = d.currency_id
            LEFT JOIN tblPaymentTerms AS e ON g.accountCurrency = e.paymentTermCode
            LEFT JOIN tblCompany AS h ON g.compCode = h.company_id
            LEFT JOIN tblOtherTransactionPO AS i ON g.vendorCode = i.otherVendorCode AND g.PONumber = i.otherPONumber
		    LEFT JOIN tblOtherTransactNonePO AS j ON g.vendorCode = j.vendor AND g.PONumber = j.po_number
            LEFT JOIN tblBankInformation as l ON c.bankCode = l.bankCode

            WHERE 
             g.dateCreated BETWEEN '$dateFrom' AND '$dateTo' $whereComp_B

            ORDER BY dateCreated";

            // echo $qry;
            // exit();

            $res = $this->db->query($qry);

            return $res->result_array();
    }

    function generateTBLPayment($compCode, $currency, $ponumber)
    {
            $qry =" SELECT
            z.otherVendorCode,
            i.otherTransacTypeName,
            j.transact_name,
            z.referenceNumber,
            FORMAT(CAST(z.updated_deduct_adjustment AS DECIMAL(10,2)), 'N2') AS updated_deduct_adjustment,
            FORMAT(CAST(z.otherTotalDeduc AS DECIMAL(10,2)), 'N2') AS otherTotalDeduc,
            FORMAT(z.dateCreated, 'yyyy-MM-dd') AS dateCreated,
            (z.rfp) AS otherPaymentRfp,
            a.vendorCode,
            a.PONumber,

            (b.vendorCode) AS vendorCodeHistory,
            (b.PONumber) AS PONumberHistory

            FROM tblOtherTransactionPO AS z
            LEFT JOIN tblOtherTransactionType AS i ON z.otherTransTypeCode = i.otherTransacTypeCode
            LEFT JOIN transact_2 AS j ON z.transactionCode = j.id
            LEFT JOIN tblTelegraphicTransfer AS a ON z.otherVendorCode = a.vendorCode  AND z.otherPONumber = a.PONumber
            LEFT JOIN tblTelegraphicTransferHis AS b ON z.otherVendorCode = b.vendorCode AND z.otherPONumber = b.PONumber
            WHERE 
                ((a.compCode = '$compCode' AND a.paymentTermCode = '$currency') OR (b.compCode = '$compCode' AND b.paymentTermCode = '$currency'))
                AND (a.PONumber = '$ponumber' OR b.PONumber = '$ponumber')

           ";

        // echo $qry;
        // exit;

        $result = $this->db->query($qry);

       

        return $result->result_array();
    }

    function generateTBLPaymentExcel($compCode, $currency, $ponumber)
    {
        $whereComp_A = "";
       
        if($compCode != '' OR $compCode != null)
        {
            $whereComp_A = "AND (x.compCode = '$compCode' OR y.compCode = '$compCode') ";
      
        }

        else if($currency != '' OR $currency != null)
        {
            $whereComp_A = "AND (x.vendorCode = '$currency' OR y.vendorCode = '$currency')";
        }

        $qry = "SELECT b.vendorName,
                a.PO_number,
                FORMAT(CAST(a.PO_amount AS DECIMAL(10,2)), 'N2') AS PO_amount, 
                c.paymentName,
                FORMAT(CAST(a.amount AS DECIMAL(10,2)), 'N2') AS amount, 
                FORMAT(CAST(a.total_balance AS DECIMAL(10,2)), 'N2') AS total_balance,
                (a.amount) AS origAmt,
                a.rfp, 
                a.remarks,
                FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created,
                a.user_created 
                FROM tblPayment AS a
                LEFT JOIN tblVendor AS b ON a.Vendor = b.vendorCode
                LEFT JOIN tblPaymentTerms AS c ON a.payment_type = c.paymentTermCode 
                LEFT JOIN tblTelegraphicTransfer AS x ON a.Vendor = x.vendorCode AND a.PO_number = x.PONumber
                LEFT JOIN tblTelegraphicTransferHis AS y ON a.Vendor = y.vendorCode AND a.PO_number = y.PONumber
                
                WHERE 
          
                (x.PONumber = '$ponumber' OR y.PONumber = '$ponumber')  $whereComp_A";

        // echo $qry;
        // exit();

        $result = $this->db->query($qry);

       

        return $result->result_array();
    }

    function generateTBLPaymentExcelRFP($po_number, $rfp)
    {
        $whereComp_A = "";
       
        if($rfp != '' AND $rfp != null)
        {

            $whereComp_A = "AND (x.PONumber='$po_number' OR y.PONumber = '$po_number')";
        }

        $qry = "SELECT b.vendorName,
                a.PO_number,
                FORMAT(CAST(a.PO_amount AS DECIMAL(10,2)), 'N2') AS PO_amount, 
                c.paymentName,
                FORMAT(CAST(a.amount AS DECIMAL(10,2)), 'N2') AS amount, 
                FORMAT(CAST(a.total_balance AS DECIMAL(10,2)), 'N2') AS total_balance,
                (a.amount) AS origAmt,
                a.rfp, 
                a.remarks,
                FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created,
                a.user_created 
                FROM tblPayment AS a
                LEFT JOIN tblVendor AS b ON a.Vendor = b.vendorCode
                LEFT JOIN tblPaymentTerms AS c ON a.payment_type = c.paymentTermCode 
                LEFT JOIN tblTelegraphicTransfer AS x ON a.Vendor = x.vendorCode AND a.PO_number = x.PONumber
                LEFT JOIN tblTelegraphicTransferHis AS y ON a.Vendor = y.vendorCode AND a.PO_number = y.PONumber
                
                WHERE 
          
                (a.rfp = '$rfp')  $whereComp_A";

        // echo $qry;
        // exit();

        $result = $this->db->query($qry);

        return $result->result_array();
    }

    function generatePaymentDaily($company, $po_number)
    {

        $whereComp_B = "";

        //not null
        if($company != '' AND $company != null)
        {
         
            $whereComp_B = "AND x.PONumber='$po_number' OR y.PONumber = '$po_number'";
        }

        $qry = "SELECT b.vendorName,
                a.PO_number,
                FORMAT(CAST(a.PO_amount AS DECIMAL(10,2)), 'N2') AS PO_amount, 
                c.paymentName,
                FORMAT(CAST(a.amount AS DECIMAL(10,2)), 'N2') AS amount, 
                FORMAT(CAST(a.total_balance AS DECIMAL(10,2)), 'N2') AS total_balance,
                (a.total_balance) AS origBal,
                (a.amount) AS origAmt,
                a.rfp, 
                a.remarks,
                FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created,
                a.user_created 
                FROM tblPayment AS a
                LEFT JOIN tblVendor AS b ON a.Vendor = b.vendorCode
                LEFT JOIN tblPaymentTerms AS c ON a.payment_type = c.paymentTermCode 
                LEFT JOIN tblTelegraphicTransfer AS x ON a.Vendor = x.vendorCode AND a.PO_number = x.PONumber
                LEFT JOIN tblTelegraphicTransferHis AS y ON a.Vendor = y.vendorCode AND a.PO_number = y.PONumber
                
                WHERE  (x.compCode = '$company' OR y.compCode = '$company') $whereComp_B";

            // echo $qry;
            // exit();

        $result = $this->db->query($qry);

        return $result->result_array();

    }

    function generateOtherPaymentExcel($compCode, $reference, $currency, $ponumber)
    {   

        $whereComp_A = "";
        
        // not empty the company
        if($compCode != '' OR $compCode != null)
        {
            $whereComp_A = "AND (a.compCode = '$compCode' OR b.compCode = '$compCode')";
      
        }

        // not empty the currency
        else if($currency != '' OR $currency != null)
        {
            $whereComp_A = " AND (b.vendorCode = '$currency' OR a.vendorCode = '$currency')";
        }

        //not empty the reference
        else if($reference != '' OR $reference != null)
        {
            $whereComp_A = " AND z.referenceNumber = '$reference'";
        }
        
        $qry = "SELECT
        z.otherVendorCode,
        z.transactionCode,
        i.otherTransacTypeName,
        j.transact_name,
        z.referenceNumber,
        FORMAT(CAST(z.updated_deduct_adjustment AS DECIMAL(10,2)), 'N2') AS updated_deduct_adjustment,
        (z.updated_deduct_adjustment) AS origUpdated_deduct_adjustment,
        FORMAT(CAST(z.otherTotalDeduc AS DECIMAL(10,2)), 'N2') AS otherTotalDeduc,
        (z.otherTotalDeduc) AS origOtherTotalDeduc,
        z.amount,
        z.total,
        FORMAT(z.dateCreated, 'MM-dd-yyyy') AS dateCreated,
        z.rfp,
        z.Remarks
 
        FROM tblOtherTransactionPO AS z
        LEFT JOIN tblOtherTransactionType AS i ON z.otherTransTypeCode = i.otherTransacTypeCode
        LEFT JOIN transact_2 AS j ON z.transactionCode = j.id
        LEFT JOIN tblTelegraphicTransfer AS a ON z.otherVendorCode = a.vendorCode  AND z.otherPONumber = a.PONumber
        LEFT JOIN tblTelegraphicTransferHis AS b ON z.otherVendorCode = b.vendorCode AND z.otherPONumber = b.PONumber
        WHERE 
        (a.PONumber = '$ponumber' OR b.PONumber = '$ponumber')  $whereComp_A";

        // echo $qry;
        // exit();

        $res = $this->db->query($qry);

        return $res->result_array();
    }

    function generateOtherPaymentExcelRFP($rfp)
    {
        $whereComp_A = "";
       
        // if($rfp != '' OR $rfp != null)
        // {
        //     $whereComp_A = "AND (a.PONumber='$po_number' OR b.PONumber = '$po_number')";
      
        // }
        
        $qry = "SELECT
        z.otherPONumber,
        z.otherVendorCode,
        z.transactionCode,
        i.otherTransacTypeName,
        j.transact_name,
        z.referenceNumber,
        z.amount,
        z.total,
        FORMAT(CAST(z.updated_deduct_adjustment AS DECIMAL(10,2)), 'N2') AS updated_deduct_adjustment,
        FORMAT(CAST(z.otherTotalDeduc AS DECIMAL(10,2)), 'N2') AS otherTotalDeduc,
        (z.otherTotalDeduc) AS origTotalDeduc,
        FORMAT(z.dateCreated, 'MM-dd-yyyy') AS dateCreated,
        z.rfp,
        z.Remarks
 
        FROM tblOtherTransactionPO AS z
        LEFT JOIN tblOtherTransactionType AS i ON z.otherTransTypeCode = i.otherTransacTypeCode
        LEFT JOIN transact_2 AS j ON z.transactionCode = j.id
        LEFT JOIN tblTelegraphicTransfer AS a ON z.otherVendorCode = a.vendorCode  AND z.otherPONumber = a.PONumber
        LEFT JOIN tblTelegraphicTransferHis AS b ON z.otherVendorCode = b.vendorCode AND z.otherPONumber = b.PONumber
        WHERE 
        (z.rfp = '$rfp')";

        // echo $qry;
        // exit();

        $res = $this->db->query($qry);

        return $res->result_array();
    }

    function generateNonRelatedPO($compCode, $currency, $PONUMBER)
    {
        $qry = "SELECT 
        a.po_number,
        a.vendor,
        FORMAT(a.date, 'yyyy-MM-dd') AS date,
        b.otherTransacTypeName,
        c.transactionName,
        a.reference_no,
        a.remarks,
        a.rfp,
        FORMAT(CAST(a.amount AS DECIMAL(10,2)), 'N2') AS amount,
        
        d.PONumber,
        d.vendorCode,
        
        (e.PONumber) AS historyPONUMBER,
        (e.vendorCode) AS historyVENDOR
        
        
        FROM tblOtherTransactNonePO AS a
        
        LEFT JOIN tblOtherTransactionType AS b ON a.transact_type = b.otherTransacTypeCode
        LEFT JOIN tblTransactionType AS c ON a.[transaction] = c.transactionCode
        LEFT JOIN tblTelegraphicTransfer AS d ON a.po_number = d.PONumber AND a.vendor = d.vendorCode
        LEFT JOIN tblTelegraphicTransferHis AS e ON a.po_number = e.PONumber AND a.vendor = e.vendorCode
        WHERE 
        ((d.compCode = '$compCode' AND d.paymentTermCode = '$currency') OR (e.compCode = '$compCode' AND e.paymentTermCode = '$currency'))
        AND
        (d.PONumber = '$PONUMBER' OR e.PONumber = '$PONUMBER')";

        $res = $this->db->query($qry);

        return $res->result_array();
    }

    function generateNonRelatedPOExcel($compCode, $reference, $vendor, $ponumber)
    {
        
        $whereComp_A = "";
       
        if($compCode != '' OR $compCode != null )
        {
            $whereComp_A = "AND (d.compCode = '$compCode' OR e.compCode = '$compCode') ";
      
        }

        else if($vendor != '' OR $vendor != null)
        {
            $whereComp_A = "AND ( d.vendorCode = '$vendor' OR e.vendorCode = '$vendor')";
        }

        else if($reference != '' OR $reference != null)
        {
            $whereComp_A = "AND a.reference_no = '$reference'";
        }

        $qry = "SELECT 
        a.po_number,
        a.vendor,
        FORMAT(a.date, 'MM-dd-yyyy') AS date,
        b.otherTransacTypeName,
        c.transactionName,
        a.reference_no,
        a.remarks,
        a.amount2,
        a.total,
        a.rfp,
        a.transact_type,
        FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created,
        FORMAT(CAST(a.amount AS DECIMAL(10,2)), 'N2') AS amount,
        (a.amount) AS newAmt,
        
        d.PONumber,
        d.vendorCode,
        
        (e.PONumber) AS historyPONUMBER,
        (e.vendorCode) AS historyVENDOR
        
        
        FROM tblOtherTransactNonePO AS a
        
        LEFT JOIN tblOtherTransactionType AS b ON a.transact_type = b.otherTransacTypeCode
        LEFT JOIN tblTransactionType AS c ON a.[transaction] = c.transactionCode
        LEFT JOIN tblTelegraphicTransfer AS d ON a.po_number = d.PONumber AND a.vendor = d.vendorCode
        LEFT JOIN tblTelegraphicTransferHis AS e ON a.po_number = e.PONumber AND a.vendor = e.vendorCode
        WHERE 
        (d.PONumber = '$ponumber' OR e.PONumber = '$ponumber') $whereComp_A";

        // echo $qry;
        // exit();

        $res = $this->db->query($qry);

        return $res->result_array();  
    }

    function generateNonRelatedPOExcelRFP($po_number, $rfp)
    {
        $whereComp_A = "";
       
        if($rfp != '' OR $rfp != null)
        {
         $whereComp_A = "AND (d.PONumber='$po_number' OR e.PONumber = '$po_number')";
      
        }

        $qry = "SELECT 
        a.po_number,
        a.vendor,
        FORMAT(a.date, 'yyyy-MM-dd') AS date,
        b.otherTransacTypeName,
        c.transactionName,
        a.reference_no,
        a.remarks,
        a.rfp,
        a.transact_type,
        FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created,
        FORMAT(CAST(a.amount AS DECIMAL(10,2)), 'N2') AS amount,
        (a.amount) AS newAmt,
        a.amount2,
        a.total,
        
        d.PONumber,
        d.vendorCode,
        
        (e.PONumber) AS historyPONUMBER,
        (e.vendorCode) AS historyVENDOR
        
        
        FROM tblOtherTransactNonePO AS a
        
        LEFT JOIN tblOtherTransactionType AS b ON a.transact_type = b.otherTransacTypeCode
        LEFT JOIN tblTransactionType AS c ON a.[transaction] = c.transactionCode
        LEFT JOIN tblTelegraphicTransfer AS d ON a.po_number = d.PONumber AND a.vendor = d.vendorCode
        LEFT JOIN tblTelegraphicTransferHis AS e ON a.po_number = e.PONumber AND a.vendor = e.vendorCode
        WHERE 
        (a.rfp = '$rfp') $whereComp_A";

        // echo $qry;
        // exit();

        $res = $this->db->query($qry);

        return $res->result_array();  
    }

    function NonRelatedPODaily($company, $po_number)
    {
        $whereComp_B = "";
       
        if($company != '' AND $company != null)
        {
         $whereComp_B = "AND d.PONumber='$po_number' OR e.PONumber = '$po_number'";
      
        }

        $qry = "SELECT 
        a.po_number,
        a.vendor,
        FORMAT(a.date, 'yyyy-MM-dd') AS date,
        b.otherTransacTypeName,
        c.transactionName,
        a.reference_no,
        a.remarks,
        a.rfp,
        a.transact_type,
        FORMAT(a.date_created, 'MM-dd-yyyy') AS date_created,
        FORMAT(CAST(a.amount AS DECIMAL(10,2)), 'N2') AS amount,
        (a.amount) AS newAmt,
        
        d.PONumber,
        d.vendorCode,
        
        (e.PONumber) AS historyPONUMBER,
        (e.vendorCode) AS historyVENDOR
        
        
        FROM tblOtherTransactNonePO AS a
        
        LEFT JOIN tblOtherTransactionType AS b ON a.transact_type = b.otherTransacTypeCode
        LEFT JOIN tblTransactionType AS c ON a.[transaction] = c.transactionCode
        LEFT JOIN tblTelegraphicTransfer AS d ON a.po_number = d.PONumber AND a.vendor = d.vendorCode
        LEFT JOIN tblTelegraphicTransferHis AS e ON a.po_number = e.PONumber AND a.vendor = e.vendorCode

        WHERE  (d.compCode = '$company' OR e.compCode = '$company') $whereComp_B";

            // echo $qry;
            // exit();

        $res = $this->db->query($qry);

        return $res->result_array();  
    }

    function sumTotalPaidPO($compCode, $currency, $dateFrom)
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


        $query1 = "		SELECT
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
                            CAST(POAmount AS DECIMAL(10, 2)) AS total_payment,
                            CAST(updated_balanced AS DECIMAL(10, 2)) AS updatedBalanced,
                            CAST(updated_paid_amount AS DECIMAL(10, 2)) AS updatedPaidAmount,
                            b.currency,
                            b.currency_sign
                            FROM
                            tblTelegraphicTransfer AS a
                            LEFT JOIN tblCurrency AS b ON a.paymentTermCode = b.currency_id
                            WHERE
                                (a.compCode = '$compCode' AND a.paymentTermCode = '$currency') AND a.dateCreated = '$dateFrom'
    
                            UNION ALL
    
                            SELECT
                            h.compCode,
                            h.paymentTermCode,
                            CAST(POAmount AS DECIMAL(10, 2)) AS total_payment,
                            CAST(updated_balanced AS DECIMAL(10, 2)) AS updatedBalanced,
                            CAST(updated_paid_amount AS DECIMAL(10, 2)) AS updatedPaidAmount,
                            b.currency,
                            b.currency_sign
                            FROM
                                tblTelegraphicTransferHis AS h
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

    function ALLgeneratePdfAllPo($dateFrom, $dateTo)
    {
        $query ="WITH PaymentSumPerPO AS (
            SELECT
            a.PONumber,
            SUM(CAST(e.updated_total_payment AS DECIMAL(10, 2))) AS total_payment_per_po
            FROM
            tblTelegraphicTransfer AS a
            LEFT JOIN tblPayment AS e ON a.vendorCode = e.Vendor AND a.PONumber = e.PO_number
            WHERE
            a.dateCreated  BETWEEN '$dateFrom' AND '$dateTo'
            GROUP BY
            a.PONumber
            ),
    
            PaymentSumPerPOHIS AS (
            SELECT
            h.PONumber,
            SUM(CAST(e.updated_total_payment AS DECIMAL(10, 2))) AS total_payment_per_po
            FROM
            tblTelegraphicTransferHis AS h
            LEFT JOIN tblPayment AS e ON h.vendorCode = e.Vendor AND h.PONumber = e.PO_number
            WHERE
            h.dateCreated  BETWEEN '$dateFrom' AND '$dateTo'
            GROUP BY
            h.PONumber
            )
    
            SELECT DISTINCT				
            formattedDateCreated,
            vendorName,
            PONumber,
            company_name,
            finalInvoice,
            proformaInvoice,
            currency,
            formatedPOAmount AS POAmount,
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
            PONumber,
            company_name,
            finalInvoice,
            proformaInvoice,
            currency,
            formatedPOAmount,
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
            a.PONumber,
            b.company_name,
            finalInvoice,
            proformaInvoice,
            FORMAT(CAST(a.updated_balanced AS DECIMAL(10, 2)), 'N2') AS formatted_updated_balance,
            FORMAT(CAST(a.updated_paid_amount AS DECIMAL(10, 2)), 'N2') AS formattedupdated_paid_amount,
            FORMAT(CAST(a.updated_adjustment_deduction_amt AS DECIMAL(10, 2)), 'N2') AS formattedupdated_adjustment_deduction_amt,
            d.currency,
            FORMAT(SUM(CAST(a.POAmount AS DECIMAL(10, 2))), 'N2') AS formatedPOAmount,
            FORMAT(SUM(total_payment_per_po), 'N2') AS formattedtotal_payment,
            FORMAT(SUM(CAST(a.POAmount AS DECIMAL(10, 2)) - COALESCE(total_payment_per_po, 0)), 'N2') AS subtractedAmount,
    
            a.userCreated
            FROM tblTelegraphicTransfer AS a
            LEFT JOIN tblCompany AS b ON a.compCode = b.company_id
            LEFT JOIN tblVendor AS c ON a.vendorCode = c.vendorCode
            LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
            LEFT JOIN PaymentSumPerPO AS e ON a.PONumber = e.PONumber
            WHERE a.dateCreated BETWEEN '$dateFrom' AND '$dateTo'
            GROUP BY
            FORMAT(a.dateCreated, 'MM-dd-yyyy'),
            c.vendorName,
            a.PONumber,
            b.company_name,
            a.finalInvoice,
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
            i.PONumber,
            b.company_name, 
            i.finalInvoice,
            i.proformaInvoice,
            FORMAT(CAST(i.updated_balanced AS DECIMAL(10, 2)), 'N2') AS formatted_updated_balance,
            FORMAT(CAST(i.updated_paid_amount AS DECIMAL(10, 2)), 'N2') AS formattedupdated_paid_amount,
            FORMAT(CAST(i.updated_adjustment_deduction_amt AS DECIMAL(10, 2)), 'N2') AS formattedupdated_adjustment_deduction_amt,
            d.currency,
            FORMAT(SUM(CAST(i.POAmount AS DECIMAL(10, 2))), 'N2') AS formatedPOAmount,
            FORMAT(SUM(total_payment_per_po), 'N2') AS formattedtotal_payment,
            FORMAT(SUM(CAST(i.POAmount AS DECIMAL(10, 2)) - COALESCE(total_payment_per_po, 0)), 'N2') AS subtractedAmount,
    
            i.userCreated
            FROM tblTelegraphicTransferHis AS i
            LEFT JOIN tblCompany AS b ON i.compCode = b.company_id
            LEFT JOIN tblVendor AS c ON i.vendorCode = c.vendorCode
            LEFT JOIN tblCurrency AS d ON i.paymentTermCode = d.currency_id
            LEFT JOIN PaymentSumPerPOHIS AS e ON i.PONumber = e.PONumber
            WHERE i.dateCreated BETWEEN '$dateFrom' AND '$dateTo'
            GROUP BY
            FORMAT(i.dateCreated, 'MM-dd-yyyy'),
            c.vendorName,
            i.PONumber,				
            b.company_name,
            i.finalInvoice,
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

    function ALLsumTotalPaidPO($dateFrom, $dateTo)
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


        $query1 = "		SELECT
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
                            CAST(POAmount AS DECIMAL(10, 2)) AS total_payment,
                            CAST(updated_balanced AS DECIMAL(10, 2)) AS updatedBalanced,
                            CAST(updated_paid_amount AS DECIMAL(10, 2)) AS updatedPaidAmount,
                            b.currency,
                            b.currency_sign
                            FROM
                            tblTelegraphicTransfer AS a
                            LEFT JOIN tblCurrency AS b ON a.paymentTermCode = b.currency_id
                            WHERE
                            a.dateCreated BETWEEN '$dateFrom' AND '$dateTo'
    
                            UNION ALL
    
                            SELECT
                            h.compCode,
                            h.paymentTermCode,
                            CAST(POAmount AS DECIMAL(10, 2)) AS total_payment,
                            CAST(updated_balanced AS DECIMAL(10, 2)) AS updatedBalanced,
                            CAST(updated_paid_amount AS DECIMAL(10, 2)) AS updatedPaidAmount,
                            b.currency,
                            b.currency_sign
                            FROM
                                tblTelegraphicTransferHis AS h
                                LEFT JOIN tblCurrency AS b ON h.paymentTermCode = b.currency_id
                            WHERE
                            h.dateCreated BETWEEN '$dateFrom' AND '$dateTo'
                            ) AS combined_results
                            GROUP BY
                            currency,
                            currency_sign";

                            $result = $this->db->query($query1);

                            return $result->result_array();
    }

    function fetchdailyTotalPO($compCode, $dateFrom)
    {
        $whereComp_A = "";
        $whereComp_B = "";

        // $whereComp = "";

        if($compCode != '' OR $compCode != null)
        {

            $whereComp_A = "AND a.compCode='$compCode'";
            $whereComp_B = "AND g.compCode='$compCode'";
        }


        $qry = "SELECT
                    FORMAT ( a.dateCreated, 'yyyy-MM-dd' ) AS dateCreated,
                    h.company_name,
                    b.vendorName,
                    a.PONumber,
                    d.currency,
                    FORMAT ( CAST ( a.POAmount AS DECIMAL ( 10, 2 )), 'N2' ) AS POAmount,
                    a.compCode,
                    a.rfp
                
                FROM
                    tblTelegraphicTransfer AS a
                    LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
                    LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
                    LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
                    LEFT JOIN tblPaymentTerms AS e ON a.accountCurrency = e.paymentTermCode
                    LEFT JOIN tblCompany AS h ON a.compCode = h.company_id 
                
                WHERE( a.dateCreated = '$dateFrom') $whereComp_A
                
                UNION ALL
                
                SELECT
                    FORMAT ( g.dateCreated, 'yyyy-MM-dd' ) AS dateCreated,
                    h.company_name,
                    b.vendorName,
                    g.PONumber,
                    d.currency,
                    FORMAT ( CAST ( g.POAmount AS DECIMAL ( 10, 2 )), 'N2' ) AS POAmount,
                    g.compCode,
                    g.rfp
                
                FROM
                    tblTelegraphicTransferHis AS g
                    LEFT JOIN tblVendor AS b ON g.vendorCode = b.vendorCode
                    LEFT JOIN tblAccounts AS c ON g.accountCode = c.accountCode
                    LEFT JOIN tblCurrency AS d ON g.paymentTermCode = d.currency_id
                    LEFT JOIN tblPaymentTerms AS e ON g.accountCurrency = e.paymentTermCode
                    LEFT JOIN tblCompany AS h ON g.compCode = h.company_id 
                
                WHERE
                (g.dateCreated = '$dateFrom') $whereComp_B";

            // echo $qry;
            // exit();

            $res = $this->db->query($qry);

            return $res->result_array();

       

        $result = $this->db->query($query1);

        return $result->result_array();
    }

    function fetchdailyAllTotalPO($dateFrom)
    {
        $query = "WITH PaymentSumPerPO AS (
            SELECT
            a.PONumber,
            SUM(CAST(e.total_payment AS DECIMAL(10, 2))) AS total_payment_per_po
            FROM
            tblTelegraphicTransfer AS a
            LEFT JOIN tblPayment AS e ON a.vendorCode = e.Vendor AND a.PONumber = e.PO_number
            WHERE

            a.dateCreated = '$dateFrom' 

            GROUP BY
            a.PONumber
        ),

        PaymentSumPerPOHIS AS (
            SELECT
            h.PONumber,
            SUM(CAST(e.total_payment AS DECIMAL(10, 2))) AS total_payment_per_po
            FROM
            tblTelegraphicTransferHis AS h
            LEFT JOIN tblPayment AS e ON h.vendorCode = e.Vendor AND h.PONumber = e.PO_number
            WHERE

            h.dateCreated = '$dateFrom'
        
            GROUP BY
            h.PONumber
        )

        SELECT DISTINCT
        formattedDateCreated,
        vendorName,
        company_name,
        PONumber,
        formatedPOAmount AS POAmount,
        formattedtotal_payment,
        subtractedAmount,
        currency,
        userCreated
        FROM (
        SELECT
        formattedDateCreated,
        vendorName,
        company_name,
        PONumber,
        formatedPOAmount,
        formattedtotal_payment,
        subtractedAmount,
        currency,
        userCreated
        FROM (
        SELECT
        FORMAT(a.dateCreated, 'MM-dd-yyyy') AS formattedDateCreated,
        c.vendorName,
        b.company_name,
        a.PONumber,
        FORMAT(SUM(CAST(a.POAmount AS DECIMAL(10, 2))), 'N2') AS formatedPOAmount,
        FORMAT(SUM(total_payment_per_po), 'N2') AS formattedtotal_payment,
        FORMAT(SUM(CAST(a.POAmount AS DECIMAL(10, 2)) - COALESCE(total_payment_per_po, 0)), 'N2') AS subtractedAmount,
        d.currency,
        a.userCreated
        FROM tblTelegraphicTransfer AS a
        LEFT JOIN tblCompany AS b ON a.compCode = b.company_id
        LEFT JOIN tblVendor AS c ON a.vendorCode = c.vendorCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN PaymentSumPerPO AS e ON a.PONumber = e.PONumber
        WHERE 

        a.dateCreated = '$dateFrom' 
     
        GROUP BY
        FORMAT(a.dateCreated, 'MM-dd-yyyy'),
        c.vendorName,
        b.company_name,
        a.PONumber,
        d.currency,
        a.userCreated

        UNION ALL

        SELECT
        FORMAT(i.dateCreated, 'MM-dd-yyyy') AS formattedDateCreated,
        c.vendorName,
        b.company_name,
        i.PONumber,
        FORMAT(SUM(CAST(i.POAmount AS DECIMAL(10, 2))), 'N2') AS formatedPOAmount,
        FORMAT(SUM(total_payment_per_po), 'N2') AS formattedtotal_payment,
        FORMAT(SUM(CAST(i.POAmount AS DECIMAL(10, 2)) - COALESCE(total_payment_per_po, 0)), 'N2') AS subtractedAmount,
        d.currency,
        i.userCreated
        FROM tblTelegraphicTransferHis AS i
        LEFT JOIN tblCompany AS b ON i.compCode = b.company_id
        LEFT JOIN tblVendor AS c ON i.vendorCode = c.vendorCode
        LEFT JOIN tblCurrency AS d ON i.paymentTermCode = d.currency_id
        LEFT JOIN PaymentSumPerPOHIS AS e ON i.PONumber = e.PONumber
        WHERE 
      
        i.dateCreated = '$dateFrom'


        GROUP BY
        FORMAT(i.dateCreated, 'MM-dd-yyyy'),
        c.vendorName,
        b.company_name,
        i.PONumber,
        d.currency,
        i.userCreated
        ) AS Subquery
        ) AS CombinedResult";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchPerPaymentPO($company, $currency, $po_number)
    {
        $qry = "SELECT
        a.rfp,
        b.paymentName,
        FORMAT(a.date_created, 'MM-dd-yyyy HH:mm:ss') AS date_created,
        FORMAT(CAST(a.total_balance AS DECIMAL(10,2)), 'N2') AS total_balance,
        FORMAT(CAST(a.total_payment AS DECIMAL(10,2)), 'N2') AS total_payment
        FROM
        tblPayment AS a
        LEFT JOIN tblPaymentTerms AS b ON a.payment_type = b.paymentTermCode
        LEFT JOIN tblTelegraphicTransfer AS x ON a.Vendor = x.vendorCode AND a.PO_number = x.PONumber
        LEFT JOIN tblTelegraphicTransferHis AS y ON a.Vendor = y.vendorCode AND a.PO_number = y.PONumber
        WHERE
        ((x.compCode = '$company' AND x.paymentTermCode = '$currency') OR (y.compCode = '$company' AND y.paymentTermCode = '$currency'))
        
        AND 
        
        (x.PONumber = '$po_number' OR y.PONumber = '$po_number')";

        $res = $this->db->query($qry);

        return $res->result_array();
    }

    function selectTransact_2()
    {

       return $this->db->get('transact_2')
              ->result_array();


    }

    function totalDailyReport($company, $dateCreated)
    {
        $whereComp = "";
   

        if($company != '' AND $company != null)
        {
            $whereComp = "AND compCode = '$company'";   
        }

        $query = "SELECT 
        FORMAT( CAST ( SUM (totalPOAmount) AS DECIMAL(10,2)), 'N2') AS grandTotalPOAmt,
        FORMAT( CAST ( SUM (totalPaidAmount) AS DECIMAL(10,2)), 'N2') AS grandTotalPaidAmt,
        FORMAT( CAST ( SUM (totalBalance) AS DECIMAL(10,2)), 'N2') AS grandTotalBalance,
        FORMAT( CAST ( SUM (totalDeductAmount) AS DECIMAL(10,2)), 'N2') AS grandTotalDeducAmt
        
        FROM 
        (
            SELECT 
            SUM(CAST(POAmount AS DECIMAL(10, 2))) AS totalPOAmount,
            SUM(CAST(updated_paid_amount AS DECIMAL(10, 2))) AS totalPaidAmount,
            SUM(CAST(updated_balanced AS DECIMAL(10, 2))) AS totalBalance,
            SUM(CAST(updated_adjustment_deduction_amt AS DECIMAL(10, 2))) AS totalDeductAmount 
            
            FROM tblTelegraphicTransfer

            WHERE (dateCreated = '$dateCreated' $whereComp)
            
            GROUP BY PONumber
            
            UNION ALL
            
            SELECT
            SUM(CAST(POAmount AS DECIMAL(10, 2))) AS totalPOAmount,
            SUM(CAST(updated_paid_amount AS DECIMAL(10, 2))) AS totalPaidAmount,
            SUM(CAST(updated_balanced AS DECIMAL(10, 2))) AS totalBalance,
            SUM(CAST(updated_adjustment_deduction_amt AS DECIMAL(10, 2))) AS totalDeductAmount 
            
            FROM tblTelegraphicTransferHis

            WHERE (dateCreated = '$dateCreated' $whereComp)
            
            GROUP BY PONumber
            
        ) AS subquery";

        // echo $query;
        // exit();

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function generateReportByRFP($rfp, $dateFrom, $dateTo)
    {
        $whereComp_A = "";
        $whereComp_B = "";

        //if compcode not equal to '' and not equal to null
        if($rfp != '' OR $rfp != null)
        {
            $whereComp_A = "AND a.rfp = '$rfp'";
            $whereComp_B = "AND g.rfp = '$rfp'";
        }


        $qry = "SELECT 
        FORMAT(a.dateCreated, 'yyyy-MM-dd') AS dateCreated,
        b.vendorName,
        b.vendorAddress1,
        c.accountNumber,
        d.currency,
        e.paymentName,
        a.PONumber,
        FORMAT(a.PODate, 'yyyy-MM-dd') AS PODate,
        FORMAT (CAST(a.POAmount AS DECIMAL (10,2)), 'N2') AS POAmount,
        a.proformaInvoice,
        a.finalInvoice,
        a.rfp,
        a.remarks,
        h.company_name,
        FORMAT(CAST(a.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
        FORMAT(CAST(a.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
        l.bankName,
        l.bankAddress2,
        c.swiftCode,
        c.ibanNo,
        c.abaNo


        FROM tblTelegraphicTransfer AS a
        LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        LEFT JOIN tblCurrency AS d ON a.paymentTermCode = d.currency_id
        LEFT JOIN tblPaymentTerms AS e ON a.accountCurrency = e.paymentTermCode
        LEFT JOIN tblCompany AS h ON a.compCode = h.company_id
        LEFT JOIN tblBankInformation as l ON c.bankCode = l.bankCode   
        WHERE a.dateCreated BETWEEN '$dateFrom' AND '$dateTo' $whereComp_A

        UNION ALL

        SELECT
            FORMAT(g.dateCreated, 'yyyy-MM-dd') AS dateCreated,
            b.vendorName,
            b.vendorAddress1,
            c.accountNumber,
            d.currency,
            e.paymentName,
            g.PONumber,
            FORMAT(g.PODate, 'yyyy-MM-dd') AS PODate,
            FORMAT (CAST(g.POAmount AS DECIMAL (10,2)), 'N2') AS POAmount,
            g.proformaInvoice,
            g.finalInvoice,
            g.rfp,
            g.remarks,
			h.company_name,
            FORMAT(CAST(g.updated_balanced AS DECIMAL(10,2)), 'N2') AS updated_balanced,
            FORMAT(CAST(g.updated_paid_amount AS DECIMAL(10,2)), 'N2') AS updated_paid_amount,
            l.bankName,
            l.bankAddress2,
            c.swiftCode,
            c.ibanNo,
            c.abaNo

            FROM tblTelegraphicTransferHis AS g
            LEFT JOIN tblVendor AS b ON g.vendorCode = b.vendorCode
            LEFT JOIN tblAccounts AS c ON g.accountCode = c.accountCode
            LEFT JOIN tblCurrency AS d ON g.paymentTermCode = d.currency_id
            LEFT JOIN tblPaymentTerms AS e ON g.accountCurrency = e.paymentTermCode
            LEFT JOIN tblCompany AS h ON g.compCode = h.company_id
            LEFT JOIN tblBankInformation as l ON c.bankCode = l.bankCode 
            WHERE g.dateCreated BETWEEN '$dateFrom' AND '$dateTo' $whereComp_B
            ORDER BY dateCreated";

            // echo $qry;
            // exit();

            $res = $this->db->query($qry);

            return $res->result_array();
    }

    function fetchRFP()
    {

        $query = "SELECT rfp FROM tblTelegraphicTransfer
    
        UNION ALL
        
        SELECT rfp FROM tblTelegraphicTransferHis";

        $res = $this->db->query($query);

        return $res->result_array();
    }

    function searchRFPToDB($rfp)
    {
        $query ="SELECT rfp FROM tblTelegraphicTransfer
        WHERE rfp LIKE '%$rfp%'
        
        UNION ALL 
        
        SELECT rfp FROM tblTelegraphicTransferHis
        WHERE rfp LIKE '%$rfp%'";


        $result = $this->db->query($query);

        return $result->result_array();
    }


}
