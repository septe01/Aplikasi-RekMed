<?php 

	
	include '../../dbconfig.php';
	
	$kper = $_POST['kper'];
	$per = "ok";
	$upPer = $DB_con->prepare("UPDATE tbl_periksa SET setper='$per' WHERE kode_periksa='$kper' ");
	$upPer->execute();
	echo json_encode($upPer);

 ?>