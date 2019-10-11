<?php 
if(isset($_POST['btn-simpan']))
{
	$uname 		= htmlspecialchars(trim($_POST['nama']));
	$ustatus 	= htmlspecialchars(trim($_POST['status']));
	$upass 		= trim($_POST['pass']);	
	if(empty($uname ))	{
			$type = "warning";
			$judul = "Data gagal di tambah";
			$error = "Masukan nama user !";	
		}else if(!preg_match("/^[a-zA-Z\s]*$/",$uname))	{
			$type = "warning";
			$judul = "Data gagal di tambah";
			$error = "Hanya boleh text !";	
		}else if(empty($ustatus))	{
			$type = "warning";
			$judul = "Data gagal di tambah";
			$error = "Pilih Status !";	
		}else if(empty($upass))	{
			$type = "warning";
			$judul = "Data gagal di tambah";
			$error = "Masukan password !";
		}else if(strlen($upass) < 6){
			$type = "warning";
			$judul = "Data gagal di tambah";
			$error = "Password minimal 6 karakter";	
	}else{
		
			$stmt = $DB_con->prepare("SELECT nama_user FROM tbl_user WHERE nama_user=:uname");
			$stmt->execute(array(':uname'=>$uname));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			if($row['nama_user']==$uname) {
				$type = "warning";
				$judul = "Data gagal di tambah";
				$error = "maaf nama user sudah ada !";
			}
			else
			{
				$usr = $user->register($uname,$ustatus,$upass);
				if($usr){
					$type = "success";
					$judul = "Congratulations !";
					$success = "User baru berhasil di tambah !!!";
				}
			}
	}
}

if(isset($_POST['btn-usrubh']))
{
	
	$nid 		= $_POST['nid'];
	$nnama 		= htmlspecialchars($_POST['nnama']);
	$nstatus 	= htmlspecialchars($_POST['nstatus']);
	$upass 		= $_POST['npass'];
		if(empty($nnama)){
			$type = "warning";
			$judul = "Data gagal di ubah";
			$error = "Masukan nama user !";
		}elseif(empty($upass)){
			$type = "warning";
			$judul = "Data gagal di ubah";
			$error = "Masukan password";
		}elseif(strlen($upass) < 6){
			$type = "warning";
			$judul = "Data gagal di ubah";
			$error = "Password minimal 6 karakter";	
		}else{
			$npass 		= password_hash($upass, PASSWORD_DEFAULT);	
			$doupdate 	= $DB_con->prepare("UPDATE tbl_user SET nama_user='$nnama', status_user='$nstatus', password_user='$npass' WHERE kode_user='$nid'");
			$doupdate->execute();
			if($doupdate){
					$type = "success";
					$judul = "Congratulations !";
					$success = "berhasil di ubah !!!";
			}
		}	
}

if(isset($_POST['btn-hapus']))
{

	$did 		= $_POST['did'];
	$dodelete 	= $DB_con->prepare("DELETE FROM tbl_user WHERE kode_user='$did'");
	$dodelete->execute();	
	if($dodelete){
					$type = "success";
					$judul = "Congratulations !";
					$success = "Data berhasil di hapus !!!";
	}
}
?>

