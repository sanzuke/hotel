<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {
	public function index()
	{
		$page_view = 'login_view'; //TEMPLATE_PATH ."default/index";
		$this->load->view($page_view);
	}

	public function auth(){
		$user = $this->input->post("username", true);
		$pass = $this->input->post("password", true);
	
		$query = $this->db->query("SELECT * FROM users WHERE user_login = '{$user}' AND password = PASSWORD('{$pass}')");
		if($query->num_rows() > 0){
			// redirect("admin/dashboard");
		} else {
			$this->session->set_flashdata("message","Cek kembali user dan password anda.");
			// redirect("admin");
		}
	}
	
	// =========================================== //
	// 					Dashboard
	// =========================================== //
	public function dashboard(){
		$data['konten_view'] 	= "dashboard_view";
		$data['judul_halaman']	= "Dashboard";

		$this->load->view("index", $data);
	}

	// =========================================== //
	// 					Page
	// =========================================== //
	public function listpage(){
		$this->load->model("Admin_model");

		$data['konten_view'] 	= "listpage_view";
		$data['judul_halaman']	= "Daftar Halaman";
		$data['listPage']		= $this->Admin_model->loadListPage('page');

		$this->load->view("index", $data);
	}

	public function addpage(){
		$data['konten_view'] 	= "addpage_view";
		$data['judul_halaman']	= "Tambah Halaman";

		$this->load->view("index", $data);
	}

	public function editpage(){

	}

	public function savepage(){

	}


	// =========================================== //
	// 					Category
	// =========================================== //
	public function listcategory(){
		$this->load->model("Admin_model");

		$data['konten_view'] 	= "listcategory_view";
		$data['judul_halaman']	= "Daftar Kategori";
		$data['listCategory']		= $this->Admin_model->loadListCategory();

		$this->load->view("index", $data);
	}

	public function categorysave(){
		$id 	= $this->input->post("id", true);
		$name 	= $this->input->post("kategori", true);
		$slug 	= $this->input->post("slug", true);
		$parent = $this->input->post("parent", true);
		$desc 	= $this->input->post("desc", true);

		$data = array(
			"category_name" => $name,
			"category_slug"	=> $slug,
			"category_parent"=> $parent == null ? '0' : $parent,
			"category_desc"	=> $desc
		);

		if($id == ""){
			$result = $this->db->insert('ss_category', $data);
		} else {
			$result = $this->db->update('ss_category', $data, array("id"=>$id));
		}

		if($result){
			$this->session->set_flashdata("message", "true:Data berhasil disimpan");
		} else {
			$this->session->set_flashdata("message", "false:Data gagal disimpan");
		}

		redirect("admin/listcategory");
	}

	public function delcategory(){
		$id = $this->uri->segment(3);

		$result = $this->db->delete('ss_category', array('id' => $id));
		if($result){
			$this->session->set_flashdata("message", "true:Data berhasil dihapus");
		} else {
			$this->session->set_flashdata("message", "false:Data gagal dihapus");
		}

		redirect("admin/listcategory");
	}

	// =========================================== //
	// 					Post
	// =========================================== //
	public function listpost(){
		$this->load->model("Admin_model");

		$data['konten_view'] 	= "listpost_view";
		$data['judul_halaman']	= "Daftar Posting";
		$data['listPage']		= $this->Admin_model->loadListPage('post');

		$this->load->view("index", $data);
	}

	public function addpost(){
		$this->load->model("Admin_model");

		$data['konten_view'] 	= "addpost_view";
		$data['judul_halaman']	= "Tambah Posting";
		$data['listCategory']		= $this->Admin_model->loadListCategory();

		$this->load->view("index", $data);
	}

	public function editpost(){

	}

	public function savepost(){

	}

	// =========================================== //
	// 					Gallery
	// =========================================== //
	public function listgallery(){
		$this->load->model("Admin_model");

		$data['konten_view'] 	= "listgallery_view";
		$data['judul_halaman']	= "Daftar Galeri";
		$data['listPage']		= $this->Admin_model->loadListPage('post');

		$this->load->view("index", $data);
	}


	// =========================================== //
	// 					Reserfasi
	// =========================================== //
	public function reservasi(){
		$this->load->model("Admin_model");

		$data['konten_view'] 	= "listreservasi_view";
		$data['judul_halaman']	= "Daftar Reserfasi";
		$data['listData']		= $this->Admin_model->loadListReservasi();

		$this->load->view("index", $data);
	}


	// =========================================== //
	// 					Pengaturan
	// =========================================== //
	public function general(){
		$this->load->model("Admin_model");

		$data['konten_view'] 	= "listpost_view";
		$data['judul_halaman']	= "Pengaturan Umum";
		$data['listPage']		= $this->Admin_model->loadListPage('post');

		$this->load->view("index", $data);
	}

	public function parameter(){
		$this->load->model("Admin_model");

		$data['konten_view'] 	= "listpost_view";
		$data['judul_halaman']	= "Pengaturan Parameter";
		$data['listPage']		= $this->Admin_model->loadListPage('post');

		$this->load->view("index", $data);
	}

	public function maps(){
		$this->load->model("Admin_model");

		$data['konten_view'] 	= "listpost_view";
		$data['judul_halaman']	= "Maps";
		$data['listPage']		= $this->Admin_model->loadListPage('post');

		$this->load->view("index", $data);
	}

	public function socialmedia(){
		$this->load->model("Admin_model");

		$data['konten_view'] 	= "listpost_view";
		$data['judul_halaman']	= "Pengaturan Sosial Media";
		$data['listPage']		= $this->Admin_model->loadListPage('post');

		$this->load->view("index", $data);
	}
}
