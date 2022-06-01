<head><title>WFH Submissions | HR | InfoSys</title></head>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			WFH Submissions <small>approve/reject WFH reports</small>
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
						<a href="#">WFH Submissions</a>
					</li>
				</ul>
				<div class="page-toolbar">
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						Export <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a onclick="gexportExcel('table')">WFH Submissions</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<div class="note note-info">
				<h4 class="block">WFH Report Guide</h4> &nbsp;&nbsp;&nbsp;Approve your staff’s WFH Report online using the new WFH Report feature.
                	<p>	&nbsp;&nbsp;&nbsp;<a target="_blank" href="<?php echo base_url('assets/WFH Report (Head).pdf');?>">Click to view WFH Report Guide</a>
				</p>
            </div>

			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
                    <div class="row">
                        <div style="display: inline" class="col-md-12 col-sm-12 col-xs-12">
                        Filter:&nbsp;&nbsp;
                            <select class="form-control select2me input-small" id="ftrDTRDates" >
							</select>&nbsp;
                        </div>
					</div>
				</div>
				<div class="portlet-body">
					<div class="">
						<table class="table table-striped table-bordered table-hover datatables" width="100%" id="table">
						<thead>
							<tr>
								<th>DTR</th>
								<th>Employee</th>
								<th>Description</th>
								<th>Status</th>
								<th>Date</th>
								<th style="width: 160px; min-width: 160px !important; max-width:165px !important">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<!-- END CONTAINER -->

<div id="mwfhReport" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> -->
				<h4 class="modal-title h4act"></h4>
			</div>
			<div class="modal-body">
                <input id=wfhid class=hidden>
                <input id=dtrDate class=hidden>
                <input id=ftrEmployee class=hidden>
                <input id=act class=hidden>
				<label>Date: &nbsp;&nbsp;&nbsp;&nbsp;</label><span id="formonth"></span> <br>
                <div class="form-group">
                    <label>WFH dates: &nbsp;&nbsp;&nbsp;&nbsp;</label> 
                    <input class="form-control" id="fordates" readonly>
					<a onClick="showDTR()"><span class="help-block"><i class="fa fa-file-pdf-o"></i>&nbsp;click to view DTR</span></a>
                </div>
                <div class="form-group dvdes">
                    <label>Report: &nbsp;&nbsp;&nbsp;&nbsp;</label> 
                    <textarea class="form-control" rows="10" cols="100" id="des" readonly></textarea>
                </div>
                <div class="form-group ">
                    <label class="lblReason">Please input reason to reject DTR/WFH Report:</label>
                    <textarea class="form-control" rows="5" cols="100" id="wfhRejectReason"></textarea>
                </div>
			</div>
			<div class="modal-footer">
				<div>
                    Do you really want to proceed?
                    <span class="dvReject">
                        <a class="btn red" onclick="submitWFH(0)">
                        <i class="fa fa-thumbs-down"></i> Reject </a>
                    </span>
                    <span class="dvApprove">
                        <a class="btn green" onclick="submitWFH(1)">
                        <i class="fa fa-thumbs-up"></i> Approve </a>
                    </span>

					<a class="btn grey cpClose" class="btn default" data-dismiss="modal">
					<i class="icon-close"></i> Cancel </a>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<div id="mwfhDTR" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-full">
		<div class="modal-content">
			<div class="modal-body" id="dtrbody">
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<script language="JavaScript" type="text/javascript">
getWFHDates()
function showDTR(){
	$('#mwfhDTR').modal('show');
    $.ajax
    ({  type:"GET",
        async: true,
        url:"<?php echo site_url('hr/dtr/show'); ?>",
        dataType: 'json',
        data: {ftrDTRDates:$("#dtrDate").val().substring(0, 7),ftrDivision:"0", ftrEmployee:$("#ftrEmployee").val()},
        success: function(data)
        {
            if(data[0]){
                $("#dtrbody").html(data[0]);
                $('#absences').html(data[1]);
                $('#presday').html(data[2]);
                $('.bdrAll tr').each(function() {
                    var $tds = $(this).find('td');
                    if($tds.length != 0) {
                        $tds.addClass('cssbdrAll');
                    }
                });
                $("#dtrbody").append('<center><a class="btn grey" data-dismiss="modal"><i class="icon-close"></i> Close </a></center>');
				$(".divFooter").addClass("hidden")
            }
        },
        error: function(data){}
    });
}

