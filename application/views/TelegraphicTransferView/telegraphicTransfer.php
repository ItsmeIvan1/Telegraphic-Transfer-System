

	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Telegraphic Transfer PO</h4>
			</div>

			<div class="heading-elements">
				<div class="heading-btn-group">
				</div>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="<?php echo base_url();?>mainController/afterLogin"><i class="icon-home2 position-left"></i> Home</a></li>
				<li class="active">Telegraphic Transfer</li>
			</ul>

			<ul class="breadcrumb-elements">
			
			</ul>
		</div>
	</div>


	
	<div class="content">
		
		<div style="padding-bottom: 10px; display: flex;">
			<div>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form_vertical"><i class="icon-spinner9 position-left"></i>Process </button>	
				<!-- <button type="button" class="btn btn-success" id="ExcelBtn"><i class="icon-user-plus position-left"></i>Generate Excel</button>	 -->
			</div>
			
			<!-- <form id="uploadForm" enctype="multipart/form-data">
				<div style="margin-left: 10px;">
						<input type="file" class="file-styled" name="userfile" id="userfile">
						<button type="button" class="btn btn-primary" id="uploadFile">Upload</button>
				</div>
			</form> -->

			<!-- <form id="readFile" enctype="multipart/form-data">
				<div style="margin-left: 10px;">
						<input type="file" class="file-styled" name="userfile" id="userfile" accept=".xls">
						<button type="button" class="btn btn-success" id="uploadExcelBtn">Upload Excel</button>
				</div>
			</form> -->
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-flat">
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table datatable-basic" id="homeTable"> 
												<thead>
													<tr class="bg-success">

													<th>Vendor</th>
													<th>Account</th>  
													<th>Company</th>  
													<th>PO No.</th>
													<th>PO Date</th>
													<th>Currency</th>
													<th>Amount</th>
													<!-- <th>Proforma invoice</th>
													<th>Commercial invoice</th>
													<th>RFP reference</th> -->
													<th>Payment</th>
													<!-- <th>Final invoice</th>
													<th>Credit note</th>
													<th>Debit note</th>
													<th>Wire transfer fee</th> -->
													<th>Remarks</th>
													<th>Status</th>
													
													<th class="text-center">Action</th>
													
													</tr>
												</thead>
												<tbody>

													<?php foreach($data as $datas){ ?>  
													<tr>
													<td><?php echo $datas['vendorName']  ?></td>
													<td><?php echo $datas['accountNumber'] ?></td>
													<td><?php echo $datas['company_name'] ?></td>
													<td><?php echo $datas['PONumber'] ?></td>
													<td><?php echo $datas['PODate'] ?></td>
													<td><?php echo $datas['currency'] ?></td>
													<td><?php echo $datas['POAmount'] ?></td>
													<td><?php echo $datas['paymentName'] ?></td>
													<!-- <td><?php echo $datas['proformaInvoice'] ?></td>
													<td><?php echo $datas['commercialInvoice'] ?></td>
													<td><?php echo $datas['rfpReference'] ?></td> -->
													<!-- <td><?php echo $datas['finalInvoice'] ?></td>
													<td><?php echo $datas['creditNote'] ?></td>
													<td><?php echo $datas['debitNote'] ?></td>
													<td><?php echo $datas['wireTransferFee'] ?></td> -->
													<td><?php echo $datas['remarks'] ?></td> 
													<td><span class="label label-success"><?php echo $datas['tts_stats'] ?></span></td>
													<td class="text-center">
														<ul class="icons-list">
															<li class="dropdown">
																<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																	<i class="icon-menu9"></i>
																</a>

																<ul class="dropdown-menu dropdown-menu-right">
																	<?php if ($datas ['accountCurrency'] == 1){ ?>
																	<li>
																		<a href="" class="" onclick="InitialPaymentFunction('<?php echo $datas['PONumber']; ?>', '<?php echo $datas['vendorCode']; ?>')"
																			 data-toggle="modal" data-target="#modalInitialPaymentDetails"><i class="icon icon-cash position-left"></i>Pay</a>
																	</li>																
																	<?php } else { ?>
																	<li>
																		<a href="" class="" onclick=FullPaymentFunction('<?php echo $datas['PONumber'] ?>') data-toggle="modal" data-target="#modalFullpayment"><i class="icon icon-cash position-left"></i>Pay</a>
																	</li>													
																	<?php } ?>
																</ul>
															</li>
														</ul>
													
													</td>
													</tr>
													<?php } ?>

												</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<!-- modal for adding  -->
	<div id="modal_form_vertical" class="modal fade in" tabindex="-1" data-backdrop="static">
				<div class="modal-dialog modal-full">
					<div class="modal-content">
						<div class="modal-header bg-primary">
							<button type="button" class="close" data-dismiss="modal" id="xBtnAdd">×</button>
							<h5 class="modal-title">Telegraphic transfer / PO</h5>
						</div>

						<form id="frmTelegraphicTransfer">
							<div class="modal-body">
								<div class="form-group">
									<div class="row" style="padding-bottom: 10px;">
										<div class="col-md-4">
											<div class="col-sm-12" style="padding-bottom: 12px;">
												<label>Vendor name <span style='color:red;'>*</span></label>
												<!-- <select class="form-control" name="vendorCode" id="vendorCode">
													<option value="">Select vendor name</option>
													<?php foreach($vendorCode as $vendorCodes){ ?>
													<option value="<?php echo $vendorCodes['vendorCode'] ?>"><?php echo $vendorCodes['vendorName'] ?></option>
													<?php } ?>
												</select> -->

												<select class="form-control" name="vendorCode" id="vendorCode">
													<option value="">Select vendor</option>

													<?php foreach($vendorCode as $vendorCodes){ ?>
													<option value="<?php echo $vendorCodes['vendorCode'] ?>"><?php echo $vendorCodes['vendorName'] ?></option>
													<?php } ?>
												</select>
											</div>

											<div class="col-sm-12" >
												<label>Account code <span style='color:red;'>*</span></label>
													<!-- <select class="form-control" name="accCode" id="accCode">
													<option value="">Select account code</option>
													<?php foreach($AccCode as $AccCodes){ ?>
													<option value="<?php echo $AccCodes['accountCode'] ?>"><?php echo $AccCodes['accountNumber'] ?></option>
													<?php }?>
													</select> -->

													<select class="form-control" name="accCode" id="accCode">
														<!-- <option value="" >Select account</option> -->
													</select>

											</div>

											<!-- <div class="col-sm-6" style="padding-top: 5px;">
												<label>Payment terms <span style='color:red;'>*</span></label>
												<input class="form-control" name="accCurrency" id="accCurrency">
												<select class="form-control" name="accCurrency" id="accCurrency">
													<option value="">Select payment terms</option>
													<?php foreach($payment as $payments){ ?>
													<option value="<?php echo $payments['paymentTermCode'] ?>"><?php echo $payments['paymentName'] ?></option>
													<?php } ?>
												</select>
											</div> -->
											<div class="col-sm-12" style="padding-top: 5px;">
												<label>Company <span style='color:red;'>*</span></label>
												<!-- <input class="form-control" name="CompanyCode" id="CompanyCode"> -->
												<select class="form-control"  name="CompanyCode" id="CompanyCode" >
													<option value="">Select company</option>
													<?php foreach($Company as $Companys){ ?>
													<option value="<?php echo $Companys['company_id'] ?>"><?php echo $Companys['company_name'] ?></option>
													<?php }?>

												</select>
											</div>
											
											<div class="col-sm-12" style="padding-top: 5px;">
												<label>PO number <span style='color:red;'>*</span></label>
												<input type="text" class="form-control" name="PONumber" id="PONumber">				
											</div>

											<div class="col-sm-12" style="padding-top: 5px;">
												<label>PO date <span style='color:red;'>*</span></label>
												<!-- <input type="text" class="form-control daterange-buttons" value="03/18/2013 - 03/23/2013">
												<div class="form-group">
													<label>Display time picker: </label>
													<div class="input-group">
														<span class="input-group-addon"><i class="icon-calendar22"></i></span>
														<input type="text" class="form-control daterange-time" value="03/18/2013 - 03/23/2013"> 
													</div>
												</div> -->
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar22"></i></span>
													<input type="text" placeholder="Select date" class="form-control pickadate-accessibility picker__input" name="PODate" id="PODate">
												</div>

												
											</div>
											
											<div class="col-sm-12" style="padding-top: 5px;">
												<label>PO amount <span style='color:red;'>*</span></label>
												<input class="form-control" name="POAmount" id="POAmount">
											</div>

											<div class="col-sm-12" style="padding-top: 5px;">
												<label>Proforma invoice </label>
												<input class="form-control" name="ProformaInvoice" id="ProformaInvoice" >
											</div>
											<!-- <div class="col-sm-6" style="padding-top: 5px;">
												<label>Commercial invoice </label>
												<input type="text" class="form-control" name="CommercialInvoice" id="CommercialInvoice" >
												
											</div>	 -->
											
											<!-- <div class="col-sm-6" style="padding-top: 5px;">
												<label>RFP reference </label>
												<input type="text" class="form-control" name="RFPreference" id="RFPreference">
											</div> -->
											
											<div class="col-sm-12" style="padding-top: 5px;">
												<label>Final invoice </label>
												<input class="form-control" name="FinalInvoice" id="FinalInvoice" >
											</div>

											<div class="col-sm-12" style="padding-top: 5px;">
												<label>Remarks </label>
												<input class="form-control" name="remarks" id="remarksInitial" >
											</div>

											<div class="col-sm-12" style="padding-top: 5px;">
												<label>RFP  <span style='color:red;'>*</span></label>
												<input class="form-control" name="rfp" id="rfp" >
											</div>




											<!-- <div class="col-sm-3" style="padding-top: 5px;">
												<label>Credit note </label>
												<input type="text" class="form-control" name="CreditNote" id="CreditNote" >
											</div>

											<div class="col-sm-3" style="padding-top: 5px;">
												<label>Debit note </label>
												<input class="form-control" name="DebitNote" id="DebitNote" >
											</div>

											<div class="col-sm-3" style="padding-top: 5px;">
												<label>Wire transfer fee </label>
												<input class="form-control" name="WireTransferFee" id="WireTransferFee" >
											</div> -->
											
										</div>

										<div class="col-md-8">
											<div style="padding-bottom: 2px;"  id="formBtnPayment">
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalpayment" id="btnAddPayment">Add payment</button>
											</div>
											
											<!-- Initial payment -->
											<div class="panel panel-flat" id="paymentForm">
												<div class="panel-heading">
													<h6 class="panel-title" style="font-weight: bold;">Payment history</h6>
												</div>

												<div class="panel-body">
													<table class="table datatable-basic" id="PaymentTable">
															<thead>
																<tr>
																	<th>PO #</th>
																	<th>PO amount</th>
																	<th>Payment type</th>
																	<th>Date created</th>
																	<th>Remarks</th>
																	<th>RFP</th>
																
																
																</tr>
															</thead>
															<tbody>
																<tr>
															
																	<td id="first"></td>
																	<td id="second"></td>
																	<td id="third"></td>
																	<td id="fourth"></td>
																	<td id="sixth"></td>
																	<td id="fifth"></td>
																	
																	
																	
																</tr>
															</tbody>
													</table>

														<div style="padding-top: 10px;">

															<p id="remainingBalance" style="font-weight: bold;"></p>
															<p id="totalPayment" style="font-weight: bold;"></p>
															
														 	<!-- <p id="change" style="font-weight: bold;"></p>	 -->
														</div>

												</div>
											</div>
											
											<!-- other payment po related -->
											<div style="padding-bottom: 2px;"  id="formBtnOther">
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalOtherpayment" id="btnOtherTransact">PO Related</button>
											</div>
											
											<div class="panel panel-flat" id="adjustmentForm" >
		
												<div class="panel-heading">
													<h6 class="panel-title" style="font-weight: bold;">PO Related History</h6>
												</div>
												<div class="panel-body">
													<table class="table datatable-basic" id="PaymentTable">
															<thead>
																<tr>
																	<th>PO #</th>
																	<th>Type</th>	
																	<th>Transaction type</th>
																	<th>Reference no.</th>
																	<th>Date created</th>
																	<th>Remarks</th>
																	<th>RFP</th>
																
																
																</tr>
															</thead>
															<tbody>
																<tr>
															
																	<td id="otherFirst"></td>
																	<td id="otherSecond"></td>
																	<td id="otherThird"></td>
																	<td id="otherFourth"></td>
																	<td id="otherFifth"></td>
																	<td id="otherSixth"></td>
																	<td id="otherSeventh"></td>
																	
																	
																	
																</tr>
															</tbody>
													</table>

														<div style="padding-top: 10px;">
															<p id="OtherRemainBalance" style="font-weight: bold;"></p>
															<p id="transAmt" style="font-weight: bold;"></p>
													
							
														</div>

												</div>
											</div>

											<!-- other payment non po related -->
											<div style="padding-bottom: 2px;"  id="formBtnOtherNonPo">
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalOtherpaymentNonPO" id="btnOtherTransactNONPO">Non PO Related</button>
											</div>

											<div class="panel panel-flat" id="adjustmentFormNonPO" >
												<div class="panel-heading">
													<h6 class="panel-title" style="font-weight: bold;">NON-PO Related History</h6>
												</div>

												<div class="panel-body">
													<table class="table datatable-basic" id="PaymentTableNonPO">
															<thead>
																<tr>
																	<th>Date</th>
																	<th>Type</th>
																	<th>Transaction type</th>
																	<th>Reference no.</th>
																	<th>Amount</th>
																	<th>Remarks</th>
																	<th>RFP</th>
																</tr>
															</thead>
															<tbody>
																<tr>
															
																	<td id="otherFirstNonPO"></td>
																	<td id="otherSecondNonPO"></td>
																	<td id="otherThirdNonPO"></td>
																	<td id="otherFourthNonPO"></td>
																	<td id="otherFourthNNonPO"></td>
																	<td id="otherFifthNonPO"></td>
																	<td id="otherSixthNonPO"></td>
																	
																	
																	
																</tr>
															</tbody>
													</table>

														<div style="">
															<p id="transAmtNonPO" style="font-weight: bold;"></p>
															<p id="OtherRemainBalanceNonPO" style="font-weight: bold;"></p>
														</div>

												</div>
											</div>
																				
										</div>
									</div>			
								</div>
							</div>
						</form>

				<div class="modal-footer" id="mdlfooter">
					<button type="button" class="btn btn-warning" data-dismiss="modal" id="btnCloseTTS" style="display: none;">Close</button>
					<button type="button" class="btn btn-success" id="addTelegraphicTransferBtn">Process</button>
				</div>
			</div>
		</div>
	</div>	

	<!-- modal for updating -->


	<!-- modal for payment -->
	<div id="modalpayment" class="modal fade" tabindex="-1" data-backdrop="static">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h5 class="modal-title">Payment</h5>
								</div>

								<div class="modal-body">
									<div class="row">
										<div class="col-md-12">
											<!-- <input type="text" id="telcode"> -->
											<label>Vendor</label>
											
											<select class="form-control" id="VendorPayment" disabled>
												<?php foreach($vendorCode as $vendor){ ?>
												<option value="<?php echo $vendor['vendorCode'] ?>"><?php echo $vendor['vendorName'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12">
											<label>PO #</label>
											<input type="text" class="form-control" id="PaymentPO" readonly>
										</div>
										<!-- <div class="col-md-12"> -->
											
											<input type="hidden" class="form-control" id="paymentDate" readonly>
										<!-- </div> -->
										<div class="col-md-12">
											<label>Date</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar22"></i></span>
												<input type="text" placeholder="Select date" class="form-control pickadate-accessibility picker__input" name="InitialDate" id="InitialDate">
											</div>
										</div>
		
										<div class="col-md-12">
											<label>PO amount</label>
											<input type="text" class="form-control" id="PaymentPOAmount" readonly>
										</div>
										<!-- <div class="col-md-12">
											<label>Total payment</label>
											<input type="text" class="form-control">
										</div> -->
										<!-- <div class="col-md-12">
											<label>Remaining balance</label>
											<input type="text" class="form-control">
										</div> -->
										
										<!-- <div class="col-md-12">
											<label>Payment type</label>
											<select class="form-control" readonly id="paymentTypePay" disabled>
												<?php foreach($payment as $payments){ ?>
													<option value="<?php echo $payments['paymentTermCode'] ?>"><?php echo $payments['paymentName'] ?></option>
													<?php } ?>
											</select>
										</div> -->
										
										<input type="hidden" name="PaymentAccountCode" id="PaymentAccountCode">
										<input type="hidden" name="PaymentCurrency" id="PaymentCurrency">
										<input type="hidden" name="PaymentProformaInvoice" id="PaymentProformaInvoice">
										<input type="hidden" name="PaymentCommercialInvoice" id="PaymentCommercialInvoice">
										<input type="hidden" name="PaymentrfpReferrence" id="PaymentrfpReferrence">
										<input type="hidden" name="PaymentCompCode" id="PaymentCompCode">
										<input type="hidden" name="PaymentFinalInvoice" id="PaymentFinalInvoice">
										<input type="hidden" name="PaymentCreditNote" id="PaymentCreditNote">
										<input type="hidden" name="PaymentdebitNote" id="PaymentdebitNote">
										<input type="hidden" name="PaymentWireTransferFee" id="PaymentWireTransferFee">



										<div class="col-md-12">
											<label>Amount <span style="color: red;">*</span></label>
											<input type="text" id="paymentAmount" class="form-control">
										</div>

										<div class="col-md-12">
											<label>Remarks </label>
											<input type="text" id="remarksInitialPay" class="form-control">
										</div>

										<div class="col-md-12">
											<label>RFP <span style="color: red;">*</span></label>
											<input type="text" id="rfpPayment" class="form-control">
										</div>
										
										
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="btnCloseAddPayment">Close</button>
									<button type="button" class="btn btn-primary" id="btnPaymentSave">Pay</button>
								</div>
							</div>
						</div>
	</div>

		<!-- modal for modalOtherpayment PO RELATED -->
	<div id="modalOtherpayment" class="modal fade" tabindex="-1" data-backdrop="static">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h5 class="modal-title">Other Payment</h5>
								</div>

								<div class="modal-body">
									<div class="row">

										<!-- <div class="col-md-12">
											<label>Vendor Name<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="OtherVendorPayment">
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>PO #<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="OtherPaymentPO" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>PO date<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="OtherpaymentDate" disabled>
										<!-- </div> -->
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Remaining balance<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="OtherRemainBalanceFromInitial" readonly>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Paid amount<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="OtherPaymentPOAmount" readonly>
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Transact Type <span style="color: red;">*</span></label>
											<select class="form-control" id="OtherTransactType">
												<?php foreach($otherTrans as $otherTranss){ ?>
												<option value="<?php echo $otherTranss['otherTransacTypeCode'] ?>"><?php echo $otherTranss['otherTransacTypeName'] ?></option>
												<?php } ?>
											</select>
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Type <span style="color: red;">*</span></label>
											<select class="form-control" id="OtherTransactType2">
												<?php foreach($transact2 as $transact2PO){ ?>
												<option value="<?php echo $transact2PO['id'] ?>"><?php echo $transact2PO['transact_name'] ?></option>
												<?php } ?>
											</select>
										</div>
										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>Transaction Type <span style="color: red;">*</span></label>
					
											<select class="form-control" id="OtherTrasaction">
												<?php foreach($deduc as $deducs){ ?>
												<option value="<?php echo $deducs['transactionCode'] ?>"><?php echo $deducs['transactionName'] ?></option>
												<?php } ?>
											</select>
										</div> -->
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Reference No<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="OtherReferenceNo">
										</div>


										<div class="col-md-12" style="padding-top: 5px;">
											<label>Amount <span style="color: red;">*</span></label>
											<input type="text" id="otherAmount" class="form-control">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Remarks</label>
											<input type="text" class="form-control" id="OtherRemarks" >
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>RFP <span style="color: red;">*</span></label>
											<input type="text" id="otherRFP" class="form-control">
										</div>
										
									</div>
							
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
									<button type="button" class="btn btn-primary" id="otherPaymentBtn">Pay</button>
								</div>
							</div>
						</div>
	</div>

	<!-- modal for modalOtherpayment NON PO RELATED -->
	<div id="modalOtherpaymentNonPO" class="modal fade" tabindex="-1" data-backdrop="static">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h5 class="modal-title">Other Payment</h5>
								</div>

								<div class="modal-body">
									<div class="row">
								
										<!-- <div class="col-md-12">
											<label>Vendor Name<span style="color: red;">*</span></label> -->
											<input type="hidden" name="OtherVendorPaymentNONPO" id="OtherVendorPaymentNONPO">
										<!-- 
										</div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>PO #<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" name="OtherPaymentNONPO" id="OtherPaymentNONPO" disabled>
										<!-- </div> -->
										
										<div class="col-md-12">
											<label>Date<span style="color: red;">*</span></label>
											<input type="text" class="form-control daterange-single" name="otherDateNONPO" id="otherDateNONPO">
										</div>
										
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Type <span style="color: red;">*</span></label>
											<select class="form-control" name="OtherTransactTypeNONPO" id="OtherTransactTypeNONPO">
												<?php foreach($otherTrans as $otherTranss){ ?>
												<option value="<?php echo $otherTranss['otherTransacTypeCode'] ?>"><?php echo $otherTranss['otherTransacTypeName'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Transaction Type <span style="color: red;">*</span></label>
					
											<select class="form-control" name="OtherTrasactionNONPO" id="OtherTrasactionNONPO">
												<?php foreach($deduc as $deducs){ ?>
												<option value="<?php echo $deducs['transactionCode'] ?>"><?php echo $deducs['transactionName'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Reference No<span style="color: red;">*</span></label>
											<input type="text" class="form-control" name="OtherReferenceNoNONPO" id="OtherReferenceNoNONPO">
										</div>


										<div class="col-md-12" style="padding-top: 5px;">
											<label>Amount <span style="color: red;">*</span></label>
											<input type="text" name="otherAmount2NONPO" id="otherAmount2NONPO" class="form-control">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Payment <span style="color: red;">*</span></label>
											<input type="text" name="otherAmountNONPO" id="otherAmountNONPO" class="form-control">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Remarks</label>
											<input type="text" class="form-control" name="OtherRemarksNONPO" id="OtherRemarksNONPO" >
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>RFP <span style="color: red;">*</span></label>
											<input type="text" class="form-control" name="RFPNONPO" id="RFPNONPO" >
										</div>
									
									</div>
							
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
									<button type="button" class="btn btn-primary" id="otherPaymentBtnNONPO">Pay</button>
								</div>
							</div>
						</div>
	</div>

	<!-- modal for payment details initial payment -->
	<div id="modalInitialPaymentDetails" class="modal fade" tabindex="-1" data-backdrop="static">
					<div class="modal-dialog modal-full">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" id="btnInitialPayClose">&times;</button>
								<button type="button" class="close" data-dismiss="modal" id="btnInitialPayClose1" style="display: none;">&times;</button>
								<h5 class="modal-title">Initial Payment / PO</h5>
							</div>

							<div class="modal-body">
								<div class="row">
									<div class="col-md-6">
										<div style="padding-bottom: 3px;">
										<button class="btn btn-primary" data-toggle="modal" data-target="#modalAnotherInitialpayment" id="btnAddInitialPayment">Add payment</button>
										</div>
										<!-- initial payment -->
										<div class="pre-scrollable">
												<table class="table datatable-basic" id="initialPaymentTable">
													<thead>
														<tr class="bg-success-400">
															<th>PO#</th>
															<!-- <th>PO date</th> -->
															<th>Amount</th>
															<th>Payment</th>
															<th>Balance</th>
															<th>Type</th>
															<th>Date created</th>
															<th>Remarks</th>
															<th>RFP</th>
														
														
														</tr>
													</thead>
													<tbody id="tbody">
									
													</tbody>
												</table>
										</div>	
									</div>

									<div class="col-md-6">
										<div style="padding-bottom: 3px;">
											<button class="btn btn-primary" data-toggle="modal" data-target="#modalOtherInitialpayment" id="AddOtherPaymentBTN">Other payment</button>
										</div>
										
										<!-- otherpayment -->
										<div class="pre-scrollable">
												<table class="table datatable-basic" id="initialPaymentTable">
													<thead>
														<tr class="bg-success-400">
															<th>PO#</th>
															<th>Type</th>
															<th>Transaction</th>
															<th>Reference</th>
															<th>Date created</th>
															<th>Amount</th>
															<th>Payment</th>
															<th>Total</th>
															<th>Remarks</th>
															<th>RFP</th>
														
														
														</tr>
													</thead>
													<tbody id="Othertbody">
									
													</tbody>
												</table>
										</div>
										
										<!-- Non PO Related -->
										<div style="padding-bottom: 3px; padding-top: 5px;">
											<button class="btn btn-primary" data-toggle="modal" data-target="#modalOtherpaymentNonPOTBL" id="AddOtherPaymentBTNNONPO">Non-po payment</button>
										</div>
										
										<!-- otherpayment -->
										<div class="pre-scrollable">
												<table class="table datatable-basic" id="initialPaymentTable">
													<thead>
														<tr class="bg-success-400">
															<th>Date</th>
															<th>Type</th>
															<th>Transaction</th>
															<th>Reference</th>
															<th>Amount</th>
															<th>Payment</th>
															<th>Balance</th>
															<th>Remarks</th>
															<th>RFP</th>
															
														
														
														</tr>
													</thead>
													<tbody id="OthertbodyNonPO">
									
													</tbody>
												</table>
										</div>
									
										
									</div>
								</div>
	
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" id="btnInitialPaymentClose" style="display: none;">Close</button>
								<!-- <button type="button" class="btn btn-primary" >Save</button> -->
							</div>
						</div>
					</div>
	</div>

		<!-- modal for modalOtherpayment NON PO RELATED 2nd modal-->
	<div id="modalOtherpaymentNonPOTBL" class="modal fade" tabindex="-1" data-backdrop="static">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h5 class="modal-title">Other Payment / Non-po related</h5>
								</div>

								<div class="modal-body">
									<div class="row">
								
										<!-- <div class="col-md-12">
											<label>Vendor Name<span style="color: red;"></span></label> -->
											<input type="hidden" class="form-control"  id="nonPORelatedVendor" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>PO #<span style="color: red;"></span></label> -->
											<input type="hidden" class="form-control" name="" id="nonPORelatedPO" disabled>
										<!-- </div> -->
										
										<div class="col-md-12">
											<label>Date<span style="color: red;">*</span></label>
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar22"></i></span>
													<input type="text" name="nonPORelatedDate" id="nonPORelatedDate" placeholder="Select date" class="form-control pickadate-accessibility picker__input" >
												</div>
										</div>
										
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Type <span style="color: red;">*</span></label>
											<select class="form-control" name="" id="nonPORelatedType">
												<?php foreach($otherTrans as $otherTranss){ ?>
												<option value="<?php echo $otherTranss['otherTransacTypeCode'] ?>"><?php echo $otherTranss['otherTransacTypeName'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Transaction Type <span style="color: red;">*</span></label>
					
											<select class="form-control" name="" id="nonPORelatedTransaction">
												<?php foreach($deduc as $deducs){ ?>
												<option value="<?php echo $deducs['transactionCode'] ?>"><?php echo $deducs['transactionName'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Reference No<span style="color: red;">*</span></label>
											<input type="text" class="form-control" name="" id="nonPORelatedReferenceNo">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Amount <span style="color: red;">*</span></label>
											<input type="text" name="" id="nonPORelatedAmount2" class="form-control">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Payment <span style="color: red;">*</span></label>
											<input type="text" name="" id="nonPORelatedAmount" class="form-control">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Remarks</label>
											<input type="text" class="form-control" name="" id="nonPORelatedRemarks" >
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>RFP <span style="color: red;">*</span></label>
											<input type="text" class="form-control" name="" id="nonPORelatedRFP" >
										</div>
									
									</div>
							
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
									<button type="button" class="btn btn-primary" id="nonPORelatedPaymentBtn">Pay</button>
								</div>
							</div>
						</div>
	</div>

	<!-- modal for payment details full payment -->
	<div id="modalFullpayment" class="modal fade" tabindex="-1" data-backdrop="static">
						<div class="modal-dialog modal-full">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h5 class="modal-title">Full Payment</h5>
								</div>

								<div class="modal-body">
									<div class="row">
										<div class="col-md-6">

											<table class="table datatable-basic" id="FullPaymentTable">
																	<thead>
																		<tr class="bg-success-400">
																			<th>PO #</th>
																			<th>PO date</th>
																			<th>PO amount</th>
																			<th>Total payment</th>
																			<th>Change</th>
																			<th>Remaining Balance</th>
																			<th>Payment Type</th>
																			<th>Date Created</th>
																		
																		
																		</tr>
																	</thead>
																	<tbody>
																		<tr>						
																			<td id="FPPONumber"></td>
																			<td id="FPDate"></td>
																			<td id="FPAmount"></td>
																			<td id="FPTotalPayment"></td>
																			<td id="FPChange"></td>
																			<td id="FPRemainBal"></td>
																			<td id="FPPaymentType"></td>
																			<td id="FPDateCreated"></td>	
																		</tr>
																	</tbody>
											</table>	
										</div>

										<div class="col-md-6">
											
											<div style="padding: 10px;">
												<button class="btn btn-primary" data-toggle="modal" data-target="#modalOtherInitialpayment" >Add other payment</button>
											</div>
											
											<table class="table datatable-basic" id="FullOtherPaymentTable">
												<thead>
													<tr class="bg-success-400">
														<th>Type</th>
														<th>PO #</th>
														<th>PO date</th>
														
														<th>Transaction type</th>
														<th>Remarks</th>
														<th>Total</th>
													
													</tr>
												</thead>
												<tbody id="OtherFulltbody">
								
												</tbody>
											</table>
										</div>
									</div>
	
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" >Close</button>
									<!-- <button type="button" class="btn btn-primary" >Save</button> -->
								</div>
							</div>
						</div>
	</div>

	<!-- modal for add another initial payment -->
	<div id="modalAnotherInitialpayment" class="modal fade" tabindex="-1" data-backdrop="static">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h5 class="modal-title">Payment</h5>
								</div>

								<div class="modal-body">
									<div class="row">
										<!-- <div class="col-md-12">
											<label>Vendor</label>
											
											<select class="form-control" id="VendorPayment" disabled>
												<?php foreach($vendorCode as $vendor){ ?>
												<option value="<?php echo $vendor['vendorCode'] ?>"><?php echo $vendor['vendorName'] ?></option>
												<?php } ?>
											</select>
										</div> -->
										<input type="hidden" class="form-control" id="InitialPaymentID" disabled>
										<!-- <label>Vendor name</label> -->
										<input type="hidden" class="form-control" id="InitialPaymentVendor" disabled>
										
										<!-- <div class="col-md-12"> -->
											<!-- <label>PO #</label> -->
											<input type="hidden" class="form-control" id="InitialPaymentPO" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12">
											<label>PO date</label> -->
											<input type="hidden" class="form-control" id="InitialpaymentDate" disabled>
										<!-- </div> -->
										<div class="col-md-12">
											<label>PO amount</label>
											<input type="text" class="form-control" id="InitialPaymentPOAmount" disabled>
										</div>
										<div class="col-md-12">
											<label>Remaining balance</label>
											<input type="text" class="form-control" id="InitialRemainingBalance" disabled>
										</div>
										<div class="col-md-12">
											<label>Total payment</label>
											<input type="text" class="form-control" id="InitialTotalPayment" disabled>
										</div>
										<div class="col-md-12">
											<label>Initial payment</label>
											<input type="text" class="form-control" id="InitialPaymentLatest" disabled>
										</div>
										<div class="col-md-12">
											<label>Payment type</label>
											<select class="form-control" id="InitialpaymentTypePay" disabled>
												<?php foreach($payment as $payments){ ?>
													<option value="<?php echo $payments['paymentTermCode'] ?>"><?php echo $payments['paymentName'] ?></option>
													<?php } ?>
											</select>
										</div>

										<div class="col-md-12">
											<label>Date<span style="color: red;">*</span></label>
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-calendar22"></i></span>
													<input type="text" name="updatedInitialDate" id="updatedInitialDate" placeholder="Select date" class="form-control pickadate-accessibility picker__input" >
												</div>
										</div>

										<div class="col-md-12">
											<label>Amount<span style="color: red;">*</span></label>
											<input type="text" id="InitialpaymentAmount" class="form-control">
										</div>

										<div class="col-md-12">
											<label>Remarks</label>
											<input type="text" id="InitialPayRemarks" class="form-control">
										</div>

										<div class="col-md-12">
											<label>RFP<span style="color: red;">*</span></label>
											<input type="text" id="InitialRFP" class="form-control">
										</div>

										<!-- hidden -->
										<input type="hidden" class="form-control" id="HistoryVendorCode" >
										<input type="hidden" class="form-control" id="HistoryAccountCode" >
										<input type="hidden" class="form-control" id="HistoryPaymentTermCode" >
										<input type="hidden" class="form-control" id="HistoryAccountCurrency" >
										<input type="hidden" class="form-control" id="HistoryPONumber" >
										<input type="hidden" class="form-control" id="HistoryPODate" >
										<input type="hidden" class="form-control" id="HistoryPOAmount" >
										<input type="hidden" class="form-control" id="HistoryProformaInvoice" >
										<input type="hidden" class="form-control" id="HistoryCompany" >
										<input type="hidden" class="form-control" id="HistoryFinal" >
										<input type="hidden" class="form-control" id="HistoryStatus" >
										<input type="hidden" class="form-control" id="HistoryRemarks" >
										
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
									<button type="button" class="btn btn-primary" id="AddAnotherPayment">Pay</button>
								</div>
							</div>
						</div>
	</div>

		<!-- modal for add another other payment -->
	<div id="modalOtherInitialpayment" class="modal fade" tabindex="-1" data-backdrop="static">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" >&times;</button>
									<h5 class="modal-title">Other Payment</h5>
								</div>

								<div class="modal-body">
									<div class="row">
										
									
										<!-- <label>Vendor name</label> -->
										<input type="hidden" class="form-control" id="InitialOtherPaymentVendor" disabled>


										<!-- <div class="col-md-12" style="padding-top: 5px;"> -->
											<!-- <label>PO #<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="InitialOtherPaymentPO" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;"> -->
											<!-- <label>PO amount<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="InitialOtherPaymentPOAmount" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>PO date<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="InitialOtherpaymentDate" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>Remaining balance<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="InitialOtherRemainingBal" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>Initial payment<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="InitialPayment" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;" style="display: none;"> -->
											<!-- <label>Adjustment/Deduction<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="adjustment_deduction" value="0" disabled>
										<!-- </div> -->
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Type<span style="color: red;">*</span></label>
											<select class="form-control" id="FetchOtherTransactType" >
												<?php foreach($otherTrans as $otherTranss){ ?>
												<option value="<?php echo $otherTranss['otherTransacTypeCode'] ?>"><?php echo $otherTranss['otherTransacTypeName'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Transaction type<span style="color: red;">*</span></label>
											<select class="form-control" id="InitialOtherTrasaction">
												<?php foreach($transact2 as $deducs){ ?>
												<option value="<?php echo $deducs['id'] ?>"><?php echo $deducs['transact_name'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Reference No.<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="InitialOtherReferenceNum">
										</div>


										<div class="col-md-12" style="padding-top: 5px;">
											<label>Amount<span style="color: red;">*</span></label>
											<input type="text" id="InitialOtherpaymentAmounts" class="form-control">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Payment<span style="color: red;">*</span></label>
											<input type="text" id="InitialOtherpaymentAmount" class="form-control">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Remarks</label>
											<input type="text" class="form-control" id="InitialOtherRemarks" >
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>RFP<span style="color: red;">*</span></label>
											<input type="text" id="InitialOtherRFP" class="form-control">
										</div>
										
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
									<button type="button" class="btn btn-primary" id="AddOtherPayment">Pay</button>
								</div>
							</div>
						</div>
	</div>

	<!-- <input type ="date" /> -->
	
<script>




$('#li9').addClass('active');



$('#mainTable').DataTable();

// $('#PaymentTable').DataTable();

// $('#initialPaymentTable').DataTable();

// $('#FullPaymentTable').DataTable();

$('#homeTable').DataTable({
	lengthMenu: [5, 25, 50, 75, 100]
});

// $('#paymentForm').hide();
 $('#formBtnPayment').hide();

$('#btnOtherTransact').hide();

$('#btnOtherTransactNONPO').hide();

var delay = 1200;

var delay1 = 500;

// $('.daterange-time').daterangepicker({
//         timePicker: true,
//         applyClass: 'bg-slate-600',
//         cancelClass: 'btn-default',
//         locale: {
//             format: 'MM/DD/YYYY h:mm a'
//         }
// });

// $('#paymentTermCode').hide();
$('#accCode').prop('disabled', true);

$('#addTelegraphicTransferBtn').prop('disabled', true);

$('#accCode').change(function(){
	$('#addTelegraphicTransferBtn').prop('disabled', false);
});


$('.daterange-single').daterangepicker({ 
        singleDatePicker: true,
		//use if disable previos date
		// minDate: moment()

		isInvalidDate: function(date) {
        // Disable dates in the future
        return date.isAfter(moment());
    }
});

$('#addTelegraphicTransferBtn').click(function(){

	var btn = $('#frmTelegraphicTransfer').serialize();
	
	$.ajax({
		 url: '<?php echo base_url(). 'telegraphicTransferController/insertTelegraphicTransfer' ?>',
		 type: 'POST',
		 data: btn,
		 dataType: 'JSON' ,
		 success: function(res){

			if(res.status == 0)
			{
				swal({
				title: "Error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.status == 1)
			{
				swal({
				title: "Error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.status == 2)
			{
				swal({
				title: "Error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.status == 3)
			{
				swal({
				title: "Success",
				text: res.message,
				type: "success",
				closeOnClickOutside: false
				});

					//disable inputs
					$('#vendorCode').prop('disabled', true);
					$('#accCode').prop('disabled', true);
					$('#CompanyCode').prop('disabled', true);
					$('#PONumber').prop('disabled', true);
					$('#PODate').prop('disabled', true);
					$('#POAmount').prop('disabled', true);
					$('#ProformaInvoice').prop('disabled', true);
					$('#FinalInvoice').prop('disabled', true);
					$('#rfp').prop('disabled', true);
					$('#rfp').prop('disabled', true);
				
					$('#addTelegraphicTransferBtn').prop('disabled', true);

					$('#formBtnPayment').show();

					//payment History
					var vVendor = $('#VendorPayment').val(res.data.vendorCode);
					var vPONumber = $('#PaymentPO').val(res.data.PONumber);
					var VPaymentAmount = $('#PaymentPOAmount').val(res.data.POAmount);
					var vPaymentType = $('#paymentTypePay').val(res.data.accountCurrency);
					var vPaymentDate = $('#paymentDate').val(res.data.PODate);

					var PaymentAccountCode = $('#PaymentAccountCode').val(res.data.accountCode);
					var PaymentCurrency = $('#PaymentCurrency').val(res.data.paymentTermCode);
					var PaymentProformaInvoice = $('#PaymentProformaInvoice').val(res.data.proformaInvoice);
					var PaymentCommercialInvoice = $('#PaymentCommercialInvoice').val(res.data.commercialInvoice);
					// var PaymentrfpReferrence = $('#PaymentrfpReferrence').val(res.data.rfpReference);
					var PaymentCompCode = $('#PaymentCompCode').val(res.data.compCode);
					var PaymentFinalInvoice = $('#PaymentFinalInvoice').val(res.data.finalInvoice);
					var PaymentCreditNote = $('#PaymentCreditNote').val(res.data.creditNote);
					var PaymentdebitNote = $('#PaymentdebitNote').val(res.data.debitNote);
					var PaymentWireTransferFee = $('#PaymentWireTransferFee').val(res.data.wireTransferFee);


			}

		}
	});
})

function fetchDataInModal(telCode)
{	
	var telcode = 			$('#telcode');
	var vendorCode = 		$('#updatevendorCode');
	var accCode = 			$('#updateaccCode');
	var paymentTermCode = 	$('#updatepaymentTermCode');
	var accCurrency = 		$('#updateaccCurrency');
	var PONumber = 			$('#updatePONumber');
	var PODate =			$('#updatePODate');
	var POAmount = 			$('#updatePOAmount');
	var ProformaInvoice = 	$('#updateProformaInvoice');
	var CommercialInvoice = $('#updateCommercialInvoice');
	var RFPreference = 		$('#updateRFPreference');
	var CompanyCode = 		$('#updateCompanyCode');
	var FinalInvoice = 		$('#updateFinalInvoice');
	var CreditNote = 		$('#updateCreditNote');
	var DebitNote =			$('#updateDebitNote');
	var WireTransferFee =	$('#updateWireTransferFee');

	$.ajax({
		 url: '<?php echo base_url(). 'telegraphicTransferController/fetchTTSDATAmodal' ?>',
		 type: 'POST',
		 data: {code: telCode},
		 dataType: 'JSON',
		 success: function(data){

			telcode.val(data.telCode);
			vendorCode.val(data.vendorCode);
			accCode.val(data.accountCode);
			paymentTermCode.val(data.paymentTermCode);
			accCurrency.val(data.accountCurrency)
			PONumber.val(data.PONumber);
			PODate.val(data.PODate);
			POAmount.val(data.POAmount);
			ProformaInvoice.val(data.proformaInvoice);
			CommercialInvoice.val(data.commercialInvoice);
			RFPreference.val(data.rfpReference);
			CompanyCode.val(data.compCode);
			FinalInvoice.val(data.finalInvoice);
			CreditNote.val(data.creditNote);
			DebitNote.val(data.debitNote);
			WireTransferFee.val(data.wireTransferFee);


		}
	});
}

$('#updateTTSData').click(function(){
	
	var telcode = 			$('#telcode').val();
	var vendorCode = 		$('#updatevendorCode').val();
	var accCode = 			$('#updateaccCode').val();
	var paymentTermCode = 	$('#updatepaymentTermCode').val();
	var accCurrency = 		$('#updateaccCurrency').val();
	var PONumber = 			$('#updatePONumber').val();
	var PODate = 			$('#updatePODate').val();
	var POAmount = 			$('#updatePOAmount').val();
	var ProformaInvoice = 	$('#updateProformaInvoice').val();
	var CommercialInvoice = $('#updateCommercialInvoice').val();
	var RFPreference = 		$('#updateRFPreference').val();
	var CompanyCode = 		$('#updateCompanyCode').val();
	var FinalInvoice = 		$('#updateFinalInvoice').val();
	var CreditNote = 		$('#updateCreditNote').val();
	var DebitNote = 		$('#updateDebitNote').val();
	var WireTransferFee = 	$('#updateWireTransferFee').val();

	$.ajax({
		 url: '<?php echo base_url(). 'telegraphicTransferController/updateTTSDATA' ?>',
		 type: 'POST',
		 data: {
			updateTelCode: telcode,
			updateVendorCode: vendorCode,
			updateaccCode: accCode,
			updatepaymentTermCode: paymentTermCode,
			updateaccCurrency: accCurrency,
			updatePONumber: PONumber,
			updatePODate: PODate,
			updatePOAmount: POAmount,
			updateProformaInvoice: ProformaInvoice,
			updateCommercialInvoice: CommercialInvoice,
			updateRFPreference: RFPreference,
			updateCompanyCode: CompanyCode,
			updateFinalInvoice: FinalInvoice,
			updateCreditNote: CreditNote,
			updateDebitNote: DebitNote,
			updateWireTransferFee: WireTransferFee
		 	},
		 dataType: 'JSON',
		 success: function(response){

		if(response.stat == 0)
		{
			swal({
			title: "Error",
			text: response.mess,
			icon: "error",
			});
		}

		else
		{
	
			if(response.status == 1)
			{
				swal({
				title: "Success",
				text: response.message,
				icon: "success",
				});

				setTimeout(function(){ window.location.reload(); }, delay);
			}

			else
			{
				swal({
				title: "Error",
				text: response.message,
				icon: "error",
				});
			}	

	
		}



		}
	});



})

$('#vendorCode').change(function(){

		var vendorName = $(this).val();

		var accCode = $('#accCode');
		var currency = $('#paymentTermCode');
	

		$.ajax({
		 url: '<?php echo base_url(). 'telegraphicTransferController/populateVendorToAccount' ?>',
		 type: 'POST',
		 data: {v: vendorName},
		 dataType: 'JSON',
		 beforeSend: function(){
			
			accCode.empty();
			accCode.append('<option value="">Select account</option>');
		
		 },
		 
		 success: function(res){

			// console.log(res);	
			$('#accCode').prop('disabled', false);

            for(x in res)
            {
             var option = document.createElement("option");
             option.text = res[x].accountNumber + " - " + res[x].currency;
             option.value = res[x].accountCode + "," + res[x].vendorCode + "," + res[x].account_currency;
             accCode.append(option);

                
            }

		}
		});


});

// $('#accCode').change(function(){

// 	var accCode = $(this).val();

// 	var paymentTermCode = $('#paymentTermCode');

// 	$.ajax({
// 			url: '<?php echo base_url(). "telegraphicTransferController/populateAccToCurrency" ?>',
// 			type: 'POST',
// 			data: {a: accCode},
// 			dataType: 'JSON',
// 			beforeSend: function(){

// 			paymentTermCode.empty();
// 			// paymentTermCode.append('<option value="">Select currency</option>');

// 		 },
// 		 success: function(res){

// 			// console.log(res.currency);
		
// 			// var res1 = JSON.parse(res);

// 			// console.log(res1);

// 				var option = document.createElement("option");
// 				option.text = res.currency;
// 				option.value = res.account_currency;
// 				paymentTermCode.append(option);
			

// 		}
// 		});

// })

$('#btnCloseAdd').click(function(){
	$('#vendorCode').val('');
	$('#accCode').val('');
	$('#paymentTermCode').val('');
	$('#accCurrency').val('');
	$('#PONumber').val('');
	$('#PODate').val('');
	$('#POAmount').val('');
	$('#ProformaInvoice').val('');
	$('#CommercialInvoice').val('');
	$('#RFPreference').val('');
	$('#CompanyCode').val('');
	$('#FinalInvoice').val('');
	$('#CreditNote').val('');
	$('#DebitNote').val('');
	$('#WireTransferFee').val('');
	
	$('#accCode').prop('disabled', true);

	$('#addTelegraphicTransferBtn').prop('disabled', true);
})

$('#ExcelBtn').click(function(){

	window.open('<?php echo base_url(). 'telegraphicTransferController/generateExel'?>');

})

$('#uploadFile').click(function(){

	var uploadForm = new FormData($('#uploadForm')[0]);

	$.ajax({
		 url: '<?php echo base_url(). "telegraphicTransferController/upload_file"; ?>',
		 type: 'POST',
		 data: uploadForm,
		 dataType: 'JSON',
		 contentType: false,
         processData: false,
		 success: function(res){

			if(res.s == 0)
			{
				alert(res.m);
			}
			else
			{
				if(res.status == 1)
				{
					alert(res.message);
				}

				else
				{
					alert(res.message);
				}
			}	

		}
	});

})

$('#uploadExcelBtn').click(function(){

	var readExcel = new FormData($('#readFile')[0]);

	 $.ajax({
	 url: '<?php echo base_url(). "telegraphicTransferController/readExcelFile"; ?>',
	 type: 'POST',
	 data: readExcel,
	 dataType: 'JSON',
	 contentType: false,
	 processData: false,
	 success: function(res){

		if(res.m == 0)
		{
			alert(res.s);
		}

		else
		{
			if(res.status == 1)
			{
				alert(res.message);
			}

			else
			{
				alert(res.message);
			}
		}

			

	}
});
})

//Initial payment
$('#btnPaymentSave').click(function(){

	var vendor = $('#VendorPayment').val();
	var inputAmt = $('#paymentAmount').val();
	var vPONumber = $('#PaymentPO').val();
	var VPaymentAmount = $('#PaymentPOAmount').val();
	var vPaymentType = $('#paymentTypePay').val();
	var vPaymentDate = $('#paymentDate').val();
	var balance = $('#balance').val();
	var rfpPayment = $('#rfpPayment').val();

	var PaymentAccountCode = $('#PaymentAccountCode').val();
	var PaymentCurrency = $('#PaymentCurrency').val();
	var PaymentProformaInvoice = $('#PaymentProformaInvoice').val();
	var PaymentCompCode = $('#PaymentCompCode').val();
	var PaymentFinalInvoice = $('#PaymentFinalInvoice').val();

	var InitialDate = $('#InitialDate').val();

	var rfp = $('#rfp').val();

	var remarksInitial = $('#remarksInitial').val();
	

	var remarksInitialPay = $('#remarksInitialPay').val();



	
						$.ajax({
						url: '<?php echo base_url(). 'telegraphicTransferController/InsertPayment' ?>',
						type: 'POST',
						data: {
							Pvendor:			vendor,
							PPONum:  			vPONumber,
							PPODate: 			vPaymentDate,
							PPOAmount:			VPaymentAmount,
							PpaymentType: 		vPaymentType,
							amount:				inputAmt,
							balance:			balance,
							AccountCode:		PaymentAccountCode,
							Currency: 			PaymentCurrency,
							ProformaInvoice:	PaymentProformaInvoice,
							CompCode:			PaymentCompCode,
							FinalInvoice:		PaymentFinalInvoice,
							remarks:			remarksInitial,
							remarksFirstPay: 	remarksInitialPay,
							rfps:				rfp,
							date:				InitialDate,
							rfpPayments: 		rfpPayment,

						},
						dataType: 'JSON',
						success: function(res){

								if(res.status == 0)
								{
									swal({
									title: "Error",
									text: res.message,
									type: "error",
									closeOnClickOutside: false
									});
								}

								else if(res.status == 1)
								{
									swal({
									title: "Error",
									text: res.message,
									type: "error",
									closeOnClickOutside: false
									});
								}

								// initial payment
								else if(res.status == 2)
								{
									swal({
									title: "Success",
									text: res.message,
									type: "success",
									closeOnClickOutside: false
									});

									$('#btnAddPayment').prop('disabled', true);

									$('#xBtnAdd').hide();

									$('#btnCloseTTS').show();

									$('#modalpayment').modal('hide');
									$('#btnAddPayment').prop('disabled', true);
									$('#addTelegraphicTransferBtn').hide();


										$.ajax({
										url: "<?php echo base_url(). 'telegraphicTransferController/fetchdataPayment' ?>",
										type: 'POST',
										data: {
											ponumber: vPONumber,
											vendorCode: vendor
										},
										dataType: 'JSON',
										success: function(res){
											
										// $('#paymentForm').show();

										$('#first').html(res.PO_number);
										$('#second').html(res.PO_amount);
										$('#third').html(res.paymentName);
										$('#fourth').html(res.date);
										$('#sixth').html(res.remarks);
										$('#fifth').html(res.rfp);

										$('#remainingBalance').html('Remaining balance: ' + res.total_balance);
										$('#totalPayment').html('Initial payment: ' + res.amount);

										$('#change').html('Change: ' + res.change);

										
										$('#btnOtherTransact').show();

										$('#btnOtherTransactNONPO').show();

										//otherPayment
										var OtherVendorPayment = $('#OtherVendorPayment').val(res.Vendor);
										var OtherPaymentPO = $('#OtherPaymentPO').val(res.PO_number);
										var OtherpaymentDate = $('#OtherpaymentDate').val(res.PO_date);
										var OtherPaymentPOAmount = $('#OtherPaymentPOAmount').val(res.total_payment);
										

										var OtherRemainBalanceFromInitial = $('#OtherRemainBalanceFromInitial').val(res.total_balance);

										//NON PO RELATED
										$('#OtherVendorPaymentNONPO').val(res.Vendor);
										$('#OtherPaymentNONPO').val(res.PO_number);
								


										


											
										}
									});
								}

								// full payment
								else if(res.status == 3)
								{
									swal({
									title: "Success",
									text: res.message,
									type: "success",
									closeOnClickOutside: false
									});

									$('#btnAddPayment').prop('disabled', true);

									$('#xBtnAdd').hide();

									$('#btnCloseTTS').show();

									$('#modalpayment').modal('hide');
									$('#btnAddPayment').prop('disabled', true);
									$('#addTelegraphicTransferBtn').hide();


										$.ajax({
										url: "<?php echo base_url(). 'telegraphicTransferController/fetchdataPayment' ?>",
										type: 'POST',
										data: {
											ponumber: vPONumber,
											vendorCode: vendor
										},
										dataType: 'JSON',
										success: function(res){
											

										$('#first').html(res.PO_number);
										$('#second').html(res.PO_amount);
										$('#third').html(res.paymentName);
										$('#fourth').html(res.PO_date);
										$('#sixth').html(res.remarks);
										$('#fifth').html(res.rfp);

										$('#remainingBalance').html('Remaining balance: ' + res.total_balance);
										$('#totalPayment').html('Initial payment: ' + res.amount);

										$('#change').html('Change: ' + res.change);

										//otherPayment
										var OtherVendorPayment = $('#OtherVendorPayment').val(res.Vendor);
										var OtherPaymentPO = $('#OtherPaymentPO').val(res.PO_number);
										var OtherpaymentDate = $('#OtherpaymentDate').val(res.PO_date);
										var OtherPaymentPOAmount = $('#OtherPaymentPOAmount').val(res.total_payment);

											
										}
									});

								}

								else 
								{
									swal({
									title: "Error",
									text: res.message,
									type: "error",
									closeOnClickOutside: false
									});
								}

						}
						});
})

//initial payment for other payment, optional
$('#otherPaymentBtn').click(function(){
		var OtherTransact = $('#OtherTransactType').val();
		var OtherVendorPayment = $('#OtherVendorPayment').val();
		var OtherPaymentPO = $('#OtherPaymentPO').val();
		var OtherpaymentDate = $('#OtherpaymentDate').val();
		var OtherReferenceNo = $('#OtherReferenceNo').val();
		var OtherPaymentPOAmount = $('#OtherPaymentPOAmount').val();
		var OtherRemarks = $('#OtherRemarks').val();
		// var OtherTrasaction = $('#OtherTrasaction').val();
		var OtherTransactType2 = $('#OtherTransactType2').val();
		var otherAmount = $('#otherAmount').val();

		var otherRFP = $('#otherRFP').val();	

		var OtherRemainBalanceFromInitial = $('#OtherRemainBalanceFromInitial').val();


		var PaymentAccountCode = $('#PaymentAccountCode').val();
		var PaymentCurrency = $('#PaymentCurrency').val();
		var PaymentProformaInvoice = $('#PaymentProformaInvoice').val();
		var PaymentCompCode = $('#PaymentCompCode').val();
		var PaymentFinalInvoice = $('#PaymentFinalInvoice').val();
		
	

		$.ajax({
		 url: "<?php echo base_url(). 'telegraphicTransferController/insertInitialOtherTransaction' ?>",
		 type: 'POST',
		 data: {
			trans_type:	OtherTransact,
			vendor:		OtherVendorPayment,
			po_number:	OtherPaymentPO,
			po_date:	OtherpaymentDate,
			referenceNo: OtherReferenceNo,
			po_amount:	OtherPaymentPOAmount,
			// deduc_type:	OtherTrasaction,
			transact2: OtherTransactType2,
			amount:		otherAmount,
			remarks:	OtherRemarks,
			total_balance_initialPay: OtherRemainBalanceFromInitial,
			rfp: otherRFP,
			
			AccountCode:		PaymentAccountCode,
			Currency: 			PaymentCurrency,
			ProformaInvoice:	PaymentProformaInvoice,
			CompCode:			PaymentCompCode,
			FinalInvoice:		PaymentFinalInvoice,
		 },
		 dataType: 'JSON',
		 success: function(res){
			
			if(res.stats == 1)
			{
				swal({
				title: "error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.stats == 2)
			{
				swal({
				title: "error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.stats == 3)
			{
				swal({
				title: "error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.stats == 4)
			{
				swal({
				title: "error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.stats == 5)
			{
				swal({
				title: "error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.stats == 6)
			{
				swal({
				title: "Success",
				text: res.message,
				type: "success",
				closeOnClickOutside: false
				});


				$.ajax({
				url: "<?php echo base_url(). 'telegraphicTransferController/fetchOtherPaymentData' ?>",
				type: 'POST',
				data: {
					po_num: OtherPaymentPO,
					reference_num: OtherReferenceNo
				},
				dataType: 'JSON',
				success: function(res){

					$('#modalOtherpayment').hide();

					$('#btnOtherTransact').prop('disabled', true);


					$('#otherFirst').html(res.otherPONumber);
					$('#otherSecond').html(res.otherTransacTypeName);
					$('#otherThird').html(res.transact_name);
					$('#otherFourth').html(res.referenceNumber);
					$('#otherFifth').html(res.dateCreated);
					$('#otherSixth').html(res.Remarks);
					$('#otherSeventh').html(res.rfp);

					$('#OtherRemainBalance').html('Amount: ' + res.otherTotalDeduc);
					$('#transAmt').html('Updated Initial payment: ' + res.updated_deduct_adjustment);

																

				}
				});

			}

			else
			{
				swal({
				title: "error",
				text: res.message,
				type: "success",
				closeOnClickOutside: false
				});
			}

		}
		});

})

$('#otherPaymentBtnNONPO').click(function(){

	var OtherVendorPaymentNONPO = $('#OtherVendorPaymentNONPO').val();
	var OtherPaymentNONPO = $('#OtherPaymentNONPO').val();
	var otherDateNONPO = $('#otherDateNONPO').val();
	var OtherTransactTypeNONPO = $('#OtherTransactTypeNONPO').val();
	var OtherTrasactionNONPO = $('#OtherTrasactionNONPO').val();
	var OtherReferenceNoNONPO = $('#OtherReferenceNoNONPO').val();
	var OtherRemarksNONPO = $('#OtherRemarksNONPO').val();
	var rfpNonPO = $('#RFPNONPO').val();
	var otherAmountNONPO = $('#otherAmountNONPO').val();
	var otherAmount2NONPO = $('#otherAmount2NONPO').val();


	$.ajax({
		 url: "<?php echo base_url(). 'telegraphicTransferController/insertInitialOtherTransactNONPO' ?>",
		 type: 'POST',
		 data: {
			VendorPaymentNONPO: OtherVendorPaymentNONPO,
			PaymentNONPO: OtherPaymentNONPO,
			DateNONPO: otherDateNONPO,
			TransactTypeNONPO: OtherTransactTypeNONPO,
			TrasactionNONPO: OtherTrasactionNONPO,
			ReferenceNoNONPO: OtherReferenceNoNONPO,
			RemarksNONPO: OtherRemarksNONPO,
			RFPNONPO: rfpNonPO,
			AmountNONPO: otherAmountNONPO,
			Amount2: otherAmount2NONPO
		 },
		 dataType: 'JSON',
		 success: function(res){

			if(res.status == 1)
			{
				swal({
				title: "Error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.status == 1.1)
			{
				swal({
				title: "Error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.status == 1.2)
			{
				swal({
				title: "Error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.status == 1.3)
			{
				swal({
				title: "Error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}	

			else if(res.status == 1.4)
			{
				swal({
				title: "Error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}	

			else
			{
				if(res.status == 2)
				{	
					//disabled the button
					$('#btnOtherTransactNONPO').prop('disabled', true);

					//hide the modal
					$('#modalOtherpaymentNonPO').hide();

					swal({
					title: "Okay",
					text: res.message,
					type: "success",
					closeOnClickOutside: false
					});

						//ajax for fetching data 
				
						$.ajax({
						url: "<?php echo base_url(). 'telegraphicTransferController/fetchNONPOdata' ?>",
						type: 'POST',
						data: {
							po: OtherPaymentNONPO,
							vendor: OtherVendorPaymentNONPO
						},
						dataType: 'JSON',
						success: function(res){


						$('#otherFirstNonPO').html(res.date);
						$('#otherSecondNonPO').html(res.otherTransacTypeName);
						$('#otherThirdNonPO').html(res.transactionName);
						$('#otherFourthNonPO').html(res.reference_no);
						$('#otherFourthNNonPO').html(res.amount2);
						$('#otherFifthNonPO').html(res.remarks);
						$('#otherSixthNonPO').html(res.rfp);

						$('#transAmtNonPO').html('Payment: ' + res.amount);
						$('#OtherRemainBalanceNonPO').html('Balance: '+ res.total);
						
				
						}});
						

				}

				else
				{
					swal({
					title: "Error",
					text: res.message,
					type: "success",
					closeOnClickOutside: false
					});
				}
			}

			}
		});



})

$('#btnCloseTTS').click(function(){

	setTimeout(function(){ window.location.reload(); }, delay1);

})

$('#btnInitialPaymentClose').click(function(){
	
	setTimeout(function(){ window.location.reload(); }, delay1);
})

function InitialPaymentFunction(PO_NUMBER, VENDOR_CODE)
{

	$.ajax({
		 url: "<?php echo base_url(). 'telegraphicTransferController/fetchInitialPayment' ?>",
		 type: 'POST',
		 data: {PO_number: PO_NUMBER,
				vendorCode: VENDOR_CODE},
		 dataType: 'JSON',
		 success: function(res){


			var tableBody = $('#tbody');

			tableBody.empty();

		    $.each(res, function(index, item){

			var newRow = $('<tr>');

			// Create and append cells for each property
			newRow.append($('<td>').html(item.PO_number));
			newRow.append($('<td>').html(item.PO_amount));
			newRow.append($('<td>').html(item.total_payment));
			newRow.append($('<td>').html(item.total_balance));
			newRow.append($('<td>').html(item.paymentName));
			newRow.append($('<td>').html(item.date));
			newRow.append($('<td>').html(item.remarks));
			newRow.append($('<td>').html(item.rfp));

			// Append the row to the table body
			tableBody.append(newRow);

			var InitialPaymentID = $('#InitialPaymentID').val(item.payment_id);
			var InitialPaymentVendor = $('#InitialPaymentVendor').val(item.Vendor);	
			var InitialPaymentPO = $('#InitialPaymentPO').val(item.PO_number);
			var InitialpaymentDate = $('#InitialpaymentDate').val(item.PO_date);
			var InitialPaymentPOAmount = $('#InitialPaymentPOAmount').val(item.PO_amount);
			var InitialTotalPayment = $('#InitialTotalPayment').val(item.sum_total_payment);
			var InitialRemainingBalance = $('#InitialRemainingBalance').val(item.total_balance);
			var InitialpaymentTypePay = $('#InitialpaymentTypePay').val(item.payment_type);

			// InitialTotalPayment
			var InitialPaymentLatest = $('#InitialPaymentLatest').val(item.updated_total_payment);
	
					$('#InitialOtherPaymentVendor').val(item.Vendor);
					$('#InitialOtherPaymentPO').val(item.PO_number);
					$('#InitialOtherPaymentPOAmount').val(item.PO_amount);
					$('#InitialOtherpaymentDate').val(item.PO_date);

					$('#InitialOtherRemainingBal').val(item.total_balance);
					$('#InitialPayment').val(item.updated_total_payment);
				
					//OTHER PAYMENT NON PO RELATED
					$('#nonPORelatedVendor').val(item.Vendor);
					$('#nonPORelatedPO').val(item.PO_number);
					
		    })

			
				$.ajax({
					url: '<?php echo base_url(). "telegraphicTransferController/fetchInitialPaymentData" ?>',
					type: 'POST',
					data: {ponumber: PO_NUMBER,
						vendorCode: VENDOR_CODE},
					dataType: 'JSON',
					success: function(res){

					$('#HistoryVendorCode').val(res.vendorCode);
					$('#HistoryAccountCode').val(res.accountCode);
					$('#HistoryPaymentTermCode').val(res.paymentTermCode);
					$('#HistoryAccountCurrency').val(res.accountCurrency);
					$('#HistoryPONumber').val(res.PONumber);
					$('#HistoryPODate').val(res.PODate);
					$('#HistoryPOAmount').val(res.POAmount);
					$('#HistoryProformaInvoice').val(res.proformaInvoice);
					$('#HistoryCompany').val(res.compCode);
					$('#HistoryFinal').val(res.finalInvoice);
					$('#HistoryRemarks').val(res.remarks);


				}
				});

	}
	});


	//FETCH OTHER PAYMENT
	$.ajax({
			url: "<?php echo base_url(). 'telegraphicTransferController/fetchOtherPaymentDatatoTBL' ?>",
			type: 'POST',
			data: { po_num: PO_NUMBER,
				vendorCode: VENDOR_CODE},
			dataType: 'JSON',
			success: function(res){

			var tableBody = $('#Othertbody');

			tableBody.empty();

			$.each(res, function(index, item){

			var newRow = $('<tr>');

			// Create and append cells for each property
			newRow.append($('<td>').html(item.otherPONumber));
			newRow.append($('<td>').html(item.otherTransacTypeName));
			newRow.append($('<td>').html(item.transact_name));
			newRow.append($('<td>').html(item.referenceNumber));
			newRow.append($('<td>').html(item.dateCreated));	
			newRow.append($('<td>').html(item.amount));
			newRow.append($('<td>').html(item.otherTotalDeduc));
			newRow.append($('<td>').html(item.total));
			newRow.append($('<td>').html(item.Remarks));
			newRow.append($('<td>').html(item.rfp));

			// Append the row to the table body
			tableBody.append(newRow);

			// $('#InitialOtherRemainingBal').val(item.updateRemainBal);

			$('#adjustment_deduction').val(item.sumTotalDeduct);
			

			$('#InitialPayment').val();
			
		

			})

		}
	});
	
	//fetch OtherPaymentNonPO Related
	$.ajax({
		url: "<?php echo base_url(). 'telegraphicTransferController/fetchNONPOdataToTBL' ?>",
		type: 'POST',
		data: { po: PO_NUMBER,
				vendor: VENDOR_CODE},
		dataType: 'JSON',
		success: function(res){

			var tableBody = $('#OthertbodyNonPO');

			tableBody.empty();

			$.each(res, function(index, item){

			var newRow = $('<tr>');

			// Create and append cells for each property
			newRow.append($('<td>').html(item.formattedDate));
			newRow.append($('<td>').html(item.otherTransacTypeName));
			newRow.append($('<td>').html(item.transactionName));
			newRow.append($('<td>').html(item.reference_no));
			newRow.append($('<td>').html(item.amount2));	
			newRow.append($('<td>').html(item.amount));
			newRow.append($('<td>').html(item.total));
			newRow.append($('<td>').html(item.remarks));
			newRow.append($('<td>').html(item.rfp));

			// Append the row to the table body
			tableBody.append(newRow);


			})

		}
	});



	
}

$('#AddAnotherPayment').click(function()
{		
		var InitialPaymentVendor = $('#InitialPaymentVendor').val();
		var InitialPaymentPO = $('#InitialPaymentPO').val();
		var InitialpaymentDate = $('#InitialpaymentDate').val();
		var InitialPaymentPOAmount = $('#InitialPaymentPOAmount').val();
	
		var InitialRemainingBalance = $('#InitialRemainingBalance').val();
		var InitialpaymentTypePay = $('#InitialpaymentTypePay').val();
		var InitialpaymentAmount = $('#InitialpaymentAmount').val();
	
		var InitialPaymentLatest = $('#InitialPaymentLatest').val();

		var InitialTotalPayments = $('#InitialTotalPayment').val();

		var InitialPayRemarks = $('#InitialPayRemarks').val();
		var updatedInitialDate = $('#updatedInitialDate').val();
		var InitialRFP = $('#InitialRFP').val();
		
		
		
		//history
		var HistoryVendorCode = $('#HistoryVendorCode').val();
		var HistoryAccountCode = $('#HistoryAccountCode').val();
		var HistoryPaymentTermCode = $('#HistoryPaymentTermCode').val();
		var HistoryAccountCurrency = $('#HistoryAccountCurrency').val();
		var HistoryPONumber = $('#HistoryPONumber').val();
		var HistoryPODate = $('#HistoryPODate').val();
		var HistoryPOAmount = $('#HistoryPOAmount').val();
		var HistoryProformaInvoice = $('#HistoryProformaInvoice').val();
		var HistoryCompany = $('#HistoryCompany').val();
		var HistoryFinal = $('#HistoryFinal').val();
		var HistoryRemarks = $('#HistoryRemarks').val();
		// var HistoryStatus = $('#HistoryStatus').val();
		


		 $.ajax({
		 url: "<?php echo base_url(). 'telegraphicTransferController/updateInitialPay' ?>",
		 type: 'POST',
		 data: {
			vendor:			InitialPaymentVendor,
			PO_number: 		InitialPaymentPO,
			PO_date: 		InitialpaymentDate,
			PO_amount: 		InitialPaymentPOAmount,
			totalInitial: 	InitialTotalPayments,
			total_balance: 	InitialRemainingBalance,
			paymentType: 	InitialpaymentTypePay,
			amount: 		InitialpaymentAmount,
			InitialPaymentL: InitialPaymentLatest,
			remarks: 		InitialPayRemarks,
			date:			updatedInitialDate,
			rfp:			InitialRFP,

			historyvendor:		HistoryVendorCode,
			historyaccount:		HistoryAccountCode,
			historycurrency:	HistoryPaymentTermCode,
			historyaccountCurrency:	HistoryAccountCurrency,
			historyPOnumber:    HistoryPONumber,
			historyPOdate:		HistoryPODate,
			historyPOamt:		HistoryPOAmount,
			historyproformaInvoice: HistoryProformaInvoice,
			historycompany_name: HistoryCompany,
			historyfinalInvoice: HistoryFinal,
			hisRemarks: HistoryRemarks


		 },
		 dataType: 'JSON',
		 success: function(res){
			if(res.status == 3)
			{
				swal({
				title: "Error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.status == 3.1)
			{
				swal({
				title: "Error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}


			else
			{	
				if(res.status == 0)
				{
					swal({
					title: "Error",
					text: res.message,
					type: "error",
					closeOnClickOutside: false
					});
				}

				else
				{
					if(res.status == 5)
					{
						swal({
						title: "Error",
						text: res.message,
						type: "error",
						closeOnClickOutside: false
						});
						
					}

					//full payment
					else if(res.status == 'D')
					{
						swal({
						title: "Success",
						text: res.message,
						type: "success",
						closeOnClickOutside: false
						});

						$('#modalAnotherInitialpayment').modal('hide');

						$('#InitialpaymentAmount').val('');

						$('#btnAddInitialPayment').prop('disabled', true);
						
						$('#AddOtherPaymentBTN').prop('disabled', true);

						$('#AddOtherPaymentBTNNONPO').prop('disabled', true);

						$('#btnInitialPayClose').hide();

						$('#btnInitialPaymentClose').show();


						$.ajax({
							url: "<?php echo base_url(). 'telegraphicTransferController/fetchInitialPayment' ?>",
							type: 'POST',
							data: {PO_number: InitialPaymentPO,
								vendorCode: InitialPaymentVendor},
							dataType: 'JSON',
							success: function(res){

							var tableBody = $('#tbody');

							tableBody.empty();

							$.each(res, function(index, item){

							var newRow = $('<tr>');

							// Create and append cells for each property
							newRow.append($('<td>').html(item.PO_number));
							newRow.append($('<td>').html(item.PO_amount));
							newRow.append($('<td>').html(item.amount));
							newRow.append($('<td>').html(item.total_balance));
							newRow.append($('<td>').html(item.paymentName));
							newRow.append($('<td>').html(item.date));
							newRow.append($('<td>').html(item.remarks));
							newRow.append($('<td>').html(item.rfp));
							

							// Append the row to the table body
							tableBody.append(newRow);

								//CHANGE AMOUNT DEPEND ON DEDUCTION
								$('#InitialOtherPaymentPOAmount').val(item.total_balance);
					
							})

							}
							});


					}

					else
					{
						if(res.status == 1)
						{
							swal({
							title: "Success",
							text: res.message,
							type: "success",
							closeOnClickOutside: false
							});

							$('#modalAnotherInitialpayment').modal('hide');
							
							$('#InitialpaymentAmount').val('');

							$.ajax({
							url: "<?php echo base_url(). 'telegraphicTransferController/fetchInitialPayment' ?>",
							type: 'POST',
							data: {PO_number: InitialPaymentPO,
								   vendorCode: InitialPaymentVendor},
							dataType: 'JSON',
							success: function(res){

							var tableBody = $('#tbody');

							tableBody.empty();

							$.each(res, function(index, item){

							var newRow = $('<tr>');

							// Create and append cells for each property

							newRow.append($('<td>').html(item.PO_number));
							newRow.append($('<td>').html(item.PO_amount));
							newRow.append($('<td>').html(item.amount));
							newRow.append($('<td>').html(item.total_balance));
							newRow.append($('<td>').html(item.paymentName));
							newRow.append($('<td>').html(item.date));
							newRow.append($('<td>').html(item.remarks));
							newRow.append($('<td>').html(item.rfp));

							// Append the row to the table body
							tableBody.append(newRow);
							var InitialPaymentPO = $('#InitialPaymentPO').val(item.PO_number);

							var InitialpaymentDate = $('#InitialpaymentDate').val(item.PO_date);

							var InitialPaymentPOAmount = $('#InitialPaymentPOAmount').val(item.PO_amount);

							var InitialRemainingBalance = $('#InitialRemainingBalance').val(item.total_balance);

							var InitialTotalPayment = $('#InitialTotalPayment').val(item.sum_total_payment);

							var InitialPaymentLatest = $('#InitialPaymentLatest').val(item.updated_total_payment);
							
							var InitialpaymentTypePay = $('#InitialpaymentTypePay').val(item.payment_type);

							//CHANGE AMOUNT DEPEND ON DEDUCTION
							$('#InitialOtherRemainingBal').val(item.total_balance);

							var InitialPayment = $('#InitialPayment').val(item.updated_total_payment);
							
							})

							}
							});

						}

						else
						{
							swal({
							title: "Error",
							text: res.message,
							type: "error",
							closeOnClickOutside: false
							});
						}
					}
				}
			}
		}
		});

})

//add other payment
$('#AddOtherPayment').click(function()
{	
	var FetchOtherTransactType = $('#FetchOtherTransactType').val();
	var InitialOtherPaymentVendor = $('#InitialOtherPaymentVendor').val();
	var InitialOtherPaymentPO = $('#InitialOtherPaymentPO').val();
	var InitialOtherPaymentPOAmount = $('#InitialOtherPaymentPOAmount').val();
	var InitialOtherReferenceNum = $('#InitialOtherReferenceNum').val();
	var InitialOtherpaymentDate = $('#InitialOtherpaymentDate').val();
	var InitialOtherTrasaction = $('#InitialOtherTrasaction').val();
	var InitialOtherRemarks = $('#InitialOtherRemarks').val();
	var InitialOtherpaymentAmount = $('#InitialOtherpaymentAmount').val();
	var InitialOtherRemainingBal = $('#InitialOtherRemainingBal').val();

	var adjustment_deduction = $('#adjustment_deduction').val();

	var InitialPayment = $('#InitialPayment').val();

	var InitialOtherpaymentAmounts = $('#InitialOtherpaymentAmounts').val();

	var InitialOtherRFP = $('#InitialOtherRFP').val();

	var HistoryVendorCode = $('#HistoryVendorCode').val();
	var	HistoryAccountCode = $('#HistoryAccountCode').val();
	var HistoryPaymentTermCode = $('#HistoryPaymentTermCode').val();
	var HistoryAccountCurrency = $('#HistoryAccountCurrency').val();
	var HistoryProformaInvoice = $('#HistoryProformaInvoice').val();
	var HistoryCompany = $('#HistoryCompany').val();
	var HistoryFinal = $('#HistoryFinal').val();


	$.ajax({
		 url: '<?php echo base_url(). "telegraphicTransferController/updateOtherPaymentTBL" ?>',
		 type: 'POST',
		 data: {
			type: FetchOtherTransactType,
			vendor: InitialOtherPaymentVendor,
			POnum: InitialOtherPaymentPO,
			POamt: InitialOtherPaymentPOAmount,
			referenceNo: InitialOtherReferenceNum,
			POdate: InitialOtherpaymentDate,
			TransactType: InitialOtherTrasaction,
			remarks: InitialOtherRemarks,
			amt: InitialOtherpaymentAmount,
			amts: InitialOtherpaymentAmounts,
			remainBal: InitialOtherRemainingBal,
			adjustment_deductionOther: adjustment_deduction,
			rfp: InitialOtherRFP,

			updated_adjustment_deductions: InitialPayment,

			historyvendor: HistoryVendorCode,
			historyaccount: HistoryAccountCode,
			historycurrency: HistoryPaymentTermCode,
			historyaccountCurrency: HistoryAccountCurrency,
			historyproformaInvoice: HistoryProformaInvoice,
			historycompany_name: HistoryCompany,
			historyfinalInvoice: HistoryFinal,
		 },
		 dataType: 'JSON',
		 success: function(res){

			if(res.stats == 1)
			{
				swal({
				title: "error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.stats == 2)
			{
				swal({
				title: "error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.stats == 3)
			{
				swal({
				title: "error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.stats == 4)
			{
				swal({
				title: "error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else if(res.stats == 7)
			{
				swal({
				title: "error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}
			
			else if(res.stats == 5)
			{
				swal({
				title: "Success",
				text: res.message,
				type: "success",
				closeOnClickOutside: false
				});

				$('#modalOtherInitialpayment').hide();

				$('#InitialOtherRemarks').val('');
				$('#InitialOtherpaymentAmount').val('');
				$('#InitialOtherReferenceNum').val('');

				$('#btnInitialPayClose').hide();

				$('#btnInitialPaymentClose').show();

				$("#btnAddInitialPayment").prop('disabled', true);
				$('#AddOtherPaymentBTN').prop('disabled', true);

				//FETCH OTHER PAYMENT
				$.ajax({
				url: "<?php echo base_url(). 'telegraphicTransferController/fetchOtherPaymentDatatoTBL' ?>",
				type: 'POST',
				data: { po_num: InitialOtherPaymentPO,
				vendorCode: InitialOtherPaymentVendor},
				dataType: 'JSON',
				success: function(res){

						var tableBody = $('#Othertbody');

						tableBody.empty();

						$.each(res, function(index, item){

						var newRow = $('<tr>');

						// Create and append cells for each property
						newRow.append($('<td>').html(item.otherPONumber));
						newRow.append($('<td>').html(item.otherTransacTypeName));
						newRow.append($('<td>').html(item.transact_name));
						newRow.append($('<td>').html(item.referenceNumber));
						newRow.append($('<td>').html(item.otherPODate));
						newRow.append($('<td>').html(item.amount));
						newRow.append($('<td>').html(item.otherTotalDeduc));
						newRow.append($('<td>').html(item.total));
						newRow.append($('<td>').html(item.Remarks));
						newRow.append($('<td>').html(item.rfp));

						// Append the row to the table body
						tableBody.append(newRow);

						//inital payment
						$('#InitialRemainingBalance').val(item.transAmt);

						//other
						$('#InitialOtherPaymentPOAmount').val(item.otherPOAmount);

						$('#adjustment_deduction').val(item.sumTotalDeduct);

						//other - balance
						$('#InitialOtherRemainingBal').val(item.updated_deduct_adjustment);

		
				
						})

					}
				});

				


			}

			else if(res.stats == 6)
			{
				swal({
				title: "Success",
				text: res.message,
				type: "success",
				closeOnClickOutside: false
				});

				$('#modalOtherInitialpayment').hide();

				$('#InitialOtherRemarks').val('');
				$('#InitialOtherpaymentAmount').val('');
				$('#InitialOtherReferenceNum').val('');

				$('#btnInitialPayClose').hide();

				$('#btnInitialPaymentClose').show();

				//FETCH OTHER PAYMENT
				$.ajax({
				url: "<?php echo base_url(). 'telegraphicTransferController/fetchOtherPaymentDatatoTBL' ?>",
				type: 'POST',
				data: { po_num: 	InitialOtherPaymentPO,
						vendorCode: InitialOtherPaymentVendor},
				dataType: 'JSON',
				success: function(res){

						var tableBody = $('#Othertbody');

						tableBody.empty();

						$.each(res, function(index, item){

						var newRow = $('<tr>');

						// Create and append cells for each property
						newRow.append($('<td>').html(item.otherPONumber));
						newRow.append($('<td>').html(item.otherTransacTypeName));
						newRow.append($('<td>').html(item.transact_name));
						newRow.append($('<td>').html(item.referenceNumber));
						newRow.append($('<td>').html(item.otherPODate));
						newRow.append($('<td>').html(item.updated_deduct_adjustment));
						newRow.append($('<td>').html(item.otherTotalDeduc));
						newRow.append($('<td>').html(item.total));
						newRow.append($('<td>').html(item.Remarks));
						newRow.append($('<td>').html(item.rfp));

						// Append the row to the table body
						tableBody.append(newRow);
	
						//inital payment
						$('#InitialRemainingBalance').val(item.updateRemainBal);
					
						//other
						$('#InitialOtherPaymentPOAmount').val(item.updateRemainBal);

						//other - balance
						$('#InitialOtherRemainingBal').val(item.updateRemainBal);
	
						$('#InitialPayment').val(item.updated_deduct_adjustment);	

						$('#InitialPaymentLatest').val(item.updated_deduct_adjustment);

						$('#adjustment_deduction').val(item.sumTotalDeduct);
		
	
						})

					}
				});
			}

			else
			{
				swal({
				title: "error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}

		}
		});

})

function FullPaymentFunction(PO_NUMBER)
{
	var FPPONumber = $('#FPPONumber');
	var FPDate = $('#FPDate');
	var FPAmount = $('#FPAmount');
	var FPTotalPayment = $('#FPTotalPayment');
	var FPRemainBal = $('#FPRemainBal');
	var FPPaymentType = $('#FPPaymentType');
	var FPDateCreated = $('#FPDateCreated');
	var FPChange = $('#FPChange');

	$.ajax({
		 url: "<?php echo base_url(). 'telegraphicTransferController/viewFullpayment' ?>",
		 type: 'POST',
		 data: {PO_number: PO_NUMBER},
		 dataType: 'JSON',
		 success: function(res){

			FPPONumber.html(res.PO_number);
			FPDate.html(res.PO_date);
			FPAmount.html(res.PO_amount);
			FPTotalPayment.html(res.total_payment);
			FPChange.html(res.change);
			FPRemainBal.html(res.total_balance);
			FPPaymentType.html(res.paymentName);
			FPDateCreated.html(res.date_created);

			}
		});

}

$('#POAmount').on('input', function() {
        var inputValue = $(this).val();
        var regex = /^[0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\-]+$/; // Allow special characters and numbers

        if (!regex.test(inputValue)) {
        //   alert('Please enter special characters and numbers only');
          $(this).val(inputValue.replace(/[^0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/g, '')); // Remove non-special characters
        }
});

$('#btnInitialPayClose1').click(function(){
	
	setTimeout(function(){ window.location.reload(); }, delay1);
})



$('#nonPORelatedPaymentBtn').click(function(){
	
	var nonPORelatedVendor = $('#nonPORelatedVendor').val();
	var nonPORelatedPO = $('#nonPORelatedPO').val();
	var nonPORelatedDate = $('#nonPORelatedDate').val();
	var nonPORelatedType = $('#nonPORelatedType').val();
	var nonPORelatedTransaction = $('#nonPORelatedTransaction').val();
	var nonPORelatedReferenceNo = $('#nonPORelatedReferenceNo').val();
	var nonPORelatedRemarks = $('#nonPORelatedRemarks').val();
	var nonPORelatedAmount = $('#nonPORelatedAmount').val();
	var nonPORelatedRFP = $('#nonPORelatedRFP').val();

	var nonPORelatedAmount2 = $('#nonPORelatedAmount2').val();

	

	$.ajax({
	url: "<?php echo base_url(). 'telegraphicTransferController/insertInitialOtherTransactNONPO' ?>",
	type: 'POST',
	data: { VendorPaymentNONPO: nonPORelatedVendor,
			PaymentNONPO: nonPORelatedPO,
			DateNONPO: nonPORelatedDate,
			TransactTypeNONPO: nonPORelatedType,
			TrasactionNONPO: nonPORelatedTransaction,
			ReferenceNoNONPO: nonPORelatedReferenceNo,
			RemarksNONPO: nonPORelatedRemarks,
			AmountNONPO: nonPORelatedAmount,
			Amount2: nonPORelatedAmount2,
			RFPNONPO: nonPORelatedRFP
		},
	dataType: 'JSON',
	success: function(res){

			if(res.status == 1)
			{
				swal({
					title: "Error",
					text: res.message,
					type: "error",
					closeOnClickOutside: false
					});
			}

			else if(res.status == 1.1)
			{
				swal({
					title: "Error",
					text: res.message,
					type: "error",
					closeOnClickOutside: false
					});
			}

			else if(res.status == 1.2)
			{
				swal({
					title: "Error",
					text: res.message,
					type: "error",
					closeOnClickOutside: false
					});	
			}

			else if(res.status == 1.3)
			{
				swal({
					title: "Error",
					text: res.message,
					type: "error",
					closeOnClickOutside: false
					});
			}

		
			else if(res.status == 2)
			{
				swal({
				title: "Success",
				text: res.message,
				type: "success",
				closeOnClickOutside: false
				});

				$('#modalOtherpaymentNonPOTBL').hide();

				//clear data in field
				$('#nonPORelatedReferenceNo, #nonPORelatedRemarks, #nonPORelatedAmount, #nonPORelatedRFP').val('');


				//fetch OtherPaymentNonPO Related
				$.ajax({
				url: "<?php echo base_url(). 'telegraphicTransferController/fetchNONPOdataToTBL' ?>",
				type: 'POST',
				data: {
					po: nonPORelatedPO ,
					vendor: nonPORelatedVendor
					},
				dataType: 'JSON',
				success: function(res){

					// console.log(res);



					$('#btnInitialPayClose').hide();

					$('#btnInitialPayClose1').show();

						var tableBody = $('#OthertbodyNonPO');

						tableBody.empty();

						$.each(res, function(index, item){

						var newRow = $('<tr>');

						// Create and append cells for each property
						newRow.append($('<td>').html(item.formattedDate));
						newRow.append($('<td>').html(item.otherTransacTypeName));
						newRow.append($('<td>').html(item.transactionName));
						newRow.append($('<td>').html(item.reference_no));
						newRow.append($('<td>').html(item.amount2));	
						newRow.append($('<td>').html(item.amount));	
						newRow.append($('<td>').html(item.total));	
						newRow.append($('<td>').html(item.remarks));
						newRow.append($('<td>').html(item.rfp));

						// Append the row to the table body
						tableBody.append(newRow);

						//value for input
				

						$('#nonPORelatedVendor').val(item.vendor);
						$('#nonPORelatedPO').val(item.po_number);
						
						

						})

					}
				});
			}

			else
			{
				swal({
				title: "Error",
				text: res.message,
				type: "error",
				closeOnClickOutside: false
				});
			}
			



	}
	});




})



</script>