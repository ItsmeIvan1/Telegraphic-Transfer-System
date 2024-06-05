
	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Accounts</h4>
			</div>

			<div class="heading-elements">
				<div class="heading-btn-group">
				</div>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="<?php echo base_url();?>mainController/dashboard"><i class="icon-home2 position-left"></i> Home</a></li>
				<li class="active">Accounts</li>
			</ul>

			<ul class="breadcrumb-elements">
			
			</ul>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
	<div class="content">

		<div style="padding-bottom: 10px;">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form_vertical"><i class="icon-user-plus position-left"></i> Add Accounts</button>	
		</div>	

		<!-- Main charts -->
		<div class="row">

			<div class="col-md-12">
				<div class="panel panel-flat">
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table datatable-basic">
												<thead>
													<tr class="bg-success">
													<th>Account Number</th>
													<th>Account Name</th>
													<th>Bank Name</th>	
													<th>Swift Code</th>
													<th>ABA No.</th>
													<th>Routing No.</th>
													<th>IBAN No.</th>
													<!-- <th>CIF No.</th>
													<th>BSB No.</th> -->
													<!-- <th>Intermediary Bank</th>
													<th>Inter Bank Address</th> -->
													<!-- <th>Number</th>
													<th>Swift</th>
													<th>ABA</th>
													<th>Chips</th> -->
													<th>Status</th>	
													<th>Approval Status</th>
													<th>Action</th>
													</tr>
												</thead>
												<tbody>

													<?php foreach($list as $lists){  ?>
													<tr>
													<td><?php echo $lists['accountNumber']  ?></td>
													<td><?php echo $lists['account_name']  ?></td>
													<td><?php echo $lists['bankName'] ?></td>
													<td><?php echo $lists['swiftCode'] ?></td>
													<td><?php echo $lists['abaNo'] ?></td>
													<td><?php echo $lists['routingNo'] ?></td>
													<td><?php echo $lists['ibanNo'] ?></td>
													<!-- <td><?php echo $lists['cifNo'] ?></td>
													<td><?php echo $lists['bsbNo'] ?></td> -->
													<!-- <td><?php echo $lists['intermediaryBank'] ?></td>
													<td><?php echo $lists['interbankAddress'] ?></td> -->
													<!-- <td><?php echo $lists['number'] ?></td>
													<td><?php echo $lists['swift'] ?></td>
													<td><?php echo $lists['aba'] ?></td>
													<td><?php echo $lists['chips'] ?></td> -->
													<td>
														<?php if($lists['status'] == 1){ ?>
														<span class="label label-success">
															<?php echo $lists['stats'] ?>
														</span>
														<?php } 
														
														else { ?>
														<span class="label label-danger">
															<?php echo $lists['stats'] ?>
														</span>
														<?php } ?>
													
													</td>
													<td>
													<?php if($lists['account_approval_status'] == 2){ ?>
														<span class="label label-default">
															<?php echo $lists['approval_stats'] ?>
														</span>
														<?php } 
														
														else { ?>
														<span class="label label-success">
															<?php echo $lists['approval_stats'] ?>
														</span>
														<?php } ?>
													</td>
														<td class="text-center">
															<ul class="icons-list">
																<li class="dropdown">
																	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																		<i class="icon-menu9"></i>
																	</a>

																	<ul class="dropdown-menu dropdown-menu-right">
																		<li><a onclick=fetchDataInModal(<?php echo $lists['accountCode'] ?>) data-toggle="modal" data-target="#modalUpdate"><i class="icon-pencil4"></i>Update</a></li>
																		
																			<?php if($lists['status'] == 1){ ?>
																				<li>
																					<a onclick=disableAccount(<?php echo $lists['accountCode'] ?>)><i class="icon-user-block"></i>Disable</a></li>
																				</li>
																			<?php } else { ?>
																				<li>
																				<a onclick=retrieveAccount(<?php echo $lists['accountCode'] ?>)><i class="icon-user-check"></i>Retrieve</a></li>
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

<!-- modal for adding acc -->
<div id="modal_form_vertical" class="modal fade in" tabindex="-1" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h5 class="modal-title">Add Accounts</h5>
			</div>

			<form id="frmAddAccount">
				<div class="modal-body">
					<div class="form-group">

						<div class="row" style="padding-bottom: 10px;">
							<div class="col-sm-4">
								<label>Account number <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="accountNumber" id="accountNumber">
							</div>

							<div class="col-sm-4">
								<label>Bank Name <span style='color:red;'>*</span></label>
								<!-- <input type="text" class="form-control" name="bankCode" id="bankCode"> -->
								<select class="form-control" name="bankCode" id="bankCode">
								<option value="">Select bank</option>
								
								<?php foreach($bank as $banks){ 
									$addressWords = explode(' ', $banks['bankAddress2']);
									
									$limitedAddress = implode(' ', array_slice($addressWords, 0, 4));
								?>
									<option value="<?php echo $banks['bankCode'] ?>"><?php echo $banks['bankName'] . ' - ' . $limitedAddress ?></option>
								<?php } ?>


								</select>
							</div>

							<div class="col-sm-4">
								<label>Swift Code </label>
								<input type="text" class="form-control" name="swiftCode" id="swiftCode">
							</div>
						</div>

						<div class="row" style="padding-bottom: 10px;">
						<div class="col-sm-4">
								<label>IBAN No. </label>
								<input type="text" class="form-control" name="ibanNo" id="ibanNo">
							</div>
							
							<div class="col-sm-4">
								<label>ABA No. </label>
								<input type="text" class="form-control" name="abaNo" id="abaNo">
							</div>

							<div class="col-sm-4">
								<label>Routing No. </label>
								<input type="text" class="form-control" name="routingNo" id="routingNo">
							</div>


						</div>

						<div class="row" style="padding-bottom: 10px;">

								<div class="col-sm-4">
									<label>CIF No. </label>
									<input type="text" class="form-control" name="cifNo" id="cifNo">
								</div>
								<div class="col-sm-4">
									<label>BSB No. </label>
									<input type="text" class="form-control" name="bsbNo" id="bsbNo">
								</div>

								<div class="col-sm-4">
								<label>Intermediary Bank </label>
								<input type="text" class="form-control" name="IntermediaryBank" id="IntermediaryBank">
							</div>

							</div>

						<div class="row" style="padding-bottom: 10px;">

							<div class="col-sm-4">
								<label>Inter bank Address </label>
								<input type="text" class="form-control" name="interBankAddress" id="interBankAddress">
							</div>

							<div class="col-sm-4">
								<label>Number </label>
								<input type="text" class="form-control" name="number" id="number">
							</div>
							<div class="row">
								
							<div class="col-sm-4">
								<label>Swift </label>
								<input type="text" class="form-control" name="swift" id="swift">
							</div>


						</div>


							<div class="col-sm-4">
								<label>Aba </label>
								<input type="text" class="form-control" name="aba" id="aba">
							</div>			

							<div class="col-sm-4">
								<label>Chips </label>
								<input type="text" class="form-control" name="chips" id="chips">
							</div>

						</div>
					</div>
				</div>
			</form>

			<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal" id="btnClose">Close</button>
					<button type="button" class="btn btn-success" id="addAccounts">Add</button>
			</div>

		</div>
	</div>
</div>

<!-- modal for update acc -->
<div id="modalUpdate" class="modal fade in" tabindex="-1" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h5 class="modal-title">Update Accounts</h5>
			</div>

			<form id="frmAddAccount">
				<div class="modal-body">
					<div class="form-group">

						<div class="row" style="padding-bottom: 10px;">
							<div class="col-sm-4">
								<input type="hidden" class="form-control" name="updateAccountCode" id="updateAccountCode">
								<label>Account number <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updateaccountNumber" id="updateaccountNumber" disabled>
							</div>

							<div class="col-sm-4">
								<label>Account name <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updateaccountName" id="updateaccountName" disabled>
							</div>

							<div class="col-sm-4">
								<label>Bank Name <span style='color:red;'>*</span></label>
								<!-- <input type="text" class="form-control" name="bankCode" id="bankCode"> -->
								<select class="form-control" name="updatebankCode" id="updatebankCode">
								<option value="">Select Bank name</option>
								
								<?php foreach($bank as $banks){ ?>
								<option value="<?php echo $banks['bankCode'] ?>"><?php echo $banks['bankName'] ?></option>
								<?php } ?>

								</select>
							</div>

						</div>

						<div class="row" style="padding-bottom: 10px;">
							<div class="col-sm-4">
								<label>Swift Code <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updateswiftCode" id="updateswiftCode">
							</div>
							<div class="col-sm-4">
								<label>ABA No. <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updateabaNo" id="updateabaNo">
							</div>

							<div class="col-sm-4">
								<label>Routing No. <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updateroutingNo" id="updateroutingNo">
							</div>

						</div>

						<div class="row" style="padding-bottom: 10px;">

							<div class="col-sm-4">
								<label>IBAN No. <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updateibanNo" id="updateibanNo">
							</div>

							<div class="col-sm-4">
								<label>CIF No. <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updatecifNo" id="updatecifNo">
							</div>
							<div class="col-sm-4">
								<label>BSB No. <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updatebsbNo" id="updatebsbNo">
							</div>

							

						</div>

						<div class="row" style="padding-bottom: 10px;">
							<div class="col-sm-4">
								<label>Intermediary Bank <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updateIntermediaryBank" id="updateIntermediaryBank">
							</div>
							<div class="col-sm-4">
								<label>Inter bank Address <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updateinterBankAddress" id="updateinterBankAddress">
							</div>

							<div class="col-sm-4">
								<label>Number <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updatenumber" id="updatenumber">
							</div>

						</div>

						<div class="row">
							<div class="col-sm-4">
								<label>Swift <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updateswift" id="updateswift">
							</div>

							<div class="col-sm-4">
								<label>Aba <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updateaba" id="updateaba">
							</div>			

							<div class="col-sm-4">
								<label>Chips <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updatechips" id="updatechips">
							</div>

							<!-- <div class="col-sm-4">
								<label>Status <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="status" id="status">
								<select class="form-control" name="updatestatus" id="updatestatus">
									<?php foreach($stat as $stats){ ?>
									<option value="<?php echo $stats['status_id'] ?>"><?php echo $stats['stats'] ?></option>
									<?php } ?>
								</select>
							</div> -->
						</div>

					</div>
				</div>
			</form>

			<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" id="updateAccountsbtn">Update</button>
			</div>

		</div>
	</div>
</div>

<script>

$('#li5').addClass('active');

$('.datatable-basic').DataTable();

var delay = 1200;

$('#addAccounts').click(function()
{
	var frmAddAccount = $('#frmAddAccount').serialize();

	$.ajax({
		 url: "<?php echo base_url() . 'accountsController/insertAccount' ?>",
		 type: 'POST',
		 data: frmAddAccount,
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

			else
			{
				if(res.s == 6)
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
					if(res.stats == 2)
					{
						swal({
						title: "Success",
						text: res.mess,
						type: "success",
						});

						setTimeout(function(){ window.location.reload(); }, delay);
					}

					else
					{
						swal({
						title: "Error",
						text: res.mess,
						type: "error",
						closeOnClickOutside: false
						});
					}
				}
			}
		}
	});
})

