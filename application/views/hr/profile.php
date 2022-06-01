<head><title>Profile | InfoSys</title></head>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Employee Profile <!-- <small>security management</small> -->
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
						<a href="#">Main Menu</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#">Employee</a>
					</li>
				</ul>
				<div class="page-toolbar">
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true" onclick="exportPDS($('#ftrEmployee').val())"> Export PDS
						<!--  <i class="fa fa-angle-down"></i> -->
						</button>
						<!-- <ul class="dropdown-menu pull-right" role="menu">
							<li><a target="_blank" onclick="exportPDS($('#ftrEmployee').val())">PDS</a></li>
						</ul> -->
					</div>
				</div>
			</div>
			<!-- END PAGE HEADER-->

			<div class="portlet light bordered hrmo hidme">
				<div class="portlet-body form frmFilter">
					<form class="form-horizontal">
						<div class="row">
							<div class="col-md-6"><br>
								<div class="form-group">
									<label class="control-label col-md-4 change-message">Employee</label>
									<div class="col-md-8">
										<select class="form-control select2me" id="ftrEmployee" onchange="updateEmployee()"></select>
									</div>
								</div>
							</div>
							<div class="col-md-6"><br>
								<div class="form-group">
									<div class="col-md-6">
										<div class="btn-group">
											<a class="btn btn-default m-icon m-icon-only" id="btnPrev">
												<i class="m-icon-swapleft"></i> Prev
											</a>
											<a class="btn btn-default m-icon m-icon-only" id="btnNext">
												Next <i class="m-icon-swapright"></i>
											</a>
										</div>
									</div>
									<div class="col-md-3">
										<a onclick="clearForms()" class="btn btn-success m-icon m-icon-only">
											<i class="fa fa-plus"></i> New Employee
										</a>
									</div>
									<div class="col-md-3">
									</div>
								</div>
							</div>
						</div>
						<!-- </div> -->
					</form>
				</div>
			</div>
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
			<div class="row profile">
				<div class="col-md-12">
					<!--BEGIN TABS-->
					<div class="tabbable tabbable-custom tabbable-full-width">
						<ul class="nav nav-tabs">
							<li class="tb1 active" onclick="getEmployee()">
								<a href="#tab_1_1" data-toggle="tab">
								Account </a>
							</li>
							<li class="tb2 " onclick="getPersonalInfo()">
								<a href="#tab_1_2" data-toggle="tab">
								Personal Info </a>
							</li>
							<li class="tb3">
								<a href="#tab_1_3" onclick="getFamily()" data-toggle="tab">
								Family </a>
							</li>
							<li class="tb4">
								<a href="#tab_1_4" onclick="getQualification()" data-toggle="tab">
								Qualification </a>
							</li>
							<li class="tb5">
								<a href="#tab_1_5" onclick="getLegal()" data-toggle="tab">
								Legal </a>
							</li>
							<li class="tb6 ">
								<a href="#tab_1_6" onclick="getRefInfo()" data-toggle="tab">
								References </a>
							</li>
							<li class="tb7 ">
								<a href="#tab_1_7" onclick="getOtherInfo()" data-toggle="tab">
								Other Info </a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane tb1 active tp" id="tab_1_1">
								<div class="row">
									<div class="col-md-12">
										<div class="portlet light bordered">
											<div class="portlet-body form">
												<form class="horizontal-form clrme hrmo divabled" autocomplete="off">
													<div class="form-body" id="frmAccount">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">First Name <span class="required"> * </span> </label>
																	<input type="text" class="form-control" id="firstname" name="firstname" required>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Middle Name</label>
																	<input type="text" class="form-control" id="middlename" name="middlename">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Last Name <span class="required"> * </span> </label>
																	<input type="text" class="form-control" id="lastname" name="lastname" required>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Name Extension (e.g. Jr., Sr.)</label>
																	<input type="text" class="form-control" id="name_extension" name="name_extension">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 hrmo remdivabled">
																<div class="form-group">
																	<label class="control-label">User Level(s) <span class="required"> * </span> </label>
																	<select multiple="multiple" class="multi-select form-control" id="empUserLevel" name="empUserLevel" required>
																		<option value="1">Employee</option>
																		<optgroup label="HR">
																			<option value="3">HRMO</option>
																			<option value="9">DTR Admin</option>
																			<option value="23">Leave Admin</option>
																		</optgroup>
																		<?php 
																			if($this->session->userdata('id')==324)
																			{?>
																				<!-- <optgroup label="Accounting"> -->
																					<option value="26">Accountant</option>
																				<!-- </optgroup> -->
																				<!-- <optgroup label="Cash"> -->
																					<option value="25">Cashier</option>
																					<option value="27">MKLACC</option>
																				<!-- </optgroup> -->
																		<?php 
																			}
																		?>
																		<optgroup label="Mangement">
																			<option value="34">Unit Head / OIC</option>
																			<option value="7">Division Chief / OIC</option>
																			<option value="35">Deputy</option>
																			<option value="4">Director</option>
																		</optgroup>
																	</select>
																</div>
															</div>
															<div class="col-md-6 pass">
																<div class="form-group">
																	<label class="control-label">Employee Number <span class="required"> * </span> <span class="caption-helper"></span></label>
																	<input type="text" id="empNum" name="empNum" class="form-control divabled" placeholder="auto-generated" readonly>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">PNRI e-mail <span class="required"> * </span> </label>
																	<div class="input-group" style="text-align:left">
																		<input type="text" class="form-control mail" id="empEmail" name="empEmail" required>
																		<span class="input-group-btn">
																			<a href="javascript:;" class="btn default">@pnri.dost.gov.ph </a>
																		</span>
																	</div>
																	<span class="help-block mail font-red"></span>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Password <span class="caption-helper"></span></label>
																	<input type="password" id="empPass" name="empPass" class="form-control">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6 hrmo remdivabled">
																<div class="form-group">
																	<label class="control-label">Employee Status <span class="required"> * </span> </label>
																	<select id="empStat" name="empStat" class="select2me form-control" data-placeholder="Choose Status" tabindex="1" required onchange="checkEmpStatus()">
																		<option value="1">Permanent</option>
																		<option value="3">Project</option>
																		<option value="4">Contractual</option>
																		<option value="12">Resigned</option>
																		<option value="11">Retired</option>
																		<option value="20">Suspended</option>
																		<option value="17">Transferred</option>
																		<option value="18">Career Incentive Program</option>
																		<option value="19">Balik Scientist</option>
																		<option value="21">DOST S&T Fellow</option>
																	</select>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Division <span class="required"> * </span> </label>
																	<select id="empDiv" name="empDiv" class="select2me form-control" data-placeholder="Choose Division" tabindex="1" required>
																		<option value="1">Finance and Administrative Division (FAD)</option>
																		<option value="3">Atomic Research Division (ARD)</option>
																		<option value="4">Nuclear Services Division (NSD)</option>
																		<option value="12">Office of the Director (OD)</option>
																		<option value="13">Technology Diffusion Division (TDD)</option>
																		<option value="14">Nuclear Regulatory Division (NRD)</option>
																		<option value="15">Office of the Deputy Director (ODD)</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Position <span class="required"> * </span> </label>
																	<select id="empPos" name="empPos" class="select2me form-control" data-placeholder="Choose Position" tabindex="1" required>
																	</select>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Section <span class="required"> * </span> </label>
																	<select id="empSec" class="select2me form-control" data-placeholder="Choose Section" tabindex="1" required></select>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Item Number <span class="required"> * </span> </label>
																	<select id="plantilla" name="plantilla" class="select2me form-control" data-placeholder="Choose Item Number" tabindex="1" required>
																	</select>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Step Type <span class="required"> * </span> </label>
																	<select id="empStep" name="empStep" class="form-control" required>
																		<option value="step_1" selected>Step 1</option>
																		<option value="step_2">Step 2</option>
																		<option value="step_3">Step 3</option>
																		<option value="step_4">Step 4</option>
																		<option value="step_5">Step 5</option>
																		<option value="step_6">Step 6</option>
																		<option value="step_7">Step 7</option>
																		<option value="step_8">Step 8</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Appointment Date <span class="required"> * </span> </label>
																	<input id="empAppDate" name="empAppDate" class="form-control form-control-inline input-medium date-picker" data-date-format="yyyy-mm-dd" type="text" value="" required>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Assumption Date <span class="required"> * </span> </label>
																	<input id="empAssDate" name="empAssDate" class="form-control form-control-inline input-medium date-picker" data-date-format="yyyy-mm-dd" type="text" value="" required>
																</div>
															</div>
														</div>
														<input type="" class="hidden" id="sbg" class="form-control">
													</div>
													<div class="actions hrmo revme remdivabled divabled">
														<a class="btn blue hidden btnNext">
															<i class="fa fa-arrow-circle-right"> Next</i>
														</a>
														<a class="btn green btnSubmit" id="btnSaveAccount" name="EMPLOYEE ACCOUNT">
															<i class="fa fa-save"> Save</i>
														</a>
														<a class="btn default">
															<i class="fa fa-times" onclick="cancelNew()"> Cancel</i>
														</a>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane tb2 tp" id="tab_1_2">
								<div class="row">
									<div class="col-md-12">
										<div class="portlet light bordered">
											<div class="portlet-body form">
												<form class="horizontal-form clrme">
													<div class="form-body" id="frmPersonInfo">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Date of Birth <span class="required"> * </span> </label>
																	<!-- <input type="text" class="form-control" id="birthday" name="birthday"> -->
																	<input id="birthday" name="birthday" class="form-control form-control-inline input-medium date-picker" data-date-format="yyyy-mm-dd" type="text" value="" required>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Place of Birth <span class="required"> * </span> </label>
																	<input type="text" class="form-control" id="birthplace" name="birthplace" required>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Gender <span class="required"> * </span> </label>
																	<div class="radio-list">
																		<label class="radio-inline">
																		<input type="radio" id="genderM" name="gender" value="M" required> Male </label>
																		<label class="radio-inline">
																		<input type="radio" id="genderF" name="gender" value="F" checked required> Female </label>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Civil Status <span class="required"> * </span> </label>
																	<select class="form-control" id="civil_status" name="civil_status" required>
																		<option>Single</option>
																		<option>Married</option>
																		<option>Separated</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Citizenship <span class="required"> * </span> </label>
																	<input type="text" value="FILIPINO" class="form-control" id="citizenship" name="citizenship" required>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Local Number</label>
																	<input type="text" class="form-control" id="local_number" name="local_number">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Personal Email address</label>
																	<input type="text" class="form-control email" id="email_address" name="email_address">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Cellphone No</label>
																	<input type="text" class="form-control" id="mobile_phone" name="mobile_phone">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Height (m)</label>
																	<input type="number" class="form-control" id="height" name="height">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Weight (kg)</label>
																	<input type="number" class="form-control" id="weight" name="weight">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">Blood Type</label>
																	<input type="text" class="form-control" id="blood_type" name="blood_type">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">TIN</label>
																	<input type="text" class="form-control" id="tin" name="tin">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">GSIS ID</label>
																	<input type="text" class="form-control" id="gsis_id_num" name="gsis_id_num">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">PAG-Ibig No</label>
																	<input type="text" class="form-control" id="pagibig_id_num" name="pagibig_id_num">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">PhilHealth ID</label>
																	<input type="text" class="form-control" id="philhealth_num" name="philhealth_num">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="control-label">SSS No</label>
																	<input type="text" class="form-control" id="sss_num" name="sss_num">
																</div>
															</div>
														</div>
														<h3 class="form-section">Residential Address</h3> 
														<div class="row">
															<div class="col-md-12 ">
																<div class="form-group">
																	<label>Street/Barangay</label>
																	<input type="text" class="form-control" id="rstreet" name="rstreet">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Town/City</label>
																	<input type="text" class="form-control" id="rtown" name="rtown">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Province</label>
																	<input type="text" class="form-control" id="rprovince" name="rprovince">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Zip Code</label>
																	<input type="number" class="form-control" id="rzip" name="rzip">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Country</label>
																	<input type="text" class="form-control" id="rcountry" name="rcountry" value="Philippines">
																</div>
															</div>
														</div>
														<!-- Same as above? <input type="checkbox" class="make-switch inline" data-on-text="Yes" data-off-text="No"> -->
														<h3 class="form-section">Permanent Address <span style="font-size: 12px !important;"><input type="checkbox" id="copyRes">Same as residential?</span></h3>
														
														<div class="row">
															<div class="col-md-12 ">
																<div class="form-group">
																	<label>Street/Barangay</label>
																	<input type="text" class="form-control" id="pstreet" name="pstreet">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Town/City</label>
																	<input type="text" class="form-control" id="ptown" name="ptown">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Province</label>
																	<input type="text" class="form-control" id="pprovince" name="pprovince">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label>Zip Code</label>
																	<input type="text" class="form-control" id="pzip" name="pzip">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label>Country</label>
																	<input type="text" class="form-control" id="pcountry" name="pcountry" value="Philippines">
																</div>
															</div>
														</div>
													</div>
													<div class="actions">
														<a class="btn blue hidden btnPrev" onclick="nextForm(1)">
															<i class="fa fa-arrow-circle-left"> Previous</i>
														</a>
														<a class="btn green btnSubmit" id="btnSavePersonInfo" name="PERSONAL INFORMATION">
															<i class="fa fa-save"> Save</i>
														</a>
														<a class="btn green hidden btnSubmit" id="btnSaveNewEmployee" name="NEW EMPLOYEE">
															<i class="fa fa-save"> Save</i>
														</a>
														<a class="btn default" onclick="cancelNew()">
															<i class="fa fa-times"> Cancel</i>
														</a>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane tb3 tp" id="tab_1_3">
								<div class="row">
									<div class="col-md-12">
										<div class="portlet light bordered">
											<div class="portlet-body form">
												<!-- BEGIN FORM-->
												<form class="form-horizontal clrme">
													<div class="form-body">
														<h4 class="form-section">Spouse's Name</h4>
														<div class="form-group">
															<label class="col-md-3 control-label">First Name</label>
															<div class="col-md-6">
																<input type="text" class="form-control" id="spsFname">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Middle Name</label>
															<div class="col-md-6">
																<input type="text" class="form-control" id="spsMname">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Last Name</label>
															<div class="col-md-6">
																<input type="text" class="form-control" id="spsLname">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Occupation</label>
															<div class="col-md-6">
																<input type="text" class="form-control" id="spsOccupation">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Employer/Business Name</label>
															<div class="col-md-6">
																<input type="text" class="form-control" id="spsEmployer">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Business Address</label>
															<div class="col-md-6">
																<!-- <input type="text" class="form-control" id="spsAdd"> -->
																<textarea class="form-control" id="spsAdd"></textarea>
															</div>
														</div>
														<div class="form-group last">
															<label class="col-md-3 control-label">Telephone No</label>
															<div class="col-md-6">
																<input type="text" class="form-control" id="spsTel">
															</div>
														</div>
														<h4 class="form-section">Father's Name</h4>
														<div class="form-group">
															<label class="col-md-3 control-label">First Name</label>
															<div class="col-md-6">
																<input type="text" class="form-control" id="frFname">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Middle Name</label>
															<div class="col-md-6">
																<input type="text" class="form-control" id="frMname">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Last Name</label>
															<div class="col-md-6">
																<input type="text" class="form-control" id="frLname">
															</div>
														</div>
														<h4 class="form-section">Mother's Maiden Name</h4>
														<div class="form-group">
															<label class="col-md-3 control-label">First Name</label>
															<div class="col-md-6">
																<input type="text" class="form-control" id="mrFname">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Middle Name</label>
															<div class="col-md-6">
																<input type="text" class="form-control" id="mrMname">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-3 control-label">Last Name</label>
															<div class="col-md-6">
																<input type="text" class="form-control" id="mrLname">
															</div>
														</div>

														<script type="text/javascript">
															function removeRow(row, id, tbl, col)
															{
																var tblid = $(row).closest('table').attr('id')
																// console.log(tblid)
																if(id){
																	var r = confirm("Do you really want to proceed?");
																	if (r == true)
																		gdelete(tbl, col, id);
																	else
																		return false;
																}
																row.closest('tr').remove();
																
																if(($("#"+tblid).find('tr').length - 1) < 1){
																	// console.log($(row).closest('table').find("tr th").length)
																	// console.log($("#"+tblid).find('tr').length)
																	// console.log(($("#"+tblid).find('tr').length - 1) < 1)
																	$("#"+tblid).find('tbody').html("<tr><td colspan="+$("#"+tblid).find("tr th").length+" align='center'>No Record</tr>");
																}
															}

															function addChild()
															{
																$('#trChild1').remove();
																$('#tbChild').append("<tr>"+
																				"<td><input class='hidden chFid' name='chFid[]'><input class='form-control chFname' name='chFname[]'></td>"+
																				"<td><input class='form-control chMname' name='chMname[]'></td>"+
																				"<td><input class='form-control chLname' name='chLname[]'></td>"+
																				"<td><input class='form-control chBday' name='chBday[]'></td>"+
																				"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																			"</tr>");
																$('.chBday').inputmask({
																	mask: "y-1-2", 
																	placeholder: "yyyy-mm-dd", 
																	leapday: "-02-29", 
																	separator: "-", 
																	alias: "yyyy/mm/dd"
																});
															}
														</script>
														<input class="hidden" name="cntChild" id="cntChild" value="0" />
														<h4 style="float: left; width:102px!important;">Children</h4>
														<a style="float: right; width:102px!important;" onClick="addChild()" class="btn green-meadow btn-sm"><i class="fa fa-plus"></i> Add Child</a>
														<table class="table table-striped datatables table-bordered table-hover" id="tblChildren">
															<thead>
															<tr>
																<th>First Name <sup></th>
																<th>Middle Name</th>
																<th>Last Name</th>
																<th>Birthday</th>
																<th width="101px"><center>Action</center></th>
															</tr>
															</thead>
															<tbody id="tbChild">
																<tr id='trChild1' class='trChild1'>
																	<td colspan="5" align="center">No Child
																</tr>
															</tbody>
														</table>
													</div>
													<div class="actions">
														<a class="btn green btnSubmit" id="btnSaveFamily" name="EMPLOYEE FAMILY">
															<i class="fa fa-save"> Save</i>
														</a>
														<a class="btn default" onClick="getFamily()">
															<i class="fa fa-times"> Cancel</i>
														</a>
													</div>
												</form>
												<!-- END FORM-->
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane tb4 tp" id="tab_1_4">
								<div class="row">
									<div class="col-md-12">
										<div class="panel-group accordion" id="accordion1">
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1">
													III. EDUCATIONAL BACKGROUND </a>
													</h4>
												</div>
												<div id="collapse_1" class="panel-collapse in">
													<div class="panel-body form">
														<form class="form-horizontal clrme">
															<p>
															<script type="text/javascript">
																function addEduc()
																{
																	$('#trEduc1').remove();
																	$('#tbEduc').append("<tr>"+
																				"<td><input class='hidden educId' name='educId[]'>"+
																					"<select class='chosen-select form-control' name='educLevel[]'>"+
																						"<option>Elementary</option>"+
																						"<option>Secondary</option>"+
																						"<option>Vocational</option>"+
																						"<option>College</option>"+
																						"<option>Post BA/BS</option>"+
																						"<option>MS/MA</option>"+
																						"<option>PhD</option>"+
																						// "<option>Graduate Studies</option>"+
																					"</select>"+"</td>"+
																				"<td><textarea rows=4 class='form-control' name='educSchool[]'></textarea></td>"+
																				"<td><input class='form-control' name='educDegree[]'></td>"+
																				"<td><input class='form-control yr' name='educStart[]'></td>"+
																				"<td><input class='form-control yr' name='educEnd[]'></td>"+
																				"<td><input class='form-control' maxlength=3 name='educUnits[]'></td>"+
																				"<td><input class='form-control yr' name='educYear[]'></td>"+
																				"<td><input class='form-control' name='educHonors[]'></td>"+
																				"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																			"</tr>");
																			$('select').select2();
																														
																			$(".yr").inputmask("9999");
																			$(".yr").css("width","70px")
																}
															</script>

															<input class="hidden" name="cntq3" id="cntq3" value="0" />
															<input class="hidden" name="cntq3cur" id="cntq3cur" value="0" />
															<a style="float: right; width:102px!important;" id="btnq3" class="btn green-meadow btn-sm" onClick='addEduc()'><i class="fa fa-plus"></i> Education</a>
															<table class="table table-striped datatables table-bordered table-hover" id="tblEduc">
																<thead>
																<tr>
																	<th>Level <sup></th>
																	<th>School</th>
																	<th>Course</th>
																	<th>From</th>
																	<th>To</th>
																	<th>Units Earned</th>
																	<th>Yr Graduated</th>
																	<th>Honors</th>
																	<th width="101px"><center>Action</center></th>
																</tr>
																</thead>
																<tbody id="tbEduc">
																	<tr id='trEduc1' class='trEduc1'>
																		<td colspan="9" align="center">No Educational Background
																	</tr>
																</tbody>
															</table>
															</p>
															<p>
																<div class="actions">
																	<a class="btn green btnSubmit" id="btnSaveEduc" name="EMPLOYEE EDUCATION">
																		<i class="fa fa-save"> Save</i>
																	</a>
																	<a class="btn default" onClick="getEducation()">
																		<i class="fa fa-times"> Cancel</i>
																	</a>
																</div>
															</p>
														</form>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion1" href="#collapse_2">
													IV. CIVIL SERVICE ELIGIBILITY </a>
													</h4>
												</div>
												<div id="collapse_2" class="panel-collapse collapse">
													<div class="panel-body form">
														<form class="form-horizontal clrme">
															<p>
															<script type="text/javascript">
																function addExam()
																{
																	$('#trExam1').remove();
																	$('#tbExam').append("<tr>"+
																				"<td><input class='hidden' name='examId[]'>"+
																					"<input class='form-control' name='examName[]'></td>"+
																				"<td><input class='form-control rate' name='examRate[]'></td>"+
																				"<td><input class='form-control dt' name='examDate[]'></td>"+
																				"<td><input class='form-control' name='examPlace[]'></td>"+
																				"<td><input class='form-control' name='examLic[]'></td>"+
																				"<td><input class='form-control dt' name='examLicdt[]'></td>"+
																				"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																			"</tr>");
																	$('.dt').inputmask({
																		mask: "y-1-2", 
																		placeholder: "yyyy-mm-dd", 
																		leapday: "-02-29", 
																		separator: "-", 
																		alias: "yyyy/mm/dd"
																	});
																	$(".rate").css("width","70px")
																	$(".dt").css("width","125px")
																}
															</script>
															<a style="float: right; width:102px!important;" onClick="addExam()" class="btn green-meadow btn-sm"><i class="fa fa-plus"></i> Eligibility</a>
															<table class="table table-striped datatables table-bordered table-hover" id="tblExam">
																<thead>
																<tr>
																	<th style="width: 300px">Eligibility</th>
																	<th>Rating</th>
																	<th>Date of Exam</th>
																	<th>Place of Exam</th>
																	<th>License</th>
																	<th>Release Date</th>
																	<th width="101px"><center>Action</center></th>
																</tr>
																</thead>
																<tbody id="tbExam">
																	<tr id='trExam' class='trExam'>
																		<td colspan="7" align="center">No Eligibility
																	</tr>
																</tbody>
															</table>
															</p>
															<p>
																<div class="actions">
																	<a class="btn green btnSubmit" id="btnSaveElig" name="EMPLOYEE ELIGIBILITY">
																		<i class="fa fa-save"> Save</i>
																	</a>
																	<a class="btn default" onClick="getEligibility()">
																		<i class="fa fa-times"> Cancel</i>
																	</a>
																</div>
															</p>
														</form>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion1" href="#collapse_3">
													V. WORK EXPERIENCE </a>
													</h4>
												</div>
												<div id="collapse_3" class="panel-collapse collapse">
													<div class="panel-body form">
														<form class="form-horizontal clrme">
															<p>
															<script type="text/javascript">
																function addWork()
																{
																	$('#trWork1').remove();
																	$('#tbWork').append("<tr>"+
																				"<td><input class='hidden' name='workId[]'>"+
																					"<input class='form-control dt' name='workStart[]'></td>"+
																				"<td><input class='form-control dt' name='workEnd[]'></td>"+
																				"<td><input class='form-control' name='workPos[]'></td>"+
																				"<td><input class='form-control' name='workComp[]'></td>"+
																				"<td><input type=number class='form-control' name='workSalary[]'></td>"+
																				"<td><input class='form-control sg' name='workSG[]'></td>"+
																				"<td><select class='form-control' name=workApp[]>"+
																						"<option>Permanent</option>"+
																						"<option>Part-time</option>"+
																						"<option>Project</option>"+
																						"<option>Contractual</option>"+
																						"<option>Emergency</option>"+
																						"<option>Temporary</option>"+
																						"<option>Transferred</option>"+
																						"<option>Career Incentive Program</option>"+
																						"<option>Balik Scientist</option>"+
																					"</select></td>"+
																				"<td><select class='form-control' name=workGov[]>"+
																						"<option>No</option>"+
																						"<option>Yes</option>"+
																					"</select></td>"+
																				"<td><select class='form-control' name=workPNRI[]>"+
																						"<option>No</option>"+
																						"<option>Yes</option>"+
																					"</select></td>"+
																				"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																			"</tr>");
																	$('select').select2();
																	$('.dt').inputmask({
																		mask: "y-1-2", 
																		placeholder: "yyyy-mm-dd", 
																		leapday: "-02-29", 
																		separator: "-", 
																		alias: "yyyy/mm/dd"
																	});
																	$(".dt").css("width","125px")
																	$('.sg').inputmask({mask: "99-9"});
																}
															</script>
															<a style="float: right; width:102px!important;" onClick=addWork() class="btn green-meadow btn-sm"><i class="fa fa-plus"></i> Add Work</a>
															<table class="table table-striped datatables table-bordered table-hover" id="tblWork">
																<thead>
																<tr>
																	<th>Start</th>
																	<th>End</th>
																	<th>Position</th>
																	<th>Company</th>
																	<th>Monthly Salary</th>
																	<th>Grade & Step</th>
																	<th>Appointment</th>
																	<th>Gov't?</th>
																	<th>PNRI?</th>
																	<th width="101px"><center>Action</center></th>
																</tr>
																</thead>
																<tbody id="tbWork">
																	<tr id='trWork1' class='trWork1'>
																		<td colspan="10" align="center">No Work Experience
																	</tr>
																</tbody>
															</table>
															</p>
															<p>
																<div class="actions">
																	<a class="btn green btnSubmit" id="btnSaveWork" name="EMPLOYEE WORK EXPERIENCE">
																		<i class="fa fa-save"> Save</i>
																	</a>
																	<a class="btn default" onClick="getWork()">
																		<i class="fa fa-times"> Cancel</i>
																	</a>
																</div>
															</p>
														</form>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion1" href="#collapse_4">
													VI. VOLUNTARY WORK OR INVOLVEMENT TO CIVIC/NON-GOVERNMENT/PEOPLE/ORGANIZATION </a>
													</h4>
												</div>
												<div id="collapse_4" class="panel-collapse collapse">
													<div class="panel-body form">
														<form class="form-horizontal clrme">
															<p>
															<script type="text/javascript">
																function addVol()
																{
																	$('#trVol1').remove();
																	$('#tbVol').append("<tr>"+
																				"<td><input class='hidden' name='volId[]'>"+
																					"<input class='form-control' name='volOrg[]'></td>"+
																				"<td><input class='form-control dt' name='volStart[]'></td>"+
																				"<td><input class='form-control dt' name='volEnd[]'></td>"+
																				"<td><input type=number class='form-control' name='volHrs[]'></td>"+
																				"<td><input class='form-control' name='volPos[]'></td>"+
																				"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																			"</tr>");
																	$('.dt').inputmask({
																		mask: "y-1-2", 
																		placeholder: "yyyy-mm-dd", 
																		leapday: "-02-29", 
																		separator: "-", 
																		alias: "yyyy/mm/dd"
																	});
																	$(".dt").css("width","125px")
																}
															</script>
															<a style="float: right; width:102px!important;" onClick='addVol()' class="btn green-meadow btn-sm"><i class="fa fa-plus"></i> Add Org</a>
															<table class="table table-striped datatables table-bordered table-hover" id="tblVol">
																<thead>
																<tr>
																	<th>Organization</th>
																	<th>From</th>
																	<th>To</th>
																	<th>Hours</th>
																	<th>Position</th>
																	<th width="101px"><center>Action</center></th>
																</tr>
																</thead>
																<tbody id="tbVol">
																	<tr id='trVol1' class='trVol1'>
																		<td colspan="6" align="center">No Voluntary Work
																	</tr>
																</tbody>
															</table>
															</p>
															<p>
																<div class="actions">
																	<a class="btn green btnSubmit" id="btnSaveVol" name="EMPLOYEE VOLUNTARY EXPERIENCE">
																		<i class="fa fa-save"> Save</i>
																	</a>
																	<a class="btn default" onClick="getVol()">
																		<i class="fa fa-times"> Cancel</i>
																	</a>
																</div>
															</p>
														</form>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
													<a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion1" href="#collapse_5">
													VII. TRAINING PROGRAMS </a>
													</h4>
												</div>
												<div id="collapse_5" class="panel-collapse collapse">
													<div class="panel-body form">
														<form class="form-horizontal clrme">
															<p>
															<script type="text/javascript">
																function addTrain()
																{
																	$('#trTrain1').remove();
																	$('#tbTrain').append("<tr>"+
																				"<td><input class='hidden' name='trainId[]'>"+
																					"<input class='form-control' name='trainTitle[]'></td>"+
																				"<td><input class='form-control dt' name='trainStart[]'></td>"+
																				"<td><input class='form-control dt' name='trainEnd[]'></td>"+
																				"<td><input type=number class='form-control' name='trainHrs[]'></td>"+
																				"<td><input class='form-control' name='trainSponsor[]'></td>"+
																				"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																			"</tr>");
																	$('.dt').inputmask({
																		mask: "y-1-2", 
																		placeholder: "yyyy-mm-dd", 
																		leapday: "-02-29", 
																		separator: "-", 
																		alias: "yyyy/mm/dd"
																	});
																	$(".dt").css("width","125px")
																}
															</script>
															<a style="float: right; width:102px!important;" onClick="addTrain()" class="btn green-meadow btn-sm"><i class="fa fa-plus"></i> Training</a>
															<table class="table table-striped datatables table-bordered table-hover" id="tblTrain">
																<thead>
																<tr>
																	<th>Title</th>
																	<th>From</th>
																	<th>To</th>
																	<th>Hours</th>
																	<th>Sponsored by</th>
																	<th width="101px"><center>Action</center></th>
																</tr>
																</thead>
																<tbody id="tbTrain">
																	<tr id='trTrain1' class='trTrain1'>
																		<td colspan="6" align="center">No Training Program
																	</tr>
																</tbody>
															</table>
															</p>
															<p>
																<div class="actions">
																	<a class="btn green btnSubmit" id="btnSaveTraining" name="EMPLOYEE TRAINING EXPERIENCE">
																		<i class="fa fa-save"> Save</i>
																	</a>
																	<a class="btn default" onClick="getTrain()">
																		<i class="fa fa-times"> Cancel</i>
																	</a>
																</div>
															</p>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane tb5 tp" id="tab_1_5">
								<div class="row">
									<div class="col-md-12">
										<div class="portlet light bordered">
											<div class="portlet-body form">
												<!-- BEGIN FORM-->
												<form class="form-horizontal clrme">
													<div class="form-body">
														<!-- <h3 class="form-section">VIII. LEGAL INFORMATION</h3> -->
														<div class="form-group col-md-12">
															<label class="control-label">
																<div align="left">
																34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be apppointed,
																	<br><br>
																	a. within the third degree?<input class="hidden" name="legalq[]" value="1">
																		<div class="radio-list">
																			<label class="radio-inline"><input type="radio" class="legala" name="legala1" value="1"> YES </label>
																			<label class="radio-inline"><input type="radio" class="legala" name="legala1" value="0" checked> NO </label>
																			<textarea class="hidden" style="resize:vertical" name="legalp[]" id="legalp1"></textarea>
																		</div>
																	<br>
																	b. within the fourth degree (for Local Government Unit - Career Employees)?<input class="hidden" name="legalq[]" value="2">
																		<div class="radio-list">
																			<label class="radio-inline"><input type="radio" class="legala" name="legala2" value="1"> YES </label>
																			<label class="radio-inline"><input type="radio" class="legala" name="legala2" value="0" checked> NO </label>
																		</div>
																	<br>
																	If YES, Please give details:<br>
																	<textarea class="form-control" style="resize:vertical" name="legalp[]"id="legalp2"></textarea>
																	<br>
																	35. a. Have you ever been found guilty of any administrative offense?<input class="hidden" name="legalq[]" value="3">
																		<div class="radio-list">
																			<label class="radio-inline"><input type="radio" class="legala" name="legala3" value="1"> YES </label>
																			<label class="radio-inline"><input type="radio" class="legala" name="legala3" value="0" checked> NO </label>
																		</div>
																	<br>
																	If YES, give details<br>
																	<textarea class="form-control" style="resize:vertical" name="legalp[]"id="legalp3"></textarea>
																	<br>
																	b. Have you been criminally charged before any court?<input class="hidden" name="legalq[]" value="4">
																		<div class="radio-list">
																			<label class="radio-inline"><input type="radio" class="legala" name="legala4" value="1"> YES </label>
																			<label class="radio-inline"><input type="radio" class="legala" name="legala4" value="0" checked> NO </label>
																		</div>
																	<br>
																	If YES, give details<br>
																	Date Filed: <input id="legaldt" name="legaldt" class="form-control form-control-inline input-medium date-picker" data-date-format="yyyy-mm-dd" type="text">
																	Status of Case/s:
																	<textarea class="form-control" style="resize:vertical" name="legalp[]"id="legalp4"></textarea>
																	<br>
																	36. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?<input class="hidden" name="legalq[]" value="5">
																		<div class="radio-list">
																			<label class="radio-inline"><input type="radio" class="legala" name="legala5" value="1"> YES </label>
																			<label class="radio-inline"><input type="radio" class="legala" name="legala5" value="0" checked> NO </label>
																		</div>
																	<br>
																	If YES, give details<br>
																	<textarea class="form-control" style="resize:vertical" name="legalp[]"id="legalp5"></textarea>
																	<br>
																	37. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?<input class="hidden" name="legalq[]" value="6">
																		<div class="radio-list">
																			<label class="radio-inline"><input type="radio" class="legala" name="legala6" value="1"> YES </label>
																			<label class="radio-inline"><input type="radio" class="legala" name="legala6" value="0" checked> NO </label>
																		</div>
																	<br>
																	If YES, give details<br>
																	<textarea class="form-control" style="resize:vertical" name="legalp[]"id="legalp6"></textarea>
																	<br>
																	38. a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?<input class="hidden" name="legalq[]" value="7">
																		<div class="radio-list">
																			<label class="radio-inline"><input type="radio" class="legala" name="legala7" value="1"> YES </label>
																			<label class="radio-inline"><input type="radio" class="legala" name="legala7" value="0" checked> NO </label>
																			<textarea class="form-control" style="resize:vertical" name="legalp[]"id="legalp7"></textarea>
																		</div>
																	<br>
																	b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?<input class="hidden" name="legalq[]" value="8">
																		<div class="radio-list">
																			<label class="radio-inline"><input type="radio" class="legala" name="legala8" value="1"> YES </label>
																			<label class="radio-inline"><input type="radio" class="legala" name="legala8" value="0" checked> NO </label>
																		</div>
																	<br>
																	If YES, give details<br>
																	<textarea class="form-control" style="resize:vertical" name="legalp[]"id="legalp8"></textarea>
																	<br>
																	39. Have you acquired the status of an immigrant or permanent resident of another country?<input class="hidden" name="legalq[]" value="9">
																		<div class="radio-list">
																			<label class="radio-inline"><input type="radio" class="legala" name="legala9" value="1"> YES </label>
																			<label class="radio-inline"><input type="radio" class="legala" name="legala9" value="0" checked> NO </label>
																		</div>
																	<br>
																	If YES, give details (country): <br>
																	<textarea class="form-control" style="resize:vertical" name="legalp[]"id="legalp9"></textarea>
																	<br>
																	40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:
																	<br>
																	a. Are you a member of any indigenous group?<input class="hidden" name="legalq[]" value="10">
																		<div class="radio-list">
																			<label class="radio-inline"><input type="radio" class="legala" name="legala10" value="1"> YES </label>
																			<label class="radio-inline"><input type="radio" class="legala" name="legala10" value="0" checked> NO </label>
																		</div>
																	<br>
																	If YES, please specify<br>
																	<textarea class="form-control" style="resize:vertical" name="legalp[]"id="legalp10"></textarea>
																	<br>
																	b. Are you a person with disability?<input class="hidden" name="legalq[]" value="11">
																		<div class="radio-list">
																			<label class="radio-inline"><input type="radio" class="legala" name="legala11" value="1"> YES </label>
																			<label class="radio-inline"><input type="radio" class="legala" name="legala11" value="0" checked> NO </label>
																		</div>
																	<br>
																	If YES, please specify ID No: <br>
																	<textarea class="form-control" style="resize:vertical" name="legalp[]"id="legalp11"></textarea>
																	<br>
																	c. Are you a solo parent?<input class="hidden" name="legalq[]" value="12">
																		<div class="radio-list">
																			<label class="radio-inline"><input type="radio" class="legala" name="legala12" value="1"> YES </label>
																			<label class="radio-inline"><input type="radio" class="legala" name="legala12" value="0" checked> NO </label>
																		</div>
																	<br>
																	If YES, please specify ID No: <br>
																	<textarea class="form-control" style="resize:vertical" name="legalp[]"id="legalp12"></textarea>
																	<br>
																	<!-- <table border='1' cellpadding="5" cellspacing="5"><tr><td>
																		<div style="margin:5px">
																		**<font color="red">Solo Parent</font> as defined in Section 3 of Republic Act No. 8972 refers to any indiviual who falls uder any of the following categories:
																			<ol type="a">
																				<li>
																					<font color="red"></font> A woman who gives birth as a result of rape and other crimes against chastity even without a final conviction of the offender:Provided that the mother keeps and raises the child;
																				</li>
																				<li>
																					<font color="red"></font> Parent left solo or alone with the responsibility of parenthood due to the death of spouse;
																				</li>
																				<li>
																					<font color="red"></font> Parent left solo or alone with the responsibility of parenthood while the spouse is detained, or is serving sentence for a criminal conviction for at least one(1) year;
																				</li>
																				<li>
																					<font color="red"></font> Parent left solo or alone with the responsibility of parenthood due to physical and/or mental incapacity of spouse as certified by a public medical practitioner;
																				</li>
																				<li>
																					<font color="red"></font> Parent left solo or alone with the responsibility of parenthood due to legal separation or defacto separation from spouse for at least one (1) year, as long as he/she is entrusted with the custody of the children;
																				</li>
																				<li>
																					<font color="red"></font> Parent left solo or alone with the responsibility of parenthood due to declaration of nullity or annulment of marriage as decreed by a court or by a church as long as he/she is entrusted with the custody of the children;
																				</li>
																				<li>
																					<font color="red"></font> Parent left solo or alone with the responsibility of parenthood due to abandonment of spouse for at least one (1) year;
																				</li>
																				<li>
																					<font color="red"></font> Unmarried mother/father who chooses to keep and rear her/his child/children instead of having others care for them or giving them up to a welfare institution;
																				</li>
																				<li>
																					<font color="red"></font> Any other person who solely provides parental care and support to a child or children;
																				</li>
																				<li>
																					<font color="red"></font> Any family member who assumes the responsibility of head of family as a result of the death, abandonment, disappearance or prolonged absence of the parents or solo parent.
																				</li>
																			</ol>
																		</div>
																	</tr></table> -->
																</div>
															</label>
															<p>
																<div class="form-group">
																	<label class="col-md-3 control-label">Government Issued ID: </label>
																	<div class="col-md-7">
																		<input type="text" class="form-control" id="govIDName" placeholder="i.e.Passport, GSIS, SSS, PRC, Driver's License, etc.">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-3 control-label">ID/License/Passport No.: </label>
																	<div class="col-md-7">
																		<input type="text" class="form-control" id="govIDNo">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-3 control-label">Date:</label>
																	<div class="col-md-7">
																		<input id="govDate" name="govDate" class="form-control form-control-inline input-medium date-picker" data-date-format="yyyy-mm-dd" type="text">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-3 control-label">Place of Issuance:</label>
																	<div class="col-md-7">
																		<input type="text" class="form-control" id="govPlace">
																	</div>
																</div>
															</p><br>
														</div>

														<div class="form-group">
															<div class="col-md-4">
															</div>
														</div>
													</div>
													<p><h4>
														<input type="checkbox" name="declaration" id="declaration" value="agree" onclick="toggleCheckBox()"><span class=font-red> I declare under penalties of perjury that the answers given above are true and correct to the best of my knowledge and belief.</span></h4>
													</p>
													<div class="actions" id="bottom_buttons" hidden>
														<a class="btn green btnSubmit" id="btnSaveLegal" name="EMPLOYEE LEGAL INFO">
															<i class="fa fa-save"> Save</i>
														</a>
														<a class="btn default">
															<i class="fa fa-times"> Cancel</i>
														</a>
													</div>
												</form>
												<!-- END FORM-->
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane tb6 tp" id="tab_1_6">
								<div class="row">
									<div class="col-md-12">
										<div class="portlet light bordered">
											<div class="portlet-body form">
												<!-- BEGIN FORM-->
												<form class="form-horizontal clrme">
													REFERENCES (Person not related by consanguinity or affinity to applicant /appointee)
													<p>
														<table class="table table-striped datatables table-bordered table-hover" id="tblRef">
															<thead>
															<tr>
																<th>Name
																<th>Address
																<th>Telephone
															</tr>
															</thead>
															<tbody id="tbRef">
																<tr>
																	<td><input class='hidden' name='refId[]'>
																	<input class='form-control' name='refName[]'></td>
																	<td><input class='form-control' name='refAdd[]'></td>
																	<td><input class='form-control' name='refTel[]'></td>
																	<td><input class='hidden' name='refFlag[]' value="0"></td>
																</tr>
																<tr>
																	<td><input class='hidden' name='refId[]'>
																	<input class='form-control' name='refName[]'></td>
																	<td><input class='form-control' name='refAdd[]'></td>
																	<td><input class='form-control' name='refTel[]'></td>
																	<td><input class='hidden' name='refFlag[]' value="0"></td>
																</tr>
																<tr>
																	<td><input class='hidden' name='refId[]'>
																	<input class='form-control' name='refName[]'></td>
																	<td><input class='form-control' name='refAdd[]'></td>
																	<td><input class='form-control' name='refTel[]'></td>
																	<td><input class='hidden' name='refFlag[]' value="0"></td>
																</tr>
																<tr>
																	<td colspan=3>PERSON TO CONTACT IN CASE OF EMERGENCY
																</tr>
																<tr>
																	<td><input class='hidden' id='erId' name='refId[]'>
																		<input class='form-control' id='erName' name='refName[]'></td>
																	<td><input class='form-control' id='erAdd' name='refAdd[]'></td>
																	<td><input class='form-control' id='erTel' name='refTel[]'></td>
																	<td><input class='hidden' id='erFlag' name='refFlag[]' value="1"></td>
																</tr>
															</tbody>
														</table>
													</p>
													<p>
														<div class="actions">
															<a class="btn green btnSubmit" id="btnSaveRef" name="EMPLOYEE REFERENCES">
																<i class="fa fa-save"> Save</i>
															</a>
															<a class="btn default" onClick="getEducation()">
																<i class="fa fa-times"> Cancel</i>
															</a>
														</div>
													</p>
												</form>
												<!-- END FORM-->
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane tb6 tp" id="tab_1_7">
								<div class="row">
									<div class="col-md-12">
										<div class="portlet light bordered">
											<div class="portlet-body form">
												<!-- BEGIN FORM-->
												<form class="form-horizontal clrme">
													<p>
													<script type="text/javascript">
														function addSkill()
														{
															$('#tbSkill').append("<tr>"+
																		"<td><input class='form-control' name='skills[]'></td>"+
																		"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																	"</tr>");
														}
														function addRecog()
														{
															$('#tbRecog').append("<tr>"+
																		"<td><input class='form-control' name='recognitions[]'></td>"+
																		"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																	"</tr>");
														}
														function addOrg()
														{
															$('#tbOrg').append("<tr>"+
																		"<td><input class='form-control' name='orgs[]'></td>"+
																		"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																	"</tr>");
														}
														function addPublications()
														{
															$('#tbPublications').append("<tr>"+
																		"<td><input class='form-control' name='publications[]'></td>"+
																		"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																	"</tr>");
														}
														function addTrainConducted()
														{
															$('#tbTrainConducted').append("<tr>"+
																		"<td><input class='form-control' name='trainConducted[]'></td>"+
																		"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																	"</tr>");
														}
														function addPrjInvolve()
														{
															$('#tbPrjInvolve').append("<tr>"+
																		"<td><input class='form-control' name='prjInvolve[]'></td>"+
																		"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																	"</tr>");
														}
														function addPrjLead()
														{
															$('#tbPrjLead').append("<tr>"+
																		"<td><input class='form-control' name='prjLead[]'></td>"+
																		"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																	"</tr>");
														}
														function addAwards()
														{
															$('#tbAwards').append("<tr>"+
																		"<td><input class='form-control' name='awards[]'></td>"+
																		"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick='removeRow(this,0,0,0)'><i class='ace-icon fa fa-times'></i> </button></td>"+
																	"</tr>");
														}
														function toggleCheckBox(){
														if($("#declaration").attr("checked"))
															$("#bottom_buttons").show();
														else
															$("#bottom_buttons").hide();
														}
													</script>
													<a style="float: right; width:102px!important;" id="btnq3" class="btn green-meadow btn-sm" onClick='addSkill()'><i class="fa fa-plus"></i> ADD</a>
													<table class="table table-striped datatables table-bordered table-hover" id="tblSkill">
														<thead>
														<tr>
															<th>Special Skills/Hobbies </th>
															<th width="101px"><center>Action</center></th>
														</tr>
														</thead>
														<tbody id="tbSkill">
														</tbody>
													</table>
													<br>
													<a style="float: right; width:102px!important;" id="btnq3" class="btn green-meadow btn-sm" onClick='addRecog()'><i class="fa fa-plus"></i> ADD</a>
													<table class="table table-striped datatables table-bordered table-hover" id="tblRecog">
														<thead>
														<tr>
															<th>Non-Academic Distinctions/Recognition (Write in full) </th>
															<th width="101px"><center>Action</center></th>
														</tr>
														</thead>
														<tbody id="tbRecog">
														</tbody>
													</table>
													<br>
													<a style="float: right; width:102px!important;" id="btnq3" class="btn green-meadow btn-sm" onClick='addOrg()'><i class="fa fa-plus"></i> ADD</a>
													<table class="table table-striped datatables table-bordered table-hover" id="tblOrg">
														<thead>
														<tr>
															<th>Membership in Association/Organization (Write in full) </th>
															<th width="101px"><center>Action</center></th>
														</tr>
														</thead>
														<tbody id="tbOrg">
														</tbody>
													</table>
													</p><br> 
													<p>
													<a style="float: right; width:102px!important;" id="btnq3" class="btn green-meadow btn-sm" onClick='addPublications()'><i class="fa fa-plus"></i> ADD</a>
													<table class="table table-striped datatables table-bordered table-hover" id="tblPublications">
														<thead>
														<tr>
															<th>PUBLICATIONS </th>
															<th width="101px"><center>Action</center></th>
														</tr>
														</thead>
														<tbody id="tbPublications">
														</tbody>
													</table>
													</p><br> 
													<p>
													<a style="float: right; width:102px!important;" id="btnq3" class="btn green-meadow btn-sm" onClick='addTrainConducted()'><i class="fa fa-plus"></i> ADD</a>
													<table class="table table-striped datatables table-bordered table-hover" id="tblTrainConducted">
														<thead>
														<tr>
															<th>TRAININGS CONDUCTED </th>
															<th width="101px"><center>Action</center></th>
														</tr>
														</thead>
														<tbody id="tbTrainConducted">
														</tbody>
													</table>
													</p><br> 
													<p>
													<a style="float: right; width:102px!important;" id="btnq3" class="btn green-meadow btn-sm" onClick='addPrjInvolve()'><i class="fa fa-plus"></i> ADD</a>
													<table class="table table-striped datatables table-bordered table-hover" id="tblPrjInvolve">
														<thead>
														<tr>
															<th>PROJECT INVOLVEMENT </th>
															<th width="101px"><center>Action</center></th>
														</tr>
														</thead>
														<tbody id="tbPrjInvolve">
														</tbody>
													</table>
													</p><br> 
													<p>
													<a style="float: right; width:102px!important;" id="btnq3" class="btn green-meadow btn-sm" onClick='addPrjLead()'><i class="fa fa-plus"></i> ADD</a>
													<table class="table table-striped datatables table-bordered table-hover" id="tblPrjLead">
														<thead>
														<tr>
															<th>PROJECT LEADERSHIP </th>
															<th width="101px"><center>Action</center></th>
														</tr>
														</thead>
														<tbody id="tbPrjLead">
														</tbody>
													</table>
													</p><br> 
													<p>
													<a style="float: right; width:102px!important;" id="btnq3" class="btn green-meadow btn-sm" onClick='addAwards()'><i class="fa fa-plus"></i> ADD</a>
													<table class="table table-striped datatables table-bordered table-hover" id="tblAwards">
														<thead>
														<tr>
															<th>AWARDS AND CITATIONS </th>
															<th width="101px"><center>Action</center></th>
														</tr>
														</thead>
														<tbody id="tbAwards">
														</tbody>
													</table>
													</p><br> 
													<p>
														<div class="actions">
															<a class="btn green btnSubmit" id="btnSaveOther" name="EMPLOYEE EDUCATION">
																<i class="fa fa-save"> Save</i>
															</a>
															<a class="btn default" onClick="getEducation()">
																<i class="fa fa-times"> Cancel</i>
															</a>
														</div>
													</p>
												</form>
												<!-- END FORM-->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--END TABS-->
				</div>
			</div>
		</div>
	</div>
	<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->

<script type="text/javascript">
	$(document).ready(function() {
		var $videoSrc;  
		$('.video-btn').click(function() {
		$videoSrc = $(this).data( "src" );
		});
		// console.log($videoSrc);
		$('#myModal').on('shown.bs.modal', function (e) {
		$("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" ); 
		})

		$('#myModal').on('hide.bs.modal', function (e) {
		$("#video").attr('src',$videoSrc); 
		}) 
		today = new Date()
		dayIndex = today.getDay();
		// console.log(<?php echo $this->session->userdata('isbday'); ?>)
		if(<?php echo $this->session->userdata('isbday'); ?>)
		   $( "#hbd"+dayIndex ).click();
	});
</script>
<script type="text/javascript">
ggetSections()
ggetPlantilla()
ggetPositions()

// if(myroles.toString() == "1"){
if(!myroles.includes("3")){
	// console.log(myroles.toString())
	$(".tb1").removeClass("active");
	$(".tb2").addClass("active");
}

function getEmployee() {
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{id:$('#ftrEmployee').val()},
      url:"<?=site_url('hr/employee/getEmployee');?>",
      success: function(data) {
			localStorage.removeItem('oPass');
			localStorage.setItem('oPass', data.password);
			localStorage.setItem('empstatus', data.employment_status_library_id);

			localStorage.setItem('oplantilla', data.plantilla_library_id);
			localStorage.setItem('oempStep', data.step_type);
			localStorage.setItem('oempAppDate', data.appointment_date);
			localStorage.setItem('oempAssDate', data.assumption_date);
			localStorage.setItem('ouid', data.users_id);

			ggetRoles(data.users_id, "#empUserLevel")
			$("#firstname").val(data.firstname);
			$("#middlename").val(data.middlename);
			$("#lastname").val(data.lastname);
			$("#name_extension").val(data.name_extension);
			$("#empNum").val(data.empno);
			$("#empPass").val(data.password);
			$("#empStat").val(data.employment_status_library_id);
			var email = data.asti_email.split('@');
			$("#empEmail").val(email[0]);

			$("#empDiv").val(data.division_id);
			$("#empSec").val(data.unit_id);
			$("#empPos").val(data.prid);
			var salary = data.step_type;
			$("#plantilla").val(data.plantilla_library_id);
			$("#empStep").val(data.step_type);
			$('#empAppDate').datepicker("setDate", data.appointment_date);
			$("#empAssDate").datepicker("setDate", data.assumption_date);
			$('select').select2();
			checkEmpStatus()
      },
      error: function(data){console.log("We encountered a problem!")}
	});
}

function checkEmpStatus() {
	//$('#ftrEmployee option:selected').data('stat')
	if((jQuery.inArray(localStorage.getItem('empstatus'), disabledEmpStatus) != -1) || (jQuery.inArray($('#ftrEmployee option:selected').data('stat'), disabledEmpStatus) != -1))// 
		$(".tab-pane").addClass("divabled");
	else
		$(".tab-pane").removeClass("divabled");

	if($("#empStat :selected").val()==1) {
		$("#plantilla").prop("required", true);
		$("#empStep").prop("required", true);
		$("#empAppDate").prop("required", true);
		$("#empAssDate").prop("required", true);
	} else {
		$("#plantilla").prop("required", false);
		$("#empStep").prop("required", false);
		$("#empAppDate").prop("required", false);
		$("#empAssDate").prop("required", false);
	}

    $("label.error, label.has-error").addClass("hidden");
    $("input.error").prop("style", "color: black;");
}

function getPersonalInfo() {
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{id:$('#ftrEmployee').val()},
      url:"<?=site_url('hr/employee/getPersonalInfo');?>",
      success: function(data) {
			// $("#birthday").val(data.birthday);
			$('#copyRes').prop("checked", false)
			localStorage.setItem('empstatus', data.status_id);
			$('#birthday').datepicker("setDate", data.birthday);
			$("#birthplace").val(data.birthplace);
			$("#gender"+data.gender).prop("checked", true);
			$("#civil_status").val(data.civil_status);
			$("#citizenship").val(data.citizenship);
			$("#local_number").val(data.local_number);
			$("#height").val(data.height);
			$("#weight").val(data.weight);
			$("#blood_type").val(data.blood_type);
			$("#gsis_id_num").val(data.gsis_id_num);
			$("#pagibig_id_num").val(data.pagibig_id_num);
			$("#philhealth_num").val(data.philhealth_num);
			$("#sss_num").val(data.sss_num);
			$("#tin").val(data.tin);
			$("#email_address").val(data.email_address);
			$("#mobile_phone").val(data.mobile_phone);
			$("#rstreet").val(data.rstreet);
			$("#rtown").val(data.rtown);
			$("#rprovince").val(data.rprovince);
			$("#rzip").val(data.rzip);
			$("#rcountry").val(data.rcountry);
			$("#pstreet").val(data.pstreet);
			$("#ptown").val(data.ptown);
			$("#pprovince").val(data.pprovince);
			$("#pzip").val(data.pzip);
			$("#pcountry").val(data.pcountry);
			$('select').select2();
			$.uniform.update();
			checkEmpStatus()
      },
      error: function(data){console.log("We encountered a problem!")}
	});
}

function getFamily() {
	// console.log($('#ftrEmployee option:selected').data('stat'))
	checkEmpStatus()
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{q:"select * from family where employee_employee_id="+$('#ftrEmployee').val()},
      url:"<?=site_url('hr/employee/getRecordArray');?>",
      success: function(data){
		var spouse = $.grep(data, function(obj){return obj.relationship === "Spouse";})[0];
		var mother = $.grep(data, function(obj){return obj.relationship === "Mother";})[0];
		var father = $.grep(data, function(obj){return obj.relationship === "Father";})[0];
		var child = $.grep(data, function(obj){return obj.relationship === "Child";});
		if(!jQuery.isEmptyObject(spouse)){
			$("#spsFname").val(spouse.firstname);
			$("#spsMname").val(spouse.middlename);
			$("#spsLname").val(spouse.lastname);
			$("#spsOccupation").val(spouse.occupation);
			$("#spsEmployer").val(spouse.employer);
			$("#spsAdd").val(spouse.employer_address);
			$("#spsTel").val(spouse.employer_telnum);
		}

		if(!jQuery.isEmptyObject(father)){
			$("#frFname").val(father.firstname);
			$("#frMname").val(father.middlename);
			$("#frLname").val(father.lastname);
		}

		if(!jQuery.isEmptyObject(mother)){
			$("#mrFname").val(mother.firstname);
			$("#mrMname").val(mother.middlename);
			$("#mrLname").val(mother.lastname);
		}
		$('#tbChild').empty()
		// console.log(child.length)
		if(child.length)
			child.forEach((number, index, array) => {
				$('#tbChild').append("<tr>"+
										"<td><input class='hidden chFid' name='chFid[]' value='"+array[index].family_id+"'><input class='form-control chFname' name='chFname[]' value='"+array[index].firstname+"'></td>"+
										"<td><input class='form-control chMname' name='chMname[]' value='"+array[index].middlename+"'></td>"+
										"<td><input class='form-control chLname' name='chLname[]' value='"+array[index].lastname+"'></td>"+
										"<td><input class='form-control chBday' name='chBday[]' value='"+array[index].birthday+"'></td>"+
										"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,"+array[index].family_id+",'infosys.family','family_id')><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
									"</tr>");
			});
		else
			$('#tbChild').html("<tr id='trChild1' class='trChild1'><td colspan=5 align='center'>No Child</tr>");
			
		$('.chBday').inputmask({
			mask: "y-1-2", 
			placeholder: "yyyy-mm-dd", 
			leapday: "-02-29", 
			separator: "-", 
			alias: "yyyy/mm/dd"
		});
      },
      error: function(data){console.log("We encountered a problem!")}
	});
}

function getQualification() {
	getEducation()
	getEligibility()
	getWork()
	getVol()
	getTrain()
	getLegal()
	getOtherInfo()
	
}

function getEducation() {
	checkEmpStatus()
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{q:"select * from education where employee_employee_id="+$('#ftrEmployee').val()+" ORDER BY CASE WHEN (year_graduated <> '0' AND CAST(year_graduated AS SIGNED) <> 0) THEN CAST(year_graduated AS SIGNED) ELSE 999999999 END DESC"},
      url:"<?=site_url('hr/employee/getRecordArray');?>",
      success: function(educ){
		$('#tbEduc').empty();
		if(educ.length){
			educ.forEach((number, index, array) => {
				$('#tbEduc').append("<tr>"+
										"<td><input class='hidden' name='educId[]' value='"+array[index].education_id+"'>"+
										"<select class='chosen-select form-control' name='educLevel[]'>"+
											"<option>"+array[index].level+"</option>"+
										"</select></td>"+
										"<td><textarea rows=4 class='form-control' name='educSchool[]'>"+array[index].school_name+"</textarea></td>"+
										"<td><input class='form-control' name='educDegree[]' value='"+array[index].degree_units_earned+"'></td>"+
										"<td><input class='form-control yr ' name='educStart[]' value='"+array[index].start_date+"'></td>"+
										"<td><input class='form-control yr' name='educEnd[]' value='"+array[index].end_date+"'></td>"+
										"<td><input class='form-control' maxlength=3 name='educUnits[]' value='"+array[index].highest_units_earned+"'></td>"+
										"<td><input class='form-control yr' name='educYear[]' value='"+array[index].year_graduated+"'></td>"+
										"<td><input class='form-control' name='educHonors[]' value='"+array[index].honors_received+"'></td>"+
										"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,"+array[index].education_id+",'infosys.education','education_id')><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
									"</tr>");
			});
		}
		else
			$('#tbEduc').html("<tr id='trEduc1' class='trEduc1'><td colspan=9 align='center'>No Educational Background</tr>");

		$(".yr").inputmask("9999");
		$(".yr").css("width","70px")
		$('select').select2();
      },
      error: function(data){console.log("We encountered a problem!")}
	});

}

function getEligibility() {
	checkEmpStatus()
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{q:"select * from examination where employee_employee_id="+$('#ftrEmployee').val()+" ORDER BY license_date DESC"},
      url:"<?=site_url('hr/employee/getRecordArray');?>",
      success: function(exam){
		$('#tbExam').empty();
		if(exam.length){
			exam.forEach((number, index, array) => {
				$('#tbExam').append("<tr>"+
										"<td><input class='hidden' name='examId[]' value='"+array[index].examination_id+"'>"+
											"<input class='form-control' name='examName[]' value='"+array[index].exam_doc+"'></td>"+
										"<td><input class='form-control rate' name='examRate[]' value='"+array[index].exam_rating+"'></td>"+
										"<td><input class='form-control dt' name='examDate[]' value='"+array[index].exam_date+"'></td>"+
										"<td><input class='form-control' name='examPlace[]' value='"+array[index].exam_location+"'></td>"+
										"<td><input class='form-control' name='examLic[]' value='"+array[index].license_number+"'></td>"+
										"<td><input class='form-control dt' name='examLicdt[]' value='"+array[index].license_date+"'></td>"+
										"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,"+array[index].examination_id+",'infosys.examination','examination_id')><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
									"</tr>");
			});
			$('.dt').inputmask({
				mask: "y-1-2", 
				placeholder: "yyyy-mm-dd", 
				leapday: "-02-29", 
				separator: "-", 
				alias: "yyyy/mm/dd"
			});
			$(".rate").css("width","70px")
			$(".dt").css("width","125px")
		}
		else
			$('#tbExam').html("<tr id='trExam1' class='trExam1'><td colspan=8 align='center'>No Eligibility</tr>");
      },
      error: function(data){console.log("We encountered a problem!")}
	});

}

function getWork() {
	checkEmpStatus()
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{q:"select * from service_record where employee_employee_id="+$('#ftrEmployee').val()+" ORDER BY start_date DESC"},
      url:"<?=site_url('hr/employee/getRecordArray');?>",
      success: function(work){
		$('#tbWork').empty();
		if(work.length){
			work.forEach((number, index, array) => {
					$('#tbWork').append("<tr>"+
						"<td><input class='hidden' name='workId[]' value='"+array[index].service_record_id+"'>"+
							"<input class='form-control dt' name='workStart[]' value='"+array[index].start_date+"'></td>"+
						"<td><input class='form-control dt' name='workEnd[]' value='"+array[index].end_date+"'></td>"+
						"<td><input class='form-control' name='workPos[]' value='"+array[index].position_desc+"'></td>"+
						"<td><input class='form-control' name='workComp[]' value='"+array[index].agency_dept_name+"'></td>"+
						"<td><input type=number class='form-control' name='workSalary[]' value='"+array[index].salary+"'></td>"+
						"<td><input class='form-control sg' name='workSG[]' value='"+array[index].salary_grade+"'></td>"+
						"<td><select class='chosen-select form-control' name='workApp[]'>"+
								"<option>"+array[index].appointment_status+"</option>"+
							"</select></td>"+
						"<td><select class='chosen-select form-control' name='workGov[]'>"+
								"<option>"+array[index].gov_service+"</option>"+
							"</select></td>"+
						"<td><select class='chosen-select form-control' name='workPNRI[]'>"+
								"<option>"+array[index].within_pnri+"</option>"+
							"</select></td>"+
						"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,"+array[index].service_record_id+",'infosys.service_record','service_record_id')><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
					"</tr>");
			});
		}
		else
			$('#tbWork').html("<tr id='trWork1' class='trWork1'><td colspan=10 align='center'>No Work Experience</tr>");
		$('select').select2();
		$('.dt').inputmask({
			mask: "y-1-2", 
			placeholder: "yyyy-mm-dd", 
			leapday: "-02-29", 
			separator: "-", 
			alias: "yyyy/mm/dd"
		});
		$('.sg').inputmask({mask: "99-9"});
		$(".dt").css("width","125px")
      },
      error: function(data){console.log("We encountered a problem!")}
	});

}

function getVol() {
	checkEmpStatus()
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{q:"select * from voluntary_work where employee_employee_id="+$('#ftrEmployee').val()+" ORDER BY start_date DESC"},
      url:"<?=site_url('hr/employee/getRecordArray');?>",
      success: function(voluntary){
		$('#tbVol').empty();
		if(voluntary.length){
			voluntary.forEach((number, index, array) => {
					$('#tbVol').append("<tr>"+
						"<td><input class='hidden' name='volId[]' value='"+array[index].voluntary_work_id+"'>"+
							"<input class='form-control' name='volOrg[]' value='"+array[index].organization_info+"'></td>"+
						"<td><input class='form-control dt' name='volStart[]' value='"+array[index].start_date+"'></td>"+
						"<td><input class='form-control dt' name='volEnd[]' value='"+array[index].end_date+"'></td>"+
						"<td><input type=number class='form-control' name='volHrs[]' value='"+array[index].work_duration_hrs+"'></td>"+
						"<td><input class='form-control' name='volPos[]' value='"+array[index].pos_or_nature+"'></td>"+
						"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,"+array[index].voluntary_work_id+",'infosys.voluntary_work','voluntary_work_id')><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
					"</tr>");
			});
		}
		else
			$('#tbVol').html("<tr id='trVol1' class='trVol1'><td colspan=10 align='center'>No Voluntary Experience</tr>");
		$('.dt').inputmask({
			mask: "y-1-2", 
			placeholder: "yyyy-mm-dd", 
			leapday: "-02-29", 
			separator: "-", 
			alias: "yyyy/mm/dd"
		});
		$(".dt").css("width","125px")
      },
      error: function(data){console.log("We encountered a problem!")}
	});

}

