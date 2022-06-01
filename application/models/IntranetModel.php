<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class IntranetModel extends CI_Model{
	function get_announcements(){
		return $this->db->query("SELECT `id`, `title`, `body`, `link`, pinned, date_format(date_created, '%b %d, %Y %h:%i%p') date_create FROM intranet.`announcements` WHERE active = 1 order by pinned desc, date_created desc")
					->result();
	}

	function get_articles(){
		return $this->db->query("SELECT *, date_format(article_date, '%b %d, %Y %h:%i%p') article_date FROM intranet.`articles`
				WHERE active = 1
				order by id desc LIMIT 10")->result();
	}
	function get_posts(){
		$posts = $this->db->query("SELECT *, date_format(post_date, '%d %b %Y') post_date, LENGTH(REPLACE(post_text, '\n', '')) lchar, LENGTH(post_text) - LENGTH(REPLACE(post_text, '\n', '')) newlines FROM intranet.`posts`
				WHERE active = 1
				order by id desc LIMIT 10")->result();

		foreach ($posts as $p) {
			if($p->post_by == 409){
				$p->emp = 'System Admin';
			}
			else{
				$p->emp = $this->getEmployee($p->post_by);
			}
			$p->attachments = $this->db->query("SELECT *, replace(file_name, ' ', '_') as file_name FROM intranet.`post_attachments` WHERE post_id = ? order by id desc", array($p->id))->row_array();
		}

		return $posts;
	}

	function getPost(){
		$input = $this->input->post();
		$post = $this->db->query("SELECT *, date_format(post_date, '%b %d, %Y %h:%i%p') post_date FROM intranet.`posts`
				WHERE id = ?",array($input['id']))->row_array();
		$post['emp'] = $this->getEmployee($post['post_by']);
		$post['post_attachments'] = $this->db->query("SELECT *, replace(file_name, ' ', '_') as file_name FROM intranet.`post_attachments` WHERE post_id = ?", array($input['id']))->row_array();

		$post['post_text'] = str_replace("\n","<br>",$post['post_text']);

		return $post;
	}

	function savePost(){
		$post = $this->input->post();
		$post = array(
			'post_title' => $post['title'],
			'post_text' => $post['content'],
			'post_by' => $this->session->userdata('id'),
		);
		$this->db->insert('intranet.posts', $post);
	}

	function getEmployee($emp){

		$e = $this->db->query("SELECT CONCAT(if(employee_id = 9, 'Maria Celerina', `firstname`),' ', LEFT(`middlename` , 1),'. ',`lastname`) FULL_NAME
							FROM infosys.employee
							INNER JOIN position_reference p
							ON `position_reference_position_reference_id` = p.position_reference_id
							WHERE employee_id = $emp")->row_array()['FULL_NAME'];
		/*TITLES*/

		$msc = array(75, 222);
		$md = array(521);
		$phd = array(77, 66, 336, 79, 352, 332, 327, 257, 205 , 239 , 16, 96, 219, 208);
		if (in_array($emp, $msc)) {
		    $e .= ', M.Sc.';
		}
		if (in_array($emp, $phd)) {
		    $e .= ', Ph.D.';
		}
		if (in_array($emp, $md)) {
		    $e .= ', M.D.';
		}
		return $e;
	}
	function update_announcement(){

		$post = $this->input->post();
	  	if($post['act'] == 1 || $post['act'] == 0){
	  		$col = 'pinned';
	  		$val = $post['act'];
	  	}
	  	else{
	  		$col = 'active';
	  		$val = 0;
	  	};
	  	$this->db->query("UPDATE intranet.`announcements` SET
	  		$col = ? WHERE id = ?", array($val, $post['id']));
	}


	function update_announcement2(){
		$post = $this->input->post();
	  	$this->db->where("id", $post['id']);
	  	$this->db->update("intranet.announcements", $post);
	}
	function save_announcement(){
		$post = $this->input->post();
		$announcement  = array(
			'title' => $post['a_title'],
			'body' => $post['a_body']
		);
		$this->db->insert('intranet.announcements', $announcement);
	}
}
