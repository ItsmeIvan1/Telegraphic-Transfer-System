<!-- <meta http-equiv="refresh" content="10"> -->

<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Telegraphic Transfer PO History</h4>
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
													<th>PO No.</th>
													<th>PO Date</th>
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
																		<a href="" class="" onclick="InitialPaymentFunction('<?php echo $datas['PONumber'] ?>', '<?php echo $datas['vendorCode'] ?>')" data-toggle="modal" data-target="#modalInitialPaymentDetailss"><i class="icon icon-file-eye position-left"></i>Payment History</a>
																	</li>																
																	<?php } else { ?>
																	<li>
																		<a href="" class="" onclick="FullPaymentFunction('<?php echo $datas['PONumber'] ?>', '<?php echo $datas['vendorCode'] ?>')" data-toggle="modal" data-target="#modalFullpayments"><i class="icon icon-file-eye position-left"></i>Payment History</a>
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
								<h5 class="modal-title">Payment History / PO</h5>
							</div>

							<div class="modal-body">
								<div class="row">

									<div class="col-md-6">
										<div class="pre-scrollable">
											<table class="table " id="">
																		<thead>
																			<tr class="bg-success-400">
																				<th>PO #</th>
																				<th>PO date</th>
																				<th>PO amount</th>
																				<th>Total payment</th>
																				<th>Remaining Balance</th>
																				<th>Payment Type</th>
																				<th>Date</th>
																				<th>Remarks</th>
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
																<th>PO #</th>
																<th>Type</th>
																<th>Transaction type</th>
																<th>Reference no.</th>
																<th>Date created</th>
																<th>Amount</th>
																<th>Payment</th>
																<th>Remarks</th>
																<th>RFP</th>
															
															
															</tr>
														</thead>
														<tbody id="OthertbodyHis">
										
														</tbody>
													</table>
											</div>

											<div style="padding-bottom: 3px;">
												<button class="btn btn-primary" data-toggle="modal" data-target="#modalOtherInitialpaymentHistory" id="AddOtherPaymentBTN">Other payment</button>
											</div>


											<!-- Non PO Related -->

                                            <div class="pre-scrollable">
                                                    <table class="table" id="initialPaymentTable">
                                                        <thead>
                                                            <tr class="bg-success-400">
                                                                <th>Date</th>
                                                                <th>Type</th>
                                                                <th>Transaction</th>
                                                                <th>Reference no.</th>
																<th>Amount</th>
                                                                <th>Payment</th>
																<th>Total</th>
                                                                <th>Remarks</th>
                                                                <th>RFP</th>
                                                                
                                                            
                                                            
                                                            </tr>
                                                        </thead>
                                                        <tbody id="OthertbodyNonPO">
                                        
                                                        </tbody>
                                                    </table>
                                            </div>

											<div style="padding-bottom: 3px;">
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#modalOtherpaymentNonPOTBL" id="AddOtherPaymentBTNNONPO">Non-po payment</button>
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

<!-- fullpaymentModal -->
<div id="modalFullpayments" class="modal fade" tabindex="-1" data-backdrop="static">
					<div class="modal-dialog modal-full">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"  id="btnCls">&times;</button>
								<button type="button" class="close" data-dismiss="modal" style="display: none;" id="btnCls1">&times;</button>
								<h5 class="modal-title">Payment History</h5>
							</div>

							<div class="modal-body">
								<div class="row">
									<div class="col-md-6">
										<div class="pre-scrollable">
											<table class="table " id="FullPaymentTable">
																	<thead>
																		<tr class="bg-success-400">
																			<th>PO#</th>
																			<!-- <th>PO date</th> -->
																			<th>Amount</th>
																			<th>Payment</th>
																			<!-- <th>Change</th> -->
																			<th>Balance</th>
																			<th>Type</th>
																			<th>Date Created</th>
																			<th>Remarks</th>
																			<th>RFP</th>
																		
																		
																		</tr>
																	</thead>
																	<tbody id="tbodyFullpayment">

																	</tbody>
											</table>
										</div>
									</div>

									<div class="col-md-6">

										<!-- otherpayment -->
										<div class="pre-scrollable">
												<table class="table" id="initialPaymentTable">
													<thead>
														<tr class="bg-success-400">
															<th>PO#</th>
															<th>Type</th>
															<th>Transaction</th>
															<th>Reference</th>
															<th>Date created</th>
															<th>Amount</th>
															<th>Payment</th>
															<th>Remarks</th>
															<th>RFP</th>
														
														
														</tr>
													</thead>
													<tbody id="Othertbody">
									
													</tbody>
												</table>
										</div>

										<div style="padding-bottom: 5px;">
												<button class="btn btn-primary" data-toggle="modal" data-target="#modalOtherFullpaymentHistory" id="AddOtherPaymentBTN">PO Payment</button>
										</div>

												<!-- otherpayment NON PO -->
												<div class="pre-scrollable">
												<table class="table" id="initialPaymentTableNONPO">
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
													<tbody id="OthertbodyNONPOS">
									
													</tbody>
												</table>
										</div>

										<div style="padding-bottom: 5px;">
												<button class="btn btn-primary" data-toggle="modal" data-target="#modalOtherpaymentNonPOTBLFULL" id="AddOtherPaymentBTNNONPOS">NON-PO Payment</button>
										</div>


									</div>
								</div>
	
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-warning" id="btnClsFullPayment" data-dismiss="modal" >Close</button>
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
								
										<!-- <div class="col-md-12"> -->
											<!-- <label>Vendor Name<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="nonPORelatedVendor" disabled>
										<!-- </div> -->

										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>PO #<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" name="" id="nonPORelatedPO" disabled>
										<!-- </div> -->
										
										<div class="col-md-12">
											<label>Date<span style="color: red;">*</span></label>
											<input type="text" class="form-control daterange-single" name="" id="nonPORelatedDate">
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
											<input type="text" name="" id="nonPORelatedAmountt" class="form-control">
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

<!-- modal for modalOtherpayment NON PO RELATED 2nd modal-->
<div id="modalOtherpaymentNonPOTBLFULL" class="modal fade" tabindex="-1" data-backdrop="static">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h5 class="modal-title">Other Payment / Non-po related</h5>
								</div>

								<div class="modal-body">
									<div class="row">
								
										<!-- <div class="col-md-12"> -->
											<!-- <label>Vendor Name<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" id="nonPORelatedVendorFULL" disabled>
										<!-- </div> -->

										<!-- <div class="col-md-12" style="padding-top: 5px;">
											<label>PO #<span style="color: red;">*</span></label> -->
											<input type="hidden" class="form-control" name="" id="nonPORelatedPOFULL" disabled>
										<!-- </div> -->
										
										<div class="col-md-12">
											<label>Date<span style="color: red;">*</span></label>
											<div class="input-group">
												<span class="input-group-addon"><i class="icon-calendar22"></i></span>
												<input type="text" placeholder="Select date" class="form-control pickadate-accessibility picker__input" name="" id="nonPORelatedDateFULL">
											</div>
											
										</div>
										
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Type <span style="color: red;">*</span></label>
											<select class="form-control" name="" id="nonPORelatedTypeFULL">
												<?php foreach($otherTrans as $otherTranss){ ?>
												<option value="<?php echo $otherTranss['otherTransacTypeCode'] ?>"><?php echo $otherTranss['otherTransacTypeName'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Transaction Type <span style="color: red;">*</span></label>
					
											<select class="form-control" name="" id="nonPORelatedTransactionFULL">
												<?php foreach($deduc as $deducs){ ?>
												<option value="<?php echo $deducs['transactionCode'] ?>"><?php echo $deducs['transactionName'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-12" style="padding-top: 5px;">
											<label>Reference No<span style="color: red;">*</span></label>
											<input type="text" class="form-control" name="" id="nonPORelatedReferenceNoFULL">
										</div>


										<div class="col-md-12" style="padding-top: 5px;">
											<label>Amount <span style="color: red;">*</span></label>
											<input type="text" name="" id="nonPORelatedAmountsFULL" class="form-control">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Payment <span style="color: red;">*</span></label>
											<input type="text" name="" id="nonPORelatedAmountFULL" class="form-control">
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>Remarks</label>
											<input type="text" class="form-control" name="" id="nonPORelatedRemarksFULL" >
										</div>

										<div class="col-md-12" style="padding-top: 5px;">
											<label>RFP <span style="color: red;">*</span></label>
											<input type="text" class="form-control" name="" id="nonPORelatedRFPFULL" >
										</div>
									
									</div>
							
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
									<button type="button" class="btn btn-primary" id="nonPORelatedPaymentBtnFull">Pay</button>
								</div>
							</div>
						</div>
</div>


<!-- modal for add another other payment -->
<div id="modalOtherInitialpaymentHistory" class="modal fade" tabindex="-1" data-backdrop="static">
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
										<label>PO #<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="InitialOtherPaymentPOHis" disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>PO amount<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="InitialOtherPaymentPOAmountHis" disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>PO date<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="InitialOtherpaymentDateHis" disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Total payment<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="totalPaidHISInitial"  disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Remaining balance<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="InitialOtherRemainingBalHis" value='0' disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Initial payment<span style="color: red;">*</span></label>
										<input type="text" class="form-control" id="InitialOtherPaymentHis" disabled="">
									</div> -->
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
											<?php foreach($deduct_2 as $deducs){ ?>
											<option value="<?php echo $deducs['id'] ?>"><?php echo $deducs['transact_name'] ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Reference No.<span style="color: red;">*</span></label>
										<input type="text" class="form-control" id="InitialOtherReferenceNumHis">
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
										<label>Remarks</label>
										<input type="text" class="form-control" id="InitialOtherRemarksHis" >
									</div>

									
									<div class="col-md-12" style="padding-top: 5px;">
										<label>RFP<span style="color: red;">*</span></label>
										<input type="text" id="InitialOtherRFPtHis" class="form-control">
									</div>
									
								</div>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
								<button type="button" class="btn btn-primary" id="AddOtherPaymentHis">Pay</button>
							</div>
						</div>
					</div>
</div>

<!-- modal for add another other payment in Fullpayment-->
<div id="modalOtherFullpaymentHistory" class="modal fade" tabindex="-1" data-backdrop="static">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" >&times;</button>
								<h5 class="modal-title">Other Payment</h5>
							</div>

							<div class="modal-body">
								<div class="row">
									
								
									<!-- <label>Vendor name</label> -->
									<input type="hidden" class="form-control" id="FullOtherPaymentVendor" disabled>


									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>PO #<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="FullOtherPaymentPOHis" disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>PO amount<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="FullOtherPaymentPOAmountHis" disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>PO date<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="FullOtherpaymentDateHis" disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Total payment<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="totalPaidHIS"  disabled>
									<!-- </div> -->
									<!-- <div class="col-md-12" style="padding-top: 5px;">
										<label>Remaining balance<span style="color: red;">*</span></label> -->
										<input type="hidden" class="form-control" id="FullOtherRemainingBalHis" value='0' disabled>
									<!-- </div> -->
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Type<span style="color: red;">*</span></label>
										<select class="form-control" id="FullFetchOtherTransactTypeHis" >
											<?php foreach($otherTrans as $otherTranss){ ?>
											<option value="<?php echo $otherTranss['otherTransacTypeCode'] ?>"><?php echo $otherTranss['otherTransacTypeName'] ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Transaction type<span style="color: red;">*</span></label>
										<select class="form-control" id="FullOtherTrasactionHis">
											<?php foreach($deduct_2 as $deducs){ ?>
											<option value="<?php echo $deducs['id'] ?>"><?php echo $deducs['transact_name'] ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Reference No.<span style="color: red;">*</span></label>
										<input type="text" class="form-control" id="FullOtherReferenceNumHis">
									</div>

									
									<div class="col-md-12" style="padding-top: 5px;">
										<label>Amount<span style="color: red;">*</span></label>
										<input type="text" id="FullOtherpaymentAmountHiss" class="form-control">
									</div>

									<div class="col-md-12" style="padding-top: 5px;">
										<label>Payment<span style="color: red;">*</span></label>
										<input type="text" id="FullOtherpaymentAmountHis" class="form-control">
									</div>

									<div class="col-md-12" style="padding-top: 5px;">
										<label>Remarks</label>
										<input type="text" class="form-control" id="FullOtherRemarksHis" >
									</div>

									<div class="col-md-12" style="padding-top: 5px;">
										<label>RFP<span style="color: red;">*</span></label>
										<input type="text" id="FullOtherRFPHis" class="form-control">
									</div>
									
								</div>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-link" data-dismiss="modal" id="">Close</button>
								<button type="button" class="btn btn-primary" id="FullAddOtherPaymentHis">Pay</button>
							</div>
						</div>
					</div>
</div>







<script>

	$('#btnClsFullPayment').hide();

$('.daterange-single').daterangepicker({ 
        singleDatePicker: true,
		//use if disable previos date
		// minDate: moment()

		isInvalidDate: function(date) {
        // Disable dates in the future
        return date.isAfter(moment());
    }
});

$('#li22').addClass('active');

$('.datatable-basic').DataTable();

var delay1 = 500;

$('#btnCls1').click(function(){

	setTimeout(function(){ window.location.reload(); }, delay1);
})

function InitialPaymentFunction(PO_NUMBER, VENDOR_CODE)
{

	$.ajax({
		url: "<?php echo base_url(). 'telegraphicTransferHistoryController/InitialPaymentDetails' ?>",
		type: 'POST',
		data: {PO_number: PO_NUMBER,
			   vendor: VENDOR_CODE},
		dataType: 'JSON',
		success: function(res){

			// console.log(res);

			var tableBody = $('#tbodyhistory');

			tableBody.empty();

			$.each(res, function(index, item){

			var newRow = $('<tr>');

			// Create and append cells for each property
			newRow.append($('<td>').html(item.PO_number));
			newRow.append($('<td>').html(item.PO_date));
			newRow.append($('<td>').html(item.PO_amount));
			newRow.append($('<td>').html(item.total_payment));
			newRow.append($('<td>').html(item.total_balance));
			newRow.append($('<td>').html(item.paymentName));
			newRow.append($('<td>').html(item.date_created));
			newRow.append($('<td>').html(item.remarks));
			newRow.append($('<td>').html(item.rfp));
			

			// Append the row to the table body
			tableBody.append(newRow);
			// var InitialPaymentVendor = $('#InitialPaymentVendor').val(item.Vendor);	
			// var InitialPaymentPO = $('#InitialPaymentPO').val(item.PO_number);
			// var InitialpaymentDate = $('#InitialpaymentDate').val(item.PO_date);
			// var InitialPaymentPOAmount = $('#InitialPaymentPOAmount').val(item.PO_amount);
			// var InitialTotalPayment = $('#InitialTotalPayment').val(item.sum_total_payment);
			// var InitialRemainingBalance = $('#InitialRemainingBalance').val(item.total_balance);
			// var InitialpaymentTypePay = $('#InitialpaymentTypePay').val(item.payment_type);

			//it shows if dont have other payment
			$('#InitialOtherPaymentVendor').val(item.Vendor);
			$('#InitialOtherPaymentPOHis').val(item.PO_number);
			$('#InitialOtherPaymentPOAmountHis').val(item.PO_amount);
			$('#InitialOtherpaymentDateHis').val(item.PO_date);

			
			$('#totalPaidHISInitial').val(item.total_paid_initial);
			$('#InitialOtherRemainingBalHis').val(item.updated_total_payment);

			$('#nonPORelatedVendor').val(item.Vendor);
			$('#nonPORelatedPO').val(item.PO_number);

	

			})


		


	
		}
	});


	//fetch other payment
	$.ajax({
		url: '<?php echo base_url(). 'telegraphicTransferHistoryController/fetchOtherPaymentHis' ?>',
		type: 'POST',
		data: {po_num: PO_NUMBER,
			vendor: VENDOR_CODE},
		dataType: 'JSON',
		success: function(res){

		var tableBody = $('#OthertbodyHis');

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
		newRow.append($('<td>').html(item.Remarks));
		newRow.append($('<td>').html(item.rfp));


		// Append the row to the table body
		tableBody.append(newRow);

		//fetch payment details
		$('#InitialOtherPaymentPOHis').val(item.otherPONumber);
		$('#InitialOtherPaymentPOAmountHis').val(item.otherPOAmount);
		$('#InitialOtherpaymentDateHis').val(item.otherPODate);

		$('#InitialOtherPaymentHis').val(item.updated_deduct_adjustment);

		

		})

		}
	});


	//fetch OtherPaymentNonPO Related
	$.ajax({
		url: "<?php echo base_url(). 'telegraphicTransferHistoryController/fetchNONPOdataToTBL' ?>",
		type: 'POST',
		data: {
			po: PO_NUMBER ,
			vendor: VENDOR_CODE
			},
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

$('#AddOtherPaymentHis').click(function(){
	
	var InitialOtherPaymentPOHis = $('#InitialOtherPaymentPOHis').val();
	var InitialOtherPaymentVendor = $('#InitialOtherPaymentVendor').val();
	var InitialOtherPaymentPOAmountHis = $('#InitialOtherPaymentPOAmountHis').val();
	var InitialOtherpaymentDateHis = $('#InitialOtherpaymentDateHis').val();

	var InitialOtherRemainingBalHis = $('#InitialOtherRemainingBalHis').val();

	var FetchOtherTransactTypeHis = $('#FetchOtherTransactTypeHis').val();
	var InitialOtherTrasactionHis = $('#InitialOtherTrasactionHis').val();
	var InitialOtherReferenceNumHis = $('#InitialOtherReferenceNumHis').val();
	var InitialOtherRemarksHis = $('#InitialOtherRemarksHis').val();
	var InitialOtherpaymentAmountHis = $('#InitialOtherpaymentAmountHis').val();

	var InitialOtherpaymentAmountHiss = $('#InitialOtherpaymentAmountHiss').val();
	
	// var InitialOtherPaymentHis = $('#InitialOtherPaymentHis').val();
	
	var InitialOtherRFPtHis = $('#InitialOtherRFPtHis').val();

	var totalPaidHISInitial = $('#totalPaidHISInitial').val();

	$.ajax({
		 url: '<?php echo base_url(). 'telegraphicTransferHistoryController/updateOtherPaymentTBLHis' ?>',
		 type: 'POST',
		 data: {
			POnum: InitialOtherPaymentPOHis,
			vendor: InitialOtherPaymentVendor,
			POamt: InitialOtherPaymentPOAmountHis,
			POdate: InitialOtherpaymentDateHis,
			amt: InitialOtherpaymentAmountHis,
			amts: InitialOtherpaymentAmountHiss,
			type: FetchOtherTransactTypeHis,
			TransactType: InitialOtherTrasactionHis,
			referenceNo: InitialOtherReferenceNumHis,
			remarks: InitialOtherRemarksHis,
			updatedInitialPay: InitialOtherRemainingBalHis,
			// updatedInitialPay: InitialOtherPaymentHis,
			totalPaid: totalPaidHISInitial,
			rfp: InitialOtherRFPtHis,
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

				$('#modalOtherInitialpaymentHistory').modal('hide');

				$('#InitialOtherReferenceNumHis').val('');
				$('#InitialOtherRemarksHis').val('');
				$('#InitialOtherpaymentAmountHis').val('');

				
				//fetch other payment
				$.ajax({
				url: '<?php echo base_url(). 'telegraphicTransferHistoryController/fetchOtherPaymentHis' ?>',
				type: 'POST',
				data: {po_num: InitialOtherPaymentPOHis,
					   vendor: InitialOtherPaymentVendor},
				dataType: 'JSON',
				success: function(res){

					var tableBody = $('#OthertbodyHis');

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
					newRow.append($('<td>').html(item.Remarks));
					newRow.append($('<td>').html(item.rfp));


					// Append the row to the table body
					tableBody.append(newRow);

					//fetch payment details
					$('#InitialOtherPaymentPOHis').val(item.otherPONumber);
					$('#InitialOtherPaymentPOAmountHis').val(item.otherPOAmount);
					$('#InitialOtherpaymentDateHis').val(item.otherPODate);
					// $('#InitialOtherRemainingBalHis').val(item.transAmt);
					$('#InitialOtherPaymentHis').val(item.updated_deduct_adjustment);

					$('#totalPaidHISInitial').val(item.total_paid_amount);
					$('#InitialOtherRemainingBalHis').val(item.updated_deduct_adjustment);
					})
					
					}
					});

			}



		}
	});


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
	var nonPORelatedAmountt = $('#nonPORelatedAmountt').val();
	var nonPORelatedRFP = $('#nonPORelatedRFP').val();

	

	

	$.ajax({
	url: "<?php echo base_url(). 'telegraphicTransferHistoryController/insertInitialOtherTransactNONPO' ?>",
	type: 'POST',
	data: { VendorPaymentNONPO: nonPORelatedVendor,
			PaymentNONPO: nonPORelatedPO,
			DateNONPO: nonPORelatedDate,
			TransactTypeNONPO: nonPORelatedType,
			TrasactionNONPO: nonPORelatedTransaction,
			ReferenceNoNONPO: nonPORelatedReferenceNo,
			RemarksNONPO: nonPORelatedRemarks,
			AmountNONPO: nonPORelatedAmount,
			amountt: nonPORelatedAmountt,
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
				url: "<?php echo base_url(). 'telegraphicTransferHistoryController/fetchNONPOdataToTBL' ?>",
				type: 'POST',
				data: {
					po: nonPORelatedPO ,
					vendor: nonPORelatedVendor
					},
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

function FullPaymentFunction(PO_NUMBER, VENDOR_CODE)
{
	$.ajax({
		url: "<?php echo base_url(). 'telegraphicTransferHistoryController/viewFullpayments' ?>",
		type: 'POST',
		data: {PO_number: PO_NUMBER,
			   vendor: VENDOR_CODE},
		dataType: 'JSON',
		success: function(res){

			var tableBody = $('#tbodyFullpayment');

			tableBody.empty();

			$.each(res, function(index, item){

			var newRow = $('<tr>');

			newRow.append($('<td>').html(item.PO_number));
			// newRow.append($('<td>').html(item.PO_date));
			newRow.append($('<td>').html(item.PO_amount));
			newRow.append($('<td>').html(item.total_payment));
			// newRow.append($('<td>').html(item.change));
			newRow.append($('<td>').html(item.total_balance));
			newRow.append($('<td>').html(item.paymentName));
			newRow.append($('<td>').html(item.date));
			newRow.append($('<td>').html(item.remarks));
			newRow.append($('<td>').html(item.rfp));

			tableBody.append(newRow);
			
			$('#FullOtherPaymentVendor').val(item.Vendor);
			$('#FullOtherPaymentPOHis').val(item.PO_number);
			$('#FullOtherPaymentPOAmountHis').val(item.PO_amount);
			$('#FullOtherpaymentDateHis').val(item.PO_date);
			$('#totalPaidHIS').val(item.total_payment);
			
			$('#nonPORelatedVendorFULL').val(item.Vendor);
			$('#nonPORelatedPOFULL').val(item.PO_number);

			})

			}
	});


	//fetch other payment
	$.ajax({
		url: '<?php echo base_url(). 'telegraphicTransferHistoryController/fetchOtherPaymentHis' ?>',
		type: 'POST',
		data: {po_num: PO_NUMBER,
				vendor: VENDOR_CODE},
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
			newRow.append($('<td>').html(item.Remarks));
			newRow.append($('<td>').html(item.rfp));
		

			// Append the row to the table body
			tableBody.append(newRow);

			//fetch payment details
			
			$('#FullOtherPaymentPOHis').val(item.otherPONumber);
			$('#FullOtherPaymentPOAmountHis').val(item.otherPOAmount);
			$('#FullOtherpaymentDateHis').val(item.otherPODate);
			$('#FullOtherRemainingBalHis').val(item.updated_deduct_adjustment);



			})

		}
	});

	
	//fetch OtherPaymentNonPO Related
	$.ajax({
		url: "<?php echo base_url(). 'telegraphicTransferHistoryController/fetchNONPOdataToTBL' ?>",
		type: 'POST',
		data: {
			po: PO_NUMBER,
			vendor: VENDOR_CODE
			},
		dataType: 'JSON',
		success: function(res){

		var tableBody = $('#OthertbodyNONPOS');

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

$('#FullAddOtherPaymentHis').click(function(){

		var FullOtherPaymentVendor = $('#FullOtherPaymentVendor').val();
		var FullOtherPaymentPOHis =	$('#FullOtherPaymentPOHis').val();
		var FullOtherPaymentPOAmountHis = $('#FullOtherPaymentPOAmountHis').val();
		var FullOtherpaymentDateHis = $('#FullOtherpaymentDateHis').val();
		var FullOtherRemainingBalHis = $('#FullOtherRemainingBalHis').val();
		
		var FullFetchOtherTransactTypeHis = $('#FullFetchOtherTransactTypeHis').val();
		var FullOtherTrasactionHis = $('#FullOtherTrasactionHis').val();	
		var FullOtherReferenceNumHis = $('#FullOtherReferenceNumHis').val();
		var FullOtherRemarksHis = $('#FullOtherRemarksHis').val();
		var FullOtherpaymentAmountHis = $('#FullOtherpaymentAmountHis').val();
		var FullOtherpaymentAmountHiss = $('#FullOtherpaymentAmountHiss').val();

		var FullOtherRFPHis = $('#FullOtherRFPHis').val();

		var totalPaidHis = $('#totalPaidHIS').val();
		
		$.ajax({
		 url: '<?php echo base_url(). "telegraphicTransferHistoryController/updateOtherPaymentTBLHis" ?>',
		 type: 'POST',
		 data: {
			POnum: 	FullOtherPaymentPOHis,
			vendor: FullOtherPaymentVendor,
			POamt: 	FullOtherPaymentPOAmountHis,
			POdate: FullOtherpaymentDateHis,
			type: FullFetchOtherTransactTypeHis,
			TransactType: FullOtherTrasactionHis,
			referenceNo: FullOtherReferenceNumHis,
			remarks: FullOtherRemarksHis,
			amt: FullOtherpaymentAmountHis,
			amts: FullOtherpaymentAmountHiss,
			updatedInitialPay: FullOtherRemainingBalHis,
			totalPaid: totalPaidHis,
			rfp: FullOtherRFPHis

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

				$('#modalOtherFullpaymentHistory').modal('hide');

				$('#FullOtherTrasactionHis').val('');
				$('#FullOtherReferenceNumHis').val('');
				$('#FullOtherRemarksHis').val('');
				$('#FullOtherpaymentAmountHis').val('');

				
				//fetch other payment
				$.ajax({
				url: '<?php echo base_url(). 'telegraphicTransferHistoryController/fetchOtherPaymentHis' ?>',
				type: 'POST',
				data: {po_num: FullOtherPaymentPOHis,
						vendor: FullOtherPaymentVendor},
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
					newRow.append($('<td>').html(item.Remarks));
					newRow.append($('<td>').html(item.rfp));


					// Append the row to the table body
					tableBody.append(newRow);

					//fetch payment details
					// $('#FullOtherPaymentPOHis').val(item.PO_number);
					// $('#FullOtherPaymentPOAmountHis').val(item.PO_amount);
					// $('#FullOtherpaymentDateHis').val(item.PO_date);
					// $('#FullOtherRemainingBalHis').val(item.total_balance);

					$('#FullOtherPaymentPOHis').val(item.otherPONumber);
					$('#FullOtherPaymentPOAmountHis').val(item.otherPOAmount);
					$('#FullOtherpaymentDateHis').val(item.otherPODate);

					$('#totalPaidHIS').val(item.total_paid_amount);
					$('#FullOtherRemainingBalHis').val(item.updated_deduct_adjustment);
					
					})

					}
					});

			}

		}
		});


})

$('#nonPORelatedPaymentBtnFull').click(function(){
	
	var nonPORelatedVendorFULL = $('#nonPORelatedVendorFULL').val();
	var nonPORelatedPOFULL = $('#nonPORelatedPOFULL').val();
	var nonPORelatedDateFULL = $('#nonPORelatedDateFULL').val();
	var nonPORelatedTypeFULL = $('#nonPORelatedTypeFULL').val();
	var nonPORelatedTransactionFULL = $('#nonPORelatedTransactionFULL').val();
	var nonPORelatedReferenceNoFULL = $('#nonPORelatedReferenceNoFULL').val();
	var nonPORelatedRemarksFULL = $('#nonPORelatedRemarksFULL').val();
	var nonPORelatedAmountFULL = $('#nonPORelatedAmountFULL').val();
	var nonPORelatedAmountsFULL = $('#nonPORelatedAmountsFULL').val();
	var nonPORelatedRFPFULL = $('#nonPORelatedRFPFULL').val();


	$.ajax({
	url: "<?php echo base_url(). 'telegraphicTransferHistoryController/insertInitialOtherTransactNONPO' ?>",
	type: 'POST',
	data: { VendorPaymentNONPO: nonPORelatedVendorFULL,
			PaymentNONPO: nonPORelatedPOFULL,
			DateNONPO: nonPORelatedDateFULL,
			TransactTypeNONPO: nonPORelatedTypeFULL,
			TrasactionNONPO: nonPORelatedTransactionFULL,
			ReferenceNoNONPO: nonPORelatedReferenceNoFULL,
			RemarksNONPO: nonPORelatedRemarksFULL,
			AmountNONPO: nonPORelatedAmountFULL,
			amountt: nonPORelatedAmountsFULL,
			RFPNONPO: nonPORelatedRFPFULL
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

				$('#modalOtherpaymentNonPOTBLFULL').hide();

				$('#btnClsFullPayment').show();

				//clear data in field
				$('#nonPORelatedReferenceNoFULL, #nonPORelatedRemarksFULL, #nonPORelatedAmountFULL, #nonPORelatedRFPFULL').val('');

				$('#btnCls').hide();

				$('#btnCls1').show();


				//fetch OtherPaymentNonPO Related
				$.ajax({
				url: "<?php echo base_url(). 'telegraphicTransferHistoryController/fetchNONPOdataToTBL' ?>",
				type: 'POST',
				data: {
					po: nonPORelatedPOFULL,
					vendor: nonPORelatedVendorFULL
					},
				dataType: 'JSON',
				success: function(res){

						var tableBody = $('#OthertbodyNONPOS');

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