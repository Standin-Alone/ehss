<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller{
	public function __construct() {
	    parent::__construct();
		if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
			redirect('access/');
	}

	public function index(){
		$data['menu'] = "survey";
		$data['gmenu'] = "survey";
		
		$this->load->view('template/header', $data);
		$this->load->view('survey');
		$this->load->view('template/footer');
	}

	public function loadLogs()
	{
		$output = null;
		$output = $this->logsmodel->getSurvey();
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
		/* $list= $this->logsmodel->exportSurveyCSV();
		header("Content-type: text/x-csv");
		header("Content-Disposition: attachment; filename='InfoSys - Survey Logs.csv'");
        echo $list; */
        $file_name = 'Survey'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$file_name"); 
		header("Content-type: text/x-csv");

        $this->db->select("DATE_FORMAT(date_answered, '%Y-%m-%d %H:%i') dt,  `service`, `name`, `company`, `contact`, `timeliness`, `competence`, `courtesy`, `environment`, `quality`, `comments`");
        $this->db->where('sec', $this->session->userdata('SECTION_ID'));
        $this->db->from('helpdesk.satisfactory_answers_outside');
        $list = $this->db->get();

        // file creation 
        $file = fopen('php://output', 'w');

        $header = array("Datetime","Service","Customer","Company","Contact#","Timeliness","Competence","Courtesy","Environment","Quality","Comment"); 
        fputcsv($file, $header);
        foreach ($list->result_array() as $key => $value)
        { 
            fputcsv($file, $value); 
        }
        fclose($file); 
        exit; 
	}
}
?>