function getTrain() {
	checkEmpStatus()
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{q:"select * from training where employee_employee_id="+$('#ftrEmployee').val()+" ORDER BY start_date DESC"},
      url:"<?=site_url('hr/employee/getRecordArray');?>",
      success: function(train){
		$('#tbTrain').empty();
		if(train.length){
			train.forEach((number, index, array) => {
					$('#tbTrain').append("<tr>"+
						"<td><input class='hidden' name='trainId[]' value='"+array[index].training_id+"'>"+
							"<input class='form-control' name='trainTitle[]' value='"+array[index].training_desc+"'></td>"+
						"<td><input class='form-control dt' name='trainStart[]' value='"+array[index].start_date+"'></td>"+
						"<td><input class='form-control dt' name='trainEnd[]' value='"+array[index].end_date+"'></td>"+
						"<td><input type=number class='form-control' name='trainHrs[]' value='"+array[index].training_duration_hrs+"'></td>"+
						"<td><input class='form-control' name='trainSponsor[]' value='"+array[index].training_sponsor+"'></td>"+
						"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,"+array[index].training_id+",'infosys.training','training_id')><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
					"</tr>");
			});
		}
		else
			$('#tbTrain').html("<tr id='trTrain1' class='trTrain1'><td colspan=10 align='center'>No Training Experience</tr>");
		$('.dt').inputmask({
			mask: "y-1-2", 
			placeholder: "yyyy-mm-dd", 
			leapday: "-02-29", 
			separator: "-", 
			alias: "yyyy/mm/dd"
		});
		$(".dt").css("width","125px")
      },
      error: function(data){console.log("We encountered a problem!")}
	});

}

