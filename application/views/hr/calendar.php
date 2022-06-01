<head><title>Calendar | InfoSys</title></head>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
            Calendar <small>Holidays and Suspensions</small>
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
                        <a href="#">Attendance</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Calendar</a>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->

            <div class="note note-info dtradmin hidme">
                <p>Click on the day to add.<br>Click on the event to edit. </p>
            </div>
            <div class="row ">
                <div class="portlet box blue-madison calendar">
                    <div class="portlet-title">
                        <!-- <div class="caption">
                            <i class="fa fa-calendar"></i>Calendar
                        </div> -->
                    </div>
                    <div class="portlet-body light-grey">
                        <div id="calendar">
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<div id="mHoliday" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> -->
                <h4 class="modal-title"><span><i class="icon-calendar"></i> Holidays and Suspension <b id="hDate"> July 2, 2020 </b></span></h4>
            </div>
            <div class="modal-body" align=center>
                <form id="form_standardH" class="form-horizontal" method="POST">
                    <table width="100%" border=0px>
                        <tr><td> <input type="hidden" name="hid" id="hid"/>
                        <tr><td> <input type="hidden" name="sdate" id="sdate"/>
                            <div class="form-group">
                                <label class="control-label col-md-2">Type <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-10">
                                    <select class="form-control select2me" id="holidays_ref_id">
                                        <option value="1">Regular Holiday</option>
                                        <option value="2">Special (Non-Working) Holiday</option>
                                    </select>
                                </div>
                            </div>
                        </tr>
                        <tr><td>
                            <div class="form-group">
                                <label class="control-label col-md-2">What <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" required="required" id="occasion"/>
                                    <span class="spnocassion error">This field is required.</span>
                                </div>
                            </div>
                        </tr>
                        <tr><td>
                            <div class="form-group">
                                <label class="control-label col-md-2">Repeats <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-10">
                                    <select class="form-control select2me" id="repeats">
                                        <option value="0">Does not repeat</option>
                                        <option value="1">Yearly</option>
                                    </select>
                                </div>
                            </div>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <div class="alert alert-info display-hide" id="ginfoH" >
                    <center><img src='<?php echo base_url('assets/global/img/spinner.gif');?>'/><strong> Heads up! </strong>Please wait while we process your request...</center>
                </div>
                <div id="gfootH">

                    <a class="btn red gbtndeleteH" onclick="gbtndeleteH()">
                    <i class="icon-trash"></i> Delete </a>

                    <a class="btn blue" class="btn default" data-dismiss="modal" onclick="gclearme('#form_standardH');$('#gsuccH').hide();$('#gdangerH').hide();">
                    <i class="icon-close"></i> Close </a>

                    <a class="btn green" onclick="gbtnsubmitH()">
                    <i class="icon-check"></i> Save </a>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>