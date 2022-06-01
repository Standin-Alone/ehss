<head><title>Reports | EHSS</title></head>
<style>
.page-content {
font-family:"Century Gothic";
color: "219ebc";
},

.swal2-container {
  z-index: 10000;
}

</style>
<head><title>Reports | InfoSys</title></head>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title" style="font-family:Century Gothic">
			Reports <small>add new report</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li><a href="javascript:history.back();"><i class="btn-xl fa fa-arrow-circle-o-left"></i></a></li>
					<li>
						<i class="fa fa-home"></i>
						<a href="<?php echo base_url('addreport2');?>">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<i class="fa fa-bell"></i>
						<a href="#">Reports</a>
						<i class="fa fa-angle-right"></i>
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

      <!--<pre>
        <?=print_r($_SESSION);?>
      </pre>-->

      <!-- BEGIN LIST OF INCIDENTS TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-reorder font-red-sunglo"></i>
						<span class="caption-subject font-red-sunglo bold uppercase">LIST OF INCIDENT REPORTS</span>
					</div>
					<div class="actions">
						<?php if($this->session->userdata("ess_role") == "end-user") { // if ( !in_array($this->session->userdata("empid"), array(257) ) ) { ?>
							<a href="javascript:open_addRequest();" class="btn btn-success m-icon m-icon-only" style="padding: 8px 13px; margin: -5px -8px !important;">
								<i class="fa fa-plus"></i> New Report</a>
						<?php } ?>				
					</div>
					<div class="actions">
						<?php if($this->session->userdata("ess_role") == "end-user") { // if ( !in_array($this->session->userdata("empid"), array(257) ) ) { ?>
							<a href="javascript:open_addReport();" class="btn btn-success m-icon m-icon-only" style="padding: 8px 13px; margin: -5px -8px !important;">
								<i class="fa fa-plus"></i> Generic Form</a>
						<?php } ?>				
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-hover datatables" id="load-table" width="100%">
						<thead>
						
						</thead>
						<tbody>
							
						</tbody>
					</table>
					
				</div>
			</div>
			<!-- END LIST OF INCIDENTS TABLE PORTLET-->	

    </div>
	</div>
	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->

<!-- MODAL START -->
<style>
.modal-content{
font-family:"Century Gothic"
},

</style>
<style>
.modal-title{
font-family:"Century Gothic";
color:#219ebc;
/* font-weight: bold; */
},
</style>

<!-- Add New Report Modal -->
<div class="modal fade" id="addRequest" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form  method="post" id="addRequest_Form" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h3 class="modal-title"><span id="addRequest_Label">Create New Report</span></h3>				
			</div>
			<div class="modal-body">
				<div class="row">

					<div class="col-md-12 col-md-12">
						<div class="portlet box grey-cascade">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-bars"></i>Spill Incident Form
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-bordered">
									<tr>
										<td><label class="control-label">Date Created</label></td>
										<td>
											<div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar-o"></i></button>
												</span>
												<input type="text" id="initial_date" name="initial_date" class="form-control" required="required" readonly value="<?=Date('Y-m-d');?>">
											</div>	
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
										<td><label class="control-label">Time of Incident</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
												</span>
												<input type="text" class="form-control timepicker timepicker-no-seconds">
											</div>
										</td>
									</tr>
									<tr>
										<td><label class="control-label">Contact Number</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-phone"></i></button>
												</span>
												<input id="location" name="contactnumber" class="form-control input-circle" placeholder="enter contact number">
											</div>
										</td>
									</tr>
									<tr>
										<td><label class="control-label">Location</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-map-marker"></i></button>
												</span>
												<input id="location" name="location" class="form-control input-circle" placeholder="enter location">
											</div>
										</td>
									</tr>

									<tr>
										<td><label for="" class="control-label"> Is there any material spill?</label></td>
										<td>
											<!-- <div class="radio radio-css radio-inline">												
												<input type="radio" name="radio_css_inline" id="cssRadio1"/>
												<label for="cssRadio1">Yes</label>												
											</div>
											<div class="radio radio-css radio-inline">												
												<input type="radio" name="radio_css_inline" id="cssRadio2" checked />
												<label for="cssRadio2">No</label>												
											</div> -->
											<input type="checkbox" class="make-switch" data-on-text="Yes" data-off-text="No">
										</td>
									</tr>

									
									<tr>
										<td><label class="control-label">Material Spilled</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-tint"></i></button>
												</span>
												<input id="location" name="materialSpilled" class="form-control input-circle" placeholder="enter material spilled">
											</div>
										</td>
									</tr>
									<tr>
										<td><label class="control-label">Amount Spilled</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-building"></i></button>
												</span>
												<input id="location" name="amountSpilled" class="form-control input-circle" placeholder="enter amount spilled">
											</div>
										</td>
									</tr>
									<tr>
										<td><label class="control-label">Any injuries related to the Spill</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-plus-square"></i></button>
												</span>
												<input id="location" name="injuries" class="form-control input-circle" placeholder="enter any injuries related to the Spill">
											</div>
										</td>
									</tr>
									<tr>
										<td><label class="control-label">Details</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-file"></i></button>
												</span>
												<textarea id="description" name="description" class="form-control input-circle" placeholder="enter details"></textarea>
											</div>
										</td>
									</tr>
									<tr>
										<td><label class="control-label">Attachments</label></td>
										<td>
											<input class="form-control form-control-sm" type="file" name="attachment" id="attachment" multiple>
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
					<button type="submit"  class="btn blue"><i class="fa fa-save"></i> Save</button>
				</div>
			</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>

