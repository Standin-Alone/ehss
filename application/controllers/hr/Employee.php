<?php defined('BASEPATH') OR exit('No direct script access allowed');

// require_once APPPATH. '/third_party/venter/box/spout/src/Spout/Autoloader/autoload.php';
class Employee extends CI_Controller{
	public function __construct() {
	    parent::__construct();
		if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
			redirect('access/');
	}

	public function index(){
		$data['menu'] = "profile";
		$data['gmenu'] = "main";
		$this->session->set_userdata("menu", "profile");

		$this->load->view('template/header', $data);
		$this->load->view('hr/profile');
		$this->load->view('template/footer');
	}

	public function list(){
		$data['menu'] = "employees";
		$data['gmenu'] = "main";
		$this->session->set_userdata("menu", "employees");

		$this->load->view('template/header', $data);
		$this->load->view('hr/employees');
		$this->load->view('template/footer');
	}

	public function getEmployees(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->employeemodel->getEmployees()));
	}

	public function getEmployee(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->employeemodel->getEmployee($this->input->get("id"))));
	}

	public function getPersonalInfo(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->employeemodel->getPersonalInfo($this->input->get("id"))));
	}

	public function getPlantilla(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->employeemodel->getPlantilla()));
	}

	public function getPositions(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->employeemodel->getPositions()));
	}

	public function getDivSec(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->employeemodel->getDivSec()));
	}

	public function getList(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->employeemodel->getList()));
	}
	
	public function updateUserLevel()
	{
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->employeemodel->updateUserLevel($this->input->post('udata'))));
	}

	public function updateChild()
	{
		// $res = $this->employeemodel->updateFamily($this->input->post());
		$this->output->set_content_type("application/json")->set_output(json_encode($this->employeemodel->updateChild($this->input->post())));
	}

	public function updateEduc()
	{
		$this->output->set_content_type("application/json")->set_output(json_encode($this->employeemodel->updateEduc($this->input->post())));
	}

	public function updateExam()
	{
		$this->output->set_content_type("application/json")->set_output(json_encode($this->employeemodel->updateExam($this->input->post())));
	}

	public function updateWork()
	{
		$this->output->set_content_type("application/json")->set_output(json_encode($this->employeemodel->updateWork($this->input->post())));
	}

	public function updateVol()
	{
		$this->output->set_content_type("application/json")->set_output(json_encode($this->employeemodel->updateVol($this->input->post())));
	}

	public function updateTrain()
	{
		$this->output->set_content_type("application/json")->set_output(json_encode($this->employeemodel->updateTrain($this->input->post())));
	}

	public function updateLegal()
	{
		$this->output->set_content_type("application/json")->set_output(json_encode($this->employeemodel->updateLegal($this->input->post())));
	}

	public function updateOther()
	{
		$this->output->set_content_type("application/json")->set_output(json_encode($this->employeemodel->updateOther($this->input->post())));
	}

	public function updateRef()
	{
		$this->output->set_content_type("application/json")->set_output(json_encode($this->employeemodel->updateRef($this->input->post())));
	}

	public function getRecordArray(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->employeemodel->getRecordArray($this->input->get('q'))));
	}

	public function getRecordObject(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->employeemodel->getRecordObject($this->input->get('q'))));
	}

	function testplode($id){
		$id=324;
		// // $tags = explode(',','["1", "7"]');
		// $tags = ["1", "7"];

		// foreach($tags as $key) {    
		//     echo '"'.$key.'"<br/>';    
		// }
		
		// $res_address = $this->employeemodel->getRecord("select * from address where employee_employee_id='92' and address_type='Residential'")->result_array()[0];
		// echo $res_address['street']." ".$res_address['town_or_city']." ".$res_address['province']." ".$res_address['zip_code'];
		
		// $res_address = $this->employeemodel->getRecord("select * from address where employee_employee_id='92' and address_type='Residential'")->result();
		// foreach($res_address as $r){
		// 	echo "<br>".$r->street." ".$r->town_or_city." ".$r->province;
		// }
		
		// $emp = $this->employeemodel->getRecord("select *, DATE_FORMAT(birthday,'%mm/%dd/%Y') AS bday from employee where employee_id=92")->result_array()[0];
		// echo $emp['empno']." ".$emp['lastname']." ".$emp['firstname']." ".$emp['middlename'];
		
		// $child = $this->employeemodel->getRecord("select * from family where employee_employee_id='92' and relationship='Child'")->result();
		// foreach($child as $c){
		// 	echo $c->firstname." ".$c->middlename." ".$c->lastname." ".$c->birthday;
		// }

		$legal = $this->employeemodel->getRecord("select * from legalinfo where employee_employee_id=".$id." order by legalissue")->result_array();
		echo "<pre>";
		print_r($legal);
		echo "</pre>";
		$ysc = "☑ YES";
		$ys = "⬜ YES";
		$noc = "☑ NO";
		$no = "⬜ NO";
		echo ($legal[0]->answer==0) ? $noc : $no;
		// var_dump("<pre>".$legal."</pre>");
	}

	public function exportPDS($id){
		// $id = 79;
		$emp = $this->employeemodel->getRecord("select *, DATE_FORMAT(birthday,'%m/%d/%Y') AS bday from employee where employee_id=".$id)->result_array()[0];
		$res_address = $this->employeemodel->getRecord("select * from address where employee_employee_id='".$id."' and address_type='Residential'")->result_array();
		$res_address = $res_address ? $res_address[0] : "";
		$per_address = $this->employeemodel->getRecord("select * from address where employee_employee_id='".$id."' and address_type='Permanent'")->result_array();
		$per_address = $per_address ? $per_address[0] : "";
		$spouse = $this->employeemodel->getRecord("select * from family where employee_employee_id='".$id."' and relationship='Spouse'")->result_array();
		$spouse = $spouse ? $spouse[0] : "";
		$father = $this->employeemodel->getRecord("select * from family where employee_employee_id='".$id."' and relationship='Father'")->result_array();
		$father = $father ? $father[0] : "";
		$mother = $this->employeemodel->getRecord("select * from family where employee_employee_id='".$id."' and relationship='Mother'")->result_array();
		$mother = $mother ? $mother[0] : "";
		$child = $this->employeemodel->getRecord("select * from family where employee_employee_id='".$id."' and relationship='Child'")->result();
		$elem = $this->employeemodel->getRecord("select * from education where employee_employee_id=".$id." and level='Elementary'")->result_array();
		$elem = $elem ? $elem[0] : "";
		$sec = $this->employeemodel->getRecord("select * from education where employee_employee_id=".$id." and level='Secondary'")->result_array();
		$sec = $sec ? $sec[0] : "";
		$voc = $this->employeemodel->getRecord("select * from education where employee_employee_id=".$id." and level='Vocational'")->result_array();
		$voc = $voc ? $voc[0] : "";
		$col = $this->employeemodel->getRecord("select * from education where employee_employee_id=".$id." and level='College'")->result_array();
		$col = $col ? $col[0] : "";
		$grad = $this->employeemodel->getRecord("select * from education where employee_employee_id=".$id." and level='Graduate Studies'")->result_array();
		$grad = $grad ? $grad[0] : "";

		$exam = $this->employeemodel->getRecord("select * from examination where employee_employee_id='".$id."' ORDER BY exam_date DESC")->result();
		$serv = $this->employeemodel->getRecord("select * from service_record where employee_employee_id='".$id."' order by start_date desc")->result();
		$volu = $this->employeemodel->getRecord("select * from voluntary_work where employee_employee_id='".$id."' ORDER BY start_date DESC")->result();
		$trai = $this->employeemodel->getRecord("select * from training where employee_employee_id='".$id."' ORDER BY start_date DESC")->result();

		ob_start();
		$this->load->library('excel');
		error_reporting(E_ALL);

		$chk = "☑ ";
		$unchk = "⬜ ";
		$excel2 = PHPExcel_IOFactory::createReader('Excel2007');
		$excel2 = $excel2->load(FCPATH.'/assets/template/2017csform212_revised_pds.xlsx');
		$excel2->setActiveSheetIndex(0);
			$excel2->getActiveSheet()->setCellValue('D10', $emp['lastname'])
					->setCellValue('D11', $emp['firstname'])
					->setCellValue('N11', $emp['name_extension'])
					->setCellValue('D12', $emp['middlename'])
					->setCellValue('D13', $emp['bday'])
					->setCellValue('D15', $emp['birthplace'])
					->setCellValue('D16', ($emp['gender']=="M" ? $chk : $unchk)."Male")
					->setCellValue('E16', ($emp['gender']=="F" ? $chk : $unchk)."Female")
					->setCellValue('D17', ($emp['civil_status']=="Single" ? $chk : $unchk)."Single")
					->setCellValue('D18', ($emp['civil_status']=="Widowed" ? $chk : $unchk)."Widowed")
					->setCellValue('D20', "Other/s:")
					->setCellValue('E17', ($emp['civil_status']=="Married" ? $chk : $unchk)."Married")
					->setCellValue('E18', ($emp['civil_status']=="Separated" ? $chk : $unchk)."Separated")
					->setCellValue('J13', "☑ Filipino")
					->setCellValue('L13', "⬜ Dual Citizenship")
					->setCellValue('L14', "⬜ by birth")
					->setCellValue('M14', "⬜ by naturalization")
					//residential
					->setCellValue('I17', $res_address['street'])
					->setCellValue('L17', '')
					->setCellValue('I19', "")
					->setCellValue('L19', '')
					->setCellValue('I22', $res_address['town_or_city'])
					->setCellValue('L22', $res_address['province'])
					->setCellValue('I24', $res_address['zip_code'])
					//permanent
					->setCellValue('I25', $per_address['street'])
					->setCellValue('L25', '')
					->setCellValue('I27', '')
					->setCellValue('L27', '')
					->setCellValue('L29', $per_address['town_or_city'])
					->setCellValue('I29', $per_address['province'])
					->setCellValue('L31', $per_address['zip_code'])
					
					->setCellValue('D22', $emp['height'])
					->setCellValue('D24', $emp['weight'])
					->setCellValue('D25', $emp['blood_type'])
					->setCellValue('D27', $emp['gsis_id_num'])
					->setCellValue('D29', $emp['philhealth_num'])
					->setCellValue('D31', $emp['pagibig_id_num'])
					->setCellValue('D32', $emp['sss_num'])
					->setCellValue('D33', $emp['tin'])
					->setCellValue('D34', $emp['empno'])
					
					->setCellValue('I32', '')
					->setCellValue('I33', $emp['mobile_phone'])
					->setCellValue('I34', $emp['email_address'])
					//spouse
					->setCellValue('D36', $spouse['lastname'])
					->setCellValue('D37', $spouse['firstname'])
					->setCellValue('H37', "")
					->setCellValue('D38', $spouse['middlename'])
					->setCellValue('D39', $spouse['occupation'])
					->setCellValue('D40', $spouse['employer'])
					->setCellValue('D41', $spouse['employer_address'])
					->setCellValue('D42', $spouse['employer_telnum'])
					//father
					->setCellValue('D43', $father['lastname'])
					->setCellValue('D44', $father['firstname'])
					->setCellValue('H44', "")
					->setCellValue('D45', $father['middlename'])
					//mother
					->setCellValue('D47', $mother['lastname'])
					->setCellValue('D48', $mother['firstname'])
					->setCellValue('D49', $mother['middlename'])
					->setCellValue('L60', date("m/d/Y"));

			//children
			$x = 37;
			if($child)
			foreach($child as $c){
				$excel2->getActiveSheet()->setCellValue('I'.$x, $c->firstname." ".$c->middlename." ".$c->lastname)
						->setCellValue('M'.$x, $c->birthday);
				$x++;
			}
			
			//education
			if($elem)
			$excel2->getActiveSheet()->setCellValue('D54', $elem['school_name'])
						->setCellValue('G54', $elem['degree_units_earned'])
						->setCellValue('J54', $elem['start_date'])
						->setCellValue('K54', $elem['end_date'])
						->setCellValue('L54', $elem['highest_units_earned'])
						->setCellValue('M54', $elem['year_graduated'])
						->setCellValue('N54', $elem['honors_received']);
			if($sec)
			$excel2->getActiveSheet()->setCellValue('D55', $sec['school_name'])
						->setCellValue('G55', $sec['degree_units_earned'])
						->setCellValue('J55', $sec['start_date'])
						->setCellValue('K55', $sec['end_date'])
						->setCellValue('L55', $sec['highest_units_earned'])
						->setCellValue('M55', $sec['year_graduated'])
						->setCellValue('N55', $sec['honors_received']);
			if($voc)		
			$excel2->getActiveSheet()->setCellValue('D56', $voc['school_name'])
						->setCellValue('G56', $voc['degree_units_earned'])
						->setCellValue('J56', $voc['start_date'])
						->setCellValue('K56', $voc['end_date'])
						->setCellValue('L56', $voc['highest_units_earned'])
						->setCellValue('M56', $voc['year_graduated'])
						->setCellValue('N56', $voc['honors_received']);
			if($col)
			$excel2->getActiveSheet()->setCellValue('D57', $col['school_name'])
						->setCellValue('G57', $col['degree_units_earned'])
						->setCellValue('J57', $col['start_date'])
						->setCellValue('K57', $col['end_date'])
						->setCellValue('L57', $col['highest_units_earned'])
						->setCellValue('M57', $col['year_graduated'])
						->setCellValue('N57', $col['honors_received']);
			if($grad)			
			$excel2->getActiveSheet()->setCellValue('D58', $grad['school_name'])
					->setCellValue('G58', $grad['degree_units_earned'])
					->setCellValue('J58', $grad['start_date'])
					->setCellValue('K58', $grad['end_date'])
					->setCellValue('L58', $grad['highest_units_earned'])
					->setCellValue('M58', $grad['year_graduated'])
					->setCellValue('N58', $grad['honors_received']);
		

		$excel2->setActiveSheetIndex(1);
			//exam
				$x = 5;
				foreach($exam as $c){
					$excel2->getActiveSheet()->setCellValue('A'.$x, $c->exam_doc)
							->setCellValue('F'.$x, $c->exam_rating)
							->setCellValue('G'.$x, $c->exam_date)
							->setCellValue('I'.$x, $c->exam_location)
							->setCellValue('L'.$x, $c->license_number)
							->setCellValue('M'.$x, $c->license_date);
					$x++;
				}

			//work
				$x = 18;
				$addedx = 0;
				if(count($serv)>30){
					$addedx = (count($serv)-30);
					$excel2->getActiveSheet()->insertNewRowBefore(20,$addedx); 
				}
				foreach($serv as $c){
					$excel2->getActiveSheet()->setCellValue('A'.$x, $c->start_date)
							->setCellValue('C'.$x, $c->end_date)
							->setCellValue('D'.$x, $c->position_desc)
							->setCellValue('G'.$x, $c->agency_dept_name)
							->setCellValue('J'.$x, $c->salary)
							->setCellValue('K'.$x, $c->salary_grade)
							->setCellValue('L'.$x, $c->appointment_status)
							->setCellValue('M'.$x, $c->gov_service);
					$excel2->getActiveSheet()->mergeCells("A$x:B$x");
					$excel2->getActiveSheet()->mergeCells("D$x:F$x");
					$excel2->getActiveSheet()->mergeCells("G$x:I$x");
					$x++;
				}
			$excel2->getActiveSheet()->setCellValue('J'.($addedx+49), date("m/d/Y"));

		$excel2->setActiveSheetIndex(2);
			//work
				$x = 6;
				foreach($volu as $c){
					$excel2->getActiveSheet()->setCellValue('A'.$x, $c->organization_info)
							->setCellValue('E'.$x, $c->start_date)
							->setCellValue('F'.$x, $c->end_date)
							->setCellValue('G'.$x, $c->work_duration_hrs)
							->setCellValue('H'.$x, $c->pos_or_nature);
					$x++;
				}

				$x = 19;
				$addedx = 0;
				if(count($trai)>20){
					$addedx = (count($trai)-20);
					$excel2->getActiveSheet()->insertNewRowBefore(20,$addedx); 
				}
				foreach($trai as $c){
					$excel2->getActiveSheet()->setCellValue('A'.$x, $c->training_desc)
							->setCellValue('E'.$x, $c->start_date)
							->setCellValue('F'.$x, $c->end_date)
							->setCellValue('G'.$x, $c->training_duration_hrs)
							->setCellValue('I'.$x, $c->training_sponsor);
					$excel2->getActiveSheet()->mergeCells("A$x:D$x");
					$excel2->getActiveSheet()->mergeCells("I$x:K$x");
					$x++;
				}
	
				$skills = explode("\n",$emp['special_skills']);
				$recognition = explode("\n",$emp['recognitions']);
				$organization = explode("\n",$emp['organizations']);
				$x = 42 + $addedx;
				foreach($skills as $c){
					$excel2->getActiveSheet()->setCellValue('A'.$x, $c);
					$x++;
				}
				$x = 42 + $addedx;
				foreach($recognition as $c){
					$excel2->getActiveSheet()->setCellValue('C'.$x, $c);
					$x++;
				}
				$x = 42 + $addedx;
				foreach($organization as $c){
					$excel2->getActiveSheet()->setCellValue('I'.$x, $c);
					$x++;
				}

				$excel2->getActiveSheet()->setCellValue('I'.(50 + $addedx), date("m/d/Y"));

		$excel2->setActiveSheetIndex(3);
			$legal = $this->employeemodel->getRecord("select * from legalinfo where employee_employee_id=".$id." order by legalissue")->result_array();
			if(count($legal))
			{
				$ysc = "☑ YES";
				$ys = "⬜ YES";
				$noc = "☑ NO";
				$no = "⬜ NO";
				$excel2->getActiveSheet()->setCellValue('G6', $legal[0]['answer'] ? $ysc : $ys)
						->setCellValue('J6', !$legal[0]->answer ? $noc : $no)
						->setCellValue('H11', $legal[1]['particulars'])
						->setCellValue('G8', $legal[1]->answer ? $ysc : $ys)
						->setCellValue('J8', !$legal[1]->answer ? $noc : $no);

				$excel2->getActiveSheet()->setCellValue('H15', $legal[2]['particulars'])
						->setCellValue('G13', $legal[2]['answer'] ? $ysc : $ys)
						->setCellValue('J13', !$legal[2]['answer'] ? $noc : $no);

				$excel2->getActiveSheet()->setCellValue('K20', ($legal[3]['datefiled'] =="0000-00-00") ? "" : $legal[3]['datefiled'])
										->setCellValue('K21', $legal[3]['particulars'])
						->setCellValue('G18', $legal[3]['answer'] ? $ysc : $ys)
						->setCellValue('J18', !$legal[3]['answer'] ? $noc : $no);

				$excel2->getActiveSheet()->setCellValue('H25', $legal[4]['particulars'])
						->setCellValue('G23', $legal[4]['answer'] ? $ysc : $ys)
						->setCellValue('J23', !$legal[4]['answer'] ? $noc : $no);

				$excel2->getActiveSheet()->setCellValue('H29', $legal[5]['particulars'])
						->setCellValue('G27', $legal[5]['answer'] ? $ysc : $ys)
						->setCellValue('J27', !$legal[5]['answer'] ? $noc : $no);

				$excel2->getActiveSheet()->setCellValue('K32', $legal[6]['particulars'])
						->setCellValue('G31', $legal[6]['answer'] ? $ysc : $ys)
						->setCellValue('J31', !$legal[6]['answer'] ? $noc : $no);

				$excel2->getActiveSheet()->setCellValue('K35', $legal[7]['particulars'])
						->setCellValue('G34', $legal[7]['answer'] ? $ysc : $ys)
						->setCellValue('J34', !$legal[7]['answer'] ? $noc : $no);

				$excel2->getActiveSheet()->setCellValue('H39', $legal[8]['particulars'])
						->setCellValue('G37', $legal[8]['answer'] ? $ysc : $ys)
						->setCellValue('J37', !$legal[8]['answer'] ? $noc : $no);

				$excel2->getActiveSheet()->setCellValue('L44', $legal[9]['particulars'])
						->setCellValue('G43', $legal[9]['answer'] ? $ysc : $ys)
						->setCellValue('J43', !$legal[9]['answer'] ? $noc : $no);

				$excel2->getActiveSheet()->setCellValue('L46', $legal[10]['particulars'])
						->setCellValue('G45', $legal[10]['answer'] ? $ysc : $ys)
						->setCellValue('J45', !$legal[10]['answer'] ? $noc : $no);

				$excel2->getActiveSheet()->setCellValue('L48', $legal[11]['particulars'])
						->setCellValue('G47', $legal[11]['answer'] ? $ysc : $ys)
						->setCellValue('J47', !$legal[11]['answer'] ? $noc : $no);
			}
			
			$ref = $this->employeemodel->getRecord("select * from reference_info where employee_employee_id='".$id."' and flag=0")->result();
			$x = 52;
			foreach($ref as $c){
				$excel2->getActiveSheet()->setCellValue('A'.$x, $c->name)
						->setCellValue('F'.$x, $c->address)
						->setCellValue('G'.$x, $c->phone);
				$x++;
			}
			$emer = $this->employeemodel->getRecord("select * from reference_info where employee_employee_id='".$id."' and flag=1");
			$ced = $this->employeemodel->getRecord("select * from identification where employee_employee_id=".$id)->result_array();
			// $ced = $ced ? $ced[0] : "";
			if($ced){
				$excel2->getActiveSheet()->setCellValue('D61', $ced[0]['id_name'])
										->setCellValue('D62', $ced[0]['id_no'])
										->setCellValue('D64', $ced[0]['id_date']."/".$ced[0]['id_place']);
			}
			$other = $this->employeemodel->getRecord("select * from pds_additionalinfo where employee_employee_id=".$id);	

		// $excel2->getActiveSheet()->setCellValue('B1', $dt);
		// $res = $this->db->query("SELECT * FROM infosys.employee e WHERE e.employee_id = $id");
		// if($res->num_rows() > 0)
		// {
		// 	foreach($res->result() as $row){
		// 		//insertrow
		// 		// $objPHPExcel->getActiveSheet()->insertNewRowBefore(2,10); 
		// 		// $objPHPExcel->getActiveSheet()->duplicateStyle($objPHPExcel->getActiveSheet()->getStyle('A1'),'A2:A10'); 
		// 		$x++;
		// 		$cnt++;
		// 	}
		// }

		// $allborders = array(
		// 	'borders' => array(
		// 		'allborders' => array(
		// 		'style' => PHPExcel_Style_Border::BORDER_THIN
		// 		)
		// 	)
		// );
		// $excel2->getActiveSheet()->getStyle('A5:BA'.$x)->applyFromArray($allborders);

		ob_end_clean();
		ob_clean();
		ob_flush();
		$filename='PDS.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
		$objWriter->save('php://output');
	}
	
}
?>