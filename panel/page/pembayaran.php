<?php 
date_default_timezone_set('UTC');
$date 	= date('Y-m-d');

// tambah data pembayaran
if(isset($_POST['btn-pembayaran']))
	{			
		// var_dump($_POST);die();
				if($_POST['kdper'] == "Pilih Kode Periksa"){
					$type = "error";
					$judul = "Oops. !";
					$success = "Pilih Kode Periksa Dulu !!!";
				}else{

						$kdper			= htmlspecialchars($_POST['kdper']);
						$norawat		= htmlspecialchars($_POST['norawat']);
						$tkeluar		= htmlspecialchars($_POST['tkeluar']);
						$lamainap		= htmlspecialchars($_POST['lamainap']);
						$dibayar		= htmlspecialchars($_POST['dibayar']);

						// var_dump($_POST);die();
						if($dibayar == ''){

							$type = "error";
							$judul = "Oops. !";
							$success = "Silah kan lakukan pembayaran dengan jumlah pembayaran yang ada !!!";
								
						}else{
								$totalkamar		= htmlspecialchars($_POST['totalkamar']);
								$totalsemua		= htmlspecialchars($_POST['tsemua']);
								$totalperiksa	= htmlspecialchars($_POST['ttpriksa']);
								$statusbayar	= htmlspecialchars($_POST['statusbayar']);
								if ($statusbayar<>'Lunas') {
									$ket = "pending";
									$ctt = $statusbayar;
								}else{
									$ket = "lunas";
									$ctt = "Lunas";
								}
								$bayar = array(
									'kode_periksa'	=> $kdper, 
									'tanggal_keluar'	=> $tkeluar, 
									'nomer_perawatan'	=> $norawat,
									'bayar_perawatan' 	=> $dibayar,
									'lama_inap'			=> $lamainap,
									'total_kamar'		=> $totalkamar,
									'total_perawatan'	=> $totalsemua,
									'total_periksa'		=> $totalperiksa,
									'status_bayar'		=> $ket,
									'notes'				=> $ctt
								);

								$ac  = implode(", ",array_keys($bayar));
								$av  = "'" . implode ( "', '", array_values($bayar)) . "'";
								$anotes = $DB_con->prepare("INSERT INTO tbl_pembayaran($ac) VALUES ($av)");
								$anotes->execute();

								$up = $DB_con->prepare("UPDATE tbl_perawatan SET setpas='1' WHERE nomer_perawatan = $norawat");
								$up->execute();

								if($anotes){									
									$type = "success";
									$judul = $norawat;
									$success = "bayar";
								 }else{ 
									$type = "error";
									$judul = "Oops. !";
									$success = "Pembayaran gagall !!!";
								}
						}
				}
				
	}

