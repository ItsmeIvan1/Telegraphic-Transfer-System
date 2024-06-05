

<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Telegraphic Transfer Invoice History</h4>
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
													<th>Invoice No.</th>
													<th>Invoice Date</th>
													<th>Currency</th>
													<th>Amount</th>
													<th>Payment</th>
													
													
													
													
													<!-- <th>Proforma invoice</th>
													<th>Commercial invoice</th>
													<th>RFP reference</th>
													<th>Company</th>
													<th>Final invoice</th>
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
													<td><?php echo $datas['InvoiceNumber'] ?></td>
													<td><?php echo $datas['InvoiceDate'] ?></td>
													<td><?php echo $datas['currency'] ?></td>
													<td><?php echo $datas['InvoiceAmount'] ?></td>
													<td><?php echo $datas['paymentName'] ?></td>
													
													
													
													
													<!-- <td><?php echo $datas['proformaInvoice'] ?></td>
													<td><?php echo $datas['commercialInvoice'] ?></td>
													<td><?php echo $datas['rfpReference'] ?></td>
													<td><?php echo $datas['company_name'] ?></td>
													<td><?php echo $datas['finalInvoice'] ?></td>
													<td><?php echo $datas['creditNote'] ?></td>
													<td><?php echo $datas['debitNote'] ?></td>
													<td><?php echo $datas['wireTransferFee'] ?></td> -->
													<td><?php echo $datas['remarks'] ?></td>
													<td>
													<span class="label label-danger"><?php echo $datas['tts_stats'] ?></span>
													</td>
                                                    <td class="text-center">
														<ul class="icons-list">
															<li class="dropdown">
																<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																	<i class="icon-menu9"></i>
																</a>

																<ul class="dropdown-menu dropdown-menu-right">
																	<?php if ($datas ['accountCurrency'] == 1){ ?>
																	<li> 
																		<a href="" class="" onclick="InitialPaymentFunction('<?php echo $datas['InvoiceNumber'] ?>', '<?php echo $datas['vendorCode'] ?>')" data-toggle="modal" data-target="#modalInitialPaymentDetailss"><i class="icon icon-file-eye position-left"></i>Payment History</a>
																	</li>																
																	<?php } else { ?>
																	<li>
																		<a href="" class="" onclick="FullPaymentFunction('<?php echo $datas['InvoiceNumber'] ?>', '<?php echo $datas['vendorCode'] ?>')" data-toggle="modal" data-target="#modalFullPaymentDetailss"><i class="icon icon-file-eye position-left"></i>Payment History</a>
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

<!-- modal for payment details initial payment -->
<div id="modalInitialPaymentDetailss" class="modal fade" tabindex="-1" data-backdrop="static">
					<div class="modal-dialog modal-full">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" id="btnInitialPayClose">&times;</button>
								<button type="button" class="close" data-dismiss="modal" id="btnInitialPayClose1" style="display: hidden;">&times;</button>
								<h5 class="modal-title">Payment History / Invoice</h5>
							</div>

							<div class="modal-body">
								<div class="row">

									<div class="col-md-6">
										<div class="pre-scrollable">
											<table class="table " id="">
												<thead>
													<tr class="bg-success-400">
														<th>Invoice #</th>
														<th>Invoice date</th>
														<th>Invoice amount</th>
														<th>Total payment</th>
														<th>Remaining Balance</th>
														<th>Payment Type</th>
														<th>Date Created</th>
														<th>RFP</th>
														
													</tr>
												</thead>
												<tbody id="tbodyhistory">
								
												</tbody>
											</table>
										</div>	
									</div>	
									
									<div class="col-md-6">	
											<!-- otherpayment -->
											<div class="pre-scrollable">
													<table class="table" id="">
														<thead>
															<tr class="bg-success-400">
																<th>Invoice #</th>
																<th>Type</th>
																<th>Transaction type</th>
																<th>Reference no.</th>
																<th>Date created</th>
																<th>Amount</th>
																<th>Payment</th>
																<th>Total</th>
																<th>Remarks</th>
																<th>Rfp</th>
															
															
															</tr>
														</thead>
														<tbody id="OthertbodyHis">
										
														</tbody>
													</table>
											</div>

											<div style="padding-bottom: 2px;">
												<button class="btn btn-primary" data-toggle="modal" data-target="#modalOtherInitialpaymentInvoiceHistory" id="AddOtherPaymentBTN">Add other payment</button>
											</div>
											<!-- 
											<div style="padding: 10px;">
												<button class="btn btn-primary" data-toggle="modal" data-target="" id="generatePdf">PDF</button>
											</div> -->

											<!-- <div style="padding: 10px;">
												<form id="upload-form" enctype="multipart/form-data">
													<input type="file" name="userfile" id="userfile" />
													<button type="button" onclick="uploadFile()">Upload</button>
												</form>
												
												<h1 id="upload-results"></h1>
											</div> -->

											<!-- Non Invoice Related -->
											<div class="pre-scrollable">
												<table class="table" id="">
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

											<div style="padding-bottom: 2px;">
												<button class="btn btn-primary" data-toggle="modal" data-target="#modalNonInvoiceRelated" id="AddNonInvoiceBtn">Non Invoice</button>
											</div>


									</div>
								</div>

							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-warning" data-dismiss="modal" id="" >Close</button>
								<!-- <button type="button" class="btn btn-primary" >Save</button> -->
							</div>
						</div>
					</div>
</div>

<!-- modal for payment details Full payment -->
<div id="modalFullPaymentDetailss" class="modal fade" tabindex="-1" data-backdrop="static">
					<div class="modal-dialog modal-full">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" id="btnInitialPayClose">&times;</button>
								<h5 class="modal-title">Full Payment History / Invoice</h5>
							</div>

							<div class="modal-body">
								<div class="row">

									<div class="col-md-6">
										<div class="pre-scrollable">
											<table class="table " id="">
												<thead>
													<tr class="bg-success-400">
														<th>Invoice#</th>
														<!-- <th>Invoice date</th> -->
														<th>Amount</th>
														<th>Payment</th>
														<th>Balance</th>
														<th>Type</th>
														<th>Date created</th>
														<th>Remarks</th>
														<th>Rfp</th>
														
													</tr>
												</thead>
												<tbody id="tbodyFullPaymentHistory">
								
												</tbody>
											</table>
										</div>	
									</div>	
									
									<div class="col-md-6">	
											<!-- otherpayment -->
											<div class="pre-scrollable">
													<table class="table" id="">
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
														<tbody id="OthertbodyFullHis">
										
														</tbody>
													</table>
											</div>

											<div style="padding-bottom: 2px;">
												<button class="btn btn-primary" data-toggle="modal" data-target="#modalOtherInitialpaymentInvoiceHistoryFull" id="AddOtherPaymentBTN">Add other payment</button>
											</div>
											<!-- 
											<div style="padding: 10px;">
												<button class="btn btn-primary" data-toggle="modal" data-target="" id="generatePdf">PDF</button>
											</div> -->

											<!-- <div style="padding: 10px;">
												<form id="upload-form" enctype="multipart/form-data">
													<input type="file" name="userfile" id="userfile" />
													<button type="button" onclick="uploadFile()">Upload</button>
												</form>
												
												<h1 id="upload-results"></h1>
											</div> -->


											<div class="pre-scrollable">
												<table class="table " id="">
													<thead>
														<tr class="bg-success-400">
															<th>Date</th>
															<th>Type</th>
															<th>Transaction</th>
															<th>Reference</th>
															<th>Amount</th>
															<th>Payment</th>
															<th>Total</th>
															<th>Remarks</th>
															<th>RFP</th>
														
														
														</tr>
													</thead>
													<tbody id="OthertbodyNonRelatedFull">

													</tbody>
												</table>
											</div>

											<div style="padding-bottom: 2px;">
												<button class="btn btn-primary" data-toggle="modal" data-target="#modalNonInvoiceRelatedFull" id="AddNonInvoiceBtnFull">Non Invoice</button>
											</div>
									</div>
								</div>

							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-warning" data-dismiss="modal" id="" >Close</button>
								<!-- <button type="button" class="btn btn-primary" >Save</button> -->
							</div>
						</div>
					</div>
</div>

<!-- modal for add another other payment -->
<div id="modalOtherInitialpaymentInvoiceHistory" class="modal fade" tabindex="-1" data-backdrop="static">
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
										<input type="hidden" class="form-control" id="InitialOtherPaymentPOHis" disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Invoice amount<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="InitialOtherPaymentPOAmountHis" disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Invoice date<span style="color: red;">*</span></label>
										<input type="hidden" class="form-control" id="InitialOtherpaymentDateHis" disabled> -->
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Remaining balance<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="InitialOtherRemainingBalHis" disabled>
									<!-- </div> -->
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Type<span style="color: red;">*</span></label>
										<select class="form-control" id="FetchOtherTransactTypeHis" >
											<?php foreach($otherTrans as $otherTranss){ ?>
											<option value="<?php echo $otherTranss['otherTransacTypeCode'] ?>"><?php echo $otherTranss['otherTransacTypeName'] ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Transaction type<span style="color: red;">*</span></label>
										<select class="form-control" id="InitialOtherTrasactionHis">
											<?php foreach($transact_2 as $transact_2s){ ?>
											<option value="<?php echo $transact_2s['id'] ?>"><?php echo $transact_2s['transact_name'] ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Reference No.<span style="color: red;">*</span></label>
										<input type="text" class="form-control" id="InitialOtherReferenceNumHis">
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Remarks</label>
										<input type="text" class="form-control" id="InitialOtherRemarksHis" >
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Amount<span style="color: red;">*</span></label>
										<input type="text" id="InitialOtherpaymentAmountHiss" class="form-control">
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Payment<span style="color: red;">*</span></label>
										<input type="text" id="InitialOtherpaymentAmountHis" class="form-control">
									</div>

									<div class="col-md-12" style="padding-top: 5px;">
										<label>Rfp<span style="color: red;">*</span></label>
										<input type="text" id="RfpHis" class="form-control">
									</div>
									
								</div>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
								<button type="button" class="btn btn-primary" id="AddOtherPaymentInvoiceHis">Pay</button>
							</div>
						</div>
					</div>
</div>

<!-- modal for full other payment -->
<div id="modalOtherInitialpaymentInvoiceHistoryFull" class="modal fade" tabindex="-1" data-backdrop="static">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" >&times;</button>
								<h5 class="modal-title">Other Payment</h5>
							</div>

							<div class="modal-body">
								<div class="row">
									
								
									<!-- <label>Vendor name</label> -->
									<input type="hidden" class="form-control" id="InitialOtherPaymentVendorFull" disabled>


									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Invoice #<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="InitialOtherPaymentPOHisFull" disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Invoice amount<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="InitialOtherPaymentPOAmountHisFull" disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Invoice date<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="InitialOtherpaymentDateHisFull" disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Remaining balance<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="InitialOtherRemainingBalHisFull" disabled>
									<!-- </div> -->
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Type<span style="color: red;">*</span></label>
										<select class="form-control" id="FetchOtherTransactTypeHisFull" >
											<?php foreach($otherTrans as $otherTranss){ ?>
											<option value="<?php echo $otherTranss['otherTransacTypeCode'] ?>"><?php echo $otherTranss['otherTransacTypeName'] ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Transaction type<span style="color: red;">*</span></label>
										<select class="form-control" id="InitialOtherTrasactionHisFull">
											<?php foreach($transact_2 as $transact_2s){ ?>
											<option value="<?php echo $transact_2s['id'] ?>"><?php echo $transact_2s['transact_name'] ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Reference No.<span style="color: red;">*</span></label>
										<input type="text" class="form-control" id="InitialOtherReferenceNumHisFull">
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Remarks</label>
										<input type="text" class="form-control" id="InitialOtherRemarksHisFull" >
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Amount<span style="color: red;">*</span></label>
										<input type="text" id="InitialOtherpaymentAmountHissFull" class="form-control">
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Payment<span style="color: red;">*</span></label>
										<input type="text" id="InitialOtherpaymentAmountHisFull" class="form-control">
									</div>

									<div class="col-md-12" style="padding-top: 5px;">
										<label>Rfp<span style="color: red;">*</span></label>
										<input type="text" id="RfpHisFull" class="form-control">
									</div>
									
								</div>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
								<button type="button" class="btn btn-primary" id="AddOtherPaymentInvoiceHisFull">Pay</button>
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
										<input type="text" class="form-control daterange-single" id="NonInvoiceRelatedDate">
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

<!-- modal for add another other Non Invoice payment Full -->
<div id="modalNonInvoiceRelatedFull" class="modal fade" tabindex="-1" data-backdrop="static">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" >&times;</button>
								<h5 class="modal-title">Other Payment</h5>
							</div>

							<div class="modal-body">
								<div class="row">
									
								
									<!-- <label>Vendor name</label> -->
									<input type="hidden" class="form-control" id="NonInvoiceRelatedVendorFull" disabled>


									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Invoice #<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="NonInvoiceRelatedNumberFull" disabled>
									<!-- </div> -->
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Date<span style="color: red;">*</span></label>

										<div class="input-group">
											<span class="input-group-addon"><i class="icon-calendar22"></i></span>
											<input type="text" placeholder="Select date" class="form-control pickadate-accessibility picker__input" id="NonInvoiceRelatedDateFull">
										</div>
										
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Type<span style="color: red;">*</span></label>
										<select class="form-control" id="NonInvoiceRelatedTypeFull" >
											<?php foreach($otherTrans as $otherTranss){ ?>
											<option value="<?php echo $otherTranss['otherTransacTypeCode'] ?>"><?php echo $otherTranss['otherTransacTypeName'] ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Transaction type<span style="color: red;">*</span></label>
										<select class="form-control" id="NonInvoiceRelatedTransactTypeFull">
											<?php foreach($deduc as $deducs){ ?>
											<option value="<?php echo $deducs['transactionCode'] ?>"><?php echo $deducs['transactionName'] ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Reference No.<span style="color: red;">*</span></label>
										<input type="text" class="form-control" id="NonInvoiceRelatedReferenceNoFull">
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Remarks</label>
										<input type="text" class="form-control" id="NonInvoiceRelatedRemarksFull" >
									</div>

									<div class="col-md-12" style="padding-top: 5px;">
										<label>Amount<span style="color: red;">*</span></label>
										<input type="text" id="NonInvoiceRelatedAmountFulls" class="form-control">
									</div>
									
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Payment<span style="color: red;">*</span></label>
										<input type="text" id="NonInvoiceRelatedAmountFull" class="form-control">
									</div>

									<div class="col-md-12" style="padding-top: 5px;">
										<label>Rfp<span style="color: red;">*</span></label>
										<input type="text" id="NonInvoiceRelatedRfpFull" class="form-control">
									</div>
									
								</div>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
								<button type="button" class="btn btn-primary" id="NonInvoicePaymentBtnFull">Pay</button>
							</div>
						</div>
					</div>
</div>




<script>

    $('#li24').addClass('active');

    $('.datatable-basic').DataTable();

	$('.daterange-single').daterangepicker({ 
	singleDatePicker: true,
	//use if disable previos date
	// minDate: moment()

	isInvalidDate: function(date) {
	// Disable dates in the future
	return date.isAfter(moment());
		}
	});

	var delay1 = 100;

	$('#btnInitialPayClose1').click(function(){

		setTimeout(function(){ window.location.reload(); }, delay1);
	})
    
    function InitialPaymentFunction(Invoice_number, Vendor_code)
    {

        $.ajax({
            url: "<?php echo base_url(). 'telegraphicInvoiceHisController/InitialPaymentDetails' ?>",
            type: 'POST',
            data: {invoice_num: Invoice_number,
				   vendor_code: Vendor_code},
            dataType: 'JSON',
            success: function(res){

                // console.log(res);

                var tableBody = $('#tbodyhistory');

                tableBody.empty();

                $.each(res, function(index, item){

                var newRow = $('<tr>');

                // Create and append cells for each property
                newRow.append($('<td>').html(item.InvoiceNumber));
                newRow.append($('<td>').html(item.InvoiceDate));
                newRow.append($('<td>').html(item.InvoiceAmount));
                newRow.append($('<td>').html(item.total_payment));
                newRow.append($('<td>').html(item.total_balance));
                newRow.append($('<td>').html(item.paymentName));
                newRow.append($('<td>').html(item.date_created));
				newRow.append($('<td>').html(item.rfp));
                

                // Append the row to the table body
                tableBody.append(newRow);

				$('#InitialOtherPaymentVendor').val(item.Vendor);
				$('#InitialOtherPaymentPOHis').val(item.InvoiceNumber);
				$('#InitialOtherPaymentPOAmountHis').val(item.InvoiceAmount);
				$('#InitialOtherpaymentDateHis').val(item.InvoiceDate);
				
				$('#InitialOtherRemainingBalHis').val(item.updated_Initial_payment);

				$('#NonInvoiceRelatedVendor').val(item.Vendor);
				$('#NonInvoiceRelatedNumber').val(item.InvoiceNumber);
				
				
                })

            }	
        });


		//fetch other payment
		$.ajax({
			url: '<?php echo base_url(). 'telegraphicInvoiceHisController/fetchOtherPaymentHis' ?>',
			type: 'POST',
			data: {invoice_num: Invoice_number,
				   vendor_code: Vendor_code},
			dataType: 'JSON',
			success: function(res){

			var tableBody = $('#OthertbodyHis');

			tableBody.empty();

				$.each(res, function(index, item)
				{

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
					newRow.append($('<td>').html(item.remark));
					newRow.append($('<td>').html(item.rfp));

					// Append the row to the table body
					tableBody.append(newRow);

					//fetch payment details
		
					$('#InitialOtherPaymentPOAmountHis').val(item.otherInvoiceAmount);
					$('#InitialOtherpaymentDateHis').val(item.otherInvoiceDate);



				})

			}
		});

		//show the data
		$.ajax({
			url: '<?php echo base_url(). 'telegraphicInvoiceHisController/fetchNONInvoiceDataToTable' ?>',
			type: 'POST',
			data: {invoice_num: Invoice_number,
				vendor: Vendor_code
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

	function FullPaymentFunction(Invoice_number, Vendor_code)
	{
		$.ajax({
            url: "<?php echo base_url(). 'telegraphicInvoiceHisController/FullPaymentDetails' ?>",
            type: 'POST',
            data: {invoice_num: Invoice_number,
				   vendor_code: Vendor_code},
            dataType: 'JSON',
            success: function(res){

                // console.log(res);

                var tableBody = $('#tbodyFullPaymentHistory');

                tableBody.empty();

                $.each(res, function(index, item){

                var newRow = $('<tr>');

                // Create and append cells for each property
                newRow.append($('<td>').html(item.InvoiceNumber));
                // newRow.append($('<td>').html(item.InvoiceDate));
                newRow.append($('<td>').html(item.InvoiceAmount));
                newRow.append($('<td>').html(item.total_payment));
                newRow.append($('<td>').html(item.total_balance));
                newRow.append($('<td>').html(item.paymentName));
                newRow.append($('<td>').html(item.date));
				newRow.append($('<td>').html(item.remarks));
				newRow.append($('<td>').html(item.rfp));
                
				$('#InitialOtherPaymentVendorFull').val(item.Vendor);
				$('#InitialOtherPaymentPOHisFull').val(item.InvoiceNumber);
				$('#InitialOtherPaymentPOAmountHisFull').val(item.InvoiceAmount);
				$('#InitialOtherpaymentDateHisFull').val(item.InvoiceDate);
				
				$('#InitialOtherRemainingBalHisFull').val(item.updated_Initial_payment);
				
				$('#NonInvoiceRelatedNumberFull').val(item.InvoiceNumber);
				$('#NonInvoiceRelatedVendorFull').val(item.Vendor);

			
                // Append the row to the table body
                tableBody.append(newRow);
				

                })

            }	
        });

		//fetch other payment
		$.ajax({
			url: '<?php echo base_url(). 'telegraphicInvoiceHisController/fetchOtherPaymentHis' ?>',
			type: 'POST',
			data: {invoice_num: Invoice_number,
				vendor_code: Vendor_code},
			dataType: 'JSON',
			success: function(res){

			var tableBody = $('#OthertbodyFullHis');

			tableBody.empty();

			$.each(res, function(index, item)
			{

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

				//fetch payment details
	
				$('#InitialOtherPaymentPOAmountHis').val(item.otherInvoiceAmount);
				$('#InitialOtherpaymentDateHis').val(item.otherInvoiceDate);

			})

			}
		});

		//show the data
		$.ajax({
			url: '<?php echo base_url(). 'telegraphicInvoiceHisController/fetchNONInvoiceDataToTable' ?>',
			type: 'POST',
			data: {
				invoice_num: Invoice_number,
				vendor: Vendor_code
			},
			dataType: 'JSON',
			success: function(res){

			var tableBody = $('#OthertbodyNonRelatedFull');

			tableBody.empty();

			$.each(res, function(index, item){

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

    $('#AddOtherPaymentInvoiceHis').click(function()
	{
      var InitialOtherPaymentPOHis = $('#InitialOtherPaymentPOHis').val();
	  var InitialOtherPaymentVendor = $('#InitialOtherPaymentVendor').val();
      var InitialOtherPaymentPOAmountHis = $('#InitialOtherPaymentPOAmountHis').val();
      var InitialOtherpaymentDateHis = $('#InitialOtherpaymentDateHis').val();
      var InitialOtherRemainingBalHis = $('#InitialOtherRemainingBalHis').val();
      var FetchOtherTransactTypeHis = $('#FetchOtherTransactTypeHis').val();
      var InitialOtherTrasactionHis =  $('#InitialOtherTrasactionHis').val();
      var InitialOtherReferenceNumHis = $('#InitialOtherReferenceNumHis').val();
      var InitialOtherRemarksHis =  $('#InitialOtherRemarksHis').val();
      var InitialOtherpaymentAmountHis =  $('#InitialOtherpaymentAmountHis').val();
	  var InitialOtherpaymentAmountHiss =  $('#InitialOtherpaymentAmountHiss').val();
	  var RfpHis = $('#RfpHis').val();

        $.ajax({
		 url: '<?php echo base_url(). "telegraphicInvoiceHisController/updateOtherPaymentTBLHis" ?>',
		 type: 'POST',
		 data: {
            InvoiceNum: InitialOtherPaymentPOHis,
			vendor_code: InitialOtherPaymentVendor,
            InvoiceAmt: InitialOtherPaymentPOAmountHis,
            InvoiceDate: InitialOtherpaymentDateHis,
            type: FetchOtherTransactTypeHis,
            TransactType: InitialOtherTrasactionHis,
            referenceNo: InitialOtherReferenceNumHis,
            remarks: InitialOtherRemarksHis,
            amt: InitialOtherpaymentAmountHis,
			amts: InitialOtherpaymentAmountHiss,
            remainBal: InitialOtherRemainingBalHis,
			rfp: RfpHis
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

			else if(res.stats == 2)
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
				title: "Success",
				text: res.message,
				type: "success",
				closeOnClickOutside: false
				});

				$('#modalOtherInitialpaymentInvoiceHistory').modal('hide');

				$('#InitialOtherReferenceNumHis').val('');
				$('#InitialOtherRemarksHis').val('');
				$('#InitialOtherpaymentAmountHis').val('');

				
                //fetch other payment
                $.ajax({
                url: '<?php echo base_url(). 'telegraphicInvoiceHisController/fetchOtherPaymentHis' ?>',
                type: 'POST',
                data: {invoice_num: InitialOtherPaymentPOHis,
					vendor_code: InitialOtherPaymentVendor},
                dataType: 'JSON',
                success: function(res)
				{

                    var tableBody = $('#OthertbodyHis');

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

                    //fetch payment details
                    $('#InitialOtherPaymentPOHis').val(item.otherInvoiceNumber);
                    $('#InitialOtherPaymentPOAmountHis').val(item.otherInvoiceAmount);
                    $('#InitialOtherpaymentDateHis').val(item.otherInvoiceDate);
                    $('#InitialOtherRemainingBalHis').val(item.transAmt);


                    })

                }
                });

			}

		 }
		});

        
    })

	$('#AddOtherPaymentInvoiceHisFull').click(function(){

		var InitialOtherPaymentVendorFull = $('#InitialOtherPaymentVendorFull').val();
		var InitialOtherPaymentPOHisFull = $('#InitialOtherPaymentPOHisFull').val();
		var InitialOtherpaymentDateHisFull = $('#InitialOtherpaymentDateHisFull').val();
		var InitialOtherPaymentPOAmountHisFull = $('#InitialOtherPaymentPOAmountHisFull').val();
		var InitialOtherRemainingBalHisFull = $('#InitialOtherRemainingBalHisFull').val();
		var FetchOtherTransactTypeHisFull = $('#FetchOtherTransactTypeHisFull').val();
		var InitialOtherTrasactionHisFull = $('#InitialOtherTrasactionHisFull').val();
		var InitialOtherReferenceNumHisFull = $('#InitialOtherReferenceNumHisFull').val();
		var InitialOtherRemarksHisFull = $('#InitialOtherRemarksHisFull').val();
		var InitialOtherpaymentAmountHissFull = $('#InitialOtherpaymentAmountHissFull').val();
		var InitialOtherpaymentAmountHisFull = $('#InitialOtherpaymentAmountHisFull').val();
		var RfpHisFull = $('#RfpHisFull').val();

		$.ajax({
		 url: '<?php echo base_url(). "telegraphicInvoiceHisController/updateOtherPaymentTBLHis" ?>',
		 type: 'POST',
		 data: {
            InvoiceNum: InitialOtherPaymentPOHisFull,
			vendor_code: InitialOtherPaymentVendorFull,
            InvoiceAmt: InitialOtherPaymentPOAmountHisFull,
            InvoiceDate: InitialOtherpaymentDateHisFull,
            type: FetchOtherTransactTypeHisFull,
            TransactType: InitialOtherTrasactionHisFull,
            referenceNo: InitialOtherReferenceNumHisFull,
            remarks: InitialOtherRemarksHisFull,
            amt: InitialOtherpaymentAmountHisFull,
			amts: InitialOtherpaymentAmountHissFull,
            remainBal: InitialOtherRemainingBalHisFull,
			rfp: RfpHisFull
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

			else if(res.stats == 2)
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
				title: "Success",
				text: res.message,
				type: "success",
				closeOnClickOutside: false
				});

				$('#modalOtherInitialpaymentInvoiceHistoryFull').modal('hide');

				$('#InitialOtherReferenceNumHisFull').val('');
				$('#InitialOtherRemarksHisFull').val('');
				$('#InitialOtherpaymentAmountHisFull').val('');

				
                //fetch other payment
                $.ajax({
                url: '<?php echo base_url(). 'telegraphicInvoiceHisController/fetchOtherPaymentHis' ?>',
                type: 'POST',
                data: {invoice_num: InitialOtherPaymentPOHisFull,
					vendor_code: InitialOtherPaymentVendorFull},
                dataType: 'JSON',
                success: function(res)
				{

                    var tableBody = $('#OthertbodyFullHis');

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

                    //fetch payment details
                    // $('#InitialOtherPaymentPOHis').val(item.otherInvoiceNumber);
                    // $('#InitialOtherPaymentPOAmountHis').val(item.otherInvoiceAmount);
                    // $('#InitialOtherpaymentDateHis').val(item.otherInvoiceDate);
                    // $('#InitialOtherRemainingBalHis').val(item.transAmt);


                    })

                }
                });

			}

		 }
		});





	})
	

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
			url: "<?php echo base_url(). 'telegraphicInvoiceHisController/InsertInitialNonInvoicePay' ?>",
			type: 'POST',
			data: {
				NonInvoiceVendor: NonInvoiceRelatedVendor,
				NonInvoiceNumber: NonInvoiceRelatedNumber,

				NonInvoiceDate: NonInvoiceRelatedDate,
				NonInvoiceType: NonInvoiceRelatedType,
				NonInvoiceTransaction: 	NonInvoiceRelatedTransactType,
				NonInvoiceAmount: NonInvoiceRelatedAmount,
				nonInvoiceAmounts: NonInvoiceRelatedAmounts,
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

					$('#btnInitialPayClose').hide();
					$('#btnInitialPayClose1').show();

					//hide the modal
					$('#modalNonInvoiceRelated').modal('hide');

					//show the data
					$.ajax({
						url: '<?php echo base_url(). 'telegraphicInvoiceHisController/fetchNONInvoiceDataToTable' ?>',
						type: 'POST',
						data: {invoice_num: NonInvoiceRelatedNumber,
							vendor: NonInvoiceRelatedVendor
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
			}

		});
	})

	$('#NonInvoicePaymentBtnFull').click(function(){
		
		var NonInvoiceRelatedVendor = $('#NonInvoiceRelatedVendorFull').val();
		var NonInvoiceRelatedNumber = $('#NonInvoiceRelatedNumberFull').val();
		var NonInvoiceRelatedDate = $('#NonInvoiceRelatedDateFull').val();
		var NonInvoiceRelatedType = $('#NonInvoiceRelatedTypeFull').val();
		var NonInvoiceRelatedTransactType = $('#NonInvoiceRelatedTransactTypeFull').val();
		var NonInvoiceRelatedReferenceNo = $('#NonInvoiceRelatedReferenceNoFull').val();
		var NonInvoiceRelatedRemarks = $('#NonInvoiceRelatedRemarksFull').val();
		var NonInvoiceRelatedAmountFulls = $('#NonInvoiceRelatedAmountFulls').val();
		var NonInvoiceRelatedAmount = $('#NonInvoiceRelatedAmountFull').val();
		var NonInvoiceRelatedRfp = $('#NonInvoiceRelatedRfpFull').val();

		$.ajax({
			url: "<?php echo base_url(). 'telegraphicInvoiceHisController/InsertInitialNonInvoicePay' ?>",
			type: 'POST',
			data: {
				NonInvoiceVendor: NonInvoiceRelatedVendor,
				NonInvoiceNumber: NonInvoiceRelatedNumber,

				NonInvoiceDate: NonInvoiceRelatedDate,
				NonInvoiceType: NonInvoiceRelatedType,
				NonInvoiceTransaction: 	NonInvoiceRelatedTransactType,
				NonInvoiceAmount: NonInvoiceRelatedAmount,
				nonInvoiceAmounts: NonInvoiceRelatedAmountFulls,
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

					$('#NonInvoiceRelatedReferenceNoFull').val('');
					$('#NonInvoiceRelatedRemarksFull').val('');
					$('#NonInvoiceRelatedAmountFull').val('');
					$('#NonInvoiceRelatedRfpFull').val('');

					//hide the modal
					$('#modalNonInvoiceRelatedFull').modal('hide');

					//show the data
					$.ajax({
						url: '<?php echo base_url(). 'telegraphicInvoiceHisController/fetchNONInvoiceDataToTable' ?>',
						type: 'POST',
						data: {invoice_num: NonInvoiceRelatedNumber,
							vendor: NonInvoiceRelatedVendor
						},
						dataType: 'JSON',
						success: function(result){

							

							var tableBody = $('#OthertbodyNonRelatedFull');

							tableBody.empty();

							$.each(result, function(index, item){

							var newRow = $('<tr>');

							
							// Create and append cells for each property
							newRow.append($('<td>').html(item.date));
							newRow.append($('<td>').html(item.otherTransacTypeName));
							newRow.append($('<td>').html(item.transactionName));
							newRow.append($('<td>').html(item.reference_no));
							newRow.append($('<td>').html(item.amount));
							newRow.append($('<td>').html(item.amount2));
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

	$('#generatePdf').click(function(){

		window.open('<?php echo base_url(). 'PDFInvoice/generatePdf'?>');

	})

	function uploadFile() 
	{
    	var formData = new FormData($('#upload-form')[0]);

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(). "PDFInvoice/do_upload" ?>',
			data: formData,
			contentType: false,
			processData: false,
			dataType: 'JSON',
			success: function(response) {
				if (response.error) {
					$('#upload-results').html('<p>Error: ' + response.error + '</p>');
				} else {
					var fileUrl = '<?php echo base_url() . "imageUpload/"; ?>' + response.upload_data.file_name;

					$('#upload-results').html('<p>File uploaded successfully!</p>');
					$('#upload-results').append('<p>File Name: ' + response.upload_data.file_name + '</p>');
					$('#upload-results').append('<p>File Size: ' + response.upload_data.file_size + ' KB</p>');
					$('#upload-results').append('<p>File URL: <a href="' + fileUrl + '" target="_blank">LINK</a></p>');
				}
			},
			error: function(error) {
				console.log(error);
				$('#upload-results').html('<p>Error occurred during file upload.</p>');
			}
		});
	}




</script>