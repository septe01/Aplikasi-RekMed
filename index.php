<?php
require_once 'dbconfig.php';
// jika user sudah login redirect ke home
if($user->is_loggedin()!="")

{
	$user->redirect('panel/');
}

// cek hak aksess user
if(isset($_POST['btn-login']))
{
        var_dump($_GET);
    	$uname = $_POST['txt_uname_email'];
    	$upass = $_POST['txt_password'];
        
    	if($user->login($uname,$upass))
    	{
            if(isset($_SESSION['status'])){
                if($_SESSION['status'] == 'user'){
                $user->redirect('panel/home.php?page=pasien');
                }elseif($_SESSION['status'] == 'admin'){
                    $user->redirect('panel/home.php?page=dashboard');
                }
            }

    	}
    	else
    	{
            
    		$error = $_SESSION['error'];
            
    	}	
}
?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Bunda Mulya - Login</title>
	<meta name="description" content="Elisyam is a Web App and Admin Dashboard Template built with Bootstrap 4">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Google Fonts -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="main/assets/img/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="main/assets/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="main/assets/img/favicon-16x16.png">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="main/assets/vendors/css/base/bootstrap.min.css">
    <link rel="stylesheet" href="main/assets/vendors/css/base/elisyam-1.5.min.css">
    <!-- mystyle -->
    <link rel="stylesheet" href="main/assets/vendors/css/base/style.css">
    <style>
        .alertku{
            background-color: #f8d7da !important;
            border-color: #f5c6cb !important;
            color: #721c24 !important;
            /*opacity: .7 !important;*/
        }
    </style>
    </head>
    <body>
    	<body class="bg-white">
    		<!-- Begin Container -->
    		<div class="container-fluid no-padding h-100">
    			<div class="row flex-row h-100 bg-white">
    				<!-- Begin Left Content -->
    				<div class="col-xl-8 col-lg-6 col-md-5 no-padding">
    					<div class="elisyam-bg" style="background: url(main/ini.jpg) no-repeat center center ; 
    					-webkit-background-size: cover;
    					-moz-background-size: cover;
    					-o-background-size: cover;
    					background-size: cover;">
    				</div>
    			</div>
    			<!-- End Left Content -->
    			<!-- Begin Right Content -->
    			<div class="col-xl-4 col-lg-6 col-md-7 my-auto no-padding " >
    				<!-- Begin Form -->
    				<div class="authentication-form mx-auto boxlog">
                      <div class="logo-centered">
                        <!-- db-default.html -->
                         <a href="#">
                            <img src="main/assets/img/logo.png" alt="logo">
                        </a>
                    </div>
                    <h3>Masuk Aplikasi</h3>
                    <?php
                    if(isset($error))
                        : ?>
                            
                            <div class="alert alert-danger alert-dismissible fade show boxlogin text-center alertku has-info" >
                              <i class=""></i> &nbsp; <?php echo $error; ?>
                            </div>
                        <?php
                            endif; ?>
                            <form method="post" onsubmit="return Confirm();">
                             <div class="group material-input">
                                <input type="text" class="error" id="usr" required name="txt_uname_email" autocomplete="OFF">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Username</label>                               
                            </div>
                            <div class="group material-input">
                                <input type="password" id="pass" class="error" required name="txt_password" autocomplete="OFF">
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <label>Password</label>
                            </div>
                            <div class="sign-btn text-center">
                             <button type="submit" name="btn-login" class="btn btn-primary btn-block">Masuk<i class="icon-circle-right2 position-right"></i></button>
                         </div>

                     </form>
                 </div>
                 <!-- End Form -->                        
             </div>
             <!-- End Right Content -->
         </div>
         <!-- End Row -->
     </div>
     <!-- End Container -->    
     <!-- Begin Vendor Js -->
<!--      <script src="assets/vendors/js/base/jquery.min.js"></script>
     <script src="assets/vendors/js/base/core.min.js"></script> -->
     <script src="main/assets/vendors/js/base/jquery.min.js"></script>
     <!-- <script src="../main/assets/vendors/js/base/sweetalert2.all.min.js"></script> -->
     <script>
         $(document).ready(function() {
             $('.error').click(function() {
                 $('.alert').fadeOut('slow/400/fast');
             });
         });

         document.addEventListener("DOMContentLoaded", function() {
             var elment = document.getElementsByTagName('INPUT');
             for (var i = 0; i < elment.length; i++) {
                 elment[i].oninvalid = function(e) {
                     e.target.setCustomValidity("");
                     if(!e.target.validity.valid){
                        e.target.setCustomValidity("Bagian ini harus diisi.");
                     }
                 };
                 elment[i].oninput = function(e){
                    e.target.setCustomValidity("");
                 };
             }
         })

     </script>


 </body>
 </html>