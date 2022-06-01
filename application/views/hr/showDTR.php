<head><title>Daily Time Record | InfoSys</title></head>
<style type="text/css">
    ol li {
        /*color: red!important;*/
    }
    .divabled
    {
        pointer-events: none;
        opacity: 0.7;
        background: #fafcfb;
    }
    @media screen {
      .divFooter * {
        display: none;
      }
    }

    @media print {
      body * {
        visibility: hidden;
      }
      #dtrbody * {
        visibility: visible;
        -webkit-print-color-adjust: exact;
      }
      #dtrbody {
        background-color: inherit !important;
        position: absolute;
        left: 0;
        top: 0;
      }
      /*.divFooter * {
        visibility: visible;
        position: absolute !important;
        bottom: 0 !important;
      }*/
    }

    #myBtn {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 99;
        border: none;
        outline: none;
        cursor: pointer;
    }

    /*#btnPrint {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 85px;
        z-index: 99;
        border: none;
        outline: none;
        cursor: pointer;
    }*/

    #myBtn:hover, #btnPrint:hover {
        /*background-color: #555;*/
    }

    .cssbdrAll {
        border: 2px solid black;
    }

    .cssbdrAlledit {
        border: 2px solid black;
        /*font: 2rem 'AmstelvarAlpha', sans-serif;*/
        font-size: 10px;
    }

</style>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
            DTR <!-- <small>security management</small> -->
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
                        <a href="#">DTR</a>
                    </li>
                </ul>
            </div>
            <!-- END PAGE HEADER-->

			<div class="note note-info">
				<h4 class="block">DTR Printing Guide</h4>
                <p>		* <b>Section Heads</b> shall be responsible for printing the DTRs of their Section personnel.
					<br>* <b>Section Heads</b> shall be responsible for printing their own DTRs to be approved by their respective Division Chiefs. 
					<br>* <b>Division Chiefs</b> shall be responsible for printing their own DTRs to be approved by the Deputy Director.
					<br>&nbsp;&nbsp;&nbsp;<a target="_blank" href="<?php echo base_url('assets/OON3_DTR.pdf');?>">Click to view Office Order No. 03 - Submission of Daily Time Records (DTR)</a>
				</p>
            </div>
			
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-equalizer font-red-sunglo"></i>
                        <span class="caption-subject font-red-sunglo  uppercase">Daily Time Record</span>
                        <span class="caption-helper">filter by date and employee or division</span>
                    </div>
                    <div class="actions hidden">
                        <a class="btn btn-danger btn-sm" data-toggle='modal' onclick="loadOR()" href='#mOR'><i class="fa fa-file-text-o"></i> View by Receipts</a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form id="ftrDTR" class="form-horizontal">
                        <!-- <div class="form-body"> -->
                        <div class="row">
                            <div class="col-md-9"><br>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Date</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2me" id="ftrDTRDates" name="ftrDTRDates"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Employee</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2me" id="ftrEmployee" name="ftrEmployee"></select>
                                    </div>
                                </div>
                                <div class="form-group dtradmin divchief sechead hidme revme">
                                    <label class="control-label col-md-4">Div/Sec</label>
                                    <div class="col-md-8">
                                        <select id="ftrDivision" name="ftrDivision" class="select2me form-control" data-placeholder="Choose Division" tabindex="1" required>
                                        </select>
                                    </div>
                                </div>
                                <div class=""><center>
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                        <button id="btnShow" type="button" class="btn btn-primary m-t-15 waves-effect" onclick="showDTR()">Show</button>
                                        <button id="btnEdit" type="button" class="btn btn-danger hidden dtradmin revme" onclick="editDTR()">Edit</button>
                                        <button id="btnPrint" type="button" class="btn btn-default hidden divchief sechead deputy revme" onclick="javascript:window.print()">Print</button>
                                    </div></center>
                                </div>
                            </div>
                            <div class="col-md-12 hidden"><br>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="btn-group">
                                            <a class="btn btn-default m-icon m-icon-only" id="btnPrev">
                                                <i class="m-icon-swapleft"></i> Prev
                                            </a>
                                            <a class="btn btn-default m-icon m-icon-only" id="btnNext">
                                                Next <i class="m-icon-swapright"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- </div> -->
                    </form>
                </div>
            </div>
            <!-- <div class="portlet light"> -->
                <div class="portlet-body form" id="dtrbody" name="dtrbody">
                </div>
                <div class="portlet-body divbtnEdit hidden">
                    <center>
                        <button id="btnUpdate" type="button" class="btn btn-success m-t-15 waves-effect" onclick="saveDTR()">Update DTR</button>
                        <button id="btnCancel" type="button" class="btn btn-danger m-t-15 waves-effect" onclick="editDTR()">Cancel</button>
                    </center>

                    Legend:<br>
                    <span class="bg-red label label-sm">  </span> - Invalid time format<br>
                    <span class="bg-green label label-sm">  </span> - Valid time format<br>
                    <br><br>
                </div>
            <!-- </div> -->
        </div>
    </div>
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->

                <!-- <div class="divFooter">
                    <table width="20%" border="2">
                        <tr>
                            <tr><td>Prepared by: <?php echo ($this->session->userdata('name'));?></td></tr>
                            <tr><td></td></tr>
                        </tr>
                    </table>
                </div> -->
