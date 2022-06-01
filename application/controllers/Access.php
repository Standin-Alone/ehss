<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller {
	public function indexx(){
		$this->load->view('login');
	}
	public function index(){
		// $data['articles'] = $this->intranetModel->get_articles();
		// $data['announcements'] = $this->intranetModel->get_announcements();
		// $data['posts'] = $this->intranetModel->get_posts();
		// $this->load->view('login2', $data);
		$this->load->view('login');
	}

	public function index2(){
		$data['articles'] = $this->intranetModel->get_articles();
		$data['announcements'] = $this->intranetModel->get_announcements();
		$this->load->view('login2', $data);
	}
	public function login(){
		$output = null;
		$response = null;
		$output = $this->accessmodel->login($_POST);

		header("Content-Type: application/json", true);
		$this->output->set_output(print(json_encode($output)));
		exit();
	}

	public function logout(){
		$res = $this->accessmodel->logout();
		$this->session->sess_destroy();
		redirect('access');
	}

	public function extra403(){
		$this->load->view('errors/extra_403');
	}
}
