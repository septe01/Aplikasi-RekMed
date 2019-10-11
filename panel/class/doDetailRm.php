<?php 
	include '../../dbconfig.php';

	$idper = $_GET['id'];
	

	$list = $DB_con->prepare("SELECT
			* ,mreg.tgl_periksa AS masuk 
			,mper.tgl_perawatan AS keluar FROM 
			tbl_pasien mpas,
			tbl_kamar mkam,
			tbl_periksa mreg,
			tbl_perawatan mper
			WHERE 
			mper.kode_pasien = mpas.kode_pasien AND
			mper.kode_kamar =mkam.kode_kamar AND
			mper.kode_periksa = mreg.kode_periksa AND
			mper.nomer_perawatan = $idper
		");
		$list->execute();
		$result = $list->fetch(PDO::FETCH_ASSOC);

	// data alat
	// $alat = $DB_con->prepare("SELECT * 
	// 			    FROM det_perawatan WHERE 
	// 			    det_type = 'alat' AND
	// 			    nomer_perawatan = $idper
	// 			    order by det_type ASC ");

 //    $alat->execute();
 //    $alats = [];
 //    while($alt = $alat->fetch(PDO::FETCH_ASSOC)){
 //    	$alats[] = $alt;

 //    }

    // data dokter
    // $dokter = $DB_con->prepare("SELECT * 
				//     FROM det_perawatan WHERE 
				//     det_type = 'dokter' AND
				//     nomer_perawatan = $idper
				//     order by det_type ASC ");

    // $dokter->execute();
    // // var_dump($dokter->fetch(PDO::FETCH_ASSOC));
    // $dokters = [];
    // while($dkt = $dokter->fetch(PDO::FETCH_ASSOC)){
    // 	$dokters[] = $dkt;

    // }

    // data obat
    // $obat = $DB_con->prepare("SELECT * 
				//     FROM det_perawatan WHERE 
				//     det_type = 'obat' AND
				//     nomer_perawatan = $idper
				//     order by det_type ASC ");

    // $obat->execute();
    // $obats = [];
    // while($obt = $obat->fetch(PDO::FETCH_ASSOC)){
    // 	$obats[] = $obt;

    // }

    // data tindak
    // $tindak = $DB_con->prepare("SELECT * 
				//     FROM det_perawatan WHERE 
				//     det_type = 'tindak' AND
				//     nomer_perawatan = $idper
				//     order by det_type ASC ");

    // $tindak->execute();
    // $tindaks = [];
    // while($tdk = $tindak->fetch(PDO::FETCH_ASSOC)){
    // 	$tindaks[] = $tdk;

    // }


	// $hasil = [
	// 	$result,
	// 	$dokters,
	// 	$alats,
	// 	$obats,
	// 	$tindaks
		
	// ];

	// echo json_encode($hasil);
	// var_dump($result);

 ?>

 <div class="col-xl-12 contentprint" >
            <div class="invoice shadow">
                <div class="invoice-container">
        <div class="invoice-header">
           	<div class="row d-flex align-items-center head">
	           <div class="col d-flex justify-content-xl-start justify-content-md-start justify-content-start mb-4">
	           		<img class="imgprint" src="../main/assets/img/logo2.png" alt="logo">
	              <div class="details ml-4">                    
	               <ul>
	                  <li class="company-name">Klinik Bunda Mulya</li>
	                  <li>Jl.Somantri No.11 Mekar Mulya, Parung Panjang</li>
	                  <li>Bogor - Jawa Barat</li>
	                  <li>Telp.(021) 5978058  Fax.(021) 5977758</li>
	              </ul>
	              </div>
	          </div>
		  	</div>
		<div class="row mt-4 borderr">
		  	<div class="col-md-12 d-flex justify-content-end ">
		  		<div>
		  			<small id="" class="form-text text-muted">Print Date : <?php echo date('d M Y'); ?></small>
		  		</div>
		  	</div>
		  	<div class="col-md-12 d-flex justify-content-center">
		  		<div>
		  			<h2>Rekam Medis Pasien</h2>
		  		</div>
		  	</div>
		</div>
		  	<div class="row mt-3 d-flex justify-content-center ">
		  		<div class="col-md-12 shadow">
		  		<div class="row d-flex justify-content-center borderr pb-1 ">
		  			<div class="col-md-6 mb-3 mt-3">
		  					<div class="table-responsive-md">
		  						<table class="table ">  
								  <tbody>
								    <tr>
								      <td class="satu">Kode Pasien</td>
								      <td class="dua">:</td>
								      <td id="normp" >PSN<?= $result['kode_pasien']; ?></td>
								    </tr>
								    <tr>
								      <td class="satu">Nama Pasien</td>
								      <td class="dua">:</td>
								      <td id="nmp" ><?= $result['nama_pasien']; ?></td>
								    </tr>
								    <tr>
								      <td class="satu">Tanggal Lahir</td>
								      <td class="dua">:</td>
								      <td id="tgl" ><?= $result['tgl_lahir']; ?></td>
								    </tr>
								    <tr>
								      <td class="satu">Jenis Kelamin</td>
								      <td class="dua">:</td>
								      <td id="jk" ><?= $result['kelamin_pasien']; ?></td>
								    </tr>
								    <tr>
								      <td class="satu">Alamat</td>
								      <td class="dua">:</td>
								      <td><p style="line-height: 20px !important;" id="ap"><?= $result['alamat_pasien']; ?></p></td>
								    </tr>
								    <tr>
								      <td class="satu">Telp. </td>
								      <td class="dua">:</td>
								      <td id="phone"><?= $result['telepon']; ?></td>
								    </tr>
								  </tbody>
								</table>
		  					</div>
		  			</div>
				  	<div class="col-md-6 mb-3 mt-3">
				  		<div class="table-responsive-md">
		  						<table class="table ">  
								  <tbody>
								    <tr>
								      <td class="satu">Ruang</td>
								      <td class="dua">:</td>
								      <td id="kmr"><?= $result['nama_kamar']; ?></td>
								    </tr>
								    <tr>
								      <td class="satu">Tgl Masuk</td>
								      <td class="dua">:</td>
								      <td id="masuk"><?= substr($result['masuk'], 0, 10); ?></td>
								    </tr>
								    <tr>
								      <td class="satu">Tgl Keluar</td>
								      <td class="dua">:</td>
								      <td id="keluar"><?= substr($result['keluar'], 0, 10); ?></td>
								    </tr>
								  </tbody>
								</table>
		  					</div>
				  	</div>
		  		</div>
		  		<div class="row mt-3 d-flex justify-content-center ">
		  			<div class="col-md-12">
		  				<div class="row d-flex justify-content-start pb-1 ">
		  					<div class="col-md-12">
					  			<div class="table-responsive-md">
			  						<table class="table " width="100%" >  
									  <tbody>
									    <tr>
									      <td class="satu">Nama Dokter</td>
									      <td class="dua">:</td>
									      <td id="nmd">
									      	<?php 
									      		// data dokter
											    $dokter = $DB_con->prepare("SELECT * 
															    FROM det_perawatan WHERE 
															    det_type = 'dokter' AND
															    nomer_perawatan = $idper
															    order by det_type ASC ");

											    $dokter->execute();
											    while($dkt = $dokter->fetch(PDO::FETCH_ASSOC)){
											    	echo "- ".$dkt['det_text']."<br>";

											    }
									      	 ?>
									      </td>
									    </tr>
									  </tbody>
									</table>
			  					</div>
			  				</div>
		  				</div>
		  			</div>
		  		</div>

				<div class="row mt-3 d-flex justify-content-center ">
					<div class="col-md-12">
		  				<div class="row d-flex justify-content-start pb-1 ">
		  					<div class="col-md-12">
			  					<div class="table-responsive-md">
			  						<table class="table " width="100%" >  
									  <tbody>
									    <tr class="alat">
									      <td class="satu">Nama Alat</td>
									      <td class="dua">:</td>
									      <td id="nma">
									      	<?php 
									      		// data alat
												$alat = $DB_con->prepare("SELECT * 
															    FROM det_perawatan WHERE 
															    det_type = 'alat' AND
															    nomer_perawatan = $idper
															    order by det_type ASC ");

											    $alat->execute();
											    while($alt = $alat->fetch(PDO::FETCH_ASSOC)){
											    	echo "- ".$alt['det_text']."<br>";

											    }
									      	 ?>
									      </td>
									    </tr>
									  </tbody>
									</table>
			  					</div>
			  				</div>
						</div>
					</div>
				</div>

				<div class="row mt-3 d-flex justify-content-center ">
					<div class="col-md-12">
		  				<div class="row d-flex justify-content-start pb-1 ">
		  					<div class="col-md-12">
			  					<div class="table-responsive-md">
			  						<table class="table " width="100%" >  
									  <tbody>
									    <tr>
									      <td class="satu">Nama Tindakan</td>
									      <td class="dua">:</td>
									      <td id="nmt">
									      	<?php 
									      		 // data tindak
											    $tindak = $DB_con->prepare("SELECT * 
															    FROM det_perawatan WHERE 
															    det_type = 'tindak' AND
															    nomer_perawatan = $idper
															    order by det_type ASC ");

											    $tindak->execute();
											    while($tdk = $tindak->fetch(PDO::FETCH_ASSOC)){
											    	echo "- ".$tdk['det_text']."<br>";

											    }
									      	 ?>
									      </td>
									    </tr>
									  </tbody>
									</table>
			  					</div>
			  				</div>
						</div>
					</div>
				</div>

				<div class="row mt-3 d-flex justify-content-center mb-5">
					<div class="col-md-12">
		  				<div class="row d-flex justify-content-start pb-1 ">
		  					<div class="col-md-12">
			  					<div class="table-responsive-md">
			  						<table class="table " width="100%" >  
									  <tbody>
									    <tr>
									      <td class="satu">Nama Obat</td>
									      <td class="dua">:</td>
									      <td id="nmo">
									      	<?php 
									      		// data obat
											    $obat = $DB_con->prepare("SELECT * 
															    FROM det_perawatan WHERE 
															    det_type = 'obat' AND
															    nomer_perawatan = $idper
															    order by det_type ASC ");

											    $obat->execute();
											    while($obt = $obat->fetch(PDO::FETCH_ASSOC)){
											    	echo "- ".$obt['det_text']."<br>";
											    }
									      	 ?>
									      </td>
									    </tr>
									  </tbody>
									</table>
			  					</div>
			  				</div>
						</div>
					</div>
				</div>
	  			<div class="mb-5 text-right tombol">
	  				<button class="print btn btn-primary mr-2 pull-right mb-5" onclick="window.print();">
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

	<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery.min.js"></script>
	<script>
		$('.back').click(function(event) {
			$('.detailsrm').fadeOut('slow/400/fast', function() {
			});
			$('.perawatan').fadeIn('slow/400/fast', function() {
			});
		});
	</script>