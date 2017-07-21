<h3><?php echo $judul_halaman ?></h3>
<?php echo $this->Admin_model->showMessage(); ?>
<div class="col-md-12">
  <div class="pull-right">
    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah</button>
  </div>
</div>
<table class="table">
  <thead>
    <tr>
      <th>No</th>
      <th>Judul</th>
      <th>Gambar</th>
      <th>Keterangan</th>
      <th>Opsi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i =1;
    foreach ($listPage->result() as $key) {
      # code...
      echo '<tr>
              <td>'.$i.'</td>
              <td>'.$key->judul.'</td>
              <td><img src="'.base_url().'uploads/gallery/'.$key->image.'" class="img-responsive img-thumbnail" width="100"></td>
              <td>'.$key->keterangan.'</td>
              <td>
                <div class="btn-group">
                  <!-- <button class="btn btn-primary" onclick="editGallery(\''.$key->id.'\',\''.$key->judul.'\',\''.$key->image.'\',\''.$key->keterangan.'\')"><i class="fa fa-edit"></i></button> -->
                  <button class="btn btn-danger" onclick="delGallery(\''.$key->id.'\',\''.$key->image.'\')"><i class="fa fa-trash-o"></i></button>
                </div>
              </td>
            </tr>';
          $i++;
    }
    ?>
  </tbody>
</table>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambah Gambar Baru</h4>
      </div>
      <form action="<?php echo base_url() . "admin/savegallery" ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label>Judul</label>
            <input type="text" name="judul" id="judul" class="form-control1" />
          </div>
          <div class="form-group">
            <label>Gambar</label>
            <input type="file" name="userfile" id="userfile" class="form-control1" />
          </div>
          <div class="form-group">
            <label>Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control1" />
          </div>
          <div class="form-group img-tmp">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  function delGallery(id, img){
    var psn = confirm("Anda yakin akan menghapus file gambar?");
    if(psn){
      window.location = '<?php echo base_url() . 'admin/delgallery' ?>/'+id+'/'+img;
    }
  }

  function editGallery(id, judul, img, ket){
    $("#judul").val(judul)
    $(".img-tmp").html('<img src="'+'<?php echo base_url() ?>uploads/gallery/'+ img +'" class="thumbnail img-responsive" />')
    $("#keterangan").val(ket)

    $("#myModal").modal("show")
  }
</script>
