<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment extends CI_Controller 
{
	public function __construct(){
	    parent::__construct();
	    // $this->load->library("Pdf");
		$this->load->library('Fpdf_gen');
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
		$pdf->setMargins(10, 34);
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

		$pdf->SetY(56);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(15,4,'',0,0,'L');
		$pdf->MultiCell(80, 3, utf8_decode(strtoupper($or[0]->payor)),'','L');

		$pdf->SetY(75);
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
		$lddap = (strpos($or[0]->paytype, 'lddap') !== false) ? "LDDAP" : "";
		$cashamt = (strpos($or[0]->paytype, 'cash,') !== false) ? "  Cash: ".$or[0]->cashamt : "";
		$jo =  $or[0]->jo ? " JO: ".$or[0]->jo : "";
		// $pdf->Cell(20, 3, "",'',1,'R');
		$pdf->Cell(85, 3, $lddap.$cashamt.$jo,'',0,'L');
		$pdf->SetY(123); $pdf->Cell(85, 3, number_format($tot, 2),'',0,'R');
		$pdf->SetY(128); $pdf->Cell(25, 3, '','',0,'R');
		$pdf->MultiCell(70, 3, numtowords($tot),'','L');
		

		$pdf->SetY(142);
		$pdf->Cell(25, 3, ((strpos($or[0]->paytype, 'cash') !== false) ? "X" : ""),'',1,'L');
		$pdf->Cell(20, 3, ((strpos($or[0]->paytype, 'check') !== false) ? "X" : ""),'',0,'L');
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(50, 3, ((strpos($or[0]->paytype, 'check') !== false) ? $or[0]->drawee."/".$or[0]->bankno : ""),'',0,'L');
		$pdf->Cell(10, 3, ((strpos($or[0]->paytype, 'check') !== false) ? $or[0]->checkdate : ""),'',1,'L');
		$pdf->SetY(152);
		$pdf->SetY(147);$pdf->SetFont('Arial','',10);
		$pdf->Cell(20, 3, ((strpos($or[0]->paytype, 'moneyorder') !== false) ? "X" : ""),'',0,'L');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(45, 3, ((strpos($or[0]->paytype, 'moneyorder') !== false) ? $or[0]->MOno : ""),'',0,'L');
		$pdf->Cell(10, 3, ((strpos($or[0]->paytype, 'moneyorder') !== false) ? $or[0]->MOdate : ""),'',1,'L');

		$pdf->SetFont('Arial','',10);
		$pdf->SetY(167); 
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
				$pglen = (strlen($particulars) > 200) ? 240 : 200;
				if($pdf->GetY()>$pglen){
					$this->printMonthlyFooter($pdf, $total);
					$this->printMonthlyHeader($pdf, $fund,$fr,$to);
					$total = 0;
				}
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
		$pdf->SetY(240);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(128.5, 7,'Total This Page ','',0,'R');
		$pdf->SetFont('Courier','B',10);
		$pdf->Cell(50, 4,number_format($total,2),'',1,'R');
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
			$pglen = (strlen($particulars) > 200) ? 240 : 200;
			if($pdf->GetY()>$pglen){
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
			$pglen = (strlen($particulars) > 200) ? 240 : 200;
			if($pdf->GetY()>$pglen){
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
}
?>