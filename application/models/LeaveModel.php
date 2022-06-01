<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class leaveModel extends CI_Model{

	function submitLeave(){
		$post = $this->input->post();
	  	$dates = explode(',', $post['dates']);
		$half_dates = $post['half_dates'];

		// $control_no = $this->db->query("SELECT CONCAT(YEAR(CURDATE()), '-', LPAD((SELECT COUNT(id) + 1 FROM `leave_application` WHERE year(date_created) = YEAR(CURDATE())) + 1, 4, '0')) control_no")->row()->control_no;
		$control_no = $this->db->query("SELECT CONCAT(YEAR(CURDATE()), '-', LPAD((SELECT COUNT(id) + 1 FROM intranet.leave_application
			WHERE year(date_created) = YEAR(CURDATE())) + 1, 4, '0')) control_no")->row_array()['control_no'];
		
	  	$leave = array(
	  		'submit_by' => $post['emp'],
				'control_no' => $control_no,
	  		'leave_type' => $post['ltype'],
	  		'place' => $post['where'],
	  		'where_remark' => $post['where_remarks'],
			  'date_created' => $post['date_filed'],
	  		'recommendation' => $post['recommendation'],
	  		'recommendation_remark' => $post['recommendation_remarks'],
	  		'commutation' => $post['commutation']
	  	);
		if($post['ltype'] == 'maternity' || $post['ltype'] == 'study'){
				$leave['maternity_start'] = $post['date_from'];
				$leave['maternity_end'] = $post['date_to'];
		}
		$leave_id = $post['leaveid'];
		if($leave_id){
			$leave = array(
				'leave_type' => $post['ltype'],
				'place' => $post['where'],
				'where_remark' => $post['where_remarks'],
				'date_created' => $post['date_filed'],
				'recommendation' => $post['recommendation'],
				'recommendation_remark' => $post['recommendation_remarks'],
				'commutation' => $post['commutation']
			);

			$this->db->where('id', $post['leaveid']);
			$this->db->update('intranet.leave_application', $leave);
			$this->db->query('DELETE FROM intranet.leave_dates where leave_id = '.$post['leaveid']);
		}else{
			$this->db->insert('intranet.leave_application', $leave);
			$leave_id =  $this->db->insert_id();
		}

	  	if($post['ltype'] == 'monetize' || $post['ltype'] == 'terminal'){
			$d = array(
				'leave_id' => $leave_id,
				'to_monetize' => $post['dates']
			);
			$this->db->insert('intranet.leave_dates', $d);
		}else{
			foreach ($dates as $key) {
				$ishalf_day = 0;
				if($half_dates){
					if (in_array(date("Y-n-j", strtotime($key)), $half_dates)) {
						$ishalf_day = 1;
					}
				}
				$d = array(
				'leave_id' => $leave_id,
				'ishalf_day' => $ishalf_day,
				'vaccination' => $post['vaccination'],
				'ldate' => date("Y-m-d", strtotime($key))
				);
				$this->db->insert('intranet.leave_dates', $d);
			}
		}
	}

 function getParticulars($emp, $type, $m, $y){
	 return $this->db->query("SELECT * FROM (SELECT CAST(DATE_FORMAT(legacy_ldate, '%e') AS INT) as dayl FROM intranet.`legacy_dates` WHERE employee_id = ? and type = ? and YEAR(legacy_ldate) = $y and month(legacy_ldate) = $m
	 						UNION SELECT CAST(DATE_FORMAT(ldate, '%e') AS INT) as dayl FROM intranet.`leave_dates` ld INNER JOIN intranet.leave_application la on la.id = ld.leave_id and ld.status = 1 WHERE submit_by = ? and leave_type = ? and YEAR(ldate) = $y and month(ldate) = $m) as leaveDates ORDER by dayl asc", array($emp, $type, $emp, $type))->result();
 }
	function submitLegLeave(){
		$post = $this->input->post();
	  	$dates = explode(',', $post['dates']);
		foreach ($dates as $key) {
		  	$leave = array(
		  		'legacy_ldate' =>  date("Y-m-d", strtotime($key)),
		  		'wpay' => $post['wpay'],
		  		'type' => $post['ltype'],
		  		'employee_id' => $post['emp'],
		  	);
	  		$this->db->insert('intranet.legacy_dates', $leave);
	  	}
	}

	function resetCredits($emp){
		$this->db->query("UPDATE intranet.`leave_credits` SET `emp_id`= ? WHERE emp_id = ?", array($emp - ($emp *2), $emp));
	}


	function getLeaveTypes(){
		return $this->db->query("SELECT * FROM intranet.`leave_types` WHERE 1 order by description")->result();
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
		$leave = $this->db->query("SELECT *, date_format(date_created, '%m/%d/%y') as date_filed, date_format(maternity_start, '%b. %d, %y') as maternity_startf, date_format(maternity_end, '%b. %d, %y') as maternity_endf, DATEDIFF(maternity_end, maternity_start) +1 no_days FROM intranet.`leave_application` WHERE id = ?", array($lid))->row_array();
		$leave['employee'] = $this->db->query("SELECT lastname, firstname, middlename, position_desc, name_extension FROM infosys.`employee` e
												INNER JOIN position_reference pr
												on position_reference_id = position_reference_position_reference_id
												WHERE employee_id = ?", array($leave['submit_by']))->row_array();
		$leave['salary_grade'] = $this->db->query("SELECT plantilla_salary_plantilla_salary_id as salary_grade FROM `plantilla` p
													INNER JOIN plantilla_library pl
													on plantilla_library_id = plantilla_library_plantilla_library_id
													INNER JOIN plantilla_salary ps
													on plantilla_salary_plantilla_salary_id = plantilla_salary_id
													WHERE `employee_employee_id` = ? and pstat = 1", array($leave['submit_by']))->row_array()['salary_grade'];

		$leave['dates'] = $this->db->query("SELECT *, date_format(ldate, '%b') md, day(ldate) dd, year(ldate) yd FROM intranet.leave_dates WHERE leave_id = ? order by `ldate` asc", array($leave['id']))->result();

		return $leave;
	}


	function approveDates(){
		$post = $this->input->post();

		$this->db->query("UPDATE intranet.`leave_application` SET `status` = 'Done' WHERE id = ?", array($post['id']));
		$leave = $this->db->query("SELECT submit_by, leave_type, maternity_end, maternity_start, recommendation FROM intranet.`leave_application` WHERE id = ?", array($post['id']))->row_array();
		$leaveType = '';
		$c = 0;

		if($leave['leave_type'] == 'maternity'||$leave['leave_type'] == 'study'){
			$lddate = $this->db->query("select *, DATE_FORMAT(DATE_ADD(selected_date, INTERVAL 2 MONTH), '%Y-%m-01') as saldate  from
			(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
			 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
			 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
			 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
			 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
			 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
			where selected_date between ? and ? AND DAYOFWEEK(selected_date) != 1 AND DAYOFWEEK(selected_date) != 7 AND DATE_FORMAT(selected_date, '%m-%d')
			 NOT IN (SELECT DATE_FORMAT(sdate,'%m-%d') sdate FROM infosys.`holidays` WHERE repeats = 1)", array($leave['maternity_start'], $leave['maternity_end']))->result();

			 $leaveType = ($post['wpay'] == 1?'MLWP':'MLWOP');
			 foreach ($lddate as $key) {
				 $leave_date = array(
	 				  'eeid' => $leave['submit_by'],
	 					'lvtype' => $leaveType,
	 					'lvdate' => $key->selected_date,
	 					'saldate' => $key->saldate
					);
					$this->db->insert('payroll_sbg.eeleaves', $leave_date);
			 }
 			$c++;
		}
		else if($leave['leave_type'] == 'monetize'){
			$ldate = $this->db->query("UPDATE intranet.`leave_dates` SET `ap_monetize`=? WHERE leave_id = ?", array($post['wpay'], $post['id']));
		}
		else{

		foreach ($post['approvedDates'] as $key) {
			$this->db->query("UPDATE intranet.`leave_dates` SET `status` = '1', wpay = ? WHERE id = ?", array($post['wpay'][$c], $key));
			$ldate = $this->db->query("SELECT ldate, DATE_FORMAT(DATE_ADD(ldate, INTERVAL 2 MONTH), '%Y-%m-01') as saldate FROM intranet.`leave_dates` WHERE id = ?", array($key))->row_array();


			switch ($leave['leave_type']) {
				case 'vacation':
					$leaveType = ($post['wpay'][$c] == 1?'VLWP':'VLWOP');
					break;
				case 'sick':
					$leaveType = ($post['wpay'][$c] == 1?'SLWP':'SLWOP');
					break;
				case 'study':
					$leaveType = ($post['wpay'][$c] == 1?'TLWP':'TLWOP');
					break;
				case 'mandatory':
					$leaveType = ($post['wpay'][$c] == 1?'DLWP':'DLWOP');
					break;
				default:
					$leaveType = ($post['wpay'][$c] == 1?'VLWP':'VLWOP');
					break;
			}
			if($leave['leave_type'] == 'mandatory' && $leave['recommendation'] == 'disapprove'){

			}
			else{
				$this->db->insert('payroll_sbg.eeleaves', array(
						'eeid' => $leave['submit_by'],
						'lvtype' => $leaveType,
						'lvdate' => $ldate['ldate'],
						'saldate' => $ldate['saldate']
				));
			}

			$c++;
			}
		}
	}

	function saveStartCredits(){
		$post = $this->input->post();

		$icredits = array(
			'emp_id'=> $post['emp'],
			'vacation_credits'=>  $post['start_vlc'],
			'sick_credits'=>  $post['start_slc'],
			'begin_vlc' => $post['begin_vlc'],
			'leave_vlc' => $post['leave_vlc'],
			'undertime_vlc' => $post['undertime_vlc'],
			'begin_slc' => $post['begin_slc'],
			'leave_slc' => $post['leave_slc'],
			'undertime_slc' => $post['undertime_slc'],
			'as_of_date' => $post['start_date']

		);
		$credits = $this->db->insert("intranet.`leave_credits`", $icredits);

	}

	function deleteLegacy(){
		$post = $this->input->post();
		$this->db->query("INSERT INTO intranet.`legacy_dates_x`(`leg_id`, `legacy_ldate`, `type`, `employee_id`, `wpay`)
											SELECT `id`, `legacy_ldate`, `type`, `employee_id`, `wpay`, 'd' FROM intranet.`legacy_dates` WHERE id = ?", array($post['id']));
	  $this->db->query("DELETE FROM intranet.`legacy_dates` WHERE id = ?", array($post['id']));

	}

	function updateLegacy(){
		$post = $this->input->post();
		$this->db->query("INSERT INTO intranet.`legacy_dates_x`(`leg_id`, `legacy_ldate`, `type`, `employee_id`, `wpay`)
											SELECT `id`, `legacy_ldate`, `type`, `employee_id`, `wpay`,  'u' FROM intranet.`legacy_dates` WHERE id = ?", array($post['id']));
		$leave = array('type' => $post['ltype'], 'wpay' => $post['wpay'], 'legacy_ldate' => $post['dates'], 'ishalf_day' => $post['half']);
		$this->db->where('id', $post['id']);
		$this->db->update('intranet.legacy_dates', $leave);

	}

	function getLeaveCreditsSummary(){

		/*$lc['legacy'] = $this->db->query("SELECT * FROM (
															SELECT 1 mm UNION ALL SELECT 2 UNION ALL SELECT 3
															UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7
															UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11
															UNION ALL SELECT 12
														) derived
										LEFT JOIN
                                        (
	                                        SELECT (COUNT(CASE WHEN type = 'vacation' and wpay = 1 THEN 1 END) - (COUNT(CASE WHEN type = 'vacation' and wpay = 1 and ishalf_day = 1 THEN 1 END) * 0.5))  as legvl,
												   (COUNT(CASE WHEN type = 'sick' and wpay = 1 THEN 1 END) - (COUNT(CASE WHEN type = 'sick' and wpay = 1 and ishalf_day = 1 THEN 1 END) * 0.5)) as legsl,
                                            	   COUNT(CASE WHEN type = 'vacation' and wpay = 0 THEN 1 END) as legvlwop,
												   COUNT(CASE WHEN type = 'sick' and wpay = 0 THEN 1 END) as legslwop,
												   MONTH(legacy_ldate) mleg
												   FROM intranet.`legacy_dates`
	                                         WHERE `employee_id` = ? GROUP BY MONTH(legacy_ldate)
                                        ) ltbl
                                        ON ltbl.mleg = derived.mm", array($eid))->result();*/


/*
SELECT *,
					IF( CONCAT(YEAR(CURDATE()) , '-',mm, '-01' ) < intranet.getStartDate(?),
IF(intranet.getLastDate(mm) < intranet.getStartDate(?), 0, intranet.toCredits(DAY(intranet.getLastDate(mm)) - DAY(as_of_date))),
IF(MONTH(CURDATE()) > mm, 1.250,
									intranet.toCredits(
											if( mm = MONTH(CURDATE()),
												 IF( mm = mbeg, DAY(CURDATE()) - DAY(as_of_date), DAY(CURDATE())),
												 IF( mm = mbeg, DAY(intranet.getLastDate(mm)) - DAY(as_of_date), DAY(intranet.getLastDate(mm)))
										)
										 )
)
) earned,

					MONTH(CURDATE()) curm FROM
											(
												SELECT 1 mm UNION ALL SELECT 2 UNION ALL SELECT 3
												UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7
												UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11
												UNION ALL SELECT 12
																) derived
											LEFT JOIN
											(SELECT MONTH(date_created) mcreated,
												COUNT(CASE WHEN leave_type = 'vacation' AND ld.`status` = 1 AND wpay = 0 THEN 1 END) as usedvl,
																												COUNT(CASE WHEN leave_type = 'vacation' AND ld.`status` = 1 AND wpay = 0 THEN 1 END) as lwop,
																												SUM(CASE WHEN leave_type = 'monetize' AND ap_monetize is not null THEN ap_monetize END) as monetized,
																		 COUNT(CASE WHEN leave_type = 'sick' THEN 1 END) as usedsl  FROM
											intranet.`leave_application` la
											INNER JOIN intranet.leave_dates ld on la.id = ld.leave_id
											WHERE submit_by = ?
											GROUP BY MONTH(date_created)) as counts
											on derived.mm = mcreated

																	LEFT JOIN
											(SELECT as_of_date, MONTH(as_of_date) mbeg FROM intranet.leave_credits where emp_id = ?) beg
																	on mbeg = derived.mm

																	LEFT JOIN (
																	SELECT MONTH(logdate) mt, SUM(CASE WHEN availcredits - lused >= equiday THEN equiday END) utwpay,
													 COALESCE(SUM(CASE WHEN availcredits - lused < equiday THEN equiday END), 0) utwopay
											FROM (SELECT logdate, ROUND(ABS(tomin * 0.002  * 0.04166), 3) equiday, ROUND(vacation_credits + (DATEDIFF(logdate, as_of_date) * 0.04166), 3) availcredits,
											(SELECT count(ldate) FROM intranet.`leave_application` la
											inner join intranet.leave_dates ld on ld.leave_id = la.id
											WHERE ld.`status` = 1
											and wpay = 1
											and ldate BETWEEN '2020-12-31' and logdate
											and leave_type = 'vacation') lused

																							FROM (
																									SELECT empno, logdate,
																									IF(logdate BETWEEN '2021-08-06' AND '2021-09-30', 0, FLOOR(
																																((#WORKT TIME RENDERED: OUT - IN
																																	intranet.maxOut(MAX(logtime))
																																	- MIN(logtime)) -
																																 #6HRS WORK TIME IS NOT UNDERTIME, PANDEMIC
																																 IF(logdate BETWEEN '2021-03-29' AND '2021-05-14',
																																	 IF(MIN(logtime) > 43200  OR MAX(logtime) < 43200,  21600, 25200),
																																		IF(MIN(logtime) > 43200  OR MAX(logtime) < 43200,  28800, 32400)
																																 )
																																 )
																																/60)) as tomin
																															FROM infosys.`logdata`
																															WHERE empno = $eid and YEAR(logdate) = 2021 AND (logtype = 'I' or logtype = 'O')
																										GROUP BY logdate
																															HAVING tomin < 0
																									) ut
																																						INNER JOIN intranet.leave_credits  lc on lc.emp_id = ?)
																																						 ass
																																						 GROUP BY MONTH(logdate)
																									) undetime
																									on undetime.mt = derived.mm

																	ORDER BY mm*/
        $input_yr = $this->input->post('year');
        $eid = $this->input->post('emp_id');
        $credits['start'] = $this->db->query("SELECT *, month(as_of_date) masof, DATE_FORMAT(as_of_date, 'From %b/%d to ') as_of_date2,  DATE_FORMAT(curdate(), '%b/%d') curd FROM intranet.`leave_credits` WHERE emp_id = ?", array($eid))->row_array();

        $start_date = $credits['start']['as_of_date'];
        /*CALCULATE LEAVE STARTING BALANCE. SUMMARIZE EVERYTHING BEFORE THE INPUT YEAR */
        $credits['legacy'] = $this->db->query("SELECT (COUNT(CASE WHEN type = 'vacation' and wpay = 1 THEN 1 END) - (COUNT(CASE WHEN type = 'vacation' and wpay = 1 and ishalf_day = 1 THEN 1 END) * 0.5))  as legvl,
												   (COUNT(CASE WHEN type = 'sick' and wpay = 1 THEN 1 END) - (COUNT(CASE WHEN type = 'sick' and wpay = 1 and ishalf_day = 1 THEN 1 END) * 0.5)) as legsl
												   FROM intranet.`legacy_dates`
	                                         WHERE `employee_id` = ? AND YEAR(legacy_ldate)  < $input_yr", array($eid))->row_array();
        $credits['used'] = $this->db->query("SELECT
												 COUNT(CASE WHEN ld.status = 1 AND leave_type = 'vacation' AND wpay = 1 THEN 1 END) as approvedVL,
												 COUNT(CASE WHEN ld.status = 1 AND leave_type = 'sick'  AND wpay = 1 THEN 1 END) as approvedSL
											 FROM intranet.`leave_application` la
											 inner join intranet.leave_dates ld
											 on la.id = leave_id
											 WHERE submit_by = ? and leave_type != 'monetize' AND YEAR(ldate) < $input_yr", array($eid))->row_array();

		$credits['monetized'] = $this->db->query("SELECT  COALESCE(SUM(ap_monetize), 0) as monetized
											 FROM intranet.`leave_application` la
											 INNER join intranet.leave_dates ld
											 on la.id = leave_id
											 WHERE submit_by = ? and leave_type = 'monetize' AND YEAR(date_submitted) < $input_yr", array($eid))->row_array()['monetized'];

		$credits['ut'] = $this->db->query("SELECT SUM(tomin) tomin,
													  SUM(CASE WHEN availcredits - lused >= equiday THEN equiday END) utwpay,
													  COALESCE(SUM(CASE WHEN availcredits - lused < equiday THEN equiday END), 0) utwopay
												FROM (SELECT ABS(tomin) tomin, ROUND(ABS(tomin * 0.002  * 0.04166), 3) equiday, ROUND(vacation_credits + (DATEDIFF(logdate, as_of_date) * 0.04166), 3) availcredits,
												(SELECT count(ldate) FROM intranet.`leave_application` la
												inner join intranet.leave_dates ld on ld.leave_id = la.id
												WHERE ld.`status` = 1
												and wpay = 1
												and ldate BETWEEN '$start_date' and logdate
												and leave_type = 'vacation' and submit_by = $eid) lused

												FROM (
														SELECT empno, logdate,
																															IF(logdate BETWEEN '2021-08-06' AND '2021-12-31', 0, FLOOR(
																											                      ((#WORKT TIME RENDERED: OUT - IN
																											                      	intranet.maxOut(MAX(logtime))
																											                        - MIN(logtime)) -
																											                       #6HRS WORK TIME IS NOT UNDERTIME, PANDEMIC
																											                       IF(logdate BETWEEN '2021-03-29' AND '2021-05-14',
																																							 IF(MIN(logtime) > 43200  OR MAX(logtime) < 43200,  21600, 25200),
																																							  IF(MIN(logtime) > 43200  OR MAX(logtime) < 43200,  28800, 32400)
																																						 )
																																						 )
																											                    	/60)) as tomin
																											                    FROM infosys.`logdata`
																											                    WHERE empno = $eid AND logdate > '$start_date' and YEAR(logdate) < $input_yr AND (logtype = 'I' or logtype = 'O')
																																GROUP BY logdate
																											                    HAVING tomin < 0
													  ) ut
												INNER JOIN intranet.leave_credits  lc on lc.emp_id = empno) ass", array($eid))->row_array();

        $credits['earned'] = $this->db->query("SELECT SUM(IF(
							 YEAR(past_date) = YEAR('$start_date') AND MONTH(past_date) = MONTH('$start_date'),
							 intranet.toCredits(DAY(last_day(past_date)) - DAY('$start_date')),

							 IF(YEAR(past_date) = YEAR(CURDATE()) AND MONTH(past_date) = MONTH(CURDATE()),
						    	IF(intranet.toCredits(DAY(CURDATE())) > 1.25, 1.25, intranet.toCredits(DAY(CURDATE()))),
						    	1.25
						    )
						)) as earned

						from
						(
							SELECT
							('$start_date' - INTERVAL DAYOFMONTH('$start_date')-1 DAY)
							+INTERVAL m MONTH as past_date
							FROM
						(
							select @rownum:=@rownum+1 as m from
							(select 1 union select 2 union select 3 union select 4) t1,
							(select 1 union select 2 union select 3 union select 4) t2,
							(select 1 union select 2 union select 3 union select 4) t3,
							(select 1 union select 2 union select 3 union select 4) t4,
							(select @rownum:=-1) t0
						) d1
						) d2
						where past_date <= CURDATE() AND YEAR(past_date) < $input_yr
						order by past_date")->row_array()['earned'];

        /*ADD EARNED FIRST*/
       /* $totalVL = ($credits['start']['vacation_credits'] + $credits['earned']);
        $totalVL -= $credits['legacy']['legvl'];
        $totalVL -= $credits['used']['approvedVL'];

        $totalSL = ($credits['start']['sick_credits'] + $credits['earned']);
        $totalSL -= $credits['legacy']['legsl'];
        $totalSL -= $credits['used']['approvedSL'];*/


        $lc['start'] = $credits;
        $lc['legacy'] = $this->db->query("SELECT * FROM (
															SELECT 1 mm UNION ALL SELECT 2 UNION ALL SELECT 3
															UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7
															UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11
															UNION ALL SELECT 12
														) derived
										LEFT JOIN
                                        (
	                                        SELECT (COUNT(CASE WHEN type = 'vacation' and wpay = 1 THEN 1 END) - (COUNT(CASE WHEN type = 'vacation' and wpay = 1 and ishalf_day = 1 THEN 1 END) * 0.5))  as legvl,
												   (COUNT(CASE WHEN type = 'sick' and wpay = 1 THEN 1 END) - (COUNT(CASE WHEN type = 'sick' and wpay = 1 and ishalf_day = 1 THEN 1 END) * 0.5)) as legsl,
                                            	   COUNT(CASE WHEN type = 'vacation' and wpay = 0 THEN 1 END) as legvlwop,
												   COUNT(CASE WHEN type = 'sick' and wpay = 0 THEN 1 END) as legslwop,
												   MONTH(legacy_ldate) mleg
												   FROM intranet.`legacy_dates`
	                                         WHERE `employee_id` = ? GROUP BY MONTH(legacy_ldate)
                                        ) ltbl
                                        ON ltbl.mleg = derived.mm", array($eid))->result();

		$lc['summary'] = $this->db->query("SELECT past_date, MONTH(past_date) mm,
						IF(
							 YEAR(past_date) = YEAR('$start_date') AND MONTH(past_date) = MONTH('$start_date'),
							 intranet.toCredits(DAY(last_day(past_date)) - DAY('$start_date')),

							 IF(YEAR(past_date) = YEAR(CURDATE()) AND MONTH(past_date) = MONTH(CURDATE()),
						    	IF(intranet.toCredits(DAY(CURDATE())) > 1.25, 1.25, intranet.toCredits(DAY(CURDATE()))),
						    	1.25
						    )
						) as earned

						from
						(
							SELECT
							('$start_date' - INTERVAL DAYOFMONTH('$start_date')-1 DAY)
							+INTERVAL m MONTH as past_date
							FROM
						(
							select @rownum:=@rownum+1 as m from
							(select 1 union select 2 union select 3 union select 4) t1,
							(select 1 union select 2 union select 3 union select 4) t2,
							(select 1 union select 2 union select 3 union select 4) t3,
							(select 1 union select 2 union select 3 union select 4) t4,
							(select @rownum:=-1) t0
						) d1
						) d2
						where past_date <= CURDATE() AND YEAR(past_date) = $input_yr
						order by past_date")->result();

						foreach ($lc['summary'] as $key) {

							$other = $this->db->query("SELECT MONTH(date_created) mcreated,
								COUNT(CASE WHEN leave_type = 'vacation' AND ld.`status` = 1 AND wpay = 1 AND ld.`status` = 1 THEN 1 END) as usedvl,
																								COUNT(CASE WHEN leave_type = 'vacation' AND ld.`status` = 1 AND wpay = 0 THEN 1 END) as lwop,
																								SUM(CASE WHEN leave_type = 'monetize' AND ap_monetize is not null THEN ap_monetize END) as monetized,
														 COUNT(CASE WHEN leave_type = 'sick' AND wpay = 1 AND ld.`status` = 1 THEN 1 END) as usedsl,
														 COUNT(CASE WHEN leave_type = 'sick' AND wpay = 0 AND ld.`status` = 1 THEN 1 END) as slwop  FROM
							intranet.`leave_application` la
							INNER JOIN intranet.leave_dates ld on la.id = ld.leave_id
							WHERE submit_by = ? AND (IF(ldate is NULL, MONTH(date_submitted), MONTH(ldate)) =  ?)  AND (IF(ldate is NULL, YEAR(date_submitted), YEAR(ldate)) = $input_yr)", array($eid, $key->mm))->row_array();

							$ut = $this->db->query("SELECT SUM(tomin) tomin,
													  SUM(CASE WHEN availcredits - lused >= equiday THEN equiday END) utwpay,
													  COALESCE(SUM(CASE WHEN availcredits - lused < equiday THEN equiday END), 0) utwopay
												FROM (SELECT ABS(tomin) tomin, ROUND(ABS(tomin * 0.002  * 0.04166), 3) equiday, ROUND(vacation_credits + (DATEDIFF(logdate, as_of_date) * 0.04166), 3) availcredits,
												(SELECT count(ldate) FROM intranet.`leave_application` la
												inner join intranet.leave_dates ld on ld.leave_id = la.id
												WHERE ld.`status` = 1
												and wpay = 1
												and ldate BETWEEN '$start_date' and logdate
												and leave_type = 'vacation' and submit_by = $eid) lused

												FROM (
														SELECT empno, logdate,
																															IF(logdate BETWEEN '2021-08-06' AND '2022-01-30', 0, FLOOR(
																											                      ((#WORKT TIME RENDERED: OUT - IN
																											                      	intranet.maxOut(MAX(logtime))
																											                        - MIN(logtime)) -
																											                       #6HRS WORK TIME IS NOT UNDERTIME, PANDEMIC
																											                       IF(logdate BETWEEN '2021-03-29' AND '2021-05-14',
																																							 IF(MIN(logtime) > 43200  OR MAX(logtime) < 43200,  21600, 25200),
																																							  IF(MIN(logtime) > 43200  OR MAX(logtime) < 43200,  28800, 32400)
																																						 )
																																						 )
																											                    	/60)) as tomin
																											                    FROM infosys.`logdata`
																											                    WHERE empno = $eid and YEAR(logdate) = $input_yr AND MONTH(logdate) = ? AND (logtype = 'I' or logtype = 'O')
																																GROUP BY logdate
																											                    HAVING tomin < 0
													  ) ut
												INNER JOIN intranet.leave_credits  lc on lc.emp_id = empno) ass", array($key->mm))->row_array();
							$key->usedvl = $other['usedvl'];
							$key->lwop =  $other['lwop'];

							$key->usedsl = $other['usedsl'];
							$key->slwop =  $other['slwop'];
							$key->monetized = $other['monetized'];
							$key->mbeg = 0;
							$key->mt = 0;
							$key->utwpay = $ut['utwpay'];
							$key->utwopay = $ut['utwopay'];
							// code...
						}

		return $lc;
	}

	function getLegLeaves(){
		$q = $this->db->query("SELECT * FROM intranet.`legacy_dates` WHERE `employee_id` = ? order by legacy_ldate asc", array($this->input->post('emp')));
		$_POST['emp_id'] = $this->input->post('emp');
		if ($q->num_rows() > 0){
			foreach ($q->result() as $key) {
					$ul = '<select id="ul'.$key->id.'" style="display:none" class="form-control inpt'.$key->id.'">
									<option value="vacation" '.($key->type == 'vacation'?'selected':'').'>Vacation</option>
									<option value="sick" '.($key->type == 'sick'?'selected':'').'>Sick</option>
								 </select>';
					$wp = '<select id="wp'.$key->id.'"  style="display:none" class="form-control inpt'.$key->id.'">
			 							<option value="1" '.($key->wpay == 1?'selected':'').'>with Pay</option>
			 							<option value="0" '.($key->wpay == 0?'selected':'').'>without Pay</option>
			 					</select>';
			 		$hd = '<select type="checkbox" id="hd'.$key->id.'"  style="display:none" class="form-control inpt'.$key->id.'">
			 							<option value="1" '.($key->ishalf_day == 1?'selected':'').'>Yes</option>
			 							<option value="0" '.($key->ishalf_day == 0?'selected':'').'>No</option>
			 					</select>';


					$result[] = array(
						'<span class="sp'.$key->id.'">'.html_escape($key->legacy_ldate) . '</span>' .'<input id="date'.$key->id.'" style="display:none" class="form-control inpt'.$key->id.'" type="date" value="'.$key->legacy_ldate.'">',
						'<span class="sp'.$key->id.'">'.html_escape($key->type). '</span>' .$ul,
						'<span class="sp'.$key->id.'">'.html_escape(($key->wpay == 1?'With Pay':'No Pay')) . '</span>' . $wp,
						'<span class="sp'.$key->id.'">'.html_escape(($key->ishalf_day == 1?'yes':'no')) . '</span>' . $hd,
						'<div class="action'.$key->id.'"><button onclick="edLeave('.$key->id.')" class="btn btn-sm btn-primary"> Edit</button><button onclick="deleteLegacy('.$key->id.')" class="btn btn-sm btn-danger"> Delete</button></div>
						 <div style="display:none" class="eaction'.$key->id.'"><button onclick="updateLeave('.$key->id.')" class="btn btn-sm btn-primary"> Update</button><button onclick="cancelEdit('.$key->id.')" class="btn btn-sm btn-danger"> Cancel</button></div>'
					);
			}
			return array('leave' =>$result, 'employee' => $this->getEmployee());
		}
		else {
			return array('leave' =>'', 'employee' => $this->getEmployee());
		}
	}

	function getLeaveCredits($emp){
		$credits = $this->db->query("SELECT * FROM intranet.`leave_credits` WHERE emp_id = ?", array($emp))->row_array();
		if($credits !== null){
			#EXPLAINED ON SP: getEarned()

			$start_date = $credits['as_of_date'];
			$credits['earned_vl']  =  $this->db->query("SELECT SUM(earned) earned FROM (SELECT
						IF(
						#F1: Check if past date is within the same month of credits start date
						YEAR(past_date) = YEAR('$start_date') AND MONTH(past_date) = MONTH('$start_date'),

							intranet.toCredits(DAY(last_day(past_date)) - DAY('$start_date')),
						 	IF( #F2: if no, check if past date is within the same month of current date
						        YEAR(past_date) = YEAR(CURDATE()) AND MONTH(past_date) = MONTH(CURDATE()),
						    	IF(intranet.toCredits(DAY(CURDATE())) > 1.25, 1.25, intranet.toCredits(DAY(CURDATE()))),
						    	1.25
						        #F2: IF yesCheck if past date is within the same month of credits start date
						    )
						#END F1
						) as earned

						from
						(
						select
						('$start_date' - INTERVAL DAYOFMONTH('$start_date')-1 DAY)
						+INTERVAL m MONTH as past_date
						from
						(
						select @rownum:=@rownum+1 as m from
						(select 1 union select 2 union select 3 union select 4) t1,
						(select 1 union select 2 union select 3 union select 4) t2,
						(select 1 union select 2 union select 3 union select 4) t3,
						(select 1 union select 2 union select 3 union select 4) t4,
						(select @rownum:=-1) t0
						) d1
						) d2
						where past_date <= CURDATE()
						order by past_date) earned_table")->row_array()['earned'];
			$credits['earned_sl'] = $credits['earned_vl'];
		}

		if($credits !== NULL){
			#EXPLAINED ON SP: getLegacy()
			$credits['legacy'] = $this->db->query("SELECT (COUNT(CASE WHEN type = 'vacation' and wpay = 1 THEN 1 END) - ((COUNT(CASE WHEN type = 'vacation' and wpay = 1 and ishalf_day = 1 THEN 1 END) * 0.5))) as legvl,
												   (COUNT(CASE WHEN type = 'sick' and wpay = 1 THEN 1 END) - ((COUNT(CASE WHEN type = 'sick' and wpay = 1 and ishalf_day = 1 THEN 1 END) * 0.5))) as legsl,
                                            	   COUNT(CASE WHEN type = 'vacation' and wpay = 0 THEN 1 END) as legvlwop,
												   COUNT(CASE WHEN type = 'sick' and wpay = 0 THEN 1 END) as legslwop
										FROM intranet.`legacy_dates` WHERE `employee_id` = ?", array($emp))->row_array();
			$credits['used'] = $this->db->query("SELECT  COUNT(CASE WHEN ld.status is null AND leave_type = 'vacation' THEN 1 END) as pendingVL,
											 COUNT(CASE WHEN ld.status = 1 AND leave_type = 'vacation' AND wpay = 1 THEN 1 END) as approvedVL,
											 COUNT(CASE WHEN ld.status = 1 AND leave_type = 'vacation' and wpay = 0 THEN 1 END) as lwop,
											 COUNT(CASE WHEN ld.status is null AND leave_type = 'sick' THEN 1 END) as pendingSL,
											 COUNT(CASE WHEN ld.status = 1 AND leave_type = 'sick' THEN 1 END) as approvedSL FROM intranet.`leave_application` la
											 inner join intranet.leave_dates ld
											 on la.id = leave_id
											 WHERE submit_by = ? and leave_type != 'monetize'", array($emp))->row_array();
			$credits['monetized'] = $this->db->query("SELECT  COALESCE(SUM(ap_monetize), 0) as monetized
											 FROM intranet.`leave_application` la
											 INNER join intranet.leave_dates ld
											 on la.id = leave_id
											 WHERE submit_by = ? and leave_type = 'monetize'", array($emp))->row_array()['monetized'];
			$credits['ut'] = $this->db->query("SELECT SUM(tomin) tomin,
													  SUM(CASE WHEN availcredits - lused >= equiday THEN equiday END) utwpay,
													  COALESCE(SUM(CASE WHEN availcredits - lused < equiday THEN equiday END), 0) utwopay
												FROM (SELECT ABS(tomin) tomin, ROUND(ABS(tomin * 0.002  * 0.04166), 3) equiday, ROUND(vacation_credits + (DATEDIFF(logdate, as_of_date) * 0.04166), 3) availcredits,
												(SELECT count(ldate) FROM intranet.`leave_application` la
												inner join intranet.leave_dates ld on ld.leave_id = la.id
												WHERE ld.`status` = 1
												and wpay = 1
												and ldate BETWEEN '$start_date' and logdate
												and leave_type = 'vacation' and submit_by = $emp) lused

												FROM (
														SELECT empno, logdate,
														IF(logdate BETWEEN '2021-08-06' AND '2022-01-31', 0, FLOOR(
																((#WORKT TIME RENDERED: OUT - IN
																intranet.maxOut(MAX(logtime))
																- MIN(logtime)) -
																#6HRS WORK TIME IS NOT UNDERTIME, PANDEMIC
																IF(logdate BETWEEN '2021-03-29' AND '2021-05-14',
																							IF(MIN(logtime) > 43200  OR MAX(logtime) < 43200,  21600, 25200),
																							IF(MIN(logtime) > 43200  OR MAX(logtime) < 43200,  28800, 32400)
																						)
																						)
																/60)) as tomin
															FROM infosys.`logdata`
															WHERE empno = $emp AND logdate > '$start_date'  AND (logtype = 'I' or logtype = 'O')
															GROUP BY logdate
															HAVING tomin < 0
													  ) ut
												INNER JOIN intranet.leave_credits  lc on lc.emp_id = empno) ass", array($emp))->row_array();
		}
		return $credits;
	}
	function signLeave(){
		if($this->session->userdata('division') == 15 || $this->session->userdata('division') == 13){
			$col = 'approved_od';
		}
		else{
			$col = 'approved_dir';
		}
		$this->db->query("UPDATE intranet.`leave_application` SET `$col`= 1  WHERE id = ?", $this->input->post('id'));
		echo 1;
	}

	function deleteLeave(){
		$id = $this->input->post('id');
		$this->db->query("UPDATE intranet.`leave_application` SET `submit_by`= (-1 * `submit_by`) WHERE id = ?", array($id));
		// echo $id;
	}

	function cancelLeave(){
		$id = $this->input->post('id');
		$this->db->query("UPDATE intranet.`leave_application` SET `status`= 'Pending' WHERE id = ?", array($id));
		$this->db->query("UPDATE intranet.`leave_dates` SET wpay = NULL, ap_monetize = NULL WHERE leave_id = ?", array($id));
		
		// $this->db->query('payroll_sbg.eeleaves'));
		// echo $id;
	}
	
	function getLeaves(){
		if($this->input->post('emp') == null){
			$q = $this->db->query("SELECT la.*, date_format(date_created, '%m/%d/%Y') as date_filed, date_format(maternity_start, '%b. %d, %Y') as maternity_startf, date_format(maternity_end, '%b. %d, %Y') as maternity_endf,
			 													DATEDIFF(maternity_end, maternity_start)+1 no_days, lastname, firstname, middlename FROM intranet.`leave_application` la
									INNER JOIN infosys.`employee` e on employee_id = la.submit_by
									WHERE submit_by > 0");
									// WHERE status = 'Pending' AND submit_by > 0");
		}
		else{
			$q = $this->db->query("SELECT *, date_format(date_created, '%m/%d/%Y') as date_filed,  date_format(date_created, '%m/%d/%Y') as date_filed, date_format(maternity_start, '%b. %d, %Y') as maternity_startf, date_format(maternity_end, '%b. %d, %y') as maternity_endf,
			 													DATEDIFF(maternity_end, maternity_start)+1 no_days FROM intranet.`leave_application` WHERE submit_by = ?", array($this->input->post('emp')));
		}


		if ($q->num_rows() > 0){
			foreach ($q->result() as $key) {
				$leave = $key;
				$leave->dates = $this->db->query("SELECT ldate, to_monetize, ap_monetize, date_format(ldate, '%b') md, day(ldate) dd, year(ldate) yd FROM intranet.leave_dates WHERE leave_id = ? order by `ldate` asc", array($key->id))->result();

				$inclusiveD = '';
				$prevm = '';
				$ct = 1;
				$prevd = 0;

				$days = [];
				if($key->approved_od == 0){
					$odstat = '';
				}
				else{
					$odstat = '<i class="text-success fa fa-check"></i>';
				}

				if($key->approved_dir == 0){
					$dirstat = '';
				}
				else{
					$dirstat = '<i class="text-success fa fa-check"></i>';
				}

				if($leave->dates)
				foreach ($leave->dates as $dkey) {
					array_push($days, $dkey->dd);
				}
				if($leave->dates)
				foreach ($leave->dates as $ddkey) {
					if($prevm != $ddkey->md){
						$inclusiveD .= $ddkey->md .'. ';
					}
					if($prevd +1 != $ddkey->dd || count($leave->dates) == $ct || $ddkey->dd == 1){
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
				if($leave->dates)
				$inclusiveD .= ' ('. count($leave->dates).' Working Day' . (count($leave->dates) > 1?'s':'') .')';

				if($key->leave_type == 'maternity' || $key->leave_type == 'study'){
						$inclusiveD = $key->maternity_start . ' - '. $key->maternity_end . '( '.$key->no_days.' Days)';
				};
				/*$purpose = ($key->purpose == 'Others'?'Others: '.$key->purpose_remark:($key->leave_type == 'vacation'?'To seek employment':'Maternity') );
				if($key->leave_type == 'CTBTO' || $key->leave_type == 'Special'){
					$purpose = $key->purpose;
				};*/
				if($leave->dates)
				if($key->leave_type == 'monetize'){
						$inclusiveD = 'Applied:' . $leave->dates[0]->to_monetize . '. Approved: '. $leave->dates[0]->ap_monetize;
				};

				if($this->session->userdata('section') == 20){
					$apact = '<button title="View/Approve Leave Application" class="btn btn-default" onclick="viewLeave('.$key->id.')"  data-toggle="modal" href="#Leave_modal"><i class="fa fa-eye"></i> </button>';
					$action = ($key->status == 'Pending' ? $apact.'</div>':($key->status == 'Done' ? '<button title="Cancel Leave Approval" class="btn btn-default" onclick="cancelLeave('.$key->id.')"><i class="fa fa-times"></i> </button>' : 'Cancelled')).'</div>';
				}
				else{
					$action = '<button title="Sign Leave Application" class="btn btn-default" onclick="signLeave('.$key->id.')" ><i class="fa fa-edit"></i> Sign</button>';
				}

				if($this->input->post('emp') == null){
					$result[] = array(
						#'<div class="checker" onclick="toggleClick(this)"><span><input type="checkbox"></span></div>',
						($key->control_no?'<span><b>Control No:</b> '.html_escape($key->control_no).'</span><br>':'').
						$key->lastname. ', ' . $key->firstname .' ' . $key->middlename,
						'<span><b>Type:</b> '.html_escape($key->leave_type).'</span>',
						html_escape($key->date_filed),
						html_escape($inclusiveD),
						'<span class="badge '.$key->status.'">'.$key->status.'</span>',
						#html_escape('route'),
						'<div style="display:flex;margin: auto;width:fit-content" class="xx"><form method="post" action="'. base_url('hr/Leave/printLeave').'" target="_blank">
							<input type="hidden" name="leave_id" value="'.$key->id.'">
							<button title="Print Leave Application" class="btn btn-default"><i class="fa fa-print"></i> </button>
						</form>'.
						$action
					);
				}
				else{
					$result[] = array(
						($key->control_no?'<span><b>Control No:</b> '.html_escape($key->control_no).'</span><br>':'').
						'<span><b>Type:</b> '.html_escape($key->leave_type).'</span><br>',
						html_escape($key->date_filed),
						html_escape($inclusiveD),
						'<span class="badge '.$key->status.'">'.($key->status != 'Pending'?$key->status:'Processing').'</span>',
						#html_escape('route'),
						'<div style="display:flex;margin: auto;"><form method="post" action="'. base_url('hr/Leave/printLeave').'" target="_blank">
							<input type="hidden" name="leave_id" value="'.$key->id.'">
							<button title="Print Leave Application" class="btn btn-default"><i class="fa fa-print"></i> </button>
						</form>
						<button title="View/Approve Leave Application" class="btn btn-default x" onclick="viewLeave('.$key->id.')"  data-toggle="modal" href="#Leave_modal"><i class="fa fa-eye"></i> </button>'.
						($key->status == 'Pending'? ((($this->session->userdata('empid')==$key->submit_by) || $this->session->userdata('empid')==324)?'<button title="Delete Leave Application" class="btn btn-default" onclick="deleteLeave('.$key->id.')"><i class="fa fa-trash-o"></i> </button>':''):'').'</div>'
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
