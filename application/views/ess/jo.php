<head><title>Profile | ESS Job Order Request</title></head>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Job Order Request (Engineering Services)
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
						<i class="icon-drawer"></i>
						<a href="#">Job Order Request</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Engineering Services</a>
					</li>
				</ul>
				<div class="page-toolbar">
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<pre>
				<?=print_r($_SESSION);?>
			</pre>

			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-reorder font-red-sunglo"></i>
						<span class="caption-subject font-red-sunglo bold uppercase">List of Job Order Requests</span>
					</div>
					<div class="actions">
						<?php //146 preciosa ?>
						<?php if($this->session->userdata("ess_role") == "end-user") { // if ( !in_array($this->session->userdata("empid"), array(257) ) ) { ?>
						<a href="javascript:open_essjo();" class="btn btn-lg btn-primary" style="padding: 8px 13px; margin: -5px -8px !important;">New Job Order Request</a>
						<?php } ?>
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered datatables" id="table" width="100%">
						<thead>
							<tr>
								<th>Ticket No.</th>
								<th>Date Requested</th>
								<th>Requested by</th>
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
	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->


<!-- MODALS START -->

<!-- Create ESS Job Order Request Modal End -->
<div class="modal fade" id="addESSJO" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="#" method="" id="ESSJO_form" enctype="multipart/form-data">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><span id="ESSJO_Label">Create Job Order Request</span></h4>
				<input type="text" id="ESSJO_id" name="ESSJO_id" value="0">
			</div>
			<div class="modal-body">
				<div class="row">

					<div class="col-md-12 col-md-12">
						<div class="portlet box grey-cascade">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-bars"></i>Information
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
								</div>
							</div>
							<div class="portlet-body">

								<table class="table table-bordered">

									<tr>
										<td><label class="control-label">Date</label></td>
										<td>
												<input type="text" id="initial_date" name="initial_date" class="form-control" required="required" readonly value="<?=Date('Y-m-d');?>">
										</td>
									</tr>

									<tr>
										<td><label class="control-label">Target Date</label></td>
										<td>
											<div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" id="target_date" name="target_date" class="form-control" required="required" value="">
											</div>
										</td>
									</tr>

									<tr>
										<td><label class="control-label">Purpose</label></td>
										<td><textarea id="purpose" name="purpose" class="form-control input-circle" placeholder="Enter purpose"></textarea></td>
									</tr>

								<tr>
									<td><label class="control-label">Description of Work Requested</label></td>
									<td><textarea id="description" name="description" class="form-control input-circle" placeholder="Enter description"></textarea></td>
								</tr>

								<tr>
									<td><label class="control-label">Upload Files</label></td>
									<td>
										<input class="form-control form-control-sm" type="file" name="attachment[]" id="attachment" multiple>
									</td>
								</tr>

								</table>

							</div>
						</div>
					</div>

				</div>

			</div><!-- /modal-body -->
			<div class="modal-footer">
				<div class="btn-group btn-group-circle btn-group-solid pull-right" role="group">
					<button type="button" id="closeBtn" class="btn grey" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
					<button type="submit" id="saveBtn" class="btn blue"><i class="fa fa-save"></i> Save</button>
				</div>
			</div>
		</div>
		</form>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- Create ESS Job Order Request Modal End -->

<script type="text/javascript">
function open_essjo() {
	$("#addESSJO").modal();
}

function clear_essjo() {
	$("#ESSJO_form")[0].reset();
}

function load_essjo_table() {
	$('#table').dataTable().fnClearTable();
	$('#table').dataTable().fnDraw();
	$('#table').dataTable().fnDestroy();

	$('#table').dataTable({
			"aaSorting": [[ 0, "desc" ]],
			"serverSide"  : true,
			"sAjaxSource" : "<?=site_url('ess/jo/get_all_essjo'); ?>/",
			"deferLoading": 10,
			"bStateSave": true
	});
	$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
	$('.dataTables_length select').addClass('form-control');
}
</script>
<!-- Create ESS Job Order Request Scripts End -->

<!-- Open Status History Modal Start -->
<div class="modal fade" id="openStatusHistory" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><span id="openStatusHistory_Label"></span></h4>
			</div>
			<div class="modal-body">
				<div class="row">

					<div class="col-md-12 col-md-12">
						<div class="portlet box grey-cascade">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-bars"></i>Status History
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
								</div>
							</div>
							<div class="portlet-body">

								<table class="table table-bordered" id="statusHistory_tbl" width="100%">
									<thead>
										<tr>
											<th>Status</th>
											<th>Date/Time</th>
											<th>Name</th>
											<th>Comments</th>
										</tr>
									</thead>
								</table>

							</div>
						</div>
					</div>

				</div>

			</div><!-- /modal-body -->
			<div class="modal-footer">
				<div class="btn-group btn-group-circle btn-group-solid pull-right" role="group">
					<button type="button" class="btn grey" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- Open Status History Modal End -->

<!-- Open Status History Scripts Start -->
<script type="text/javascript">
function open_status_history_modal(oshm_id) {
	$("#openStatusHistory").modal();
	// $("#openStatusHistory_Label").val();

	$('#statusHistory_tbl').dataTable().fnClearTable();
	$('#statusHistory_tbl').dataTable().fnDraw();
	$('#statusHistory_tbl').dataTable().fnDestroy();

	$('#statusHistory_tbl').dataTable({
			"aaSorting": [[ 0, "desc" ]],
			"serverSide"  : true,
			"sAjaxSource" : "<?=site_url('ess/jo/get_status_history_modal/');?>" + oshm_id,
			"deferLoading": 10,
			"bSort": false,
			"bPaginate": false
	});
	$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');

}
</script>
<!-- Open Status History Scripts End -->

