<?php
include '../dbconfig.php';
// include '../str.php';
if(!$user->is_loggedin())
{
	$user->redirect('../index.php');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Klinik Bunda Mulya</title>
	<meta name="description" content="Elisyam is a Web App and Admin Dashboard Template built with Bootstrap 4">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Google Fonts -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Montserrat:400,500,600,700","Noto+Sans:400,700"]},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="../main/assets/img/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../main/assets/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../main/assets/img/favicon-16x16.png">
	<!-- Stylesheet -->
	<link rel="stylesheet" href="../main/assets/vendors/css/base/bootstrap.min.css">
	<link rel="stylesheet" href="../main/assets/vendors/css/base/elisyam-1.5.min.css">
	<link rel="stylesheet" href="../main/assets/vendors/css/base/animate.css">
	<link rel="stylesheet" href="../main/assets/css/datatables/datatables.min.css">
	<link rel="stylesheet" href="../main/assets/css/datatables/buttons.dataTables.min.css">
	<link rel="stylesheet" href="../main/assets/css/datepicker/jquery-ui.css">
	<link rel="stylesheet" href="../main/assets/icons/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css"><!--morris chart-->
	<!-- mystyle -->
    <link rel="stylesheet" href="../main/assets/vendors/css/base/style.css">

    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    
</head>
<body id="page-top">
	<div class="page db-social">
		<?php 
		$base_url = "http://localhost/bundamulya/panel/home.php?page=";
		$basic_url = "http://localhost/bundamulya/"; 
		?>

		<!-- Main navbar -->
		<?php 
		if($_SESSION['status'] == 'admin'){
				include ('view/top.php');
			}elseif($_SESSION['status'] == 'user'){
				include ('view/topusr.php');
			} 
		?>
		<!-- /main navbar -->
		<div class="page-content d-flex align-items-stretch">

			<!-- Page header -->
			<?php include ('view/nav.php');?>
			<!-- /page header -->
			<!-- Begin Content -->
			<div class="content-inner compact">
				<div class="container-fluid"  style="min-height: 620px">
					<?php include ('class/function.php')?>
				</div>

				<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				if (strpos($actual_link, 'invoice') !== false) { echo "";}else{?>
					<footer class="main-footer">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-flex align-items-center justify-content-xl-start justify-content-lg-start justify-content-md-start justify-content-center">
								<!-- <p class="text-gradient-02">Skripsi - Septe</p> -->
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-flex align-items-center justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-center">
								<ul class="nav">
									<li class="nav-item">
										<!-- <a class="nav-link" href="documentation.html">UNPAM 2019</a> -->
										<a class="# footerr" href="documentation.html"> &copy 2019 Klinik Bunda Mulya</a>
									</li>
									<li class="nav-item">
										<!-- <a class="nav-link" href="changelog.html">2014141082</a> -->
									</li>
								</ul>
							</div>
						</div>
					</footer>
				<?php }?>
				<!-- End Page Footer -->

				<a href="#" class="go-top"><i class="la la-arrow-up"></i></a>
			</div>
		</div>
	</div>
	
	<!-- flash message -->
	<?php if (isset($success)): ?>		
		<h4 id="alert" data-text="<?php echo $success; ?>" data-judul="<?php echo $judul; ?>" data-tipe="<?php echo $type; ?>"></h4>
	<?php endif ?>

	<?php if (isset($error)): ?>		
		<h4 id="alert" data-text="<?php echo $error; ?>" data-judul="<?php echo $judul; ?>" data-tipe="<?php echo $type; ?>"></h4>
	<?php endif ?>

	<!-- Core JS files -->
	<script src="../main/assets/vendors/js/base/jquery-3.3.1.js"></script>
	<script src="../main/assets/vendors/js/base/core.min.js"></script>
	<!-- End Vendor Js -->
	<!-- Begin Page Vendor Js -->
	<script src="../main/assets/vendors/js/datatables/datatables.min.js"></script>
	<script src="../main/assets/vendors/js/datatables/dataTables.buttons.min.js"></script>
	<script src="../main/assets/vendors/js/datatables/dataTablesApi.js"></script>
	<script src="../main/assets/vendors/js/datatables/buttons.flash.min.js"></script>
	<script src="../main/assets/vendors/js/datatables/jszip.min.js"></script>
	<script src="../main/assets/vendors/js/datatables/pdfmake.min.js"></script>
	<script src="../main/assets/vendors/js/datatables/vfs_fonts.js"></script>
	<script src="../main/assets/vendors/js/datatables/buttons.html5.min.js"></script>
	<script src="../main/assets/vendors/js/datatables/buttons.print.min.js"></script>
	<script src="../main/assets/vendors/js/datepicker/jquery-ui.js"></script>

	

<script src="../main/assets/vendors/js/nicescroll/nicescroll.min.js"></script>
<script src="../main/assets/vendors/js/app/app.min.js"></script>
<!-- sweetalert -->
<!-- morris chart -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

 <script src="../main/assets/vendors/js/base/sweetalert2.all.min.js"></script>
 <script src="../main/assets/vendors/js/base/script.js"></script>
 <!-- endsweetaleert -->

<!-- End Page Vendor Js -->
<!-- Begin Page Snippets -->
<script src="../main/assets/js/components/tables/tables.js"></script>
<!-- End Page Snippets -->
<script>
	$(document).ready(function() {
	$('.list-unstyled li').click(function() {
		/* Act on the event */
		$(this).addClass('liborder').siblings().removeClass('liborder');
	});;
});	
</script>
<script>
  
</script>


</body>
</html>