<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller 
{
	public function __construct(){
	    parent::__construct();
		if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
			redirect('access/');
		// $this->load->library('Fpdf_gen');
		$this->load->library('Fpdi');
	}

	public function getCode(){
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->paymentmodel->getCode($this->input->post('type', TRUE))));
	}

	public function index(){
		$data['menu'] = "receipt";
		$data['gmenu'] = "payment";

		$this->load->view('template/header', $data);
		$this->load->view('cash/receipt');
		$this->load->view('template/footer');
	}

	public function receipt(){
		$data['menu'] = "receipt";
		$data['gmenu'] = "payment";
		$data['drawees'] = $this->paymentmodel->getDrawees();

		$this->load->view('template/header', $data);
		$this->load->view('cash/soa');
		$this->load->view('template/footer');
	}

	function read($tbl){
		$output = $this->paymentmodel->read($tbl);
		$response = array(
			'aaData' => $output,
			'iTotalRecords' => count($output),
			'iTotalDisplayRecords' => count($output),
			'iDisplayStart' => 0
		);
		header("Content-Type: application/json", true);
		echo json_encode($response);
	}
	
	function getStatement(){
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->paymentmodel->getStatement($this->input->post('id', TRUE))));
	}
	
	function getSignatory(){
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->paymentmodel->getSignatory($this->input->post('id', TRUE))));
	}
	
	function getReceipt(){
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->paymentmodel->getReceipt($this->input->post('id', TRUE))));
	}
	
	function checkORNumber(){
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->paymentmodel->checkORNumber($this->input->post('id', TRUE))));
	}
	
	public function items()
	{
		$response = $this->paymentmodel->items($this->input->post('tbl'), $this->input->post('id'), $this->input->post('item'), $this->input->post('act'));

		header("Content-Type: application/json", true);
		echo json_encode($response);
	}

	function officialreceiptnew($id){
		function numtowords($num){ 
			$decones = array( 
			        '01' => "One", 
			        '02' => "Two", 
			        '03' => "Three",
	 		        '04' => "Four", 
			        '05' => "Five", 
			        '06' => "Six", 
			        '07' => "Seven", 
			        '08' => "Eight", 
			        '09' => "Nine", 
			        10 => "Ten", 
			        11 => "Eleven", 
			        12 => "Twelve", 
			        13 => "Thirteen", 
			        14 => "Fourteen", 
			        15 => "Fifteen", 
			        16 => "Sixteen", 
			        17 => "Seventeen", 
			        18 => "Eighteen", 
			        19 => "Nineteen" 
			        );
			$ones = array( 
			        0 => " ",
			        1 => "One",     
			        2 => "Two", 
			        3 => "Three", 
			        4 => "Four", 
			        5 => "Five", 
			        6 => "Six", 
			        7 => "Seven", 
			        8 => "Eight", 
			        9 => "Nine", 
			        10 => "Ten", 
			        11 => "Eleven", 
			        12 => "Twelve", 
			        13 => "Thirteen", 
			        14 => "Fourteen", 
			        15 => "Fifteen", 
			        16 => "Sixteen", 
			        17 => "Seventeen", 
			        18 => "Eighteen", 
			        19 => "Nineteen" 
			        ); 
			$tens = array( 
			        0 => "",
			        2 => "Twenty", 
			        3 => "Thirty", 
			        4 => "Forty", 
			        5 => "Fifty", 
			        6 => "Sixty", 
			        7 => "Seventy", 
			        8 => "Eighty", 
			        9 => "Ninety" 
			        ); 
			$hundreds = array( 
			        "Hundred", 
			        "Thousand", 
			        "Million", 
			        "Billion", 
			        "Trillion", 
			        "Quadrillion" 
			        );
			$num = number_format($num,2,".",","); 
			$num_arr = explode(".",$num); 
			$wholenum = $num_arr[0]; 
			$decnum = $num_arr[1]; 
			$whole_arr = array_reverse(explode(",",$wholenum)); 
			krsort($whole_arr); 
			$rettxt = ""; 
			foreach($whole_arr as $key => $i){ 
			if($i < 20){ 
			    $rettxt .= $ones[$i]; 
			}
			elseif($i < 100){ 
			    $rettxt .= $tens[substr($i,0,1)]; 
			    $rettxt .= " ".$ones[substr($i,1,1)]; 
			}
			else{ 
			    $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
			    $rettxt .= " ".$tens[substr($i,1,1)]; 
			    $rettxt .= "".$ones[substr($i,2,1)]; 
			} 
			if($key > 0){ 
			    $rettxt .= " ".$hundreds[$key]." "; 
			} 

			} 
			$rettxt = $rettxt."Pesos";

			if($decnum > 0){ 
			$rettxt .= " and "; 
			if($decnum < 20){ 
			    $rettxt .= $decones[$decnum]; 
			}
			elseif($decnum < 100){ 
			    $rettxt .= $tens[substr($decnum,0,1)]; 
			    $rettxt .= " ".$ones[substr($decnum,1,1)]; 
			}
			$rettxt = $rettxt." Centavos"; 
			} 
			return $rettxt;
		}

		$or = $this->paymentmodel->getOR($id);
		$items = $this->paymentmodel->getORItems($id);

		$pdf = new FPDF('P','mm',array('100','200'));
		$pdf->SetTitle('PNRI OR '.$or[0]->receiptno);
		$pdf->setMargins(10, 36);
		$pdf->AddPage();
		// add a page
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(85,8,$or[0]->receiptno,0,1,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(78,7,date("d-M-y h:i A", strtotime($or[0]->offdate)),0,1,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(54,3,'PHILIPPINE NUCLEAR',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(28,3,$or[0]->fund,0,1,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(56,3,'RESEARCH INSTITUTE ',0,0,'R');

		$pdf->SetY(58);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(15,4,'',0,0,'L');
		$pdf->MultiCell(75, 3, utf8_decode(strtoupper($or[0]->payor)),'','L');

		$pdf->SetY(77);
		$tot = 0;
		foreach ($items as $i) {
			$pdf->SetFont('Arial','',9.5);
			$ccnt = ceil(mb_strlen($i->des) /25);
				$start_y = $pdf->GetY();
				$start_x = $pdf->GetX();
				$pdf->MultiCell(40, 3, utf8_decode(strtoupper($i->des)),'','L');
				$y = $pdf->GetY(); 
				$pdf->SetXY($start_x + 40, $start_y);
				// $start_y = $y;

				$start_x = $pdf->GetX();
				$pdf->MultiCell(25, 3, $i->acc,'','C');
				// $y = $pdf->GetY(); 
				$pdf->SetXY($start_x + 25, $start_y);
				$start_y = $y;

				$pdf->Cell(20, 3, number_format($i->amt, 2),'',0,'R');
				$pdf->SetY($start_y);

			$tot += $i->amt;
		}
		$lddap = (strpos($or[0]->paytype, 'lddap') !== false) ? "LDDAP ".$or[0]->MOno." ".$or[0]->MOdate : "";
		$cashamt = (strpos($or[0]->paytype, 'cash,') !== false) ? "  Cash: ".$or[0]->cashamt : "";
		$jo =  $or[0]->jo ? " JO: ".$or[0]->jo : "";
		// $pdf->Cell(20, 3, "",'',1,'R');
		$pdf->MultiCell(85, 3, $lddap.$cashamt.$jo,'','L');
		$pdf->SetY(125); $pdf->Cell(85, 3, number_format($tot, 2),'',0,'R');
		$pdf->SetY(130); $pdf->Cell(25, 3, '','',0,'R');
		// $pdf->MultiCell(70, 3, numtowords($tot),'','L');
		$exp = explode('.', $tot);
		$f = new NumberFormatter("en_US", NumberFormatter::SPELLOUT);
		$pdf->MultiCell(65, 3, ucwords($f->format($exp[0])  . numtowords("0.".$exp[1])),'','C');
		

		$pdf->SetY(144);
		$pdf->Cell(25, 3, ((strpos($or[0]->paytype, 'cash') !== false) ? "X" : ""),'',1,'L');
		$pdf->SetY(150);
		$pdf->Cell(20, 3, ((strpos($or[0]->paytype, 'check') !== false) ? "X" : ""),'',0,'L');
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(50, 3, ((strpos($or[0]->paytype, 'check') !== false) ? $or[0]->drawee."/".$or[0]->bankno : ""),'',0,'L');
		$pdf->Cell(10, 3, ((strpos($or[0]->paytype, 'check') !== false) ? $or[0]->checkdate : ""),'',1,'L');

		$pdf->SetY(158);$pdf->SetFont('Arial','',10);
		$pdf->Cell(20, 3, ((strpos($or[0]->paytype, 'moneyorder') !== false) ? "X" : ""),'',0,'L');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(45, 3, ((strpos($or[0]->paytype, 'moneyorder') !== false) ? $or[0]->MOno : ""),'',0,'L');
		$pdf->Cell(10, 3, ((strpos($or[0]->paytype, 'moneyorder') !== false) ? $or[0]->MOdate : ""),'',1,'L');

		$pdf->SetFont('Arial','',10);
		$pdf->SetY(169); 
		$pdf->Cell(40, 3,'',0,0,'C');
		$pdf->Cell(30, 3,strtoupper($this->db->query("SELECT sig_name FROM payment.r_config WHERE sig_id = 1")->row()->sig_name),0,1,'C');
		$pdf->Cell(40, 3,'',0,0,'C');
		$pdf->Cell(30, 3,$this->db->query("SELECT sig_des FROM payment.r_config WHERE sig_id = 1")->row()->sig_des,0,1,'C');
		ob_clean();
		$pdf->Output();
    }

	function officialreceipt($id){
		function numtowords($num){ 
			$decones = array( 
			        '01' => "One", 
			        '02' => "Two", 
			        '03' => "Three",
	 		        '04' => "Four", 
			        '05' => "Five", 
			        '06' => "Six", 
			        '07' => "Seven", 
			        '08' => "Eight", 
			        '09' => "Nine", 
			        10 => "Ten", 
			        11 => "Eleven", 
			        12 => "Twelve", 
			        13 => "Thirteen", 
			        14 => "Fourteen", 
			        15 => "Fifteen", 
			        16 => "Sixteen", 
			        17 => "Seventeen", 
			        18 => "Eighteen", 
			        19 => "Nineteen" 
			        );
			$ones = array( 
			        0 => " ",
			        1 => "One",     
			        2 => "Two", 
			        3 => "Three", 
			        4 => "Four", 
			        5 => "Five", 
			        6 => "Six", 
			        7 => "Seven", 
			        8 => "Eight", 
			        9 => "Nine", 
			        10 => "Ten", 
			        11 => "Eleven", 
			        12 => "Twelve", 
			        13 => "Thirteen", 
			        14 => "Fourteen", 
			        15 => "Fifteen", 
			        16 => "Sixteen", 
			        17 => "Seventeen", 
			        18 => "Eighteen", 
			        19 => "Nineteen" 
			        ); 
			$tens = array( 
			        0 => "",
			        2 => "Twenty", 
			        3 => "Thirty", 
			        4 => "Forty", 
			        5 => "Fifty", 
			        6 => "Sixty", 
			        7 => "Seventy", 
			        8 => "Eighty", 
			        9 => "Ninety" 
			        ); 
			$hundreds = array( 
			        "Hundred", 
			        "Thousand", 
			        "Million", 
			        "Billion", 
			        "Trillion", 
			        "Quadrillion" 
			        );
			$num = number_format($num,2,".",","); 
			$num_arr = explode(".",$num); 
			$wholenum = $num_arr[0]; 
			$decnum = $num_arr[1]; 
			$whole_arr = array_reverse(explode(",",$wholenum)); 
			krsort($whole_arr); 
			$rettxt = ""; 
			foreach($whole_arr as $key => $i){ 
			if($i < 20){ 
			    $rettxt .= $ones[$i]; 
			}
			elseif($i < 100){ 
			    $rettxt .= $tens[substr($i,0,1)]; 
			    $rettxt .= " ".$ones[substr($i,1,1)]; 
			}
			else{ 
			    $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
			    $rettxt .= " ".$tens[substr($i,1,1)]; 
			    $rettxt .= "".$ones[substr($i,2,1)]; 
			} 
			if($key > 0){ 
			    $rettxt .= " ".$hundreds[$key]." "; 
			} 

			} 
			$rettxt = $rettxt."Pesos";

			if($decnum > 0){ 
			$rettxt .= " and "; 
			if($decnum < 20){ 
			    $rettxt .= $decones[$decnum]; 
			}
			elseif($decnum < 100){ 
			    $rettxt .= $tens[substr($decnum,0,1)]; 
			    $rettxt .= " ".$ones[substr($decnum,1,1)]; 
			}
			$rettxt = $rettxt." Centavos"; 
			} 
			return $rettxt;
		}

		$or = $this->paymentmodel->getOR($id);
		$items = $this->paymentmodel->getORItems($id);

		$pdf = new FPDF('P','mm',array('100','200'));
		$pdf->SetTitle('PNRI OR '.$or[0]->receiptno);
		$pdf->setMargins(10, 36);
		$pdf->AddPage();
		// add a page
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(85,8,$or[0]->receiptno,0,1,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(78,7,date("d-M-y h:i A", strtotime($or[0]->offdate)),0,1,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(54,3,'PHILIPPINE NUCLEAR',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(28,3,$or[0]->fund,0,1,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(56,3,'RESEARCH INSTITUTE ',0,0,'R');

		$pdf->SetY(58);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(15,4,'',0,0,'L');
		$pdf->MultiCell(75, 3, utf8_decode(strtoupper($or[0]->payor)),'','L');

		$pdf->SetY(77);
		$tot = 0;
		foreach ($items as $i) {
			$pdf->SetFont('Arial','',9.5);
			$ccnt = ceil(mb_strlen($i->des) /25);
				$start_y = $pdf->GetY();
				$start_x = $pdf->GetX();
				$pdf->MultiCell(40, 3, utf8_decode(strtoupper($i->des)),'','L');
				$y = $pdf->GetY(); 
				$pdf->SetXY($start_x + 40, $start_y);
				// $start_y = $y;

				$start_x = $pdf->GetX();
				$pdf->MultiCell(25, 3, $i->acc,'','C');
				// $y = $pdf->GetY(); 
				$pdf->SetXY($start_x + 25, $start_y);
				$start_y = $y;

				$pdf->Cell(20, 3, number_format($i->amt, 2),'',0,'R');
				$pdf->SetY($start_y);

			$tot += $i->amt;
		}
		$lddap = (strpos($or[0]->paytype, 'lddap') !== false) ? "LDDAP ".$or[0]->MOno." ".$or[0]->MOdate : "";
		$cashamt = (strpos($or[0]->paytype, 'cash,') !== false) ? "  Cash: ".$or[0]->cashamt : "";
		$jo =  $or[0]->jo ? " JO: ".$or[0]->jo : "";
		// $pdf->Cell(20, 3, "",'',1,'R');
		$pdf->MultiCell(85, 3, $lddap.$cashamt.$jo,'','L');
		$pdf->SetY(125); $pdf->Cell(85, 3, number_format($tot, 2),'',0,'R');
		$pdf->SetY(130); $pdf->Cell(25, 3, '','',0,'R');
		// $pdf->MultiCell(70, 3, numtowords($tot),'','L');
		$exp = explode('.', $tot);
		$f = new NumberFormatter("en_US", NumberFormatter::SPELLOUT);
		$pdf->MultiCell(65, 3, ucwords($f->format($exp[0])  . numtowords("0.".$exp[1])),'','C');
		

		$pdf->SetY(144);
		$pdf->Cell(25, 3, ((strpos($or[0]->paytype, 'cash') !== false) ? "X" : ""),'',1,'L');
		$pdf->SetY(150);
		$pdf->Cell(20, 3, ((strpos($or[0]->paytype, 'check') !== false) ? "X" : ""),'',0,'L');
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(25, 3, ((strpos($or[0]->paytype, 'check') !== false) ? $or[0]->drawee : ""),'',0,'L');
		$pdf->Cell(25, 3, ((strpos($or[0]->paytype, 'check') !== false) ? $or[0]->bankno : ""),'',0,'L');
		$pdf->Cell(10, 3, ((strpos($or[0]->paytype, 'check') !== false) ? $or[0]->checkdate : ""),'',1,'L');

		$pdf->SetY(158);$pdf->SetFont('Arial','',10);
		$pdf->Cell(20, 3, ((strpos($or[0]->paytype, 'moneyorder') !== false) ? "X" : ""),'',0,'L');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(45, 3, ((strpos($or[0]->paytype, 'moneyorder') !== false) ? $or[0]->MOno : ""),'',0,'L');
		$pdf->Cell(10, 3, ((strpos($or[0]->paytype, 'moneyorder') !== false) ? $or[0]->MOdate : ""),'',1,'L');

		$pdf->SetFont('Arial','',10);
		$pdf->SetY(169); 
		$pdf->Cell(40, 3,'',0,0,'C');
		$pdf->Cell(30, 3,strtoupper($this->db->query("SELECT sig_name FROM payment.r_config WHERE sig_id = 1")->row()->sig_name),0,1,'C');
		$pdf->Cell(40, 3,'',0,0,'C');
		$pdf->Cell(30, 3,$this->db->query("SELECT sig_des FROM payment.r_config WHERE sig_id = 1")->row()->sig_des,0,1,'C');
		ob_clean();
		$pdf->Output();
    }

	public function monthly($fund,$fr,$to){
		$pdf = new FPDF('P','mm','Letter');
		$particulars = ""; $amt = $total = $grandtot = 0;
		$dts = $this->exportmodel->getDaysPerMonth($fund,$fr,$to);
		$this->printMonthlyHeader($pdf,$fund,$fr,$to);
		$start_y = 74;

		$pdf->SetY($start_y);
		foreach ($dts as $dt) {
			$ctr = 0;
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(16, 4,$dt->dtname,'',1,'C');
			$payments = $this->exportmodel->getPayments($fund,$dt->dt);
			foreach ($payments as $pay) {
				$particulars = ""; $amt = 0;
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(2, 4,'','',0,'C');
				$pdf->Cell(14, 4,$pay->dt,'',0,'C');
				$pdf->Cell(16, 4,$pay->receiptno,'',0,'C');
				$pdf->Cell(18, 4,$pay->ctrcode,'',0,'C');
				$start_y = $pdf->GetY();
				$items = $this->paymentmodel->getORItems($pay->payid);
				foreach ($items as $i) {
					$particulars .= $i->des."\n";
					$amt = $amt + $i->amt;
					$grandtot = $grandtot + $i->amt;
				}
				$pdf->SetFont('Arial','',8);

				$start_x = $pdf->GetX();
				$pdf->MultiCell(55, 4, utf8_decode(strtoupper($pay->payor)),'','L');
				$y = $pdf->GetY(); 
				$pdf->SetXY($start_x + 55, $start_y);

				$start_x = $pdf->GetX();
				$pdf->MultiCell(45, 4, utf8_decode(strtoupper($particulars)),'','L');
				$y = $pdf->GetY(); 
				$pdf->SetXY($start_x + 45, $start_y);
				$start_y = $y;

				$pdf->SetFont('Arial','',8);
				$pdf->Cell(30, 4, number_format($amt, 2),'',0,'R');
				$pdf->SetY($start_y+2);

				$total = $total + $amt;
				if($pdf->GetY()>220){
					$this->printMonthlyFooter($pdf, $total);
					$this->printMonthlyHeader($pdf, $fund,$fr,$to);
					$total = 0;
				}
			}
		}
		//Grand Total
		$pdf->Ln(6);
		$pdf->SetFont('Courier','B',12);
		// $pdf->SetFont('Arial','B',10);
		$pdf->Cell(128.5, 7,'Total This Page ','',0,'R');
		// $pdf->SetFont('Courier','B',10);
		$pdf->Cell(52, 7,number_format($total,2),'',1,'R');

		// $pdf->SetFont('Arial','B',10);
		$pdf->Cell(128.5, 7,'GRAND TOTAL:','',0,'R');
		// $pdf->SetFont('Courier','B',12);
		$pdf->Cell(52, 7,number_format($grandtot,2),'',1,'R');

		ob_clean();
		$pdf->Output();
	}

	public function printMonthlyHeader($pdf, $fund,$fr,$to){
			$start_y = 74;
			$pdf->SetLeftMargin(15);
			$pdf->AddPage();
			$pn = '';
			$pdf->SetY(27);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,6,'REPORT OF COLLECTION AND DEPOSITS',0,1,'C');
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,'PHILIPPINE NUCLEAR RESEARCH INSTITUTE',0,1,'C');	
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(155,0,$fund,0,0,'R');
			$pdf->SetFont('Arial','B',8);
			$pdf->Ln(6);
			$pdf->Cell(310,0,'Report No.           _'.'',0,1,'C');
			$pdf->Cell(310,6,'Sheet No.             '.$pdf->PageNo(),0,1,'C');
			$pdf->SetFont('Arial','B',10);
			if($to)
				$pdf->Cell(130,8,"For the Period Covered from   ".date("d-M-y", strtotime($fr))."  To  ".date("d-M-y", strtotime($to)),0,1,'R');
			else
				$pdf->Cell(130,8,"For the Period Covered from   ".date("d-M-y", strtotime($fr))."  To  ".date("d-M-y", strtotime($fr)),0,1,'R');
			//ITEM HEADING
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(32, 7,'Official Receipts','LTBR',0,'C');
			$pdf->Cell(18, 7,"Respon-",'LTR',0,'C');
			$pdf->Cell(55, 7,'','LTR',0,'C');
			$pdf->Cell(45, 7,'','LTR',0,'C');
			$pdf->Cell(30, 7,'','LTR',1,'C');

			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(32, 0,'','LTBR',0,'C');
			$pdf->Cell(18, 0,'sibility','',0,'C');
			$pdf->Cell(55, 0,'Payor','',0,'C');
			$pdf->Cell(45, 0,'Particulars','',0,'C');
			$pdf->Cell(30, 0,'Amount','',1,'C');

			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(12, 7,'Date','LTBR',0,'C');
			$pdf->Cell(20, 7,'Number','LTBR',0,'C');
			$pdf->Cell(18, 7,"CTRCode",'LBR',0,'C');
			$pdf->Cell(55, 7,'','LBR',0,'C');
			$pdf->Cell(45, 7,'','LBR',0,'C');
			$pdf->Cell(30, 7,'','LBR',1,'C');
	}

	public function printMonthlyFooter($pdf, $total){
		$pdf->SetY(250);
		$pdf->SetFont('Courier','B',12);
		$pdf->Cell(128.5, 7,'Total This Page ','',0,'R');
		$pdf->SetFont('Courier','B',10);
		$pdf->Cell(50, 7,number_format($total,2),'',1,'R');
	}

	public function daily1($fund,$fr){
		$pdf = new FPDF('P','mm','Letter');
		$particulars = ""; $amt = $total = $grandtot = 0;
		$this->printMonthlyHeader($pdf,$fund,$fr,"");
		$start_y = 74;

		$hasLDDAP = 0;
		$pdf->SetY($start_y);
		$payments = $this->exportmodel->getPayments($fund,$fr);
		foreach ($payments as $pay) {
			$particulars = ""; $amt = 0;
			$hasLDDAP = (strpos($pay->paytype, 'lddap') !== false) ? 1 : $hasLDDAP;
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(2, 4,'','',0,'C');
			$pdf->Cell(14, 4,$pay->dt,'',0,'C');
			$pdf->Cell(16, 4,$pay->receiptno,'',0,'C');
			$pdf->Cell(18, 4,$pay->ctrcode,'',0,'C');
			$start_y = $pdf->GetY();
			$items = $this->paymentmodel->getORItems($pay->payid);
			foreach ($items as $i) {
				$particulars .= $i->des."\n";
				$amt = $amt + $i->amt;
				$grandtot = $grandtot + $i->amt;
			}
			$pdf->SetFont('Arial','',8);

			$start_x = $pdf->GetX();
			$pdf->MultiCell(55, 4, utf8_decode(strtoupper($pay->payor)),'','L');
			$y = $pdf->GetY(); 
			$pdf->SetXY($start_x + 55, $start_y);
			// $start_y = $y;

			$start_x = $pdf->GetX();
			$pdf->MultiCell(45, 4, utf8_decode(strtoupper($particulars)),'','L');
			$y = $pdf->GetY(); 
			$pdf->SetXY($start_x + 45, $start_y);
			$start_y = $y;

			$pdf->SetFont('Arial','',8);
			$pdf->Cell(30, 4, number_format($amt, 2),'',0,'R');
			$pdf->SetY($start_y+2);

			$total = $total + $amt;
			if($pdf->GetY()>230){
				$this->printMonthlyFooter($pdf, $total);
				$this->printMonthlyHeader($pdf, $fund,$fr,"");
				$total = 0;
			}
		}
		//Grand Total
		$pdf->Ln(6);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(128.5, 7,'Total This Page ','',0,'R');
		$pdf->SetFont('Courier','B',10);
		$pdf->Cell(52, 4,number_format($total,2),'',1,'R');

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(128.5, 7,'GRAND TOTAL:','',0,'R');
		$pdf->SetFont('Courier','B',12);
		$pdf->Cell(52, 4,number_format($grandtot,2),'',1,'R');

		//LDDAP
		if($hasLDDAP){
			$pdf->Ln(20);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(150, 5,"LDDAP",'',1,'L');
			$pdf->Cell(20, 5,'Date','LTBR',0,'C');
			$pdf->Cell(30, 5,"Receipt Number",'LTBR',0,'C');
			$pdf->Cell(30, 5,"LDDAP Number",'LTBR',0,'C');
			$pdf->Cell(30, 5,'Amount','LTBR',1,'C');

			$payments = $this->exportmodel->getPaymentsLDDAP($fund,$fr);
			$lddapamt = 0;
			foreach ($payments as $pay) {
				$particulars = ""; $lddap = 0;
				$pdf->SetFont('Arial','',8);
				$pdf->Cell(20, 4,$pay->MOdate,'',0,'C');
				$pdf->Cell(30, 4,$pay->receiptno,'',0,'C');
				$pdf->Cell(30, 4,$pay->MOno,'',0,'C');
				$items = $this->paymentmodel->getORItems($pay->payid);
				foreach ($items as $i) {
					$lddap = $lddap + $i->amt;
					$lddapamt = $lddapamt + $i->amt;
				}
				$pdf->Cell(20, 4,number_format($lddap,2),'',1,'R');
			}
			$pdf->Cell(20, 5,'','',0,'C');
			$pdf->Cell(30, 5,"",'',0,'C');
			$pdf->Cell(30, 5,"",'',0,'C');
			$pdf->Cell(20, 5,number_format($lddapamt,2),'',1,'R');


			$pdf->Ln(10);
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(47.5, 7,'GRAND TOTAL:','',0,'R');
			$pdf->Cell(52, 4,number_format($grandtot,2),'',1,'R');
			$pdf->Cell(47.5, 7,'LDDAP-ADA:','',0,'R');
			$pdf->Cell(52, 4,number_format($lddapamt,2),'',1,'R');
			$pdf->Cell(47.5, 7,'TOTAL:','',0,'R');
			$pdf->Cell(52, 4,number_format(($grandtot-$lddapamt),2),'',1,'R');
		}
		ob_clean();
		$pdf->Output();
	}

	public function daily($fund,$fr){
		$pdf = new FPDF('P','mm','Letter');
		$particulars = ""; $amt = $total = $grandtot = 0;
		$this->printDailyHeader($pdf,$fund,$fr);
		$start_y = 80;

		$pdf->SetY($start_y);

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(16, 4,date("d-M-y", strtotime($fr)),'',1,'C');
		$payments = $this->exportmodel->getPayments($fund,$fr);
		foreach ($payments as $pay) {
			$particulars = ""; $amt = 0;

			$start_y = $pdf->GetY();
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(12, 4,'','',0,'C');
			$pdf->Cell(20, 4,$pay->receiptno,'',0,'C');
			$items = $this->paymentmodel->getORItems($pay->payid);
			foreach ($items as $i) {
				$particulars .= $i->des."\n";
				$amt = $amt + $i->amt;
				$grandtot = $grandtot + $i->amt;
			}
			$pdf->SetFont('Arial','',8);

			$start_x = $pdf->GetX();
			$pdf->MultiCell(45, 4, utf8_decode(strtoupper($pay->payor)),'','L');
			$y = $pdf->GetY(); 
			$pdf->SetXY($start_x + 45, $start_y);
			// $start_y = $y;

			$start_x = $pdf->GetX();
			$pdf->MultiCell(40, 4, utf8_decode(strtoupper($particulars)),'','L');
			$y = $pdf->GetY(); 
			$pdf->SetXY($start_x + 40, $start_y);
			$start_y = $y;

			$pdf->SetFont('Arial','',8);
			$pdf->Cell(25, 4, number_format($amt, 2),'',1,'R');
			$pdf->SetY($start_y+4);

			$total = $total + $amt;
			if($pdf->GetY()>230){
				$this->printDailyFooter($pdf, $total);
				$this->printDailyHeader($pdf, $fund,$fr);
				$total = 0;
			}
		}
		//Grand Total
		$pdf->Ln(6);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(80, 7,'Balance to be forwarded ','',0,'R');
		$pdf->SetFont('Courier','B',10);
		$pdf->Cell(62, 4,number_format($total,2),'',1,'R');

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(80, 7,'TOTAL COLLECTION:','',0,'R');
		$pdf->SetFont('Courier','B',12);
		$pdf->Cell(62, 4,number_format($grandtot,2),'',1,'R');

		ob_clean();
		$pdf->Output();
	}

	public function printDailyHeader($pdf, $fund,$fr){
			$start_y = 80;
			$pdf->SetLeftMargin(15);
			$pdf->AddPage();
			$pn = '';
			$pdf->SetY(27);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,6,'CASH RECEIPTS RECORD',0,1,'C');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(175,0,"Page    ".$pdf->PageNo(),0,1,'R');
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,'PHILIPPINE NUCLEAR RESEARCH INSTITUTE',0,1,'C');	
			$pdf->Ln(6);

			$pdf->SetFont('Arial','',10);
			$pdf->Cell(28, 5,'','',0,'C');
			$pdf->Cell(40, 5,$this->db->query("SELECT sig_name FROM payment.r_config WHERE sig_id = 1")->row()->sig_name,'B',0,'C');
			$pdf->Cell(10, 5,'','',0,'C');
			$pdf->Cell(40, 5,$this->db->query("SELECT sig_des FROM payment.r_config WHERE sig_id = 1")->row()->sig_des,'B',0,'C');
			$pdf->Cell(38, 5,'','',0,'C');
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(20, 5,$fund,'',1,'C');

			$pdf->Cell(28, 7,'','',0,'C');
			$pdf->Cell(40, 7,'Accountable Officer','',0,'C');
			$pdf->Cell(10, 7,'','',0,'C');
			$pdf->Cell(40, 7,'Official Designation','',0,'C');
			$pdf->Cell(38, 7,'','',0,'C');
			$pdf->Cell(20, 7,'','',1,'C');

			//ITEM HEADING
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(32, 7,'Official Receipts','LTBR',0,'C');
			$pdf->Cell(45, 7,'','LTR',0,'C');
			$pdf->Cell(40, 7,'','LTR',0,'C');
			$pdf->Cell(25, 7,'','LTR',0,'C');
			$pdf->Cell(20, 7,'','LTR',0,'C');
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(20, 7,'Undeposited','LTR',1,'C');

			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(32, 0,'','LTBR',0,'C');
			$pdf->Cell(45, 0,'Name of Payor','',0,'C');
			$pdf->Cell(40, 0,"Nature of Collection",'',0,'C');
			$pdf->Cell(25, 0,'Collection','',0,'C');
			$pdf->Cell(20, 0,'Deposit','',0,'C');
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(20, 0,'Collection','',1,'C');

			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(12, 7,'Date','LTBR',0,'C');
			$pdf->Cell(20, 7,'Number','LTBR',0,'C');
			$pdf->Cell(45, 7,'','LBR',0,'C');
			$pdf->Cell(40, 7,'','LBR',0,'C');
			$pdf->Cell(25, 7,'','LBR',0,'C');
			$pdf->Cell(20, 7,'','LBR',0,'C');
			$pdf->Cell(20, 7,'','LBR',1,'C');

			$pdf->SetFont('Arial','',10);
			$pdf->Cell(117, 7,'Balance forwarded','LTBR',0,'R');
			$pdf->Cell(25, 7,'','LBR',0,'C');
			$pdf->Cell(20, 7,'','LBR',0,'C');
			$pdf->Cell(20, 7,'','LBR',1,'C');
	}

	public function printDailyFooter($pdf, $total){
		$pdf->SetY(248);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(80, 7,'Balance to be forwarded ','',0,'R');
		$pdf->SetFont('Courier','B',10);
		$pdf->Cell(62, 4,number_format($total,2),'',1,'R');
	}

	public function exportCashBook($fund,$fr,$to){
		ob_start();
		$this->load->library('excel');
		error_reporting(E_ALL);

			function getsizeRow($as, $row)
			{
				// default font of the workbook
				$font = $as->getDefaultStyle()->getFont();
				$rowDimensions = $as->getRowDimensions();
				// first find the true row height in pixels (uncollapsed and unhidden)
				if (isset($rowDimensions[$row]) and $rowDimensions[$row]->getRowHeight() != -1) {
					// then we have a row dimension
					$rowDimension = $rowDimensions[$row];
					$rowHeight = $rowDimension->getRowHeight();
					$pixelRowHeight = (int) ceil(4 * $rowHeight / 3);
					// here we assume Arial 10
				} elseif ($as->getDefaultRowDimension()->getRowHeight() != -1) {
					// then we have a default row dimension with explicit height
					$defaultRowDimension = $as->getDefaultRowDimension();
					$rowHeight = $defaultRowDimension->getRowHeight();
					// PHPExcel_Shared_Font::setAutoSizeMethod(PHPExcel_Shared_Font::AUTOSIZE_METHOD_EXACT);
					$pixelRowHeight = PHPExcel_Shared_Drawing::pointsToPixels($rowHeight);
				} else {
					// we don't even have any default row dimension. Height depends on default font
					$pointRowHeight = PHPExcel_Shared_Font::getDefaultRowHeightByFont($font);
					$pixelRowHeight = PHPExcel_Shared_Font::fontSizeToPixels($pointRowHeight);
				}
				// now find the effective row height in pixels
				if (isset($rowDimensions[$row]) and !$rowDimensions[$row]->getVisible()) {
					$effectivePixelRowHeight = 0;
				} else {
					$effectivePixelRowHeight = $pixelRowHeight;
				}
				return $pixelRowHeight;
				// return $effectivePixelRowHeight;
			}

		$excel2 = PHPExcel_IOFactory::createReader('Excel2007');
		$excel2 = $excel2->load(FCPATH.'/assets/template/cashbook_101I_2019.xlsx');
		$excel2->setActiveSheetIndex(0);
		$excel2->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1,7);
		$excel2->getActiveSheet()->calculateColumnWidths();
		
		$x = $dcnt = 0;

		$excel2->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

		$thintopborder = array('style' => PHPExcel_Style_Border::BORDER_THIN);
		$doubletopborder = array('style' => PHPExcel_Style_Border::BORDER_DOUBLE);
		
		$excel2->getActiveSheet()
				->setCellValue("A4", ($this->db->query("SELECT sig_name FROM payment.r_config WHERE sig_id = 1")->row()->sig_name))
				->setCellValue("D4", ($this->db->query("SELECT sig_des FROM payment.r_config WHERE sig_id = 1")->row()->sig_des))
				->setCellValue("G4", $fund);
		
		$x = 8; $sumx = $pgBalForX = $pgCnt = $pgBalFor = $pgSubtot = 0;$rh = "";
		$dts = $this->exportmodel->getDaysPerMonth($fund,$fr,$to);
		foreach ($dts as $dt)
		{
			$x+=2;
			$excel2->getActiveSheet()
				->setCellValue("D$x", "Balance forwarded:")
				->setCellValue("E$x", "=".$pgBalForX);
			$excel2->getActiveSheet()->getStyle("D$x")->getFont()->setBold(true);
			$excel2->getActiveSheet()->getStyle("D$x")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$balforx = $x;
			$x+=2;
			$sumx = $x;
			$hasLDDAP = $grandtot = $lddaptot = 0;
			$payments = $this->exportmodel->getPayments($fund, $dt->dt);
			foreach ($payments as $pay) {
				$particulars = ""; $amt = 0;
				$hasLDDAP = (strpos($pay->paytype, 'lddap') !== false) ? 1 : $hasLDDAP;
				$lddaptot += (strpos($pay->paytype, 'lddap') !== false) ? $lddaptot : 0;
				$items = $this->paymentmodel->getORItems($pay->payid);
				foreach ($items as $i) {
					$particulars .= $i->des."\n";
					$amt = $amt + $i->amt;
					$grandtot = $grandtot + $i->amt;
				}
				$pgSubtot += $grandtot;
				$particulars = rtrim($particulars);
				$excel2->getActiveSheet()
					->setCellValue("A$x", $pay->dt)
					->setCellValue("B$x", $pay->receiptno)
					->setCellValue("C$x", $pay->payor)
					->setCellValue("D$x", $particulars)
					->setCellValue("E$x", $amt);
					$excel2->getActiveSheet()->setCellValue("H$x", getsizeRow($excel2->getActiveSheet(), $x));
				// $excel2->getActiveSheet()->getStyle('C'.$x.':D'.$x)->getAlignment()->setWrapText(true); 
				// $excel2->getActiveSheet()->setCellValue("H$x", $excel2->getActiveSheet()->getRowDimension()->getRowHeight());
				// foreach($excel2->getActiveSheet()->getRowDimensions() as $rd) 
				// {
				// 	$rh .= "; "." ". $rd->getRowHeight();
				// }
				// $excel2->getActiveSheet()->setCellValue("H1", $rh);
				
				// $excel2->getActiveSheet()->setCellValue("H$x", $excel2->getActiveSheet()->getRowDimension($x)->getRowHeight());
				// $excel2->getActiveSheet()->setCellValue("H$x", $excel2->getActiveSheet()->getColumnDimension("A")->getWidth());
				$x+=1;
				/*$pgCnt++;
				if($pgCnt % 15 == 0){
					$pgsubtot = $x;
					// $excel2->getActiveSheet()
					// 	->setCellValue("D$x", "=SUM(D".$pgsubtot.":D".($x-1).")")
					// 	->setCellValue("E$x", "=SUM(E".$pgsubtot.":E".($x-1).")"); 
					$pgCnt = 0;
					$excel2->getActiveSheet()->setCellValue("A3", $excel2->GetY());
					$excel2->getActiveSheet()->setBreak( 'A'.$x , PHPExcel_Worksheet::BREAK_ROW);
				}*/
			}
			$subtot = $x;
			$excel2->getActiveSheet()
				->setCellValue("D$x", "TOTAL COLLECTION")
				->setCellValue("E$x", "=SUM(E".$sumx.":E".($x-1).")");
			$excel2->getActiveSheet()->getStyle("E$x")->getBorders()->getTop()->applyFromArray($thintopborder);
			$excel2->getActiveSheet()->getStyle("D$x")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); $x+=1;
			$excel2->getActiveSheet()
				->setCellValue("D$x", "Deposit of Collection ()")
				->setCellValue("F$x", 0);
			$excel2->getActiveSheet()->getStyle("D$x")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); $x+=1;
			if($hasLDDAP){
				$excel2->getActiveSheet()
					->setCellValue("D$x", "LDDAP-ADA#")
					->setCellValue("F$x", $lddaptot); 
				$excel2->getActiveSheet()->getStyle("D$x")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); $x+=1;
			}
			$excel2->getActiveSheet()
				->setCellValue("E$x", "=SUM(E".$subtot.":E".($x-1).")")
				->setCellValue("F$x", "=SUM(F".$subtot.":F".($x-1).")"); 
			$excel2->getActiveSheet()->getStyle("E$x")->getBorders()->getTop()->applyFromArray($thintopborder);
			$excel2->getActiveSheet()->getStyle("F$x")->getBorders()->getTop()->applyFromArray($thintopborder);
			$x+=1;
			$excel2->getActiveSheet()
				->setCellValue("D$x", "Balance to be forwarded:")
				->setCellValue("E$x", "=E".$balforx."+E".($x-1))
				->setCellValue("F$x", "=E".$balforx."+F".($x-1));
			$excel2->getActiveSheet()->getStyle("E$x")->getBorders()->getTop()->applyFromArray($doubletopborder);
			$excel2->getActiveSheet()->getStyle("F$x")->getBorders()->getTop()->applyFromArray($doubletopborder);
			$excel2->getActiveSheet()->getStyle("D$x")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$excel2->getActiveSheet()->getStyle("D".$subtot.":D".$x)->getFont()->setSize(8);


				
			$pgBalForX = "E$x";
			$x+=1;
			$excel2->getActiveSheet()->setBreak( 'A' . $x, PHPExcel_Worksheet::BREAK_ROW);
			$x+=1;
		}
		
		ob_end_clean();
		ob_clean();
		ob_flush();
		$filename='InfoSys - Payment CashbBook '.$fr.'-'.$to.'.xlsx';
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($excel2, 'Excel2007');
		// $objWriter->setPreCalculateFormulas(FALSE);
		// $objWriter->setPreCalculateFormulas(true);
		$objWriter->save('php://output');
	}

	function orview($id){

		// use setasign\Fpdi\Fpdi;
		// use setasign\Fpdi\PdfReader;
		$pdf = new \setasign\Fpdi\Fpdi('P','mm',array('100','200'));

		$pageCount = $pdf->setSourceFile('assets/template/or.pdf');
		$pageId = $pdf->importPage(1);
		$pdf->SetTitle('PNRI OR '.$or[0]->receiptno);
		$pdf->setMargins(0, 0);
		$pdf->setMargins(7, 34);
		$pdf->addPage();
		$pdf->useImportedPage($pageId, 2, 2, 100);

		function numtowords($num){ 
			$decones = array( 
			        '01' => "One", 
			        '02' => "Two", 
			        '03' => "Three",
	 		        '04' => "Four", 
			        '05' => "Five", 
			        '06' => "Six", 
			        '07' => "Seven", 
			        '08' => "Eight", 
			        '09' => "Nine", 
			        10 => "Ten", 
			        11 => "Eleven", 
			        12 => "Twelve", 
			        13 => "Thirteen", 
			        14 => "Fourteen", 
			        15 => "Fifteen", 
			        16 => "Sixteen", 
			        17 => "Seventeen", 
			        18 => "Eighteen", 
			        19 => "Nineteen" 
			        );
			$ones = array( 
			        0 => " ",
			        1 => "One",     
			        2 => "Two", 
			        3 => "Three", 
			        4 => "Four", 
			        5 => "Five", 
			        6 => "Six", 
			        7 => "Seven", 
			        8 => "Eight", 
			        9 => "Nine", 
			        10 => "Ten", 
			        11 => "Eleven", 
			        12 => "Twelve", 
			        13 => "Thirteen", 
			        14 => "Fourteen", 
			        15 => "Fifteen", 
			        16 => "Sixteen", 
			        17 => "Seventeen", 
			        18 => "Eighteen", 
			        19 => "Nineteen" 
			        ); 
			$tens = array( 
			        0 => "",
			        2 => "Twenty", 
			        3 => "Thirty", 
			        4 => "Forty", 
			        5 => "Fifty", 
			        6 => "Sixty", 
			        7 => "Seventy", 
			        8 => "Eighty", 
			        9 => "Ninety" 
			        ); 
			$hundreds = array( 
			        "Hundred", 
			        "Thousand", 
			        "Million", 
			        "Billion", 
			        "Trillion", 
			        "Quadrillion" 
			        );
			$num = number_format($num,2,".",","); 
			$num_arr = explode(".",$num); 
			$wholenum = $num_arr[0]; 
			$decnum = $num_arr[1]; 
			$whole_arr = array_reverse(explode(",",$wholenum)); 
			krsort($whole_arr); 
			$rettxt = ""; 
			foreach($whole_arr as $key => $i){ 
			if($i < 20){ 
			    $rettxt .= $ones[$i]; 
			}
			elseif($i < 100){ 
			    $rettxt .= $tens[substr($i,0,1)]; 
			    $rettxt .= " ".$ones[substr($i,1,1)]; 
			}
			else{ 
			    $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
			    $rettxt .= " ".$tens[substr($i,1,1)]; 
			    $rettxt .= "".$ones[substr($i,2,1)]; 
			} 
			if($key > 0){ 
			    $rettxt .= " ".$hundreds[$key]." "; 
			} 

			} 
			$rettxt = $rettxt."Pesos";

			if($decnum > 0){ 
			$rettxt .= " and "; 
			if($decnum < 20){ 
			    $rettxt .= $decones[$decnum]; 
			}
			elseif($decnum < 100){ 
			    $rettxt .= $tens[substr($decnum,0,1)]; 
			    $rettxt .= " ".$ones[substr($decnum,1,1)]; 
			}
			$rettxt = $rettxt." Centavos"; 
			} 
			return $rettxt;
		}

		$or = $this->paymentmodel->getOR($id);
		$items = $this->paymentmodel->getORItems($id);

		// add a page
		$pdf->SetY(34);$pdf->SetFont('Arial','',17);
		$pdf->Cell(71,8,$or[0]->receiptno,0,1,'R');
		$pdf->SetY(46);$pdf->SetFont('Arial','',10);
		$pdf->Cell(78,7,date("d-M-y h:i A", strtotime($or[0]->offdate)),0,1,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(54,3,'PHILIPPINE NUCLEAR',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(28,3,$or[0]->fund,0,1,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(56,3,'RESEARCH INSTITUTE ',0,0,'R');

		$pdf->SetY(61);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(15,4,'',0,0,'L');
		$pdf->MultiCell(70, 3, utf8_decode(strtoupper($or[0]->payor)),'','L');

		$pdf->SetY(80);
		$tot = 0;
		foreach ($items as $i) {
			$pdf->SetFont('Arial','',9.5);
			$ccnt = ceil(mb_strlen($i->des) /25);
				$start_y = $pdf->GetY();
				$start_x = $pdf->GetX();
				$pdf->MultiCell(40, 3, utf8_decode(strtoupper($i->des)),'','L');
				$y = $pdf->GetY(); 
				$pdf->SetXY($start_x + 40, $start_y);
				// $start_y = $y;

				$start_x = $pdf->GetX();
				$pdf->MultiCell(25, 3, $i->acc,'','C');
				$pdf->SetXY($start_x + 25, $start_y);
				$start_y = $y;

				$pdf->Cell(20, 3, number_format($i->amt, 2),'',0,'R');
				$pdf->SetY($start_y);

			$tot += $i->amt;
		}
		$lddap = (strpos($or[0]->paytype, 'lddap') !== false) ? "LDDAP" : "";
		$cashamt = (strpos($or[0]->paytype, 'cash,') !== false) ? "  Cash: ".$or[0]->cashamt : "";
		$jo =  $or[0]->jo ? " JO: ".$or[0]->jo : "";
		// $pdf->Cell(20, 3, "",'',1,'R');
		$pdf->Cell(85, 3, $lddap.$cashamt.$jo,'',0,'L');
		$pdf->SetY(123); $pdf->Cell(85, 3, number_format($tot, 2),'',0,'R');
		$pdf->SetY(131); $pdf->Cell(28, 3, '','',0,'R');

		$exp = explode('.', $tot);
		$f = new NumberFormatter("en_US", NumberFormatter::SPELLOUT);
		$pdf->MultiCell(70, 3, ucwords($f->format($exp[0])  . numtowords("0.".$exp[1])),'','L');
		

		$pdf->SetY(144);
		$pdf->Cell(25, 3, ((strpos($or[0]->paytype, 'cash') !== false) ? "X" : ""),'',1,'L');

		$pdf->SetY(150);
		$pdf->Cell(20, 3, ((strpos($or[0]->paytype, 'check') !== false) ? "X" : ""),'',0,'L');
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(50, 3, ((strpos($or[0]->paytype, 'check') !== false) ? $or[0]->drawee."/".$or[0]->bankno : ""),'',0,'L');
		// $pdf->MultiCell(50, 3, ((strpos($or[0]->paytype, 'check') !== false) ? $or[0]->drawee."/".$or[0]->bankno : ""),'','L');
		$pdf->Cell(10, 3, ((strpos($or[0]->paytype, 'check') !== false) ? $or[0]->checkdate : ""),'',1,'L');

		$pdf->SetY(155);$pdf->SetFont('Arial','',10);
		$pdf->Cell(20, 3, ((strpos($or[0]->paytype, 'moneyorder') !== false) ? "X" : ""),'',0,'L');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(45, 3, ((strpos($or[0]->paytype, 'moneyorder') !== false) ? $or[0]->MOno : ""),'',0,'L');
		$pdf->Cell(10, 3, ((strpos($or[0]->paytype, 'moneyorder') !== false) ? $or[0]->MOdate : ""),'',1,'L');

		$pdf->SetFont('Arial','',10);
		$pdf->SetY(170); 
		$pdf->Cell(40, 3,'',0,0,'C');
		$pdf->Cell(30, 3,strtoupper($this->db->query("SELECT sig_name FROM payment.r_config WHERE sig_id = 1")->row()->sig_name),0,1,'C');
		$pdf->Cell(40, 3,'',0,0,'C');
		$pdf->Cell(30, 3,$this->db->query("SELECT sig_des FROM payment.r_config WHERE sig_id = 1")->row()->sig_des,0,1,'C');
		ob_clean();
		$pdf->Output();

	}
}
?>