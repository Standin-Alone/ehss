<head><title>Leave | InfoSys</title></head>
<style type="text/css">
  .closer:hover,.lock:hover {
    color: green;
    font-weight: 600;
    cursor: pointer;
}
.btn-success {
  border: 1px solid;
  border-color: #51a351 #51a351 #387038;
}

.day{
  background: #5bef1e40;
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
#leaves_table td:last-child{
    padding-top: 0;
    padding-bottom: 0;
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
  text-align: left;
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

#leaves_table td:first-child{
    text-align: left;
    min-width: 200px;
    padding-left:1em !important;
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

#leaves_table tbody tr td:nth-child(6), #leaves_table tbody tr td:nth-child(1){
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

.datepicker table th{
  font-weight: 600!important;
}
.select2-container-multi .select2-choices{
      border: 1px solid #727272;
}
</style>
 <?php

                $month = date('m');
                $day = date('d');
                $year = date('Y');

                $today = $year . '-' . $month . '-' . $day;
                ?>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->

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

            <?php
            if (in_array(23, $this->session->userdata('uroles'))) {
                echo '<div class="portlet light bordered hrmo">
                      <div class="portlet-body form frmFilter">
                        <form action="#" class="form-horizontal">
                          <div class="row">
                            <div class="col-md-6"><br>
                              <div class="form-group">
                                <label class="control-label col-md-4 change-message">Employee</label>
                                <div class="col-md-8">
                                 <select id="employees_select" onchange="getLeaveDetails();"></select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6"></div>
                          </div>
                        </form>
                      </div>
                    </div>';
            }
            else{
              echo '<select id="employees_select" style="display:none"><option selected value="'. $this->session->userdata('id') .'">emp</option></select>';
            }

            ?>


            <!--<div class="note note-danger">
        				<h4 class="block">Monetization leave application bug.</h4>
                    <p>A bug has been found this morning where applications for monetization of leaves are not properly recorded. The issue has now been fixed and you can now use the system to apply for monetization.<br><br>Sorry for the inconvenience it has caused.</p>
            </div>-->
            <div class="row">
              <div class="portlet light bordered col-md-8" style="margin: auto;">
                  <div class="portlet-title">
                      <div class="caption">
                          <i class="fa fa-leaf font-red-sunglo"></i>
                          <span class="caption-subject font-red-sunglo  uppercase">Leave</span>
                          <span class="caption-helper">Leave applications</span>
                      </div>
                      <button class="btn btn-primary pull-right" data-toggle='modal' href='#Leave_modal' onclick="$('.edit').show(); $('.view').hide();; $('#leave_id').val('');"> Apply for a Leave</button>
                      <div class="actions hidden">
                          <a class="btn btn-danger btn-sm" data-toggle='modal' onclick="loadOR()" href='#Leave_modal'><i class="fa fa-file-text-o"></i> View by Receipts</a>
                      </div>
                  </div>
                  <div class="portlet-body form">


                      <div id="post_board" >
                        <table class="table" id="leaves_table" style="border: 1px solid #cecece;">
                          <thead>
                            <tr>
                              <!-- <th class="text-center"><input type="checkbox"></th> -->
                              <th>Leave</th>
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


              <div class="portlet light bordered col-md-4" id="cdiv" style="margin: auto;">

                  <h4 style="font-weight: 600;">LEAVE CREDITS <small style="position: absolute;top: 45px;left: 20px;color: #878787;" id="as_of"></small>
                    <form class="pull-right" target="_blank" method="post" action="<?php echo base_url('hr/Leave/printLeaveCard')?>" >
                    <select name="year">
                        <option value="2021">2021</option>
                        <option value="2022" selected>2022</option>
                    </select>
                    <input type="hidden" id="emp_id" name="emp_id" value="">
                  <button class="btn btn-sm btn-default" type="submit"><i class="fa fa-print"></i> Summary</button>
                </form>
                <?php
                  if (in_array(23, $this->session->userdata('uroles'))) {
                    echo '<button data-toggle="modal" class="btn btn-sm btn-default pull-right" href="#legacy_modal" onclick="getLegacyLdates();"><i class="fa fa-history"></i> Legacy leave</button>
                    <a href="#" onclick="resetCred();" style="position: absolute;top: 0;right: 5px;"><i class="fa fa-times" style=" color: red;"></i></a>';
                  }
                ?>


            </h4>
                <br>

                <div id="credits">

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
          <p class="caption-subject uppercase ptitle"><span>Apply for Leave</span> <a href="javascript:;" class="close font-white" data-dismiss="modal"></a></p>
        </div>

        <div class="portlet-body" id="leave-body">
          <input type="hidden" id="leave_id">
          <div class="row view">
                <div class="col-md-12">

                  <table border="1" class="table" style="width:55%; margin:auto;">
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


            <div class="row edit">
                <div class="col-md-12">
                  <div class="section" style="text-align:left">
                    <label class="form-control-label dtitle" style="text-align:left"><mark>Type of Leave </mark></label>
                    <select id="sleave_type" onchange="typeInput()">
                      <option value="0" selected disabled>Select Type</option>
                      <option value="monetize">Monetization of Leave</option>
                        <?php
                        foreach ($leave_types as $key) {
                          echo '<option value="'.$key->leave_type.'">'.$key->description.'</option>';
                          // code...
                        }?>
                    </select>
                    <input type="text" id="otherLeave" class="form-control" placeholder="Please Specify" style="display:none">
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="section" style="text-align:left">
                    <label class="form-control-label dtitle" style="text-align:left"><mark>Date of Filing </mark></label>
                    <input disabled id="date_filed" type="date" value="<?php echo $today; ?>">
                  </div>
                </div>

                <div class="col-md-12 dvVac">
                  <div class="section" style="text-align:left">
                    <label class="form-control-label dtitle" style="text-align:left"><input type="checkbox" id="vaccination"> <mark>Vaccination </mark></label>
                    
                  </div>
                </div>

                <div class="col-md-12" >
                  <div class="section" style="text-align:left">
                    <label class="form-control-label dtitle" style="text-align:left"><mark>Details of Leave</mark></label>
                    <span class="required" style="color:red; display:none;">This field is required. Please choose an option</span>
                    <div id="wlsp" style="display:none;">
                      <div class="form-group">
                        <label>
                          <input type="radio" name="where" id="where_local" value="local"> <span class="alt-inpt" on-text="Within Philippines" off-text="In Hospital (specify)"></span>
                        </label>
                          <input type="text" id="rwhere_local" class="form-control" maxlength="35" onfocus="$('#where_local').prop('checked', true);$.uniform.update();">
                      </div>
                      <div class="form-group">
                        <label>
                        <input type="radio" name="where"  id="where_abroad" value="abroad"> <span class="alt-inpt" on-text="Abroad (specify)" off-text="Out-Patient (specify)"></span>
                        </label>
                         <input type="text" id="rwhere_abroad" class="form-control" maxlength="35" onfocus="$('#where_abroad').prop('checked', true);$.uniform.update();">
                      </div>
                    </div>

                    <div id="fspecial_women" class="col-md-12" style="display:none">
                        <div class="form-group">
                          <label>Specify illness: </label>
                          <input type="text" id="where_remarks" class="form-control" maxlength="35">
                        </div>
                    </div>

                    <div id="fstudy_leave" style="display:none;">
                      <div class="form-group">
                        <label><input type="radio" name="study_purpose" value="masters">Completion of Master's Degree</label>
                      </div>
                      <div class="form-group">
                        <label><input type="radio" name="study_purpose" value="examination">BAR/Board Examination Review</label>
                      </div>

                      <div class="form-group">
                        <h5 class="form-control-label " style=" margin: auto; font-weight: 600; font-size: 10pt;"><mark>Official / Personal</mark></h5>
                      </div>

                      <div class="form-group">
                        <label><input type="radio" name="sponsor" value="scholar">PNRI Scholar</label>
                      </div>
                      <div class="form-group">
                        <label><input type="radio" name="sponsor" value="personal">Personal (will be deducted from Vacation Leave credits.)</label>
                      </div>
                    </div>

                    <hr>
                    <div class="non-monetize">
                      <label class="form-control-label" style="font-weight: 600">Commutation</label>
                      <div class="form-group">
                        <label><input type="radio" name="commutation" value="1"> Requested</label>
                        <label><input type="radio" name="commutation" value="0" checked=""> Not Requested</label>
                      </div>
                    </div>

                    <div class="non-monetize">
                      <label class="form-control-label" style="font-weight: 600">Dates <span id="selectfirst" class="text-danger">Select leave type first!</span></label> <br>
                       <div class="input-group date form-group col-md-6" id="datepicker">
                          <input type="text" class="form-control" id="Dates" name="Dates" placeholder="Select days" required style="font-size: 9pt;" />
                          <span class="input-group-addon"><i class="icon-calendar"></i><span class="count"></span></span>
                      </div>

                      <div class="halfdates">
                        <label>Halfdays: <small>(Select if there are halfadys in your leave)</small></label>
                        <select id="half_dates" multiple="multiple"></select>
                      </div>

                      <div id="fmaternity_leave" style="display:none; margin-bottom:2em">
                         From:
                        <input id="date_from" type="date" value="<?php echo $today; ?>" >
                        To:
                        <label class="form-control-label dtitle"><mark>To </mark></label>
                        <input id="date_to" type="date" value="<?php echo $today; ?>">
                      </div>

                    </div>
                    <div class="monetize" style="display: none; text-align: center;">
                      <label class="form-control-label" style="font-weight: 600">No. of Leave to Monetize (10 Maximum)</label> <br>
                      <input type="number" class="form-control" id="no_of_leave" name="no_of_leave" style="font-size: 9pt;width: 150px;text-align: right;padding: 0; margin: auto;" /><br>
                    </div>
                    <div class="non-monetize">
                        <label class="form-control-label" style="font-weight: 600">Recommendation</label>
                        <div class="form-group">
                          <label><input type="radio" name="recommendation" checked="" value="approve"> Approval</label>
                        </div>
                        <div class="form-group">
                          <label>
                              <input type="radio" id="recommendation_disapprove" name="recommendation" value="disapprove"> Disapproval due to:
                          </label>
                          <input type="text" id="rdisapprove" class="form-control" maxlength="35" onfocus="$('#recommendation_disapprove').prop('checked', true);$.uniform.update();">
                        </div>
                    </div>

                    <div style="text-align: right;">
                       <button class="btn btn-success" onclick="submitLeave()">Submit</button>
                    </div>

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


<!-- LEave /.modal -->
<div id="legacy_modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-body">
      <div class="portlet box">
        <div style="background: black;padding: 0.15em;">
          <p class="caption-subject uppercase ptitle"><span>Add Leave</span> <a href="javascript:;" class="close font-white" data-dismiss="modal"></a></p>
        </div>

        <div class="portlet-body" id="leave-body">
          <input type="hidden" id="leave_id">
          <div class="row view">
                <div class="col-md-12">

                  <table border="1" class="table table-bordered" style="width:55%; margin:auto;">

                  <tbody>
                    <tr>
                      <td>Employee:</td>
                      <td id="emp_name"></td></label>
                    </tr>
                    <tr>
                      <td>Leave Type:</td>
                      <td><label><input type="radio" name="legacy_type" value="vacation" checked> Vacation </label>
                          <label><input type="radio" name="legacy_type" value="sick"> Sick</label>
                    </tr>
                    <tr>
                      <td>w/Pay:</td>
                      <td><label><input type="radio" name="lwpay" value="1" checked> w/Pay </label>
                          <label><input type="radio" name="lwpay" value="sick"> w/o Pay</label>
                    </tr>

                    </tbody>
                  </table>

                <div class="col-md-12">
                    <div>
                      <label class="form-control-label" style="font-weight: 600">Dates</label> <br>
                       <div class="input-group date form-group" id="ldatepicker">
                          <input type="text" class="form-control" id="legacy_date" name="lDates" placeholder="Select days" required style="font-size: 9pt;" readonly/>
                          <span class="input-group-addon"><i class="icon-calendar"></i><span class="count"></span></span>
                      </div>
                      <button class="btn btn-success pull-right" onclick="submitLegLeave()">Save</button>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <br>


                    <table border="1" class="table table-bordered" id="Lleaves" width="100%" style=" margin:auto;width:100% !important;" >
                      <thead>
                      <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>With Pay</th>
                        <th>Half-day</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody ></tbody>
                    </table>
                </div>

                    <div style="text-align: right;">
                      <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Close</a>

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
    $('#half_dates').select2({'width':'100%'});
   <?php
      if (in_array(23, $this->session->userdata('uroles'))) {
        echo 'get_employees(0);';
      }
  ?>

    $("#sleave_type").select2({'width':'100%'});
    getLeaveDetails();
    $('#ldatepicker').datepicker({
          multidate: true,
          format: "mm/dd/yyyy",
          daysOfWeekHighlighted: [5,6],
          daysOfWeekDisabled: [0,6],
          language: 'en'
        });

    //leave_type($('#ltype'));
   /*$('#datepicker').datepicker({
        multidate: true,
        format: "mm/dd/yyyy",
        startDate: new Date(),
        daysOfWeekHighlighted: [5,6],
        daysOfWeekDisabled: [0,6],
        language: 'en'
    }).on('changeDate', function(e) {
        // `e` here contains the extra attributes
        $(this).find('.input-group-addon .count').text(' ' + e.dates.length);
    });*/

  });

  var base_url = '<?php echo base_url()?>';
  var ltype = 'Vacation';

  function typeInput(){
    $('#selectfirst').hide();
      $('#datepicker').val("").datepicker("update");
      $('#datepicker').datepicker('remove');

      $('#wlsp, #fspecial_women, #fstudy_leave, #fmaternity_leave').hide();
      let type = $('#sleave_type').val();

      if(type == 'maternity' || type == 'study'){
        $('#fmaternity_leave').show();
        $('#datepicker, .halfdates').hide();
      }
      else{
        $('#datepicker').show();
      }
      if(type == 'vacation' || type == 'special_leave'){
        $('#wlsp').show();
        $('.alt-inpt').each(function(){
              $(this).text($(this).attr('on-text'));
        });

        $('#datepicker').datepicker({
            multidate: true,
            format: "mm/dd/yyyy",
            startDate: 0,
            daysOfWeekHighlighted: [5,6],
            daysOfWeekDisabled: [0,6],
            language: 'en'
          }).on('changeDate',function(e){
            let m = e.date.getMonth() + 1;
            let d = e.date.getDate();
            let y = e.date.getFullYear();
            let text_date = (m +'/'+ ('0' + d).slice(-2) + '/'+y);
            let val_date = y +'-'+ m + '-'+('0' + d).slice(-2);
            $('#half_dates').append('<option value="'+val_date+'">'+ text_date+'</option>');
          });
        //$('#datepicker').datepicker(new_options);
      }
      else{
        $('#datepicker').datepicker({
          multidate: true,
          format: "mm/dd/yyyy",
          startDate: 0,
          daysOfWeekHighlighted: [5,6],
          daysOfWeekDisabled: [0,6],
          language: 'en'
        }).on('changeDate',function(e){
          let m = e.date.getMonth() + 1;
          let d = e.date.getDate();
          let y = e.date.getFullYear();
          let text_date = (m +'/'+ d + '/'+y);
          let val_date = (y +'-'+ m + '-'+d);
            $('#half_dates').append('<option value="'+val_date+'">'+ text_date+'</option>');
        });
      }
      
      $('#vaccination').prop('checked', false)
      $.uniform.update();
      $('.dvVac').hide();
      if(type == 'sick'){
        $('.dvVac').show();
        $('#wlsp').show();
        $('.alt-inpt').each(function(){
              $(this).text($(this).attr('off-text'));
        });
      }
      if(type == 'special_women'){
        $('#fspecial_women').show();
      }
      if(type == 'study'){
        $('#fstudy_leave').show();
      }

      if(type == 'monetize'){
        $('.monetize').show();
        $('.non-monetize').hide();
      }
      else if(type == 'terminal'){
        $('.monetize, .non-monetize').hide();
      }
      else{
        $('.monetize').hide();
        $('.non-monetize').show();
      }

      /*if(type == 'others'){
        $('#otherLeave').show();
      }
      else{
        $('#otherLeave').hide();
      }*/

      $('#Dates').val('');
      $('#datepicker').val("").datepicker("update");
  }

  function deleteLegacy(id){
    var r = confirm("Are you sure?");
    if (r == true) {
      $.ajax
       ({ type:"POST",
          async: true,
          url:"<?php echo site_url('hr/Leave/deleteLegacy'); ?>",
          data:{id:id},
          cache: false,
          success: function(){
           getLegacyLdates();
           toastr.success("Successfully deleted legacy leave application", "Success");
          }
       });
    }
  }
  function getLeaveDetails(){

    $('#emp_id').val($('#employees_select').val());
    getLeaves();
    getCredits();
  }

  function approveLeave(){

    let approvedDates = [];
    let wpay = [];
    let leave = $('#leave_id').val();

    if($('#leave_type').text() == 'maternity' || $('#leave_type').text() == 'study'){
       if($('#wpay').is(":checked")){
         wpay =1;
       }
       else{
         wpay = 0;
       };
    }
    else if($('#leave_type').text() == 'monetize'){
      wpay = $('#to_approve').val();
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

  function toggleClick(e){
    $(e).find('span').toggleClass('checked');
    var checkBoxes = $("input[type='checkbox']");
    checkBoxes.prop("checked", (checkBoxes.prop("checked")==true)?false:true);
  }


function get_employees(sel) {
  $.ajax ({  type:"POST", async: false, dataType: 'json', cache: false,
      url:"<?php echo base_url()?>hr/Leave/getEmployees",
      success: function(data) {
        $("#employees_select").html(data).select2({'width':'100%'});
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

        let where = '';
        /*if(d.leave_type == 'Sick'){
          purpose = (d.purpose == 'Others' && d.leave_type == 'Vacation'?'Others:'+d.purpose_remark:'Maternity');
          where = (d.purpose == 'local' && d.leave_type == 'Vacation'?'In Hospital:'+d.purpose_remark:'Out-Patient:' +d.purpose_remark);
        }
        else{
          purpose = (d.purpose == 'Others' && d.leave_type == 'Vacation'?'Others:'+d.purpose_remark:'To seek employment');
          where = (d.purpose == 'local' && d.leave_type == 'Vacation'?'Local:'+d.purpose_remark:'Abroad:' +d.purpose_remark);
        }

        $('#purpose').text(purpose);*/
        $('#where').text(d.where_remarks);
        $('#wd').html('<i>'+d.dates.length + ' Working days</i>');
        $('#leave_purpose').text(d.leave_type);

        let inclusiveDates ='<i class="finished">Check which days to approve</i>';
        if(myroles.includes("3") && d.status != 'Done'){

          if(d.leave_type == 'monetize'){
              inclusiveDates = 'Applied '+d.dates[0].to_monetize + ' leaves to monetize. <input type="number" id="to_approve" placeholder="to Approve"></label>';
          }
          else{
            inclusiveDates += '<table style="width:100%;">';
            $(d.dates).each(function(i,rs){
              inclusiveDates += '<tr>'+
                                  '<td><label style="width:100%"><input type="checkbox" name="inclusives[]" value="'+rs.id+'" checked> '+rs.md+'/'+rs.dd+'/'+rs.yd+'</label></td>'+
                                  '<td><label style="width:100%"><input type="checkbox" id="withPay'+rs.id+'" value="'+rs.id+'" checked> with Pay?</label></td>'+
                                '</tr>';
            });
            inclusiveDates += '</table>';
          }
        }
        else if(d.status == 'Done'){

            if(d.leave_type == 'monetize'){
              inclusiveDates = 'Applied '+d.dates[0].to_monetize + ' leaves to monetize. '+d.dates[0].to_monetize + ' Approved.</label>';
            }
            else{
              inclusiveDates += '<table style="width:100%;">';
              $(d.dates).each(function(i,rs){
                inclusiveDates += '<tr>'+
                                    '<td>'+(rs.status == 1?'<i class="dc-green fa fa-check"></i> ':'<i class="dc-red fa fa-times"></i> ') + rs.md+'/'+rs.dd+'/'+rs.yd+
                                          (rs.ishalf_day == 1? '(halfday)':'')+'</td>'+
                                    '<td>'+(rs.wpay == 1?'<i class="dc-green fa fa-check"></i> ':'<i class="dc-red fa fa-times"></i> ') + ' with pay?</td>'+
                                  '</tr>';
              });
              inclusiveDates += '</table>';
            }
        }
        else{
            $('.finished').hide();

            if(d.leave_type == 'monetize'){
              inclusiveDates = 'Applied '+d.dates[0].to_monetize + ' leaves to monetize. (not yet Approved).</label>';
            }
            else{
              $(d.dates).each(function(i,rs){
                inclusiveDates += '<p class="m0"><i class="dc-green fa fa-question"></i> '+rs.md+'/'+rs.dd+'/'+rs.yd+'</p>';
              });
            }
        }

        $('#inlusiveDates').html(inclusiveDates);
        if(d.leave_type == 'maternity' || d.leave_type == 'study'){
          $('#inlusiveDates').html(d.maternity_startf + ' - ' +d.maternity_endf + '  <label><input type="checkbox" id="wpay" checked > with Pay?</label>');
        }

        if(d.status == 'Done'){
          $('.finished').hide();
        }

       }
    });
}

function resetCred(){
  var r = confirm("Are you sure you want to reset record?");
  if (r == true) {
    $.ajax({ type:"POST",
      async: true,
      url:"<?php echo site_url('hr/Leave/resetCredits'); ?>",
      dataType: 'json',
      data:{emp: $('#employees_select').val()},
      cache: false,
      success: function(data){
        getCredits();
      }
    });
  }
}

function updateBal(id){

  let begin = $('#begin_'+id).val();
  let leave = $('#leave_'+id).val();
  let undertime = $('#undertime_'+id).val();
  $('#start_' +id).val((begin - leave) - undertime);
}
function getCredits(){
   $.ajax
    ({ type:"POST",
       async: true,
       url:"<?php echo site_url('hr/Leave/getLeaveCredits'); ?>",
       dataType: 'json',
       data:{emp: $('#employees_select').val()},
       cache: false,
       success: function(data){
        if(data == [] || data == null){
          if(myroles.includes("23")){
            let d = new Date();
            let month = d.getMonth()+1;
            let day = d.getDate();

            let output = ((''+month).length<2 ? '0' : '') + month + '/' +
                ((''+day).length<2 ? '0' : '') + day + '/' +d.getFullYear();

            $('#credits').html('<div class="row">'+
                                '<h4 style="margin-left:1em;font-weight:400;">Vacation Leave</h4>'+
                                '<div class="col-md-4"> <input onchange="updateBal(\'vlc\')" class="form-control" type="number" placeholder="Eearned" id="begin_vlc"></div>'+
                                '<div class="col-md-4"> <input onchange="updateBal(\'vlc\')" class="form-control" type="number" placeholder="Leave" id="leave_vlc"></div>'+
                                '<div class="col-md-4"> <input onchange="updateBal(\'vlc\')" class="form-control" type="number" placeholder="Undertime" id="undertime_vlc"></div>'+
                                '<div class="col-md-12" style="margin-top:1em; margin-bottom: 1em;"><input class="form-control" type="number" placeholder="Vacation Leave Balance" id="start_vlc"></div>'+
                              '</div>'+
                              '<div class="row">'+
                                '<h4 style="margin-left:1em;font-weight:400;">Sick Leave</h4>'+
                                '<div class="col-md-4"> <input onchange="updateBal(\'slc\')" class="form-control" type="number" placeholder="Eearned" id="begin_slc"></div>'+
                                '<div class="col-md-4"> <input onchange="updateBal(\'slc\')" class="form-control" type="number" placeholder="Leave" id="leave_slc"></div>'+
                                '<div class="col-md-4"> <input onchange="updateBal(\'slc\')" class="form-control" type="number" placeholder="Undertime" id="undertime_slc"></div>'+
                                '<div class="col-md-12" style="margin-top:1em; margin-bottom: 1em;"><input class="form-control" type="number" placeholder="Sick leave credits" id="start_slc"></div>'+
                              '</div>'+
              '<button class="btn btn-sm btn-default btn-success pull-right" onclick="saveStartCredits()"><i class="fa fa-save"></i> Save</button>Enter balance as of <input type="date" id="start_date" value="<?php echo $today; ?>">');
          }
          else{
            $('#credits').html('<h4>No data.</h4><h5 style="font-weight: 600;color: red;">Please wait for HR to register your total credits left before calculation begins.</h5>');
          }
        }
        else{
            let as_of = new Date(data.as_of_date);
            let month = as_of.getMonth()+1;
            let day = as_of.getDate();

          let output = ((''+month).length<2 ? '0' : '') + month + '/' +
              ((''+day).length<2 ? '0' : '') + day;


            $('#as_of').text(output+' - present');
            let equiday = data.ut.tomin * 0.002;
            let utc = (equiday * 0.04166).toFixed(3);
            let lwop = ((data.used.lwop + parseInt(data.legacy.legvlwop)) * 0.04166).toFixed(3);
            let wholevl = ((parseFloat(data.vacation_credits) + parseFloat(data.earned_vl)) - (parseFloat(data.used.approvedVL) + parseFloat(data.legacy.legvl)) - data.ut.utwpay - lwop).toFixed(3);

            let vls = ((wholevl - parseInt(data.monetized)) + '').split('.');


            let wholesl = ((parseFloat(data.sick_credits) + parseFloat(data.earned_sl)) - (parseFloat(data.used.approvedSL) + parseFloat(data.legacy.legsl))).toFixed(3);

            let sls = (wholesl + '').split('.');

            if(myroles.includes("23")){
           $('#credits').html('<div style="display: inline-flex; width: 100%;">'+
                              '<div class="dashcard" style="background: #cde9f9">'+
                                '<h1 class="dch1 dc-green">' +vls[0] + '<small style="font-size:13pt" class="dc-green">.'+ (vls[1] == undefined?'000':vls[1])+ '</small></h1>'+
                                '<a class="dca dc-green">VACATION</a>'+
                              '</div>'+
                              '<div class="dashcard" style="background: #ffe2e5">'+
                                '<h1 class="dch1 dc-red">' +sls[0] + '<small style="font-size:13pt" class="dc-red">.'+ (sls[1] == undefined?'000':sls[1])+ '</small></h1>'+
                                '<a class="dca dc-red">SICK</a>'+
                              '</div>'+
                            '</div>'+
                            '<table id="breakdown" style="width:100%;margin-top: 3em;font-size: 12pt;font-weight: 600;">'+
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
                                '<td colspan="3" style="padding-right:12px"><p style="margin:0;text-align:right;">Leave w/o Pay: '+(parseInt(data.used.lwop) + parseInt(data.legacy.legvlwop))+' day(s) x 0.04166 = '+ lwop +' in leave credits</p>'+
                                '</td>'+
                              '</tr>'+

                              '<tr>'+
                                '<td>Disapproved/Pending Leaves</td>'+
                                '<td class="text-center">'+data.used.pendingVL+'</td>'+
                                '<td class="text-center">'+data.used.pendingSL+'</td>'+
                              '</tr>'+
                              '<tr>'+
                                '<td>Approved Leaves</td>'+
                                '<td class="text-center" style="color: red;">'+(parseInt(data.used.approvedVL) + parseInt(data.legacy.legvl))+'</td>'+
                                '<td class="text-center" style="color: red;">'+(parseInt(data.used.approvedSL) + parseInt(data.legacy.legsl))+'</td>'+
                              '</tr>'+
                              '<tr>'+
                                '<td>Monetized Leaves</td>'+
                                '<td class="text-center" style="color: red;">'+(parseInt(data.monetized))+'</td>'+
                                '<td></td>'+
                              '</tr>'+
                            '</table>')
                          }
                          else{
                              $('#cdiv').hide()
                          }

        }

       },
       error: function(data){}
    });
}

function saveStartCredits(){
  let start_vlc = $('#start_vlc').val();
  let start_slc = $('#start_slc').val();
  let begin_vlc = $('#begin_vlc').val();
  let leave_vlc = $('#leave_vlc').val();
  let undertime_vlc = $('#undertime_vlc').val();
  let begin_slc = $('#begin_slc').val();
  let leave_slc = $('#leave_slc').val();
  let undertime_slc = $('#undertime_slc').val();
  let start_date = $('#start_date').val();

   $.ajax
    ({ type:"POST",
       async: true,
       url:"<?php echo site_url('hr/Leave/saveStartCredits'); ?>",
       dataType: 'json',
       data:{
         emp: $('#employees_select').val(),
         start_vlc:start_vlc,
         start_slc:start_slc,
         begin_vlc:begin_vlc,
         leave_vlc:leave_vlc,
         undertime_vlc:undertime_vlc,
         begin_slc:begin_slc,
         leave_slc:leave_slc,
         undertime_slc:undertime_slc,
         start_date:start_date
       },
       cache: false,
       success: function(data){
        getCredits();
       }
    });
}
 function getLegacyLdates(){

    $.ajax
    ({ type:"POST",
       async: false,
       url:"<?php echo site_url('hr/Leave/getLegLeaves'); ?>",
       dataType: 'json',
       data:{emp: $('#employees_select').val()},
       cache: false,
       success: function(d){
         $('#emp_name').text(d.employee.lastname + ', '+ d.employee.firstname + ' '+ d.employee.middlename);

        $('#Lleaves').dataTable().fnClearTable();
        $('#Lleaves').dataTable().fnDraw();
        $('#Lleaves').dataTable().fnDestroy();

        $('#Lleaves').dataTable({
            "aaData": d.leave,
            "iTotalRecords": d.leave.length,
            "iTotalDisplayRecords": d.leave.length,
            "iDisplayStart": 0,
        });

        $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
        $('.dataTables_length select').addClass('form-control');
/*

        $(d).each(function(i,rs){
           $('#Lleaves').append('<tr>'+
            '<td>'+rs.legacy_ldate+'</td>'+
            '<td>'+rs.type+'</td>'+
            '</tr>');
        });*/

       },
       error: function(data){}
    });
 }
 function getLeaves(){
    $.ajax
    ({ type:"POST",
       async: true,
       url:"<?php echo site_url('hr/Leave/getLeaves'); ?>",
       dataType: 'json',
       data:{emp: $('#employees_select').val()},
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
            "aaSorting": [[4,'desc']]
        });

        $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
        $('.dataTables_length select').addClass('form-control');

       },
       error: function(data){}
    });
    $('#calibration_transactions_filter input').attr('placeholder', 'Search Here...');
}


  function leave_type(ele){
    var new_options = {};

    let type;
    if($(ele).prop('checked')){
      $('.vacay').show();
      $('#leave-head').removeClass('red');
      type = 'on';
      ltype = 'Vacation';
      $('#datepicker').datepicker('remove');

      $('#datepicker').datepicker({
          multidate: true,
          format: "mm/dd/yyyy",
          startDate: new Date(),
          daysOfWeekHighlighted: [5,6],
          daysOfWeekDisabled: [0,6],
          language: 'en'
        });
      $('#datepicker').datepicker(new_options);
    }
    else {
      $('.vacay').hide();
      $('#leave-head').addClass('red');
      type = 'off';
      ltype = 'sick';
      $('#datepicker').datepicker('remove');
      $('#datepicker').datepicker({
          multidate: true,
          format: "mm/dd/yyyy",
          startDate: 0,
          daysOfWeekHighlighted: [5,6],
          daysOfWeekDisabled: [0,6],
          language: 'en'
        });
    }
    $('.alt-inpt').each(function(){
          $(this).text($(this).attr(type+'-text'));
      });

    $('#Dates').val('');
    $('#datepicker').val("").datepicker("update");
  }
  function edLeave(id){
    $('.inpt'+id).show();
    $('.sp'+id).hide();
    $('.action'+id).hide();
    $('.eaction'+id).show();
  }
  function updateLeave(id){
     let dates = $('#date'+id).val();
     let ltype = $('#ul' + id).val();
     let wpay = $('#wp' + id).val();
     let half = $('#hd' + id).val();
     $.ajax({
        url: base_url + 'hr/Leave/updateLegacy',
        data:{
          id:id,
          ltype:ltype,
          wpay:wpay,
          dates:dates,
          half:half
        },
        type: 'POST',
        async: false,
        success: function(d){
          getLegacyLdates();
        }
      });
  }

  function submitLegLeave(){
    var r = confirm("Are you sure?");
    if (r == true) {
     let dates = $('#legacy_date').val();
     let ltype = $('input[name="legacy_type"]:checked').val();
     let wpay = $('input[name="lwpay"]:checked').val();

     $.ajax({
        url: base_url + 'hr/Leave/submitLegLeave',
        data:{
          emp:$('#emp_id').val(),
          ltype:ltype,
          wpay:wpay,
          dates:dates
        },
        type: 'POST',
        async: false,
        success: function(d){
          //getLegacyLdates();
          //$('#legacy_date').val('');
          //getLeaveDetails();
        }
      });
   }
  }
  function submitLeave(){
    let type = $('#sleave_type').val();
    let purpose = '';//$('input[name="purpose"]:checked').val();

    let  commutation = $('input[name="commutation"]:checked').val();
    let dates = $('#Dates').val();
    let date_filed = $('#date_filed').val();
    let half_dates = $('#half_dates').val();
    let  recommendation = $('input[name="recommendation"]:checked').val();
    let emp = $('#employees_select').val();
    /*input = {};
    var fd = new FormData();*/


    let  where = "";
    let where_remarks = "";
    let date_from = $('#date_from').val();
    let date_to = $('#date_to').val();


    switch (type) {
      case 'vacation':
      case 'sick':
      case 'special_leave':
        where = $('input[name="where"]:checked').val();
        where_remarks = $('#rwhere_'+where).val() ? $('#rwhere_'+where).val() : '';
        where = (where == 'local'?'local':'abroad');
        break;
      case 'fspecial_women':
        where_remarks = $('#rwhere_'+where).val() ? $('#rwhere_'+where).val() : '';
        break;
      case 'study':
        where = $('input[name="study_purpose"]:checked').val();
        purpose = $('input[name="sponsor"]:checked').val();
        break;
      case 'others':
        purpose = $('#otherLeave').val();
        break;
      default:
    }

    let recommendation_remarks = (recommendation == 'disapprove'?$('#rdisapprove').val():'');

    if(purpose == 'Special Leave'){
      ltype = 'Special';
      purpose = $('#special_leave').val();
    }
    if(type  == 'monetize'){
     dates = $('#no_of_leave').val();

     if(dates > 10){
       return false;
     }
    }

    if(dates != '' || (date_from && date_to)){// || type == 'maternity' || type == 'monetize' || type == 'terminal'
      if(where != undefined){
          $.ajax({
              url: base_url + 'hr/Leave/submitLeave',
              data:{
                leaveid:$('#leave_id').val(),
                ltype:type,
                where:where,
                purpose:purpose,
                commutation:commutation,
                date_filed:date_filed,
                half_dates:half_dates,
                dates:dates,
                recommendation:recommendation,
                where_remarks:where_remarks,
                recommendation_remarks:recommendation_remarks,
                date_from:date_from,
                date_to:date_to,
                emp:emp,
                vaccination:$('#vaccination').is(":checked")?1:0
              },
              type: 'POST',
              async: false,
              success: function(d){
                  location.reload();
              }
            });
      }
      else{
        $('.required').show();
      }
    }
    else{
      alert('Enter dates');
    }
  }


