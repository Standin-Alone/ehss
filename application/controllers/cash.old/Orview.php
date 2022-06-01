<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Orview extends CI_Controller 
{
	public function __construct(){
	    parent::__construct();
		$this->load->library('Fpdi');
	}

	public function index($id){

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
		$pdf->SetY(168); 
		$pdf->Cell(40, 3,'',0,0,'C');
		$pdf->Cell(30, 3,strtoupper($this->db->query("SELECT sig_name FROM payment.r_config WHERE sig_id = 1")->row()->sig_name),0,1,'C');
		$pdf->Cell(40, 3,'',0,0,'C');
		$pdf->Cell(30, 3,$this->db->query("SELECT sig_des FROM payment.r_config WHERE sig_id = 1")->row()->sig_des,0,1,'C');
		ob_clean();
		$pdf->Output();

	}
}
?>