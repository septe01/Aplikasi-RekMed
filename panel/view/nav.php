<?php 

if($_SESSION['status'] == 'user'): ?>
	<div class="compact-sidebar has-shadow">
		<!-- Begin Side Navbar -->
		<nav class="side-navbar box-scroll sidebar-scroll">
			
			<!-- Begin Main Navigation -->
			<ul class="list-unstyled">
				<div 
					<?php 
					if(isset($_GET['page'])):
							$page = $_GET['page'];

						if($page == "dokter"):?>
					class="bgnav"
							<?php
						endif;
						 ?>
						>
					<li>
						<a href="<?php echo $base_url."dokter";?>">
							<i class="fas fa-user-md"></i><span>Dokter</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "alat"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."alat";?>">
							<i class="la la-stethoscope"></i><span>Alat</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "ruang"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."ruang";?>">
							<i class="la la-bed"></i><span>Ruang</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "obat"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."obat";?>">
							<i class="fas fa-pills"></i><span>Obat</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "tindakan"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."tindakan";?>">
							<i class="ion-person-add"></i><span>Tindakan</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "penyakit"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."penyakit";?>">
							<i class="fas fa-diagnoses"></i><span>Penyakit</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "pasien"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."pasien";?>">
							<i class="fa fa-users"></i><span>Pasien</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "periksa"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<!-- <i class="la la-edit"></i> -->
						<a href="<?php echo $base_url."periksa";?>">
							<i class="fas fa-user-check"></i><span>Periksa</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "perawatan"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<!-- <i class="ion-clipboard"></i> -->
						<a href="<?php echo $base_url."perawatan";?>">
							<i class="fas fa-file-medical-alt"></i><span>Perawatan</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "rujukan"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."rujukan";?>">
							<i class="fas fa-envelope-open-text"></i><span>Rujukan</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "pembayaran"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."pembayaran";?>">
							<i class="la la-credit-card"></i><span>Pembayaran</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "laporan"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."laporan";?>">
							<i class="la la-file-pdf-o"></i><span>Laporan</span>
						</a>
					</li>
				</div>


				<?php 
					else:
				 ?>
				<div class="">
					<li>
						<a href="<?php echo $base_url."dokter";?>">
							<i class="fas fa-user-md"></i><span>Dokter</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."alat";?>">
							<i class="la la-stethoscope"></i><span>Alat</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."ruang";?>">
							<i class="la la-bed"></i><span>Ruang</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."obat";?>">
							<i class="fas fa-pills"></i><span>Obat</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."tindakan";?>">
							<i class="ion-person-add"></i><span>Tindakan</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."penyakit";?>">
							<i class="fas fa-diagnoses"></i><span>Penyakit</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."pasien";?>">
							<i class="fa fa-users"></i><span>Pasien</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<!-- <i class="la la-edit"></i> -->
						<a href="<?php echo $base_url."periksa";?>">
							<i class="fas fa-user-check"></i><span>Periksa</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<!-- <i class="ion-clipboard"></i> -->
						<a href="<?php echo $base_url."perawatan";?>">
							<i class="fas fa-file-medical-alt"></i><span>Perawatan</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."rujukan";?>">
							<i class="fas fa-envelope-open-text"></i><span>Rujukan</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."pembayaran";?>">
							<i class="la la-credit-card"></i><span>Pembayaran</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."laporan";?>">
							<i class="la la-file-pdf-o"></i><span>Laporan</span>
						</a>
					</li>
				</div>
				<?php 
					endif;
				 ?>
			</ul>
			<!-- End Main Navigation -->
		</nav>
		<!-- End Side Navbar -->
	</div>

<?php elseif($_SESSION['status'] == 'admin'): ?>
	<div class="compact-sidebar has-shadow">
		<!-- Begin Side Navbar -->
		<nav class="side-navbar box-scroll sidebar-scroll">
			<!-- Begin Main Navigation -->
			<ul class="list-unstyled">
				<div 
					<?php 
						if(isset($_GET['page'])):
							$page = $_GET['page'];

						if($page == "dashboard"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."dashboard";?>">
							<i class="ti ti-user"></i><span>Users</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "dokter"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."dokter";?>">
							<i class="fas fa-user-md"></i><span>Dokter</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "alat"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."alat";?>">
							<i class="la la-stethoscope"></i><span>Alat</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "ruang"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."ruang";?>">
							<i class="la la-bed"></i><span>Ruang</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "obat"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."obat";?>">
							<i class="fas fa-pills"></i><span>Obat</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "tindakan"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."tindakan";?>">
							<i class="ion-person-add"></i><span>Tindakan</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "penyakit"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."penyakit";?>">
							<i class="fas fa-diagnoses"></i><span>Penyakit</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "pasien"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."pasien";?>">
							<i class="fa fa-users"></i><span>Pasien</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "periksa"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<!-- <i class="la la-edit"></i> -->
						<a href="<?php echo $base_url."periksa";?>">
							<i class="fas fa-user-check"></i><span>Periksa</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "perawatan"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<!-- <i class="ion-clipboard"></i> -->
						<a href="<?php echo $base_url."perawatan";?>">
							<i class="fas fa-file-medical-alt"></i><span>Perawatan</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "rujukan"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."rujukan";?>">
							<i class="fas fa-envelope-open-text"></i><span>Rujukan</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "pembayaran"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."pembayaran";?>">
							<i class="la la-credit-card"></i><span>Pembayaran</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "laporan"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."laporan";?>">
							<i class="la la-file-pdf-o"></i><span>Laporan</span>
						</a>
					</li>
				</div>
				<div 
					<?php 
						if($page == "home"):?>
					class="bgnav"
					<?php
						endif;
					 ?>
				>
					<li>
						<a href="<?php echo $base_url."home";?>">
							<i class="la la-file-pdf-o"></i><span>Laporan</span>
						</a>
					</li>
				</div>

				<?php 
					else:
				 ?>
				<div class="">
					<li>
						<a href="<?php echo $base_url."dashboard";?>">
							<i class="ti ti-user"></i><span>Users</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."dokter";?>">
							<i class="fas fa-user-md"></i><span>Dokter</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."alat";?>">
							<i class="la la-stethoscope"></i><span>Alat</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."ruang";?>">
							<i class="la la-bed"></i><span>Ruang</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."obat";?>">
							<i class="fas fa-pills"></i><span>Obat</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."tindakan";?>">
							<i class="ion-person-add"></i><span>Tindakan</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."penyakit";?>">
							<i class="fas fa-diagnoses"></i><span>Penyakit</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."pasien";?>">
							<i class="fa fa-users"></i><span>Pasien</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<!-- <i class="la la-edit"></i> -->
						<a href="<?php echo $base_url."periksa";?>">
							<i class="fas fa-user-check"></i><span>Periksa</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<!-- <i class="ion-clipboard"></i> -->
						<a href="<?php echo $base_url."perawatan";?>">
							<i class="fas fa-file-medical-alt"></i><span>Perawatan</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."rujukan";?>">
							<i class="fas fa-envelope-open-text"></i><span>Rujukan</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."pembayaran";?>">
							<i class="la la-credit-card"></i><span>Pembayaran</span>
						</a>
					</li>
				</div>
				<div class="">
					<li>
						<a href="<?php echo $base_url."laporan";?>">
							<i class="la la-file-pdf-o"></i><span>Laporan</span>
						</a>
					</li>
				</div>
				<?php 
					endif;
				 ?>
			</ul>
			<!-- End Main Navigation -->
		</nav>
		<!-- End Side Navbar -->
	</div>

<?php endif; ?>





