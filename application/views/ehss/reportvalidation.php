<head><title>ReportValidation | EHSS</title></head>
<style>
.page-bar, .page-title, .edit-text{
font-family:"Century Gothic"
},


</style>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Report Validation
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
						<a href="#">Report Validation</a>
						<i class="fa fa-angle-right"></i>
					</li>
				</ul>
				<div class="page-toolbar">
				</div>
			</div>
      <!-- Content Start -->

      <!--<pre>
        <?=print_r($_SESSION);?>
      </pre>-->

      <!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-reorder font-red-sunglo"></i>
						<span class="caption-subject font-red-sunglo bold uppercase">List of Reports that are for Validation</span>
					</div>
					
				</div>
				<div class="portlet-body">
					<table class="table table-hover datatables" id="load-report_table" width="100%">
						<thead>
						
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->	

      <!-- Content End -->
    </div>
	</div>
	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->

<!-- <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,600,800&display=swap" rel="stylesheet">

<h1 class="rainbow-text">E H S S<h1>
<style type="text/css">
/* General styling of the page. */
/* Sets a background color, font-size etc. */
body {
  background-color: #EDDDD4;
}

h1 {
  font-family: "Work Sans", sans-serif;
  font-weight: 800;
  font-size: 3em;
  width: 5em;
  line-height: 0.9em;
  margin-left: auto;
  margin-right: auto;
  margin-top: 1.5em;
  margin-top: calc(10vh - 1em);
}


/* Style the rainbow text element. */
.rainbow-text {
  /* Create a conic gradient. */
  /* Double percentages to avoid blur (#000 10%, #fff 10%, #fff 20%, ...). */
  background: #CA4246;
  background-color: #CA4246;
  background: conic-gradient(
    #CA4246 16.666%, 
    #E16541 16.666%, 
    #E16541 33.333%, 
    #F18F43 33.333%, 
    #F18F43 50%, 
    #8B9862 50%, 
    #8B9862 66.666%, 
    #476098 66.666%, 
    #476098 83.333%, 
    #A7489B 83.333%);
  
  /* Set thee background size and repeat properties. */
  background-size: 57%;
  background-repeat: repeat;
  
  /* Use the text as a mask for the background. */
  /* This will show the gradient as a text color rather than element bg. */
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent; 
  
  /* Animate the text when loading the element. */
  /* This animates it on page load and when hovering out. */
  animation: rainbow-text-animation-rev 0.5s ease forwards;

  cursor: pointer;
}

/* Add animation on hover. */
.rainbow-text:hover {
  animation: rainbow-text-animation 0.5s ease forwards;
}

/* Move the background and make it larger. */
/* Animation shown when hovering over the text. */
@keyframes rainbow-text-animation {
  0% {
    background-size: 57%;
    background-position: 0 0;
  }
  20% {
    background-size: 57%;
    background-position: 0 1em;
  }
  100% {
    background-size: 300%;
    background-position: -9em 1em;
  }
}

/* Move the background and make it smaller. */
/* Animation shown when entering the page and after the hover animation. */
@keyframes rainbow-text-animation-rev {
  0% {
    background-size: 300%;
    background-position: -9em 1em;
  }
  20% {
    background-size: 57%;
    background-position: 0 1em;
  }
  100% {
    background-size: 57%;
    background-position: 0 0;
  }
}
</style> -->
    

<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$('#load-report_table').DataTable({
		ajax:'<?php echo base_url();?>' + 'ehss/reportvalidation/report_validation',
		responsive:true,	
			
		columns:[{data:'report_code',title:'Report Code'},
				{data:'report_date',title:'Report Date'},
				{data:'location',title:'Location'},
				{data:'details',title:'Details'}],
		order: [[ 1, "desc" ]]	
	})
})



</script>