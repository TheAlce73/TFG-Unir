<?php
$numero=$_POST['numero'];
//Primera Parte Sacar Tablero 0 en switch
$tablero1=[
	["Tn","Cn","An","Qn","Kn","An","Cn","Tn"],
	["Pn","Pn","Pn","Pn","Pn","Pn","Pn","Pn"],
	["-","-","-","-","-","-","-","-"],	
	["-","-","-","-","-","-","-","-"],
	["-","-","-","-","-","-","-","-"],
	["-","-","-","-","-","-","-","-"],
	["Pb","Pb","Pb","Pb","Pb","Pb","Pb","Pb"],
	["Tb","Cb","Ab","Qb","Kb","Ab","Cb","Tb"],
];
$tablero2=[
	["Tb","Cb","Ab","Qb","Kb","Ab","Cb","Tb"],
	["Pb","Pb","Pb","Pb","Pb","Pb","Pb","Pb"],
	["-","-","-","-","-","-","-","-"],	
	["-","-","-","-","-","-","-","-"],
	["-","-","-","-","-","-","-","-"],
	["-","-","-","-","-","-","-","-"],
	["Pn","Pn","Pn","Pn","Pn","Pn","Pn","Pn"],
	["Tn","Cn","An","Qn","Kn","An","Cn","Tn"],
];
$tableroT=[$tablero1,$tablero2];
function evaluarTablero($tablero, $color) {
	$ValorPieza = [
	   	'P'=> 1,
	    'A'=> 3.5,
	    'C'=> 3.5,
	    'T'=> 5.25,
	    'Q'=> 10,
	    'K'=> 1000,
	];
	$valor = 0;
	forEach($tablero as $filas) {
	 	forEach($filas as $pieza) {
	      	if ($pieza!="-") {
	        	if (substr($pieza,1,2) === $color) {
	        		$valor+=$ValorPieza[substr($pieza,0,1)];
	        	}else{
	        		$valor-=$ValorPieza[substr($pieza,0,1)];
	        		
	        	}
	      	}
	    }
	}

	return $valor;
};