function getLegal() {
	checkEmpStatus()
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{q:"select * from legalinfo where employee_employee_id="+$('#ftrEmployee').val()+" ORDER BY legalissue"},
      url:"<?=site_url('hr/employee/getRecordArray');?>",
      success: function(legal){
		if(legal.length){
			legal.forEach((number, index, array) => {
				if(array[index].legalissue){
					// console.log(array[index].particulars)
					$("input[name=legala"+array[index].legalissue+"][value='"+array[index].answer+"']").prop("checked", true);
					$("input[name=legala"+array[index].legalissue+"][value='"+array[index].answer+"']").trigger('click');
					$("#legalp"+array[index].legalissue).val(array[index].particulars);
					if(array[index].legalissue==4)
						$("#legaldt").val((array[index].datefiled=="0000-00-00") ? "" :  array[index].datefiled)
				}
			});
		}
      },
      error: function(data){console.log("We encountered a problem!")}
	});
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{q:"select * from identification where employee_employee_id="+$('#ftrEmployee').val()},
      url:"<?=site_url('hr/employee/getRecordArray');?>",
      success: function(ref){
		if(ref.length){
			ref.forEach((number, index, array) => {
				$("#govIDName").val(array[index].id_name);
				$("#govIDNo").val(array[index].id_no);
				$("#govDate").val(array[index].id_date);
				$("#govPlace").val(array[index].id_place);
			});
		}
      },
      error: function(data){console.log("We encountered a problem!")}
	});
}

