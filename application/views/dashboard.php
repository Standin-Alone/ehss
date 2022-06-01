<head><title>Dashboard | PNRI Payroll System (PPS)</title></head>

	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">

			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Dashboard <small>dashboard & statistics</small>
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
						<a href="#">Dashboard</a>
					</li>
				</ul>
				<div class="page-toolbar">
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						<div id="txt"></div> <!-- <i class="fa fa-lc"></i> -->
						</button>

						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						<span id="spnYr"> </span><i class="fa fa-angle-downx"></i>
						</button>
						<!-- <ul class="dropdown-menu pull-right" role="menu" id="ddmenuyrs">
							<li>
								<a href="#">Action</a>
							</li>
						</ul> -->

					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN DASHBOARD STATS -->
			<div class="row">
				<!-- <div class="col-md-12">
					<div class="note note-info">
						<h4 class="block">NEW FEATURE: <a href="<?php echo base_url('survey');?>">Customer Satisfaction Survey Logs</a></h4>
						<p>
						Checkout the new <a href="<?php echo base_url('survey');?>">Satisfaction Survey</a> page where you can export survey logs . </a>
							.
						</p>
					</div>
				</div> -->
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								 <span id="lblfeed"></span>
							</div>
							
						</div>
						<a class="more" data-toggle="modal" href="#mfeeds" onClick="$('#uFeedback').focus()">New Feedbacks</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number">
								 <span id="lblallemp"></span>
							</div>
						</div>
						<a class="more" href="#">Total Employees</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="fa fa-user"></i>
						</div>
						<div class="details">
							<div class="number">
								 <span id="lblallreg"></span>
							</div>
						</div>
						<a class="more" href="#">Regular Employees</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number">
								 +<span id="lblnewemp"></span>
							</div>
						</div>
						<a class="more" href="#">New Employees</a>
					</div>
				</div>
			</div>
			<!-- END DASHBOARD STATS -->
			<div class="row">
				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
					<div id="gpAge" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
				</div>
				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<div id="gpGender" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
				</div>
			</div>
			<!-- <div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div id="totalReceipt" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				</div>
			</div>
			<div class="row"> 
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
				</div>
			</div> -->
			<div class="clearfix">
				<br><br>
			</div>
			<div class="row ">
				<div class="col-md-7 col-sm-7">
					<!-- BEGIN PORTLET-->
					<div class="portlet box blue-madison calendar">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-calendar"></i>
							</div>
						</div>
						<div class="portlet-body light-grey">
							<div id="calendar">
							</div>
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
				<div class="col-md-5 col-sm-5">
					<!-- BEGIN PORTLET-->
					<div class="portlet">
						<div class="portlet-title line">
							<div class="caption">
								<i class="fa fa-calendar"></i>Happy Birthday &#127881; &#127874; &#127880;
							</div>
							<!-- <div class="tools">
								<a href="" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="" class="reload">
								</a>
								<a href="" class="remove">
								</a>
							</div> -->
						</div>
						<div class="portlet-body" id="chats">
							<div class="scroller" style="height: 435px;" data-always-visible="1" data-rail-visible1="1">
								<ul class="chats" id="lstBday">
								</ul>
							</div>
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
			</div>

			<script>
				function gotosite(s){
					var URL = "<?php echo base_url();?>"+s;
					var win = window.open(URL);
				}
				function startTime() {
				    var today = new Date();
				    var h = today.getHours();
				    var m = today.getMinutes();
				    var s = today.getSeconds();
				    m = checkTime(m);
				    s = checkTime(s);
				    document.getElementById('txt').innerHTML = '<i class="fa fa-clock-o"></i> Time: ' + h + ":" + m + ":" + s ;
				    var t = setTimeout(startTime, 500);
				}
				function checkTime(i) {
				    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
				    return i;
				}
			</script>

			<body onload="startTime()">

			<!-- END DASHBOARD STATS// alert("<?php echo substr(today, 1,3);?>"); -->
			<!-- END DASHBOARD STATS -->

