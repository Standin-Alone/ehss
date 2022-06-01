<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eprint extends CI_Controller {

	/**
	 * Example: FPDF 
	 *
	 * Documentation: 
	 * http://www.fpdf.org/ > Maanual
	 *
	 */
	public function index(){
		$data['menu'] = "epayslip";
		$data['gmenu'] = "payment";

		$this->load->view('template/header', $data);
		$this->load->view('cash/payslip');
		$this->load->view('template/footer');
	}

	public function view(){
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->payslipmodel->index()));
	}

	public function slip($mpayid) {
		$Sql_Empl = "SELECT e.employee_id, e.empno, esl.status empl_type, pl.item_number projno,
							e.lastname, e.firstname, e.middlename, e.name_extension nameext,
							ps.salary_grade emplsg, p.step_type emplsgstep, pr.position_code, pr.position_desc,
                            e.taxexmp, pl.item_number posid, pr.position_desc posdes,
							mp.emplid, mp.saldate, mp.paycat, mp.salary, mp.pera,
							mp.addlcomp, mp.grsalary, mp.wtax, mp.gsis, mp.phlhealth,
							mp.pagibig, mp.salaryded, mp.peraded, mp.addlcompded,
							mp.totalded, mp.netsalary, pc.paycatcod paycat, pc.catdesc,
							mp.mpayid, mp.lwop, mp.ut, mp.al_hazard, mp.al_subs, mp.al_laundry, mp.al_longevity, mp.netbasicsal, mp.nethazard, mp.netlongi, mp.al_rata, mp.netsaltaxable, mp.netsala, mp.hazardwtax, mp.longiwtax, mp.sala, mp.saladed, mp.actlhazpay, mp.netsalwtax, mp.hazpaydis, concat(lastname, ', ', firstname, ' ', coalesce(substr(middlename,0,1),''), coalesce(name_extension,'')) fullname
					FROM infosys.employee e
					left join infosys.employment_status_library esl on e.employment_status_library_employment_status_library_id = esl.employment_status_library_id
					left join infosys.plantilla p on e.employee_id = p.employee_employee_id
					left join infosys.plantilla_library pl on p.plantilla_library_plantilla_library_id = pl.plantilla_library_id
					left join infosys.plantilla_salary ps on pl.plantilla_salary_plantilla_salary_id = ps.plantilla_salary_id
					left join infosys.position_reference pr on pl.position_reference_position_reference_id = pr.position_reference_id
					left join payroll_sbg.monthlypay mp on e.employee_id = mp.emplid
					left join payroll_sbg.paycategory pc on mp.paycat = pc.paycatid
					WHERE mp.mpayid = '$mpayid'";

		$query_result = $this->db->query($Sql_Empl);
		$result = array();
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$saldate = $rows->saldate;
				$id = $rows->employee_id;
				$my = date('F Y', strtotime($saldate));
				$this->load->library('fpdf_master');
				$pdf = new FPDF('P','mm',array('100','120'));
				$pdf->AddPage();
				$pdf->SetFont('Arial','',5);
				$image1 = "assets/pnri_logo_trans.gif";
				$pdf->Cell(1, 1, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 10), 0, 0, 'L', false );
				$pdf->SetFont('Arial','B',5);$pdf->Cell(80,2,'PHILIPPINE NUCLEAR RESEARCH INSTITUTE','',1,'C',0);
				$pdf->SetFont('Arial','',5);$pdf->Cell(80,2,'Department of Science and Technology','',1,'C',0);
				$pdf->Cell(80,2,'Republic of the Philippines','',1,'C',0);
				$pdf->Cell(80,2,'------------------------------------------------------------','',1,'C',0);
				$pdf->Cell(80,2,'P A Y S L I P','',1,'C',0);
				$pdf->Cell(80,2,'------------------------------------------------------------','',1,'C',0);
				$l = '';
				$pdf->ln();

				$pdf->SetFont('Arial','B',5);$pdf->Cell(10,2,'Name:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(35,2, strtoupper($rows->fullname),$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(15,2,'Salary Date:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(20,2, $my,$l,0,'L',0);
				$pdf->ln();
				$pdf->SetFont('Arial','B',5);$pdf->Cell(10,2,'Position:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(35,2, $rows->position_desc,$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(15,2,'Salary Grade:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(20,2, $rows->emplsg,$l,0,'L',0);
				$pdf->ln();
				$pdf->SetFont('Arial','B',5);$pdf->Cell(12,2,'Department:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(63,2, $rows->catdesc,$l,0,'L',0);
				$pdf->ln(4);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(40,2,'Gross Salary & Allowances:',$l,0,'L',0);
				$pdf->Cell(40,2,'Deductions:',$l,0,'L',0);
				$pdf->ln();

				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(20,2,'Salary:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'P',$l,0,'L',0);
				$pdf->Cell(10,2, number_format($rows->salary, 2),$l,0,'R',0);
				$pdf->Cell(4,2,'',$l,0,'L',0);

				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(35,2,'Withholding Tax:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->ln();

				$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(20,2,'PERA:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($rows->pera, 2),$l,0,'R',0);
				$pdf->Cell(4,2,'',$l,0,'L',0);

				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->Cell(22,2,'  - Salary:',$l,0,'L',0);
				$pdf->Cell(3,2,'P',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($rows->netsalwtax, 2),$l,0,'R',0);
				$pdf->ln();

				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(20,2,'SALA:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($rows->sala, 2),$l,0,'R',0);
				$pdf->Cell(4,2,'',$l,0,'L',0);

				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->Cell(22,2,'  - Hazard Pay:',$l,0,'L',0);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($rows->hazardwtax, 2),$l,0,'R',0);
				$pdf->ln();

				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(20,2,'Hazard:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($rows->actlhazpay, 2),$l,0,'R',0);
				$pdf->Cell(4,2,'',$l,0,'L',0);

				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->Cell(22,2,'  - Longevity Pay:',$l,0,'L',0);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($rows->longiwtax, 2),$l,0,'R',0);
				$pdf->ln();

				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(20,2,'Longevity:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($rows->al_longevity, 2),$l,0,'R',0);
				$pdf->Cell(4,2,'',$l,0,'L',0);

				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(22,2,'GSIS Premium:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($rows->gsis, 2),$l,0,'R',0);
				$pdf->ln();

				$pdf->SetFont('Arial','B',5);$pdf->Cell(23,2,'Total Gross Salary:',$l,0,'L',0);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(10,2,'',$l,0,'R',0);
				$pdf->Cell(4,2,'',$l,0,'L',0);

				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->Cell(22,2,'Philhealth:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($rows->phlhealth, 2),$l,0,'R',0);
				$pdf->ln();

				$ttlGrossPay = $rows->salary + $rows->pera + $rows->sala + $rows->al_longevity + $rows->actlhazpay;
				$pdf->SetFont('Arial','B',5);$pdf->Cell(23,2,' & Allowances:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'P',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($ttlGrossPay, 2),$l,0,'R',0);
				$pdf->Cell(4,2,'',$l,0,'L',0);

				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(22,2,'Pag-ibig:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($rows->pagibig, 2),$l,0,'R',0);
				$pdf->ln();

				$pdf->Cell(40,2,'',$l,0,'L',0);

				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(22,2,'SALA:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($rows->saladed, 2),$l,0,'R',0);
				$pdf->ln();

				$HazardPayLWOP = $rows->actlhazpay - $rows->al_hazard;

				$pdf->Cell(40,2,'',$l,0,'L',0);
				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(22,2,'Hazard:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($HazardPayLWOP, 2),$l,0,'R',0);
				$pdf->ln();
				$EmplSaLaDed = $rows->sala - $rows->netsala;
				$EmplTotalDed = $rows->totalded + $EmplSaLaDed + $HazardPayLWOP;


				if ($rows->salaryded != 0) {
					$pdf->Cell(40,2,'',$l,0,'L',0);
					$pdf->Cell(5,2,'',$l,0,'L',0);
					$pdf->SetFont('Arial','B',5);$pdf->Cell(22,2,'LWOP Salary:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
					$pdf->Cell(3,2,'',$l,0,'L',0);
					$pdf->Cell(10,2,number_format($rows->salaryded, 2),$l,0,'R',0);
					$pdf->ln();
				}

				if ($rows->peraded != 0) {
					$pdf->Cell(40,2,'',$l,0,'L',0);
					$pdf->Cell(5,2,'',$l,0,'L',0);
					$pdf->SetFont('Arial','B',5);$pdf->Cell(22,2,'LWOP PERA:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
					$pdf->Cell(3,2,'',$l,0,'L',0);
					$pdf->Cell(10,2,number_format($rows->peraded, 2),$l,0,'R',0);
					$pdf->ln();
				}

				//LOANS:
				$qrloan = $this->db->query("SELECT monthlypayded.empid, monthlypayded.dedcod, monthlypayded.dedamount, loanded.coddes,
										 loanded.description, monthlypayded.saldate
									 FROM payroll_sbg.monthlypayded, payroll_sbg.loanded
									 WHERE monthlypayded.empid = $id AND monthlypayded.dedcod = loanded.coddes
									 AND monthlypayded.saldate = '$saldate'");
				if($qrloan->num_rows() > 0)
				{
					$pdf->Cell(45,2,'',$l,0,'L',0);
					$pdf->SetFont('Arial','B',5);$pdf->Cell(40,2,'Loans:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
					$pdf->ln();
					foreach($qrloan->result() as $loan)
					{
						$pdf->Cell(40,2,'',$l,0,'L',0);

						$pdf->SetFont('Arial','',4.5);
						$pdf->Cell(5,2,'',$l,0,'L',0);
						$pdf->Cell(22,2,'  - '.$loan->description.':',$l,0,'L',0);
						$pdf->Cell(3,2,'',$l,0,'L',0);
						// $pdf->SetFont('Arial','',5);
						$pdf->Cell(10,2,number_format($loan->dedamount, 2),$l,0,'R',0);
						$pdf->ln();
						switch ($loan->coddes) {
							case 'MCSL':
							case 'RHPDIS':
							case 'MCLL':
							case 'MCHL':
								$EmplTotalDed = $EmplTotalDed + $loan->dedamount;
								break;
							default:
								break;
						}
					}
				}

				$pdf->SetFont('Arial','',5);
				//END LOANS
				$pdf->Cell(40,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(27,2,'Total Deductions:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'P',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($EmplTotalDed, 2),$l,0,'R',0);
				$pdf->ln();

				$pdf->SetFont('Arial','B',5);$pdf->Cell(80,2,'REMARKS:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->ln();
				if (!empty($rows->lwop)) {
					$pdf->Cell(80,2,'Absence(s): '.$rows->lwop,$l,0,'L',0);
					$pdf->ln();
				}
		  		if (!empty($rows->ut)) {
					$pdf->Cell(80,2,'Late(s): '.$rows->ut,$l,0,'L',0);
					$pdf->ln();
				}
				$pdf->Cell(40,2,'',$l,0,'L',0);
				$pdf->ln();

				$EmplNetAllowances = $rows->netsala + $rows->nethazard + $rows->netlongi;
				$EmplTakeHomePay = $rows->netbasicsal + $EmplNetAllowances;

				$BiNetSalary = $rows->netbasicsal / 2;
				$nBiNetSalary = number_format($BiNetSalary, 3, '.', '');
				$oBiNetSalary = explode(".", $nBiNetSalary);
				$pBiNetSalary = $oBiNetSalary[0];
				$qBiNetSalary = $oBiNetSalary[1];
				$rBiNetSalary = substr($qBiNetSalary, -1);
				if ($rBiNetSalary == 5) {
					$unBiNetSalary = $nBiNetSalary + 0.005;
					$tnBiNetSalary = $nBiNetSalary - 0.005;
					$uBiNetSalary = number_format($unBiNetSalary, 2);
					$tBiNetSalary = number_format($tnBiNetSalary, 2);

				} else {
					$unBiNetSalary = $nBiNetSalary;
					$tnBiNetSalary = $nBiNetSalary;
					$uBiNetSalary = number_format($unBiNetSalary, 2);
					$tBiNetSalary = number_format($tnBiNetSalary, 2);
				}

				$pdf->SetFont('Arial','B',5);$pdf->Cell(23,2,'Total Net Salary:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'P',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($rows->netbasicsal, 2),$l,0,'R',0);
				$pdf->Cell(4,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(40,2,'1st Half:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->ln();

				$pdf->SetFont('Arial','B',5);$pdf->Cell(23,2,'Total Net Allowances:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'P',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($EmplNetAllowances, 2),$l,0,'R',0);
				$pdf->Cell(4,2,'',$l,0,'L',0);

				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(22,2,'Salary 1st Period:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'P',$l,0,'L',0);
				$pdf->Cell(10,2,$uBiNetSalary,$l,0,'R',0);
				$pdf->ln();

				$pdf->SetFont('Arial','B',5);$pdf->Cell(23,2,'Total Take Home Pay:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'P',$l,0,'L',0);
				$pdf->Cell(10,2,number_format($EmplTakeHomePay, 2),$l,0,'R',0);
				$pdf->Cell(4,2,'',$l,0,'L',0);

				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(22,2,'SALA:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'P',$l,0,'L',0);
				$pdf->Cell(10,2,number_format(($rows->netsala), 2),$l,0,'R',0);
				$pdf->ln();
				$pdf->Cell(40,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(40,2,'2nd Half:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->ln();

				$pdf->Cell(40,2,'',$l,0,'L',0);
				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(22,2,'Salary 2nd Period:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'P',$l,0,'L',0);
				$pdf->Cell(10,2,$tBiNetSalary,$l,0,'R',0);
				$pdf->ln();

				$pdf->Cell(40,2,'',$l,0,'L',0);
				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(22,2,'Hazard:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'P',$l,0,'L',0);
				$pdf->Cell(10,2,number_format(($rows->nethazard), 2),$l,0,'R',0);
				$pdf->ln();

				$pdf->Cell(40,2,'',$l,0,'L',0);

				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->SetFont('Arial','B',5);$pdf->Cell(22,2,'Longevity:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->Cell(3,2,'P',$l,0,'L',0);
				$pdf->Cell(10,2,number_format(($rows->netlongi), 2),$l,0,'R',0);
				$pdf->ln();


				$SqlSig = "SELECT s.sigid, s.sigstat, s.sigtype, e.employee_id emplid, e.lastname,
								  e.firstname, e.middlename, pl.item_number projno, pl.item_number posid, pr.position_desc posdes
								  FROM payroll_sbg.signatory s
							join infosys.employee e on s.empsig = e.employee_id
							left join infosys.plantilla p on e.employee_id = p.employee_employee_id
							left join infosys.plantilla_library pl on p.plantilla_library_plantilla_library_id = pl.plantilla_library_id
							left join infosys.position_reference pr on pl.position_reference_position_reference_id = pr.position_reference_id
							WHERE s.sigtype='2' AND s.sigstat='1'";

				$SigName = $SigPos = '';
				$query_SqlSig = $this->db->query($SqlSig);
				if($query_SqlSig->num_rows() > 0)
				{
					foreach($query_SqlSig->result() as $rows)
					{
						$SigPos = $rows->posdes;
						$SigName = $rows->firstname." ".substr($rows->middlename,0,1)."."." ".$rows->lastname;
					}
				}

				$pdf->SetFont('Arial','B',5);$pdf->Cell(80,2,'Noted by:',$l,0,'L',0);$pdf->SetFont('Arial','',5);
				$pdf->ln(6);
				$pdf->SetFont('Arial','',5);
				$pdf->Cell(40,2,strtoupper($SigName ? $SigName : "SUSAN S. PASCUAL"),$l,0,'C',0);
				$pdf->ln();
				$pdf->SetFont('Arial','');
				$pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->Cell(30,2,$SigPos ? $SigPos : "Administrative Officer V",'T',0,'C',0);
				// $pdf->Cell(5,2,'',$l,0,'L',0);
				$pdf->ln();


			}
		}

		echo $pdf->Output('payslip.pdf','I');	
	}
	
	function sendPayslip1(){
		// $saldate = '2020-06-01';
		// $saldate = $_POST['dt'];
		// $ftr = (int) $_POST['id'] > 0 ? " and employee_id = ".$_POST['id'] : "";// and employee_id in (324, 178, 409, 355, 179)
		// $my = date('F Y', strtotime($saldate));
	    $config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => 'smtp.office365.com',
		    'smtp_port' => 587,
		    'smtp_user'    => 'cs.fad@pnri.dost.gov.ph',
			'smtp_pass'    => 'c@$H!234',
			'smtp_crypto' => 'tls',
		    'mailtype'  => 'html',
		    'charset'  => 'iso-8859-1',
		    'wordwrap'   => TRUE
		);

		$this->load->library('email', $config);
		$message = $mlog = $res = "";
		$FromEmail = 'cs.fad@pnri.dost.gov.ph'; 
		$FromUser = 'FAD Cashier';
		$emailLogData = Array();
		$mailSubject = 'PNRI InfoSys - ePayslip';
		$emailLogData['E_SUBJECT'] = $mailSubject;
		$hd = "<html><body>";
		$ft = "<small><i>* This is a system generated message<br>
							* If you have questions regarding your payslip, you may call us at (+632) 929-6011 to 19 local 241 - 242 or email us at cs.fad@pnri.dost.gov.ph. <br>
							* This email is strictly confidential and may be legally protected. If you are not the intended recipient, kindly notify us at mis@pnri.dost.gov.ph, delete permanently and do not forward, copy or print any of the contents.</i></small><br><br>

							<center><b>CONNECT WITH PNRI</b><br><a href='https://www.facebook.com/PNRIDOST'><img src='".base_url('assets/fb.png')."' alt='Facebook'></a><a href='https://www.pnri.dost.gov.ph/'><img src='".base_url('assets/web.png')."' alt='Website'></a></center></body></html>";

		
		$this->email->clear(TRUE);
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->set_crlf("\r\n");
		$this->email->from($FromEmail, $FromUser);
		$this->email->subject($mailSubject); 
		$message = $hd."Dear ".$this->session->userdata('name').",<br><br>
					Greetings!<br>
					Please see the attached payslip.<br><br>
					Sincerely,<br>
					FAD Cashier<br><br>".$ft;
		if(strpos($this->session->userdata('empMail'), '@') !== false){
			$this->email->to($this->session->userdata('empMail'));
	        $this->email->attach(base_url('cash/Eprint/slip/'.$_POST['id']), 'attachment', 'payslip.pdf');

			$statusMessage = ""; $emailLogMessage = "";
			$this->email->message($message);
			$res = $this->email->send(FALSE);
		}
		$mlog .= $this->session->userdata('empMail').' '.$res.'<br>';
		header("Content-Type: application/json", true);
		echo json_encode($mlog);
	}
}
