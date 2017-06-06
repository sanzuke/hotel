<h3>Tambah Halaman</h3>
<form class="form-horizontal">
	<div class="col-md-8">
		<div class="form-group">
	     	<label class="control-label" for="inputSuccess1"></label>
	        <input type="text" class="form-control1" id="judul" placeholder="Masukan Judul Disini">
	    </div>
		<div class="form-group">
			<textarea class="form-control1" id="editor"></textarea>
		</div>
	</div>
	<div class="col-md-4"><br>
		<div class="panel panel-default">
			<div class="panel-heading">Opsi</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="selector1" class="col-sm-3 control-label">Parent</label>
					<div class="col-sm-9">
						<select name="selector1" id="selector1" class="form-control1">
							<option value="0">(no parent)</option>
							<option>Lorem ipsum dolor sit amet.</option>
							<option>Dolore, ab unde modi est!</option>
							<option>Illum, fuga minus sit eaque.</option>
							<option>Consequatur ducimus maiores voluptatum minima.</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="checkbox" class="col-sm-3 control-label">Publikasi</label>
					<div class="col-sm-9">
						<div class="checkbox-inline"><label><input type="checkbox" checked=""></label></div>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<button class="btn btn-primary pull-right">Simpan</button>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Gambar</div>
			<div class="panel-body">
				<div class="form-group">
			        <label for="exampleInputFile" class="col-md-12">Upload Gambar</label>
			        <input type="file" id="exampleInputFile" class="col-md-12">
			    </div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</form>
<script>
	tinymce.init({
	  selector: 'textarea',
	  height: 400,
	  menubar: false,
	  plugins: [
	    'advlist autolink lists link image charmap print preview anchor',
	    'searchreplace visualblocks code fullscreen',
	    'insertdatetime media table contextmenu paste code'
	  ],
	  toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
	  content_css: '//www.tinymce.com/css/codepen.min.css'
	});
</script>