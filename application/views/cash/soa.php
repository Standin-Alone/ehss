<head><title>Issue Receipt | Payment | InfoSys</title></head>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Issue Receipt <small>official receipt issuances</small>
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
						<i class="fa fa-cogs"></i>
						<a href="#">Payments</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Issue Receipt</a>
					</li>
				</ul>
				<div class="page-toolbar">
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						Settings <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a href="<?php echo base_url('assets/paymentuserguide.pdf');?>" target="_blank">User's Manual</a></li>
							<li class="cashier revme"><a href="#mSeries" data-toggle="modal" onclick="loadSignatory()">Signatory</a></li>
							<li><a onclick="gexportExcel('table')">Export Logs</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->

			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject font-red-sunglo bold ">List of statement</span>
					</div>
					<div class="actions row">
						<div class="col-md-8 col-sm-8">
							<div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
								<input type="text" class="form-control" name="soaFrom" id="soaFrom">
								<span class="input-group-addon">
								to </span>
								<input type="text" class="form-control" name="soaTo" id="soaTo">
								<span class="input-group-btn">
									<button class="btn default" type="reset"><i class="fa fa-times"></i></button>
								</span>
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<a class="btn btn-danger btn-sm" data-toggle='modal' onclick="loadOR()" href='#mOR'><i class="fa fa-file-text-o"></i> View by Receipts</a>
						</div>
					</div>
				</div>
				<div class="portlet-body">
					<table class="table table-striped table-bordered datatables" width="100%" id="table">
						<thead>
						<tr>
							<th>Reference Code
							<th>Payee
							<th>Company
							<th>Date Created
							<th>Prepared By
							<th>Receipt
							<th width="140px" style="min-width:140px;max-width:140px;">Action
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

