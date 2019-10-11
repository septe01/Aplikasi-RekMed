<?php 
date_default_timezone_set('UTC');
$date 	= date('dmy');


if(isset($_POST['btn-periksa']))
{
	// var_dump($_POST);
	$kperiksa	= $_POST['nomer_periksa'];
	$patterna = '/([^0-9]+)/';
	$kdreg = preg_replace($patterna,'',$kperiksa);
	$kobat 		= $_POST['kdobat'];
	$catatan 	= $_POST['cttnobt'];
	
	
	$kdpasien 	= htmlspecialchars($_POST['kode_pasien']);
	$keluhan 	= htmlspecialchars($_POST['keluhan']);
	$kdpenyakit	= $_POST['kdpenyakit'];
	$kdtindakan	= $_POST['kdtdk'];
	$kdalat		= $_POST['kalat'];
	$kddokter	= $_POST['kddokter'];
	$kdkamar	= $_POST['kode_kamar'];

	if ($kdpasien == "") {
		$type = "error";
		$judul = "Oops. !";
		$success = "silahkan pilih pasien !!!";

	} else if(empty($keluhan)) {
		$type = "error";
		$judul = "Oops. !";
		$success = "silahkan isi keluhan nya !!!";

	}else if($kdpenyakit == "Pilih Penyakit") {
		$type = "error";
		$judul = "Oops. !";
		$success = "silahkan pilih diagnosa penyakit !!!";

	}else if($kdtindakan == "Pilih tindakan") {
		$type = "error";
		$judul = "Oops. !";
		$success = "silahkan pilih tindakan !!!";

	}else if($kdalat == "Pilih alat") {
		$type = "error";
		$judul = "Oops. !";
		$success = "silahkan pilih alat !!!";

	}else if($kddokter == "Dokter") {
		$type = "error";
		$judul = "Oops. !";
		$success = "silahkan pilih Dokter !!!";

	}else if(empty($kdkamar)) {
		$type = "error";
		$judul = "Oops. !";
		$success = "silahkan pilih Ruangan nya !!!";

	}else{
		if($kobat[0] == "pilih obat"){
			$type = "error";
			$judul = "Oops. !";
			$success = "silahkan berikan resep obat !!!";

		}else{

			for ($i = 0; $i < count($kobat); $i++) {//masukan data ke tabel transaksi obat

					if($kobat[$i] != "pilih obat"){

						$dtrobat = array(
									'kode_obat' => $kobat[$i],
									'kode_periksa' => $kdreg,
									'catatan' => htmlspecialchars($catatan[$i])
								);
						$ok  = implode(", ",array_keys($dtrobat));
						$ov  = "'" . implode ( "', '", array_values($dtrobat)) . "'";
						$onotes = $DB_con->prepare("INSERT INTO det_obat($ok) VALUES ($ov)");
						$onotes->execute();
					}
				}

			// operasi simpan
				$status = 'a';
				$list = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kdkamar");
				$list->execute();
				$row = $list->fetch();

				$baru = $row['isi_kamar']+1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kdkamar");
				$menus->execute();

				$notes 	= $DB_con->prepare("INSERT INTO tbl_periksa(kode_periksa,kode_pasien,kode_kamar,kode_dokter,kd_penyakit,kode_tindakan,kode_alat,status,keluhan)VALUES('$kdreg','$kdpasien','$kdkamar','$kddokter','$kdpenyakit','$kdtindakan','$kdalat','$status','$keluhan')");
				$notes->execute();	

					if($notes){
									$type = "success";
									$judul = "Congratulations !";
									$success = "pasien berhasil di periksa !!!";
						}else{ 
									$type = "error";
									$judul = "Oops. !";
									$success = "pasien gagal di periksa !!!";
						}				
		}

	}

}

