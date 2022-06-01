<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller{
	public function __construct() {
	    parent::__construct();
		if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
			redirect('access/');
	}

	public function getSections(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->commonmodel->getSections()));
	}

	public function getRoles(){
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->commonmodel->getRoles(0)));
	}
	
	public function add()
	{
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->commonmodel->add($this->input->post('tbl'), $this->input->post('udata'))));
	}
	
	public function update()
	{
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->commonmodel->update($this->input->post('tbl'), $this->input->post('udata'), $this->input->post('id'), $this->input->post('col'))));
	}
	
	public function updateWhere()
	{
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->commonmodel->updateWhere($this->input->post('tbl'), $this->input->post('udata'), $this->input->post('con'))));
	}
	
	public function updateQuery()
	{
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->commonmodel->updateQuery($this->input->post('sql'))));
	}
	
	public function replace()
	{
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->commonmodel->replace($this->input->post('tbl'), $this->input->post('udata'), $this->input->post('con'))));
	}
	
	public function delete()
	{
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->commonmodel->delete($this->input->post('tbl'), $this->input->post('id'), $this->input->post('col'))));
	}
	
	public function deac()
	{
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->commonmodel->deac($this->input->post('tbl'), $this->input->post('id'), $this->input->post('col'), $this->input->post('cname'))));
	}
}
?>