<script language="JavaScript" type="text/javascript">
jQuery(document).ready(function() {
	toastr.options = {
		"closeButton": true,
		"debug": false,
		"newestOnTop": true,
		"progressBar": true,
		"progressClass": "toast-progress",
		"positionClass": "toast-top-full-width",
		"showDuration": "1000",
		// "onclick": "<?php echo base_url('hr/wfh');?>",
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "8000",
		"extendedTimeOut": "1000",
		"showEasing": "easeOutBounce",
		"hideEasing": "easeInBack",
		"closeEasing ": "easeInBack",
		"showMethod": "slideDown",
		"hideMethod": "slideUp"
	}
	//ANNOUCEMENTS
    // toastr.info("Checkout the new WFH Report page", "NEW FEATURE: WFH Report");
	loadAll("<?php echo date('Y');?>");
	getToday()
	getThisMonth()
});
function loadAll(yr){
	loadPie(yr);
	loadPieAge(yr);
	getStats(yr);
	// loadPie(yr);
	// loadGraphReceiptMonthly(yr)
	// $('#spnYr').html(yr)
}

function loadGraph(yr)
{
    var ard_json = new Array(), nsd_json = new Array(), nrd_json = new Array(), tdd_json = new Array(), gas_json = new Array();   
    $.getJSON("<?php echo site_url('logs/sumIncome/" + yr + "'); ?>", function(data)
    {
        for (i = 0; i < data['ard'].length; i++){
            ard_json.push([data['ard'][i].key, data['ard'][i].value]);
            nsd_json.push([data['nsd'][i].key, data['nsd'][i].value]);
            nrd_json.push([data['nrd'][i].key, data['nrd'][i].value]);
            tdd_json.push([data['tdd'][i].key, data['tdd'][i].value]);
            gas_json.push([data['gas'][i].key, data['gas'][i].value]);
        }

        var sdate = "Year <?php echo date('Y'); ?>";
        if(yr != null){
        	sdate = "Year: "+yr;
        }
        //draw chart
        $('#totalPR').highcharts(
        {
        	chart: {
                type: "column"
            },
	        title: {
	            text: 'Net Salary'
	        },
	        subtitle: {
	            text: sdate
	        },
	        xAxis: {
	            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            	crosshair: true
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                text: 'Total Cost of Analysis'
	            }
	        },
	        tooltip: {
	            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
	            footerFormat: '</table>',
	            shared: true,
	            useHTML: true
	        },
	        plotOptions: {
	            column: {
	                borderWidth: 0
	            }
	        },
	        plotOptions: {
	            series: {
	                cursor: 'pointer',
	                point: {
	                    events: {
	                        click: function() {
	                            for (var i = 0; i < this.series.data.length; i++) {
	                                this.series.data[i].update({ color: '#ECB631' }, true, false);
	                            }
	                            this.update({ color: '#f00' }, true, false)
	                        }
	                    }
	                }
	            }
	        },
	        series: 
        	[
        		{
		            name: 'ARD',
		            data: ard_json
		        }, {
		            name: 'NSD',
		            data: nsd_json
		        }, {
		            name: 'NRD',
		            data: nrd_json
		        }, {
		            name: 'TDD',
		            data: tdd_json
		        }, {
		            name: 'GAS',
		            data: gas_json
		        }
		    ]
    	}); 
	});
}

