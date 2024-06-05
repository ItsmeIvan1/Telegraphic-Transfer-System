<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class bankInformationModel extends CI_Model {

    function insertBankInfoData($vendorID)
    {
        return $this->db->insert('tblBankInformation', $vendorID);
    }

    function fetchBankInfo()
    {   
        $query = "SELECT a.*, b.stats FROM tblBankInformation AS a
        INNER JOIN tblStatus AS b ON a.bankStatus = b.status_id";

        $query1 = "SELECT a.bankCode,
                          a.bankName,
                          a.bank_number,
                          a.bankAddress2,
                          a.bankAddress1,
                          b.provinceName, 
                          c.municipalityName, 
                          d.barangayName, 
                          e.stats, 
                          a.userCreated,
                          a.dateCreated,
                          a.bankStatus FROM tblBankInformation AS a
        LEFT JOIN tblprovince AS b ON a.bankProvince = b.provinceCode
        LEFT JOIN tblmunicipality AS c ON a.bankMunicipality = c.municipalityCode
        LEFT JOIN tblbarangay AS d ON a.bankAddress = d.barangayCode
        LEFT JOIN tblStatus AS e ON a.bankStatus = e.status_id";
        
        $result = $this->db->query($query1);

        return $result->result_array();  
    }

    function disableBankInfo($bankInfo)
    {
        $query = "UPDATE tblBankInformation SET bankStatus = 2 WHERE bankCode='$bankInfo'";
        $result = $this->db->query($query);
        
        return $result;
    }

    function retrieveBankInfo($bankInfo)
    {
        $query = "UPDATE tblBankInformation SET bankStatus = 1 WHERE bankCode='$bankInfo'";
        $result = $this->db->query($query);
        
        return $result;
    }

    function fetchBankInfoModal($bankInfo)
    {
        $query = "SELECT * FROM tblBankInformation WHERE bankCode='$bankInfo'";

        $query1 = "SELECT a.*,
                b.provinceName, 
                c.municipalityName, 
                d.barangayName, 
                e.stats
                FROM tblBankInformation AS a
                LEFT JOIN tblprovince AS b ON a.bankProvince = b.provinceCode
                LEFT JOIN tblmunicipality AS c ON a.bankMunicipality = c.municipalityCode
                LEFT JOIN tblbarangay AS d ON a.bankAddress = d.barangayCode
                LEFT JOIN tblStatus AS e ON a.bankStatus = e.status_id
                WHERE a.bankCode = '$bankInfo'";


        $result = $this->db->query($query1);

        return $result->row();
    }

    function updateBankInformation($bankCode, $tblBankInformation)
    {
                $this->db->where('bankCode', $bankCode);
       $query = $this->db->update('tblBankInformation', $tblBankInformation);

       return $query;
    }

    function checkbankNameifExist($bankName)
    {
        $query = "SELECT bankName FROM tblBankInformation WHERE bankName='$bankName'";
        $result = $this->db->query($query);

        if($result->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function fetchStatus()
    {
        $query = "SELECT * FROM tblStatus";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchProvince()
    {
        $query = "SELECT * FROM tblprovince";
        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchMunicipalityBasedOnProvince($provinceCode)
    {
        $query = "SELECT b.municipalityCode, b.municipalityName FROM tblprovince AS a
        LEFT JOIN tblmunicipality AS b ON a.provinceCode = b.provinceCode
        WHERE a.provinceCode = '$provinceCode'";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    function fetchBarangayBasedOnMunicipality($municipalityCode)
    {
        $query = "SELECT b.barangayCode, b.barangayName FROM tblmunicipality AS a
        LEFT JOIN tblbarangay AS b ON a.municipalityCode = b.municipalityCode
        WHERE a.municipalityCode = '$municipalityCode'";

        $result = $this->db->query($query);
        
        return $result->result_array();
    }

    function generateBankInfo()
    {
        $query = "SELECT 
                a.vendorAccountCode,
                b.vendorName,
                b.vendorAddress2, 
                b.country,
                d.bank_number, 
                d.bankName,
                d.bankAddress2,
                c.swiftCode,
                e.currency,
                c.ibanNo,
                c.abaNo,
                c.routingNo, 
                c.cifNo,
                c.bsbNo,
                c.intermediaryBank,
                c.interbankAddress,
                c.number,
                c.swift,
                c.aba,
                c.chips
                FROM tblVendorAccount AS a
                LEFT JOIN tblVendor AS b ON a.vendorCode = b.vendorCode
                LEFT JOIN tblAccounts AS c ON a.accountCode = c.accountCode
                LEFT JOIN tblBankInformation AS d ON c.bankCode = d.bankCode
                LEFT JOIN tblCurrency AS e ON a.account_currency = e.currency_id";
        
        $result = $this->db->query($query);

        return $result->result_array();
    }
    


}