<script type="text/javascript">
ggetEmployees(0)
ggetDTRDates()
function showDTR(){
    if($("#ftrEmployee").val()!="0")
        $(document).prop('title', $("#ftrDTRDates :selected").text() + '_' + $("#ftrEmployee :selected").text());
    else
        $(document).prop('title', $("#ftrDTRDates :selected").text() + ' ' + $("#ftrDivision :selected").text());
    allowArrowKeys = 1;
    $(".divbtnEdit").hide();
    $("div[name='dtrbody']").html("<center><span><img src='<?php echo base_url('assets/spinner.gif');?>'/> Please wait...</span></center>");
    $("#btnPrint").removeClass("hidden");
    var form = $("#ftrDTR").serialize();
    $.ajax
    ({  type:"GET",
        async: true,
        url:"<?php echo site_url('hr/dtr/show'); ?>",
        dataType: 'json',
        data: $("#ftrDTR").serialize(),
        success: function(data)
        {
            if(data[0]){
                $("div[name='dtrbody']").html(data[0]);
                $('.bdrAll tr').each(function() {
                    var $tds = $(this).find('td');
                    if($tds.length != 0) {
                        $tds.addClass('cssbdrAll');
                    }
                });
                $('#absences').html(data[1]);
                $('#presday').html(data[2]);
            }else
                $("div[name='dtrbody']").html("<center>No record.</center>");

            var aroles = ['9', '7', '34'];
            if (aroles.some(i => myroles.includes(i)))
                $("div[name='dtrbody']").attr('id','dtrbody')
            else
                $("div[name='dtrbody']").removeAttr('id');

        },
        error: function(data){}
    });
}

function editDTR(){
    allowArrowKeys = 0;
    $("#btnUpdate").hide();
    $("#btnCancel").hide();
    $("div[name='dtrbody']").html("<center><span><img src='<?php echo base_url('assets/spinner.gif');?>'/> Please wait...</span></center>");
    // $("#btnPrint").removeClass("hidden");
    var form = $("#ftrDTR").serialize();
    $.ajax
    ({  type:"GET",
        async: true,
        url:"<?php echo site_url('hr/dtr/edit'); ?>",
        dataType: 'json',
        data: $("#ftrDTR").serialize(),
        success: function(data)
        {
            if(data[0]){
                $("div[name='dtrbody']").html(data[0]);
                $('.bdrAll tr').each(function() {
                    var $tds = $(this).find('td');
                    if($tds.length != 0) {
                        $tds.addClass('cssbdrAlledit');
                    }
                });
                $('#absences').html(data[1]);
                $('#presday').html(data[2]);
                $(".divbtnEdit").removeClass('hidden').show();
            }else
                $("div[name='dtrbody']").html("<center>No record.</center>");

            $('td.tdTime').attr('contenteditable','true');
            $("td.tdTime").focusout(function() {
                if($(this).html())
                    $(this).attr("bgcolor", chkTime($(this).html(), $(this).data("otime")));
            }).mouseout(function() {
                if($(this).html())
                    $(this).attr("bgcolor", chkTime($(this).html(), $(this).data("otime")));
            });

            $("td.tdRem").focusout(function() {
                if($(this).html()!=$(this).data("oval")){
                    $(this).attr("bgcolor", "#35aa47");
                    $("#btnCancel").show();
                    $("#btnUpdate").show();
                }
                else
                    $(this).attr("bgcolor", "");
            }).mouseout(function() {
                if($(this).html()!=$(this).data("oval")){
                    $(this).attr("bgcolor", "#35aa47");
                    $("#btnCancel").show();
                    $("#btnUpdate").show();
                }
                else
                    $(this).attr("bgcolor", "");
            })/*.blur(function() {
                if($(this).html()!=$(this).data("oval"))
                    $(this).attr("bgcolor", "#35aa47");
                else
                    $(this).attr("bgcolor", "");
            });*/
            /**/
            // $(this).addClass("bg-lime");
        },
        error: function(data){}
    });
}

