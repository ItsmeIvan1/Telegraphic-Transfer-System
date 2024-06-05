<!-- Page header -->
<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4>Bank Information</h4>
		</div>

		<div class="heading-elements">
			<div class="heading-btn-group">
			</div>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="<?php echo base_url();?>mainController/afterLogin"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Bank Information</li>
		</ul>

		<ul class="breadcrumb-elements">
		
		</ul>
	</div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
	<div style="padding-bottom: 10px;">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form_vertical"><i class="icon-briefcase position-left"></i> Add Bank</button>	
		<button type="button" class="btn btn-success" id="btnGenerateBank" ><i class="icon-file-excel"></i> Generate bank details</button>	
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-flat">
				<div class="panel-body">
					<table class="table datatable-basic">
						<thead>
							<tr class="bg-success">

							<th>Bank Name</th>	
							<!-- <th>Bank #</th>				 -->
							<th>Address 1</th>
							<!-- <th>Address 2</th>	 -->
							<th>Status</th>
							<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>

							<?php foreach($bankInfo as $bankInfos){?>	
								<tr>
									<td><?php echo $bankInfos['bankName']; ?></td>
									<!-- <td><?php echo $bankInfos['bank_number']; ?></td> -->
									<td><?php echo $bankInfos['bankAddress2']; ?></td>
									<!-- <td><?php echo $bankInfos['bankAddress1'] . ", ". $bankInfos['barangayName'] . ", ". $bankInfos['municipalityName'] . ", ". $bankInfos['provinceName']; ?></td> -->
									<td>
										<?php if($bankInfos['bankStatus'] == 1){ ?>
										<span class="label label-success"><?php echo $bankInfos['stats']; ?></span>
										<?php } else{ ?>
										<span class="label label-danger"><?php echo $bankInfos['stats']; ?></span>
										<?php } ?>
									</td>
								<td class="text-center">
									<ul class="icons-list">
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<ul class="dropdown-menu dropdown-menu-right">
												<li><a onclick="updateVendor(<?php echo $bankInfos['bankCode'] ?>)" data-toggle="modal" data-target="#modalUpdate"><i class="icon-pencil4"></i>Update</a></li>
												
													<?php if($bankInfos['bankStatus'] == 1){ ?>
														<li>
															<a onclick="disableBank(<?php echo $bankInfos['bankCode'] ?>)"><i class="icon-user-block"></i>Disable</a></li>
														</li>
													<?php } else { ?>
														<li>
														<a onclick="retrievedBank(<?php echo $bankInfos['bankCode'] ?>)"><i class="icon-user-check"></i>Retrieve</a></li>
														</li>
													<?php } ?>
											</ul>
										</li>
									</ul>
								</td>
								</tr>
							<?php }?>	

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>






</div>
<!-- End of Content area -->

