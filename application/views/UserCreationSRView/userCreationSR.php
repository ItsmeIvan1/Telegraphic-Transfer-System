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
				<li class="active">User Creation / S&R</li>
			</ul>

			<ul class="breadcrumb-elements">
			
			</ul>
		</div>
	</div>

    <div class="content">
        <div style="padding-bottom: 10px;">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_default_loginSR"><i class="icon-user-plus position-left"></i> Add user</button>	
        </div>

        <div class="row">
			<div class="col-md-12">
				<div class="panel panel-flat">
					<div class="panel-body">
						<table class="table datatable-basic">
							<thead>
								<tr class="bg-success">
								<th>First Name</th>
								<th>Last Name</th>
								<th>Username</th>
								<th>Role</th>
								<th>Date added</th>
								<th>User created</th>
								<th>Status</th>
								<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>

								<?php foreach($SRempUser as $SRempUsers){ ?>	

								<tr>
								<td><?php echo $SRempUsers['firstName'] ?></td>
								<td><?php echo $SRempUsers['lastName'] ?></td>
								<td><?php echo $SRempUsers['username'] ?></td>
								<td><?php echo $SRempUsers['roleName']?></td>
								<td><?php echo $SRempUsers['datecreated'] ?></td>
								<td><?php echo $SRempUsers['userCreated'] ?></td>
								<td>
									<?php if($SRempUsers['status'] == 1){ ?>
										<span class="label label-success">
										<?php echo $SRempUsers['stats'] ?>
										</span>
										<?php  } else { ?>
										<span class="label label-danger">
										<?php echo $SRempUsers['stats'] ?>
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
													<li><a onclick=fetchSRemp(<?php echo $SRempUsers['id'] ?>) data-toggle="modal" data-target="#modalSRUpdate"><i class="icon-pencil4"></i>Update</a></li>
													
													<?php if($SRempUsers['status'] == 1) { ?>
															<li>
																<a onclick=disabledSRempUser(<?php echo $SRempUsers['id'] ?>)><i class="icon-user-block"></i>Disable</a></li>
															</li>
														<?php } else { ?>
															<li>
																<a onclick=retrievedSRempUser(<?php echo $SRempUsers['id'] ?>)><i class="icon-user-check"></i>Retrieve</a></li>
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

<script>

var delay = 1200;

$('#li28').addClass('active');

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
		srUserAccessUpdate.val(resp.roleMenu);	
	
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