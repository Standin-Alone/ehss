<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class UsersModel extends CI_Model
{
	public function insertSelectUsers(){
		$info = $this->load->database('info');
		$result = array();
		$sql = "SELECT id, emplid, empno, concat(COALESCE(lastname,''), ', ', COALESCE(firstname,''), ' ', COALESCE(middlename,''), ' ', COALESCE(name_extension,'')) fullname, username, empl_type, projno FROM employee left join r_user on emp_id=emplid WHERE empl_type not in ('Retired', 'Resigned', 'AWOL')";
		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
			}
		}
		else
			'Error';
		return $result;
	}

	public function read(){
		$result = array();
		$sql = "SELECT user_id, emp, username, user_stat, typedes, concat(firstname, ' ', substr(middlename,1,1), '. ', lastname) fullname, user_type FROM payroll_sbg.sys_user left join infosys.employee on employee_id = emp";
		$query_result=$this->db->query($sql);
		
		// $query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$name = '"'.html_escape($rows->fullname).'"';
				$type = $rows->user_type.";".$rows->typedes;
				$result[] = array(
					html_escape($rows->username),
					html_escape($rows->fullname),
					// html_escape($rows->fullname),
					html_escape($rows->typedes),
					$rows->user_stat ? "<span class='label label-sm label-success'> Active </span>": "<span class='label label-sm label-danger'> In-Active </span>",
					"<center><a onclick='$(\"#userid\").val($rows->user_id);$(\"#ftremployee\").val($rows->emp);$(\"#typedes\").val(\"$type\");$(\"#username\").val(\"$rows->username\");$(\"#user_stat\").val(\"$rows->user_stat\");$(\"select\").select2()' glose='Edit' class='tags btn blue btn-sm' data-toggle='modal' href='#memployee'><i class='icon-pencil'></i><span></span></a> <a onclick='$(\"#guid\").val($rows->user_id);$(\"#gname\").val(\"$rows->username\")' glose='Change Password' class='tags btn grey-cascade btn-sm' data-toggle='modal' href='#mchangepass'><i class='icon-lock'></i><span></span></a></center>"

					);
			}
		}
		else
			'Error';
		return $result;
	}

	public function readEmployee(){
		$result = array();
		// $sql = "SELECT id, emplid, empno, concat(lastname, ' ', substr(middlename,1,1), '. ', firstname) fullname, username, empl_type, projno FROM employee left join r_user on emp_id=emplid WHERE empl_type not in ('Retired', 'Resigned', 'AWOL')";

		$sql = "SELECT users_id, employee_id, empno, concat(COALESCE(lastname,''), ', ', COALESCE(firstname,''), ' ', COALESCE(middlename,''), ' ', COALESCE(name_extension,'')) fullname, username, 'Employee' as role_name, status FROM infosys.users u join infosys.employee e on employee_employee_id = e.employee_id left join infosys.employment_status_library esl on esl.employment_status_library_id = employment_status_library_employment_status_library_id";
		$query_result=$this->db->query($sql);
		
		// $query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				if($rows->status=="Permanent"){
					$status = "<span class='label label-sm label-success'> Permanent </span>";
				}
				else{
					$status = "<span class='label label-sm label-danger'> ".$rows->status." </span>";
				}

				$name = '"'.html_escape($rows->fullname).'"';
				$result[] = array(
					html_escape($rows->empno),
					html_escape($rows->fullname),
					html_escape($rows->username),
					$status,
					"<center><a onclick='$(\"#guid\").val($rows->users_id);$(\"#gname\").val(\"$rows->username\")' glose='Change Password' class='tags btn-danger btn-sm' data-toggle='modal' href='#mchangepass'><i class='icon-lock'></i><span></span></a></center>"

					);
			}
		}
		else
			'Error';
		return $result;
	}

	public function readSignatory(){
		$result = array();
		$sql = "SELECT sigid, empsig, sigtype, sigdes, desig, sigstat, empno, concat(COALESCE(lastname,''), ', ', COALESCE(firstname,''), ' ', COALESCE(middlename,''), ' ', COALESCE(name_extension,'')) fullname FROM payroll_sbg.signatory LEFT JOIN infosys.employee on empsig = employee_id";
		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{

				$name = '"'.html_escape($rows->fullname).'"';
				$type = $rows->sigtype.";".$rows->sigdes;
				$result[] = array(
					html_escape($rows->fullname),
					// html_escape($rows->sigtype),
					html_escape($rows->sigdes),
					// html_escape($rows->sigstat ? "Active": "In-Active"),
					$rows->sigstat ? "<span class='label label-sm label-success'> Active </span>": "<span class='label label-sm label-danger'> In-Active </span>",
					"<center><a onclick='$(\"#sigid\").val($rows->sigid);$(\"#ftremployee\").val($rows->empsig);$(\"#sigtype\").val(\"$type\");$(\"#sigstat\").val(\"$rows->sigstat\");$(\"#sigdesig\").val(\"$rows->desig\");$(\"select\").select2()' glose='Edit' class='tags btn blue btn-sm' data-toggle='modal' href='#memployee'><i class='icon-pencil'></i><span></span></a>"

					);
			}
		}
		else
			'Error';
		return $result;
	}

	public function update($input)
	{
		$data = array(
			'password' => rtrim(base64_encode(pack("H*",md5($input['password']))),"=")
		);

		$this->db->where('user_id', $input['guid']);
		$this->db->update('sys_user', $data);

		if($this->db->affected_rows() > 0){
			$this->db->query("INSERT INTO r_logs (`log_action`, `log_des`, `user`, log_ip) VALUES ('Change Password', 'Password changed for user ".$input['gname']."', ".$this->session->userdata('userid').", '".$_SERVER['REMOTE_ADDR']."');");
			return 1;
		}
		else 
			return 0;	
	}
}
?>