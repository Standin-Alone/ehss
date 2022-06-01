<head><title>Employees | HR | InfoSys</title></head>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Employees <small>export employee report</small>
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
						<a href="#">Employees</a>
					</li>
				</ul>
				<div class="page-toolbar">
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						Export <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a target=_blank href="<?php echo base_url('Dashboard/printReport1');?>">PNRI Manpower</a></li>
							<li><a onclick="gexportExcel('table')">Employees</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->

			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
                    <div class="row">
                        <div style="display: inline" class="col-md-12 col-sm-12 col-xs-12">
                        Filter:&nbsp;&nbsp;
							<select id="ftrStat" class="select2me form-control input-medium" data-placeholder="Choose Status" tabindex="1">
								<option value="0" selected>All</option>
								<option value="1">Permanent</option>
								<option value="3">Project</option>
								<option value="4">Contractual</option>
								<option value="12">Resigned</option>
								<option value="11">Retired</option>
								<option value="20">Suspended</option>
								<option value="17">Transferred</option>
								<option value="18">Career Incentive Program</option>
								<option value="19">Balik Scientist</option>
							</select>&nbsp;
                            <select class="form-control select2me input-small" id="ftDivSec" ></select>&nbsp;
                            <select class="form-control select2me input-small" id="ftrGender" >
								<option value="0" selected>All</option>
								<option value="M">Male</option>
								<option value="F">Female</option>
							</select>&nbsp;
                        </div>
                        <!-- <div style="display: inline" class="col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label col-md-5">
                                Date Type:&nbsp;
								<select id="empStat" class="select2me form-control input-medium" data-placeholder="Choose Status" tabindex="1">
									<option value="1">Appointment</option>
									<option value="3">Project</option>
									<option value="4">Contractual</option>
									<option value="12">Resigned</option>
									<option value="11">Retired</option>
									<option value="20">Suspended</option>
									<option value="17">Transferred</option>
									<option value="18">Career Incentive Program</option>
									<option value="19">Balik Scientist</option>
								</select>&nbsp;&nbsp;
                            </label>
                            <div class="col-md-7">
                                <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                    <input type="text" class="form-control" name="soaFrom" id="soaFrom">
                                    <span class="input-group-addon">
                                    to </span>
                                    <input type="text" class="form-control" name="soaTo" id="soaTo">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="reset"><i class="fa fa-times"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div> -->
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-scrollable">
						<table class="table table-striped table-bordered table-hover datatables" width="100%" id="table">
					    <!-- <table class="table table-striped table-bordered datatables" id="table" width="100%"> -->
						<thead>
							<tr>
								<th>No.</th>
								<th>Name</th>
								<th>Position</th>
								<th>Div/Sec</th>
								<th>Plantilla</th>
								<th>App Date</th>
								<th>Assump Date</th>
								<th>Start Date</th>
								<th>Status</th>
								<th width="100px">Action</th>
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
function loadTables(){ 
	var ftrStat = $('#ftrStat').val();
	var ftDivSec = $('#ftDivSec').val();
	var ftrGender = $('#ftrGender').val();
	$.ajax
    ({ type:"POST",
       async: true,
       url:"<?php echo site_url('hr/employee/getList'); ?>",
	   data: {ftrStat:ftrStat, ftDivSec:ftDivSec, ftrGender:ftrGender},
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
	        	"aaSorting": [[0,'asc']],
				"aoColumns": [null,null,null,null,null,null,null,null,null,null] 
		    });
		    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
		    $('.dataTables_length select').addClass('form-control');
       },
       error: function(data){}
    });
}

function getDivSec() {
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,
      url:"<?=site_url('hr/employee/getDivSec');?>",
      success: function(data) {
			$("#ftDivSec").html(data);
			$('select').select2();
      },
      error: function(data){console.log("We encountered a problem!")}
	});
}

function openwin(mpayid)
{
	var URL = "<?php echo base_url();?>cash/Eprint/slip/"+mpayid+"/";
	var win = window.open(URL, 'Print Payslip','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,left=300,top=100, width=900,height=500');
}

$(document).ready(function(){
	loadTables();
	getDivSec()
	$(document).on('change','#ftrStat, #ftDivSec, #ftrGender',function(){
		loadTables()
	});
})
</script>