function disableAccount(accountCode)
{
	$.ajax({
	url: "<?php echo base_url(). 'accountsController/alertIfDisable'; ?>",
	type: 'POST',
	data: {accCode: accountCode},
	dataType: 'JSON',
	success: function(res)
	{
		if(res.status == 0)
		{

			swal({
					title: "Are you sure?",
					text: res.message,
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#EF5350",
					confirmButtonText: "Yes",
					closeOnConfirm: false,
					showCancelButton: true,
				},
				function(isConfirm){
					if (isConfirm)
					{

						$.ajax({
						type: 'POST',
						url: "<?php echo base_url(). 'accountsController/disableAccount'; ?>",
						data: {accCode: accountCode},
						dataType: 'JSON',
						success: function(response)
						{
							if(response.stat == 1)
							{

								swal({
								title: "Disabled!",
								text: response.mess,
								confirmButtonColor: "#66BB6A",
								type: "success"
								});

								setTimeout(function(){ window.location.reload(); }, delay);
							}
						}
						});

					}
					
					else 
					{
			
					}
				});
		}
	}
   });
}

function retrieveAccount(accountCode)
{
	$.ajax({
	url: "<?php echo base_url(). 'accountsController/alertIfRetrieved'; ?>",
	type: 'POST',
	data: {accCode: accountCode},
	dataType: 'JSON',
	success: function(res)
	 {
		if(res.status == 0)
		{

			swal({
					title: "Are you sure?",
					text: res.message,
					type: "info",
					showCancelButton: true,
					confirmButtonColor: "#EF5350",
					confirmButtonText: "Yes",
					closeOnConfirm: false,
					showCancelButton: true,
				},
				function(isConfirm){
					if (isConfirm)
					{

						$.ajax({
						type: 'POST',
						url: "<?php echo base_url(). 'accountsController/retrieveAccount'; ?>",
						data: {accCode: accountCode},
						dataType: 'JSON',
						success: function(response)
						{
							if(response.stat == 1)
							{

								swal({
								title: "Retrieved!",
								text: response.mess,
								confirmButtonColor: "#66BB6A",
								type: "success"
								});

								setTimeout(function(){ window.location.reload(); }, delay);
							}
						}
						});

					}
					
					else 
					{
			
					}
				});







			
		}
	 }
    });
}

