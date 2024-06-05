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
				<li class="active">Adjustment / Deduction Reports Invoice</li>
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
                    <h6 class="panel-title">Breakdown Reports By Invoice</h6>
                </div>
                
                <div class="panel-body">
                    <label>Company</label>
                    <select class="form-control" name="Icomp" id="Icomp">
                        <option value=''>Select company</option>
                        <?php foreach($company as $companys){ ?>	
                            <option value='<?php echo $companys['company_id'] ?>'><?php echo $companys['company_name'] ?></option>
                        <?php } ?>
                    </select> <br>

                    <label>Vendor</label>
                    <select class="form-control" name="Ivendor" id="Ivendor">
                        <option value=''>Select vendor</option>
                        <?php foreach($vendor as $vendors){ ?>	
                            <option value='<?php echo $vendors['vendorCode'] ?>'><?php echo $vendors['vendorName'] ?></option>
                        <?php } ?>
                    </select> <br>
                    
                    <label>Reference No.</label>
                    <input type="text" class="form-control" name="referenceNO" id="referenceNO"> <br>

                    <label>Date from <span style="color:red;">*</span></label>
                    <input type="text" class="form-control daterange-single" name="IdateFrom" id="IdateFrom"> <br>

                    <label>Date to <span style="color:red;">*</span></label>
                    <input type="text" class="form-control daterange-single" name="IdateTo" id="IdateTo">


                    <div style="padding-top: 10px;">
                        <button class="btn btn-success" name="btnGenerateInvoice" id="btnGenerateInvoice"><i class="icon-file-excel position-left"></i>Excel</button>
                        <button class="btn btn-danger" name="btnGenerateInvoicePDF" id="btnGenerateInvoicePDF"><i class="icon-file-pdf position-left"></i>PDF</button>
                        <!-- <button class="btn btn-primary" name="btnBankAll" id="btnBankAll"><i class="icon-pdf-excel position-left"></i>Generate All</button> -->
                    </div>
                </div>
            </div>								
		</div> 

 

        <div class="col-sm-3">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title">Breakdown Reports By RFP</h6>
                </div>
                
                <div class="panel-body">
                    <label>RFP</label>
                   

                    <input class="form-control" list="searchResults" id= "searchRFP" placeholder="Search RFP">
                        <datalist id="searchResults" >
                        
                        </datalist>  
                    <br>



                    <label>Date from <span style="color:red;">*</span></label>
                    <input type="text" class="form-control daterange-single" name="IdateFromRFP" id="IdateFromRFP"> <br>

                    <label>Date to <span style="color:red;">*</span></label>
                    <input type="text" class="form-control daterange-single" name="IdateToRFP" id="IdateToRFP">


                    <div style="padding-top: 10px;">
                        <button class="btn btn-success" name="btnGenerateInvoice" id="btnGenerateInvoiceRFP"><i class="icon-file-excel position-left"></i>Excel</button>
                        <button class="btn btn-danger" name="btnGenerateInvoicePDF" id="btnGenerateInvoicePDFRFP"><i class="icon-file-pdf position-left"></i>PDF</button>
                        <!-- <button class="btn btn-primary" name="btnBankAll" id="btnBankAll"><i class="icon-pdf-excel position-left"></i>Generate All</button> -->
                    </div>
                </div>
            </div>								
		</div> 

        <div class="col-sm-3">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <h6 class="panel-title">Daily Invoice Report</h6>
                </div>
                
                <div class="panel-body">
                    <label>Company</label>
                    <select class="form-control" name="IIcomp" id="IIcomp">
                        <option value=''>Select company</option>
                        <?php foreach($company as $companys){ ?>	
                            <option value='<?php echo $companys['company_id'] ?>'><?php echo $companys['company_name'] ?></option>
                        <?php } ?>
                    </select> <br>

                    <!-- <select class="form-control" name="Ivendor" id="Ivendor">
                        <option value=''>Select Vendor</option>
                        <?php foreach($vendor as $vendors){ ?>	
                            <option value='<?php echo $vendors['vendorCode'] ?>'><?php echo $vendors['vendorName'] ?></option>
                        <?php } ?>
                    </select> <br> -->

                    <!-- <select class="form-control" name="Itransact" id="Itransact">
                        <option value=''>Select Transaction</option>
                        <?php foreach($transaction as $transactions){ ?>	
                            <option value='<?php echo $transactions['transactionCode'] ?>'><?php echo $transactions['transactionName'] ?></option>
                        <?php } ?>
                    </select> <br> -->



                    <label>Date <span style="color:red;">*</span></label>
                    <input type="text" class="form-control daterange-single" name="IIdateFrom" id="IIdateFrom"> <br>
