<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller{
	public function __construct() {
	    parent::__construct();
		if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
			redirect('access/');
	}

	public function index(){
		$data['menu'] = "logs";
		$data['gmenu'] = "config";
		
		$this->load->view('template/header', $data);
		$this->load->view('sm_logs');
		$this->load->view('template/footer');
	}

	public function loadLogs()
	{
		$output = null;
		$output = $this->logsmodel->getLogs();
		$response = array(
		  'aaData' => $output,
		  'iTotalRecords' => count($output),
		  'iTotalDisplayRecords' => count($output),
		  'iDisplayStart' => 0
		);

		header("Content-Type: application/json", true);
		echo json_encode($response);
	}

	public function exportCSV(){
		$list= $this->logsmodel->exportCSV();
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename='PeS - List of Logs.csv'");
        echo $list;
	}

	public function gpGender()
	{
		$output = null;
		$output = $this->logsmodel->gpGender();

		header("Content-Type: application/json", true);
		echo $output;
	}

	public function gpAge()
	{
		$output = null;
		$output = $this->logsmodel->gpAge();

		header("Content-Type: application/json", true);
		echo $output;
	}

	public function getStats()
	{
		$output = null;
		$output = $this->logsmodel->getStats();

		header("Content-Type: application/json", true);
		echo $output;
	}
}
?>