function loadGraphReceiptMonthly(yr)
{
    var a_json = new Array(), b_json = new Array(), c_json = new Array(), d_json = new Array(), e_json = new Array(), f_json = new Array(), g_json = new Array();   
    $.getJSON("<?php echo site_url('logs/sumReceipt/" + yr + "'); ?>", function(data)
    {
        for (i = 0; i < data['a'].length; i++){
            a_json.push([data['a'][i].key, data['a'][i].value]);
            b_json.push([data['b'][i].key, data['b'][i].value]);
            c_json.push([data['c'][i].key, data['c'][i].value]);
            d_json.push([data['d'][i].key, data['d'][i].value]);
            e_json.push([data['e'][i].key, data['e'][i].value]);
            f_json.push([data['f'][i].key, data['f'][i].value]);
            g_json.push([data['g'][i].key, data['g'][i].value]);
        }

        var sdate = "Year <?php echo date('Y'); ?>";
        if(yr != null){
        	sdate = "Year: "+yr;
        }
        //draw chart
        $('#totalReceipt').highcharts(
        {
        	chart: {
                type: "column"
            },
	        title: {
	            text: 'Net Income'
	        },
	        subtitle: {
	            text: sdate
	        },
	        xAxis: {
	            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            	crosshair: true
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                text: 'Total'
	            }
	        },
	        tooltip: {
	            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
	            footerFormat: '</table>',
	            shared: true,
	            useHTML: true
	        },
	        plotOptions: {
	            column: {
	                borderWidth: 0
	            }
	        },
	        plotOptions: {
	            series: {
	                cursor: 'pointer',
	                point: {
	                    events: {
	                        click: function() {
	                            for (var i = 0; i < this.series.data.length; i++) {
	                                this.series.data[i].update({ color: '#ECB631' }, true, false);
	                            }
	                            this.update({ color: '#f00' }, true, false)
	                        }
	                    }
	                }
	            }
	        },
	        series: 
        	[
        		{
		            name: '101-I',
		            data: a_json
		        }, {
		            name: '101-R',
		            data: b_json
		        }, {
		            name: '184-R',
		            data: c_json
		        }, {
		            name: '184-MDS',
		            data: d_json
		        }, {
		            name: '184-UNDP',
		            data: e_json
		        }, {
		            name: '171',
		            data: f_json
		        }, {
		            name: 'PROV',
		            data: g_json
		        }
		    ]
    	}); 
	});
}

function loadPie(yr){
    $.getJSON("<?php echo site_url('logs/gpGender/" + yr + "'); ?>", function(data)
    {
    	var sum = parseInt(data['male']) + parseInt(data['female']);
    	console.log(sum)

		Highcharts.chart('gpGender', {
		    chart: {
		        plotBackgroundColor: null,
		        plotBorderWidth: null,
		        plotShadow: false,
		        type: 'pie'
		    },
		    title: {
		        text: 'Gender' 
		    },
		    tooltip: {
		        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		    },
		    plotOptions: {
		        pie: {
		            allowPointSelect: true,
		            cursor: 'pointer',
		            dataLabels: {
		                enabled: true,
		                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
		                style: {
		                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
		                }
		            }
		        }
		    },
		    series: [{
		        name: '%',
		        colorByPoint: true,
		        data: [{
		            name: 'Male<br>Total '+data['male'] +' ',
		            y: ((data['male'] / sum) * 100),
		            sliced: true,
		            selected: true
		        }, {
		            // name: 'Female',
		            name: 'Female<br>Total '+data['female'] +' ',
		            y: ((data['female'] / sum) * 100)
		        }]
		    }]
		});
	});
}

function loadPieAge(yr){
    $.getJSON("<?php echo site_url('logs/gpAge/" + yr + "'); ?>", function(data)
    {
    	var sum = parseInt(data['a20']) + parseInt(data['a30']) + parseInt(data['a40']) + parseInt(data['a50']) + parseInt(data['a60']) + parseInt(data['a61']);
    	console.log(sum)

		Highcharts.chart('gpAge', {
		    chart: {
		        plotBackgroundColor: null,
		        plotBorderWidth: null,
		        plotShadow: false,
		        type: 'pie'
		    },
		    title: {
		        text: 'Age'
		    },
		    tooltip: {
		        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		    },
			accessibility: {
				point: {
					valueSuffix: '%'
				}
			},
		    plotOptions: {
		        pie: {
		            allowPointSelect: true,
		            cursor: 'pointer',
		            dataLabels: {
		                enabled: true,
		                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
		                style: {
		                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
		                }
		            }
		        }
		    },
		    series: [{
		        name: '%',
		        colorByPoint: true,
		        data: [{
		            name: '20 yrs old & below<br>Total '+data['a20'] +' ',
		            y: ((data['a20'] / sum) * 100)
		        }, {
		            name: '21-30 yrs old<br>Total '+data['a30'] +' ',
		            y: ((data['a30'] / sum) * 100)
		        }, {
		            name: '31-40 yrs old<br>Total '+data['a40'] +' ',
		            y: ((data['a40'] / sum) * 100),
					sliced: true,
					selected: true
		        }, {
		            name: '41-50 yrs old<br>Total '+data['a50'] +' ',
		            y: ((data['a50'] / sum) * 100)
		        }, {
		            name: '51-60 yrs old<br>Total '+data['a60'] +' ',
		            y: ((data['a60'] / sum) * 100)
		        }, {
		            name: '61 yrs old & above<br>Total '+data['a61'] +' ',
		            y: ((data['a61'] / sum) * 100)
		        }]
		    }]
		});
	});
}

