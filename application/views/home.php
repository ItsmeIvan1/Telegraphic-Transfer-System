
	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Dashboard</h4>
			</div>

			<div class="heading-elements">
				<div class="heading-btn-group">
				</div>
			</div>
		</div>

		<!-- <div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li class="active">Dashboard</li>
			</ul>

			<ul class="breadcrumb-elements">
			
			</ul>
		</div> -->
	</div>
	<!-- /page header -->

	<div class="content">

		<div class="row">
			<!-- PO TRANSACTION -->
			<div class="col-md-6">
						<div class="chart has-fixed-height has-minimum-width" id="pie_basic_tele_po" style="user-select: none; position: relative;" _echarts_instance_="ec_1703039510187">
								<div style="position: relative; overflow: hidden; width: 750px; height: 400px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;">
									<canvas style="position: absolute; left: 0px; top: 0px; width: 750px; height: 400px; user-select: none; padding: 0px; margin: 0px; border-width: 0px;" data-zr-dom-id="zr_0" width="750" height="400">
									</canvas>
								</div>
								<div style="position: absolute; display: none; border-style: solid; white-space: nowrap; z-index: 9999999; transition: left 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s, top 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s; background-color: rgba(0, 0, 0, 0.75); border-width: 0px; border-color: rgb(51, 51, 51); border-radius: 4px; color: rgb(255, 255, 255); font: 13px / 20px Roboto, sans-serif; padding: 10px 15px; left: 325px; top: 265.917px;">
									Browsers <br>Chrome: 1548 (60.42%)
								</div>
						</div>
			</div>
			<!-- INVOICE TRANSACTION -->
			<div class="col-md-6">
						<div class="chart has-fixed-height has-minimum-width" id="pie_basic_invoice" style="user-select: none; position: relative;" _echarts_instance_="ec_1703039510187">
								<div style="position: relative; overflow: hidden; width: 750px; height: 400px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;">
									<canvas style="position: absolute; left: 0px; top: 0px; width: 750px; height: 400px; user-select: none; padding: 0px; margin: 0px; border-width: 0px;" data-zr-dom-id="zr_0" width="750" height="400">
									</canvas>
								</div>
								<div style="position: absolute; display: none; border-style: solid; white-space: nowrap; z-index: 9999999; transition: left 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s, top 0.4s cubic-bezier(0.23, 1, 0.32, 1) 0s; background-color: rgba(0, 0, 0, 0.75); border-width: 0px; border-color: rgb(51, 51, 51); border-radius: 4px; color: rgb(255, 255, 255); font: 13px / 20px Roboto, sans-serif; padding: 10px 15px; left: 325px; top: 265.917px;">
									Browsers <br>Chrome: 1548 (60.42%)
								</div>
						</div>
			</div>
		</div>

		<div class="chart has-fixed-height has-minimum-width" id="pie_multiples_tele" style="height: 450px; user-select: none;" _echarts_instance_="ec_1703058857683"><div style="position: relative; overflow: hidden; width: 1561px; height: 450px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas style="position: absolute; left: 0px; top: 0px; width: 1561px; height: 450px; user-select: none; padding: 0px; margin: 0px; border-width: 0px;" data-zr-dom-id="zr_0" width="1561" height="450"></canvas></div></div>


			<!-- Modal for create account for S&R -->
			<div id="modal_default_loginSR" class="modal fade in" data-backdrop="static" data-keyboard="false" tabindex="-1" >
						<div class="modal-dialog ">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Change Password</h5>
								</div>

								<div class="modal-body">
									<div class="form-group">
									<?php  
										if($this->session->userdata('username')){?>
										<span >
										Hello!  <b><?php echo $this->session->userdata('username')?></b>
										</span>
									<?php }?>
									</div>

									<div class="form-group">
										<label >Current Password<span style="color: red;">*</span></label>
										<input type="password" class="form-control" name="currentPass" id="currentPass">
										<span style="color: red;" id="errormsg1"></span>
									</div>

									<div class="form-group">
										<label >New Password<span style="color: red;">*</span></label>
										<input type="password" class="form-control" name="newPass" id="newPass">
										<span style="color: red;" id="errormsg2"></span>
									</div>

									<div class="form-group">
										<label >Retype New Password<span style="color: red;">*</span></label>
										<input type="password" class="form-control" name="RetypePass" id="RetypePass">
										<span style="color: red;" id="errormsg3"></span>
									</div>
									

								<div class="modal-footer">
									<a  href="<?php echo base_url(). 'mainController/logout' ?>" >Logout</a>	
									<button type="button" class="btn btn-primary" id="ChangePass">Change password</button>
								</div>
							</div>
						</div>
					</div>

			</div>

	</div>


		



