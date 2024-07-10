<?php

$id=$_POST['id'];
$casos=$_POST['casos'];

require "BaseDatos.php";
$a=new BaseDato();
if($a->Iniciar()){
	switch ($casos) {
		case 0:
			$nombre=$_POST['nombre'];
			echo $a->SolicitudAceptada($id,$nombre);
			break;
		case 1:
			$amigos=$a->Amigos($id);
            echo json_encode($amigos);
			break;
		case 2:
            $Solicitudes=$a->Solicitudes($id);
            echo json_encode($Solicitudes);
			break;
		case 3:
			$idJugador=$_POST['idAgregar'];
            $Agregar=$a->Agregar($id,$idJugador);
            echo $Agregar;
			break;
		
		default:
			echo "Hay Un Fallo De Conesión Con la BD";
			break;
	}
	
}else{
	echo "Hay Un Fallo De Conesión Con la BD";
}
?>