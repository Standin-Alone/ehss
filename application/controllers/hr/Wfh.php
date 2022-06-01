<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wfh extends CI_Controller {
	public function __construct() {
	    parent::__construct();
		if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
			redirect('access/');
	}

	function index(){
		$data['menu'] = "wfh";
		$data['gmenu'] = "attendance";
		$this->session->set_userdata("menu", "dtr");

		
		$this->load->view('template/header', $data);
		$this->load->view('hr/wfh');
		$this->load->view('template/footer');
	}
	function submissions(){
		$data['menu'] = "wfhsub";
		$data['gmenu'] = "attendance";
		$this->session->set_userdata("menu", "dtr");

		
		$this->load->view('template/header', $data);
		$this->load->view('hr/wfhsub');
		$this->load->view('template/footer');
	}

	public function getList(){
		$this->output->set_content_type("application/json")->set_output(json_encode($this->wfhmodel->getList()));
	}

	public function getSecList(){
		$this->output->set_content_type("application/json")->set_output(json_encode($this->wfhmodel->getSecList()));
	}

	public function getReport(){
		$this->output->set_content_type("application/json")->set_output(json_encode($this->wfhmodel->getReport()));
	}

	public function getReportById(){
		$this->output->set_content_type("application/json")->set_output(json_encode($this->wfhmodel->getReportById()));
	}

	public function getReportx(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->wfhmodel->getReportx($this->input->get('dt'), $this->session->userdata('id'))));
	}

	public function act(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->wfhmodel->act()));
	}

	public function printWFH($dt){
		$wfhs = $this->wfhmodel->getReportx($dt, $this->session->userdata('id'));
		$dtS = $dtA = $aby = $remarks = "";
		$this->load->library('fpdf_gen');
		$pdf = new FPDF('P','mm', 'A4');
		$pdf->SetTitle('WFH Report');
		// $pdf->SetMargins(25.4,25.4,25.4);
		$pdf->SetAutoPageBreak(false);

		$pdf->AddPage();

		foreach($wfhs as $row){
			$pdf->SetFont('Times', '', 14);
			$pdf->Cell(0, 4, 'WORK FROM HOME REPORT', '' , 1, 'C');

			$pdf->SetFont('Times', '', 12);
			// $pdf->Cell(0, 4, $row->fordts." ".date("F Y", strtotime($dt)), '' , 1, 'C');
			$pdf->MultiCell(0,6, $row->fordts." ".date("F Y", strtotime($dt)),0,'C',0);
			$pdf->ln(6);
			$pdf->SetFont('Times', '', 12);
			$pdf->Cell(0, 5, 'LIST OF ACCOMPLISHMENTS', '' , 1, 'C');

			if($row->id){
				$qrhisS = $this->db->query("SELECT DATE_FORMAT(statdt, '%m/%d/%Y') sdt FROM wfh.report_history WHERE status = 'Submitted' and wfhid = ".$row->id." order by statdt desc limit 1");
				foreach($qrhisS->result() as $rhisS)
					$dtS = $rhisS->sdt;
				$qrhisA = $this->db->query("SELECT DATE_FORMAT(statdt, '%m/%d/%Y') sdt, statby, remarks FROM wfh.report_history WHERE status = 'Approved' and wfhid = ".$row->id." order by statdt desc limit 1");
				foreach($qrhisA->result() as $rhisA){
					$dtA = $rhisA->sdt;
					$aby = $rhisA->statby;
					$remarks = $rhisA->remarks;
				}
			}
			foreach (explode("\n", $row->des) as $des) {
				if($des){
					$pdf->MultiCell(0,6,$des,1,'L',0);
					
					if($pdf->GetY()>250){
						$pdf->AddPage();
						$pdf->SetFont('Times', '', 14);
						$pdf->Cell(0, 4, 'WORK FROM HOME REPORT', '' , 1, 'C');
			
						$pdf->SetFont('Times', '', 12);
						// $pdf->Cell(0, 4, $row->fordts." ".date("F Y", strtotime($dt)), '' , 1, 'C');
						$pdf->MultiCell(0,6, $row->fordts." ".date("F Y", strtotime($dt)),0,'C',0);
						$pdf->ln(6);
						$pdf->SetFont('Times', '', 12);
						$pdf->Cell(0, 5, 'LIST OF ACCOMPLISHMENTS', '' , 1, 'C');
					}
				}
			}
		}

		if($remarks){
			$pdf->ln(5);
			$pdf->MultiCell(0,6,"REMARKS:",0,'L',0);
			$pdf->MultiCell(0,6,$remarks,0,'J',0);
		}
			
		$pdf->ln(12);
		$pdf->Cell(80,6,"Submitted By:",'', 0, 'L');
		$pdf->Cell(30,6,"",'', 0, '');
		$pdf->Cell(80,6,"Noted By:",'', 1, 'L');
			
			
		$pos = "";
		$prepname = "";
		if($aby){
			$cbyqr = $this->db->query("SELECT position_desc, concat(firstname, ' ', concat(COALESCE(SUBSTRING(middlename, 1, 1), ''), '. '), lastname) as name FROM infosys.employee left join infosys.position_reference pr on position_reference_id = position_reference_position_reference_id WHERE employee_id = ".$aby);
			// var_dump($this->db->last_query());
			if($cbyqr->num_rows() > 0)
			{
				foreach($cbyqr->result() as $abyrows)
				{
					$prepname = $abyrows->name;
					$pos = $abyrows->position_desc;
				}
			}
		}else{
			if($this->session->userdata('section')==1){//no unit
				$pos = $this->session->userdata('divCode').' Chief';
				$prepname = $this->db->query("SELECT concat(firstname, ' ', concat(COALESCE(SUBSTRING(middlename, 1, 1), ''), '. '), lastname) as name FROM userlevel join users on users_users_id = users_id join employee on employee_employee_id = employee_id where userlevelref_userlevelref_id = 7 and division_division_id = ".$this->session->userdata('division')." order by userlevel_id desc limit 1")->row()->name;
			}else{
				$pos = $this->session->userdata('secCode').' Head';
				$prepname = $this->db->query("SELECT concat(firstname, ' ', concat(COALESCE(SUBSTRING(middlename, 1, 1), ''), '. '), lastname) as name FROM employee join unit on unit_head = employee_id where unit_id = ".$this->session->userdata('section')." order by employee_id desc limit 1")->row()->name;
			}
			if(in_array(34, $this->session->userdata('uroles'))){//head
				$prepname = $this->db->query("SELECT concat(firstname, ' ', concat(COALESCE(SUBSTRING(middlename, 1, 1), ''), '. '), lastname) as name FROM userlevel join users on users_users_id = users_id join employee on employee_employee_id = employee_id where userlevelref_userlevelref_id = 7 and division_division_id = ".$this->session->userdata('division')." order by userlevel_id desc limit 1")->row()->name;
				$pos = $this->session->userdata('divCode').' Chief';
				if($this->session->userdata('section')==17){
					$prepname = $this->db->query("SELECT concat(firstname, ' ', concat(COALESCE(SUBSTRING(middlename, 1, 1), ''), '. '), lastname) as name FROM userlevel join users on users_users_id = users_id join employee on employee_employee_id = employee_id where userlevelref_userlevelref_id = 35 order by userlevel_id desc limit 1")->row()->name;
					$pos = 'Deputy Director';
				}
			}
			if(in_array(7, $this->session->userdata('uroles'))){//chief
				$pos = 'Deputy Director';
				$prepname = $this->db->query("SELECT concat(firstname, ' ', concat(COALESCE(SUBSTRING(middlename, 1, 1), ''), '. '), lastname) as name FROM userlevel join users on users_users_id = users_id join employee on employee_employee_id = employee_id where userlevelref_userlevelref_id = 35 order by userlevel_id desc limit 1")->row()->name;
			}
			if(in_array(35, $this->session->userdata('uroles'))){//chief
				$pos = 'Director';
				$prepname = $this->db->query("SELECT concat(firstname, ' ', concat(COALESCE(SUBSTRING(middlename, 1, 1), ''), '. '), lastname) as name FROM userlevel join users on users_users_id = users_id join employee on employee_employee_id = employee_id where userlevelref_userlevelref_id = 4 order by userlevel_id desc limit 1")->row()->name;
			}
		}

		$pdf->ln(10);
		$pdf->Cell(80,6,strtoupper(utf8_decode($this->session->userdata('name'))),'', 0, 'C');
		$pdf->Cell(25,6,"",'', 0, '');
		$pdf->Cell(80,6,strtoupper(utf8_decode($prepname)),'', 1, 'C');

		$pdf->Cell(80,6,$this->session->userdata('posref'),'T', 0, 'C');
		$pdf->Cell(25,6,"",'', 0, '');
		$pdf->Cell(80,6,$pos,'T', 1, 'C');
		// $pdf->ln();
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(80,6,"Submitted: $dtS",'', 0, 'C');
		$pdf->Cell(25,6,"",'', 0, '');
		$pdf->Cell(80,6,"Approved: $dtA",'', 1, 'C');

		$pdf->SetAutoPageBreak(true);
		$pdf->Output();
	}

	public function printWFHReport($dt, $id){
		$dtS = $dtA = $empid = $aby = $remarks = "";
		$wfhs = $this->wfhmodel->getReporty($id);
		$this->load->library('fpdf_gen');
		$pdf = new FPDF('P','mm', 'A4');
		$pdf->SetTitle('WFH Report');
		$pdf->SetAutoPageBreak(false);

		$pdf->AddPage();

		$pdf->SetFont('Times', '', 14);
		$pdf->Cell(0, 4, 'WORK FROM HOME REPORT', '' , 1, 'C');

		foreach($wfhs as $row){
			$pdf->SetFont('Times', '', 12);
			// $pdf->Cell(0, 4, $row->fordts." ".date("F Y", strtotime($dt)), '' , 1, 'C');
			$pdf->MultiCell(0,6, $row->fordts." ".date("F Y", strtotime($dt)),0,'C',0);
			$pdf->ln(6);
			$pdf->SetFont('Times', '', 12);
			$pdf->Cell(0, 5, 'LIST OF ACCOMPLISHMENTS', '' , 1, 'C');

			if($row->id){
				$empid = $row->cby;
				$qrhisS = $this->db->query("SELECT DATE_FORMAT(statdt, '%m/%d/%Y') sdt FROM wfh.report_history WHERE status = 'Submitted' and wfhid = ".$row->id." order by statdt desc limit 1");
				foreach($qrhisS->result() as $rhisS)
					$dtS = $rhisS->sdt;
				$qrhisA = $this->db->query("SELECT DATE_FORMAT(statdt, '%m/%d/%Y') sdt, statby, remarks FROM wfh.report_history WHERE status = 'Approved' and wfhid = ".$row->id." order by statdt desc limit 1");
				foreach($qrhisA->result() as $rhisA){
					$dtA = $rhisA->sdt;
					$aby = $rhisA->statby;
					$remarks = $rhisA->remarks;
				}
			}
			foreach (explode("\n", $row->des) as $des) {
				if($des){
					$pdf->MultiCell(0,6,$des,1,'L',0);
				}
			}
		}
		if($remarks){
			$pdf->ln(5);
			$pdf->MultiCell(0,6,"REMARKS:",0,'L',0);
			$pdf->MultiCell(0,6,$remarks,0,'J',0);
		}
			
		$pdf->ln(12);
		$pdf->Cell(80,6,"Submitted By:",'', 0, 'L');
		$pdf->Cell(30,6,"",'', 0, '');
		$pdf->Cell(80,6,"Noted By:",'', 1, 'L');
			
			
		$pos = $prepname = $empname = $emppos = "";
		
		$query_result = $this->db->query("SELECT position_desc, concat(firstname, ' ', concat(COALESCE(SUBSTRING(middlename, 1, 1), ''), '. '), lastname) as name FROM infosys.employee left join infosys.position_reference pr on position_reference_id = position_reference_position_reference_id WHERE employee_id = ".$empid);
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$empname = utf8_decode($rows->name);
				$emppos = utf8_decode($rows->position_desc);
			}
		}
		$query_result = $this->db->query("SELECT position_desc, concat(firstname, ' ', concat(COALESCE(SUBSTRING(middlename, 1, 1), ''), '. '), lastname) as name FROM infosys.employee left join infosys.position_reference pr on position_reference_id = position_reference_position_reference_id WHERE employee_id = ".$aby);
		// var_dump($this->db->last_query());
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$prepname = $rows->name;
				$pos = $rows->position_desc;
			}
		}
		$pdf->ln(10);
		$pdf->Cell(80,6,strtoupper($empname),'', 0, 'C');
		$pdf->Cell(25,6,"",'', 0, '');
		$pdf->Cell(80,6,strtoupper($prepname),'', 1, 'C');

		$pdf->Cell(80,6,$emppos,'T', 0, 'C');
		$pdf->Cell(25,6,"",'', 0, '');
		$pdf->Cell(80,6,$pos,'T', 1, 'C');
		// $pdf->ln();
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(80,6,"Submitted: $dtS",'', 0, 'C');
		$pdf->Cell(25,6,"",'', 0, '');
		$pdf->Cell(80,6,"Approved: $dtA",'', 1, 'C');

		$pdf->SetAutoPageBreak(true);
		$pdf->Output();
	}

	function getWFHDates()
	{
		$this->output->set_content_type("application/json")->set_output(json_encode($this->wfhmodel->getWFHDates()));
	}
}
