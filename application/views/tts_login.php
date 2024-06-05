
<body class="login-container">

	<!-- Page container -->
	<div class="page-container ">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
							<!-- Content area -->
			<div class="content" >
				<!-- Simple login form -->
				<form id="formCreate" >
					<div class="panel panel-body login-form" >
						<div class="text-center">
							<img src="<?php echo base_url();?>assets/images/pg_logo.png" class="" alt="" style="width: 10rem;">
							<h5 class="content-group">Telegraphic Transfer System <small class="display-block">Enter your credentials below</small></h5>
						</div>

						<div id="ppciInputs">
							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control"  name="empName" id="empName" placeholder="Employee No.">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" class="form-control" name="password" id="password" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>
						</div>

						<div id="srInputs" style="display: none;">
							<div class="form-group has-feedback has-feedback-left">
								<input type="text" class="form-control"  name="empNameSR" id="empNameSR" placeholder="Username">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" class="form-control" name="passwordSR" id="passwordSR" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>
						</div>


						<div class="form-group">
							<select name="selectComp" id="selectComp" class="form-control">
								<option value="PPCI">PPCI</option>
								<option value="S&R">S&R</option>
							</select>	
						</div>

						<div class="form-group" id="btnPPCILogin">
							<button type="button" class="btn btn-success btn-block" onclick="Login()">Sign in <i class="icon-circle-right2 position-right"></i></button>
						</div>

						<div class="form-group" id="btnSRLogin" style="display: none;">
							<button type="button"  class="btn btn-success btn-block" onclick="LoginSR()">Sign in <i class="icon-circle-right2 position-right"></i></button>
						</div>

						<div class="text-center" id="footerbtn">
							<!-- <div>
								<a href="#" id="" data-toggle="modal" data-target="#modal_default">Create Account</a>
							</div> -->

							<!-- <div>
								<a href="#" id="forgotPass"  data-toggle="modal" data-target="#modal_default1">Forgot password?</a>
							</div> -->
						
						

							
						</div>
					</div>
				</form>

				<!-- <button type="button" class="btn btn-default btn-sm" >Launch <i class="icon-play3 position-right"></i></button> -->

				


	

								
							
				<!-- /simple login form -->

			
				<!-- Footer -->
				<!-- <div class="footer text-muted text-center">
					&copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
				</div> -->
				<!-- /footer -->

			</div>
			<!-- /content area -->
			<!-- /main content -->

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
												<a type="button" id="createAccPPCI" class="btn btn-success btn-float btn-float-lg"><i class="icon-office"></i> <span>PPCI</span></a>
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

			<div id="modal_default1" class="modal fade in" tabindex="-1" >
						<div class="modal-dialog modal-xs">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">×</button>
									<h5 class="modal-title">Company</h5>
								</div>

								<div class="modal-body">
									
										<div id="parentbtn">
											<div>
												<a type="button" id="createAccPPCIs" class="btn btn-success btn-float btn-float-lg"><i class="icon-office"></i> <span>PPCI</span></a>
											</div>

											<div>
												<button type="button" id="createAccSR" class="btn btn-primary btn-float btn-float-lg" data-toggle="modal" data-target="#modal_default_changePassSR"><i class="icon-home7"></i> <span>S&R</span></button>
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

			<!-- Modal for create account for S&R -->
			<div id="modal_default_loginSR" class="modal fade in" tabindex="-1" >
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Create Account</h5>
								</div>

								<div class="modal-body">
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

									<div class="form-group">
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
									</div>

									

								<div class="modal-footer">
									<button type="button" class="btn btn-link" data-dismiss="modal" id="modalCreateSR">Close</button>	
									<button type="button" class="btn btn-primary" id="createAccBtnSR">Create Account</button>
								</div>
							</div>
						</div>
			 		</div>

		    </div>


			<!-- Modal for change pass for S&R -->
			<div id="modal_default_changePassSR" class="modal fade in" tabindex="-1" >
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Change password</h5>
						</div>

						<div class="modal-body">
							<div class="form-group">
								<label >Username<span style="color: red;">*</span></label>
								<input type="text" class="form-control" name="changeUsername" id="changeUsername">
								
							</div>

							<div class="form-group">
								<label >New Password<span style="color: red;">*</span></label>
								<input type="password" class="form-control" name="changeNewPass" id="changeNewPass">
								<span style="color: red;" id="newPassSpan"></span>
							</div>

							<div class="form-group">
								<label >Re type New Password<span style="color: red;">*</span></label>
								<input type="password" class="form-control" name="retypeChangePass" id="retypeChangePass"> 
								<span style="color: red;" id="retypenewPassSpan"></span>
							</div>

							<div class="form-group">
								<label >Security question<span style="color: red;">*</span></label>
								<select name="" id="ChangeSecurityQues" class="form-control">
									<?php foreach($data as $datas){?>
									<option value="<?php echo $datas['id'] ?>"><?php echo $datas['security_question'] ?></option>
								<?php }?>
								</select>
							</div>

							<div class="form-group">
								<label >Your Answer<span style="color: red;">*</span></label>
								<input type="text" class="form-control" name="changeSecurityAns" id="changeSecurityAns"> 
							</div>

							

						<div class="modal-footer">
							<button type="button" class="btn btn-link" data-dismiss="modal" id="modalCreateSR">Close</button>	
							<button type="button" class="btn btn-primary" id="btnChangePass">Change password</button>
						</div>
					</div>
				</div>
			</div>

		    </div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>