function getOtherInfo() {
	$('#tbSkill').empty()
	$('#tbRecog').empty()
	$('#tbOrg').empty()
	$('#tbPublications').empty()
	$('#tbTrainConducted').empty()
	$('#tbPrjInvolve').empty()
	$('#tbPrjLead').empty()
	$('#tbAwards').empty()
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{q:"select o.*, special_skills, organizations, recognitions from employee e left join pds_additionalinfo o on e.employee_id = o.employee_employee_id where employee_id="+$('#ftrEmployee').val()},
      url:"<?=site_url('hr/employee/getRecordArray');?>",
      success: function(addinfo){
		if(addinfo.length){
			addinfo.forEach((number, index, array) => {
				var arr = array[index].special_skills ? array[index].special_skills.split("\n") : "";
				$.each( arr, function( index, value ) {
					$('#tbSkill').append("<tr>"+
							"<td><input class='form-control' name='skills[]' value='"+value+"'></td>"+
							"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,0,0,0)><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
						"</tr>");
				});
				var arr = array[index].recognitions ? array[index].recognitions.split("\n") : "";
				$.each( arr, function( index, value ) {
					$('#tbRecog').append("<tr>"+
						"<td><input class='form-control' name='recognitions[]' value='"+value+"'></td>"+
						"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,0,0,0)><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
					"</tr>");
				});
				var arr = array[index].organizations ? array[index].organizations.split(/\n/) : "";
				// var arr = array[index].organizations.split("\n");
				$.each( arr, function( index, value ) {
					$('#tbOrg').append("<tr>"+
						"<td><input class='form-control' name='orgs[]' value='"+value+"'></td>"+
						"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,0,0,0)><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
					"</tr>");
				});
				var arr = array[index].publications ? array[index].publications.split("\n") : "";
				$.each( arr, function( index, value ) {
					$('#tbPublications').append("<tr>"+
						"<td><input class='form-control' name='publications[]' value='"+value+"'></td>"+
						"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,0,0,0)><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
					"</tr>");
				});
				var arr = array[index].trainings_conducted ? array[index].trainings_conducted.split("\n") : "";
				$.each( arr, function( index, value ) {
					$('#tbTrainConducted').append("<tr>"+
						"<td><input class='form-control' name='trainConducted[]' value='"+value+"'></td>"+
						"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,0,0,0)><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
					"</tr>");
				});
				var arr = array[index].projects_consultancies ? array[index].projects_consultancies.split("\n") : "";
				$.each( arr, function( index, value ) {
					$('#tbPrjInvolve').append("<tr>"+
						"<td><input class='form-control' name='prjInvolve[]' value='"+value+"'></td>"+
						"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,0,0,0)><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
					"</tr>");
				});
				var arr = array[index].project_leadership ? array[index].project_leadership.split("\n") : "";
				$.each( arr, function( index, value ) {
					$('#tbPrjLead').append("<tr>"+
						"<td><input class='form-control' name='prjLead[]' value='"+value+"'></td>"+
						"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,0,0,0)><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
					"</tr>");
				});
				var arr = array[index].awards_citations ? array[index].awards_citations.split("\n") : "";
				$.each( arr, function( index, value ) {
					$('#tbAwards').append("<tr>"+
						"<td><input class='form-control' name='awards[]' value='"+value+"'></td>"+
						"<td class='text-center'><button type='button' class='btn btn-sm btn-danger' onclick=removeRow(this,0,0,0)><i class='ace-icon fa fa-trash-o'></i> </button></td>"+
					"</tr>");
				});
			});
		}
      },
      error: function(data){console.log("We encountered a problem!")}
	});
}

