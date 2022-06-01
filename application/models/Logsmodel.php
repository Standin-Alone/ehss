<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class LogsModel extends CI_Model
{
	public function getLogs(){
		$result = array();
		$sql = "SELECT log_id, log_datetime, log_action, log_des, username, user_id, emp, typedes FROM payroll_sbg.r_logs l join payroll_sbg.sys_user u on l.user = u.user_id WHERE user_id > 0";
		if($this->session->userdata('userid') == 0)
			$sql = "SELECT log_id, log_datetime, log_action, log_des, username, user_id, emp, typedes FROM payroll_sbg.r_logs l join payroll_sbg.sys_user u on l.user = u.user_id";
		if($this->session->userdata('user_type') > 1)
			$sql = "SELECT log_id, log_datetime, log_action, log_des, username, user_id, emp, typedes FROM payroll_sbg.r_logs l join payroll_sbg.sys_user u on l.user = u.user_id WHERE user_type = ".$this->session->userdata('user_type');

		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result[] = array(
					html_escape($rows->log_datetime),
					html_escape($rows->log_action),
					html_escape($rows->log_des),
					html_escape($rows->username. ' ('.$rows->typedes.')')
					);	
			}
		}
		else
			'Error';
		return $result;
	}

	function gpGender()
	{
		$result = array();
		$sql = "SELECT gender, COUNT(employee_id) AS count FROM employee WHERE employment_status_library_employment_status_library_id = 1 GROUP BY gender ORDER BY gender";

		$query = $this->db->query($sql);
		// return $query->result();
		if($query->num_rows() > 0)
		{
			$row = $query->result_array();
			$result = array("male" => $row[1]['count'], "female" => $row[0]['count']);
			$result = json_encode($result);
		}
		else
			'Error';
		return $result;
	}

	function gpAge()
	{
		$result = array();
		$sql = "SELECT 
					SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) < 21,1,0)) as 'a20',
					SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 21 and 30,1,0)) as 'a30',
					SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 31 and 40,1,0)) as 'a40',
					SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 41 and 50,1,0)) as 'a50',
					SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 51 and 60,1,0)) as 'a60',
					SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) > 60,1,0)) as 'a61'
				FROM employee WHERE employment_status_library_employment_status_library_id = 1";

		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$result = array("a20" => $row->a20, "a30" => $row->a30, "a40" => $row->a40, "a50" => $row->a50,"a60" => $row->a60, "a61" => $row->a61);

				$result = json_encode($result);
			}
		}
		else
			'Error';
		return $result;
	}

	function getStats()
	{
		$result = array();
		$sql = "SELECT 
				(select count(feedid) from feedback where YEAR(feeddt)='2021' ) as 'feed',
				(select count(employee_id) from employee where YEAR(dtcreated) ='2021') as 'newemp',
				(select count(employee_id) from employee where employment_status_library_employment_status_library_id = 1) as 'allreg',
				(select count(employee_id) from employee where employment_status_library_employment_status_library_id not in (11,12,13,14,17,20)) as 'allemp'";

		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$result = array("feed" => $row->feed, "newemp" => $row->newemp, "allreg" => $row->allreg, "allemp" => $row->allemp);

				$result = json_encode($result);
			}
		}
		else
			'Error';
		return $result;
	}
	public function getSurvey(){
		$result = array();
		$sql = "SELECT DATE_FORMAT(date_answered, '%Y-%m-%d %H:%i') dt, `service`, `name`, `company`, `contact`, `date_answered`, `timeliness`, `competence`, `courtesy`, `environment`, `quality`, `comments`, `sec` FROM helpdesk.satisfactory_answers_outside where sec = ".$this->session->userdata('SECTION_ID');
		if($this->session->userdata('id')==324)
			$sql = "SELECT DATE_FORMAT(date_answered, '%Y-%m-%d %H:%i') dt,  `service`, `name`, `company`, `contact`, `date_answered`, `timeliness`, `competence`, `courtesy`, `environment`, `quality`, `comments`, `sec` FROM helpdesk.satisfactory_answers_outside";
		
		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result[] = array(
					html_escape($rows->dt),
					html_escape($rows->service),
					html_escape($rows->name),
					html_escape($rows->company),
					html_escape($rows->contact),
					"Timeliness: ".$rows->timeliness."<br>".
					"Competence: ".$rows->competence."<br>".
					"Courtesy: ".$rows->courtesy."<br>".
					"Environment: ".$rows->environment."<br>".
					"Quality: ".$rows->quality,
					html_escape($rows->comments)
					);	
			}
		}
		else
			'Error';
		return $result;
	}

	public function exportSurveyCSVx(){
		$data[] = array('x'=> $x, 'y'=> $y, 'z'=> $z, 'a'=> $a);
		 header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=\"test".".csv\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		$handle = fopen('php://output', 'w');

		foreach ($data as $data_array) {
			fputcsv($handle, $data_array);
		}
			fclose($handle);
		exit;
	}
}
?>