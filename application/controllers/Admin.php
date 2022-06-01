<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{
	public function __construct(){
	    parent::__construct();
		if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
			redirect('access/');
	}
	
	public function updateAcc()
	{
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->adminmodel->updateAcc()));
	}
	
	public function newAcc()
	{
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->adminmodel->newAcc()));
	}
}
?>
