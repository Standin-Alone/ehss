<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class EssModel extends CI_Model
{

  function create_ticket_number() { $ticket_number = "";
    $divCode = $this->session->userdata('divCode');
    $year = date("y");
    $ticket_code = "ESJO-".$divCode."-".$year."-";

    $ticket_number = $this->db->query("SELECT CONCAT( '$ticket_code', LPAD ( COALESCE( SUBSTRING_INDEX(MAX(`reference_no`), '-', -1), '0' ) + 1, 4, 0)
      ) AS `code`
      FROM `ess`.`job_order`
      WHERE `reference_no` LIKE '$ticket_code%'
      LIMIT 1")->row_array()["code"];

    return $ticket_number;
  }

  function get_ess_role($emp_id) {
    $query = $this->db->query("SELECT DISTINCT `employee_id`, `users_id`,
      `empno`, `firstname`, `lastname`, `division_id`, `division_code`,
      `userlevelref_id`, `level_desc`, `unit_id`, `unit_desc`
      FROM `infosys`.`userlevel`
      INNER JOIN `infosys`.`users`
      ON `users_users_id` = `users_id`
      INNER JOIN `infosys`.`userlevelref`
      ON `userlevelref_userlevelref_id` = `userlevelref_id`
      INNER JOIN `infosys`.`employee`
      ON `employee_employee_id` = `employee_id`
      INNER JOIN `infosys`.`division`
      ON `division_division_id` = `division_id`
      INNER JOIN `infosys`.`unit`
      ON `unit_unit_id` = `unit_id`
      WHERE (`userlevelref_userlevelref_id` IN(7, 34) OR unit_id = 30) AND `employee_id` = $emp_id
    ")->row_array();
    if($query) {
      $type = "high-user";
    }
    else { // Regular Employee
      $type = "end-user";
    }

    $query2 = $this->db->query("SELECT DISTINCT `employee_id`, `users_id`
      `empno`, `firstname`, `lastname`, `division_id`, `division_code`,
      `userlevelref_id`, `level_desc`, `unit_id`, `unit_desc`
      FROM `infosys`.`userlevel`
      INNER JOIN `infosys`.`users`
      ON `users_users_id` = `users_id`
      INNER JOIN `infosys`.`userlevelref`
      ON `userlevelref_userlevelref_id` = `userlevelref_id`
      INNER JOIN `infosys`.`employee`
      ON `employee_employee_id` = `employee_id`
      INNER JOIN `infosys`.`division`
      ON `division_division_id` = `division_id`
      INNER JOIN `infosys`.`unit`
      ON `unit_unit_id` = `unit_id`
      WHERE `employee_id` = $emp_id
    ")->row_array(); // TODO (AAB) Mali eto, follow ate sunrise session role array

    return array(
      "ess_role" => $type,
      "ess_divcode" => $query2["division_code"],
      "ess_level" => $query2["level_desc"],
      "ess_unit" => $query2["unit_desc"]
    );


  }

  function create_jo($input) { $output = array(); $files = array();

    $data = array(
      "reference_no" => $this->create_ticket_number(),
      "filled_dt" => $input["initial_date"] ." ". Date("H:i:s"),
      "target_date" => $input["target_date"],
      "purpose" => $input["purpose"],
      "description" => $input["description"],
      "employee_id" => $this->session->userdata('empid'),
      "employee_name" => $this->session->userdata('wname'),
      "employee_division" => $this->session->userdata('division')
    );
    $this->db->insert('ess.job_order', $data);
    if($this->db->affected_rows() > 0) {
      $jo_id = $this->db->insert_id();

      // Upload Attachment Start
      $config = array(
          'upload_path'   => './uploads/ess/',
          'allowed_types' => 'jpg|jpeg|gif|png|txt|csv|xlsx|xls|ppt|doc|docx',
          'overwrite'     => 1
      );

      $this->load->library('upload', $config);

      $images = array();

      $files = $_FILES;

      for($i=0; $i<count($files['attachment']['name']); $i++) {
          $_FILES['attachment']['name']= $files['attachment']['name'][$i];
          $_FILES['attachment']['type']= $files['attachment']['type'][$i];
          $_FILES['attachment']['tmp_name']= $files['attachment']['tmp_name'][$i];
          $_FILES['attachment']['error']= $files['attachment']['error'][$i];
          $_FILES['attachment']['size']= $files['attachment']['size'][$i];

          $fileName = $files['attachment']['name'][$i];

          $images[] = $fileName;

          $config['file_name'] = $jo_id."_".$fileName;

          $this->upload->initialize($config);

          if ($this->upload->do_upload('attachment')) {
              $this->upload->data();
              $attachment =  array(
                "job_order_id" => $jo_id,
                "attachment" => $jo_id."_".$fileName
              );
              $this->db->insert('ess.attachments', $attachment);
              if($this->db->affected_rows() > 0) {
              } else {
              }
          } else {
              return false;
          }
      }
      // Upload Attachment End

    }
    else $jo_id = 0;

    // Insert Status is JO is inserted successfully
    if ($jo_id > 0) {
      $data1 = array(
        "job_order_id" => $jo_id,
        "employee_id" => $this->session->userdata('empid'),
        "status" => "created",
        "created_dt" => date("Y-m-d H:i:s")
      );
      $this->db->insert('ess.status', $data1);
      if($this->db->affected_rows() > 0) {
        return array("Success", $files, $input);
      } else {
        return array("Error1", $files, $input);
      }
    } else return array("Error2", $files, $input);

  }

  function get_all_essjo() { $result = array();

    if($this->session->userdata("ess_role") == "end-user") {
      $query_end = " AND `jo`.`employee_id` = " . $this->session->userdata("empid");
    } else if ($this->session->userdata("ess_role" == "high-user") ) {
      if ($this->session->userdata("ess_unitdesc") != "Engineering Services") {

      } else {
        if($this->session->userdata("ess_role") == "high-user" ) {
          // TODO (AAA) Stopped Here
        }
      }
    } else $query_end = "";

    $sql = "SELECT `jo`.`id`, `jo`.`reference_no`, `jo`.`employee_name`,
        DATE_FORMAT(`jo`.`filled_dt`, '%Y-%m-%d') AS `filled_dt`, `s`.`status`, `s`.`comments`
      FROM `ess`.`job_order` AS `jo`
      INNER JOIN `ess`.`status` `s`
      ON `s`.`id` IN (SELECT MAX(`id`) AS `id` FROM `ess`.`status` GROUP BY `job_order_id`)
      AND `jo`.`id` = `s`.`job_order_id` $query_end
    ";
		$query_result = $this->db->query($sql);
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{

        // Status
        if($rows->status == "created") {
          $status_current = '<center><button type="button" class="btn btn-circle btn-xs blue-madison" onclick="open_status_history_modal('.$rows->id.');">Created</button></center>';
        } else if ($rows->status == "approved") {
          $status_current = '<center><button type="button" class="btn btn-circle btn-xs green-meadow" onclick="open_status_history_modal('.$rows->id.');">Approved</button></center>';
        } else if ($rows->status == "nsd-approved") {
          $status_current = '<center><button type="button" class="btn btn-circle btn-xs green-turquoise" onclick="open_status_history_modal('.$rows->id.');">Approved NSD</button></center>';
        } else if ($rows->status == "cancelled") {
          $status_current = '<center><button type="button" class="btn btn-circle btn-xs red-intense" onclick="open_status_history_modal('.$rows->id.');">Cancelled</button></center>';
        } else {
          $status_current = "";
        }

        // Action
        if ($rows->status != "cancelled") {
          $action = '<button type="button" class="btn btn-sm purple" onclick="open_jo('.$rows->id.');"><i class="fa fa-eye"></i></button>';
        } else {
          $action = '';
        }



				$result[] = array (
					$rows->reference_no,
					$rows->filled_dt,
          $rows->employee_name,
					$status_current,
          $action
				);


			}
		}

    return $result;
  }

  function get_status_history_modal($id) { $result = [];
    $sql = "SELECT `st`.`id`, CONCAT(COALESCE(`emp`.`firstname`,''), ' ', COALESCE(`emp`.`lastname`,'')) 'fullname',
        DATE_FORMAT(`st`.`created_dt`, '%M %d, %Y %H:%i') AS `created_dt`, `st`.`status`, `st`.`comments`
      FROM `ess`.`status` AS `st`
      LEFT JOIN `infosys`.`employee` AS `emp`
      ON `emp`.`employee_id` = `st`.`employee_id`
      WHERE `st`.`job_order_id` = $id
      ORDER BY `st`.`created_dt` DESC
    ";
		$query_result = $this->db->query($sql);
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{

        // Status
        if($rows->status == "created") {
          $status = '<center><button type="button" class="btn btn-circle btn-xs blue-madison">Created</button></center>';
        } else if ($rows->status == "approved") {
          $status = '<center><button type="button" class="btn btn-circle btn-xs green-meadow">Approved</button></center>';
        } else if ($rows->status == "nsd-approved") {
          $status = '<center><button type="button" class="btn btn-circle btn-xs green-turquoise">Approved NSD</button></center>';
        } else if ($rows->status == "cancelled") {
          $status = '<center><button type="button" class="btn btn-circle btn-xs red-intense">Cancelled</button></center>';
        } else {
          $status = '';
        }

				$result[] = array (
					$status,
					$rows->created_dt,
          $rows->fullname,
          $rows->comments
				);
			}
		}

    return $result;
  }

  function view_selected_jo($id) { $output = array();

    $sql = "SELECT *, DATE_FORMAT(`filled_dt`, '%Y-%m-%d') AS `filled_date` FROM `ess`.`job_order` WHERE `id` = $id";
    $output = $this->db->query($sql)->row_array();

    $sql2 = "SELECT * FROM `ess`.`attachments` WHERE `job_order_id` = $id";
    $output["uploads"] = $this->db->query($sql2)->result_array();

    return $output;

  }

}
