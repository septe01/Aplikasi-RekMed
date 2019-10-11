<?php 
if(isset($_POST['btn-tindakan']))
{
	$nama		= htmlspecialchars($_POST['nama_tindakan']);
	$var		= htmlspecialchars($_POST['tarif_tindakan']);

	if(!preg_match("/^[a-zA-Z\.\s\/\()]*$/",$nama))	{
			$type = "warning";
			$judul = "Data gagal di tambah";
			$error = "Nama tindakan hanya boleh text !";	

	}elseif(!floatval($var)){
			$type = "error";
			$judul = "Data gagal di tambah";
			$success = "tarif tindakan harus angka.";
		
	}else{
		$tarif 		= intval(preg_replace('/[^\d.]/', '', $var));
		$notes 		= $DB_con->prepare("INSERT INTO tbl_tindakan(nama_tindakan,tarif_tindakan)VALUES('$nama','$tarif')");
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
	$nnama		= htmlspecialchars($_POST['nnama_tindakan']);
	$var		= htmlspecialchars($_POST['ntarif_tindakan']);
	if(floatval($var)){
		$ntarif 	= intval(preg_replace('/[^\d.]/', '', $var));
		$menus = $DB_con->prepare("UPDATE tbl_tindakan SET nama_tindakan='$nnama',tarif_tindakan='$ntarif' WHERE kode_tindakan='$nid'");
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
			$success = "tarif tindakan harus angka.";
	}
}

if(isset($_POST['btn-hps']))
{
	$did 		= $_POST['did'];
	$dodelete 	= $DB_con->prepare("DELETE FROM tbl_tindakan WHERE kode_tindakan='$did'");
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
	<!-- tambah data -->
	<div class="col-xl-12">
		<div class="row">
			<div class="col-lg-4">
				<div class="widget has-shadow bg-warning">
					<div class="widget-header bordered no-actions d-flex align-items-center">
						<h4>Tambah tindakan</h4>
					</div>	
					<div class="widget-body">
						<form method="post">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Nama tindakan</label>
										<input name="nama_tindakan" type="text" class="form-control" placeholder="masukan nama" required="" autocomplete="off" >
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Tarif tindakan</label>
										<input name="tarif_tindakan" type="text" id="tarif" class="form-control"  placeholder="tarif tindakan" required="" autocomplete="off" >
										<small id="emailHelp" class="form-text text-muted">Harus angka yang di input.</small>
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit" name="btn-tindakan" class="btn btn-primary pull-right">Tambah</button>
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
						<h4 class="text-white">List tindakan</h4>
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="sorting-table" class="table mb-0">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama</th>
										<th>Tarif</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$list = $DB_con->prepare("SELECT * FROM tbl_tindakan");
									$list->execute();
									$no = 1;
									while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
										<tr>
											<td><span class="text-primary"><?= $no; ?></span></td>
											<td><?php echo ucfirst($row['nama_tindakan']);?></td>
											<td class="text-right"><?php echo number_format($row['tarif_tindakan']);?></td>
											<td class="td-actions text-center">
												<a href="#" class="eedit" data-id="<?php echo $row['kode_tindakan']?>" data-nama="<?php echo $row['nama_tindakan']?>" data-tarif="<?php echo $row['tarif_tindakan'];?>" data-toggle="modal" data-target="#update">
													<i class="la la-edit edit text-success"></i>
												</a>
												<a href="#" class="trash" data-id="<?php echo $row['kode_tindakan']?>" data-toggle="modal" data-target="#delete"><i class="la la-close delete text-danger"></i></a>
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

<!-- modal ubah -->
<form method="post" onsubmit="return uTdk();">
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
								<input name="nnama_tindakan" id="tnama" type="text" class="form-control" placeholder="masukan nama" autocomplete="off" >
								<small id="nmtdk" class="form-text text-danger"></small>
								<input type="hidden" id="tno_id" name="nid">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">Tarif</label>
								<input name="ntarif_tindakan" type="text" id="ttarr" class="form-control"  placeholder="tarif alat" autocomplete="off" >
								<small id="tarTdk" class="form-text text-danger"></small>
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
	 	$("#tnama").keyup(function(event) {
	 		$("#nmtdk").hide();
	 	});

		$("#ttarr").keyup(function(event) {
			$("#tarTdk").hide();
		});
	
	function uTdk() {
		var nmtdk 	= $("#tnama").val();
		var tarif 	= $("#ttarr").val();

		if(nmtdk == ""){
			$("#nmtdk").text('nama alat tidak boleh kosong !').show();
				return false;

		}else if(!(/^[a-zA-Z\.\s\/\()]+$/.test(nmtdk))){
			$('#nmtdk').text('nama alat hanya boleh text !').show();
				return false;

		}else if(!(/^[0-9\,]+$/.test(tarif))){
			$("#tarTdk").text('tarif hanya boleh angka !').show();
				return false;

		}else{
			return true;
		}

	}
</script>

<script type="text/javascript">
	$('.eedit').click(function(){
		var tid 		=$(this).data('id');
		var tnama 	=$(this).data('nama');
		var tarif 	=$(this).data('tarif');
		var tharga 	=tarif.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		document.getElementById('tno_id').value = tid;
		document.getElementById('tnama').value = tnama;
		document.getElementById('ttarr').value = tharga;
		// alert(tarif);
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

<script type="text/javascript">
	$('.trash').click(function(){
		var id=$(this).data('id');
		document.getElementById('d_id').value = id;
	});
</script>

<script type="text/javascript">
	var fnf = document.getElementById("tarif");
	var frf = document.getElementById("ttarr");
	fnf.addEventListener('keyup', function(evt){
		var n = parseInt(this.value.replace(/\D/g,''),10);
		fnf.value = n.toLocaleString();
	}, false);
	frf.addEventListener('keyup', function(evt){
		var n = parseInt(this.value.replace(/\D/g,''),10);
		frf.value = n.toLocaleString();
	}, false);
</script>