<?php

$datos1 = Array(
	"id" => 0,
	"nombre"=>"Mindustry",
	"imagen" => "imagenes/Stander.jpg",
	"imagenes" => Array(
		"imagenes/Stander1.jpg",
		"imagenes/Stander2.jpg",
		"imagenes/Stander3.jpg"
	),
	"def" => "Un tower Defense abierto centrado en la gestion de recursos",
);
 

$datos2 = Array(
	"id" => 1,
	"nombre"=>"Euro TruckSimulator2",
	"imagen" => "imagenes/pant.jpg",
	"imagenes" => Array(
		"imagenes/pant1.jpg",
		"imagenes/pant2.jpg",
		"imagenes/pant3.jpg"
	),
	"def" => "Juego de camiones muy animado"
);
$datos3 = Array(
	"id" => 1,
	"nombre"=>"Euro TruckSimulator3",
	"imagen" => "imagenes/pant.jpg",
	"imagenes" => Array(
		"imagenes/pant1.jpg",
		"imagenes/pant2.jpg",
		"imagenes/pant3.jpg"
	),
	"def" => "Juego fdsfg"
);


$datos = Array($datos1, $datos2,$datos3);

echo json_encode($datos);
?>