<?php 
date_default_timezone_set('Asia/jakarta');

$date 	= date('dmy');
$tgl 	= date('Y-m-d');

if(isset($_POST['btn-pasien']))
{
	
	$psn	= $_POST['kode_pasien'];
	$patterna = '/([^0-9]+)/';
	$pid = preg_replace($patterna,'',$psn);

	$nama	    = htmlspecialchars($_POST['nama_pasien']);
	$tgl_lahir	= htmlspecialchars($_POST['tgllahir']);
	$pekerjaan 	= htmlspecialchars($_POST['pekerjaan']);
	$alamat	    = htmlspecialchars($_POST['alamat_pasien']);
	$kelamin    = htmlspecialchars($_POST['kelamin_pasien']);
	$ortu 		= htmlspecialchars($_POST['ortu']);
	$nohp	    = htmlspecialchars($_POST['telepon']);
	$notes 	= $DB_con->prepare("INSERT INTO tbl_pasien(kode_pasien,nama_pasien,tgl_lahir,pekerjaan,alamat_pasien,kelamin_pasien,nm_orangtua,telepon,tanggal)VALUES('$pid','$nama','$tgl_lahir','$pekerjaan','$alamat','$kelamin','$ortu','$nohp','$tgl')");
	$notes->execute();	
	if($notes){
					$type = "success";
					$judul = "Congratulations !";
					$success = "data berhasil di tambah !!!";
		}else{
				$type = "error";
				$judul = "Oops. !";
				$success = "data gagal di tambah !!!";
		}

}

if(isset($_POST['btn_ubah']))
{
	
	$nid 		= $_POST['nid'];
	$nnama 		= htmlspecialchars($_POST['nama_pasien']);
	$tgllhir 	= htmlspecialchars($_POST['tgllahir']);
	$pekerjaan 	= htmlspecialchars($_POST['pekerjaan']);
	$jns_kelamin = htmlspecialchars($_POST['kelamin_pasien']);
	$nohp 		= htmlspecialchars($_POST['telepon']);	
	$ortu 		= htmlspecialchars($_POST['ortu']);
	$alamat 	= htmlspecialchars($_POST['alamat_pasien']);

	$menus = $DB_con->prepare("UPDATE tbl_pasien SET nama_pasien='$nnama',tgl_lahir='$tgllhir',pekerjaan='$pekerjaan', alamat_pasien='$alamat', kelamin_pasien='$jns_kelamin', nm_orangtua='$ortu', telepon='$nohp', tanggal='$tgl' WHERE kode_pasien='$nid'");
	$menus->execute();
	if($menus){
					$type = "success";
					$judul = "Congratulations !";
					$success = "data berhasil di ubah !!!";
		}else{
				$type = "error";
				$judul = "Oops. !";
				$success = "data gagal di ubah !!!";
		}

}