function chkTime(tm, otime){
    // var isValidTime = /^[0-1][0-9]:[0-5][0-9] ([AP]M)?$/.test(tm);
    // var isValidTime = /^\d{1,2}:\d{2} ([AP]M)?$/.test(tm);
    // var isValidTime = /^(0?[1-9]|1[0-2]):[0-5][0-9]$/.test(tm);
    var isValidTime = /((1[0-2]|0?[1-9]):([0-5][0-9]) ?([AaPp][Mm]))/.test(tm);
    if(isValidTime){
        if(tm == otime)
            return "";
        else{
            $("#btnCancel").show();
            $("#btnUpdate").show();
            return "#35aa47";
        }
    }

    $("#btnUpdate").hide();
    $("#btnCancel").show();
    return "#d84a38";
      
    // return (isValidTime ? (tm == otime ? "" : "#35aa47") : "#d84a38");
}

function saveDTR()
{
    // var tab = $('#ctab').val();
    var tddate = new Array();
    var tdamIn = new Array();
    var tdamOut = new Array();
    var tdpmIn = new Array();
    var tdpmOut = new Array();
    var tdotIn = new Array();
    var tdotOut = new Array();
    var tdrem = new Array();
    var tdamInId = new Array();
    var tdamOutId = new Array();
    var tdpmInId = new Array();
    var tdpmOutId = new Array();
    var tdotInId = new Array();
    var tdotOutId = new Array();
    var tdremId = new Array();
    var tdremDt = new Array();
    $(".tdi").each(function(q) {
        var rid = $(this).text();
        var ldate = $('.tdDate'+rid).text() + ' ';
        var otDate = $('.tdotOutDate'+rid).text() + ' ';
        if(rid){
            if($('.tdamIn'+rid).attr("bgcolor") == "#35aa47"){
                tdamIn.push($('.tdamIn'+rid).text() ? ldate + $('.tdamIn'+rid).text() : null);
                tdamInId.push($('.tdamIn'+rid).data('id') ? $('.tdamIn'+rid).data('id') : null);
            }
            if($('.tdamOut'+rid).attr("bgcolor") == "#35aa47"){
                tdamOut.push($('.tdamOut'+rid).text() ? ldate + $('.tdamOut'+rid).text() : null);
                tdamOutId.push($('.tdamOut'+rid).data('id') ? $('.tdamOut'+rid).data('id') : null);
            }
            if($('.tdpmIn'+rid).attr("bgcolor") == "#35aa47"){
                tdpmIn.push($('.tdpmIn'+rid).text() ? ldate + $('.tdpmIn'+rid).text() : null);
                tdpmInId.push($('.tdpmIn'+rid).data('id') ? $('.tdpmIn'+rid).data('id') : null);
            }
            if($('.tdpmOut'+rid).attr("bgcolor") == "#35aa47"){
                tdpmOut.push($('.tdpmOut'+rid).text() ? ldate + $('.tdpmOut'+rid).text() : null);
                tdpmOutId.push($('.tdpmOut'+rid).data('id') ? $('.tdpmOut'+rid).data('id') : null);
            }
            if($('.tdotIn'+rid).attr("bgcolor") == "#35aa47"){
                tdotIn.push($('.tdotIn'+rid).text() ? ldate + $('.tdotIn'+rid).text() : null);
                tdotInId.push($('.tdotIn'+rid).data('id') ? $('.tdotIn'+rid).data('id') : null);
            }
            if($('.tdotOut'+rid).attr("bgcolor") == "#35aa47"){
                tdotOut.push($('.tdotOut'+rid).text() ? ldate + $('.tdotOut'+rid).text() : null);
                tdotOutId.push($('.tdotOut'+rid).data('id') ? $('.tdotOut'+rid).data('id') : null);
            }
            if($('.tdrem'+rid).attr("bgcolor") == "#35aa47"){
                tdrem.push($('.tdrem'+rid).text());
                tdremId.push($('.tdrem'+rid).data('id'));
                tdremDt.push($('.tdDate'+rid).text());
            }
        }

        /*var i = $(this).text();
        var ldate = $('.tdDate'+i).text() + ' ';
        var otDate = $('.tdotOutDate'+i).text() + ' ';
        
        logId.push($('.logId'+i).text());
        tdamIn.push(ldate + $('.tdamIn'+i).text());
        tdamOut.push(ldate + $('.tdamOut'+i).text());
        tdpmIn.push(ldate + $('.tdpmIn'+i).text());
        tdpmOut.push(ldate + $('.tdpmOut'+i).text());
        tdotIn.push(ldate + $('.tdotIn'+i).text());
        tdotOut.push(otDate + $('.tdotOut'+i).text());
        tdrem.push($('.tdrem'+i).text());*/
    });

    console.log(tdamIn)
    console.log(tdamOut)
    console.log(tdpmIn)
    console.log(tdpmOut)
    console.log(tdotIn)
    console.log(tdotOut)
    console.log(tdrem)

    $.ajax
    ({  type:"POST",
        async: true,
        url: "<?php echo site_url('hr/dtr/updateDTR'); ?>",
        data: { empno:$('#ftrEmployee').val(), amIn:tdamIn, amOut:tdamOut, pmIn:tdpmIn, pmOut:tdpmOut, otIn:tdotIn, otOut:tdotOut, rem:tdrem, amInId:tdamInId, amOutId:tdamOutId, pmInId:tdpmInId, pmOutId:tdpmOutId, otInId:tdotInId, otOutId:tdotOutId, remId:tdremId, remDt:tdremDt },
        dataType: 'json',
        cache: false,
        success: function(data)
        {
            if(data){
                toastr.success("DTR UPDATED", "SUCCESS");
            }
            else{
                if(data=="E1")
                    toastr.info("ERROR ON UPDATING LOGS. PLEASE RELOAD AND TRY AGAIN.", "FAILED");

                if(data=="E2")
                    toastr.info("ERROR ON UPDATING REMARKS. PLEASE RELOAD AND TRY AGAIN.", "FAILED");
            }
            editDTR()
        },
        error: function(data)
        {
            toastr.error('PLEASE RELOAD THE PAGE AND TRY AGAIN.', 'OOOOOPHS! WE ENCOUNTERED A PROBLEM') 
        }
    })
}

$('#ftrEmployee').on("change", function() {
    $('#ftrDivision').val($('#ftrDivision option:first').val())
    $('select').select2();
    $("#btnEdit").show();
});

$('#ftrDivision').on("change", function() {
    $('#ftrEmployee').val($('#ftrEmployee option:first').val())
    $('select').select2();
    $("#btnEdit").hide();
});

jQuery(function($) {
    $('select.form-select').select2();

    $('#btnNext').on("click", function() {
        if(allowArrowKeys){
            if(!$('#ftrEmployee option:selected').next().val())
                $('#ftrEmployee').val($('#ftrEmployee option:first').val())
            else
                $('#ftrEmployee option:selected').next().attr('selected', 'selected');
            $('select').select2();
            showDTR()
        }
    });

    $('#btnPrev').on("click", function() {
        if(allowArrowKeys){
            if(!$('#ftrEmployee option:selected').prev().val())
                $('#ftrEmployee').val($('#ftrEmployee option:last').val())
            else
                $('#ftrEmployee option:selected').prev().attr('selected', 'selected');
            $('select').select2();
            showDTR()
        }
    });
})

function updateEmployee(){}
</script>
