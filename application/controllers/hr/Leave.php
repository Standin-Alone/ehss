<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller{
	public function __construct() {
	    parent::__construct();
		if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
			redirect('access/');
	}

	public function index(){
		$data['menu'] = "leave";
		$data['gmenu'] = "";
		$data['credits'] = $this->leaveModel->getLeaveCredits($this->session->userdata('id'));
		$data['leave_types'] = $this->leaveModel->getLeaveTypes();
		$this->session->set_userdata("menu", "leave");

		$this->load->view('template/header', $data);
		$this->load->view('hr/leave');
		$this->load->view('template/footer');
	}

	public function leave_applications(){
		$data['menu'] = "leave_applications";
		$data['gmenu'] = "";
		$data['credits'] = $this->leaveModel->getLeaveCredits($this->session->userdata('id'));
		$this->session->set_userdata("menu", "leave");

		$this->load->view('template/header', $data);
		$this->load->view('hr/leave_applications');
		$this->load->view('template/footer');
	}

	public function signLeave(){
		$this->leaveModel->signLeave();
	}

	public function earned(){
		$this->leaveModel->getLeaveCreditsNew();
		echo '<br>';

		print_r($this->leaveModel->getLeaveCreditsSummary());
	}

	function getLeaves(){
		#$output = $this->leaveModel->getLeaves();
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->leaveModel->getLeaves()));


		/*$response = array(
			'aaData' => $output,
			'iTotalRecords' => count($output),
			'iTotalDisplayRecords' => count($output),
			'iDisplayStart' => 0
		);
		header("Content-Type: application/json", true);
		echo json_encode($response);*/
	}

	function approveDates(){
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->leaveModel->approveDates()));
	}

	function getLeave(){
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->leaveModel->getLeave($this->input->post('id'))));

	}

		public function printLeave(){
			$this->load->library('fpdf_gen');


			if($this->input->post('leave_id') === null){
				redirect(site_url('hr/Leave'));
				exit();
			}
			$leave_id = explode(',',$this->input->post('leave_id'));
			/*array(210,148.5)*/
			/*$pdf = new FPDF('L','mm', 'A4');*/
			$pdf = new FPDF('P','mm', 'A4');
			$pdf->SetTitle('Leave Form');
			#$sec = $this->session->userdata('SECTION');
			$pdf->SetAutoPageBreak(false);

			foreach ($leave_id as $lid) {
				$leave = $this->leaveModel->getLeave($lid);
				$credits = $this->leaveModel->getLeaveCredits($leave['submit_by']);


				$lwop = round((($credits['used']['lwop'] + intval($credits['legacy']['legvlwop'])) * 0.04166), 3);
				$wholevl = round(((floatval($credits['vacation_credits']) + floatval($credits['earned_vl'])) - (floatval($credits['used']['approvedVL']) + floatval($credits['legacy']['legvl'])) - $credits['ut']['utwpay'] - $lwop - $credits['monetized']), 3);
				$wholesl = round(((floatval($credits['sick_credits']) + floatval($credits['earned_sl'])) - (floatval($credits['used']['approvedSL']) + floatval($credits['legacy']['legsl']))), 3);

				$x= 0;
				$ystart = $pdf->getY();
				for ($i=0; $i < 2; $i++) {
					# code...
				$pdf->AddPage();
				$pdf->SetFont('Arial', 'I', 8);
				$pdf->Cell(0, 3, 'Civil Service Form No. 6', '' , 1);
				$pdf->Cell(0, 3, 'Revised 2020', '', 1);

				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Cell(0, 3, 'ANNEX A', '', 1, 'R');
				$pdf->setX($x);
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->ln(4);
				$pdf->Cell(0, 3, 'Republic of the Philippines', '' , 1, 'C');
				$pdf->Cell(0, 3, 'Philippine Nuclear Research Institute', '' , 1, 'C');
				$pdf->Cell(0, 3, 'Commonwealth Avenue, Diliman, Quezon City', '' , 1, 'C');
				$pdf->ln(8);


				if($leave['control_no']){
					$x1 = $pdf->getX();
					$pdf->SetFont('Arial', '', 9);
					$pdf->Cell(0, 5, 'Control No: '. $leave['control_no'], '' );
					$pdf->setX($x1);
				}
				$pdf->SetFont('Arial', 'B', 14);

				$pdf->Cell(0, 5, 'APPLICATION FOR LEAVE', '' , 1, 'C');

				$pdf->ln(2);
				$pdf->Cell(0.35, 233.3, '', '', 0,'', 1);
				$pdf->Cell(0, 0.35, '', '', 0,'', 1);
				$pdf->Cell(0.35, 233.3, '', '', 0,'', 1);
				$pdf->SetFont('Arial', '', 9);
				$pdf->setX($x);
				$pdf->Cell(10);
				$pdf->Cell(60, 6, '1. OFFICE/DEPARTMENT');
				$pdf->Cell(50, 6, '2. NAME :              (Last)', 'T');
				$pdf->Cell(45, 6, '(First)', 'T', 0, 'C');
				$pdf->Cell(0, 6, '(Middle)', 'T', 1, 'C');

				$pdf->setX($x);
				$pdf->Cell(10);
				$pdf->Cell(60, 6, 'PNRI  ', '', 0, '');
				$pdf->Cell(50, 6, '    '. (utf8_decode($leave['employee']['lastname'])), '', 0, 'C');
				$pdf->Cell(45, 6, (utf8_decode($leave['employee']['firstname'])), '', 0, 'C');
				$pdf->Cell(0, 6, (utf8_decode($leave['employee']['middlename'])).' '.$leave['employee']['name_extension'], '', 1, 'C');

				$pdf->setX($x);
				$pdf->Cell(10);
				$pdf->Cell(0, 0.35, '', '', 1,'', 1);

				$pdf->setX($x);
				$pdf->Cell(10);
				$pdf->Cell(30, 10, '3. DATE OF FILING _______________', 'T' );
				$pdf->Cell(30, 10, $leave['date_filed'], '', 0, 'C');
				$pdf->Cell(20, 10, '4. POSITION ___________________________________', '');
				$pdf->Cell(70, 10,  $leave['employee']['position_desc'], '', 0, 'C');
				$pdf->Cell(12, 10, '5. SALARY _________');
				$pdf->Cell(0, 10, 'SG'.$leave['salary_grade'], '', 1, 'C');

				$pdf->setX($x);
				$pdf->Cell(10);


				$pdf->Cell(0, 0.55, '', '', 1,'', 1);
				$pdf->setX($x);
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Cell(10);
				$pdf->Cell(0, 6, '6. DETAILS OF APPLICATION', '' , 1, 'C');
				$pdf->Cell(0, 0.55, '', '', 1,'', 1);


				$pdf->SetFont('Arial', '', 9);
				$pdf->ln(1);

				$pdf->setX($x);
				$pdf->Cell(10);
				$y = $pdf->getY();
				$pdf->Cell(116, 6, '6.A TYPE OF LEAVE TO BE AVAILED OF', 'R', 1);


				$pdf->setX($x);
				$pdf->Cell(13);

				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'vacation'?1:0));

				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(22, 4, 'Vacation Leave');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(74, 4, '(Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)', '', 1);
	$pdf->ln(1.25);
				$pdf->Cell(3);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'mandatory'?1:0));
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(35.5, 4, 'Mandatory/Forced Leave');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(74, 4, '(Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No. 292)', '', 1);
	$pdf->ln(1.25);
				$pdf->Cell(3);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'sick'?1:0));
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(16, 4, 'Sick Leave');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(74, 4, '(Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)', '', 1);
	$pdf->ln(1.25);
				$pdf->Cell(3);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'maternity'?1:0));
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(23, 4, 'Maternity Leave');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(74, 4, '(R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)', '', 1);
	$pdf->ln(1.25);
				$pdf->Cell(3);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'paternity'?1:0));
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(22.5, 4, 'Paternity Leave');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(74, 4, '(R.A. No. 8187 / CSC MC No. 8, s. 2005)', '', 1);
	$pdf->ln(1.25);
				$pdf->Cell(3);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'special_leave'?1:0));
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(33, 4, 'Special Privilege Leave');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(74, 4, '(Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)', '', 1);
	$pdf->ln(1.25);
				$pdf->Cell(3);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'solo_parent'?1:0));
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(27, 4, 'Solo Parent Leave');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(74, 4, '(RA No. 8972 / CSC MC No. 8.s 2004)', '', 1);
	$pdf->ln(1.25);

				$pdf->Cell(3);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'study'?1:0));
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(18, 4, 'Study Leave');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(74, 4, '(Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)', '', 1);
	$pdf->ln(1.25);
				$pdf->Cell(3);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'vawc'?1:0));
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(31, 4, '10-Day VAWC Leave');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(74, 4, '(RA No. 9262 / CSC MC No. 15.s 2005)', '', 1);
	$pdf->ln(1.25);
				$pdf->Cell(3);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'rehabilitation'?1:0));
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(33, 4, 'Rehabilitation Privilege');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(74, 4, '(Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)', '', 1);
	$pdf->ln(1.25);
				$pdf->Cell(3);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'special_women'?1:0));
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(49, 4, 'Special Leave Benefits for Women');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(74, 4, '(RA No. 9262 / CSC MC No.25, s. 2010)', '', 1);
	$pdf->ln(1.25);
				$pdf->Cell(3);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'emergency'?1:0));
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(53, 4, 'Special Emergency (Calamity) Leave');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(60, 4, '(CSC MC No. 2, s.2012, as amended)', '', 1);
	$pdf->ln(1.25);
				$pdf->Cell(3);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'adoption'?1:0));
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(23, 4, 'Adoption Leave');
				$pdf->SetFont('Arial', '', 7);
				$pdf->Cell(78, 4, '(R.A. No. 8552)', '', 1);
				$pdf->ln(6);


				$pdf->Cell(3);
				$pdf->SetFont('Arial', 'I', 8);
				$pdf->Cell(20, 4, 'Others:', '', 1);

				$pdf->Cell(3);
				$ox = $pdf->getX();
				if($leave['leave_type'] == 'monetize'){
					$pdf->Cell(78, 4, 'Monetization of Leave', '', 0, 'C');
					$pdf->setX($ox);
				}
				$pdf->Cell(78, 7, '_________________________________________', '', 1);

				$pdf->setY($y-1);
				$pdf->Cell(116);
				$pdf->Cell(0.35, 120, '', '', 1,'', 1);


				$pdf->setY($y);
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(117);
				$pdf->Cell(0, 6, '6.B DETAILS OF LEAVE', '', 1);

				$pdf->Cell(117);

				$pdf->SetFont('Arial', 'I', 9);
				$pdf->Cell(64.5, 4, 'In case of Vacation/Special Privilege Leave:', '', 1);
				$pdf->ln(1);

				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(118);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['place'] == 'local' && $leave['leave_type'] == 'vacation'?1:0));
				$pdf->Cell(28, 5, 'Within Philippines');
				$pdf->Cell(0, 4, ($leave['place'] == 'local'?$leave['where_remark']:''), 'B', 1);
				$pdf->ln(1);

				$pdf->Cell(118);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['place'] == 'abroad' && $leave['leave_type'] == 'vacation'?1:0));
				$pdf->Cell(25, 5, 'Abroad (Specify)');
				$pdf->Cell(0, 4, ($leave['place'] == 'abroad' && $leave['leave_type'] == 'vacation'?$leave['where_remark']:''), 'B', 1);

				$pdf->ln(2);
				$pdf->Cell(117);
				$pdf->SetFont('Arial', 'I', 9);
				$pdf->Cell(64.5, 4, 'In case of Sick Leave:', '', 1);
				$pdf->ln(1);

				$pdf->Cell(118);
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['place'] == 'local' && $leave['leave_type'] == 'sick'?1:0));
				$pdf->Cell(40, 5, 'In Hospital (Specify Illness)');
				$pdf->Cell(0, 4, ($leave['place'] == 'local' && $leave['leave_type'] == 'sick'?$leave['where_remark']:''), 'B', 1);
				$pdf->ln(1);

				$pdf->Cell(118);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['place'] == 'abroad' && $leave['leave_type'] == 'sick'?1:0));
				$pdf->Cell(41, 5, 'Out Patient (Specify Illness)');
				$pdf->Cell(0, 4, '', 'B', 1);


				$pdf->Cell(118);
				$pdf->Cell(0, 4, ($leave['place'] == 'abroad'  && $leave['leave_type'] == 'sick'?$leave['where_remark']:''), 'B', 1);

				$pdf->ln(2);
				$pdf->Cell(117);

				$pdf->SetFont('Arial', 'I', 9);
				$pdf->Cell(64.5, 4, 'In case of Special Leave Benefits for Women:', '', 1);

				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(118);
				$pdf->Cell(25, 5, '(Specify Illness)');
				$pdf->Cell(0, 5, ($leave['place'] == 'local' && $leave['leave_type'] == 'Vacation'?$leave['where_remark']:''), 'B', 1);

				$pdf->Cell(118);
				$pdf->Cell(0, 5, '', 'B', 1);

				$pdf->ln(2);
				$pdf->Cell(117);
				$pdf->SetFont('Arial', 'I', 9);
				$pdf->Cell(64.5, 4, 'In case of Study Leave', '', 1);

				$pdf->ln(1);
				$pdf->Cell(118);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['place'] == 'masters'?1:0));
				$pdf->Cell(40, 4, 'Completion of Master\'s Degree', '', 1);

				$pdf->ln(1);
				$pdf->Cell(118);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['place'] == 'examination'?1:0));
				$pdf->Cell(40, 4, 'BAR/Board Examination Review', '', 1);
				$pdf->ln(2);

				$pdf->Cell(118);
				$pdf->SetFont('Arial', 'I', 9);
				$pdf->Cell(64.5, 4, 'Other purpose:', '', 1);
				$pdf->ln(1);

				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(118);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ( $leave['leave_type'] == 'monetize'?1:0));
				$pdf->Cell(40, 4, 'Monetization of Leave Credits', '', 1);
				$pdf->ln(1);

				$pdf->Cell(118);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ( $leave['leave_type'] == 'terminal'?1:0));
				$pdf->Cell(40, 4, 'Terminal Leave', '', 1);
				$pdf->ln(2);

				$pdf->Cell(0, 0.35, '', '', 1,'', 1);


				$inclusiveD = '';
				$prevm = '';
				$ct = 1;
				$prevd = 0;
				#echo '<pre>';

				$days = [];

				foreach ($leave['dates'] as $key) {
					array_push($days, $key->dd);
				}
				$half_dates = $tmpmd = '';
				$hf = 0;
				foreach ($leave['dates'] as $key) {
					if($key->ishalf_day == 1){
						$hf++;
						$half_dates .= ($key->md != $tmpmd) ?  $key->md.'. ' : ', ';
						$half_dates .= $key->dd;
						$tmpmd = $key->md;
					}

					#echo $days[$ct - 1]+1 .'!= ' . next($days) . '<br>';

					#when previous is not equal to current MONTH
					if($prevm != $key->md){
						$inclusiveD .= $key->md .'. ';
					}

					#echo ($prevd +1 ).'!='. $key->dd . ':' .($days[$ct - 1]+1) .'!= ' . next($days) .'<hr>';

					#echo ($prevd +1) .'!='. $key->dd .'||' .count($leave['dates']) .'=='. $ct .'<br>';
					if($prevd +1 != $key->dd || count($leave['dates']) == $ct || $key->dd == 1){
						$inclusiveD .= $key->dd;

						if((count($leave['dates']) == $ct || ($days[$ct - 1]+1) !=  next($days)) ){
							if(count($leave['dates']) != $ct){
								$inclusiveD .= ',';
							}
						}
						else{
							$inclusiveD .= '-';
						}


					}
					else{

						if(($days[$ct - 1]+1) !=  next($days) ||  $days == 1){
							$inclusiveD .= $key->dd . ',';
						}

					}

					/*if($days[$ct - 1]+1 .'!= ' . next($days)){
						$inclusiveD .=  '-'. $key->dd;
						if(count($leave['dates']) > $ct){
							$inclusiveD .= ',';
						}
					}*/


					$prevm = $key->md;
					$prevd = $key->dd;
					$ct++;

				}
				$inclusiveD .= ' '.$leave['dates'][0]->yd;

				if($leave['leave_type'] == 'maternity' || $leave['leave_type'] == 'study'){
					$inclusiveD = $leave['maternity_start'] . ' - ' .$leave['maternity_end'];
				}

				if($leave['leave_type'] == 'monetize'){
					$inclusiveD = '';
				}



				$pdf->Cell(117, 6, '6.C NUMBER OF WORKING DAYS APPLIED FOR');

				$pdf->Cell(0, 6, '6.D COMMUTATION', '', 1);

				$pdf->Cell(7);
				$wd = count($leave['dates']);
				$wd = $wd - ($hf * 0.5);
				if($leave['leave_type'] == 'monetize'){
					$wd = $leave['dates'][0]->to_monetize;
				}else if($leave['leave_type'] == 'study'){
					$leave['no_days'] = $this->getWeekdayDifference($leave['maternity_start'], $leave['maternity_end']);
				}
				$pdf->Cell(67.5, 5, (($leave['leave_type'] == 'maternity' || $leave['leave_type'] == 'study')?$leave['no_days'] . ' Days':$wd.' Working Day' . ($wd > 1?'s':'')), 'B', 0, 'C');
				$pdf->Cell(44);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['commutation'] == 0?1:0));
				$pdf->Cell(40, 4, 'Not Requested', '', 1);


				$pdf->ln(2);

				$pdf->Cell(7);
				$pdf->Cell(110.5, 6, 'INCLUSIVE DATES');
				$pdf->Cell(1);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['commutation'] == 1?1:0));
				$pdf->Cell(40, 4, 'Requested', '', 1);

				$pdf->Cell(7);
				$pdf->Cell(67.5, 6, $inclusiveD, 'B', 0, 'C');
				$pdf->Cell(50);
				$pdf->Cell(0, 6, '', 'B', 1);

				$pdf->Cell(7);
				$pdf->Cell(110, 5, 'Halfdays: '. $half_dates );
				$pdf->Cell(0, 5, '(Signature of Applicant)', '', 1, 'C');
				$pdf->ln(1.8);

				$pdf->Cell(0, 0.55, '', '', 1,'', 1);
				$pdf->SetFont('Arial', 'B', 11);
				$pdf->Cell(10);
				$pdf->Cell(0, 6, '7. DETAILS OF ACTION ON APPLICATION', '' , 1, 'C');
				$pdf->Cell(0, 0.55, '', '', 1,'', 1);


				$pdf->SetFont('Arial', '', 9);

				$pdf->Cell(116, 6, '7.A CERTIFICATION OF LEAVE CREDITS');
				$pdf->Cell(0.35, 40.5, '', '', 0,'', 1);
				$pdf->Cell(117, 6, '7.B RECOMMENDATION', '' ,1);

				$y = $pdf->getY();
				$pdf->setY($y);
				$pdf->Cell(35, 6, 'As of ', '', 0, 'R');
				$pdf->Cell(1, 6, '__________________________');
				$pdf->Cell(45, 6, date("m/d/Y"), '', 1, 'C');
				$pdf->Cell(5);
				$pdf->Cell(30, 4, '', 'LBTR');
				$pdf->Cell(30, 4, 'Vacation Leave', 'LBTR', 0, 'C');
				$pdf->Cell(30, 4, 'Sick Leave', 'LBTR', 1, 'C');

				$pdf->Cell(5);
				$pdf->Cell(30, 4, 'Total Earned', 'LBTR', 0, 'C');
				$pdf->Cell(30, 4, $wholevl, 'LBTR', 0, 'C');
				$pdf->Cell(30, 4, $wholesl, 'LBTR', 1, 'C');

				$pdf->Cell(5);
				$pdf->Cell(30, 4, 'Less this application', 'LBTR', 0, 'C');
				$pdf->Cell(30, 4, ($leave['leave_type'] == 'vacation' || $leave['leave_type'] == 'monetize'?$wd:'0'), 'LBTR', 0, 'C');
				$pdf->Cell(30, 4, ($leave['leave_type'] == 'sick'?$wd:'0'), 'LBTR', 1, 'C');

				$pdf->Cell(5);
				$pdf->Cell(30, 4, 'Balance', 'LBTR', 0, 'C');
				$pdf->Cell(30, 4, ($leave['leave_type'] == 'vacation' || $leave['leave_type'] == 'monetize'?$wholevl-$wd:$wholevl), 'LBTR', 0, 'C');
				$pdf->Cell(30, 4, ($leave['leave_type'] == 'sick'?$wholesl-$wd:$wholesl), 'LBTR', 1, 'C');



				$pdf->ln(8);
				$pdf->Cell(5);
				$pdf->Cell(90, 4, '(Authorized Officer)', 'T', 0, 'C');

				$pdf->setY($y);

				$pdf->Cell(122);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['recommendation'] == 'approve'?1:0));
				$pdf->Cell(40, 4, 'For Approval', '', 1);

				$pdf->ln(2);
				$pdf->Cell(122);
				$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['recommendation'] == 'disapprove'?1:0));
				$pdf->Cell(40, 4, 'For disapproval due to _________________', '', 1);

				$dremarks = $pdf->getY();

				$pdf->Cell(122);
				$pdf->MultiCell(67, 4, $leave['recommendation_remark'], '', 'C');
				$pdf->setY($dremarks);

				$pdf->Cell(122);
				$pdf->Cell(40, 4, '_____________________________________', '', 1);
				$pdf->Cell(122);
				$pdf->Cell(40, 4, '_____________________________________', '', 1);
				$pdf->Cell(122);
				$pdf->Cell(40, 4, '_____________________________________', '', 1);

				$pdf->ln(4);
				$pdf->Cell(123);
				$pdf->Cell(65, 4, utf8_decode($leave['authorized_official']), '', 0, 'C');
				$pdf->Cell(0, 4, '', '', 1);
				$pdf->Cell(123);
				$pdf->Cell(65, 4, '(Authorized Officer)', 'T', 1, 'C');
				$pdf->Cell(0, 0.55, '', '', 1,'', 1);
					$pdf->ln(1);

				$pdf->Cell(116, 6, '7.C APPROVED FOR:');
				$pdf->Cell(117, 6, '7.D DISAPPROVED OUT TO:', '' ,1);

				$pdf->Cell(6);
			  $pdf->Cell(117, 4, '_________ days with pay');
				$pdf->Cell(117, 4, '_____________________________________', '', 1);

				$pdf->Cell(6);
				$pdf->Cell(117, 4, '_________ days without pay');
				$pdf->Cell(117, 4, '_____________________________________', '', 1);

				$pdf->Cell(6);
				$pdf->Cell(117, 4, '_________ others (Specify)');
				$pdf->Cell(117, 4, '_____________________________________', '', 1);

				$pdf->ln(7);
				$pdf->Cell(60);
				$pdf->Cell(65, 5, utf8_decode($leave['authorized_official_dir']), '', 1, 'C');

				$pdf->Cell(60);
				$pdf->Cell(65, 5, '(Authorized Official)', 'T', 1, 'C');
				$pdf->Cell(0, 0.35, '', '', 1,'', 1);





				$pdf->setY($ystart);
			}
			}

			/*$pdf->Cell(6);
			$pdf->Cell(3, 3, '', 'LBTR');
			$pdf->Cell(4);
			$pdf->Cell(67.5, 5, 'Disapproval due to __________', '', 1);*/

			//  Duplicate End

			$pdf->SetAutoPageBreak(true);
			$pdf->Output();
		}

	public function getWeekdayDifference($startDate, $endDate)
	{	
		$startDate = new DateTime($startDate);
		$endDate = new DateTime($endDate);
		$isWeekday = function (\DateTime $date) {
			return $date->format('N') < 6;
		};
	
		$days = $isWeekday($endDate) ? 1 : 0;
		while($startDate->diff($endDate)->days > 0) {
			$days += $isWeekday($startDate) ? 1 : 0;
			$startDate = $startDate->add(new \DateInterval("P1D"));
		}
		return $days;
	}

	public function printLeave_old(){
		$this->load->library('fpdf_gen');

		if($this->input->post('leave_id') === null){
			redirect(site_url('hr/Leave'));
			exit();
		}
		$leave_id = explode(',',$this->input->post('leave_id'));
		/*array(210,148.5)*/
		/*$pdf = new FPDF('L','mm', 'A4');*/
		$pdf = new FPDF('L','mm', 'A4');
		$pdf->SetTitle('Leave Form');
		#$sec = $this->session->userdata('SECTION');
		$pdf->SetAutoPageBreak(false);


		foreach ($leave_id as $lid) {
			$leave = $this->leaveModel->getLeave($lid);
			$pdf->AddPage();

			$x= 0;
			$ystart = $pdf->getY();
			for ($i=0; $i < 2; $i++) {
				# code...

			$pdf->SetFont('Times', '', 7);
			$pdf->Cell(148.5, 3, 'CSC FORM NO. 6', '' , 1);
			$pdf->Cell(0, 3, 'Revised 1984');
			$pdf->setX($x);
			$pdf->SetFont('Arial', 'B', 11);
			$pdf->Cell(148.5, 5, 'APPLICATION FOR LEAVE', '' , 1, 'C');

			$pdf->SetFont('Arial', '', 10);
			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(35, 6, '1. AGENCY', 'RT' );
			$pdf->Cell(35, 6, '2. NAME (Last)', 'T');
			$pdf->Cell(35, 6, 'FIRST', 'RT');
			$pdf->Cell(30, 6, 'MIDDLE', 'T', 1, 'C');

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(35, 4, 'PNRI  ', 'R', 0, 'R');
			$pdf->Cell(35, 4, '    '. strtoupper($leave['employee']['lastname']).',');
			$pdf->Cell(35, 4, strtoupper($leave['employee']['firstname']), 'R');
			$pdf->Cell(30, 4, strtoupper($leave['employee']['middlename']), '', 1, 'C');

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(35, 5, '3. DATE OF FILING', 'RT' );
			$pdf->Cell(70, 5, '4. POSITION', 'RT');
			$pdf->Cell(30, 5, '5. SALARY', 'T', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(35, 4, $leave['date_filed'], 'R', 0, 'R');
			$pdf->Cell(70, 4, $leave['employee']['position_desc'], 'R', 0, 'C');
			$pdf->Cell(30, 4, 'SG'.$leave['salary_grade'], '', 1, 'C');

			$pdf->setX($x);
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Cell(10);
			$pdf->Cell(135.5, 5.5, 'DETAILS OF APPLICATION', 'TB' , 1, 'C');

			$pdf->SetFont('Arial', '', 10);
			$pdf->ln(1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(67.5, 6, '6. TYPE OF LEAVE', 'R' );
			$pdf->Cell(1);
			$pdf->Cell(67.5, 6, '6b. WHERE LEAVE WILL BE SPENT', '', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(7);
			$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'Vacation' || $leave['leave_type'] == 'Special' || $leave['leave_type'] == 'CTBTO'?1:0));
			$pdf->Cell(3);
			$pdf->Cell(54.5, 4, 'VACATION', 'R');
			$pdf->Cell(3);

			$pdf->Cell(64.5, 4, '1. IN CASE OF VACATION LEAVE', '', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(13);
			$pdf->Cell(35, 5, 'To seek employment _________', '', 0);

			#check
			$pdf->SetFont('Arial', 'BI', 12);
			$pdf->Cell(19.5, 5, ($leave['purpose'] != 'Others' && $leave['leave_type'] == 'Vacation'?'/':''), 'R', 0, 'C');
			$pdf->SetFont('Arial', '', 10);

			$pdf->Cell(7);
			$pdf->Cell(30, 5, 'Within Philippines ________________');
			$pdf->Cell(30, 5, ($leave['place'] == 'local' && $leave['leave_type'] == 'Vacation'?$leave['where_remark']:''), '', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(13);
			$pdf->Cell(35, 5, 'Others (specify) _____________');

			#check
			$pdf->SetFont('Arial', 'BI', 12);
			$pdf->Cell(19.5, 5, ($leave['purpose'] == 'Others' && $leave['leave_type'] == 'Vacation'?'/':''), 'R', 0, 'C');
			$pdf->SetFont('Arial', '', 10);

			$pdf->Cell(7);
			$pdf->Cell(30, 5, 'Abroad (specify)', '', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(13);
			$pdf->Cell(1, 5, '__________________________');

			#check
			$purpose = ($leave['purpose'] == 'Others' && $leave['leave_type'] == 'Vacation'?$leave['purpose_remark']:'');

			if($leave['leave_type'] == 'CTBTO' || $leave['leave_type'] == 'Special'){
				$purpose  =$leave['purpose'];
			}

			$pdf->Cell(53.5, 5, $purpose, 'R', 0, 'C');


			$pdf->Cell(7);
			$pdf->Cell(1, 5, '_______________________________');
			$pdf->Cell(53.5, 5, ($leave['place'] == 'abroad' && $leave['leave_type'] == 'Vacation'?$leave['where_remark']:''), '', 1, 'C');

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(67.5, 2,'','R', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			#SICK LEAVE
			$pdf->Cell(7);
			$pdf->Cell(3, 3, '', 'LBTR', 0, '', ($leave['leave_type'] == 'Sick'?1:0));
			$pdf->Cell(3);
			$pdf->Cell(54.5, 4, 'SICK', 'R');
			$pdf->Cell(3);

			$pdf->Cell(64.5, 4, '2. IN CASE OF SICK LEAVE', '', 1);


			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(13);
			$pdf->Cell(17, 5, 'Maternity', ($leave['purpose'] != 'Others' && $leave['leave_type'] == 'Sick'?'LBTR':''), 0);
			$pdf->Cell(18);
			$pdf->Cell(19.5, 5, '', 'R', '', 0);


			$pdf->Cell(7);
			$pdf->Cell(30, 5, 'In Hospital (specify)', '', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(13);
			$pdf->Cell(35, 5, 'Others (specify) _____________');


			#check
			$pdf->SetFont('Arial', 'BI', 12);
			$pdf->Cell(19.5, 5, ($leave['purpose'] == 'Others' && $leave['leave_type'] == 'Sick'?'/':''), 'R', 0, 'C');
			$pdf->SetFont('Arial', '', 10);

			$pdf->Cell(8);
			$pdf->Cell(1, 5, '______________________________');
			$pdf->Cell(53.5, 5, ($leave['place'] == 'local' && $leave['leave_type'] == 'Sick'?$leave['where_remark']:''), '', 1, 'C');


			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(13);
			$pdf->Cell(1, 5, '__________________________');
			#check
			$pdf->Cell(53.5, 5, ($leave['purpose'] == 'Others' && $leave['leave_type'] == 'Sick'?$leave['purpose_remark']:''), 'R', 0, 'C');


			$pdf->Cell(7);


			$pdf->Cell(30, 5, 'Out-Patient (specify)______________', '', 1);


			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(67.5, 6, '', 'R');
			$pdf->Cell(1);
			$pdf->Cell(7);
			$pdf->Cell(1, 5, '______________________________');
			$pdf->Cell(60.5, 6, ($leave['place'] == 'abroad' && $leave['leave_type'] == 'Sick'?$leave['where_remark']:''), '', 1, 'C');


			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(67.5, 6, '6c. No. of Working Days Applied', 'R');

			$pdf->Cell(67.5, 5, '6d. COMMUTATION', '', 1);

			$pdf->setX($x);
			$pdf->Cell(10);

			$pdf->Cell(6);
			$pdf->Cell(1, 5, 'For __________________________');


			$pdf->Cell(60.5, 5, count($leave['dates']).' Working Day' . (count($leave['dates']) > 1?'s':''), 'R', 0, 'C');

			$pdf->Cell(1);


			$pdf->Cell(7);
			$pdf->Cell(30, 5, 'Requested', ($leave['commutation'] == 1?'LBTR':''));
			$pdf->Cell(30, 5, 'Not Requested', ($leave['commutation'] == 0?'LBTR':''), 1);

			$pdf->setX($x);
			$pdf->Cell(10);

			$pdf->Cell(6);


			$pdf->Cell(18, 5, 'Inclusive Dates _________________');
			$inclusiveD = '';
			$prevm = '';
			$ct = 1;
			$prevd = 0;
			#echo '<pre>';

			$days = [];

			foreach ($leave['dates'] as $key) {
				array_push($days, $key->dd);
			}

			foreach ($leave['dates'] as $key) {


				#echo $days[$ct - 1]+1 .'!= ' . next($days) . '<br>';

				#when previous is not equal to current MONTH
				if($prevm != $key->md){
					$inclusiveD .= $key->md .'. ';
				}

				#echo ($prevd +1 ).'!='. $key->dd . ':' .($days[$ct - 1]+1) .'!= ' . next($days) .'<hr>';

				#echo ($prevd +1) .'!='. $key->dd .'||' .count($leave['dates']) .'=='. $ct .'<br>';
				if($prevd +1 != $key->dd || count($leave['dates']) == $ct ){
					$inclusiveD .= $key->dd;

					if(count($leave['dates']) == $ct || ($days[$ct - 1]+1) !=  next($days)){
						if(count($leave['dates']) != $ct){
							$inclusiveD .= ',';
						}
					}
					else{
						$inclusiveD .= '-';
					}


				}
				else{

					if(($days[$ct - 1]+1) !=  next($days)){
						$inclusiveD .= $key->dd . ',';
					}

				}

				/*if($days[$ct - 1]+1 .'!= ' . next($days)){
					$inclusiveD .=  '-'. $key->dd;
					if(count($leave['dates']) > $ct){
						$inclusiveD .= ',';
					}
				}*/


				$prevm = $key->md;
				$prevd = $key->dd;
				$ct++;

			}
			$inclusiveD .= ' '.$leave['dates'][0]->yd;

			$pdf->SetFont('Arial', '', 8);
			$pdf->Cell(8);
			$pdf->Cell(35.5, 5, $inclusiveD, 'R', 0, 'C');

			$pdf->SetFont('Arial', '', 10);
			$pdf->Cell(7);
			$pdf->Cell(15);
			$pdf->Cell(45, 5, '', 'B', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->SetFont('Times', 'B', 8);
			$pdf->Cell(67.5, 5, '', 'R');
			$pdf->Cell(7);
			$pdf->Cell(15);
			$pdf->Cell(45, 3, '(Signature of Applicant)', '', 1, 'C');
			$pdf->ln(2);
			$pdf->setX($x);
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Cell(10);
			$pdf->Cell(135.5, 5.5, 'DETAILS OF ACTION ON APPLICATION', 'TB' , 1, 'C');

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->SetFont('Arial', '', 10);
			$pdf->ln(1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(67.5, 5, '7a. CERTIFICATION OF LEAVE', 'R' );
			$pdf->Cell(1);
			$pdf->Cell(67.5, 5, '7b. RECOMMENDATION', '', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$y = $pdf->getY();
			$pdf->Cell(67.5, 7, 'CREDITS: as of ___________', 'R' , 1);


			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->SetFont('Times', 'B', 8);
			$pdf->Cell(21, 8, 'VACATION', 'TR', 0, 'C' );
			$pdf->Cell(21, 8, 'SICK', 'TR', 0, 'C' );
			$pdf->Cell(21, 8, 'TOTAL', 'TR', 0, 'C' );
			$pdf->Cell(4.5, 8,'', 'R', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->SetFont('Arial', '', 10);
			$pdf->Cell(21, 10, '', 'BTR', 0, 'C' );
			$pdf->Cell(21, 10, '', 'BTR', 0, 'C' );
			$pdf->Cell(21, 10, '', 'BTR', 0, 'C' );
			$pdf->Cell(4.5, 10,'', 'R', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(67.5, 5,'Personnel Officer', 'BR' ,0, 'R');

			$pdf->setY($y);

			$pdf->setX($x + 83.5);
			$pdf->Cell(3, 3, '', 'LBTR', '', 1, ($leave['recommendation'] == 'approve'?1:0) );
			$pdf->Cell(4);
			$pdf->Cell(67.5, 5, 'Approval', '', 1);

			$pdf->setX($x + 83.5);
			$pdf->Cell(3, 3, '', 'LBTR', '', 1, ($leave['recommendation'] == 'disapprove'?1:0) );
			$pdf->Cell(4);
			$pdf->Cell(67.5, 5, 'Disapproval due to ____________', '', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(73);
			$pdf->Cell(62.5, 5, ($leave['recommendation'] == 'disapprove'?$leave['recommendation_remark']:''), 'B', 1);

			$pdf->ln(8);


			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(90);
			$pdf->Cell(45.5, 3, utf8_decode($leave['authorized_official']), 'B', 1, 'C');



			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(90);

			$pdf->SetFont('Times', 'B', 8);
			$pdf->Cell(45.5, 3, 'Authorized Official', '', 1, 'C');

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(67.5);
			$pdf->Cell(67.5, 1, '', 'B', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->SetFont('Arial', '', 10);

			$pdf->Cell(67.5, 6, '7c. APPROVED FOR:');
			$pdf->Cell(1);
			$pdf->Cell(67.5, 6, '7d. DISAPPROVED DUE TO:', '', 1);

			$pdf->SetFont('Arial', '', 9);
			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(22, 4, '', 'B');
			$pdf->Cell(22, 4, 'days with pay', '', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(22, 4, '', 'B');
			$pdf->Cell(22, 4, 'days without pay', '', 1);

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(22, 4, '', 'B');
			$pdf->Cell(22, 4, 'others (specify)');
			$pdf->Cell(40);
			$pdf->Cell(50, 5, '', 'B', 1, 'C');

			$pdf->SetFont('Times', 'B', 8);
			$pdf->ln(8);
			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(48);
			$pdf->Cell(45, 3, '(Signature)', 'T', 0, 'C');


			$pdf->ln(8);
			$pdf->SetFont('Arial', '', 9);
			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(48);
			$pdf->Cell(45, 3, utf8_decode($leave['authorized_official_dir']), 'B', 1, 'C');

			$pdf->SetFont('Times', 'B', 8);
			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(48);
			$pdf->Cell(45, 3, '(Authorized Official)', '', 1, 'C');

			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->SetFont('Arial', '', 10);
			$pdf->ln(2);
			$pdf->setX($x);
			$pdf->Cell(10);
			$pdf->Cell(40, 3, 'Date: _______________');


			if($i == 0){
				$pdf->setXY(148.5, 0);
				$pdf->MultiCell(1, 5.5, "|||||||||||||||||||||||||||||||||||||||", 0);
			}
			$x+=148.5;

			$pdf->setY($ystart);
		}
		}

		/*$pdf->Cell(6);
		$pdf->Cell(3, 3, '', 'LBTR');
		$pdf->Cell(4);
		$pdf->Cell(67.5, 5, 'Disapproval due to __________', '', 1);*/

		//  Duplicate End

		$pdf->SetAutoPageBreak(true);
		$pdf->Output();
	}


	public function printLeaveCard(){
		$this->load->library('fpdf_gen');
		#$leave = $this->leaveModel->getLeave();
		$employee = $this->leaveModel->getEmployee();
		$leaveSummary = $this->leaveModel->getLeaveCreditsSummary();
		/*echo '<pre>';
		print_r($this->input->post());*/
		$lsum = $leaveSummary['summary'];
		$legacy = $leaveSummary['legacy'];
		$year = $this->input->post('year');
		$emp = $this->input->post('emp_id');
		/*array(210,148.5)*/
		/*$pdf = new FPDF('L','mm', 'A4');*/
		$pdf = new FPDF('L','mm', 'A4');
		$pdf->SetTitle('Leave Form');
		#$sec = $this->session->userdata('SECTION');
		$pdf->SetAutoPageBreak(false);

		$pdf->AddPage();

		$x= 0;
		$ystart = $pdf->getY();
			# code...

		$pdf->SetFont('Times', '', 12);
		$pdf->Cell(0, 4, 'REPUBLIC OF THE PHILIPPINES', '' , 1, 'C');

		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(0, 4, 'DEPARTMENT OF SCIENCE & TECHNOLOGY', '' , 1, 'C');
		$pdf->ln(3);
		$pdf->SetFont('Times', '', 14);
		$pdf->Cell(0, 4, 'Philippine Nuclear Research Institute', '' , 1, 'C');

		$pdf->ln(4);

		$pdf->Cell(0, 5, 'EMPLOYEE\'S LEAVE CARD', '' , 1, 'C');
		$pdf->ln(8);
		$pdf->SetFont('Times', '', 11);
		$pdf->Cell(11, 2, 'Name');
		$pdf->Cell(1, 4, '...............................................................................');

		$pdf->Cell(172, 2, '  '. strtoupper($employee['lastname'].', '. $employee['firstname'] . ' '. $employee['middlename']));

		$pdf->Cell(8, 2, 'Unit');
		$pdf->Cell(1, 4, '...............................................................................');
		$pdf->Cell(0, 2, '  '.$employee['division_code']. ($employee['unit_code'] != 'NU'?'/'.$employee['unit_code']:'') , '', 1);
		$pdf->ln(3);
		$pdf->Cell(0, 0.75, '', 'T', 1);
		$pdf->Cell(20, 4, '', 'TR', 0, 'C');
		$pdf->Cell(30, 20, 'PARTICULARS', 'LBTR', 0, 'C');
		$pdf->Cell(20, 20, ' EARNED', 'LBTR', 0, 'C');
		$pdf->Cell(55, 4, ' VACATION LEAVE', 'LBTR', 0, 'C');

		$pdf->Cell(30, 20, 'PARTICULARS', 'LBTR', 0, 'C');
		$pdf->Cell(20, 20, ' EARNED', 'LBTR', 0, 'C');
		$pdf->Cell(55, 4, ' SICK LEAVE', 'LBTR', 0, 'C');
		$pdf->Cell(0, 20, ' REMARKS', 'LBT', 0, 'C');

		$pdf->ln(4);
		$y = $pdf->getY();
		$pdf->Cell(20, 4, 'PERIOD', 'R', 1, 'C');
		$pdf->Cell(20, 4, 'YEAR', 'R', 1, 'C');
		$pdf->Cell(20, 4, 'MONTH', 'R', 1, 'C');
		$pdf->Cell(20, 4, '', 'BR', 0, 'C');

		$pdf->setY($y);
		$pdf->Cell(70);

		$pdf->SetFont('Times', '', 6);
		$pdf->Cell(20, 3, 'TOTAL NUMBER', 'LTR', 0, 'C');
		$pdf->Cell(15, 16, 'BALANCE', 'LBTR', 0, 'C');
		$pdf->Cell(20, 3, 'TOTAL NUMBER', 'LTR', 0, 'C');

		$pdf->Cell(50);
		$pdf->Cell(20, 3, 'TOTAL NUMBER', 'LTR', 0, 'C');
		$pdf->Cell(15, 16, 'BALANCE', 'LBTR', 0, 'C');
		$pdf->Cell(20, 3, 'TOTAL NUMBER', 'LTR', 1, 'C');

		$pdf->Cell(70);
		$pdf->Cell(20, 3, 'OF ABSENCES', 'LR', 0, 'C');
		$pdf->Cell(15);
		$pdf->Cell(20, 3, 'OF ABSENCES', 'LR', 0, 'C');

		$pdf->Cell(50);
		$pdf->Cell(20, 3, 'OF ABSENCES', 'LR', 0, 'C');
		$pdf->Cell(15);
		$pdf->Cell(20, 3, 'OF ABSENCES', 'LR', 1, 'C');

		$pdf->Cell(70);

		$pdf->Cell(20, 3, 'AND UNDERTIME', 'LR', 0, 'C');
		$pdf->Cell(15);
		$pdf->Cell(20, 3, 'AND UNDERTIME', 'LR', 0, 'C');

		$pdf->Cell(50);
		$pdf->Cell(20, 3, 'AND UNDERTIME', 'LR', 0, 'C');
		$pdf->Cell(15);
		$pdf->Cell(20, 3, 'AND UNDERTIME', 'LR', 1, 'C');


		$pdf->Cell(70);
		$pdf->SetFont('Times', '', 6);
		$pdf->Cell(20, 3, 'WITH PAY', 'LR', 0, 'C');
		$pdf->Cell(15);
		$pdf->Cell(20, 3, 'WITHOUT PAY', 'LR', 0, 'C');

		$pdf->Cell(50);
		$pdf->Cell(20, 3, 'WITH PAY', 'LR', 0, 'C');
		$pdf->Cell(15);
		$pdf->Cell(20, 3, 'WITHOUT PAY', 'LR', 1, 'C');


		$pdf->Cell(70);
		$pdf->SetFont('Times', '', 11);
		$pdf->Cell(10, 4, 'A', 'LBTR', 0, 'C');
		$pdf->Cell(10, 4, 'U', 'LBTR', 0, 'C');
		$pdf->Cell(15);
		$pdf->Cell(10, 4, 'A', 'LBTR', 0, 'C');
		$pdf->Cell(10, 4, 'U', 'LBTR', 0, 'C');

		$pdf->Cell(50);
		$pdf->Cell(10, 4, 'A', 'LBTR', 0, 'C');
		$pdf->Cell(10, 4, 'U', 'LBTR', 0, 'C');
		$pdf->Cell(15);
		$pdf->Cell(10, 4, 'A', 'LBTR', 0, 'C');
		$pdf->Cell(10, 4, 'U', 'LBTR', 1, 'C');

		$credits = $leaveSummary['start'];

		$vl_availed = $credits['legacy']['legvl'] + $credits['used']['approvedVL'] + $credits['monetized'] + $credits['ut']['utwpay'];
		$vl_balance = $credits['start']['vacation_credits'] + $credits['earned'];
		$vlc = $vl_balance- $vl_availed;

        $sl_availed = $credits['legacy']['legsl'] + $credits['used']['approvedSL'];
        $sl_balance = $credits['start']['sick_credits'] + $credits['earned'];
		$slc = $sl_balance- $sl_availed;


		$y = $pdf->getY();
		$pdf->Cell(20, 8, $year, 'BR', 0, 'C');
		$pdf->SetFont('Times', '', 8);
		$pdf->Cell(30, 4, 'BALANCE', 'R', 1, 'C');
		$pdf->Cell(20);
		$pdf->Cell(30, 4, 'BROUGHT FORWARD', 'BR', 0, 'C');
		$pdf->SetFont('Times', '', 10);

		$pdf->setY($y);
		$pdf->Cell(50);
		$pdf->Cell(20, 8, $vl_balance, 'BR', 0, 'C');
		$pdf->Cell(10, 8, $vl_availed, 'BR', 0, 'C');
		$pdf->Cell(10, 8, $credits['ut']['utwpay'], 'BR', 0, 'C');
		$pdf->Cell(15, 8, $vlc, 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR');
		$pdf->Cell(10, 8, '', 'BR');
		$pdf->Cell(30, 8, '', 'BR');
		$pdf->Cell(20, 8, $sl_balance, 'BR', 0, 'C');
		$pdf->Cell(10, 8, $sl_availed, 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(15, 8, $slc, 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR');
		$pdf->Cell(10, 8, '', 'BR');
		$pdf->Cell(0, 8, '', 'LB', 1, 'C');


		$pdf->Cell(20, 8, '', 'BR', 0, 'C');
		$pdf->Cell(30, 8, '', 'BR', 0, 'C');
		$pdf->Cell(20, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(15, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(30, 8, '', 'BR', 0, 'C');
		$pdf->Cell(20, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(15, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(0, 8, '', 'LB', 1, 'C');

		$earn = 0;
		$usedvl = 0;
		$usedsl = 0;
		$vbal = $vlc;
		$vbalf = $vlc;
		$sbal = $slc;
		$sbalf = $slc;
		$months = [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		if($credits['start']['masof'] == 12)  $credits['start']['masof'] =1;

		for ($i=0; $i < 12; $i++) {
			$pdays = $this->leaveModel->getParticulars($emp, 'vacation', $i+1, $year);
			$vparticulars = $this->setParticulars($pdays);

			$pdays = $this->leaveModel->getParticulars($emp, 'sick', $i+1, $year);
			$sparticulars = $this->setParticulars($pdays);


			$current_month = date('m');
			if($credits['start']['masof'] <= $i+1 && $current_month >= $i+1 || $year != 2022){
				if($lsum[$i]->monetized > 0){
					$vparticulars .= ' ('.$lsum[$i]->monetized . 'M)';
				}
				$vbal = ($vbal += $lsum[$i]->earned) - ($lsum[$i]->usedvl + $legacy[$i]->legvl) - $lsum[$i]->utwpay - (round(($lsum[$i]->lwop + $legacy[$i]->legvlwop) * 0.04166, 3));
				$sbal = ($sbal += $lsum[$i]->earned) - ($lsum[$i]->usedsl+ $legacy[$i]->legsl);
				$vbal -= $lsum[$i]->monetized;
				$pdf->Cell(20, 8, $months[$i], 'BR', 0, 'C');
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(30, 8, $vparticulars, 'BR', 0, 'C');
				$pdf->SetFont('Times', '', 9);
				$pdf->Cell(20, 8, $lsum[$i]->earned, 'BR', 0, 'C');
				$pdf->Cell(10, 8, $lsum[$i]->usedvl + $legacy[$i]->legvl, 'BR', 0, 'C');
				$pdf->Cell(10, 8, $lsum[$i]->utwpay, 'BR', 0, 'C');
				$pdf->Cell(15, 8, $vbal, 'BR', 0, 'C');
				$pdf->Cell(10, 8, round(($lsum[$i]->lwop + $legacy[$i]->legvlwop) * 0.04166, 3) , 'BR', 0, 'C');
				$pdf->Cell(10, 8, $lsum[$i]->utwopay, 'BR', 0, 'C');
				$pdf->SetFont('Arial', '', 8);
				$pdf->Cell(30, 8, $sparticulars, 'BR', 0, 'C');
				$pdf->SetFont('Times', '', 9);
				$pdf->Cell(20, 8,  $lsum[$i]->earned, 'BR', 0, 'C');
				$pdf->Cell(10, 8,  ($lsum[$i]->usedsl+ $legacy[$i]->legsl), 'BR', 0, 'C');
				$pdf->Cell(10, 8, '', 'BR');
				$pdf->Cell(15, 8, $sbal, 'BR', 0, 'C');
				$pdf->Cell(10, 8, '', 'BR');
				$pdf->Cell(10, 8, '', 'BR');
				$pdf->Cell(0, 8, '', 'LB', 1, 'C');
				$vbalf = $vbal;
				$sbalf = $sbal;
			}
			else{
				$pdf->Cell(20, 8, $months[$i], 'BR', 0, 'C');
				$pdf->Cell(30, 8, '', 'BR');
				$pdf->Cell(20, 8, '', 'BR');
				$pdf->Cell(10, 8, '', 'BR');
				$pdf->Cell(10, 8, '', 'BR');
				$pdf->Cell(15, 8, '', 'BR');
				$pdf->Cell(10, 8, '', 'BR');
				$pdf->Cell(10, 8, '', 'BR');
				$pdf->Cell(30, 8, '', 'BR');
				$pdf->Cell(20, 8, '', 'BR');
				$pdf->Cell(10, 8, '', 'BR');
				$pdf->Cell(10, 8, '', 'BR');
				$pdf->Cell(15, 8, '', 'BR');
				$pdf->Cell(10, 8, '', 'BR');
				$pdf->Cell(10, 8, '', 'BR');
				$pdf->Cell(0, 8, '', 'LB', 1);
			}
		}

		$pdf->Cell(20, 8, '', 'BR', 0, 'C');
		$pdf->SetFont('Times', '', 9);
		$y = $pdf->getY();
		$pdf->MultiCell(30, 4, 'TOTAL BALANCE FORWARDED', 'BR', 'C');
		$pdf->setY($y);
		$pdf->Cell(50);
		$pdf->SetFont('Times', '', 11);
		$pdf->Cell(20, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(15, 8, $vbal, 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(30, 8, '', 'BR', 0, 'C');
		$pdf->Cell(20, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(15, 8, $sbal, 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(10, 8, '', 'BR', 0, 'C');
		$pdf->Cell(0, 8, $credits['start']['as_of_date2'] . $credits['start']['curd'], 'LB', 1, 'C');

		$pdf->Cell(0, 1, '', 'B', 1);
		$pdf->Cell(0, 1, '', 'B', 1);
		#
		/*$pdf->Cell(6);
		$pdf->Cell(3, 3, '', 'LBTR');
		$pdf->Cell(4);
		$pdf->Cell(67.5, 5, 'Disapproval due to __________', '', 1);*/

		//  Duplicate End

		 $pdf->SetY(-15);
	    // Arial italic 8
	    $pdf->SetFont('Arial','I',8);
	    // Page number
	    $pdf->Cell(0,10,'printed on  '. date("Y-m-d h:i a"),0,0,'R');

		$pdf->SetAutoPageBreak(true);
		$pdf->Output();
	}

function setParticulars($pdays){
	$inclusiveD = '';

	if(!empty($pdays)){
		$prevm = '';
		$ct = 1;
		$prevd = 0;
		#echo '<pre>';

		$days = [];
		foreach ($pdays as $key) {
			array_push($days, $key->dayl);
		}

		foreach ($pdays as $key) {
			#echo $days[$ct - 1]+1 .'!= ' . next($days) . '<br>';

			#when previous is not equal to current MONTH

			if($prevd +1 != $key->dayl || count($pdays) == $ct ){
				$inclusiveD .= $key->dayl;

				if(count($pdays) == $ct || ($days[$ct - 1]+1) !=  next($days)){
					if(count($pdays) != $ct){
						$inclusiveD .= ', ';
					}
				}
				else{
					$inclusiveD .= '-';
				}


			}
			else{

				if(($days[$ct - 1]+1) !=  next($days)){
					$inclusiveD .= $key->dayl . ', ';
				}

			}

			$prevd = $key->dayl;
			$ct++;

		}


	}
	else{
		$inclusiveD = '';
	}

	return $inclusiveD;
}
	function get_announcements(){
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->intranetModel->get_announcements()));
	}


	function saveStartCredits(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->leaveModel->saveStartCredits()));
	}

	function getLeaveCredits(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->leaveModel->getLeaveCredits($this->input->post('emp'))));
	}

	function getEmployees(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->leaveModel->getEmployees()));
	}


	function submitLeave(){
		$this->output->set_content_type("application/json")->set_output(json_encode($this->leaveModel->submitLeave()));
		/* // $this->output->set_content_type("application/json")->set_output(json_encode($this->input->post()));
		foreach ($this->input->post('dates') as $key) {
			echo date("Y-m-d", strtotime($key));
			/* $ishalf_day = 0;
			if($this->input->post('half_dates')){
				// if (in_array(date("Y-m-d", strtotime($key)), $this->input->post('half_dates'))) {
				if (in_array($key, $this->input->post('half_dates'))) {
					$ishalf_day = 1;
				}
			}

			$d = array(
			'leave_id' => $leave_id,
			'ishalf_day' => $ishalf_day,
			'ldate' => date("Y-m-d", strtotime($key))
			); 
		  }*/
		//   var_dump($this->input->post('half_dates')); */
	}

	function submitLegLeave(){
		$this->output->set_content_type("application/json")->set_output(json_encode($this->leaveModel->submitLegLeave()));
	}
	function updateLegacy(){
		$this->output->set_content_type("application/json")->set_output(json_encode($this->leaveModel->updateLegacy()));
	}
	function deleteLegacy(){
		$this->output->set_content_type("application/json")->set_output(json_encode($this->leaveModel->deleteLegacy()));
	}
	function deleteLeave(){
		$this->output->set_content_type("application/json")->set_output(json_encode($this->leaveModel->deleteLeave()));
	}
	function cancelLeave(){
		$this->output->set_content_type("application/json")->set_output(json_encode($this->leaveModel->cancelLeave()));
	}

	function resetCredits(){
	  $this->output->set_content_type("application/json")
	  ->set_output(json_encode($this->leaveModel->resetCredits($this->input->post('emp'))));
	}


	function getLegLeaves(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->leaveModel->getLegLeaves()));
	}
}
?>