function getStats(yr) {
    $.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,
      url:"<?=site_url('logs/getStats/" + yr + "');?>",
      success: function(data) {
        $("#lblfeed").html(data['feed']);
        $("#lblnewemp").html(data['newemp']);
        $("#lblallreg").html(data['allreg']);
        $("#lblallemp").html(data['allemp']);
      },
      error: function(data){console.log("We encountered a problem!")}
  });
}


function getToday() {
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{q:"SELECT gender, UPPER(concat(COALESCE(firstname,''), ' ', COALESCE(lastname,''))) fullname, position_code, position_desc, unit_code, division_code, date_format(birthday, '%b %e - %W') bday FROM infosys.employee e left join infosys.division d on d.division_id = e.division_division_id left join infosys.unit u on e.unit_unit_id = u.unit_id left join infosys.position_reference pr on e.position_reference_position_reference_id = pr.position_reference_id WHERE MONTH(birthday) = MONTH(NOW()) AND DAY(birthday) = DAY(NOW()) and employment_status_library_employment_status_library_id not in (11,12,13,14,17,20)"},
      url:"<?=site_url('hr/employee/getRecordArray');?>",
      success: function(tdy){
		$('#lstBday').empty();
		if(tdy.length){
			$("#lstBday").append('<li class="out">Today\'s</li>');
			tdy.forEach((number, index, array) => {
					$("#lstBday").append('<li class="in">'+
														'<img class="avatar" alt="" src="<?php echo base_url();?>/assets/'+array[index].gender+'.png"/>'+
														'<div class="message">'+
															'<span class="arrow"></span>'+
															'<a href="#" class="name">'+array[index].fullname+' </a>'+
															'<span class="body">'+array[index].position_desc+' from '+array[index].division_code+'/'+array[index].unit_code+' </span>'+
														'</div>'+
													'</li>');
			});
		}
      },
      error: function(data){console.log("We encountered a problem!")}
	});
}


function getThisMonth() {
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{q:"SELECT gender, UPPER(concat(COALESCE(firstname,''), ' ', COALESCE(lastname,''))) fullname, position_code, position_desc, unit_code, division_code, concat(date_format(birthday, '%b %e'), date_format(concat(YEAR(NOW()),date_format(birthday,'-%m-%d')),' - %W')) bday FROM infosys.employee e left join infosys.division d on d.division_id = e.division_division_id left join infosys.unit u on e.unit_unit_id = u.unit_id left join infosys.position_reference pr on e.position_reference_position_reference_id = pr.position_reference_id WHERE MONTH(birthday) = MONTH(NOW()) and employment_status_library_employment_status_library_id not in (11,12,13,14,17,20) ORDER by DAY(birthday)"},
      url:"<?=site_url('hr/employee/getRecordArray');?>",
      success: function(mnth){
		if(mnth.length){
			$("#lstBday").append('<li class="out">This month\'s</li>');
			mnth.forEach((number, index, array) => {
					$("#lstBday").append('<li class="in">'+
														'<img class="avatar" alt="" src="<?php echo base_url();?>/assets/'+array[index].gender+'.png"/>'+
														'<div class="message">'+
															'<span class="arrow"></span>'+
															'<a href="#" class="name">'+array[index].fullname+' </a>'+
															'<span class="datetime">on </span>'+array[index].bday+' </span>'+
															'<span class="body">'+array[index].position_desc+' from '+array[index].division_code+'/'+array[index].unit_code+' </span>'+
														'</div>'+
													'</li>');
			});
		}
      },
      error: function(data){console.log("We encountered a problem!")}
	});
}
</script>