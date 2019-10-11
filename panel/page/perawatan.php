<?php 
date_default_timezone_set('UTC');
$date 	= date('Y-m-d');

// tambah perawatan //
if(isset($_POST['btn-perawatan']))
{
	// var_dump($_POST);die();
	if($_POST['kdper'] === "Pilih Kode Periksa"){
						$type = "error";
						$judul = "Oops. !";
						$success = "Pilih kode periksa dulu !!!";
	}elseif($_POST['kdper'] !== "Pilih Kode periksa"){
		// var_dump($_POST);die();
		$kd	= htmlspecialchars($_POST['kd_rawat']);
		$patterna = '/([^0-9]+)/';
		$kd_perawatan = preg_replace($patterna,'',$kd);

		$tanggal_check	= htmlspecialchars($_POST['tanggal_check']);
		$no_pasien		= htmlspecialchars($_POST['no_pasien']);
		$kode_kamar		= htmlspecialchars($_POST['kode_kamar']);

		$tarifalat		= htmlspecialchars($_POST['tarifalat']);
		$tarifdokter	= htmlspecialchars($_POST['tarifdokter']);
		$tarifobat		= htmlspecialchars($_POST['tarifobat']);
		$tariftindakan	= htmlspecialchars($_POST['tariftindakan']);
		$totaltarif		= htmlspecialchars($_POST['totaltarif']);

		$name 			= explode("-",htmlspecialchars($_POST['kdper']));
		$jml_segmen 	= count($name);
		$item_id 		= $name[$jml_segmen-2];
		// var_dump($item_id);die();
		$kkamar			= htmlspecialchars($_POST['kode_kamar']);

		$rawat = array(
			'kode_perawatan'	=> $kd_perawatan, 
			'kode_periksa'	=> $item_id, 
			'kode_pasien' 		=> $no_pasien,
			'kode_kamar'		=> $kkamar,
			'total_alat'		=> $tarifalat,
			'total_dokter'		=> $tarifdokter,
			'total_obat'		=> $tarifobat,
			'total_tindakan'	=> $tariftindakan,
			'total_semua'		=> $totaltarif
		);

		$nrc  = implode(", ",array_keys($rawat));
		$nrv  = "'" . implode ( "', '", array_values($rawat)) . "'";
		
		$notes = $DB_con->prepare("INSERT INTO tbl_perawatan($nrc) VALUES ($nrv)");
		$notes->execute();
		if($notes){
						$type = "success";
						$judul = "Congratulations !";
						$success = "perawatan success !!!";
					 }else{ 
						$type = "error";
						$judul = "Oops. !";
						$success = "perawatan gagal di input !!!";
			}

		$list = $DB_con->prepare("SELECT MAX(nomer_perawatan) as top FROM tbl_perawatan");
		$list->execute();$idp =$list->fetch();
		$nidp =$idp['top'];

		// jika tidak pilih alat dokter obat & tindakan
		if(empty($_POST['ida']) && empty($_POST['idd']) && empty($_POST['ido']) && empty($_POST['idt'])){
			
			$talat			= ' ';
			$halat			= 0;

	
			$det_rawat		= $nidp;
			$det_type    	= 'alat';
			$det_text     	= $talat;
			$det_harga    	= $halat;

			$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
			$anotes->execute();

			// dokter
			$tdokter		= ' ';
			$hdokter		= 0;

			$det_rawat		= $nidp;
			$det_type    = 'dokter';
			$det_text     = $tdokter;
			$det_harga     = $hdokter;

			$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
			$anotes->execute();

			// obat
			$tobat		= ' ';
			$hobat		= 0;

			$det_rawat		= $nidp;
			$det_type    = 'obat';
			$det_text     = $tobat;
			$det_harga     = $hobat;

			$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
			$anotes->execute();

			// tindakan
			$ttindakan		= ' ';
			$htindakan		= 0;

			$det_rawat		= $nidp;
			$det_type    = 'tindak';
			$det_text     = $ttindakan;
			$det_harga     = $htindakan;

			$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
			$anotes->execute();
			

			// ======== kurangi space kamar ============= //
			$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
			$min->execute();
			$rowm = $min->fetch();

			$baru = $rowm['isi_kamar']-1;
			$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
			$menus->execute();
			// ========================================= //

			$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
			$deactive->execute();


			
			// jika hanya pilih alat aja
		}elseif(!empty($_POST['ida']) && empty($_POST['idd']) && empty($_POST['ido']) && empty($_POST['idt'])){

				$ialat			= $_POST['ida'];
				$talat			= $_POST['txa'];
				$halat			= $_POST['harga'];

				foreach ($ialat as $key => $p) {
					$data_alat = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'alat',
						'det_text'      => htmlspecialchars($talat[$key]),
						'det_harga'     => htmlspecialchars($halat[$key])
					);
					$ac  = implode(", ",array_keys($data_alat));
					$av  = "'" . implode ( "', '", array_values($data_alat)) . "'";
					$anotes = $DB_con->prepare("INSERT INTO det_perawatan($ac) VALUES ($av)");
					$anotes->execute();

				}


				// dokter
				$tdokter		= ' ';
				$hdokter		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'dokter';
				$det_text     = $tdokter;
				$det_harga     = $hdokter;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();

				// obat
				$tobat		= ' ';
				$hobat		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'obat';
				$det_text     = $tobat;
				$det_harga     = $hobat;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();

				// tindakan
				$ttindakan		= ' ';
				$htindakan		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'tindak';
				$det_text     = $ttindakan;
				$det_harga     = $htindakan;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();

				// jika hanya pilih dokter saja
			}elseif(empty($_POST['ida']) && !empty($_POST['idd']) && empty($_POST['ido']) && empty($_POST['idt'])){

				$talat			= ' ';
				$halat			= 0;

		
				$det_rawat		= $nidp;
				$det_type    = 'alat';
				$det_text     = $talat;
				$det_harga     = $halat;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();


				// dokter
				$idokter		= $_POST['idd'];
				$tdokter		= $_POST['txd'];
				$hdokter		= $_POST['hargadokter'];
				foreach ($idokter as $dok => $p) {
					$data_dokter = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'dokter',
						'det_text'      => htmlspecialchars($tdokter[$dok]),
						'det_harga'     => htmlspecialchars($hdokter[$dok])
					);
					$dc  = implode(", ",array_keys($data_dokter));
					$dv  = "'" . implode ( "', '", array_values($data_dokter)) . "'";
					$dnotes = $DB_con->prepare("INSERT INTO det_perawatan($dc) VALUES ($dv)");
					$dnotes->execute();
					// var_dump($data_dokter);die();
				}

				// obat
				$tobat		= ' ';
				$hobat		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'obat';
				$det_text     = $tobat;
				$det_harga     = $hobat;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();

				// tindakan
				$ttindakan		= ' ';
				$htindakan		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'tindak';
				$det_text     = $ttindakan;
				$det_harga     = $htindakan;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();

			// jika hanya pilih obat saja
			}elseif(empty($_POST['ida']) && empty($_POST['idd']) && !empty($_POST['ido']) && empty($_POST['idt'])){

				$talat			= ' ';
				$halat			= 0;

		
				$det_rawat		= $nidp;
				$det_type    = 'alat';
				$det_text     = $talat;
				$det_harga     = $halat;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();


				// dokter
				$tdokter		= ' ';
				$hdokter		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'dokter';
				$det_text     = $tdokter;
				$det_harga     = $hdokter;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();

				// obat
				$iobat			= $_POST['ido'];
				$tobat			= $_POST['txo'];
				$hobat			= $_POST['hargaobat'];
				foreach ($iobat as $bat => $p) {
					$data_obat = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'obat',
						'det_text'      => htmlspecialchars($tobat[$bat]),
						'det_harga'     => htmlspecialchars($hobat[$bat])
					);
					$oc  = implode(", ",array_keys($data_obat));
					$ov  = "'" . implode ( "', '", array_values($data_obat)) . "'";
					$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
					$onotes->execute();

					// var_dump($data_obat);die();

					}

				// tindakan
				$ttindakan		= ' ';
				$htindakan		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'tindak';
				$det_text     = $ttindakan;
				$det_harga     = $htindakan;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();

				// jika hanya pilih tindakan saja
			}elseif(empty($_POST['ida']) && empty($_POST['idd']) && empty($_POST['ido']) && !empty($_POST['idt'])){

				$talat			= ' ';
				$halat			= 0;

		
				$det_rawat		= $nidp;
				$det_type    = 'alat';
				$det_text     = $talat;
				$det_harga     = $halat;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();


				// dokter
				$tdokter		= ' ';
				$hdokter		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'dokter';
				$det_text     = $tdokter;
				$det_harga     = $hdokter;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();

				// obat
				$tobat		= ' ';
				$hobat		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'obat';
				$det_text     = $tobat;
				$det_harga     = $hobat;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();

				// tindakan
				$itindakan			= $_POST['idt'];
				$ttindakan			= $_POST['txt'];
				$htindakan			= $_POST['hargatindak'];
				foreach ($itindakan as $tdk => $p) {
					$data_tindakan = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'tindak',
						'det_text'      => htmlspecialchars($ttindakan[$tdk]),
						'det_harga'     => htmlspecialchars($htindakan[$tdk])
					);
					$oc  = implode(", ",array_keys($data_tindakan));
					$ov  = "'" . implode ( "', '", array_values($data_tindakan)) . "'";
					$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
					$onotes->execute();

					// var_dump($data_obat);die();
					}
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();
			
			// jika pilih alat dan dokter saja
			}elseif(!empty($_POST['ida']) && !empty($_POST['idd']) && empty($_POST['ido']) && empty($_POST['idt'])){

				$ialat			= $_POST['ida'];
				$talat			= $_POST['txa'];
				$halat			= $_POST['harga'];

				foreach ($ialat as $key => $p) {
					$data_alat = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'alat',
						'det_text'      => htmlspecialchars($talat[$key]),
						'det_harga'     => htmlspecialchars($halat[$key])
					);
					$ac  = implode(", ",array_keys($data_alat));
					$av  = "'" . implode ( "', '", array_values($data_alat)) . "'";
					$anotes = $DB_con->prepare("INSERT INTO det_perawatan($ac) VALUES ($av)");
					$anotes->execute();

				}

				$idokter		= $_POST['idd'];
				$tdokter		= $_POST['txd'];
				$hdokter		= $_POST['hargadokter'];
				foreach ($idokter as $dok => $p) {
					$data_dokter = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'dokter',
						'det_text'      => htmlspecialchars($tdokter[$dok]),
						'det_harga'     => htmlspecialchars($hdokter[$dok])
					);
					$dc  = implode(", ",array_keys($data_dokter));
					$dv  = "'" . implode ( "', '", array_values($data_dokter)) . "'";
					$dnotes = $DB_con->prepare("INSERT INTO det_perawatan($dc) VALUES ($dv)");
					$dnotes->execute();
					// var_dump($data_dokter);die();
				}

				// obat
				$tobat		= ' ';
				$hobat		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'obat';
				$det_text     = $tobat;
				$det_harga     = $hobat;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();

				// tindakan
				$ttindakan		= ' ';
				$htindakan		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'tindak';
				$det_text     = $ttindakan;
				$det_harga     = $htindakan;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();
			
			// jika pilih obat dan tindakan saja
			}elseif(empty($_POST['ida']) && empty($_POST['idd']) && !empty($_POST['ido']) && !empty($_POST['idt'])){

				$talat			= ' ';
				$halat			= 0;

		
				$det_rawat		= $nidp;
				$det_type    = 'alat';
				$det_text     = $talat;
				$det_harga     = $halat;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();


				// dokter
				$tdokter		= ' ';
				$hdokter		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'dokter';
				$det_text     = $tdokter;
				$det_harga     = $hdokter;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();

				$iobat			= $_POST['ido'];
				$tobat			= $_POST['txo'];
				$hobat			= $_POST['hargaobat'];
				foreach ($iobat as $bat => $p) {
					$data_obat = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'obat',
						'det_text'      => htmlspecialchars($tobat[$bat]),
						'det_harga'     => htmlspecialchars($hobat[$bat])
					);
					$oc  = implode(", ",array_keys($data_obat));
					$ov  = "'" . implode ( "', '", array_values($data_obat)) . "'";
					$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
					$onotes->execute();

					// var_dump($data_obat);die();

					}

				// tindakan
				$itindakan			= $_POST['idt'];
				$ttindakan			= $_POST['txt'];
				$htindakan			= $_POST['hargatindak'];
				foreach ($itindakan as $tdk => $p) {
					$data_tindakan = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'tindak',
						'det_text'      => htmlspecialchars($ttindakan[$tdk]),
						'det_harga'     => htmlspecialchars($htindakan[$tdk])
					);
					$oc  = implode(", ",array_keys($data_tindakan));
					$ov  = "'" . implode ( "', '", array_values($data_tindakan)) . "'";
					$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
					$onotes->execute();

					// var_dump($data_obat);die();
					}
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();
			
			// jika hanya pilih alat dan obat
			}elseif(!empty($_POST['ida']) && empty($_POST['idd']) && !empty($_POST['ido']) && empty($_POST['idt'])){

				$ialat			= $_POST['ida'];
				$talat			= $_POST['txa'];
				$halat			= $_POST['harga'];

				foreach ($ialat as $key => $p) {
					$data_alat = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'alat',
						'det_text'      => htmlspecialchars($talat[$key]),
						'det_harga'     => htmlspecialchars($halat[$key])
					);
					$ac  = implode(", ",array_keys($data_alat));
					$av  = "'" . implode ( "', '", array_values($data_alat)) . "'";
					$anotes = $DB_con->prepare("INSERT INTO det_perawatan($ac) VALUES ($av)");
					$anotes->execute();

				}


				// dokter
				$tdokter		= ' ';
				$hdokter		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'dokter';
				$det_text     = $tdokter;
				$det_harga     = $hdokter;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();


				$iobat			= $_POST['ido'];
				$tobat			= $_POST['txo'];
				$hobat			= $_POST['hargaobat'];
				foreach ($iobat as $bat => $p) {
					$data_obat = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'obat',
						'det_text'      => htmlspecialchars($tobat[$bat]),
						'det_harga'     => htmlspecialchars($hobat[$bat])
					);
					$oc  = implode(", ",array_keys($data_obat));
					$ov  = "'" . implode ( "', '", array_values($data_obat)) . "'";
					$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
					$onotes->execute();

					// var_dump($data_obat);die();

					}

				// tindakan
				$ttindakan		= ' ';
				$htindakan		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'tindak';
				$det_text     = $ttindakan;
				$det_harga     = $htindakan;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();

			// jika hanya pilih dokter dan tindakan saja
			}elseif(empty($_POST['ida']) && !empty($_POST['idd']) && empty($_POST['ido']) && !empty($_POST['idt'])){

				$talat			= ' ';
				$halat			= 0;

		
				$det_rawat		= $nidp;
				$det_type    = 'alat';
				$det_text     = $talat;
				$det_harga     = $halat;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();


				// dokter
				$idokter		= $_POST['idd'];
				$tdokter		= $_POST['txd'];
				$hdokter		= $_POST['hargadokter'];
				foreach ($idokter as $dok => $p) {
					$data_dokter = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'dokter',
						'det_text'      => htmlspecialchars($tdokter[$dok]),
						'det_harga'     => htmlspecialchars($hdokter[$dok])
					);
					$dc  = implode(", ",array_keys($data_dokter));
					$dv  = "'" . implode ( "', '", array_values($data_dokter)) . "'";
					$dnotes = $DB_con->prepare("INSERT INTO det_perawatan($dc) VALUES ($dv)");
					$dnotes->execute();
					// var_dump($data_dokter);die();
				}


				// obat
				$tobat		= ' ';
				$hobat		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'obat';
				$det_text     = $tobat;
				$det_harga     = $hobat;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();

				
				// tindakan
				$itindakan			= $_POST['idt'];
				$ttindakan			= $_POST['txt'];
				$htindakan			= $_POST['hargatindak'];
				foreach ($itindakan as $tdk => $p) {
					$data_tindakan = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'tindak',
						'det_text'      => htmlspecialchars($ttindakan[$tdk]),
						'det_harga'     => htmlspecialchars($htindakan[$tdk])
					);
					$oc  = implode(", ",array_keys($data_tindakan));
					$ov  = "'" . implode ( "', '", array_values($data_tindakan)) . "'";
					$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
					$onotes->execute();

					// var_dump($data_obat);die();
					}
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();
			
			// jika hanya pilih alat dan tindakan saja
			}elseif(!empty($_POST['ida']) && empty($_POST['idd']) && empty($_POST['ido']) && !empty($_POST['idt'])){

				$ialat			= $_POST['ida'];
				$talat			= $_POST['txa'];
				$halat			= $_POST['harga'];

				foreach ($ialat as $key => $p) {
					$data_alat = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'alat',
						'det_text'      => htmlspecialchars($talat[$key]),
						'det_harga'     => htmlspecialchars($halat[$key])
					);
					$ac  = implode(", ",array_keys($data_alat));
					$av  = "'" . implode ( "', '", array_values($data_alat)) . "'";
					$anotes = $DB_con->prepare("INSERT INTO det_perawatan($ac) VALUES ($av)");
					$anotes->execute();

				}

				// dokter
				$tdokter		= ' ';
				$hdokter		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'dokter';
				$det_text     = $tdokter;
				$det_harga     = $hdokter;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();

				// obat
				$tobat		= ' ';
				$hobat		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'obat';
				$det_text     = $tobat;
				$det_harga     = $hobat;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();
				
				// tindakan
				$itindakan			= $_POST['idt'];
				$ttindakan			= $_POST['txt'];
				$htindakan			= $_POST['hargatindak'];
				foreach ($itindakan as $tdk => $p) {
					$data_tindakan = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'tindak',
						'det_text'      => htmlspecialchars($ttindakan[$tdk]),
						'det_harga'     => htmlspecialchars($htindakan[$tdk])
					);
					$oc  = implode(", ",array_keys($data_tindakan));
					$ov  = "'" . implode ( "', '", array_values($data_tindakan)) . "'";
					$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
					$onotes->execute();

					// var_dump($data_obat);die();
					}
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();
			
			// jika hanya pilih alat, dokter dan obat
			}elseif(!empty($_POST['ida']) && !empty($_POST['idd']) && !empty($_POST['ido']) && empty($_POST['idt'])){

					$ialat			= $_POST['ida'];
					$talat			= $_POST['txa'];
					$halat			= $_POST['harga'];

					foreach ($ialat as $key => $p) {
						$data_alat = array(
							'nomer_perawatan'		=> $nidp,
							'det_type'      => 'alat',
							'det_text'      => htmlspecialchars($talat[$key]),
							'det_harga'     => htmlspecialchars($halat[$key])
						);
						$ac  = implode(", ",array_keys($data_alat));
						$av  = "'" . implode ( "', '", array_values($data_alat)) . "'";
						$anotes = $DB_con->prepare("INSERT INTO det_perawatan($ac) VALUES ($av)");
						$anotes->execute();

					}

					$idokter		= $_POST['idd'];
					$tdokter		= $_POST['txd'];
					$hdokter		= $_POST['hargadokter'];
					foreach ($idokter as $dok => $p) {
						$data_dokter = array(
							'nomer_perawatan'		=> $nidp,
							'det_type'      => 'dokter',
							'det_text'      => htmlspecialchars($tdokter[$dok]),
							'det_harga'     => htmlspecialchars($hdokter[$dok])
						);
						$dc  = implode(", ",array_keys($data_dokter));
						$dv  = "'" . implode ( "', '", array_values($data_dokter)) . "'";
						$dnotes = $DB_con->prepare("INSERT INTO det_perawatan($dc) VALUES ($dv)");
						$dnotes->execute();
						// var_dump($data_dokter);die();
					}


					// obat
					$iobat			= $_POST['ido'];
					$tobat			= $_POST['txo'];
					$hobat			= $_POST['hargaobat'];
					foreach ($iobat as $bat => $p) {
						$data_obat = array(
							'nomer_perawatan'		=> $nidp,
							'det_type'      => 'obat',
							'det_text'      => htmlspecialchars($tobat[$bat]),
							'det_harga'     => htmlspecialchars($hobat[$bat])
						);
						$oc  = implode(", ",array_keys($data_obat));
						$ov  = "'" . implode ( "', '", array_values($data_obat)) . "'";
						$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
						$onotes->execute();


						}

				
				// tindakan
				$ttindakan		= ' ';
				$htindakan		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'tindak';
				$det_text     = $ttindakan;
				$det_harga     = $htindakan;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();
			
			// jika hanya pilih dokter, obat dan tindakan
			}elseif(empty($_POST['ida']) && !empty($_POST['idd']) && !empty($_POST['ido']) && !empty($_POST['idt'])){

					$talat			= ' ';
					$halat			= 0;

			
					$det_rawat		= $nidp;
					$det_type    = 'alat';
					$det_text     = $talat;
					$det_harga     = $halat;

					$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
					$anotes->execute();

					// dokter
					$idokter		= $_POST['idd'];
					$tdokter		= $_POST['txd'];
					$hdokter		= $_POST['hargadokter'];
					foreach ($idokter as $dok => $p) {
						$data_dokter = array(
							'nomer_perawatan'		=> $nidp,
							'det_type'      => 'dokter',
							'det_text'      => htmlspecialchars($tdokter[$dok]),
							'det_harga'     => htmlspecialchars($hdokter[$dok])
						);
						$dc  = implode(", ",array_keys($data_dokter));
						$dv  = "'" . implode ( "', '", array_values($data_dokter)) . "'";
						$dnotes = $DB_con->prepare("INSERT INTO det_perawatan($dc) VALUES ($dv)");
						$dnotes->execute();
						// var_dump($data_dokter);die();
					}

					// obat
					$iobat			= $_POST['ido'];
					$tobat			= $_POST['txo'];
					$hobat			= $_POST['hargaobat'];
					foreach ($iobat as $bat => $p) {
						$data_obat = array(
							'nomer_perawatan'		=> $nidp,
							'det_type'      => 'obat',
							'det_text'      => htmlspecialchars($tobat[$bat]),
							'det_harga'     => htmlspecialchars($hobat[$bat])
						);
						$oc  = implode(", ",array_keys($data_obat));
						$ov  = "'" . implode ( "', '", array_values($data_obat)) . "'";
						$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
						$onotes->execute();

						// var_dump($data_obat);die();

						}

				
				// tindakan
				$itindakan			= $_POST['idt'];
				$ttindakan			= $_POST['txt'];
				$htindakan			= $_POST['hargatindak'];
				foreach ($itindakan as $tdk => $p) {
					$data_tindakan = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'tindak',
						'det_text'      => htmlspecialchars($ttindakan[$tdk]),
						'det_harga'     => htmlspecialchars($htindakan[$tdk])
					);
					$oc  = implode(", ",array_keys($data_tindakan));
					$ov  = "'" . implode ( "', '", array_values($data_tindakan)) . "'";
					$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
					$onotes->execute();

					// var_dump($data_obat);die();
					}
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();

			// jika hanya pilih alat, obat dan tindakan
			}elseif(!empty($_POST['ida']) && empty($_POST['idd']) && !empty($_POST['ido']) && !empty($_POST['idt'])){

					$ialat			= $_POST['ida'];
					$talat			= $_POST['txa'];
					$halat			= $_POST['harga'];

					foreach ($ialat as $key => $p) {
						$data_alat = array(
							'nomer_perawatan'		=> $nidp,
							'det_type'      => 'alat',
							'det_text'      => htmlspecialchars($talat[$key]),
							'det_harga'     => htmlspecialchars($halat[$key])
						);
						$ac  = implode(", ",array_keys($data_alat));
						$av  = "'" . implode ( "', '", array_values($data_alat)) . "'";
						$anotes = $DB_con->prepare("INSERT INTO det_perawatan($ac) VALUES ($av)");
						$anotes->execute();

					}

					// dokter
				$tdokter		= ' ';
				$hdokter		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'dokter';
				$det_text     = $tdokter;
				$det_harga     = $hdokter;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();

					// obat
					$iobat			= $_POST['ido'];
					$tobat			= $_POST['txo'];
					$hobat			= $_POST['hargaobat'];
					foreach ($iobat as $bat => $p) {
						$data_obat = array(
							'nomer_perawatan'		=> $nidp,
							'det_type'      => 'obat',
							'det_text'      => htmlspecialchars($tobat[$bat]),
							'det_harga'     => htmlspecialchars($hobat[$bat])
						);
						$oc  = implode(", ",array_keys($data_obat));
						$ov  = "'" . implode ( "', '", array_values($data_obat)) . "'";
						$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
						$onotes->execute();

						}

				
				// tindakan
				$itindakan			= $_POST['idt'];
				$ttindakan			= $_POST['txt'];
				$htindakan			= $_POST['hargatindak'];
				foreach ($itindakan as $tdk => $p) {
					$data_tindakan = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'tindak',
						'det_text'      => htmlspecialchars($ttindakan[$tdk]),
						'det_harga'     => htmlspecialchars($htindakan[$tdk])
					);
					$oc  = implode(", ",array_keys($data_tindakan));
					$ov  = "'" . implode ( "', '", array_values($data_tindakan)) . "'";
					$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
					$onotes->execute();

					// var_dump($data_obat);die();
					}
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();
			
			// jika hanya pilih alat, dokter dan tindakan
			}elseif(!empty($_POST['ida']) && !empty($_POST['idd']) && empty($_POST['ido']) && !empty($_POST['idt'])){

					$ialat			= $_POST['ida'];
					$talat			= $_POST['txa'];
					$halat			= $_POST['harga'];

					foreach ($ialat as $key => $p) {
						$data_alat = array(
							'nomer_perawatan'		=> $nidp,
							'det_type'      => 'alat',
							'det_text'      => htmlspecialchars($talat[$key]),
							'det_harga'     => htmlspecialchars($halat[$key])
						);
						$ac  = implode(", ",array_keys($data_alat));
						$av  = "'" . implode ( "', '", array_values($data_alat)) . "'";
						$anotes = $DB_con->prepare("INSERT INTO det_perawatan($ac) VALUES ($av)");
						$anotes->execute();

					}

				// dokter
				$idokter		= $_POST['idd'];
				$tdokter		= $_POST['txd'];
				$hdokter		= $_POST['hargadokter'];
				foreach ($idokter as $dok => $p) {
					$data_dokter = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'dokter',
						'det_text'      => htmlspecialchars($tdokter[$dok]),
						'det_harga'     => htmlspecialchars($hdokter[$dok])
					);
					$dc  = implode(", ",array_keys($data_dokter));
					$dv  = "'" . implode ( "', '", array_values($data_dokter)) . "'";
					$dnotes = $DB_con->prepare("INSERT INTO det_perawatan($dc) VALUES ($dv)");
					$dnotes->execute();
					// var_dump($data_dokter);die();
				}

					
					// obat
				$tobat		= ' ';
				$hobat		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'obat';
				$det_text     = $tobat;
				$det_harga     = $hobat;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();

				
				// tindakan
				$itindakan			= $_POST['idt'];
				$ttindakan			= $_POST['txt'];
				$htindakan			= $_POST['hargatindak'];
				foreach ($itindakan as $tdk => $p) {
					$data_tindakan = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'tindak',
						'det_text'      => htmlspecialchars($ttindakan[$tdk]),
						'det_harga'     => htmlspecialchars($htindakan[$tdk])
					);
					$oc  = implode(", ",array_keys($data_tindakan));
					$ov  = "'" . implode ( "', '", array_values($data_tindakan)) . "'";
					$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
					$onotes->execute();

					// var_dump($data_obat);die();
					}
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();

			// jika hanya pilih dokter dan obat saja
			}elseif(empty($_POST['ida']) && !empty($_POST['idd']) && !empty($_POST['ido']) && empty($_POST['idt'])){

					$talat			= ' ';
					$halat			= 0;

			
					$det_rawat		= $nidp;
					$det_type    = 'alat';
					$det_text     = $talat;
					$det_harga     = $halat;

					$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
					$anotes->execute();

					// dokter
					$idokter		= $_POST['idd'];
					$tdokter		= $_POST['txd'];
					$hdokter		= $_POST['hargadokter'];
					foreach ($idokter as $dok => $p) {
						$data_dokter = array(
							'nomer_perawatan'		=> $nidp,
							'det_type'      => 'dokter',
							'det_text'      => htmlspecialchars($tdokter[$dok]),
							'det_harga'     => htmlspecialchars($hdokter[$dok])
						);
						$dc  = implode(", ",array_keys($data_dokter));
						$dv  = "'" . implode ( "', '", array_values($data_dokter)) . "'";
						$dnotes = $DB_con->prepare("INSERT INTO det_perawatan($dc) VALUES ($dv)");
						$dnotes->execute();
						// var_dump($data_dokter);die();
					}

					// obat
					$iobat			= $_POST['ido'];
					$tobat			= $_POST['txo'];
					$hobat			= $_POST['hargaobat'];
					foreach ($iobat as $bat => $p) {
						$data_obat = array(
							'nomer_perawatan'		=> $nidp,
							'det_type'      => 'obat',
							'det_text'      => htmlspecialchars($tobat[$bat]),
							'det_harga'     => htmlspecialchars($hobat[$bat])
						);
						$oc  = implode(", ",array_keys($data_obat));
						$ov  = "'" . implode ( "', '", array_values($data_obat)) . "'";
						$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
						$onotes->execute();

						// var_dump($data_obat);die();
						}

				
				// tindakan
				$ttindakan		= ' ';
				$htindakan		= 0;

				$det_rawat		= $nidp;
				$det_type    = 'tindak';
				$det_text     = $ttindakan;
				$det_harga     = $htindakan;

				$anotes = $DB_con->prepare("INSERT INTO det_perawatan VALUES ('','$det_rawat','$det_type','$det_text','$det_harga')");
				$anotes->execute();
				

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();
			}

			// jika pilih smuanya
		else{
				$ialat			= $_POST['ida'];
				$talat			= $_POST['txa'];
				$halat			= $_POST['harga'];

				foreach ($ialat as $key => $p) {
					$data_alat = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'alat',
						'det_text'      => htmlspecialchars($talat[$key]),
						'det_harga'     => htmlspecialchars($halat[$key])
					);
					$ac  = implode(", ",array_keys($data_alat));
					$av  = "'" . implode ( "', '", array_values($data_alat)) . "'";
					$anotes = $DB_con->prepare("INSERT INTO det_perawatan($ac) VALUES ($av)");
					$anotes->execute();

				}

				$idokter		= $_POST['idd'];
				$tdokter		= $_POST['txd'];
				$hdokter		= $_POST['hargadokter'];
				foreach ($idokter as $dok => $p) {
					$data_dokter = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'dokter',
						'det_text'      => htmlspecialchars($tdokter[$dok]),
						'det_harga'     => htmlspecialchars($hdokter[$dok])
					);
					$dc  = implode(", ",array_keys($data_dokter));
					$dv  = "'" . implode ( "', '", array_values($data_dokter)) . "'";
					$dnotes = $DB_con->prepare("INSERT INTO det_perawatan($dc) VALUES ($dv)");
					$dnotes->execute();
					// var_dump($data_dokter);die();
				}


				$iobat			= $_POST['ido'];
				$tobat			= $_POST['txo'];
				$hobat			= $_POST['hargaobat'];
				foreach ($iobat as $bat => $p) {
					$data_obat = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'obat',
						'det_text'      => htmlspecialchars($tobat[$bat]),
						'det_harga'     => htmlspecialchars($hobat[$bat])
					);
					$oc  = implode(", ",array_keys($data_obat));
					$ov  = "'" . implode ( "', '", array_values($data_obat)) . "'";
					$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
					$onotes->execute();

					// var_dump($data_obat);die();

					}

				// tindakan
				$itindakan			= $_POST['idt'];
				$ttindakan			= $_POST['txt'];
				$htindakan			= $_POST['hargatindak'];
				foreach ($itindakan as $tdk => $p) {
					$data_tindakan = array(
						'nomer_perawatan'		=> $nidp,
						'det_type'      => 'tindak',
						'det_text'      => htmlspecialchars($ttindakan[$tdk]),
						'det_harga'     => htmlspecialchars($htindakan[$tdk])
					);
					$oc  = implode(", ",array_keys($data_tindakan));
					$ov  = "'" . implode ( "', '", array_values($data_tindakan)) . "'";
					$onotes = $DB_con->prepare("INSERT INTO det_perawatan($oc) VALUES ($ov)");
					$onotes->execute();

					// var_dump($data_obat);die();
					}

				// ======== kurangi space kamar ============= //
				$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kkamar");
				$min->execute();
				$rowm = $min->fetch();

				$baru = $rowm['isi_kamar']-1;
				$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kkamar");
				$menus->execute();
				// ========================================= //

				$deactive = $DB_con->prepare("UPDATE tbl_periksa SET status='d' WHERE kode_periksa = $item_id");
				$deactive->execute();

		}
	
	}

}


