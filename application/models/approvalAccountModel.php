<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class approvalAccountModel extends CI_Model {

    function fetchApprovalAccounts()
    {
        $query = "SELECT a.*, b.bankName, c.stats, d.approval_stats
        FROM tblAccounts AS a
        INNER JOIN tblBankInformation AS b ON a.bankCode = b.bankCode
        INNER JOIN tblStatus AS c ON a.status = c.status_id
        LEFT JOIN tblApprovalStats AS d ON a.account_approval_status = d.approval_id";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function updateDisapproved($accountCode)
    {
        $query ="UPDATE tblAccounts SET account_approval_status = 1 WHERE accountCode = '$accountCode'";

        $result = $this->db->query($query);

        return $result;

    }

    function disApprovedUpdate($accountCode)
    {
        $query ="UPDATE tblAccounts SET account_approval_status = 2 WHERE accountCode = '$accountCode'";

        $result = $this->db->query($query);

        return $result;

    }

    
}
