<?php
ob_start();

defined('BASEPATH') OR exit('No direct script access allowed');

class mainController extends CI_Controller {


	public function index()
	{   
        $question['data'] = $this->LoginModel->selectSecurityQuestion();


        $this->load->view('includes/header_limitless');
        //$this->load->view('includes/navbar_limitless');
		$this->load->view('tts_login', $question);
        // ]$this->load->view('includes/footer_limitless');
	}

    public function userCreation()
    {
        $user['users'] =      $this->userCreationModel->fetchUser();
        $user['testmodule'] = $this->userCreationModel->fetchModules1();
        $user['SRempUser'] = $this->userCreationModel->SelectSREmps();
        
        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('UserCreationView/userCreation', $user);
        $this->load->view('includes/footer_limitless');
    }

    public function userCreationSR()
    {
        $user['testmodule'] = $this->userCreationModel->fetchModules1();
        $user['SRempUser'] = $this->userCreationModel->SelectSREmps();
        
        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('UserCreationSRView/userCreationSR', $user);
        $this->load->view('includes/footer_limitless');
    }

    public function afterLogin()
    {
        if(!$this->session->userdata('empName'))
        {
            redirect(base_url().'mainController/login');
        }


        else
        {
            $this->load->view('includes/header_limitless');
            $this->load->view('includes/navbar_limitless');
            $this->load->view('home');
            $this->load->view('includes/footer_limitless');
        }
    }

    public function afterLoginSR()
    {
        if(!$this->session->userdata('username'))
        {
            redirect(base_url().'mainController/login');
        }

        else
        {
            $this->load->view('includes/header_limitless');
            $this->load->view('includes/navbar_limitless');
            $this->load->view('home');
            $this->load->view('includes/footer_limitless');
        }
    }

    public function logout()
    {    
        $this->session->sess_destroy();

        redirect(base_url());
    }

    public function vendor()
    {
        $vendor['vendor'] = $this->VendorModel->fetchVendor();
        $vendor['stat'] =   $this->VendorModel->fetchStatus();
        $vendor['Province'] = $this->VendorModel->fetchProvince();
        // $vendor['municipality'] = $this->VendorModel->fetchMunicipality();
        // $vendor['barangay'] = $this->VendorModel->fetchBarangay();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('vendorView/vendor', $vendor);
        $this->load->view('includes/footer_limitless');
    }

    public function vendorAccounts()
    {
        $vendorAccount['vendorCode'] =  $this->VendorAccountModel->fetchVendorCode();
        $vendorAccount['accountCode'] = $this->VendorAccountModel->fetchAccountCode();
        $vendorAccount['data'] =        $this->VendorAccountModel->fetchAccountsVendor();
        $vendorAccount['currency'] = $this->VendorAccountModel->fetchCurrency();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('vendorAccountView/vendorAccounts', $vendorAccount);
        $this->load->view('includes/footer_limitless');
    }

    public function bankInfo()
    {

        $bankInfo['bankInfo'] = $this->bankInformationModel->fetchBankInfo();
        $bankInfo['stat'] = $this->bankInformationModel->fetchStatus();
        $bankInfo['Province'] = $this->VendorModel->fetchProvince();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('bankInfoView/bankInfo', $bankInfo);
        $this->load->view('includes/footer_limitless');
    }

    public function accounts()
    {
        $account['bank'] = $this->accountsModel->fetchBankCode();
        $account['list'] = $this->accountsModel->fetchAccount();
        $account['stat'] = $this->accountsModel->fetchStatus();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('accountView/accounts', $account);
        $this->load->view('includes/footer_limitless');
    }

    public function paymentTerms()
    {
        $payment['payment'] = $this->paymentTermsModel->fetchPayment();
        $payment['stat'] =    $this->paymentTermsModel->fetchStatus();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('paymentTermsView/paymentTerms', $payment);
        $this->load->view('includes/footer_limitless');
    }

    public function telegraphicTerms()
    {   
        $telegraphic['vendorCode'] =$this->telegraphicTransferModel->fetchVendorCode();
        // $telegraphic['vendorCode'] = $this->telegraphicTransferModel->populateVendorNametoAccountCode();
        // $telegraphic['getValueAcc'] = $this->telegraphicTransferModel->getValueAcc();
        $telegraphic['AccCode'] =   $this->telegraphicTransferModel->fetchAccCode();
        $telegraphic['Company'] =   $this->telegraphicTransferModel->fetchCompany();
        $telegraphic['payment'] =   $this->telegraphicTransferModel->fetchPaymentTerms();
        $telegraphic['data'] =      $this->telegraphicTransferModel->fetchTTSdata();
        $telegraphic['otherTrans']  = $this->telegraphicTransferModel->fetchOtherTransactType();
        $telegraphic['deduc']   = $this->telegraphicTransferModel->fetchDeduction();
        $telegraphic['transact2'] = $this->telegraphicTransferModel->fetchTransaction2();
     

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('telegraphicTransferView/telegraphicTransfer', $telegraphic);
        $this->load->view('includes/footer_limitless');
    }