<!-- Generic Form Modal -->
<div class="modal fade" id="addReport" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form  method="post" id="addReport_Form" enctype="multipart/form-data">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h3 class="modal-title"><span id="addReport_Label">Create New Report</span></h3>				
			</div>
			<div class="modal-body">
				<div class="row">

					<div class="col-md-12 col-md-12">
						<div class="portlet box grey-cascade">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-bars"></i>Incident Information
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-bordered">
								
									<tr>
										<td><label class="control-label">Date ofDeployment</label></td>
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
										<td><label class="control-label">Time of Deployment</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
												</span>
												<input type="text" class="form-control timepicker timepicker-no-seconds">
											</div>
										</td>
									</tr>
									<tr>
										<td><label class="control-label">Person In-Charge at the Scene</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-users"></i></button>
												</span>
												<input id="location" name="contactnumber" class="form-control input-circle" placeholder="enter person in-charge">
											</div>
										</td>
									</tr>
									<tr>
										<td><label class="control-label">Nature of the Incident</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-bullhorn"></i></button>
												</span>
												<input id="location" name="location" class="form-control input-circle" placeholder="enter nature of incident">
											</div>
										</td>
									</tr>

									<tr>
										<td><label for="" class="control-label"> Clearance for Deployment made by</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-check-square-o"></i></button>
												</span>
												<input id="location" name="location" class="form-control input-circle" placeholder="enter clearance for deployment made by">
											</div>
										</td>
									</tr>
									<tr>
										<td><label class="control-label">Objective</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-tags"></i></button>
												</span>
												<input id="location" name="amountSpilled" class="form-control input-circle" placeholder="enter objective">
											</div>
										</td>
									</tr>
									<tr>
										<td><label class="control-label">Action Taken</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-file-text"></i></button>
												</span>
												<input id="location" name="injuries" class="form-control input-circle" placeholder="enter actions taken">
											</div>
										</td>
									</tr>
									<tr>
										<td><label class="control-label">Recommendation</label></td>
										<td>
											<div class="input-group">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-file"></i></button>
												</span>
												<textarea id="description" name="description" class="form-control input-circle" placeholder="enter recommendation"></textarea>
											</div>
										</td>
									</tr>
									<tr>
										<td><label class="control-label">Attachments</label></td>
										<td>
											<input class="form-control form-control-sm" type="file" name="attachment" id="attachment" multiple>
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
					<button type="submit"  class="btn blue"><i class="fa fa-save"></i> Save</button>
				</div>
			</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- ADD NEW REPORT MODAL ENDS -->



<!-- View Report Modal -->
<div class="modal fade" id="viewRequest" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="#" method="" id="viewRequest_Form" enctype="multipart/form-data">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"><span id="addRequest_Label">View Report</span></h4>				
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
									<!-- <tr>
										<td><label class="control-label">Date of Incident</label></td>
										<td>
											<div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
												<span class="input-group-btn">
													<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
												</span>
												<input type="text" id="target_date" name="target_date" class="form-control" required="required" value="<?=Date('Y-m-d');?>">
											</div>
										</td>
									</tr> -->
									<tr>
										<td><label class="control-label">Location</label></td>
										<td><input id="location" name="location" class="form-control input-circle" placeholder="enter location of incident"></td>
									</tr>
									<tr>
										<td><label class="control-label">Details</label></td>
										<td><textarea id="description" name="description" class="form-control input-circle" placeholder="enter details"></textarea></td>
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
					<!-- <button type="submit" id="saveBtn" class="btn blue"><i class="fa fa-save"></i> Save</button> -->
				</div>
			</div>
		</div>
		</form>

		
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- MODALS END -->

