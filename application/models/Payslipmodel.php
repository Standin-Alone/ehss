<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class PayslipModel extends CI_Model
{
	function index()
	{
		$result = array();
		$query_result = $this->db->query("SELECT mp.emplid, mp.saldate, mp.paycat, mp.salary, mp.pera,
				mp.addlcomp, mp.grsalary, mp.wtax, mp.gsis, mp.phlhealth,
				mp.pagibig, mp.salaryded, mp.peraded, mp.addlcompded,
				mp.totalded, mp.netsalary, 
				mp.mpayid, mp.lwop, mp.ut, mp.al_hazard, mp.al_subs, mp.al_laundry, mp.al_longevity, mp.netbasicsal, mp.nethazard, mp.netlongi, mp.al_rata, mp.netsaltaxable, mp.netsala, mp.hazardwtax, mp.longiwtax, mp.sala, mp.saladed, mp.actlhazpay, mp.netsalwtax, mp.hazpaydis, salawtax FROM payroll_sbg.monthlypay mp JOIN payroll_sbg._payroll on _saldate = saldate JOIN infosys.employee e on mp.emplid = e.employee_id WHERE _islocked = 1 and _isdeleted = 0 AND e.employee_id = ".$this->session->userdata('empid'));
		if ($query_result->num_rows() > 0){
			foreach ( $query_result->result() as $rows ){

				$ttlGrossPay = $rows->salary + $rows->pera + $rows->sala + $rows->al_longevity + $rows->actlhazpay;
				$HazardPayLWOP = $rows->actlhazpay - $rows->al_hazard;

				$EmplSaLaDed = $rows->sala - $rows->netsala;
				$EmplTotalDed = $rows->totalded + $EmplSaLaDed + $HazardPayLWOP;// + $rows->salawtax;
				//LOANS:
				$qrloan = $this->db->query("SELECT monthlypayded.empid, monthlypayded.dedcod, monthlypayded.dedamount, loanded.coddes,
										 loanded.description, monthlypayded.saldate
											FROM payroll_sbg.monthlypayded, payroll_sbg.loanded
											WHERE monthlypayded.empid = '$rows->emplid' AND monthlypayded.dedcod = loanded.coddes
											AND monthlypayded.saldate = '$rows->saldate'");
				if($qrloan->num_rows() > 0)
				{
					foreach($qrloan->result() as $loan)
					{
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
				}else{

				}
				$EmplNetAllowances = $rows->netsala + $rows->nethazard + $rows->netlongi;
				$EmplTakeHomePay = $rows->netbasicsal + $EmplNetAllowances;


				$result[] = array(
					html_escape($rows->saldate),
					html_escape(number_format($rows->salary,2)),
					html_escape(number_format($ttlGrossPay,2)),
					html_escape(number_format($EmplTotalDed,2)),
					html_escape(number_format(($EmplTakeHomePay),2)),
					// "<center><a href='http://www.facebook.com/sharer' target='_blank' onclick=\"window.open(this.href, 'mywin','left=300,top=100, width=900,height=300'); return false;\" glose='Print' class='tags btn-primary btn-sm'><i class='fa fa-print'></i><span></span></a></center>"
					"<center><a onclick=\"sendPayslip1(".$rows->mpayid.")\" glose='Send to email' class='hidden tags btn btn-sm btn-default font-red btnsendpay'><i class='font-red fa fa-envelope-o'></i><span></span></a> <a onclick=\"openwin('".$rows->mpayid."', ".$rows->emplid.")\" glose='Print' class='tags btn btn-sm btn-default font-green'><i class='fa fa-print font-green'></i><span> </span></a></center>"
					);
			}
		}
		return $result;
	}
}
?>
