<?php defined('BASEPATH') OR exit('No direct script access allowed');

class addreportv2 extends CI_Controller {
  public function __construct(){
      parent::__construct();
    if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
      redirect('access/');
  }

  public function index(){
    $data['gmenu'] = "ehss";
    $data['menu'] = "add_report";

    $this->load->view('template/headerlea', $data);
    $this->load->view('ehss/addreportv2', $data);
    $this->load->view('template/footer');
  }

  public function manage(){
    $data['gmenu'] = "";
    $data['menu'] = "";

    $this->load->view('template/headerlea', $data);
    $this->load->view('ehss/manage');
    $this->load->view('template/footer');
  }

  public function load_reports(){
    $reports = $this->EhssModel->load_reports();
    
    
    return $this->output->set_content_type('application/json')->set_output($reports);
     
  }

  public function email_template(){
    $this->load->view('ehss/emailtemplate');
  }

  public function hazard(){
    $hazard = $this->EhssModel->hazard();

    return $this->output->set_content_type('application/json')->set_output($hazard);
  }

  public function load_incident(){
    $incident = $this->EhssModel->load_incident();

    return $this->output->set_content_type('application/json')->set_output($incident);
  }

  public function insert_report(){
    $insert_report = $this->EhssModel->insert_report();

    return $this->output->set_content_type('application/json')->set_output($insert_report);
    
  }

  public function insert_report2(){
    $insert_report2 = $this->EhssModel->insert_report2();

    return $this->output->set_content_type('application/json')->set_output($insert_report2);
    
  }
}
?>