<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
function open_addRequest() {
	$("#addRequest").modal();
}
$(document).ready(function(){
	$('#load-table').DataTable({
		ajax:'<?php echo base_url();?>' + 'ehss/addreportv2/load_reports',
		responsive:true,	
		
		columns:[{data:'report_code',title:'Report Code'},
			
				{data:'report_date',title:'Date Created'},
				{data:'report_date',title:'Date of Incident'},
				{data:'location',title:'Location'},
				{data:'details',title:'Details'},
				{data:'reviewed_by_name',title:'Reviewed By'},
				{data:'verified_by_name',title:'Verified By'},
				
				{data:'status',title:'Status'},			
				{data:'report_id',title:'Action', render:function(data,type,row){
					return('<button class="btn btn-warning btn-block" data-toggle="modal" data-target="#viewRequest"><i class="fa fa-eye"/>View</button>')
		
				}},
				],
                order: [[ 5, "desc" ]]
			
	})
	
	$('#addRequest_Form').validate({
		rules:{description:{required:true},
				location:{required:true}
				},
		messages:{
			description:{required:"Please enter the full details"},
			initial_date:{required:"Please enter the date today"},
			
			location:{required:"Please enter the location"}
		},
		submitHandler:function(){
			Swal.fire({
						target: document.getElementById('addRequest'),
						title: 'Do you want to add this Report?',
						showDenyButton: true,						
						confirmButtonText: 'Save',
						denyButtonText: `Cancel`,
			}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				let fd = new FormData();

				fd.append('location',$("#addRequest_Form input[name=location]").val());			
				fd.append('description',$("#addRequest_Form textarea[name=description]").val());				
				fd.append('attachment',$("#addRequest_Form input[name=attachment]")[0].files[0]);
				
				$.ajax({
					url:'<?php echo base_url();?>' + 'ehss/addreportv2/insert_report',
					type:'post',
					contentType:false,
					processData:false,
					data:fd,
					success:function(response){
						
							Swal.fire({
								target: document.getElementById('addRequest'),
								icon: response.status == true ? 'success' : 'error',
								title: 	response.message,	
							}).then(()=>{
								$("#addRequest_Form")[0].reset();
								$("#addRequest").modal('hide');
								$("#load-table").DataTable().ajax.reload()
							})
						
						
											
					}
					
				})
				
			} else {
				Swal.fire({
								target: document.getElementById('addRequest'),
								icon: 'error',
								title: 	'Operation Cancelled!',
								
							})
			}
			})
			
			
		}
	})
	// $('#addReportForm').validate({

	// 	rules:{
	// 			description:{required:true},			
	// 			target_date:{required:true},
	// 			location:{required:true},
	// 			attachment:{required:true},
	// 			// contact:{required:true,phoneUS:true}
	// 		},
	// 	messages:{
			
		
	// 		target_date:{required:"Please enter the date of incident"},
	// 		location:{required:"Please enter the location"},
	// 		description:{required:"Please enter the full details"},
	// 		attachment:{required:"Please enter the upload a file",
	// 		// contact:{required:"Please enter the contact number",phoneUS:"Phone number must start with +639"}
	// 	},
	// 	submitHandler:function(){
	// 		// alert("Please input all required fields.")
	// 		let fd = new FormData();


	// 		fd.append('target_date',$("input[name=target_date]").val());
	// 		fd.append('location',$("input[name=location]").val());
	// 		fd.append('description',$("input[name=description]").val());
	// 		fd.append('attachment',$("input[name=attachment]")[0].file()[0]);


	// 		$.ajax({
	// 			url:'<?php echo base_url();?>' + 'ehss/addreport/insert_report',
	// 			type:'post',
	// 			data:fd,
	// 			success:function(response){

	// 				console.warn(response)
	// 			}
	// 		})
	// 	}
	// })
})

function open_addReport() {
	$("#addReport").modal();
}

</script>

