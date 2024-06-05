<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class approvalVendorAccountModel extends CI_Model {


    function fetchApprovalVendorAcc()
    {
        $query = "SELECT a.vendorAccountCode, b.vendorName, c.accountNumber, d.currency, e.stats, a.status, a.approval_status, f.approval_stats FROM tblVendorAccount AS a
        INNER JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
        INNER JOIN tblAccounts AS c ON a.accountCode = c.accountCode
        INNER JOIN tblCurrency AS d ON a.account_currency = d.currency_id
        INNER JOIN tblStatus AS e ON a.status = e.status_id
        LEFT JOIN tblApprovalStats AS f ON a.approval_status = f.approval_id";

        $result = $this->db->query($query);

        return $result->result_array();
    }


    function approveApprovalVendorAcc($vendorAccountCode)
    {
        $query ="UPDATE tblVendorAccount SET approval_status='1' WHERE vendorAccountCode='$vendorAccountCode'";
        $result = $this->db->query($query);

        return $result;
    }

    function disapproveApprovalVendorAcc($vendorAccountCode)
    {
        $query ="UPDATE tblVendorAccount SET approval_status='2' WHERE vendorAccountCode='$vendorAccountCode'";
        $result = $this->db->query($query);

        return $result;
    }
}