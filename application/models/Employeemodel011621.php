<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class EmployeeModel extends CI_Model
{
	public function getEmployees()
	{
		$result = "";
		$sql = "SELECT employee_id, concat(COALESCE(lastname,''), ', ', COALESCE(firstname,''), ' ', COALESCE(middlename,''), ' ', COALESCE(name_extension,'')) fullname, empno, users_id FROM infosys.employee LEFT JOIN infosys.users on employee_id = employee_employee_id WHERE employee_id = ".$this->session->userdata('empid');
		if (in_array("3", $this->session->userdata('uroles'))) {
		    if($this->session->userdata("menu")=="profile")
		    	$sql = "SELECT employee_id, concat(COALESCE(lastname,''), ', ', COALESCE(firstname,''), ' ', COALESCE(middlename,''), ' ', COALESCE(name_extension,'')) fullname, empno, users_id FROM infosys.employee LEFT JOIN infosys.users on employee_id = employee_employee_id WHERE employee_id > 0 ORDER BY lastname, firstname";
		}
		if (in_array("9", $this->session->userdata('uroles'))) {
		    if($this->session->userdata("menu")=="dtr")
		   		$sql = "SELECT employee_id, concat(COALESCE(lastname,''), ', ', COALESCE(firstname,''), ' ', COALESCE(middlename,''), ' ', COALESCE(name_extension,'')) fullname, empno, users_id FROM infosys.employee LEFT JOIN infosys.users on employee_id = employee_employee_id WHERE employee_id > 0 ORDER BY lastname, firstname";
		}
		//employment_status_library_employment_status_library_id in (1,11,12,15,16,17)
		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result .= "<option data-userid=".$rows->users_id." value=".$rows->employee_id.">".$rows->empno." - ".strtoupper($rows->fullname)."</option>";
			}
		}
		else
		'Error';
		return $result;
	}

	public function getEmployee($id)
	{
		$result = "";
					// --left join infosys.plantilla_salary ps on pl.plantilla_salary_plantilla_salary_id = ps.plantilla_salary_id
		$sql = "SELECT *, e.position_reference_position_reference_id prid, UPPER(concat(COALESCE(firstname,''), ' ', COALESCE(lastname,''))) fullname
					FROM infosys.employee e 
					left join infosys.division d on d.division_id = e.division_division_id 
					left join infosys.employment_status_library esl on e.employment_status_library_employment_status_library_id = esl.employment_status_library_id
					left join infosys.unit u on e.unit_unit_id = u.unit_id
					left join infosys.plantilla p on e.employee_id = p.employee_employee_id and p.pstat = 1
					left join infosys.plantilla_library pl on p.plantilla_library_plantilla_library_id = pl.plantilla_library_id
					left join infosys.position_reference pr on pl.position_reference_position_reference_id = pr.position_reference_id
					left join payroll_sbg.paycategory pc on pl.paycat = pc.paycatid 
                    left join infosys.users s on employee_id = s.employee_employee_id WHERE employee_id = ".$id;
        $query = $this->db->query($sql);
		if($query->num_rows() > 0)
			return $this->db->query($sql)->result()[0];
		return 0;
	}

	public function getPersonalInfo($id)
	{
		$result = "";
		$sql = "SELECT employee_id, employment_status_library_employment_status_library_id as status_id, firstname, middlename, lastname, name_extension, birthday, birthplace, gender, civil_status, citizenship, local_number, height, weight, blood_type, gsis_id_num, pagibig_id_num, philhealth_num, sss_num, tin, email_address, mobile_phone, r.home_phone rphone, r.street rstreet, r.town_or_city rtown, r.province rprovince, r.country rcountry, r.zip_code rzip, p.home_phone pphone, p.street pstreet, p.town_or_city ptown, p.province pprovince, p.country pcountry, p.zip_code pzip FROM infosys.employee left join infosys.address r on r.employee_employee_id = employee_id and r.address_type = 'Residential' left join infosys.address p on p.employee_employee_id = employee_id and p.address_type = 'Permanent' WHERE employee_id = $id GROUP BY employee_id";
        $query = $this->db->query($sql);
		if($query->num_rows() > 0)
			return $this->db->query($sql)->result()[0];
		return 0;
	}
	
	public function getEmploymentStatus()
	{
		$result = "<option>All</option>";
		$sql = "SELECT employment_status_library_id, status_code, status FROM infosys.employment_status_library where disabled=0";
		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result .= "<option value='".$rows->employment_status_library_id."'>".$rows->status."</option>";
			}
		}
		else
		'Error';
		return $result;
	}
	
	public function getPlantilla()
	{
		$sql = "SELECT plantilla_library_id, item_number FROM infosys.plantilla_library";
		$result = "";

		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result .= "<option value='".$rows->plantilla_library_id."'>".$rows->item_number."</option>";
			}
		}
		else
		'Error';
		return $result;
	}
	
	public function getPositions()
	{
		$sql = "SELECT position_reference_id, position_code, position_desc FROM infosys.position_reference";
		$result = "";

		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result .= "<option value='".$rows->position_reference_id."'>".$rows->position_desc."(".$rows->position_code.")</option>";
			}
		}
		else
		'Error';
		return $result;
	}

	public function updateUserLevel($data)
	{
		$res[0] = $this->commonmodel->delete("infosys.userlevel", $data['id'], "users_users_id");

		// $tags = explode(',',$data['uref']);
		$tags = $data['uref'];
		foreach($tags as $key) {
			$udata['users_users_id'] = $data['id'];
			$udata['userlevelref_userlevelref_id'] = $key;
			if($this->db->insert("infosys.userlevel", $udata)){
				$res[1] = $this->db->insert_id().",";
			}   
		}

		return $res;
	}
}