<div class="row justify-content-center">
	<!-- form add data -->
	<div class="col-xl-12">
		<div class="row">
			<div class="col-lg-4">
				<div class="widget has-shadow">
					<div class="widget-header bordered no-actions d-flex align-items-center">
						<h4>Tambah User</h4>
					</div>	
					<div class="widget-body bg-warning">
						<form method="post">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Nama</label>
										<input name="nama" type="text" maxlength="20" class="form-control"  placeholder="masukan nama" required="" autocomplete="off">
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Password</label>
										<input name="pass" type="text" class="form-control" required="" maxlength="20" placeholder="masukan password" autocomplete="off">
										<small id="emailHelp" class="form-text text-muted">Password minimal 6 karakter.</small>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Status</label>
										<select name="status" class="custom-select form-control">
											<option value="">Pilih</option>
											<option value="admin">Admin</option>
											<option value="user">User</option>
										</select>
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit" name="btn-simpan" class="btn btn-primary pull-right" data-toggle="modal">Tambah</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-8">
				<!-- Sorting -->
				<div class="widget has-shadow">
					<div class="widget-header bordered no-actions d-flex align-items-center bg-primary">
						<h4 class="text-white">User</h4>
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="sorting-table" class="table mb-0">
								<thead>
									<tr>
										<th>No</th>
										<th>Nama User</th>
										<th>Password</th>
										<th><span style="width:100px;">Status</span></th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$list = $DB_con->prepare("SELECT * FROM tbl_user");
									$list->execute();
									$no = 1;
									while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
										
										<tr>
											<td><span class="text-primary"><?php echo $no;?></span></td>
											<td><?php echo $row['nama_user']?></td>
											<td class="text-center">********</td>
											<td class="text-center"><span style="width:100px;"><span class="badge-text badge-text-small info"><?php echo $row['status_user'];?></span></span></td>
											<td class="td-actions text-center">
													<a href="#" class="ubah" data-id="<?php echo $row['kode_user'];?>" data-nama="<?php echo $row['nama_user'];?>" data-status="<?php echo $row['status_user'];?>" data-toggle="modal" data-target="#usrubah">
														<i class="la la-edit edit text-success"></i>
													</a>
													<a href="#" class="trash" data-id="<?php echo $row['kode_user']?>" data-toggle="modal" data-target="#delete"><i class="la la-close delete text-danger"></i></a>
											</td>
										</tr>

										<?php 

										$no++;	}
											 ?>
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
	<form method="post" onsubmit="return valUbah();">
		<div id="usrubah" class="modal fade">
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
									<input name="nnama" id="namausr" type="text" class="form-control" placeholder="masukan nama" autocomplete="off">
									<small id="usr" class="form-text text-danger"></small>
									<input type="hidden" id="id" name="nid">
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="form-control-label">Password baru</label>
									<input name="npass" id="upass" type="text" class="form-control"  placeholder="masukan password" autocomplete="off">
									<small id="pass" class="form-text text-danger"></small>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="form-control-label">Status</label>
									<select name="nstatus" id="status" class="custom-select form-control">
										<option value="admin">Admin</option>
										<option value="user">User</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-shadow" data-dismiss="modal">Tutup</button>
						<button type="submit" name="btn-usrubh" class="btn btn-danger">Simpan</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- End Large Modal -->
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
						<button type="submit" class="btn btn-danger mb-3" name="btn-hapus">Ok</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery.min.js"></script>
	<script type="text/javascript">
		$('.ubah').click(function(){
			var id=$(this).data('id');
			var nama=$(this).data('nama');
			var status=$(this).data('status');
			var data = $(this).data();
			document.getElementById('id').value = id;
			document.getElementById('namausr').value = nama;
			document.getElementById('status').value = status;
		});
	</script>
	
	<!-- scriipt valfromubah -->
	<script>
		$("#namausr").keyup(function(event) {
			$('#usr').hide();
		});

		$("#upass").keyup(function(event) {
			$('#pass').hide();
		});

		function valUbah(){
			var nmusr 	= $("#namausr").val();
			console.log(nmusr);
			var pass 	= $("#upass").val();

			if(nmusr == ""){
				$('#usr').text('Masukan nama user !').show();
				return false;

			}else if(!(/^[a-zA-Z\s]+$/.test(nmusr))){
				$('#usr').text('Nama user hanya boleh text !').show();
				return false;

			}else if(pass == ""){
				$('#pass').text('Password tidak boleh Kosong !').show();
				return false;

			}else if(pass.length < 6){
				$('#pass').text('Password minimal 6 karakter. !').show();
				return false;

			}else{
				return true;
			}
		}
	</script>

	<script type="text/javascript">
		$('.trash').click(function(){
			var id=$(this).data('id');
			console.log(id);

			document.getElementById('d_id').value = id;
		});

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
<script>
	$(document).ready(function() {
		$('#sorting-table').data({
			"order": [[0,"asc"]]
		});
	});
</script>
	