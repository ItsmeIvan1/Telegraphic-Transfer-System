	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Vendor</h4>
			</div>

			<div class="heading-elements">
				<div class="heading-btn-group">
				</div>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="<?php echo base_url();?>mainController/afterLogin"><i class="icon-home2 position-left"></i> Home</a></li>
				<li class="active">Vendor</li>
			</ul>

			<ul class="breadcrumb-elements">
			
			</ul>
		</div>
	</div>
	<!-- /page header -->

	<!-- Content area -->
	<div class="content">
			<div style="padding-bottom: 10px;">
				<button type="button" class="btn btn-primary" id="btnAddVendor" data-toggle="modal" data-target="#modal_form_vertical"><i class="icon-user-plus position-left"></i> Add vendor</button>	
			</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-flat">
					<div class="panel-body">
						<table class="table datatable-basic">
								<thead>
									<tr class="bg-success">

									<th>Vendor Name</th>
									<!-- <th>Address 1</th> -->
									<th>Address 1</th>
									<th>Country</th>
									<th>Status</th>
									<th>Approval Status</th>
									<th>Action</th>
									</tr>
								</thead>
								<tbody>

								<?php foreach($vendor as $vendors){?>	
									<tr>
									<td><?php echo $vendors['vendorName']; ?></td>
									
									<td><?php echo $vendors['vendorAddress1']; ?></td>

									<td><?php echo $vendors['country']; ?></td>
									
									<!-- <td><?php echo $vendors['vendorAddress1'] . ', ' . $vendors['barangayName']   . ', ' . $vendors['municipalityName'] . ', ' . $vendors['provinceName']; ?></td> -->

									<td>
										<?php if($vendors['vendorStatus'] == 1){ ?>
										<span class="label label-success">
										<?php echo $vendors['stats']; ?>
										</span>
										<?php } else { ?>
										<span class="label label-danger">
										<?php echo $vendors['stats']; ?>
										</span>
										<?php }?>
									</td>
									<td>
									<?php if ($vendors['vendor_approval_status'] == 2){ ?>
										<span class="label label-default">
										<?php echo $vendors['approval_stats']; ?>
										</span>
									<?php } else {?>
										<span class="label label-info">
										<?php echo $vendors['approval_stats']; ?>
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
														<li><a onclick=updateVendor(<?php echo $vendors['vendorCode'] ?>) data-toggle="modal" data-target="#modal_form_vertical_update"><i class="icon-pencil4"></i>Update</a></li>
														
															<?php if($vendors['vendorStatus'] == 1){ ?>
																<li>
																	<a onclick=disableVendor(<?php echo $vendors['vendorCode'] ?>)><i class="icon-user-block"></i>Disable</a></li>
																</li>
															<?php } else { ?>
																<li>
																<a onclick=retrieveVendor(<?php echo $vendors['vendorCode'] ?>)><i class="icon-user-check"></i>Retrieve</a></li>
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

	<!-- End of Content area -->

	
	<!-- modal for add vendor -->
	<div id="modal_form_vertical" class="modal fade in" tabindex="-1" data-backdrop="static">
		<div class="modal-dialog" >
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h5 class="modal-title">Add vendor</h5>
				</div>

				<form id="frmAddVendor">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<label>Vendor Name <span style='color:red;'>*</span></label>
									<input type="text" class="form-control" name="vendorName" id="vendorAdd">
								</div>


							</div>
						</div>

						<div class="form-group">
							<div class="row">

								<div class="col-sm-12">
									<label>Address 1 <span style='color:red;'></span></label>
									<input type="text" class="form-control" name="vendorAddress" id="vendorAddress">
								</div>

								<!-- <div class="col-sm-6">
									<label>Address 2 <span style='color:red;'></span></label>
									<input type="text" class="form-control" name="vendorAddress1" id="vendorAddress1">
								</div> -->

							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<label>Province <span style='color:red;'></span></label>
									<!-- <input type="text" class="form-control" name="province" id="vendorProvince"> -->
									<select class="form-control" name="province" id="vendorProvince">
										<option value=''>Select province</option>
										<?php foreach($Province as $Provinces) { ?>
										<option value="<?php echo $Provinces['provinceCode'] ?>"> <?php echo $Provinces['provinceName'] ?> </option>
										<?php } ?>

									</select>
								</div>

								<div class="col-sm-6">
									<label>Municipality <span style='color:red;'></span></label>
									<!-- <input type="text" class="form-control" name="municipality" id="vendorMunicipality"> -->
									<select class="form-control" name="municipality" id="vendorMunicipality">
										<option value=''>Select municipality</option>
									</select>
								</div>



							</div>
						</div>

						<div class="form-group">
							<div class="row">

								<div class="col-sm-6">
									<label>Barangay <span style='color:red;'></span></label>
									<!-- <input type="text" class="form-control" name="baranggay" id="vendorBaranggay"> -->
									<select class="form-control" name="baranggay" id="vendorBaranggay">
										<option value=''>Select barangay</option>
									</select>
								</div>

								<div class="col-sm-6">
									<label>Country <span style='color:red;'></span></label>
									<!-- <input type="text" class="form-control" name="baranggay" id="vendorBaranggay"> -->
									<input type="text" class="form-control" name="country" id="country">
										
									
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
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h5 class="modal-title">Update vendor</h5>
				</div>

				<form id="">
					<div class="modal-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<input type="hidden" class="form-control" name="updatevendorCode" id="updatevendorCode">

									<label>Vendor name <span style='color:red;'>*</span></label>
									<input type="text" class="form-control" name="updatevendorName" id="updatevendorName" disabled>
								</div>

				
								<div class="col-sm-6">
									<label>Address 1 <span style='color:red;'></span></label>
									<input type="text" class="form-control" name="updatevendorAddress" id="updatevendorAddress">
								</div>			
								<!-- <div class="col-sm-6">
									<label>Vendor status <span style='color:red;'>*</span></label>
									<select class="form-control"  name="updatevendorStatus" id="updatevendorStatus">
										<?php foreach($stat as $stats){ ?>
										<option value="<?php echo $stats['status_id'] ?>"><?php echo $stats['stats'] ?></option>
										<?php } ?>
									</select>
								</div> -->
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-6">
									<label>Address 2 <span style='color:red;'></span></label>
									<input type="text" class="form-control" name="updatevendorAddress1" id="updatevendorAddress1">
								</div>

								<div class="col-sm-6">
									<label>Province <span style='color:red;'></span></label>
									<!-- <input type="text" class="form-control" name="updateProvince" id="updateProvince"> -->
									<select class="form-control" name="updateProvince" id="updateProvince">
										<option value=''>Select province</option>

										<?php foreach($Province as $Provinces) { ?>
										<option value="<?php echo $Provinces['provinceCode'] ?>"> <?php echo $Provinces['provinceName'] ?> </option>
										<?php } ?>
									</select>
								</div>

								
							</div>
						</div>

						<div class="form-group">
							<div class="row">

								<div class="col-sm-6">
									<label>Municipality <span style='color:red;'></span></label>
									<!-- <input type="text" class="form-control" name="updatemunicipality" id="updatemunicipality"> -->
									<select class="form-control" name="updatemunicipality" id="updatemunicipality">
										<!-- <option value=''>Select municipality</option> -->
									</select>
								</div>

								<div class="col-sm-6">
									<label>Barangay <span style='color:red;'></span></label>
									<!-- <input type="text" class="form-control" name="updatebaranggay" id="updatebarangay"> -->
									<select class="form-control" name="updatebaranggay" id="updatebaranggay">
										<!-- <option value=''>Select barangay</option> -->

									</select>

								</div>			

							</div>
						</div>


					</div>
				</form>

				<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-success" id="updateVendor">Update</button>
				</div>
			</div>
		</div>
	</div>

<script>

$('.datatable-basic').DataTable();

$('#li6').addClass('active');

$('#vendorMunicipality').prop('disabled', true);
$('#vendorBaranggay').prop('disabled', true);


var delay = 1200;

$('#addVendor').click(function(){

	var frmAddVendor = $('#frmAddVendor').serialize();


	$.ajax({
	url: "<?php echo base_url(). "vendorController/InsertingVendorData"; ?>",
	type: 'POST',
	data: frmAddVendor,
	dataType: 'JSON',
	success: function(res){

		if(res.stat_empty == 0)
		{
			swal({
			title: "Error",
			text: res.stat_message,
			type: "error",
			closeOnClickOutside: false
			});
		}

		else
		{	
			if(res.s == 3)
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
					title: "Success	",
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

function disableVendor(vendorCode)
{
	$.ajax({
	url: "<?php echo base_url(). 'vendorController/AlertDisabledVendor'; ?>",
	type: 'POST',
	data: {vendorID: vendorCode},
	dataType: 'JSON',
	success: function(res)
	 {
		if(res.stat == 0)
		{

					
			swal({
					title: "Are you sure?",
					text: "You want to disable vendor?",
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
						url: "<?php echo base_url(). 'vendorController/DisabledVendor'; ?>",
						data: {vendorID: vendorCode},
						dataType: 'JSON',
						success: function(response)
						{
							if(response.status == 1)
							{

								swal({
								title: "Disabled!",
								text: "Vendor is disabled",
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

function retrieveVendor(vendorCode)
{
	$.ajax({
	url: "<?php echo base_url(). 'vendorController/AlertRetrieveVendor'; ?>",
	type: 'POST',
	data: {vendorID: vendorCode},
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
						url: "<?php echo base_url(). 'vendorController/retrieveVendor'; ?>",
						data: {vendorID: vendorCode},
						dataType: 'JSON',
						success: function(response)
						{
							if(response.status == 1)
							{

								swal({
								title: "Retrieved!",
								text: "Vendor is retrieved",
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

function updateVendor(vendorCode)
{
	var updatevendorCode = 		   $('#updatevendorCode');
	var updatevendorName = 		   $('#updatevendorName');
	var updatevendorStatus = 	   $('#updatevendorStatus');
	var updatevendorAddress = 		$('#updatevendorAddress');
	var updatevendorAddress1 =     $('#updatevendorAddress1');
	var updatevendorAddress2 =     $('#updatebaranggay');
	var updatevendorMunicipality = $('#updatemunicipality');
	var updatevendorProvince = 	   $('#updateProvince');

	$.ajax({
	url: "<?php echo base_url(). 'vendorController/fetchVendor'; ?>",
	type: 'POST',
	data: {vendorID: vendorCode},
	dataType: 'JSON',
	success: function(res){


		
		updatevendorCode.val(res.data.vendorCode);
		updatevendorName.val(res.data.vendorName);
		updatevendorStatus.val(res.data.vendorStatus);
		updatevendorAddress.val(res.data.vendorAddress2);
		updatevendorAddress1.val(res.data.vendorAddress1);
		updatevendorProvince.val(res.data.province);
	

		$.each(res.municipality, function(index, item) {

			var option = document.createElement("option");
			option.text = item.municipalityName;
			option.value = item.municipalityCode;
			updatevendorMunicipality.append(option);
		});


		updatevendorMunicipality.val(res.data.municipality);
	
		$.each(res.baranggay, function(index, item) {

			var option = document.createElement("option");
			option.text = item.barangayName;
			option.value = item.barangayCode;
			updatevendorAddress2.append(option);
		});

		
		updatevendorAddress2.val(res.data.baranggay);
		
		
	}
	});
}

$('#updateVendor').click(function()
{

	var updatevendorCode = 		   $('#updatevendorCode').val();
	var updatevendorName =		   $('#updatevendorName').val();
	// var updatevendorStatus = 	   $('#updatevendorStatus').val();
	var updatevendorAddress = 	   $('#updatevendorAddress').val();
	var updatevendorAddress1 = 	   $('#updatevendorAddress1').val();
	var updatebaranggay = 	   	   $('#updatebaranggay').val();
	var updatemunicipality = 	   $('#updatemunicipality').val();
	var updateprovince = 	       $('#updateProvince').val();

	$.ajax({
	url: "<?php echo base_url(). 'vendorController/updateVendor'; ?>",
	type: 'POST',
	data: {vendorCode: 			updatevendorCode,
		   vendorName:			updatevendorName,
		//    vendorStatus: 		updatevendorStatus,
		   vendorAddress:		updatevendorAddress,
		   vendorAddress1: 		updatevendorAddress1,
		   baranggay: 			updatebaranggay,
		   municipality: 		updatemunicipality,
		   province: 			updateprovince
		},
	dataType: 'JSON',
	success: function(res){

		if(res.stat_empty == 0)
		{
			swal({
			title: "Error",
			text: res.stat_message,
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
				closeOnClickOutside: false
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

$('#btnAddClose').click(function()
{
	$('#vendorAdd').val('');
	$('#vendorAddress1').val('');
	$('#vendorBaranggay').val('');
	$('#vendorProvince').val('');
	$('#vendorMunicipality').val('');

	$('#vendorMunicipality').prop('disabled', true);
	$('#vendorBaranggay').prop('disabled', true);

})

//modalAdd
$('#vendorProvince').change(function(){

	$('#vendorMunicipality').prop('disabled', false);

	var province = $(this).val();

	var municipality = $('#vendorMunicipality'); 
	var barangay = $('#vendorBaranggay'); 

	$.ajax({
		 url: "<?php echo base_url(). 'vendorController/populateMunicipalityToProvince' ?>",
		 type: 'POST',
		 data: {provinces: province},
		 dataType: 'JSON',
		 beforeSend: function(){

			municipality.empty();
			municipality.append('<option value="">Select municipality</option>');

			barangay.empty();
			barangay.append('<option value="">Select barangay</option>');
		 },

		 success: function(res){

			 // Iterate through the data and add options for each municipality
            $.each(res, function(index, item) {
                var option = document.createElement("option");
                option.text = item.municipalityName;
                option.value = item.municipalityCode;
                municipality.append(option);
            });
	
		}
	});

})

//modalAdd
$('#vendorMunicipality').change(function(){

	$('#vendorBaranggay').prop('disabled', false);

	var municipality = $(this).val();

	var barangay = $('#vendorBaranggay'); 

	$.ajax({
		 url: "<?php echo base_url(). 'vendorController/populateBarangayToMunicipality' ?>",
		 type: 'POST',
		 data: {municipalities: municipality},
		 dataType: 'JSON',
		 beforeSend: function(){

			barangay.empty();

			barangay.append('<option value="">Select barangay</option>');
		 },

		 success: function(res){

			 // Iterate through the data and add options for each municipality
            $.each(res, function(index, item) {
                var option = document.createElement("option");
                option.text = item.barangayName;
                option.value = item.barangayCode;
                barangay.append(option);
            });
	
				}
	});
})

//modalUpdate
$('#updateProvince').change(function(){

	var updateprovince = $(this).val();

	var municipality = $('#updatemunicipality'); 
	var barangay = $('#updatebaranggay'); 

	$.ajax({
		url: "<?php echo base_url(). 'vendorController/populateMunicipalityToProvince' ?>",
		type: 'POST',
		data: {provinces: updateprovince},
		dataType: 'JSON',
		beforeSend: function(res){

			municipality.empty();
			municipality.append('<option value="">Select municipality</option>');

			barangay.empty();
			barangay.append('<option value="">Select barangay</option>');
		},

		success: function(res){

			// Iterate through the data and add options for each municipality
			$.each(res, function(index, item) {
				var option = document.createElement("option");
				option.text = item.municipalityName;
				option.value = item.municipalityCode;
				municipality.append(option);
			});

		}
	});

})

$('#updatemunicipality').change(function(){

	var municipality = $(this).val();
	var barangay = $('#updatebaranggay'); 

	$.ajax({
	 url: "<?php echo base_url(). 'vendorController/populateBarangayToMunicipality' ?>",
	 type: 'POST',
	 data: {municipalities: municipality},
	 dataType: 'JSON',
	 beforeSend: function(){

		barangay.empty();

		barangay.append('<option value="">Select barangay</option>');
	 },

	 success: function(res){

		 // Iterate through the data and add options for each municipality
		$.each(res, function(index, item) {
			var option = document.createElement("option");
			option.text = item.barangayName;
			option.value = item.barangayCode;
			barangay.append(option);
		});

	}
	});
})



</script>