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
		$this->load->model("Admin_model");
		$data['konten_view'] 	= "addpage_view";
		$data['judul_halaman']	= "Tambah Halaman";

		$data['parentlist'] = $this->Admin_model->parentlistpage();
		$data['id'] = "";
		$data['judul'] = "";
		$data['konten'] = "";
		$data['pub'] = "";
		$data['img'] = "";

		$this->load->view("index", $data);
	}

	public function editpage(){
		$this->load->model("Admin_model");
		$data['konten_view'] 	= "addpage_view";
		$data['judul_halaman']	= "Tambah Halaman";

		$data['parentlist'] = $this->Admin_model->parentlistpage();
		$data['id'] = $this->uri->segment(3);
		$dataPage = $this->Admin_model->loadPageEdit($data['id']);
		foreach ($dataPage->result() as $key) {
			$judul = $key->post_title;
			$konten= $key->post_content;
			$pub = $key->post_status;
			$img = $key->image;
		}
		$data['judul'] = $judul;
		$data['konten'] = $konten;
		$data['pub'] = $pub;
		$data['img'] = $img;

		$this->load->view("index", $data);
	}

	public function delpage(){
		$id = $this->uri->segment(3);
		if($id != ""){
			$hasil = $this->db->query("DELETE FROM cm_post WHERE id = '{$id}'");
			if($hasil){
				$this->session->set_flashdata("message", "true:Data telah dihapus");
			} else {
				$this->session->set_flashdata("message", "false:Data gagal dihapus");
			}
		}
		redirect("admin/listpage");
	}

	public function savepage(){
		$id 			= $this->input->post("id", true);
		$judul 		= $this->input->post("judul", true);
		$konten 	= $this->input->post("konten", true);
		$parent 	= $this->input->post("parent", true);
		$publish 	= $this->input->post("publish", true)  == "on" ? 1 : 0;
		$file = $this->input->post("userfile", true);

		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;

		$this->load->library('upload', $config);

		if($id == ""){ // jika field id kosong (Insert)

			if( $_FILES['userfile']['size'] != 0 ){ // jika upload file ada
		    if ( ! $this->upload->do_upload('userfile'))
		    {
		            $error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata("message", "false:Data gagal disimpan <br>".$this->upload->display_errors() );

		            // $this->load->view('upload_form', $error);
		    } else {
		            $data = array('upload_data' => $this->upload->data());
								$this->session->set_flashdata("message", "true:Data berhasil disimpan" );

								// $upload = $this->db->query("INSERT INTO");

		            // $this->load->view('upload_success', $data);
								$result = $this->db->query("INSERT INTO cm_post (id, post_title, post_date, post_content, post_type, 	post_status, post_author, image )
								VALUES(NULL, '".$judul."','".date("Y-m-d H:i")."','".$konten."','page','".$publish."','1', '".$this->upload->data('file_name')."')");

								if($result){
									$this->session->set_flashdata("message", "true:Data berhasil disimpan" );
								} else {
									$this->session->set_flashdata("message", "false:Data gagal disimpan<br> " .$this->db->_error_message());
								}
		    }
				redirect("admin/listPage");
			} else { // jika upload file tidak ada
				$result = $this->db->query("INSERT INTO cm_post (id, post_title, post_date, post_content, post_type, 	post_status, post_author )
				VALUES(NULL, '".$judul."','".date("Y-m-d H:i")."','".$konten."','page','".$publish."','1')");

				if($result){
					$this->session->set_flashdata("message", "true:Data berhasil disimpan ". $userfile );
				} else {
					$this->session->set_flashdata("message", "false:Data gagal disimpan<br> wqwdasd " .$this->db->_error_message());
				}
				redirect("admin/listPage");
			}
		} else { // jika field id tidak kosong (Update)
			if( $_FILES['userfile']['size'] != 0 ){

				if ( ! $this->upload->do_upload('userfile'))
				{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata("message", "false:Data gagal disimpan <br>".$this->upload->display_errors() );

								// $this->load->view('upload_form', $error);
				} else {
								$data = array('upload_data' => $this->upload->data());
								$this->session->set_flashdata("message", "true:Data berhasil disimpan" );

								// $upload = $this->db->query("INSERT INTO");

								// $this->load->view('upload_success', $data);
								$result = $this->db->query("UPDATE cm_post SET post_title = '".$judul."',
								post_content = '".$konten."',
								post_status = '".$publish."',
								image ='".$this->upload->data('file_name')."'
								WHERE id = '".$id."' ");

								if($result){
									$this->session->set_flashdata("message", "true:Data berhasil diubah !!!" );
								} else {
									$this->session->set_flashdata("message", "false:Data gagal diubah<br> " .$this->db->_error_message());
								}
				}
			} else {
				$result = $this->db->query("UPDATE cm_post SET post_title = '".$judul."',
				post_content = '".$konten."',
				post_status = '".$publish."'
				WHERE id = '".$id."'  ");

				if($result){
					$this->session->set_flashdata("message", "true:Data berhasil diubah" );
				} else {
					$this->session->set_flashdata("message", "false:Data gagal diubah<br> " .$this->db->_error_message());
				}
			}
			redirect("admin/listPage");
		}
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
		$this->load->model("Admin_model");
		$data['konten_view'] 	= "addpost_view";
		$data['judul_halaman']	= "Tambah Posting";
		$data['listCategory']		= $this->Admin_model->loadListCategory();

		// $data['parentlist'] = $this->Admin_model->parentlistpage();
		$data['id'] = $this->uri->segment(3);
		$dataPage = $this->Admin_model->loadPageEdit($data['id']);
		foreach ($dataPage->result() as $key) {
			$judul = $key->post_title;
			$konten= $key->post_content;
			$pub = $key->post_status;
			$kat = $key->post_category;
			$img = $key->image;
		}
		$data['judul'] = $judul;
		$data['konten'] = $konten;
		$data['kategori'] = $kat;
		$data['pub'] = $pub;
		$data['img'] = $img;

		$this->load->view("index", $data);
	}

	public function delpost()
	{
		$id = $this->uri->segment(3);
		if($id != ""){
			$hasil = $this->db->query("DELETE FROM cm_post WHERE id = '{$id}'");
			if($hasil){
				$this->session->set_flashdata("message", "true:Data telah dihapus");
			} else {
				$this->session->set_flashdata("message", "false:Data gagal dihapus");
			}
		}
		redirect("admin/listpost");
	}

	public function savepost(){
		$id 			= $this->input->post("id", true);
		$judul 		= $this->input->post("judul", true);
		$konten 	= $this->input->post("konten", true);
		$parent 	= $this->input->post("parent", true);
		$publish 	= $this->input->post("publish", true)  == "on" ? 1 : 0;
		$file = $this->input->post("userfile", true);
		$kategori = $this->input->post("kategori", true);

		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;

		$this->load->library('upload', $config);

		if($id == ""){ // jika field id kosong (Insert)

			if( $_FILES['userfile']['size'] != 0 ){ // jika upload file ada
		    if ( ! $this->upload->do_upload('userfile'))
		    {
		            $error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata("message", "false:Data gagal disimpan <br>".$this->upload->display_errors() );

		            // $this->load->view('upload_form', $error);
		    } else {
		            $data = array('upload_data' => $this->upload->data());
								$this->session->set_flashdata("message", "true:Data berhasil disimpan" );

								// $upload = $this->db->query("INSERT INTO");

		            // $this->load->view('upload_success', $data);
								$result = $this->db->query("INSERT INTO cm_post (id, post_title, post_date, post_category, post_content, post_type, 	post_status, post_author, image )
								VALUES(NULL, '".$judul."','".date("Y-m-d H:i")."','".$kategori."', '".$konten."','post','".$publish."','1', '".$this->upload->data('file_name')."')");

								if($result){
									$this->session->set_flashdata("message", "true:Data berhasil disimpan" );
								} else {
									$this->session->set_flashdata("message", "false:Data gagal disimpan<br> " .$this->db->_error_message());
								}
		    }
				redirect("admin/listpost");
			} else { // jika upload file tidak ada
				$result = $this->db->query("INSERT INTO cm_post (id, post_title, post_date, post_category, post_content, post_type, 	post_status, post_author )
				VALUES(NULL, '".$judul."','".date("Y-m-d H:i")."','".$kategori."','".$konten."','post','".$publish."','1')");

				if($result){
					$this->session->set_flashdata("message", "true:Data berhasil disimpan ". $userfile );
				} else {
					$this->session->set_flashdata("message", "false:Data gagal disimpan<br> wqwdasd " .$this->db->_error_message());
				}
				redirect("admin/listpost");
			}
		} else { // jika field id tidak kosong (Update)
			if( $_FILES['userfile']['size'] != 0 ){

				if ( ! $this->upload->do_upload('userfile'))
				{
								$error = array('error' => $this->upload->display_errors());
								$this->session->set_flashdata("message", "false:Data gagal disimpan <br>".$this->upload->display_errors() );

								// $this->load->view('upload_form', $error);
				} else {
								$data = array('upload_data' => $this->upload->data());
								$this->session->set_flashdata("message", "true:Data berhasil disimpan" );

								// $upload = $this->db->query("INSERT INTO");

								// $this->load->view('upload_success', $data);
								$result = $this->db->query("UPDATE cm_post SET post_title = '".$judul."',
								post_content = '".$konten."',
								post_status = '".$publish."',
								post_category = '".$kategori."',
								image ='".$this->upload->data('file_name')."'
								WHERE id = '".$id."' ");

								if($result){
									$this->session->set_flashdata("message", "true:Data berhasil diubah !!!" );
								} else {
									$this->session->set_flashdata("message", "false:Data gagal diubah<br> " .$this->db->_error_message());
								}
				}
			} else {
				$result = $this->db->query("UPDATE cm_post SET post_title = '".$judul."',
				post_content = '".$konten."',
				post_status = '".$publish."',
				post_category = '".$kategori."'
				WHERE id = '".$id."'  ");

				if($result){
					$this->session->set_flashdata("message", "true:Data berhasil diubah" );
				} else {
					$this->session->set_flashdata("message", "false:Data gagal diubah<br> " .$this->db->_error_message());
				}
			}
			redirect("admin/listpost");
		}
	}

	// =========================================== //
	// 					Gallery
	// =========================================== //
	public function listgallery(){
		$this->load->model("Admin_model");

		$data['konten_view'] 	= "listgallery_view";
		$data['judul_halaman']	= "Daftar Galeri";
		$data['listPage']		= $this->Admin_model->loadListGallery();

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
