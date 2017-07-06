<?php
class Core_model extends CI_Model {
	public function __construct()
        {
                parent::__construct();
                // Your own constructor code
        }

    /* =========================== Generate Date =========================*/
  	function generateDate($d){
  		$hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
  		$bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

  		$h=date("w",strtotime($d));
  		$b=date("m",strtotime($d));

  		$hasil=$hari[$h] .", ".date("d-m-Y H:i",strtotime($d)) ." WIB" ;

  		return $hasil;

  	}


  	/*=================================================== load index post ==========================*/
    function loadIndexPost($kategori, $limit, $start)
    {
        $sql = "select * from post where kategori='".$kategori."' and publish='1' order by tgl desc limit " . $start . ', ' . $limit;
        $query = $this->db->query($sql);
        return $query->result();
    }

    function loadOtherPost($kon, $id){
  		?>
      <div id="isiBeritax" class="panel panel-default">
  		<div class="judulx panel-heading"><img src="<?php echo base_url() ?>images/green_arrow.png" align="absmiddle" /> Artikel Lain</div>
  		<!-- <fieldset style="border:1px solid #e6e6e6; margin:10px 0px;"> -->
          	<ul class="list-group">
              <?php
              $q=$this->db->query("SELECT kategori FROM post WHERE id='".$id."'");
              $r=$q->row();
      				$q1=$this->db->query("select id, judul, kategori from post where kategori='".$r->kategori."' order by id desc limit 1 ,5");
      				// while($rr=mysql_fetch_array($q1)){
              // print_r($q1->result_array());
              foreach ($q1->result_array() as $row) {
      					//echo "<li><a href='".base_url() . "post/". $rr['id']."/". str_replace(" ","-",$rr['judul'])."' title='$rr[judul]'>".$rr['judul']."</a></li>";
                $link = base_url() ."berita/lihat/".$this->main_model->generateLinkBerita($row['id'],$row['judul']);
                echo "<li class='list-group-item'><a href='".$link."'>".$row['judul']."</a></li>";
      				}
      			  ?>
              </ul>
          <!-- </fieldset> -->
          </div>
          <?php
  	}

  	function loadPost($idPost){
  		$qr=$this->db->query("select * from cm_post where id='$idPost'");
  		$view=$qr->row();
  		return $qr;
  	}

  	function getViewerPost($id){
  		$q = $this->db->query("SELECT viewer FROM post WHERE id = '{$id}'");
  		$row = $q->row();
  		return $row->viewer;
  	}

  	function getImgPost($id){
  		$q = $this->db->query("SELECT photo FROM post WHERE id = '{$id}'");
  		$row = $q->row();
  		return $row->photo;
  	}

    function loadGaleri(){
      $view=$this->db->query("select * from post where kategori='foto' order by tgl desc limit 0,9");
  		return $view;
    }

  	function addViewer($id,$nilViewer){
  		$nilViewer++;
  		$q=$this->db->query("update post set viewer='$nilViewer' where id='$id'");
  	}

  	function loadMetaKW($id){
  		$q=$this->db->query("select * from post where id='$id'");
  		$r=$q->row(); //mysql_fetch_array($q);

  		$array[0]=$r->judul;
  		$array[1]=substr(strip_tags($r->isi),0,200);

  		return $array;
  	}

  	function generateLinkBerita($id, $judul){
      $find = array(',','.','&','!',':',' ');
      $replace = array('_','_','dan','_','_','_');
      $hasil = $id."_".str_replace($find, $replace, $judul);
      return $hasil;
    }

    function getIdFromLink($link){
      $is = explode("_", $link);
      return $is[0];
    }

    function getCategoryFromPost($id, $link){
      $q = $this->db->query("SELECT kategori FROM post Where id = '{$id}' ");
      $r = $q->row();

      if($link == true){
        return '<a href="'.base_url().'kategori/lihat/'.$r->kategori.'">'.ucwords(strtolower($r->kategori)).'</a>';
      } else {
        return ucwords(strtolower($r->kategori));
      }
    }

    function totalPageRowCategory($kategori){
      $q = $this->db->query("SELECT COUNT(*) as jumlah FROM post WHERE kategori = '{$kategori}'");
      $row = $q->row();
      return $row->jumlah;
    }

    function getTitle(){
      $id = $this->getIdFromLink($this->uri->segment(3));
      if( strlen($id) >= 1){
        $q = $this->db->query("SELECT judul FROM post Where id = '{$id}' ");
        $r = $q->row();
        return $r->judul;
      } else {
        return "Portal Berita Seputar Bandung Raya";
      }

    }

		function loadGallery(){
			$query = $this->db->query("SELECT * FROM cm_gallery ORDER BY id DESC");
			return $query;
		}

		function loadOption($value='')
		{
			$result ='';
			if($value != ''){
				$query = $this->db->query("SELECT * FROM ss_options WHERE codename ='{$value}'");
				foreach ($query->result() as $row)
				{
	        $result = $row->value;
				}
			}

			return $result;
		}
}