<script language="JavaScript" type="text/javascript">
	if (localStorage.getItem('soaFrom')){
		$("#soaFrom").val(localStorage.getItem('soaFrom'));
		$("#soaTo").val(localStorage.getItem('soaTo'));
	}else{
		$("#soaFrom").val("<?php echo date('Y-m-d', strtotime('-7 days')); ?>");
		$("#soaTo").val("<?php echo date('Y-m-d'); ?>");
	}

	$('#soaFrom, #soaTo').live('change', function(){
		if($('#soaFrom').val() && $('#soaTo').val()){
			localStorage.setItem('soaFrom', $('#soaFrom').val());
			localStorage.setItem('soaTo', $('#soaTo').val());
			loadSOA()
		}
	});
	$(document).on('keyup',function(e){
		if(e.target.id == "recno"){
			$.ajax
			({ type:"POST",
			   async: true,
			   url:"<?php echo site_url('cash/payment/checkORNumber'); ?>",
			   data:{id:e.target.value},
			   dataType: 'json',
			   cache: false,
			   success: function(data)
			     {
			     	if(data=="0"){
			        	$('.sprecno').addClass('hidden');
			        	$('.dvrecno').removeClass('has-error');
			     	}
			        else{
			        	$('.sprecno').removeClass('hidden');
			        	$('.dvrecno').addClass('has-error');
			        }
			     },
			     error: function(data)
			     {
			     }
			});
		}

		// if(e.target) 
		console.log(e.target.id)
		// if(!$(e.target).is(':input'))
		if(!$(e.target).is(':input') || e.target.classList.contains('inpK'))
		{
			console.log(e.target.classList.contains('inpK'))
			if ((e.keyCode || e.which) == 67){
				try{
					// $('#ptcash').prop('checked', true);
					$('#ptcash').attr("checked", !$('#ptcash').attr("checked"));

				} catch(err)
				{console.log(err)}
			}
			if ((e.keyCode || e.which) == 72){
				try{
					// $('#ptcheck').prop('checked', true);
					$('#ptcheck').attr("checked", !$('#ptcheck').attr("checked"));
				} catch(err)
				{console.log(err)}
			}
			if ((e.keyCode || e.which) == 77){
				try{
					// $('#ptmoney').prop('checked', true);
					$('#ptmoney').attr("checked", !$('#ptmoney').attr("checked"));
				} catch(err)
				{console.log(err)}
			}
			if ((e.keyCode || e.which) == 76){
				try{
					// $('#ptlddap').prop('checked', true);
					$('#ptlddap').attr("checked", !$('#ptlddap').attr("checked"));
				} catch(err)
				{console.log(err)}
			}
			$.uniform.update();
			chkChanged()
		}
	});

	function loadSOA()
	{
		$('#table').dataTable().fnClearTable();
	    $('#table').dataTable().fnDraw();
	    $('#table').dataTable().fnDestroy();

	    var fr = $('#soaFrom').val();
	    var to = $('#soaTo').val();
	    $('#table').dataTable({
	        "serverSide": true,
	        // "sAjaxSource": "<?php echo site_url('cash/payment/read/soa'); ?>",
	        "sAjaxSource": "<?php echo site_url('cash/payment/read/soa/1/"+ fr +"/"+ to +"'); ?>",
	        "deferLoading": 10,
	        "bStateSave": true,
	        "aaSorting": [[3,'desc'],[1,'asc']],
	    });

	    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
	    $('.dataTables_length select').addClass('form-control');
	}

	function loadOR()
	{
		$('.divOR').removeClass('hidden');
		$('#tableOR').dataTable().fnClearTable();
	    $('#tableOR').dataTable().fnDraw();
	    $('#tableOR').dataTable().fnDestroy();
	    var url;
	    var fr = $('#orFrom').val();
	    var to = $('#orTo').val();
	    var fund = $('#ftrFund').val();
	    $('#tableOR').dataTable({
	        "serverSide": true,
	        "sAjaxSource": "<?php echo site_url('cash/payment/read/receipt/"+ fund +"/"+ fr +"/"+ to +"'); ?>",
	        "deferLoading": 57,
	        "pagingType": "full_numbers",
	        "bStateSave": true,
	        "aaSorting": [[0,'desc'],[1,'asc']]
	    });

	    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
	    $('.dataTables_length select').addClass('form-control');
	}

	$('#orFrom, #orTo').live('change', function(){
		$(".clsPrintAct").addClass("hidden");
		if($('#orFrom').val() && $('#orTo').val()){
			loadOR()
			$(".clsPrintAct").removeClass("hidden");
		}
	});

	function cancelORConfirm(or, payid){
		$('#lblcOR').text(or)
		$('#payid').val(payid)
	}

	function deleteOR(){
		$('#processvalidation1').show();
		$.ajax
		({  type:"POST",
		    async: true,
		    url: "<?php echo site_url('common/update'); ?>",
			data: {	tbl:"payment.t_payment", col:"payid", id:$("#payid").val(),
					udata:{ status:0, cashamt:0, payor: 'Cancelled'}},
			dataType: 'json',
			cache: false,
		    success: function(data)
		    {
				$('#processvalidation1').hide();
				if (data)
				{
					$.ajax
					({  type:"POST",
					    async: true,
					    url: "<?php echo site_url('common/delete'); ?>",
						data: {	tbl:"payment.t_item", col:"pid", id:$("#payid").val()},
						dataType: 'json',
						cache: false,
					    success: function(data)
					    {
							loadSOA()
							toastr.success("Receipt <b>'"+$('#lblcOR').text()+"'</b> successfully cancelled", "Success");
							$('#mCancelOR').modal('toggle');
					    }
					})
				}else{
					toastr.info("Receipt <b>'"+$('#lblcOR').text()+"'</b> was not cancelled", "Info");
				}

		    },
		    error: function(data)
		    {
		        toastr.error('Please reload the page and try again.', 'Ooooophs! We encountered a problem') 
		    }
		})
	}

	function vwSOA(id, payid){
		gclearme('#form_sample_2');
		$('#divMoneyOrder').hide()
		$('#divCheck').hide()
		$('#divCash').hide()
		// $("#type").val("cash");
		// $("#ptcash").prop('checked', true);
		$(".date-picker").datepicker("update", "<?php echo date('m/d/yyyy'); ?>");
		$(".timepicker").timepicker("update", "<?php echo date('H:i'); ?>");
		$('#soaid').val(id);
		$('#tbitems').empty();
		$('#tfitems').empty();

		$.ajax({
		  url: "<?php echo site_url('cash/payment/getStatement'); ?>",
		  data: {id: id},
		  type: 'POST',
		  assync: false,
		  success: function(d){

			// d.TIN_NO ? $('#tin_div').show().text(d.TIN_NO) : $('#tin_div').hide();
			$(".refcode").text(d.REF_CODE)
			$(".soadt").text(d.DATE_CREATED)
			$(".payee").text(d.PAYEE)
			$(".company").text(d.COMPANY)
			$(".prepby").text(d.NAME)
			if(d.JO)
			{
				$(".divJO").removeClass("hidden")
			}else{

				$(".divJO").addClass("hidden")
			}
			$(".jono").text(d.JO)
			total = before = amt = 0;
			active = '';

			if(payid){
				$.ajax({
				  url: "<?php echo site_url('cash/payment/getReceipt'); ?>",
				  data: {id: payid},
				  type: 'POST',
				  assync: false,
				  success: function(d){
					$("#payid").val(payid);
					$("#offdate").val(d.d);
					$("#rem").val(d.rem);
					$("#offtime").val(d.t);
					$("#fund").val(d.fund);
					$("#recno").val(d.receiptno);
					$("#type").val(d.paytype);
					$("#chkdraw").val(d.drawee);
					$("#chknumber").val(d.bankno);
					$("#chkdate").val(d.checkdate);
					$("#pmono").val(d.MOno);
					$("#pmodates").val(d.MOdate);
					$("#cashamt").val(d.cashamt);
					$('#ptcash').prop('checked', $("#type").val().includes('cash'))
					$('#ptcheck').prop('checked', $("#type").val().includes('check'))
					$('#ptmoney').prop('checked', $("#type").val().includes('money'))
					$('#ptlddap').prop('checked', $("#type").val().includes('lddap'))
					$.uniform.update();
					chkChanged()

					$('#tbhead').html('<tr><th>Code<th>Description<th>Amount</tr>');
					$.each(d.ITEMS, function(i, rs){
						if(rs.amt != '')
							total += parseFloat(rs.amt);
						else
							total += 0;
						$('#tbitems').append('<tr>'+
							'<td><input type=text class="acc'+rs.iid+' form-control hidden" value="'+ rs.acc +'">'+ rs.acc +'</td>' +
							// '<td></td>' +
							'<td><input class="iid hidden" value='+rs.iid+'><input class="id'+rs.iid+' hidden" value='+rs.id+'><textarea class="des'+rs.iid+' form-control">'+ rs.des +'</textarea></td>' +
							'<td><input type=number class="amt'+rs.iid+' form-control hidden" value="'+ rs.amt +'">'+ rs.amt +'</td></tr>');
							// '<td></td></tr>');
					});
					$('#tfitems').append('<tr style="font-weight:600"><td><td class="c2">Total<td>'+toMoney(total)+'</td></tr>');
				  }
				});
			}else
			{
				$('#tbhead').html('<tr><th>Service<th>Code<th>Description<th>Qty<th>Unit Price<th>Amount</tr>');
				$.each(d.SERVICES, function(i, rs){
					rs.A_AMOUNT = rs.A_AMOUNT ? rs.A_AMOUNT : 0;
					rs.QUANTITY = rs.QUANTITY ? rs.QUANTITY : 0;
					rs.UNIT_PRICE = rs.UNIT_PRICE ? rs.UNIT_PRICE : 0;
					amt = '<td><input type=number class="amt'+rs.ID+' form-control hidden" value='+rs.A_AMOUNT+'>'+toMoney(rs.A_AMOUNT)+'</td>';
					total += parseFloat(rs.A_AMOUNT);
					
					/*if(rs.A_AMOUNT != ''){
						// amt = '<td></td>';
						amt = '<td><input type=number class="amt'+rs.ID+' form-control hidden" value='+rs.A_AMOUNT+'>'+toMoney(rs.A_AMOUNT)+'</td>';
						total += parseFloat(rs.A_AMOUNT);
					}
					else{
						amt = '<td class="amt'+rs.ID+'"></td>';
						total += 0;
					}*/
					var des = (rs.QUANTITY ? (rs.QUANTITY+ ' ') : "") + (rs.SERVICE + ' ' + rs.DESCRIPTION);
					$('#tbitems').append('<tr>'+
						'<td>'+rs.SERVICE+'<input class="id'+rs.ID+' hidden" value='+rs.ID+'><input class="iid hidden" value='+rs.ID+'></td>' +
						// '<td><</td>' +
						'<td><input type=text class="acc'+rs.ID+' form-control hidden" value="'+ (rs.account ? rs.account : 0) +'">'+ rs.account +'</td>' +
						'<td><textarea class="des'+rs.ID+' form-control">'+ des +'</textarea></td>' +
						'<td>'+rs.QUANTITY+'</td>' +
						'<td>'+toMoney(rs.UNIT_PRICE)+'</td>' +
						amt + '</tr>');
				});
				$('#tfitems').append('<tr style="font-weight:600"><td><td><td><td><td>Total' +
		        '<td class="c1">'+toMoney(total)+'</td></tr>');
			}
		  }
		});
		
		$.uniform.update();
	}

	function getCode(){
		if(!$("#payid").val())
		$.ajax
	    ({ type:"POST",
	       async: true,
	       url:"<?php echo site_url('cash/payment/getCode'); ?>",
	       data: {type: $("#fund").val()},
	       dataType: 'json',
	       cache: false,
	       success: function(data)
	         {
	            $('#recno').val(data)
	         },
	         error: function(data)
	         {
	         }
	    });
	}

	function toMoney(val){
	  var amount = parseFloat(val);
	  var amt = amount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	  return amount.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	  //return isNaN(amt) ? "0.00" : amt;
	}

	function chkChanged(){
		$('#divMoneyOrder').hide()
		$('#divCheck').hide()
		$('#divCash').hide()
		$('#divlddap').hide()
		$('#divlddap1').hide()
		if($('input[name="paytype"]').val() == "cash"){}
		if($("#ptcheck").prop("checked"))
			$('#divCheck').show()
		if($("#ptmoney").prop("checked") || $("#ptlddap").prop("checked")){
			$('#divMoneyOrder').show()
			if($("#ptlddap").prop("checked")){
				$('#divlddap').show()
				$('#divlddap1').show()
			}
		}
		$("#type").val($("input[name=paytype]:checked").map(function () {return this.value;}).get().join(","))
		if($("#type").val().includes('cash,')){
			$('#divCash').show()
		}
	}

	$('input[name="paytype"]').live('change', function(){
		chkChanged()
	});

	function printOR(or)
	{
		var URL = "<?php echo base_url();?>cash/payment/officialreceipt/"+or;
		var win = window.open(URL, 'Print OR','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,left=300,top=100, width=400,height=800');
		win.focus();
		win.print();
	}

	function formatDate(date) {
		var d = new Date(date),
		month = '' + (d.getMonth() + 1),
		day = '' + d.getDate(),
		year = d.getFullYear();

		if (month.length < 2) month = '0' + month;
		if (day.length < 2) day = '0' + day;

		return [year, month, day].join('-');
	}

	$(document).ready(function(){
		loadSOA();
		$('#form_sample_2').on('submit', (function(e)
	    {
		    e.preventDefault();
		    console.log(1)
	    	if($("#form_sample_2").valid())
	    	{
	    		pid = acc = des = amt = item = [];
				$('#alertvalidation').hide();
				$('#infovalidation').hide();
				$('#processvalidation').show();
				var url, itemurl, msg = '';
				if($("#payid").val()){
					url = "<?php echo site_url('common/update'); ?>";
					msg = "updated";
				}
				else{
					url = "<?php echo site_url('common/add'); ?>";
					msg = "created";
				}

			    var a;
	            $.ajax
	            ({  type:"POST",
	                async: true,
	                url: url,
	                data: {	tbl:"payment.t_payment", col:"payid", id:$("#payid").val(),
	                		udata:{ soaid:$("#soaid").val(),
	                				offdate:formatDate($("#offdate").val()) +" "+ $("#offtime").val(),
	                				payor:$(".company").text(),
	                				jo:$(".jono").text(),
	                				receiptno:$("#recno").val(),
	                				fund:$("#fund").val(),
	                				ctrcode:$("#ctrcode").val(),
	                				paytype:$("#type").val(),
	                				drawee:$("#chkdraw").val(),
	                				bankno:$("#chknumber").val(),
	                				MOno:$("#pmono").val(),
	                				MOdate:$("#pmodates").val(),
	                				rem:$("#rem").val(),
	                				cashamt:$("#cashamt").val() ? $("#cashamt").val() : "0.00",
	                				checkdate:$("#chkdate").val()}},
					dataType: 'json',
					cache: false,
	                success: function(data)
	                {
						$('#successvalidation').hide();
						$('#processvalidation').hide();
						
						var act = $("#payid").val().length ? "update" : "add";


		            	if(data){
							if($("#payid").val()){
								act = "update";
								$(".iid").each(function(q) {
									i = $(this).val();
									item.push({
										iid:i,
										id:$('.id'+i).val(),
										pid:$("#payid").val(),
										acc:$('.acc'+i).val(),
										des:$('.des'+i).val(),
										amt:$('.amt'+i).val()
									});
								});
							}else{
								$("#payid").val(data[0]);
								act = "add";
								$(".iid").each(function(q) {
									i = $(this).val();
									item.push({
										id:$('.id'+i).val(),
										pid:$("#payid").val(),
										acc:$('.acc'+i).val(),
										des:$('.des'+i).val(),
										amt:$('.amt'+i).val()
									});
								});
							}

							$.ajax({
								type:"POST",
								async: true,
								url: "<?php echo site_url('cash/payment/items'); ?>",
								data: {	tbl:"payment.t_item", id:a,item:item, act:act},
								dataType: 'json',
								cache: false,
								success: function (data2) {
	            					// $("#payid").val(a)
									toastr.success("Receipt successfully "+msg, "Success");
									printOR($("#payid").val())
								}
							});
	            			loadSOA()

	                	}
	            		else
		            		toastr.info("Receipt was not "+msg, "Info");
	                },
	                error: function(data)
	                {
	                	console.log(data)
	                    toastr.error('Please reload the page and try again.', 'Ooooophs! We encountered a problem') 
	                }
	            })
			}
	    }))

		$('#form_sample_2_2').on('submit', (function(e)
	    {
		    e.preventDefault();
	    	if($("#form_sample_2_2").valid())
	    	{
				$('#alertvalidation1').hide();
				$('#infovalidation1').hide();
				$('#processvalidation1').show();

			    var a;
	            $.ajax
	            ({  type:"POST",
	                async: true,
	                url: "<?php echo site_url('common/update'); ?>",
	                data: {	tbl:"payment.r_config", col:"sig_id", id:1,
	                		udata:{ sig_name:$("#sig_name").val(),
	                				sig_des:$("#sig_des").val()}},
					dataType: 'json',
					cache: false,
	                success: function(data)
	                {
						$('#successvalidation1').hide();
						$('#processvalidation1').hide();
						a = data;
	                	if(a){
	                		loadSignatory()
							toastr.success("Successfully updated", "Success");
	                	}
	            		else
		            		toastr.info("Was not updated", "Info");
	                },
	                error: function(data)
	                {
	                	console.log(data)
	                    toastr.error('Please reload the page and try again.', 'Ooooophs! We encountered a problem') 
	                }
	            })
			}
	    }))
	})

	function openMonthly()
	{
		var fund = $('#ftrFund').val();
		var fr = $('#orFrom').val();
		var to = $('#orTo').val();
		var URL = "<?php echo base_url();?>cash/payment/monthly/"+fund+"/"+fr+"/"+to+"/";
		var win = window.open(URL, 'Print Monthly Report','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,left=100,top=100, width=700,height=700');
	}

	function exportCashBook()
	{
		var fund = $('#ftrFund').val();
		var fr = $('#orFrom').val();
		var to = $('#orTo').val();
		var URL = "<?php echo base_url();?>cash/payment/exportCashBook/"+fund+"/"+fr+"/"+to+"/";
		var win = window.open(URL, 'Print Monthly Report','');
	}

	function openDaily1()
	{
		var fund = $('#ftrFund').val();
		var fr = $('#orFrom').val();
		var to = $('#orTo').val();
		var URL = "<?php echo base_url();?>cash/payment/daily1/"+fund+"/"+fr+"/";
		var win = window.open(URL, 'Print Daily Report','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,left=100,top=100, width=700,height=700');
	}

	function openDaily()
	{
		var fund = $('#ftrFund').val();
		var fr = $('#orFrom').val();
		var URL = "<?php echo base_url();?>cash/payment/daily/"+fund+"/"+fr+"/";
		var win = window.open(URL, 'Print Daily Report','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,left=100,top=100, width=700,height=700');
	}

	function loadSignatory()
	{
		$.ajax({
		  url: "<?php echo site_url('cash/payment/getSignatory'); ?>",
		  data: {id: 1},
		  type: 'POST',
		  assync: false,
		  success: function(d){
			$('#sig_name').val(d['sig_name'])
			$('#sig_des').val(d['sig_des'])
		  }
		});
	}
