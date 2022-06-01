<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
Class EhssModel extends CI_Model
{
    public function load_reports(){
        $reports = $this->db->select('*')->from('ehss.t_report')->get()->result();
        $response = array(
            "draw" => 1,
            "recordsTotal" => count($reports),
            "recordsFiltered" => count($reports),
            "data" => $reports
          );    
        
        return json_encode($response);
    }

    public function report_validation(){
        $rvalidation = $this->db->select('*')->from('ehss.t_report')->get()->result();
        $response = array(
            "draw" => 1,
            "recordsTotal" => count($rvalidation),
            "recordsFiltered" => count($rvalidation),
            "data" => $rvalidation
          );    
        
        return json_encode($response);
    }

    public function review_report(){
        $rreports = $this->db->select('*')->from('ehss.t_report')->get()->result();
        $response = array(
            "draw" => 1,
            "recordsTotal" => count($rreports),
            "recordsFiltered" => count($rreports),
            "data" => $rreports
          );    
        
        return json_encode($response);
    }

    public function hazard(){
        $hazard = $this->db->select('*')->from('ehss.hazards')->get()->result();
        $response = array(
            "draw" => 1,
            "recordsTotal" => count($hazard),
            "recordsFiltered" => count($hazard),
            "data" => $hazard
        );

        return json_encode($response);
    }

    public function load_incident(){
        $incident = $this->db->select('*')->from('ehss.incident')->get()->result();
        $response = array(
            "draw" => 1,
            "recordsTotal" => count($incident),
            "recordsFiltered" => count($incident),
            "data" => $incident
        );
        return json_encode($response);
    }


    public function getEmail($user_level_id){

        $get_email = $this->db->select('*')
                            ->from('infosys.users as u')
                            ->join('infosys.userlevel as ul','u.users_id = ul.users_users_id')
                            ->join('infosys.employee as emp','u.employee_employee_id = emp.employee_id')
                            ->where('userlevelref_userlevelref_id',$user_level_id)
                            ->get()->result();

        return $get_email;

    }


    public function insert_report(){

        $this->load->config('email');			
        $this->load->library('email');

        $result = [];
       
        $location = $this->input->post('location');
        $description = $this->input->post('description');        
      	$generate_uuid = Uuid::uuid4()->toString();
        
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'jpg|png';
    

        $this->load->library('upload', $config);

        if($this->upload->do_upload('attachment')){

             $insert_report = $this->db->insert('ehss.t_report',[
                            'user_id' =>$this->session->userdata('userid'),
                            'report_id'=>$generate_uuid,
                            'location'=>$location, 
                            'details'=>$description,
             ]);


            if($insert_report){
                $upload_data = $this->upload->data();
                $generate_attachment_uuid  = Uuid::uuid4()->toString();

                $insert_attachments = $this->db->insert('ehss.t_attachments',[
                    'report_id'=>$generate_uuid,
                    'attachment_id'=>$generate_attachment_uuid, 
                    'file_name'=>$upload_data['file_name']
                ]);    


                if($insert_attachments){
                    $user_level_id  = 7; // DIVISION CHIEF
                    foreach($this->getEmail($user_level_id) as $row){

                        $from = $this->config->item('smtp_user');
                        $to = $row->email_address;
                        $subject = 'Report Details';
                        $url= base_url() . 'ehss/reportvalidation/validate_report/'. $generate_uuid;
                        

                        $data['url'] = $url ;
                        $data['reporter_name'] =  $row->firstname.' '.$row->lastname;

                   
                        $this->email->from($from, 'PNRI');
                        $this->email->to($to);
                        $this->email->subject($subject);
                        $load_view = $this->load->view('ehss/emailtemplate',$data,true);
                        $this->email->message($load_view);

                        $this->email->send();
                         
                    }

                    $result = ['status'=>true,
                    'message'=>'Report has been successfully added.'];
                }else{
                    $result = ['status'=>false,
                    'message'=>"Report does not added."];
                }
                
            } else {
                $result = ['status'=>false,
                'message'=>"Report does not added."];
            }
            return json_encode($result);
        }

        
    }

    public function insert_report2(){
        $result = [];
        $location = $this->input->post('location');
        $description = $this->input->post('description');

        $insert_report2 = $this->db->insert('ehss.t_report',['location'=>$location,
        'details'=>$description,
        'report_id'=>Uuid::uuid4()->toString()
    ]);
    }

    

    public function mark_as_valid(){
        $result = [];
        $report_id = $this->input->post('report_id');

        

        $insert_report2 = $this->db->insert('ehss.t_report',['location'=>$location,
            'details'=>$description,
            'report_id'=>Uuid::uuid4()->toString()
        ]);

    }
    
}
