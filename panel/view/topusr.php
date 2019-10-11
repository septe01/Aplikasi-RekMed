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
			if(strlen($upass) < 7){
				$type = "warning";
				$judul = "Data gagal di ubah";
				$success = "Password harus lebih 6 karakte";	
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

<!-- Begin Header -->
<header class="header">
	<nav class="navbar fixed-top">        
		<!-- Begin Search Box-->
		<div class="search-box">
			<button class="dismiss"><i class="ion-close-round"></i></button>
			<form id="searchForm" action="#" role="search">
				<input type="search" placeholder="Search something ..." class="form-control">
			</form>
		</div>
		<!-- End Search Box-->
		<!-- Begin Topbar -->
		<div class="navbar-holder d-flex align-items-center align-middle justify-content-between">
			<!-- Begin Logo -->
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
				<!-- End Toggle -->
			</div>
			<!-- End Logo -->
			<?php 
			$usr = $usr['user'];
			
			$list = $DB_con->prepare("SELECT * FROM tbl_user WHERE nama_user = '$usr' ");
			$list->execute();
			$row=$list->fetch(PDO::FETCH_ASSOC);
			// var_dump($row);

			 ?>
			<!-- Begin Navbar Menu -->
			<ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center pull-right">
				<div class="mr-3">
					<img src="<?php echo $basic_url;?>main/assets/img/logo3.png" alt="logo" class="logo-small">
				</div>
				<!-- User -->
				<li class="nav-item dropdown"><a id="user" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><img src="<?php echo $basic_url ?>main/assets/img/avatar/boy-4.png" alt="..." class="avatar rounded-circle has-shadow"></a>
					<ul aria-labelledby="user" class="user-size dropdown-menu" style="min-height: 240px;">
						<li class="welcome">
							<a href="#" class="edit-profil" data-id="<?php echo $row['kode_user']?>" data-nama="<?php echo $row['nama_user']?>" data-toggle="modal" data-target="#ubahusr"><i class="la la-edit edit text-success"></i></a>
							<img src="<?php echo $basic_url ?>main/assets/img/avatar/boy-4.png" alt="..." class="rounded-circle has-shadow">
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
				<!-- End User -->
			</ul>
			<!-- End Navbar Menu -->
		</div>
		<!-- End Topbar -->
	</nav>
</header>
            <!-- End Header -->

<!-- update modal -->
<!-- Begin Large Modal -->
	<form method="post" onsubmit="return topUsr();">
		<div id="ubahusr" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Edit</h4>
						<button type="button" class="close" data-dismiss="modal">
							<span aria-hidden="true">×</span>
							<span class="sr-only">close</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<label class="form-control-label">Nama</label>
									<input name="nnama" id="nama" type="text" class="form-control usr" placeholder="masukan nama" autocomplete="off">
									<small id="tusr" class="form-text text-danger"></small>
									<input type="hidden" id="no_id" name="nid">
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="form-control-label">Password baru</label>
									<input name="npass" type="password" class="form-control pass"  placeholder="masukan password" autocomplete="off">
									<small id="pass" class="form-text text-danger"></small>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group">
									<label class="form-control-label">Konfirmasi password baru</label>
									<input name="kpass" type="password" class="form-control kpas"  placeholder="konfirmasi password" autocomplete="off">
									<small id="kpas" class="form-text text-danger"></small>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-shadow" data-dismiss="modal">Close</button>
						<div class="sub">
							<button type="submit"  id="submit" name="btn-usr" class="btn btn-danger">Save</button>
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
	 	$(".usr").keyup(function(event) {
	 		/* Act on the event */
	 		$("#tusr").hide();
	 	});

		$(".pass").keyup(function(event) {
			/* Act on the event */
			$("#pass").hide();
		});

		$(".kpas").keyup(function(event) {
			/* Act on the event */
			$("#kpas").hide();
		});
	
	function topUsr() {
		var nmusr 	= $(".usr").val();
		var pass 	= $(".pass").val();
		var kpas 	= $(".kpas").val();

		if(nmusr == ""){
			$("#tusr").text('Masukan nama user !').show();
				return false;

		}else if(!(/^[a-zA-Z\s]+$/.test(nmusr))){
			$('#tusr').text('Nama user hanya boleh text !').show();
				return false;

		}else if(pass == ""){
			$("#pass").text('Password tidak boleh Kosong !').show();
				return false;

		}else if(pass.length < 6){
			$('#pass').text('Password Password minimal 6 karakter. !').show();
			return false;

		}else if(kpas == ""){
			$("#kpas").text('Password tidak boleh Kosong !').show();
				return false;

		}else if(kpas.length < 6){
			$('#kpas').text('Password Password minimal 6 karakter. !').show();
			return false;

		}else if(pass !== kpas){
			$("#pass").text('Password tidak sama !').show();
			$("#kpas").text('Password tidak sama !').show();
				return false;
		}else{
			return true;
		}

	}
</script>