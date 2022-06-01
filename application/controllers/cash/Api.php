<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// header('Access-Control-Allow-Origin: *');
class Api extends CI_Controller 
{
	public function __construct(){
	    parent::__construct();
	}

	public function index(){
		if($this->input->post('hash', TRUE) == md5('2021030672' . date('m-d-Y') . 'CAXLT86Mvt')){
            $data = array(
                'epp' => $this->input->post('epp', TRUE),
                'mrn' => $this->input->post('merchant_reference_number', TRUE),
                'sIp' => $this->input->ip_address()
            );

            if($this->db->insert("payment_online.epp", $data)){
                $id = $this->db->insert_id();
                $this->db->query("INSERT INTO payment_online.logs (log_action, mrn, log_des) VALUES ('SUCCESS', '".$this->input->post('merchant_reference_number', TRUE)."', '')");
                $this->output->set_content_type("application/json")->set_output(json_encode("Success"));
            }else{
                $err = $this->db->error();
                $this->db->query("INSERT INTO payment_online.logs (log_action, mrn, log_des) VALUES ('FAILED', '".$this->input->post('merchant_reference_number', TRUE)."', '".addslashes($err['message'])."')");
                $this->output->set_content_type("application/json")->set_output(json_encode($err));
            }
        }else{
            $this->output->set_content_type("application/json")->set_output(json_encode("Invalid Hash"));
        }
	}
}
?>