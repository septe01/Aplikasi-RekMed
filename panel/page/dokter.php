<?php 
if(isset($_POST['btn-dokter']))
{
	$nama		= htmlspecialchars($_POST['nama_dokter']);
	$spesialis	= htmlspecialchars($_POST['spesialis_dokter']);
	$var		= htmlspecialchars($_POST['tarif_dokter']);
	$tarif 		= intval(preg_replace('/[^\d.]/', '', $var));

	if(!preg_match("/^[a-zA-Z\.\s]*$/",$nama))	{
			$type = "warning";
			$judul = "Data gagal di tambah";
			$error = "Nama dokter hanya boleh text !";	

	}elseif(!floatval($var)){
			$type = "error";
			$judul = "Data gagal di tambah";
			$success = "tarif dokter harus angka.";	
		
	}else{
		$notes 		= $DB_con->prepare("INSERT INTO tbl_dokter(nama_dokter,spesialis_dokter,tarif_dokter)VALUES('$nama','$spesialis','$tarif')");
		$notes->execute();	
		if($notes){
						$type = "success";
						$judul = "Congratulations !";
						$success = "data berhasil di tambah !!!";
		}else{
						$type = "error";
						$judul = "Oops. !";
						$success = "data gagal di tambah !!!";
			}
	}
	
}

if(isset($_POST['btn-ubah']))
{
	$nid 		= $_POST['nid'];
	$nnama		= htmlspecialchars($_POST['nnama_dokter']);
	$nspesialis	= htmlspecialchars($_POST['nspesialis']);
	$var		= htmlspecialchars($_POST['ntarif_dokter']);
	if(floatval($var)){
		$ntarif 	= intval(preg_replace('/[^\d.]/', '', $var));
		$menus = $DB_con->prepare("UPDATE tbl_dokter SET nama_dokter='$nnama', spesialis_dokter='$nspesialis',tarif_dokter='$ntarif' WHERE kode_dokter='$nid'");
		$menus->execute();
		if($menus){
						$type = "success";
						$judul = "Congratulations !";
						$success = "data berhasil di ubah !!!";
		}else{
						$type = "error";
						$judul = "Oops. !";
						$success = "data gagal di ubah !!!";
		}
	}else{
			$type = "error";
			$judul = "Data gagal di tambah";
			$success = "tarif dokter harus angka.";	
		}
	
}

if(isset($_POST['btn-hps']))
{
	$did 		= $_POST['did'];
	$dodelete 	= $DB_con->prepare("DELETE FROM tbl_dokter WHERE kode_dokter='$did'");
	$dodelete->execute();	
	if($dodelete){
					$type = "success";
					$judul = "Congratulations !";
					$success = "data berhasil di hapus !!!";
	}else{
					$type = "error";
					$judul = "Oops. !";
					$success = "data gagal di hapus !!!";
	}
	
}
?>
<div class="row justify-content-center">
	<!-- add data -->
	<div class="col-xl-12">
		<div class="row">
			<div class="col-lg-4">
				<div class="widget has-shadow bg-warning">
					<div class="widget-header bordered no-actions d-flex align-items-center">
						<h4>Tambah Dokter</h4>
					</div>	
					<div class="widget-body">
						<form method="post">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Nama Dokter</label>
										<input name="nama_dokter" type="text" class="form-control" placeholder="masukan nama" required="" autocomplete="off">
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Spesialis</label>
										<input name="spesialis_dokter" type="text" class="form-control"  placeholder="spesialis dokter" required="" autocomplete="off">
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Tarif Dokter</label>
										<input name="tarif_dokter" type="text" id="tarif" class="form-control"  placeholder="tarif dokter" required="" autocomplete="off">
										<small id="emailHelp" class="form-text text-muted">Harus angka yang di input.</small>
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit" name="btn-dokter" class="btn btn-primary pull-right">Tambah</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-8">
				<!-- Sorting -->
				<div class="widget has-shadow">
					<div class="widget-header bg-primary bordered no-actions d-flex align-items-center">
						<h4 class="text-white">List Dokter</h4>
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="sorting-table" class="table mb-0">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama Dokter</th>
										<th>Spesialis</th>
										<th>Tarif</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$list = $DB_con->prepare("SELECT * FROM tbl_dokter");
									$list->execute();
									$no = 1;
									while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
										<tr>
											<td><span class="text-primary"><?= $no; ?></span></td>
											<td><?php echo ucfirst($row['nama_dokter']);?></td>
											<td><?php echo ucfirst($row['spesialis_dokter']);?></td>
											<td class="text-right"><?php echo number_format($row['tarif_dokter']);?></td>
											<td class="td-actions text-center">
												<a href="#" class="eedit" data-id="<?php echo $row['kode_dokter']?>" data-nama="<?php echo $row['nama_dokter']?>" data-tarif="<?php echo $row['tarif_dokter'];?>" data-spesialis="<?php echo $row['spesialis_dokter'];?>" data-toggle="modal" data-target="#update">
													<i class="la la-edit edit text-success"></i>
												</a>
												<a href="#" class="trash" data-id="<?php echo $row['kode_dokter']?>" data-toggle="modal" data-target="#delete"><i class="la la-close delete text-danger"></i></a>
											</td>
										</tr>
									<?php $no++; } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- End Row -->
			</div>
		</div>

	</div>
	<!-- Offcanvas Sidebar -->