function getRefInfo() {
	$.ajax ({  type:"GET", async: true, dataType: 'json', cache: false,data:{q:"select * from reference_info where employee_employee_id="+$('#ftrEmployee').val()+" ORDER BY flag"},
      url:"<?=site_url('hr/employee/getRecordArray');?>",
      success: function(data){
		var ref = $.grep(data, function(obj){return obj.flag === "0";});
		var er = $.grep(data, function(obj){return obj.flag === "1";})[0];
		if(ref.length){
			ref.forEach((number, index, array) => {
				$('[name="refName[]"]').eq(index).val(array[index].name);
				$('[name="refAdd[]"]').eq(index).val(array[index].address);
				$('[name="refTel[]"]').eq(index).val(array[index].phone);
				$('[name="refFlag[]"]').eq(index).val(array[index].flag);
			});
		}
		if(!jQuery.isEmptyObject(er)){
			$("#erName").val(er.name);
			$("#erAdd").val(er.address);
			$("#erTel").val(er.phone);
			$("#erFlag").val(er.flag);
		}
      },
      error: function(data){console.log("We encountered a problem!")}
	});
}

function updateEmployee(){
	$(':input','.clrme')
	  .not(':button, :submit, :reset, :hidden')
	  .not(':radio, :checkbox')
	  .val('')
	  .prop('checked', false)
	  .prop('selected', false);
	//   getEmployee()
	$("#sbg").val($('#ftrEmployee').val());
	switch($("div.tab-pane.active").attr('id')) {
		case "tab_1_1":
			getEmployee()
			break;
		case "tab_1_2":
			getPersonalInfo()
			break;
		case "tab_1_3":
			getFamily()
			break;
		case "tab_1_4":
			getQualification()
			break;
		case "tab_1_5":
			getLegal()
			break;
		case "tab_1_6":
			getRefInfo()
			break;
		case "tab_1_7":
			getOtherInfo()
			break;
		default:
			// code block
	}
}