</script>

<!-- receipt /.modal -->
<div id="mreceipt" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-body">
			<div class="portlet box red">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-equalizer"></i>
						<span class="caption-subject uppercase">Receipt Form</span>
					</div>
				</div>
				<div class="portlet-body form">
					<form action="#" name="frmloan_type" id="form_sample_2" class="form-horizontal" method="POST">
						<div class="form-body">
							<!-- <h4 class="form-section">Fill in the details below</h4> -->
							<div class="alert alert-danger display-hide" id="alertvalidation">
								<button class="close" data-close="alert"></button>
								You have some form errors. Please check below.
							</div>
							<div class="alert alert-info display-hide" id="processvalidation" >
								<button class="close" data-close="alert"></button>
								<span><img src='<?php echo base_url('assets/global/img/spinner.gif');?>'/>  <strong>Processing! </strong>Please wait... </span>
							</div>
							<div class="alert alert-warning display-hide" id="infovalidation" >
								<button class="close" data-close="alert"></button>
								Nothing was updated! Change some fields!
							</div>

							<div class="portlet grey-cascade box">
								<div class="portlet-title" style="height:20px !important; min-height: 20px !important;">
									<div class="">Order Details</div>
								</div>
								<div class="portlet-body">
									<div class="static-info">
										<div class="row">
											<div class="col-md-5 name">
												 Reference Code:
											</div>
											<div class="col-md-7 value refcode"></div>
										</div>
										<div class="row">
											<div class="col-md-5 name">
												 Date:
											</div>
											<div class="col-md-7 value soadt"></div>
										</div>
										<div class="row">
											<div class="col-md-5 name">
												 Payee:
											</div>
											<div class="col-md-7 value payee"></div>
										</div>
										<div class="row">
											<div class="col-md-5 name">
												 Company:
											</div>
											<div class="col-md-7 value company"></div>
										</div>
										<div class="row">
											<div class="col-md-5 name">
												 Prepared by:
											</div>
											<div class="col-md-7 value prepby"></div>
										</div>
										<div class="row divJO">
											<div class="col-md-5 name">
												 JO:
											</div>
											<div class="col-md-7 value jono"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="portlet grey-cascade box">
								<div class="portlet-title" style="height:20px !important; min-height: 20px !important;">
									<div class="">Services Availed</div>
								</div>
								<div class="portlet-body">
									<div class="table-responsive static-info">
										<table class="table table-hover table-bordered table-striped table-condensed table-hover">
										<thead id="tbhead"></thead>
										<tbody id="tbitems"></tbody>
										<tfoot id="tfitems"></tfoot>
										</table>
									</div>
								</div>
							</div>
							<input type="text" class="hidden" id="soaid">
							<input type="text" class="hidden" id="payid">
							<input type="text" class="hidden" id="type">
							<div class="form-group">
								<label class="control-label col-md-4">Official Date <span class="required"> * </span> </label>
								<div class="col-md-3">
									<div class="input-group date date-picker" data-date-format="mm/dd/yyyy">
										<input type="text" class="form-control" required="required" name="offdate" id="offdate">
										<span class="input-group-btn">
										<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
										</span>
									</div>
								</div>
								<div class="col-md-3">
									<div class="input-group">
										<input type="text" class="form-control timepicker timepicker-24" name="offtime" id="offtime">
										<span class="input-group-btn">
										<button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
										</span>
									</div>

								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4">Fund <span class="required">
								* </span>
								</label>
								<div class="col-md-6">
									<select class="form-control select2me" data-placeholder="Select..." id="fund" name="fund" onchange="getCode()">
										<option>101-I</option>
										<option>101-R</option>
										<option>184-R</option>
										<option>184-MDS</option>
										<option>184-UNDP</option>
										<option>171</option>
										<option>PROV</option>
									</select>
								</div>
							</div>
							<div class="form-group static-info dvrecno">
								<label class="control-label col-md-4">Receipt Number <span class="required">
								* </span>
								</label>
								<div class="col-md-6">
									<div class="input-icon right">
										<i class="fa"></i>
										<input type="text" required="true" class="form-control" id="recno" name="recno"/>
									</div>
									<span class="help-block sprecno hidden">Receipt number exist! </span>
								</div>
							</div>
							<div class="form-group static-info">
								<label class="control-label col-md-4">Type <span class="required">
								* </span>
								</label>
								<div class="col-md-2">
									<label><input type="checkbox" name="paytype" id="ptcash" value="cash" data-title="Cash" class="inpK"/><u>C</u>ash </label>
									<label><input type="checkbox" name="paytype" id="ptcheck" value="check" data-title="Check" class="inpK"/>C<u>h</u>eck </label>
									<label><input type="checkbox" name="paytype" id="ptmoney" value="moneyorder" data-title="Money Order" class="inpK"/><u>M</u>oney Order </label>
									<label><input type="checkbox" name="paytype" id="ptlddap" value="lddap" data-title="LDDAP" class="inpK"/><u>L</u>DDAP </label>
								</div>
							</div>
							<div class="form-group static-info" id="divCash" hidden>
								<label class="control-label col-md-4">Cash Amount <span class="required">
								* </span>
								</label>
								<div class="col-md-5">
									<input type="number" class="form-control" id="cashamt" name="cashamt" value="0.00"/>
								</div>
							</div>
							<div id="divCheck" hidden>
								<div class="form-group static-info">
									<label class="control-label col-md-4">Drawee Bank <span class="required">
									* </span>
									</label>
									<div class="col-md-5">
										<input type="text" list="drawees" class="form-control select" id="chkdraw" name="chkdraw"/>
										<datalist id="drawees">
										<?php echo $drawees;?>
										</datalist>
									</div>
								</div>
								<div class="form-group static-info">
									<label class="control-label col-md-4">Number <span class="required">
									* </span>
									</label>
									<div class="col-md-5">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="text" class="form-control" id="chknumber" name="chknumber"/>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-4">Date <span class="required"> * </span> </label>
									<div class="col-md-5">
										<div class="input-icon right">
											<i class="fa"></i>
											<input type="text" class="form-control" id="chkdate" name="chkdate"/>
										</div>
									</div>
								</div>
							</div>
							<div id="divMoneyOrder" hidden>
								<div class="form-group static-info">
									<label class="control-label col-md-4"><span id="divlddap">LDDAP /</span> PMO # <span class="required">
									* </span>
									</label>
									<div class="col-md-5">
										<input type="text" class="form-control" id="pmono" name="pmono"/>
									</div>
								</div>
											
								<div class="form-group static-info">
									<label class="control-label col-md-4"><span id="divlddap1">LDDAP </span>Dates <span class="required">
									* </span>
									</label>
									<div class="col-md-5">
										<input type="text" class="form-control" id="pmodates" name="pmodates"/>
									</div>
								</div>
							</div>
							<div class="form-group static-info dvrecno">
								<label class="control-label col-md-4">Remarks</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="rem" name="rem"/>
								</div>
							</div>

						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-4">
								</div>
								<div class="col-md-8">
									<button type="submit" class="btn green">Submit</button>
									<button type="reset" class="btn default" onclick="gclearme('#form_sample_2');" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- receipt /.modal -->