// ubah data
if(isset($_POST['btn-upembayaran'])){
	// var_dump($_POST);die();
		$idpem 			= $_POST['nopem'];
		$norawat 		= $_POST['norawat'];
		$tsemua 		= htmlspecialchars($_POST['tsemua']);
		$statusbayar	= htmlspecialchars($_POST['statusbayar']);
			if ($statusbayar<>'Lunas') {
				$ket = "pending";
				$ctt = $statusbayar;
			}else{
				$ket = "lunas";
				$ctt = "Lunas";
			}

		$dibayar		= $_POST['dibayar'];

	if(empty($_POST['dibayar'])){
		$type = "error";
		$judul = "Oops. !";
		$success = "Harap bayar !!!";
	}elseif($dibayar < $tsemua ){
		$type = "error";
		$judul = "Oops. !";
		$success = "Pembayaran kurang !!!";
	}else{		
	
		$query = $DB_con->prepare("UPDATE tbl_pembayaran SET
					bayar_perawatan = $dibayar,
					status_bayar = '$ket',
					notes = '$ctt'
					WHERE 
					nomer_pembayaran = $idpem 
				");
		$result = $query->execute();
			if($result){

						$type = "success";
						$judul = $norawat;
						$success = "ubayar";
					 }else{ 
						$type = "error";
						$judul = "Oops. !";
						$success = "Pembayaran gagall di ubah!!!";
			}

	}
}

// hpas data
if(isset($_POST['btn-hpuspem']))
{

	$did 		= $_POST['did'];
	$dodelete 	= $DB_con->prepare("DELETE FROM tbl_pembayaran WHERE nomer_pembayaran='$did'");
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
		<form class="form-horizontal"  method="post">
			<div class="row">
				<div class="col-lg-6">
					<div class="row flex-row">
						<div class="col-12">
							<div class="widget has-shadow">
								<div class="widget-header bg-primary bordered no-actions d-flex align-items-center">
									<h4 class="text-white">Pembayaran</h4>
								</div>
								<div class="widget-body">
									<div class="form-group row d-flex align-items-center mb-5 has-info">
										<label class="col-lg-3 form-control-label">No Pembayaran</label>
										<div class="col-sm-9">
											<input type="text" name="nopem" id="nopem" class="form-control" readonly value="<?php 
										$list = $DB_con->prepare("SELECT MAX(nomer_pembayaran) as top FROM tbl_pembayaran");
										$list->execute();$idp =$list->fetch();
										echo $idp['top']+1;?> ">
										</div>
									</div>
									<div class="form-group row d-flex align-items-center mb-5 has-info">
										<label class="col-lg-3 form-control-label">Tanggal Pembayaran</label>
										<div class="col-sm-9">
											<input name="tanggal_check" type="text" id="tbayar" class="form-control"  placeholder="Tanggal" value="<?php echo $date;?>" readonly>
										</div>
									</div>
									<div class="form-group row d-flex align-items-center mb-5 has-info">
										<label class="col-lg-3 form-control-label">Kode Periksa</label>
										<div class="col-sm-9">
											<?php 
											$pem = $DB_con->prepare("SELECT
												* , tbp.tgl_periksa as masuk
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
											$pem->execute();

											// var_dump($kamar->fetch(PDO::FETCH_ASSOC));die();
											?>

											<input type="text" name="nreg" id="nreg" style="display: none;" class="form-control" readonly="">
											<select class="form-control" name="kdper" id="kdper">
												<option selected >Pilih Kode Periksa</option>
												<?php while ($rows=$pem->fetch(PDO::FETCH_ASSOC)){
													// cari data periksa
													$kdperiksa = $rows['kode_periksa'];
													$bperiksa = $DB_con->prepare("SELECT * FROM 
																		tbl_periksa tbp,
																		tbl_dokter tdok,
																		tbl_tindakan tdak,
																		tbl_alat talt
																		WHERE 
																		tbp.kode_dokter = tdok.kode_dokter
																		AND tbp.kode_tindakan = tdak.kode_tindakan
																		AND tbp.kode_alat = talt.kode_alat
																		AND tbp.kode_periksa = '$kdperiksa' ");
													$bperiksa->execute();
													$trf = $bperiksa->fetch(PDO::FETCH_ASSOC);
													
													$ttlper = (int)$trf['tarif_dokter']+(int)$trf['tarif_tindakan']+(int)$trf['tarif_alat'];
													$disc = $ttlper-($ttlper*75/100);

													// total obat waktu di periksa
													$trobt = $DB_con->prepare("SELECT * FROM 
																		det_obat trobt,
																		tbl_obat tblobt
																		WHERE 
																		trobt.kode_obat = tblobt.kode_obat
																		AND trobt.kode_periksa = '$kdperiksa' ");
													$trobt->execute();
													$sttlobatp = 0;

													while($ttlobt = $trobt->fetch(PDO::FETCH_ASSOC)){
														$sttlobatp += (int)$ttlobt['tarif_obat'];
													}
														$tbiayaobat = $sttlobatp;
														$ttlpriksa = $tbiayaobat+$disc;
													?>
													<option value="<?php echo $rows['kode_periksa'];?>" 
														data-nama="<?php echo $rows['nama_pasien'];?>" 
														data-kode="<?php echo $rows['nomer_perawatan'];?>" 
														data-kkamar="<?php echo $rows['kode_kamar'];?>" 
														data-nkamar="<?php echo $rows['nama_kamar'];?>" 
														data-tkamar="<?php echo $rows['tarif_kamar'];?>"
														data-kmasuk="<?php echo $rows['masuk'];?>"
														data-kkeluar="<?php echo $rows['tgl_perawatan'];?>"
														data-tobat="<?php echo $rows['total_obat'];?>" 
														data-ttindak="<?php echo $rows['total_tindakan'];?>" 
														data-tdokter="<?php echo $rows['total_dokter'];?>"
														data-talat="<?php echo $rows['total_alat'];?>"

														data-tpriksa="<?php echo $ttlpriksa;?>"
														data-tsemua="<?php echo $rows['total_semua'];?>">
														<?php echo $rows['kode_periksa'].'-'.$rows['nama_pasien'];?></option>

													<?php }?>
												</select>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-5 has-info">
											<label class="col-lg-3 form-control-label">Tgl Masuk</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="kmasuk" placeholder="yyyy-mm-dd" readonly>
												<input type="hidden" name="norawat" class="form-control" id="kodep" placeholder="0" readonly>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-5 has-info">
											<label class="col-lg-3 form-control-label">Nama Pasien</label>
											<div class="col-sm-9">
												<input type="text" id="namap" class="form-control" placeholder="nama pasien" readonly>
											</div>
										</div>
										
										<div class="form-group row d-flex align-items-center mb-5 has-info">
											<label class="col-lg-3 form-control-label">Nama Ruangan</label>
											<div class="col-sm-9">
												<input type="hidden" class="form-control" id="kkamar" readonly>
												<input type="text" class="form-control" id="nkamar" placeholder="nama ruangan" readonly>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-5 has-info">
											<label class="col-lg-3 form-control-label">Tarif Ruangan</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="tkamar" placeholder="0" readonly>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-5 has-info">
											<label class="col-lg-3 form-control-label">Tgl Keluar</label>
											<div class="col-sm-9">
												<input type="text" name="tkeluar" class="form-control" id="kkeluar" placeholder="yyyy-mm-dd" readonly>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-5 has-info">
											<label class="col-lg-3 form-control-label">Lama inap (Hari)</label>
											<div class="col-sm-9">
												<input type="text" name="lamainap" class="form-control" id="lama" placeholder="0" readonly>
											</div>
										</div>
										<div class="form-group row d-flex align-items-center mb-5 has-info">
											<label class="col-lg-3 form-control-label">Total Biaya Inap</label>
											<div class="col-sm-9">
												<input type="text" name="totalkamar" class="form-control" id="totkamar" placeholder="0" readonly>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="row flex-row">
							<div class="col-12">
								<div class="widget has-shadow">
									<div class="widget-header bg-primary bordered no-actions d-flex align-items-center">
										<h4 class="text-white">Pembayaran</h4>
									</div>
									<div class="widget-body">
										<form class="form-horizontal">
											<div class="form-group row d-flex align-items-center mb-5 has-info">
												<label class="col-lg-3 form-control-label">Total Biaya Periksa</label>
												<div class="col-sm-9">
													<input type="number" class="form-control" id="ttpriksa" name="ttpriksa" placeholder="0" readonly>
												</div>
											</div>

											<div class="form-group row d-flex align-items-center mb-5 has-info">
												<label class="col-lg-3 form-control-label">Biaya Alat Perawatan</label>
												<div class="col-sm-9">
													<input type="number" class="form-control" id="talat" name="talat" placeholder="0" readonly>
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-5 has-info">
												<label class="col-lg-3 form-control-label">Biaya Dokter Perawatan</label>
												<div class="col-sm-9">
													<input type="number" class="form-control" id="tdokter" name="tdokter" placeholder="0" readonly>
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-5 has-info">
												<label class="col-lg-3 form-control-label">Biaya Obat Perawatan</label>
												<div class="col-sm-9">
													<input type="number" class="form-control" id="tobat" name="tobat" placeholder="0" readonly>
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-5 has-info">
												<label class="col-lg-3 form-control-label">Biaya Tindakan Perawatan</label>
												<div class="col-sm-9">
													<input type="number" class="form-control" id="ttindak" name="ttindak" placeholder="0" readonly>
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-5 has-info">
												<label class="col-lg-3 form-control-label">Sub Total</label>
												<div class="col-sm-9">
													<input type="number" class="form-control" id="tsemua" name="tsemua" placeholder="0" readonly>
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-5 has-info">
												<label class="col-lg-3 form-control-label">Dibayar</label>
												<div class="col-sm-9">
													<input type="number" name="dibayar" id="bayar" class="form-control" onkeyup="HitungDiskon();" placeholder="0" >
												</div>
											</div>
											<div id="xharus" class="form-group row d-flex align-items-center mb-5 has-info">
												<label  class="col-lg-3 form-control-label stts">Kurang/Kembali</label>
												<div class="col-sm-9">
													<input type="number" id="harus" class="form-control" placeholder="0" readonly>
												</div>
											</div>
											<div class="form-group row d-flex align-items-center mb-5 has-info fstatus">
												<label class="col-lg-3 form-control-label">Status Pembayaran</label>
												<div class="col-sm-9">
													<input type="text" name="statusbayar" id="fstatus" class="form-control"placeholder="status" readonly>
												</div>
											</div>
											<button name="btn-pembayaran" class="save savpem btn btn-primary mr-1 mb-5 pull-right"><i class="la la-pencil"></i>Bayar</button>
											<button name="btn-upembayaran" class="upem btn btn-primary mr-1 mb-5 pull-right"><i class="la la-pencil"></i>Ubah</button>
											<button class="bcancel btn btn-warning mr-1 mb-5 pull-right" style="display: none;"><i class="la la-close"></i>Batal</button>
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

	<!-- list content -->
		<div class="row">
			<div class="col-lg-12">
				<!-- Sorting -->
				<div class="widget has-shadow">
					<div class="widget-header bordered no-actions d-flex align-items-center">
						<h4>List pembayaran pasien</h4>
						<div class="col col-xs-6 text-right">
						</div>
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="sorting-table" class="table mb-0">
								<thead>
									<tr>
										<th>No</th>
										<th>Kode Pasien</th>
										<th>Nama Pasien</th>
										<th>Tanggal Pembayaran</th>
										<th>Lama Inap</th>
										<th>Pembayaran</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
								</thead>
								
								<tbody>
									<?php 
									$pemb = $DB_con->prepare("SELECT * FROM tbl_pembayaran 
									  	ORDER BY nomer_pembayaran DESC ");
									$pemb->execute();
									$no = 1;
									while (
										$upd = $pemb->fetch(PDO::FETCH_ASSOC)){


											$nrwt = $upd['nomer_perawatan'];

										
											$kombin = $DB_con->prepare("SELECT * , tbp.tgl_periksa as masuk, mr.tgl_perawatan as keluar
														FROM tbl_perawatan mr,
														tbl_pasien mp,
														tbl_kamar mk,
														tbl_periksa tbp
														WHERE mr.kode_pasien = mp.kode_pasien
														AND mr.kode_kamar = mk.kode_kamar
														AND mr.kode_periksa = tbp.kode_periksa
														AND mr.nomer_perawatan = '$nrwt' ");
											$kombin->execute();

										while(	$kombinasi = $kombin->fetch(PDO::FETCH_ASSOC)){ ?>
										<tr>
											 <td><span class="text-primary"><?php echo $no; ?></span></td> 
											 <td><span class="text-primary">PSN<?php echo $kombinasi['kode_pasien']?></span></td> 
											<td><span class="text-primary"><?php echo $kombinasi['nama_pasien']?></span></td>
											<td><span class="text-primary">
												<?php 
												$dt = $upd['tanggal_pembayaran'];
												$tgl = substr($dt, 0, 10);
												echo $tgl;
												?>
											</span></td>
											<td><span class="text-primary"><?php echo $upd['lama_inap'];?></span></td>
											<td><span class="text-primary">Rp. <?php echo number_format($upd['total_perawatan']);?></span></td>
											<?php 
											$note = $upd['notes'];
											$patterna = '/([^0-9]+)/';
											$patternh = '/([^a-zA-Z]+)/';
											$patternl = '/([^Lunas]+)/';
											$hslh = preg_replace($patternh,'',$note);
											$lns = preg_replace($patternl,'',$note);
											$hsla = intval(preg_replace($patterna,'',$note));
											$angka = number_format($hsla);

											if($upd['notes'] == 'Lunas'): ?>
												<td><span class="text-primary"><?= $lns; ?></span></td>
											<?php else : ?>
												<td><span class="text-primary"><?= $hslh.'<br>Rp. '.$angka; ?></span></td>
											<?php endif;

											?>

											<td class="td-actions text-center">
												  <a href="#" class="pemubah" 
												  	data-id="<?php echo $upd['nomer_pembayaran']?>" 
												  	data-tbayar="<?= $upd['tanggal_pembayaran'] ?>" 
												  	data-nreg="<?= $upd['kode_periksa'] ?>" 
												  	data-masuk="<?= $kombinasi['masuk'] ?>" 
												  	data-norawat="<?= $kombinasi['nomer_perawatan'] ?>"
												  	data-nmpasien="<?= $kombinasi['nama_pasien'] ?>" 
												  	data-nmkamar="<?= $kombinasi['nama_kamar'] ?>" 
												  	data-tkmar="<?= $kombinasi['tarif_kamar'] ?>" 
												  	data-tkeluar="<?= $kombinasi['keluar'] ?>" 
												  	data-linap="<?= $upd['lama_inap'] ?>" 
												  	data-ttkmar="<?= $upd['total_kamar'] ?>" 
												  	data-ttalat="<?= $kombinasi['total_alat'] ?>" 
												  	data-ttdokter="<?= $kombinasi['total_dokter'] ?>" 
												  	data-ttobat="<?= $kombinasi['total_obat'] ?>" 
												  	data-tttindakan="<?= $kombinasi['total_tindakan'] ?>" 
												  	data-ttperiksa="<?= $upd['total_periksa'] ?>" 
												  	data-subtotal="<?= $upd['total_perawatan'] ?>" 
												  	data-bayar="<?= $upd['bayar_perawatan'] ?>" 
												  	data-note="<?= $upd['notes'] ?>" 
												  	><i class="la la-edit edit delete"></i></a> 

												<a href="<?php echo $base_url;?>invoice&&id=<?php echo $upd['nomer_perawatan'];?>" target="_blank"><i class="la la-print more text-success"></i></a>
												
												<a href="#" class="trash" data-id="<?php echo $upd['nomer_pembayaran']?>" data-toggle="modal" data-target="#delete"><i class="la la-close delete text-danger"></i></a>
											</td>
										</tr>
										<?php 
										$no++;
										} ?>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- End Row -->
			</div>
		</div>

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
							<button type="submit" class="btn btn-danger mb-3" name="btn-hpuspem">Ok</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery.min.js"></script>
		<script type="text/javascript">
			$('.trash').click(function(){
				var id=$(this).data('id');
				document.getElementById('d_id').value = id;
			});
		</script>

<!-- ambil data saat mau bayar -->
		<script type="text/javascript">
			$('#kdper').on('change', function() {
				var nama 	= $(this).find("option:selected").data('nama');
				var kode 	= $(this).find("option:selected").data('kode');
				var kkamar 	= $(this).find("option:selected").data('kkamar');
				var nkamar 	= $(this).find("option:selected").data('nkamar');
				var tkamar 	= $(this).find("option:selected").data('tkamar');
				var kmasuk 	= $(this).find("option:selected").data('kmasuk');
				var kkeluar = $(this).find("option:selected").data('kkeluar');
				var tobat 	= $(this).find("option:selected").data('tobat');
				var ttindak = $(this).find("option:selected").data('ttindak');
				var tdokter = $(this).find("option:selected").data('tdokter');
				var talat 	= $(this).find("option:selected").data('talat');
				var tpriksa = $(this).find("option:selected").data('tpriksa');
				var tsemua 	= $(this).find("option:selected").data('tsemua');
				var oneDay 		= 24*60*60*1000;

				var firstDate 	= new Date(kmasuk);
				var secondDate 	= new Date(kkeluar);

				var diffDays = Math.round(Math.abs(( secondDate.getTime() - firstDate.getTime() )/(oneDay)));
				// alert(diffDays);
				var lama  	 = tkamar*diffDays;
				var total  	 = tsemua+lama+tpriksa;
				document.getElementById('namap').value 	= nama;
				document.getElementById('kodep').value 	= kode;
				document.getElementById('nkamar').value = nkamar;
				document.getElementById('kkamar').value = kkamar;
				document.getElementById('tkamar').value = tkamar;
				document.getElementById('kkeluar').value= kkeluar;
				document.getElementById('kmasuk').value = kmasuk;
				document.getElementById('lama').value 	= diffDays;
				document.getElementById('totkamar').value= lama;
				document.getElementById('tobat').value 	= tobat;
				document.getElementById('ttindak').value= ttindak;
				document.getElementById('talat').value 	= talat;
				document.getElementById('ttindak').value= ttindak;
				document.getElementById('tdokter').value= tdokter;

				document.getElementById('ttpriksa').value= tpriksa;
				document.getElementById('tsemua').value = total;
			});
			function HitungDiskon(){
				var harga = parseInt(document.getElementById("tsemua").value);
				var bayar = document.getElementById("bayar").value;
				var sisa  = parseInt(bayar-harga);
				if(harga > bayar){
					$('.stts').text('Kurang');
					$('#xharus').addClass('form-group row d-flex align-items-center mb-5 has-info');
					$('#xharus').show();
				}else if(harga < bayar){
					$('.stts').text('Kembali');
					$('#xharus').addClass('form-group row d-flex align-items-center mb-5 has-info');
					$('#xharus').show();
				}else if(harga == bayar){
					$('#xharus').removeClass('form-group row d-flex align-items-center mb-5 has-info');
					$('#xharus').css('display', 'none');
				}
				document.getElementById("harus").value = sisa;

				if (sisa=='0') {
					var final = 'Lunas';
				}else if(sisa<0){
					var final = 'Kurang '+Math.abs(sisa);
				}else{
					var final = 'Kembali '+Math.abs(sisa);
				}
				document.getElementById("fstatus").value = final;
			}
		</script>
		<script>
			$(document).ready(function() {
				$('.pemubah').click(function(event) {

					var uid = $(this).data('id');
					var tbayar = $(this).data('tbayar');
					var xbayar = tbayar.slice(0, 10);

					var nreg = $(this).data('nreg');
					var masuk = $(this).data('masuk');
					var norawat = $(this).data('norawat');
					var nmpasien = $(this).data('nmpasien');
					var nmkamar = $(this).data('nmkamar');
					var tkmar = $(this).data('tkmar');
					var tkeluar = $(this).data('tkeluar');
					var linap = $(this).data('linap');
					var ttkmar = $(this).data('ttkmar');
					var ttalat = $(this).data('ttalat');
					var ttdokter = $(this).data('ttdokter');
					var ttobat = $(this).data('ttobat');
					var tttindakan = $(this).data('tttindakan');
					var subtotal = $(this).data('subtotal');
					var ttpriksa = $(this).data('ttperiksa');
					var bayar = $(this).data('bayar');
					var note = $(this).data('note');

					$('#nopem').val(uid);
					$('#tbayar').val(xbayar);
					$('#nreg').val(nreg+'-'+nmpasien);
					$('#kmasuk').val(masuk);
					$('#kodep').val(norawat);
					$('#namap').val(nmpasien);
					$('#nkamar').val(nmkamar);
					$('#tkamar').val(tkmar);
					$('#kkeluar').val(tkeluar);
					$('#lama').val(linap);
					$('#totkamar').val(ttkmar);
					$('#ttpriksa').val(ttpriksa);
					$('#talat').val(ttalat);
					$('#tdokter').val(ttdokter);
					$('#tobat').val(ttobat);
					$('#ttindak').val(tttindakan);
					$('#tsemua').val(subtotal);
					$('#bayar').val(bayar);
					$('#fstatus').val(note);

					// console.log(nreg+'-'+nmpasien+' '+ttalat+' '+ttdokter+' '+ttobat+' '+tttindakan);
					
					// $('#harus').hide();
					$('#xharus').removeClass('form-group row d-flex align-items-center mb-5 has-info');
					$('#xharus').hide();

					$('#kdper').hide();
					$('#nreg').show();
					$('.savpem').fadeOut('slow/400/fast');
					$('.upem').fadeIn('slow/400/fast');
					$('.bcancel').fadeIn('slow/400/fast');
				});

				$('.bcancel').click(function(event) {
					});
				
				$('.upem').click(function(event) {
					$('.savpem').show();
					$('.upem').hide();
					$('.bcancel').hide();

				});				
			});
		</script>