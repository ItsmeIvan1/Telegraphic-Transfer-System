<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class paymentTermsModel extends CI_Model {


    //Inserting to the database
 function addPaymentTerms($tblPaymentTerms)
 {
    return $this->db->insert('tblPaymentTerms', $tblPaymentTerms);
 }
 
   //checking if the payment name is existing in the database
 function checkPaymentIfExisting($paymentName)
 {
    $query = "SELECT paymentName FROM tblPaymentTerms WHERE paymentName = '$paymentName'";
    
    $result = $this->db->query($query);

    return $result->row_array();
 }

 //populate the data from the database
 function fetchPayment()
 {
    $query = "SELECT a.*, b.stats FROM tblPaymentTerms AS a
              INNER JOIN tblStatus AS b ON a.paymentStatus = b.status_id";

    $result = $this->db->query($query);

    return $result->result_array();
 }

 //disable payment 
 function disabledPayment($paymentTermCode)
 {
    $query = "UPDATE tblPaymentTerms SET paymentStatus = 2 WHERE paymentTermCode = '$paymentTermCode'";

    $result = $this->db->query($query);

    return $result;
 }

 //retrieve payment 
 function retrievePayment($paymentTermCode)
 {
    $query = "UPDATE tblPaymentTerms SET paymentStatus = 1 WHERE paymentTermCode = '$paymentTermCode'";

    $result = $this->db->query($query);

    return $result;
 }

//  function fetchPaymentModal($paymentTermCode)
//  {
//     $query = "SELECT a.*, b.stats
//      FROM tblPaymentTerms AS a
//     INNER JOIN tblStatus AS b 
//     ON a.stats = b.status_id 
//     WHERE a.stats = 1 AND a.paymentTermCode='$paymentTermCode'";

//     $result = $this->db->query($query);

//     return $result->row_array();

//  }
//fetching status to create
 function fetchStatus()
 {
    $query = "SELECT * FROM tblStatus";
    $result = $this->db->query($query);

    return $result->result_array();
 }

 function fetchpaymentData($paymentTermCode)
 {
    $query = "SELECT * FROM tblPaymentTerms WHERE paymentTermCode ='$paymentTermCode'";
    $result = $this->db->query($query);

    return $result->row_array();
 }

 function updatePaymentInModal($paymentTermCode, $tblPaymentTerms)
 {
    $this->db->where('paymentTermCode', $paymentTermCode);
    return $this->db->update('tblPaymentTerms', $tblPaymentTerms);
 }

}
