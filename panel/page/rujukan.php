<?php 
if(isset($_POST['btn-rjkan']))
{
	$kd	= htmlspecialchars($_POST['kd_rjk']);
	$patterna = '/([^0-9]+)/';
	$kd_rjk = preg_replace($patterna,'',$kd);

	$kdper 		= htmlspecialchars($_POST['kdper']);
	$nm_dokter 	= htmlspecialchars($_POST['nm_dokter']);
	$rm_rujukan = htmlspecialchars($_POST['rm_rujukan']);
	$alamat 	= htmlspecialchars($_POST['alamat']);
	$notlp 		= htmlspecialchars($_POST['notlp']);

	if($_POST['kdper'] == "" || $_POST['kdper'] == "Kode Perawatan || Pasien" ){
			$type = "error";
			$judul = "Data gagal di tambah";
			$success = "Silahkan Pilih Pasien.";
	}else if(!preg_match("/^[a-zA-Z\s\.]*$/",$nm_dokter)){
			$type = "error";
			$judul = "Data gagal di tambah";
			$success = "Nama Dokter harus text.";
	}else if(!preg_match("/^[0-9]*$/",$notlp)){
			$type = "error";
			$judul = "Data gagal di tambah";
			$success = "No Telp harus angka.";
	}else{
				$notes 		= $DB_con->prepare("INSERT INTO tbl_rujukan(kode_rujukan,kode_perawatan,dokter,rs_rujukan,alamat,no_tlp)
					VALUES('$kd_rjk','$kdper','$nm_dokter','$rm_rujukan','$alamat','$notlp')");
				$notes->execute();	
				if($notes){
								$type = "success";
								$judul = "Congratulations !";
								$success = "data rujukan berhasil di tambah !!!";
				}else{
								$type = "error";
								$judul = "Oops. !";
								$success = "data rujukan gagal di tambah !!!";
				}
	}
}

if(isset($_POST['btn-ubah']))
{

	
	$kdrjk 		= htmlspecialchars($_POST['krjk']);
	// $nmpas 		= htmlspecialchars($_POST['unmpas']);
	$nmrs 		= htmlspecialchars($_POST['urm_rujukan']);
	$nmdok 		= htmlspecialchars($_POST['unm_dokter']);
	$alamat		= htmlspecialchars($_POST['ualamat']);
	$tlp		= htmlspecialchars($_POST['unotlp']);


				
				$menus = $DB_con->prepare("UPDATE tbl_rujukan SET rs_rujukan='$nmrs', dokter='$nmdok', alamat='$alamat', no_tlp='$tlp'  WHERE kode_rujukan='$kdrjk'");
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
	$kdrjk 		= $_POST['kdrjk'];
	$dodelete 	= $DB_con->prepare("DELETE FROM tbl_rujukan WHERE kode_rujukan='$kdrjk'");
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
<div class="row justify-content-center main">
	<div class="col-xl-12">
		<div class="row">
			<div class="col-lg-3">
				<div class="widget has-shadow bg-warning">
					<div class="widget-header bordered no-actions d-flex align-items-center">
						<h4>Tambah Rujukan</h4>
					</div>	
					<div class="widget-body">
						<form method="post">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<?php 
											$tgl = date('dmy');
											$list = $DB_con->prepare("SELECT MAX(nomor) as top FROM tbl_rujukan");
											$list->execute();
											$idr =$list->fetch();
											$kdr =$idr['top']+1;
											if($kdr<10){
											 	$kdrjk = '00'.$kdr;
											 }else{ $kdrjk = '0'.$kdr;} ?>

										<label class="form-control-label">Nomor Rujukan</label>
										<input name="kd_rjk" type="text" class="form-control" readonly value="SRP<?php 
											echo $kdrjk.$tgl; 
										?> ">
									</div>
								</div>
								<div class="col-lg-12 pilpas">
									<div class="form-group">
										<label class="form-control-label">Pilih Pasien</label>
											<?php 
											$rujukan = $DB_con->prepare("SELECT
												*
												FROM
												tbl_periksa tbp,
												tbl_pasien mp,
												tbl_kamar mk,
												tbl_perawatan mpr
												WHERE
												tbp.kode_pasien = mp.kode_pasien
												AND tbp.kode_kamar = mk.kode_kamar
												AND tbp.kode_periksa = mpr.kode_periksa
												AND ISNULL(mpr.setpas)");
											$rujukan->execute();
											?>
											<select class="form-control" name="kdper" id="kdper" required="">
												<option value="" id="kdper" selected >Kode Perawatan || Pasien</option>
												<?php while ($rows=$rujukan->fetch(PDO::FETCH_ASSOC)){ ?>
													<option value="<?php echo $rows['kode_perawatan'];?>">
														<?php echo $rows['kode_perawatan'].'- '.$rows['nama_pasien'];?></option>

													<?php }?>
												</select>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Rumah Sakit Rujukan</label>
										<input name="rm_rujukan" id="rm_rujukan" type="text" class="form-control" placeholder="Nama rumah sakit" required="" autocomplete="off">
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Nama Dokter Rujukan</label>
										<input name="nm_dokter" id="nm_dokter" type="text" class="form-control" placeholder="Nama Dokter" required="" autocomplete="off">
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Alamat</label>
										<textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Alamat" required="" maxlength="50"></textarea>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">No. Telp</label>
										<input name="notlp" id="notlp" type="text" class="form-control" autocomplete="off" maxlength="15" placeholder="No Telp" required="">
										<small id="tel" class="form-text text-danger"></small>
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit" name="btn-rjkan" class="btn btn-primary pull-right">Tambah</button>
								</div>
							</div>
						</form>
					</div>	
				</div>
			</div>

	<!-- table data -->
			<div class="col-lg-9">
				<!-- Sorting -->
				<div class="widget has-shadow">
					<div class="widget-header bg-primary bordered no-actions d-flex align-items-center">
						<h4 class="text-white">List Pasien Rujukan</h4>
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="sorting-table" class="table mb-0">
								<thead>
									<tr>
										<th>No</th>
										<th>No Surat Rujukan</th>
										<th>Tanggal</th>
										<th>Nama Pasien</th>
										<th>Rumah Sakit</th>
										<th>Dokter</th>
										<th>Aksi</th>
									</tr>
								</thead>
								
								<tbody>						
									<?php 
										$tmpilData = $DB_con->prepare("SELECT * FROM 
																		tbl_rujukan tbr,
																		tbl_perawatan tbperw,
																		tbl_pasien tbpas
																		WHERE
																		tbr.kode_perawatan = tbperw.kode_perawatan
																		AND tbperw.kode_pasien = tbpas.kode_pasien
																		");
										$tmpilData->execute();
										$no = 1;
										while ($rows = $tmpilData->fetch(PDO::FETCH_ASSOC)):
									 ?>			
										<tr>
											<td><span class="text-primary"><?= $no; ?></span></td>
											<td><span class="text-primary">SRP<?= $rows['kode_rujukan']; ?></span></td>
											<td><span class="text-primary"><?= substr($rows['tanggal'], 0, 10); ?></span></td>
											<td><span class="text-primary"><?= $rows['nama_pasien']; ?></span></td>
											<td><span class="text-primary"><?= $rows['rs_rujukan']; ?></span></td>
											<td><span class="text-primary"><?= $rows['dokter']; ?></span></td>
											
											<td class="td-actions text-center">
												<a href="#" class="eedit" 
													data-krjk="<?= $rows['kode_rujukan']; ?>"
													data-nmpas="<?= $rows['nama_pasien']; ?>"
													data-nmrm="<?= $rows['rs_rujukan']; ?>"
													data-nmdok="<?= $rows['dokter']; ?>"
													data-almt="<?= $rows['alamat']; ?>"
													data-tlp="<?= $rows['no_tlp']; ?>" 
													data-toggle="modal" data-target="#ubah" >
													<i class="la la-edit edit delete"></i>
												</a>

												<!-- <a href="<?php echo $base_url;?>invoice&&id=" target="_blank"><i class="la la-print more text-success"></i></a> -->

												<a href="#" class="print" 
													data-krjk="<?= $rows['kode_rujukan']; ?>"
													data-toggle="modal" data-target="#print"
													>
													<i class="la la-print more text-success"></i>
												</a>

												<a href="#" class="trash" 
													data-id="<?= $rows['kode_rujukan']; ?>" 
													data-toggle="modal" data-target="#delete">
													<i class="la la-close delete text-danger"></i>
												</a>
											</td>
										</tr>
									<?php 
										$no++;
										endwhile;
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


<!-- print rujukan -->
<div class="row printSr">
</div>

<!-- modal ubah data -->
<form method="post" onsubmit="return formValidasi();">
	<div id="ubah" class="modal fade">
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
								<label class="form-control-label">Nama Pasien</label>
								<input name="unmpas" type="text" class="form-control" placeholder="masukan nama" autocomplete="off" required="" disabled="">
								<input type="hidden" name="krjk">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">Rumah Sakit Rujukan</label>
								<input name="urm_rujukan" type="text" class="form-control unmrs" placeholder="Nama rumah sakit" autocomplete="off">
								<small class="form-text text-danger" id="unmrs"></small>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">Nama Dokter Rujukan</label>
								<input name="unm_dokter" type="text" class="form-control unmdok" placeholder="Nama Dokter" autocomplete="off">
								<small class="form-text text-danger" id="unmdok"></small>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">Alamat</label>
								<textarea class="form-control ualmt" name="ualamat" rows="2" placeholder="Alamat" ></textarea>
								<small class="form-text text-danger" id="ualmt"></small>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label class="form-control-label">No. Telp</label>
								<input name="unotlp" type="text" class="form-control utelp" autocomplete="off">
								<small class="form-text text-danger" id="utelp"></small>
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
						<input type="hidden" name="kdrjk" id="kdrjk">
					</div>
					<p class="mb-5">Data tidak dapat dikembalikan setelah di hapus</p>
					<button type="submit" class="btn btn-danger mb-3" name="btn-hps">Ok</button>
				</div>
			</div>
		</div>
	</div>
</form>
	
<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery.min.js"></script>

<!-- script print SRp -->
<script>
	$('.print').click(function(event) {
		/* Act on the event */
		var kdrjk = $(this).data('krjk');

			$('.main').fadeOut('slow/400/fast', function() {
			});
			$('.printSr').fadeIn('slow/400/fast', function() {
			});

		$('.printSr').load('class/doPrintSrp.php?kdrjk='+kdrjk ,
			function(){
		});
		

	});
</script>

<!-- script ubah -->
<script type="text/javascript">
	$('.eedit').click(function(){
		var krjk = $(this).data('krjk');
		var nmpas = $(this).data('nmpas');
		var nmrm = $(this).data('nmrm');
		var nmdok = $(this).data('nmdok');
		var almt = $(this).data('almt');
		var tlp = $(this).data('tlp');

		$("[name='krjk']").val(krjk);
		$("[name='unmpas']").val(nmpas);
		$("[name='urm_rujukan']").val(nmrm);
		$("[name='unm_dokter']").val(nmdok);
		$("[name='ualamat']").val(almt);
		$("[name='unotlp']").val(tlp);


	});
</script>

<!-- formvalidsi -->
<script>

	$(".unmrs").keyup(function(event) {
		$("#unmrs").hide();
	});

	$(".unmdok").keyup(function(event) {
		$("#unmdok").hide();
	});

	$(".ualmt").keyup(function(event) {
		$("#ualmt").hide();
	});

	$(".utelp").keyup(function(event) {
		$("#utelp").hide();
	});
	
	function formValidasi(){

		var nmrs 	= $(".unmrs").val(),
			nmdok 	= $(".unmdok").val(),
			almt 	= $(".ualmt").val(),
			telp 	= $(".utelp").val();

		if(nmrs == ""){
			$("#unmrs").text('Bagian ini tidak boleh kosong').show();
			$(".unmrs").focus();
			return false;

		}else if(nmdok == ""){
			$("#unmdok").text('Bagian ini tidak boleh kosong').show();
			$(".unmdok").focus();
			return false;

		}else if(!(/^[a-zA-Z\.\s\/\()]+$/.test(nmdok))){
			$('#unmdok').text('nama dokter hanya boleh text !').show();
			$(".unmdok").focus();
				return false;

		}else if(almt == ""){
			$("#ualmt").text('Bagian ini tidak boleh kosong').show();
			$(".ualmt").focus();
			return false;

		}else if(telp == ""){
			$("#utelp").text('Bagian ini tidak boleh kosong').show();
			$(".utelp").focus();
			return false;

		}else if(!(/^-?\d*$/.test(telp))){
			$("#utelp").text('no telp hanya boleh angka !').show();
			$(".utelp").focus();
			return false;
			
		}else{
			return true;
		}

	}
</script>

<!-- valid required -->
<script>
	document.addEventListener("DOMContentLoaded", function() {
             var elment = document.getElementsByTagName('INPUT');
             var elmentSel = document.getElementsByTagName('SELECT');

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

             //...
             elmentSel[0].oninvalid = function(e) {
	             e.target.setCustomValidity("");
	             if(!e.target.validity.valid){
	                e.target.setCustomValidity("Silahkan Pilih Pasien.");
	             }
	         };
	         elmentSel[0].oninput = function(e){
	            e.target.setCustomValidity("");
	         };


         });
</script>

<!-- script hps -->
<script type="text/javascript">
	$('.trash').click(function(){
		var id=$(this).data('id');
		document.getElementById('kdrjk').value = id;
	});
</script>

<script>
	$(document).ready(function() {
		$('#sorting-table').data({
			"order": [[1,"desc"]]
		});
	});
</script>