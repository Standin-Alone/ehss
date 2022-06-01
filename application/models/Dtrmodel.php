<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class DtrModel extends CI_Model
{
	function ggetDTRDates(){
		$result = "";
		// $sql = "SELECT DISTINCT concat(year(logdate), ' - ',monthname(logdate)) dt, DATE_FORMAT(logdate, '%Y-%m') val FROM infosys.logdata ORDER BY logdate DESC";
		$sql = "SELECT DISTINCT concat(year(logdatetime), ' - ',monthname(logdatetime)) dt, DATE_FORMAT(logdatetime, '%Y-%m') val FROM infosys.logdata where year(logdatetime) > '2018' ORDER BY logdatetime DESC";
		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result .= "<option value='".$rows->val."'>".$rows->dt."</option>";
			}
		}else
			return 0;
		return $result;
	}

	function getDivSec()
	{
		$res = "";
		if(in_array(9, $this->session->userdata('uroles')) || $this->session->userdata('empNum')=="SG0512")
			$sql = "SELECT * FROM infosys.division";
		else 
			$sql = "SELECT * FROM infosys.division WHERE division_id = ".$this->session->userdata('division');
		$qdiv = $this->db->query($sql);
		foreach($qdiv->result() as $d)
		{
			//if(in_array(7, $this->session->userdata('uroles')) || $this->session->userdata('empNum')=="SG0512"){
			if(in_array(7, $this->session->userdata('uroles')) || in_array(9, $this->session->userdata('uroles')) || $this->session->userdata('empNum')=="SG0512"){
				$res .= "<option value=".$d->division_id.">".$d->division_code."</option>";
				$sqlsec = "SELECT * FROM infosys.unit WHERE unit_div = ".$d->division_id." order by unit_code";
			}
			else if(in_array(34, $this->session->userdata('uroles'))){
				$sqlsec = "SELECT * FROM infosys.unit WHERE unit_div = ".$d->division_id." AND unit_id = ".$this->session->userdata('section')." order by unit_code";
			}
			// else
			// 	$sqlsec = "SELECT * FROM infosys.unit WHERE unit_id = 0";

			$qsec = $this->db->query($sqlsec);
			foreach($qsec->result() as $u)
			{
				$res .= "<option value=".$d->division_id."-".$u->unit_id.">".$d->division_code."/".$u->unit_code."</option>";
			}
		}
		return $res;
	}

	function time_sec($time)
	{
		// print($time);
		list($hours, $mins, $secs) = explode(':', $time);
		return ($hours * 3600 ) + ($mins * 60 ) + $secs;
	}
	
	function updateDTR($input)
	{
		$output = false;
		$logArray = ["amIn", "amOut", "pmIn", "pmOut", "otIn", "otOut"];
		$logtype = [
				    "amIn" => "I",
				    "amOut" => "0",
				    "pmIn" => "1",
				    "pmOut" => "O",
				    "otIn" => "2",
				    "otOut" => "3"
				];
		if(isset($input['rem']) && !empty($input['rem']))
        if(count($input['rem'])){
			for($i=0; $i<count($input['remId']); $i++)
			{
				if(isset($input['remId'][$i]) && !empty($input['remId'][$i])){
					$this->db->where('remid', $input['remId'][$i]);
					$this->db->update('infosys.logdata_remarks', $data = array('remarks' => $input['rem'][$i]));
				}else{
					$data = array(
						'empno' => $input['empno'],
						'remarks' => $input['rem'][$i],
						'dt' => date("Y-m-d", strtotime($input['remDt'][$i])),
						'cby' => 36
					);
					$this->db->insert('infosys.logdata_remarks', $data);
				}

				if($this->db->affected_rows() > 0)
					$output =  true;
				else
					$output =  "E2";
			}
        }

        foreach ($logArray as $log){
        	$k = 0;

			if(isset($input[$log]) && !empty($input[$log]))
            if(count($input[$log])){
				for($i=0; $i<count($input[$log]); $i++)
				{
					if(isset($input[$log.'Id'][$i]) && !empty($input[$log.'Id'][$i])){
						$data = array(
							'newlogdatetime' => date("Y-m-d H:i:s", strtotime($input[$log][$i])),
							// 'logtime' => $this->time_sec(date("G:i:s", strtotime($input[$log][$i]))),
							'edited_by' => $this->session->userdata('empid'),
							'date_updated' => date("Y-m-d")
						);
						$this->db->where('logdata_id', $input[$log.'Id'][$i]);
						$this->db->update('infosys.logdata', $data);
					}else{
						$data = array(
							'empno' => $input['empno'],
							'logdatetime' => date("Y-m-d H:i:s", strtotime($input[$log][$i])),
							'logtime' => $this->time_sec(date("G:i:s", strtotime($input[$log][$i]))),
							'logdate' => date("Y-m-d", strtotime($input[$log][$i])),
							'logtype' => $logtype[$log],
							'upload_by' => $this->session->userdata('empid'),
							'upload_date' => date("Y-m-d")
						);
						$this->db->insert('infosys.logdata', $data);
					}

					if($this->db->affected_rows() > 0)
						$output =  true;
					else
						$output =  "E1";
				}
            }
        	$k++;
        }
		return $output;
	}
	
	function getRemarks($id, $date){
		$result = array();
		$result['id'] = $result['val'] = "";
		$sql = "SELECT remid, remarks FROM infosys.logdata_remarks WHERE empno='$id' AND dt = '$date'";
		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result['id'] = $rows->remid;
				$result['val'] = $rows->remarks;
			}
		}
		// if(isset($result))
			return $result;
		// else
		// 	return 0;
	}

	function get_log($id, $date){
		$log['logId'] = $log['amIn'] = $log['amOut'] = $log['pmIn'] = $log['pmOut'] = $log['otIn'] = $log['otOut'] = $log['rem'] = $log['amInId'] = $log['amOutId'] = $log['pmInId'] = $log['pmOutId'] = $log['otInId'] = $log['otOutId'] = "";
		$sql ="SELECT logtype, DATE_FORMAT((case when logtype = 'I' then MIN(logdatetime)
					when logtype = '0' THEN MAX(logdatetime)
					when logtype = '1' then MIN(logdatetime)
					when logtype = 'O' THEN MAX(logdatetime)
					when logtype = '2' THEN MIN(logdatetime)
					when logtype = '3' THEN MAX(logdatetime)
					else MAX(logdatetime) end), '%Y-%m-%d %H:%i:00') logtime, logdate, logdata_id, newlogdatetime
					FROM infosys.logdata WHERE empno='$id' AND logdate = '$date'  
					AND (upload_by <> 'NULL' OR edited_by <> 'NULL') 
					GROUP BY logdate, logtype";

					/*when logtype = '0' THEN MAX(logtime)
					when logtype = '1' then MIN(logtime)
					when logtype = 'O' THEN MAX(logtime)
					when logtype = '2' THEN MIN(logtime)
					when logtype = '3' THEN MAX(logtime)*/
		$query_result =  $this->db->query($sql);
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$datetime = $rows->newlogdatetime ? $rows->newlogdatetime : $rows->logtime;
				// $datetime = date('Y-m-d', strtotime($rows->logdatetime));
				$log['logId'] = $rows->logdata_id;
				if($rows->logtype == 'I'){
					$log['amIn'] = $datetime;
					$log['amInId'] = $rows->logdata_id;
					// $log['rem'] = $rows->remarks;
				}
				if($rows->logtype == '0'){
					$log['amOut'] = $datetime;
					$log['amOutId'] = $rows->logdata_id;
					// $log['rem'] = $rows->remarks;
				}
				if($rows->logtype == '1'){
					$log['pmIn'] = $datetime;
					$log['pmInId'] = $rows->logdata_id;
					// $log['rem'] = $rows->remarks;
				}
				if($rows->logtype == 'O'){
					$log['pmOut'] = $datetime;
					$log['pmOutId'] = $rows->logdata_id;
					// $log['rem'] = $rows->remarks;
				}
				if($rows->logtype == '2'){
					$log['otIn'] = $datetime;
					$log['otInId'] = $rows->logdata_id;
					// $log['rem'] = $rows->remarks;
				}
				if($rows->logtype == '3'){
					$log['otOut'] = $datetime;
					$log['otOutId'] = $rows->logdata_id;
					// $log['rem'] = $rows->remarks;
				}
			}
		}
		/*$log['amIn'] = $this->db->query("SELECT MIN(logtime) lt FROM logdata WHERE empno='$id' AND logdate = '$date' AND logtype = 'I'")->row()->lt;

		$log['amOut'] = $this->db->query("SELECT MAX(logtime) lt FROM logdata WHERE empno='$id' AND logdate = '$date' AND logtype = '0'")->row()->lt;

		$log['pmIn'] = $this->db->query("SELECT MIN(logtime) lt FROM logdata WHERE empno='$id' AND logdate = '$date' AND logtype = '1'")->row()->lt;

		$log['pmOut'] = $this->db->query("SELECT MAX(logtime) lt FROM logdata WHERE empno='$id' AND logdate = '$date' AND logtype = 'O'")->row()->lt;

		$log['otIn'] = $this->db->query("SELECT MIN(logtime) lt FROM logdata WHERE empno='$id' AND logdate = '$date' AND logtype = '2'")->row()->lt;

		$log['otOut'] = $this->db->query("SELECT MAX(logtime) lt FROM logdata WHERE empno='$id' AND logdate = '$date' AND logtype = '3'")->row()->lt;*/

		return $log;
	}

	function get_logold($id, $date){
		$log['logId'] = $log['remarks'] = $log['amIn'] = $log['amOut'] = $log['pmIn'] = $log['pmOut'] = $log['otIn'] = $log['otOut'] = "";
		/*$sql ="SELECT logid, logdate, TIME_FORMAT(amin, '%h:%i %p') amin, TIME_FORMAT(amout, '%h:%i %p') amout, TIME_FORMAT(pmin, '%h:%i %p') pmin, TIME_FORMAT(pmout, '%h:%i %p') pmout, TIME_FORMAT(otin, '%h:%i %p') otin, TIME_FORMAT(otout, '%h:%i %p') otout
					FROM dtrlog WHERE empno='$id' AND logdate = '$date'";*/
		$sql ="SELECT logid, amin, amout, pmin, pmout, otin, otout, remarks FROM dtrlog WHERE empno='$id' AND logdate = '$date'";

		$query_result =  $this->db->query($sql);
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$log['logId'] = $rows->logid;
				// $log['logdate'] = $rows->logdate;
				$log['amIn'] = $rows->amin;
				$log['amOut'] = $rows->amout;
				$log['pmIn'] = $rows->pmin;
				$log['pmOut'] = $rows->pmout;
				$log['otIn'] = $rows->otin;
				$log['otOut'] = $rows->otout;
				$log['remarks'] = $rows->remarks;
			}
		}

		return $log;
	}

	function getUndertime($amIn, $amOut, $pmIn, $pmOut){
		//for early time in and late time out AM/PM
		// $amIn = "07:46";
		// $amOut = "12:00";
		// $pmIn = "01:00";
		// $pmOut = "07:08";
		$undertime = 0;
		//early time in AM
		if( $this->timeDiff($amIn, "07:00") > 0 )
			$amIn = "07:00";
		//late break out AM
		if( $this->timeDiff($amOut, "12:00") < 0 )
			$amOut = "12:00";
		//early break in PM
		$pmIn = $this->chkstimex($pmIn);
 		//late time out PM
		if( $this->timeDiff($pmOut, "06:00") < 0 )
			$pmOut = "06:00";
		//get manhour
		$timediffam = $this->timeDiff($amIn,$amOut);
		$timediffpm = $this->timeDiff($pmIn,$pmOut);

		$timediffam = $timediffam < 0 ? 0 : $timediffam;
		$timediffpm = $timediffpm < 0 ? 0 : $timediffpm;

		$timediff = $timediffam + $timediffpm;

		$undertime = 0;
		//late time in
		if($timediffam > 0)
		{
			if($this->timeDiff("09:00", $amIn) > 0)
				$undertime += $this->timeDiff("09:00", $amIn);

			if($this->timeDiff($amOut, "12:00") > 0)
				$undertime += $this->timeDiff($amOut, "12:00");
		}else
			$undertime += 180;
		//early time out
		if($timediffpm > 0)
		{
			if($this->timeDiff("01:00", $pmIn) > 0){
				$undertime += $this->timeDiff("01:00", $pmIn );
			}

			if($this->timeDiff($pmOut, "04:00") > 0){
				$undertime += $this->timeDiff($pmOut, "04:00");
			}
		}else
			$undertime += 180;
		//
		$totalundertime = 480 - $timediff;
		//if manhour is less than 2 hours (absent)
		if($timediff < 120)
		{
			$totalundertime = 0;
			$undertime = 0;
			$absences ++;
		}

		// $uthr = floor($totalundertime / 60);
		// $utmin = $totalundertime % 60;

		// $timediffhour = floor($timediff / 60);
		// $timediffminutes = $timediff % 60;
		// if ( $this->timeDiff( $timediffhour.":".$timediffminutes , "08:00") < 0 )
		// 	$timediffundertimehr =  floor($this->timeDiff( "08:00" , $timediffhour.":".$timediffminutes ) / 60);
		$offset = $totalundertime - $undertime;

		// $cad += $cadtemp;
		// print "<br>automatic ded: ".$undertime;
		// print "<br>manhours: ".$timediff;
		// print "<br>undertime: ".$totalundertime;
		// print "<br>offset: ".$offset;

		
						$data["autoded"] = $undertime;
						$data["manhour"] = $timediff;
						$data["undertime"] = $totalundertime;
						$data["offset"] = $offset;
						$data["uthr"] = $uthr;
						$data["utmin"] = $utmin;
						// var_dump($data);
						return $data;
		/*return array(
						"autoded" => $undertime,
						"manhour" => $timediff,
						"undertime" => $totalundertime,
						"offset" => $offset,
						"uthr" => $uthr,
						"utmin" => $utmin
					);*/
	}

	function timeDiff($firstTime,$lastTime)
	{
		// convert to unix timestamps
		$firstTime = strtotime($firstTime);
		$lastTime = strtotime($lastTime);

		// perform subtraction to get the difference (in seconds) between times
		$timeDiff = $lastTime - $firstTime;
		$timeDiff = $timeDiff / 60;

		// return the difference
		return $timeDiff;
	}

	//////////////////////////////////
	function check_holidays($date)
	{
		$date2 = date("m-d", strtotime($date));
		// $date2 = date_format($date,"m-d");
		// $date2 = date('m-d', $date);
		$holiday["start"] = $holiday["end"] = $holiday["on"] = 0;
		$holiday["date"] = $date;
		$weekend = date ("w", strtotime($date));
		// $sql = "SELECT * FROM holidays WHERE '$date' >= sdate and '$date' <= edate";
		$sql = "SELECT * from infosys.holidays where ((repeats = '0' and '$date' >= sdate and '$date' <= edate) 
		or (repeats = '1' and '$date2' >= DATE_FORMAT(sdate,'%m-%d') and '$date2' <= DATE_FORMAT(edate,'%m-%d')))";

		$query_result = $this->db->query($sql);
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$holiday["start"] = $rows->stime;
				$holiday["end"] = $rows->etime;
				$holiday["occasion"] = $rows->occasion;
				$holiday["on"] = 1;
			}
		}

		// if ($weekend == 0 || $weekend == 6){
		// 	$holiday["start"] = $GLOBALS['DEFINE_WKND_IN'];
		// 	$holiday["end"] = $GLOBALS['DEFINE_WKND_OUT'];
		// 	$holiday["on"] = 2;
		// }
		return $holiday;
	}

	function check_leaves($month, $day, $year, $empID){
		//$holiday ["start"] = $holiday["end"] = $holiday["on"] = 0;
		$date = $year . "-" . $month . "-" . $day;
		$date = date('Y-m-d',strtotime($date));
		$weekend = date ("w", mktime (0,0,0, $month, $day, $year));
		//$query = "SELECT * FROM leaves WHERE month='$month' AND day= '$day' AND year = '$year' and plantilla_employee_employee_id='$empID'";
		  $query = "SELECT *, description FROM `leaves`, leave_reference WHERE leave_reference_id = leave_reference_leave_reference_id and `plantilla_employee_employee_id`='$empID' and '$date' >= start_date and '$date' <= `end_date` and leave_status_leave_status_id IN (4,6,10)";//approved by division chief, director, deputy director
		  //$query = "SELECT * FROM leaves WHERE (plantilla_employee_employee_id='$empID' and 
		  //(leave_status_leave_status_id = 4 or leave_status_leave_status_id = 6) and (start_date >= '$date' and end_date <= '$date') )";
		$result = selectQuery($query);
		$index = $result['numRows'];
		if ($index){
			$leaves ["start"] = $result[0]->start_time;
			$leaves ["end"] = $result[0]->end_time;
			//$holiday ["occasion"] = $row-> occasion;
			$leaves ["on"] = 3;
			$leaves ["type"] = $result[0]->description;
			$leaves ["so_number"] = $result[0]->specification;
		}

		if ($weekend == 0 || $weekend == 6){
			//$holiday ["start"] = $GLOBALS['DEFINE_MANHOURS_WITH_BRK'];
			//$holiday ["end"] = $GLOBALS['DEFINE_MANHOURS_WITH_BRK'] + $GLOBALS['DEFINE_MANHOURS_WITH_BRK'];
			$leaves ["on"] = 2;
		}

		switch($result[0]->kind_kind_id){
			case "1":
			    $leaves["leave"] = '28800';							// 8HRS OR ONE DAY
			    break;
			case "2":
			    $leaves["leave"] = '14400';							// 4HRS OR HALF DAY (AM)
			    break;
			case "3":
			    $leaves["leave"] = '14400';							// 4HRS OR HALF DAY (PM)
			    break;
			case "4":
			    $leaves["leave"] = ($result[0]->num_kind) * 3600;	// 
			    break;
			default:
			    $leaves["leave"] = 0;
			    break;
		} 	
		//$leaves["leave"]=$leaves["end"]-$leaves["start"];
		return $leaves;
	}

	function check_officialtime($month, $day, $year, $empID){
		$date = $year . "-" . $month . "-" . $day;
		$date = date('Y-m-d',strtotime($date));
		$weekend = date ("w", mktime (0,0,0, $month, $day, $year));
		//$officialtime ["start"] = $officialtime["end"] = $officialtime["on"] = 0;
		//$query = "SELECT * FROM `official_time` WHERE `employee_employee_id`= '$empdID' and '$date' >= `start_date` and '$date' <= `end_date` and `official_status` IN (4,6)"; // approved by division chief or director
		$query = "SELECT *, reference_desc FROM official_time, official_time_ref WHERE employee_employee_id= '$empID' and '$date' >= start_date and '$date' <= end_date and official_time_ref_id = official_time_ref and official_status IN (4,6)";
		$result = selectQuery($query);
		//$index = $result['numRows'];
		if ($result['numRows']){
			$officialtime ["start"] = $result[0]->start_time;
			$officialtime ["end"] = $result[0]->end_time;
			$officialtime ["type"] = $result[0]->reference_desc;
			$officialtime ["sch_type"] = $result[0]->scholarship_type;
			$officialtime ["des_type"] = $result[0]->destination_type;
			$officialtime ["so_number"] = $result[0]->so_number;
			$officialtime ["on"] = 4;
		}

		if ($weekend == 0 || $weekend == 6){
			$officialtime ["on"] = 2;
		}
		return $officialtime;
	}

	function where_to_put($log, $count){
		// INITIALIZATION
		$cell[1] = $cell[2] = $cell[3] = $cell[4] = " ";

		if ($count == 1){  		// ONLY ONE PAIR OF IN - OUT
			$timein = $log[0]["in"];
			$timeout = $log[0]["out"];
			if ($log[0]["in_m"] == 0){
				$cell[1] = date("g:i", mktime(0,0,$timein));
			}
			else
				$cell[3] = date("g:i", mktime(0,0,$timein));

			if ($log[0]["out_m"] == 0){
				$cell[2] = date("g:i", mktime(0,0,$timeout));
			}
			else{
				//      if ($timeout >= 43200 && $timeout < 46800){
				if ($timein >= 43200){
					//        $cell[2] = date("g:i", mktime(0,0,$timeout));
					$cell[4] = date("g:i", mktime(0,0,$timeout));
					//        $cell[3] = "";
					//        $cell[4] = "";
				}
				else{
					$cell[2] = "12:00";
					$cell[3] = "1:00";
					$cell[4] = date("g:i", mktime(0,0,$timeout));
				}
			}
		}
		else if ($count == 2){  		// ONLY ONE PAIR OF IN - OUT
			if ($log[0]["in_m"] == 0){
				$timein = $log[0]["in"];
				$cell[1] = date("g:i", mktime(0,0,$timein));
				$timein = $log[0]["out"];
				$cell[2] = date("g:i", mktime(0,0,$timein));
				$timein = $log[1]["in"];
				$cell[3] = date("g:i", mktime(0,0,$timein));
				$timein = $log[1]["out"];
				$cell[4] = date("g:i", mktime(0,0,$timein));
			}
			else{
				$timein = $log[0]["in"];
				$cell[3] = date("g:i", mktime(0,0,$timein));
				$timein = $log[1]["out"];
				$cell[4] = date("g:i", mktime(0,0,$timein));
			}    
		}
		else{
			//07/07/17 - remove start - start comment by sbg
			// if ($log[0]["in_m"] == 0){
			//   $timein = $log[0]["in"];
			//   if($timein>0)
			//   {
			//     $cell[1] = date("g:i", mktime(0,0,$timein));
			//   }
			//   $cell[2] = "";
			//   $cell[3] = "";
			//   $cell[4] = "";
			//   //$timein = $log[$count]["out"];
			//   //$cell[4] = date("g:i", mktime(0,0,$timein));
			// } - remove end
			// add start
			if ($log[0]["in_m"] == 0){
				$timein = $log[0]["in"];
				$cell[1] = "";
				$cell[2] = "";
				$cell[3] = "";
				$cell[4] = "";
				if($timein > 0 && $timein <= 43200)
				{
					$cell[1] = date("g:i", mktime(0,0,$timein));
				}
				if($timein > 43200)
				{
					$cell[4] = date("g:i", mktime(0,0,$timein));
				}
			} //add end - end comment by sbg
			else{
				$timein = $log[0]["in"];
				$cell[3] = date("g:i", mktime(0,0,$timein));
				$timein = $log[$count]["out"];
				$cell[4] = date("g:i", mktime(0,0,$timein));
			}
		} 
		return $cell;
	}

	function get_logs($start, $empID)
	{
		//update 060717 - comment by sbg
		// $query ="SELECT DISTINCT logtime, logdate, logtype, logdata_id FROM logdata WHERE empno='$empID' AND logdate = '$start' AND (upload_by <> 'NULL' OR edited_by <> 'NULL') GROUP BY logdate, logtype ORDER BY logtime ";
		$query ="SELECT (case when logtype = 'I' then MIN(logtime) else MAX(logtime) end) logtime, logdate, logtype, logdata_id 
		FROM logdata WHERE empno='$empID' AND logdate = '$start' 
		AND (upload_by <> 'NULL' OR edited_by <> 'NULL') 
		GROUP BY logdate, logtype ORDER BY logtime ";
		//end

		$result = selectQuery($query);
		$log["count"] = $result['numRows'];
		for ($j=0; $j < $log["count"]; $j++)
		{   //store in arrays
			$log[$j]["date"] = $result[$j]->logdate;
			$log[$j]["time"] = $result[$j]->logtime;
			$log[$j]["type"] = $result[$j]->logtype;
			$log[$j]["id"] = $result[$j]->logdata_id;
		}

		// sort 
		for ($j=0, $i=0; $j <= $log["count"] && $log["count"]; $j++)
		{
			if ($log[$j]["type"] != 'I' && $log[$j]["type"] != 'O') //update 070717 - comment by sbg add  && $log[$j]["type"] != 'O'
				continue;
			else{
				$login[$i]["in"] = $log[$j]["time"];
				$login[$i]["inID"] = $log[$j]["id"];

				for ($j=$j+1; $j <= $log["count"]; $j++){
					if ($j <= $log["count"] && $log[$j]["type"] == 'O')
					{
						$login[$i]["out"] = $log[$j]["time"];
						$login[$i]["outID"] = $log[$j]["id"];

						$i++;
						break;
					}
				}
			}
		}
		$login["count"] = $i;
		//ADDITIONAL QUERY FOR PASS SLIP BY JOSEPH
		$query = "select nature,pass_slip_id from pass_slip where employee_employee_id='$empID' and logdate='$start'";
		$pslip = selectQuery($query);
		$query2 = sprintf("select * from approving_officer where pass_slip_pass_slip_id = '%s'",$pslip[0]->pass_slip_id);
		$app_off = selectQuery($query2);
		if ($app_off['numRows']){
			$login["passslip_nature"]=$pslip[0]->nature;
			$login["passslip"]=1;
			$login["logdate"]=$pslip[0]->appdate;
		}
		else
			$login["passslip"]=0;

		return $login;
	}

	function get_undertime($start, $log, $flag2, $DEFINE_LATEST_OUT, $empID)
	{
		if($flag2==0){
			//$late_and_undertime=compute_employee($empno,$start,$connect);
			compute_employee($start, $empID);
		}
		$query = "SELECT * FROM undertime WHERE employee_employee_id='$empID' AND logdate = '$start'";
		$result = selectQuery($query);
		$log["count"] = $result['numRows'];
		if ($log["count"])
		{
			$undertime  = $result[0]->utime;
			$leave = $result[0]->leave;
			$undertime -= $leave;
			$utime["otime"] = $utime["overtime"] = $result[0]->otime;

			if ($undertime <= 0)
			{
				//$undertime = abs($undertime);
				$undertime = 0;
			}	
		}
		else {
			$undertime = 0;
		}

		//MODIFICATION START TO ACCOMODATE PASS SLIP
		$passslip = get_passslip($empID,$start,$log);
		$undertime = $undertime + $passslip["personal"] - $passslip["official"];
		if ($passslip["personal"]!=0 || $passslip["official"]!=0){
			if ($undertime <= 0)
				//undertime = abs($undertime);
				$undertime = 0;
				//elseif($undertime == 0)
				//$undertime = 0;
			else {
				$adjustment = adjustundertime($empID,$start,$DEFINE_LATEST_OUT);
				$undertime = $undertime - $adjustment;
				if ($undertime <= 0)
				$undertime = 0;
			}
		}
		//MODIFICATION END FOR PASS SLIP
		$utime["total"] = $undertime;
		$utime["hours"] = $utime["minutes"] = 0;

		//ADDITIONAL MODIFICATIONS FOR PASS SLIP
		if ($passslip["personal"]>0 || $passslip["official"]>0){
			$log["passslip"] = 1;
		}
		else {
			$log["passslip"] = 0;
		}

		//END OF PASS SLIP MODIFICATION
		if ($undertime){
			$utime["hours"] = date ("H", mktime (0,0, $undertime));
			$utime["minutes"] = date ("i", mktime (0,0, $undertime));
			$utime["hours"] = intval ($utime["hours"]);
			$utime["minutes"] = intval ($utime["minutes"]);
		}
		return $utime;
	}

	function chkstimex($timein)
	{
		$timediff = $this->timeDiff("1:00",$timein);
		if( $timediff > 659 and $timediff <720 )
			return "1:00";
		else
			return $timein;

		return "0:00";
	}

	function getHolidays () {
		$sql = "SELECT DISTINCT TRIM(sample_type) type FROM natas.t_receiving WHERE TRIM(sample_type) like ?";
		$query = $this->db->query($sql,array('%'.$this->input->post('searchTerm', TRUE).'%'));
		return  $query->result_array();
	}
}