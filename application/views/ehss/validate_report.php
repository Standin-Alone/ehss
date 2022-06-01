<head><title>Reports | EHSS</title></head>
<style>
.page-title{
font-family:"Century Gothic";

},

.swal2-container {
  z-index: 10000;
}

</style>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Review Report
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li><a href="javascript:history.back();"><i class="btn-xl fa fa-arrow-circle-o-left"></i></a></li>
					<li>
						<i class="fa fa-home"></i>
						<a href="<?php echo base_url('addreport');?>">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<i class="icon-drawer"></i>
						<a href="#">Reports</a>
						<i class="fa fa-angle-right"></i>
					</li>
				</ul>
				<div class="page-toolbar">
				</div>
			</div>
      <!-- Content Start -->

  
      <div class="row">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="col-md-5 ">
            <div class="portlet light bordered  ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder font-red-sunglo"></i>
                        <span class="caption-subject font-red-sunglo bold ">Report Information</span>
                    </div>				
                </div>
                <div class="portlet-body">                        
                    <table class="table table-bordered ">
                        <thead>     
                           <tr class="bg-primary">
                                <td  colspan="2"><b> Details <b> </td>
                            <tr>
                        </thead>
                       <tbody>

                            <tr>
                                <th class="text-secondary"> Location </th>
                                <td> <?php echo $report->location;?> </td>
                            </tr>
                            <tr>
                                <th class="text-secondary"> Description </th>
                                <td> <?php echo $report->details;?> </td>
                            </tr> 
                            
                                                       
                            <tr>
                                <th class="text-secondary"> Reported by </th>
                                <td> <?php echo $report->firstname.' '.$report->middlename.' '.$report->lastname;?> </td>
                            </tr>

                       </tbody>
                    </table>
                    <button type="button" class="btn btn-block btn-success validate-report-btn">Mark as Valid Report</button>
                    <button type="button" class="btn btn-block btn-danger">Not Valid</button>
                </div>
            </div>
        </div>
        

        <div class="col-md-7">
            <div class="portlet light bordered  ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder font-red-sunglo"></i>
                        <span class="caption-subject font-red-sunglo bold uppercase">Attachment</span>
                    </div>				
                </div>
                <div class="portlet-body">                        
                    <?php $file_path = base_url().'uploads/';?>

                    <center>
                        <object data="<?php echo $file_path.$attachments->file_name;?>" style="position:relative;" class="media d-flex flex-column" width="auto" height="500" draggable="false"></object> 
                    </center>
                </div>
            </div>
        </div>
		<!-- END EXAMPLE TABLE PORTLET-->	


        </div>

      <!-- Content End -->
    </div>
	</div>
	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->




<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){

    $(".validate-report-btn").click(()=>{
        let reportId =  <?php echo $report->report_id;?> 
        Swal.fire({
						
						title: 'Do you want to mark as valid this report?',
						showDenyButton: true,						
						confirmButtonText: 'Yes',
						denyButtonText: `Cancel`,
			}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {

                let payload= {
                    report_id:reportId;
                }
                $.ajax({
					url:'<?php echo base_url();?>' + 'ehss/reportvalidation/insert_report',
					type:'post',				
					data:payload,
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
            }else{

            }
        }):
    })
})
</script>

