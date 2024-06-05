<div class="page-header page-header-default">
		<div class="page-header-content">
			<div class="page-title">
				<h4>Adjustment / Deduction Reports</h4>
			</div>

			<div class="heading-elements">
				<div class="heading-btn-group">
				</div>
			</div>
		</div>

		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="<?php echo base_url();?>mainController/afterLogin"><i class="icon-home2 position-left"></i> Home</a></li>
				<li class="active">Adjustment / Deduction Reports</li>
			</ul>

			<ul class="breadcrumb-elements">
			
			</ul>
		</div>
</div>




<div class="content">
		<div class="row">
		

			<div class="col-sm-3">
							<div class="panel panel-flat">
								<div class="panel-heading">
									<h6 class="panel-title">Breakdown Report By PO</h6>
								</div>
								
								<div class="panel-body">
								<label>Company</label>
								<select class="form-control" name="Rcomp" id="Rcomp">
										<option value=''>Select company</option>
										<?php foreach($company as $companys){ ?>	
											<option value='<?php echo $companys['company_id'] ?>'><?php echo $companys['company_name'] ?></option>
										<?php } ?>
									</select> <br>

									<label>Vendor</label>
									<select class="form-control" name="Rvendor" id="Rvendor">
										<option value=''>Select vendor</option>
										<?php foreach($vendor as $vendors){ ?>	
											<option value='<?php echo $vendors['vendorCode'] ?>'><?php echo $vendors['vendorName'] ?></option>
										<?php } ?>
									</select> <br>

									<label>Reference No. </label>
                                    <input type="text" class="form-control " name="Reference_no" id="Reference_no"> <br>

                                    <label>Date from <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control daterange-single" name="RdateFrom" id="RdateFrom"> <br>

                                    <label>Date to <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control daterange-single" name="RdateTo" id="RdateTo">


									<div style="padding-top: 10px;">
										<button class="btn btn-success" name="btnGenerate" id="btnGenerate"><i class="icon-file-excel position-left"></i>Excel</button>
										<button class="btn btn-danger" name="btnGeneratePDF" id="btnGeneratePDF"><i class="icon-file-pdf position-left"></i>PDF</button>
									</div>
								</div>
							</div>								
			</div> 


			<div class="col-sm-3">
							<div class="panel panel-flat">
								<div class="panel-heading">
									<h6 class="panel-title">Breakdown Report By RFP</h6>
								</div>
								
								<div class="panel-body">
									<label>RFP</label>
									<input class="form-control" list="searchResults" id= "searchRFP" placeholder="Search RFP">
										<datalist id="searchResults" >
										
										</datalist>
									
									<br>

                                    <label>Date from <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control daterange-single" name="RFPdateFrom" id="RFPdateFrom"> <br>

                                    <label>Date to <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control daterange-single" name="RFPdateTo" id="RFPdateTo">


									<div style="padding-top: 10px;">
										<button class="btn btn-success" name="btnGenerateRFP" id="btnGenerateRFP"><i class="icon-file-excel position-left"></i>Excel</button>
										<button class="btn btn-danger" name="btnGeneratePDFRFP" id="btnGeneratePDFRFP"><i class="icon-file-pdf position-left"></i>PDF</button>
									</div>
								</div>
							</div>								
			</div> 								



			<div class="col-sm-3">
							<div class="panel panel-flat">
								<div class="panel-heading">
									<h6 class="panel-title">Daily PO Report</h6>
								</div>
								
								<div class="panel-body">
								<label>Company</label>
								<select class="form-control" name="Rcomp" id="RRcomp">
										<option value=''>Select company</option>
										<?php foreach($company as $companys){ ?>	
											<option value='<?php echo $companys['company_id'] ?>'><?php echo $companys['company_name'] ?></option>
										<?php } ?>
									</select> <br>

									<!-- <select class="form-control" name="Rvendor" id="Rvendor">
										<option value=''>Select Currency</option>
										<?php foreach($currency as $currencys){ ?>	
											<option value='<?php echo $currencys['currency_id'] ?>'><?php echo $currencys['currency'] ?></option>
										<?php } ?>
									</select> <br> -->

									<!-- <select class="form-control" name="Rtransact" id="Rtransact">
										<option value=''>Select Transaction</option>
										<?php foreach($transaction as $transactions){ ?>	
											<option value='<?php echo $transactions['transactionCode'] ?>'><?php echo $transactions['transactionName'] ?></option>
										<?php } ?>
									</select> <br> -->



                                    <label>Date  <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control daterange-single" name="RRdateFrom" id="RRdateFrom"> <br>

                                    <!-- <label>Date to <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control daterange-single" name="RRdateTo" id="RRdateTo"> -->


									<div style="padding-top: 10px;">
										<button class="btn btn-success" name="bbtnGenerate" id="bbtnGenerate"><i class="icon-file-excel position-left"></i>Generate</button>
										<!-- <button class="btn btn-primary" name="bbtnGenerateAll" id="bbtnGenerateAll"><i class="icon-file-pdf position-left"></i>Generate All</button> -->
										<!-- <button class="btn btn-primary" name="btnBankAll" id="btnBankAll"><i class="icon-pdf-excel position-left"></i>Generate All</button> -->
									</div>
								</div>
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

