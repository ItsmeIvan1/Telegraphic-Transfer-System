<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VendorAccountModel extends CI_Model {

    function fetchVendorCode()
    {
        $query ="SELECT vendorCode, vendorName, vendorStatus FROM tblVendor WHERE vendorStatus = 1 AND vendor_approval_status = 1";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchAccountCode()
    {
        $query = "SELECT accountCode, accountNumber, status FROM tblAccounts WHERE status = 1 AND account_approval_status = 1";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function insertVendorAccount($id)
    {
        return $this->db->insert('tblVendorAccount', $id);
    }

    function checkIfExistingInDB($vendorCode, $accountCode, $account_currency)
    {
        $query = "SELECT vendorCode, accountCode, account_currency FROM tblVendorAccount
        WHERE vendorCode = '$vendorCode' AND accountCode = '$accountCode' AND account_currency = '$account_currency'";

        $result = $this->db->query($query);

        return $result->row_array();
    }
    
    function fetchAccountsVendor()
    {

        $query1 = "SELECT a.*, b.vendorName, c.accountNumber, d.currency FROM tblVendorAccount AS a
                INNER JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
				INNER JOIN tblAccounts AS c ON a.accountCode = c.accountCode
				INNER JOIN tblCurrency AS d ON a.account_currency = d.currency_id";

        $query2 = "SELECT a.vendorAccountCode, b.vendorName, c.accountNumber, d.currency, e.stats, a.status, a.approval_status, f.approval_stats FROM tblVendorAccount AS a
                INNER JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
				INNER JOIN tblAccounts AS c ON a.accountCode = c.accountCode
				INNER JOIN tblCurrency AS d ON a.account_currency = d.currency_id
                INNER JOIN tblStatus AS e ON a.status = e.status_id
                LEFT JOIN tblApprovalStats AS f ON a.approval_status = f.approval_id";        

        $result = $this->db->query($query2);

        return $result->result_array();
    }

    function fetchVendorAccInModal($vendorAccountCode)
    {
        $query = "SELECT a.*, b.vendorName, c.accountNumber, d.currency FROM tblVendorAccount AS a
        INNER JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        INNER JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        INNER JOIN tblCurrency AS d ON a.account_currency = d.currency_id
        WHERE a.vendorAccountCode = '$vendorAccountCode'";

        $result = $this->db->query($query);

        return $result->row_array();
    }

    function updateAccountsVendor($vendorAccountCode, $tblVendorAccount)
    {
        $this->db->where('vendorAccountCode', $vendorAccountCode);
        
        return $this->db->update('tblVendorAccount', $tblVendorAccount);
    }

    function fetchCurrency()
    {
        $query ="SELECT * FROM tblCurrency";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function disabledVendorAcc($vendorAccountCode)
    {
        $query = "UPDATE TblVendorAccount SET status = '2' WHERE vendorAccountCode = '$vendorAccountCode'";
        $result = $this->db->query($query);

        return $result;

    }

    function retrieveVendorAcc($vendorAccountCode)
    {
        $query ="UPDATE tblVendorAccount SET status='1' WHERE vendorAccountCode='$vendorAccountCode'";
        $result = $this->db->query($query);

        return $result;
    }

}
