<?php 
	include '../../dbconfig.php';
	date_default_timezone_set('Asia/jakarta');

	$thn = 2019;

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
	// var_dump(count($tgl));

	$dataL = [];
	$dataP = [];
	for ($i = 0; $i < count($tgl) ; $i++) {

		$pasien[$i] = $DB_con->prepare("SELECT * FROM tbl_pasien WHERE kelamin_pasien='pria' AND tanggal LIKE '$tgl[$i]%' ");
		$pasien[$i]->execute();
		$laki[$i] = $pasien[$i]->rowCount();

		$pasper[$i] = $DB_con->prepare("SELECT * FROM tbl_pasien WHERE kelamin_pasien='wanita' AND tanggal LIKE '$tgl[$i]%' ");
		$pasper[$i]->execute();
		$perempuan[$i] = $pasper[$i]->rowCount();

		$dataL[] .= $laki[$i];
		$dataP[] .= $perempuan[$i];
	}

	$rows = [
		$dataL,
		$dataP,
		$thn
	];

	echo json_encode($rows);
?>