function getWFHDates() {
	$.ajax ({  type:"POST", async: true, dataType: 'json', cache: false,
      url:"<?=site_url('hr/wfh/getWFHDates');?>",
      success: function(data) {
		$("#ftrDTRDates").html(data);
        $('#ftrDTRDates option:eq(1)').attr('selected', 'selected');
		$('select').select2();
        
	    loadTables();
      },
      error: function(data){console.log("We encountered a problem!")}
  });
}

$(document).on('keydown, keyup', '#mwfhReport', function() {
	if( $("#act").val() == "Reject"){
		if($("#wfhRejectReason").val())
			$(".dvReject").removeClass('hidden');
		else
			$(".dvReject").addClass('hidden');
	}
});
function act(dtval, act, id){
    $("#wfhRejectReason").val("")
    $("#wfhid").val(id)
    $("#act").val(act)
    $("#dtrDate").val(dtval)
    $("#formonth").text(dtval)
	$('#mwfhReport').modal('show');
    $(".dvReject, .dvApprove").addClass("hidden")
    $.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,
        url:"<?=site_url('hr/wfh/getReportById');?>",
        data: {id:id},
        success: function(data) {
            $("#fordates").val(data[0].fordts)
            $("#des").val(data[0].des)
			$("#des").height( $("#des").scrollHeight );
    		$("#ftrEmployee").val(data[0].cby)
        },
        error: function(data){console.log("We encountered a problem!")}
    });
	if(act == "Approve"){
        $(".h4act").html("WFH Report Form - <span class='label label-success'>Approve</span>")
        $(".dvApprove").removeClass("hidden")
        $(".lblReason").text("Remarks on DTR/WFH Report:")
	}
	if(act == "Reject"){
        $(".h4act").html("WFH Report Form - <span class='label label-danger'>Reject</span>")
        $(".lblReason").text("Reason to reject DTR/WFH Report:")
	}
}

function loadTables(){
	var ftrDTRDates = $('#ftrDTRDates').val();
	$.ajax
    ({ type:"POST",
       async: true,
       url:"<?php echo site_url('hr/wfh/getSecList'); ?>",
	   data: {ftrDTRDates:ftrDTRDates},
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
				"aoColumns": [null,null,null,null,null,null] 
		    });
		    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
		    $('.dataTables_length select').addClass('form-control');
       },
       error: function(data){}
    });
}

function submitWFH(act){
    var udata;
    if(act){//approve
        udata = {
                    wfhid: $("#wfhid").val(),
                    status: "Approved",
                    remarks: $("#wfhRejectReason").val()
                };
        act = "approved.";
    }else{//reject
        udata = {
                    wfhid: $("#wfhid").val(),
                    status: "Rejected",
                    remarks: $("#wfhRejectReason").val()
                };
        act = "rejected.";
    }
    console.log(act)
    console.log(udata)
    $.ajax
    ({ type:"GET",
        async: true,
        url:"<?php echo site_url('hr/wfh/act'); ?>",
        data:udata,
        dataType: 'json',
        cache: false,
        success: function(data)
        {
            if(data[0]){
                loadTables()
                toastr.success("Report "+act, "Success");
            }
            else
                toastr.info("Report was not "+act, "Info");
	        $('#mwfhReport').modal('hide');
        },
        error: function(data){}
    });
}


$(document).ready(function(){
	$(document).on('change','#ftrDTRDates',function(){
		loadTables()
	});
})
</script>
