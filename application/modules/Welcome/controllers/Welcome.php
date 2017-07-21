<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MX_Controller {
	public function index()
	{
		$this->load->model("Core_model");
		$this->load->helper('captcha');
		$page_view = '../../content/theme/mr_hotel/index'; //TEMPLATE_PATH ."mr_hotel/index";
		// $this->load->view('../../content/theme/default/index');
		$data['page_view'] = "home";
		$data['page_title'] = '';
		$data['fb'] = $this->Core_model->loadOption('FBLink');
		$data['tw'] = $this->Core_model->loadOption('TWLink');
		$data['ig'] = $this->Core_model->loadOption('IGLink');
		$data['ph'] = $this->Core_model->loadOption('PH');
		$data['em'] = $this->Core_model->loadOption('email');
		$data['logo'] = $this->Core_model->loadOption('logo');
		$data['sitename'] = $this->Core_model->loadOption('buname');
		$data['alamat'] = $this->Core_model->loadOption('bucontact');

		$vals = array(
        'word'          => '',
        'img_path'      => './captcha/',
        'img_url'       => base_url() . 'captcha/',
        'font_path'     => base_url() . 'system/fonts/texb.ttf',
        'img_width'     => '150',
        'img_height'    => 30,
        'expiration'    => 7200,
        'word_length'   => 5,
        'font_size'     => 25,
        'img_id'        => 'Imageid',
        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

        // White background and border, black text and red grid
        // 'colors'        => array(
        //         'background' => array(255, 255, 255),
        //         'border' => array(255, 255, 255),
        //         'text' => array(0, 0, 0),
        //         'grid' => array(255, 40, 40)
        // )
		);

		$cap = create_captcha($vals);
		$data['cap'] = $cap;
		$this->session->set_userdata('mycaptcha', $cap['word']);
		$data['kamar'] = $this->Core_model->loadKamar();

		$this->load->view($page_view, $data);
	}

	public function saveref()
	{
		if ($this->input->post() && ($this->input->post('cap') == $this->session->userdata('mycaptcha'))) {
			$nama = $this->input->post("nama", true);
			$alamat = $this->input->post("alamat", true);
			$email = $this->input->post("email", true);
			$phone = $this->input->post("phone", true);
			$checkin = $this->input->post("tglpesan", true);
			$checkout = $this->input->post("tglcheckout", true);
			$kamar = $this->input->post("kamar", true);
			$jmlkamar = $this->input->post("jmlkamar", true);
			$cap = $this->input->post("cap", true);

			$query = $this->db->insert("cm_reservasi", array(
					'Nama' => $nama,
					'Alamat' => $alamat,
					'email' => $email,
					'Telp' => $phone,
					'TglPesan' => $checkin,
					'TglChekOut' => $checkout,
					'JenisKamar' => $kamar,
					'JmlKamar' => $jmlkamar,
					'createddate' => date('Y/m/d H:i:s'),
					'isread' => false
			));
			if($query){
				$this->session->set_flashdata("msg", "<span class='alert alert-success'>Data reservasi anda telah disimpan</span>");
			} else {
				$this->session->set_flashdata("msg", "<span class='alert alert-danger'>Kesalahan pada sistem, coba kembali</span>");
			}
		} else {
			$this->session->set_flashdata("msg", "<span class='alert alert-danger'>Kode salah, coba kembali</span>");
		}

		redirect('');
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
		$data['alamat'] = $this->Core_model->loadOption('bucontact');


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
