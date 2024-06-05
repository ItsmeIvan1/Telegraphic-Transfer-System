<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class accountsModel extends CI_Model {

    function fetchBankCode()
    {
        $query = "SELECT bankCode, bankName, bankAddress2, bankStatus FROM tblBankInformation WHERE bankStatus = 1 ";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function insertAccount($tblAccounts)
    {
        return $this->db->insert('tblAccounts', $tblAccounts);
    }

    function checkAccountIfExistDB($accountNumber)
    {
        $query = "SELECT accountNumber FROM tblAccounts WHERE accountNumber = '$accountNumber'";
        $result = $this->db->query($query);

        return $result->row_array();
    }

    function fetchAccount()
    {
        // $query = "SELECT a.*, b.bankName, c.stats, d.approval_stats
        //         FROM tblAccounts AS a
        //         INNER JOIN tblBankInformation AS b ON a.bankCode = b.bankCode
        //         INNER JOIN tblStatus AS c ON a.status = c.status_id
        //         LEFT JOIN tblApprovalStats AS d ON a.account_approval_status = d.approval_id
        //         ";

        $query = "SELECT a.*, b.bankName, c.stats, d.approval_stats
        FROM tblAccounts AS a
        LEFT JOIN tblBankInformation AS b ON a.bankCode = b.bankCode
        INNER JOIN tblStatus AS c ON a.status = c.status_id
        LEFT JOIN tblApprovalStats AS d ON a.account_approval_status = d.approval_id
        ";       
        // echo $query;
        // exit();

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchStatus()
    {
        $query = "SELECT * FROM tblStatus";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function disableAccountModel($accountCode)
    {
        $query = "UPDATE tblAccounts SET status = 2 WHERE accountCode = '$accountCode'";
        $result = $this->db->query($query);

        return $result;
    }

    function retrieveAccountModel($accountCode)
    {
        $query = "UPDATE tblAccounts SET status = 1 WHERE accountCode = '$accountCode'";
        $result = $this->db->query($query);

        return $result;
    }

    function retrievedAccountMode($accountCode)
    {
        $query = "UPDATE tblAccounts SET status = 1 WHERE accountCode = '$accountCode'";
        $result = $this->db->query($query);

        return $result;
    }

    function fetchDataInModal($accCode)
    {
        $query = "SELECT a.*, b.bankName, c.stats
        FROM tblAccounts AS a
        LEFT JOIN tblBankInformation AS b ON a.bankCode = b.bankCode
        INNER JOIN tblStatus AS c ON a.status = c.status_id
        WHERE a.accountCode = '$accCode'";
        
        $result = $this->db->query($query);

        return $result->row_array();
    }

    function updateAccount($accountCode, $tblAccounts)
    {
        $this->db->where('accountCode', $accountCode);
        $result = $this->db->update('tblAccounts', $tblAccounts);

        return $result;
    }

}
