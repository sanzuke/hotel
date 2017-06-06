<h3>Daftar Kategori</h3>
<?php echo $this->Admin_model->showMessage(); ?>
<form method="POST" action="<?php echo base_url() ?>admin/categorysave">
<div class="col-md-4">
	<div class="form-group">
     	<label class="control-label" for="inputSuccess1">Nama Kategori</label>
        <input type="text" class="form-control1" name="kategori" id="kategori" >
        <input type="hidden" class="form-control1" name="id" id="id" >
    </div>
    <div class="form-group">
     	<label class="control-label" for="inputSuccess1">slug</label>
        <input type="text" class="form-control1" name="slug" id="slug" >
    </div>
    <div class="form-group">
		<label for="parent" class="control-label">Parent</label>
		<select name="parent" id="parent" class="form-control1">
			<option value="0">(no parent)</option>
			<?php 
			foreach ($listCategory->result() as $row) {
				echo '<option value="'.$row->id.'">'.$row->category_name.'</option>';
			}
			?>
		</select>
	</div>
	<div class="form-group">
		<label for="desc" class="control-label">Deskripsi</label>
		<textarea class="form-control1" name="desc" rows="5" id="desc"></textarea>
	</div>
	<div class="form-group">
		<button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
	</div>
	<div class="clearfix"></div>
</div>
</form>
<div class="col-md-8">
	<table class="table table-striped" id="grid">
		<thead>
			<tr>
				<th class="col-md-4">Nama</th>
				<th class="col-md-4">Deskripsi</th>
				<th class="col-md-2">Slug</th>
				<th class="col-md-2">Opsi</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sub = "";
			foreach ($listCategory->result() as $key) {
				echo '<tr>
						<td class="col-md-4">'.$key->category_name.'</td>
						<td class="col-md-4">'.$key->category_desc.'</td>
						<td class="col-md-2">'.$key->category_slug.'</td>
						<td class="col-md-2">
							<div class="btn-group">
								<a href="javascript:;" onclick="edit(\''.$key->id.'\',\''.$key->category_name.'\',\''.$key->category_slug.'\',\''.$key->category_desc.'\',\''.$key->category_parent.'\')" class="btn btn-default"><i class="fa fa-edit"></i></a>
								<a href="javascript:;" onclick="del(\''.$key->id.'\')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
							</div>
						</td>
					</tr>';

				$listCategorySub = $this->Admin_model->loadListCategorySub($key->id);

				if( count($listCategorySub->result()) > 0 ){
					foreach ($listCategorySub->result() as $val) {
						echo '<tr>
								<td class="col-md-4">—'.$val->category_name.'</td>
								<td class="col-md-4">'.$val->category_desc.'</td>
								<td class="col-md-2">'.$val->category_slug.'</td>
								<td class="col-md-2">
									<div class="btn-group">
										<a href="javascript:;" onclick="edit(\''.$val->id.'\',\''.$val->category_name.'\',\''.$val->category_slug.'\',\''.$val->category_desc.'\',\''.$val->category_parent.'\')" class="btn btn-default"><i class="fa fa-edit"></i></a>
										<a href="javascript:;" onclick="del(\''.$val->id.'\')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
									</div>
								</td>
							</tr>';
					}
				} 
				// else {
				// 	echo '<tr>
				// 		<td class="col-md-4">'.$key->category_name.'</td>
				// 		<td class="col-md-4">'.$key->category_desc.'</td>
				// 		<td class="col-md-2">'.$key->category_slug.'</td>
				// 		<td class="col-md-2">
				// 			<div class="btn-group">
				// 				<a href="javascript:;" onclick="edit(\''.$key->id.'\',\''.$key->category_name.'\',\''.$key->category_slug.'\',\''.$key->category_desc.'\',\''.$key->category_parent.'\')" class="btn btn-default"><i class="fa fa-edit"></i></a>
				// 				<a href="javascript:;" onclick="del(\''.$key->id.'\')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
				// 			</div>
				// 		</td>
				// 	</tr>';
				// }
				
			}
			?>
		</tbody>
	</table>
</div>
<div class="clearfix"></div>
<script type="text/javascript">
	function del(id){
		var psn = confirm("Anda yakin akan menghapus data?");
		if(psn){
			window.location = "<?php echo base_url() ?>admin/delcategory/"+id;
		}
	}

	function edit(id, nama, slug, desc, parent){
		$("#id").val(id);
		$("#kategori").val(nama);
		$("#slug").val(slug);
		$("#parent").val(parent);
		$("#desc").val(desc);
	}
</script>