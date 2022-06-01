<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class AdminModel extends CI_Model
{
	function updateAcc()
	{
		$data = array(
			// 'username' => $this->input->post('accname'),
			'password' => rtrim(base64_encode(pack("H*",md5($this->input->post('acc')))),"=")
		);

		$this->db->where('employee_employee_id', $this->input->post('accid'));
		$this->db->update('infosys.users', $data);

		if($this->db->affected_rows() > 0){
			// $this->db->query("INSERT INTO r_logs (`log_action`, `log_des`, `user`, log_ip) VALUES ('Change Password', 'Password changed for user ".$input['gname']."', ".$this->session->userdata('userid').", '".$_SERVER['REMOTE_ADDR']."');");
			$this->session->set_userdata('notsec',0);
			return 1;
		}
		else{
			return 0;	
		}
	}

	function newAcc()
	{
		$data = array(
			'employee_employee_id' => $this->input->post('accid'),
			'username' => $this->input->post('accname'),
			'password' => rtrim(base64_encode(pack("H*",md5($this->input->post('acc')))),"=")
		);

		if($this->db->insert('infosys.users', $data)){
			$id = $this->db->insert_id();
			return $id;
		}else
			return false;	
	}
}
?>




					
