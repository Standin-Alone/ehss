<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class PaymentModel extends CI_Model
{
	public function read($tbl){
		$result = array();
		$sql = "";
		$fund = $this->uri->segment(5);
		$fr = $this->uri->segment(6);
		$to = $this->uri->segment(7);
		$type = $this->uri->segment(8);
		switch ($tbl){
			case "soaonline":
			case "soa":
				/*$sql = "SELECT p.receiptno, payid REC, statements.ID, NAME, INITIALS, SECTION, REF_CODE, date_format(DATE_CREATED, '%Y-%m-%d') DT, PAYEE, COMPANY, CREATE_DATE, p.status, (SELECT sum(A_AMOUNT) amt FROM statement.items WHERE STATEMENT_ID = statements.ID) amt FROM statement.statements LEFT JOIN payment.t_payment p on ID = soaid WHERE (REF_CODE IN (SELECT REF_CODE FROM statement.statements WHERE REV_ID IS NULL AND ID NOT IN (SELECT REV_ID FROM statement.statements WHERE REV_ID IS NOT NULL)) OR REF_CODE IN (SELECT MAX(REF_CODE) FROM statement.statements WHERE REV_ID IS NOT NULL GROUP BY REV_ID)) AND ACTIVE";*/
				$ftr = ($fr) ? " AND date(DATE_CREATED) BETWEEN '$fr' AND '$to'" : "";
				$ftr = !$type ? $ftr : ($type==1 ? $ftr." AND EPAY_TYPE = 1" : $ftr." AND EPAY_TYPE = 0");
				$sql = "SELECT EPAY_TYPE, p.receiptno, payid REC, statements.ID, NAME, INITIALS, SECTION, REF_CODE, date_format(DATE_CREATED, '%Y-%m-%d') DT, PAYEE, COMPANY, CREATE_DATE, p.status FROM statement.statements LEFT JOIN payment.t_payment p on ID = soaid WHERE (REF_CODE IN (SELECT REF_CODE FROM statement.statements WHERE REV_ID IS NULL AND ID NOT IN (SELECT REV_ID FROM statement.statements WHERE REV_ID IS NOT NULL)) OR REF_CODE IN (SELECT MAX(REF_CODE) FROM statement.statements WHERE REV_ID IS NOT NULL GROUP BY REV_ID)) AND ACTIVE $ftr or receiptno is not null";
			break;
			case ("receipt" || "receiptXLS"):
				$ftr = ($fr) ? " AND date(offdate) BETWEEN '$fr' AND '$to'" : "";
				$ftr = !$type ? $ftr : ($type==1 ? $ftr." AND paytype='online'" : $ftr." AND paytype<>'online'");
				$sql = "SELECT p.jo, fund, paytype, drawee, bankno, checkdate, MOno, MOdate, cashamt, status, payid, offdate, p.receiptno, payor COMPANY, (SELECT GROUP_CONCAT(des SEPARATOR ', ') FROM payment.t_item WHERE pid = payid GROUP BY pid) part, (SELECT sum(amt) FROM payment.t_item WHERE pid = payid) amt,TIME(pdt),TIME(offdate), SUBTIME(TIME(offdate),TIME(pdt)) hroff FROM payment.t_payment p WHERE fund = '$fund'".$ftr;
			break;
			case "admin_trans_type":
				$sql = "SELECT * FROM $tbl";
			break;
			default: 
				return 0;
		}
		// return $sql;

		$query_result = $this->db->query($sql);
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$orv = 0;
				switch ($tbl){
					case "soa":
						$stat = $rows->REC ? ($rows->status ? '' : '<br><span class="label label-sm label-default "> Canceled </span>') : '';
						$act = $rows->status ? '<a onclick="vwSOA('.$rows->ID.','.$rows->REC.')" href="#mreceipt" class="btn blue btn-xs" data-toggle="modal"><i class="fa fa-edit"></i>Edit</a> 
											<a onclick="printOR('.$rows->REC.')" class="btn green btn-xs"><i class="fa fa-print"></i> Print</a> 
											<a onclick="cancelORConfirm('.$rows->receiptno.','.$rows->REC.')" href="#mCancelOR" class="btn red btn-xs" data-toggle="modal"><i class="fa fa-times"></i></a>' : '<a onclick="vwSOA('.$rows->ID.',0);getCode();" href="#mreceipt" class="btn red btn-xs" data-toggle="modal"><i class="fa fa-send"></i> Re-issue Receipt </a>';

						$action = $rows->REC ? $act : '<a onclick="vwSOA('.$rows->ID.',0);getCode();" href="#mreceipt" class="btn red btn-xs" data-toggle="modal"><i class="fa fa-send"></i> Issue Receipt </a>';

						if (in_array("26", $this->session->userdata('uroles'))) {//accountant
							$action = "<center><i class='fa fa-lock'></i></center>";
							
						}
						else if (in_array("25", $this->session->userdata('uroles'))) {//cashier
						}

						$result[] = array(
							html_escape($rows->REF_CODE),
							html_escape($rows->PAYEE),
							html_escape($rows->COMPANY),
							html_escape($rows->DT),
							html_escape($rows->NAME),
							"<center>".$rows->receiptno.$stat."</center>",
							"<center>". $action ."</center>"
							);
						break;
					case "soaonline":
						$orv = $rows->EPAY_TYPE;
						$id = $rows->EPAY_TYPE ? $rows->receiptno : $rows->REC;
						$stat = $rows->REC ? ($rows->status ? '' : '<br><span class="label label-sm label-default "> Cancelled </span>') : '';
						$btnissue = '<a onclick="vwSOA('.$rows->ID.',0);getCode();" href="#mreceipt" class="btn red btn-xs" data-toggle="modal"><i class="fa fa-send"></i> Issue Receipt </a>';

						$epp = NULL;
						$rnum = $rows->receiptno;
						if($rows->EPAY_TYPE){
							// $rnum = '<span class="label label-sm label-default"> Cancelled </span>';
							$qrepay = $this->db->query("SELECT epp from payment_online.epp WHERE mrn = 'PNRI-".$rows->REF_CODE."'");
							if($qrepay->num_rows() > 0)
							{
								foreach($qrepay->result() as $eprow)
								{
									$epp = $eprow->epp;
									$rnum = '<span class="label label-sm label-success"> '.$epp.' </span>';
									// $action = $rows->receiptno ? $action : '<a onclick="vwSOA('.$rows->ID.',1);$(\'#recno\').val('.$epp.')" href="#mreceipt" class="btn green btn-xs" data-toggle="modal"><i class="fa fa-send"></i> Create Receipt </a>';
									// $act = $rows->status ? '<a onclick="vwSOA('.$rows->ID.','.$rows->REC.')" href="#mreceipt" class="btn blue btn-xs" data-toggle="modal"><i class="fa fa-edit"></i>Edit</a> 
									// 					<a onclick="printOR('.$id.','.$orv.')" class="btn green btn-xs"><i class="fa fa-print"></i> Print</a> 
									// 					<a onclick="cancelORConfirm('.$rows->receiptno.','.$rows->REC.')" href="#mCancelOR" class="btn red btn-xs" data-toggle="modal"><i class="fa fa-times"></i></a>' : '<a onclick="vwSOA('.$rows->ID.',0);getCode();" href="#mreceipt" class="btn red btn-xs" data-toggle="modal"><i class="fa fa-send"></i> Re-issue Receipt </a>';
									$btnissue = '<a onclick="vwSOA('.$rows->ID.',1);$(\'#recno\').val('.$epp.')" href="#mreceipt" class="btn green btn-xs" data-toggle="modal"><i class="fa fa-send"></i> Create Receipt </a>';
								}
							}
						}
						$act = $rows->status ? '<a onclick="vwSOA('.$rows->ID.','.$rows->REC.')" href="#mreceipt" class="btn blue btn-xs" data-toggle="modal"><i class="fa fa-edit"></i>Edit</a> 
											<a onclick="printOR('.$rows->REC.')" class="btn green btn-xs"><i class="fa fa-print"></i> Print</a> 
											<a onclick="cancelORConfirm('.$rows->receiptno.','.$rows->REC.')" href="#mCancelOR" class="btn red btn-xs" data-toggle="modal"><i class="fa fa-times"></i></a>' : '<a onclick="vwSOA('.$rows->ID.',0);getCode();" href="#mreceipt" class="btn red btn-xs" data-toggle="modal"><i class="fa fa-send"></i> Re-issue Receipt </a>';

						$action = $rows->REC ? $act : $btnissue;
						
						if(in_array("26", $this->session->userdata('uroles'))) {//accountant
							$action = "<center><i class='fa fa-lock'></i></center>";
						}

						$result[] = array(
							$rows->EPAY_TYPE ? '<a class="font-green">'.$rows->REF_CODE.'</a>' : $rows->REF_CODE,
							html_escape($rows->PAYEE),
							html_escape($rows->COMPANY),
							html_escape($rows->DT),
							html_escape($rows->NAME),
							"<center>".$rnum.$stat."</center>",
							"<center>". $action.'<a onclick="printSOC('.$rows->ID.')" class="btn yellow btn-xs"><i class="fa fa-print"></i> SOC</a> '."</center>"
							);
						break;
					case "receipt":
						$orv = $rows->paytype == 'online' ? 1 : 0;
						$id = $rows->paytype == 'online' ? $rows->receiptno : $rows->payid;
						$hroff = str_replace('-','',$rows->hroff);
						$stat = $rows->status ? '' : '<span class="label label-sm label-default "> Canceled </span>';
						$result[] = array(
							html_escape($rows->offdate),
							$hroff,
							html_escape($rows->receiptno).$stat,
							html_escape($rows->COMPANY),
							html_escape($rows->part),
							$rows->jo,
							$rows->fund,
							$rows->paytype,
							$rows->drawee,
							$rows->bankno,
							$rows->checkdate,
							$rows->MOno,
							$rows->MOdate,
							$rows->cashamt,
							html_escape($rows->amt),
							'<a onclick="printOR('.$id.','.$orv.')" class="btn green btn-xs"><i class="fa fa-print"></i> Print</a>'
						);
						break;
					default: 
						return 0;
				}
			}
		}
		else
			'Error';
		return $result;
	}

	function getStatement($id){
		$q = $this->db->query("SELECT *, ss.SECTION SSECTION, st.SIGNATORY SSIGNATORY, st.ID SID, DATE_FORMAT(DATE_CREATED, '%d-%b-%Y') DATE_CREATED
								FROM statement.statements st
								INNER JOIN statement.section ss
								ON ss.ID  = st.SECTION
								WHERE st.ID = ?", array($id));

		$result = $q->row_array();
		// $result['SERVICES'] = $this->db->query("SELECT i.*, s.title, s.account, DESCRIPTION FROM statement.items i LEFT JOIN statement.services s on s.sid = i.SERVICE WHERE STATEMENT_ID = ? ORDER BY i.SERVICE", array($id))->result();
		$result['SERVICES'] = $this->db->query("SELECT A_AMOUNT, i.ID, QUANTITY, DESCRIPTION, account, s.SERVICE, UNIT_PRICE FROM statement.items i INNER JOIN statement.services s on s.ID = i.SERVICE WHERE STATEMENT_ID = ? ORDER BY i.SERVICE", array($id))->result();
		// $result['REVISIONS'] = $this->db->query("SELECT ID, RIGHT(REF_CODE, 1) REV_NO FROM statement.statements WHERE REV_ID = ?", array($id))->result();
		return $result;
	}

	function getSignatory($id){
		$q = $this->db->query("SELECT sig_name, sig_des FROM payment.r_config WHERE sig_id = ".$id);

		$result = $q->row_array();
		return $result;
	}

	function getReceipt($id){//date_format(checkdate, '%m/%d/%Y') checkdate, 
		$q = $this->db->query("SELECT *, date_format(offdate, '%m/%d/%Y') d, date_format(offdate, '%H:%i') t FROM payment.t_payment WHERE payid = ".$id);

		$result = $q->row_array();
		$result['ITEMS'] = $this->db->query("SELECT * FROM payment.t_item WHERE pid = ".$id)->result();
		return $result;
	}

	function getOR($id){
		$query = $this->db->query("SELECT * FROM payment.t_payment WHERE payid = $id");
		return $query->result();
	}

	function getORbyNo($num){
		$query = $this->db->query("SELECT p.*, EPAY_TRANSACTION_TYPE, REF_CODE, EMAIL, (SELECT sum(amt) FROM payment.t_item WHERE pid = payid) amt FROM payment.t_payment p left join statement.statements s on s.ID = p.soaid WHERE receiptno = '$num'");
		return $query->result();
	}

	function getCode($type){
		$res=0;
		switch ($type) {
			case '101-I':
				$res = $this->db->query("select max(receiptno) + 1 orno from payment.t_payment where receiptno BETWEEN 8058501 and 8063300 and fund='".$type."'")->row('orno');
				break;
			
			case '184-MDS':
				$res = $this->db->query("select max(receiptno) + 1 orno from payment.t_payment where receiptno BETWEEN 8063401 and 8063500 and fund='".$type."'")->row('orno');
				break;
			
			default:
				$res = $this->db->query("select max(receiptno) + 1 orno from payment.t_payment where fund='".$type."'")->row('orno');
				break;
		}
		
		return $res;
	}

	function checkORNumber($no){
		return $this->db->query("select COUNT(*) AS total from payment.t_payment where receiptno='".$no."'")->row()->total;
		// $this->db->last_query();
	}

	function getORItems($id){
		$query = $this->db->query("SELECT des, acc, amt FROM payment.t_item WHERE pid = $id");
		return $query->result();
	}

	public function items($tbl, $id, $data, $act)
	{
		if($act=="add")
			return $this->db->insert_batch($tbl,$data);
		else
			return $this->db->update_batch($tbl, $data, 'iid');
		// foreach ($data as $value) {
		// 	if(isset($value['id'])){
		// 		$this->db->where('id', $value['id'])->update('payment.t_item', $value);
		// 	}
		// 	else {
		// 		$this->db->insert('payment.t_item', $value);
		// 	}
		// }
	}

	public function getDrawees(){
		$result = '<option value="">Select...</option>';
		$query_result = $this->db->query("SELECT draweebank FROM payment.r_drawee");
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result .= "<option>".$rows->draweebank."</option>";
			}
		}
		$query_result = $this->db->query("SELECT DISTINCT drawee FROM payment.t_payment WHERE drawee not in (select draweebank FROM payment.r_drawee)");
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$result .= "<option>".$rows->drawee."</option>";
			}
		}
		return $result;
	}
}
?>