<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payslip extends CI_Controller 
{
	public function __construct(){
	    parent::__construct();
		// if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
		// 	redirect('access/');
		// $this->load->library('Fpdi');
	}

	public function index(){
		$data['menu'] = "receipt";
		$data['gmenu'] = "payment";

		$this->load->view('template/header', $data);
		$this->load->view('cash/receipt');
		$this->load->view('template/footer');
	}
}
?>