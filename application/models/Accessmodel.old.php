<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class AccessModel extends CI_Model
{
	function login($input)
	{
		$utype = "";
		if(!$this->db->query("SELECT status from infosys.users WHERE username = '".$input['username']."'")->row()->status)
			return 2;
		$sql = "SELECT users_id, asti_email, empno, employee_id, username, rights, concat(COALESCE(firstname,''), ' ', COALESCE(lastname,'')) fullname, password FROM infosys.users left join infosys.employee on employee_id = employee_employee_id WHERE (username = ? and password = ?)";
		$query_result = $this->db->query($sql, array($input['username'], rtrim(base64_encode(pack("H*",md5($input['password']))),"=")));
		if ($query_result->num_rows() > 0){
			foreach ( $query_result->result() as $row ){
				$this->session->set_userdata(array(
                            'userid'		=> $row->users_id,
                            'name'			=> $row->fullname,
                            'empid'			=> $row->employee_id,
                            'empNum'		=> $row->empno,
                            'empMail'		=> $row->asti_email,
                            'rolename'		=> "",
                            'user_type'		=> "",
                            'uroles'		=> "",
                            'username'		=> $row->username));
				$roles = $this->commonmodel->getRoles($row->users_id);
				$this->session->set_userdata('uroles', $roles);
				$this->session->set_userdata('notsec',0);
				if($row->password == rtrim(base64_encode(pack("H*",md5($row->empno))),"="))
					$this->session->set_userdata('notsec',1);

				// $this->db->query("INSERT INTO payment.r_logs (user, log_ip) VALUES ($row->users_id, '".$_SERVER['REMOTE_ADDR']."');");
			}
			$this->db->query("UPDATE infosys.users SET attempt = 0 WHERE username = '".$input['username']."';");
			return array(1,$utype);
		}
		else{
			$this->db->query("UPDATE infosys.users SET attempt = (attempt + 1) WHERE username = '".$input['username']."';");
			if(($this->db->query("SELECT attempt from infosys.users WHERE username = '".$input['username']."'")->row()->attempt) >= 5)
				$this->db->query("UPDATE infosys.users SET user_stat = 0 WHERE username = '".$input['username']."';");
			return array(0,0);
		}
	}

	function logout()
	{
		// return $this->db->query("INSERT INTO payment.r_logs (log_action, log_des, user, log_ip) VALUES ('Logout', 'User logged out.', ".$this->session->userdata('userid').", '".$_SERVER['REMOTE_ADDR']."');");
	}
}
?>