<style>

#parentbtn{
	display: flex;
  	justify-content: center;

	
}

#parentbtn > div{
	margin: 10px;

}

#footerbtn{
	display: flex;
  	justify-content: center;
}

#footerbtn > div{
	margin-left: 10px;
}
.btn-float-lg{
	width: 85px;
}

.content{
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);

}
	
.panel{
	box-shadow: 0 20px 20px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	text-align: center;
}

.login-container {
	background-image: url("<?php echo base_url();?>/assets/images/bg_home_6.jpg");
	background-size: cover;
	background-position: center; 
	background-repeat: no-repeat;

}

.login-container::before {
	content: "";
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(0, 0, 0, 0.5); /* Adjust the alpha value to control darkness */
}

	/* assets/images/pg_logo.png */

</style>

<script>

$('#selectComp').change(function()
{

	// alert( this.value );

	if(this.value === 'S&R')
	{
		$('#btnPPCILogin').hide();
		$('#btnSRLogin').show();

		
		$('#ppciInputs').hide();
		$('#srInputs').show();

	}

	else
	{
		$('#btnPPCILogin').show();
		$('#btnSRLogin').hide();

		$('#ppciInputs').show();
		$('#srInputs').hide();
		

		
	}
	
	
})

// $('#createAccSR').click(function(){

// 	$('#modal_default').hide();

// })



