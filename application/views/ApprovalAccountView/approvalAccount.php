	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Approval Accounts</h4>
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


    <div class="content">

<!-- <div style="padding-bottom: 10px;">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_form_vertical"><i class="icon-user-plus position-left"></i> Add Accounts</button>	
</div>	 -->

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
													<!-- <th>Bank Name</th>	
													<th>Swift Code</th>
													<th>ABA No.</th>
													<th>Routing No.</th>
													<th>IBAN No.</th>
													<th>CIF No.</th>
													<th>BSB No.</th>
													<th>Intermediary Bank</th>
													<th>Inter Bank Address</th> -->
													<!-- <th>Number</th>
													<th>Swift</th>
													<th>ABA</th>
													<th>Chips</th> -->
													<!-- <th>Status</th>	 -->
													<th>Approval Status</th>
													<th>Action</th>
													</tr>
												</thead>
												<tbody>

													<?php foreach($list as $lists){  ?>
													<tr>
													<td><?php echo $lists['accountNumber']  ?></td>
													<!-- <td><?php echo $lists['bankName'] ?></td>
													<td><?php echo $lists['swiftCode'] ?></td>
													<td><?php echo $lists['abaNo'] ?></td>
													<td><?php echo $lists['routingNo'] ?></td>
													<td><?php echo $lists['ibanNo'] ?></td>
													<td><?php echo $lists['cifNo'] ?></td>
													<td><?php echo $lists['bsbNo'] ?></td>
													<td><?php echo $lists['intermediaryBank'] ?></td>
													<td><?php echo $lists['interbankAddress'] ?></td> -->
													<!-- <td><?php echo $lists['number'] ?></td>
													<td><?php echo $lists['swift'] ?></td>
													<td><?php echo $lists['aba'] ?></td>
													<td><?php echo $lists['chips'] ?></td> -->
													<!-- <td>
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
													
													</td> -->
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
																		<!-- <li><a onclick=fetchDataInModal(<?php echo $lists['accountCode'] ?>) data-toggle="modal" data-target="#modalUpdate"><i class="icon-pencil4"></i>Update</a></li> -->
																		
																			<?php if($lists['account_approval_status'] == 2){ ?>
																				<li>
																					<a onclick=approvedAccount(<?php echo $lists['accountCode'] ?>)><i class="icon-user-block"></i>Approved</a></li>
																				</li>
																			<?php } else { ?>
																				<li>
																				<a onclick=disApprovedAccount(<?php echo $lists['accountCode'] ?>)><i class="icon-user-check"></i>Disapproved</a></li>
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





<script>
    $('#li20').addClass('active');

    $('.datatable-basic').DataTable();

    var delay = 1200;                    

     function approvedAccount(acc_id)
     {
            $.ajax({
            url: "<?php echo base_url(). 'approvalAccountController/alertAccountApproval'; ?>",
            type: 'POST',
            data: {acc_code: acc_id},
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
                                url: "<?php echo base_url(). 'approvalAccountController/updateAccountApproval'; ?>",
                                data: {acc_code: acc_id},
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
     
     function disApprovedAccount(acc_id)
     {
            $.ajax({
            url: "<?php echo base_url(). 'approvalAccountController/alertAccountDisapproved'; ?>",
            type: 'POST',
            data: {acc_code: acc_id},
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
                                url: "<?php echo base_url(). 'approvalAccountController/updateDisapproved'; ?>",
                                data: {acc_code: acc_id},
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

</script>