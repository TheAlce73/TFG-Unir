<?php


require '../../vendor/autoload.php';







use Dompdf\Dompdf;
$dompdf = new Dompdf();

ob_start(); //iniciamos un output buffer
require_once('Resultado1.php'); // llamamos el archivo que se supone contiene el html y dejamoso que se renderize
$dompdf->load_html(ob_get_clean());//y ponemos todo lo que se capturo con ob_start() para que sea capturado por DOMPDF

$dompdf->set_paper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('document.pdf');
?>