$('#firstname, #lastname, #birthday').on("change", function() {
	var n = $("#birthday").val();
	n = n.replace(/-/g,"");
	n = n.substr(n.length - 4);
	if(!allowArrowKeys){
		$("#empNum").val($("#firstname").val().charAt(0) + $("#lastname").val().charAt(0) + n);
		$("#empPass").val($("#firstname").val().charAt(0) + $("#lastname").val().charAt(0) + n);
	}
});

$('#btnNext').on("click", function() {
  if(!$('#ftrEmployee option:selected').next().val())
      $('#ftrEmployee').val($('#ftrEmployee option:first').val())
  else
      $('#ftrEmployee option:selected').next().attr('selected', 'selected');
  $('select').select2();
  updateEmployee()
});

$('#btnPrev').on("click", function(){
  if(!$('#ftrEmployee option:selected').prev().val())
      $('#ftrEmployee').val($('#ftrEmployee option:last').val())
  else
      $('#ftrEmployee option:selected').prev().attr('selected', 'selected');
  $('select').select2();
  updateEmployee()
});

jQuery(function($) {
	/*var $form = $('form'), origForm = $form.serialize();

	$('form :input').on('change input', function() {
		if($form.serialize() != origForm)
			$('#passchange').val(1)
		else
			$('#passchange').val(0)
	});*/
	
	console.log("<?php echo $this->uri->segment(4);?>")
	if("<?php echo $this->uri->segment(4);?>")
		ggetEmployees("<?php echo $this->uri->segment(4);?>")
	else 
		ggetEmployees(0)
	$('select.form-select').select2();
	$('#empUserLevel').select2();

	$('.btnSubmit').on('click', (function(e)
    {
		
    	var btnName = $(this).prop("name");
    	var btnID = $(this).prop("id");
    	var a = "";
    	var pdata = {	employee_employee_id:$("#sbg").val(),
						plantilla_library_plantilla_library_id:$("#plantilla").val(),
						step_type:$("#empStep").val(),
						appointment_date:$("#empAppDate").val(),
						assumption_date:$("#empAssDate").val()
					};
		var ardata = {	street:$("#rstreet").val(),
						town_or_city:$("#rtown").val(),
						province:$("#rprovince").val(),
						country:$("#rcountry").val(),
						zip_code:$("#rzip").val(),
						address_type:"Residential"
					};
		var apdata = {	street:$("#pstreet").val(),
						town_or_city:$("#ptown").val(),
						province:$("#pprovince").val(),
						country:$("#pcountry").val(),
						zip_code:$("#pzip").val(),
						address_type:"Permanent"
					}

		$("form").prop('id', '');
    	$(this).closest("form").prop('id', 'form_sample_2');
		$("input[type=text]").each(function(){
			this.value = this.value.toUpperCase();          
		});

	    e.preventDefault();

    	if($("#form_sample_2").valid())
    	{
			e.stopPropagation();
    		$("label.error, label.has-error").prop("style", "color: red;");
			$('#alertvalidation').hide();
			$('#infovalidation').hide();
			$('#processvalidation').show();
			
			var url;
			var plantilla = $("#empStat :selected").val() == 1 ? "Plantilla" : "nonPlantilla";
			if($("#sbg").val()){
				url = "<?php echo site_url('common/update'); ?>";
				a = "UPDATED";
			}else{
				url = "<?php echo site_url('common/add'); ?>";
				a = "ADDED";
			}

			switch(btnID) {
				case "btnSaveNewEmployee":
					udata = {	firstname:$("#firstname").val(),
								middlename:$("#middlename").val(),
								lastname:$("#lastname").val(),
								name_extension:$("#name_extension").val(),
								empno:$("#empNum").val(),
								asti_email:$("#empEmail").val() + '@pnri.dost.gov.ph',
								employment_status_library_employment_status_library_id:$("#empStat").val(),
								employee_type:plantilla,
								division_division_id:$("#empDiv").val(),
								unit_unit_id:$("#empSec").val(),
								position_reference_position_reference_id:$("#empPos").val(),
								birthday:$("#birthday").val(),
								birthplace:$("#birthplace").val(),
								gender:$("[name=gender]:checked").val(),
								civil_status:$("#civil_status").val(),
								citizenship:$("#citizenship").val(),
								local_number:$("#local_number").val(),
								email_address:$("#email_address").val(),
								mobile_phone:$("#mobile_phone").val(),
								height:$("#height").val(),
								weight:$("#weight").val(),
								blood_type:$("#blood_type").val(),
								tin:$("#tin").val(),
								gsis_id_num:$("#gsis_id_num").val(),
								pagibig_id_num:$("#pagibig_id_num").val(),
								philhealth_num:$("#philhealth_num").val(),
								sss_num:$("#sss_num").val()
							};
					break;
				case "btnSaveAccount":
					//plantilla
					if($("#empStat").val() !=localStorage.getItem('empstatus')){
						if($("#empStat").val()==1)
							aCall(a, "PLANTILLA DETAILS", "infosys.plantilla", "employee_employee_id", $("#sbg").val(), pdata, "<?php echo site_url('common/add'); ?>");
						
						aCall(a, "STATUS HISTORY", "infosys.employment_status_history", "empid", $("#sbg").val(), {empid:$("#sbg").val(),statid:$("#empStat").val(),statby:"<?php echo $this->session->userdata('id'); ?>"}, "<?php echo site_url('common/add'); ?>");
					}
					else if($("#empStat").val()==1){
						if($('#plantilla').val() != localStorage.getItem('oplantilla') || $('#empStep').val() != localStorage.getItem('oempStep') || $('#empAppDate').val() != localStorage.getItem('oempAppDate') || $('#empAssDate').val() != localStorage.getItem('oempAssDate'))
							aCall(a, "PLANTILLA DETAILS", "infosys.plantilla", "employee_employee_id", $("#sbg").val(), pdata, url);
					}
					if($("#empStat").val()!=1)
						gdelete("infosys.plantilla", "employee_employee_id", $("#sbg").val());
						// gdeac("infosys.plantilla", "employee_employee_id", $("#sbg").val(), 'pstat')
		            //User Level
					if($('#empUserLevel').val() != localStorage.getItem('oUserLevel')){
						aCalldu({id:localStorage.getItem('ouid'), uref:$("#empUserLevel").val()});
					}

					udata = {	firstname:$("#firstname").val(),
								middlename:$("#middlename").val(),
								lastname:$("#lastname").val(),
								name_extension:$("#name_extension").val(),
								empno:$("#empNum").val(),
								asti_email:$("#empEmail").val() + '@pnri.dost.gov.ph',
								employment_status_library_employment_status_library_id:$("#empStat").val(),
								employee_type:plantilla,
								division_division_id:$("#empDiv").val(),
								unit_unit_id:$("#empSec").val(),
								position_reference_position_reference_id:$("#empPos").val()
							};
	        		if($('#empPass').val() != localStorage.getItem('oPass'))
						updatePass('update', $('#empPass').val(), $('#empNum').val(), $('#sbg').val());
					break;
				case "btnSavePersonInfo":
					aCallc(a, "RESIDENTIAL ADDRESS", "infosys.address", "employee_employee_id = "+$('#sbg').val()+" and address_type = 'Residential'", ardata, "<?php echo site_url('common/updateWhere'); ?>");
					aCallc(a, "PERMANENT ADDRESS", "infosys.address", "employee_employee_id = "+$('#sbg').val()+" and address_type = 'Permanent'", apdata, "<?php echo site_url('common/updateWhere'); ?>");
					udata = {	birthday:$("#birthday").val(),
								birthplace:$("#birthplace").val(),
								gender:$("[name=gender]:checked").val(),
								civil_status:$("#civil_status").val(),
								citizenship:$("#citizenship").val(),
								local_number:$("#local_number").val(),
								email_address:$("#email_address").val(),
								mobile_phone:$("#mobile_phone").val(),
								height:$("#height").val(),
								weight:$("#weight").val(),
								blood_type:$("#blood_type").val(),
								tin:$("#tin").val(),
								gsis_id_num:$("#gsis_id_num").val(),
								pagibig_id_num:$("#pagibig_id_num").val(),
								philhealth_num:$("#philhealth_num").val(),
								sss_num:$("#sss_num").val()
							};
					break;
				case "btnSaveFamily":
					var spouse = {firstname:$("#spsFname").val(),middlename:$("#spsMname").val(),lastname:$("#spsLname").val(),occupation:$("#spsOccupation").val(),employer:$("#spsEmployer").val(),employer_address:$("#spsAdd").val(),employer_telnum:$("#spsTel").val()};
					var father = {firstname:$("#frFname").val(),middlename:$("#frMname").val(),lastname:$("#frLname").val()};
					var mother = {firstname:$("#mrFname").val(),middlename:$("#mrMname").val(),lastname:$("#mrLname").val()};
					var chFid = $("input[name='chFid[]']").map(function(){return $(this).val();}).get();
					var chFname = $("input[name='chFname[]']").map(function(){return $(this).val();}).get();
					var chMname = $("input[name='chMname[]']").map(function(){return $(this).val();}).get();
					var chLname = $("input[name='chLname[]']").map(function(){return $(this).val();}).get();
					var chBday = $("input[name='chBday[]']").map(function(){return $(this).val();}).get();

					aCallc(a, "FAMAILY INFO - SPOUSE", "infosys.family", {employee_employee_id:$("#sbg").val(),relationship:'Spouse'}, spouse, "<?php echo site_url('common/replace'); ?>");
					aCallc(a, "FAMAILY INFO - MOTHER", "infosys.family", {employee_employee_id:$("#sbg").val(),relationship:'Mother'}, mother, "<?php echo site_url('common/replace'); ?>");
					aCallc(a, "FAMAILY INFO - FATHER", "infosys.family", {employee_employee_id:$("#sbg").val(),relationship:'Father'}, father, "<?php echo site_url('common/replace'); ?>");
					
					if(chFname.length !== 0)
					$.ajax
					({  type:"POST",
						async: true,
						url: "<?php echo site_url('hr/employee/updateChild'); ?>",
						data: {id:$('#sbg').val(), chFid:chFid, chFname:chFname, chMname:chMname,chLname:chLname, chBday:chBday},
						dataType: 'json',
						cache: false,
						success: function(data)
						{
							$('#processvalidation').hide();
							if(data[0])
								toastr.success("SUCCESSFULLY UPDATED FAMILY INFO - CHILD", "Success");
							else if(data[2].code==1062)
								toastr.error("QUALIFICATION INFO - EDUCATION DUPLICATE ENTRY", "Error");
							else
								console.log("FAMILY INFO WAS NOT UPDATED", "INFO");
						},
						error: function(data)
						{
							toastr.error('PLEASE RELOAD THE PAGE AND TRY AGAIN.', 'OOOOOPHS! WE ENCOUNTERED A PROBLEM');
						}
					})
					return true;
					break;
				case "btnSaveEduc":
					var educId = $("input[name='educId[]']").map(function(){return $(this).val();}).get();
					var educLevel = $("select[name='educLevel[]']").map(function(){return $(this).val();}).get();
					var educSchool = $("textarea[name='educSchool[]']").map(function(){return $(this).val();}).get();
					var educDegree = $("input[name='educDegree[]']").map(function(){return $(this).val();}).get();
					var educStart = $("input[name='educStart[]']").map(function(){return $(this).val();}).get();
					var educEnd = $("input[name='educEnd[]']").map(function(){return $(this).val();}).get();
					var educUnits = $("input[name='educUnits[]']").map(function(){return $(this).val();}).get();
					var educYear = $("input[name='educYear[]']").map(function(){return $(this).val();}).get();
					var educHonors = $("input[name='educHonors[]']").map(function(){return $(this).val();}).get();
					if(educSchool.length !== 0)
					$.ajax
					({  type:"POST",
						async: true,
						url: "<?php echo site_url('hr/employee/updateEduc'); ?>",
						data: {id:$('#sbg').val(), educId:educId, educLevel:educLevel, educSchool:educSchool,educDegree:educDegree, educStart:educStart, educEnd:educEnd, educUnits:educUnits,educYear:educYear, educHonors:educHonors},
						dataType: 'json',
						cache: false,
						success: function(data)
						{
							$('#processvalidation').hide();
							if(data[0]){
								getEducation()
								toastr.success("SUCCESSFULLY UPDATED QUALIFICATION INFO - EDUCATION", "Success");
							}else if(data[2].code==1062)
								toastr.error("QUALIFICATION INFO - EDUCATION DUPLICATE ENTRY", "Error");
							else
								console.log("QUALIFICATION INFO - EDUCATION WAS NOT UPDATED", "Info");
						},
						error: function(data)
						{
							toastr.error('PLEASE RELOAD THE PAGE AND TRY AGAIN.', 'OOOOOPHS! WE ENCOUNTERED A PROBLEM');
						}
					})
					return true;
					break;
				case "btnSaveElig":
					var examId = $("input[name='examId[]']").map(function(){return $(this).val();}).get();
					var examName = $("input[name='examName[]']").map(function(){return $(this).val();}).get();
					var examRate = $("input[name='examRate[]']").map(function(){return $(this).val();}).get();
					var examDate = $("input[name='examDate[]']").map(function(){return $(this).val();}).get();
					var examPlace = $("input[name='examPlace[]']").map(function(){return $(this).val();}).get();
					var examLic = $("input[name='examLic[]']").map(function(){return $(this).val();}).get();
					var examLicdt = $("input[name='examLicdt[]']").map(function(){return $(this).val();}).get();
					if(examName.length !== 0)
					$.ajax
					({  type:"POST",
						async: true,
						url: "<?php echo site_url('hr/employee/updateExam'); ?>",
						data: {id:$('#sbg').val(), examId:examId, examName:examName, examRate:examRate,examDate:examDate, examPlace:examPlace, examLic:examLic, examLicdt:examLicdt},
						dataType: 'json',
						cache: false,
						success: function(data)
						{
							$('#processvalidation').hide();
							if(data[0]){
								getEligibility()
								toastr.success("SUCCESSFULLY UPDATED QUALIFICATION INFO - ELIGIBILITY", "Success");
							}else if(data[2].code==1062)
								toastr.error("QUALIFICATION INFO - ELIGIBILITY DUPLICATE ENTRY", "Error");
							else
								console.log("QUALIFICATION INFO - ELIGIBILITY WAS NOT UPDATED", "Info");
						},
						error: function(data)
						{
							toastr.error('PLEASE RELOAD THE PAGE AND TRY AGAIN.', 'OOOOOPHS! WE ENCOUNTERED A PROBLEM');
						}
					})
					return true;
					break;
				case "btnSaveWork":
					var workId = $("input[name='workId[]']").map(function(){return $(this).val();}).get();
					var workStart = $("input[name='workStart[]']").map(function(){return $(this).val();}).get();
					var workEnd = $("input[name='workEnd[]']").map(function(){return $(this).val();}).get();
					var workPos = $("input[name='workPos[]']").map(function(){return $(this).val();}).get();
					var workComp = $("input[name='workComp[]']").map(function(){return $(this).val();}).get();
					var workSalary = $("input[name='workSalary[]']").map(function(){return $(this).val();}).get();
					var workSG = $("input[name='workSG[]']").map(function(){return $(this).val();}).get();
					var workApp = $("select[name='workApp[]']").map(function(){return $(this).val();}).get();
					var workGov = $("select[name='workGov[]']").map(function(){return $(this).val();}).get();
					var workPNRI = $("select[name='workPNRI[]']").map(function(){return $(this).val();}).get();
					if(workPos.length !== 0)
					$.ajax
					({  type:"POST",
						async: true,
						url: "<?php echo site_url('hr/employee/updateWork'); ?>",
						data: {id:$('#sbg').val(), workId:workId, workStart:workStart, workEnd:workEnd,workPos:workPos, workComp:workComp, workSalary:workSalary, workSG:workSG,workApp:workApp, workGov:workGov, workPNRI:workPNRI},
						dataType: 'json',
						cache: false,
						success: function(data)
						{
							$('#processvalidation').hide();
							if(data[0]){
								getWork()
								toastr.success("SUCCESSFULLY UPDATED QUALIFICATION INFO - WORK EXPERIENCE", "Success");
							}else if(data[2].code==1062)
								toastr.error("QUALIFICATION INFO - WORK EXPERIENCE DUPLICATE ENTRY", "Error");
							else
								console.log("QUALIFICATION INFO - WORK EXPERIENCE WAS NOT UPDATED", "Info");
						},
						error: function(data)
						{
							toastr.error('PLEASE RELOAD THE PAGE AND TRY AGAIN.', 'OOOOOPHS! WE ENCOUNTERED A PROBLEM');
						}
					})
					return true;
					break;
				case "btnSaveVol":
					var volId = $("input[name='volId[]']").map(function(){return $(this).val();}).get();
					var volOrg = $("input[name='volOrg[]']").map(function(){return $(this).val();}).get();
					var volStart = $("input[name='volStart[]']").map(function(){return $(this).val();}).get();
					var volEnd = $("input[name='volEnd[]']").map(function(){return $(this).val();}).get();
					var volHrs = $("input[name='volHrs[]']").map(function(){return $(this).val();}).get();
					var volPos = $("input[name='volPos[]']").map(function(){return $(this).val();}).get();
					if(volOrg.length !== 0)
					$.ajax
					({  type:"POST",
						async: true,
						url: "<?php echo site_url('hr/employee/updateVol'); ?>",
						data: {id:$('#sbg').val(), volId:volId, volOrg:volOrg, volStart:volStart,volEnd:volEnd, volHrs:volHrs, volPos:volPos},
						dataType: 'json',
						cache: false,
						success: function(data)
						{
							$('#processvalidation').hide();
							if(data[0]){
								getVol()
								toastr.success("SUCCESSFULLY UPDATED QUALIFICATION INFO - VOLUNTARY EXPERIENCE", "Success");
							}else if(data[2].code==1062)
								toastr.error("QUALIFICATION INFO - VOLUNTARY EXPERIENCE DUPLICATE ENTRY", "Error");
							else
								console.log("QUALIFICATION INFO - VOLUNTARY EXPERIENCE WAS NOT UPDATED", "Info");
						},
						error: function(data)
						{
							toastr.error('PLEASE RELOAD THE PAGE AND TRY AGAIN.', 'OOOOOPHS! WE ENCOUNTERED A PROBLEM');
						}
					})
					return true;
					break;
				case "btnSaveTraining":
					var trainId = $("input[name='trainId[]']").map(function(){return $(this).val();}).get();
					var trainTitle = $("input[name='trainTitle[]']").map(function(){return $(this).val();}).get();
					var trainStart = $("input[name='trainStart[]']").map(function(){return $(this).val();}).get();
					var trainEnd = $("input[name='trainEnd[]']").map(function(){return $(this).val();}).get();
					var trainHrs = $("input[name='trainHrs[]']").map(function(){return $(this).val();}).get();
					var trainSponsor = $("input[name='trainSponsor[]']").map(function(){return $(this).val();}).get();
					if(trainTitle.length !== 0)
					$.ajax
					({  type:"POST",
						async: true,
						url: "<?php echo site_url('hr/employee/updateTrain'); ?>",
						data: {id:$('#sbg').val(), trainId:trainId, trainTitle:trainTitle, trainStart:trainStart,trainEnd:trainEnd, trainHrs:trainHrs, trainSponsor:trainSponsor},
						dataType: 'json',
						cache: false,
						success: function(data)
						{
							$('#processvalidation').hide();
							if(data[0]){
								getTrain()
								toastr.success("SUCCESSFULLY UPDATED QUALIFICATION INFO - TRAINING EXPERIENCE", "Success");
							}else if(data[2].code==1062)
								toastr.error("QUALIFICATION INFO - TRAINING EXPERIENCE DUPLICATE ENTRY", "Error");
							else
								console.log("QUALIFICATION INFO - TRAINING EXPERIENCE WAS NOT UPDATED", "Info");
						},
						error: function(data)
						{
							toastr.error('PLEASE RELOAD THE PAGE AND TRY AGAIN.', 'OOOOOPHS! WE ENCOUNTERED A PROBLEM');
						}
					})
					return true;
					break;
				case "btnSaveLegal":
					var legalq = $("input[name='legalq[]']").map(function(){return $(this).val();}).get();
					var legala = $("input[class='legala']:checked").map(function(){return $(this).val();}).get();
					var legalp = $("textarea[name='legalp[]']").map(function(){return $(this).val();}).get();
					if(legalq.length !== 0)
					$.ajax
					({  type:"POST",
						async: true,
						url: "<?php echo site_url('hr/employee/updateLegal'); ?>",
						data: {id:$('#sbg').val(), legalq:legalq, legala:legala, legalp:legalp, legaldt:$("#legaldt").val(),govIDName:$("#govIDName").val(), govIDNo:$("#govIDNo").val(), govDate:$("#govDate").val(),govPlace:$("#govPlace").val()},
						dataType: 'json',
						cache: false,
						success: function(data)
						{
							$('#processvalidation').hide();
							if(data[0]){
								getLegal()
								toastr.success("SUCCESSFULLY UPDATED LEGAL INFO", "Success");
							}else if(data[2].code==1062)
								toastr.error("QUALIFICATION INFO - LEGAL INFO DUPLICATE ENTRY", "Error");
							else
								console.log("QUALIFICATION INFO - LEGAL INFO WAS NOT UPDATED", "Info");
						},
						error: function(data)
						{
							toastr.error('PLEASE RELOAD THE PAGE AND TRY AGAIN.', 'OOOOOPHS! WE ENCOUNTERED A PROBLEM');
						}
					})
					return true;
					break;
				case "btnSaveOther":
					var refId = $("[name='refId[]']").map(function(){return $(this).val();}).get();
					var refName = $("[name='refName[]']").map(function(){return $(this).val();}).get();
					var refAdd = $("[name='refAdd[]']").map(function(){return $(this).val();}).get();
					var refTel = $("[name='refTel[]']").map(function(){return $(this).val();}).get();
					var refFlag = $("[name='refFlag[]']").map(function(){return $(this).val();}).get();
					var skills = recognitions = orgs = publications = trainConducted = prjInvolve = prjLead = awards = "";
					$("input[name='skills[]']").map(function(){ skills = skills + $(this).val()+ "\n";}).get();
					$("input[name='recognitions[]']").map(function(){ recognitions = recognitions + $(this).val()+ "\n";}).get();
					$("input[name='orgs[]']").map(function(){ orgs = orgs + $(this).val()+ "\n";}).get();
					$("input[name='publications[]']").map(function(){ publications = publications + $(this).val()+ "\n";}).get();
					$("input[name='trainConducted[]']").map(function(){ trainConducted = trainConducted + $(this).val()+ "\n";}).get();
					$("input[name='prjInvolve[]']").map(function(){ prjInvolve = prjInvolve + $(this).val()+ "\n";}).get();
					$("input[name='prjLead[]']").map(function(){ prjLead = prjLead + $(this).val()+ "\n";}).get();
					$("input[name='awards[]']").map(function(){ awards = awards + $(this).val()+ "\n";}).get();
					// console.log(skills.trim())
					// console.log(orgs.trim())
					// console.log(publications.trim())
					// console.log(trainConducted.trim())
					// console.log(prjInvolve.trim())
					// console.log(prjLead.trim())
					// console.log(awards.trim())
					$.ajax
					({  type:"POST",
						async: true,
						url: "<?php echo site_url('hr/employee/updateOther'); ?>",
						data: {id:$('#sbg').val(), skills:skills.trim(),recognitions:recognitions.trim(),orgs:orgs.trim(),publications:publications.trim(),trainConducted:trainConducted.trim(), prjInvolve:prjInvolve.trim(),prjLead:prjLead.trim(),awards:awards.trim()},
						dataType: 'json',
						cache: false,
						success: function(data)
						{
							$('#processvalidation').hide();
							if(data[0]){
								getOtherInfo()
								toastr.success("SUCCESSFULLY UPDATED OTHER INFO", "Success");
							}else if(data[2].code==1062)
								toastr.error("OTHER INFO DUPLICATE ENTRY", "Error");
							else
								console.log("OTHER INFO WAS NOT UPDATED", "Info");
						},
						error: function(data)
						{
							toastr.error('PLEASE RELOAD THE PAGE AND TRY AGAIN.', 'OOOOOPHS! WE ENCOUNTERED A PROBLEM');
						}
					})
					return true;
					break;
				case "btnSaveRef":
					var refId = $("[name='refId[]']").map(function(){return $(this).val();}).get();
					var refName = $("[name='refName[]']").map(function(){return $(this).val();}).get();
					var refAdd = $("[name='refAdd[]']").map(function(){return $(this).val();}).get();
					var refTel = $("[name='refTel[]']").map(function(){return $(this).val();}).get();
					var refFlag = $("[name='refFlag[]']").map(function(){return $(this).val();}).get();
					if(refName.length !== 0)
					$.ajax
					({  type:"POST",
						async: true,
						url: "<?php echo site_url('hr/employee/updateRef'); ?>",
						data: {id:$('#sbg').val(),refName:refName,refAdd:refAdd,refTel:refTel,refFlag:refFlag},
						dataType: 'json',
						cache: false,
						success: function(data)
						{
							$('#processvalidation').hide();
							if(data[0]){
								getRefInfo()
								toastr.success("SUCCESSFULLY UPDATED REFERENCE INFO", "Success");
							}else if(data[2].code==1062)
								toastr.error("REFERENCE INFO DUPLICATE ENTRY", "Error");
							else
								console.log("REFERENCE INFO WAS NOT UPDATED", "Info");
						},
						error: function(data)
						{
							toastr.error('PLEASE RELOAD THE PAGE AND TRY AGAIN.', 'OOOOOPHS! WE ENCOUNTERED A PROBLEM');
						}
					})
					return true;
					break;
				default:
					// code \block
			}
			//main
            $.ajax
            ({  type:"POST",
                async: true,
                url: url,
                data: {	tbl:"infosys.employee", col:"employee_id", id:$('#sbg').val(), udata: udata},
				dataType: 'json',
				cache: false,
                success: function(data)
                {
					$('#processvalidation').hide();
                	if(typeof(data[1]) != "undefined" && data[1] !== null){}
                	else{
                		data[0] = data;
                		data[1] = 0;
                	}
                	if(data[0]){
                		if(btnID == "btnSaveNewEmployee"){
                			$("#sbg").val(data[0]);
							pdata.employee_employee_id = data[0];
							apdata.employee_employee_id = data[0];
							ardata.employee_employee_id = data[0];

							updatePass('new', $('#empPass').val(), $('#empNum').val(), data[0]);
							aCall(a, "PLANTILLA DETAILS", "infosys.plantilla", "employee_employee_id", data[0], pdata, url);
							aCall(a, "PERMANENT ADDRESS", "infosys.address", "employee_employee_id", data[0], apdata, url);
							aCall(a, "RESIDENTIAL ADDRESS", "infosys.address", "employee_employee_id", data[0], ardata, url);
							toastr.success("SUCCESSFULLY ADDED NEW EMPLOYEE", "SUCCESS");
							cancelNew()
							ggetEmployees(data[0])
                		}else{
							toastr.success("SUCCESSFULLY UPDATED "+btnName, "SUCCESS");
							getEmployee()
						}
                	}
                	else
            			toastr.info(btnName+" WAS NOT UPDATED", "INFO");
                	if(data[1])
                		if(data[1].code == 1062)
                			toastr.info(data[1].message, 'TRANSACTION FAILED') 
                },
                error: function(data)
                {
                    toastr.error('PLEASE RELOAD THE PAGE AND TRY AGAIN.', 'OOOOOPHS! WE ENCOUNTERED A PROBLEM') 
                }
            })
		}
    }))

})

$('#copyRes').on('change', function() {
	if(this.checked){
		localStorage.setItem('tstreet', $("#pstreet").val());
		localStorage.setItem('ttown', $("#ptown").val());
		localStorage.setItem('tprovince', $("#pprovince").val());
		localStorage.setItem('tzip', $("#pzip").val());
		localStorage.setItem('tcountry', $("#pcountry").val());
		$("#pstreet").val($("#rstreet").val());
		$("#ptown").val($("#rtown").val());
		$("#pprovince").val($("#rprovince").val());
		$("#pzip").val($("#rzip").val());
		$("#pcountry").val($("#rcountry").val());
	}else{
		$("#pstreet").val(localStorage.getItem('tstreet'));
		$("#ptown").val(localStorage.getItem('ttown'));
		$("#pprovince").val(localStorage.getItem('tprovince'));
		$("#pzip").val(localStorage.getItem('tzip'));
		$("#pcountry").val(localStorage.getItem('tcountry'));
	}
});
</script>