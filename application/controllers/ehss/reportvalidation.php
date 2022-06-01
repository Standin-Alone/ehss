<?php defined('BASEPATH') OR exit('No direct script access allowed');

class reportvalidation extends CI_Controller{
    public function __construct(){
        parent::__construct();
      if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
        redirect('access/');
    }
  
    public function index(){
      $data['gmenu'] = "ehss";
      $data['menu'] = "report_validation";
      
  
      $this->load->view('template/headerlea', $data);
      $this->load->view('ehss/reportvalidation', $data);
      $this->load->view('template/footer');
    }
  
    public function manage(){
      $data['gmenu'] = "";
      $data['menu'] = "";
  
      $this->load->view('template/headerlea', $data);
      $this->load->view('ehss/manage');
      $this->load->view('template/footer');
    }

    public function report_validation(){
        $rvalidation = $this->EhssModel->report_validation();
        
        
        return $this->output->set_content_type('application/json')->set_output($rvalidation);
         
      }




      public function validate_report($report_id){

     

        $report = $this->db->select('*')->from('ehss.t_report as tr')     
              ->join('users as u','u.users_id = tr.user_id')
              ->join('employee as emp','u.employee_employee_id = emp.employee_id')              
              ->where('report_id',$report_id)->get()->row();

        $get_attachments = $this->db->select('*')->from('ehss.t_attachments')->where('report_id',$report_id)->get()->row();


        $data['gmenu'] = "";
        $data['menu'] = "";
        $data['report'] = $report;
        $data['attachments'] = $get_attachments;
        $this->load->view('template/headerlea',$data);
        $this->load->view('ehss/validate_report',$report);
        $this->load->view('template/footer');

      }


      public function mark_as_valid(){
        $mark_as_valid = $this->EhssModel->mark_as_valid();
        
        
        return $this->output->set_content_type('application/json')->set_output($mark_as_valid);
         
      }




      public function email_template_IMT(){
        $this->load->view('ehss/emailtemplateIMT');
      }

      public function email_template_EMT(){
        $this->load->view('ehss/emailtemplateEMT');
      }

      public function email_template_PIRT(){
        $this->load->view('ehss/emailtemplatePIRT');
      }

      public function email_template_IRST(){
        $this->load->view('ehss/emailtemplateIRST');
      }


}
?>