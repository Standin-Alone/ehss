<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class EmployeeModel extends CI_Model
{
	public function updateChild($data)
	{
		$suc = $err = 0;
		for( $i=0; $i < count($data['chFname']); $i++ )
		{
			$data1 = array(
				'employee_employee_id ' => $data['id'],
				'relationship' => 'Child',
				'firstname' => $data['chFname'][$i],
				'middlename' => $data['chMname'][$i],
				'lastname' => $data['chLname'][$i],
				'birthday' => $data['chBday'][$i]
			);
			if($data['chFid'][$i]){
				$this->db->where('family_id', $data['chFid'][$i]);
				$this->db->update('infosys.family', $data1);
				$res = $this->db->affected_rows();
			}else{
				$this->db->insert('infosys.family', $data1);
				$res = $this->db->insert_id();
			}
			if($res > 0) {
				$suc++;
			}
			else
				$err++;
		}
		return array($suc,$err,$this->db->error());
	}

	public function updateEduc($data)
	{
		$suc = $err = 0;
		for( $i=0; $i < count($data['educSchool']); $i++ )
		{
			$data1 = array(
				'employee_employee_id ' => $data['id'],
				'level' => $data['educLevel'][$i],
				'school_name' => $data['educSchool'][$i],
				'degree_units_earned' => $data['educDegree'][$i],
				'start_date' => $data['educStart'][$i],
				'end_date' => $data['educEnd'][$i],
				'highest_units_earned' => $data['educUnits'][$i],
				'year_graduated' => $data['educYear'][$i],
				'honors_received' => $data['educHonors'][$i]
			);
			if($data['educId'][$i]){
				$this->db->where('education_id', $data['educId'][$i]);
				$this->db->update('infosys.education', $data1);
				$res = $this->db->affected_rows();
			}else{
				$this->db->insert('infosys.education', $data1);
				$res = $this->db->insert_id();
			}
			if($res > 0)
				$suc++;
			else
				$err++;
		}
		return array($suc,$err,$this->db->error());
	}

	public function updateExam($data)
	{
		$suc = $err = 0;
		for( $i=0; $i < count($data['examName']); $i++ )
		{
			$data1 = array(
				'employee_employee_id ' => $data['id'],
				'exam_doc' => $data['examName'][$i],
				'exam_rating' => $data['examRate'][$i],
				'exam_date' => $data['examDate'][$i],
				'exam_location' => $data['examPlace'][$i],
				'license_number' => $data['examLic'][$i],
				'license_date' => $data['examLicdt'][$i]
			);
			if($data['examId'][$i]){
				$this->db->where('examination_id', $data['examId'][$i]);
				$this->db->update('infosys.examination', $data1);
				$res = $this->db->affected_rows();
			}else{
				$this->db->insert('infosys.examination', $data1);
				$res = $this->db->insert_id();
			}
			if($res > 0)
				$suc++;
			else
				$err++;
		}
		return array($suc,$err,$this->db->error());
	}

	public function updateWork($data)
	{
		$suc = $err = 0;
		for( $i=0; $i < count($data['workPos']); $i++ )
		{
			$data1 = array(
				'employee_employee_id ' => $data['id'],
				'start_date' => $data['workStart'][$i],
				'end_date' => $data['workEnd'][$i],
				'position_desc' => $data['workPos'][$i],
				'agency_dept_name' => $data['workComp'][$i],
				'salary' => $data['workSalary'][$i],
				'salary_grade' => $data['workSG'][$i],
				'appointment_status' => $data['workApp'][$i],
				'gov_service' => $data['workGov'][$i],
				'within_pnri' => $data['workPNRI'][$i]
			);

			if($data['workId'][$i]){
				$this->db->where('service_record_id', $data['workId'][$i]);
				$this->db->update('infosys.service_record', $data1);
				$res = $this->db->affected_rows();
			}else{
				$this->db->insert('infosys.service_record', $data1);
				$res = $this->db->insert_id();
			}
			if($res > 0)
				$suc++;
			else
				$err++;
		}
		return array($suc,$err,$this->db->error());
	}

	public function updateVol($data)
	{
		$suc = $err = 0;
		for( $i=0; $i < count($data['volOrg']); $i++ )
		{
			$data1 = array(
				'employee_employee_id ' => $data['id'],
				'organization_info' => $data['volOrg'][$i],
				'start_date' => $data['volStart'][$i],
				'end_date' => $data['volEnd'][$i],
				'work_duration_hrs' => $data['volHrs'][$i],
				'pos_or_nature' => $data['volPos'][$i]
			);

			if($data['volId'][$i]){
				$this->db->where('voluntary_work_id', $data['volId'][$i]);
				$this->db->update('infosys.voluntary_work', $data1);
				$res = $this->db->affected_rows();
			}else{
				$this->db->insert('infosys.voluntary_work', $data1);
				$res = $this->db->insert_id();
			}
			if($res > 0)
				$suc++;
			else
				$err++;
		}
		return array($suc,$err,$this->db->error());
	}

	public function updateTrain($data)
	{
		$suc = $err = 0;
		for( $i=0; $i < count($data['trainTitle']); $i++ )
		{
			$data1 = array(
				'employee_employee_id ' => $data['id'],
				'training_desc' => $data['trainTitle'][$i],
				'start_date' => $data['trainStart'][$i],
				'end_date' => $data['trainEnd'][$i],
				'training_duration_hrs' => $data['trainHrs'][$i],
				'training_sponsor' => $data['trainSponsor'][$i]
			);

			if($data['trainId'][$i]){
				$this->db->where('training_id', $data['trainId'][$i]);
				$this->db->update('infosys.training', $data1);
				$res = $this->db->affected_rows();
			}else{
				$this->db->insert('infosys.training', $data1);
				$res = $this->db->insert_id();
			}
			if($res > 0)
				$suc++;
			else
				$err++;
		}
		return array($suc,$err,$this->db->error());
	}

	public function updateLegal($data)
	{
		$suc = $err = 0;
		$this->db->query('DELETE FROM infosys.legalinfo WHERE employee_employee_id ='.$data['id']);
		for( $i=0; $i < count($data['legalq']); $i++ )
		{
			$dt = $data['legalq'][$i] == "4" ? $data['legaldt'] : "";
			$data1 = array(
				'employee_employee_id ' => $data['id'],
				'legalissue' => $data['legalq'][$i],
				'answer' => $data['legala'][$i],
				'particulars' => $data['legalp'][$i],
				'datefiled' => $dt
			);
			$this->db->insert('infosys.legalinfo', $data1);
			$res = $this->db->insert_id();
			if($res > 0)
				$suc++;
			else
				$err++;
		}

		$data3 = array(
			'employee_employee_id' => $data['id'],
			'id_name' => $data['govIDName'],
			'id_no' => $data['govIDNo'],
			'id_date' => $data['govDate'],
			'id_place' => $data['govPlace']
		);
		$qrid = $this->db->query("SELECT COUNT(*) AS count from infosys.identification where employee_employee_id =".$data['id'])->row();
		if($qrid->count > 0){
			$this->db->where('employee_employee_id', $data['id']);
			$this->db->update('infosys.identification', $data3);
			$res = $this->db->affected_rows();
		}
		else{
			$this->db->insert('infosys.identification ', $data3);
			$res = $this->db->insert_id();
		}
		if($res > 0)
			$suc++;
		else
			$err++;
	
		return array($suc,$err,$this->db->error());
	}

	public function updateOther($data)
	{
		$suc = $err = 0;
		$data1 = array(
			'employee_employee_id ' => $data['id'],
			'publications' => $data['publications'],
			'trainings_conducted' => $data['trainConducted'],
			'projects_consultancies' => $data['prjInvolve'],
			'project_leadership' => $data['prjLead'],
			'awards_citations' => $data['awards']
		);
		$qr = $this->db->query("SELECT COUNT(*) AS count from infosys.pds_additionalinfo where employee_employee_id =".$data['id'])->row();
		if($qr->count > 0){
			$this->db->where('employee_employee_id', $data['id']);
			$this->db->update('infosys.pds_additionalinfo', $data1);
			$res = $this->db->affected_rows();
		}
		else{
			$this->db->insert('infosys.pds_additionalinfo ', $data1);
			$res = $this->db->insert_id();
		}
		if($res > 0)
			$suc++;
		else
			$err++;
		
		$data2 = array(
			'special_skills' => $data['skills'],
			'organizations' => $data['orgs'],
			'recognitions' => $data['recognitions']
		);
		$this->db->where('employee_id', $data['id']);
		$this->db->update('infosys.employee', $data2);
		if($this->db->affected_rows() > 0)
			$suc++;
		else
			$err++;

		// $this->db->query('DELETE FROM infosys.reference_info WHERE employee_employee_id ='.$data['id']);
		// for( $i=0; $i < count($data['refName']); $i++ )
		// {
		// 	$data1 = array(
		// 		'employee_employee_id ' => $data['id'],
		// 		'name' => $data['refName'][$i],
		// 		'address' => $data['refAdd'][$i],
		// 		'phone' => $data['refTel'][$i],
		// 		'flag' => $data['refFlag'][$i]
		// 	);
		// 	$this->db->insert('infosys.reference_info', $data1);
		// 	$res = $this->db->insert_id();
		// 	if($res > 0)
		// 		$suc++;
		// 	else
		// 		$err++;
		// }

		// $data3 = array(
		// 	'employee_employee_id' => $data['id'],
		// 	'organizations' => $data['govIDName'],
		// 	'organizations' => $data['govIDNo'],
		// 	'organizations' => $data['govDate'],
		// 	'recognitions' => $data['govPlace']
		// );
		// $qrid = $this->db->query("SELECT COUNT(*) AS count from infosys.identification where employee_employee_id =".$data['id'])->row();
		// if($qrid->count > 0){
		// 	$this->db->where('employee_employee_id', $data['id']);
		// 	$this->db->update('infosys.identification', $data3);
		// 	$res = $this->db->affected_rows();
		// }
		// else{
		// 	$this->db->insert('infosys.identification ', $data3);
		// 	$res = $this->db->insert_id();
		// }
		// if($res > 0)
		// 	$suc++;
		// else
		// 	$err++;
		return array($suc,$err,$this->db->error());
	}

	public function updateRef($data)
	{
		$suc = $err = 0;

		$this->db->query('DELETE FROM infosys.reference_info WHERE employee_employee_id ='.$data['id']);
		for( $i=0; $i < count($data['refName']); $i++ )
		{
			$data1 = array(
				'employee_employee_id ' => $data['id'],
				'name' => $data['refName'][$i],
				'address' => $data['refAdd'][$i],
				'phone' => $data['refTel'][$i],
				'flag' => $data['refFlag'][$i]
			);
			$this->db->insert('infosys.reference_info', $data1);
			$res = $this->db->insert_id();
			if($res > 0)
				$suc++;
			else
				$err++;
		}
		return array($suc,$err,$this->db->error());
	}

	public function getEmployees()
	{
		$result = "";
		$sql = "SELECT employee_id, concat(COALESCE(lastname,''), ', ', COALESCE(firstname,''), ' ', COALESCE(middlename,''), ' ', COALESCE(name_extension,'')) fullname, empno, users_id, employment_status_library_employment_status_library_id empstat FROM infosys.employee LEFT JOIN infosys.users on employee_id = employee_employee_id WHERE employee_id = ".$this->session->userdata('empid');
		if (in_array("3", $this->session->userdata('uroles'))) {
		    if($this->session->userdata("menu")=="profile")
		    	$sql = "SELECT employee_id, concat(COALESCE(lastname,''), ', ', COALESCE(firstname,''), ' ', COALESCE(middlename,''), ' ', COALESCE(name_extension,'')) fullname, empno, users_id, employment_status_library_employment_status_library_id empstat FROM infosys.employee LEFT JOIN infosys.users on employee_id = employee_employee_id WHERE employee_id > 0 ORDER BY lastname, firstname";
		}
		if($this->session->userdata("menu")=="dtr") {
		    if(in_array("34", $this->session->userdata('uroles')))
		   		$sql = "SELECT employee_id, concat(COALESCE(lastname,''), ', ', COALESCE(firstname,''), ' ', COALESCE(middlename,''), ' ', COALESCE(name_extension,'')) fullname, empno, users_id, employment_status_library_employment_status_library_id empstat FROM infosys.employee LEFT JOIN infosys.users on employee_id = employee_employee_id WHERE employment_status_library_employment_status_library_id not in (11,12,13,14,17) and unit_unit_id = ".$this->session->userdata('section')." ORDER BY lastname, firstname";
		    if(in_array("7", $this->session->userdata('uroles')))
		   		$sql = "SELECT employee_id, concat(COALESCE(lastname,''), ', ', COALESCE(firstname,''), ' ', COALESCE(middlename,''), ' ', COALESCE(name_extension,'')) fullname, empno, users_id, employment_status_library_employment_status_library_id empstat FROM infosys.employee LEFT JOIN infosys.users on employee_id = employee_employee_id WHERE employment_status_library_employment_status_library_id not in (11,12,13,14,17) and division_division_id = ".$this->session->userdata('division')." and (users_id in (SELECT users_users_id FROM `userlevel` where `userlevel`.`userlevelref_userlevelref_id` = 34) or unit_unit_id =1) ORDER BY lastname, firstname";
			if(in_array("35", $this->session->userdata('uroles')))
				$sql = "SELECT employee_id, concat(COALESCE(lastname,''), ', ', COALESCE(firstname,''), ' ', COALESCE(middlename,''), ' ', COALESCE(name_extension,'')) fullname, empno, users_id, employment_status_library_employment_status_library_id empstat FROM infosys.employee LEFT JOIN infosys.users on employee_id = employee_employee_id WHERE employment_status_library_employment_status_library_id not in (11,12,13,14,17) and (users_id in (SELECT users_users_id FROM `userlevel` where `userlevel`.`userlevelref_userlevelref_id` = 7) || division_division_id = ".$this->session->userdata('division').") ORDER BY lastname, firstname";
		    if(in_array("9", $this->session->userdata('uroles')))
		   		$sql = "SELECT employee_id, concat(COALESCE(lastname,''), ', ', COALESCE(firstname,''), ' ', COALESCE(middlename,''), ' ', COALESCE(name_extension,'')) fullname, empno, users_id, employment_status_library_employment_status_library_id empstat FROM infosys.employee LEFT JOIN infosys.users on employee_id = employee_employee_id WHERE employment_status_library_employment_status_library_id not in (11,12,13,14,17) ORDER BY lastname, firstname";
		}
		//employment_status_library_employment_status_library_id in (1,11,12,15,16,17)
		$query_result = $this->db->query($sql);

		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result .= "<option data-stat='".$rows->empstat."' data-userid=".$rows->users_id." value=".$rows->employee_id.">".$rows->empno." - ".strtoupper($rows->fullname)."</option>";
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

	function getRecord($q){
		return $this->db->query($q) ?? '';
	}

	function getRecordArray($q){
		return $this->db->query($q)->result_array() ?? '';
	}

	function getRecordObject($q){
		return $this->db->query($q)->result() ?? '';
	}

	function getEmployeeRecord($id){
		$query="select * from infosys where employee_id='".$id."'";
		$emp = $this->db->query($query);
		return $emp[0];
	}

	function getPermanentAddress($id){
		if($flag == 0)
			$table_name = "address";
		else
			$table_name = "address_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."' and address_type='Permanent'";
		$permanent = $this->db->query($query);
		return $permanent[0];
	}

	function getResidentialAddress($id){
		if($flag == 0)
			$table_name = "address";
		else
			$table_name = "address_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."' and address_type='Residential'";
		$residential = $this->db->query($query);
		return $residential[0];
	}

	function getSpouseRecord($id){
		if($flag == 0)
			$table_name = "family";
		else
			$table_name = "family_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."' and relationship='Spouse'";
		$spouse = $this->db->query($query);
		return $spouse[0];
	}

	function getFatherRecord($id){
		if($flag == 0)
			$table_name = "family";
		else
			$table_name = "family_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."' and relationship='Father'";
		$father = $this->db->query($query);
		return $father[0];
	}

	function getMotherRecord($id){
		if($flag == 0)
			$table_name = "family";
		else
			$table_name = "family_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."' and relationship='Mother'";
		$mother = $this->db->query($query);
		return $mother[0];
	}

	function getChildrenRecord($id){
		if($flag == 0)
			$table_name = "family";
		else
			$table_name = "family_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."' and relationship='Child'";
		$child = $this->db->query($query);
		return $child;
	}

	function getEducationRecord($id, $param){
		if($flag == 0)
			$table_name = "education";
		else
			$table_name = "education_temp";

		if($param)
		$query="select ".$table_name.".* from ".$table_name." where employee_employee_id=".$id." and level='".$param."'";
		//$query="select ".$table_name.".*, school.school_name, school.district, school.division from ".$table_name." inner join school on ".$table_name.".school_school_id = school.school_id where employee_employee_id=".$id." and level='".$param."'";
		else
		$query="select ".$table_name.".* from ".$table_name." where employee_employee_id=".$id;
		//$query="select ".$table_name.".*, school.school_name, school.district, school.division from ".$table_name." inner join school on ".$table_name.".school_school_id = school.school_id where employee_employee_id=".$id;
		$education = $this->db->query($query);
		return $education;
	}

	function getExaminationRecord($id){
		if($flag == 0)
			$table_name = "examination";
		else
			$table_name = "examination_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."' ORDER BY exam_date DESC";
		$examination = $this->db->query($query);
		return $examination;
	}

	function getServiceRecord($id){
		if(!$flag)
			$table_name = "service_record";
		else
			$table_name = "service_record_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."' order by start_date desc";
		$service = $this->db->query($query);
		return $service;
	}

	function getVoluntaryRecord($id){
		if($flag == 0)
			$table_name = "voluntary_work";
		else
			$table_name = "voluntary_work_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."' ORDER BY start_date DESC";
		$voluntary = $this->db->query($query);
		return $voluntary;
	}

	function getTrainingRecord($id){
		if($flag == 0)
			$table_name = "training";
		else
			$table_name = "training_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."' ORDER BY start_date DESC";
		$training = $this->db->query($query);
		return $training;
	}

	function getLegalInformation($id){
		if($flag == 0)
			$table_name = "legalinfo";
		else
			$table_name = "legalinfo_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."'";
		$legalinfo = $this->db->query($query);
		return $legalinfo;
	}

	function getOtherInformation($id){
		if($flag == 0)
			$table_name = "pds_additionalinfo";
		else
			$table_name = "pds_additionalinfo_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."'";
		$otherinfo = $this->db->query($query);
		return $otherinfo;
	}

	function getReferenceInfo($id){
		if($flag == 0)
			$table_name = "reference_info";
		else
			$table_name = "reference_info_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."' and flag=0";
		$referenceinfo = $this->db->query($query);
		return $referenceinfo;
	}

	function getEmergencyInfo($id){
		if($flag == 0)
			$table_name = "reference_info";
		else
			$table_name = "reference_info_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."' and flag=1";
		$emergencyinfo = $this->db->query($query);
		return $emergencyinfo;
	}

	function getLocalEmail($id){
		if($flag == 0)
			$table_name = "employee";
		else
			$table_name = "employee_temp";

		$query="select asti_email from ".$table_name." where employee_id='".$id."'";
		$asti_email = $this->db->query($query);
		return $asti_email[0]->asti_email;
	}

	function getPositionDesc($id){
		$query="select position_desc from position_reference inner join employee on position_reference_id = position_reference_position_reference_id and employee.employee_id='".$id."'";
		$position = $this->db->query($query);
		return $position[0]->position_desc;
	}

	function getDivisionDesc($id){
		$query="select division_desc from division inner join employee on division_id = division_division_id and employee.employee_id='".$id."'";
		$division = $this->db->query($query);
		return $division[0]->division_desc;
	}

	function getSkills($id){
		if($flag == 0)
			$table_name = "employee";
		else
			$table_name = "employee_temp";

		$query="select special_skills, organizations, recognitions from ".$table_name." where employee_id='".$id."'";
		$skills = $this->db->query($query);
		return $skills[0];
	}

	function getCedula($id){
		if($flag == 0)
			$table_name = "cedula";
		else
			$table_name = "cedula_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."'";
		$cedula = $this->db->query($query);
		return $cedula[0];
	}

	function getAdditionalInfo($id){
		if($flag == 0)
			$table_name = "pds_additionalinfo";
		else
			$table_name = "pds_additionalinfo_temp";

		$query="select * from ".$table_name." where employee_employee_id='".$id."'";
		$addinfo = $this->db->query($query);
		return $addinfo[0];
	}

	function getAllEmployees(){
		$query = "select employee.*, pds_flags.*, division.division_desc from employee inner join pds_flags on employee.empno = pds_flags.empno inner join division on employee.division_division_id = division.division_id where personal=1 || picture=1 || family=1 || education=1 || examination=1 || work=1 || voluntary=1 || training=1 || legal=1 || other=1 order by date_updated asc";
		$employee = $this->db->query($query);
		return $employee;
	}

	function getSchools($val){
		$query = "select * from school where school_name like '".$val."%'";
		$school = $this->db->query($query);
		return $school;
	}

	function getEmployeeAll(){
		$query = "select employee.employee_id, employee.empno, employee.lastname, employee.firstname, employee.middlename, pds_flags.date_updated, division.division_desc from employee inner join pds_flags on employee.empno = pds_flags.empno inner join division on employee.division_division_id = division.division_id order by lastname";
		$employee = $this->db->query($query);
		return $employee;
	}

	function getDivSec()
	{
		$res = "<option value=0 selected>All</option>";
		$qdiv = $this->db->query("SELECT * FROM infosys.division order by division_code");
		foreach($qdiv->result() as $d)
		{
			$res .= "<option value=".$d->division_id.">".$d->division_code."</option>";
			$qsec = $this->db->query("SELECT * FROM infosys.unit WHERE unit_div = ".$d->division_id." order by unit_code");
			foreach($qsec->result() as $u)
			{
				$res .= "<option value=".$d->division_id."_".$u->unit_id.">".$d->division_code."/".$u->unit_code."</option>";
			}
		}
		return $res;
	}

	function getList()
	{
		$result = array();
		$filter="";
		$sql = "SELECT *, esl.status as empstat, e.position_reference_position_reference_id prid, UPPER(concat(COALESCE(firstname,''), ' ', COALESCE(lastname,''))) fullname, min(sr.start_date) start_date
		FROM infosys.employee e 
			left join infosys.division d on d.division_id = e.division_division_id 
			left join infosys.employment_status_library esl on e.employment_status_library_employment_status_library_id = esl.employment_status_library_id
			left join infosys.unit u on e.unit_unit_id = u.unit_id
			left join infosys.plantilla p on e.employee_id = p.employee_employee_id and p.pstat = 1
			left join infosys.plantilla_library pl on p.plantilla_library_plantilla_library_id = pl.plantilla_library_id
			left join infosys.position_reference pr on pl.position_reference_position_reference_id = pr.position_reference_id
            left join infosys.service_record sr on employee_id = sr.employee_employee_id
			left join payroll_sbg.paycategory pc on pl.paycat = pc.paycatid 
			left join infosys.users s on employee_id = s.employee_employee_id WHERE employee_id <> 0
            ";
		if($this->input->post('ftrStat'))
			$filter .= " and employment_status_library_employment_status_library_id = '".$this->input->post('ftrStat')."'";
		if($this->input->post('ftDivSec')){
			if(strpos($this->input->post('ftDivSec'), '_') !== false){
				$f = explode("_", $this->input->post('ftDivSec'));
				$filter .= " and division_division_id = ".$f[0]." and unit_unit_id =".$f[1];
			}
			else
				$filter .= " and division_division_id = ".$this->input->post('ftDivSec');
		}
		if($this->input->post('ftrGender'))
			$filter .= " and gender = '".$this->input->post('ftrGender')."'";
		// return $sql.$filter;
		$query_result = $this->db->query($sql.$filter." GROUP BY employee_id ");
		if ($query_result->num_rows() > 0){
			foreach ( $query_result->result() as $rows ){
				// <th>No.</th>
				// <th>Name</th>
				// <th>Position</th>
				// <th>Div/Sec</th>
				// <th>Plantilla</th>
				// <th>App Date</th>
				// <th>Assump Date</th>
				// <th>Status</th>
				$result[] = array(
					html_escape($rows->empno),
					html_escape($rows->fullname),
					html_escape($rows->position_code),
					html_escape($rows->division_code."/".$rows->unit_code),
					html_escape($rows->item_number),
					html_escape($rows->appointment_date),
					html_escape($rows->assumption_date),
					html_escape($rows->start_date),
					html_escape($rows->empstat),
					"<center><a target=_blank onclick=\"window.open('".base_url('hr/employee/index/').$rows->employee_id."');\" glose='Edit' class='tags btn btn-sm btn-default font-blue'><i class='fa fa-edit font-blue'></i><span> </span></a></center>"
					);
			}
		}
		return $result;
	}

}