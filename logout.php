<?php

require_once 'dbconfig.php';



if($_SESSION['user_session']!="")

{

	$user->redirect($basic_url);

}

if(isset($_GET['logout']) && $_GET['logout']=="true")

{

	$user->logout();

	$user->redirect($basic_url);

}

if(!isset($_SESSION['user_session']))

{

	$user->redirect($basic_url);

}