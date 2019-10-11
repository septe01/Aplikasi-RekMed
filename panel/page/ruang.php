<?php 
if(isset($_POST['btn-kamar']))
{
	$nama		= htmlspecialchars($_POST['nama_kamar']);
	$kapasitas	= htmlspecialchars($_POST['kapasitas_kamar']);
	$var		= htmlspecialchars($_POST['tarif_kamar']);

		if(!preg_match("/^[a-zA-Z\.\s]*$/",$nama))	{
			$type = "warning";
			$judul = "Data gagal di tambah";
			$error = "Nama ruangan hanya boleh text !";	

		}elseif(!is_numeric($kapasitas)){
			$type = "error";
			$judul = "Data gagal di tambah";
			$success = "Kapasitas kamar harus angka.";	
			
		}else if(!floatval($var)){
				$type = "error";
				$judul = "Data gagal di tambah";
				$success = "tarif kamar harus angka.";	
				
		}else{
			$isikamar = 0;
				$tarif 		= intval(preg_replace('/[^\d.]/', '', $var));
				$notes 		= $DB_con->prepare("INSERT INTO tbl_kamar(nama_kamar,kapasitas_kamar,isi_kamar,tarif_kamar)VALUES('$nama','$kapasitas',$isikamar,'$tarif')");
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
	$nnama		= htmlspecialchars($_POST['nnama_kamar']);
	$patterna = '/([^0-9]+)/';
	$nkapasitas	= htmlspecialchars($_POST['nkapasitas_kamar']);
	if(is_numeric($nkapasitas)){
			$var		= $_POST['ntarif_kamar'];			
			if(floatval($var) || $var == 0){
				$ntarif 	= intval(preg_replace('/[^\d.]/', '', $var));				
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET nama_kamar='$nnama', kapasitas_kamar='$nkapasitas',tarif_kamar='$ntarif' WHERE kode_kamar='$nid'");
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
				$success = "tarif kamar harus angka.";	
			}
	}else{
			$type = "warning";
			$judul = "Data gagal di ubah";
			$success = "Kapasitas kamar harus angka.";
	}
}

if(isset($_POST['btn-hps']))
{
	$did 		= $_POST['did'];
	$dodelete 	= $DB_con->prepare("DELETE FROM tbl_kamar WHERE kode_kamar='$did'");
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
	<div class="col-xl-12">
		<div class="row">
			<div class="col-lg-3">
				<div class="widget has-shadow bg-warning">
					<div class="widget-header bordered no-actions d-flex align-items-center">
						<h4>Tambah Ruangan</h4>
					</div>	
					<div class="widget-body">
						<form method="post">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Nama Ruangan</label>
										<input name="nama_kamar" type="text" class="form-control" placeholder="masukan nama" required="" autocomplete="off">
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Kapasitas</label>
										<input name="kapasitas_kamar" id="kapas" type="text" class="form-control" placeholder="Kapasitas kamar" required="" autocomplete="off">
										<small id="emailHelp" class="form-text text-muted">Harus angka yang di input.</small>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Tarif Ruangan</label>
										<input name="tarif_kamar" id="tarif" type="text" class="form-control"  placeholder="Tarif ruangan" required="" autocomplete="off">
										<small id="emailHelp" class="form-text text-muted">Harus angka yang di input.</small>
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit" name="btn-kamar" class="btn btn-primary pull-right">Tambah</button>
								</div>
							</div>
						</form>
					</div>	
				</div>
			</div>
			<div class="col-lg-9">
				<!-- Sorting -->
				<div class="widget has-shadow">
					<div class="widget-header bg-primary bordered no-actions d-flex align-items-center">
						<h4 class="text-white">List Ruangan</h4>
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="sorting-table" class="table mb-0">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama</th>
										<th>Kapasitas</th>
										<th>Terisi</th>
										<th>Tarif</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$list = $DB_con->prepare("SELECT * FROM tbl_kamar");
									$list->execute();
									$no = 1;
									while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
										<tr>
											<td><span class="text-primary"><?= $no; ?></span></td>
											<td><?php echo ucfirst($row['nama_kamar']);?></td>
											<?php 
												if($row['nama_kamar'] == 'IGD'): ?>
												<td class="text-right"><?php echo $row['kapasitas_kamar'];?> orang</td>
											<?php 
												else: ?>
												<td class="text-right"><?php echo $row['kapasitas_kamar'];?> kamar</td>
											<?php 
											 endif; ?>
											<td class="text-right"><?php echo $row['isi_kamar'];?></td>
											<td class="text-right"><?php echo number_format($row['tarif_kamar']);?></td>
											<td class="text-right"><?php 
											$sisa = $row['kapasitas_kamar'] - $row['isi_kamar'];
											if ($sisa == 0) {
											 	echo "Penuh";
											 } else { echo "Tersedia";} ?></td>
											<td class="td-actions text-center">
												<a href="#" class="eedit" data-id="<?php echo $row['kode_kamar']?>" data-nama="<?php echo $row['nama_kamar']?>" data-tarif="<?php echo $row['tarif_kamar'];?>" data-kapasitas="<?php echo $row['kapasitas_kamar'];?>" data-toggle="modal" data-target="#update">
													<i class="la la-edit edit text-success"></i>
												</a>
												<a href="#" class="trash" data-id="<?php echo $row['kode_kamar']?>" data-toggle="modal" data-target="#delete"><i class="la la-close delete text-danger"></i></a>
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
<form method="post" onsubmit="return uKmr();">
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
								<input name="nnama_kamar" id="kanama" type="text" class="form-control" placeholder="masukan nama" autocomplete="off">
								<small id="nnkmr" class="form-text text-danger"></small>
								<input type="hidden" id="kano_id" name="nid">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">Kapasitas</label>
								<input name="nkapasitas_kamar" type="text" id="kapasitas" class="form-control"  placeholder="Kapasitas kamar" autocomplete="off">
								<small id="jmlk" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">Tarif</label>
								<input name="ntarif_kamar" type="text" id="katarr" class="form-control"  placeholder="tarif ruangan" autocomplete="off">
								<small id="tarKmr" class="form-text text-danger"></small>
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
	 	$("[name='nnama_kamar']").keyup(function(event) {
	 		$("#nnkmr").hide();
	 	});

		$("[name='nkapasitas_kamar']").keyup(function(event) {
			$("#jmlk").hide();
		});

		$("[name='ntarif_kamar']").keyup(function(event) {
			$("#tarKmr").hide();
		});
	
	function uKmr() {
		var nmkmr 	= $("[name='nnama_kamar']").val();
		var jmlk 	= $("[name='nkapasitas_kamar']").val();
		var tarkmr 	= $("[name='ntarif_kamar']").val();

		if(nmkmr == ""){
			$("#nnkmr").text('nama kamar tidak boleh kosong !').show();
				return false;

		}else if(!(/^[a-zA-Z\.\s]+$/.test(nmkmr))){
			$('#nnkmr').text('nama kamar hanya boleh text !').show();
				return false;

		}else if(!(/^[0-9\,]+$/.test(jmlk))){
			$("#jmlk").text('kapasitas hanya boleh angka !').show();
				return false;

		}else if(!(/^[0-9\,]+$/.test(tarkmr))){
			$("#tarKmr").text('tarif hanya boleh angka !').show();
				return false;

		}else{
			return true;
		}

	}
</script>

<script type="text/javascript">
	$('.eedit').click(function(){
		var kaid 		=$(this).data('id');
		var kanama 		=$(this).data('nama');
		var kakap 		=$(this).data('kapasitas');
		var tarif 		=$(this).data('tarif');
		var kaharga 	=tarif.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		document.getElementById('kano_id').value = kaid;
		document.getElementById('kanama').value = kanama;
		document.getElementById('katarr').value = kaharga;
		$("[name='nkapasitas_kamar']").val(kakap);
		// console.log(tarif);
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
	var frf = document.getElementById("katarr");
	var kpas = document.getElementById("kapas");
	var kpass = document.getElementById("kapasitas");

	fnf.addEventListener('keyup', function(evt){
		var n = parseInt(this.value.replace(/\D/g,''),10);
		fnf.value = n.toLocaleString();
	}, false);

	frf.addEventListener('keyup', function(evt){
		var n = parseInt(this.value.replace(/\D/g,''),10);
		frf.value = n.toLocaleString();
	}, false);

	kpas.addEventListener('keyup', function(evt){
		var n = parseInt(this.value.replace(/\D/g,''),10);
		kpas.value = n.toString();
	}, false);

	kpass.addEventListener('keyup', function(evt){
		var n = parseInt(this.value.replace(/\D/g,''),10);
		kpass.value = n.toString();
	}, false);
	
</script>