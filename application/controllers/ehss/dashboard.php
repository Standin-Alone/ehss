<?php defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller {
  public function __construct() {
      parent::__construct();
    if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
      redirect('access/');
  }

  public function index() {
    $data['gmenu'] = "";
    $data['menu'] = "";

    $this->load->view('template/headerlea', $data);
    $this->load->view('ehss/dashboard', $data);
    $this->load->view('template/footer');
  }

  public function manage() {
    $data['gmenu'] = "";
    $data['menu'] = "";

    $this->load->view('template/headerlea', $data);
    $this->load->view('ehss/manage');
    $this->load->view('template/footer');
  }



}
?>
