
<?php 	
		// var_dump($_GET);
		$baselap = 'http://localhost/bundamulya/panel/home.php?page=laporan';
		if(isset($_GET)){
			$pagelaporan = $_GET['page'];
			$lp = "";
			if (isset($_GET['lp'])) {
				$lp 		= $_GET['lp'];
			}
			if($pagelaporan == 'laporan' && $lp == ""){

 ?>

<div class="row justify-content-center">
	<div class="col-xl-12">
		<div class="row lapgrapik">
			<div class="col-md-6">
				<div class="container has-shadow">
					<div class="row">
						<div class="col-md text-center mt-2">Perawatan Pasien <span class="thntwo"></span><br>
							<div class="canvaspas">
								<div id="mytwochart" style="height: 250px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 ">
				<div class="container has-shadow">
					<div class="row">
						<div class="col-md text-center mt-2">Pendaftaran Pasien <span class="thn"></span><br>
							<div class="canvaspas">
								<div id="myfirstchart" style="height: 250px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-2 laptabel">
			<div class="col-lg-12">
				<!-- Tabel laporan -->
				<div class="widget has-shadow">
					<div class="widget-header bordered no-actions d-flex align-items-center">
						<h4>Laporan </h4>
					</div>
					<div class="">
						<div class="table-responsive mt-3">
					
						<table id="laporans" class="table mb-0" style="width:100%">
						        <thead>
									<tr>
										<th>No</th>
										<th>Jenis Laporan</th>
										<th>Aksi</th>
										
									</tr>
								</thead>
								<tbody>
										<tr>
											<td><span class="text-primary">1</span></td>
											<td><span class="text-primary">Keuangan</span></td>
											<td><span class="text-primary"><a href="?page=laporan&lp=<?php echo 'lapkeu' ?>"><i class="la la-download md delete text-danger download"></i></a></span></td>
											
										</tr>
										<tr>
											<td><span class="text-primary">2</span></td>
											<td><span class="text-primary">Pasien</span></td>
											<td><span class="text-primary"><a href="?page=laporan&lp=<?php echo 'lappas' ?>"><i class="la la-download md delete text-danger download"></i></a></span></td>
											
										</tr>
								</tbody>
						       
						</table>

						</div>
					</div>
				</div>
				<!-- End laporan -->
			</div>
		</div>
	</div>	
</div>

<?php 		
			}elseif($pagelaporan == 'laporan' && $lp == "lapkeu"){
 ?>
<div class="row justify-content-center">
	<div class="col-xl-12">

		<div class="row mt-2 laporanuang">
			<div class="col-lg-12">
				<!-- Sorting -->
				<div class="widget has-shadow ">
					<div class="widget-header bordered no-actions d-flex align-items-center">
						<h4>Laporan Keuangan</h4>
					</div>
					<div class="widget-body">
						<div class="table-responsive">

						<div class="rangedate row justify-content-end mb-3 mr-1">
							<div class="col-sm-12 col-md-6">
								<form>
								  <div class="row ">
									  	<label class="pt-2" style="color: #9FAEB9">Rentang tanggal</label>
									    <div class="col">
									    		  <input type="text" id="fini" class="form-control" placeholder="yyyy-mm-dd" autocomplete="off">
									    </div>
									    <div class="col">
											      <input type="text" id="ffin" class="form-control" placeholder="yyyy-mm-dd" autocomplete="off">		
									    </div>
								  </div>
								</form>
							</div>
						</div>

					
						<table id="mylap" class="table mb-0" style="width:100%">
						        <thead>
									<tr>
										<th>No</th>
										<th>Pasien</th>
										<th>Tanggal Pembayaran</th>
										<th>Pembayaran</th>
										<th>Keterangan</th>
										<th>Status</th>
										
									</tr>
								</thead>
								<tbody>
									<?php 
									$no = 1;
									$list = $DB_con->prepare("SELECT * FROM 
															tbl_pembayaran tbpem,
															tbl_periksa tbper,
															tbl_pasien tbpas
															WHERE 
															tbpem.kode_periksa = tbper.kode_periksa
															AND
															tbper.kode_pasien = tbpas.kode_pasien
															");
									$list->execute();
									
									while ($row=$list->fetch(PDO::FETCH_ASSOC)){
										if($row['notes'] === "Lunas"){
										?>
										<tr>
											<td><span class="text-primary"><?php echo $no; ?></span></td>
											<td><span class="text-primary"><?php echo $row['nama_pasien']?></span></td>
											<td><span class="text-primary"><?php $tgl = substr($row['tanggal_pembayaran'], 0, 10); echo $tgl;?></span></td>
											<td><span class="text-primary">Rp. <?php echo number_format($row['total_perawatan']);?></span></td>
										<?php 
											if($row['kode_kamar'] == "12"):
										?>
											<td><span class="text-primary">Rawat Jalan</span></td>
										<?php 
											else:
										 ?>
											<td><span class="text-primary">Rawat Inap</span></td>	
										<?php endif; ?>
											<td><span class="text-primary"><?php echo $row['notes'];?></span></td>
											
										</tr>
									<?php $no++; } 
										}
									?>
								</tbody>
						        <tfoot style="color: #5D5386;">
						            <tr class="text-primary">
						            	<th></th>
						            	<th></th>
						            	<th style="text-align:center; padding: 20px 0;"></th>
						            	<th></th>
						            	<th></th>
						                <th></th>
						            </tr>
						        </tfoot>
						</table>

						</div>
					</div>
				<div class=" text-right">
					<div class="btn btn-outline-primary mb-3 mr-3 kembali" onclick="location.href='http://localhost/bundamulya/panel/home.php?page=laporan';">Kembali</div>
					<!-- <a class="btn btn-outline-primary mb-3 mr-3 kembali" href="http://localhost/bundamulya/panel/cetak/cetak.php" target="_blank">Cetak</a> -->
				</div>
				</div>
				<!-- End Row -->
			</div>
		</div>

	</div>
	<!-- Offcanvas Sidebar -->
</div>

<?php 		
			}elseif($pagelaporan == 'laporan' && $lp == "lappas"){
 ?>
<div class="row justify-content-center">
	<div class="col-xl-12">

		<div class="row mt-2 laporanuang">
			<div class="col-lg-12">
				<!-- Sorting -->
				<div class="widget has-shadow ">
					<div class="widget-header bordered no-actions d-flex align-items-center">
						<h4>Laporan Pasien</h4>
					</div>
					<div class="widget-body">
						<div class="table-responsive">

						<div class="rangedate row justify-content-end mb-3 mr-1">
							<div class="col-sm-12 col-md-6">
								<form>
								  <div class="row ">
									  	<label class="pt-2" style="color: #9FAEB9">Rentang tanggal</label>
									    <div class="col">
									    		  <input type="text" id="fspas" class="form-control" placeholder="yyyy-mm-dd" autocomplete="off">
									    </div>
									    <div class="col">
											      <input type="text" id="fepas" class="form-control" placeholder="yyyy-mm-dd" autocomplete="off">		
									    </div>
								  </div>
								</form>
							</div>
						</div>

					
						<table id="mylappas" class="table mb-0" style="width:100%">
						        <thead>
									<tr>
										<th>No</th>
										<th>Kode Pasien</th>
										<th>Nama Pasien</th>
										<th>Jenis kelamin</th>
										<th>Tanggal Lahir</th>
										<th>Alamat</th>
										<th>Telepon</th>
										<th>Tanggal Daftar</th>
										
									</tr>
								</thead>
								<tbody>
									<?php 
									$no = 1;
									$list = $DB_con->prepare("SELECT * FROM 
															tbl_pasien
															");
									$list->execute();
									
									while ($row=$list->fetch(PDO::FETCH_ASSOC)){
										// var_dump($row);
										?>
										<tr>
											<td><span class="text-primary"><?php echo $no; ?></span></td>
											<td><span class="text-primary">PSN<?php echo $row['kode_pasien']?></span></td>
											<td><span class="text-primary"><?php echo $row['nama_pasien']?></span></td>
											<td><span class="text-primary"><?php echo $row['kelamin_pasien']?></span></td>
											<td><span class="text-primary"><?php echo $row['tgl_lahir']?></span></td>
											<td><span class="text-primary"><?php echo $row['alamat_pasien']?></span></td>
											<td><span class="text-primary"><?php echo $row['telepon']?></span></td>
											<td><span class="text-primary"><?php echo $row['tanggal']?></span></td>
										</tr>
									<?php $no++; } 
									?>
								</tbody>
						</table>

						</div>
					</div>
				<div class=" text-right">
					<div class="btn btn-outline-primary mb-3 mr-3 kembali" onclick="location.href='http://localhost/bundamulya/panel/home.php?page=laporan';">Kembali</div>
					<!-- <a class="btn btn-outline-primary mb-3 mr-3 kembali" href="http://localhost/bundamulya/panel/cetak/cetak.php" target="_blank">Cetak</a> -->
				</div>
				</div>
				<!-- End Row -->
			</div>
		</div>

	</div>
	<!-- Offcanvas Sidebar -->
</div>
<?php 	
		}
	}

 ?>
<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery-3.3.1.js"></script>
<script src="<?php echo $basic_url; ?>main/assets/vendors/js/datatables/jquery.dataTables.min.js"></script>

<script>	
	// $('.download').click(function(event) {
	// 	/* Act on the event */
	// 	$('.lapgrapik').css('display', 'none');
	// 	$('.laptabel').css('display', 'none');
	// 	$('.laporanuang').removeClass('hidden');
	// });
	// $('.kembali').click(function(event) {
	// 	$('.lapgrapik').show();
	// 	$('.laptabel').show();
	// 	$('.laporanuang').addClass('hidden');
	// });
</script>






