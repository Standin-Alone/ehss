<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Announcements extends CI_Controller{
	public function __construct() {
	    parent::__construct();
		if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
			redirect('access/');
	}

	public function index(){
		$data['menu'] = "announcement";
		$data['gmenu'] = "";

		$data['announcements'] = $this->intranetModel->get_announcements();
		$this->session->set_userdata("menu", "announcement");

		$this->load->view('template/header', $data);
		$this->load->view('hr/announcements');
		$this->load->view('template/footer');
	}

	function get_announcements(){
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->intranetModel->get_announcements()));
	}

	function update_announcement(){
		$this->intranetModel->update_announcement();
	}
	function update_announcement2(){
		$this->intranetModel->update_announcement2();
	}
	function save_announcement(){
		$this->intranetModel->save_announcement();
	}



}
?>
