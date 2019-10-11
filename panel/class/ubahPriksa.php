<div class="col-xl-12">
		<form class="form-horizontal"  method="post">
			<div class="row justify-content-center">
				<?php 
						include '../../dbconfig.php';			
						$kdreg = $_GET['kreg'];

						$reg = $DB_con->prepare("SELECT * FROM
							tbl_periksa WHERE kode_periksa = '$kdreg'
							");						
						$reg->execute();

						while ($rows = $reg->fetch(PDO::FETCH_ASSOC)) :?>
						    <!-- var_dump($rows); -->
														
				 	<div class="col-lg-5">
					<div class="row flex-row">
						<div class="col-12">
							<div class="widget has-shadow bg-warning">
								<div class="widget-header bordered no-actions d-flex align-items-center">
									<h4 class="">Ubah Data</h4>
								</div>
								<div class="widget-body">
										<div class="form-group row d-flex align-items-center mb-1">
											<div class="col-lg-12">
												<div class="form-group">
													<?php 
														$kdpsn = $rows['kode_pasien'];
														$psn = $DB_con->prepare("
															SELECT * FROM 
															tbl_pasien 
															WHERE 
															kode_pasien = '$kdpsn';
															");
														$psn->execute();
														$nmpsn = $psn->fetch(PDO::FETCH_ASSOC);
														
														?>
													<label class="form-control-label">Nama</label>
													<input value="<?php echo $nmpsn['nama_pasien']; ?>" type="text" class="form-control" placeholder="masukan nama" readonly>
													<input type="hidden" id="" name="kprks" value="<?= $kdreg; ?>">
													<input type="hidden" id="" name="kpasien" value="<?= $kdpsn; ?>">
													<?php 
													 ?>
												</div>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-1">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="form-control-label">Keluhan</label>
													<div class="input-group">
													  <textarea class="form-control" name="keluhan" value="" rows="2" maxlength="50"><?= $rows['keluhan'] ?></textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-1">
											<div class="col-lg-12">
												<div class="form-group">
												<?php 
														$kdalat = $rows['kode_alat'];
														$alat = $DB_con->prepare("
															SELECT * FROM 
															tbl_alat
															WHERE 
															kode_alat = '$kdalat';
															");
														$alat->execute();
														$nmalat = $alat->fetch(PDO::FETCH_ASSOC);
														?>
													<label class="form-control-label">Pilih Alat</label>
													<select class="form-control" name="kdalat" id="">

														<option  value="<?= $nmalat['kode_alat']; ?>"disabled selected><?= $nmalat['nama_alat']; ?></option>
															<?php 
																$alat = $DB_con->prepare("SELECT * FROM tbl_alat");
																$alat->execute();
																while ($row = $alat->fetch(PDO::FETCH_ASSOC)) : ?>
																<option value="<?= $row['kode_alat']; ?>"><?php echo $row['nama_alat']; ?></option>
																<?php
																endwhile;
															?>
													</select>


													<input type="hidden" id="" name="kdaltlm" value="<?= $kdalat; ?>">
													<?php 
													 ?>
												</div>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-1">
											<div class="col-lg-12">
												<div class="form-group">
												<?php 
														$kddokter = $rows['kode_dokter'];
														$dokter = $DB_con->prepare("
															SELECT * FROM 
															tbl_dokter
															WHERE 
															kode_dokter = '$kddokter';
															");
														$dokter->execute();
														$nmdokter = $dokter->fetch(PDO::FETCH_ASSOC);
														?>
													<label class="form-control-label">Dokter</label>
													<select class="form-control" name="kddokter" id="">

														<option  value="<?= $nmdokter['kode_dokter']; ?>"disabled selected><?= $nmdokter['nama_dokter']; ?></option>
															<?php 
																$dokter = $DB_con->prepare("SELECT * FROM tbl_dokter");
																$dokter->execute();
																while ($row = $dokter->fetch(PDO::FETCH_ASSOC)) : ?>
																<option value="<?= $row['kode_dokter']; ?>"><?php echo $row['nama_dokter']; ?></option>
																<?php
																endwhile;
															?>
													</select>

													<input type="hidden" id="" name="kddktlm" value="<?= $kddokter; ?>">
													<?php 
													 ?>
												</div>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-1">
											<div class="col-lg-12">
												<div class="form-group">
												<?php 
														$kdkamar = $rows['kode_kamar'];
														$kamar = $DB_con->prepare("
															SELECT * FROM 
															tbl_kamar
															WHERE 
															kode_kamar = '$kdkamar';
															");
														$kamar->execute();
														$nmkamar = $kamar->fetch(PDO::FETCH_ASSOC);
														?>
													<label class="form-control-label">Pilih ruangan</label>
													<select class="form-control" name="kdkamar" id="">

														<option  value="<?= $nmkamar['kode_kamar']; ?>"disabled selected><?= $nmkamar['nama_kamar']; ?></option>
															<?php 
																$kamar = $DB_con->prepare("SELECT * FROM tbl_kamar WHERE kapasitas_kamar - isi_kamar");
																$kamar->execute();
																while ($row = $kamar->fetch(PDO::FETCH_ASSOC)) : ?>
																<option value="<?= $row['kode_kamar']; ?>"><?php echo $row['nama_kamar']; ?></option>
																<?php
																endwhile;
															?>
													</select>

													<input type="hidden" id="rk_id" name="kdkmrlm" value="<?= $kdkamar;?> ">
													<?php 
													 ?>
												</div>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-2">
											<div class="col-lg-12" style="display: none;">
												<label class="form-control-label">Nama Kamar</label>
												<input type="text" class="form-control" placeholder="nama kamar" id="kmr" readonly>
												<input name="" type="hidden" class="form-control" id="tmr">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-lg-7">
						<div class="row flex-row">
							<div class="col-12">
								<div class="widget has-shadow bg-warning" style="min-height: 500px !important">
									<div class="widget-header bordered no-actions d-flex align-items-center">
										<h4 class="">Ubah Data</h4>
									</div>
									<div class="widget-body">
										<form class="form-horizontal">
											<div class="form-group row d-flex align-items-center mb-1">
												<div class="col-lg-12">
														<div class="form-row">
														    <div class="col">
																<div class="form-group">
																<?php 
																		$kdpenyakit = $rows['kd_penyakit'];
																		$penyakit = $DB_con->prepare("
																			SELECT * FROM 
																			tbl_penyakit
																			WHERE 
																			kd_penyakit = '$kdpenyakit';
																			");
																		$penyakit->execute();
																		$nmpenyakit = $penyakit->fetch(PDO::FETCH_ASSOC);
																		?>
																	<label class="form-control-label">Diagnosa Penyakit</label>
																	<select class="form-control" name="kdpenyakit" id="">

																		<option  value="<?= $nmpenyakit['kd_penyakit']; ?>"disabled selected><?= $nmpenyakit['nm_penyakit']; ?></option>
																			<?php 
																		$penyakit = $DB_con->prepare("SELECT * FROM tbl_penyakit");
																		$penyakit->execute();?>
																			<?php
																			while ($row = $penyakit->fetch(PDO::FETCH_ASSOC)) : ?>
																		<option value="<?= $row['kd_penyakit']; ?>"><?php echo $row['nm_penyakit']; ?></option>
																			<?php
																			endwhile;
																			?>
																	</select>

																	 <input type="hidden" id="" name="kdpenyakitlm" value="<?= $kdpenyakit ?>">	
																	<?php 
																	 ?>
																</div>
															</div>
															<div class="col">
																<div class="form-group">
																<?php 
																		$kdtindak = $rows['kode_tindakan'];
																		$tindakan = $DB_con->prepare("
																			SELECT * FROM 
																			tbl_tindakan
																			WHERE 
																			kode_tindakan = '$kdtindak';
																			");
																		$tindakan->execute();
																		$nmtindakan = $tindakan->fetch(PDO::FETCH_ASSOC);
																		?>
																	<label class="form-control-label">Tindakan</label>
																	<select class="form-control" name="kdtdk" id="">

																		<option  value="<?= $nmtindakan['kode_tindakan']; ?>"disabled selected><?= $nmtindakan['nama_tindakan']; ?></option>
																		<?php 
																		$tindakan = $DB_con->prepare("SELECT * FROM tbl_tindakan");
																		$tindakan->execute();?>
																			<?php
																			while ($row = $tindakan->fetch(PDO::FETCH_ASSOC)) : ?>
																		<option value="<?= $row['kode_tindakan']; ?>"><?php echo $row['nama_tindakan']; ?></option>
																			<?php
																			endwhile;
																			?>
																	</select>

																	<input type="hidden" id="" name="kdtdklm" value="<?= $kdtindak; ?>">
																	<?php 
																	 ?>	
																</select>
																</div>
															</div>
														</div>
												</div>
											</div>

									<!-- obat -->
											<div class="form-group row d-flex align-items-center mb-1">
												<div class="col-lg-12">
														<div class="form-row">
														    <div class="col-lg-4">
																<label class="form-control-label">Obat</label>
															</div>
															<div class="col">
																<label class="form-control-label">Catatan</label>
															</div>
														</div>
												</div>
											</div>
									<?php 
										$obts = $DB_con->prepare("SELECT * FROM 
											det_obat trobt,
											tbl_obat tblobt
											WHERE 
											tblobt.kode_obat = trobt.kode_obat
											AND trobt.kode_periksa = '$kdreg'
											");
										$obts->execute();

										$isiData = $obts->rowCount();
										for ($i = 0; $i < $isiData; $i++) :
											$obt = $obts->fetch(PDO::FETCH_ASSOC);
									?>

											<div class="form-group row d-flex align-items-center mb-3">
												<div class="col-lg-12">
													    <div class="form-row">
														    <div class="col-lg-4">

														    <select class="form-control" id="obt<?php echo $i; ?>" name="kdobat[]">
															<option disabled="" selected="" value="<?= $obt['kode_obat'] ?>"><?= $obt['nama_obat'] ?></option>
																<?php 
																	$obat = $DB_con->prepare("SELECT * FROM tbl_obat");
																	$obat->execute();
																	while ($row = $obat->fetch(PDO::FETCH_ASSOC)) :?>
															<option value="<?= $row['kode_obat']; ?>">
																<?= $row['nama_obat']; ?>
															</option>	    
																<?php
																endwhile;
																 ?>
															</select>
														</div>
														    <div class="col">
														      <input type="text" class="form-control" id="ctt<?= $i; ?>" name="cttnobt[]" placeholder="" value="<?= $obt['catatan']; ?>">

														    </div>
														</div>
														<input type="hidden" id="" name="kdtrobt[]" value="<?= $obt['id_trobat']; ?>">
														<input type="hidden" id="" name="kdobtlm[]" value="<?= $obt['kode_obat']; ?>">
												</div>
											</div>

									<?php
										endfor;
									 ?>
											

											<div class="pull-right mt-3 mb-4">
												<button type="submit" name="btn-ubah" class="btn btn-primary pull-right simp2">Simpan</button>
												<button type="button" class="btn btn-shadow pull-right mr-2 kembali2" data-dismiss="modal">Kembali</button>
											</div>												
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>

					<?php endwhile;
					
				 ?>	
			</div>
		</form>
	</div>
			<!-- Offcanvas Sidebar -->

<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery.min.js"></script>

<!-- tampil -->
<script>
	$('.kembali2').click(function(event) {
		/* Act on the event */
		$('.main').fadeIn('slow/800/fast', function() {
		});
		$('.ubahpriksa').fadeOut('slow/400/fast', function() {
		});
	});

	$('.simp2').click(function(event) {
		/* Act on the event */
		$('.main').fadeIn('10000/400/fast', function() {
		});
		$('.ubahpriksa').fadeOut('slow/400/fast', function() {
		});
	});
</script>
<!-- scriptubahformobat -->
<script>
	
	for (var i = 0; i < 10; i++) {
		$("#ctt"+[i]).attr('disabled', true);
	}

	for (var i = 1; i < 10; i++) {
		$("#obt"+[i]).attr('disabled', true);
	}

	$("#obt0").change(function(event) {
		$("#obt1").attr('disabled', false);
		$("#ctt0").attr('disabled', false);

	});

	$("#obt1").change(function(event) {
		$("#obt2").attr('disabled', false);
		$("#ctt1").attr('disabled', false);

	});

	$("#obt2").change(function(event) {
		$("#obt3").attr('disabled', false);
		$("#ctt2").attr('disabled', false);

	});

	$("#obt3").change(function(event) {
		$("#obt4").attr('disabled', false);
		$("#ctt3").attr('disabled', false);

	});

	$("#obt4").change(function(event) {
		$("#obt5").attr('disabled', false);
		$("#ctt4").attr('disabled', false);

	});

	$("#obt5").change(function(event) {
		$("#obt6").attr('disabled', false);
		$("#ctt5").attr('disabled', false);

	});

	$("#obt6").change(function(event) {
		$("#obt7").attr('disabled', false);
		$("#ctt6").attr('disabled', false);

	});

	$("#obt7").change(function(event) {
		$("#obt8").attr('disabled', false);
		$("#ctt7").attr('disabled', false);

	});

	$("#obt8").change(function(event) {
		$("#obt9").attr('disabled', false);
		$("#ctt8").attr('disabled', false);

	});

	$("#obt9").change(function(event) {
		$("#ctt9").attr('disabled', false);

	});
</script>