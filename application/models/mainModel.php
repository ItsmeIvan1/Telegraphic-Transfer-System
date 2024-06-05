<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mainModel extends CI_Model {

    function getModules()
    {
        $this->db->where('tblRoles.roles', $this->session->userdata('roleMenu'));

		$result = $this->db->select('tblRoles.roles_desc');

		$query = $this->db->get('tblRoles');

		return $query->result_array();
    }

	function getMenus($ids)
	{
		$this->db->where('tblModules.hasSubMenu', 1);

		$this->db->where('tblModules.id IN ('.$ids.')');

		$query = $this->db->get('tblModules');

		return $query->result();
	}

    function getsubMenus($id,$ids)
	{
		$this->db->where('tblModules.hasSubMenu', 0);

		$this->db->where('tblModules.firstLvl', $id);

		$this->db->where('tblModules.id IN ('.$ids.')');

		$query = $this->db->get('tblModules');

		return $query->result();
	}

	function totalNumberOpenStatus()
	{
		$query = "SELECT COUNT(PONumber) AS PONumber FROM tblTelegraphicTransfer";
		$result = $this->db->query($query);
	
		// Fetch the 'PONumber' column value from the result
		$count = $result->row()->PONumber;
	
		return $count;
	}

	function totalNumberOpenStatusHis()
	{
		$query = "SELECT COUNT(PONumber) AS PONumber FROM tblTelegraphicTransferHis";
		$result = $this->db->query($query);
	
		// Fetch the 'PONumber' column value from the result
		$count = $result->row()->PONumber;
	
		return $count;
	}

	function totalNumberOpenStatusInvoice()
	{
		$query = "SELECT COUNT(InvoiceNumber) AS InvoiceNumber FROM tblTelegraphicTransferInvoice";
		$result = $this->db->query($query);
	
		// Fetch the 'PONumber' column value from the result
		$count = $result->row()->InvoiceNumber;
	
		return $count;
	}

	function totalNumberOpenStatusInvoiceHis()
	{
		$query = "SELECT COUNT(InvoiceNumber) AS InvoiceNumber FROM tblTelegraphicTransferInvoice_his";
		$result = $this->db->query($query);
	
		// Fetch the 'PONumber' column value from the result
		$count = $result->row()->InvoiceNumber;
	
		return $count;
	}
	
	function totalNumberPaymentTerms()
	{
		$query = "SELECT COUNT(paymentTermCode) AS paymentTermCode FROM tblPaymentTerms";
		
		$result = $this->db->query($query);

		return $result->row()->paymentTermCode;
	}

	function totalNumberBanks()
	{
		$query = "SELECT COUNT(bankCode) AS bankCode FROM tblBankInformation";

		$result = $this->db->query($query);

		return $result->row()->bankCode;
	}

	function totalNumberAccounts()
	{
		$query = "SELECT COUNT(accountCode) AS accountCode FROM tblAccounts";
		
		$result = $this->db->query($query);

		return $result->row()->accountCode;
	}

	function totalNumberVendors()
	{
		$query = "SELECT COUNT(vendorCode) AS vendorCode FROM tblVendor";

		$result = $this->db->query($query);

		return $result->row()->vendorCode;

	}

	function totalVendorAccounts()
	{
		$query = "SELECT COUNT(vendorAccountCode) AS vendorAccountCode FROM tblVendorAccount";

		$result = $this->db->query($query);

		return $result->row()->vendorAccountCode;
	}
	

	

}
