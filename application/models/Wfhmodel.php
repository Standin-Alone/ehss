<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class WfhModel extends CI_Model
{

	function getList()
	{
		$result = array();
		$filter="";
		$sql = "SELECT DISTINCT DATE_FORMAT(logdatetime, '%y/%m %b') dt, DATE_FORMAT(logdatetime, '%Y-%m-01') dtval FROM infosys.logdata where logdatetime > '2020-08-01';";
        //`id`, `formonth`, `fordts`, `des`, `isapproved`, `cby`, `dt_created
		$query_result = $this->db->query($sql.$filter);
		if ($query_result->num_rows() > 0){
			foreach ( $query_result->result() as $row ){
				$act = "<a onclick='act(\"".$row->dt."\",\"".$row->dtval."\", \"Add\", 0)' title='Add' class='btn btn-xs blue'><i class='fa fa-plus'></i><span> Add</span></a>";
				
				$hid = $hstat = $hwfhid = $hremarks = $hstatby = $hstatdt = $stat = $fordts = $des = "";
				$qwfh = $this->db->query("SELECT * FROM wfh.report WHERE formonth = '$row->dtval' and cby = ".$this->session->userdata('id'));
				foreach($qwfh->result() as $rows)
				{
					$fordts = $rows->fordts;
					$des = $rows->des;
					if($rows->id){
						$qrhis = $this->db->query("SELECT *, DATE_FORMAT(statdt, '%y/%m/%d %k:%i') sdt FROM wfh.report_history WHERE wfhid = ".$rows->id." order by statdt desc limit 1");
						foreach($qrhis->result() as $rhis)
						{
							$hid = $rhis->id;
							$hstat = $rhis->status;
							$hwfhid = $rhis->wfhid;
							$hremarks = $rhis->remarks;
							$hstatby = $rhis->statby;
							$hstatdt = $rhis->sdt;
						}
					}
	
					if($hstat=="Draft"){
						$stat = "<h5><span class='label label-primary'>Draft</span></h5>";
						$act = "<a onclick='act(\"".$row->dt."\",\"".$row->dtval."\", \"Edit\", $rows->id)' title='Edit' class='btn btn-xs blue'><i class='fa fa-edit '></i><span> Edit</span></a>"."<a onclick='submit($rows->id, \"Submitted\")' title='Submit' class=' btn btn-xs green'><i class='fa fa-save'></i><span> Submit</span></a>";
					}
					if($hstat=="Submitted" || $hstat=="Resubmitted"){
						$stat = "<h5><span class='label label-success'>$hstat</span></h5>";
						$act = "<a onclick='cancelSubmit($hid)' title='Cancel' class=' btn btn-xs red'><i class='fa fa-times'></i><span> Cancel</span></a> <a href='".base_url('hr/wfh/printWFH/').$row->dtval."' target=_blank title='View' class='btn grey-cascade btn-xs'><i class='fa fa-file-pdf-o'></i><span> View </span></a><br>";//<h6><i class='fa fa-lock'> <span class='label label-default'>under review</span></h6>";
					}
					if($hstat=="Rejected"){
						$stat = "<h5><span class='label label-danger'>Rejected</span></h5>Reason: ".$hremarks;
						$act = "<a onclick='act(\"".$row->dt."\",\"".$row->dtval."\", \"Edit\", $rows->id)' title='Edit' class='btn btn-xs blue'><i class='fa fa-edit '></i><span> Edit</span></a>"."<a onclick='submit($rows->id, \"Resubmitted\")' title='Resubmit' class=' btn btn-xs green'><i class='fa fa-save'></i><span> Resubmit</span></a>";
					}
					if($hstat=="Approved"){
						$act = "<a href='".base_url('hr/wfh/printWFH/').$row->dtval."' target=_blank title='View' class='btn grey-cascade btn-xs'><i class='fa fa-file-pdf-o'></i><span> View </span></a>";
						$stat = "<h5><span class='label label-info'>Approved</span></h5>";
						// $act = "<a onclick='act(\"".$rows->dt."\",\"".$rows->dtval."\", 0)' title='View' class=' btn btn-xs btn-default '><i class='fa fa-eye '></i><span> </span></a>";
					}
				}
				$result[] = array(
					html_escape($row->dt),
					($fordts ? "WFH dates: ".$fordts : "")."<br>".$des,
					$stat,
					$hstatdt,
					$act
					);
						
			}
		}
		return $result;
	}

	function getSecList()
	{
		$result = array();
		$filter=$qwfhsql="";
		if(in_array(34, $this->session->userdata('uroles'))){//head
			$qwfhsql = "SELECT r.*, firstname, lastname, unit_unit_id, division_division_id, DATE_FORMAT(formonth, '%y/%m %b') dt, DATE_FORMAT(formonth, '%Y-%m-01') dtval FROM wfh.report r join infosys.employee on cby = employee_id WHERE employee_id <> ".$this->session->userdata('id')." and unit_unit_id = ".$this->session->userdata('section');
		}
		if(in_array(7, $this->session->userdata('uroles'))){//chief
			$qwfhsql = "SELECT r.*, firstname, lastname, unit_unit_id, division_division_id, DATE_FORMAT(formonth, '%y/%m %b') dt, DATE_FORMAT(formonth, '%Y-%m-01') dtval FROM wfh.report r join infosys.employee on cby = employee_id WHERE employee_id <> ".$this->session->userdata('id')." and division_division_id = ".$this->session->userdata('division')." and (employee_id in (select unit_head from infosys.unit) or unit_unit_id = 1)";
		}
		if(in_array(35, $this->session->userdata('uroles'))){//deputy
			$qwfhsql = "SELECT r.*, firstname, lastname, unit_unit_id, division_division_id, DATE_FORMAT(formonth, '%y/%m %b') dt, DATE_FORMAT(formonth, '%Y-%m-01') dtval FROM wfh.report r join infosys.employee on cby = employee_id WHERE employee_id in (select division_chief from infosys.division) and employee_id <> ".$this->session->userdata('id');
		}
		if(in_array(3, $this->session->userdata('uroles'))){//hr
			$qwfhsql = "SELECT r.*, firstname, lastname, unit_unit_id, division_division_id, DATE_FORMAT(formonth, '%y/%m %b') dt, DATE_FORMAT(formonth, '%Y-%m-01') dtval FROM wfh.report r join infosys.employee on cby = employee_id WHERE employee_id <> ".$this->session->userdata('id');
		}
		if($this->input->post('ftrDTRDates'))
			$filter = " and formonth = '".$this->input->post('ftrDTRDates')."'";
		// return $qwfhsql;
		$qwfh = $this->db->query($qwfhsql.$filter);
		foreach($qwfh->result() as $rows)
		{
			$act = $hid = $hstat = $hwfhid = $hremarks = $hstatby = $hstatdt = $stat = "";
			if($rows->id){
				$qrhis = $this->db->query("SELECT *, DATE_FORMAT(statdt, '%y/%m/%d %k:%i') sdt FROM wfh.report_history WHERE wfhid = ".$rows->id." order by statdt desc limit 1");
				foreach($qrhis->result() as $rhis)
				{
					if(in_array($rhis->status, array("Submitted", "Resubmitted", "Approved"))){
						if(in_array("3", $this->session->userdata('uroles'))){//hr
							if($rhis->status=="Approved"){
								$stat = "<h5><span class='label label-info'>Approved</span></h5>";
								$act = "<a href='".base_url('hr/wfh/printWFHReport/').$rows->dtval."/".$rows->id."' target=_blank title='View' class='btn grey-cascade btn-xs'><i class='fa fa-file-pdf-o'></i><span> View </span></a>";
								$result[] = array(
									html_escape($rows->dt),
									html_escape($rows->firstname." ".$rows->lastname),
									($rows->fordts ? "WFH dates: ".$rows->fordts : "")."<br>".$rows->des,
									$stat,
									$hstatdt,
									$act
									);
							}else if($rows->unit_unit_id == $this->session->userdata('section') && in_array(34, $this->session->userdata('uroles')) && ($rhis->status=="Submitted" || $rhis->status=="Resubmitted")){
								$stat = "<h5><span class='label label-primary'>$rhis->status</span></h5>";
								$act = "<a data-toggle='modal' href='mwfhReport' onclick='act(\"".$rows->dtval."\", \"Approve\", $rows->id)' title='Approve' class='btn btn-xs green'><i class='fa fa-thumbs-up '></i><span> Approve</span></a>"."<a data-toggle='modal' href='mWFHReject' onclick='act(\"".$rows->dtval."\", \"Reject\", $rows->id)' title='Reject' class=' btn btn-xs red'><i class='fa fa-thumbs-down'></i><span> Reject</span></a>";
								$result[] = array(
									html_escape($rows->dt),
									html_escape($rows->firstname." ".$rows->lastname),
									($rows->fordts ? "WFH dates: ".$rows->fordts : "")."<br>".$rows->des,
									$stat,
									$hstatdt,
									$act
									);
							}
						}else if(count(array_intersect($this->session->userdata('uroles'), array(7,34,35))) > 0){
								if($rhis->status=="Submitted" || $rhis->status=="Resubmitted"){
									$stat = "<h5><span class='label label-primary'>$rhis->status</span></h5>";
									$act = "<a data-toggle='modal' href='mwfhReport' onclick='act(\"".$rows->dtval."\", \"Approve\", $rows->id)' title='Approve' class='btn btn-xs green'><i class='fa fa-thumbs-up '></i><span> Approve</span></a>"."<a data-toggle='modal' href='mWFHReject' onclick='act(\"".$rows->dtval."\", \"Reject\", $rows->id)' title='Reject' class=' btn btn-xs red'><i class='fa fa-thumbs-down'></i><span> Reject</span></a>";
								}
								else if($rhis->status=="Approved"){
									$act = "<a href='".base_url('hr/wfh/printWFHReport/').$rows->dtval."/".$rows->id."' target=_blank title='View' class='btn grey-cascade btn-xs'><i class='fa fa-file-pdf-o'></i><span> View </span></a>";
									$stat = "<h5><span class='label label-info'>Approved</span></h5>";
								}else{}
							$result[] = array(
								html_escape($rows->dt),
								html_escape($rows->firstname." ".$rows->lastname),
								($rows->fordts ? "WFH dates: ".$rows->fordts : "")."<br>".$rows->des,
								$stat,
								$hstatdt,
								$act
								);

						}
					}
				}
			}
		}
		return $result;
	}

	function getReport()
	{
		$sql = "SELECT * FROM wfh.report WHERE formonth = '".$this->input->get('dt')."' and cby = ".$this->session->userdata('id');
		// $this->db->query($sql);
		return $this->db->query($sql)->result();
	}

	function getReportById()
	{
		$sql = "SELECT * FROM wfh.report WHERE id = ".$this->input->get('id');
		// $this->db->query($sql);
		return $this->db->query($sql)->result();
	}

	function getReportx($dt, $id)
	{
		$sql = "SELECT * FROM wfh.report WHERE formonth = '".$dt."' and cby = ".$id;
		// $this->db->query($sql);
		return $this->db->query($sql)->result();
	}

	function getReporty($id)
	{
		$sql = "SELECT * FROM wfh.report WHERE id = ".$id;
		// $this->db->query($sql);
		return $this->db->query($sql)->result();
		// var_dump($this->db->last_query());
	}

	public function act()
	{
		$data = array(
					'wfhid' => $this->input->get('wfhid', TRUE), 
					'status' => $this->input->get('status', TRUE), 
					'remarks' => $this->input->get('remarks', TRUE),
					'statby' => $this->session->userdata('id')
				);
		if($this->db->insert('wfh.report_history', $data)){
			$id = $this->db->insert_id();
			return array(1,$this->db->error());
		}
		else 
			return array(0,$this->db->error());
	}

	function getWFHDates(){
		$result = "<option value='0'>All</option>";
		$sql = "SELECT DISTINCT DATE_FORMAT(formonth, '%y/%m %b') dt, DATE_FORMAT(formonth, '%Y-%m-01') dtval FROM wfh.report ORDER BY dtval DESC";
		// $sql = "SELECT DISTINCT DATE_FORMAT(logdatetime, '%y/%m %b') dt, DATE_FORMAT(logdatetime, '%Y-%m-01') dtval FROM infosys.logdata where logdatetime > '2020-08-01' ORDER BY dtval DESC";
		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result .= "<option value='".$rows->dtval."'>".$rows->dt."</option>";
			}
		}else
			return 0;
		return $result;
	}
}
