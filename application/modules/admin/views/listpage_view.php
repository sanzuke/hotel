<h3>Daftar Halaman</h3>
<?php echo $this->Admin_model->showMessage(); ?>
<table class="table table-striped" id="grid">
	<thead>
		<tr>
			<th class="col-md-6">Judul</th>
			<th class="col-md-2">Penulis</th>
			<th class="col-md-2">Tanggal</th>
			<th class="col-md-2">Opsi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($listPage->result() as $key) {
			echo '<tr>
					<td class="col-md-6">'.$key->post_title.'</td>
					<td class="col-md-2">'.$key->user_nicename.'</td>
					<td class="col-md-2">'.$this->Admin_model->generateDate($key->post_date, 'basic').'</td>
					<td class="col-md-2">
						<div class="btn-group">
							<a href="" class="btn btn-default"><i class="fa fa-edit"></i></a>
							<a href="" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
						</div>
					</td>
				</tr>';
		}
		?>
	</tbody>
</table>
