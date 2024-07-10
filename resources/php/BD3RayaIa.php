<?php

$idJ=$_POST['idUsr'];
require "BaseDatos.php";
$a=new BaseDato();
if($a->Iniciar()){
	$arrayResult=$a->Marcador($idJ);
	echo json_encode($arrayResult);
}else{
	echo "Hay Un Fallo De Conesión Con la BD";
}
?>