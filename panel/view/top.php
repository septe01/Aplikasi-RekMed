<?php 

	$usr = 	$user->is_loggedin();
	$status = $usr['status'];
	if(isset($_POST['btn-usr']))
	{
		
		$nid 		= $_POST['nid'];
		$nnama 		= htmlspecialchars($_POST['nnama']);
		$nstatus 	= $status;

		$upass 		= $_POST['npass'];
		$kpass 		= $_POST['kpass'];
		
		if($upass == $kpass)	{
			if(strlen($upass) < 6){
				$type = "warning";
				$judul = "Data gagal di ubah";
				$success = "Password minimal 6 karakter";	
				}else{
					$npass 		= password_hash($upass, PASSWORD_DEFAULT);	
					$doupdate 	= $DB_con->prepare("UPDATE tbl_user SET nama_user='$nnama', status_user='$nstatus', password_user='$npass' WHERE kode_user='$nid'");
					$doupdate->execute();
						if($doupdate){
							$type = "success";
							$judul = "Congratulations !";
							$success = "usser";
						}
					
				}
		}else{
				$type = "warning";
				$judul = "Data gagal di ubah";
				$success = "Password tidak sama";	
		}

	}


 ?>

<!-- awal Header -->
<header class="header">
	<nav class="navbar fixed-top">        
		<!-- awal Search Box-->
		<div class="search-box">
			<button class="dismiss"><i class="ion-close-round"></i></button>
			<form id="searchForm" action="#" role="search">
				<input type="search" placeholder="Search something ..." class="form-control">
			</form>
		</div>
		<!-- akhir Search Box-->
		<!-- awal Topbar -->
		<div class="navbar-holder d-flex align-items-center align-middle justify-content-between">
			<!-- awal Logo -->
			<div class="navbar-header">
				<!-- db-social.html -->
				<a href="#" class="navbar-brand">
					<div class="brand-image brand-big">
						<img src="<?php echo $basic_url;?>main/assets/img/logo2.png" alt="logo" style="width: 70px;" class="logo-big">
					</div>
					<div class="brand-image brand-small">
						<img src="<?php echo $basic_url;?>main/assets/img/logo2.png" alt="logo" class="logo-small">
					</div>
				</a>
				<!-- Toggle Button -->
				<a id="toggle-btn" href="#" class="menu-btn active">
					<span></span>
					<span></span>
					<span></span>
				</a>
				<!-- akhir Toggle -->
			</div>
			<!-- akhir Logo -->
			<?php 
			$usr = $usr['user'];
			
			$list = $DB_con->prepare("SELECT * FROM tbl_user WHERE nama_user = '$usr' ");
			$list->execute();
			$row=$list->fetch(PDO::FETCH_ASSOC);
			// var_dump($row);

			 ?>
			<!-- awal Navbar Menu -->
			<ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center pull-right">
				<div class="mr-3">
					<img src="<?php echo $basic_url;?>main/assets/img/logo3.png" alt="logo" class="logo-small">
				</div>
				<!-- User -->
				<li class="nav-item dropdown"><a id="user" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><img src="<?php echo $basic_url ?>main/assets/img/avatar/2.png" alt="..." class="avatar rounded-circle has-shadow"></a>
					<ul aria-labelledby="user" class="user-size dropdown-menu" style="min-height: 240px;">
						<li class="welcome">
							<a href="#" class="edit-profil" data-id="<?php echo $row['kode_user']?>" data-nama="<?php echo $row['nama_user']?>" data-toggle="modal" data-target="#ubahusr"><i class="la la-edit edit text-success"></i></a>
							<img src="<?php echo $basic_url ?>main/assets/img/avatar/2.png" alt="..." class="rounded-circle has-shadow">
						</li>
						<li>
							<a href="#" class="dropdown-item"> 
								Hello <?php 
									echo $usr;								
								?>
							</a>
						</li>
						<li><a rel="nofollow" href="../logout.php?logout=true" class="dropdown-item logout text-center"><i class="ti-power-off"></i></a></li>
					</ul>
				</li>
				<!-- akhir User -->
			</ul>
			<!-- akhir Navbar Menu -->
		</div>
		<!-- akhir Topbar -->
	</nav>
</header>
            <!-- akhir Header -->

<!-- ubah modal -->
<!-- awal Large Modal -->
	<form method="post" onsubmit="return topAdm();">
		<div id="ubahusr" class="modal fade">
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
									<input name="nnama" id="nama" type="text" class="form-control tpusr" placeholder="masukan nama" autocomplete="off">
									<small id="tusr" class="form-text text-danger"></small>
									<input type="hidden" id="no_id" name="nid">
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="form-control-label">Password baru</label>
									<input name="npass" type="password" id="npas" class="form-control npass"  placeholder="masukan password" autocomplete="off">
									<small id="npass" class="form-text text-danger"></small>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="form-control-label">Konfirmasi password baru</label>
									<input name="kpass" type="password" class="form-control kpass"  placeholder="konfirmasi password" autocomplete="off">
									<small id="kpass" class="form-text text-danger"></small>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-shadow" data-dismiss="modal">Tutup</button>
						<div class="sub">
							<button type="submit"  id="submit" name="btn-usr" class="btn btn-danger">Simpan</button>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</form>

	
<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery.min.js"></script>
<script type="text/javascript">
		$('.edit-profil').click(function(){
			var id=$(this).data('id');
			var nama=$(this).data('nama');
			// var status=$(this).data('status');
			
			document.getElementById('no_id').value = id;
			document.getElementById('nama').value = nama;
			// document.getElementById('status').value = status;
		});
</script>

<!-- valid formubah -->
<script>
	 	$(".tpusr").keyup(function(event) {
	 		/* Act on the event */
	 		$("#tusr").hide();
	 	});

		$(".npass").keyup(function(event) {
			/* Act on the event */
			$("#npass").hide();
		});

		$(".kpass").keyup(function(event) {
			/* Act on the event */
			$("#kpass").hide();
		});
	
	function topAdm() {
		var nmusr 	= $(".tpusr").val();
		var npass 	= $(".npass").val();
		var kpass 	= $(".kpass").val();

		if(nmusr == ""){
			$("#tusr").text('Masukan nama user !').show();
				return false;

		}else if(!(/^[a-zA-Z\s]+$/.test(nmusr))){
			$('#tusr').text('Nama user hanya boleh text !').show();
				return false;

		}else if(npass == ""){
			$("#npass").text('Password tidak boleh Kosong !').show();
				return false;

		}else if(npass.length < 6){
			$('#npass').text('Password Password minimal 6 karakter. !').show();
			return false;

		}else if(kpass == ""){
			$("#kpass").text('Password tidak boleh Kosong !').show();
				return false;

		}else if(kpass.length < 6){
			$('#kpass').text('Password Password minimal 6 karakter. !').show();
			return false;

		}else if(npass !== kpass){
			$("#npass").text('Password tidak sama !').show();
			$("#kpass").text('Password tidak sama !').show();
				return false;
		}else{
			return true;
		}

	}
</script>