if(isset($_POST['btn-ubah']))
{

	$kdtrobt = $_POST['kdtrobt'];
	$kdobtlm = $_POST['kdobtlm'];

	$kpasien 	= htmlspecialchars($_POST['kpasien']);
	$kprks 		= htmlspecialchars($_POST['kprks']);
	$keluhan 	= htmlspecialchars($_POST['keluhan']);
	$kdkmar 	= $kddokter = $kdpenyakit = $kdtindakan = $kdalat = $ctt = $kdobt = ""; //inisialisasi

	if(isset($_POST['kdpenyakit'])){
		$kdpenyakit = $_POST['kdpenyakit'];
	}else{
		$kdpenyakit = $_POST['kdpenyakitlm'];
	}

	if(isset($_POST['kddokter'])){
		$kddokter 	= $_POST['kddokter'];
	}else{
		$kddokter 	= $_POST['kddktlm'];
	}

	if(isset($_POST['kdtdk'])){
		$kdtindakan 	= $_POST['kdtdk'];
	}else{
		$kdtindakan 	= $_POST['kdtdklm'];
	}

	if(isset($_POST['kdalat'])){
		$kdalat 	= $_POST['kdalat'];
	}else {
		$kdalat 	= $_POST['kdaltlm'];
	}

	if(empty($keluhan)) {
		$type = "error";
		$judul = "Oops. !";
		$success = "silahkan isi keluhan nya !!!";

	}elseif(isset($_POST['kdobat'])){
			$kdobt 		= $_POST['kdobat'];
			$ctt 		= $_POST['cttnobt'];

			for ($i = 0; $i < count($kdobt); $i++) {//masukan data ke tabel transaksi obat
				if($ctt[$i] != ""){

					// $ucttn = htmlspecialchars($ctt[$i]);
					// $onotes = $DB_con->prepare("UPDATE det_obat SET kode_obat='$kdobt[$i]' , catatan='$ucttn'
					// 			WHERE id_trobat = $kdtrobt[$i] ");
					// $onotes->execute();
				}
									$type = "error";
									$judul = "Oops. !";
									$success = "Bagian catatan tidak boleh kosong !!!";
			}

	}elseif(!isset($_POST['kdkamar'])){

			$kdkmar = $_POST['kdkmrlm'];
			$reg = $DB_con->prepare("UPDATE tbl_periksa SET kode_kamar='$kdkmar' , kode_dokter='$kddokter' , kd_penyakit='$kdpenyakit' , kode_tindakan='$kdtindakan' , kode_alat='$kdalat' , keluhan='$keluhan' WHERE kode_periksa='$kprks' and kode_pasien='$kpasien'");
			$reg->execute();
			if($reg){
							$type = "success";
							$judul = "Congratulations !";
							$success = "data berhasil di ubah !!!";
				}else{
						$type = "error";
						$judul = "Oops. !";
						$success = "data gagal di ubah !!!";
				}


				if(isset($_POST['kdobat'])){
					$kdobt 		= $_POST['kdobat'];
					$ctt 		= $_POST['cttnobt'];

					for ($i = 0; $i < count($kdobt); $i++) {//masukan data ke tabel transaksi obat
						if($ctt[$i] != ""){

							$ucttn = htmlspecialchars($ctt[$i]);
							$onotes = $DB_con->prepare("UPDATE det_obat SET kode_obat='$kdobt[$i]' , catatan='$ucttn'
										WHERE id_trobat = $kdtrobt[$i] ");
							$onotes->execute();
						}
					}
					
				}

		}else{

			$kid 	= $_POST['kdkmrlm'];
			$list = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kid");
			$list->execute();
			$row = $list->fetch();

			$baru = $row['isi_kamar']-1;
			$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kid");
			$menus->execute();
			// ========================================= //

			$kamar 		= $_POST['kdkamar'];

			// ======== pindah space kamar ============= //
			$baru = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kamar");
			$baru->execute();
			$rows = $baru->fetch();
			$pindah = $rows['isi_kamar']+1;

			$move  = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$pindah' WHERE kode_kamar = $kamar");
			$move->execute();
			// ========================================= //

			$reg = $DB_con->prepare("UPDATE tbl_periksa SET kode_kamar='$kamar' , kode_dokter='$kddokter' , kd_penyakit='$kdpenyakit' , kode_tindakan='$kdtindakan' , kode_alat='$kdalat' , keluhan='$keluhan' WHERE kode_periksa='$kprks' and kode_pasien='$kpasien'");
			$reg->execute();
			if($reg){
							$type = "success";
							$judul = "Congratulations !";
							$success = "data berhasil di ubah !!!";
				}else{
						$type = "error";
						$judul = "Oops. !";
						$success = "data gagal di ubah !!!";
				}

			if(isset($_POST['kdobat'])){
					$kdobt 		= $_POST['kdobat'];
					$ctt 		= $_POST['cttnobt'];

					for ($i = 0; $i < count($kdobt); $i++) {//masukan data ke tabel transaksi obat
						if($ctt[$i] != ""){

							$ucttn = htmlspecialchars($ctt[$i]);
							$onotes = $DB_con->prepare("UPDATE det_obat SET kode_obat='$kdobt[$i]' , catatan='$ucttn'
										WHERE id_trobat = $kdtrobt[$i] ");
							$onotes->execute();
						}
					}
					
				}

			}

	}

if(isset($_POST['btn-hapus']))
{
	$did 		= $_POST['did'];
	$nid 		= $_POST['nid'];
	$kid 		= $_POST['kid'];
	$dodelete 	= $DB_con->prepare("DELETE FROM tbl_periksa WHERE kode_periksa='$did' and kode_pasien='$nid' ");
	$dodelete->execute();
	// tbl pendamping
	$dodeletepend 	= $DB_con->prepare("DELETE FROM tbl_pendamping WHERE kode_periksa='$did' and kode_pasien='$nid' ");
	$dodeletepend->execute();

	// ======== hapus trobat ============= //
	$trobat 	= $DB_con->prepare("DELETE FROM det_obat WHERE kode_periksa = '$did'");
	$trobat->execute();
	// ======== tambah space kamar ============= //

	$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kid");
	$min->execute();
	$rowm = $min->fetch();

	$baru = $rowm['isi_kamar']-1;
	$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kid");
	$menus->execute();
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

<!-- modal tambah priksa pasien -->
<div class="row justify-content-center tambahpriksa" style="display: none;">
	<div class="col-xl-12">
		<form class="form-horizontal"  method="post">
			<div class="row justify-content-center">
				<div class="col-lg-5">
					<div class="row flex-row">
						<div class="col-12">
							<div class="widget has-shadow bg-warning">
								<div class="widget-header bordered no-actions d-flex align-items-center">
									<h4 class="">Periksa Pasien</h4>
								</div>
								<div class="widget-body">
										<div class="form-group row d-flex align-items-center" style="margin-bottom: -1px !important">
											<div class="col-lg-12" style="display: none;">
												
													<label class="form-control-label">Nomer registrasi</label>
													<?php 

													$list = $DB_con->prepare("SELECT MAX(nomer_periksa) as top FROM tbl_periksa WHERE kode_periksa");
													$list->execute();$idp =$list->fetch();$nidp =$idp['top']+1;
													if ($nidp<10) {
													 	$nid = '00'.$nidp;
													}else{ $nid = '0'.$nidp;}?>

													<input name="nomer_periksa" type="text" class="form-control" value="Reg<?php echo $nid.$date;?>" readonly>
												
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-3">
											<div class="col-lg-12">
												
													<label class="form-control-label">Kode Pasien | Nama pasien</label>

													<select class="form-control" id="selectpasien">
														<option>Pilih Kode Pasien</option>
														<?php 
														$list = $DB_con->prepare("SELECT
															p.* 
															FROM 
															tbl_pasien AS p 
															WHERE NOT EXISTS ( SELECT kode_pasien FROM tbl_periksa AS mp WHERE mp.kode_pasien = p.kode_pasien AND mp.status !='d') ");
														$list->execute();
														while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
															<option value="<?php echo $row['nama_pasien']?>" data-kdpasien="<?php echo $row['kode_pasien'] ?>"><?php echo $row['kode_pasien'] ." - ". $row['nama_pasien']?></option>
														<?php }?>
													</select>
												
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-1">
											<div class="col-lg-12" style="display: none;">
												<div class="form-group">
													<label class="form-control-label">Nama</label>
													<input id="nmp" type="text" class="form-control" placeholder="masukan nama" readonly>
													<input name="kode_pasien" id="tmp" type="hidden" class="form-control">
												</div>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-3">
											<div class="col-lg-12">
												<label class="form-control-label">Keluhan</label>
												<div class="input-group">
												  <textarea class="form-control" name="keluhan" rows="2" placeholder="Keluhan" maxlength="50"></textarea>
												</div>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-3">
											<div class="col-lg-12">
												<label class="form-control-label">Diagnosa Penyakit</label>

												<select class="form-control" id="plhpenyakit" name="kdpenyakit">
													<option>Pilih Penyakit</option>
														<?php 
														$penyakit = $DB_con->prepare("SELECT * FROM tbl_penyakit");
														$penyakit->execute();
														while ($row = $penyakit->fetch(PDO::FETCH_ASSOC)) : ?>
													<option value="<?php echo $row['kd_penyakit']; ?>"><?php echo $row['nm_penyakit']; ?></option>
														<?php
														endwhile;
														?>
												</select>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-3">
											<div class="col-lg-12">
												<label class="form-control-label">Tindakan</label>

												<select class="form-control" id="plhtindak1" name="kdtdk">
													<option>Pilih tindakan</option>
														<?php 
															$tindak = $DB_con->prepare("SELECT * FROM tbl_tindakan");
															$tindak->execute();
															while ($row = $tindak->fetch(PDO::FETCH_ASSOC)) :?>
													<option value="<?= $row['kode_tindakan']; ?>">
														<?= $row['nama_tindakan']; ?>
													</option> 	    
														<?php
														endwhile;
														 ?>
												</select>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-3">
											<div class="col-lg-12">
												<label class="form-control-label">Alat</label>

												<select class="form-control" id="plhtindak1" name="kalat">
													<option>Pilih alat</option>
														<?php 
															$alat = $DB_con->prepare("SELECT * FROM tbl_alat");
															$alat->execute();
															while ($row = $alat->fetch(PDO::FETCH_ASSOC)) :?>
													<option value="<?= $row['kode_alat']; ?>">
														<?= $row['nama_alat']; ?>
													</option> 	    
														<?php
														endwhile;
														 ?>
												</select>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-3">
											<div class="col-lg-12">
												<label class="form-control-label">Dokter</label>

												<select class="form-control" id="plhdokter" name="kddokter">
													<option>Dokter</option>
														<?php 
														$dokter = $DB_con->prepare("SELECT * FROM tbl_dokter");
														$dokter->execute();
														while ($row = $dokter->fetch(PDO::FETCH_ASSOC)) : ?>
													<option value="<?php echo $row['kode_dokter']; ?>"><?php echo $row['nama_dokter']; ?></option>
														<?php
														endwhile;
														?>
												</select>
											</div>
										</div>
									


										<div class="form-group row d-flex align-items-center mb-3">
											<div class="col-lg-12">
												<label class="form-control-label">Pilih Ruangan</label>
												<select class="form-control" id="selectkamar">
													<option>Ruangan</option>
													<?php 
													$kamar = $DB_con->prepare("SELECT * FROM tbl_kamar WHERE kapasitas_kamar - isi_kamar");
													// var_dump($kamar);
													$kamar->execute();
													while ($rows=$kamar->fetch(PDO::FETCH_ASSOC)){?>
														<option value="<?php echo $rows['nama_kamar']?>" data-kdkamar="<?php echo $rows['kode_kamar'] ?>"><?php echo $rows['kode_kamar'].' '.$rows['nama_kamar']?></option>
													<?php }?>
												</select>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-5" style="margin-bottom: 56px !important">
											<div class="col-lg-12" style="display: none;">
												<label class="form-control-label">Nama Kamar</label>
												<input type="text" class="form-control" placeholder="nama kamar" id="kmr" readonly>
												<input name="kode_kamar" type="hidden" class="form-control" id="tmr">
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
								<div class="widget has-shadow bg-warning">
									<div class="widget-header bordered no-actions d-flex align-items-center">
										<h4 class="">Periksa Pasien</h4>
									</div>
									<div class="widget-body">
										<form class="form-horizontal">
									<!-- obat -->
											<div class="form-group row d-flex align-items-center mb-3">
												<div class="col-lg-12">
														<div class="form-row">
														    <div class="col-lg-4">
																<label class="form-control-label">Obat</label>
															</div>
															<div class="col">
																<label class="form-control-label">Catatan</label>
															</div>
														</div>
														<div class="form-row">
														    <div class="col-lg-4">
														      <select class="form-control" id="plhobat1" name="kdobat[]">
															<option>pilih obat</option>
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
														      <input type="text" class="form-control ctt1" name="cttnobt[]" placeholder="" readonly="" maxlength="30">
														    
														    </div>
														  </div>
														
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-3">
												<div class="col-lg-12">
													
														<div class="form-row">
													    <div class="col-lg-4">
													      <select class="form-control" id="plhobat2" name="kdobat[]">
															<option>pilih obat</option>
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
														      <input type="text" class="form-control ctt2" name="cttnobt[]" placeholder="" readonly="" maxlength="30">
													    </div>
													  </div>
														
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-3">
												<div class="col-lg-12">
													
														<div class="form-row">
													    <div class="col-lg-4">
													      <select class="form-control" id="plhobat3" name="kdobat[]">
															<option>pilih obat</option>
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
														      <input type="text" class="form-control ctt3" name="cttnobt[]" placeholder="" readonly="" maxlength="30">
													    </div>
													  </div>
														
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-3">
												<div class="col-lg-12">
													
														<div class="form-row">
													    <div class="col-lg-4">
													      <select class="form-control" id="plhobat4" name="kdobat[]">
															<option>pilih obat</option>
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
														      <input type="text" class="form-control ctt4" name="cttnobt[]" placeholder="" readonly="" maxlength="30">
													    </div>
													  </div>
														
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-3">
												<div class="col-lg-12">
													
														<div class="form-row">
													    <div class="col-lg-4">
													      <select class="form-control" id="plhobat5" name="kdobat[]">
															<option>pilih obat</option>
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
														      <input type="text" class="form-control ctt5" name="cttnobt[]" placeholder="" readonly="" maxlength="30">
													    </div>
													  </div>
														
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-3">
												<div class="col-lg-12">
													
														<div class="form-row">
													    <div class="col-lg-4">
													      <select class="form-control" id="plhobat6" name="kdobat[]">
															<option>pilih obat</option>
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
														      <input type="text" class="form-control ctt6" name="cttnobt[]" placeholder="" readonly="" maxlength="30">
													    </div>
													  </div>
														
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-3">
												<div class="col-lg-12">
													
														<div class="form-row">
													    <div class="col-lg-4">
													      <select class="form-control" id="plhobat7" name="kdobat[]">
															<option>pilih obat</option>
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
														      <input type="text" class="form-control ctt7" name="cttnobt[]" placeholder="" readonly="" maxlength="30">
													    </div>
													  </div>
														
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-3">
												<div class="col-lg-12">
													
														<div class="form-row">
													    <div class="col-lg-4">
													      <select class="form-control" id="plhobat8" name="kdobat[]">
															<option>pilih obat</option>
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
														      <input type="text" class="form-control ctt8" name="cttnobt[]" placeholder="" readonly="" maxlength="30">
													    </div>
													  </div>
														
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-3">
												<div class="col-lg-12">
													
														<div class="form-row">
													    <div class="col-lg-4">
													      <select class="form-control" id="plhobat9" name="kdobat[]">
															<option>pilih obat</option>
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
														      <input type="text" class="form-control ctt9" name="cttnobt[]" placeholder="" readonly="" maxlength="30">
													    </div>
													  </div>
														
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-4">
												<div class="col-lg-12">
													
														<div class="form-row">
													    <div class="col-lg-4">
													      <select class="form-control" id="plhobat10" name="kdobat[]">
															<option>pilih obat</option>
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
														      <input type="text" class="form-control ctt10" name="cttnobt[]" placeholder="" readonly="" maxlength="30">
													    </div>
													  </div>
														
												</div>
											</div>

											<div class="pull-right mb-5">
												<button type="submit" name="btn-periksa" class="btn btn-primary pull-right" onclick="tbhPeriksa();">Simpan</button>
												<button type="button" class="btn btn-shadow pull-right mr-2 kembali1" data-dismiss="modal">Kembali</button>
											</div>												
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</form>
	</div>
			<!-- Offcanvas Sidebar -->
</div>

<!-- main -->
<div class="row justify-content-center main">
	<div class="col-xl-12">
		<div class="row">
			<div class="col-lg-12">
				<!-- Sorting -->
				<div class="widget has-shadow">
					<div class="widget-header bordered no-actions d-flex align-items-center">
						<h4>List periksa</h4>
						<div class="col col-xs-6 text-right">
							<button type="button" class="btn btn-primary btn-square mr-1 mb-2 priksa">Priksa pasien</button>
						</div>
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="sorting-table" class="table mb-0">
								<thead>
									<tr>
										<th>Kode periksa</th>
										<th>Kode Pasien</th>
										<th>Nama Pasien</th>
										<th>Tanggal periksa</th>
										<th>Ruang Periksa</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$list = $DB_con->prepare("SELECT
										tbper.*,
										mp.nama_pasien AS nama,
										mp.tgl_lahir AS tgllhr,
										tpe.nm_penyakit AS nmpenyakit,
										tdk.nama_tindakan AS nmtindakan,
										talt.nama_alat AS nmalat,
										tdkt.nama_dokter AS nmdkt,
										mk.nama_kamar AS nkamar 
										FROM
										tbl_periksa tbper,
										tbl_pasien mp,
										tbl_penyakit tpe,
										tbl_tindakan tdk,
										tbl_alat talt,
										tbl_dokter tdkt,
										tbl_kamar mk
										WHERE
										tbper.kode_pasien = mp.kode_pasien 
										AND tbper.kd_penyakit = tpe.kd_penyakit
										AND tbper.kode_tindakan = tdk.kode_tindakan
										AND tbper.kode_alat = talt.kode_alat
										AND tbper.kode_dokter = tdkt.kode_dokter
										AND tbper.kode_kamar = mk.kode_kamar"
										
									);
									
									$list->execute();
									// var_dump($list->fetch(PDO::FETCH_ASSOC));
									while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
										<tr>
											<td><span class="text-primary">KP<?php echo $row['kode_periksa']?></span></td>
											<td><span class="text-primary">PSN<?= ($row['kode_pasien'])?></span></td>
											<td><span class="text-primary"><?php echo ucfirst($row['nama']);?></span></td>
											<td><span class="text-primary"><?php echo substr($row['tgl_periksa'], 0, 10); ?></span></td>
											<td><span class="text-primary"><?php echo ucfirst($row['nkamar']);?></span></td>
											<td class=""><span class="text-primary">
												<?php 

													if($row['nkamar']=='IGD' && $row['status']=='a'){
														echo "Sedang di periksa";
													}elseif ($row['nkamar'] !='IGD' && $row['status']=='a'){
														echo "Sedang di rawat";
													}elseif ($row['status']=='d'){
														echo "Selesai";
													}

												?>
											</span></td>

											<?php 
												// $kdreg = $row['kode_periksa'];
												// $obt = $DB_con->prepare("
												// 	SELECT * FROM 
												// 	det_obat tbrobt,
												// 	tbl_obat tblobt,
												// 	tbl_periksa tbreg
												// 	WHERE
												// 	tbrobt.kode_periksa = tbreg.kode_periksa
												// 	AND	tbrobt.kode_obat = tblobt.kode_obat
												// 	AND tbreg.kode_periksa = '$kdreg'
												// 	");

												// $obt->execute();												
												// $hobt = $obt->fetch(PDO::FETCH_ASSOC);

											 ?>

											<td class="td-actions text-left">
												<?php 
													if($row['nkamar'] == 'IGD' || $row['status'] == 'd'): ?>
														<a href="#" class="eedit" 
														data-rid="<?php echo $row['kode_periksa']?>"
														data-toggle="modal" data-target="#update">
															<i class="la la-edit edit text-success"></i>
														</a>

														<a href="#" class="detail" 
														data-kper="<?php echo $row['kode_periksa']?>"
														data-toggle="modal" data-target="#">
															<i class="fas fa-info-circle edit text-success"></i>
														</a>

														<a href="#" class="trash" 
														data-id="<?php echo $row['kode_periksa']?>" data-idp="<?php echo $row['kode_pasien']?>"
														data-kamar="<?php echo $row['kode_kamar'];?>" data-toggle="modal" data-target="#delete"><i class="la la-close delete text-danger"></i>
														</a>
	
													<?php 
													else: ?>
														<a href="#" class="eedit" 
														data-rid="<?php echo $row['kode_periksa']?>"
														data-toggle="modal" data-target="#update">
															<i class="la la-edit edit text-success"></i>
														</a>

														<a href="#" class="detail" 
														data-kper="<?php echo $row['kode_periksa']?>"
														data-toggle="modal" data-target="#">
															<i class="fas fa-info-circle edit text-success"></i>
														</a>

														<a href="#" class="trash" 
														data-id="<?php echo $row['kode_periksa']?>" data-idp="<?php echo $row['kode_pasien']?>"
														data-kamar="<?php echo $row['kode_kamar'];?>" data-toggle="modal" data-target="#delete"><i class="la la-close delete text-danger"></i>
														</a>

														<?php 
															if($row['setper'] == 'ok'):?>
																<a href="#" class="sign" 
																data-kpas="<?php echo $row['kode_pasien']?>"
																data-kper="<?php echo $row['kode_periksa']?>"
																data-toggle="modal" data-target="#pendamping">
																	<i class="fas fa-signature signper text-success"></i>
																</a>
															<?php 
																else: ?>
																<a href="#" class="sign" 
																data-kpas="<?php echo $row['kode_pasien']?>"
																data-kper="<?php echo $row['kode_periksa']?>"
																data-toggle="modal" data-target="#pendamping">
																	<i class="fas fa-signature signper text-warning"></i>
																</a>
															<?php 
															endif;
													endif;
												 ?>	
											</td>
										</tr>
									<?php } ?>
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


<!-- detail periksa -->
<div class="row rmp">
</div>


<!-- sign -->
<div class="row getSign">
</div>


<!-- container ubah -->
<div class="row justify-content-center ubahpriksa" >	
</div>

<!-- modal tbh / ubh pendamping -->
	<div id="pendamping" class="modal fade">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title mtpend">Pendamping</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">tutup</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Nama Pendamping</label>
								<input name="nama_pendamping" type="text" class="form-control" placeholder="Nama" autocomplete="off" required="" >
								<small id="nmpend" class="form-text text-danger"></small>

								<input name="kd_pasien" type="hidden" class="form-control">
								<input name="kd_priksa" type="hidden" class="form-control">
							</div>
						</div>
						
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Jenis Kelamin</label>
								<select name="jns_kelamin" class="custom-select form-control" required="">
									<option value="">Pilih</option>
									<option value="pria">Pria</option>
									<option value="wanita">Wanita</option>
								</select>
								<small id="jnskel" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Tanggal lahir</label>
								<input name="tgllahir" type="date" class="form-control tglpend" data-date-format="yyyy-mm-dd" onchange="cektgl();" id="" placeholder="yyyy-mm-dd" autocomplete="off" required="" >
								<small id="tglpend" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Hub. Dengan Pasien</label>
								<select name="hubungan" class="custom-select form-control" required="">
									<option value="">Pilih</option>
									<option value="orang_tua">Orang Tua</option>
									<option value="suami">Suami</option>
									<option value="istri">Istri</option>
									<option value="anak">Anak</option>
									<option value="wali">Wali</option>
								</select>
								<small id="hub" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Nomer Telepon</label>
								<input name="telepon" type="tel" maxlength="15" class="form-control" placeholder="nomer telephone" autocomplete="off" required="" title="Format: 081297205191" >
								<small id="tel" class="form-text text-info"> Format: 081297205191</small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Pekerjaan</label>
								<input name="pekerjaan" type="text" class="form-control" placeholder="pekerjaan" autocomplete="off" required="" >
								<small id="pekerjaan" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Alamat</label>
								<textarea name="alamat" class="form-control" placeholder="alamat" autocomplete="off" required="" ></textarea>
								<small id="alamat" class="form-text text-danger"></small>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Tutup</button>
					<button type="submit" name="btn-sign" class="btn-sign btn btn-danger mr-1" onclick="addPendamping()">Simpan</button>
					<button style="display: none;" type="submit" name="btn-ubah" class="btn-ubah btn btn-danger mr-1" onclick="addPendamping('ubah')">Ubah / Cetak</button>
				</div>
			</div>
		</div>
	</div>


<!-- modal hapus -->
<form method="post">
	<div id="delete" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
					<div class="section-title mt-5 mb-2">
						<h2 class="text-gradient-02">Anda yakin mau menghapus ini ?</h2>
						<input type="hidden" name="did" id="d_id">
						<input type="hidden" name="nid" id="n_id">
						<input type="hidden" name="kid" id="kamar">
					</div>
					<p class="mb-5">Data tidak dapat dikembalikan setelah di hapus</p>
					<button type="submit" class="btn btn-danger mb-3" name="btn-hapus">Ok</button>
				</div>
			</div>
		</div>
	</div>
</form>

<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery.min.js"></script>





<!-- btn form ttd  -->
<script>

//validasi form	
	$("[name='nama_pendamping']").keyup(function(event) {
				$('#nmpend').hide();
			});

	$("[name='tgllahir']").click(function(event) {
				$('#tglpend').hide();
			});

	$("[name='jns_kelamin']").change(function(event) {
				$('#jnskel').hide();
			});

	$("[name='hubungan']").change(function(event) {
				$('#hub').hide();
			});

	$("[name='pekerjaan']").keyup(function(event) {
				$('#pekerjaan').hide();
			});

	$("[name='alamat']").keyup(function(event) {
				$('#alamat').hide();
			});

	$("[name='telepon']").keyup(function(event) {
				$('#tel').hide();
			});


	function cektgl(){
		// var tgl = $("[name='tgllahir']").val();
		// var plhtgl = new Date(tgl);
		// var tgls = new Date();
		// if(plhtgl > tgls){
		// 	$('#tglpend').text('format tanggal tidak sesuai !');
		// 	$('#tglpend').show();
		// 	return false;
		// }
	}

//masukan data ke database
	function addPendamping(ubah) {
		var ubhData = ubah;
		var kdpas 		= $("[name='kd_pasien']").val();
		var kdper 		= $("[name='kd_priksa']").val();
		var nmpend 		= $("[name='nama_pendamping']").val();
		var tgllhr 		= $("[name='tgllahir']").val();
		var jnsklm 		= $("[name='jns_kelamin']").val();
		var hubungan 	= $("[name='hubungan']").val();
		var tlp 		= $("[name='telepon']").val();
		var pekerjaan	= $("[name='pekerjaan']").val();
		var alamat 		= $("[name='alamat']").val();
		var date 		= new Date().toISOString().split('T')[0];

		if(nmpend == ""){
			$('#nmpend').text('nama pendamping tidak boleh kosong !').show();
			$("[name='nama_pendamping']").focus();
			return false;

		}else if(!(/^[a-zA-Z\s]+$/.test(nmpend))){
			$('#nmpend').text('nama pendamping hanya boleh text !').show();
			$("[name='nama_pendamping']").focus();
			return false;

		}else if(jnsklm == ""){
			$('#jnskel').text('pilih jenis kelamin !').show();
			$("[name='jns_kelamin']").focus();
			return false;

		}else if(tgllhr == ""){
			$('#tglpend').text('tanggal harus di isi !').show();
			$("[name='tgllahir']").focus();
			return false;

		}else if(tgllhr >= date){
			$("#tglpend").text('tanggal lahir salah !').show();
			$("[name='tgllahir']").focus();
			return false;

		}else if(hubungan == ""){
			$('#hub').text('pilih hubungan keluarga !').show();
			$("[name='hubungan']").focus();
			return false;

		}else if(tlp == ""){
			$('#tel').text('kolom ini tidak boleh kosong !').removeClass('text-info').addClass('text-danger').show();
			$("[name='telepon']").focus();
			return false;

		}else if(!(/^-?\d*$/.test(tlp))){
			$('#tel').text('no telp hanya boleh angka !').removeClass('text-info').addClass('text-danger').show();
			$("[name='telepon']").focus();
			return false;

		}else if(pekerjaan == ""){
			$('#pekerjaan').text('kolom ini tidak boleh kosong !').show();
			$("[name='pekerjaan']").focus();
			return false;

		}else if(!(/^[a-zA-Z\.\s\/\()]+$/.test(pekerjaan))){
			$('#pekerjaan').text('pekerjaan hanya boleh text !').show();
			$("[name='pekerjaan']").focus();
			return false;

		}else if(alamat == ""){
			$('#alamat').text('kolom ini tidak boleh kosong !').show();
			$("[name='alamat']").focus();
			return false;
		}else{
			
			$.ajax({
				url: 'class/tbhPendamping.php',
				type: 'POST',
				dataType: 'html',
				data: "kdpas="+kdpas+"&kdper="+kdper+"&nmpend="+nmpend+"&tgllhr="+tgllhr+"&jnsklm="+jnsklm+"&hubungan="+hubungan+"&tlp="+tlp+"&pekerjaan="+pekerjaan+"&alamat="+alamat+"&ubah="+ubhData,
				success: function(result) {
					$('.getSign').html(result);
				}
			});

			// modal hide 1
			$('#pendamping').fadeOut('fast', function() {
			});
			$('body').removeClass('modal-open');
			$('.modal-backdrop').fadeOut('fast', function() {
			});

			// ilangkan main
			$('.main').fadeOut('slow/400/fast', function() {
			});
		}



	}
</script>

<!-- btn ttd click -->
<script>
	$('.sign').click(function(event) {
		var kdpasien = $(this).data('kpas');
		var kdperiksa = $(this).data('kper');

		$.ajax({
			url: "class/aksiBtnTtd.php",
			type: "POST",
			data: "kdpasien="+kdpasien+"&kdperiksa="+kdperiksa,
			success: function(result) {
				 var resultObj = JSON.parse(result);
				 // console.log(resultObj);
			//jika data ada maka ubah data / cetak
				 if(resultObj[0] == "ada"){

				 	var kdper 		= resultObj[1].kode_periksa;
				 	var kdpas 		= resultObj[1].kode_pasien;

				 	var nmpend 		= resultObj[1].nama_pendamping;
				 	var jnskel 		= resultObj[1].jns_kelamin;
				 	var tgllhr 		= resultObj[1].tgl_lahir;
				 	var hubpas 		= resultObj[1].hub_keluarga;
				 	var notlp  		= resultObj[1].telp_pendamping;
				 	var pekerjaan  	= resultObj[1].pekerjaan;
				 	var alamat  	= resultObj[1].alamat_pendamping;

				 // isi ke form 
				 	$("[name='kd_pasien']").val(kdpas);
				 	$("[name='kd_priksa']").val(kdper);

				 	$("[name='nama_pendamping']").val(nmpend);
				 	$("[name='jns_kelamin']").val(jnskel);
				 	$("[name='tgllahir']").val(tgllhr);
				 	$("[name='hubungan']").val(hubpas);
				 	$("[name='telepon']").val(notlp);
				 	$("[name='pekerjaan']").val(pekerjaan);
				 	$("[name='alamat']").val(alamat);

				 //ubah title
				 $('.mtpend').text('Ubah Data');
				 //hilangkan tombol simpan ganti dengan tbl ubah
				 $("[name='btn-sign']").hide();
				 $("[name='btn-ubah']").show();

				$('#nmpend').hide();
				$('#tglpend').hide();
				$('#jnskel').hide();
				$('#hub').hide();
				$('#pekerjaan').hide();
				$('#alamat').hide();
				$('#tel').hide();
				 

			//jika data kosong input pendamping
				 }else if(resultObj[0] == "kosong"){
				 	$("[name='kd_pasien']").val(kdpasien);
					$("[name='kd_priksa']").val(kdperiksa);

				 	$("[name='nama_pendamping']").val('');
				 	$("[name='jns_kelamin']").val('');
				 	$("[name='tgllahir']").val('');
				 	$("[name='hubungan']").val('');
				 	$("[name='telepon']").val('');
				 	$("[name='pekerjaan']").val('');
				 	$("[name='alamat']").val('');

				 	$('.mtpend').text('Tambah Data');
				 	//tompilkan tombol simpan 
					 $("[name='btn-sign']").show();
					 $("[name='btn-ubah']").hide();


					$('#nmpend').hide();
					$('#tglpend').hide();
					$('#jnskel').hide();
					$('#hub').hide();
					$('#pekerjaan').hide();
					$('#alamat').hide();
					$('#tel').hide();
				 }
			}
		});
		
		
	});
</script>

<!-- daftar tampil -->
<script>
	$('.priksa').click(function(event) {
		/* Act on the event */
		$('.tambahpriksa').fadeIn('800', function() {
		});
		$('.main').fadeOut('slow/400/fast', function() {
		});
	});

	$('.kembali1').click(function(event) {
		/* Act on the event */
		$('.main').fadeIn('slow/400/fast', function() {
		});
		$('.tambahpriksa').fadeOut('slow/400/fast', function() {
		});
	});

</script>


<!-- form obat & datapicker -->
<script>
	$(document).ready(function() {

		$('#plhobat1').change(function(event) {
			/* Act on the event */
			$dataobt1 = $(this).val();
			if($dataobt1 != "pilih obat"){
				$('.ctt1').attr('readonly', false);
			}else{
				$('.ctt1').attr('readonly', true);
			}
		}); 

		$('#plhobat2').change(function(event) {
			/* Act on the event */
			$dataobt2 = $(this).val();
			if($dataobt2 != "pilih obat"){
				$('.ctt2').attr('readonly', false);
			}else{
				$('.ctt2').attr('readonly', true);
			}
		}); 

		$('#plhobat3').change(function(event) {
			/* Act on the event */
			$dataobt3 = $(this).val();
			if($dataobt3 != "pilih obat"){
				$('.ctt3').attr('readonly', false);
			}else{
				$('.ctt3').attr('readonly', true);
			}
		}); 
		$('#plhobat4').change(function(event) {
			/* Act on the event */
			$dataobt4 = $(this).val();
			if($dataobt4 != "pilih obat"){
				$('.ctt4').attr('readonly', false);
			}else{
				$('.ctt4').attr('readonly', true);
			}
		}); 
		$('#plhobat5').change(function(event) {
			/* Act on the event */
			$dataobt5 = $(this).val();
			if($dataobt5 != "pilih obat"){
				$('.ctt5').attr('readonly', false);
			}else{
				$('.ctt5').attr('readonly', true);
			}
		}); 
		$('#plhobat6').change(function(event) {
			/* Act on the event */
			$dataobt6 = $(this).val();
			if($dataobt6 != "pilih obat"){
				$('.ctt6').attr('readonly', false);
			}else{
				$('.ctt6').attr('readonly', true);
			}
		}); 
		$('#plhobat7').change(function(event) {
			/* Act on the event */
			$dataobt7 = $(this).val();
			if($dataobt7 != "pilih obat"){
				$('.ctt7').attr('readonly', false);
			}else{
				$('.ctt7').attr('readonly', true);
			}
		}); 
		$('#plhobat8').change(function(event) {
			/* Act on the event */
			$dataobt8 = $(this).val();
			if($dataobt8 != "pilih obat"){
				$('.ctt8').attr('readonly', false);
			}else{
				$('.ctt8').attr('readonly', true);
			}
		}); 
		$('#plhobat9').change(function(event) {
			/* Act on the event */
			$dataobt9 = $(this).val();
			if($dataobt9 != "pilih obat"){
				$('.ctt9').attr('readonly', false);
			}else{
				$('.ctt9').attr('readonly', true);
			}
		}); 
		$('#plhobat10').change(function(event) {
			/* Act on the event */
			$dataobt10 = $(this).val();
			if($dataobt10 != "pilih obat"){
				$('.ctt10').attr('readonly', false);
			}else{
				$('.ctt10').attr('readonly', true);
			}
		}); 

		// shorting data in datatable 
		$('#sorting-table').data({
			"order": [[0,"desc"]]
		});
		// datapicker
		  $( "" ).datepicker({dateFormat: 'yy-mm-dd'});
	      $( "" ).datepicker( "option", "showAnim", 'slideDown' );

		
	});
</script>

<!-- script ubah data periksa -->
<script type="text/javascript">
	$('.eedit').click(function(){
		var kdreg 		= $(this).data('rid');
		$('.ubahpriksa').fadeIn('slow/400/fast', function() {
		});
		$('.main').fadeOut('slow/400/fast', function() {
		});

		$('.ubahpriksa').load('class/ubahPriksa.php?kreg='+kdreg ,
			function(){
			/* Stuff to do after the page is loaded */
		});

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

<!-- scriphapus -->
<script type="text/javascript">
	$('.trash').click(function(){
		var id=$(this).data('id');
		var idp=$(this).data('idp');
		var kamar=$(this).data('kamar');
		document.getElementById('d_id').value = id;
		document.getElementById('n_id').value = idp;
		document.getElementById('kamar').value = kamar;
	});
</script>

<!-- script tmpl detperiksa -->
<script>
	$('.detail').click(function(event) {
		var kper = $(this).data('kper');
		$('.rmp').fadeIn('slow/400/fast', function() {
		});
		$('.main').fadeOut('slow/400/fast', function() {
		});
		
		$('.rmp').load('class/detailPeriksa.php?kdper='+kper,
			function(){
		});
		
	});
</script>

<!-- script pilih pasien -->
<script type="text/javascript">
	$('#selectpasien').on('change', function() {
		var id = $(this).val();
		var tx = $(this).find("option:selected").text();
		var kdpasien= $(this).find("option:selected").data('kdpasien');
		document.getElementById('nmp').value = id;
		document.getElementById('tmp').value = kdpasien;
	});
</script>

<!-- pilih ubah kamar -->
<script type="text/javascript">
	$('#selectkamar').on('change', function() {
		var id = $(this).val();
		var tx = $(this).find("option:selected").text();
		var kdkamar = $(this).find("option:selected").data('kdkamar');
		document.getElementById('kmr').value = id;
		document.getElementById('tmr').value = kdkamar;
	});
</script>