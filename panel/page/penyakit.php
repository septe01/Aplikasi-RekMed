 <?php 
if(isset($_POST['btn-penyakit']))
{
		$nama	= htmlspecialchars($_POST['nm_penyakit']);

		if(!preg_match("/^[a-zA-Z\.\s\/\()]*$/",$nama))	{
			$type = "warning";
			$judul = "Data gagal di tambah";
			$error = "Nama penyakit hanya boleh text !";	

	}else{
		$notes 	= $DB_con->prepare("INSERT INTO tbl_penyakit(nm_penyakit)VALUES('$nama')");
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
	
	$pykid 		= $_POST['pykid'];
	$nmpyk 		= htmlspecialchars($_POST['nm_penyakit']);
		$menus = $DB_con->prepare("UPDATE tbl_penyakit SET nm_penyakit='$nmpyk ' WHERE kd_penyakit='$pykid'");
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
}

if(isset($_POST['btn-hps']))
{
	$pykid 		= $_POST['did'];
	$dodelete 	= $DB_con->prepare("DELETE FROM tbl_penyakit WHERE kd_penyakit='$pykid'");
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
						<h4>Tambah Penyakit</h4>
					</div>	
					<div class="widget-body">
						<form method="post">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Nama Penyakit</label>
										<input name="nm_penyakit" type="text" class="form-control" placeholder="masukan nama" required="" autocomplete="off" >
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit" name="btn-penyakit" class="btn btn-primary pull-right">Tambah</button>
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
						<h4 class="text-white">List Penyakit</h4>
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="sorting-table" class="table mb-0">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama Penyakit</th>
										<th style="display: none;"></th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$list = $DB_con->prepare("SELECT * FROM tbl_penyakit");
										$list->execute();
										$no = 1;
										while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
											<tr>
												<td><span class="text-primary"><?= $no; ?></span></td>
												<td><?php echo ucfirst($row['nm_penyakit']);?></td>
												<td style="display: none;"></td>
												<td class="td-actions text-center">
													<a href="#" class="eedit" 
													data-pykid="<?php echo $row['kd_penyakit']?>" 
													data-nmpyk="<?php echo $row['nm_penyakit']?>"
													data-toggle="modal" data-target="#update">
														<i class="la la-edit edit text-success"></i>
													</a>
													<a href="#" class="trash" 
													data-id="<?php echo $row['kd_penyakit']?>" 
													data-toggle="modal" data-target="#delete">
													<i class="la la-close delete text-danger"></i></a>
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

<!-- ubah data -->
<form method="post" onsubmit="return uPeny();">
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
								<input name="nm_penyakit" id="pyknama" type="text" class="form-control" placeholder="masukan nama" autocomplete="off">
								<small id="nmpeny" class="form-text text-danger"></small>
								<input type="hidden" id="pykid" name="pykid">
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

<!-- scripform ubah -->
<script>
	$("#pyknama").keyup(function(event) {
		$('#nmpeny').hide();
	});

	function uPeny(){
		var nmpeny = $("#pyknama").val();

		if(nmpeny == ""){
			$("#nmpeny").text('nama penyakit tidak boleh kosong !').show();
				return false;

		}else if(!(/^[a-zA-Z\.\s\/\()]+$/.test(nmpeny))){
			$('#nmpeny').text('nama penyakit hanya boleh text !').show();
				return false;

		}else{
			return true;
		}
	}
</script>

 <script type="text/javascript">
	$('.eedit').click(function(){
		var pykid 	=$(this).data('pykid');
		var nmpyk 	=$(this).data('nmpyk');

		document.getElementById('pykid').value = pykid;
		document.getElementById('pyknama').value = nmpyk;
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