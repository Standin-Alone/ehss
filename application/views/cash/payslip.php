<head><title>ePayslip | InfoSys</title></head>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			ePayslip <small>print/email payslip</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li><a href="javascript:history.back();"><i class="btn-xl fa fa-arrow-circle-o-left"></i></a></li>
					<li>
						<i class="fa fa-home"></i>
						<a href="<?php echo base_url('dashboard');?>">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">ePayslip</a>
					</li>
				</ul>
				<div class="page-toolbar">
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						Export <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a onclick="gexportExcel('table')">Logs</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->

			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="col-md-12">
					<div class="note note-info">
						<h4 class="block">NOTE: </h4>
						<p>Work-From-Home days for January 2022 payslip are printed as LWP. LWP days which are classified as WFH were not deducted in the leave credits.</p>
					</div>
				</div>
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-reorder font-red-sunglo"></i>
						<span class="caption-subject font-red-sunglo bold uppercase">List of Payslip</span>
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered datatables" id="table" width="100%">
						<thead>
							<tr>
								<th>
									 Pay Date
								</th>
								<th>
									 Salary
								</th>
								<th>
									 Gross Salary
								</th>
								<th>
									 Deduction
								</th>
								<th>
									 Net Salary
								</th>
								<th width="100px"></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
<!-- END CONTAINER -->

<script language="JavaScript" type="text/javascript">
	console.log("<?php echo $this->session->userdata('empMail');?>")
function loadTables(){ 
	$.ajax
    ({ type:"POST",
       async: true,
       url:"<?php echo site_url('cash/eprint/view'); ?>",
       dataType: 'json',
       cache: false,
       success: function(data)
       {
			$('#table').dataTable().fnClearTable();
		    $('#table').dataTable().fnDraw();
		    $('#table').dataTable().fnDestroy();

		    $('#table').dataTable({
		        // "iDisplayLength": -1,
		        "aaData": data,
		        "iTotalRecords": data.length,
		        "iTotalDisplayRecords": data.length,
		        "iDisplayStart": 0,
		        "bStateSave": true,
	        	"aaSorting": [[0,'desc']],
				"aoColumns": [null,{'sType':'formatted-num'},{'sType':'formatted-num'},{'sType':'formatted-num'},{'sType':'formatted-num'},null] 
		    });
		    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
		    $('.dataTables_length select').addClass('form-control');
		 	// $("#table tfoot").html(data[1]);

       },
       error: function(data){}
    });
}

function sendPayslip1(id)
{
	$(".btnsendpay").attr('disabled', true);
	$.ajax
	({ type:"POST",
		async: true,
		url:"<?php echo site_url('cash/Eprint/sendPayslip1'); ?>",
		data:{id:id},
		dataType: 'json',
		cache: false,
		success: function(data)
		{
			if(data)
			{
				$(".btnsendpay").attr('disabled', false);
				toastr.success("Payslip successfully sent", "Success");
			}else{
				toastr.info("Payslip was not sent", "Info");
			}
		},
		error: function(data)
		{
			toastr.error('Please reload the page and try again.', 'Ooooophs! We encountered a problem') 
		}
	});
}

function openwin(mpayid)
{
	var URL = "https://admin.services.pnri.dost.gov.ph/payroll/Eprint/slip/"+mpayid+"/";
	var win = window.open(URL, 'Print Payslip','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,left=300,top=100, width=900,height=500');
}

$(document).ready(function(){
	loadTables();
})
</script>
