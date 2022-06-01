<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IntranetAPI extends CI_Controller {
	function get_announcements(){
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->intranetModel->get_announcements()));
	}

	function getArticles(){
		$this->output
		    ->set_content_type("application/json")
		    ->set_output(json_encode($this->intranetModel->get_articles()));
	}
}
