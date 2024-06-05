<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Vendor Approval</h4>
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

	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-flat">
					<div class="panel-body">
						<table class="table datatable-basic">
								<thead>
									<tr class="bg-success">

									<th>Vendor Name</th>
									<!-- <th>Address 1</th>
									<th>Address 2</th>
									<th>Status</th> -->
									<th>Approval Status</th>
									<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>

								<?php foreach($vendor as $vendors){?>	
									<tr>
									<td><?php echo $vendors['vendorName']; ?></td>
									
									<!-- <td><?php echo $vendors['vendorAddress2']; ?></td>
									
									<td><?php echo $vendors['vendorAddress1'] . ', ' . $vendors['barangayName']   . ', ' . $vendors['municipalityName'] . ', ' . $vendors['provinceName']; ?></td>

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
									</td> -->
									<td>
									<?php if ($vendors['vendor_approval_status'] == 2){ ?>
										<span class="label label-default">
										<?php echo $vendors['approval_stats']; ?>
										</span>
									<?php } else {?>
										<span class="label label-success">
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
														<!-- <li><a onclick=updateVendor(<?php echo $vendors['vendorCode'] ?>) data-toggle="modal" data-target="#modal_form_vertical_update"><i class="icon-pencil4"></i>Update</a></li> -->
														
															<?php if($vendors['vendor_approval_status'] == 2){ ?>
																<li>
																	<a onclick=approveVendor(<?php echo $vendors['vendorCode'] ?>)><i class="icon-user-check"></i>Approved</a></li>
																</li>
															<?php } else { ?>
																<li>
																<a onclick=disapprovedVendor(<?php echo $vendors['vendorCode'] ?>)><i class="icon-user-block"></i>Disapproved</a></li>
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




<script>

var delay = 1200;

    $('#li19').addClass('active');

    $('.datatable-basic').DataTable();

        function approveVendor(vendor_id)
        {
            $.ajax({
            url: "<?php echo base_url(). 'approvalVendorController/alertApprovalFirst' ?>",
            type: 'POST',
            data: {vendor: vendor_id},
            dataType: 'JSON',
            success: function(res){

            		if(res.stats == 2)
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
                                    url: "<?php echo base_url(). 'approvalVendorController/updateApprovalStat' ?>",
                                    data: {vendor: vendor_id},
                                    dataType: 'JSON',
                                    success: function(response)
                                    {
                                        if(response.stats == 1)
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
        
        function disapprovedVendor(vendor_id)
        {
                $.ajax({
                url: "<?php echo base_url(). 'approvalVendorController/alertDissapprove' ?>",
                type: 'POST',
                data: {vendor: vendor_id},
                dataType: 'JSON',
                success: function(res){

                        if(res.stats == 2)
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
                                        url: "<?php echo base_url(). 'approvalVendorController/disApprovedVendor' ?>",
                                        data: {vendor: vendor_id},
                                        dataType: 'JSON',
                                        success: function(response)
                                        {
                                            if(response.stats == 1)
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