<!-- 
                    <label>Date to <span style="color:red;">*</span></label>
                    <input type="text" class="form-control daterange-single" name="IIdateTo" id="IdateTo"> -->


                    <div style="padding-top: 10px;">
                        <button class="btn btn-success" name="bbtnGenerateInvoice" id="bbtnGenerateInvoice"><i class="icon-file-excel position-left"></i>Generate</button>
                        <!-- <button class="btn btn-primary" name="bbtnGenerateAllInvoice" id="bbtnGenerateAllInvoice"><i class="icon-file-pdf position-left"></i>Generate All</button> -->
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


$('#li27').addClass('active');

function blockUILoading()
{
	$.blockUI({ 
            message: '<h5 class="text-semibold">Please wait...</h5>',
            timeout: 1000, //unblock after 5 seconds
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

$('.daterange-single').daterangepicker({ 
	singleDatePicker: true,
	//use if disable previos date
	// minDate: moment()

	isInvalidDate: function(date) {
	// Disable dates in the future
	return date.isAfter(moment());
}
});

//INVOICE
$('#btnGenerateInvoice').click(function(){

    var Icomp = $('#Icomp').val();
    var IRvendor = $('#Ivendor').val();
    // var Itransact = $('#Itransact').val();
    var referenceNO = $('#referenceNO').val();
    var IdateFrom = $('#IdateFrom').val();
    var IdateTo = $('#IdateTo').val();

    $.ajax({
        url: '<?php echo base_url(). "adjustmentDeductionInvoiceController/generateExcelReportsInvoice" ?>',
        type: 'POST',
        data: {
            company: Icomp,
            vendor: IRvendor,
            // transaction: Itransact,
            referenceNo: referenceNO,
            dateFrom: IdateFrom,
            dateTo: IdateTo
        },
        beforeSend: function(){
            blockUILoading();
        },
        dataType: 'JSON',
        success: function (response) {

            if(response.stats == 1)
            {
                alert(response.message);
            }

            else if (response.success) {
                // Trigger the download after success

                
                window.open('<?php echo base_url(). "adjustmentDeductionInvoiceController/downloadExcelFileInvoice" ?>');

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

//INVOICE ALL
$('#btnGenerateAllInvoice').click(function(){

    var IdateFrom = $('#IdateFrom').val();
    var IdateTo = $('#IdateTo').val();

    $.ajax({
        url: '<?php echo base_url(). "adjustmentDeductionInvoiceController/generateAllInvoice" ?>',
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

                window.open('<?php echo base_url(). "adjustmentDeductionInvoiceController/downloadExcelFileInvoiceAll" ?>');

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

$('#bbtnGenerateInvoice').click(function(){

    var Icomp = $('#IIcomp').val();
	var IdateFrom = $('#IIdateFrom').val();
	// var IdateTo = $('#IIdateTo').val();

	$.ajax({
        url: '<?php echo base_url(). "adjustmentDeductionInvoiceController/generateDailyReportInvoice_2" ?>',
        type: 'POST',
        data: {
            compCode: Icomp,
			dateFrom: IdateFrom,
			// dateTo: IdateTo
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

            else if (response.success)
            {
                // Trigger the download after success
      
                window.open('<?php echo base_url(). "adjustmentDeductionInvoiceController/downloadExcelFilesPOS" ?>');

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
            else {
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

$('#bbtnGenerateAllInvoice').click(function(){
    
    // var Icomp = $('#IIcomp').val();
	var IdateFrom = $('#IIdateFrom').val();
	// var IdateTo = $('#IIdateTo').val();

	$.ajax({
        url: '<?php echo base_url(). "adjustmentDeductionInvoiceController/generateExcelReportsAllPaidAmountInvoice" ?>',
        type: 'POST',
        data: {
            // compCode: Icomp,
			dateFrom: IdateFrom
			// dateTo: IdateTo
        },
        dataType: 'JSON',
        success: function (response) {

			if(response.stats == 1)
			{
				alert(response.message);
			}

            else if (response.success)
            {
                // Trigger the download after success
      
                window.open('<?php echo base_url(). "adjustmentDeductionInvoiceController/downloadAllExcelFilesInvoice" ?>');

                swal({
                title: "Success",
                text: "Successfully Generated!",
                type: "success",
                closeOnClickOutside: false
                });


            } 
            else {
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

$('#btnGenerateInvoicePDF').click(function(){

    var Icomp = $('#Icomp').val();
    var Ivendor = $('#Ivendor').val();
    var referenceNO = $('#referenceNO').val();
    var IdateFrom = $('#IdateFrom').val();
    var IdateTo = $('#IdateTo').val();

    // console.log(Icomp);
    // console.log(Ivendor);
    // console.log(IdateFrom);
    // console.log(IdateTo);

    $.ajax({
		url: '<?php echo base_url(). 'adjustmentDeductionInvoiceController/generatePdfInvoice_2' ?>',
		type: 'POST',
		data: {
            company: Icomp,
            vendor: Ivendor,
            reference_no: referenceNO,
            dateFrom: IdateFrom,
            dateTo: IdateTo
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

                // Hide UI blocking after a delay
                setTimeout(function() {
                    $.unblockUI();
                }, 1000); // Adjust the delay as needed

			
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
		url: '<?php echo base_url(). 'adjustmentDeductionInvoiceController/generatePdfInvoice' ?>',
		type: 'POST',
		data: {
			compCode: Pcomp,
			currency: Pcurrency,
			// dateFrom: PdateFrom,
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

$('#searchRFP').keypress(function() {

    var searchRFP = $(this).val().trim();

    if (searchRFP === '') {
        // Clear the select dropdown
        $('#searchResults').empty();
        return;
    }

    $.ajax({
        url: '<?php echo base_url() . 'adjustmentDeductionInvoiceController/searchRFPfromDB' ?>',
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

//EXCEL
$('#btnGenerateInvoiceRFP').click(function(){
    
    var searchRFP = $('#searchRFP').val();
    var IdateFromRFP = $('#IdateFromRFP').val();
    var IdateToRFP = $('#IdateToRFP').val();

    $.ajax({
        url: '<?php echo base_url(). "adjustmentDeductionInvoiceController/generateReportByRFPExcel" ?>',
        type: 'POST',
        data: {
            rfp: searchRFP,
            dateFrom: IdateFromRFP,
            dateTo: IdateToRFP
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

                
                window.open('<?php echo base_url(). "adjustmentDeductionInvoiceController/downloadExcelFileInvoiceRFP" ?>');

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

//PDF
$('#btnGenerateInvoicePDFRFP').click(function(){

    var searchRFP = $('#searchRFP').val();
    var IdateFromRFP = $('#IdateFromRFP').val();
    var IdateToRFP = $('#IdateToRFP').val();

    $.ajax({
		url: '<?php echo base_url(). 'adjustmentDeductionInvoiceController/generatePDFInvoiceByRfp' ?>',
		type: 'POST',
		data: {
            rfp: searchRFP,
            dateFrom: IdateFromRFP,
            dateTo: IdateToRFP,
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

        
            // Hide UI blocking after a delay
            setTimeout(function() {
                $.unblockUI();
            }, 1000); // Adjust the delay as needed
                
            }


	});
})




</script>