<!-- monthly /.modal -->
<div id="mOR" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-full">
		<div class="modal-body">
			<div class="portlet box blue-hoki">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject uppercase">Receipts</span>
					</div>
					<div class="tools">
						<a href="javascript:;" class="close font-white" data-dismiss="modal"></a>
					</div>
				</div>
				<div class="portlet-body">
					<form action="#" class="form-horizontal" id="">
						<div class="form-body">
							<div class="form-group">
								<label class="control-label col-md-2">Fund</label>
								<div class="col-md-2">
									<select class="form-control select2me" id="ftrFund" onchange="loadOR()">
										<option>101-I</option>
										<option>101-R</option>
										<option>184-R</option>
										<option>184-MDS</option>
										<option>184-UNDP</option>
										<option>171</option>
										<option>PROV</option>
									</select>
									<span class="help-block">select fund type </span>
								</div>
								<label class="control-label col-md-2">Official Date</label>
								<div class="col-md-4">
									<div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
										<input type="text" class="form-control" name="orFrom" id="orFrom" value="<?php echo date('Y-m-01'); ?>">
										<span class="input-group-addon">
										to </span>
										<input type="text" class="form-control" name="orTo" id="orTo" value="<?php echo date('Y-m-t'); ?>">
										<span class="input-group-btn">
											<button class="btn default" type="reset"><i class="fa fa-times"></i></button>
										</span>
									</div>
									<!-- /input-group -->
									<span class="help-block">
									Input date range </span>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="portlet-body hidden divOR">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption">
							</div>
							<div class="actions clsPrintAct">
								<span class="label label-sm label-primary" onclick="exportCashBook()"><i class="fa fa-print"></i> CashBook </span>&nbsp; 
								<span class="label label-sm label-success" onclick="gexportExcel('tableOR')"><i class="fa fa-print"></i> XLS </span>&nbsp; 
								<span class="label label-sm label-danger" onclick="openMonthly()"><i class="fa fa-print"></i> Monthly </span>&nbsp; 
								<span class="label label-sm label-danger" onclick="openDaily1()"><i class="fa fa-print"></i> Daily </span>&nbsp; 
							</div>
						</div>
						<div class="portlet-body"><!-- table-advance table-hover -->
							<table class="table table-striped table-bordered  datatables" width="100%" id="tableOR">
								<thead>
								<tr>
									<th>Date
									<th>Time
									<th>Number
									<th>Payor
									<th>Particular
										<th>JO
										<th>Fund
										<th>Paytype
										<th>Drawee
										<th>Bank#
										<th>CheckDate
										<th>MO#
										<th>MODate
										<th>CashAmt
									<th>Amount
									<th width="60px" style="min-width:50px;max-width:80px;">
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
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