function blockUILoading()
{
	$.blockUI({ 
            message: '<h5 class="text-semibold">Please wait...</h5>',
            timeout: 10000, //unblock after 5 seconds
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

function Login()
{
	var user = $('#empName').val();
	var pass = $('#password').val();

	$.ajax({
	url: "<?php echo base_url()."/SSOController/SSOlogin";?>",
	type: 'POST',
	data: {
		username: user,
		password: pass
	},
	dataType:'JSON' ,
	success: function(res){
	
		if(res.status == 2) 
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
			if(res.loggedStatus == 1)
			{
				blockUILoading();

				window.location.href = "<?php echo base_url(). 'mainController/afterlogin' ?>";
			}

			else{

				swal({
				title: "Error",
				text: res.loggedErrorMsg,
				type: "error",
				closeOnClickOutside: false
				});
			}
		}
		}
	});
}

function LoginSR()
{
	var user = $('#empNameSR').val();
	var pass = $('#passwordSR').val();

	$.ajax({
	url: "<?php echo base_url()."/SSOController/loginSR";?>",
	type: 'POST',
	data: {
		username: user,
		password: pass
	},
	dataType:'JSON' ,
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

			if(res.status == 2)
			{
				blockUILoading();

					window.location.href = "<?php echo base_url(). 'mainController/afterLoginSR' ?>";	
			
			}

			else{

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
}

$('#createAccPPCI').click(function(){
	
	window.open('http://myportal.puregold.local/index.php/login');
})

$('#createAccPPCIs').click(function(){
	
	window.open('http://myportal.puregold.local/index.php/login');
})

/* Block current page on button click */

$('#createAccBtnSR').prop('disabled', true);

$('#srRetypePassword').keyup(function(){

	var user = $('#srUsername').val();
	var pass = $('#srPassword').val();
	var newpass = $('#srRetypePassword').val();
	var SecurityQues = $('#srSecurityQues').val();
	var Answer = $('#srAnswer').val();


	if(newpass == '')
	{
		$('#errormsg').empty();
		$('#createAccBtnSR').prop('disabled', true);
	}

	else if($(this).val() !== pass)
	{	
		$('#errormsg').empty();
		$('#errormsg').append('Password not matched!');
		$('#createAccBtnSR').prop('disabled', true);
	}

	else if($(this).val() == pass)
	{	
		$('#errormsg').empty();
		$('#createAccBtnSR').prop('disabled', false);
	}

	

})

$('#srPassword').keyup(function(){

	var pass = $(this).val();


	if(pass == '')
	{
		$('#errormsg1').empty();
	}

	else if(pass.length <= 5)
	{	
		$('#errormsg1').empty();
		$('#errormsg1').append('Your password is too short!');
	}

	else
	{
		$('#errormsg1').empty();
	}


})



$('#srUsername').keyup(function(){

	var user = $(this).val();
	var pattern = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;

	$.ajax({
	url: "<?php echo base_url()."/SSOController/checkUserExistInDB";?>",
	type: 'POST',
	data: {
		username: user,
	},
	dataType:'JSON' ,
	success: function(res){

			//if username is empty
			if(user == '')
			{
				$('#errormsg11').empty();
				$('#createAccBtnSR').prop('disabled', true);
			}

			// if username length is less than or equal to 5 
			else if(user.length <= 5)
			{
				$('#errormsg11').empty();
				$('#errormsg11').append('Your username is too short!');
				$('#createAccBtnSR').prop('disabled', true);
			}
			
			//if username is not contain letters and numbers
			else if(!pattern.test(user))
			{
				$('#errormsg11').empty();
				$('#errormsg11').append('Username must contain both letters and numbers.');
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


$('#createAccBtnSR').click(function(){

	var username = $('#srUsername').val();
	var password = $('#srPassword').val();
	var rePassword = $('#srRetypePassword').val();
	var SecurityQues = $('#srSecurityQues').val();
	var Answer = $('#srAnswer').val();

	$.ajax({
	url: "<?php echo base_url()."/SSOController/createAccSR";?>",
	type: 'POST',
	data: {
		user: username,
		pass: password,
		reTypePassword: rePassword,
		securityQues: SecurityQues,
		securityAnswer: Answer
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

				$('#srUsername, #srPassword, #srRetypePassword, #srAnswer').val('');
				
				$('#errormsg').empty();
				
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

$('#btnChangePass').click(function(){

	var changeUsername = $('#changeUsername').val();
	var changeNewPass = $('#changeNewPass').val();
	var retypeChangePass = $('#retypeChangePass').val();
	var ChangeSecurityQues = $('#ChangeSecurityQues').val();
	var changeSecurityAns = $('#changeSecurityAns').val();


	$.ajax({
	url: "<?php echo base_url()."/SSOController/resetPassword";?>",
	type: 'POST',
	data: {
		user: changeUsername,
		newpass: changeNewPass,
		retypePass: retypeChangePass,
		securityQues: ChangeSecurityQues,
		securityAns: changeSecurityAns
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

		else if(res.status == 1)
		{
	
				swal({
				title: "Success",
				text: res.message,
				type: "success",
				closeOnClickOutside: false
				});

				$('#modal_default_changePassSR').modal('hide');

				$('#changeUsername, #changeNewPass, #retypeChangePass, #changeSecurityAns').val('');
			

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

$('#changeNewPass').keyup(function(){

		var pass = $(this).val();

		if(pass == '')
		{
			$('#newPassSpan').empty();
		}

		else if(pass.length <= 5)
		{	
			$('#newPassSpan').empty();
			$('#newPassSpan').append('Your password is too short!');
		}

		else
		{
			$('#newPassSpan').empty();
		}
})

$('#btnChangePass').prop('disabled', true);

$('#retypeChangePass').keyup(function(){

	var newPass = $('#changeNewPass').val();
	var reTypePass = $(this).val();

	
	if(reTypePass == '')
	{
		$('#retypenewPassSpan').empty();
		$('#btnChangePass').prop('disabled', true);
	}

	else if(reTypePass !== newPass)
	{
		$('#retypenewPassSpan').empty();
		$('#retypenewPassSpan').append('Password not matched!');
	}

	else
	{
		$('#retypenewPassSpan').empty();
		$('#retypenewPassSpan').append('<span style="color: green;">Password matched!</span>');
		$('#btnChangePass').prop('disabled', false);
	}
})


</script>