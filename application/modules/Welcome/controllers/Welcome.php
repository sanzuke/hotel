<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MX_Controller {
	public function index()
	{
		$page_view = TEMPLATE_PATH ."default/index";
		// $this->load->view('../../content/theme/default/index');
		$this->load->view($page_view);
	}
}
