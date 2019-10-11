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
		  			<h2 class="subjudul text-primary">surat rujukan</h2>
		  		</div>
		  	</div>
		</div>
		<?php 
				include '../../dbconfig.php';

				$kdrjk 		= $_GET['kdrjk'];

				$Rjk 	= $DB_con->prepare("SELECT * FROM 
											tbl_rujukan tbr,
											tbl_perawatan tbperw,
											tbl_dokter tbdok,
											tbl_periksa tbper,
											tbl_penyakit tbpeny,
											tbl_pasien tbpas
											WHERE
											tbr.kode_perawatan = tbperw.kode_perawatan
											AND tbperw.kode_periksa = tbper.kode_periksa
											AND tbper.kd_penyakit = tbpeny.kd_penyakit
											AND tbper.kode_dokter = tbdok.kode_dokter
											AND tbperw.kode_pasien = tbpas.kode_pasien
											AND tbr.kode_rujukan='$kdrjk' ");
				$Rjk->execute();
				$rows 	= $Rjk->fetch(PDO::FETCH_ASSOC);

		 ?>
		  	<div class="row mt-3 d-flex justify-content-center ">
		  		<div class="col-md-12 shadow">
		  			<div class="row d-flex justify-content-center pb-1 mb-1">
		  			<div class="col-md-10 mb-2 mt-3">
				  		<div class="row mb-2 mt-3">
							<div class="col-md-10">
								<div class="row justify-content-start">
									<div class="col-md-8">
										<div class="" >
									<p class="text-primary" style="font-weight: bold; margin-bottom: .3px;">Kepada Yth,</p>
									<p class="text-primary" style="font-weight: bold; margin-bottom: .3px;"><?= $rows['dokter'] ?></p>
									<p class="text-primary" style="font-weight: bold;"><?= $rows['rs_rujukan'] ?></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					</div>
		  		<div class="row d-flex justify-content-center pb-1 mb-4 pemb">
		  			<div class="col-md-10 mb-2 mt-3">
		  					<div class="table-responsive-md mb-2">
		  						<table class="table"> 
		  						<p class="text-primary" style="font-weight: bold;">Dengan Hormat</p>
		  						<p class="text-primary" style="font-weight: bold;">Mohon pemeriksaan dan pengobatan lebih lanjut terhadap pasien :</p>
								  <tbody>
								    <tr class="pertr">
								      <td class="satu">Nama Pasien</td>
								      <td class="dua">:</td>
								      <td id="nmpasien" style="width: 250px !important"><?= $rows['nama_pasien']; ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Jenis Kelamin</td>
								      <td class="dua">:</td>
								      <td id="jnspas" >
								      					<?php if($rows['kelamin_pasien'] == "wanita"){
								      								echo"Perempuan";
								      						}elseif ($rows['kelamin_pasien'] == "pria") {
								      								echo 'Laki-laki';
								      						} ?>
								      </td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Tanggal Lahir</td>
								      <td class="dua">:</td>
								      <td id="tgl"><?= $rows['tgl_lahir']; ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Umur</td>
								      <td class="dua">:</td>
								      <td id="umrpas">
								      	<?php 
								      		$tgllhr = new DateTime($rows['tgl_lahir']);
											$hrini  = new DateTime('today');
											
											$thn 	= $hrini->diff($tgllhr)->y;
											$bln 	= $hrini->diff($tgllhr)->m;
											$hr 	= $hrini->diff($tgllhr)->d;

											$tahun = "";
											if($thn > 2){
												echo $thn." tahun ";
												
											}else{
												if($thn != 0){
													$tahun = $thn." tahun";
												}else{
													$tahun = "";
												}
												echo $tahun." ".$bln." bulan";
											}

								      	 ?>
								      </td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Pekerjaan</td>
								      <td class="dua">:</td>
								      <td id="pekpas"><?= $rows['pekerjaan']; ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Alamat</td>
								      <td class="dua">:</td>
								      <td id="almpas" ><p style="line-height: 20px !important;"><?= $rows['alamat_pasien']; ?></p></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">No. Telp</td>
								      <td class="dua">:</td>
								      <td id="telppas" ><?= $rows['telepon']; ?></td>
								    </tr>
								  </tbody>
								</table>
		  					</div>
			  				<p class="text-primary" style="font-weight: bold;">Pada pemeriksaan saya mendapatkan :</p>
			  				<table class="table"> 
								  <tbody>
								    <tr class="pertr">
								      <td class="satu">Keluhan</td>
								      <td class="dua">:</td>
								      <td id="nmpasien" style="width: 250px !important"><?= ucfirst($rows['keluhan']); ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Diagnosa Penyakit</td>
								      <td class="dua">:</td>
								      <td id="tgl"><?= $rows['nm_penyakit']; ?></td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Tindakan Pemeriksaan </td>
								      <td class="dua">:</td>
								      <td id="jnspas" >
								      	<?php 
								      		$nmrper = $rows['nomer_perawatan'];
								      		$detper = $DB_con->prepare("SELECT * FROM 
													det_perawatan
													WHERE
													nomer_perawatan='$nmrper'
													AND det_type='tindak' ");
											$detper->execute();

											while($row = $detper->fetch(PDO::FETCH_ASSOC)){
												echo "- ".$row['det_text']."<br><br><br>";
											}
								      	 ?>
								      </td>
								    </tr>
								    <tr class="pertr">
								      <td class="satu">Obat yang diberikan</td>
								      <td class="dua">:</td>
								      <td id="umrpas">
								      	<?php 
								      		$nmrper = $rows['nomer_perawatan'];
								      		$detper = $DB_con->prepare("SELECT * FROM 
													det_perawatan
													WHERE
													nomer_perawatan='$nmrper'
													AND det_type='obat' ");
											$detper->execute();

											while($row = $detper->fetch(PDO::FETCH_ASSOC)){
												echo "- ".$row['det_text']."<br><br><br>";
											}
								      	 ?>
								      	 
								      </td>
								    </tr>
								  </tbody>
								</table>


				
					
				<div class="row d-flex justify-content-center pb-1 mb-1" style="margin-left: 29px; ">
		  			<div class="col-lg-12 mb-2 justify-content-center">
		  					<div class="table-responsive-md kotak">
		  						<div class="row justify-content-end">
		  							<div class="col-lg-6">
										<div class="row justify-content-end mt-5" style="margin-bottom: -25	px !important; ">
											<div class="col-lg-11" style="margin-bottom: -13px !important; ">
													<p class=" text-primary" style="font-weight: bold;">Parungpanjang, <?php echo date(' d M Y'); ?></p>
											</div>
										</div>
									</div>
								</div>
								<div class="row justify-content-end">
									<div class="col-lg-6">
										<div class="row justify-content-end">
											<div class="col-lg-11">
												<div class="border-sign">
													<p class=" text-primary" style="font-weight: bold;">Hormat Kami :</p>
													<p class="text-center nama text-primary" style="font-weight: bold;"><?= $rows['nama_dokter']; ?></p>
												</div>
											</div>
										</div>
									</div>
								</div>
		  					</div>
		  			</div>
		  		</div>
		  		<div class="mb-5 mt-5 text-right tombol" style="margin-bottom: 30px">
	  				<button class="printpdp btn btn-primary mr-5 pull-right mb-5 print" onclick="window.print();">
	  					<i class="fa fa-print text-white mr-2"></i>Print
	  				</button>
	  				<button class="back btn btn-primary mr-2 pull-right mb-5">
	  					<i class="fa fa-arrow-circle-left text-white mr-2"></i>Kembali
	  				</button>
	  			</div>	
			  	</div>
		  	</div>
	    </div>
		</div>
		</div>
	</div>
	</div>

	<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery.min.js"></script>
	<!-- script kembali -->
	<script>
		$('.back').click(function(event) {
			/* Act on the event */
			$('.main').fadeIn('slow/400/fast', function() {
			});
			$('.printSr').fadeOut('slow/400/fast', function() {
			});
		});
	</script>