if(isset($_POST['btn-hpsper']))
{
	$did 		= $_POST['did'];
	$kid 		= $_POST['kid'];
	$rid 		= $_POST['rid'];
	$ddelete 	= $DB_con->prepare("DELETE FROM det_perawatan WHERE nomer_perawatan='$did'");
	$ddelete->execute();

	$dodelete 	= $DB_con->prepare("DELETE FROM tbl_perawatan WHERE nomer_perawatan='$did'");
	$dodelete->execute();	
	// ======== tambah space kamar ============= //
	$min = $DB_con->prepare("SELECT kode_kamar,isi_kamar FROM tbl_kamar where kode_kamar = $kid");
	$min->execute();
	$rowm = $min->fetch();

	$baru = $rowm['isi_kamar']+1;
	$menus = $DB_con->prepare("UPDATE tbl_kamar SET isi_kamar='$baru' WHERE kode_kamar = $kid");
	$menus->execute();
	$active = $DB_con->prepare("UPDATE tbl_periksa SET status='a' WHERE kode_periksa = $rid");
	$active->execute();
	// ========================================= //
	if($ddelete && $dodelete){
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

<!-- tambah perawatan -->
<form method="post" class="perawatan">
	<div class="row justify-content-center">
		<div class="col-xl-12">
			<div class="row">
				<div class="col-lg-3">
					<div class="widget has-shadow bg-warning">
						<div class="widget-header bordered no-actions d-flex align-items-center">
							<h4>Tambah Perawatan</h4>
						</div>	
						<div class="widget-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<?php 
											$tgl = date('dmy');
											$list = $DB_con->prepare("SELECT MAX(nomer_perawatan) as top FROM tbl_perawatan");
											$list->execute();
											$idp =$list->fetch();
											$nidp =$idp['top']+1;
											if($nidp<10){
											 	$nid = '00'.$nidp;
											 }else{ $nid = '0'.$nidp;} ?>

										<label class="form-control-label">Kode Perawatan</label>
										<input name="kd_rawat" type="text" class="form-control" readonly value="PRW<?php 
											echo $nid.$tgl; 
										?> ">
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Tanggal</label>
										<input name="tanggal_check" type="date" class="form-control"  placeholder="Tanggal" value="<?php echo $date;?>" readonly>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Kode Periksa</label>
										<select class="form-control" name="kdper" id="kdper">
											<option>Pilih Kode Periksa</option>
											<?php 
											$kamar = $DB_con->prepare("SELECT * 
												FROM tbl_periksa tbp,
												tbl_pasien mp,
												tbl_kamar mk 
												WHERE tbp.kode_pasien = mp.kode_pasien
												and tbp.kode_kamar = mk.kode_kamar
												and tbp.status='a'");
											$kamar->execute();
											while ($rows=$kamar->fetch(PDO::FETCH_ASSOC)){?>
												<option value="<?php echo $rows['kode_pasien'].'-'.$rows['kode_periksa'].'-'.$rows['nama_pasien'].'&'.$rows['kode_kamar'].'or'.$rows['nama_kamar'];?>"><?php echo $rows['kode_periksa'].'-'.$rows['nama_pasien'];?></option>
											<?php }?>
										</select>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Nama Pasien</label>
										<input id="npasien" type="text" class="form-control"  placeholder="nama pasien" readonly>
										<input name="no_pasien" id="idpas" type="hidden" class="form-control"  placeholder="">
									</div>
								</div>
								<div class="col-lg-12" style="display: none;">
									<div class="form-group">
										<label class="form-control-label">Kode Kamar</label>
										<input name="kode_kamar" id="kkamar" type="text" class="form-control" placeholder="Kode kamar" readonly>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Nama Ruang</label>
										<input id="nkamar" type="text" class="form-control"  placeholder="nama Ruang" readonly>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Biaya Alat</label>
										<input name="tarifalat" id="tarifalat" type="text" class="form-control my-class"  placeholder="tarif alat" onchange="math()" readonly>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Biaya Dokter</label>
										<input name="tarifdokter" id="tarifdokter" type="text" class="form-control my-class"  placeholder="tarif dokter" onchange="math()" readonly>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Biaya Obat</label>
										<input name="tarifobat" id="tarifobat" type="text" class="form-control my-class"  placeholder="tarif obat" onchange="math()" readonly>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Biaya Tindakan</label>
										<input name="tariftindakan" id="tariftindakan" type="text" class="form-control my-class"  placeholder="tarif Kamar" onchange="math()" readonly>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-control-label">Total Biaya</label>
										<input name="totaltarif" id="totalsemua" type="text" class="form-control my-class"  placeholder="total" readonly>
									</div>
								</div>
								<div class="col-lg-12">
									<button type="submit" name="btn-perawatan" class="btn btn-primary pull-right">Tambah</button>
								</div>
							</div>
						</div>	
					</div>
				</div>
				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-8">
							<!-- Sorting -->
							<div class="widget has-shadow">
								<div class="widget-header bordered no-actions d-flex align-items-center">
									<h4>Alat Kesehatan</h4>
									<div class="col col-xs-6 text-right">
										<button type="button" class="btn btn-danger btn-square mr-1 mb-2" id="delete-alat">Hapus</button>
									</div>
								</div>
								<div class="widget-body">
									<div class="table-responsive">
										<table id="tab" class="table mb-0">
											<thead>
												<tr>
													<th>#</th>
													<th>Kode</th>
													<th>Nama Alat</th>
													<th>Tarif</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- End Row -->
						</div>
						<div class="col-lg-4">
							<div class="widget has-shadow bg-warning">
								<div class="widget-body">
									<form method="post">
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="form-control-label">Alat</label>
													<select class="form-control" id="selectalat">
														<option value="" disabled selected>Pilih Alat</option>
														<?php 
														$list = $DB_con->prepare("SELECT * 
															FROM tbl_alat");
														$list->execute();
														while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
															<option value="<?php echo $row['kode_alat'].'-'.$row['tarif_alat']?>"><?php echo $row['nama_alat']?></option>
														<?php }?>
													</select>
												</div>
											</div>
										</div>
									</form>
								</div>	
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-8">
							<!-- Sorting -->
							<div class="widget has-shadow">
								<div class="widget-header bordered no-actions d-flex align-items-center">
									<h4>Dokter</h4>
									<div class="col col-xs-6 text-right">
										<button type="button" class="btn btn-danger btn-square mr-1 mb-2" id="delete-dokter">Hapus</button>
									</div>
								</div>
								<div class="widget-body">
									<div class="table-responsive">
										<table id="dtab" class="table mb-0">
											<thead>
												<tr>
													<th>#</th>
													<th>Kode</th>
													<th>Nama Dokter</th>
													<th>Tarif</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- End Row -->
						</div>
						<div class="col-lg-4">
							<div class="widget has-shadow bg-warning">
								<div class="widget-body">
									<form method="post">
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="form-control-label">Dokter</label>
													<select class="form-control" id="selectdokter">
														<option value="" disabled selected>Pilih Dokter</option>
														<?php 
														$list = $DB_con->prepare("SELECT * 
															FROM tbl_dokter");
														$list->execute();
														while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
															<option value="<?php echo $row['kode_dokter'].'-'.$row['tarif_dokter']?>"><?php echo $row['nama_dokter']?></option>
														<?php }?>
													</select>
												</div>
											</div>
										</div>
									</form>
								</div>	
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-8">
							<!-- Sorting -->
							<div class="widget has-shadow">
								<div class="widget-header bordered no-actions d-flex align-items-center">
									<h4>Obat</h4>
									<div class="col col-xs-6 text-right">
										<button type="button" class="btn btn-danger btn-square mr-1 mb-2" id="delete-obat">Hapus</button>
									</div>
								</div>
								<div class="widget-body">
									<div class="table-responsive">
										<table id="otab" class="table mb-0">
											<thead>
												<tr>
													<th>#</th>
													<th>Kode</th>
													<th>Nama Obat</th>
													<th>Tarif</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- End Row -->
						</div>
						<div class="col-lg-4">
							<div class="widget has-shadow bg-warning">
								<div class="widget-body">
									<form method="post">
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="form-control-label">Obat</label>
													<select class="form-control" id="selectobat">
														<option value="" disabled selected>Pilih Obat</option>
														<?php 
														$list = $DB_con->prepare("SELECT * 
															FROM tbl_obat");
														$list->execute();
														while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
															<option value="<?php echo $row['kode_obat'].'-'.$row['tarif_obat']?>"><?php echo $row['nama_obat']?></option>
														<?php }?>
													</select>
												</div>
											</div>
										</div>
									</form>
								</div>	
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-8">
							<!-- Sorting -->
							<div class="widget has-shadow">
								<div class="widget-header bordered no-actions d-flex align-items-center">
									<h4>Tindakan</h4>
									<div class="col col-xs-6 text-right">
										<button type="button" class="btn btn-danger btn-square mr-1 mb-2" id="delete-tindak">Hapus</button>
									</div>
								</div>
								<div class="widget-body">
									<div class="table-responsive">
										<table id="ttable" class="table mb-0">
											<thead>
												<tr>
													<th>#</th>
													<th>Kode</th>
													<th>Nama Tindakan</th>
													<th>Tarif</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- End Row -->
						</div>
						<div class="col-lg-4">
							<div class="widget has-shadow bg-warning">
								<div class="widget-body">
									<form method="post">
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="form-control-label">Tindakan</label>
													<select class="form-control" id="selecttindakan">
														<option value="" disabled selected>Pilih Tindakan</option>
														<?php 
														$list = $DB_con->prepare("SELECT * 
															FROM tbl_tindakan");
														$list->execute();
														while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
															<option value="<?php echo $row['kode_tindakan'].'-'.$row['tarif_tindakan']?>"><?php echo $row['nama_tindakan']?></option>
														<?php }?>
													</select>
												</div>
											</div>
										</div>
									</form>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<!-- Sorting -->
					<div class="widget has-shadow">
						<div class="widget-header bordered no-actions d-flex align-items-center">
							<h4>List perawatan pasien</h4>
							<div class="col col-xs-6 text-right">
							</div>
						</div>
						<div class="widget-body">
							<div class="table-responsive">
								<table id="sorting-table" class="table mb-0">
									<thead>
										<tr>
											<th>No</th>
											<th>Kode Perawatan</th>
											<th>Kode Pasien</th>
											<th>Nama Pasien</th>
											<th>Tanggal Perawatan</th>
											<!-- <th>Nomor periksa</th> -->
											<th>Ruang</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$list = $DB_con->prepare("SELECT
											* FROM 
											tbl_perawatan mper,
											tbl_pasien mpas,
											tbl_kamar mkam
											WHERE 
											mper.kode_pasien = mpas.kode_pasien AND
											mper.kode_kamar = mkam.kode_kamar
											");
										$list->execute();
										$no = 1;
										while ($row=$list->fetch(PDO::FETCH_ASSOC)):?>
											<tr>
												<td><span class="text-primary"><?= $no; ?></span></td>
												<td><span class="text-primary">PRW<?php echo $row['kode_perawatan']?></span></td>
												<td><span class="text-primary">PSN<?php echo ucfirst($row['kode_pasien']);?></span></td>
												<td><span class="text-primary"><?php echo $row['nama_pasien']?></span></td>
												<td><span class="text-primary"><?php 
												$tgl = $row['tgl_perawatan'];
												echo  substr($tgl, 0, 10);
												?></span></td>
												<!-- <td><span class="text-primary">Reg<?php echo $row['nomer_periksa']?></span></td> -->
												<td><span class="text-primary"><?php echo ucfirst($row['nama_kamar']);?></span></td>
												<td class="td-actions text-center">
													<a href="#" class="detail" title="detail"
													id= "<?= $row['nomer_perawatan']; ?>"
													data-toggle="modal" data-target="#detail"

													>
													<i class="fas fa-info-circle edit text-success"></i>
                                                 	</a>

													<a href="#" class="trash"  title="hapus"
													data-id="<?php echo $row['nomer_perawatan']?>"
													data-kid="<?php echo $row['kode_kamar']?>"
													data-rid="<?php echo $row['kode_periksa']?>"
													data-toggle="modal" data-target="#delete"><i class="la la-close delete text-danger"></i></a>
												</td>
											</tr>

										<?php 
										$no++;
										endwhile; ?>
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
</form>


<!-- detail perawatan -->
<div class="row detailsrm">
	
</div>

<!-- hapusdata -->
<form method="post">
	<div id="delete" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body text-center">
					<div class="section-title mt-5 mb-2">
						<h2 class="text-gradient-02">Anda yakin mau menghapus ini ?</h2>
						<input type="hidden" name="did" id="d_id">
						<input type="hidden" name="kid" id="k_id">
						<input type="hidden" name="rid" id="r_id">
					</div>
					<p class="mb-5">Data tidak dapat dikembalikan setelah di hapus</p>
					<button type="submit" class="btn btn-danger mb-3" name="btn-hpsper">Ok</button>
				</div>
			</div>
		</div>
	</div>
</form>


<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery.min.js"></script>

<!-- detail -->
<script>
	$('.detail').click(function() {
			
			$('.detailsrm').fadeIn();
			$(window).scrollTop(0);
			var idrm = $(this).attr('id');
			$('.detailsrm').load("class/doDetailRm.php?id="+idrm,
				function(){
					$('.perawatan').fadeOut();
			});
	});

</script>

<script type="text/javascript">
	$('.trash').click(function(){
		var id=$(this).data('id');
		var kid=$(this).data('kid');
		var rid=$(this).data('rid');
		document.getElementById('d_id').value = id;
		document.getElementById('k_id').value = kid;
		document.getElementById('r_id').value = rid;
	});
</script>
<script type="text/javascript">
	$('#kdper').on('change', function() {

		var id = $(this).val();
		var tx = $(this).find("option:selected").text();
		var idpasien= id.split('-')[0];
		var nama 	= id.split('-').pop().split('&')[0];
		var kamar 	= id.split('&').pop().split('or')[0];
		var nkamar 	= id.substr(id.indexOf("or") + 2);
		document.getElementById('idpas').value = idpasien;
		document.getElementById('npasien').value = nama;
		document.getElementById('nkamar').value = nkamar;
		document.getElementById('kkamar').value = kamar;
		
	});
	function math(){
		var alat 	= document.getElementById('tarifalat').value || 0;
		var dok 	= document.getElementById('tarifdokter').value || 0;
		var obat 	= document.getElementById('tarifobat').value || 0;
		var tindak 	= document.getElementById('tariftindakan').value || 0;
		var totals  = parseInt(alat) + parseInt(dok) + parseInt(obat) + parseInt(tindak);
		document.getElementById('totalsemua').value = totals;
	}

	function calc_alat(){
		$('#tab tbody').each(function(){
			var totalPoints = 0;
			$(this).find('input[name="harga[]"]').each(function(){
				totalPoints += parseInt($(this).val());
			});
			document.getElementById('tarifalat').value = totalPoints;
			math();
		});
	}
	function calc_dokter(){
		$('#dtab tbody').each(function(){
			var totalPoints = 0;
			$(this).find('input[name="hargadokter[]"]').each(function(){
				totalPoints += parseInt($(this).val());
			});
			document.getElementById('tarifdokter').value = totalPoints;
			math();
		});
	}
	function calc_obat(){
		$('#otab tbody').each(function(){
			var totalPoints = 0;
			$(this).find('input[name="hargaobat[]"]').each(function(){
				totalPoints += parseInt($(this).val());
			});
			document.getElementById('tarifobat').value = totalPoints;
			math();
		});
	}
	function calc_tindakan(){
		$('#ttable tbody').each(function(){
			var totalPoints = 0;
			$(this).find('input[name="hargatindak[]"]').each(function(){
				totalPoints += parseInt($(this).val());
			});
			document.getElementById('tariftindakan').value = totalPoints;
			math();
		});
	}
	$('#selectalat').on('change', function() {
		var id = $(this).val();
		var tx = $(this).find("option:selected").text();
		var ida = id.split('-')[0];
		var harga = id.substr(id.indexOf("-") + 1);
		
		var markup = "<tr>\
		<td class='text-center'><input type='checkbox' name='record'></td>\
		<td><input type='hidden' name='ida[]' value='"+ida+"'>"+ida+"</td>\
		<td><input type='hidden' name='txa[]' value='"+tx+"'>"+tx+"</td>\
		<td><input type='hidden' name='harga[]' id='totalbro' value='"+harga+"'>"+harga+"</td>\
		</tr>";

		$("#tab tbody").append(markup);
		calc_alat();
		
	});
	$("#delete-alat").click(function(){
		$("table tbody").find('input[name="record"]').each(function(){
			if($(this).is(":checked")){
				$(this).parents("tr").remove();
			}
			calc_alat();
		});
	});
	$('#selectdokter').on('change', function() {
		var id = $(this).val();
		var tx = $(this).find("option:selected").text();
		var ida = id.split('-')[0];
		var harga = id.substr(id.indexOf("-") + 1);


		var markup = "<tr>\
		<td class='text-center'><input type='checkbox' name='record'></td>\
		<td><input type='hidden' name='idd[]' value='"+ida+"'>"+ida+"</td>\
		<td><input type='hidden' name='txd[]' value='"+tx+"'>"+tx+"</td>\
		<td><input type='hidden' name='hargadokter[]' value='"+harga+"'>"+harga+"</td>\
		</tr>";

		$("#dtab tbody").append(markup);
		calc_dokter();
	});
	$("#delete-dokter").click(function(){
		$("table tbody").find('input[name="record"]').each(function(){
			if($(this).is(":checked")){
				$(this).parents("tr").remove();
			}
			calc_dokter();
		});
	});
	$('#selectobat').on('change', function() {
		var id = $(this).val();
		var tx = $(this).find("option:selected").text();
		var ida = id.split('-')[0];
		var harga = id.substr(id.indexOf("-") + 1);


		var markup = "<tr>\
		<td class='text-center'><input type='checkbox' name='record'></td>\
		<td><input type='hidden' name='ido[]' value='"+ida+"'>"+ida+"</td>\
		<td><input type='hidden' name='txo[]' value='"+tx+"'>"+tx+"</td>\
		<td><input type='hidden' name='hargaobat[]' value='"+harga+"'>"+harga+"</td>\
		</tr>";

		$("#otab tbody").append(markup);
		calc_obat();
	});
	$("#delete-obat").click(function(){
		$("table tbody").find('input[name="record"]').each(function(){
			if($(this).is(":checked")){
				$(this).parents("tr").remove();
			}
			calc_obat();
		});
	});
	$('#selecttindakan').on('change', function() {
		var id = $(this).val();
		var tx = $(this).find("option:selected").text();
		var ida = id.split('-')[0];
		var harga = id.substr(id.indexOf("-") + 1);


		var markup = "<tr>\
		<td class='text-center'><input type='checkbox' name='record'></td>\
		<td><input type='hidden' name='idt[]' value='"+ida+"'>"+ida+"</td>\
		<td><input type='hidden' name='txt[]' value='"+tx+"'>"+tx+"</td>\
		<td><input type='hidden' name='hargatindak[]' value='"+harga+"'>"+harga+"</td>\
		</tr>";

		$("#ttable tbody").append(markup);
		calc_tindakan();
	});
	$("#delete-tindak").click(function(){
		$("table tbody").find('input[name="record"]').each(function(){
			if($(this).is(":checked")){
				$(this).parents("tr").remove();
			}
			calc_tindakan();
		});
	});
</script>
<!-- shorting data in datatable -->
<script>
	$(document).ready(function() {
		$('#sorting-table').data({
			"order": [[0,"asc"]]
		});
	});
</script>