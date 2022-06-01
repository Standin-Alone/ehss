<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class ExportModel extends CI_Model
{
	public function getDaysPerMonth($fund,$fr,$to,$type){
		$ftr = !$type ? "" : ($type==1 ? " AND paytype='online'" : " AND paytype<>'online'");
		$query = $this->db->query("SELECT DISTINCT date_format(offdate, '%d-%b-%y') dtname, date(offdate) dt FROM payment.t_payment WHERE fund = '$fund' AND date(offdate) BETWEEN '$fr' AND '$to' $ftr ORDER BY offdate");
		return $query->result();
	}

	public function getPayments($fund,$dt,$type){
		$ftr = !$type ? "" : ($type==1 ? " AND paytype='online'" : " AND paytype<>'online'");
		$query = $this->db->query("SELECT payid, date_format(offdate, '%m/%d/%Y') dt, receiptno, ctrcode, payor, paytype FROM payment.t_payment WHERE fund = '$fund' AND date(offdate) = '$dt' $ftr ORDER BY date(offdate), receiptno");
		return $query->result();
	}

	public function getPaymentsLDDAP($fund,$dt,$type){
		// $ftr = !$type ? "" : ($type==1 ? " AND paytype='online'" : " AND paytype<>'online'");
		$query = $this->db->query("SELECT payid, date_format(offdate, '%m/%d/%Y') dt, receiptno, ctrcode, payor, MOdate, MOno, (SELECT sum(amt) FROM payment.t_item WHERE pid = payid) totamt FROM payment.t_payment WHERE paytype like '%lddap%' and fund = '$fund' AND date(offdate) = '$dt' ORDER BY date(offdate), receiptno");
		return $query->result();
	}

	public function getPaymentsReports($fund,$dt,$type){
		// $ftr = !$type ? "" : ($type==1 ? " AND paytype='online'" : " AND paytype<>'online'");
		$query = array();
		$query['totlddap'] = $this->db->query("SELECT sum(amt) val FROM payment.t_item LEFT JOIN payment.t_payment on pid = payid WHERE fund = '$fund' AND date(offdate) = '$dt' AND paytype like '%lddap%'")->row()->val;
		$query['totcntlddap'] = $this->db->query("SELECT count(payid) val FROM payment.t_payment WHERE fund = '$fund' AND date(offdate) = '$dt' AND paytype like '%lddap%'")->row()->val;

		$query['totnolddap'] = $this->db->query("SELECT sum(amt) val FROM payment.t_item LEFT JOIN payment.t_payment on pid = payid WHERE fund = '$fund' AND date(offdate) = '$dt' AND paytype not like '%lddap%'")->row()->val;
		$query['totcntnolddap'] = $this->db->query("SELECT count(payid) val FROM payment.t_payment WHERE fund = '$fund' AND date(offdate) = '$dt' AND paytype not like '%lddap%'")->row()->val;
		
		$query['totY'] = $this->db->query("SELECT sum(amt) val FROM payment.t_item LEFT JOIN payment.t_payment on pid = payid WHERE fund = '$fund' AND date(offdate) = DATE_SUB('$dt', INTERVAL 1 DAY)")->row()->val;
		$query['totcntY'] = $this->db->query("SELECT count(payid) val FROM payment.t_payment WHERE fund = '$fund' AND date(offdate) = DATE_SUB('$dt', INTERVAL 1 DAY) ")->row()->val;
		$query['totnolddapY'] = $this->db->query("SELECT sum(amt) val FROM payment.t_item LEFT JOIN payment.t_payment on pid = payid WHERE fund = '$fund' AND date(offdate) = DATE_SUB('$dt', INTERVAL 1 DAY) AND paytype not like '%lddap%'")->row()->val;
		return $query;
	}

	public function getPaymentsLDDAPY($fund,$dt,$type){
		// $ftr = !$type ? "" : ($type==1 ? " AND paytype='online'" : " AND paytype<>'online'");
		$query = $this->db->query("SELECT payid, date_format(offdate, '%m/%d/%Y') dt, receiptno, ctrcode, payor, MOdate, MOno FROM payment.t_payment WHERE paytype like '%lddap%' and fund = '$fund' AND date(offdate) = DATE_SUB('$dt', INTERVAL 1 DAY) ORDER BY date(offdate), receiptno");
		return $query->result();
	}

	public function getTotalperFundCode($fund,$acc,$dt,$type){
		$ftr = !$type ? "" : ($type==1 ? " AND paytype='online'" : " AND paytype<>'online'");
		$query = $this->db->query("SELECT COALESCE(sum(amt),0) totamt FROM payment.t_payment LEFT JOIN payment.t_item on pid = payid WHERE fund = '$fund' AND (date(offdate) BETWEEN $dt) AND acc = '$acc' $ftr");
		return $query->row_array()['totamt'];
	}
}
?>