function fetchDataInModal(accountCode)
{
	var updateAccountCode = 	 $('#updateAccountCode');
	var updateAccountNumber = 	 $('#updateaccountNumber');
	var updateaccountName = 	 $('#updateaccountName');
	var updateBankCode	= 		 $('#updatebankCode');
	var updateSwiftCode	= 		 $('#updateswiftCode');
	var updateAbaNO = 			 $('#updateabaNo');
	var updateRoutingNo =		 $('#updateroutingNo');
	var updateIbanNo = 			 $('#updateibanNo');
	var updateCifNo = 			 $('#updatecifNo');
	var updateBsbNo =			 $('#updatebsbNo');
	var updateIntermediaryBank = $('#updateIntermediaryBank');
	var updateInterbankAddress = $('#updateinterBankAddress');
	var updateNumber = 			 $('#updatenumber');
	var updateSwift = 			 $('#updateswift');
	var updateAba = 			 $('#updateaba');
	var updateChips = 			 $('#updatechips');
	var updateStatus = 			 $('#updatestatus');

	$.ajax({
    url: "<?php echo base_url(). 'accountsController/fetchDataInModal'; ?>",
    type: 'POST',
    data: {accCode: accountCode},
    dataType: 'JSON',
    success: function(res){

		updateAccountCode.val(res.accountCode);
		updateAccountNumber.val(res.accountNumber);
		updateaccountName.val(res.account_name);
		updateBankCode.val(res.bankCode);
		updateSwiftCode.val(res.swiftCode);
		updateAbaNO.val(res.abaNo);
		updateRoutingNo.val(res.routingNo);
		updateIbanNo.val(res.ibanNo);
		updateCifNo.val(res.cifNo);
		updateBsbNo.val(res.bsbNo);
		updateIntermediaryBank.val(res.intermediaryBank);
		updateInterbankAddress.val(res.interbankAddress);
		updateNumber.val(res.number);
		updateSwift.val(res.swift);
		updateAba.val(res.aba);
		updateChips.val(res.chips);
		updateStatus.val(res.status);
     	}
    });
}

