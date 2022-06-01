<head><title>Satisfactory Survey | InfoSys</title></head>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Satisfaction Survey <small>customer satisfactory survey</small>
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
						<a href="#">Satisfaction Survey</a>
					</li>
				</ul>
				<div class="page-toolbar">
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						Export <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a onclick="gexportExcel('table')">Table Logs</a></li>
							<li><a target=_blank href="<?php echo base_url('Survey/exportCSV');?>">Excel (csv)</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->

			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-reorder font-red-sunglo"></i>
						<span class="caption-subject font-red-sunglo bold uppercase">Survey Logs</span>
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered datatables" id="table">
						<thead>
						<tr>
							<th>
								 Datetime
							</th>
							<th>
								 Service
							</th>
							<th>
								 Customer
							</th>
							<th>
								 Company
							</th>
							<th>
								 Contact #
							</th>
							<th>
								 Survey
							</th>
							<th>
								 Comment
							</th>
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
function loadTables()
{
	$('#table').dataTable().fnClearTable();
    $('#table').dataTable().fnDraw();
    $('#table').dataTable().fnDestroy();

    $('#table').dataTable({
        "serverSide": true,
        "sAjaxSource": "<?php echo site_url('survey/loadLogs'); ?>",
        "deferLoading": 10,
        "aaSorting": [[0,'desc'],[1,'asc']]
    });
     $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
    $('.dataTables_length select').addClass('form-control');
}
$(document).ready(function(){
	loadTables();
})
</script>