<script>

$('#ChangePass').prop('disabled', true);

$(window).on('load', function() {

    $.ajax({
        url: "<?php echo base_url()."/SSOController/checkIfFirstLogin";?>",
        type: 'POST',
        dataType: 'json',
        success: function(res){

            if(res.status == 1) 
			{
                $('#modal_default_loginSR').modal('show');

            } 
			
			else {
                $('#modal_default_loginSR').modal('hide');
            }
        },

        error: function(){

            console.error('Error fetching first login status.');
        }
    });

});

$('#newPass').keyup(function(){
	
	var pass = $(this).val();
	var currentPass = $('#currentPass').val();
	var pattern = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;

	if(pass == '')
	{
		$('#errormsg2').empty();
		$('#ChangePass').prop('disabled', true);
	}

	else if(pass == currentPass)
	{
		$('#errormsg2').empty();
		$('#errormsg2').append('Oops, your new password matches your previous one.');
		$('#ChangePass').prop('disabled', true);
	}

	else if(pass.length<= 5)
	{	
		$('#errormsg2').empty();
		$('#errormsg2').append('Your password must be 6 characters.');
		$('#ChangePass').prop('disabled', true);
	}


	else if(!pattern.test(pass))
	{
		$('#errormsg2').empty();
		$('#errormsg2').append('Your password must contain both letters and numbers.');
		$('#ChangePass').prop('disabled', true);
	}

	else
	{
		$('#errormsg2').empty();	
	}

});

$('#RetypePass').keyup(function(){

	var newpass = $('#newPass').val();
	var retypePass = $(this).val();

	if(retypePass == '')
	{
		$('#errormsg3').empty();
		$('#ChangePass').prop('disabled', true);
	}
	else if(retypePass !== newpass)
	{
		$('#errormsg3').empty();
		$('#errormsg3').append("Your password dont match!");
		$('#ChangePass').prop('disabled', true);
	}

	else
	{
		$('#errormsg3').empty();
		$('#ChangePass').prop('disabled', false);
	}
})


$('#ChangePass').click(function(){

	var currentPass = $('#currentPass').val();
	var newPass = $('#newPass').val();
	var RetypePass = $('#RetypePass').val();

	$.ajax({
        url: "<?php echo base_url()."/SSOController/resetPassword";?>",
        type: 'POST',
		data: {
			newpass: newPass,
		},
        dataType: 'JSON',
        success: function(res){

			if(res.status == 1)
			{

				$('#modal_default_loginSR').modal('hide');

			}

			else
			{
				// swal({
				// title: "error",
				// text: res.message,
				// type: "error",
				// closeOnClickOutside: false
				// });	
			}
    
        }
    });
 

})

$('#currentPass').keyup(function(){

	var pass = $(this).val();

	$.ajax({
        url: "<?php echo base_url()."/SSOController/checkUserAndPassExist";?>",
        type: 'POST',
		data: {
			pass: pass
		},
        dataType: 'json',
        success: function(res){

            if(res.status == 1) 
			{
				$('#errormsg1').empty();
            }
			
			else if(pass == '')
			{
				$('#errormsg1').empty();
			}
			
			else {
				$('#errormsg1').empty();	
				$('#errormsg1').append('Your Password is incorrect!');
			
            }
        },

        error: function(){

            console.error('Error fetching first login status.');
        }
    });
})


$('#0').addClass('active');


