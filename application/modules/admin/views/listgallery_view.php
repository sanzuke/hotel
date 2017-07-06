<h3><?php echo $judul_halaman ?></h3>
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
                  <button class="btn btn-primary"><i class="fa fa-edit"></i></button>
                  <button class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                </div>
              </td>
            </tr>';
          $i++;
    }
    ?>
  </tbody>
</table>