//Funcion MinMAX
function minimaxM($tablero,$maximizando,$profundidad,$t,$colorIA,$colorJ){
	if ($profundidad==0) {
		$valor=evaluarTablero($tablero,$colorIA);
		return $valor;
	}
	if ($maximizando) {
		$MejorPuntuacion = INF;
		$posibles[$t]=posiblesMovimientosJ($tablero,$colorJ,$colorIA);
	  	for ($i = 0; $i < count($posibles[$t]); $i++) {
	  		$posicionInicial[$t]=$posibles[$t][$i][0];
	    	for ($p = 1; $p < count($posibles[$t][$i]); $p++) {
	    		$posicionFinal[$t]=$posibles[$t][$i][$p];		
				$nUI[$t]=substr($posicionInicial[$t],0,1);
			 	$nDI[$t]=substr($posicionInicial[$t],1,2);
			 	$nUF[$t]=substr($posicionFinal[$t],0,1);
			 	$nDF[$t]=substr($posicionFinal[$t],1,2);
			 	$fichaUno[$t]=$tablero[$nUI[$t]][$nDI[$t]];
			 	$fichaDos[$t]=$tablero[$nUF[$t]][$nDF[$t]];
			 	$tablero[$nUF[$t]][$nDF[$t]]=$fichaUno[$t];
			 	$tablero[$nUI[$t]][$nDI[$t]]="-";
			 	$t++;
			 	$valor=minimaxM($tablero,false,$profundidad-1,$t,$colorIA,$colorJ);
			 	if ($MejorPuntuacion>$valor) {
			 		$MejorPuntuacion=$valor;
			 	}
			 	$t--;
			 	$tablero[$nUF[$t]][$nDF[$t]]=$fichaDos[$t];
			 	$tablero[$nUI[$t]][$nDI[$t]]=$fichaUno[$t];
	    	}
	    }
	}else{
		$MejorPuntuacion = -INF;
		$posibles[$t]=posiblesMovimientosIA($tablero,$colorIA,$colorJ);
	  	for ($i = 0; $i < count($posibles[$t]); $i++) {
	  		$posicionInicial[$t]=$posibles[$t][$i][0];
	    	for ($p = 1; $p < count($posibles[$t][$i]); $p++) {
	    		
	    		$posicionFinal[$t]=$posibles[$t][$i][$p];	
				$nUI[$t]=substr($posicionInicial[$t],0,1);
			 	$nDI[$t]=substr($posicionInicial[$t],1,2);
			 	$nUF[$t]=substr($posicionFinal[$t],0,1);
			 	$nDF[$t]=substr($posicionFinal[$t],1,2);
			 	$fichaUno[$t]=$tablero[$nUI[$t]][$nDI[$t]];
			 	$fichaDos[$t]=$tablero[$nUF[$t]][$nDF[$t]];
			 	$tablero[$nUF[$t]][$nDF[$t]]=$fichaUno[$t];
			 	$tablero[$nUI[$t]][$nDI[$t]]="-";
			 	$t++;
			 	$valor=minimaxM($tablero,true,$profundidad-1,$t,$colorIA,$colorJ);
			 	$t--;
			 	if ($MejorPuntuacion<$valor) {
			 		$MejorPuntuacion=$valor;
			 	}
			 	$tablero[$nUF[$t]][$nDF[$t]]=$fichaDos[$t];
			 	$tablero[$nUI[$t]][$nDI[$t]]=$fichaUno[$t];
	    	}
	    }
	}
	
	return $MejorPuntuacion;
}
//Segunda Parte Mobimientos 1 en switch
switch ($numero) {
	case 0:
		echo json_encode($tableroT);
		break;
	case 1:
		$ColorFicha=$_POST['ColorFicha'];
		$TipoFicha=$_POST['TipoFicha'];
		$tablero=json_decode($_POST['tablero']);
		$lugar=json_decode($_POST['lugar']);
		if ($ColorFicha=="b") {
			$ColorVs="n";
		}else{
			$ColorVs="b";
		}
		$i=$_POST['i'];
		$j=$_POST['j'];
		if ($ColorFicha=="b"||$ColorFicha=="n") {
		//Movimiento Peon
			if ($TipoFicha=="P") {
				if ($lugar[1]==$j&&$tablero[$lugar[0]-1][$lugar[1]]=="-") {
					if ($lugar[0]==6) {
						if (($lugar[0]-$i)==1||($lugar[0]-$i)==2) {
							$mobimientoValido=true;
						}else{
							$mobimientoValido="Elije un lugar Correcto";
						}
					}else{
						if (($lugar[0]-$i)==1) {
							$mobimientoValido=true;
						}else{
							$mobimientoValido="Elije un lugar Correcto";
						}
					}	
				}else if (($lugar[0]-$i)==1&&(($lugar[1]-$j)==-1||($lugar[1]-$j)==1)&&$tablero[$i][$j]!="-"){
					$Casilla2=$tablero[$i][$j];
					$ColorFichaEnemiga=substr($Casilla2,1,2);
					if ($ColorFichaEnemiga==$ColorVs) {
						$mobimientoValido=true;
					}else{
						$mobimientoValido="Elije un lugar Correcto";
					}
				}else{
					$mobimientoValido="Elije un lugar Correcto";
				}
			}
		//Movimiento Caballo
			if ($TipoFicha=="C") {
				if ((($lugar[0]-$i)==2&&(($lugar[1]-$j)==-1||($lugar[1]-$j)==1)) || (($lugar[0]-$i)==-2&&(($lugar[1]-$j)==-1||($lugar[1]-$j)==1)) || (($lugar[1]-$j)==-2&&(($lugar[0]-$i)==-1||($lugar[0]-$i)==1)) || (($lugar[1]-$j)==2&&(($lugar[0]-$i)==-1||($lugar[0]-$i)==1))) {
					if ($tablero[$i][$j]!="-") {
						$Casilla2=$tablero[$i][$j];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($ColorFichaEnemiga==$ColorVs) {
							$mobimientoValido=true;
						}else{
							$mobimientoValido="Elije un lugar Correcto";
						}
					}else{
						$mobimientoValido=true;
					}
				}else{
					$mobimientoValido="Elije un lugar Correcto";
				}
			}
		//Movimiento Torre
			if ($TipoFicha=="T") {
				if ($lugar[0]==$i||$lugar[1]==$j) {
					$x=0;
					for ($r = $lugar[0]; $r > $i; $r--) {
						
						if ($tablero[$r-1][$j]!="-") {
							$x++;
						}
					}
					for ($r = $lugar[0]; $r < $i; $r++) {
						
						if ($tablero[$r+1][$j]!="-") {
							$x++;
						}
					}
					for ($r = $lugar[1]; $r < $j; $r++) {
						if ($tablero[$i][$r+1]!="-") {
							$x++;
						}
					}
					for ($r = $lugar[1]; $r > $j; $r--) {
						if ($tablero[$i][$r-1]!="-") {
							$x++;
						}
					}
					if ($x==1) {
						$Casilla2=$tablero[$i][$j];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($ColorFichaEnemiga==$ColorVs) {
							$mobimientoValido=true;
						}else{
							$mobimientoValido="Elije un lugar Correcto";
						}
					}else if($x==0){
						$mobimientoValido=true;
					}else{
						$mobimientoValido="Elije un lugar Correcto";
					}
				}else{
					$mobimientoValido="Elije un lugar Correcto";
				}
			}
			//Movimiento Alfil
			function comprobarAlfil($p,$lugar,$i,$j){
				return ($lugar[0]==($i+$p)&&$lugar[1]==($j+$p))||($lugar[0]==($i+$p)&&$lugar[1]==($j-$p))||($lugar[0]==($i-$p)&&$lugar[1]==($j+$p))||($lugar[0]==($i-$p)&&$lugar[1]==($j-$p));
			}
			if ($TipoFicha=="A") {
				if (comprobarAlfil(1,$lugar,$i,$j)||comprobarAlfil(2,$lugar,$i,$j)||comprobarAlfil(3,$lugar,$i,$j)||comprobarAlfil(4,$lugar,$i,$j)||comprobarAlfil(5,$lugar,$i,$j)||comprobarAlfil(6,$lugar,$i,$j)||comprobarAlfil(7,$lugar,$i,$j)) {
					$x=0;
					if ($lugar[0]>$i&&$lugar[1]>$j) {
						$vecesi=$lugar[0]-1;
						$vecesj=$lugar[1]-1;
						for($r=$lugar[0]-$i;$r>0;$r--){
							if ($tablero[$vecesi][$vecesj]!="-") {
								$x++;
							}
							$vecesi--;
							$vecesj--;
						}
					}
					if ($lugar[0]>$i&&$lugar[1]<$j) {
						$vecesi=$lugar[0]-1;
						$vecesj=$lugar[1]+1;
						for($r=$lugar[0]-$i;$r>0;$r--){
							if ($tablero[$vecesi][$vecesj]!="-") {
								$x++;
							}
							$vecesi--;
							$vecesj++;
						}
					}
					if ($lugar[0]<$i&&$lugar[1]<$j) {
						$vecesi=$lugar[0]+1;
						$vecesj=$lugar[1]+1;
						for($r=$i-$lugar[0];$r>0;$r--){
							if ($tablero[$vecesi][$vecesj]!="-") {
								$x++;
							}
							$vecesi++;
							$vecesj++;
						}
					}

					if ($lugar[0]<$i&&$lugar[1]>$j) {
						$vecesi=$lugar[0]+1;
						$vecesj=$lugar[1]-1;
						for($r=$i-$lugar[0];$r>0;$r--){
							if ($tablero[$vecesi][$vecesj]!="-") {
								$x++;
							}
							$vecesi++;
							$vecesj--;
						}
					}
					if ($x==1) {
						$Casilla2=$tablero[$i][$j];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($ColorFichaEnemiga==$ColorVs) {
							$mobimientoValido=true;
						}else{
							$mobimientoValido="Elije un lugar Correcto";
						}
					}else if($x==0){
						$mobimientoValido=true;
					}else{
						$mobimientoValido="Elije un lugar Correcto";
					}
				}else{
					$mobimientoValido="Elije un lugar Correcto";
				}
			}
			//Movimiento Reina
			if ($TipoFicha=="Q") {
				if ($lugar[0]==$i||$lugar[1]==$j) {
					$x=0;
					for ($r = $lugar[0]; $r > $i; $r--) {
						
						if ($tablero[$r-1][$j]!="-") {
							$x++;
						}
					}
					for ($r = $lugar[0]; $r < $i; $r++) {
						
						if ($tablero[$r+1][$j]!="-") {
							$x++;
						}
					}
					for ($r = $lugar[1]; $r < $j; $r++) {
						if ($tablero[$i][$r+1]!="-") {
							$x++;
						}
					}
					for ($r = $lugar[1]; $r > $j; $r--) {
						if ($tablero[$i][$r-1]!="-") {
							$x++;
						}
					}
					if ($x==1) {
						$Casilla2=$tablero[$i][$j];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($ColorFichaEnemiga==$ColorVs) {
							$mobimientoValido=true;
						}else{
							$mobimientoValido="Elije un lugar Correcto";
						}
					}else if($x==0){
						$mobimientoValido=true;
					}else{
						$mobimientoValido="Elije un lugar Correcto";
					}
				}else if (comprobarAlfil(1,$lugar,$i,$j)||comprobarAlfil(2,$lugar,$i,$j)||comprobarAlfil(3,$lugar,$i,$j)||comprobarAlfil(4,$lugar,$i,$j)||comprobarAlfil(5,$lugar,$i,$j)||comprobarAlfil(6,$lugar,$i,$j)||comprobarAlfil(7,$lugar,$i,$j)) {
					$x=0;
					if ($lugar[0]>$i&&$lugar[1]>$j) {
						$vecesi=$lugar[0]-1;
						$vecesj=$lugar[1]-1;
						for($r=$lugar[0]-$i;$r>0;$r--){
							if ($tablero[$vecesi][$vecesj]!="-") {
								$x++;
							}
							$vecesi--;
							$vecesj--;
						}
					}
					if ($lugar[0]>$i&&$lugar[1]<$j) {
						$vecesi=$lugar[0]-1;
						$vecesj=$lugar[1]+1;
						for($r=$lugar[0]-$i;$r>0;$r--){
							if ($tablero[$vecesi][$vecesj]!="-") {
								$x++;
							}
							$vecesi--;
							$vecesj++;
						}
					}

					if ($lugar[0]<$i&&$lugar[1]<$j) {
						$vecesi=$lugar[0]+1;
						$vecesj=$lugar[1]+1;
						for($r=$i-$lugar[0];$r>0;$r--){
							if ($tablero[$vecesi][$vecesj]!="-") {
								$x++;
							}
							$vecesi++;
							$vecesj++;
						}
					}

					if ($lugar[0]<$i&&$lugar[1]>$j) {
						$vecesi=$lugar[0]+1;
						$vecesj=$lugar[1]-1;
						for($r=$i-$lugar[0];$r>0;$r--){
							if ($tablero[$vecesi][$vecesj]!="-") {
								$x++;
							}
							$vecesi++;
							$vecesj--;
						}
					}
					if ($x==1) {
						$Casilla2=$tablero[$i][$j];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($ColorFichaEnemiga==$ColorVs) {
							$mobimientoValido=true;
						}else{
							$mobimientoValido="Elije un lugar Correcto";
						}
					}else if($x==0){
						$mobimientoValido=true;
					}else{
						$mobimientoValido="Elije un lugar Correcto";
					}
				}else{
					$mobimientoValido="Elije un lugar Correcto";
				}
			}
			//Movimiento del Rey
			if ($TipoFicha=="K") {
				if ($lugar[0]==$i+1&&$lugar[1]==$j||$lugar[0]==$i+1&&$lugar[1]==$j+1||$lugar[0]==$i+1&&$lugar[1]==$j-1||$lugar[0]==$i-1&&$lugar[1]==$j||$lugar[0]==$i-1&&$lugar[1]==$j-1||$lugar[0]==$i-1&&$lugar[1]==$j+1||$lugar[0]==$i&&$lugar[1]==$j-1||$lugar[0]==$i&&$lugar[1]==$j+1) {
					if ($tablero[$i][$j]=="-") {
						$mobimientoValido=true;
					}else{
						$Casilla2=$tablero[$i][$j];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($ColorFichaEnemiga==$ColorVs) {
							$mobimientoValido=true;
						}else{
							$mobimientoValido="Elije un lugar Correcto";
						}
					}
				}else{
					$mobimientoValido="Elije un lugar Correcto";
				}
			}
			echo $mobimientoValido;
		}
		break;
		case 2:
		$tablero=json_decode($_POST['tablero']);
		$colorIA=$_POST["colorIA"];
		$colorJ=$_POST["colorJ"];
		$t=0;
		$MejorPuntuacion = -INF;
	  	$posibles[$t]=posiblesMovimientosIA($tablero,$colorIA,$colorJ);
	  	for ($i = 0; $i < count($posibles[$t]); $i++) {
	  		$posicionInicial[$t]=$posibles[$t][$i][0];
	    	for ($p = 1; $p < count($posibles[$t][$i]); $p++) {
	    		$posicionFinal[$t]=$posibles[$t][$i][$p];
				$nUI[$t]=substr($posicionInicial[$t],0,1);
			 	$nDI[$t]=substr($posicionInicial[$t],1,2);
			 	$nUF[$t]=substr($posicionFinal[$t],0,1);
			 	$nDF[$t]=substr($posicionFinal[$t],1,2);
			 	$fichaUno[$t]=$tablero[$nUI[$t]][$nDI[$t]];
			 	$fichaDos[$t]=$tablero[$nUF[$t]][$nDF[$t]];
			 	$tablero[$nUF[$t]][$nDF[$t]]=$fichaUno[$t];
			 	$tablero[$nUI[$t]][$nDI[$t]]="-";
			 	$t++;
			 	$valor=minimaxM($tablero,true,1,$t,$colorIA,$colorJ);
			 	$t--;
			 	if ($MejorPuntuacion<$valor) {
			 		$MejorPuntuacion=$valor;
			 		$movimientoIAFinal[0]=$posicionInicial[$t];
			 		$movimientoIAFinal[1]=$posicionFinal[$t];
			 	}
			 	$tablero[$nUF[$t]][$nDF[$t]]=$fichaDos[$t];
			 	$tablero[$nUI[$t]][$nDI[$t]]=$fichaUno[$t];
	    	}
	    }
	    $NUI=substr($movimientoIAFinal[0],0,1);
		$NDI=substr($movimientoIAFinal[0],1,2);
		$NUF=substr($movimientoIAFinal[1],0,1);
		$NDF=substr($movimientoIAFinal[1],1,2);
		$fichaUno1=$tablero[$NUI][$NDI];
		$fichaDos1=$tablero[$NUF][$NDF];
		$tablero[$NUF][$NDF]=$fichaUno1;
		$tablero[$NUI][$NDI]="-";
		$LeToca="J";
		echo json_encode($tablero);
		break;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////MOVIMIENTOS IA///////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function posiblesMovimientosIA($tablero,$colorIA,$colorJ){
	$x=0;
	$y=0;
	//Mobi Peon
	for ($i = 0; $i < 8; $i++) {
		for ($p = 0; $p < 8; $p++) {
			if (substr($tablero[$i][$p],0,1)=="P"&&substr($tablero[$i][$p],1,2)==$colorIA) {	
				$movimientoP[$x][$y]=$i."".$p;
				$y++;				
				if (($i+1)<=7) {
					if ($tablero[$i+1][$p]=="-") {
						$movimientoP[$x][$y]=($i+1)."".$p;
						$y++;
					}
					if ($i==1){
						if ($tablero[$i+2][$p]=="-"&&$tablero[$i+1][$p]=="-") {
							$movimientoP[$x][$y]=($i+2)."".$p;
							$y++;
						}
					}
					if ($p==0) {
						$Casilla2=$tablero[$i+1][$p+1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($tablero[$i+1][$p+1]!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i+1)."".($p+1);
							$y++;
						}
					}else if($p==7){
						$Casilla2=$tablero[$i+1][$p-1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($tablero[$i+1][$p-1]!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i+1)."".($p-1);
							$y++;
						}
					}else{
						$Casilla2=$tablero[$i+1][$p+1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($tablero[$i+1][$p+1]!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i+1)."".($p+1);
							$y++;
						}
						$Casilla2=$tablero[$i+1][$p-1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($tablero[$i+1][$p-1]!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i+1)."".($p-1);
							$y++;
						}
					}
				}
				$x++;
				$y=0;
			}
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
			//Caballo
			if (substr($tablero[$i][$p],0,1)=="C"&&substr($tablero[$i][$p],1,2)==$colorIA) {
				$movimientoP[$x][$y]=$i."".$p;
				$y++;
				//Abajo izquierda
				if (($i+2)<=7&&($p-1)>=0) {
					if ($tablero[$i+2][$p-1]=="-") {
						$movimientoP[$x][$y]=($i+2)."".($p-1);
						$y++;
					}
					else{
						$Casilla2=$tablero[$i+2][$p-1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i+2)."".($p-1);
							$y++;
						}
					}
				}
				//Abajo derecha
				if (($i+2)<=7&&($p+1)<=7) {
					if ($tablero[$i+2][$p+1]=="-") {
						$movimientoP[$x][$y]=($i+2)."".($p+1);
						$y++;
					}
					else{
						$Casilla2=$tablero[$i+2][$p+1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i+2)."".($p+1);
							$y++;
						}
					}
				}
				//Arriba Izquierda
				if (($i-2)>=0&&($p-1)>=0) {
					if (($tablero[$i-2][$p-1]=="-")) {
						$movimientoP[$x][$y]=($i-2)."".($p-1);
						$y++;
					}else{
						$Casilla2=$tablero[$i-2][$p-1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i-2)."".($p-1);
							$y++;
						}
					}
				}
				//Arriba Derecha
				if (($i-2)>=0&&($p+1)<=7) {
					if (($tablero[$i-2][$p+1]=="-")) {
						$movimientoP[$x][$y]=($i-2)."".($p+1);
						$y++;
					}else{
						$Casilla2=$tablero[$i-2][$p+1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i-2)."".($p+1);
							$y++;
						}
					}
				}
				//Izquierda Arriba
				if (($i-1)>=0&&($p-2)>=0) {
					if ($tablero[$i-1][$p-2]=="-") {
						$movimientoP[$x][$y]=($i-1)."".($p-2);
						$y++;
					}
					else{
						$Casilla2=$tablero[$i-1][$p-2];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i-1)."".($p-2);
							$y++;
						}
					}
				}
				//Izquierda Abajo
				if (($i+1)<=7&&($p-2)>=0) {
					if ($tablero[$i+1][$p-2]=="-") {
						$movimientoP[$x][$y]=($i+1)."".($p-2);
						$y++;
					}
					else{
						$Casilla2=$tablero[$i+1][$p-2];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i+1)."".($p-2);
							$y++;
						}
					}
				}
				//Derecha arriba
				if (($i-1)>=0&&($p+2)<=7) {
					if ($tablero[$i-1][$p+2]=="-") {
						$movimientoP[$x][$y]=($i-1)."".($p+2);
						$y++;
					}else{
						$Casilla2=$tablero[$i-1][$p+2];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i-1)."".($p+2);
							$y++;
						}
					}
				}
				//Derecha abajo
				if (($i+1)<=7&&($p+2)<=7) {
					if ($tablero[$i+1][$p+2]=="-") {
						$movimientoP[$x][$y]=($i+1)."".($p+2);
						$y++;
					}else{
						$Casilla2=$tablero[$i+1][$p+2];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i+1)."".($p+2);
							$y++;
						}
					}
				}	
				$x++;
				$y=0;
			}
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
			//Movimiento Torre
			if (substr($tablero[$i][$p],0,1)=="T"&&substr($tablero[$i][$p],1,2)==$colorIA) {
			
				$movimientoP[$x][$y]=$i."".$p;
				$y++;
				//Hacia arriba
				$tamañoArriba=0;
				for($arriba=$i-1;$arriba>=$tamañoArriba;$arriba--){
					if ($arriba>=0) {
						if (substr($tablero[$arriba][$p],1,2)==$colorIA) {
							$arriba=0;
						}else if(substr($tablero[$arriba][$p],1,2)==$colorJ){
							$movimientoP[$x][$y]=$arriba."".$p;
							$y++;
							$arriba=0;
						}else{
							$movimientoP[$x][$y]=$arriba."".$p;
							$y++;
						}
					}
				}
				//Hacia Abajo
				$tamañoBaja=8;
				for($abajo=$i+1;$abajo<$tamañoBaja;$abajo++){
					if($abajo<=7){
						if (substr($tablero[$abajo][$p],1,2)==$colorIA) {
							$abajo=8;
						}else if (substr($tablero[$abajo][$p],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$abajo."".$p;
							$y++;
							$abajo=8;
						}else{
							$movimientoP[$x][$y]=$abajo."".$p;
							$y++;
						}
					}
				}
				//Hacia Derecha
				$tamañoDerecha=8;
				for($derecha=$p+1;$derecha<=$tamañoDerecha;$derecha++){
					if($derecha<=7){
						if (substr($tablero[$i][$derecha],1,2)==$colorIA) {
							$derecha=8;
						}else if(substr($tablero[$i][$derecha],1,2)==$colorJ){
							$movimientoP[$x][$y]=$i."".$derecha;
							$y++;
							$derecha=8;
						}else{
							$movimientoP[$x][$y]=$i."".$derecha;
							$y++;
						}
					}
				}
				//Hacia Izquierda
				$tamañoIzquierda=0;
				for($izquierda=$p-1;$izquierda>=$tamañoIzquierda;$izquierda--){
					if ($p>=0) {
						if (substr($tablero[$i][$izquierda],1,2)==$colorIA) {
							$izquierda=0;
						}else if(substr($tablero[$i][$izquierda],1,2)==$colorJ){
							$movimientoP[$x][$y]=$i."".$izquierda;
							$y++;
							$izquierda=0;
						}else{
							$movimientoP[$x][$y]=$i."".$izquierda;
							$y++;
						}
					}	
				}
				$x++;
				$y=0;
			}
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
			//Mobimientos Alfil
			if (substr($tablero[$i][$p],0,1)=="A"&&substr($tablero[$i][$p],1,2)==$colorIA) {
				$movimientoP[$x][$y]=$i."".$p;
				$y++;
				//Diagonal Izquierda Arriba
				$tamañoDIa=-1;
				$ejexD=$p-1;
				for ($ejeyD = $i-1; $ejeyD >= $tamañoDIa; $ejeyD--) {
					if ($ejeyD>=0&&$ejexD>=0) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamañoDIa;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamañoDIa;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD--;
					}
				}
				//Diagonal Derecha Arriba
				$tamañoDDa=-1;
				$ejexD=$p+1;
				for ($ejeyD = $i-1; $ejeyD >= $tamañoDDa; $ejeyD--) {
					if ($ejeyD>=0&&$ejexD<=7) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamañoDDa;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamañoDDa;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD++;
					}
				}
				//Diagonal Izquierda Abajo
				$tamañoDIb=8;
				$ejexD=$p-1;
				for ($ejeyD = $i+1; $ejeyD < $tamañoDIb; $ejeyD++) {
					if ($ejeyD<=7&&$ejexD>=0) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamañoDIb;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamañoDIb;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD--;
					}
				}
				//Diagonal Derecha Abajo
				$tamñaoDDb=8;
				$ejexD=$p+1;
				for ($ejeyD = $i+1; $ejeyD <= $tamñaoDDb; $ejeyD++) {
					if ($ejeyD<=7&&$ejexD<=7) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamñaoDDb;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamñaoDDb;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD++;
					}
				}
				$x++;
				$y=0;
			}
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
			//Reina
			if (substr($tablero[$i][$p],0,1)=="Q"&&substr($tablero[$i][$p],1,2)==$colorIA) {
				$movimientoP[$x][$y]=$i."".$p;
				$y++;
				//Hacia arriba
				$tamañoArriba=0;
				for($arriba=$i-1;$arriba>=$tamañoArriba;$arriba--){
					if ($arriba>=0) {
						if (substr($tablero[$arriba][$p],1,2)==$colorIA) {
							$arriba=0;
						}else if(substr($tablero[$arriba][$p],1,2)==$colorJ){
							$movimientoP[$x][$y]=$arriba."".$p;
							$y++;
							$arriba=0;
						}else{
							$movimientoP[$x][$y]=$arriba."".$p;
							$y++;
						}
					}
				}
				//Hacia Abajo
				$tamañoBaja=8;
				for($abajo=$i+1;$abajo<$tamañoBaja;$abajo++){
					if($abajo<=7){
						if (substr($tablero[$abajo][$p],1,2)==$colorIA) {
							$abajo=8;
						}else if (substr($tablero[$abajo][$p],1,2)==$colorJ) {

							$movimientoP[$x][$y]=$abajo."".$p;
							$y++;
							$abajo=8;
						}else{
							$movimientoP[$x][$y]=$abajo."".$p;
							$y++;
						}
					}
				}
				//Hacia Derecha
				$tamañoDerecha=8;
				for($derecha=$p+1;$derecha<=$tamañoDerecha;$derecha++){
					if($derecha<=7){
						if (substr($tablero[$i][$derecha],1,2)==$colorIA) {
							$derecha=8;
						}else if(substr($tablero[$i][$derecha],1,2)==$colorJ){
							$movimientoP[$x][$y]=$i."".$derecha;
							$y++;
							$derecha=8;
						}else{
							$movimientoP[$x][$y]=$i."".$derecha;
							$y++;
						}
					}
				}
				//Hacia Izquierda
				$tamañoIzquierda=0;
				for($izquierda=$p-1;$izquierda>=$tamañoIzquierda;$izquierda--){
					if ($p>=0) {
						if (substr($tablero[$i][$izquierda],1,2)==$colorIA) {
							$izquierda=0;
						}else if(substr($tablero[$i][$izquierda],1,2)==$colorJ){
							$movimientoP[$x][$y]=$i."".$izquierda;
							$y++;
							$izquierda=0;
						}else{
							$movimientoP[$x][$y]=$i."".$izquierda;
							$y++;
						}
					}	
				}
				//Diagonal Izquierda Arriba
				$tamañoDIa=-1;
				$ejexD=$p-1;
				for ($ejeyD = $i-1; $ejeyD >= $tamañoDIa; $ejeyD--) {
					if ($ejeyD>=0&&$ejexD>=0) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamañoDIa;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamañoDIa;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD--;
					}
				}
				//Diagonal Derecha Arriba
				$tamañoDDa=-1;
				$ejexD=$p+1;
				for ($ejeyD = $i-1; $ejeyD >= $tamañoDDa; $ejeyD--) {
					if ($ejeyD>=0&&$ejexD<=7) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamañoDDa;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamañoDDa;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD++;
					}
				}
				//Diagonal Izquierda Abajo
				$tamañoDIb=8;
				$ejexD=$p-1;
				for ($ejeyD = $i+1; $ejeyD < $tamañoDIb; $ejeyD++) {
					if ($ejeyD<=7&&$ejexD>=0) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamañoDIb;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamañoDIb;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD--;
					}
				}
				//Diagonal Derecha Abajo
				$tamñaoDDb=8;
				$ejexD=$p+1;
				for ($ejeyD = $i+1; $ejeyD <= $tamñaoDDb; $ejeyD++) {
					if ($ejeyD<=7&&$ejexD<=7) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamñaoDDb;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamñaoDDb;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD++;
					}
				}
				$x++;
				$y=0;
			}
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
			if (substr($tablero[$i][$p],0,1)=="K"&&substr($tablero[$i][$p],1,2)==$colorIA) {
				$movimientoP[$x][$y]=$i."".$p;
				$y++;
				//Arriba 1
				if(($i-1)>=0){
					if ($tablero[$i-1][$p]=="-") {
						$movimientoP[$x][$y]=($i-1)."".$p;
						$y++;
					}else if (substr($tablero[$i-1][$p],1,2)==$colorJ){
						$movimientoP[$x][$y]=($i-1)."".$p;
						$y++;
					}
				}
				//Abajo 1
				if(($i+1)<=7){
					if ($tablero[$i+1][$p]=="-") {
						$movimientoP[$x][$y]=($i+1)."".$p;
						$y++;
					}else if (substr($tablero[$i+1][$p],1,2)==$colorJ){
						$movimientoP[$x][$y]=($i+1)."".$p;
						$y++;
					}
				}
				//Derecha 1
				if(($p+1)<=7){
					if ($tablero[$i][$p+1]=="-") {
						$movimientoP[$x][$y]=$i."".($p+1);
						$y++;
					}else if (substr($tablero[$i][$p+1],1,2)==$colorJ){
						$movimientoP[$x][$y]=$i."".($p+1);
						$y++;
					}
				}
				//Izquierda 1
				if(($p-1)>=0){
					if ($tablero[$i][$p-1]=="-") {
						$movimientoP[$x][$y]=$i."".($p-1);
						$y++;
					}else if (substr($tablero[$i][$p-1],1,2)==$colorJ){
						$movimientoP[$x][$y]=$i."".($p-1);
						$y++;
					}
				}
				//Diagonal IAr 1
				if (($i-1)>=0&&($p-1)>=0) {
					if ($tablero[$i-1][$p-1]=="-") {
						$movimientoP[$x][$y]=($i-1)."".($p-1);
						$y++;
					}else if (substr($tablero[$i-1][$p-1],1,2)==$colorJ){
						$movimientoP[$x][$y]=($i-1)."".($p-1);
						$y++;
					}
				}
				//Diagonal IAb 1
				if (($i+1)<=7&&($p-1)>=0) {
					if ($tablero[$i+1][$p-1]=="-") {
						$movimientoP[$x][$y]=($i+1)."".($p-1);
						$y++;
					}else if (substr($tablero[$i+1][$p-1],1,2)==$colorJ){
						$movimientoP[$x][$y]=($i+1)."".($p-1);
						$y++;
					}
				}
				//Diagonal DAb 1
				if (($i+1)<=7&&($p+1)<=7) {
					if ($tablero[$i+1][$p+1]=="-") {
						$movimientoP[$x][$y]=($i+1)."".($p+1);
						$y++;
					}else if (substr($tablero[$i+1][$p+1],1,2)==$colorJ){
						$movimientoP[$x][$y]=($i+1)."".($p+1);
						$y++;
					}
				}
				//Diagonal DAr 1
				if (($i-1)>=0&&($p+1)<=7) {
					if ($tablero[$i-1][$p+1]=="-") {
						$movimientoP[$x][$y]=($i-1)."".($p+1);
						$y++;
					}else if (substr($tablero[$i-1][$p+1],1,2)==$colorJ){
						$movimientoP[$x][$y]=($i-1)."".($p+1);
						$y++;
					}
				}
				$x++;
				$y=0;
			}
		}
	}
	return $movimientoP;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////MOVIMIENTOS JUGADOR//////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function posiblesMovimientosJ($tablero,$colorIA,$colorJ){
	$x=0;
	$y=0;
	//Mobi Peon
	for ($i = 0; $i < 8; $i++) {
		for ($p = 0; $p < 8; $p++) {
			if (substr($tablero[$i][$p],0,1)=="P"&&substr($tablero[$i][$p],1,2)==$colorIA) {	
				$movimientoP[$x][$y]=$i."".$p;
				$y++;				
				if (($i-1)>=0) {
					if ($tablero[$i-1][$p]=="-") {
						$movimientoP[$x][$y]=($i-1)."".$p;
						$y++;
					}
					if ($i==6){
						if ($tablero[$i-2][$p]=="-"&&$tablero[$i-1][$p]=="-") {
							$movimientoP[$x][$y]=($i-2)."".$p;
							$y++;
						}
					}
					if ($p==0) {
						$Casilla2=$tablero[$i-1][$p+1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($tablero[$i-1][$p+1]!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i-1)."".($p+1);
							$y++;
						}
					}else if($p==7){
						$Casilla2=$tablero[$i-1][$p-1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($tablero[$i-1][$p-1]!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i-1)."".($p-1);
							$y++;
						}
					}else{
						$Casilla2=$tablero[$i-1][$p-1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($tablero[$i-1][$p-1]!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i-1)."".($p-1);
							$y++;
						}
						$Casilla2=$tablero[$i-1][$p-1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($tablero[$i-1][$p-1]!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i-1)."".($p-1);
							$y++;
						}
					}
				}
				$x++;
				$y=0;
			}
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
			//Caballo
			if (substr($tablero[$i][$p],0,1)=="C"&&substr($tablero[$i][$p],1,2)==$colorIA) {
				$movimientoP[$x][$y]=$i."".$p;
				$y++;
				//Abajo izquierda
				if (($i+2)<=7&&($p-1)>=0) {
					if ($tablero[$i+2][$p-1]=="-") {
						$movimientoP[$x][$y]=($i+2)."".($p-1);
						$y++;
					}
					else{
						$Casilla2=$tablero[$i+2][$p-1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i+2)."".($p-1);
							$y++;
						}
					}
				}
				//Abajo derecha
				if (($i+2)<=7&&($p+1)<=7) {
					if ($tablero[$i+2][$p+1]=="-") {
						$movimientoP[$x][$y]=($i+2)."".($p+1);
						$y++;
					}
					else{
						$Casilla2=$tablero[$i+2][$p+1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i+2)."".($p+1);
							$y++;
						}
					}
				}
				//Arriba Izquierda
				if (($i-2)>=0&&($p-1)>=0) {
					if (($tablero[$i-2][$p-1]=="-")) {
						$movimientoP[$x][$y]=($i-2)."".($p-1);
						$y++;
					}else{
						$Casilla2=$tablero[$i-2][$p-1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i-2)."".($p-1);
							$y++;
						}
					}
				}
				//Arriba Derecha
				if (($i-2)>=0&&($p+1)<=7) {
					if (($tablero[$i-2][$p+1]=="-")) {
						$movimientoP[$x][$y]=($i-2)."".($p+1);
						$y++;
					}else{
						$Casilla2=$tablero[$i-2][$p+1];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i-2)."".($p+1);
							$y++;
						}
					}
				}
				//Izquierda Arriba
				if (($i-1)>=0&&($p-2)>=0) {
					if ($tablero[$i-1][$p-2]=="-") {
						$movimientoP[$x][$y]=($i-1)."".($p-2);
						$y++;
					}
					else{
						$Casilla2=$tablero[$i-1][$p-2];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i-1)."".($p-2);
							$y++;
						}
					}
				}
				//Izquierda Abajo
				if (($i+1)<=7&&($p-2)>=0) {
					if ($tablero[$i+1][$p-2]=="-") {
						$movimientoP[$x][$y]=($i+1)."".($p-2);
						$y++;
					}
					else{
						$Casilla2=$tablero[$i+1][$p-2];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i+1)."".($p-2);
							$y++;
						}
					}
				}
				//Derecha arriba
				if (($i-1)>=0&&($p+2)<=7) {
					if ($tablero[$i-1][$p+2]=="-") {
						$movimientoP[$x][$y]=($i-1)."".($p+2);
						$y++;
					}else{
						$Casilla2=$tablero[$i-1][$p+2];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i-1)."".($p+2);
							$y++;
						}
					}
				}
				//Derecha abajo
				if (($i+1)<=7&&($p+2)<=7) {
					if ($tablero[$i+1][$p+2]=="-") {
						$movimientoP[$x][$y]=($i+1)."".($p+2);
						$y++;
					}else{
						$Casilla2=$tablero[$i+1][$p+2];
						$ColorFichaEnemiga=substr($Casilla2,1,2);
						if ($Casilla2!="-"&&$ColorFichaEnemiga==$colorJ) {
							$movimientoP[$x][$y]=($i+1)."".($p+2);
							$y++;
						}
					}
				}	
				$x++;
				$y=0;
			}
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
			//Movimiento Torre
			if (substr($tablero[$i][$p],0,1)=="T"&&substr($tablero[$i][$p],1,2)==$colorIA) {

				$movimientoP[$x][$y]=$i."".$p;
				$y++;
				//Hacia arriba
				$tamañoArriba=0;
				for($arriba=$i-1;$arriba>=$tamañoArriba;$arriba--){
					if ($arriba>=0) {
						if (substr($tablero[$arriba][$p],1,2)==$colorIA) {
							$arriba=0;
						}else if(substr($tablero[$arriba][$p],1,2)==$colorJ){
							$movimientoP[$x][$y]=$arriba."".$p;
							$y++;
							$arriba=0;
						}else{
							$movimientoP[$x][$y]=$arriba."".$p;
							$y++;
						}
					}
				}
				//Hacia Abajo
				$tamañoBaja=8;
				for($abajo=$i+1;$abajo<$tamañoBaja;$abajo++){
					if($abajo<=7){
						if (substr($tablero[$abajo][$p],1,2)==$colorIA) {
							$abajo=8;
						}else if (substr($tablero[$abajo][$p],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$abajo."".$p;
							$y++;
							$abajo=8;
						}else{
							$movimientoP[$x][$y]=$abajo."".$p;
							$y++;
						}
					}
				}
				//Hacia Derecha
				$tamañoDerecha=8;
				for($derecha=$p+1;$derecha<=$tamañoDerecha;$derecha++){
					if($derecha<=7){
						if (substr($tablero[$i][$derecha],1,2)==$colorIA) {
							$derecha=8;
						}else if(substr($tablero[$i][$derecha],1,2)==$colorJ){
							$movimientoP[$x][$y]=$i."".$derecha;
							$y++;
							$derecha=8;
						}else{
							$movimientoP[$x][$y]=$i."".$derecha;
							$y++;
						}
					}
				}
				//Hacia Izquierda
				$tamañoIzquierda=0;
				for($izquierda=$p-1;$izquierda>=$tamañoIzquierda;$izquierda--){
					if ($p>=0) {
						if (substr($tablero[$i][$izquierda],1,2)==$colorIA) {
							$izquierda=0;
						}else if(substr($tablero[$i][$izquierda],1,2)==$colorJ){
							$movimientoP[$x][$y]=$i."".$izquierda;
							$y++;
							$izquierda=0;
						}else{
							$movimientoP[$x][$y]=$i."".$izquierda;
							$y++;
						}
					}	
				}
				$x++;
				$y=0;
			}
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
			//Mobimientos Alfil
			if (substr($tablero[$i][$p],0,1)=="A"&&substr($tablero[$i][$p],1,2)==$colorIA) {
				$movimientoP[$x][$y]=$i."".$p;
				$y++;
				//Diagonal Izquierda Arriba
				$tamañoDIa=-1;
				$ejexD=$p-1;
				for ($ejeyD = $i-1; $ejeyD >= $tamañoDIa; $ejeyD--) {
					if ($ejeyD>=0&&$ejexD>=0) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamañoDIa;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamañoDIa;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD--;
					}
				}
				//Diagonal Derecha Arriba
				$tamañoDDa=-1;
				$ejexD=$p+1;
				for ($ejeyD = $i-1; $ejeyD >= $tamañoDDa; $ejeyD--) {
					if ($ejeyD>=0&&$ejexD<=7) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamañoDDa;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamañoDDa;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD++;
					}
				}
				//Diagonal Izquierda Abajo
				$tamañoDIb=8;
				$ejexD=$p-1;
				for ($ejeyD = $i+1; $ejeyD < $tamañoDIb; $ejeyD++) {
					if ($ejeyD<=7&&$ejexD>=0) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamañoDIb;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamañoDIb;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD--;
					}
				}
				//Diagonal Derecha Abajo
				$tamñaoDDb=8;
				$ejexD=$p+1;
				for ($ejeyD = $i+1; $ejeyD <= $tamñaoDDb; $ejeyD++) {
					if ($ejeyD<=7&&$ejexD<=7) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamñaoDDb;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamñaoDDb;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD++;
					}
				}
				$x++;
				$y=0;
			}
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
			//Reina
			if (substr($tablero[$i][$p],0,1)=="Q"&&substr($tablero[$i][$p],1,2)==$colorIA) {
				$movimientoP[$x][$y]=$i."".$p;
				$y++;
				//Hacia arriba
				$tamañoArriba=0;
				for($arriba=$i-1;$arriba>=$tamañoArriba;$arriba--){
					if ($arriba>=0) {
						if (substr($tablero[$arriba][$p],1,2)==$colorIA) {
							$arriba=0;
						}else if(substr($tablero[$arriba][$p],1,2)==$colorJ){
							$movimientoP[$x][$y]=$arriba."".$p;
							$y++;
							$arriba=0;
						}else{
							$movimientoP[$x][$y]=$arriba."".$p;
							$y++;
						}
					}
				}
				//Hacia Abajo
				$tamañoBaja=8;
				for($abajo=$i+1;$abajo<$tamañoBaja;$abajo++){
					if($abajo<=7){
						if (substr($tablero[$abajo][$p],1,2)==$colorIA) {
							$abajo=8;
						}else if (substr($tablero[$abajo][$p],1,2)==$colorJ) {

							$movimientoP[$x][$y]=$abajo."".$p;
							$y++;
							$abajo=8;
						}else{
							$movimientoP[$x][$y]=$abajo."".$p;
							$y++;
						}
					}
				}
				//Hacia Derecha
				$tamañoDerecha=8;
				for($derecha=$p+1;$derecha<=$tamañoDerecha;$derecha++){
					if($derecha<=7){
						if (substr($tablero[$i][$derecha],1,2)==$colorIA) {
							$derecha=8;
						}else if(substr($tablero[$i][$derecha],1,2)==$colorJ){
							$movimientoP[$x][$y]=$i."".$derecha;
							$y++;
							$derecha=8;
						}else{
							$movimientoP[$x][$y]=$i."".$derecha;
							$y++;
						}
					}
				}
				//Hacia Izquierda
				$tamañoIzquierda=0;
				for($izquierda=$p-1;$izquierda>=$tamañoIzquierda;$izquierda--){
					if ($p>=0) {
						if (substr($tablero[$i][$izquierda],1,2)==$colorIA) {
							$izquierda=0;
						}else if(substr($tablero[$i][$izquierda],1,2)==$colorJ){
							$movimientoP[$x][$y]=$i."".$izquierda;
							$y++;
							$izquierda=0;
						}else{
							$movimientoP[$x][$y]=$i."".$izquierda;
							$y++;
						}
					}	
				}
				//Diagonal Izquierda Arriba
				$tamañoDIa=-1;
				$ejexD=$p-1;
				for ($ejeyD = $i-1; $ejeyD >= $tamañoDIa; $ejeyD--) {
					if ($ejeyD>=0&&$ejexD>=0) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamañoDIa;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamañoDIa;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD--;
					}
				}
				//Diagonal Derecha Arriba
				$tamañoDDa=-1;
				$ejexD=$p+1;
				for ($ejeyD = $i-1; $ejeyD >= $tamañoDDa; $ejeyD--) {
					if ($ejeyD>=0&&$ejexD<=7) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamañoDDa;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamañoDDa;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD++;
					}
				}
				//Diagonal Izquierda Abajo
				$tamañoDIb=8;
				$ejexD=$p-1;
				for ($ejeyD = $i+1; $ejeyD < $tamañoDIb; $ejeyD++) {
					if ($ejeyD<=7&&$ejexD>=0) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamañoDIb;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamañoDIb;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD--;
					}
				}
				//Diagonal Derecha Abajo
				$tamñaoDDb=8;
				$ejexD=$p+1;
				for ($ejeyD = $i+1; $ejeyD <= $tamñaoDDb; $ejeyD++) {
					if ($ejeyD<=7&&$ejexD<=7) {
						if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorIA) {
							$ejeyD=$tamñaoDDb;
						}else if (substr($tablero[$ejeyD][$ejexD],1,2)==$colorJ) {
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
							$ejeyD=$tamñaoDDb;
						}else{
							$movimientoP[$x][$y]=$ejeyD."".$ejexD;
							$y++;
						}
						$ejexD++;
					}
				}
				$x++;
				$y=0;
			}
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
			if (substr($tablero[$i][$p],0,1)=="K"&&substr($tablero[$i][$p],1,2)==$colorIA) {
				$movimientoP[$x][$y]=$i."".$p;
				$y++;
				//Arriba 1
				if(($i-1)>=0){
					if ($tablero[$i-1][$p]=="-") {
						$movimientoP[$x][$y]=($i-1)."".$p;
						$y++;
					}else if (substr($tablero[$i-1][$p],1,2)==$colorJ){
						$movimientoP[$x][$y]=($i-1)."".$p;
						$y++;
					}
				}
				//Abajo 1
				if(($i+1)<=7){
					if ($tablero[$i+1][$p]=="-") {
						$movimientoP[$x][$y]=($i+1)."".$p;
						$y++;
					}else if (substr($tablero[$i+1][$p],1,2)==$colorJ){
						$movimientoP[$x][$y]=($i+1)."".$p;
						$y++;
					}
				}
				//Derecha 1
				if(($p+1)<=7){
					if ($tablero[$i][$p+1]=="-") {
						$movimientoP[$x][$y]=$i."".($p+1);
						$y++;
					}else if (substr($tablero[$i][$p+1],1,2)==$colorJ){
						$movimientoP[$x][$y]=$i."".($p+1);
						$y++;
					}
				}
				//Izquierda 1
				if(($p-1)>=0){
					if ($tablero[$i][$p-1]=="-") {
						$movimientoP[$x][$y]=$i."".($p-1);
						$y++;
					}else if (substr($tablero[$i][$p-1],1,2)==$colorJ){
						$movimientoP[$x][$y]=$i."".($p-1);
						$y++;
					}
				}
				//Diagonal IAr 1
				if (($i-1)>=0&&($p-1)>=0) {
					if ($tablero[$i-1][$p-1]=="-") {
						$movimientoP[$x][$y]=($i-1)."".($p-1);
						$y++;
					}else if (substr($tablero[$i-1][$p-1],1,2)==$colorJ){
						$movimientoP[$x][$y]=($i-1)."".($p-1);
						$y++;
					}
				}
				//Diagonal IAb 1
				if (($i+1)<=7&&($p-1)>=0) {
					if ($tablero[$i+1][$p-1]=="-") {
						$movimientoP[$x][$y]=($i+1)."".($p-1);
						$y++;
					}else if (substr($tablero[$i+1][$p-1],1,2)==$colorJ){
						$movimientoP[$x][$y]=($i+1)."".($p-1);
						$y++;
					}
				}
				//Diagonal DAb 1
				if (($i+1)<=7&&($p+1)<=7) {
					if ($tablero[$i+1][$p+1]=="-") {
						$movimientoP[$x][$y]=($i+1)."".($p+1);
						$y++;
					}else if (substr($tablero[$i+1][$p+1],1,2)==$colorJ){
						$movimientoP[$x][$y]=($i+1)."".($p+1);
						$y++;
					}
				}
				//Diagonal DAr 1
				if (($i-1)>=0&&($p+1)<=7) {
					if ($tablero[$i-1][$p+1]=="-") {
						$movimientoP[$x][$y]=($i-1)."".($p+1);
						$y++;
					}else if (substr($tablero[$i-1][$p+1],1,2)==$colorJ){
						$movimientoP[$x][$y]=($i-1)."".($p+1);
						$y++;
					}
				}
				$x++;
				$y=0;
			}
		}
	}
	return $movimientoP;
}
?>
