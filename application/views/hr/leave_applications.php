<head><title>Leave | InfoSys</title></head>
<style type="text/css">
  .closer:hover,.lock:hover {
    color: green;
    font-weight: 600;
    cursor: pointer;
}
.form-group{
  display: flex;
  width: 100%;
}
.form-group input{
  /*border:0;
  border-bottom:1px solid;*/
}
.form-group label{
  font-weight: 400;
  font-size: 14px;
  min-width: 200px;
  padding-top: 5px;
}
.checkbox label .toggle,
.checkbox-inline .toggle {
  margin-left: -20px;
  margin-right: 5px;
}
#leaves_table td:nth-child(2){
    text-align: left !important;
    min-width: 200px;
    padding-left:1em !important;
}
.toggle {
  position: relative;
  overflow: hidden;
}
.toggle input[type="checkbox"] {
  display: none;
}
.toggle-group {
  position: absolute;
  width: 200%;
  top: 0;
  bottom: 0;
  left: 0;
  transition: left 0.35s;
  -webkit-transition: left 0.35s;
  -moz-user-select: none;
  -webkit-user-select: none;
}
.toggle.off .toggle-group {
  left: -100%;
}
.toggle-on {
  position: absolute;
  font-weight: 600;
  top: 0;
  bottom: 0;
  left: 0;
  right: 50%;
  margin: 0;
  border: 0;
  border-radius: 0;
}
.toggle-off {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 50%;
  right: 0;
  background: #a8ddf5;
  margin: 0;
  border: 0;
  border-radius: 0;
  -webkit-box-shadow: inset 0 3px 5px rgba(0,0,0,.125);
    box-shadow: inset 0 3px 5px rgba(0,0,0,.125) !important;
}
.toggle-handle {
  position: relative;
  background: white;
  margin: 4px auto;
  padding-top: 0px;
  padding-bottom: 0px;
  height: 80%;
  width: 0px;
  border-width: 0 1px;
}

.toggle.btn { min-width: 159px; min-height: 34px;    margin: auto; }
.toggle-on.btn { padding-right: 24px; }
.toggle-off.btn { padding-left: 24px; background: #89374a;
    font-weight: 700;
    color: white;}

.toggle.btn-lg { min-width: 79px; min-height: 45px; }
.toggle-on.btn-lg { padding-right: 31px; }
.toggle-off.btn-lg { padding-left: 31px; }
.toggle-handle.btn-lg { width: 40px; }

.toggle.btn-sm { min-width: 50px; min-height: 30px;}
.toggle-on.btn-sm { padding-right: 20px; }
.toggle-off.btn-sm { padding-left: 20px; }

.toggle.btn-xs { min-width: 35px; min-height: 22px;}
.toggle-on.btn-xs { padding-right: 12px; }
.toggle-off.btn-xs { padding-left: 12px; }

mark, .mark {
    padding: .52em;
    background-color: #ffffff;
}
label.dtitle{
  font-weight: 600;
  position: absolute;
  top: -11px;
  padding: 0 1em;
  left: 0;
  width: 100%;
  margin: auto;
  text-align: center;
}
.section{
  padding: 2em;
  margin-top: 2em;
  padding-bottom: 0;
  border-radius: 10px !important;
  position: relative;
  font-size: 11pt;
}
.red{
  background-color: #89374a !important;
}

.form-control {
    border: 1px solid #838383;
}



#leaves_table tbody  tr{
  height: 52px;
}

#leaves_table thead  tr{
  height: 56px;
}

#leaves_table td, #leaves_table th{
  padding-left: 16px;
  padding-right: 16px;
  text-align: center;
}


#leaves_table .btn-default{
  color: #333333;
  background-color: white;
  border: 0;
  height: 52px;
  margin:0;
  transition: 0.25s background ease;
}

#leaves_table .btn-default:hover{
  background: #d2d2d2;
}
.m0{ margin: 0;}
.table>thead>tr>th {
    border-bottom: 1px solid #e3e3e3;
}
#leave-head{
  transition: background-color 0.5s ease;
  background-color: #428bca;
  padding: 0.5em;
}

tbody div.checker{
  width: 100%;
  height: 52px;
  padding-top: 10px;
  text-align: center;
}

#leaves_table tbody tr td:nth-child(7), #leaves_table tbody tr td:nth-child(1){
  padding: 0;
}

.ptitle{
  color: white;margin: 0;font-size: 14pt;margin-top: 0.5em; margin-left: 0.2em;
}