    public function claim()
    {
        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('claimView/claim');
        $this->load->view('includes/footer_limitless');
    }

    public function Reports()
    {   
        $report['vendorReport'] = $this->reportsModel->getVendorReports();
        $report['bankReport'] = $this->reportsModel->getBank();
        $report['CompPO'] = $this->reportsModel->selectCompanyPO();
        $report['vendorCode'] = $this->reportsModel->fetchVendorCode();
        $report['fetchCurrency'] = $this->reportsModel->fetchCurrency();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('reportView/report', $report);
        $this->load->view('includes/footer_limitless');
    }

    public function approvalVendor()
    {
        $approval['vendor'] = $this->approvalVendorModel->fetchVendorApproval();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('ApprovalVendorView/ApprovalVendor', $approval);
        $this->load->view('includes/footer_limitless'); 
    }

    public function approvalAccount()
    {
        $approval['list'] = $this->approvalAccountModel->fetchApprovalAccounts();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('ApprovalAccountView/approvalAccount', $approval);
        $this->load->view('includes/footer_limitless'); 
    }

    public function VAccount()
    {

        $approval['data'] = $this->approvalVendorAccountModel->fetchApprovalVendorAcc();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('ApprovalVendorAccountView/approvalVendorAccount', $approval);
        $this->load->view('includes/footer_limitless'); 
    }

    public function telegraphicTermsHistory()
    {   

        $history['data'] = $this->telegraphicTransferHistoryModel->fetchTTSDATAHistory();
        $history['otherTrans'] = $this->telegraphicTransferHistoryModel->fetchType();
        $history['deduc'] = $this->telegraphicTransferHistoryModel->fetchTransactType();
        $history['deduct_2'] = $this->telegraphicTransferHistoryModel->fetchTransaction2();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('TelegraphicTransferHistoryView/telegraphicTransferHistory', $history);
        $this->load->view('includes/footer_limitless');
    }

    public function telegraphicInvoices()
    {
        $invoice['vendorCode'] = $this->telegraphicInvoiceModel->fetchVendorCodeInvoice();
        $invoice['Company'] = $this->telegraphicInvoiceModel->fetchCompanyInvoice();
        $invoice['data'] =      $this->telegraphicInvoiceModel->fetchTTSInvoicedata();
        $invoice['otherTrans'] = $this->telegraphicInvoiceModel->fetchType();
        $invoice['deduc'] = $this->telegraphicInvoiceModel->fetchTransactType();
        $invoice['payment'] =   $this->telegraphicInvoiceModel->fetchPaymentTerms();
        $invoice['transact_2'] = $this->telegraphicInvoiceModel->selectOtherTransact();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('TelegraphicInvoiceView/telegraphicTransferInvoice', $invoice);
        $this->load->view('includes/footer_limitless');
    }

    public function telegraphicInvoiceHis()
    {
        $invoiceHist['data'] = $this->telegraphicInvoiceHisModel->fetchTTSInvoiceDataHistory();
        $invoiceHist['otherTrans'] = $this->telegraphicInvoiceHisModel->fetchType();
        $invoiceHist['deduc'] = $this->telegraphicInvoiceHisModel->fetchTransactType();
        $invoiceHist['transact_2'] = $this->telegraphicInvoiceHisModel->transact_2();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('TelegraphicInvoiceHisView/TelegraphicInvoiceHisView', $invoiceHist);
        $this->load->view('includes/footer_limitless');
    }

    public function AdjustmentDeductionReport()
    {   
        $report ['vendor'] = $this->adjustmentDeductionReportModel->selectVendor();
        $report['company'] = $this->adjustmentDeductionReportModel->selectCompany();
        $report['transaction'] = $this->adjustmentDeductionReportModel->selectTransactions();
        $report['currency'] = $this->adjustmentDeductionReportModel->selectCurrency();
        $report['transact_2'] = $this->adjustmentDeductionReportModel->selectTransact_2();
        $report['rfp']  = $this->adjustmentDeductionReportModel->fetchRFP();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('AdjustmentDeductionView/AdjustmentDeductionView', $report);
        $this->load->view('includes/footer_limitless');
    }


    public function adjustmentDeductionInvoice()
    {
        $otherPayment['company'] = $this->adjustmentDeductionReportInvoiceModel->selectCompany();
        $otherPayment['vendor'] = $this->adjustmentDeductionReportInvoiceModel->selectVendor();
        $otherPayment['transaction'] = $this->adjustmentDeductionReportInvoiceModel->selectTransactions();
        $otherPayment['currency'] = $this->adjustmentDeductionReportInvoiceModel->selectCurrency();

        $this->load->view('includes/header_limitless');
        $this->load->view('includes/navbar_limitless');
        $this->load->view('AdjustmentDeductionViewInvoice/AdjustmentDeductionInvoice', $otherPayment);
        $this->load->view('includes/footer_limitless');
    }


}
