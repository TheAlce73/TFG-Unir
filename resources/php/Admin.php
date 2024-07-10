<?php
$id=$_POST['id'];
$casos=$_POST['casos'];

require "BaseDatos.php";
$a=new BaseDato();
if($a->Iniciar()){
	switch ($casos) {
		case 0:
			echo json_encode($a->EliminarUser($id));
			break;
		case 1:
			echo json_encode($a->EliminarPartidaT($id));
			break;
		case 2:
			echo json_encode($a->EliminarPartidaA($id));
			break;
		default:
			break;
	}
}

?>