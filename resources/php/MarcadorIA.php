<?php

$idJ=$_POST['idUsr'];
$ganador=$_POST['marcador'];
require "BaseDatos.php";
$a=new BaseDato();
if($a->Iniciar()){
	$a->AMarcador($idJ,$ganador);
	$arrayResult=$a->Marcador($idJ);
	echo json_encode($arrayResult);
}else{
	echo "Hay Un Fallo De Conesión Con la BD";
}
?>