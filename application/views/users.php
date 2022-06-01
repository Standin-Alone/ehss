<head><title>Users | PNRI Payroll System (PPS)</title></head>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Users <small>security management</small>
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
						<i class="fa fa-cogs"></i>
						<a href="#">Configurations</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Users</a>
					</li>
				</ul>
				<div class="page-toolbar">
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						Export <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a onclick="gexportExcel('table')">Users</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->

			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-edit font-red-sunglo"></i>
						<span class="caption-subject font-red-sunglo bold uppercase">List of Users</span>
					</div>
					<div class="actions">
						<a id="btnAddLate" class="btn red btn-sm" data-toggle='modal' href='#memployee' onclick="$('#id').val('')">
						<i class="fa fa-plus"></i> New User</a>
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered datatables" id="table">
						<thead>
						<tr>
							<th>Username</th>
							<th>Employee</th>
							<!-- <th>Unit / Division</th> -->
							<th>Type</th>
							<th>Status</th>
							<th><center>Action</center></th>
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->

	<!-- END CONTENT -->

<script language="JavaScript" type="text/javascript">
function loadTables(){
	$('#table').dataTable().fnClearTable();
    $('#table').dataTable().fnDraw();
    $('#table').dataTable().fnDestroy();

    $('#table').dataTable({
        "serverSide": true,
        "sAjaxSource": "<?php echo site_url('users/read'); ?>",
        "deferLoading": 10
    });
    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
    $('.dataTables_length select').addClass('form-control');
}

function updateEmployee(){
	gclearme('#form_sample_2');
	var ftr = $("#ftremployee").find('option:selected');
	var emp = ftr.data('emp');
	$("#empID").val(emp.ID);
	$(".tdID").html(emp.EmpNo);
	$(".tdPos").html(emp.Pos);
	$(".tdLast").html(emp.Last);
	$(".tdSG").html(emp.SG + ' / ' + emp.SI);
	$(".tdFirst").html(emp.First);
	// $(".tdSI").html(emp.SI);
	$(".tdMiddle").html(emp.Middle);
	$(".tdSal").html(emp.rateF);
	$(".tdExt").html(emp.Ext);
	$(".tdStat").html(emp.Stat);
	getLoansIndiv()
	payslipcomputation()
}

$(document).ready(function()
{	
	loadTables();
	ggetEmployees(0)
	$('#form_sample_2').on('submit', (function(e)
    {
	    e.preventDefault();
    	if($("#form_sample_2").valid())
    	{
			$('#alertvalidation').hide();
			$('#infovalidation').hide();
			$('#processvalidation').show();
			var url, msg = '';
			if($("#userid").val()){
				url = "<?php echo site_url('admin/update'); ?>";
				msg = "updated";
			}
			else{
				url = "<?php echo site_url('admin/add'); ?>";
				msg = "added";
			}
			var uname = $("#username").val();
			var pword = '<?php echo rtrim(base64_encode(pack("H*",md5("'+uname+'"))),"="); ?>';
            $.ajax
            ({  type:"POST",
                async: true,
                url: url,
                data: {	tbl:"payroll_sbg.sys_user", col:"user_id", id:$("#userid").val(), 
                		udata:{ emp:$("#ftremployee").val(),
                				username:$("#username").val(),
                				user_stat:$("#user_stat").val(),
                				password:pword,
                				user_type:$("#typedes").val().split(";",2)[0],
                				typedes:$("#typedes").val().split(";",2)[1]}},
				dataType: 'json',
				cache: false,
                success: function(data)
                {
					$('#successvalidation').hide();
					$('#processvalidation').hide();
                	if(data){
            			toastr.success("User successfully "+msg, "Success");
            			loadTables()
            			$("#userid").val(data)
                	}
            		else
	            		toastr.info("User was not "+msg, "Info");
                },
                error: function(data)
                {
                	console.log(data)
                    toastr.error('Please reload the page and try again.', 'Ooooophs! We encountered a problem') 
                }
            })
		}
    }))
})
</script>

<!-- LOGOUT /.modal -->
<div id="memployee" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-body">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-equalizer font-red"></i>
						<span class="caption-subject font-red bold uppercase">User Form</span>
						<!-- <span class="caption-helper">some info...</span> -->
					</div>
				</div>
				<div class="portlet-body form">
					<form action="#" id="form_sample_2" class="form-horizontal" method="POST">
						<div class="form-body">
							<input type="hidden" name="userid" id="userid">
							<div class="form-group">
								<label class="control-label col-md-4">Employee <span class="required">
								* </span>
								</label>
								<div class="col-md-4">
									<select class="form-control select2me" id="ftremployee"></select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">Type <span class="required">
								* </span>
								</label>
								<div class="col-md-4">
									<select class="form-control select2me" id="typedes">
										<option value="2;Cashier">Cashier</option>
										<option value="3;Personnel">Personnel</option>
										<option value="4;Accounting">Accounting</option>
										<option value="5;Leaves">Leaves</option>
										<option value="6;MKLACC">MKLACC</option>
										<option value="7;RATA">RATA</option>
										<!-- <option value="1;Administrator">Administrator</option> -->
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">Username <span class="required">
								* </span>
								</label>
								<div class="col-md-4">
									<input type="text" class="form-control" id="username">
									<span class="help-block">default password will be the username</span>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">Username <span class="required">
								* </span>
								</label>
								<div class="col-md-4">
									<select class="form-control select2me" id="user_stat">
										<option value="1">Active</option>
										<option value="0">In-Active</option>
									</select>
								</div>
							</div>


						</div>						
						<div class="form-actions">
							<div class="row">
								<div class="col-md-4">
								</div>
								<div class="col-md-8">
									<button type="submit" class="btn green">Submit</button>
									<button type="reset" class="btn default" onclick="gclearme('#form_sample_2');" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- LOGOUT /.modal -->
