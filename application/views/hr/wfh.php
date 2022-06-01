<head><title>WFH Reports | HR | InfoSys</title></head>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			WFH Reports <small>manage WFH reports</small>
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
						<a href="#">WFH Reports</a>
					</li>
				</ul>
				<div class="page-toolbar">
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						Export <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a onclick="gexportExcel('table')">WFH Reports</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<div class="note note-info">
				<h4 class="block">WFH Report Guide</h4> &nbsp;&nbsp;&nbsp;Submit your WFH Report online using the new WFH Report feature.
                	<p>	&nbsp;&nbsp;&nbsp;<a target="_blank" href="<?php echo base_url('assets/WFH Report (Staff).pdf');?>">Click to view WFH Report Guide</a>
				</p>
            </div>

			<!-- BEGIN EXAMPLE TABLE PORTLET-->
            <input id=wfhid class="hidden">
            <input id=dtval class="hidden">
			<div class="portlet light bordered">
				<div class="portlet-body">
					<div class=""><!-- table-scrollable -->
						<table class="table table-striped table-bordered table-hover datatables" width="100%" id="table">
					    <!-- <table class="table table-striped table-bordered datatables" id="table" width="100%"> -->
						<thead>
							<tr>
								<th>DTR</th>
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
			
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	</div>
<!-- END CONTAINER -->

<div id="mwfhReport" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> -->
				<h4 class="modal-title">WFH Report Form</h4>
			</div>
			<div class="modal-body">
				<label>Month: &nbsp;&nbsp;&nbsp;&nbsp;</label><span id="formonth"></span><br>
                <div class="form-group">
                    <label>WFH dates: &nbsp;&nbsp;&nbsp;&nbsp;</label> 
                    <input class="form-control" placeholder="1-2, 11, 30-31" id="fordates">
					<a onClick="showDTR()"><span class="help-block"><i class="fa fa-file-pdf-o"></i>&nbsp;click to view DTR</span></a>
                </div>
                <div class="form-group dvdes">
                    <label>Report: &nbsp;&nbsp;&nbsp;&nbsp;</label> 
                    <textarea class="form-control" rows="10" cols="100" id="des"></textarea>
					<span class="help-block">Input your WFH report here. Separate lists by ENTER key.</span>
                </div>
			</div>
			<div class="modal-footer">
				<div>
					<a class="btn green hidden" id="btnsubmitwfh" onclick="btnsubmitwfh()">
					<i class="icon-check"></i> Save </a>

					<a class="btn blue cpClose" class="btn default" data-dismiss="modal" onclick="$('#uFeedback').val('')">
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
function cancelSubmit(id){
	gdelete("wfh.report_history", "id", id);
}
function showDTR(){
	$('#mwfhDTR').modal('show');
    $.ajax
    ({  type:"GET",
        async: true,
        url:"<?php echo site_url('hr/dtr/show'); ?>",
        dataType: 'json',
        data: {ftrDTRDates:$("#dtval").val().substring(0, 7),ftrDivision:"0", ftrEmployee:"<?php echo $this->session->userdata('id');?>"},
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

$(document).on('keydown, keyup', '#mwfhReport', function() {
    if($("#des").val())// && ($("#des").val().length > 100)
        $("#btnsubmitwfh").removeClass('hidden');
    else
        $("#btnsubmitwfh").addClass('hidden');
});
function act(dt, dtval, act, id){
    $("#btnsubmitwfh").addClass('hidden');
    $("#formonth").text("")
    $("#des, #fordates").val("")
    $("#dtval").val(dtval)
	
	$("#formonth").text(dt)
	if(act == "Submit"){
		alert(1)
	}
    else{
		if(act == "Edit")
    		$("#btnsubmitwfh").removeClass('hidden');
		if(id)
		{
			$('#mwfhReport').modal('show');
			$("#wfhid").val(id)
			$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,
				url:"<?=site_url('hr/wfh/getReport');?>",
				data: {dt:dtval},
				success: function(data) {
					$("#formonth").val(data[0].formonth)
					$("#des").val(data[0].des)
					$("#fordates").val(data[0].fordts)
					$("#des").height($("#des").scrollHeight );
				},
				error: function(data){console.log("We encountered a problem!")}
			});
			if(act==1){//edit
				$('#mwfhReport').modal('show');
			}else if(act==2){//submit
			}
		}
		else 
		{
			$('#mwfhReport').modal('show');
		}
	}
}
function loadTables(){ 
	var ftrStat = $('#ftrStat').val();
	var ftDivSec = $('#ftDivSec').val();
	var ftrGender = $('#ftrGender').val();
	$.ajax
    ({ type:"POST",
       async: true,
       url:"<?php echo site_url('hr/wfh/getList'); ?>",
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
	        	"aaSorting": [[0,'desc']],
				"aoColumns": [null,null,null,null,null] 
		    });
		    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
		    $('.dataTables_length select').addClass('form-control');
       },
       error: function(data){}
    });
}

function submit(id, act){
	$.ajax
	({ type:"GET",
		async: true,
		url:"<?php echo site_url('hr/wfh/act'); ?>",
		data:{
			wfhid: id,
			status: act,
			remarks: ""
		},
		dataType: 'json',
		cache: false,
		success: function(data)
		{
			if(data){
				loadTables()
				toastr.success("Report Submitted", "Success");
			}
			else
				toastr.info("Report was not submitted", "Info");
		},
		error: function(data){}
	});
}

function btnsubmitwfh(){
    if($("#des").val())
    {
        $('.dvdes').removeClass("has-error error");
        $('.spnocassion').addClass("hidden");
        var hurl = "<?php echo site_url('common/add'); ?>";
        var a = "ADDED";
        if($("#wfhid").val()){
            hurl = "<?php echo site_url('common/update'); ?>";
            a = "UPDATED";
        }
        var hdata = {   formonth:$("#dtval").val(),
                        fordts:$("#fordates").val(),
                        des:$("#des").val(),
                        cby:<?php echo $this->session->userdata('id');?>
                    };
        aCall(a, "WFH REPORT", "wfh.report", "id", $("#wfhid").val(), hdata, hurl);
        $('#mwfhReport').modal('hide');
    }else
        $('.dvdes').addClass("has-error error");
}

$(document).ready(function(){
	loadTables();
})
</script>
