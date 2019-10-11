<div class="col-xl-12 contentprint">
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
			<?php 
				include '../../dbconfig.php';
				// ambil data pasien periksa
				$kdper 	= $_GET['kdper'];
				$detper = $DB_con->prepare("SELECT * FROM
							tbl_periksa tper,
							tbl_penyakit tpen,
							tbl_pasien tpas,
							tbl_kamar tkam,
							tbl_tindakan ttdk,
							tbl_alat talt,
							tbl_dokter tdkt
							WHERE
							tper.kd_penyakit = tpen.kd_penyakit
							AND tper.kode_pasien = tpas.kode_pasien
							AND tper.kode_kamar = tkam.kode_kamar
							AND tper.kode_tindakan = ttdk.kode_tindakan
							AND tper.kode_alat = talt.kode_alat
							AND tper.kode_dokter = tdkt.kode_dokter
							AND tper.kode_periksa = '$kdper'
							");
				$detper->execute();
				$row = $detper->fetch(PDO::FETCH_ASSOC);
			 ?>
		  	<div class="row mt-3 d-flex justify-content-center ">
		  		<div class="col-md-12 shadow">
		  		<div class="row d-flex justify-content-center borderr pb-1 mb-3 ">
		  			<div class="col-md-6 mb-3 mt-3">
		  					<div class="table-responsive-md">
		  						<table class="table ">  
								  <tbody>
								    <tr>
								      <td class="satu">Kode Pasien</td>
								      <td class="dua">:</td>
								      <td id="normp" >PSN<?= $row['kode_pasien'] ?></td>
								    </tr>
								    <tr>
								      <td class="satu">Nama Pasien</td>
								      <td class="dua">:</td>
								      <td id="nmp" ><?= $row['nama_pasien'] ?></td>
								    </tr>
								    <tr>
								      <td class="satu">Tanggal Lahir</td>
								      <td class="dua">:</td>
								      <td id="tgl"><?= $row['tgl_lahir'] ?></td>
								    </tr>
								    <tr>
								      <td class="satu">Jenis Kelamin</td>
								      <td class="dua">:</td>
								      <td id="jk"><?= $row['kelamin_pasien'] ?></td>
								    </tr>
								    <tr>
								      <td class="satu">Alamat</td>
								      <td class="dua">:</td>
								      <td id="ap" ><p style="line-height: 20px !important;"><?= $row['alamat_pasien'] ?></p></td>
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
								      <td id="kmr"><?= $row['nama_kamar'] ?></td>
								    </tr>
								    <tr>
								      <td class="satu">Tanggal</td>
								      <td class="dua">:</td>
								      <td id="masuk"><?= substr($row['tgl_periksa'], 0, 10); ?></td>
								    </tr>
								    <tr>
								      <td class="satu">Telp. </td>
								      <td class="dua">:</td>
								      <td id="phone"><?= $row['telepon'] ?></td>
								    </tr>
								  </tbody>
								</table>
		  					</div>
				  	</div>
		  		</div>

		  		<div class="row d-flex justify-content-center ">
		  			<div class="col-md-12">
		  				<div class="row d-flex justify-content-start ">
		  					<div class="col-md-12">
					  			<div class="table-responsive-md">
			  						<table class="table " width="100%" >  
									  <tbody>
									    <tr>
									      <td id="satu">Keluhan</td>
									      <td class="dua">:</td>
									      <td id="nmd"><?= $row['keluhan'] ?></td>
									    </tr>
									  </tbody>
									</table>
			  					</div>
			  				</div>
		  				</div>
		  			</div>
		  		</div>

				<div class="row d-flex justify-content-center ">
					<div class="col-md-12">
		  				<div class="row d-flex justify-content-start ">
		  					<div class="col-md-12">
			  					<div class="table-responsive-md">
			  						<table class="table " width="100%" >  
									  <tbody>
									    <tr>
									      <td id="satu">Diagnosa Penyakit</td>
									      <td class="dua">:</td>
									      <td id="nmt"><?= $row['nm_penyakit'] ?></td>
									    </tr>
									  </tbody>
									</table>
			  					</div>
			  				</div>
						</div>
					</div>
				</div>

				<div class="row d-flex justify-content-center ">
					<div class="col-md-12">
		  				<div class="row d-flex justify-content-start ">
		  					<div class="col-md-12">
			  					<div class="table-responsive-md">
			  						<table class="table " width="100%" >  
									  <tbody>
									    <tr class="alat">
									      <td id="satu">Tindakan Periksa</td>
									      <td class="dua">:</td>
									      <td id="nma"><?= $row['nama_tindakan'] ?></td>
									    </tr>
									  </tbody>
									</table>
			  					</div>
			  				</div>
						</div>
					</div>
				</div>

				<div class="row d-flex justify-content-center">
					<div class="col-md-12">
		  				<div class="row d-flex justify-content-start">
		  					<div class="col-md-12">
			  					<div class="table-responsive-md">
			  						<table class="table " width="100%" >  
									  <tbody>
									    <tr>
									      <td id="satu">Alat</td>
									      <td class="dua">:</td>
									      <td id="nmo"><?= $row['nama_alat'] ?></td>
									    </tr>
									  </tbody>
									</table>
			  					</div>
			  				</div>
						</div>
					</div>
				</div>

				<div class="row d-flex justify-content-center omb">
					<div class="col-md-12">
		  				<div class="row d-flex justify-content-start">
		  					<div class="col-md-12">
			  					<div class="table-responsive-md">
			  						<table class="table " width="100%" >  
									  <tbody>
									  	<?php 

									  		$kper = $row['kode_periksa'];
									  		// data obat
											$detobt = $DB_con->prepare("SELECT * FROM
																det_obat trobt,
																tbl_obat tobt
																WHERE
																trobt.kode_obat = tobt.kode_obat
																AND trobt.kode_periksa = '$kper'
																");
											$detobt->execute();
											$obts = "";
											while ($rows = $detobt->fetch(PDO::FETCH_ASSOC)) {
											    $obts .= $rows['nama_obat']." ".$rows['catatan']."<br> ";
											} ?>
											 <tr>
										      <td id="satu">Obat yang diberikan</td>
										      <td class="dua">:</td>
										      <td id="nmo"><?= $obts; ?></td>
										    </tr>
										<?php 

									  	 ?>
									   
									  </tbody>
									</table>
			  					</div>
			  				</div>
						</div>
					</div>
				</div>
				
				<div class="row d-flex justify-content-center mb-5">
					<div class="col-md-12">
		  				<div class="row d-flex justify-content-start">
		  					<div class="col-md-12">
			  					<div class="table-responsive-md">
			  						<table class="table " width="100%" >  
									  <tbody>
									    <tr>
									      <td id="satu">Nama Dokter</td>
									      <td class="dua">:</td>
									      <td id="nmo"><?= $row['nama_dokter'] ?></td>
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
			$('.rmp').fadeOut('slow/400/fast', function() {
			});
			$('.main').fadeIn('slow/400/fast', function() {
			});
		});
	</script>