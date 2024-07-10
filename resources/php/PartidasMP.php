<?php
$idJ=$_POST['idUsr'];
$accion=$_POST['Accion'];
require "BaseDatos.php";
switch ($accion) {
	case 0:
		$a=new BaseDato();
		if($a->Iniciar()){
			$juga=$a->PartidasIniciadas1($idJ);
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
			$juga=$a->APartidas($idJ,$IDPActual,$LeTocaMp,$victoria,$tablero);
			echo json_encode($juga);
		}else{
			echo "Hay Un Fallo De Conesión Con la BD";
		}
		break;
	case 2:
		$a=new BaseDato();
		echo json_encode($a->UsuariosAzar());
		break;
	case 3:
		$idContrario=$_POST['idContrario'];
		$a=new BaseDato();
		echo ($a->CrearPartida($idJ,$idContrario));	
		break;
	case 4:
		$idPartida=$_POST['idPartida'];
		$a=new BaseDato();
		echo json_encode($a->MostrarPartidaCreada($idPartida));
		break;
	case 5:
		$a=new BaseDato();
		$nombre=json_decode($_POST['nombre']);
		echo json_encode($a->SacarIdJugador($nombre));
		break;
	default:
		# code...
		break;
}

?>