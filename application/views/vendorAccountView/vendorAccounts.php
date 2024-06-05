
	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Vendor Account</h4>
			</div>

			<div class="heading-elements">
				<div class="heading-btn-group">
				</div>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="<?php echo base_url();?>mainController/afterLogin"><i class="icon-home2 position-left"></i> Home</a></li>
				<li class="active">Vendor Account</li>
			</ul>

			<ul class="breadcrumb-elements">
			
			</ul>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
<div class="content">

	<div style="padding-bottom: 10px;">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form_vertical"><i class="icon-user-plus position-left"></i> Add vendor account</button>	
	</div>		

	<!-- Main charts -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-flat">
				<div class="panel-body">
					<table class="table datatable-basic">
									<thead>
										<tr class="bg-success">

										<th>Vendor Name</th>					
										<th>Account</th>
										<th>Currency</th>
										<th>Status</th>	
										<th>Approval Status</th>	
										<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>

										<?php foreach($data as $datas){ ?>	
										<tr>
											<td><?php echo $datas['vendorName']  ?></td>
											<td><?php echo $datas['accountNumber'] ?></td>
											<td><?php echo $datas['currency']  ?></td>
											<td>
												<?php if($datas['status'] == 1){ ?>

													<span class="label label-success">
														<?php echo $datas['stats']  ?>
													</span>
												<?php } else { ?>
													<span class="label label-danger">
														<?php echo $datas['stats']  ?>
													</span>
												<?php } ?>	
											</td>
											<td>
												<?php if($datas['approval_status'] == 2){ ?>

													<span class="label label-default">
														<?php echo $datas['approval_stats']  ?>
													</span>
												<?php } else { ?>
													<span class="label label-success">
														<?php echo $datas['approval_stats']  ?>
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
															<li><a onclick=fetchUpdateVendorAcc(<?php echo $datas['vendorAccountCode'] ?>) data-toggle="modal" data-target="#updateModal"><i class="icon-pencil4"></i>Update</a></li>
															
																<?php if($datas['status'] == 1){ ?>	
																	<li>
																		<a onclick=disable(<?php echo $datas['vendorAccountCode'] ?>)><i class="icon-user-block"></i>Disable</a></li>
																	</li>
																<?php } else { ?>
																	<li>
																	<a onclick=retrieved(<?php echo $datas['vendorAccountCode'] ?>)><i class="icon-user-check"></i>Retrieve</a></li>
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


	<!-- modal for adding payment -->
	<div id="modal_form_vertical" class="modal fade in" tabindex="-1" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h5 class="modal-title">Add vendor account</h5>
				</div>

				<form id="frmVendorAcc">
					<div class="modal-body">
						<div class="form-group">
							<div class="row" style="padding-bottom: 10px;">
								<div class="col-sm-6">
									<label>Vendor Name <span style='color:red;'>*</span></label>
									<!-- <input type="text" class="form-control" name="vendorCode"> -->
									<select class="form-control" name="vendorCode" id="vendorCode">
										<option value="">Select vendor</option>
										<?php foreach($vendorCode as $vendorCodes){ ?>
										<option value="<?php echo $vendorCodes['vendorCode']  ?>"><?php echo $vendorCodes['vendorName'] ?></option>
										<?php }?>
									</select>
								</div>

								<div class="col-sm-6">
									<label>Bank account # <span style='color:red;'>*</span></label>
									<!-- <input type="text" class="form-control" name="paymentStatus"> -->
									<select class="form-control" name="accountCode" id="accountCode">
										<option value="">Select account</option>
										<?php foreach($accountCode as $accountCodes){ ?>
										<option value="<?php echo $accountCodes['accountCode'] ?>"><?php echo $accountCodes['accountNumber'] ?></option>
										<?php }?>
									</select>
								</div>
							</div>

							<div class="row" >
								<div class="col-sm-6">
									<label>Currency <span style='color:red;'>*</span></label>
									<!-- <input type="text" class="form-control" name="accCurrency"> -->
									<select class="form-control" class="form-control" name="accCurrency" id="accCurrency">
										<option value=''>Select currency</option>
										<?php foreach($currency as $currencies) { ?>
										<option value='<?php echo $currencies['currency_id'] ?>'><?php echo $currencies['currency'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</form>

				<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal" id="btnClose">Close</button>
						<button type="button" class="btn btn-success" id="addVendorAccBtn">Add</button>
				</div>
			</div>
		</div>
	</div>

	<!-- modal for updating payment -->
	<div id="updateModal" class="modal fade in" tabindex="-1" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h5 class="modal-title">Update vendor account</h5>
				</div>

				<form id="frmVendorAcc">
					<div class="modal-body">
						<div class="form-group">
							<div class="row" style="padding-bottom: 10px;">
								<div class="col-sm-6">
								<input type="hidden" class="form-control" name="vendorAccountCode" id="updateVendorAccountCode">
									<label>Vendor Name <span style='color:red;'>*</span></label>
									<select class="form-control" name="vendorCode" id="updateVendorCode" disabled>
										<option value="">Select vendor</option>
										<?php foreach($vendorCode as $vendorCodes){ ?>
										<option value="<?php echo $vendorCodes['vendorCode']  ?>"><?php echo $vendorCodes['vendorName'] ?></option>
										<?php }?>
									</select>
								</div>

								<div class="col-sm-6">
									<label>Accounts <span style='color:red;'>*</span></label>
									<!-- <input type="text" class="form-control" name="paymentStatus"> -->
									<select class="form-control" name="accountCode" id="updateAccountCode" disabled>
										<option value="">Select account code</option>
										<?php foreach($accountCode as $accountCodes){ ?>
										<option value="<?php echo $accountCodes['accountCode'] ?>"><?php echo $accountCodes['accountNumber'] ?></option>
										<?php }?>
									</select>
								</div>
							</div>

							<div class="row" >
								<div class="col-sm-6">
									<label>Currency <span style='color:red;'>*</span></label>
									<!-- <input type="text" class="form-control" name="accCurrency" id="accCurrency"> -->
									<select class="form-control" class="form-control" name="updateaccCurrency" id="updateaccCurrency">
										<option value=''>Select currency</option>
										<?php foreach($currency as $currencies) { ?>
										<option value='<?php echo $currencies['currency_id'] ?>'><?php echo $currencies['currency'] ?></option>
										<?php } ?>
									</select>
								</div>

							
							</div>
						</div>

				

					</div>
				</form>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal" id="btnUpdateClose">Close</button>
					<button type="button" class="btn btn-success" id="updateVendorAcc">Update</button>
				</div>
			</div>
		</div>
	</div>

</div>


<script>

$('#li7').addClass('active');
$('.datatable-basic').DataTable();
var delay = 1200;

$('#updateVendorAcc').prop('disabled', true);

$('#updateaccCurrency').change(function(){
	$('#updateVendorAcc').prop('disabled', false);
})

$('#btnUpdateClose').click(function(){
	$('#updateVendorAcc').prop('disabled', true);
})

$('#addVendorAccBtn').click(function(){

	var frmVendorAcc = $('#frmVendorAcc').serialize();
	$.ajax({
		url: '<?php echo base_url(). 'vendorAccountController/insertVendorAcc' ?>',
		type: 'POST',
		data: frmVendorAcc,
		dataType: 'JSON',
		success: function(res){

		if(res.stat == 2)
		{
			swal({
			title: "Error",
			text: 'Please select first!',
			type: "error",
			closeOnClickOutside: false
			});
		}
		
		else
		{	
			if(res.s == 0)
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

	}
	});
})

function fetchUpdateVendorAcc(id)
{	
	var vendorAccountCode = $('#updateVendorAccountCode');
	var updateVendorCode = 	$('#updateVendorCode');
	var updateAccountCode = $('#updateAccountCode');
	var accCurrency = 		$('#updateaccCurrency');

	$.ajax({
	url: '<?php echo base_url(). 'vendorAccountController/fetchVendorAccountInModal' ?>',
	type: 'POST',
	data: {vendorAccCode: id},
	dataType: 'JSON',
	success: function(res){

	vendorAccountCode.val(res.vendorAccountCode)
	updateVendorCode.val(res.vendorCode);
	updateAccountCode.val(res.accountCode);
	accCurrency.val(res.account_currency);

	}
    });
}

$('#updateVendorAcc').click(function()
{

	var vendorAccountCode = $('#updateVendorAccountCode').val();
	var updateVendorCode = 	$('#updateVendorCode').val();
	var updateAccountCode = $('#updateAccountCode').val();
	var accCurrency = 		$('#updateaccCurrency').val();


	$.ajax({
		 url: '<?php echo base_url(). 'vendorAccountController/updateVendorAccountInModal' ?>',
		 type: 'POST',
		 data: {
			vendorAccCode:   vendorAccountCode,
			vendorCode: 	 updateVendorCode,
			accountCode: 	 updateAccountCode,
			accountCurrency: accCurrency, 		
		 },
		 dataType: 'JSON',
		 success: function(res)
		 {

			if(res.stat == 2)
			{
				swal({
				title: "Error",
				text: res.mess,
				type: "error",
				closeOnClickOutside: false
				});
			}

			else
			{

				if(res.s == 0)
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
		}
	});
})

function disable(vendorAccountCode)
{
	$.ajax({
		 url: '<?php echo base_url(). 'vendorAccountController/alertDisabled' ?>',
		 type: 'POST',
		 data: {
			btn: vendorAccountCode
		 },
		 dataType: 'JSON',
		 success: function(res)
		 {

			if(res.s == 0)
			{

				swal({
					title: "Are you sure?",
					text: res.m,
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
						url: "<?php echo base_url(). 'vendorAccountController/disableVendorAcc'; ?>",
						data: {btn: vendorAccountCode},
						dataType: 'JSON',
						success: function(response)
						{
							if(response.status == 1)
							{

								swal({
								title: "Disabled!",
								text: response.message,
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

function retrieved(vendorAccountCode)
{
	$.ajax({
		 url: '<?php echo base_url(). 'vendorAccountController/alertRetrieved' ?>',
		 type: 'POST',
		 data: {
			btn: vendorAccountCode
		 },
		 dataType: 'JSON',
		 success: function(res)
		 {

			if(res.stat == 0)
			{

				swal({
					title: "Are you sure?",
					text: res.mess,
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
						url: "<?php echo base_url(). 'vendorAccountController/retrievedVendorAcc'; ?>",
						data: {btn: vendorAccountCode},
						dataType: 'JSON',
						success: function(response)
						{
							if(response.status == 1)
							{

								swal({
								title: "Retrieved!",
								text: response.message,
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

$('#btnClose').click(function()
{
	$('#vendorCode').val('');
	$('#accountCode').val('');
	$('#accCurrency').val('');
})

</script>