.dashcard{
  border-radius: 16.25px!important;  width: 166px; height: 126px;position: relative; margin:auto;
}
.Done{background:#4b7c51;}
.dca{
  font-weight: 600!important; font-size:14pt;text-decoration: none;cursor: pointer; position: absolute;bottom: 0.5em;width: 100%;text-align: center;
}
.dc-red{color:#f64e60; }
.dc-red:hover{color:#8a111e;text-decoration: none}
.dc-green{color:#005788;}
.dc-green:hover{color:#319cd8;text-decoration: none}
.dch1{font-size: 40pt;text-align: center;cursor: pointer;}
.sorting, .sorting_asc, .sorting_desc {
    background : none !important;
}
.Pending{background:#428bca;}

.btn-default > i {
    color: #3e3e3e;
}

#breakdown tr {
    height: 41px;
    border: 1px solid #e7e7e7;
    padding: 1em;
}
#breakdown td {
    padding-left: 10px;
}
</style>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!--<h5 class="dc-red">Only pending applications will appear here. You c</h5>-->
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
                        <a href="#">Leave</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->


            <div class="row">
              <div class="portlet light bordered col-md-12" style="margin: auto;">
                  <div class="portlet-title">
                      <div class="caption">
                          <i class="fa fa-leaf font-red-sunglo"></i>
                          <span class="caption-subject font-red-sunglo  uppercase">Leave</span>
                          <span class="caption-helper">Leave applications</span>
                      </div>

                  </div>
                  <div class="portlet-body form">


                      <div id="post_board" >
                        <table class="table" id="leaves_table" style="border: 1px solid #cecece;">
                          <thead>
                            <tr>
                              <!-- <th class="text-center"><input type="checkbox"></th> -->
                              <th>Name</th>
                              <th>Type</th>
                              <th>Date Filed</th>
                              <th>Inclusive Dates</th>
                              <th>Status</th>
                             <!--  <th>Route</th> -->
                              <th>Actions</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                  </div>
              </div>

            </div>

        </div>
    </div>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->

<!-- LEave /.modal -->
<div id="Leave_modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-body">
      <div class="portlet box">
        <div  id="leave-head">
          <p class="caption-subject uppercase ptitle">Leave Application <a href="javascript:;" class="close font-white" data-dismiss="modal"></a></p>
        </div>

        <div class="portlet-body" id="leave-body">
          <input type="hidden" id="leave_id">

          <div id="credits"></div>
          <div class="row view">
                <div class="col-md-12">

                  <table border="1" class="table" style="width:55%; margin:auto;border-color: #ffffff6e;">
                  <thead>
                    <tr>
                      <th colspan="2" style="text-align: center;">Leave Application</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Employee:</td>
                      <td id="employee"></td>
                    </tr>
                    <tr>
                      <td>Leave Type:</td>
                      <td id="leave_type"></td>
                    </tr>
                    <tr>
                      <td>Purpose:</td>
                      <td id="purpose"></td>
                    </tr>
                    <tr>
                      <td>Where:</td>
                      <td id="where"></td>
                    </tr>
                    <tr>
                      <td>Working Days:</td>
                      <td id="wd"></td>
                    </tr>
                    <tr>
                      <td>Inclusive Dates:</td>
                      <td id="inlusiveDates"></td>
                    </tr>
                    </tbody>
                  </table>
                </div>

                <div class="col-md-12">
                  <div style="text-align: right;">
                     <button class="btn btn-success finished" onclick="approveLeave()">Approve</button>
                  </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- monthly /.modal -->

<script type="text/javascript">
  $( document ).ready(function() {

    getLeaves();

  });

  var base_url = '<?php echo base_url()?>';
  var ltype = 'Vacation';


  function approveLeave(){

    let approvedDates = [];
    let wpay = [];
    let leave = $('#leave_id').val();

    if($('#leave_type').text() == 'maternity' || $('#leave_type').text() == 'maternity'){
       if($('#wpay').is(":checked")){
         wpay =1;
       }
       else{
         wpay = 0;
       };
    }
    else{
      $('input[name="inclusives[]"]:checked').each(function() {

          let id = this.value;
          approvedDates.push(id);
          if($('#withPay'+id).is(":checked")){
            wpay.push(1);
          }
          else{
            wpay.push(0);
          }

      });
    }

    $.ajax({ type:"POST",
       async: true,
       url:"<?php echo site_url('hr/Leave/approveDates'); ?>",
       dataType: 'json',
       type:'post',
       data:{id: leave, approvedDates: approvedDates, wpay:wpay},
       async:false,
       cache: false,
       success: function(d){
          viewLeave(leave);
          getLeaves()
          toastr.success("Successfully approved leave application", "Success");
          
       }
    });
  }

function viewLeave(id){

  $('#leave_id').val(id);
  $('.edit').hide(); $('.view').show();
  $.ajax({ type:"POST",
       async: true,
       url:"<?php echo site_url('hr/Leave/getLeave'); ?>",
       dataType: 'json',
       type:'post',
       data:{id: id},
       async:false,
       cache: false,
       success: function(d){
        $('#employee').text(d.employee.lastname + ', '+ d.employee.firstname +' ' + d.employee.middlename );
        $('#leave_type').text(d.leave_type);


        let purpose = '';
        let where = '';
        if(d.leave_type == 'Sick'){
          purpose = (d.purpose == 'Others' && d.leave_type == 'Vacation'?'Others:'+d.purpose_remark:'Maternity');
          where = (d.purpose == 'local' && d.leave_type == 'Vacation'?'In Hospital:'+d.purpose_remark:'Out-Patient:' +d.purpose_remark);
        }
        else{
          purpose = (d.purpose == 'Others' && d.leave_type == 'Vacation'?'Others:'+d.purpose_remark:'To seek employment');
          where = (d.purpose == 'local' && d.leave_type == 'Vacation'?'Local:'+d.purpose_remark:'Abroad:' +d.purpose_remark);
        }

        $('#purpose').text(purpose);
        $('#where').text(where);
        $('#wd').html('<i>'+d.dates.length + ' Working days</i>');
        $('#leave_purpose').text(d.leave_type);

        let inclusiveDates ='<i class="finished">Check which days to approve</i>';
        if(myroles.includes("3") && d.status != 'Done'){
           inclusiveDates += '<table style="width:100%;">';
            $(d.dates).each(function(i,rs){
              inclusiveDates += '<tr>'+
                                  '<td><label style="width:100%"><input type="checkbox" name="inclusives[]" value="'+rs.id+'" checked> '+rs.md+'/'+rs.dd+'/'+rs.yd+'</label></td>'+
                                  '<td><label style="width:100%"><input type="checkbox" id="withPay'+rs.id+'" value="'+rs.id+'" checked> with Pay?</label></td>'+
                                '</tr>';
            });
            inclusiveDates += '</table>';
        }
        else if(d.status == 'Done'){
            $(d.dates).each(function(i,rs){
              inclusiveDates += '<p class="m0">'+(rs.status == 1?'<i class="dc-green fa fa-check"></i> ':'<i class="dc-red fa fa-times"></i> ') + rs.md+'/'+rs.dd+'/'+rs.yd+'</p>';
            });
        }
        else{
            $(d.dates).each(function(i,rs){
              inclusiveDates += '<p class="m0"><i class="dc-green fa fa-question"></i> '+rs.md+'/'+rs.dd+'/'+rs.yd+'</p>';
            });
        }



        if(d.leave_type == 'maternity' || d.leave_type == 'study'){
          $('#inlusiveDates').html(d.maternity_startf + ' - ' +d.maternity_endf + '  <label><input type="checkbox" id="wpay" checked > with Pay?</label>');
        }
        else{
            $('#inlusiveDates').html(inclusiveDates);
        }
        if(d.status == 'Done'){
          $('.finished').hide();
        }

        getCredits(d.submit_by);

       }
    });
}

function getCredits(emp){
   $.ajax
    ({ type:"POST",
       async: true,
       url:"<?php echo site_url('hr/Leave/getLeaveCredits'); ?>",
       dataType: 'json',
       data:{emp: emp},
       cache: false,
       success: function(data){
        if(data == [] || data == null){
          if(myroles.includes("3")){
            let d = new Date();
            let month = d.getMonth()+1;
            let day = d.getDate();

            let output = ((''+month).length<2 ? '0' : '') + month + '/' +
                ((''+day).length<2 ? '0' : '') + day + '/' +d.getFullYear();


            $('#credits').html('<input class="form-control" type="number" placeholder="Vacation leave credits" id="start_vlc"><br><input class="form-control" type="number" placeholder="Sick leave credits" id="start_slc">'+
              '<br><button class="btn btn-sm btn-default btn-success pull-right" onclick="saveStartCredits()"> <i class="fa fa-save"></i> Save</button>As of '+ output) ;
          }
        }
        else{
            let as_of = new Date(data.as_of_date);
            let month = as_of.getMonth()+1;
            let day = as_of.getDate();

          let output = ((''+month).length<2 ? '0' : '') + month + '/' +
              ((''+day).length<2 ? '0' : '') + day;


            $('#as_of').text('('+output+' - present)');

            let equiday = data.ut.tomin * 0.002;
            let utc = (equiday * 0.04166).toFixed(3);
            let lwop = (data.used.lwop * 0.04166).toFixed(3);
            let wholevl = ((parseFloat(data.vacation_credits) + parseFloat(data.earned_vl)) - parseFloat(data.used.approvedVL) - data.ut.utwpay - lwop).toFixed(3);

            let vls = (wholevl + '').split('.');


            let wholesl = ((parseFloat(data.sick_credits) + parseFloat(data.earned_sl)) - parseFloat(data.used.approvedSL));
            let sls = (wholesl + '').split('.');
           $('#credits').html(

                            '<table id="breakdown" style="width:55%;margin:auto;margin-top: 3em;font-size: 10pt;font-weight: 600;">'+
                              '<tr>'+
                                '<td>Type</td>'+
                                '<td class="text-center">VL</td>'+
                                '<td class="text-center">SL</td>'+
                              '</tr>'+
                              '<tr>'+
                                '<td>Beginning of the Year 2021</td>'+
                                '<td class="text-center">'+data.vacation_credits +'</td>'+
                                '<td class="text-center">'+data.sick_credits +'</td>'+
                              '</tr>'+
                              '<tr style="color:green;">'+
                                '<td>Earned</td>'+
                                '<td class="text-center">'+data.earned_vl+'</td>'+
                                '<td class="text-center">'+data.earned_sl+'</td>'+
                              '</tr>'+

                              '<tr style="border-bottom: 0;height: 20px;">'+
                                '<td colspan="3" style="padding-right:12px"><p style="text-align:right">-'+utc+'</td>'+
                              '</tr>'+
                              '<tr style="font-size: 9pt;border-top: 0 !important;height: 20px;">'+
                                '<td colspan="3" style="padding-right:12px"><p style="margin:0;text-align:right;">Undertime: '+data.ut.tomin+' minutes x 0.002 = '+equiday+' in days x 0.04166 = ' + utc + '</p>'+
                                  '<p style="margin:0;text-align:right;">w/ pay ' + data.ut.utwpay+'</p>'+
                                  '<p style="margin:0;text-align:right;">w/o pay ' + data.ut.utwopay+'</p>'+
                                '</td>'+
                              '</tr>'+
                              '<tr style="border-bottom: 0;height: 20px;">'+
                                '<td colspan="3" style="padding-right:12px"><p style="text-align:right">-'+lwop+'</td>'+
                              '</tr>'+


                              '<tr style="font-size: 9pt;border-top: 0 !important;height: 20px;">'+
                                '<td colspan="3" style="padding-right:12px"><p style="margin:0;text-align:right;">Leave w/o Pay: '+data.used.lwop+' day(s) x 0.04166 = '+ lwop +' in leave credits</p>'+
                                '</td>'+
                              '</tr>'+


                              '<tr>'+
                                '<td>Disapproved/Pending Leaves</td>'+
                                '<td class="text-center">'+data.used.pendingVL+'</td>'+
                                '<td class="text-center">'+data.used.pendingSL+'</td>'+
                              '</tr>'+
                              '<tr>'+
                                '<td>Approved Leaves</td>'+
                                '<td class="text-center" style="color: red;">'+data.used.approvedVL+'</td>'+
                                '<td class="text-center" style="color: red;">'+data.used.approvedSL+'</td>'+
                              '</tr>'+
                              '<tr>'+
                                '<td>Available Leaves</td>'+
                                '<td class="text-center" style="color: blue;">'+wholevl+'</td>'+
                                '<td class="text-center" style="color: blue;">'+wholesl+'</td>'+
                              '</tr>'+
                            '</table>');

        }

       },
       error: function(data){}
    });
}

function saveStartCredits(){
  let start_vlc = $('#start_vlc').val();
  let start_slc = $('#start_slc').val();


   $.ajax
    ({ type:"POST",
       async: true,
       url:"<?php echo site_url('hr/Leave/saveStartCredits'); ?>",
       dataType: 'json',
       data:{
         emp: $('#employees_select').val(),
         start_vlc:start_vlc,
         start_slc:start_slc
       },
       cache: false,
       success: function(data){
        getCredits();
       }
    });
}

function signLeave(id){
  var txt;
  var r = confirm("Mark this leave as signed?");
  if (r == true) {
    txt = "You pressed OK!";
    $.ajax
    ({ type:"POST",
       async: false,
       url:"<?php echo site_url('hr/Leave/signLeave'); ?>",
       dataType: 'json',
       data:{id: id},
       cache: false,
       success: function(){
         location.reload();
         toastr.success("Successfully signed leave application", "Success");
       },
       error: function(data){}
    });
  }
}
 function getLeaves(){
    $.ajax
    ({ type:"POST",
       async: true,
       url:"<?php echo site_url('hr/Leave/getLeaves'); ?>",
       dataType: 'json',
       data:{emp: null},
       cache: false,
       success: function(data){
        $('#leaves_table').dataTable().fnClearTable();
        $('#leaves_table').dataTable().fnDraw();
        $('#leaves_table').dataTable().fnDestroy();

        $('#leaves_table').dataTable({
            "aaData": data,
            "iTotalRecords": data.length,
            "iTotalDisplayRecords": data.length,
            "iDisplayStart": 0,
            "bStateSave": true,
            "aaSorting": [[4,'desc']]
        });

        $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
        $('.dataTables_length select').addClass('form-control');

       },
       error: function(data){}
    });
    $('#calibration_transactions_filter input').attr('placeholder', 'Search Here...');
}




</script>
