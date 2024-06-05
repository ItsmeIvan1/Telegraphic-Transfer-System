
	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
	
			</div>

			<div class="heading-elements">
				<div class="heading-btn-group">
				</div>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
			<li><a href="<?php echo base_url();?>mainController/afterLogin"><i class="icon-home2 position-left"></i> Home</a></li>
				<li class="active">User Creation / PPCI</li>
			</ul>

			<ul class="breadcrumb-elements">
			
			</ul>
		</div>
	</div>

	<div class="content">
		<div style="padding-bottom: 10px;">
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form_vertical"><i class="icon-user-plus position-left"></i> Add user</button>	
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-flat">
					<div class="panel-body">
						<table class="table datatable-basic">
							<thead>
								<tr class="bg-success">
								<th>Employee No.</th>
								<th>Last name, First name, Middle name</th>
								<!-- <th>First name</th>
								<th>Middle name</th> -->
								<th>Role</th>
								<th>Department</th>
								<th>Date added</th>
								<th>Status</th>
								<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>

								<?php foreach($users as $userss){ ?>	

								<tr>
								<td><?php echo $userss['emp_number'] ?></td>
								<td><?php echo $userss['last_name'] . ', ' . $userss['first_name'] . ', ' . $userss['middle_name'] ?></td>
								<td><?php echo $userss['roleName'] ?></td>
								<td><?php echo $userss['empDepartment']?></td>
								<td><?php echo $userss['dateAdded'] ?></td>
								<td>
									<?php if($userss['empStat'] == 1){ ?>
										<span class="label label-success">
										<?php echo $userss['stats'] ?>
										</span>
										<?php  } else { ?>
										<span class="label label-danger">
										<?php echo $userss['stats'] ?>
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
													<li><a onclick=fetchUser(<?php echo $userss['emp_id'] ?>) data-toggle="modal" data-target="#modalUpdate"><i class="icon-pencil4"></i>Update</a></li>
													
													<?php if($userss['empStat'] == 1) { ?>
															<li>
																<a onclick=disableUser(<?php echo $userss['emp_id'] ?>)><i class="icon-user-block"></i>Disable</a></li>
															</li>
														<?php } else { ?>
															<li>
																<a onclick=retrieveUser(<?php echo $userss['emp_id'] ?>)><i class="icon-user-check"></i>Retrieve</a></li>
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

	<div id="modal_default" class="modal fade in" tabindex="-1" >
						<div class="modal-dialog modal-xs">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">×</button>
									<h5 class="modal-title">Company</h5>
								</div>

								<div class="modal-body">
									
										<div id="parentbtn">
											<div>
												<a type="button" id="createAccPPCI" class="btn btn-success btn-float btn-float-lg" data-toggle="modal" data-target="#modal_form_vertical"><i class="icon-office"></i> <span>PPCI</span></a>
											</div>

											<div>
												<button type="button" id="createAccSR" class="btn btn-primary btn-float btn-float-lg" data-toggle="modal" data-target="#modal_default_loginSR"><i class="icon-home7"></i> <span>S&R</span></button>
											</div>
										</div>
									
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
									<!-- <button type="button" class="btn btn-primary">Save</button> -->
								</div>
							</div>
						</div>
			 		</div>

	</div>

	<!-- modal for add user -->
	<div id="modal_form_vertical" class="modal fade in" tabindex="-1" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h5 class="modal-title">Add user</h5>
				</div>

				<form id="frmAddUsers">
					<div class="modal-body">
						<div class="form-group" style="padding-left: 10px; padding-right: 10px;">
							<div class="row">
							<div class="input-group">
								<input type="text" class="form-control" name="empNumber" id="empNumber" placeholder="Search Employee No.">
								<span class="input-group-btn">
									<button class="btn bg-blue" id="btnSearch" type="button"><i class="icon-search4"></i></button>
								</span>
							</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-4">
									<input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last name" readonly>
								</div>

								<div class="col-sm-4">
									<input type="text" class="form-control" name="firstname" id="firstname" placeholder="First name" readonly>
								</div>

								<div class="col-sm-4">
									<input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle name" readonly>
								</div>
							</div>
						</div>


						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<input type="text" class="form-control" name="department" id="department" placeholder="Department" readonly>
								</div>
							</div>
						</div>
					

					<div class="form-group">
						<div class="row">
						<div class="col-sm-12">
							<label>Roles</label>
							<select class="select" name="selectModules" id="selectModules">
							<option value="">Select a Roles...</option>
							<optgroup label="Roles">
							<?php foreach($testmodule as $testmodules){ ?>
								<option value="<?php echo $testmodules['roles'] ?>"><?php echo $testmodules['roleName'] ?></option>
								<?php } ?>
							</optgroup>
						
						</select>
						</div>
						</div>
					</div>



					</div>
				</form>

				<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal" id="btnCloseAddModal">Close</button>
						<button type="button" class="btn btn-success" id="addUser">Add user</button>
				</div>

			</div>
		</div>
	</div>

	<!-- Modal for update -->
	<div id="modalUpdate" class="modal fade in" tabindex="-1" data-backdrop="static">
		<div class="modal-dialog ">
			<div class="modal-content">
				<div class="modal-header bg-primary">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h5 class="modal-title">Update user</h5>
				</div>

				<form id="">
					<div class="modal-body">

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<input type="hidden" class="form-control" name="updateEmpId" id="updateEmpId" disabled>
									<label>Employee No.<span style='color:red;'>*</span></label>
									<input type="text" class="form-control" name="updateEmpNo" id="updateEmpNo" disabled>
								</div>
								
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-4">
									<label>Last name <span style='color:red;'>*</span></label>
									<input type="text" class="form-control" name="updateLastName" id="updateLastName" disabled>
								</div>

								<div class="col-sm-4">
									<label>First name <span style='color:red;'>*</span></label>
									<input type="text" class="form-control" name="updateFirstName" id="updateFirstName" disabled>
								</div>

								<div class="col-sm-4">
									<label>Middle name <span style='color:red;'>*</span></label>
									<input type="text" class="form-control" name="middleName" id="middleName" disabled>
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
								<label>Department<span style='color:red;'>*</span></label>
									<input type="text" class="form-control" name="updatedepartment" id="updatedepartment" placeholder="Department" disabled>
								</div>
							</div>
						</div>		

						<div class="form-group">
							<label>Roles</label>
							<select class="form-control" name="selectModulesupdate" id="selectModulesupdate">
								<option value="">Select a Role...</option>
								<?php foreach($testmodule as $testmodules){ ?>	
								<option value="<?php echo $testmodules['roles'] ?>"><?php echo $testmodules['roleName'] ?></option>	
								<?php } ?>
							</select>
						</div>

					</div>
				</form>

				<div class="modal-footer">
						<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-success" id="updateVendor">Update user</button>
				</div>

			</div>
		</div>
	</div>

	<!-- Modal for create account for S&R -->
	<div id="modal_default_loginSR" class="modal fade in" data-backdrop="static" tabindex="-1" >
				<div class="modal-dialog ">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Create Account</h5>
						</div>

						<div class="modal-body">
							<div class="form-group">
								<label >Firstname<span style="color: red;">*</span></label>
								<input type="text" class="form-control" name="srFirstName" id="srFirstName">
								<span style="color: red;" id="errormssg"></span>
							</div>

							<div class="form-group">
								<label >Lastname<span style="color: red;">*</span></label>
								<input type="text" class="form-control" name="srLastName" id="srLastName">
								<span style="color: red;" id="errormssg11"></span>
							</div>

							<div class="form-group">
								<label >Username<span style="color: red;">*</span></label>
								<input type="text" class="form-control" name="srUsername" id="srUsername">
								<span style="color: red;" id="errormsg11"></span>
							</div>

							<div class="form-group">
								<label >Password<span style="color: red;">*</span></label>
								<input type="password" class="form-control" name="srPassword" id="srPassword">
								<span style="color: red;" id="errormsg1"></span>
							</div>

							<!-- <div class="form-group">
								<label >Re type Password<span style="color: red;">*</span></label>
								<input type="password" class="form-control" name="srRetypePassword" id="srRetypePassword"> 

								<span style="color: red;" id="errormsg"></span>
							</div>

							<div class="form-group">
								<label >Security question<span style="color: red;">*</span></label>
								<select name="" id="srSecurityQues" class="form-control">
									<?php foreach($data as $datas){?>
									<option value="<?php echo $datas['id'] ?>"><?php echo $datas['security_question'] ?></option>
								<?php }?>
								</select>
							</div>

							<div class="form-group">
								<label >Your Answer<span style="color: red;">*</span></label>
								<input type="text" class="form-control" name="srAnswer" id="srAnswer"> 
							</div> -->

							<div class="form-group">
								<label >User Access<span style="color: red;">*</span></label>

								<select name="srUserAccess" id="srUserAccess" class="form-control">
									<option value="">Select a Roles...</option>
									<optgroup label="Roles">
									<?php foreach($testmodule as $testmodules){ ?>
										<option value="<?php echo $testmodules['roles'] ?>"><?php echo $testmodules['roleName'] ?></option>
										<?php } ?>
									</optgroup>
								</select>
							</div> 

							

						<div class="modal-footer">
							<button type="button" class="btn btn-link" data-dismiss="modal" id="modalCreateSR">Close</button>	
							<button type="button" class="btn btn-primary" id="createAccBtnSR">Create Account</button>
						</div>
					</div>
				</div>
			</div>

	</div>

	<!-- Modal for create account for S&R -->
	<div id="modalSRUpdate" class="modal fade in" data-backdrop="static" tabindex="-1" >
				<div class="modal-dialog ">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Update Account</h5>
						</div>

						<div class="modal-body">
							<div class="form-group">
								<label >Firstname<span style="color: red;">*</span></label>
								<input type="text" class="form-control" name="srFirstNameUpdate" id="srFirstNameUpdate" disabled>
							</div>

							<div class="form-group">
								<label >Lastname<span style="color: red;">*</span></label>
								<input type="text" class="form-control" name="srLastNameUpdate" id="srLastNameUpdate" disabled>
							</div>

							<div class="form-group">
								<label >Username<span style="color: red;">*</span></label>
								<input type="text" class="form-control" name="srUsernameUpdate" id="srUsernameUpdate" disabled>
							</div>


							<div class="form-group">
								<label >User Access<span style="color: red;">*</span></label>

								<select name="srUserAccess" id="srUserAccessUpdate" class="form-control">
									<option value="">Select a Roles...</option>
									<optgroup label="Roles">
									<?php foreach($testmodule as $testmodules){ ?>
										<option value="<?php echo $testmodules['roles'] ?>"><?php echo $testmodules['roleName'] ?></option>
										<?php } ?>
									</optgroup>
								</select>
							</div> 

							

						<div class="modal-footer">
							<button type="button" class="btn btn-link" data-dismiss="modal" >Close</button>	
							<button type="button" class="btn btn-primary" id="updateSRemp">Update</button>
						</div>
					</div>
				</div>
			</div>

	</div>


<style>

#parentbtn{
	display: flex;
  	justify-content: center;

	
}

#parentbtn > div{
	margin: 10px;

}

.btn-float-lg{
	width: 85px;
}


</style>



<script>

$('#li15').addClass('active');

$('.datatable-basic').DataTable();

// Disable the select element by default
$('#selectModules').prop('disabled', true);

$('#addUser').prop('disabled', true);

var delay = 1200;

function blockUILoading()
{
	$.blockUI({ 
            message: '<h5 class="text-semibold">Please wait...</h5>',
            timeout: 2000, //unblock after 2 seconds
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

$('.select').select2({
        minimumResultsForSearch: Infinity
});

$('#btnSearch').click(function(){

	var emp = 		 $('#empNumber').val();
	var lastname = 	 $('#lastname');
	var firstname =  $('#firstname');
	var middlename = $('#middlename');
	var department = $('#department');

	$.ajax({
		 url: "<?php echo base_url(). 'userCreationController/checkEmpNameInSSO' ?>",
		 type: 'POST',
		 data: {employeeNumber: emp},
		 dataType: 'JSON',
		 success: function(resp){

			if(resp.stat == 1)
			{
				swal({
				title: "Error",
				text: resp.mes,
				type: "error",
				closeOnClickOutside: false
				});

				lastname.val('');
				firstname.val('');
				middlename.val('');
				department.val('');

				$('#selectModules').prop('disabled', true);
			}

			else
			{
				if(resp)
				{
					if(resp.empLastName)
					{
						blockUILoading();

						lastname.val(resp.empLastName);
						firstname.val(resp.empFirstname);
						middlename.val(resp.empMidName);
						department.val(resp.deptDesc);

						$('#selectModules').prop('disabled', false);
						$('#addUser').prop('disabled', false);
					}
					else
					{	
						lastname.val('');
						firstname.val('');
						middlename.val('');
						department.val('');

						swal({
						title: "Error",
						text: resp.message,
						type: "error",
						closeOnClickOutside: false
						});

						$('#selectModules').prop('disabled', true);
					}
				}
			}
		  }
	});	
})

$('#addUser').click(function(){

	var frmAddUsers = $('#frmAddUsers').serialize();

	$.ajax({
	url: '<?php echo base_url(). "userCreationController/insertUserPG" ?>',
	type: 'POST',
	data: frmAddUsers,
	dataType: 'JSON',
	success: function(resp){

	if(resp.stats == 0)
	{
		swal({
			title: "Error",
			text: resp.mess,
			type: "error",
			closeOnClickOutside: false
			});
	}

	else
	{
		if(resp.s == 3)
		{
			swal({
			title: "Error",
			text: resp.m,
			type: "error",
			closeOnClickOutside: false
			});
		}

		else
		{	
			if(resp.status == 1)
			{
				swal({
				title: "Success",
				text: resp.message,
				type: "success",
				});

				setTimeout(function(){ window.location.reload(); }, delay);
			}

			else
			{
				swal({
				title: "Error",
				text: resp.status,
				type: "error",
				closeOnClickOutside: false
				});
			}
		}
	
	}

	}
  });
})

function fetchUser(emp_id){

	var updateEmpId 		= $('#updateEmpId');
	var updateEmpNo 		= $('#updateEmpNo');
	var updateLastName 		= $('#updateLastName');
	var updateFirstName 	= $('#updateFirstName');
	var middleName 			= $('#middleName');
	var department 			= $('#updatedepartment');
	var selectModulesupdate = $('#selectModulesupdate');

	$.ajax({
	url: '<?php echo base_url(). "userCreationController/fetchUsersInModalController" ?>',
	type: 'POST',
	data: {id: emp_id},
	dataType: 'JSON',
	success: function(data){

	updateEmpId.val(data.emp_id);
	updateEmpNo.val(data.emp_number);
	updateLastName.val(data.last_name);
	updateFirstName.val(data.first_name);
	middleName.val(data.middle_name);
	department.val(data.empDepartment);
	selectModulesupdate.val(data.roleMenu);
	}
	});
}

function fetchSRemp(SR_id)
{
	var srFirstNameUpdate = $('#srFirstNameUpdate');
	var srLastNameUpdate = $('#srLastNameUpdate');
	var srUsernameUpdate = $('#srUsernameUpdate');
	var srUserAccessUpdate = $('#srUserAccessUpdate');

	$.ajax({
	url: '<?php echo base_url(). "userCreationController/fetchEmpUserToTable" ?>',
	type: 'POST',
	data: {
		empSR_id: SR_id
	},
	dataType: 'JSON',
	success: function(resp){



		srFirstNameUpdate.val(resp.firstName);
		srLastNameUpdate.val(resp.lastName);
		srUsernameUpdate.val(resp.username);
		srUserAccessUpdate.val(resp.status);	
	
	}

	
  });


}

$('#updateSRemp').click(function(){

	var srUsernameUpdate = $('#srUsernameUpdate').val();
	var srUserAccessUpdate = $('#srUserAccessUpdate').val();

	$.ajax({
	url: '<?php echo base_url(). "userCreationController/updateSRInTBL" ?>',
	type: 'POST',
	data: {
		user: srUsernameUpdate,
		modules: srUserAccessUpdate
	},
	dataType: 'JSON',
	success: function(resp){

		if(resp.status == 1)
		{
			swal({
			title: "Error",
			text: resp.message,
			type: "error",
			closeOnClickOutside: false
			});	

			
		}

		else
		{
			if(resp.status == 1.5)
			{
				swal({
				title: "Success",
				text: resp.message,
				type: "success",
				closeOnClickOutside: false
				});	

				$('#modalSRUpdate').modal('hide');

				setTimeout(function(){ window.location.reload(); }, delay);
			}

			else
			{
				swal({
				title: "Error",
				text: resp.message,
				type: "error",
				closeOnClickOutside: false
				});	
			}
		}
	
	}

	
  });

	
});

$('#updateVendor').click(function(){
	
	var updateEmpId = $('#updateEmpId').val();
	var selectModulesupdate = $('#selectModulesupdate').val();

	$.ajax({
	url: '<?php echo base_url(). "userCreationController/updateUsersInModalController" ?>',
	type: 'POST',
	data: {
	emp_id: updateEmpId,
	roleMenu: selectModulesupdate
	},
	dataType: 'JSON',
	success: function(data){
	
	if(data.stat == 0)
	{
	swal({
	title: "Error",
	text: data.mess,
	type: "error",
	closeOnClickOutside: false
	});	
	}

	else
	{
	if(data.status == 1)
	{
		swal({
				title: "Success",
				text: data.message,
				type: "success",
			});

		setTimeout(function(){ window.location.reload(); }, delay);
	}

	else
	{
		swal({
		title: "Error",
		text: data.message,
		type: "error",
		closeOnClickOutside: false
		});
	}
	}

	}
	});

})

function disableUser(emp_id)
{
	$.ajax({
	url: "<?php echo base_url(). 'userCreationController/alertDisableUser'; ?>",
	type: 'POST',
	data: {userID: emp_id},
	dataType: 'JSON',
	success: function(res)
	 {
		if(res.stat == 0)
		{

			swal({
					title: "Are you sure?",
					text: "You want to disable user?",
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
						url: "<?php echo base_url(). 'userCreationController/disabledUserController'; ?>",
						data: {userID: emp_id},
						dataType: 'JSON',
						success: function(response)
						{
							if(response.status == 1)
							{

								swal({
								title: "Disabled!",
								text: "User is disabled",
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

function retrieveUser(emp_id)
{
	$.ajax({
	url: "<?php echo base_url(). 'userCreationController/alertRetrievedUser'; ?>",
	type: 'POST',
	data: {userID: emp_id},
	dataType: 'JSON',
	success: function(res)
	 {
	
		if(res.stat == 0)
		{

			swal({
					title: "Are you sure?",
					text: 'You want to retrieve user?',
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
						url: "<?php echo base_url(). 'userCreationController/retrievedUser'; ?>",
						data: {userID: emp_id},
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

$('#btnCloseAddModal').click(function(){
	$('#empNumber').val('');
	$('#lastname').val('');
	$('#firstname').val('');
	$('#middlename').val('');
	$('#department').val('');
	$('#selectModules').prop('disabled', true);

})


$('#createAccBtnSR').prop('disabled', true);


$('#createAccBtnSR').click(function(){

	var FirstName = $('#srFirstName').val();
	var LastName = $('#srLastName').val();
	var username = $('#srUsername').val();
	var password = $('#srPassword').val();
	var modules = $('#srUserAccess').val();

	$.ajax({
	url: "<?php echo base_url()."userCreationController/createAccSR";?>",
	type: 'POST',
	data: {
		firstname: FirstName,
		lastName: LastName,
		user: username,
		pass: password,
		access: modules

	},
	dataType:'JSON' ,
	success: function(res){


		if(res.status == 0.1)
		{
			swal({
				title: "error",
				text: res.message,
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

				$('#modal_default_loginSR').modal('hide');
				$('#modal_default').modal('hide');

				$('#srFirstName, #srLastName, #srUsername, #srPassword ').val('');
				
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

$('#srUsername').keyup(function(){
	
	var username = $(this).val();

	var pattern = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;

	$.ajax({
        url: "<?php echo base_url()."userCreationController/checkUsernameFirst";?>",
        type: 'POST',
		data: {
			user: username,
		},
        dataType: 'JSON',
        success: function(res){


			if(username == '')
			{
				$('#errormsg11').empty();
				$('#createAccBtnSR').prop('disabled', true);
			}

			else if(username.length <= 5)
			{
				$('#errormsg11').empty();
				$('#errormsg11').append('Your username must be 6 characters.');
				$('#createAccBtnSR').prop('disabled', true);
			}

			else if(!pattern.test(username))
			{
				$('#errormsg11').empty();
				$('#errormsg11').append('Your username must contain both letters and numbers.');
				$('#createAccBtnSR').prop('disabled', true);
			}


			else if(res.status == 1)
			{
				$('#errormsg11').empty();
				$('#errormsg11').append(res.message);
				$('#createAccBtnSR').prop('disabled', true);
			}

			else
			{
				$('#errormsg11').empty();
				$('#createAccBtnSR').prop('disabled', false);
			}
    
        }
    });


})

$('#srPassword').keyup(function(){

	var pass = $(this).val();
	var pattern = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;

	if(pass == '')
	{
		$('#errormsg1').empty();
		$('#createAccBtnSR').prop('disabled', true);
	}

	else if(pass.length <= 5)
	{
		$('#errormsg1').empty();
		$('#errormsg1').append('Your password must be 6 characters.');
		$('#createAccBtnSR').prop('disabled', true);
	}

	else if(!pattern.test(pass))
	{
		$('#errormsg1').empty();
		$('#errormsg1').append('Your password must contain numbers and letters.');
		$('#createAccBtnSR').prop('disabled', true);
	}

	else
	{
		$('#errormsg1').empty();
		$('#createAccBtnSR').prop('disabled', false);
	}
})

function disabledSRempUser(username)
{
	$.ajax({
	url: "<?php echo base_url(). 'userCreationController/alertDisabledSRUser'; ?>",
	type: 'POST',
	data: {alert: username},
	dataType: 'JSON',
	success: function(res)
	 {
		if(res.status == 0.1)
		{

			swal({
					title: "Are you sure?",
					text: "You want to disable user?",
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
						url: "<?php echo base_url(). 'userCreationController/disabledSRUser'; ?>",
						data: {d: username},
						dataType: 'JSON',
						success: function(response)
						{
							if(response.status == 1)
							{

								swal({
								title: "Disabled!",
								text: "User is disabled",
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

function retrievedSRempUser(username)
{
		$.ajax({
		url: "<?php echo base_url(). 'userCreationController/alertRetrievedSRUser'; ?>",
		type: 'POST',
		data: {alert: username},
		dataType: 'JSON',
		success: function(res)
		{
			if(res.status == 0.1)
			{

				swal({
						title: "Are you sure?",
						text: "You want to retrieved user?",
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
							url: "<?php echo base_url(). 'userCreationController/retrievedSRUser'; ?>",
							data: {d: username},
							dataType: 'JSON',
							success: function(response)
							{
								if(response.status == 1)
								{

									swal({
									title: "Retrieved!",
									text: "User is retrieved",
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



</script>