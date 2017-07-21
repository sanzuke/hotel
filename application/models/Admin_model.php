<?php
class Admin_model extends CI_Model {
	public function __construct()
        {
                parent::__construct();
                // Your own constructor code
        }

    /* =========================== Generate Date =========================*/
  	function generateDate($d, $opt = 'full'){
  		$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
  		$bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

  		$h=date("w",strtotime($d));
  		$b=date("m",strtotime($d));

  		switch($opt){
        case 'full':
  			  $hasil=$hari[$h] .", ".date("d-m-Y H:i",strtotime($d)) ." WIB" ;
          break;
  		  case 'basic':
  			 $hasil=$hari[$h] .", ".date("d-m-Y",strtotime($d)) ;
          break;
        default :
          $hasil = date("d-m-Y",strtotime($d));
  		}

  		return $hasil;
  	}

    public function showMessage(){
      $psn = $this->session->flashdata("message");
      $hasil = "";
      if( $psn != "" ){
        $str = explode(":",$psn);
        if($str[0] == "true"){
          $hasil = '<div class="alert alert-success"><i class="fa fa-check"></i> '.$str[1].'</div>';
        } else {
          $hasil = '<div class="alert alert-danger"><i class="fa fa-times"></i> '.$str[1].'</div>';
        }
      }

      return $hasil;
    }

    public function loadListPage($type){
    	// $query = $this->db->get_where("cm_post", array("post_type" => "page"));

    	$this->db->select('cm_post.id, cm_post.post_title, cm_post.post_type, cm_post.post_author, ss_users.user_nicename, cm_post.post_date, cm_post.post_category, ss_category.category_name');
  		$this->db->from('cm_post');
      $this->db->join('ss_users', 'ss_users.id = cm_post.post_author', 'left');
  		$this->db->join('ss_category', 'ss_category.id = cm_post.post_category', 'left');
      $this->db->where('post_type', $type);
  		// $query = $this->db->get_where("cm_post", array("post_type" => "page"));
  		$query = $this->db->get();

    	return $query;
    }

		public function parentlistpage(){
			$query = $this->db->get_where("cm_post", array("post_type"=> "page"));
      return $query;
		}

    public function loadListCategory(){
      $query = $this->db->get_where("ss_category", array("category_parent"=> "0"));
      return $query;
    }

    public function loadListCategorySub($parent){
      $query = $this->db->get_where("ss_category", array("category_parent"=> $parent));
      return $query;
    }

    public function loadListReservasi(){
      // $query = $this->db->get_where("cm_post", array("post_type" => "page"));

      $this->db->select('*');
      $this->db->from('cm_reservasi');
      $this->db->join('ss_jenis_kamar', 'cm_reservasi.JenisKamar = ss_jenis_kamar.type', 'left');
      $this->db->order_by("KodeR", "DESC");
      $query = $this->db->get();

      return $query;
    }

		public function loadPageEdit($id)
		{
			$query = $this->db->get_where("cm_post", array("id" => $id));
			return $query;
		}

		public function loadListGallery(){
      $query = $this->db->get_where("cm_gallery");
      return $query;
    }

		public function time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'tahun',
	        'm' => 'bulan',
	        'w' => 'minggu',
	        'd' => 'hari',
	        'h' => 'jam',
	        'i' => 'menit',
	        's' => 'detik',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' lalu' : 'baru saja';
	}

		public function new5Reserfasi()
		{
			$query = $this->db->query("SELECT * FROM cm_reservasi WHERE isread = '0' ORDER BY KodeR DESC Limit 5");
			return $query;
		}

		public function newcountAllReserfasi()
		{
			$query = $this->db->query("SELECT * FROM cm_reservasi WHERE isread = '0' ORDER BY KodeR DESC");
			return count($query->result());
		}
}
