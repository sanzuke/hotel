<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MX_Controller {
	public function index()
	{
		$page_view = '../../content/theme/mr_hotel/index'; //TEMPLATE_PATH ."mr_hotel/index";
		// $this->load->view('../../content/theme/default/index');
		$data['page_view'] = "home";
		$this->load->view($page_view, $data);
	}

	public function page()
	{
		$this->load->model("Core_model");

		$theme = base_url() . TEMPLATE_PATH ."mr_hotel/index";
		$uri = $this->uri->segment(1);
		$id = '';
		switch ($uri) {
			case 'profil':
				$id = '2';
				break;
			case 'layanan':
				$id = '3';
				break;
			case 'kamar':
				$id = '4';
				break;
			case 'galeri':
				$id = '5';
				break;
			case 'kontak':
				$id = '6';
				break;
			default:
				# code...
				break;
		}

		$data['page_content'] = $this->Core_model->loadPost($id);
		$data['page_title'] = ucwords(strtolower($uri));
		// $this->load->view('../../content/theme/default/index');
		$data['page_view'] = "page";

		$this->load->view('../../content/theme/mr_hotel/index', $data);
	}

	public function post()
	{
		$theme = base_url() . TEMPLATE_PATH ."mr_hotel/index";
		// $this->load->view('../../content/theme/default/index');
		$data['data'] = 'Postingan';
		$this->load->view('../../content/theme/mr_hotel/index', $data);
	}
}
