<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class CommonModel extends CI_Model
{
	public function update($tbl, $data, $id, $col)
	{
		$this->db->where($col, $id);
		$this->db->update($tbl, $data);
		
		return array($this->db->affected_rows(),0);
	}

	public function updateWhere($tbl, $data, $con)
	{
		$this->db->where($con);
		$this->db->update($tbl, $data);
		
		return $this->db->affected_rows();
	}

	public function add($tbl, $data)
	{
		if($this->db->insert($tbl, $data)){
			$id = $this->db->insert_id();

			if(isset($data['soaid'])){
				$this->isCalibration($data['soaid']);
			}
			return array($id,0);
		}else
			return array(0,$this->db->error());
	}

	public function isCalibration($soa){
		$service = $this->db->query("SELECT SERVICE FROM statement.`items` WHERE STATEMENT_ID  = ? LIMIT 1",array($soa))->row_array()['SERVICE'];
		if($service == 3){
			$id =  $this->db->query("SELECT `id` FROM rpss_new.`cal_transactions` WHERE soa_id = ? ",array($soa))->row_array()['id'];
			$this->assign_jobno($id);
		}
	}

	function get_latest_job(){
		return $this->db->query("SELECT max(job_order) job_order FROM rpss_new.`cal_instruments` ci
			INNER JOIN rpss_new.cal_transactions ct
			on ct.id = ci.transaction_id
			WHERE YEAR(ct.received_date) = YEAR(CURDATE())")->row_array()['job_order'];
	}
	function assign_jobno($id){
		$ins = $this->db->query("SELECT id, type FROM rpss_new.cal_instruments WHERE transaction_id = ?", array($id))->result();
		$jobno = $this->get_latest_job();
		$job = 0;
		$pd = 0;
		$pdcnt = 0;
		$ra = 0;
		$racnt = 0;
		$jono = array();
		foreach ($ins as $key) {
			$typeid = $key->type;
			if($typeid ==1 || $typeid == 2 || ($typeid == 3 && $pd == 0) || ($typeid == 4 && $ra == 0)){
				$jobno += 1;
			}
			if($pd != 0 && $typeid == 3){
				$job = $pd;
				$pdcnt++;
			}
			else if($ra != 0 && $typeid == 4){
				$job =  $ra;
				$racnt++;
			}
			else {
				$job = $jobno;
			}
			if($pd == 0 && $typeid == 3){
				$pd = $jobno;
			}
			if($ra == 0 && $typeid == 4){
				$ra = $jobno;
			}

			$item = array(
				'job_order' => $job
			);

			if($pdcnt == 5){
				$pd = 0;
				$pdcnt =0;
			}
			if($racnt == 5){
				$ra = 0;
				$racnt =0;
			}
			$this->db->where('id', $key->id);
			$this->db->update('rpss_new.cal_instruments', $item);
		}
	}

	public function updateQuery($sql)
	{
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function delete($tbl, $id, $col)
	{
		$this->db->where($col, $id)->delete($tbl);
		$ar = $this->db->affected_rows();
		return $ar;
	}

	public function deac($tbl, $id, $col, $name)
	{
		$this->db->set($name, 0);
		$this->db->where($col, $id)->update($tbl);
		$ar = $this->db->affected_rows();
		return $ar;
	}

	public function getSections()
	{
		$sql = "SELECT * FROM infosys.unit WHERE disabled = 0";
		$result = "";

		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$ext = array('code' => $rows->unit_code,
							'desc' => $rows->unit_desc,
							'div' => $rows->unit_div,
							'head' => $rows->unit_head);
				$ext = json_encode($ext);
				$result .= "<option data-ext='$ext' value='".$rows->unit_id."'>".$rows->unit_desc.' ('.$rows->unit_code.')'."</option>";
			}
		}
		else
		'Error';
		return $result;
	}
	
	public function getRoles($id)
	{
		$uid = $id ? $id : $this->input->get('userid');
		$result = array();
		$sql = "SELECT userlevelref_userlevelref_id id FROM infosys.userlevel WHERE users_users_id = ".$uid;

		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result[] = $rows->id;	
			}
		}
		else
		'Error';
		return $result;
	}
}