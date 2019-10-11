<?php 
	include '../../dbconfig.php';
	// var_dump($_POST);die();

	if($_POST['ubah'] == "ubah"){
		var_dump($_POST);die();
		$kdpas		= $_POST['kdpas'];
		$kdper		= $_POST['kdper'];
		$nmpend		= htmlspecialchars($_POST['nmpend']);
		$tgllhr		= htmlspecialchars($_POST['tgllhr']);
		$jnsklm		= htmlspecialchars($_POST['jnsklm']);
		$hubungan	= htmlspecialchars($_POST['hubungan']);
		$pekerjaan	= htmlspecialchars($_POST['pekerjaan']);
		$alamat		= htmlspecialchars($_POST['alamat']);
		$tlp		= htmlspecialchars($_POST['tlp']);

		$query = $DB_con->prepare("UPDATE tbl_pendamping SET 
									nama_pendamping='$nmpend',
									tgl_lahir='$tgllhr',
									jns_kelamin='$jnsklm',
									hub_keluarga='$hubungan',
									pekerjaan='$pekerjaan',
									alamat_pendamping='$alamat',
									telp_pendamping='$tlp'
								WHERE kode_pasien='$kdpas'
								AND kode_periksa='$kdper' ");
		$query->execute();

		$per = "";
		$upPer = $DB_con->prepare("UPDATE tbl_periksa SET setper='$per' WHERE kode_periksa='$kdper' ");
		$upPer->execute();

	}elseif($_POST['ubah'] == "undefined"){

		var_dump($_POST);die();
		$kdpas		= $_POST['kdpas'];
		$kdper		= $_POST['kdper'];
		$nmpend		= htmlspecialchars($_POST['nmpend']);
		$tgllhr		= htmlspecialchars($_POST['tgllhr']);
		$jnsklm		= htmlspecialchars($_POST['jnsklm']);
		$hubungan	= htmlspecialchars($_POST['hubungan']);
		$pekerjaan	= htmlspecialchars($_POST['pekerjaan']);
		$alamat		= htmlspecialchars($_POST['alamat']);
		$tlp		= htmlspecialchars($_POST['tlp']);

		$query = $DB_con->prepare("INSERT INTO 
									tbl_pendamping(kode_pasien,kode_periksa,nama_pendamping,tgl_lahir,jns_kelamin,hub_keluarga,pekerjaan,alamat_pendamping,telp_pendamping) 
									VALUES('$kdpas','$kdper','$nmpend','$tgllhr','$jnsklm','$hubungan','$pekerjaan','$alamat','$tlp') ");
		$query->execute();

	}

// query tb pendamping
	$dpend = $DB_con->prepare("SELECT * FROM tbl_pendamping 
							WHERE 	
							kode_pasien = '$kdpas'
							AND kode_periksa = '$kdper'
							ORDER BY nomor_pendamping DESC

							");
	$dpend->execute();

// query all
	$pasdok = $DB_con->prepare("SELECT * FROM 
								tbl_periksa tper,
								tbl_dokter tdok,
								tbl_pasien tpas
								WHERE
								tper.kode_pasien = tpas.kode_pasien
								AND tper.kode_dokter = tdok.kode_dokter
								AND tper.kode_periksa = '$kdper'
								AND tpas.kode_pasien = '$kdpas'
								");
	$pasdok->execute();
	// var_dump($pasdok->fetch(PDO::FETCH_ASSOC));
	$rowall = $pasdok->fetch(PDO::FETCH_ASSOC);

	// var_dump($dpend->fetch(PDO::FETCH_ASSOC));
	$rowpend = $dpend->fetch(PDO::FETCH_ASSOC);

	function umur($tgl){
		$tgllhr = new DateTime($tgl);
		$hrini  = new DateTime('today');
		
		$thn 	= $hrini->diff($tgllhr)->y;
		$bln 	= $hrini->diff($tgllhr)->m;
		$hr 	= $hrini->diff($tgllhr)->d;

		$tahun = "";
		if($thn > 2){
			return $thn." tahun ";
			
		}else{
			if($thn != 0){
				$tahun = $thn." tahun";
			}else{
				$tahun = "";
			}
			return $tahun." ".$bln." bulan";
		}
	}

 ?>


 <div class="col-xl-12 contentprint">
            <div class="invoice shadow">
                <div class="invoice-container">
        <div class="invoice-header">
           	<div class="row d-flex align-items-center head">
	           <div class="col d-flex justify-content-xl-start justify-content-md-start justify-content-start img mb-4">
	           		<img class="imgprint imgfloat" src="../main/assets/img/logo2.png" alt="logo">
	              <div class="details text-center" style="width: 100%">                    
	               <ul>
	                  <li class="company-name judulper">Klinik Bunda Mulya</li>
	                  <li class="ket">Jl.Somantri No.11 Mekar Mulya, Parung Panjang</li>
	                  <li class="ket">Bogor - Jawa Barat</li>
	                  <li class="ket">Telp.(021) 5978058  Fax.(021) 5977758</li>
	              </ul>
	              </div>
	          </div>
		  	</div>
		<div class="row mt-5">
		  	<div class="col-md-12 d-flex justify-content-center">
		  		<div>
		  			<h2 class="subjudul"> surat persetujuan / penolakan medis khusus</h2>
		  		</div>
		  	</div>
		</div>
		  	<div class="row mt-3 d-flex justify-content-center ">
		  		<div class="col-md-12 shadow">
		  		<div class="row d-flex justify-content-center pb-1 mb-1">
		  			<div class="col-md-7 mb-2 mt-3">
		  					<div class="table-responsive-md">
		  						<table class="table"> 
		  						<p class="h3 mb-2">I. IDENTITAS PASIEN</p>
								  <tbody>
								    <tr class="pertr">
								      <td class="satu" style="width: 200px !important">Nama Pasien</td>
								      <td class="dua">:</td>
								      <td id="nmpasien"><?= ucfirst($rowall['nama_pasien']); ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Tanggal Lahir</td>
								      <td class="dua">:</td>
								      <td id="tgl"><?= $rowall['tgl_lahir']; ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Jenis Kelamin</td>
								      <td class="dua">:</td>
								      <td id="jnspas" ><?php if($rowall['kelamin_pasien'] == "wanita"){
								      								echo"Perempuan";
								      						}elseif ($rowall['kelamin_pasien'] == "pria") {
								      								echo 'Laki-laki';
								      						} ?>
								      </td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Pekerjaan</td>
								      <td class="dua">:</td>
								      <td id="pekpas"><?= ucfirst($rowall['pekerjaan']); ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Alamat</td>
								      <td class="dua">:</td>
								      <td id="almpas" ><p style="line-height: 20px !important;"><?= ucfirst($rowall['alamat_pasien']); ?></p></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">No. Telp</td>
								      <td class="dua">:</td>
								      <td id="telppas" ><?= $rowall['telepon']; ?></td>
								    </tr>
								  </tbody>
								</table>
		  					</div>
		  			</div>
				  	<div class="col-md-5 mb-3 mt-5">
				  		<div class="table-responsive-md">
		  						<table class="table mt-5" style="margin-top: 36px !important">  
								  <tbody>
								    <tr class="pertr">
								      <td class="satu text-center">Umur</td>
								      <td class="dua">:</td>
								      <td id="umrpas"><?php echo umur($rowall['tgl_lahir']); ?></td>
								    </tr>
								  </tbody>
								</table>
		  					</div>
				  	</div>
		  		</div> 

				<div class="row d-flex justify-content-center pb-1 mb-1 ">
		  			<div class="col-md-7 mb-2 mt-1">
		  					<div class="table-responsive-md">
		  						<table class="table "> 
						  		<p class="h3 mb-3">II. KELUARGA / PENANGGUNG PASIEN</p>
								  <tbody>
								    <tr class="pertr">
								      <td class="satu" style="width: 200px !important">Hub. Dengan Pasien</td>
								      <td class="dua">:</td>
								      <td id="hub"><?php  if($rowpend['hub_keluarga'] == 'orang_tua'){
								      							echo 'Orang Tua';
								      							}else{
								      								echo ucfirst($rowpend['hub_keluarga']);
								      							}
								      ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Nama Pendamping</td>
								      <td class="dua">:</td>
								      <td id="nmppend" ><?= ucfirst($rowpend['nama_pendamping']); ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Tanggal Lahir</td>
								      <td class="dua">:</td>
								      <td id="tglpend"><?= $rowpend['tgl_lahir']; ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Jenis Kelamin</td>
								      <td class="dua">:</td>
								      <td id="jnspend" ><?php  
								      						if($rowpend['jns_kelamin'] == "wanita"){
								      								echo"Perempuan";
								      						}elseif ($rowpend['jns_kelamin'] == "pria") {
								      								echo 'Laki-laki';
								      						}
								      ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Pekerjaan</td>
								      <td class="dua">:</td>
								      <td id="pekpend"><?= ucfirst($rowpend['pekerjaan']); ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Alamat</td>
								      <td class="dua">:</td>
								      <td id="almpend"><p style="line-height: 20px !important;"><?= ucfirst($rowpend['alamat_pendamping']); ?></p></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">No. Telp</td>
								      <td class="dua">:</td>
								      <td id="telppend" ><?= $rowpend['telp_pendamping']; ?></td>
								    </tr>
								  </tbody>
								</table>
		  					</div>
		  			</div>
				  	<div class="col-md-5 mb-3 mt-5">
				  		<div class="table-responsive-md">
		  						<table class="table mt-5" style="margin-top: 36px !important">  
								  <tbody>
								    <tr class="pertr">
								      <td class="satu text-center">Umur</td>
								      <td class="dua">:</td>
								      <td id="umrpend"><?php echo umur($rowpend['tgl_lahir']); ?></td>
								    </tr>
								  </tbody>
								</table>
		  					</div>
				  	</div>
		  		</div>

		  		<div class="row justify-content-center pb-1 mb-1" style="margin-left: 29px">
		  			<div class="col-md-12 mb-2 mt-1 justify-content-center">
		  					<div class="table-responsive-md isi">
		  						<!-- <table class="table ">  -->
		  						<!-- <p class="h3 mb-3">III. INFORMASI YANG DI BERIKAN</p> -->
								 <p>Dengan ini menyatakan SETUJU atau MENOLAK untuk dikukan tindakan medis berupa. . . . .</p>
								 <p>Dan bersedia untuk menanggung biaya perawatan pasien selama di Klinik Bunda Mulya</p>
								 <p>Dari penjelasan yang diberikan, telah saya mengerti segala hal yang berhubungan penyakit tersebut, serta tindakan medis yang akan dilakukan dan kemungkinan pasca tindakan yang dapat terjadi sesuai penjelasan yang diberikan.</p>
								<!-- </table> -->
		  					</div>
		  			</div>
		  		</div>
					
				<div class="row justify-content-center pb-1 mb-1 printbawah" style="margin-left: 29px; ">
		  			<div class="col-md-12 mb-2 mt-1 justify-content-center">
		  					<div class="table-responsive-md isi">
		  						<div class="row justify-content-end">
		  							<div class="col-md-6">
										<div class="row justify-content-end mt-5" style="margin-bottom: -15	px !important; ">
											<div class="col-md-8">
												<div>
													<p style="text-indent: 13px !important" class="pnm">Parungpanjang, <?php echo date(' d M Y'); ?></p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row justify-content-start">
											<div class="col-md-8">
												<div class="border-sign" >
											<p style="text-indent: 0 !important" class="text-center">Dokter</p>
											<p class="text-center nama"><?= $rowall['nama_dokter']; ?></p>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row justify-content-end">
											<div class="col-md-8">
												<div class="border-sign">
											<p style="text-indent: 0 !important" class="text-center">Yang membuat pernyataan :</p>
											<p class="text-center nama"><?= ucfirst($rowpend['nama_pendamping']); ?></p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- </table> -->
		  					</div>
		  			</div>
		  		</div>
		  		<form action="" method="post">
		  			<input type="hidden" name="kper" value="<?= $rowall['kode_periksa']; ?>">


	  			<div class="mb-5 mt-5 text-right tombol" style="margin-bottom: 30px">
	  				<button class="printpdp btn btn-primary mr-5 pull-right mb-5 print" onclick="window.print();">
	  					<i class="fa fa-print text-white mr-2"></i>Print
	  				</button>
	  				<button class="back btn btn-primary mr-2 pull-right mb-5">
	  					<i class="fa fa-arrow-circle-left text-white mr-2"></i>Kembali
	  				</button>
	  			</div>	
			  	</div>
				</form>
		  	</div>
	    </div>
		</div>
		</div>
	</div>

	<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery.min.js"></script>
	<!-- print pendamping -->
<script>
	$('.printpdp').click(function(event) {
		/* Act on the event */
		var kper = $("[name='kper']").val();
		$.ajax({
			url: 'class/setper.php',
			type: 'POST',
			data: 'kper='+kper,
			success: function() {
				// body...
				$('.main').fadeIn('slow/400/fast', function() {
				});
			}
		});		
	});
	

	$('.back').click(function(event) {
		$('.rmp').fadeOut('slow/400/fast', function() {
		});
		$('.main').fadeIn('slow/400/fast', function() {
		});
	});

</script>