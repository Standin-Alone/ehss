<head><title>Profile | EHSS</title></head>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			EHSS Users
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
						<a href="#">EHSS Users</a>
						<i class="fa fa-angle-right"></i>
					</li>
				</ul>
				<div class="page-toolbar">
				</div>
			</div>
      <!-- Content Start -->

      <!--<pre>
        <?=print_r($_SESSION);?>
      </pre>-->

      <!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-reorder font-red-sunglo"></i>
						<span class="caption-subject font-red-sunglo bold uppercase">Users</span>
					</div>
					<div class="actions">
						<?php if($this->session->userdata("ess_role") == "end-user") { // if ( !in_array($this->session->userdata("empid"), array(257) ) ) { ?>
						<!--<a href="javascript:open_addRequest();" class="btn btn-lg btn-primary" style="padding: 8px 13px; margin: -5px -8px !important;">New Request</a>-->
						<?php } ?>
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered datatables" id="table" width="100%">
						<thead>
							<tr>
								<th>Reference Number</th>
								<th>Date Requested</th>
								<th>Requested by</th>
								<th>Request Type</th>
								<th>Description</th>
								<th>Status</th>
								<th width="100px">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>EHS-22-001</td>
								<td>April 4, 2022</td>
								<td>Juan Dela Cruz</td>
								<td>Emergency</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->

      <!-- Content End -->
    </div>
	</div>
	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->


<!-- MODALS START -->

<!-- Create ESS Job Order Request Modal End -->
<div class="modal fade" id="addRequest" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="#" method="" id="addRequest_Form" enctype="multipart/form-data">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><span id="addRequest_Label">Create New Request</span></h4>
				<input type="text" id="addRequest_id" name="addRequest_id" value="0">
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
										<td><label class="control-label">Date of Incident</label></td>
										<td>
											<div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" id="target_date" name="target_date" class="form-control" required="required" value="<?=Date('Y-m-d');?>">
											</div>
										</td>
									</tr>

									<tr>
										<td><label class="control-label">Location of Incident</label></td>
										<td><input id="location" name="location" class="form-control input-circle" placeholder="enter location of incident"></td>
									</tr>

									<tr>
										<td><label class="control-label">Enter Details</label></td>
										<td><textarea id="description" name="description" class="form-control input-circle" placeholder="enter details"></textarea></td>
									</tr>

									<tr>
										<td><label class="control-label">Contact Number</label></td>
										<td><input id="contact_number" name="contact_number" class="form-control input-circle" placeholder="enter mobile number"></td>
									</tr>

									<tr>
										<td><label class="control-label">Attachments</label></td>
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

<script type="text/javascript">
function open_addRequest() {
	$("#addRequest").modal();
}
</script>
<!-- Create ESS Job Order Request Modal End -->


<!-- MODALS END -->
