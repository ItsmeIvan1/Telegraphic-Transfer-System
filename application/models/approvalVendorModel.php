<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class approvalVendorModel extends CI_Model {

function fetchVendorApproval()
{
    $query = "SELECT a.*, b.provinceName, c.municipalityName, d.barangayName, e.stats, f.approval_stats FROM tblVendor AS a
    LEFT JOIN tblprovince AS b ON a.province = b.provinceCode
    LEFT JOIN tblmunicipality AS c ON a.municipality = c.municipalityCode
    LEFT JOIN tblbarangay AS d ON a.baranggay = barangayCode
    LEFT JOIN tblStatus AS e ON a.vendorStatus = e.status_id
    LEFT JOIN tblApprovalStats AS f ON a.vendor_approval_status = f.approval_id";

    $result = $this->db->query($query);

    return $result->result_array();
}

function updateVendorApproval($vendorCode)
{
    $query = "UPDATE tblVendor SET vendor_approval_status = 1 WHERE vendorCode = '$vendorCode'";

    $result = $this->db->query($query);

    return $result;
}

function disableVendorApproval($vendorCode)
{
    $query = "UPDATE tblVendor SET vendor_approval_status = 2 WHERE vendorCode = '$vendorCode'";

    $result = $this->db->query($query);

    return $result;
}


 }