<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {

	function index(){
		$data['menu'] = "calendar";
		$data['gmenu'] = "attendance";

		
		$this->load->view('template/header', $data);
		$this->load->view('hr/calendar');
		$this->load->view('template/footer');
	}

	function getHolidays() {
	 	$output = array();
	 	$data = $this->DtrModel->getHolidays();
 		foreach($data as $val)
 		{
 			$output[] = array(
 				"id" => $val['id'],
 				"title" => $val['title'],
 				"date_start" => $val['date_start']
 				);
 		}
	 	echo json_encode($data);
		$this->output->set_content_type("application/json")
		->set_output(json_encode($output));
	}

	function getHolidaysold() {
		// if($action == 'calendarData'){
		$s = $this->input->get('start', TRUE);
		$e = $this->input->get('end', TRUE);
		$start = date('Y-m-d', $s/1000);
		$end = date('Y-m-d', $e/1000);
		$stemp = date('m-d', $s/1000);
		$etemp = date('m-d', $e/1000);
		$syr = date('Y', $s/1000);
		$eyr = date('Y', $e/1000);
		$sel_yr = $syr;

		$query = "select * from infosys.holidays h left join infosys.holidays_ref r on h.holidays_ref_id = r.holidays_ref_id where ((repeats = '0' and sdate >= '$start' and edate < '$end') 
			  or (repeats = '1' and DATE_FORMAT(sdate,'".$syr."-%m-%d') >= '$start' and DATE_FORMAT(edate,'".$syr."-%m-%d') < '$end')
			  or (repeats = '1' and DATE_FORMAT(sdate,'".$eyr."-%m-%d') >= '$start' and DATE_FORMAT(edate,'".$eyr."-%m-%d') < '$end'))";

		$holidays = $this->db->query($query);
		#echo $query;
		$a = array();
		$b = array();

		if($holidays->num_rows() > 0)
		foreach ($holidays->result() as $holiday)
		{
		    if(date('m',strtotime($holiday->edate))=='1') $sel_yr = $eyr; else $sel_yr = $syr;

		    $hrs = floor($holiday->stime/3600);
		    $mins = ($holiday->stime - ($hrs * 3600))/60;
		    $sdate = strtotime($sel_yr."-".date('m-d',strtotime($holiday->sdate)));
		    $stime = mktime($hrs,$mins,0,date('m',$sdate),date('d',$sdate),date('Y',$sdate));
		    $a['start'] = $stime;
		    
		    $hrs = floor($holiday->etime/3600);
		    $mins = ($holiday->etime - ($hrs * 3600))/60;
		    $sdate = strtotime($sel_yr."-".date('m-d',strtotime($holiday->edate)));
		    $stime = mktime($hrs,$mins,0,date('m',$sdate),date('d',$sdate),date('Y',$sdate));
		    $a['end'] = $stime;

		    $a['id'] = $holiday->holidays_id;
		    $a['title'] = $holiday->occasion;
		    if($holiday->allDay)
		    	$a['allDay'] = true;
		    else
		    	$a['allDay'] = false;
		    
		    $a['repeats'] = $holiday->repeats;
		    $a['type'] = $holiday->holidays_ref_id;
		    // $holidayRef = $this->getHolidayRef($holiday->holidays_ref_id);
		    $a['typeDesc'] = $holiday->holidays_ref_desc; 

		    $b[] = $a;
		    unset($a);
		
		}
		// for($i=0; $i<$holidays->num_rows(); $i++){}

		$this->output->set_content_type("application/json")
		->set_output(json_encode($b));
	}

	/*function getHolidayRef($holidays_ref_id=NULL, $params = NULL){
		$i = 0;
		if(!empty($holidays_ref_id)){
			if(!empty($params))
				$query = sprintf("select %s from infosys.holidays_ref where holidays_ref_id='%s'",$params,$holidays_ref_id);
				else
				$query = sprintf("select * from infosys.holidays_ref where holidays_ref_id='%s'",$holidays_ref_id);
		}else{
			if(!empty($params))
				$query = sprintf("select %s from infosys.holidays_ref",$params);
				else
				$query = "select * from infosys.holidays_ref order by holidays_ref_desc";
		}
		
		$qr = $this->db->query($query);

		$result["numRows"] = $qr->num_rows();
		if($result["numRows"] > 0){
			while($result[$i]=$qr->moveNext()) $i++;
		}

		//return result
		return $result;
	}*/
}
