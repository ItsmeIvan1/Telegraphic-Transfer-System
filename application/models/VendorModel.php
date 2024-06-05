<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VendorModel extends CI_Model {

    function insertVendorData($vendorID)
    {
        return $this->db->insert('tblVendor', $vendorID);
    }

    function fetchVendor()
    {   
        $query = "SELECT a.*, b.stats FROM tblVendor AS a
        INNER JOIN tblStatus AS b ON a.vendorStatus = b.status_id";

        $query1 = "SELECT a.*, b.provinceName, c.municipalityName, d.barangayName, e.stats, f.approval_stats FROM tblVendor AS a
        LEFT JOIN tblprovince AS b ON a.province = b.provinceCode
        LEFT JOIN tblmunicipality AS c ON a.municipality = c.municipalityCode
        LEFT JOIN tblbarangay AS d ON a.baranggay = barangayCode
        LEFT JOIN tblStatus AS e ON a.vendorStatus = e.status_id
        LEFT JOIN tblApprovalStats AS f ON a.vendor_approval_status = f.approval_id";

        $result = $this->db->query($query1);

        return $result->result_array();  
    }

    function disableVendor($vendorCode)
    {
        $query = "UPDATE tblVendor SET vendorStatus='2' WHERE vendorCode='$vendorCode'";
        $result = $this->db->query($query);
        
        return $result;
    }

    function retrieveVendor($vendorCode)
    {
        $query = "UPDATE tblVendor SET vendorStatus='1' WHERE vendorCode='$vendorCode'";
        $result = $this->db->query($query);
        
        return $result;
    }

    function fetchVendorInModal($vendorCode)
    {
        $query = "SELECT * FROM tblVendor WHERE vendorCode='$vendorCode'";

        $query1 = "SELECT a.*, b.provinceName, c.municipalityName, d.barangayName, e.stats 
        FROM tblVendor AS a
        LEFT JOIN tblprovince AS b ON a.province = b.provinceCode
        LEFT JOIN tblmunicipality AS c ON a.municipality = c.municipalityCode
        LEFT JOIN tblbarangay AS d ON a.baranggay = barangayCode
        LEFT JOIN tblStatus AS e ON a.vendorStatus = e.status_id
        WHERE a.vendorCode = '$vendorCode'";

        $result = $this->db->query($query1);

        return $result->row();
    }

    function updateVendor($vendorCode, $tblVendor)
    {
       $this->db->where('vendorCode', $vendorCode);
       $query = $this->db->update('tblVendor', $tblVendor);

       return $query;
    }

    function checkVendorifExist($vendorName)
    {
        $query = "SELECT vendorName FROM tblVendor WHERE vendorName='$vendorName'";
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

    
    

}
