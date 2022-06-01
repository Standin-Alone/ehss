<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jo extends CI_Controller {
	public function __construct() {
	    parent::__construct();
		if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
			redirect('access/');
	}

	public function test($emp_id) {
		echo "<pre>";
		print_r($this->EssModel->get_ess_role($emp_id));
		echo "</pre>";
	}

  public function index() {
    $data['gmenu'] = "joborder";
    $data['menu'] = "engservices";

    $this->load->view('template/header', $data);
    $this->load->view('ess/jo');
    $this->load->view('template/footer');
  }

	public function create_jo() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->EssModel->create_jo($this->input->post())));
	}

	public function create_jo_test() {
		echo "<pre>";
		print_r($this->EssModel->create_jo($this->input->post()));
		echo "</pre>";
	}

	public function get_all_essjo() { $output = null;
		$output = $this->EssModel->get_all_essjo();
		$response = array(
			'aaData' => $output,
			'iTotalRecords' => count($output),
			'iTotalDisplayRecords' => count($output),
			'iDisplayStart' => 0
		);

		if (isset($_REQUEST['sEcho'])) { $response['sEcho'] = $_REQUEST['sEcho']; }

		header("Content-Type: application/json", true); echo json_encode($response);
	}

	public function get_status_history_modal($oshm_id) { $output = null;
		$output = $this->EssModel->get_status_history_modal($oshm_id);
		$response = array(
			'aaData' => $output,
			'iTotalRecords' => count($output),
			'iTotalDisplayRecords' => count($output),
			'iDisplayStart' => 0
		);

		if (isset($_REQUEST['sEcho'])) { $response['sEcho'] = $_REQUEST['sEcho']; }

		header("Content-Type: application/json", true); echo json_encode($response);
	}

	public function view_selected_jo() {
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->EssModel->view_selected_jo($this->input->post('jo_id'))));
	}

}
?>
