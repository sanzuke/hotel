<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

	// public function __construct(){
	// 	if ( $this->session->userdata("userlogin") ){
	// 		redirect("admin/dashboard");
	// 	}
	// 	//else {
	// 	// 	redirect("admin");
	// 	// }
	// }

	public function index()
	{
		$this->load->model("Admin_model");
		if ( $this->session->userdata("userlogin") ){
			redirect("admin/dashboard");
		}

		$page_view = 'login_view'; //TEMPLATE_PATH ."default/index";
		$this->load->view($page_view);
	}

	public function auth(){
		$this->load->model("Admin_model");

		$user = $this->input->post("username", true);
		$pass = $this->input->post("password", true);

		$query = $this->db->query("SELECT * FROM ss_users WHERE user_login = '{$user}' AND user_pass = '{$pass}' ");
		if( $query->num_rows() > 0 ){
			$this->session->set_userdata("userlogin", $user);
			redirect("admin/dashboard");
		} else {
			$this->session->set_flashdata("message","false:Cek kembali user dan password anda.");
			redirect("admin");
		}
	}

	public function logout()
	{
		$this->session->unset_userdata("userlogin");
		$this->session->sess_destroy();

		redirect("admin");
	}

	public function getnotif()
	{
		$id = $this->input->post("id", true);
		$data = array();
		$i = 0;
		$query = $this->db->query("SELECT r.*, jk.type FROM cm_reservasi r, ss_jenis_kamar jk WHERE r.KodeR = '{$id}' AND r.JenisKamar = jk.idkamar");
		foreach ($query->result() as $key) {
			$rec['nama'] = $key->Nama;
			$rec['alamat'] = $key->Alamat;
			$rec['email'] = $key->email;
			$rec['telp'] = $key->Telp;
			$rec['checkin'] = date('d/m/Y', strtotime($key->TglPesan));
			$rec['checkout'] = date('d/m/Y', strtotime($key->TglChekOut));
			$rec['kamar'] = $key->type;
			$rec['jumlah'] = $key->JmlKamar;

			$data[] = $rec;
			$i++;
		}
		if( $i > 0 ){
			$this->db->update("cm_reservasi", array('isread'=>true), array("KodeR"=>$id));
		}
		header("Content-type:application/json");
		echo json_encode($data);
	}

	// =========================================== //
	// 					Dashboard
	// =========================================== //
	public function dashboard(){
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}
		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

		$data['konten_view'] 	= "dashboard_view";
		$data['judul_halaman']	= "Dashboard";

		$this->load->view("index", $data);
	}

	// =========================================== //
	// 					Page
	// =========================================== //
	public function listpage(){
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}

		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

		$data['konten_view'] 	= "listpage_view";
		$data['judul_halaman']	= "Daftar Halaman";
		$data['listPage']		= $this->Admin_model->loadListPage('page');

		$this->load->view("index", $data);
	}

	public function addpage(){
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}

		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

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
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}

		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

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
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}

		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

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
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}

		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

		$data['konten_view'] 	= "listpost_view";
		$data['judul_halaman']	= "Daftar Posting";
		$data['listPage']		= $this->Admin_model->loadListPage('post');

		$this->load->view("index", $data);
	}

	public function addpost(){
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}

		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

		$data['konten_view'] 	= "addpost_view";
		$data['judul_halaman']	= "Tambah Posting";
		$data['listCategory']		= $this->Admin_model->loadListCategory();

		$this->load->view("index", $data);
	}

	public function editpost(){
		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

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
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}

		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

		$data['konten_view'] 	= "listgallery_view";
		$data['judul_halaman']	= "Daftar Galeri";
		$data['listPage']		= $this->Admin_model->loadListGallery();

		$this->load->view("index", $data);
	}

	public function savegallery()
	{
		$config['upload_path']          = './uploads/gallery/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 100;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;

		$this->load->library('upload', $config);

		$judul = $this->input->post("judul", true);
		$image = $this->input->post("image", true);
		$keterangan = $this->input->post("keterangan", true);

		if ( ! $this->upload->do_upload('userfile'))
		{
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata("message", "false:Data gagal disimpan <br>".$this->upload->display_errors() );

			// $this->load->view('upload_form', $error);
		} else {
			$data = array('upload_data' => $this->upload->data());
			$this->session->set_flashdata("message", "true:Data berhasil disimpan" );
			$img = $this->upload->data('file_name');

			$result = $this->db->query("INSERT INTO cm_gallery VALUES(NULL, '{$judul}', '{$img}', '{$keterangan}')");

			if($result){
				$this->session->set_flashdata("message", "true:Data galeri berhasil disimpan !!!" );
			} else {
				$this->session->set_flashdata("message", "false:Data galeri gagal disimpan<br> " .$this->db->_error_message());
			}
		}
		redirect("admin/listgallery");
	}

	public function delgallery()
	{
		$id = $this->uri->segment(3);
		$img = $this->uri->segment(4);
		$query = $this->db->query("DELETE FROM cm_gallery WHERE id = '{$id}'");
		if($query){
			// unlink( base_url().'uploads/gallery/'.$img );
			$this->session->set_flashdata("message", "true:Data galeri berhasil dihapus !!!" );
		} else {
			$this->session->set_flashdata("message", "false:Data galeri gagal dihapus<br> " .$this->db->_error_message());
		}
		redirect("admin/listgallery");
	}

	// =========================================== //
	// 					Reserfasi
	// =========================================== //
	public function reservasi(){
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}

		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

		$data['konten_view'] 	= "listreservasi_view";
		$data['judul_halaman']	= "Daftar Reserfasi";
		$data['listData']		= $this->Admin_model->loadListReservasi();

		$this->load->view("index", $data);
	}


	// =========================================== //
	// 					Pengaturan
	// =========================================== //
	public function general(){
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}

		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

		$this->load->model("Core_model");

		$data['konten_view'] 	= "set_general_view";
		$data['judul_halaman']	= "Pengaturan Umum";
		$data['ph'] = $this->Core_model->loadOption('PH');
		$data['em'] = $this->Core_model->loadOption('email');
		$data['logo'] = $this->Core_model->loadOption('logo');
		$data['sitename'] = $this->Core_model->loadOption('buname');
		$data['alamat'] = $this->Core_model->loadOption('bucontact');

		$this->load->view("index", $data);
	}

	public function savegeneral()
	{
		$bu = $this->input->post("buname", true);
		$bucontact = $this->input->post("bucontact", true);
		$email = $this->input->post("email", true);
		$phone = $this->input->post("phone", true);

		$query = $this->db->query("UPDATE ss_options SET value = '{$bu}' WHERE codename = 'buname' AND id = '2' ");
		$query = $this->db->query("UPDATE ss_options SET value = '{$bucontact}' WHERE codename = 'bucontact' AND id = '3' ");
		$query = $this->db->query("UPDATE ss_options SET value = '{$email}' WHERE codename = 'EMAIL' AND id = '8' ");
		$query = $this->db->query("UPDATE ss_options SET value = '{$phone}' WHERE codename = 'PH' AND id = '7' ");

		redirect("admin/general");
	}

	public function parameter(){
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}

		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

		$data['konten_view'] 	= "listpost_view";
		$data['judul_halaman']	= "Pengaturan Parameter";
		$data['listPage']		= $this->Admin_model->loadListPage('post');

		$this->load->view("index", $data);
	}

	public function maps(){
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}

		$this->load->model("Admin_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

		$data['konten_view'] 	= "listpost_view";
		$data['judul_halaman']	= "Maps";
		$data['listPage']		= $this->Admin_model->loadListPage('post');

		$this->load->view("index", $data);
	}

	public function socialmedia(){
		if ( ! $this->session->userdata("userlogin") ){
			redirect("admin");
		}

		$this->load->model("Admin_model");
		$this->load->model("Core_model");
		$data['reserfasi5Baru'] = $this->Admin_model->new5Reserfasi();
		$data['reserfasiAllBaru'] = $this->Admin_model->newcountAllReserfasi();

		$data['konten_view'] 	= "set_sosmed_view";
		$data['judul_halaman']	= "Pengaturan Sosial Media";
		$data['fb'] = $this->Core_model->loadOption('FBLink');
		$data['tw'] = $this->Core_model->loadOption('TWLink');
		$data['ig'] = $this->Core_model->loadOption('IGLink');

		$this->load->view("index", $data);
	}

	public function savesosmed()
	{
		$fb = $this->input->post("fb", true);
		$tw = $this->input->post("tw", true);
		$ig = $this->input->post("ig", true);

		$query = $this->db->query("UPDATE ss_options SET value = '{$fb}' WHERE codename = 'FBLink' AND id = '4' ");
		$query = $this->db->query("UPDATE ss_options SET value = '{$tw}' WHERE codename = 'TWLink' AND id = '5' ");
		$query = $this->db->query("UPDATE ss_options SET value = '{$ig}' WHERE codename = 'IGLink' AND id = '6' ");

		redirect("admin/socialmedia");
	}
}
