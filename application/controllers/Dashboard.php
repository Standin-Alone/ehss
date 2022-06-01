<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{
	public function __construct() {
	    parent::__construct();
		if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
			redirect('access/');
	}

	public function index(){
		$data['menu'] = "dashboard";
		$data['gmenu'] = "";
		$this->load->view('template/header', $data);
		$this->load->view('dashboard');
		$this->load->view('template/footer');
	}

	public function extra_error(){
		$data['menu'] = "dashboard";
		$data['gmenu'] = "";
		$this->load->view('errors/extra_404');
	}


	public function printReport1(){
		$dt = date('F d, Y');
		$this->load->library('fpdf_gen');
		$pdf = new FPDF('L','mm', 'A4');
		$pdf->SetMargins(20, 20, 20);
		$pdf->SetTitle('DOST-PNRI Manpower');
		$pdf->SetAutoPageBreak(false);
		$pdf->AddFont('Calibri','','calibri.php');
		$pdf->SetFont('Calibri', 'B', 12);
		$this->addpageAgeSex($pdf, 1, 'Table 1. Distribution of Plantilla Personnel of the DOST System by Agency, Age Group, and Sex as of '.$dt);
		$this->addpageEduc($pdf, 1, 'Table 2. Distribution of Plantilla Personnel of the DOST System by Agency and Educational Attainment as of '.$dt);
		$this->addpageAgeSex($pdf, 0, 'Table 3. Distribution of Non-Permanent Personnel of the DOST System by Agency, Age Group, and Sex as of '.$dt);
		$this->addpageEduc($pdf, 0, 'Table 4. Distribution of Non-Permanent Personnel of the DOST System by Agency and Educational Attainment as of '.$dt);
		$pdf->Output('','DOST-PNRI Manpower '.date('Y-m-d').'.pdf');
		// $pdf->Output();
	}
	
	public function addpageAgeSex($pdf, $stat, $title){
		$sqlM = "SELECT SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) < 21,1,0)) as 'a20',
						SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 21 and 30,1,0)) as 'a30',
						SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 31 and 40,1,0)) as 'a40',
						SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 41 and 50,1,0)) as 'a50',
						SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 51 and 60,1,0)) as 'a60',
						SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) > 60,1,0)) as 'a61'
					FROM employee WHERE employment_status_library_employment_status_library_id not in (1,11,12,13,14,17,20) and gender = 'M'";
		$sqlF = "SELECT SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) < 21,1,0)) as 'a20',
						SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 21 and 30,1,0)) as 'a30',
						SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 31 and 40,1,0)) as 'a40',
						SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 41 and 50,1,0)) as 'a50',
						SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 51 and 60,1,0)) as 'a60',
						SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) > 60,1,0)) as 'a61'
					FROM employee WHERE employment_status_library_employment_status_library_id not in (1,11,12,13,14,17,20) and gender = 'F'";
		if($stat){
			$sqlM = "SELECT SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) < 21,1,0)) as 'a20',
							SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 21 and 30,1,0)) as 'a30',
							SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 31 and 40,1,0)) as 'a40',
							SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 41 and 50,1,0)) as 'a50',
							SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 51 and 60,1,0)) as 'a60',
							SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) > 60,1,0)) as 'a61'
						FROM employee WHERE employment_status_library_employment_status_library_id = 1 and gender = 'M'";
			$sqlF = "SELECT SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) < 21,1,0)) as 'a20',
							SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 21 and 30,1,0)) as 'a30',
							SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 31 and 40,1,0)) as 'a40',
							SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 41 and 50,1,0)) as 'a50',
							SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 51 and 60,1,0)) as 'a60',
							SUM(IF(TIMESTAMPDIFF(YEAR, birthday, CURDATE()) > 60,1,0)) as 'a61'
						FROM employee WHERE employment_status_library_employment_status_library_id = 1 and gender = 'F'";
		}
		
		$m = $this->employeemodel->getRecord($sqlM)->result_array()[0];
		$f = $this->employeemodel->getRecord($sqlF)->result_array()[0];
		$pdf->AddPage();
			$x = 0;
			$ystart = $pdf->getY();
			$pdf->SetFont('Calibri', 'B', 12);
			$pdf->Cell(0, 4, 'Philippine Nuclear Research Institute', '' , 1, 'L');
			$pdf->ln(1);
			$pdf->Cell(0, 4, 'PERFORMANCE INDICATOR TABLES FOR DOST S&T PERSONNEL PROFILE', '' , 1, 'C');
			$pdf->ln(6);
			$pdf->SetFont('Calibri', '', 11);
			$pdf->Cell(20, 4, '', '' , 0, 'L');
			$pdf->Cell(20, 4, $title, '' , 1, 'L');
			$pdf->ln(5);
			$pdf->Cell(20, 5, '', '', 0, 'C');
			$pdf->Cell(40, 15, 'Agency', '1', 0, 'C');
			$pdf->Cell(50, 15, ' Age Group', '1', 0, 'C');
			$pdf->Cell(80, 5, ' Sex', '1', 0, 'C');
			$pdf->Cell(40, 10, 'Total', '1', 0, 'C');

			$pdf->ln(5);
			$y = $pdf->getY();
			$pdf->Cell(20, 5, '', '', 0, 'C');
			$pdf->Cell(40, 5, '', '', 0, 'C');
			$pdf->Cell(50, 5, '', '', 0, 'C');
			$pdf->Cell(80, 5, '', '', 0, 'C');
			$pdf->Cell(40, 5, '', '', 0, 'C');

			$pdf->setY($y);
			$pdf->Cell(110);
			$pdf->Cell(40, 5, 'Male', 'LTR', 0, 'C');
			$pdf->Cell(40, 5, 'Female', 'LTR', 0, 'C');
			$pdf->Cell(40, 10, '', '', 0, 'C');
			$pdf->Cell(40, 5, '', '', 1, 'C');

			$pdf->Cell(110);
			$pdf->Cell(20, 5, 'No.', '1', 0, 'C');
			$pdf->Cell(20, 5, '%', '1', 0, 'C');
			$pdf->Cell(20, 5, 'No.', '1', 0, 'C');
			$pdf->Cell(20, 5, '%', '1', 0, 'C');
			$pdf->Cell(20, 5, 'No.', '1', 0, 'C');
			$pdf->Cell(20, 5, '%', '1', 0, 'C');

			$pdf->ln(5);
			$pdf->Cell(20, 5, '', '', 0, 'C');
			$pdf->Cell(40, 5, '', 'LR', 0, 'C');
			$pdf->Cell(50, 5, '20 years old and below', '1', 0, 'L');
			$pdf->Cell(20, 5, $m['a20'], '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($m['a20'] / ($m['a20']+$f['a20'])) * 100),2), '1', 0, 'R');
			$pdf->Cell(20, 5, $f['a20'], '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($f['a20'] / ($m['a20']+$f['a20'])) * 100),2), '1', 0, 'R');
			$pdf->Cell(20, 5, ($m['a20']+$f['a20']), '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($m['a20']+$f['a20']) / (array_sum($m)+array_sum($f))) * 100, 2), '1', 0, 'R');

			$pdf->ln(5);
			$pdf->Cell(20, 5, '', '', 0, 'C');
			$pdf->Cell(40, 5, '', 'LR', 0, 'C');
			$pdf->Cell(50, 5, '21-30 years old', '1', 0, 'L');
			$pdf->Cell(20, 5, $m['a30'], '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($m['a30'] / ($m['a30']+$f['a30'])) * 100),2), '1', 0, 'R');
			$pdf->Cell(20, 5, $f['a30'], '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($f['a30'] / ($m['a30']+$f['a30'])) * 100),2), '1', 0, 'R');
			$pdf->Cell(20, 5, ($m['a30']+$f['a30']), '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($m['a30']+$f['a30']) / (array_sum($m)+array_sum($f))) * 100, 2), '1', 0, 'R');

			$pdf->ln(5);
			$pdf->Cell(20, 5, '', '', 0, 'R');
			$pdf->Cell(40, 5, '', 'LR', 0, 'R');
			$pdf->Cell(50, 5, '31-4 years old', '1', 0, 'L');
			$pdf->Cell(20, 5, $m['a40'], '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($m['a40'] / ($m['a40']+$f['a40'])) * 100),2), '1', 0, 'R');
			$pdf->Cell(20, 5, $f['a40'], '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($f['a40'] / ($m['a40']+$f['a40'])) * 100),2), '1', 0, 'R');
			$pdf->Cell(20, 5, ($m['a40']+$f['a40']), '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($m['a40']+$f['a40']) / (array_sum($m)+array_sum($f))) * 100, 2), '1', 0, 'R');

			$pdf->ln(5);
			$pdf->Cell(20, 5, '', '', 0, 'C');
			$pdf->Cell(40, 5, '', 'LR', 0, 'C');
			$pdf->Cell(50, 5, '41-50 years old', '1', 0, 'L');
			$pdf->Cell(20, 5, $m['a50'], '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($m['a50'] / ($m['a50']+$f['a50'])) * 100),2), '1', 0, 'R');
			$pdf->Cell(20, 5, $f['a50'], '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($f['a50'] / ($m['a50']+$f['a50'])) * 100),2), '1', 0, 'R');
			$pdf->Cell(20, 5, ($m['a50']+$f['a50']), '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($m['a50']+$f['a50']) / (array_sum($m)+array_sum($f))) * 100, 2), '1', 0, 'R');

			$pdf->ln(5);
			$pdf->Cell(20, 5, '', '', 0, 'R');
			$pdf->Cell(40, 5, '', 'LR', 0, 'R');
			$pdf->Cell(50, 5, '51-60 years old', '1', 0, 'L');
			$pdf->Cell(20, 5, $m['a60'], '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($m['a60'] / ($m['a60']+$f['a60'])) * 100),2), '1', 0, 'R');
			$pdf->Cell(20, 5, $f['a60'], '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($f['a60'] / ($m['a60']+$f['a60'])) * 100),2), '1', 0, 'R');
			$pdf->Cell(20, 5, ($m['a60']+$f['a60']), '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($m['a60']+$f['a60']) / (array_sum($m)+array_sum($f))) * 100, 2), '1', 0, 'R');

			$pdf->ln(5);
			$pdf->Cell(20, 5, '', '', 0, 'R');
			$pdf->Cell(40, 5, '', 'LR', 0, 'R');
			$pdf->Cell(50, 5, '61 years old and over', '1', 0, 'L');
			$pdf->Cell(20, 5, $m['a61'], '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($m['a61'] / ($m['a61']+$f['a61'])) * 100),2), '1', 0, 'R');
			$pdf->Cell(20, 5, $f['a61'], '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($f['a61'] / ($m['a61']+$f['a61'])) * 100),2), '1', 0, 'R');
			$pdf->Cell(20, 5, ($m['a61']+$f['a61']), '1', 0, 'R');
			$pdf->Cell(20, 5, 0 + number_format((($m['a61']+$f['a61']) / (array_sum($m)+array_sum($f))) * 100, 2), '1', 0, 'R');

			$pdf->ln(5);
			$pdf->Cell(20, 5, '', '', 0, 'R');
			$pdf->Cell(40, 5, '', 'LRB', 0, 'R');
			$pdf->Cell(50, 5, 'TOTAL', '1', 0, 'R');
			$pdf->Cell(20, 5, array_sum($m), '1', 0, 'R');
			$pdf->Cell(20, 5, '100%', '1', 0, 'R');
			$pdf->Cell(20, 5, array_sum($f), '1', 0, 'R');
			$pdf->Cell(20, 5, '100%', '1', 0, 'R');
			$pdf->Cell(20, 5, array_sum($m)+array_sum($f), '1', 0, 'R');
			$pdf->Cell(20, 5, '100%', '1', 0, 'R');

			$pdf->ln(10);
			$pdf->Cell(20, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Prepared by:', '' , 0, 'L');
			$pdf->Cell(70, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Noted by:', '' , 1, 'L');

			$pdf->ln(10);
			$pdf->Cell(20, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, '', 'B' , 0, 'L');
			$pdf->Cell(70, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, '', 'B' , 1, 'L');
			// $pdf->ln(5);
			$pdf->Cell(20, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Ma. Nadia D. Estaris', '' , 0, 'L');
			$pdf->Cell(70, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Maria Celerina M. Ramiro', '' , 1, 'L');

			$pdf->Cell(20, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Administrative Officer IV', '' , 0, 'L');
			$pdf->Cell(70, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Chief', '' , 1, 'L');

			$pdf->Cell(20, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'HRMRCS-FAD', '' , 0, 'L');
			$pdf->Cell(70, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Finance and Administrative Division', '' , 1, 'L');

		
	}
	
	public function addpageEduc($pdf, $stat, $title){
		$sec = $voc = $col = $post = $ms = $doc = $tot = 0;
		$sql = "SELECT (select level from education where employee_employee_id=employee_id ORDER by end_date desc, year_graduated desc limit 1) maxeduc FROM employee WHERE employment_status_library_employment_status_library_id not in (1,11,12,13,14,17,20)";
		if($stat){
			$sql = "SELECT (select level from education where employee_employee_id=employee_id ORDER by end_date desc, year_graduated desc limit 1) maxeduc FROM employee WHERE employment_status_library_employment_status_library_id = 1";
		}
		$query_result = $this->db->query($sql);
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				switch($rows->maxeduc){
					case "Graduate Studies":
					case "PhD":
						$doc++;
						break;
					case "MS/MA":
						$ms++;
						break;
					case "Post BA/BS":
						$post++;
						break;
					case "College":
						$col++;
						break;
					case "Vocational":
						$voc++;
						break;
					case "Secondary":
					case "Elementary":
						$sec++;
						break;
					default:
						$sec++;
				}
			}
		}else
			return 0;
		$tot = $elem + $sec + $voc + $col + $post + $ms + $doc;
		$pdf->AddPage();
			$x = 0;
			$ystart = $pdf->getY();
			$pdf->SetFont('Calibri', 'B', 12);
			$pdf->Cell(0, 4, 'Philippine Nuclear Research Institute', '' , 1, 'L');
			$pdf->ln(1);
			$pdf->Cell(0, 4, 'PERFORMANCE INDICATOR TABLES FOR DOST S&T PERSONNEL PROFILE', '' , 1, 'C');
			$pdf->ln(6);
			$pdf->SetFont('Calibri', '', 11);
			$pdf->Cell(20, 4, '', '' , 0, 'L');
			$pdf->Cell(20, 4, $title, '' , 1, 'L');
			$pdf->ln(5);
			$pdf->SetFont('Calibri', '', 9);
			$pdf->Cell(15, 15, '', 'LT', 0, 'C');
			$pdf->Cell(180, 5, 'Educational Attainment', '1', 0, 'C');
			$pdf->Cell(30, 10, 'Total', 'LTR', 0, 'C');
			$pdf->ln(5);

			$pdf->Cell(15, 5, 'Agency', 'L', 0, 'C');
			$pdf->Cell(30, 5, 'PhD', '1', 0, 'C');
			$pdf->Cell(30, 5, 'MS/MA', '1', 0, 'C');
			$pdf->Cell(30, 5, 'Post BS/BA', '1', 0, 'C');
			$pdf->Cell(30, 5, 'BS/BA', '1', 0, 'C');
			$pdf->Cell(30, 5, 'Post High School', '1', 0, 'C');
			$pdf->Cell(30, 5, 'High School and Below', '1', 0, 'C');
			$pdf->Cell(30, 5, '', 'LRB', 0, 'C');

			$pdf->ln(5);
			$y = $pdf->getY();
			$pdf->Cell(20, 5, '', '', 0, 'C');
			$pdf->Cell(40, 5, '', '', 0, 'C');
			$pdf->Cell(50, 5, '', '', 0, 'C');
			$pdf->Cell(80, 5, '', '', 0, 'C');
			$pdf->Cell(40, 5, '', '', 0, 'C');

			$pdf->setY($y);
			$pdf->Cell(15, 5, '', 'B', 0, 'C');
			$pdf->Cell(15, 5, 'No.', '1', 0, 'C');
			$pdf->Cell(15, 5, '%', '1', 0, 'C');
			$pdf->Cell(15, 5, 'No.', '1', 0, 'C');
			$pdf->Cell(15, 5, '%', '1', 0, 'C');
			$pdf->Cell(15, 5, 'No.', '1', 0, 'C');
			$pdf->Cell(15, 5, '%', '1', 0, 'C');
			$pdf->Cell(15, 5, 'No.', '1', 0, 'C');
			$pdf->Cell(15, 5, '%', '1', 0, 'C');
			$pdf->Cell(15, 5, 'No.', '1', 0, 'C');
			$pdf->Cell(15, 5, '%', '1', 0, 'C');
			$pdf->Cell(15, 5, 'No.', '1', 0, 'C');
			$pdf->Cell(15, 5, '%', '1', 0, 'C');
			$pdf->Cell(15, 5, 'No.', '1', 0, 'C');
			$pdf->Cell(15, 5, '%', '1', 1, 'C');

			$pdf->Cell(15, 5, '', '1', 0, 'R');
			$pdf->Cell(15, 5, $doc, '1', 0, 'R');
			$pdf->Cell(15, 5, number_format((($doc / $tot) * 100),2) + 0, '1', 0, 'R');
			$pdf->Cell(15, 5, $ms, '1', 0, 'R');
			$pdf->Cell(15, 5, number_format((($ms / $tot) * 100),2) + 0, '1', 0, 'R');
			$pdf->Cell(15, 5, $post, '1', 0, 'R');
			$pdf->Cell(15, 5, number_format((($post / $tot) * 100),2) + 0, '1', 0, 'R');
			$pdf->Cell(15, 5, $col, '1', 0, 'R');
			$pdf->Cell(15, 5, number_format((($col / $tot) * 100),2) + 0, '1', 0, 'R');
			$pdf->Cell(15, 5, $voc, '1', 0, 'R');
			$pdf->Cell(15, 5, number_format((($voc / $tot) * 100),2) + 0, '1', 0, 'R');
			$pdf->Cell(15, 5, $sec, '1', 0, 'R');
			$pdf->Cell(15, 5, number_format((($sec / $tot) * 100),2) + 0, '1', 0, 'R');
			$pdf->Cell(15, 5, $tot, '1', 0, 'R');
			$pdf->Cell(15, 5, '', '1', 0, 'R');

			$pdf->SetFont('Calibri', '', 11);
			$pdf->ln(10);
			$pdf->Cell(20, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Prepared by:', '' , 0, 'L');
			$pdf->Cell(70, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Noted by:', '' , 1, 'L');

			$pdf->ln(10);
			$pdf->Cell(20, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, '', 'B' , 0, 'L');
			$pdf->Cell(70, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, '', 'B' , 1, 'L');
			// $pdf->ln(5);
			$pdf->Cell(20, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Ma. Nadia D. Estaris', '' , 0, 'L');
			$pdf->Cell(70, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Maria Celerina M. Ramiro', '' , 1, 'L');

			$pdf->Cell(20, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Administrative Officer IV', '' , 0, 'L');
			$pdf->Cell(70, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Chief', '' , 1, 'L');

			$pdf->Cell(20, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'HRMRCS-FAD', '' , 0, 'L');
			$pdf->Cell(70, 4, '', '' , 0, 'L');
			$pdf->Cell(40, 4, 'Finance and Administrative Division', '' , 1, 'L');

		
	}
}
?>