<!-- monthly /.modal -->
<div id="mSeries" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-body">
			<div class="portlet box blue-madison">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-equalizer"></i>
						<span class="caption-subject uppercase">Signatory</span>
					</div>
					<div class="tools">
						<a href="javascript:;" class="close font-white" data-dismiss="modal"></a>
					</div>
				</div>
				<div class="portlet-body form">
					<form id="form_sample_2_2" class="form-horizontal">
						<div class="form-body">
							<div class="alert alert-danger display-hide" id="alertvali1dation1">
								<button class="close" data-close="alert"></button>
								You have some form errors. Please check below.
							</div>
							<div class="alert alert-info display-hide" id="processvalidation1" >
								<button class="close" data-close="alert"></button>
								<span><img src='<?php echo base_url('assets/global/img/spinner.gif');?>'/>  <strong>Processing! </strong>Please wait... </span>
							</div>
							<div class="alert alert-warning display-hide" id="infovalidation1" >
								<button class="close" data-close="alert"></button>
								Nothing was updated! Change some fields!
							</div>

							<div class="form-group">
								<label class="control-label col-md-3">Name</label>
								<div class="col-md-7">
									<input type="text" class="form-control" id="sig_name" required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3">Designation</label>
								<div class="col-md-7">
									<input type="text" class="form-control" id="sig_des" required>
								</div>
							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-4">
								</div>
								<div class="col-md-8">
									<button type="submit" class="btn green">Submit</button>
									<button type="reset" class="btn default" onclick="gclearme('#form_sample_2_2');" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- monthly /.modal -->


<!-- delete OR /.modal -->
<div id="mCancelOR" class="modal fade bootbox-prompt in" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Cancel Receipt Confirmation</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-info display-hide" id="processvalidation1" >
					<button class="close" data-close="alert"></button>
					<span><img src='<?php echo base_url('assets/global/img/spinner.gif');?>'/>  <strong>Processing! </strong>Please wait... </span>
				</div>
				<div class="bootbox-body">
					Cancel Official Receipt <b id="lblcOR">{select official receipt}</b> ?<br><br>
					<span class="label label-danger">NOTE!</span> 
					<span class=" font-red">  Cancelling receipt cannot be undone!</span>
				</div>

			</div>

			<div class="modal-footer">
				<a class="btn red" onclick="deleteOR()">
				<i class="fa fa-warning"></i> Continue </a>

				<a class="btn blue" class="btn default" data-dismiss="modal">
				<i class="fa fa-times"></i> Cancel </a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- delete OR /.modal -->
