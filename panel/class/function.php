<?php

$action='home';

$pages_dir = 'page';				


if($_SESSION['status'] == 'admin'){

	if(!empty($_GET['page'])){

	$atas = scandir($pages_dir, 0);
	unset($atas[0], $atas[1]);

	$p = $_GET['page'];

		if(in_array($p.'.php', $atas)){

			include($pages_dir.'/'.$p.'.php');

		} else {

			echo '<div class="container-fluid text-center">

					<h1 class="error-title">404</h1>

					<h6 class="text-semibold content-group">Oops, an error has occurred. Page not found!</h6>

				</div>';

				$url='../';

				echo '<META HTTP-EQUIV=REFRESH CONTENT="5; '.$url.'">';

		}

	} else {include($pages_dir.'/dashboard.php');

	}			
}elseif($_SESSION['status'] == 'user'){

	if(!empty($_GET['page'])){

	$atas = scandir($pages_dir, 0);
	unset($atas[0], $atas[1]);

	$p = $_GET['page'];

		if(in_array($p.'.php', $atas)){

			include($pages_dir.'/'.$p.'.php');

		} else {

			echo '<div class="container-fluid text-center">

					<h1 class="error-title">404</h1>

					<h6 class="text-semibold content-group">Oops, an error has occurred. Page not found!</h6>

				</div>';

				$url='../';

				echo '<META HTTP-EQUIV=REFRESH CONTENT="5; '.$url.'">';

		}

	} else {include($pages_dir.'/pasien.php');

	}			
}

?>	