<!-- View/Approve ESS Job Order Request Modal Start -->
<div class="modal fade" id="viewapproveJO" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="#" method="" id="viewapproveJO_form" enctype="multipart/form-data">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><span id="viewapproveJO_Label">View Job Order Request</span></h4>
				<input type="text" id="viewapproveJO_id" name="viewapproveJO_id" value="0" style="display:none">
			</div>
			<div class="modal-body">
				<div class="row">

					<div class="col-md-12 col-md-12">
						<div class="portlet box grey-cascade">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-bars"></i>Information
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
								</div>
							</div>
							<div class="portlet-body">

								<table class="table table-bordered">

									<tr>
										<td><label class="control-label">Ticket Number</label></td>
										<td>
												<input type="text" id="view_ticket_number" name="ticket_number" class="form-control" required="required" readonly>
										</td>
									</tr>

									<tr>
										<td><label class="control-label">Date Requested</label></td>
										<td>
												<input type="text" id="view_initial_date" name="initial_date" class="form-control" required="required" readonly>
										</td>
									</tr>

									<tr>
										<td><label class="control-label">Target Date</label></td>
										<td>
												<input type="text" id="view_target_date" name="target_date" class="form-control" required="required" readonly>
										</td>
									</tr>

									<tr>
										<td><label class="control-label">Purpose</label></td>
										<td><textarea id="view_purpose" name="purpose" class="form-control" readonly></textarea></td>
									</tr>

								<tr>
									<td><label class="control-label">Description of Work Requested</label></td>
									<td><textarea id="view_description" name="description" class="form-control" readonly></textarea></td>
								</tr>

								<?php if ( in_array($this->session->userdata("empid"), array(420, 257, 125, 75, 178, 409) ) ) { ?>
								<tr>
									<td><label class="control-label">Input Comments/Reason:</label></td>
									<td><textarea id="view_input_comments" name="input_comments" class="form-control"></textarea></td>
								</tr>
								<?php } ?>

								<tr>
									<td><label class="control-label">Files</label></td>
									<td class="load_uploaded_file">
									</td>
								</tr>
								<script>
								function openInNewTab(url) {
									window.open(url, '_blank').focus();
								}
								</script>

								</table>

							</div>
						</div>
					</div>

				</div>

			</div><!-- /modal-body -->
			<div class="modal-footer">
				<div class="btn-group btn-group-circle btn-group-solid pull-right" role="group">
					<button type="button" class="btn grey" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
					<?php if ( in_array($this->session->userdata("empid"), array(420, 257, 125, 75, 178, 409) ) ) { ?>
					<button type="button" class="btn red-sunglo" data-dismiss="modal"><i class="fa fa-thumbs-down"></i> Cancel</button>
					<button type="button" class="btn green-meadow" data-dismiss="modal"><i class="fa fa-thumbs-up"></i> Approve</button>
					<?php } ?>
				</div>
			</div>
		</div>
		</form>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- View/Approve ESS Job Order Request Modal End -->

<!--  View/Approve ESS Job Order Request Scripts Start -->
<script type="text/javascript">
function open_jo(jo_id) {
	$("#viewapproveJO").modal();
	$("#viewapproveJO_id").val(jo_id);

	$.ajax({ type:"POST", async: true,
			url:"<?=base_url('ess/jo/view_selected_jo'); ?>",
			data: {jo_id: jo_id},
			success: function(data) {
				$("#view_ticket_number").val(data["reference_no"]);
				$("#view_initial_date").val(data["filled_date"]);
				$("#view_target_date").val(data["target_date"]);
				$("#view_purpose").val(data["purpose"]);
				$("#view_description").val(data["description"]);

				var the_uploads = ""; $(".load_uploaded_file").empty();
				for (let i = 0; i < data["uploads"].length; i++) {
					the_url = "<?=site_url("uploads/ess");?>/" + data["uploads"][i]["attachment"];
  				the_uploads += "<a href='" + the_url + "' target='_blank'>" + data["uploads"][i]["attachment"] + "</a> <br>";
				}
				$(".load_uploaded_file").append(the_uploads);

			},
			error: function(data) {
				$.pnotify({ title: "We encountered a problem!", type: "error",
					text: "Please reload the page and try again." });
			}
	 }); // ajax end

}
</script>
<!--  View/Approve ESS Job Order Request Scripts End -->

<!-- MODALS END -->

<!-- JQuery OnLoad -->
<script type="text/javascript">
$(function() {
	load_essjo_table();

	$('#ESSJO_form').on('submit', (function(e) {

    if($("#ESSJO_form").valid()) {
      e.preventDefault();

	    $.ajax({  type:"POST", async: true, contentType: false, cache: false, processData:false,
	        url:"<?=base_url('ess/jo/create_jo'); ?>",
	        data: new FormData(this),
	        success: function(data) {
	          if (data[0] == "Success") {
	            $.pnotify ({  title: "Success", type: "success",
	              text: "Job Order Request has been successfully Added." });
							$("#addESSJO").modal("hide"); clear_essjo(); load_essjo_table();
	          } else if (data[0] == "Error3") {
	            $.pnotify ({ title: "Nothing was added", type: "info",
	            text: "Error, couldnt find other employee information" });
	          } else {
							$.pnotify ({ title: "Nothing was added", type: "info",
							text: "Job Order was not added. Please check your inputs. If you are sure that you didn't caused the problem, please reload the page and try again." });
						}
	        },
	        error: function(data) {
	          $.pnotify({ title: "We encountered a problem!", type: "error",
	            text: "Please reload the page and try again." });
	        }
	     }); // ajax end

		} // if form is valid end
  }));

});
</script>
<!-- -->
