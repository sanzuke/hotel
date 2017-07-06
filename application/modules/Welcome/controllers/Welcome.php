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
				$data['kontak'] = '';
				break;
			case 'layanan':
				$id = '3';
				$data['kontak'] = '';
				break;
			case 'kamar':
				$id = '4';
				$data['kontak'] = '';
				break;
			case 'galeri':
				$id = '5';
				$data['kontak'] = '';
				break;
			case 'kontak':
				$id = '6';
				$data['kontak'] = $this->Core_model->loadOption('bucontact');
				break;
			default:
				# code...
				break;
		}

		$data['page_content'] = $this->Core_model->loadPost($id);
		$data['page_title'] = ucwords(strtolower($uri));
		// $this->load->view('../../content/theme/default/index');
		if($id == '5'){
			$data['galleryList'] = $this->Core_model->loadGallery();
			$data['page_view'] = "gallery";
		} else {
			$data['page_view'] = "page";
		}

		$data['fb'] = $this->Core_model->loadOption('FBLink');
		$data['tw'] = $this->Core_model->loadOption('TWLink');
		$data['ig'] = $this->Core_model->loadOption('IGLink');
		$data['ph'] = $this->Core_model->loadOption('PH');
		$data['em'] = $this->Core_model->loadOption('email');
		$data['logo'] = $this->Core_model->loadOption('logo');
		$data['sitename'] = $this->Core_model->loadOption('buname');

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
