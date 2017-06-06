<h3><?php echo $judul_halaman ?></h3>
<table class="table table-striped" id="grid">
	<thead>
		<tr>
			<th>Pemesan</th>
			<!-- <th>Alamat</th>
			<th>Email</th>-->
			<th>Telp.</th> 
			<th>CheckIn</th>
			<th>CheckOut</th>
			<th>Opsi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($listData->result() as $key) {
			echo '<tr>
					<td>'.$key->Nama.'</td>
					<td>'.$key->Telp.'</td>
					<td>'.$this->Admin_model->generateDate($key->TglPesan, 'c').'</td>
					<td>'.$this->Admin_model->generateDate($key->TglChekOut, 'c').'</td>
					<td>
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