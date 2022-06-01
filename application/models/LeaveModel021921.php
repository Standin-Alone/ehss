<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class leaveModel extends CI_Model{
	
	function submitLeave(){
		$post = $this->input->post();

	  	$dates = explode(',', $post['dates']);
	  	
	/* => Others
     => local
     => Not Requested
     => 02/01/2021,02/02/2021
     => disapprove
     => Others
     => 123
     => 123123

$post['dates']*/

	  	$leave = array(
	  		'submit_by' => $this->session->userdata('id'),
	  		'leave_type' => $post['ltype'],
	  		'purpose' => $post['purpose'],
	  		'purpose_remark' => $post['purpose_remarks'],
	  		'place' => $post['where'],
	  		'where_remark' => $post['where_remarks'],
	  		'recommendation' => $post['recommendation'],
	  		'recommendation_remark' => $post['recommendation_remarks'],
	  		'commutation' => $post['commutation']
	  	);
	  	echo '<pre>';
		print_r($leave);

	  	$this->db->insert('intranet.leave_application', $leave);
	  	#$leave_id =  $this->db->insert_id();
	  	/*foreach ($dates as $key) {
	  		$d = array(
	  		'leave_id' => $leave_id,
	  		'ldate' => date("Y-m-d", strtotime($key))
	  		);
	  		$this->db->insert('intranet.leave_dates', $d);
	  	}*/
	}
	function getEmployee(){
		$eid = $this->input->post('emp_id');
		$employee =  $this->db->query("SELECT employee_id, empno, lastname, firstname, middlename, unit_code, division_code from infosys.employee e
								INNER JOIN unit on unit_id = unit_unit_id 
						        INNER JOIN division on division_id = division_division_id 
						        where employee_id = ?", array($eid))->row_array();

		$msc = array(75, 222);
		$md = array(521);
		$phd = array(77, 66, 336, 79, 352, 332, 327, 257, 205 , 239 , 16, 96, 219, 208);
		if (in_array($eid, $msc)) {
		    $employee['middlename'] .= ', M.Sc.';
		}
		if (in_array($eid, $phd)) {
		    $employee['middlename'] .= ', Ph.D.';
		}
		if (in_array($eid, $md)) {
		    $employee['middlename'] .= ', M.D.';
		}

		return $employee;

	}

	function getEmployees(){
		$employee = $this->db->query("SELECT employee_id, empno, lastname, firstname, middlename from infosys.employee where employment_status_library_employment_status_library_id = 1 order by lastname")->result();
		$select ='';
		foreach ($employee as $e) {
			$select .= '<option value="'.$e->employee_id.'">'.$e->empno.' - '.$e->lastname.', '. $e->firstname. ' ' .$e->middlename.'</option>';
		}

		return $select;
	}

	function getLeave($lid){
		$leave = $this->db->query("SELECT *, date_format(date_created, '%m/%d/%y') as date_filed FROM intranet.`leave_application` WHERE id = ?", array($lid))->row_array();
		$leave['employee'] = $this->db->query("SELECT lastname, firstname, middlename, position_desc FROM infosys.`employee` e
												INNER JOIN position_reference pr 
												on position_reference_id = position_reference_position_reference_id
												WHERE employee_id = ?", array($leave['submit_by']))->row_array();
		$leave['salary_grade'] = $this->db->query("SELECT salary_grade FROM `plantilla` p
													INNER JOIN plantilla_library pl 
													on plantilla_library_id = plantilla_library_plantilla_library_id
													INNER JOIN plantilla_salary ps 
													on plantilla_salary_plantilla_salary_id = plantilla_salary_id
													WHERE `employee_employee_id` = ? and pstat = 1", array($leave['submit_by']))->row_array()['salary_grade'];

		$leave['dates'] = $this->db->query("SELECT id, ldate, date_format(ldate, '%b') md, day(ldate) dd, year(ldate) yd, `status` FROM intranet.leave_dates WHERE leave_id = ? order by `ldate` asc", array($leave['id']))->result();

		return $leave;
	}

	
	function approveDates(){
		$post = $this->input->post();
		$this->db->query("UPDATE intranet.`leave_application` SET `status` = 'Done' WHERE id = ?", array($post['id']));

		foreach ($post['approvedDates'] as $key) {
			$this->db->query("UPDATE intranet.`leave_dates` SET `status` = '1' WHERE id = ?", array($key));
		}

	}

	function saveStartCredits(){
		$post = $this->input->post();
		
		$icredits = array(
			'emp_id'=> $post['emp'],
			'vacation_credits'=>  $post['start_vlc'],
			'sick_credits'=>  $post['start_slc'],
			'as_of_date' =>  date("Y") .'-12-31'

		);
		$credits = $this->db->query("INSERT INTO intranet.`leave_credits`(`emp_id`, `vacation_credits`, `sick_credits`, `as_of_date`) VALUES (?, ?, ?, ? ) ", $icredits);

	}

	function getLeaveCreditsSummary(){
		$eid = $this->input->post('emp_id');
		$lc['start'] = $this->db->query("SELECT *, month(as_of_date) masof, DATE_FORMAT(as_of_date, 'From %m/%d - ') as_of_date2,  DATE_FORMAT(curdate(), '%m/%d %Y') curd FROM intranet.`leave_credits` WHERE emp_id = ?", array($eid))->row_array();
		$lc['summary'] = $this->db->query("SELECT *,
  
											ROUND( 
											    if( mm = MONTH(CURDATE()), 
											       IF( mm = mbeg, DAY(CURDATE()) - DAY(as_of_date), DAY(CURDATE()))
											       
											       ,
											       IF( mm = mbeg, DAY(
											            LAST_DAY( 
											                CONCAT(YEAR(CURDATE()) , '-',mm, '-01' )
											            )
											        ) - DAY(as_of_date), DAY(
											            LAST_DAY( 
											                CONCAT(YEAR(CURDATE()) , '-',mm, '-01' )
											            )
											        ))
											       ) * 0.041665
											, 3) earned,

											MONTH(CURDATE()) curm FROM 
																	(
																    SELECT 1 mm UNION ALL SELECT 2 UNION ALL SELECT 3 
																    UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7  
																    UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 
																    UNION ALL SELECT 12
																						) derived
																	LEFT JOIN 
																	(SELECT MONTH(date_created) mcreated,  COUNT(CASE WHEN leave_type = 'Vacation' THEN 1 END) as usedvl, 
																							   COUNT(CASE WHEN leave_type = 'Sick' THEN 1 END) as usedsl  FROM 
																	intranet.`leave_application` la 
																	INNER JOIN intranet.leave_dates ld on la.id = ld.leave_id
																	WHERE submit_by = ?
																	GROUP BY MONTH(date_created)) as counts
																	on derived.mm = mcreated
											                        
											                        LEFT JOIN 
																	(SELECT as_of_date, MONTH(as_of_date) mbeg FROM intranet.leave_credits where emp_id = ?) beg
											                        on mbeg = derived.mm
											                        
											                        ORDER BY mm", array($eid, $eid))->result();

		return $lc;
	}


	function getLeaveCredits($emp){
		$credits = $this->db->query("SELECT *, round(DATEDIFF(curdate(), as_of_date)*0.041665, 3) as earned_vl, round(DATEDIFF(curdate(), as_of_date)*0.041665, 3) as earned_sl FROM intranet.`leave_credits` WHERE emp_id = ?", array($emp))->row_array();

		if($credits !== NULL)
		$credits['used'] = $this->db->query("SELECT  COUNT(CASE WHEN ld.status is null AND leave_type = 'Vacation' THEN 1 END) as pendingVL,
											 COUNT(CASE WHEN ld.status = 1 AND leave_type = 'Vacation' THEN 1 END) as approvedVL,
											 COUNT(CASE WHEN ld.status is null AND leave_type = 'Sick' THEN 1 END) as pendingSL,
											 COUNT(CASE WHEN ld.status = 1 AND leave_type = 'Sick' THEN 1 END) as approvedSL FROM intranet.`leave_application` la 
											 inner join intranet.leave_dates ld
											 on la.id = leave_id
											 WHERE submit_by = ?", array($emp))->row_array();
		

		return $credits;
	}


	function getLeaves(){
		if($this->input->post('emp') == null){
			$q = $this->db->query("SELECT la.*, date_format(date_created, '%m/%d/%Y') as date_filed, lastname, firstname, middlename FROM intranet.`leave_application` la 	
									INNER JOIN infosys.`employee` e on employee_id = la.submit_by
									WHERE status = 'Pending'");
		}
		else{
			$q = $this->db->query("SELECT *, date_format(date_created, '%m/%d/%Y') as date_filed FROM intranet.`leave_application` WHERE submit_by = ?", array($this->input->post('emp')));	
		}
		

		if ($q->num_rows() > 0){
			foreach ($q->result() as $key) {




				$leave = $key;
				$leave->dates = $this->db->query("SELECT ldate, date_format(ldate, '%b') md, day(ldate) dd, year(ldate) yd FROM intranet.leave_dates WHERE leave_id = ? order by `ldate` asc", array($key->id))->result();

				$inclusiveD = '';
				$prevm = '';
				$ct = 1;
				$prevd = 0;

				$days = [];

				foreach ($leave->dates as $dkey) {
					array_push($days, $dkey->dd);
				}

				foreach ($leave->dates as $ddkey) {
					if($prevm != $ddkey->md){
						$inclusiveD .= $ddkey->md .'. ';
					}
					if($prevd +1 != $ddkey->dd || count($leave->dates) == $ct ){
						$inclusiveD .= $ddkey->dd;

						if(count($leave->dates) == $ct || ($days[$ct - 1]+1) !=  next($days)){
							if(count($leave->dates) != $ct){
								$inclusiveD .= ',';
							}
						}
						else{
							$inclusiveD .= '-';
						}
					}
					else{
						if(($days[$ct - 1]+1) !=  next($days)){
							$inclusiveD .= $ddkey->dd . ',';
						}
					}
					$prevm = $ddkey->md;
					$prevd = $ddkey->dd;
					$ct++;
				}

				$inclusiveD .= ' ('. count($leave->dates).' Working Days)';


				if($this->input->post('emp') == null){
					$result[] = array(
						#'<div class="checker" onclick="toggleClick(this)"><span><input type="checkbox"></span></div>',
						$key->lastname. ', ' . $key->firstname .' ' . $key->middlename,
						html_escape($key->leave_type),
						html_escape(($key->purpose == 'Others'?'Others: '.$key->purpose_remark:($key->leave_type == 'Vacation'?'To seek employment':'Maternity') ) ),
						html_escape($key->date_filed),
						html_escape($inclusiveD),
						'<span class="badge '.$key->status.'">'.$key->status.'</span>',
						#html_escape('route'),
						'<div style="display:flex;width: 50%;margin: auto;"><form method="post" action="'. base_url('hr/Leave/printLeave').'" target="__blank">
							<input type="hidden" name="leave_id" value="'.$key->id.'">
							<button class="btn btn-default"><i class="fa fa-print"></i> </button>
						</form>
						<button class="btn btn-default" onclick="viewLeave('.$key->id.')"  data-toggle="modal" href="#Leave_modal"><i class="fa fa-eye"></i> </button></div>'					
					);	
				}
				else{
					$result[] = array(
						html_escape($key->leave_type),
						html_escape(($key->purpose == 'Others'?'Others: '.$key->purpose_remark:($key->leave_type == 'Vacation'?'To seek employment':'Maternity') ) ),
						html_escape($key->date_filed),
						html_escape($inclusiveD),
						'<span class="badge '.$key->status.'">'.$key->status.'</span>',
						#html_escape('route'),
						'<div style="display:flex;width: 50%;margin: auto;"><form method="post" action="'. base_url('hr/Leave/printLeave').'" target="__blank">
							<input type="hidden" name="leave_id" value="'.$key->id.'">
							<button class="btn btn-default"><i class="fa fa-print"></i> </button>
						</form>
						<button class="btn btn-default" onclick="viewLeave('.$key->id.')"  data-toggle="modal" href="#Leave_modal"><i class="fa fa-eye"></i> </button></div>'					
					);	
				}
				

			}
			return $result;
		}
		else {
			return '';
		}
	}
	

}