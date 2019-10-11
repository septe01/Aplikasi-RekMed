<?php 
	include '../../dbconfig.php';
	date_default_timezone_set('Asia/jakarta');
	$date = Date('Y');
	$M = Date('m');
	// var_dump($M);
	$thn = $date;
	$bln = $M;
	$tgl = [];
	// if($bln == 1){
	// 	$tgl = [$thn.'-01'];
	// }elseif($bln  < 3 ){
	// 	$tgl = [
	// 			$thn.'-01',
	// 			$thn.'-02'
	// 		];
	// }elseif($bln  < 4 ){
	// 	$tgl = [
	// 			$thn.'-01',
	// 			$thn.'-02',
	// 			$thn.'-03'
	// 		];
	// }elseif($bln  < 5 ){
	// 	$tgl = [
	// 			$thn.'-01',
	// 			$thn.'-02',
	// 			$thn.'-03',
	// 			$thn.'-04'
	// 		];
	// }elseif($bln  < 6 ){
	// 	$tgl = [
	// 			$thn.'-01',
	// 			$thn.'-02',
	// 			$thn.'-03',
	// 			$thn.'-04',
	// 			$thn.'-05'
	// 		];
	// }elseif($bln  < 7 ){
	// 	$tgl = [
	// 			$thn.'-01',
	// 			$thn.'-02',
	// 			$thn.'-03',
	// 			$thn.'-04',
	// 			$thn.'-05',
	// 			$thn.'-06'
	// 		];
	// }elseif($bln  < 8 ){
	// 	$tgl = [
	// 			$thn.'-01',
	// 			$thn.'-02',
	// 			$thn.'-03',
	// 			$thn.'-04',
	// 			$thn.'-05',
	// 			$thn.'-06',
	// 			$thn.'-07'
	// 		];
	// }elseif($bln  < 9 ){
	// 	$tgl = [
	// 			$thn.'-01',
	// 			$thn.'-02',
	// 			$thn.'-03',
	// 			$thn.'-04',
	// 			$thn.'-05',
	// 			$thn.'-06',
	// 			$thn.'-07',
	// 			$thn.'-08'
	// 		];
	// }elseif($bln  < 10 ){
	// 	$tgl = [
	// 			$thn.'-01',
	// 			$thn.'-02',
	// 			$thn.'-03',
	// 			$thn.'-04',
	// 			$thn.'-05',
	// 			$thn.'-06',
	// 			$thn.'-07',
	// 			$thn.'-08',
	// 			$thn.'-09'
	// 		];
	// }

	// var_dump($tgl);
	$tgl 	= [
		$thn.'-01',
		$thn.'-02',
		$thn.'-03',
		$thn.'-04',
		$thn.'-05',
		$thn.'-06',
		$thn.'-07',
		$thn.'-08',
		$thn.'-09',
		$thn.'-10',
		$thn.'-11',
		$thn.'-12'
	];
	// // var_dump(count($tgl));

	$data = [];
	for ($i = 0; $i < count($tgl) ; $i++) {

		$perawatan[$i] = $DB_con->prepare("SELECT * FROM tbl_perawatan WHERE tgl_perawatan LIKE '$tgl[$i]%' ");
		$perawatan[$i]->execute();
		$sttus[$i] = $perawatan[$i]->rowCount();

		$data[] .= $sttus[$i];
	}

	$rows = [
		$data,
		$thn
	];

	echo json_encode($rows);

?>