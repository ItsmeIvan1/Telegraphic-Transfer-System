<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Telegraphic Transfer Invoice</h4>
			</div>

			<div class="heading-elements">
				<div class="heading-btn-group">
				</div>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="<?php echo base_url();?>mainController/afterLogin"><i class="icon-home2 position-left"></i> Home</a></li>
				<li class="active">Telegraphic Transfer Invoice</li>
			</ul>

			<ul class="breadcrumb-elements">
			
			</ul>
		</div>
</div>

	
	<div class="content">
			<div style="padding-bottom: 10px; display: flex;">
				<div>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form_vertical_invoice"><i class="icon-spinner9 position-left"></i> Process</button>	
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-flat">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table datatable-basic" id="homeTableInvoice"> 
													<thead>
														<tr class="bg-success">

														<th>Vendor</th>
														<th>Account</th>  
														<th>Company</th>  
														<th>Invoice No.</th>
														<th>Invoice Date</th>
														<th>Currency</th>
														<th>Amount</th>
														<th>Payment</th>
														<!-- <th>Proforma invoice</th>
														<th>Commercial invoice</th>
														<th>RFP reference</th> -->
														
														<!-- <th>Final invoice</th>
														<th>Credit note</th>
														<th>Debit note</th>
														<th>Wire transfer fee</th> -->
														<th>Remarks</th>
														<th>Status</th>
														<th class="text-center	">Action</th>
														
														</tr>
													</thead>
													<tbody>

														<?php foreach($data as $datas){ ?>  
														<tr>
														<td><?php echo $datas['vendorName']  ?></td>
														<td><?php echo $datas['accountNumber'] ?></td>
														<td><?php echo $datas['company_name'] ?></td>
														<td><?php echo $datas['InvoiceNumber'] ?></td>
														<td><?php echo $datas['InvoiceDate'] ?></td>
														<td><?php echo $datas['currency'] ?></td>
														<td><?php echo $datas['InvoiceAmount'] ?></td>
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
																			<a href="" class="" onclick="InitialPaymentFunction('<?php echo $datas['InvoiceNumber'] ?>','<?php echo $datas['vendorCode'] ?>')" data-toggle="modal" data-target="#modalInitialInvoicePaymentDetails"><i class="icon icon-cash position-left"></i>Pay</a>
																		</li>																
																		<?php } else { ?>
																		<li>
																			<a href="" class="" onclick=FullPaymentFunction(<?php echo $datas['InvoiceNumber'] ?>) data-toggle="modal" data-target="#modalFullpayment"><i class="icon icon-cash position-left"></i>Pay</a>
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


</div>

	<!-- modal for adding  -->
	<div id="modal_form_vertical_invoice" class="modal fade in" tabindex="-1" data-backdrop="static">
			<div class="modal-dialog modal-full">
				<div class="modal-content">
					<div class="modal-header bg-primary">
						<button type="button" class="close" data-dismiss="modal" id="xBtnAddInvoice">×</button>
						<h5 class="modal-title">Telegraphic transfer Invoice</h5>
					</div>

					<form id="TTSformInvoice">
						<div class="modal-body">
							<div class="form-group">
								<div class="row" style="padding-bottom: 10px;">
									<div class="col-md-4">
										<div class="col-sm-12" style="padding-bottom: 12px;">
											<label>Vendor name <span style='color:red;'>*</span></label>
											<select class="form-control" name="vendorCodeInvoice" id="vendorCodeInvoice">
												<option value="">Select vendor</option>

												<?php foreach($vendorCode as $vendorCodes){ ?>
												<option value="<?php echo $vendorCodes['vendorCode'] ?>"><?php echo $vendorCodes['vendorName'] ?></option>
												<?php } ?>
											</select>
										</div>

										<div class="col-sm-12" >
											<label>Account code <span style='color:red;'>*</span></label>
												<select class="form-control" name="accCodeInvoice" id="accCodeInvoice">
											
												</select>

										</div>

										<div class="col-sm-12" style="padding-top: 5px;">
											<label>Company <span style='color:red;'>*</span></label>
											<select class="form-control"  name="CompanyCodeInvoice" id="CompanyCodeInvoice" >
												<option value="">Select company</option>
												<?php foreach($Company as $Companys){ ?>
												<option value="<?php echo $Companys['company_id'] ?>"><?php echo $Companys['company_name'] ?></option>
												<?php }?>

											</select>
										</div>
										
										<div class="col-sm-12" style="padding-top: 5px;">
											<label>Invoice number <span style='color:red;'>*</span></label>
											<input type="text" class="form-control" name="InvoiceNumber" id="InvoiceNumber">				
										</div>

										<div class="col-sm-12" style="padding-top: 5px;">
											<label>Invoice date <span style='color:red;'>*</span></label>
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar22"></i></span>
												<input type="text" placeholder="Select date" class="form-control pickadate-accessibility picker__input" name="PODateInvoice" id="PODateInvoice">
											</div>
										</div>
										
										<div class="col-sm-12" style="padding-top: 5px;">
											<label>Invoice amount <span style='color:red;'>*</span></label>
											<input class="form-control" name="POAmountInvoice" id="POAmountInvoice">
										</div>

										<div class="col-sm-12" style="padding-top: 5px;">
											<label>Proforma invoice </label>
											<input class="form-control" name="ProformaInvoiceInvoice" id="ProformaInvoiceInvoice" >
										</div>
			
										<div class="col-sm-12" style="padding-top: 5px;">
											<label>Commercial invoice </label>
											<input class="form-control" name="CommercialInvoiceInvoice" id="CommercialInvoiceInvoice" >
										</div>

										<div class="col-sm-12" style="padding-top: 5px;">
											<label>Remarks </label>
											<input class="form-control" name="RemarksInvoice" id="RemarksInvoice" >
										</div>

										<div class="col-sm-12" style="padding-top: 5px;">
											<label>RFP <span style="color: red;">*</span></label>
											<input class="form-control" name="RFPInvoice" id="RFPInvoice" >
										</div>
										
									</div>

									<div class="col-md-8" >
										<div id="formBtnPaymentInvoice" style="padding-bottom: 1px;">
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalpaymentInvoice" id="btnAddPayment">Add payment</button>
										</div>
										

										<div class="panel panel-flat" id="paymentFormCommercial">
											<div class="panel-heading">
												<h6 class="panel-title" style="font-weight: bold;">Payment history</h6>
											</div>
											<div class="panel-body">
												<table class="table datatable-basic" id="PaymentTable">
														<thead>
															<tr>
																<th>Invoice #</th>
																<th>Payment type</th>
																<th>Invoice amount</th>
																<th>Date created</th>
																<th>Remarks</th>
																<th>Rfp</th>
															
															
															</tr>
														</thead>
														<tbody>
															<tr>
														
																<td id="firstInvoice"></td>
																<td id="secondInvoice"></td>
																<td id="thirdInvoice"></td>
																<td id="fourthInvoice"></td>
																<td id="sixthInvoice"></td>
																<td id="fifthInvoice"></td>
																<!-- <td></td> -->
															</tr>
														</tbody>
												</table>

													<div style="padding-top: 3px;">
														
														<p id="totalPaymentInvoice" style="font-weight: bold;"></p>
														<p id="remainingBalanceInvoice" style="font-weight: bold;"></p>
														<p id="changeInvoice" style="font-weight: bold;"></p>	
													</div>
											</div>
										</div>

										<!-- other payment table -->
										<div id="" style="padding-bottom: 1px;">
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalOtherpaymenInvoice" id="btnAddOtherPayment">Add other payment</button>
										</div>

										<div class="panel panel-flat" id="" >	
											<div class="panel-heading">
												<h6 class="panel-title" style="font-weight: bold;">Invoice Related History</h6>
											</div>

											<div class="panel-body">
												<table class="table datatable-basic" id="PaymentTable">
														<thead>
															<tr>
																<th>Invoice #</th>
																<th>Type</th>
																<th>Transaction type</th>
																<th>Reference no.</th>
																<th>Date created</th>
																<th>Remarks</th>
																<th>Rfp</th>
															
															
															</tr>
														</thead>
														<tbody>
															<tr>
														
																<td id="otherFirstInvoice"></td>
																<td id="otherSecondInvoice"></td>
																<td id="otherThirdInvoice"></td>
																<td id="otherFourthInvoice"></td>
																<td id="otherFifthInvoice"></td>
																<td id="otherSixthInvoice"></td>
																<td id="otherSeventhInvoice"></td>
																
																
															</tr>
														</tbody>
												</table>

													<div style="padding-top: 3px;">
													
														<p id="transAmtInvoice" style="font-weight: bold;"></p>

														<p id="OtherRemainBalanceInvoice" style="font-weight: bold;"></p>
														
													</div>

											</div>
										</div>	
	
										<!-- other non invoice payment table -->
										<div id="" style="padding-bottom: 1px;">
											<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalOtherInitialpaymentNonInvoice" id="NonInvoiceBtn">Non Invoice</button>
										</div>

										<div class="panel panel-flat" id="" >
				
											<div class="panel-heading">
												<h6 class="panel-title" style="font-weight: bold;">Non Invoice Related History</h6>
											</div>
											<div class="panel-body">
												<table class="table datatable-basic" id="PaymentTable">
														<thead>
															<tr>
																<th>Type</th>
																<th>Date </th>
																<th>Transaction</th>
																<th>Reference</th>
																<th>Amount</th>
																<th>Remarks</th>
																<th>Rfp</th>
															
															
															</tr>
														</thead>
														<tbody>
															<tr>
														
																<td id="NonInvoiceType"></td>
																<td id="NonInvoiceDate"></td>
																<td id="NonInvoiceTransact"></td>
																<td id="NonInvoiceReference"></td>
																<td id="NonInvoiceAmount2"></td>
																<td id="NonInvoiceRemarks"></td>
																<td id="NonInvoiceRfp"></td>
																
																
																
															</tr>
														</tbody>
												</table>

												<div style="padding-top: 3px;">

													<p id="NonInvoiceAmount" style="font-weight: bold;"></p>
													<p id="NonInvoicetotal" style="font-weight: bold;"></p>

												</div>

											</div>
									    </div>
									</div> 
								</div>			
							</div>
						</div>
					</form>

					<div class="modal-footer" id="mdlfooter">
						<button type="button" class="btn btn-warning" data-dismiss="modal" id="clsBtnInvoice" style="display: none;">Close</button>
						<button type="button" class="btn btn-success" id="InsertTTSInvoiceBtn">Process</button>
					</div>
		
				</div>
			</div>
	</div>

	<!-- modal for first initial payment -->
	<div id="modalpaymentInvoice" class="modal fade" tabindex="-1" data-backdrop="static">
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
											
											<select class="form-control" id="VendorPaymentInvoice" disabled>
												<?php foreach($vendorCode as $vendor){ ?>
												<option value="<?php echo $vendor['vendorCode'] ?>"><?php echo $vendor['vendorName'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12">
											<label>Invoice #</label>
											<input type="text" class="form-control" id="PaymentInvoice" readonly>
										</div>
										<div class="col-md-12">
											<label>Invoice date</label>
											<input type="text" class="form-control" id="paymentDateInvoice" readonly>
										</div>
										<div class="col-md-12">
											<label>Invoice amount</label>
											<input type="text" class="form-control" id="PaymentPOAmountInvoice" readonly>
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
										
										<input type="hidden" name="PaymentAccountCodeInvoice" id="PaymentAccountCodeInvoice">
										<input type="hidden" name="PaymentCurrencyInvoice" id="PaymentCurrencyInvoice">
										<input type="hidden" name="PaymentProformaInvoices" id="PaymentProformaInvoices">
										<input type="hidden" name="PaymentCommercialInvoices" id="PaymentCommercialInvoices">
										<input type="hidden" name="PaymentCompCodeInvoice" id="PaymentCompCodeInvoice">
										<input type="hidden" name="PaymentRFPInvoice" id="PaymentRFPInvoice">

										<div class="col-md-12">
											<label>Date</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar22"></i></span>
												<input type="text" placeholder="Select date" class="form-control pickadate-accessibility picker__input" name="InitialDate" id="InitialDate">
											</div>
										</div>			

										<div class="col-md-12">
											<label>Payment <span style="color: red;">*</span></label>
											<input type="text" id="paymentAmountInvoice" class="form-control">
										</div>

										<div class="col-md-12">
											<label>Remarks</label>
											<input type="text" id="paymentAmountRemarks" class="form-control">
										</div>

										<div class="col-md-12">
											<label>RFP <span style="color: red;">*</span></label>
											<input type="text" id="paymentAmountRFP" class="form-control">
										</div>
										
										
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="btnCloseAddPaymentInvoice">Close</button>
									<button type="button" class="btn btn-primary" id="btnPaymentSaveInvoice">Pay</button>
								</div>
							</div>
						</div>
	</div>

	<!-- modal for first initial other payment -->
	<div id="modalOtherpaymenInvoice" class="modal fade" tabindex="-1" data-backdrop="static">
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
											<input type="hidden" class="form-control" id="OtherVendorPaymentInvoice" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>Invoice #<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="OtherPaymentInvoice" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;"> -->
											<!-- <label>Invoice date<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="OtherpaymentDateInvoice" disabled>
										<!-- </div> -->
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Remaining balance<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="OtherRemainBal" readonly>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Paid amount<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="OtherPaidAmount" readonly>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Type <span style="color: red;">*</span></label>
											<select class="form-control" id="OtherTransactTypeInvoice">
												<?php foreach($otherTrans as $otherTranss){ ?>
												<option value="<?php echo $otherTranss['otherTransacTypeCode'] ?>"><?php echo $otherTranss['otherTransacTypeName'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Transaction Type <span style="color: red;">*</span></label>
					
											<select class="form-control" id="OtherTrasactionInvoice">
												<?php foreach($transact_2 as $transact_2s){ ?>
												<option value="<?php echo $transact_2s['id'] ?>"><?php echo $transact_2s['transact_name'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Reference No<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="OtherReferenceNoInvoice">
										</div>
										<div class="col-md-12" style="padding-top: 5px; display: none;">
											<label>Invoice amount<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="OtherPaymentPOAmountInvoice" readonly>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Remarks</label>
											<input type="text" class="form-control" id="OtherRemarksInvoice" >
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Amount <span style="color: red;">*</span></label>
											<input type="text" id="otherAmountInvoice" class="form-control">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Rfp <span style="color: red;">*</span></label>
											<input type="text" id="otherRfpInvoice" class="form-control">
										</div>
										
									</div>
							
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
									<button type="button" class="btn btn-primary" id="otherPaymentBtnInvoice">Pay</button>
								</div>
							</div>
						</div>
	</div>

	<!-- modal for payment details initial and Other Invoice payment -->
	<div id="modalInitialInvoicePaymentDetails" class="modal fade" tabindex="-1" data-backdrop="static">
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" id="btnInitialPayClose">&times;</button>
					<button type="button" class="close" data-dismiss="modal" id="btnInitialPayClose1" style="display: none;">&times;</button>
					<h5 class="modal-title">Initial Invoice Payment</h5>
				</div>

				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div style="padding-bottom: 2px;">
							<button class="btn btn-primary" data-toggle="modal" data-target="#modalAnotherInitialpaymentInvoice" id="btnAddInitialPayment">Add payment</button>
							</div>
							<!-- initial payment -->
							<div class="pre-scrollable">
									<table class="table datatable-basic" id="">
										<thead>
											<tr class="bg-success-400">
												<th>Invoice#</th>
												<th>Amount</th>
												<th>Payment</th>
												<th>Balance</th>
												<th>Payment</th>
												<th>Date Created</th>
												<th>Remarks</th>
												<th>RFP</th>
											
											
											</tr>
										</thead>
										<tbody id="InitialPaymentInvoiceTbl">
						
										</tbody>
									</table>
							</div>	
						</div>

						<div class="col-md-6">

							<!-- otherpayment -->
							<div style="padding-bottom: 2px;">
								<button class="btn btn-primary" data-toggle="modal" data-target="#modalOtherInitialpaymentInvoice" id="AddOtherPaymentBTN">Add other payment</button>
							</div>
							
				
							<div class="pre-scrollable">
									<table class="table datatable-basic" id="">
										<thead>
											<tr class="bg-success-400">
												<th>Invoice#</th>
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
							
							<!-- Non Invoice Related -->
							<div style="padding-bottom: 2px;">
								<button class="btn btn-primary" data-toggle="modal" data-target="#modalNonInvoiceRelated" id="AddNonInvoiceBtn">Non Invoice</button>
							</div>

							<div class="pre-scrollable">
									<table class="table datatable-basic" id="">
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
										<tbody id="OthertbodyNonRelated">
						
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

	<!-- modal for add another initial payment -->
	<div id="modalAnotherInitialpaymentInvoice" class="modal fade" tabindex="-1" data-backdrop="static">
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
									
										<!-- <label>Vendor name</label> -->
										<input type="hidden" class="form-control" id="InitialPaymentVendor" disabled>
										
										<!-- <div class="col-md-12">
											<label>Invoice #<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="InitialPaymentInvoice" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>Invoice date<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="InitialpaymentDateInvoice" disabled>
										<!-- </div> -->
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Invoice amount<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="InitialPaymentInvoiceAmount" disabled>
										</div>
										<div class="col-md-12" style="padding-top: 5px;"> 
											<label>Remaining balance<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="InitialRemainingBalance" disabled>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Total payment<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="InitialTotalPayment" disabled>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Initial payment<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="InitialUpdatedPayment" disabled>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Payment type<span style="color: red;">*</span></label>
											<select class="form-control" id="InitialpaymentTypePay" disabled>
												<?php foreach($payment as $payments){ ?>
													<option value="<?php echo $payments['paymentTermCode'] ?>"><?php echo $payments['paymentName'] ?></option>
													<?php } ?>
											</select>
										</div>

										<div class="col-md-12">
											<label>Date</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar22"></i></span>
												<input type="text" placeholder="Select date" class="form-control pickadate-accessibility picker__input" name="UPDATEInitialDate" id="UPDATEInitialDate">
											</div>
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Amount<span style="color: red;">*</span></label>
											<input type="text" id="InitialpaymentAmount" class="form-control">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Remarks</label>
											<input type="text" id="InitialRemarks" class="form-control">
										</div>

										
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Rfp<span style="color: red;">*</span></label>
											<input type="text" id="InitialpaymentRfp" class="form-control">
										</div>

										<!-- hidden -->
										<input type="hidden" class="form-control" id="InvoiceHistoryVendorCode" >
										<input type="hidden" class="form-control" id="InvoiceHistoryAccountCode" >
										<input type="hidden" class="form-control" id="InvoiceHistoryPaymentTermCode" >
										<input type="hidden" class="form-control" id="InvoiceHistoryAccountCurrency" >
										<input type="hidden" class="form-control" id="InvoiceHistoryInvoiceNumber" >
										<input type="hidden" class="form-control" id="InvoiceHistoryInvoiceDate" >
										<input type="hidden" class="form-control" id="InvoiceHistoryInvoiceAmount" >
										<input type="hidden" class="form-control" id="InvoiceHistoryProformaInvoice" >
										<input type="hidden" class="form-control" id="InvoiceHistoryCompany" >
										<input type="hidden" class="form-control" id="InvoiceHistoryCommercialInvoice" >
										<input type="hidden" class="form-control" id="InvoiceHistoryStatus" >
										<input type="hidden" class="form-control" id="InvoiceHistoryRemarks" >
										<input type="hidden" class="form-control" id="InvoiceHistoryRfp" >

										
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
									<button type="button" class="btn btn-primary" id="AddAnotherPaymentInvoice">Pay</button>
								</div>
							</div>
						</div>
	</div>

	<!-- modal for add another other payment -->
	<div id="modalOtherInitialpaymentInvoice" class="modal fade" tabindex="-1" data-backdrop="static">
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


										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>Invoice #<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="InitialOtherPaymentInvoice" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;"> -->
											<!-- <label>Invoice date<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="InitialOtherpaymentInvoiceDate" disabled>
										<!-- </div> -->
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Invoice amount<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="InitialOtherPaymentInvoiceAmount" disabled>
										</div>
										<!-- <div class="col-md-12" style="padding-top: 5px;"> -->
											<!-- <label>Remaining balance<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="InitialOtherRemainingBal" disabled>
										<!-- </div> -->
										<!-- <div class="col-md-12" style="padding-top: 5px;"> -->
											<!-- <label>Initial Payment<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="InitialUpdatePay" disabled>
										<!-- </div> -->
										<input type="hidden" class="form-control" id="adjustment_deduction" value ='0' disabled>
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
												<?php foreach($transact_2 as $transact_2s){ ?>
												<option value="<?php echo $transact_2s['id'] ?>"><?php echo $transact_2s['transact_name'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Reference No.<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="InitialOtherReferenceNum">
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Remarks</label>
											<input type="text" class="form-control" id="InitialOtherRemarks" >
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
											<label>Rfp<span style="color: red;">*</span></label>
											<input type="text" id="InitialOtherpaymentRfp" class="form-control">
										</div>
										
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
									<button type="button" class="btn btn-primary" id="AddOtherPaymentInvoice">Pay</button>
								</div>
							</div>
						</div>
	</div>

	<!-- modal for add another other Non Invoice payment -->
	<div id="modalNonInvoiceRelated" class="modal fade" tabindex="-1" data-backdrop="static">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" >&times;</button>
									<h5 class="modal-title">Other Payment</h5>
								</div>

								<div class="modal-body">
									<div class="row">
										
									
										<!-- <label>Vendor name</label> -->
										<input type="hidden" class="form-control" id="NonInvoiceRelatedVendor" disabled>


										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>Invoice #<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="NonInvoiceRelatedNumber" disabled>
										<!-- </div> -->
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Date<span style="color: red;">*</span></label>
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar22"></i></span>
												<input type="text" placeholder="Select date" class="form-control pickadate-accessibility picker__input" id="NonInvoiceRelatedDate">
											</div>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Type<span style="color: red;">*</span></label>
											<select class="form-control" id="NonInvoiceRelatedType" >
												<?php foreach($otherTrans as $otherTranss){ ?>
												<option value="<?php echo $otherTranss['otherTransacTypeCode'] ?>"><?php echo $otherTranss['otherTransacTypeName'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Transaction type<span style="color: red;">*</span></label>
											<select class="form-control" id="NonInvoiceRelatedTransactType">
												<?php foreach($deduc as $deducs){ ?>
												<option value="<?php echo $deducs['transactionCode'] ?>"><?php echo $deducs['transactionName'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Reference No.<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="NonInvoiceRelatedReferenceNo">
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Remarks</label>
											<input type="text" class="form-control" id="NonInvoiceRelatedRemarks" >
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Amount<span style="color: red;">*</span></label>
											<input type="text" id="NonInvoiceRelatedAmounts" class="form-control">
										</div>
										
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Payment<span style="color: red;">*</span></label>
											<input type="text" id="NonInvoiceRelatedAmount" class="form-control">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Rfp<span style="color: red;">*</span></label>
											<input type="text" id="NonInvoiceRelatedRfp" class="form-control">
										</div>
										
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
									<button type="button" class="btn btn-primary" id="NonInvoicePaymentBtn">Pay</button>
								</div>
							</div>
						</div>
	</div>

	<!-- modal for add another other payment -->
	<div id="modalOtherInitialpaymentNonInvoice" class="modal fade" tabindex="-1" data-backdrop="static">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" >&times;</button>
									<h5 class="modal-title">Other Payment</h5>
								</div>

								<div class="modal-body">
									<div class="row">
										
									
										<!-- <label>Vendor name</label> -->
										<input type="hidden" class="form-control" id="InitialNonInvoicePaymentVendor" disabled>


										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>Invoice #<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="InitialNonInvoice" disabled>
										<!-- </div> -->
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Invoice date<span style="color: red;">*</span></label>
											<input type="text" class="form-control daterange-single" name="InitialNonInvoiceDate" id="InitialNonInvoiceDate">
										</div>
										
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Type<span style="color: red;">*</span></label>
											<select class="form-control" id="FetchOtherNonTransactType" >
												<?php foreach($otherTrans as $otherTranss){ ?>
												<option value="<?php echo $otherTranss['otherTransacTypeCode'] ?>"><?php echo $otherTranss['otherTransacTypeName'] ?></option>
												<?php } ?>
											</select>
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Transaction type<span style="color: red;">*</span></label>
											<select class="form-control" id="InitialOtherNonTrasaction">
												<?php foreach($deduc as $deducs){ ?>
												<option value="<?php echo $deducs['transactionCode'] ?>"><?php echo $deducs['transactionName'] ?></option>
												<?php } ?>
											</select>
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Amount<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="InitialNonAmounts">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Payment<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="InitialNonAmount">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Reference No.<span style="color: red;">*</span></label>
											<input type="text" class="form-control" id="InitialNonOtherReference">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Remarks</label>
											<input type="text" class="form-control" id="InitialNonOtherRemarks" >
										</div>
										

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Rfp<span style="color: red;">*</span></label>
											<input type="text" id="InitialNonRfp" class="form-control">
										</div>
										
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
									<button type="button" class="btn btn-primary" id="AddNonOtherPaymentInvoice">Pay</button>
								</div>
							</div>
						</div>
	</div>


<script>

	$('#li23').addClass('active');

	$('#homeTableInvoice').DataTable({
		lengthMenu: [5, 25, 50, 75, 100]
	});

	var	delay1 = 100;						

	$('.daterange-single').daterangepicker({ 
	singleDatePicker: true,
	//use if disable previos date
	// minDate: moment()

	isInvalidDate: function(date) {
	// Disable dates in the future
	return date.isAfter(moment());
		}
	});

	$('#btnInitialPayClose1').click(function(){
		
		setTimeout(function(){ window.location.reload(); }, delay1);
	})

	$('#InsertTTSInvoiceBtn').prop('disabled', true);

	$('#accCodeInvoice').prop('disabled', true);

	$('#NonInvoiceBtn').hide();

	$('#btnInitialPaymentClose').click(function(){

		setTimeout(function(){ window.location.reload(); }, delay1);
	})

	$('#clsBtnInvoice').click(function(){
		setTimeout(function(){ window.location.reload(); }, delay1);
	});

	$('#vendorCodeInvoice').change(function(){

		$('#accCodeInvoice').prop('disabled', false);
	})

	$('#accCodeInvoice').change(function(){

		$('#InsertTTSInvoiceBtn').prop('disabled', false);
	})

	$('#formBtnPaymentInvoice').hide();

	$('#btnAddOtherPayment').hide();

	$('#vendorCodeInvoice').change(function(){

		var vendorName = $(this).val();

		var accCode = $('#accCodeInvoice');
		var currency = $('#paymentTermCodeInvoice');


		$.ajax({
		url: '<?php echo base_url(). 'telegraphicInvoiceController/populateVendorToAccountInvoice' ?>',
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

	$('#InsertTTSInvoiceBtn').click(function(){
		
		var btn = $('#TTSformInvoice').serialize();
	
		$.ajax({
			url: '<?php echo base_url(). 'telegraphicInvoiceController/insertTelegraphicTransferInvoice' ?>',
			type: 'POST',
			data: btn,
			dataType: 'JSON' ,
			success: function(res){

				if(res.stat == 0)
				{
					swal({
					title: "Error",
					text: res.mess,
					type: "error",
					closeOnClickOutside: false
					});
				}



				else if(res.s == 4)
				{
					swal({
					title: "Error",
					text: res.m,
					type: "error",
					closeOnClickOutside: false
					});
				}

				else
				{	
					if(res.stats == 9)
					{
						swal({
						title: "Error",
						text: res.m,
						type: "error",
						closeOnClickOutside: false
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
							});

							$('#vendorCodeInvoice').prop('disabled', true);
							$('#accCodeInvoice').prop('disabled', true);
							$('#CompanyCodeInvoice').prop('disabled', true);
							$('#InvoiceNumber').prop('disabled', true);
							$('#PODateInvoice').prop('disabled', true);
							$('#POAmountInvoice').prop('disabled', true);
							$('#ProformaInvoiceInvoice').prop('disabled', true);
							$('#CommercialInvoiceInvoice').prop('disabled', true);
							$('#RFPInvoice').prop('disabled', true);

							$('#InsertTTSInvoiceBtn').prop('disabled', true);

							// $('#telcode').val(res.data.telCode);
							$('#formBtnPaymentInvoice').show();

							var vVendor = $('#VendorPaymentInvoice').val(res.data.vendorCode);
							var vPONumber = $('#PaymentInvoice').val(res.data.InvoiceNumber);
							var VPaymentAmount = $('#PaymentPOAmountInvoice').val(res.data.InvoiceAmount);
							var vPaymentDate = $('#paymentDateInvoice').val(res.data.InvoiceDate);

							var PaymentAccountCode = $('#PaymentAccountCodeInvoice').val(res.data.accountCode);
							var PaymentCurrency = $('#PaymentCurrencyInvoice').val(res.data.paymentTermCode);
							var PaymentProformaInvoice = $('#PaymentProformaInvoices').val(res.data.proformaInvoice);
							var PaymentCommercialInvoice = $('#PaymentCommercialInvoices').val(res.data.commercialInvoice);
							var PaymentCompCode = $('#PaymentCompCodeInvoice').val(res.data.compCode);
							var PaymentRFPInvoice = $('#PaymentRFPInvoice').val(res.data.rfp);
			

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
		});
		
	});

	//INITIAL PAYMENT
	$('#btnPaymentSaveInvoice').click(function(){
		
		var VendorPaymentInvoice = $('#VendorPaymentInvoice').val();
		var PaymentInvoice = $('#PaymentInvoice').val();
		var paymentDateInvoice = $('#paymentDateInvoice').val();
		var PaymentPOAmountInvoice = $('#PaymentPOAmountInvoice').val();
		var paymentAmountInvoice = $('#paymentAmountInvoice').val();
		var paymentAmountRFP = $('#paymentAmountRFP').val();
		var paymentAmountRemarks = $('#paymentAmountRemarks').val();

		var InitialDate = $('#InitialDate').val();

	
		//data 
		var PaymentAccountCodeInvoice = $('#PaymentAccountCodeInvoice').val();
		var PaymentCurrencyInvoice = $('#PaymentCurrencyInvoice').val();
		var PaymentProformaInvoices = $('#PaymentProformaInvoices').val();
		var PaymentCommercialInvoices = $('#PaymentCommercialInvoices').val();
		var PaymentCompCodeInvoice = $('#PaymentCompCodeInvoice').val();
		var PaymentRFPInvoice = $('#PaymentRFPInvoice').val();
		var RFPInvoice = $('#RFPInvoice').val();
		var RemarksInvoice = $('#RemarksInvoice').val();

		$.ajax({
		 url: '<?php echo base_url(). "telegraphicInvoiceController/insertPaymentInvoice" ?>' ,
		 type: 'POST',
		 data: {
			VendorP: 		VendorPaymentInvoice,
			InvoiceP: 		PaymentInvoice,
			PODateP: 		paymentDateInvoice,
			POAmountP: 		PaymentPOAmountInvoice,
			AmountP: 		paymentAmountInvoice,
			rfp:			paymentAmountRFP,
			date: 			InitialDate,
			remarks: 		paymentAmountRemarks,

			accountCodeP: 	PaymentAccountCodeInvoice,
			currencyP: 		PaymentCurrencyInvoice,
			proformaP: 		PaymentProformaInvoices,
			commercialP: 	PaymentCommercialInvoices,
			companyP: 		PaymentCompCodeInvoice,
			rfpP: 			RFPInvoice,
			remarksP: 		RemarksInvoice,
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

			else if(res.status == 0.1)
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
					text: res.messages,
					type: "error",
					closeOnClickOutside: false
					});
				}

				else if(res.status == 1.1)
				{ 
					swal({
					title: "Error",
					text: res.messages,
					type: "error",
					closeOnClickOutside: false
					});
				}

			//INITIAL PAYMENT
			else if(res.status == 2)
			{	

					swal({
					title: "Success",
					text: res.message,
					type: "success",
					closeOnClickOutside: false
					});

					$('#modalpaymentInvoice').hide();

					$('#btnAddPayment').prop('disabled', true);
					$('#InsertTTSInvoiceBtn').hide();

					$('#clsBtnInvoice').show();

					$('#xBtnAddInvoice').hide();

					//FIRST BUTTON
					$('#btnAddOtherPayment').show();

					//SECOND BUTTON
					$('#NonInvoiceBtn').show();

					$.ajax({
					url: "<?php echo base_url(). 'telegraphicInvoiceController/fetchdataPaymentInvoice' ?>",
					type: 'POST',
					data: {
						invoiceNum: PaymentInvoice,
						vendor_code: VendorPaymentInvoice
					},
					dataType: 'JSON',
					success: function(res){
						
					// $('#paymentForm').show();

					$('#firstInvoice').html(res.InvoiceNumber);
					$('#secondInvoice').html(res.paymentName);
					$('#thirdInvoice').html(res.InvoiceAmount);
					$('#fourthInvoice').html(res.InvoiceDate);
					$('#sixthInvoice').html(res.remarks);
					$('#fifthInvoice').html(res.rfp);

					$('#totalPaymentInvoice').html('Initial payment: ' + res.amount);
					$('#remainingBalanceInvoice').html('Remaining balance: ' + res.total_balance);
					// $('#changeInvoice').html('Change: ' + res.change);

					$('#OtherRemainBal').val(res.total_balance);

					$('#OtherVendorPaymentInvoice').val(res.vendor);
					$('#OtherPaymentInvoice').val(res.InvoiceNumber);
					$('#OtherpaymentDateInvoice').val(res.InvoiceDate);
					$('#OtherPaymentPOAmountInvoice').val(res.total_balance);
					$('#OtherPaidAmount').val(res.updated_Initial_payment);	

					$('#InitialNonInvoice').val(res.InvoiceNumber);

					$('#InitialNonInvoicePaymentVendor').val(res.vendor);

					}
					});
				

				
			}

			//FULL PAYMENT
			else if(res.status == 3)
			{	

					swal({
					title: "Success",
					text: res.message,
					type: "success",
					closeOnClickOutside: false
					});

					$('#modalpaymentInvoice').hide();

					$('#btnAddPayment').prop('disabled', true);
					$('#InsertTTSInvoiceBtn').hide();

					$('#clsBtnInvoice').show();

					$('#xBtnAddInvoice').hide();

					// $('#btnAddOtherPayment').show();

					$.ajax({
					url: "<?php echo base_url(). 'telegraphicInvoiceController/fetchdataPaymentInvoice' ?>",
					type: 'POST',
					data: {
						invoiceNum: PaymentInvoice,
						vendor_code: VendorPaymentInvoice
					},
					dataType: 'JSON',
					success: function(res){
						
					// $('#paymentForm').show();

				
					$('#firstInvoice').html(res.InvoiceNumber);
					$('#secondInvoice').html(res.paymentName);
					$('#thirdInvoice').html(res.InvoiceAmount);
					$('#fourthInvoice').html(res.InvoiceDate);
					$('#sixthInvoice').html(res.remarks);
					$('#fifthInvoice').html(res.rfp);
					
					$('#totalPaymentInvoice').html('Total payment: ' + res.amount);
					$('#remainingBalanceInvoice').html('Remaining balance: ' + res.total_balance);
					// $('#changeInvoice').html('Change: ' + res.change);


					$('#OtherVendorPaymentInvoice').val(res.vendor);
					$('#OtherPaymentInvoice').val(res.InvoiceNumber);
					$('#OtherpaymentDateInvoice').val(res.InvoiceDate);
					$('#OtherPaymentPOAmountInvoice').val(res.total_balance);

					$('#InitialNonInvoicePaymentVendor').val(res.vendor);
			
					}
					});
				


			}

		}
		});


	});

	$('#otherPaymentBtnInvoice').click(function(){

		var OtherVendorPaymentInvoice = $('#OtherVendorPaymentInvoice').val();
		var OtherPaymentInvoice = $('#OtherPaymentInvoice').val();
		var OtherpaymentDateInvoice = $('#OtherpaymentDateInvoice').val();
		var OtherPaymentPOAmountInvoice = $('#OtherPaymentPOAmountInvoice').val();

		var otherRfpInvoice = $('#otherRfpInvoice').val();

		var OtherPaidAmount = $('#OtherPaidAmount').val();

		var OtherRemainBal = $('#OtherRemainBal').val();

		var OtherTransactTypeInvoice = $('#OtherTransactTypeInvoice').val();
		var OtherTrasactionInvoice = $('#OtherTrasactionInvoice').val();
		var OtherReferenceNoInvoice = $('#OtherReferenceNoInvoice').val();
		var OtherRemarksInvoice = $('#OtherRemarksInvoice').val();
		var otherAmountInvoice = $('#otherAmountInvoice').val();

			$.ajax({
			url: "<?php echo base_url(). 'telegraphicInvoiceController/insertOtherPaymentInvoice' ?>",
			type: 'POST',
			data: {
				vendor: OtherVendorPaymentInvoice,
				invoiceNumber: OtherPaymentInvoice,
				invoiceDate: OtherpaymentDateInvoice,
				referenceNo: OtherReferenceNoInvoice,
				invoiceAmount: OtherPaidAmount,
				remarks: OtherRemarksInvoice,
				trans_type: OtherTransactTypeInvoice,
				deduc_type: OtherTrasactionInvoice,
				amount: otherAmountInvoice,
				insertTotalBal: OtherRemainBal,
				rfp: otherRfpInvoice
			},
			dataType: 'JSON',
			success: function(res){

				if(res.stats == 1)
				{
					swal({
					title: "Error",
					text: res.message,
					type: "error",
					closeOnClickOutside: false
					});
				}

				if(res.stats == 2)
				{
					swal({
					title: "Error",
					text: res.message,
					type: "error",
					closeOnClickOutside: false
					});
				}

				else if(res.stats == 3)
				{
					swal({
					title: "Error",
					text: res.message,
					type: "error",
					closeOnClickOutside: false
					});
				}

				else if(res.stats == 4)
				{
					swal({
					title: "Error",
					text: res.message,
					type: "error",
					closeOnClickOutside: false
					});
				}

				else if(res.stats == 5)
				{
					swal({
					title: "Error",
					text: res.message,
					type: "error",
					closeOnClickOutside: false
					});
				}

				//INITIAL PAY
				else if(res.stats == 6)
				{
					swal({
					title: "Success",
					text: res.message,
					type: "success",
					closeOnClickOutside: false
					});

					//payment modal will close
					$('#modalOtherpaymenInvoice').modal('hide');

					//button will disabled
					$('#btnAddOtherPayment').prop('disabled', true);

					$.ajax({
					url: "<?php echo base_url(). 'telegraphicInvoiceController/fetchOtherPaymentInvoice' ?>",
					type: 'POST',
					data: {
						invoiceNum: OtherPaymentInvoice,
						vendor_code: OtherVendorPaymentInvoice
					},
					dataType: 'JSON',
					success: function(res){
						


					$('#otherFirstInvoice').html(res.otherInvoiceNumber);
					$('#otherSecondInvoice').html(res.otherTransacTypeName);
					$('#otherThirdInvoice').html(res.transact_name);
					$('#otherFourthInvoice').html(res.referenceNumber);
					$('#otherFifthInvoice').html(res.otherInvoiceDate);
					$('#otherSixthInvoice').html(res.Remarks);
					$('#otherSeventhInvoice').html(res.rfp);

					$('#transAmtInvoice').html('Total: ' + res.otherTotalDeduc);
					$('#OtherRemainBalanceInvoice').html('Remaining balance: ' + res.update_Initial_deduction);


					//value to nonPO Related
					$('#InitialNonInvoicePaymentVendor').val(res.otherVendorCode);
					$('#InitialNonInvoice').val(res.otherInvoiceNumber);


					}
					});

				}

			}

			});




	})

	function InitialPaymentFunction(INVOICE_Number, VENDOR_code)
	{	

		//INITIAL PAYMENT
		$.ajax({
		 url: "<?php echo base_url(). 'telegraphicInvoiceController/fetchInitialPayInvoice' ?>",
		 type: 'POST',
		 data: { invoice_num: INVOICE_Number,
				vendor_code: VENDOR_code},
		 dataType: 'JSON',
		 success: function(res){

			var tableBody = $('#InitialPaymentInvoiceTbl');

			tableBody.empty();

			$.each(res, function(index, item){

			var newRow = $('<tr>');

			// Create and append cells for each property
			newRow.append($('<td>').html(item.InvoiceNumber));
			newRow.append($('<td>').html(item.InvoiceAmount));
			newRow.append($('<td>').html(item.updated_Initial_payment));
			newRow.append($('<td>').html(item.total_balance));
			newRow.append($('<td>').html(item.paymentName));
			newRow.append($('<td>').html(item.date));
			newRow.append($('<td>').html(item.remarks));
			newRow.append($('<td>').html(item.rfp));

			// Append the row to the table body
			tableBody.append(newRow);

			//fetch data to modal for another payment
			$('#InitialPaymentInvoice').val(item.InvoiceNumber);
			$('#InitialpaymentDateInvoice').val(item.InvoiceDate);
			$('#InitialPaymentInvoiceAmount').val(item.InvoiceAmount);
			$('#InitialTotalPayment').val(item.sum_total_payment);

			$('#InitialRemainingBalance').val(item.total_balance);

			$('#InitialpaymentTypePay').val(item.payment_type);

			// InitialRemainingBalance
	

			//it fetch if dont have other payment included in initial payment
			$('#InitialOtherPaymentInvoice').val(item.InvoiceNumber);
			$('#InitialOtherPaymentInvoiceAmount').val(item.InvoiceAmount); 
			$('#InitialOtherpaymentInvoiceDate').val(item.date_created);
			$('#InitialOtherRemainingBal').val(item.total_balance);
			$('#InitialOtherPaymentVendor').val(item.Vendor);
			
			//tbl payment
			$('#InitialUpdatedPayment').val(item.update_initial_payment2);	
			
			//to other tbl
			$('#InitialUpdatePay').val(item.updated_Initial_payment);

			//NonInvoiceRelated
			$('#NonInvoiceRelatedVendor').val(item.Vendor);
			$('#NonInvoiceRelatedNumber').val(item.InvoiceNumber);


			})
			
		}
		});

		//OTHER PAYMENT
		$.ajax({
			url: "<?php echo base_url(). 'telegraphicInvoiceController/fetchInvoiceOtherPayment' ?>",
			type: 'POST',
			data: { invoice_num: INVOICE_Number,
					vendor_code: VENDOR_code},
			dataType: 'JSON',
			success: function(res){

			var tableBody = $('#Othertbody');

			tableBody.empty();

			$.each(res, function(index, item){

			var newRow = $('<tr>');

			// Create and append cells for each property
			newRow.append($('<td>').html(item.otherInvoiceNumber));
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

			$('#InitialOtherPaymentVendor').val(item.otherVendorCode);
			$('#InitialUpdatePay').val(item.update_Initial_deduction);

			// fetch data to modal for another payment
			// $('#InitialOtherPaymentInvoice').val(item.otherInvoiceNumber);
			// $('#InitialOtherPaymentInvoiceAmount').val(item.otherInvoiceAmount);
			// $('#InitialOtherpaymentInvoiceDate').val(item.dateCreated);
			$('#InitialOtherRemainingBal').val(item.transAmt);	

			$('#adjustment_deduction').val(item.sumTotalDeduct);
		
			})
			
		}
		});


		//fetch full data of each invoices
		$.ajax({
			url: '<?php echo base_url(). "telegraphicInvoiceController/fetchInitialPaymentData" ?>',
			type: 'POST',
			data: {invoice_num: INVOICE_Number,
				   vendor_code: VENDOR_code},
			dataType: 'JSON',
			success: function(res){

				$('#InvoiceHistoryVendorCode').val(res.vendorCode);
				$('#InvoiceHistoryAccountCode').val(res.accountCode);
				$('#InvoiceHistoryPaymentTermCode').val(res.paymentTermCode);
				$('#InvoiceHistoryAccountCurrency').val(res.accountCurrency);
				$('#InvoiceHistoryInvoiceNumber').val(res.InvoiceNumber);
				$('#InvoiceHistoryInvoiceDate').val(res.InvoiceDate);
				$('#InvoiceHistoryInvoiceAmount').val(res.InvoiceAmount);
				$('#InvoiceHistoryProformaInvoice').val(res.proformaInvoice);
				$('#InvoiceHistoryCompany').val(res.compCode);
				$('#InvoiceHistoryCommercialInvoice').val(res.commercialInvoice);
				$('#InvoiceHistoryStatus').val(res.status);
				$('#InvoiceHistoryRemarks').val(res.remarks);
				$('#InvoiceHistoryRfp').val(res.rfp);

			}
		});

		//show the data
		$.ajax({
			url: "<?php echo base_url(). 'telegraphicInvoiceController/fetchNONInvoiceDataToTable' ?>",
			type: 'POST',
			data: {invoice_num: INVOICE_Number,
				vendor: VENDOR_code
			},
			dataType: 'JSON',
			success: function(result){

			var tableBody = $('#OthertbodyNonRelated');

			tableBody.empty();

			$.each(result, function(index, item){

			var newRow = $('<tr>');

			// Create and append cells for each property
			newRow.append($('<td>').html(item.date));
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

	//Add tbl payment
	$('#AddAnotherPaymentInvoice').click(function(){

		const InitialPaymentInvoice = $('#InitialPaymentInvoice').val();
		const InitialpaymentDateInvoice = $('#InitialpaymentDateInvoice').val();
		const InitialPaymentInvoiceAmount = $('#InitialPaymentInvoiceAmount').val();

		const InitialTotalPayment = $('#InitialTotalPayment').val();

		const InitialRemainingBalance = $('#InitialRemainingBalance').val();
		const InitialpaymentTypePay = $('#InitialpaymentTypePay').val();
		
		const InitialpaymentAmount = $('#InitialpaymentAmount').val();
		const InitialRemarks = $('#InitialRemarks').val();
		const UPDATEInitialDate = $('#UPDATEInitialDate').val();
		const InitialpaymentRfp = $('#InitialpaymentRfp').val();

		const InvoiceHistoryVendorCode = $('#InvoiceHistoryVendorCode').val();
		const InvoiceHistoryAccountCode	= $('#InvoiceHistoryAccountCode').val();
		const InvoiceHistoryPaymentTermCode	= $('#InvoiceHistoryPaymentTermCode').val();
		const InvoiceHistoryAccountCurrency = $('#InvoiceHistoryAccountCurrency').val();
		const InvoiceHistoryInvoiceNumber = $('#InvoiceHistoryInvoiceNumber').val();
		const InvoiceHistoryInvoiceDate	= $('#InvoiceHistoryInvoiceDate').val();
		const InvoiceHistoryInvoiceAmount = $('#InvoiceHistoryInvoiceAmount').val();
		const InvoiceHistoryProformaInvoice	 = 	$('#InvoiceHistoryProformaInvoice').val();
		const InvoiceHistoryCompany	= $('#InvoiceHistoryCompany').val();
		const InvoiceHistoryCommercialInvoice = $('#InvoiceHistoryCommercialInvoice').val();
		const InvoiceHistoryRemarks = $('#InvoiceHistoryRemarks').val();
		const InvoiceHistoryRfp = $('#InvoiceHistoryRfp').val();

		const InitialUpdatedPayment = $('#InitialUpdatedPayment').val();
		
		$.ajax({
		 url: "<?php echo base_url(). 'telegraphicInvoiceController/updateInitialPay' ?>",
		 type: 'POST',
		 data: {
			InvoiceNum: InitialPaymentInvoice,
			InvoiceDate: InitialpaymentDateInvoice,
			InvoiceAmount: InitialPaymentInvoiceAmount,
			total_payment: InitialTotalPayment,
			total_balance: InitialRemainingBalance,
			paymentType: InitialpaymentTypePay,
			amount: InitialpaymentAmount,
			remarks: InitialRemarks,
			date: UPDATEInitialDate,
			rfp: InitialpaymentRfp,

			update_initial_p: InitialUpdatedPayment,

			historyvendor: InvoiceHistoryVendorCode,
			historyaccount: InvoiceHistoryAccountCode,
			historycurrency: InvoiceHistoryPaymentTermCode,
			historyaccountCurrency: InvoiceHistoryAccountCurrency,
			historyInvoiceNumber: InvoiceHistoryInvoiceNumber,
			historyInvoiceDate: InvoiceHistoryInvoiceDate,
			historyInvoiceAmt: InvoiceHistoryInvoiceAmount,
			historyproformaInvoice: InvoiceHistoryProformaInvoice,
			historycompany_name: InvoiceHistoryCompany,
			historycommercialInvoice: InvoiceHistoryCommercialInvoice,
			hisRemarks: InvoiceHistoryRemarks,
			hisRfp: InvoiceHistoryRfp
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

					//if full payment
					else if(res.status == 'D')
					{
						swal({
						title: "Success",
						text: res.message,
						type: "success",
						closeOnClickOutside: false
						});

						$('#modalAnotherInitialpaymentInvoice').modal('hide');

						$('#InitialpaymentAmount').val('');

						$('#btnAddInitialPayment').prop('disabled', true);
						
						$('#AddOtherPaymentBTN').prop('disabled', true);
						
						$('#AddNonInvoiceBtn').prop('disabled', true);

						$('#btnInitialPayClose').hide();

						$('#btnInitialPaymentClose').show();

						$.ajax({
							url: "<?php echo base_url(). 'telegraphicInvoiceController/fetchInitialPayInvoice' ?>",
							type: 'POST',
							data: { invoice_num: InitialPaymentInvoice,
									vendor_code: InvoiceHistoryVendorCode},
							dataType: 'JSON',
							success: function(res){

								var tableBody = $('#InitialPaymentInvoiceTbl');

								tableBody.empty();

								$.each(res, function(index, item){

								var newRow = $('<tr>');

								// Create and append cells for each property
								newRow.append($('<td>').html(item.InvoiceNumber));
								newRow.append($('<td>').html(item.InvoiceAmount));
								newRow.append($('<td>').html(item.total_payment));
								newRow.append($('<td>').html(item.total_balance));
								newRow.append($('<td>').html(item.paymentName));
								newRow.append($('<td>').html(item.date));
								newRow.append($('<td>').html(item.remarks));
								newRow.append($('<td>').html(item.rfp));

								// Append the row to the table body
								tableBody.append(newRow);

								$('#InitialRemainingBalance').val(item.total_balance);

								$('#InitialUpdatePay').val(item.updated_Initial_payment);
			
								})	

							}
						});



						// $.ajax({
						// url: '<?php echo base_url(). "telegraphicInvoiceController/fetchInitialPaymentData" ?>',
						// type: 'POST',
						// data: {invoice_num: InitialPaymentInvoice},
						// dataType: 'JSON',
						// success: function(res){

						// 	$('#InvoiceHistoryVendorCode').val(res.vendorCode);
						// 	$('#InvoiceHistoryAccountCode').val(res.accountCode);
						// 	$('#InvoiceHistoryPaymentTermCode').val(res.paymentTermCode);
						// 	$('#InvoiceHistoryAccountCurrency').val(res.accountCurrency);
						// 	$('#InvoiceHistoryInvoiceNumber').val(res.InvoiceNumber);
						// 	$('#InvoiceHistoryInvoiceDate').val(res.InvoiceDate);
						// 	$('#InvoiceHistoryInvoiceAmount').val(res.InvoiceAmount);
						// 	$('#InvoiceHistoryProformaInvoice').val(res.proformaInvoice);
						// 	$('#InvoiceHistoryCompany').val(res.compCode);
						// 	$('#InvoiceHistoryCommercialInvoice').val(res.commercialInvoice);
						// 	$('#InvoiceHistoryStatus').val(res.status);

						// }
						// });
		
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

							$('#modalAnotherInitialpaymentInvoice').modal('hide');
							
							$('#InitialpaymentAmount').val('');

							$.ajax({
							url: "<?php echo base_url(). 'telegraphicInvoiceController/fetchInitialPayInvoice' ?>",
							type: 'POST',
							data: { invoice_num: InitialPaymentInvoice,
								vendor_code:  InvoiceHistoryVendorCode},
							dataType: 'JSON',
							success: function(res){

								var tableBody = $('#InitialPaymentInvoiceTbl');

								tableBody.empty();

								$.each(res, function(index, item){

								var newRow = $('<tr>');

								// Create and append cells for each property
								newRow.append($('<td>').html(item.InvoiceNumber));
								newRow.append($('<td>').html(item.InvoiceAmount));
								newRow.append($('<td>').html(item.updated_Initial_payment));
								newRow.append($('<td>').html(item.total_balance));
								newRow.append($('<td>').html(item.paymentName));
								newRow.append($('<td>').html(item.date));
								newRow.append($('<td>').html(item.remarks));
								newRow.append($('<td>').html(item.rfp));

								// Append the row to the table body
								tableBody.append(newRow);

								$('#InitialRemainingBalance').val(item.total_balance);

								$('#InitialTotalPayment').val(item.sum_total_payment);	


								$('#InitialUpdatedPayment').val(item.updated_Initial_payment);
						
						
								//other tbl
								$('#InitialOtherRemainingBal').val(item.total_balance);
								$('#InitialUpdatePay').val(item.updated_Initial_payment);
								
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

	// add other payment
	$('#AddOtherPaymentInvoice').click(function(){

		const InitialOtherPaymentInvoice = $('#InitialOtherPaymentInvoice').val();
		const InitialOtherPaymentVendor = $('#InitialOtherPaymentVendor').val();
		const InitialOtherPaymentInvoiceAmount	= $('#InitialOtherPaymentInvoiceAmount').val();
		const InitialOtherpaymentInvoiceDate = $('#InitialOtherpaymentInvoiceDate').val();

		const InitialOtherRemainingBal = $('#InitialOtherRemainingBal').val();

		const FetchOtherTransactType = $('#FetchOtherTransactType').val();
		const InitialOtherTrasaction = $('#InitialOtherTrasaction').val();
		const InitialOtherReferenceNum = $('#InitialOtherReferenceNum').val();
		const InitialOtherRemarks = $('#InitialOtherRemarks').val();
		const InitialOtherpaymentAmount	= $('#InitialOtherpaymentAmount').val();

		const InitialOtherpaymentAmounts	= $('#InitialOtherpaymentAmounts').val();

		const InitialOtherpaymentRfp = $('#InitialOtherpaymentRfp').val();
		
		const adjustment_deduction = $('#adjustment_deduction').val();

		var InitialUpdatedPayment = $('#InitialUpdatedPayment').val();
		
		const InvoiceHistoryVendorCode = $('#InvoiceHistoryVendorCode').val();
		const InvoiceHistoryAccountCode	= $('#InvoiceHistoryAccountCode').val();
		const InvoiceHistoryPaymentTermCode	= $('#InvoiceHistoryPaymentTermCode').val();
		const InvoiceHistoryAccountCurrency	= $('#InvoiceHistoryAccountCurrency').val();
		const InvoiceHistoryProformaInvoice	= $('#InvoiceHistoryProformaInvoice').val();
		const InvoiceHistoryCompany	= $('#InvoiceHistoryCompany').val();
		const InvoiceHistoryCommercialInvoice = $('#InvoiceHistoryCommercialInvoice').val();


		
		$.ajax({
		 url: '<?php echo base_url(). "telegraphicInvoiceController/updateOtherPaymentInvoiceTBL" ?>',
		 type: 'POST',
		 data: {
			InvoiceNum: InitialOtherPaymentInvoice,
			vendor_code: InitialOtherPaymentVendor,
			InvoiceAmt: InitialOtherPaymentInvoiceAmount,
			InvoiceDate: InitialOtherpaymentInvoiceDate,
			remainBalafterPay: InitialOtherRemainingBal,
			// initialP: InitialUpdatePay,
			type: FetchOtherTransactType,
			TransactType: InitialOtherTrasaction,
			referenceNo: InitialOtherReferenceNum,
			remarks: InitialOtherRemarks,
			amt: InitialOtherpaymentAmount,
			amts: InitialOtherpaymentAmounts,
			updated_adjustment_deductions: adjustment_deduction,
			rfp: InitialOtherpaymentRfp,

			historyvendor: InvoiceHistoryVendorCode,
			historyaccount: InvoiceHistoryAccountCode,
			historycurrency: InvoiceHistoryPaymentTermCode,
			historyaccountCurrency: InvoiceHistoryAccountCurrency,
			historyproformaInvoice: InvoiceHistoryProformaInvoice,
			historycompany_name: InvoiceHistoryCompany,
			commercialInvoice: InvoiceHistoryCommercialInvoice
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

			else if(res.stats == 7)
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
			
			//full payment
			else if(res.stats == 5)
			{
				swal({
				title: "Success",
				text: res.message,
				type: "success",
				closeOnClickOutside: false
				});

				$('#modalOtherInitialpaymentInvoice').hide();

				$('#InitialOtherRemarks').val('');
				$('#InitialOtherpaymentAmount').val('');
				$('#InitialOtherReferenceNum').val('');

				$('#btnInitialPayClose').hide();

				$('#btnInitialPaymentClose').show();

				$("#btnAddInitialPayment").prop('disabled', true);
				$('#AddOtherPaymentBTN').prop('disabled', true);


				//OTHER PAYMENT
				$.ajax({
				url: "<?php echo base_url(). 'telegraphicInvoiceController/fetchInvoiceOtherPayment' ?>",
				type: 'POST',
				data: { invoice_num: InitialOtherPaymentInvoice,
					vendor_code: InitialOtherPaymentVendor },
				dataType: 'JSON',
				success: function(res){

					var tableBody = $('#Othertbody');

					tableBody.empty();

					$.each(res, function(index, item){

					var newRow = $('<tr>');

					// Create and append cells for each property
					newRow.append($('<td>').html(item.otherInvoiceNumber));
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

					//inital payment
					$('#InitialRemainingBalance').val(item.transAmt);

					//other - balance
					$('#InitialOtherRemainingBal').val(item.transAmt);

					})
					
				}
				});

			}

			//add another payment
			else if(res.stats == 6)
			{
				swal({
				title: "Success",
				text: res.message,
				type: "success",
				closeOnClickOutside: false
				});

				$('#modalOtherInitialpaymentInvoice').hide();

				$('#InitialOtherRemarks').val('');
				$('#InitialOtherpaymentAmount').val('');
				$('#InitialOtherReferenceNum').val('');

				$('#btnInitialPayClose').hide();

				$('#btnInitialPaymentClose').show();

				//OTHER PAYMENT
				$.ajax({
				url: "<?php echo base_url(). 'telegraphicInvoiceController/fetchInvoiceOtherPayment' ?>",
				type: 'POST',
				data: { invoice_num: InitialOtherPaymentInvoice,
					vendor_code: InitialOtherPaymentVendor },
				dataType: 'JSON',
				success: function(res){

					var tableBody = $('#Othertbody');

					tableBody.empty();

					$.each(res, function(index, item){

					var newRow = $('<tr>');

					// Create and append cells for each property
					newRow.append($('<td>').html(item.otherInvoiceNumber));
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

					//inital payment
					// $('#InitialRemainingBalance').val(item.transAmt);
	
					var InitialUpdatedPayment =  $('InitialUpdatedPayment').val(item.total);
						
					$('#InitialUpdatePay').val(item.update_Initial_deduction);
				
					//other - balance
					$('#InitialOtherRemainingBal').val(item.transAmt);

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

	$('#AddNonOtherPaymentInvoice').click(function(){
		
		var InitialNonInvoicePaymentVendor = $('#InitialNonInvoicePaymentVendor').val();
		var InitialNonInvoice = $('#InitialNonInvoice').val();
	
		var InitialNonInvoiceDate = $('#InitialNonInvoiceDate').val();
		var FetchOtherTransactType = $('#FetchOtherNonTransactType').val(); // TYPE
		var InitialOtherNonTrasaction = $('#InitialOtherNonTrasaction').val(); //CLAIMS ,CREDIT, ETC
		var InitialNonAmount = $('#InitialNonAmount').val();
		var InitialNonAmounts = $('#InitialNonAmounts').val();
		var InitialNonOtherReference = $('#InitialNonOtherReference').val();
		var InitialNonOtherRemarks = $('#InitialNonOtherRemarks').val();
		var InitialNonRfp = $('#InitialNonRfp').val();



		$.ajax({
			url: "<?php echo base_url(). 'telegraphicInvoiceController/InsertInitialNonInvoicePay' ?>",
			type: 'POST',
			data: {
				NonInvoiceVendor: InitialNonInvoicePaymentVendor,
				NonInvoiceNumber: InitialNonInvoice,

				NonInvoiceDate: InitialNonInvoiceDate,
				NonInvoiceType: FetchOtherTransactType,
				NonInvoiceTransaction: 	InitialOtherNonTrasaction,
				NonInvoiceAmount: InitialNonAmount,
				NonInvoiceAmounts: InitialNonAmounts,
				NonInvoiceReference: InitialNonOtherReference,
				NonInvoiceRemarks: InitialNonOtherRemarks,
				NonInvoiceRfp: InitialNonRfp
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
					type: "success",
					closeOnClickOutside: false
					});

					//hide the modal
					$('#modalOtherInitialpaymentNonInvoice').modal('hide');

					//disabled the button
					$('#NonInvoiceBtn').prop('disabled', true);

					//show the data
					$.ajax({
						url: "<?php echo base_url(). 'telegraphicInvoiceController/fetchNONInvoiceData' ?>",
						type: "POST",
						data: {invoice_num: InitialNonInvoice,
							vendor: InitialNonInvoicePaymentVendor
						},
						dataType: "JSON",
						success: function(result){

							$('#NonInvoiceType').html(result.otherTransacTypeName);
							$('#NonInvoiceDate').html(result.date);
							$('#NonInvoiceTransact').html(result.transactionName);
							$('#NonInvoiceReference').html(result.reference_no);
							$('#NonInvoiceAmount2').html(result.amount2);
							$('#NonInvoiceRemarks').html(result.remarks);
							$('#NonInvoiceRfp').html(result.rfp);

							$('#NonInvoiceAmount').html('Payment: ' + result.amount);
							$('#NonInvoicetotal').html('Balance: ' + result.total);
						}
					});

				}
			}

		});


	});

	$('#NonInvoicePaymentBtn').click(function(){
		
		var NonInvoiceRelatedVendor = $('#NonInvoiceRelatedVendor').val();
		var NonInvoiceRelatedNumber = $('#NonInvoiceRelatedNumber').val();
		var NonInvoiceRelatedDate = $('#NonInvoiceRelatedDate').val();
		var NonInvoiceRelatedType = $('#NonInvoiceRelatedType').val();
		var NonInvoiceRelatedTransactType = $('#NonInvoiceRelatedTransactType').val();
		var NonInvoiceRelatedReferenceNo = $('#NonInvoiceRelatedReferenceNo').val();
		var NonInvoiceRelatedRemarks = $('#NonInvoiceRelatedRemarks').val();
		var NonInvoiceRelatedAmount = $('#NonInvoiceRelatedAmount').val();
		var NonInvoiceRelatedAmounts = $('#NonInvoiceRelatedAmounts').val();
		var NonInvoiceRelatedRfp = $('#NonInvoiceRelatedRfp').val();


		$.ajax({
			url: "<?php echo base_url(). 'telegraphicInvoiceController/InsertInitialNonInvoicePay' ?>",
			type: 'POST',
			data: {
				NonInvoiceVendor: NonInvoiceRelatedVendor,
				NonInvoiceNumber: NonInvoiceRelatedNumber,
				$NonInvoiceAmounts: NonInvoiceRelatedAmounts,
				NonInvoiceDate: NonInvoiceRelatedDate,
				NonInvoiceType: NonInvoiceRelatedType,
				NonInvoiceTransaction: 	NonInvoiceRelatedTransactType,
				NonInvoiceAmount: NonInvoiceRelatedAmount,
				NonInvoiceAmounts: NonInvoiceRelatedAmounts,
				NonInvoiceReference: NonInvoiceRelatedReferenceNo,
				NonInvoiceRemarks: NonInvoiceRelatedRemarks,
				NonInvoiceRfp: NonInvoiceRelatedRfp
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
					title: "Success",
					text: res.message,
					type: "success",
					closeOnClickOutside: false
					});

					//hide the modal
					$('#modalNonInvoiceRelated').modal('hide');

					//show the data
					$.ajax({
						url: '<?php echo base_url(). 'telegraphicInvoiceController/fetchNONInvoiceDataToTable' ?>',
						type: 'POST',
						data: {invoice_num: NonInvoiceRelatedNumber,
							vendor: NonInvoiceRelatedVendor
						},
						dataType: 'JSON',
						success: function(result){

							$('btnInitialPayClose').hide();
							$('btnInitialPayClose1').show();

							var tableBody = $('#OthertbodyNonRelated');

							tableBody.empty();

							$.each(result, function(index, item){

							var newRow = $('<tr>');

							
							// Create and append cells for each property
							newRow.append($('<td>').html(item.date));
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
			}

		});
	})



</script>