<?php 
	include '../../dbconfig.php';
	$kdper 		= $_POST['kdperiksa'];
	$kdpas 		= $_POST['kdpasien'];

	$cekData = $DB_con->prepare("SELECT * FROM tbl_pendamping 
							WHERE 	
							kode_pasien = '$kdpas'
							AND kode_periksa = '$kdper'
							ORDER BY nomor_pendamping DESC

							");
	$cekData->execute();

	$Rdata = $cekData->fetch(PDO::FETCH_ASSOC);
	$setPend = [];
	if($Rdata > 0){
		$setPend[] = "ada";
		$setPend[] = $Rdata;
		echo json_encode($setPend);
	}else{
		$setPend[] = "kosong";
		echo json_encode($setPend);
	}
	
 ?>

