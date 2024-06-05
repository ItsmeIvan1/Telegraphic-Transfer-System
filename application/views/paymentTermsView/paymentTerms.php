

	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Payment Terms</h4>
			</div>

			<div class="heading-elements">
				<div class="heading-btn-group">
				</div>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="<?php echo base_url();?>mainController/afterLogin"><i class="icon-home2 position-left"></i> Home</a></li>
				<li class="active">Payment</li>
			</ul>

			<ul class="breadcrumb-elements">	
			</ul>
		</div>
	</div>



	<div class="content">
	<div style="padding-bottom: 10px;">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form_vertical"><i class="icon-cash position-left"></i> Add payment</button>	
	</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-flat">
					<div class="panel-body">
						<table class="table datatable-basic">
										<thead>
											<tr class="bg-success">

											<th>Payment Name</th>					
											<th>User created</th>
											<th>Date created</th>
											<th>Status</th>	
											<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>

											<?php foreach($payment as $payments){  ?>
											<tr>
												<td><?php echo $payments['paymentName']  ?></td>
												<td><?php echo $payments['userCreated'] ?></td>
												<td><?php echo $payments['dateCreated'] ?></td>
												<td>
													<?php if($payments['paymentStatus'] == 1){ ?>
													<span class="label label-success"><?php echo $payments['stats'] ?></span>
													<?php } else { ?>
													<span class="label label-danger"><?php echo $payments['stats'] ?></span>
													<?php } ?>
												</td>
												<td class="text-center">
													<ul class="icons-list">
														<li class="dropdown">
															<a href="#" class="dropdown-toggle" data-toggle="dropdown">
																<i class="icon-menu9"></i>
															</a>

															<ul class="dropdown-menu dropdown-menu-right">
																<li><a onclick=fetchUpdatePayment(<?php echo $payments['paymentTermCode'] ?>) data-toggle="modal" data-target="#modal_form_vertical_update"><i class="icon-pencil4"></i>Update</a></li>
																
																	<?php if($payments['paymentStatus'] == 1){ ?>
																		<li>
																			<a onclick=disablePayment(<?php echo $payments['paymentTermCode'] ?>)><i class="icon-user-block"></i>Disable</a></li>
																		</li>
																	<?php } else { ?>
																		<li>
																		<a onclick=retrievedPayment(<?php echo $payments['paymentTermCode'] ?>)><i class="icon-user-check"></i>Retrieve</a></li>
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

<!-- modal for adding payment -->
<div id="modal_form_vertical" class="modal fade in" tabindex="-1" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h5 class="modal-title">Add payment</h5>
			</div>

			<form id="frmAddPayment">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<label>Payment Name <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="paymentName" id="paymentName">
							</div>


						</div>
					</div>
				</div>
			</form>

			<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal" id="btnAddClose">Close</button>
					<button type="button" class="btn btn-success" id="addVendor">Add</button>
			</div>

		</div>
	</div>
</div>

<!-- Update modal -->
<div id="modal_form_vertical_update" class="modal fade in" tabindex="-1" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h5 class="modal-title">Update Payment</h5>
			</div>
			<form id="frmAddPayment">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
							<input type="hidden" class="form-control" name="updatePaymentTermCode" id="updatePaymentTermCode">
								<label>Name <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updatePaymentName" id="updatePaymentName">
							</div>

							<!-- <div class="col-sm-6">
								<label>Status <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="paymentStatus">
								<select class="form-control" name="updatePaymentStatus" id="updatePaymentStatus">
									<option value="">Select Status</option>
									<?php foreach($stat as $status){ ?>
									<option value="<?php echo $status['status_id'] ?>"><?php echo $status['stats'] ?></option>
									<?php }?>
								</select>
							</div> -->
						</div>
					</div>
				</div>
			</form>

			<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" id="updatePayment">Update</button>
			</div>
			
		</div>
	</div>
</div>
	
<script>

var delay = 1200;

// $('#myTable').DataTable();

$('.datatable-basic').DataTable();

$('#li3').addClass('active');

$('#addVendor').click(function(){

	var frmAddPayment = $('#frmAddPayment').serialize();

	$.ajax({
	url: "<?php echo base_url(). "paymentTermsController/addPayment"; ?>",
	type: 'POST',
	data: frmAddPayment,
	dataType: 'JSON',
	success: function(res)
	{
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
			if(res.stat == 2)
			{
				swal({
				title: "Error",
				text: res.mes,
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
   }
   });
})

function disablePayment(paymentTermCode){
	
	$.ajax({
		 url: "<?php echo base_url(). "paymentTermsController/alertIfDisable" ?>",
		 type: 'POST',
		 data: {paymentCode: paymentTermCode},
		 dataType: 'JSON',
		 success: function(res){

			if(res.stat == 2)
			{
		
				swal({
					title: "Are you sure?",
					text: res.mess,
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
						url: "<?php echo base_url(). 'paymentTermsController/disabledPayment'; ?>",
						data: {paymentCode: paymentTermCode},
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

			else
			{
				swal({
				title: "Oops...",
				text: res.message,
				type: "error",
				});
			}
		}
	});
}

function retrievedPayment(paymentTermCode){

	$.ajax({
		 url: "<?php echo base_url(). "paymentTermsController/alertIfRetrieve" ?>",
		 type: 'POST',
		 data: {paymentCode: paymentTermCode},
		 dataType: 'JSON',
		 success: function(res){

			if(res.stat == 2)
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
						url: "<?php echo base_url(). 'paymentTermsController/retrievedPayment'; ?>",
						data: {paymentCode: paymentTermCode},
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

			else
			{
				swal({
				title: "Oops...",
				text: res.message,
				type: "error",
				});
			}
		}
	});
}

function fetchUpdatePayment(paymentTermCode)
{	
	var updatePaymentTermCode = $('#updatePaymentTermCode');
	var updatePaymentName = 	$('#updatePaymentName');
	var updatePaymentStatus = 	$('#updatePaymentStatus');

	$.ajax({
	url: "<?php echo base_url(). 'paymentTermsController/fetchPaymentInModal'; ?>",
	type: 'POST',
	data: {paymentID: paymentTermCode},
	dataType: 'JSON',
	success: function(res){

		updatePaymentTermCode.val(res.paymentTermCode);
		updatePaymentName.val(res.paymentName);
		updatePaymentStatus.val(res.paymentStatus);
		
	}
	});
}

$('#updatePayment').click(function()
{

	var updatePaymentTermCode = $('#updatePaymentTermCode').val();
	var updatePaymentName =   	$('#updatePaymentName').val();
	var updatePaymentStatus = 	$('#updatePaymentStatus').val();

	$.ajax({
	url: "<?php echo base_url(). 'paymentTermsController/updatePaymentInModal'; ?>",
	type: 'POST',
	data: { 
			paymentTermCode: updatePaymentTermCode,
			paymentName: updatePaymentName,
			paymentStatus: updatePaymentStatus
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

		else
		{
			if(res.s == 2)
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
				if(res.stat == 2)
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

$('#btnAddClose').click(function()
{
	$('#paymentName').val('');
})

</script>