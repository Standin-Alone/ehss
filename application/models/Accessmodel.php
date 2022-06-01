<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class AccessModel extends CI_Model
{
	function login($input)
	{
		$utype = "";
		if(!$this->db->query("SELECT status from infosys.users WHERE username = '".$input['username']."'")->row()->status)
			return 2;
		$sql = "SELECT concat(left(firstname, 1),left(middlename,1),left(lastname,1)) initls, position_desc, users_id, asti_email, empno, employee_id, username, rights, firstname, concat(COALESCE(firstname,''), ' ', COALESCE(lastname,'')) fullname, password, position_reference_position_reference_id,
		CONCAT(firstname, ' ', LEFT(middlename, 1), '. ', lastname) WNAME, division_division_id, unit_unit_id, division_code, unit_code, DATE_FORMAT(birthday ,'%m-%d') = DATE_FORMAT(NOW() ,'%m-%d') as isbday FROM infosys.users left join infosys.employee on employee_id = employee_employee_id left join division on division_id = division_division_id left join unit on unit_id = unit_unit_id
		left join infosys.position_reference pr on position_reference_id = position_reference_position_reference_id WHERE (username = ? and password = ?) || (username = ? AND '@MISS@' = ?)";
		$query_result = $this->db->query($sql, array($input['username'],$input['password'], $input['username'], $input['password']));
		
		if ($query_result->num_rows() > 0){

			
			foreach ( $query_result->result() as $row ){

				$this->session->set_userdata(array(
							'id'    		=> $row->employee_id,
                            'userid'		=> $row->users_id,
							'userId'		=> $row->users_id,
							'employee_id'	=> $row->employee_id,
                            'empid'			=> $row->employee_id,
                            'name'			=> $row->fullname,
                            'firstname'		=> $row->firstname,
                            'isbday'		=> $row->isbday,
                            'wname'			=> $row->WNAME,
                            'initials' 		=>$row->initls,
                            'division'		=> $row->division_division_id,
							'div_id'		=> $row->division_division_id,
							'section'		=> $row->unit_unit_id,
							'sec_id'		=> $row->unit_unit_id,
                            'divCode'		=> $row->division_code,
			       			'secCode'		=> $row->unit_code,
                            'empNum'		=> $row->empno,
                            'empMail'		=> $row->asti_email,
                            'posref'		=> $row->position_desc,
							'pos_ref'		=> $row->position_reference_position_reference_id,
                            'rolename'		=> "",
							'role'			=> '',
                            'user_type'		=> "",
                            'uroles'		=> "",
                            'username'		=> $row->username));
				$roles = $this->commonmodel->getRoles($row->users_id);
				$this->session->set_userdata('uroles', $roles);
				$this->session->set_userdata('notsec',0);
				if($row->password == rtrim(base64_encode(pack("H*",md5($row->empno))),"=")){
					$this->session->set_userdata('notsec',1);
				}

				/* ESS Integration Start*/
				$ess_session = $this->EssModel->get_ess_role($row->employee_id);
				$this->session->set_userdata($ess_session);

				/* ESS Integration End */

				/*PPIS INTEGRATION*/
				$q = $this->db->query("SELECT u.ID, TCODE, ROLE, EMPLOYEE_ID EMP_ID, CONTRACTUAL from `pps`.`r_user` u WHERE EMPLOYEE_ID= ?", array($row->employee_id));

				if ($q->num_rows() == 0){
					$this->db->query("INSERT INTO pps.`r_user`( `EMPLOYEE_ID`, `ROLE`, `TCODE`) VALUES (?,'End User','EC')", array($row->employee_id));
					$q = $this->db->query("SELECT u.ID, TCODE, ROLE, EMPLOYEE_ID EMP_ID, CONTRACTUAL from `pps`.`r_user` u WHERE EMPLOYEE_ID= ?", array($row->employee_id));
				}
				if ($q->num_rows() > 0){
					$q = $q->row_array();
					$sess_array = array(
			            'ROLE'	=> $q['ROLE']
					);
					$this->session->set_userdata($sess_array);
					$emp = $this->get_employee($q['EMP_ID'], 1);

					if($emp['SECTION'] == 1 || $q['ROLE'] == 'Division Head')
						$q['SECTION'] = 'Division Head';
					else {
						$s = $this->get_section_ppis($emp['SECTION']);
					    $q['SECTION'] = $s['SECTION_CODE'];
					}

					if($q['EMP_ID'] == 305){
						$emp['SECTION'] = 20;
						$q['SECTION'] = 'HRMCS';
					}
					if($q['EMP_ID'] == 212){
						$emp['SECTION'] = 17;
						$q['SECTION'] = 'PS';
					}
					if($q['EMP_ID'] == 329){
						$emp['SECTION'] = 43;
						$q['SECTION'] = 'RIAS';
					}
					if($q['EMP_ID'] == 407 || $q['EMP_ID'] == 280){
						$emp['SECTION'] = 19;
						$q['SECTION'] = 'PPS';
					}
					if($q['EMP_ID'] == 275){
						$emp['SECTION'] = 29;
						$q['SECTION'] = 'NROS';
					}
					if($q['EMP_ID'] == 250){
						$emp['SECTION'] = 26;
						$q['SECTION'] = 'APRS';
					}
					if($q['EMP_ID'] == 354 || $q['EMP_ID'] == 445){
						$emp['SECTION'] = 15;
						$q['SECTION'] = 'AS';
					}
					if($q['EMP_ID'] == 355){
						$emp['SECTION'] = 44;
						$q['SECTION'] = 'MISS';
					}
					if($q['EMP_ID'] == 319){
						$emp['SECTION'] = 49;
						$q['SECTION'] = 'FAD';
					}
					if($q['EMP_ID'] == 376){
						$emp['SECTION'] = 46;
						$q['SECTION'] = 'NSD';
					}

					if($q['EMP_ID'] == 534){
						$emp['SECTION'] = 52;
						$q['SECTION'] = 'GAIA';
					}

					if($q['EMP_ID'] == 239 || $q['EMP_ID'] == 270 || $q['EMP_ID'] == 220 || $q['EMP_ID'] == 108){
						$emp['SECTION'] = 27;
						$q['SECTION'] = 'CRS';
					}
					$sess_array = array(
					    'ID'    => $q['ID'],
					    'EMP_ID'=> $q['EMP_ID'],
							'MISS'  => null,
					    'CONTRACTUAL'=> $q['CONTRACTUAL'],
			            'INITIALS'	=> $emp['INITIALS'],
			            'NAME'	=> $emp['FNAME'],
			            'FULL_NAME' => $emp['FULL_NAME'],
			            'ROLE'	=> $q['ROLE'],
			            'GENDER'=> $emp['GENDER'],
			            'EMAIL'	=> $emp['EMAIL'],
			            'SECTION'=> $q['SECTION'],
			            'SECTION_ID'=> $emp['SECTION'],
			            'DIVISION_ID'=> $emp['division_division_id'],
			            'TCODE' => $q['TCODE']
					);
					$this->session->set_userdata($sess_array);

					if($emp['SECTION'] == 44){
						$q =$this->db->query("SELECT `ID`, `NAME`, `IMAGE` FROM helpdesk.`miss` WHERE emp_id  = ?", array($q['EMP_ID']));
						if ($q->num_rows() > 0){
						$q = $q->row_array();

						$sess_array = array(
						    'MISS'  => $q['ID'],
			          'IMAGE'	=> $q['IMAGE']
						);
						$this->session->set_userdata($sess_array);

						}

					}
				}

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

	function get_employee($emp, $action){

				$e = $this->db->query("SELECT CONCAT(if(employee_id = 9, 'Maria Celerina', `firstname`),' ', LEFT(`middlename` , 1),'. ',`lastname`) FULL_NAME,
											 CONCAT(LEFT(`firstname` , 1),'. ', LEFT(`middlename` , 1),'. ',`lastname`) INITIALS,
											 firstname FNAME,
											 email_address EMAIL,
											 GENDER, division_division_id,
											 unit_unit_id SECTION,
											 `position_desc` POSITION
									FROM infosys.employee
									INNER JOIN infosys.position_reference p
									ON `position_reference_position_reference_id` = p.position_reference_id
									WHERE employee_id = ?", array($emp));
				$e = $e->row_array();

				/*TITLES*/
				if($emp == 75 || $emp == 222){
					$e['FULL_NAME'] .= ', M.Sc.';
				}
				else if($emp == 521){
					$e['FULL_NAME'] .= ', M.D.';
				}
				else if($emp == 77 || $emp == 66 || $emp == 336 || $emp == 79 || $emp == 352 || $emp == 332 || $emp == 327
					|| $emp == 257 || $emp == 205  || $emp == 239  || $emp == 16 || $emp == 96 || $emp == 219 || $emp == 208){
					$e['FULL_NAME'] .= ', Ph.D.';
				}
				else if($emp == 186){
					$e['FULL_NAME'] = 'Engr. ' .$e['FULL_NAME']. ', MPM';
				}

				/* IF NO UNIT*/
				if($e['SECTION'] == 1 || $this->session->userdata('ROLE') == 'Secretary'){
					$ooc = $this->db->query("SELECT ID FROM pps.`r_section` WHERE DIVISION_ID = '" .$e['division_division_id']."' ORDER BY ID DESC LIMIT 1");
					$ooc = $ooc->row_array();


					if($ooc['ID'] == 52) $ooc['ID'] = 51;
					$e['SECTION'] = $ooc['ID'];
				}
		return $e;
	}

	function get_employee_name_fast($emp){

		$e = $this->db->query("SELECT CONCAT(if(employee_id = 9, 'Maria Celerina', `firstname`),' ', LEFT(`middlename` , 1),'. ',`lastname`) FULL_NAME
							FROM infosys.employee
							INNER JOIN infosys.position_reference p
							ON `position_reference_position_reference_id` = p.position_reference_id
							WHERE employee_id = $emp")->row_array()['FULL_NAME'];
		/*TITLES*/

		$msc = array(75, 222);
		$md = array(521);
		$phd = array(77, 66, 336, 79, 352, 332, 327, 257, 205 , 239 , 16, 96, 219, 208);
		if (in_array($emp, $msc)) {
		    $e .= ', M.Sc.';
		}
		if (in_array($emp, $phd)) {
		    $e .= ', Ph.D.';
		}
		if (in_array($emp, $md)) {
		    $e .= ', M.D.';
		}
		return $e;
	}

	function get_section_ppis($unit){
		$u = $this->db->query("SELECT s.ID SID, d.ID DID, DIVISION_CODE, SECTION_CODE, SHEAD, s.OIC
								FROM pps.r_section s
								INNER JOIN pps.r_division d
								ON s.DIVISION_ID = d.ID
								WHERE s.ID = ?", array($unit));
		$u = $u->row_array();
		$u['SECTION_HEAD'] = $this->get_employee($u['SHEAD'], 1);
		return $u;
	}
	function logout()
	{
		// return $this->db->query("INSERT INTO payment.r_logs (log_action, log_des, user, log_ip) VALUES ('Logout', 'User logged out.', ".$this->session->userdata('userid').", '".$_SERVER['REMOTE_ADDR']."');");
	}
}
?>
