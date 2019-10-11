 <?php 
if(isset($_POST['btn-alat']))
{
	$nama	= htmlspecialchars($_POST['nama_alat']);
	$var	= htmlspecialchars($_POST['tarif_alat']);
	$tarif 	= intval(preg_replace('/[^\d.]/', '', $var));

		if(!preg_match("/^[a-zA-Z\.\s]*$/",$nama))	{
			$type = "warning";
			$judul = "Data gagal di tambah";
			$error = "Nama alat hanya boleh text !";	

		}elseif(!floatval($var)){
				$type = "error";
				$judul = "Data gagal di tambah";
				$success = "tarif alat harus angka.";	
		}else{
			$notes 	= $DB_con->prepare("INSERT INTO tbl_alat(nama_alat,tarif_alat)VALUES('$nama', '$tarif')");
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
	$nnama 		= htmlspecialchars($_POST['nnama_alat']);
	$var 		= htmlspecialchars($_POST['ntarif_alat']);
	$ntarif 	= intval(preg_replace('/[^\d.]/', '', $var));
	if(floatval($var)){
		$menus = $DB_con->prepare("UPDATE tbl_alat SET nama_alat='$nnama', tarif_alat='$ntarif' WHERE kode_alat='$nid'");
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
				$judul = "Data gagal di ubah";
				$success = "tarif alat harus angka.";	
			}
}

if(isset($_POST['btn-hps']))
{
	$did 		= $_POST['did'];
	$dodelete 	= $DB_con->prepare("DELETE FROM tbl_alat WHERE kode_alat='$did'");
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

<!-- main -->
<div class="row justify-content-center">
	<div class="col-xl-12">
		<div class="row">
			<div class="col-lg-4">
				<div class="widget has-shadow bg-warning">
					<div class="widget-header bordered no-actions d-flex align-items-center">
						<h4>Tambah Alat</h4>
					</div>	
					<div class="widget-body">
						<form method="post">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Nama Alat</label>
										<input name="nama_alat" type="text" class="form-control" placeholder="masukan nama" required="" autocomplete="off" >
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Tarif Alat</label>
										<input name="tarif_alat" type="text" id="tarif" class="form-control"  placeholder="tarif alat" required="" autocomplete="off" >
										<small id="emailHelp" class="form-text text-muted">Harus angka yang di input.</small>
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit" name="btn-alat" class="btn btn-primary pull-right">Tambah</button>
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
						<h4 class="text-white">List Alat</h4>
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="sorting-table" class="table mb-0">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama Alat</th>
										<th>Tarif</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$list = $DB_con->prepare("SELECT * FROM tbl_alat");
									$list->execute();
									$no = 1;
									while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
										<tr>
											<td><span class="text-primary"><?= $no; ?></span></td>
											<td><?php echo ucfirst($row['nama_alat']);?></td>
											<td class="text-right"><?php echo number_format($row['tarif_alat']);?></td>
											<td class="td-actions text-center">
												<a href="#" class="eedit" data-eid="<?php echo $row['kode_alat']?>" data-nmalat="<?php echo $row['nama_alat']?>" data-tarif="<?php echo $row['tarif_alat'];?>" data-toggle="modal" data-target="#update">
													<i class="la la-edit edit text-success"></i>
												</a>
												<a href="#" class="trash" data-id="<?php echo $row['kode_alat']?>" data-toggle="modal" data-target="#delete"><i class="la la-close delete text-danger"></i></a>
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

<!-- modal ubah data -->
<form method="post" onsubmit="return uAlat();">
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
								<input name="nnama_alat" id="enama" type="text" class="form-control" placeholder="masukan nama" autocomplete="off">
								<small id="nmal" class="form-text text-danger"></small>
								<input type="hidden" id="aid" name="nid">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">Tarif</label>
								<input name="ntarif_alat" type="text" id="tarr" class="form-control"  placeholder="tarif alat" autocomplete="off">
								<small id="tarral" class="form-text text-danger"></small>
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

<!-- modal hapus -->
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
	 	$("#enama").keyup(function(event) {
	 		/* Act on the event */
	 		$("#nmal").hide();
	 	});

		$("#tarr").keyup(function(event) {
			/* Act on the event */
			$("#tarral").hide();
		});
	
	function uAlat() {
		var nmal 	= $("#enama").val();
		var tarif 	= $("#tarr").val();

		if(nmal == ""){
			$("#nmal").text('nama alat tidak boleh kosong !').show();
				return false;

		}else if(!(/^[a-zA-Z\.\s]+$/.test(nmal))){
			$('#nmal').text('nama alat hanya boleh text !').show();
				return false;

		}else if(!(/^[0-9\,]+$/.test(tarif))){
			$("#tarral").text('tarif hanya boleh angka !').show();
				return false;

		}else{
			return true;
		}

	}
</script>

<script type="text/javascript">
	$('.eedit').click(function(){
		var eid 		=$(this).data('eid');
		var enama 	=$(this).data('nmalat');
		var tarif 	=$(this).data('tarif');
		var harga 	=tarif.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

		document.getElementById('aid').value = eid;
		document.getElementById('enama').value = enama;
		document.getElementById('tarr').value = harga;
		console.log(tarif);
	});
</script>

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