<?php
require_once __DIR__ .'../../../main/assets/vendors/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();




$mpdf->WriteHTML($html);
$mpdf->Output();