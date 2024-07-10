<?php
	class BaseDato{
		function datos(){
			return array(
				'host'=>'localhost',
				'dbname'=>'proyectodaw');
		}
		function Iniciar(){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					return true;
			}
			catch(PDOException $e) {
				return false;
			}

			$conn = null;
		}
		function Marcador($idJ){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$select = "SELECT MarcadorX,MarcadorY FROM users WHERE id=".$idJ."";
					$result=$conn->query($select);

					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$salida=array(
								'MarcadorX'=>$listado["MarcadorX"],
								'MarcadorY'=>$listado["MarcadorY"],
							);
						}
					}
				return $salida;
			}
			catch(PDOException $e) {
				return false;
			}

			$conn = null;
		}

		function AMarcador($idJ,$ganador){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$select = "SELECT MarcadorX,MarcadorY FROM users WHERE id=".$idJ."";
					$result=$conn->query($select);
					
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$x=$listado["MarcadorX"];
								$y=$listado["MarcadorY"];
							
						}
					}

					$x=intval($x);
					$y=intval($y);
					if ($ganador=='X') {
						$x++;
						$select = "UPDATE users SET MarcadorX =". $x ." WHERE id=".$idJ."";
					}else{
						$y++;
						$select = "UPDATE users SET MarcadorY =". $y ." WHERE id=".$idJ."";
					}

					
					$conn->query($select);
					
					$select = "SELECT MarcadorX,MarcadorY FROM users WHERE id=".$idJ."";
					$result=$conn->query($select);

					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$salida=array(
								'MarcadorX'=>$listado["MarcadorX"],
								'MarcadorY'=>$listado["MarcadorY"],
							);
						}
					}
				return $salida;

			}
			catch(PDOException $e) {
				return false;
			}

			$conn = null;
		}
		function PartidasIniciadas1($idJ){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$idP1=[];
					$j2Id=[];
					$j1=[];
					$t1=[];
					$tablero1=[];
					$Victoria1=[];
					$select = "SELECT id,jugador2_id,j1,turno,tablero,Victoria FROM partidas WHERE jugador1_id=".$idJ."";
					$result=$conn->query($select);
					$x=0;
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$j2Id[$x]=$listado['jugador2_id'];
								$j1[$x]=$listado['j1'];
								$t1[$x]=$listado['turno'];
								$tablero1[$x]=$listado['tablero'];
								$idP1[$x]=$listado['id'];
								$Victoria1[$x]=$listado['Victoria'];
								$x++;
						}
					}

					$idP2=[];
					$j1Id=[];
					$j2=[];
					$t2=[];
					$tablero2=[];
					$Victoria2=[];
					$select = "SELECT id,jugador1_id,j2,turno,tablero,Victoria FROM partidas WHERE jugador2_id=".$idJ."";
					$result=$conn->query($select);
					$x=0;
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$j1Id[$x]=$listado['jugador1_id'];
								$j2[$x]=$listado['j2'];
								$t2[$x]=$listado['turno'];
								$tablero2[$x]=$listado['tablero'];
								$idP2[$x]=$listado['id'];
								$Victoria2[$x]=$listado['Victoria'];
								$x++;
						}
					}

					$Id=array_merge($j2Id,$j1Id);
					$x=0;
					for($i=0;$i<count($Id);$i++){
						$select = "SELECT name FROM users WHERE id=".$Id[$i]."";
						$result=$conn->query($select);
						if ($result->rowCount()>0) {
							while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$nombres[$x]=$listado["name"];
								$x++;
							}
						}
					}

					$idPT=array_merge($idP1,$idP2);
					$jt=array_merge($j1,$j2);
					$turno=array_merge($t1,$t2);
					$tablero=array_merge($tablero1,$tablero2);
					$Victoria=array_merge($Victoria1,$Victoria2);

					$salida=[
						"ids"=>$Id,
						"idP"=>$idPT,
						"nombres"=>$nombres,
						"marcaJ"=>$jt,
						"turno"=>$turno,
						"tablero"=>$tablero,
						"victoria"=>$Victoria,
					];
				return $salida;

			}
			catch(PDOException $e) {
				return false;
			}

			$conn = null;
		}
		function APartidas($idJ,$IDPActual,$turno,$victoria,$tablero){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					if ($victoria!=0) {
						$select = "UPDATE partidas SET Victoria =". $victoria ." WHERE id=".$IDPActual."";
						$conn->query($select);
					}
					$tablero=json_encode($tablero);

					$select = "UPDATE partidas SET tablero =". $tablero ." WHERE id=".$IDPActual."";

					$conn->query($select);

					if ($turno=="X") {
						$select = "UPDATE partidas SET turno ='O' WHERE id=".$IDPActual."";
					}else{
						$select = "UPDATE partidas SET turno ='X' WHERE id=".$IDPActual."";
					}
					$conn->query($select);
			
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$idP1=[];
					$j2Id=[];
					$j1=[];
					$t1=[];
					$tablero1=[];
					$Victoria1=[];
					$select = "SELECT id,jugador2_id,j1,turno,tablero,Victoria FROM partidas WHERE jugador1_id=".$idJ."";
					$result=$conn->query($select);
					$x=0;
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$j2Id[$x]=$listado['jugador2_id'];
								$j1[$x]=$listado['j1'];
								$t1[$x]=$listado['turno'];
								$tablero1[$x]=$listado['tablero'];
								$idP1[$x]=$listado['id'];
								$Victoria1[$x]=$listado['Victoria'];
								$x++;
						}
					}

					$idP2=[];
					$j1Id=[];
					$j2=[];
					$t2=[];
					$tablero2=[];
					$Victoria2=[];
					$select = "SELECT id,jugador1_id,j2,turno,tablero,Victoria FROM partidas WHERE jugador2_id=".$idJ."";
					$result=$conn->query($select);
					$x=0;
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$j1Id[$x]=$listado['jugador1_id'];
								$j2[$x]=$listado['j2'];
								$t2[$x]=$listado['turno'];
								$tablero2[$x]=$listado['tablero'];
								$idP2[$x]=$listado['id'];
								$Victoria2[$x]=$listado['Victoria'];
								$x++;
						}
					}

					$Id=array_merge($j2Id,$j1Id);
					$x=0;
					for($i=0;$i<count($Id);$i++){
						$select = "SELECT name FROM users WHERE id=".$Id[$i]."";
						$result=$conn->query($select);
						if ($result->rowCount()>0) {
							while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$nombres[$x]=$listado["name"];
								$x++;
							}
						}
					}

					$idPT=array_merge($idP1,$idP2);
					$jt=array_merge($j1,$j2);
					$turno=array_merge($t1,$t2);
					$tablero=array_merge($tablero1,$tablero2);
					$Victoria=array_merge($Victoria1,$Victoria2);

					$salida=[
						"ids"=>$Id,
						"idP"=>$idPT,
						"nombres"=>$nombres,
						"marcaJ"=>$jt,
						"turno"=>$turno,
						"tablero"=>$tablero,
						"victoria"=>$Victoria,
					];
				return $salida;

			}
			catch(PDOException $e) {
				return false;
			}

			$conn = null;
		}

		function Amigos($idUser){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$id1=[];
				$select = "SELECT jugador1_id FROM amigos WHERE jugador2_id=".$idUser." AND son=true";
				$result=$conn->query($select);
				$x=0;
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
						$id1[$x]=$listado["jugador1_id"];
						$x++;
					}
				}
				$id2=[];
				$select = "SELECT jugador2_id FROM amigos WHERE jugador1_id=".$idUser." AND son=true";
				$result=$conn->query($select);
				$x=0;
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
						$id2[$x]=$listado["jugador2_id"];
						$x++;
					}
				}
				$id=array_merge($id1,$id2);
				$amigos=[];
				$x=0;
				for($i=0;$i<count($id);$i++){
					$select = "SELECT name FROM users WHERE id=".$id[$i]."";
					$result=$conn->query($select);
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$amigos[$x]=$listado["name"];
							$x++;
						}
					}
				}
				return $amigos;
			}
			catch(PDOException $e) {
				return false;
			}

			$conn = null;
		}
		function Solicitudes($idUser){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$id=[];
				$select = "SELECT jugador1_id FROM amigos WHERE jugador2_id=".$idUser." AND son=false";
				$result=$conn->query($select);
				$x=0;
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
						$id[$x]=$listado["jugador1_id"];
						$x++;
					}
				}
				
				$amigos=[];
				$x=0;
				for($i=0;$i<count($id);$i++){
					$select = "SELECT name FROM users WHERE id=".$id[$i]."";
					$result=$conn->query($select);
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$amigos[$x]=$listado["name"];
							$x++;
						}
					}
				}
				return $amigos;
			}
			catch(PDOException $e) {
				return $e->getMessage();
			}

			$conn = null;
		}
		function SolicitudAceptada($idUser,$nombrSoli){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$select = "SELECT id FROM users WHERE name=\"".$nombrSoli."\"";
				$result=$conn->query($select);
				$x=0;
				$idInvitado=[];
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$idInvitado[$x]=$listado["id"];
							$x++;
					}
				}


				$id1=[];
				$select = "UPDATE amigos SET son =true WHERE jugador1_id=".$idInvitado[0]." AND jugador2_id=".$idUser." ";
				$result=$conn->query($select);
				echo "Solicitud Aceptada al Jugador ".$nombrSoli;
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}

			$conn = null;
		}
		function IdJuego($id){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$select = "SELECT IdInGame FROM users WHERE id=".$id."";
				$result=$conn->query($select);
				$x=0;
				$idJugador=[];
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$idJugador[$x]=$listado["IdInGame"];
							$x++;
					}
				}
				return $idJugador;
	
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}

			$conn = null;
		}
		function Agregar($id,$idJugador){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$select = "SELECT id FROM users WHERE IdInGame='".$idJugador."'";
				$result=$conn->query($select);
				$x=0;
				$idJugador1=[];
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$idJugador1[$x]=$listado["id"];
							$x++;
					}
				}else{
					$idJugador1[0]=false;
				}
				if ($idJugador1[0]==false) {
					echo "El usuario no existe pon un id valido";
				}else{
					$select = "SELECT son FROM amigos WHERE jugador1_id='".$idJugador1[0]."' AND jugador2_id='".$id."'";
					$select1 = "SELECT son FROM amigos WHERE jugador2_id='".$idJugador1[0]."' AND jugador1_id='".$id."'";
					$result=$conn->query($select);
					$result1=$conn->query($select1);
					if ($result->rowCount()>0) {
						$x=0;
						$son=[];
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$son[$x]=$listado["son"];
							$x++;
						}
					}else{
						$son[0]=false;
					}
					if ($result1->rowCount()>0) {
						$x=0;
						$son1=[];
						while ($listado=$result1->fetch(PDO::FETCH_ASSOC)) {
							$son1[$x]=$listado["son"];
							$x++;
						}
					}else{
						$son1[0]=false;
					}
					if ($son[0]==true||$son1[0]==true) {
						echo "Ya sois amigos";
					}else if ($idJugador1[0]!=$id) {
						if ($result->rowCount()!=0) {
							echo "Este jugador te ha enviado una solicitud aceptala";
						}else if ($result1->rowCount()!=0) {
							echo "Ya le has mandado una invitación a este jugador";
						}else{
							$select = "INSERT INTO `amigos`( `jugador1_id`, `jugador2_id`, `son`) VALUES (".$id.",".$idJugador1[0].",false)";
							if($conn->query($select)==TRUE){
								echo "Solicitud Enviada";
							}else{
								echo "Error: " . $select . "<br>" . $conn->error;
							}
						}
					}else{
						echo "No te puedes Agregar a ti mismo";
					}
				}
			}
			catch(PDOException $e) {
				echo "hi".$e->getMessage();
			}

			$conn = null;
		}
		function UsuariosAzar(){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$select = "SELECT id FROM users";
				$result=$conn->query($select);
				$x=0;
				$idJugador1=[];
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$idJugador1[$x]=$listado["id"];
							$x++;
					}
				}				
				return $idJugador1;
			}
			catch(PDOException $e) {
				echo "hi".$e->getMessage();
			}

			$conn = null;
		}

		function CrearPartida($id1,$id2){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$select ="INSERT INTO `partidas`( `jugador1_id`, `jugador2_id`, `j1`,`j2`,`turno`) VALUES (".$id1.",".$id2.", 'X','O','X')";
				$result=$conn->query($select);
				$select = "SELECT id FROM partidas WHERE jugador1_id='".$id1."' AND jugador2_id='".$id2."'";
				$result=$conn->query($select);
				$x=0;
				$idPartidas=[];
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$idPartidas[$x]=$listado["id"];
							$x++;
					}
				}
				$tamano=count($idPartidas);	
				return $idPartidas[$tamano-1];
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}

			$conn = null;
		}
		function MostrarPartidaCreada($idP){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$select = "SELECT tablero,jugador2_id FROM partidas WHERE id='".$idP."'";
				$result=$conn->query($select);
				$x=0;
				$tablero=[];
				$idJ2=[];
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$tablero[$x]=$listado["tablero"];
							$idJ2[$x]=$listado["jugador2_id"];
							$x++;
					}
				}
				for($i=0;$i<count($idJ2);$i++){
					$select = "SELECT name FROM users WHERE id=".$idJ2[$i]."";
					$result=$conn->query($select);
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$nombre[$x]=$listado["name"];
							$x++;
						}
					}
				}
				$salida=[
					"tablero"=>$tablero,
					"Contrario"=>$nombre,
				];
				return $salida;
			}
			catch(PDOException $e) {
				echo $e->getMessage(); 
			}

			$conn = null;
		}
		function SacarIdJugador($nombre){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$r=0;
				$idJugador1=[];
				$x=0;
				while(count($nombre)>$r){
					$select = "SELECT id FROM users WHERE name='".$nombre[$r]."'";
					$result=$conn->query($select);
					
					
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$idJugador1[$x]=$listado["id"];
								$x++;
						}
					}
					$r++;
				}
								
				return $idJugador1;
			}
			catch(PDOException $e) {
				echo "hi".$e->getMessage();
			}

			$conn = null;
		}
		function PartidasIniciadas2($idJ){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$idP1=[];
					$j2Id=[];
					$j1=[];
					$t1=[];
					$tablero1=[];
					$Victoria1=[];
					$select = "SELECT id,jugador2_id,j1,turno,tablero,Victoria FROM partidasaj WHERE jugador1_id=".$idJ."";
					$result=$conn->query($select);
					$x=0;
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$j2Id[$x]=$listado['jugador2_id'];
								$j1[$x]=$listado['j1'];
								$t1[$x]=$listado['turno'];
								$tablero1[$x]=$listado['tablero'];
								$idP1[$x]=$listado['id'];
								$Victoria1[$x]=$listado['Victoria'];
								$x++;
						}
					}

					$idP2=[];
					$j1Id=[];
					$j2=[];
					$t2=[];
					$tablero2=[];
					$Victoria2=[];
					$select = "SELECT id,jugador1_id,j2,turno,tablero,Victoria FROM partidasaj WHERE jugador2_id=".$idJ."";
					$result=$conn->query($select);
					$x=0;
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$j1Id[$x]=$listado['jugador1_id'];
								$j2[$x]=$listado['j2'];
								$t2[$x]=$listado['turno'];
								$tablero2[$x]=$listado['tablero'];
								$idP2[$x]=$listado['id'];
								$Victoria2[$x]=$listado['Victoria'];
								$x++;
						}
					}

					$Id=array_merge($j2Id,$j1Id);
					$x=0;
					$nombres=[];
					for($i=0;$i<count($Id);$i++){
						$select = "SELECT name FROM users WHERE id=".$Id[$i]."";
						$result=$conn->query($select);
						if ($result->rowCount()>0) {
							while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$nombres[$x]=$listado["name"];
								$x++;
							}
						}
					}

					$idPT=array_merge($idP1,$idP2);
					$jt=array_merge($j1,$j2);
					$turno=array_merge($t1,$t2);
					$tablero=array_merge($tablero1,$tablero2);
					$Victoria=array_merge($Victoria1,$Victoria2);

					$salida=[
						"ids"=>$Id,
						"idP"=>$idPT,
						"nombres"=>$nombres,
						"marcaJ"=>$jt,
						"turno"=>$turno,
						"tablero"=>$tablero,
						"victoria"=>$Victoria,
					];
				return $salida;

			}
			catch(PDOException $e) {
				return false;
			}

			$conn = null;
		}
		function APartidas1($idJ,$IDPActual,$turno,$victoria,$tablero){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					if ($victoria!=0) {
						$select = "UPDATE partidas SET Victoria =". $victoria ." WHERE id=".$IDPActual."";
						$conn->query($select);
					}
					$tablero=json_encode($tablero);

					$select = "UPDATE partidasaj SET tablero =". $tablero ." WHERE id=".$IDPActual."";

					$conn->query($select);

					if ($turno=="b") {
						$select = "UPDATE partidasaj SET turno ='n' WHERE id=".$IDPActual."";
					}else{
						$select = "UPDATE partidasaj SET turno ='b' WHERE id=".$IDPActual."";
					}
					$conn->query($select);
			
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
					// set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$idP1=[];
					$j2Id=[];
					$j1=[];
					$t1=[];
					$tablero1=[];
					$Victoria1=[];
					$select = "SELECT id,jugador2_id,j1,turno,tablero,Victoria FROM partidasaj WHERE jugador1_id=".$idJ."";
					$result=$conn->query($select);
					$x=0;
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$j2Id[$x]=$listado['jugador2_id'];
								$j1[$x]=$listado['j1'];
								$t1[$x]=$listado['turno'];
								$tablero1[$x]=$listado['tablero'];
								$idP1[$x]=$listado['id'];
								$Victoria1[$x]=$listado['Victoria'];
								$x++;
						}
					}

					$idP2=[];
					$j1Id=[];
					$j2=[];
					$t2=[];
					$tablero2=[];
					$Victoria2=[];
					$select = "SELECT id,jugador1_id,j2,turno,tablero,Victoria FROM partidasaj WHERE jugador2_id=".$idJ."";
					$result=$conn->query($select);
					$x=0;
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$j1Id[$x]=$listado['jugador1_id'];
								$j2[$x]=$listado['j2'];
								$t2[$x]=$listado['turno'];
								$tablero2[$x]=$listado['tablero'];
								$idP2[$x]=$listado['id'];
								$Victoria2[$x]=$listado['Victoria'];
								$x++;
						}
					}

					$Id=array_merge($j2Id,$j1Id);
					$x=0;
					for($i=0;$i<count($Id);$i++){
						$select = "SELECT name FROM users WHERE id=".$Id[$i]."";
						$result=$conn->query($select);
						if ($result->rowCount()>0) {
							while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
								$nombres[$x]=$listado["name"];
								$x++;
							}
						}
					}

					$idPT=array_merge($idP1,$idP2);
					$jt=array_merge($j1,$j2);
					$turno=array_merge($t1,$t2);
					$tablero=array_merge($tablero1,$tablero2);
					$Victoria=array_merge($Victoria1,$Victoria2);

					$salida=[
						"ids"=>$Id,
						"idP"=>$idPT,
						"nombres"=>$nombres,
						"marcaJ"=>$jt,
						"turno"=>$turno,
						"tablero"=>$tablero,
						"victoria"=>$Victoria,
					];
				return $salida;

			}
			catch(PDOException $e) {
				return false;
			}

			$conn = null;
		}
		function CrearPartidaA($id1,$id2){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$select ="INSERT INTO `partidasaj`( `jugador1_id`, `jugador2_id`, `j1`,`j2`,`turno`) VALUES (".$id1.",".$id2.", 'b','n','b')";
				$result=$conn->query($select);
				$select = "SELECT id FROM partidasaj WHERE jugador1_id='".$id1."' AND jugador2_id='".$id2."'";
				$result=$conn->query($select);
				$x=0;
				$idPartidas=[];
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$idPartidas[$x]=$listado["id"];
							$x++;
					}
				}
				$tamano=count($idPartidas);	
				return $idPartidas[$tamano-1];
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}

			$conn = null;
		}
		function MostrarPartidaCreadaA($idP){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$select = "SELECT tablero,jugador2_id FROM partidasaj WHERE id='".$idP."'";
				$result=$conn->query($select);
				$x=0;
				$tablero=[];
				$idJ2=[];
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$tablero[$x]=$listado["tablero"];
							$idJ2[$x]=$listado["jugador2_id"];
							$x++;
					}
				}
				for($i=0;$i<count($idJ2);$i++){
					$select = "SELECT name FROM users WHERE id=".$idJ2[$i]."";
					$result=$conn->query($select);
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$nombre[$x]=$listado["name"];
							$x++;
						}
					}
				}
				$salida=[
					"tablero"=>$tablero,
					"Contrario"=>$nombre,
				];
				return $salida;
			}
			catch(PDOException $e) {
				echo $e->getMessage(); 
			}

			$conn = null;
		}
		function UsuariosT(){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$nombre=[];
				$id=[];
				$x=0;
				$select = "SELECT id,name FROM users WHERE id!=1";
				$result=$conn->query($select);
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
						$nombre[$x]=$listado["name"];
						$id[$x]=$listado["id"];
						$x++;
					}
				}

				$salida=[
					"nombres"=>$nombre,
					"id"=>$id,
				];
				return $salida;
			}
			catch(PDOException $e) {
				echo $e->getMessage(); 
			}

			$conn = null;
		}
		function EliminarUser($id){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$select = "DELETE FROM amigos WHERE jugador1_id=".$id."";
				$conn->exec($select);
				$select = "DELETE FROM amigos WHERE jugador2_id=".$id."";
				$conn->exec($select);
				$select = "DELETE FROM partidasaj WHERE jugador1_id=".$id."";
				$conn->exec($select);
				$select = "DELETE FROM partidasaj WHERE jugador2_id=".$id."";
				$conn->exec($select);
				$select = "DELETE FROM partidas WHERE jugador1_id=".$id."";
				$conn->exec($select);
				$select = "DELETE FROM partidas WHERE jugador2_id=".$id."";
				$conn->exec($select);
				$select = "DELETE FROM users WHERE id=".$id."";
				$conn->exec($select);
				$nombre=[];
				$id=[];
				$x=0;
				$select = "SELECT id,name FROM users WHERE id!=1";
				$result=$conn->query($select);
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
						$nombre[$x]=$listado["name"];
						$id[$x]=$listado["id"];
						$x++;
					}
				}

				$salida=[
					"nombres"=>$nombre,
					"id"=>$id,
				];
				return $salida;
			}
			catch(PDOException $e) {
				echo $e->getMessage(); 
			}

			$conn = null;
		}
		function PartidasTres(){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$id=[];
				$id1=[];
				$id2=[];
				$tablero=[];
				$x=0;
				$select = "SELECT id,jugador1_id,jugador2_id,tablero FROM partidas";
				$result=$conn->query($select);
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
						$id[$x]=$listado["id"];
						$id1[$x]=$listado["jugador1_id"];
						$id2[$x]=$listado["jugador2_id"];
						$tablero[$x]=$listado["tablero"];
						$x++;
					}
				}
				$nombre1=[];
				$nombre2=[];
				$x=0;
				for($i=0;$i<count($id1);$i++){
					$select = "SELECT name FROM users WHERE id=".$id1[$i]."";
					$result=$conn->query($select);
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$nombre1[$x]=$listado["name"];
							$x++;
						}
					}
				}
				$x=0;
				for($i=0;$i<count($id2);$i++){
					$select = "SELECT name FROM users WHERE id=".$id2[$i]."";
					$result=$conn->query($select);
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$nombre2[$x]=$listado["name"];
							$x++;
						}
					}
				}
				$salida=[
					"id"=>$id,
					"nombres1"=>$nombre1,
					"nombres2"=>$nombre2,
					"tablero"=>$tablero,
				];
				return $salida;
			}
			catch(PDOException $e) {
				echo $e->getMessage(); 
			}

			$conn = null;
		}
		
		function EliminarPartidaT($id){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$select = "DELETE FROM partidas WHERE id=".$id."";
				$conn->exec($select);
				$id=[];
				$id1=[];
				$id2=[];
				$x=0;
				$select = "SELECT id,jugador1_id,jugador2_id FROM partidas";
				$result=$conn->query($select);
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
						$id[$x]=$listado["id"];
						$id1[$x]=$listado["jugador1_id"];
						$id2[$x]=$listado["jugador2_id"];
						$x++;
					}
				}
				$nombre1=[];
				$nombre2=[];
				$x=0;
				for($i=0;$i<count($id1);$i++){
					$select = "SELECT name FROM users WHERE id=".$id1[$i]."";
					$result=$conn->query($select);
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$nombre1[$x]=$listado["name"];
							$x++;
						}
					}
				}
				$x=0;
				for($i=0;$i<count($id2);$i++){
					$select = "SELECT name FROM users WHERE id=".$id2[$i]."";
					$result=$conn->query($select);
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$nombre2[$x]=$listado["name"];
							$x++;
						}
					}
				}
				$salida=[
					"id"=>$id,
					"nombres1"=>$nombre1,
					"nombres2"=>$nombre2,
				];
				return $salida;
			}
			catch(PDOException $e) {
				echo $e->getMessage(); 
			}

			$conn = null;
		}
		function PartidasAje(){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$id=[];
				$id1=[];
				$id2=[];
				$tablero=[];
				$x=0;
				$select = "SELECT id,jugador1_id,jugador2_id,tablero FROM partidasaj";
				$result=$conn->query($select);
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
						$id[$x]=$listado["id"];
						$id1[$x]=$listado["jugador1_id"];
						$id2[$x]=$listado["jugador2_id"];
						$tablero[$x]=$listado["tablero"];
						$x++;
					}
				}
				$nombre1=[];
				$nombre2=[];
				$x=0;
				for($i=0;$i<count($id1);$i++){
					$select = "SELECT name FROM users WHERE id=".$id1[$i]."";
					$result=$conn->query($select);
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$nombre1[$x]=$listado["name"];
							$x++;
						}
					}
				}
				$x=0;
				for($i=0;$i<count($id2);$i++){
					$select = "SELECT name FROM users WHERE id=".$id2[$i]."";
					$result=$conn->query($select);
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$nombre2[$x]=$listado["name"];
							$x++;
						}
					}
				}
				$salida=[
					"id"=>$id,
					"nombres1"=>$nombre1,
					"nombres2"=>$nombre2,
					"tablero"=>$tablero,
				];
				return $salida;
			}
			catch(PDOException $e) {
				echo $e->getMessage(); 
			}

			$conn = null;
		}
		function EliminarPartidaA($id){
			$a=new BaseDato();
			$datos=$a->datos();
			try {
				$conn = new PDO("mysql:host=".$datos["host"].";dbname=".$datos["dbname"],$datos["dbname"],$datos["dbname"]);
				// set the PDO error mode to exception
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$select = "DELETE FROM partidasaj WHERE id=".$id."";
				$conn->exec($select);
				$id=[];
				$id1=[];
				$id2=[];
				$x=0;
				$select = "SELECT id,jugador1_id,jugador2_id FROM partidasaj";
				$result=$conn->query($select);
				if ($result->rowCount()>0) {
					while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
						$id[$x]=$listado["id"];
						$id1[$x]=$listado["jugador1_id"];
						$id2[$x]=$listado["jugador2_id"];
						$x++;
					}
				}
				$nombre1=[];
				$nombre2=[];
				$x=0;
				for($i=0;$i<count($id1);$i++){
					$select = "SELECT name FROM users WHERE id=".$id1[$i]."";
					$result=$conn->query($select);
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$nombre1[$x]=$listado["name"];
							$x++;
						}
					}
				}
				$x=0;
				for($i=0;$i<count($id2);$i++){
					$select = "SELECT name FROM users WHERE id=".$id2[$i]."";
					$result=$conn->query($select);
					if ($result->rowCount()>0) {
						while ($listado=$result->fetch(PDO::FETCH_ASSOC)) {
							$nombre2[$x]=$listado["name"];
							$x++;
						}
					}
				}
				$salida=[
					"id"=>$id,
					"nombres1"=>$nombre1,
					"nombres2"=>$nombre2,
				];
				return $salida;
			}
			catch(PDOException $e) {
				echo $e->getMessage(); 
			}

			$conn = null;
		}
		
	}
?>