document.addEventListener('DOMContentLoaded', function() {
	var pie_basic_element = document.getElementById('pie_basic_tele_po');
	var pie_basic_element_invoice = document.getElementById('pie_basic_invoice');
	var pie_multiples_element = document.getElementById('pie_multiples_tele');

	    // Basic pie chart
			if (pie_basic_element) 
			{																																																																																																																																																																																																																																																																																																																																														

				// Initialize chart
				var pie_basic = echarts.init(pie_basic_element);


				//
				// Chart config
				//

				// Options
				pie_basic.setOption({

				// Colors
				color: [
					'#0BDA51','#BF3131'
				],

				// Global text styles
				textStyle: {
					fontFamily: 'Roboto, Arial, Verdana, sans-serif',
					fontSize: 13
				},

				// Add title
				title: {
					text: 'Telegraphic transfer / PO',
					subtext: 'Number of transact',
					left: 'center',
					textStyle: {
						fontSize: 17,
						fontWeight: 500
					},
					subtextStyle: {
						fontSize: 12
					}
				},

				// Add tooltip
				tooltip: {
					trigger: 'item',
					backgroundColor: 'rgba(0,0,0,0.75)',
					padding: [10, 15],
					textStyle: {
						fontSize: 13,
						fontFamily: 'Roboto, sans-serif'
					},
					formatter: "{a} <br/>{b}: {c} ({d}%)"
				},

				// Add legend
				// legend: {
				// 	orient: 'vertical',
				// 	top: 'center',
				// 	left: 0,
				// 	data: ['Open transaction', 'Closed transaction'],
				// 	itemHeight: 8,
				// 	itemWidth: 8
				// },

				// Add series
				series: [{
					name: 'Total',
					type: 'pie',
					radius: '60%',
					center: ['50%', '57.5%'],
					itemStyle: {
						normal: {
							borderWidth: 1,
							borderColor: '#fff'
						}
					},
					// label: {
					// show: true,
					// position: 'inner', // 'inside', 'outside', 'center', 'inner'
					// textStyle: {
					// 	fontSize: 13,
					// 	fontFamily: 'Roboto, sans-serif'
					// },
					// formatter: '{d}%' // Display only the percentage
					// },

					
					data: [
						{value:'<?php echo $this->mainModel->totalNumberOpenStatus(); ?>', name: 'Open transaction'},
						{value: '<?php echo $this->mainModel->totalNumberOpenStatusHis(); ?>', name: 'Closed transaction'},
					]

				}]
				});
			}

			if (pie_basic_element) 
			{

				// Initialize chart
				var pie_basic = echarts.init(pie_basic_element_invoice);


				//
				// Chart config
				//

				// Options
				pie_basic.setOption({

				// Colors
				color: [
					'#5FBDFF','#7B66FF'
				],

				// Global text styles
				textStyle: {
					fontFamily: 'Roboto, Arial, Verdana, sans-serif',
					fontSize: 13
				},

				// Add title
				title: {
					text: 'Telegraphic transfer / Invoice',
					subtext: 'Number of transact',
					left: 'center',
					textStyle: {
						fontSize: 17,
						fontWeight: 500
					},
					subtextStyle: {
						fontSize: 12
					}
				},

				// Add tooltip
				tooltip: {
					trigger: 'item',
					backgroundColor: 'rgba(0,0,0,0.75)',
					padding: [10, 15],
					textStyle: {
						fontSize: 13,
						fontFamily: 'Roboto, sans-serif'
					},
					formatter: "{a} <br/>{b}: {c} ({d}%)"
				},

				// Add legend
				// legend: {
				// 	orient: 'vertical',
				// 	top: 'center',
				// 	left: 0,
				// 	data: ['Open transaction', 'Closed transaction'],
				// 	itemHeight: 8,
				// 	itemWidth: 8
				// },

				// Add series
				series: [{
					name: 'Total',
					type: 'pie',
					radius: '60%',
					center: ['50%', '57.5%'],
					itemStyle: {
						normal: {
							borderWidth: 1,
							borderColor: '#fff'
						}
					},
					// label: {
					// show: true,
					// position: 'inside', // 'inside', 'outside', 'center', 'inner'
					// textStyle: {
					// 	fontSize: 13,
					// 	fontFamily: 'Roboto, sans-serif'
					// },
					// formatter: '{d}%' // Display only the percentage
					// },
					data: [
						{value:'<?php echo $this->mainModel->totalNumberOpenStatusInvoice(); ?>', name: 'Open transaction'},
						{value: '<?php echo $this->mainModel->totalNumberOpenStatusInvoiceHis(); ?>', name: 'Closed transaction'},
					]

				}]
				});
			}

			// Donut multiples
			if (pie_multiples_element) 
			{

				// Initialize chart
				var pie_multiples = echarts.init(pie_multiples_element);


				//
				// Chart config
				//

				// Top text label
				var labelTop = {
					show: true,
					position: 'center',
					formatter: '{b}\n',
					fontSize: 15,
					lineHeight: 50,
					rich: {
						a: {}
					}
				};

				// Background item style
				var backStyle = {
					color: '#eee',
					emphasis: {
						color: '#eee'
					}
				};

				// Bottom text label
				var labelBottom = {
					color: '#333',
					show: true,
					position: 'center',
					formatter: function (params) {
						return '\n\n' + (100 - params.value)
					},
					fontWeight: 500,
					lineHeight: 35,
					rich: {
						a: {}
					},
					emphasis: {
						color: '#333'
					}
				};

				// Set inner and outer radius
				var radius = [62, 85];

		

				// Options
				pie_multiples.setOption({

					// Colors
					color: [
						'#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
						'#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
						'#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
						'#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
					],

					// Global text styles
					textStyle: {
						fontFamily: 'Roboto, Arial, Verdana, sans-serif',
						fontSize: 13
					},

					// Add series
					series: [
						{
							type: 'pie',
							center: ['10%', '33%'],
							radius: radius,
							hoverAnimation: false,
							data: [
								{ name: 'other', value: 100 - <?php echo $this->mainModel->totalNumberPaymentTerms(); ?>, label: labelBottom, itemStyle: backStyle },
								{ name: 'Payments', value: <?php echo $this->mainModel->totalNumberPaymentTerms(); ?>, label: labelTop }
							]
						},
						{
							type: 'pie',
							center: ['30%', '33%'],
							radius: radius,
							hoverAnimation: false,
							data: [
								{name: 'other', value: 100 - <?php echo $this->mainModel->totalNumberBanks(); ?>, label: labelBottom, itemStyle: backStyle},
								{name: 'Banks', value: <?php echo $this->mainModel->totalNumberBanks(); ?>, label: labelTop}
							]
						},
						{
							type: 'pie',
							center: ['50%', '33%'],
							radius: radius,
							hoverAnimation: false,
							data: [
								{name: 'other', value: 100 - <?php echo $this->mainModel->totalNumberAccounts(); ?>, label: labelBottom, itemStyle: backStyle},
								{name: 'Accounts', value: <?php echo $this->mainModel->totalNumberAccounts(); ?>, label: labelTop}
							]
						},
						{
							type: 'pie',
							center: ['70%', '33%'],
							radius: radius,
							hoverAnimation: false,
							data: [
								{name: 'other', value: 100 - <?php echo $this->mainModel->totalNumberVendors(); ?>, label: labelBottom, itemStyle: backStyle},
								{name: 'Vendors', value: <?php echo $this->mainModel->totalNumberVendors(); ?>, label: labelTop}
							]
						},
						{
							type: 'pie',
							center: ['90%', '33%'],
							radius: radius,
							hoverAnimation: false,
							data: [
								{name: 'other', value: 100 - <?php echo $this->mainModel->totalVendorAccounts(); ?>, label: labelBottom, itemStyle: backStyle},
								{name: 'Vendor Accounts', value: <?php echo $this->mainModel->totalVendorAccounts(); ?>, label: labelTop}
							]
						},
					
					]
				});
			}
		
});


</script>