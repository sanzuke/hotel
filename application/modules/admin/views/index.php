<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Modern an Admin Panel Category Flat Bootstarp Resposive Website Template | Home :: w3layouts</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Modern Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?php echo base_url(); ?>assets/admin/css/style.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?php echo base_url(); ?>assets/admin/css/jquery.dataTables.min.css" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="<?php echo base_url(); ?>assets/admin/css/lines.css" rel='stylesheet' type='text/css' />
<link href="<?php echo base_url(); ?>assets/admin/css/font-awesome.css" rel="stylesheet">
<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.min.js"></script>
<!-- webfonts--->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<!---//webfonts--->
<!-- Nav CSS -->
<link href="<?php echo base_url(); ?>assets/admin/css/custom.css" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url(); ?>assets/admin/js/metisMenu.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/custom.js"></script>
<!-- Graph JavaScript -->
<script src="<?php echo base_url(); ?>assets/admin/js/d3.v3.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/rickshaw.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/tinymce/tinymce.min.js"></script>
<!-- DataTable -->
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div id="wrapper">
     <!-- Navigation -->
        <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url() ?>admin/dashboard">Admin Panel</a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
	        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-comments-o"></i><span class="badge"><?php echo $reserfasiAllBaru ?></span></a>
	        <ul class="dropdown-menu">
            <?php foreach ($reserfasi5Baru->result() as $key) { ?>
              <li class="avatar">
  							<a href="javascript:;" onclick="showNotif('<?php echo $key->KodeR; ?>', null)">
  								<img src="<?php echo base_url() ?>assets/admin/images/1.png" alt=""/>
  								<div><?php echo $key->Nama ?></div>
  								<small><?php echo $this->Admin_model->time_elapsed_string($key->createddate, false) ?></small>
  								<span class="label label-info"><?php echo $key->isread = 0 ? '' : 'BARU' ?></span>
  							</a>
  						</li>
            <?php } ?>
						<li class="dropdown-menu-footer text-center">
							<a href="#">View all messages</a>
						</li>
	        		</ul>
	      		</li>
			    <li class="dropdown">
	        		<a href="#" class="dropdown-toggle avatar" data-toggle="dropdown"><i class="fa fa-user fa-lg"></i><!-- <span class="badge">9</span> --></a>
	        		<ul class="dropdown-menu">
    						<li class="m_2"><a href="#"><i class="fa fa-user"></i> Profile</a></li>
    						<li class="m_2"><a href="<?php echo base_url() ?>admin/logout"><i class="fa fa-lock"></i> Logout</a></li>
	        		</ul>
	      		</li>
			</ul>
			<!-- <form class="navbar-form navbar-right">
              <input type="text" class="form-control" value="Search..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search...';}">
            </form> -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard fa-fw nav_icon"></i>Beranda</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-check-square-o nav_icon"></i>Halaman<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>admin/listpage">Daftar Halaman</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>admin/addpage">Tambah Halaman</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-pencil-square-o nav_icon"></i>Posting<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>admin/listcategory">Kategori</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>admin/listpost">Daftar Posting</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>admin/addpost">Tambah Posting</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-picture-o nav_icon"></i>Galeri<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>admin/listgallery">Daftar Galeri</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-users nav_icon"></i>Reservasi<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>admin/reservasi">Daftar Reservasi</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-gears nav_icon"></i>Pengaturan<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>admin/general">Umum</a>
                                </li>
                                <!-- <li>
                                    <a href="<?php echo base_url() ?>admin/parameter">Parameter Kamar</a>
                                </li> -->
                                <!-- <li>
                                    <a href="<?php echo base_url() ?>admin/maps">Maps</a>
                                </li> -->
                                <li>
                                    <a href="<?php echo base_url() ?>admin/socialmedia">Sosial Media</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <!-- <li>
                          <a href="#"><i class="fa fa-archive"></i> Plugin</a>
                          <ul class="nav nav-second-level">
                            <li>
                              <a href="<?php echo base_url() ?>admin/content-home">Content Home</a>
                            </li>
                          </ul>
                        </li> -->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
            <div class="graphs">
                <div class="xs">
                    <?php $this->load->view($konten_view); ?>
                </div>
        		<div class="copy">
                    <p>Copyright &copy; 2015 Modern. All Rights Reserved | Design by <a href="http://w3layouts.com/" target="_blank">W3layouts</a> </p>
        	    </div>
    		</div>
       </div>
      <!-- /#page-wrapper -->
   </div>

   <div class="modal fade" id="myModalNotif" tabindex="-1" role="dialog">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title" >Reservasi Baru</h4>
         </div>
         <div class="modal-body">
           <table id="notif" class="table table-striped"></table>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
         </div>
       </div>
     </div>
   </div>

    <!-- /#wrapper -->
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    function showNotif(idNotif, sts) {
      $("#myModalNotif").modal("show");
      $.post('<?php echo base_url() . 'admin/getnotif' ?>', {id:idNotif}, function (json) {
        if( json.length > 0 ){
          $("#notif").html('');
          $.each(json, function(idx, val){
            var str = '<tr><td>Nama</td><td>: '+val.nama+'</td></tr>'+
                      '<tr><td>Alamat</td><td>: '+val.alamat+'</td></tr>'+
                      '<tr><td>Telp</td><td>: '+val.telp+'</td></tr>'+
                      '<tr><td>Email</td><td>: '+val.email+'</td></tr>'+
                      '<tr><td>Checkin</td><td>: '+val.checkin+'</td></tr>'+
                      '<tr><td>Checkout</td><td>: '+val.checkout+'</td></tr>'+
                      '<tr><td>Jenis Kamar</td><td>: '+val.kamar+'</td></tr>'+
                      '<tr><td>Jumlah Kamar</td><td>: '+val.jumlah+'</td></tr>';
            $("#notif").append(str);
          })
        }
      })

      if(sts !== null){
        $("."+sts).html('');
      }
    }
    </script>
</body>
</html>