+function ($) {
  'use strict';

  // TOGGLE PUBLIC CLASS DEFINITION
  // ==============================

  var Toggle = function (element, options) {

    Toggle.DEFAULTS.on = $(element).attr('ontext') != undefined?$(element).attr('ontext'): 'On'
    Toggle.DEFAULTS.off = $(element).attr('offtext') != undefined?$(element).attr('offtext'): 'Off'
    this.$element  = $(element)
    this.options   = $.extend({}, this.defaults(), options)
    this.render()
  }

  Toggle.VERSION  = '2.2.0'

  Toggle.DEFAULTS = {
    on: 'On',
    off: 'Off',
    onstyle: 'primary',
    offstyle: 'default',
    size: 'normal',
    style: '',
    width: null,
    height: null
  }

  Toggle.prototype.defaults = function() {
    return {
      on: this.$element.attr('data-on') || Toggle.DEFAULTS.on,
      off: this.$element.attr('data-off') || Toggle.DEFAULTS.off,
      onstyle: this.$element.attr('data-onstyle') || Toggle.DEFAULTS.onstyle,
      offstyle: this.$element.attr('data-offstyle') || Toggle.DEFAULTS.offstyle,
      size: this.$element.attr('data-size') || Toggle.DEFAULTS.size,
      style: this.$element.attr('data-style') || Toggle.DEFAULTS.style,
      width: this.$element.attr('data-width') || Toggle.DEFAULTS.width,
      height: this.$element.attr('data-height') || Toggle.DEFAULTS.height
    }
  }

  Toggle.prototype.render = function () {
    this._onstyle = 'btn-' + this.options.onstyle
    this._offstyle = 'btn-' + this.options.offstyle
    var size = this.options.size === 'large' ? 'btn-lg'
      : this.options.size === 'small' ? 'btn-sm'
      : this.options.size === 'mini' ? 'btn-xs'
      : ''
    var $toggleOn = $('<label class="btn">').html(this.options.on)
      .addClass(this._onstyle + ' ' + size)
    var $toggleOff = $('<label class="btn">').html(this.options.off)
      .addClass(this._offstyle + ' ' + size + ' active')
    var $toggleHandle = $('<span class="toggle-handle btn btn-default">')
      .addClass(size)
    var $toggleGroup = $('<div class="toggle-group">')
      .append($toggleOn, $toggleOff, $toggleHandle)
    var $toggle = $('<div class="toggle btn" data-toggle="toggle">')
      .addClass( this.$element.prop('checked') ? this._onstyle : this._offstyle+' off' )
      .addClass(size).addClass(this.options.style)

    this.$element.wrap($toggle)
    $.extend(this, {
      $toggle: this.$element.parent(),
      $toggleOn: $toggleOn,
      $toggleOff: $toggleOff,
      $toggleGroup: $toggleGroup
    })
    this.$toggle.append($toggleGroup)

    var width = this.options.width || Math.max($toggleOn.outerWidth(), $toggleOff.outerWidth())+($toggleHandle.outerWidth()/2)
    var height = this.options.height || Math.max($toggleOn.outerHeight(), $toggleOff.outerHeight())
    $toggleOn.addClass('toggle-on')
    $toggleOff.addClass('toggle-off')
    this.$toggle.css({ width: width, height: height })
    if (this.options.height) {
      $toggleOn.css('line-height', $toggleOn.height() + 'px')
      $toggleOff.css('line-height', $toggleOff.height() + 'px')
    }
    this.update(true)
    this.trigger(true)
  }

  Toggle.prototype.toggle = function () {
    if (this.$element.prop('checked')) this.off()
    else this.on()
  }

  Toggle.prototype.on = function (silent) {
    if (this.$element.prop('disabled')) return false
    this.$toggle.removeClass(this._offstyle + ' off').addClass(this._onstyle)
    this.$element.prop('checked', true)
    if (!silent) this.trigger()
  }

  Toggle.prototype.off = function (silent) {
    if (this.$element.prop('disabled')) return false
    this.$toggle.removeClass(this._onstyle).addClass(this._offstyle + ' off')
    this.$element.prop('checked', false)
    if (!silent) this.trigger()
  }

  Toggle.prototype.enable = function () {
    this.$toggle.removeAttr('disabled')
    this.$element.prop('disabled', false)
  }

  Toggle.prototype.disable = function () {
    this.$toggle.attr('disabled', 'disabled')
    this.$element.prop('disabled', true)
  }

  Toggle.prototype.update = function (silent) {
    if (this.$element.prop('disabled')) this.disable()
    else this.enable()
    if (this.$element.prop('checked')) this.on(silent)
    else this.off(silent)
  }

  Toggle.prototype.trigger = function (silent) {
    this.$element.off('change.bs.toggle')
    if (!silent) this.$element.change()
    this.$element.on('change.bs.toggle', $.proxy(function() {
      this.update()
    }, this))
  }

  Toggle.prototype.destroy = function() {
    this.$element.off('change.bs.toggle')
    this.$toggleGroup.remove()
    this.$element.removeData('bs.toggle')
    this.$element.unwrap()
  }

  // TOGGLE PLUGIN DEFINITION
  // ========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.toggle')
      var options = typeof option == 'object' && option

      if (!data) $this.data('bs.toggle', (data = new Toggle(this, options)))
      if (typeof option == 'string' && data[option]) data[option]()
    })
  }

  var old = $.fn.bootstrapToggle

  $.fn.bootstrapToggle             = Plugin
  $.fn.bootstrapToggle.Constructor = Toggle

  // TOGGLE NO CONFLICT
  // ==================

  $.fn.toggle.noConflict = function () {
    $.fn.bootstrapToggle = old
    return this
  }

  // TOGGLE DATA-API
  // ===============

  $(function() {
    $('input[type=checkbox][data-toggle^=toggle]').bootstrapToggle()
  })

  $(document).on('click.bs.toggle', 'div[data-toggle^=toggle]', function(e) {
    var $checkbox = $(this).find('input[type=checkbox]')
    $checkbox.bootstrapToggle('toggle')
    e.preventDefault()
  })

}(jQuery);
</script>