$('#updateAccountsbtn').click(function()
{

	var updatedAccountCode = 	  $('#updateAccountCode').val();
	var updateAccountName = 	  $('#updateaccountName').val();
	var updatedAccountNumber = 	  $('#updateaccountNumber').val();
	var updatedBankCode	= 		  $('#updatebankCode').val();
	var updatedSwiftCode =    	  $('#updateswiftCode').val();
	var updatedAbaNO =   		  $('#updateabaNo').val();
	var updatedRoutingNo = 		  $('#updateroutingNo').val();
	var updatedIbanNo =     	  $('#updateibanNo').val();
	var updatedCifNo = 			  $('#updatecifNo').val();
	var updatedBsbNo = 		 	  $('#updatebsbNo').val();
	var updatedIntermediaryBank = $('#updateIntermediaryBank').val();
	var updatedInterbankAddress = $('#updateinterBankAddress').val();
	var updatedNumber = 		  $('#updatenumber').val();
	var updatedSwift =  		  $('#updateswift').val();
	var updatedAba = 			  $('#updateaba').val();
	var updatedChips = 			  $('#updatechips').val();
	var updatedStatus = 		  $('#updatestatus').val();

	$.ajax({
		 url: "<?php echo base_url(). 'accountsController/updateAccountController'; ?>",
		 type: 'POST',
		 data: {
			accountCode:	  updatedAccountCode,
			accName:	  	  updateAccountName,
			accountNumber: 	  updatedAccountNumber,
			bankCode: 		  updatedBankCode,
			swiftCode:        updatedSwiftCode,
			abaNo:            updatedAbaNO,
			routingNo:        updatedRoutingNo,
			ibanNo:           updatedIbanNo,
			cifNo:            updatedCifNo,
			bsbNo:            updatedBsbNo,
			intermediaryBank: updatedIntermediaryBank,
			interBankAddress: updatedInterbankAddress,
			number:           updatedNumber,
			swift:            updatedSwift,
			aba:              updatedAba,
			chips:            updatedChips,
			status:           updatedStatus
		 },
		 dataType: 'JSON',
		 success: function(res){

			if(res.s == 1)
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
				if(res.status == 0)
				{
					swal({
					title: "Success",
					text: res.message,
					type: "success",
					});

					setTimeout(function(){ window.location.reload(); }, delay);
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
	});

})


$('#btnClose').click(function()
{

	$('#accountNumber').val('');
	$('#bankCode').val('');
	$('#swiftCode').val('');
	$('#abaNo').val('');
	$('#routingNo').val('');
	$('#ibanNo').val('');
	$('#cifNo').val('');
	$('#bsbNo').val('');
	$('#IntermediaryBank').val('');
	$('#interBankAddress').val('');
	$('#number').val('');
	$('#swift').val('');
	$('#aba').val('');
	$('#chips').val('');

});


</script>