	<!-- Page header -->
	<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Approval Vendor Account</h4>
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



    <div class="content">
		
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
                                            <th>Approval Status</th>	
                                            <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php foreach($data as $datas){ ?>	
                                            <tr>
                                                <td><?php echo $datas['vendorName']  ?></td>
                                                <td><?php echo $datas['accountNumber'] ?></td>
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
                                                                <!-- <li><a onclick=fetchUpdateVendorAcc(<?php echo $datas['vendorAccountCode'] ?>) data-toggle="modal" data-target="#updateModal"><i class="icon-pencil4"></i>Update</a></li> -->
                                                                
                                                                    <?php if($datas['approval_status'] == 2){ ?>	
                                                                        <li>
                                                                            <a onclick=approved(<?php echo $datas['vendorAccountCode'] ?>)><i class="icon-user-check"></i>Approve</a>
                                                                        </li>
                                                                    <?php } else { ?>
                                                                        <li>
                                                                        <a onclick=Disapproved(<?php echo $datas['vendorAccountCode'] ?>)><i class="icon-user-block"></i>Disapproved</a>
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

        $('#li21').addClass('active');

        $('.datatable-basic').DataTable();

        var delay = 1200;


        function approved(VA_id)
        {
            $.ajax({
            url: '<?php echo base_url(). 'approvalVendorAccountController/alertIfApproved' ?>',
            type: 'POST',
            data: {
                id: VA_id
            },
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
                        url: "<?php echo base_url(). 'approvalVendorAccountController/ApprovedVC'; ?>",
                        data: {id: VA_id},
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


        function Disapproved(VA_id)
        {
            $.ajax({
            url: '<?php echo base_url(). 'approvalVendorAccountController/alertIfDisApproved' ?>',
            type: 'POST',
            data: {
                id: VA_id
            },
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
                        url: "<?php echo base_url(). 'approvalVendorAccountController/DisApprovedVC'; ?>",
                        data: {id: VA_id},
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