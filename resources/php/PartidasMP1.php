<?php
$idJ=$_POST['idUsr'];
$accion=$_POST['Accion'];
require "BaseDatos.php";
switch ($accion) {
	case 0:
		$a=new BaseDato();
		if($a->Iniciar()){
			$juga=$a->PartidasIniciadas2($idJ);
			echo json_encode($juga);
		}else{
			echo "Hay Un Fallo De Conesión Con la BD";
		}
		break;
	case 1:
		$IDPActual=$_POST['IDPActual'];
		$LeTocaMp=$_POST['LeTocaMp'];
		$victoria=$_POST['victoria'];
		$tablero=$_POST['tablero'];
		$a=new BaseDato();
		if($a->Iniciar()){
			$juga=$a->APartidas1($idJ,$IDPActual,$LeTocaMp,$victoria,$tablero);
			echo json_encode($juga);
		}else{
			echo "Hay Un Fallo De Conesión Con la BD";
		}
		break;
	case 2:
		$idContrario=$_POST['idContrario'];
		$a=new BaseDato();
		echo ($a->CrearPartidaA($idJ,$idContrario));	
		break;
	case 3:
		$idPartida=$_POST['idPartida'];
		$a=new BaseDato();
		echo json_encode($a->MostrarPartidaCreadaA($idPartida));
		break;
	default:
		# code...
		break;
}
?>