</div>
	
	<!-- ubahdata -->
<form method="post" onsubmit="return uDokter();">
	<div id="update" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Ubah</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">tutup</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">Nama</label>
								<input name="nnama_dokter" id="dnama" type="text" class="form-control" placeholder="masukan nama" autocomplete="off" >
								<small id="dname" class="form-text text-danger"></small>
								<input type="hidden" id="deno_id" name="nid">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">Spesialis</label>
								<input name="nspesialis" type="text" id="spesialis" class="form-control"  placeholder="spesialis" autocomplete="off" >
								<small id="spesialiss" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">Tarif</label>
								<input name="ntarif_dokter" type="text" id="tarr" class="form-control"  placeholder="tarif alat" autocomplete="off" >
								<small id="tarrd" class="form-text text-danger"></small>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Tutup</button>
					<button type="submit" name="btn-ubah" class="btn btn-danger">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</form>
<form method="post">
	<div id="delete" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
					<div class="section-title mt-5 mb-2">
						<h2 class="text-gradient-02">Anda yakin mau menghapus ini ?</h2>
						<input type="hidden" name="did" id="d_id">
					</div>
					<p class="mb-5">Data tidak dapat dikembalikan setelah di hapus</p>
					<button type="submit" class="btn btn-danger mb-3" name="btn-hps">Ok</button>
				</div>
			</div>
		</div>
	</div>
</form>

<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery.min.js"></script>

<!-- valid formubah -->
<script>
	 	$("#dnama").keyup(function(event) {
	 		/* Act on the event */
	 		$("#dname").hide();
	 	});

		$("#spesialis").keyup(function(event) {
			/* Act on the event */
			$("#spesialiss").hide();
		});

		$("#tarr").keyup(function(event) {
			/* Act on the event */
			$("#tarrd").hide();
		});
	
	function uDokter() {
		var nmdok 	= $("#dnama").val();
		var spesialis 	= $("#spesialis").val();
		var tarif 	= $("#tarr").val();

		if(nmdok == ""){
			$("#dname").text('nama dokter tidak boleh kosong !').show();
				return false;

		}else if(!(/^[a-zA-Z\.\s]+$/.test(nmdok))){
			$('#dname').text('nama dokter hanya boleh text !').show();
				return false;

		}else if(spesialis == ""){
			$("#spesialiss").text('spesialis tidak boleh kosong !').show();
				return false;

		}else if(!(/^[a-zA-Z\.\s]+$/.test(spesialis))){
			$('#spesialiss').text('spesialis hanya boleh text !').show();
				return false;

		}else if(!(/^[0-9\,]+$/.test(tarif))){
			$("#tarrd").text('tarif hanya boleh angka !').show();
				return false;

		}else{
			return true;
		}

	}
</script>

<!-- form ubah data -->
<script type="text/javascript">
	$('.eedit').click(function(){
		var deid 		=$(this).data('id');
		var dnama 	=$(this).data('nama');
		var spes 	=$(this).data('spesialis');
		var tarif 	=$(this).data('tarif');
		var harga 	=tarif.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		document.getElementById('deno_id').value = deid;
		document.getElementById('dnama').value = dnama;
		document.getElementById('spesialis').value = spes;
		document.getElementById('tarr').value = harga;
		console.log(tarif);
	});
</script>

<!-- hapus data -->
<script type="text/javascript">
	$('.trash').click(function(){
		var id=$(this).data('id');
		document.getElementById('d_id').value = id;
	});
</script>

<!-- valid required -->
<script>
	document.addEventListener("DOMContentLoaded", function() {
             var elment = document.getElementsByTagName('INPUT');
             for (var i = 0; i < elment.length; i++) {
                 elment[i].oninvalid = function(e) {
                     e.target.setCustomValidity("");
                     if(!e.target.validity.valid){
                        e.target.setCustomValidity("Bagian ini harus diisi.");
                     }
                 };
                 elment[i].oninput = function(e){
                    e.target.setCustomValidity("");
                 };
             }
         });
</script>

<!-- parse Int -->
<script type="text/javascript">
	var fnf = document.getElementById("tarif");
	var frf = document.getElementById("tarr");
	fnf.addEventListener('keyup', function(evt){
		var n = parseInt(this.value.replace(/\D/g,''),10);
		fnf.value = n.toLocaleString();
	}, false);
	frf.addEventListener('keyup', function(evt){
		var n = parseInt(this.value.replace(/\D/g,''),10);
		frf.value = n.toLocaleString();
	}, false);
</script>