if(isset($_POST['btn-hapus']))
{
	$did 		= $_POST['did'];
	$dodelete 	= $DB_con->prepare("DELETE FROM tbl_pasien WHERE kode_pasien='$did'");
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

<!-- main -->
<div class="row justify-content-center">
	<div class="col-xl-12">
		<div class="row">
			<div class="col-lg-12">
				<!-- Sorting -->
				<div class="widget has-shadow">
					<div class="widget-header bordered no-actions d-flex align-items-center ml-1">
						<h4>List pasien</h4>
						<div class="col col-xs-6 text-right">
							<button type="button" class="btn btn-primary btn-square mr-1 mb-2" data-toggle="modal" data-target="#new">Tambah Pasien</button>
						</div>
					</div>
					<div class="widget-body">
						<div class="table-responsive">
							<table id="sorting-table" class="table mb-0">
								<thead>
									<tr>
										<th>No</th>
										<th>Kode pasien</th>
										<th>Nama</th>
										<th>Kelamin</th>
										<th>Alamat</th>
										<th>Telepon</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$list = $DB_con->prepare("SELECT * FROM tbl_pasien ");
									$list->execute();
									$no = 1;
									while ($row=$list->fetch(PDO::FETCH_ASSOC)){?>
										<tr>
											<td><span class="text-primary"><?= $no; ?></span></td>
											<td><span class="text-primary">PSN<?php echo $row['kode_pasien']?></span></td>
											<td><?php echo ucfirst($row['nama_pasien']);?></td>
											<td><?php echo ucfirst($row['kelamin_pasien']);?></td>
											<td><?php echo $row['alamat_pasien'];?></td>
											<td class="text-left"><?php echo $row['telepon'];?></td>
											<td class="td-actions text-center">
												<a href="#" class="eedit" 
												data-id="<?php echo $row['kode_pasien']?>" 
												data-nama="<?php echo $row['nama_pasien']?>" 
												data-tgllhr="<?php echo $row['tgl_lahir']?>" 
												data-pekerjaan="<?php echo $row['pekerjaan'] ?>"
												data-kelamin="<?php echo $row['kelamin_pasien'];?>" 
												data-phone="<?php echo $row['telepon'];?>" 
												data-ortu="<?php echo $row['nm_orangtua'];?>" 
												data-alamat="<?php echo $row['alamat_pasien'];?>" 
												data-toggle="modal" data-target="#update">
													<i class="la la-edit edit text-success"></i>
												</a>
												<a href="#" class="trash" data-id="<?php echo $row['kode_pasien']?>" data-toggle="modal" data-target="#delete"><i class="la la-close delete text-danger"></i></a>
											</td>
										</tr>
									<?php $no++; } ?>
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

<!-- modal tambah -->
<form method="post" onsubmit="return formValidasiAdd();">
	<div id="new" class="modal fade">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Tambah</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">tutup</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Kode Pasien</label>
								<?php 
								$list = $DB_con->prepare("SELECT max(nomor_pasien) as top FROM tbl_pasien");
								$list->execute();
								$idp =$list->fetch();
								$nidp =$idp['top']+1;
								if($nidp<10){
								 	$nid = '00'.$nidp;
								 }else{ $nid = '0'.$nidp;} ?>
								<input name="kode_pasien" type="text" class="form-control" value="PSN<?php echo $nid.$date;?>" readonly>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Nama</label>
								<input name="nama_pasien" id="ftnm" type="text" class="form-control" placeholder="Nama" autocomplete="off" >
								<small id="tnmpas" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Tanggal lahir</label>
								<input name="tgllahir" type="text" class="form-control ftgl" id="tgllhr" placeholder="yyyy-mm-dd" autocomplete="off" >
								<small id="ttgl" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Pekerjaan</label>
								<input name="pekerjaan" type="text" id="ftpkj" class="form-control" placeholder="pekerjaan" autocomplete="off" >
								<small id="tpkj" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Jenis Kelamin</label>
								<select name="kelamin_pasien" id="ftjns" class="custom-select form-control">
									<option value="">Pilih</option>
									<option value="pria">Pria</option>
									<option value="wanita">Wanita</option>
								</select>
								<small id="tjns" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Nomer Telepon</label>
								<input name="telepon" type="text" id="fttlp" class="form-control" placeholder="nomer telephone" autocomplete="off" maxlength="15">
								<small id="ttlp" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Orang Tua</label>
								<input name="ortu" type="text" id="ftort" class="form-control" placeholder="nama orang tua" autocomplete="off" >
								<small id="tortu" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Alamat</label>
								<textarea name="alamat_pasien" id="ftalm" class="form-control" placeholder="alamat" autocomplete="off" maxlength="50"></textarea>
								<small id="talm" class="form-text text-danger"></small>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Tutup</button>
					<button type="submit" name="btn-pasien" class="btn btn-danger simp">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</form>

<!-- modal ubah -->
<form method="post" onsubmit="return formValidasiEdt();">
	<div id="update" class="modal fade">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Ubah data pasien</h4>
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">tutup</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Nama</label>
								<input name="nama_pasien" id="pnama" type="text" class="form-control pnama" placeholder="masukan nama">
								<small id="unmpas" class="form-text text-danger"></small>
								<input type="hidden" id="pno_id" name="nid">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Tanggal lahir</label>
								<input name="tgllahir" type="text" class="form-control" id="tgllhrubh" placeholder="Tanggal Lahir" autocomplete="off" >
								<small id="utgl" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Pekerjaan</label>
								<input name="pekerjaan" type="text" class="form-control" id="paspek" placeholder="pekerjaan" autocomplete="off" >
								<small id="upkj" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Jenis Kelamin</label>
								<select name="kelamin_pasien" id="kel" class="custom-select form-control">
									<option value="">Pilih</option>
									<option value="pria">Pria</option>
									<option value="wanita">Wanita</option>
								</select>
								<small id="ujns" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Nomer Telpon</label>
								<input name="telepon" id="ph" type="text" class="form-control" placeholder="masukan nomer telpon" maxlength="15">
								<small id="utlp" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Orang Tua</label>
								<input name="ortu" type="text" class="form-control" id="pasortu" placeholder="nama orang tua" autocomplete="off" >
								<small id="uortu" class="form-text text-danger"></small>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="form-control-label">Alamat</label>
								<textarea name="alamat_pasien" id="adr" class="form-control" placeholder="Masukan alamat" maxlength="50"></textarea>
								<small id="ualm" class="form-text text-danger"></small>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-shadow" data-dismiss="modal">Tutup</button>
					<button type="submit" name="btn_ubah" class="btn btn-danger">Simpan</button>
				</div>
			</div>
		</div>
	</div>
</form>

<!-- modal hapus -->
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
					<button type="submit" class="btn btn-danger mb-3" name="btn-hapus">Ok</button>
				</div>
			</div>
		</div>
	</div>
</form>

	
<script src="<?php echo $basic_url; ?>main/assets/vendors/js/base/jquery.min.js"></script>

<!-- form Validasi -->
<script>

// add
	$("#ftnm").keyup(function(event) {
		$("#tnmpas").hide();
	});

	$(".ftgl").click(function(event) {
		$("#ttgl").hide();
	});

	$("#ftpkj").keyup(function(event) {
		$("#tpkj").hide();
	});

	$("#ftjns").change(function(event) {
		$("#tjns").hide();
	});

	$("#fttlp").keyup(function(event) {
		$("#ttlp").hide();
	});

	$("#ftort").keyup(function(event) {
		$("#tortu").hide();
	});

	$("#ftalm").keyup(function(event) {
		$("#talm").hide();
	});

// ubah
	$("#pnama").keyup(function(event) {
		$("#unmpas").hide();
	});

	$("#tgllhrubh").click(function(event) {
		$("#utgl").hide();
	});

	$("#paspek").keyup(function(event) {
		$("#upkj").hide();
	});

	$("#kel").change(function(event) {
		$("#ujns").hide();
	});

	$("#ph").keyup(function(event) {
		$("#utlp").hide();
	});

	$("#pasortu").keyup(function(event) {
		$("#uortu").hide();
	});

	$("#adr").keyup(function(event) {
		$("#ualm").hide();
	});

// addfunction
function formValidasiAdd(){

		var nmp 	= $("#ftnm").val(),
			tgl 	= $(".ftgl").val(),
			pkrj 	= $("#ftpkj").val(),
			jns 	= $("#ftjns").val(),
			tlp 	= $("#fttlp").val(),
			ortu 	= $("#ftort").val(),	
			almt 	= $("#ftalm").val(),
			date 	= new Date().toISOString().split('T')[0];
		

	if(nmp == ""){
		$("#tnmpas").text('nama pasien tidak boleh kosong !').show();
		$("#ftnm").focus();
		return false;

	}else if(!(/^[a-zA-Z\.\s\/\()]+$/.test(nmp))){
		$('#tnmpas').text('nama pasien hanya boleh text !').show();
		$("#ftnm").focus();
			return false;

	}else if(tgl == ""){
		$("#ttgl").text('tanggal lahir tidak boleh kosong !').show();
		return false;

	}else if(tgl >= date){
		$("#ttgl").text('tanggal lahir salah !').show();
		return false;

	}else if(pkrj == ""){
		$("#tpkj").text('pekerjaan tidak boleh kosong !').show();
		$("#ftpkj").focus();
		return false;
		
	}else if(!(/^[a-zA-Z\.\s\/\()]+$/.test(pkrj))){
		$('#tpkj').text('pekerjaan hanya boleh text !').show();
		$("#ftpkj").focus();
			return false;

	}else if(jns == ""){
		$("#tjns").text('silahkan pilih jenis kelamin !').show();
		return false;
		
	}else if(tlp == ""){
		$("#ttlp").text('no telp tidak boleh kosong !').show();
		$("#fttlp").focus();
		return false;
		
	}else if(!(/^-?\d*$/.test(tlp))){
		$("#ttlp").text('no telp hanya boleh angka !').show();
		$("#fttlp").focus();
		return false;
		
	}else if(ortu == ""){
		$("#tortu").text('nama orang tua tidak boleh kosong !').show();
		$("#ftort").focus();
		return false;
		
	}else if(!(/^[a-zA-Z\.\s\/\()]+$/.test(ortu))){
		$('#tortu').text('nama orang tua hanya boleh text !').show();
		$("#ftort").focus();
			return false;

	}else if(almt == ""){
		$("#talm").text('alamat tidak boleh kosong !').show();
		$("#ftalm").focus();
		return false;
		
	}else{
		return true;
	}
}

// edfunction
	function formValidasiEdt(){

		var unmp 	= $("#pnama").val(),
			tgl 	= $("#tgllhrubh").val(),
			pkrj 	= $("#paspek").val(),
			jns 	= $("#kel").val(),
			tlp 	= $("#ph").val(),
			ortu 	= $("#pasortu").val(),	
			almt 	= $("#adr").val(),
			date 	= new Date().toISOString().split('T')[0];

	if(unmp == ""){
	$("#unmpas").text('nama pasien tidak boleh kosong !').show();
	$("#pnama").focus();
	return false;

	}else if(!(/^[a-zA-Z\.\s\/\()]+$/.test(unmp))){
		$('#unmpas').text('nama pasien hanya boleh text !').show();
		$("#pnama").focus();
			return false;

	}else if(tgl == ""){
		$("#utgl").text('tanggal lahir tidak boleh kosong !').show();
		return false;

	}else if(tgl >= date){
		$("#utgl").text('tanggal lahir salah !').show();
		return false;

	}else if(pkrj == ""){
		$("#upkj").text('pekerjaan tidak boleh kosong !').show();
		$("#paspek").focus();
		return false;
		
	}else if(!(/^[a-zA-Z\.\s\/\()]+$/.test(pkrj))){
		$('#upkj').text('pekerjaan hanya boleh text !').show();
		$("#paspek").focus();
		return false;

	}else if(jns == ""){
		$("#ujns").text('silahkan pilih jenis kelamin !').show();
		return false;
		
	}else if(tlp == ""){
		$("#utlp").text('no telp tidak boleh kosong !').show();
		$("#ph").focus();
		return false;
		
	}else if(!(/^-?\d*$/.test(tlp))){
		$("#utlp").text('no telp hanya boleh angka !').show();
		$("#ph").focus();
		return false;
		
	}else if(ortu == ""){
		$("#uortu").text('nama orang tua tidak boleh kosong !').show();
		$("#pasortu").focus();
		return false;
		
	}else if(!(/^[a-zA-Z\.\s\/\()]+$/.test(ortu))){
		$('#uortu').text('nama orang tua hanya boleh text !').show();
		$("#pasortu").focus();
			return false;

	}else if(almt == ""){
		$("#ualm").text('alamat tidak boleh kosong !').show();
		$("#adr").focus();
		return false;
		
	}else{
		return true;
	}
}	
</script>

<!-- ubahdata -->
<script type="text/javascript">
	
	$('.eedit').click(function(){
		var pid 		=$(this).data('id');
		var pnama 		=$(this).data('nama');
		var tgllahir 	=$(this).data('tgllhr');
		var pekerjaan 	=$(this).data('pekerjaan');
		var kelamin 	=$(this).data('kelamin');
		var phone   	=$(this).data('phone');
		var nmortu   	=$(this).data('ortu');
		var alamat  	=$(this).data('alamat');

		document.getElementById('pno_id').value = pid;
		document.getElementById('pnama').value = pnama;
		document.getElementById('tgllhrubh').value = tgllahir;
		document.getElementById('paspek').value = pekerjaan;
		document.getElementById('kel').value = kelamin;
		document.getElementById('ph').value = phone;
		document.getElementById('pasortu').value = nmortu;
		document.getElementById('adr').value = alamat;
	});
</script>
<script type="text/javascript">
	$('.trash').click(function(){
		var id=$(this).data('id');
		document.getElementById('d_id').value = id;
	});
</script>
<!-- shorting data in datatable -->
<script>
	$(document).ready(function() {
		$('#sorting-table').data({
			"order": [[0,"desc"]]
		});


		$( "#tgllhr" ).datepicker({dateFormat: 'yy-mm-dd'});
          $( "#tgllhr" ).datepicker( "option", "showAnim", 'slideDown' );

        $( "#tgllhrubh" ).datepicker({dateFormat: 'yy-mm-dd'});
          $( "#tgllhrubh" ).datepicker( "option", "showAnim", 'slideDown' );
	});


</script>