<!-- modal for add vendor -->
<div id="modal_form_vertical" class="modal fade" tabindex="-1" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h5 class="modal-title">Add Bank</h5>
			</div>

			<form id="frmAddBank">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<label>Bank Name <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="bankName" id="bankName">
							</div>

							<!-- <div class="col-sm-6">
								<label>Bank # <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="bankNumber" id="bankNumber">
							</div> -->
					
						</div>
					</div>

					<div class="form-group" >
						<div class="row" style="padding-bottom: 10px;">
							<div class="col-sm-12">
								<label>Address <span style='color:red;'></span></label>
								<input type="text" class="form-control" name="bankAddress" id="bankAddress">
							</div>
							<!-- <div class="col-sm-4">
								<label>Address 2 <span style='color:red;'></span></label>
								<input type="text" class="form-control" name="bankAddress1" id="bankAddress1">
							</div> -->

							
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-sm-4">
								<label>Province <span style='color:red;'></span></label>
								<select class="form-control" name="bankProvince" id="bankProvince">
									<option value=''>Select province</option>
									<?php foreach($Province as $Provinces){ ?>
									<option value="<?php echo $Provinces['provinceCode'] ?>"><?php echo $Provinces['provinceName'] ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-4">
								<label>Municipality <span style='color:red;'></span></label>
								<select class="form-control" name="bankMunicipality" id="bankMunicipality">
									<option value=''>Select municipality</option>
								</select>
							</div>

							<div class="col-sm-4">
								<label>Barangay <span style='color:red;'></span></label>
								<select class="form-control" name="bankBarangay" id="bankBarangay">
								<option value=''>Select barangay</option>
									</select>
							</div>
						</div>
					</div>
				</div>
			</form>

			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal" id="btnAddClose">Close</button>
				<button type="button" class="btn btn-success" id="addBank">Add</button>
			</div>

		</div>
	</div>
</div>

<!-- modal for update vendor -->
<div id="modalUpdate" class="modal fade" tabindex="-1" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h5 class="modal-title">Update Bank</h5>
			</div>

			<form id="frmAddBank">
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-6">
								<input type="hidden" name="updatebankCode" id="updatebankCode" />
								<label>Bank Name <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="updatebankName" id="updatebankName" disabled>
							</div>

							<div class="col-sm-6">
								<label>Address 1 <span style='color:red;'></span></label>
								<input type="text" class="form-control" name="updatebankAddress" id="updatebankAddress">
							</div>

							<!-- <div class="col-sm-6">
								<label>Status <span style='color:red;'>*</span></label>
								<input type="text" class="form-control" name="bankStatus">
								<select class="form-control" name="updatebankStatus" id="updatebankStatus">
									<?php foreach($stat as $stats){ ?>
									<option value="<?php echo $stats['status_id'] ?>"><?php echo $stats['stats'] ?></option>
									<?php } ?>
								</select>
							</div> -->
						</div>
					</div>

					<div class="form-group" >
						<div class="row" style="padding-bottom: 10px;">
							<div class="col-sm-6">
								<label>Address 2 <span style='color:red;'></span></label>
								<input type="text" class="form-control" name="updatebankAddress1" id="updatebankAddress1">
							</div>

							<div class="col-sm-6">
								<label>Province <span style='color:red;'></span></label>
								<select class="form-control" name="updatebankProvince" id="updatebankProvince">
									<option value=''>Select province</option>
									<?php foreach($Province as $Provinces){ ?>
									<option value="<?php echo $Provinces['provinceCode'] ?>"><?php echo $Provinces['provinceName'] ?></option>
									<?php } ?>
								</select>
							</div>
	
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-sm-6">
								<label>Municipality <span style='color:red;'></span></label>

								<select class="form-control" name="updatebankMunicipality" id="updatebankMunicipality">

								</select>
								
							</div>

							<div class="col-sm-6">
								<label>Barangay <span style='color:red;'></span></label>

								<select class="form-control" name="updatebankBarangay" id="updatebankBarangay">

								</select>
								
							</div>
						</div>
					</div>
				</div>
			</form>

			<div class="modal-footer">
				<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success" id="updateVendorBtn">Update</button>
			</div>

		</div>
	</div>
</div>

<script>

function blockUILoading()
{
	$.blockUI({ 
            message: '<h5 class="text-semibold">Please wait...</h5>',
            overlayCSS: {
                backgroundColor: '#1b2024',
                opacity: 0.8,
                zIndex: 1200,
                cursor: 'wait'
            },
            css: {
                border: 0,
                color: '#fff',
                padding: 0,
                zIndex: 1201,
                backgroundColor: 'transparent'
            }
    });  
}


$('.datatable-basic').DataTable();


$('#li4').addClass('active');

var delay = 1200;


$('#bankMunicipality').prop('disabled', true);
$('#bankBarangay').prop('disabled', true);

$('#addBank').click(function()
{

	var frmAddBank = $('#frmAddBank').serialize();

	$.ajax({
	url: "<?php echo base_url(). "bankInformationController/InsertingBankInfoData"; ?>",
	type: 'POST',
	data: frmAddBank,
	dataType: 'JSON',
	success: function(res)
	{
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

function disableBank(bankCode)
{
	$.ajax({
	url: "<?php echo base_url(). 'bankInformationController/AlertDisabledBankInfo'; ?>",
	type: 'POST',
	data: {bankID: bankCode},
	dataType: 'JSON',
	success: function(res)
	 {
		if(res.stat == 0)
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
						url: "<?php echo base_url(). 'bankInformationController/DisabledBankInfo'; ?>",
						data: {bankID: bankCode},
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

function retrievedBank(bankCode)
{
	$.ajax({
	url: "<?php echo base_url(). 'bankInformationController/AlertRetrieveBankInfo'; ?>",
	type: 'POST',
	data: {bankID: bankCode},
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
						url: "<?php echo base_url(). 'bankInformationController/retrieveBankInfo'; ?>",
						data: {bankID: bankCode},
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

function updateVendor(bankCode)
{
	var updatebankCode = 		 $('#updatebankCode');
    var updatebankName = 		 $('#updatebankName');
    // var updatebankStatus = 		 $('#updatebankStatus');
	var updatebankAddress = 	 $('#updatebankAddress');
    var updatebankAddress1 = 	 $('#updatebankAddress1');
    var updatebankProvince = 	 $('#updatebankProvince');
    var updatebankMunicipality = $('#updatebankMunicipality');
    var updatebankBarangay = 	 $('#updatebankBarangay');

    $.ajax({
    url: "<?php echo base_url(). 'bankInformationController/fetchBankInformationInModal'; ?>",
    type: 'POST',
    data: {bankID: bankCode},
    dataType: 'JSON',
    success: function(res){

     updatebankCode.val(res.data.bankCode);
     updatebankName.val(res.data.bankName);
    //  updatebankStatus.val(res.data.bankStatus);
	 updatebankAddress.val(res.data.bankAddress2);
     updatebankAddress1.val(res.data.bankAddress1);
     updatebankProvince.val(res.data.bankProvince);

	 	$.each(res.bankMunicipality, function(index, item) {

		var option = document.createElement("option");
		option.text = item.municipalityName;
		option.value = item.municipalityCode;
		updatebankMunicipality.append(option);
		});


		updatebankMunicipality.val(res.data.bankMunicipality);


		$.each(res.bankAddress, function(index, item) {

		var option = document.createElement("option");
		option.text = item.barangayName;
		option.value = item.barangayCode;
		updatebankBarangay.append(option);
		});


		updatebankBarangay.val(res.data.bankAddress);
 
    }
    });

}

$('#updateVendorBtn').click(function()
{
	var updatebankCode = 		 $('#updatebankCode').val();
	var updatebankName = 		 $('#updatebankName').val();
	var updatebankStatus = 		 $('#updatebankStatus').val();
	var updatebankAddress = 	 $('#updatebankAddress').val();
	var updatebankAddress1 = 	 $('#updatebankAddress1').val();
	var updatebankAddress2 = 	 $('#updatebankBarangay').val();
	var updatebankMunicipality = $('#updatebankMunicipality').val();
	var updatebankProvince = 	 $('#updatebankProvince').val();

	$.ajax({
	url: "<?php echo base_url(). 'bankInformationController/updateBank'; ?>",
	type: 'POST',
	data: {bankCode: 		updatebankCode,
		bankName:			updatebankName,
		// bankStatus: 		updatebankStatus,
		bankAddress:		updatebankAddress,
		bankAddress1: 		updatebankAddress1,
		bankAddress2: 		updatebankAddress2,
		bankMunicipality: 	updatebankMunicipality,
		bankProvince: 		updatebankProvince
		},
	dataType: 'JSON',
	success: function(res){

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
 });
})

$('#btnAddClose').click(function(){
	$('#bankName').val('');
	$('#bankAddress1').val('');
	$('#bankAddress').val('');
	$('#bankMunicipality').val('');
	$('#bankProvince').val('');
	$('#bankBarangay').val('');	

	$('#bankMunicipality').prop('disabled', true);
	$('#bankBarangay').prop('disabled', true);
})

//modalAdd
$('#bankProvince').change(function(){

	$('#bankMunicipality').prop('disabled', false);

	var province = $(this).val();

	var municipality = $('#bankMunicipality'); 
	var barangay = $('#bankBarangay'); 

	$.ajax({
		url: "<?php echo base_url(). 'bankInformationController/populateMunicipalityToProvince' ?>",
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
$('#bankMunicipality').change(function(){

	$('#bankBarangay').prop('disabled', false);

	var municipality = $(this).val();

	var barangay = $('#bankBarangay'); 

		$.ajax({
			url: "<?php echo base_url(). 'bankInformationController/populateBarangayToMunicipality' ?>",
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

//modal update
$('#updatebankProvince').change(function(){

	var updateprovince = $(this).val();

	var municipality = $('#updatebankMunicipality'); 
	var barangay = $('#updatebankBarangay'); 

	$.ajax({
		url: "<?php echo base_url(). 'bankInformationController/populateMunicipalityToProvince' ?>",
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

$('#updatebankMunicipality').change(function(){

	var municipality = $(this).val();
	var barangay = $('#updatebankBarangay'); 

	$.ajax({
	url: "<?php echo base_url(). 'bankInformationController/populateBarangayToMunicipality' ?>",
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


$('#btnGenerateBank').click(function () {

    $.ajax({
        url: '<?php echo base_url(). "bankInformationController/generateBankInfoExcel" ?>',
        type: 'POST',
        data: {
        },
        dataType: 'JSON',
		beforeSend: function(){
			
			blockUILoading();
		},

        success: function (response) {

           if (response.success) {

				window.open('<?php echo base_url(). "bankInformationController/downloadExcelFile" ?>');

				swal({
				title: "Success",
				text: "Successfully Generated!",
				type: "success",
				closeOnClickOutside: false
				});

				// Hide UI blocking after a delay
                setTimeout(function() {
                    $.unblockUI();
                }, 1000); // Adjust the delay as needed
            } 
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle AJAX error
            console.error('AJAX Error:', textStatus, errorThrown);
			blockUILoading();
        }
    });
});






</script>