$('#li25').addClass('active');

$('.daterange-single').daterangepicker({ 
	singleDatePicker: true,
	//use if disable previos date
	// minDate: moment()

	isInvalidDate: function(date) {
	// Disable dates in the future
	return date.isAfter(moment());
}
});

//PO
$('#btnGenerate').click(function () {
    var Rcomp = $('#Rcomp').val();
    var Rvendor = $('#Rvendor').val();
	// var Rtransact = $('#Rtransact').val();
	var Reference_no = $('#Reference_no').val();
	var RdateFrom = $('#RdateFrom').val();
	var RdateTo = $('#RdateTo').val();

    $.ajax({
        url: '<?php echo base_url(). "adjustmentDeductionReportController/generateExcelReports" ?>',
        type: 'POST',
        data: {
            company: Rcomp,
            vendor: Rvendor,
			reference: Reference_no,
			// transaction: Rtransact,
			dateFrom: RdateFrom,
			dateTo: RdateTo
        },
        dataType: 'JSON',
		beforeSend: function(){

			blockUILoading();

		},
        success: function (response) {

			if(response.stats == 1)
			{
				alert(response.message);
			}

            else if (response.success) {
                // Trigger the download after success

				window.open('<?php echo base_url(). "adjustmentDeductionReportController/downloadExcelFile" ?>');

				swal({
				title: "Success",
				text: "Successfully Generated!",
				type: "success",
				closeOnClickOutside: false
				});

				setTimeout(function() {
                    $.unblockUI();
                }, 1000); // Adjust the delay as needed


            } else {
                // Handle error or show a message
                console.error('Error generating Excel report');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle AJAX error
            console.error('AJAX Error:', textStatus, errorThrown);
        }
    });
});

//PO ALL
$('#btnGenerateAll').click(function(){
	
	var RdateFrom = $('#RdateFrom').val();
	var RdateTo = $('#RdateTo').val();

	$.ajax({
        url: '<?php echo base_url(). "adjustmentDeductionReportController/generateExcelReportsAllPO" ?>',
        type: 'POST',
        data: {
			dateFrom: RdateFrom,
			dateTo: RdateTo
        },
        dataType: 'JSON',
        success: function (response) {

			if(response.stats == 1)
			{
				alert(response.message);
			}

            else if (response.success) {
                // Trigger the download after success
      
				window.open('<?php echo base_url(). "adjustmentDeductionReportController/downloadExcelFilesALLPO" ?>');

				swal({
				title: "Success",
				text: "Successfully Generated!",
				type: "success",
				closeOnClickOutside: false
				});


            } else {
                // Handle error or show a message
                console.error('Error generating Excel report');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle AJAX error
            console.error('AJAX Error:', textStatus, errorThrown);
        }
    });

})

//INVOICE ALL
$('#btnGenerateAllInvoice').click(function(){

	var IdateFrom = $('#IdateFrom').val();
	var IdateTo = $('#IdateTo').val();

	$.ajax({
        url: '<?php echo base_url(). "adjustmentDeductionReportController/generateAllInvoice" ?>',
        type: 'POST',
        data: {
			dateFrom: IdateFrom,
			dateTo: IdateTo
        },
        dataType: 'JSON',
        success: function (response) {

			if(response.stats == 1)
			{
				alert(response.message);
			}

            else if (response.success) {
                // Trigger the download after success

				window.open('<?php echo base_url(). "adjustmentDeductionReportController/downloadExcelFileInvoiceAll" ?>');

				swal({
				title: "Success",
				text: "Successfully Generated!",
				type: "success",
				closeOnClickOutside: false
				});

                // window.location.href = '<?php echo base_url(). "adjustmentDeductionReportController/downloadExcelFileInvoiceAll" ?>';
            } else {
                // Handle error or show a message
                console.error('Error generating Excel report');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle AJAX error
            console.error('AJAX Error:', textStatus, errorThrown);
        }
    });

})


$('#btnPdfAllPO').click(function()
{

	var Pcomp = $('#Pcomp').val();
	var Pcurrency = $('#Pcurrency').val()
	var PdateFrom = $('#PdateFrom').val();
	// var PdateTo = $('#PdateTo').val();

	$.ajax({
		url: '<?php echo base_url(). 'adjustmentDeductionReportController/generatePdfPO' ?>',
		type: 'POST',
		data: {
			compCode: Pcomp,
			currency: Pcurrency,
			dateFrom: PdateFrom,
			// dateTo: PdateTo
		},
		dataType: 'JSON',
		success: function(response){


				window.open(response.pdfPath, '_blank');
			
				swal({
				title: "Done",
				text: "Successfully generated",
				type: "success",
				closeOnClickOutside: false
				});

			

			
		}


	});



})

$('#btnALLPDF').click(function(){

	var PdateFrom = $('#PdateFrom').val();
	var PdateTo = $('#PdateTo').val();

	$.ajax({
		url: '<?php echo base_url(). 'adjustmentDeductionReportController/ALLgeneratePdfPO' ?>',
		type: 'POST',
		data: {
			dateFrom: PdateFrom,
			dateTo: PdateTo
		},
		dataType: 'JSON',
		success: function(response){


				window.open(response.pdfPath, '_blank');
			
				swal({
				title: "Done",
				text: "Successfully generated",
				type: "success",
				closeOnClickOutside: false
				});

			

			
		}


	});


})


$('#bbtnGenerate').click(function(){
	
    var Rcomp = $('#RRcomp').val();
	var RdateFrom = $('#RRdateFrom').val();
	// var RdateTo = $('#RRdateTo').val();

	$.ajax({
        url: '<?php echo base_url(). "adjustmentDeductionReportController/generateExcelReportsPaidAmount" ?>',
        type: 'POST',
        data: {
            compCode: Rcomp,
			dateFrom: RdateFrom,
			// dateTo: RdateTo
        },
        dataType: 'JSON',
		beforeSend: function(){

			blockUILoading();

		},
        success: function (response) {

			if(response.stats == 1)
			{
				alert(response.message);
			}

            else if (response.success) {
                // Trigger the download after success
      
				window.open('<?php echo base_url(). "adjustmentDeductionReportController/downloadExcelFilesPOS" ?>');

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


            } else {
                // Handle error or show a message
                console.error('Error generating Excel report');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle AJAX error
            console.error('AJAX Error:', textStatus, errorThrown);
        }
    });

})

$('#btnGeneratePDF').click(function(){

	var Rcomp = $('#Rcomp').val();
	var Rvendor = $('#Rvendor').val();
	// var Rtransact = $('#Rtransact').val();
	var Reference_no = $('#Reference_no').val();
	var RdateFrom = $('#RdateFrom').val();
	var RdateTo = $('#RdateTo').val();


	$.ajax({
		url: '<?php echo base_url(). 'adjustmentDeductionReportController/generatePdfPO_2' ?>',
		type: 'POST',
		data: {
			compCode: Rcomp,
			vendor: Rvendor,
			reference: Reference_no,
			dateFrom: RdateFrom,
			dateTo: RdateTo
		},
		dataType: 'JSON',
		beforeSend: function(){

			blockUILoading();

		},
		success: function(response){


			window.open(response.pdfPath, '_blank');
		
			swal({
			title: "Done",
			text: "Successfully generated",
			type: "success",
			closeOnClickOutside: false
			});

			setTimeout(function() {
                    $.unblockUI();
            }, 1000); // Adjust the delay as needed


		}


	});
})


$('#bbtnGenerateAll').click(function(){


	var RdateFrom = $('#RRdateFrom').val();
	var RdateTo = $('#RRdateTo').val();

	$.ajax({
        url: '<?php echo base_url(). "adjustmentDeductionReportController/generateExcelReportsAllPaidAmount" ?>',
        type: 'POST',
        data: {
			dateFrom: RdateFrom,
			// dateTo: RdateTo
        },
        dataType: 'JSON',
        success: function (response) {

			if(response.stats == 1)
			{
				alert(response.message);
			}

            else if (response.success) {
                // Trigger the download after success
      
				window.open('<?php echo base_url(). "adjustmentDeductionReportController/downloadExcelFilesALLPOS" ?>');

				swal({
				title: "Success",
				text: "Successfully Generated!",
				type: "success",
				closeOnClickOutside: false
				});


            } else {
                // Handle error or show a message
                console.error('Error generating Excel report');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Handle AJAX error
            console.error('AJAX Error:', textStatus, errorThrown);
        }
    });

})


//rfp excel
$('#btnGenerateRFP').click(function(){

	var RFPcomp = $('#RFPcomp').val();
	var RFPs = $('#RFP').val();
	var RFPdateFrom = $('#RFPdateFrom').val();
	var RFPdateTo = $('#RFPdateTo').val();

		$.ajax({
			url: '<?php echo base_url(). "adjustmentDeductionReportController/rfpReportExcel" ?>',
			type: 'POST',
			data: {
				// company: RFPcomp,
				rfp: RFPs,
				dateFrom: RFPdateFrom,
				dateTo: RFPdateTo
			},
			dataType: 'JSON',
			beforeSend: function(){
		
				blockUILoading();

			},
			success: function (response) {

				if(response.stats == 1)
				{
					alert(response.message);
				}

				else if (response.success) {
					// Trigger the download after success
		
					window.open('<?php echo base_url(). "adjustmentDeductionReportController/downloadExcelFileRFP" ?>');

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


				} else {
					// Handle error or show a message
					console.error('Error generating Excel report');
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				// Handle AJAX error
				console.error('AJAX Error:', textStatus, errorThrown);
			}
		});
})

//rfp pdf
$('#btnGeneratePDFRFP').click(function(){

	var RFPs = $('#searchRFP').val();
	var RFPdateFrom = $('#RFPdateFrom').val();
	var RFPdateTo = $('#RFPdateTo').val();


	$.ajax({
		url: '<?php echo base_url(). 'adjustmentDeductionReportController/generatePdfRFP' ?>',
		type: 'POST',
		data: {
			rfp: RFPs,
			dateFrom: RFPdateFrom,
			dateTo: RFPdateTo
		},
		dataType: 'JSON',
		beforeSend: function(){

			blockUILoading();

		},
		success: function(response){


			window.open(response.pdfPath, '_blank');
		
			swal({
			title: "Done",
			text: "Successfully generated",
			type: "success",
			closeOnClickOutside: false
			});

			setTimeout(function() {
                    $.unblockUI();
            }, 1000); // Adjust the delay as needed

		
		}


	});
})


$('#searchRFP').keypress(function() {

	var searchRFP = $(this).val().trim();

	if (searchRFP === '') {
		// Clear the select dropdown
		$('#searchResults').empty();
		return;
	}

	$.ajax({
		url: '<?php echo base_url() . 'adjustmentDeductionReportController/searchRFPTODB' ?>',
		type: 'POST',
		data: {
			rfp: searchRFP
		},
		dataType: 'JSON',
		success: function(response) {

			if (Array.isArray(response) && response.length > 0) {
				// Clear previous results 

				$('#searchResults').empty();

				// Populate the select dropdown with the search results
				$.each(response, function(index, value) {
					$('#searchResults').append($('<option>', {
						value: value.rfp, // Assuming each result has an 'rfp' property
						text: value.rfp
					}));
				});
			} else {
				// Clear the select dropdown and display a default message
				$('#searchResults').empty().html('<option value="">No results found</option>');
			}
		},
		error: function(error) {
			console.log('Error:', error);
		}
	});
});






</script>