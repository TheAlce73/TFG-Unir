////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////Movimientos Usuario/////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function MobimientoAjedrez(i,j){
	console.log(1);
	Casilla1=tablero[i][j];
	if (Casilla1.substr(1,2)==colorJ&&LeToca=="J") {
		lugar[0]=i;
		lugar[1]=j;
		$("#Consejos").html("Elije a Donde quieres mover");
		for (var i = 0; i < 8; i++) {
			for (var j = 0; j < 8; j++) {
				$("#"+i+""+j).attr('onclick', "ADondeMober("+i+","+j+")");
			}
		}	
	}
}

function ADondeMober(i, j) {
    console.log(Multijugador);
    var movimientoValido = false;
    TipoFicha = Casilla1.substr(0, 1);
    ColorFicha = Casilla1.substr(1, 2);
    tablero1 = JSON.stringify(tablero);
    lugar1 = JSON.stringify(lugar);
    var is = i;
    var js = j;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if (lugar[0] == is && lugar[1] == js) {
                movimientoValido = false;
                $("#Consejos").html("Elije la ficha que quieres mover");
                for (var i = 0; i < 8; i++) {
                    for (var j = 0; j < 8; j++) {
                        $("#" + i + "" + j).attr('onclick', "MobimientoAjedrez(" + i + "," + j + ")");
                    }
                }
            } else if (this.responseText == true) {
                console.log("movimiento válido");
                var tableroP = JSON.parse(tablero1); // Crear una copia del tablero actual
                tableroP[is][js] = Casilla1;
                tableroP[lugar[0]][lugar[1]] = "-";
                console.log(tableroP);
                console.log(tablero);
                if (!estaEnJaque(tableroP, colorJ)) {
                    tablero = tableroP;
                    console.log(tablero+"Mio");
                    pintarTBAje(tablero);
                    for (var i = 0; i < 8; i++) {
                        for (var j = 0; j < 8; j++) {
                            $("#" + i + "" + j).attr('onclick', "MobimientoAjedrez(" + i + "," + j + ")");
                        }
                    }

                    if (Multijugador == 1) {
                        console.log("Esta en jaque IA:" + estaEnJaque(tablero, colorIA));
                        console.log("Esta en jaque mate IA:"+esJaqueMate(tablero, colorIA));
                        if(esJaqueMate(tablero, colorIA)){
                        	 $("#Consejos").html("Gana el jugador por jaque mate.");
		                    for (var i = 0; i < 8; i++) {
			                    for (var j = 0; j < 8; j++) {
			                        $("#" + i + "" + j).attr('onclick', "");
			                    }
		                	}
                        }else{
                        	LeToca = "IA";
                        	MovimientoIA();
                        	pintarTBAje(tablero);
                        	$("#Consejos").html("Elije la ficha que quieres mover");
                        }
                        
                    } else if(Multijugador == 0){
                    	console.log("Partida Multijugador");
                        if (LeTocaMp == "n") {
                            console.log(LeTocaMp);
                            console.log("ds");
                            var tableroC = [
                                ["-", "-", "-", "-", "-", "-", "-", "-"],
                                ["-", "-", "-", "-", "-", "-", "-", "-"],
                                ["-", "-", "-", "-", "-", "-", "-", "-"],
                                ["-", "-", "-", "-", "-", "-", "-", "-"],
                                ["-", "-", "-", "-", "-", "-", "-", "-"],
                                ["-", "-", "-", "-", "-", "-", "-", "-"],
                                ["-", "-", "-", "-", "-", "-", "-", "-"],
                                ["-", "-", "-", "-", "-", "-", "-", "-"]
                            ];
                            var xc = 0;
                            var yc = 0;
                            for (var i = 7; i >= 0; i--) {
                                yc = 0;
                                for (var t = 7; t >= 0; t--) {
                                    tableroC[xc][yc] = tablero[i][t];
                                    yc++;
                                    console.log(xc, yc);
                                }
                                xc++;
                            }

                            tablero = tableroC;
                        }
                        LeToca = "IA";
                        tablero = Ttablero1(tablero);
                        jugada(IDPActual, LeTocaMp, victoria, tablero);
                    }else if(Multijugador==2){
                    	console.log("Partida contra Stock");
                    	if(esJaqueMate(tablero, colorIA)){
                        	 $("#Consejos").html("Gana el jugador por jaque mate.");
		                    for (var i = 0; i < 8; i++) {
			                    for (var j = 0; j < 8; j++) {
			                        $("#" + i + "" + j).attr('onclick', "");
			                    }
		                	}
                        }else{
                        	LeToca = "IA";
                        	MovimientoIAStock();
                        	pintarTBAje(tablero);
                        	$("#Consejos").html("Elije la ficha que quieres mover");
                        }
                    }
                } else {
                    $("#Consejos").html("Elije un lugar correcto. No puedes mover ahí porque estarías en jaque.Elije la ficha que quieres mover");
                    for (var i = 0; i < 8; i++) {
                    for (var j = 0; j < 8; j++) {
                        $("#" + i + "" + j).attr('onclick', "MobimientoAjedrez(" + i + "," + j + ")");
                    }
                }
                }
            } else {
                $("#Consejos").html("Elije un lugar correcto. Elije la ficha que quieres mover");
                for (var i = 0; i < 8; i++) {
                    for (var j = 0; j < 8; j++) {
                        $("#" + i + "" + j).attr('onclick', "MobimientoAjedrez(" + i + "," + j + ")");
                    }
                }
            }
        }
    };
    xhttp.open("POST", "../resources/php/Ajedrez1.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("numero=1&ColorFicha=" + ColorFicha + "&TipoFicha=" + TipoFicha + "&tablero=" + tablero1 + "&lugar=" + lugar1 + "&i=" + i + "&j=" + j);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////Pintar Tablero con Img///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function pintarTBAje(tablero){
	for(var nxt=0;nxt<8;nxt++){
		for(var nyt=0;nyt<8;nyt++){
			var variable;
			if (tablero[nxt][nyt]=="Tb") {
				variable="../resources/Figuras/torreblanca.png";
			}else if (tablero[nxt][nyt]=="Cb") {
				variable="../resources/Figuras/caballoblanco.png";
			}else if (tablero[nxt][nyt]=="Ab") {
				variable="../resources/Figuras/alfilblanco.png";
			}else if(tablero[nxt][nyt]=="Qb"){
				variable="../resources/Figuras/reinablanca.png";
			}else if(tablero[nxt][nyt]=="Kb"){
				variable="../resources/Figuras/reyblanco.png";
			}else if(tablero[nxt][nyt]=="Pb"){
				variable="../resources/Figuras/peonblanco.png";
			}else if (tablero[nxt][nyt]=="Tn") {
				variable="../resources/Figuras/torrenegra.png";
			}else if (tablero[nxt][nyt]=="Cn") {
				variable="../resources/Figuras/caballonegro.png";
			}else if (tablero[nxt][nyt]=="An") {
				variable="../resources/Figuras/alfilnegro.png";
			}else if(tablero[nxt][nyt]=="Qn"){
				variable="../resources/Figuras/reinanegra.png";
			}else if(tablero[nxt][nyt]=="Kn"){
				variable="../resources/Figuras/reynegro.png";
			}else if(tablero[nxt][nyt]=="Pn"){
				variable="../resources/Figuras/peonnegro.png";
			}else if(tablero[nxt][nyt]=="-"){
				variable="../resources/Figuras/descarga.png";
			}
			$("#"+nxt+nyt).html("<img src='"+variable+"' width='75' height='75' >");
		}
	}
	$("#tablero").show();
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////Transformar tablero/////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Ttablero1(tablero){
	tablero1="";
	tablero1+="[";
	for (var i = 0; i < 8; i++) {
		tablero1+="[";
		for (var p = 0; p < 8; p++) {
			tablero1+=String(tablero[i][p]);
			if (p!=7) {
				tablero1+=","
			}
		}
		tablero1+="]";
		if (i!=7) {
			tablero1+=",";
		}
	}
	tablero1+="]";
	console.log(tablero1);
	return tablero1;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////Comprobar tipos Jaque///////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function esJaqueMate(tablero, colorRey) {
    if (!estaEnJaque(tablero, colorRey)) {
        return false; // No hay jaque, por lo tanto, no puede haber jaque mate
    }

    const direcciones = [
        [1, 0], [-1, 0], [0, 1], [0, -1], 
        [1, 1], [1, -1], [-1, 1], [-1, -1]
    ];

    const [filaRey, columnaRey] = encontrarRey(tablero, colorRey);
    const enemigo = colorRey === "b" ? "n" : "b";

    // Verificar si el rey puede moverse a una casilla segura
    for (const [dx, dy] of direcciones) {
        const nuevaFila = filaRey + dx;
        const nuevaColumna = columnaRey + dy;
        if (nuevaFila >= 0 && nuevaFila < 8 && nuevaColumna >= 0 && nuevaColumna < 8) {
            const piezaDestino = tablero[nuevaFila][nuevaColumna];
            if (piezaDestino === "-" || piezaDestino.charAt(1) !== colorRey) {
                const tableroCopia = JSON.parse(JSON.stringify(tablero));
                tableroCopia[filaRey][columnaRey] = "-";
                tableroCopia[nuevaFila][nuevaColumna] = `K${colorRey}`;
                if (!estaEnJaque(tableroCopia, colorRey)) {
                    return false; // El rey puede moverse a una casilla segura
                }
            }
        }
    }

    // Verificar si alguna pieza puede capturar la pieza atacante o bloquear el jaque
    for (let fila = 0; fila < 8; fila++) {
        for (let columna = 0; columna < 8; columna++) {
            const pieza = tablero[fila][columna];
            if (pieza.charAt(1) === colorRey) {
                const movimientos = obtenerMovimientosValidos(tablero, fila, columna);
                for (const [nuevaFila, nuevaColumna] of movimientos) {
                    const tableroCopia = JSON.parse(JSON.stringify(tablero));
                    tableroCopia[nuevaFila][nuevaColumna] = pieza;
                    tableroCopia[fila][columna] = "-";
                    if (!estaEnJaque(tableroCopia, colorRey)) {
                        return false; // Una pieza puede capturar la pieza atacante o bloquear el jaque
                    }
                }
            }
        }
    }

    return true; // No hay movimientos válidos para evitar el jaque, por lo tanto, es jaque mate
}

function obtenerMovimientosValidos(tablero, fila, columna) {
    const pieza = tablero[fila][columna];
    const tipoPieza = pieza.charAt(0);
    const colorPieza = pieza.charAt(1);
    const movimientos = [];

    switch(tipoPieza) {
        case 'P':
            obtenerMovimientosPeon(tablero, fila, columna, colorPieza, movimientos);
            break;
        case 'T':
            obtenerMovimientosTorre(tablero, fila, columna, colorPieza, movimientos);
            break;
        case 'C':
            obtenerMovimientosCaballo(tablero, fila, columna, colorPieza, movimientos);
            break;
        case 'A':
            obtenerMovimientosAlfil(tablero, fila, columna, colorPieza, movimientos);
            break;
        case 'Q':
            obtenerMovimientosReina(tablero, fila, columna, colorPieza, movimientos);
            break;
        case 'K':
            obtenerMovimientosRey(tablero, fila, columna, colorPieza, movimientos);
            break;
    }

    return movimientos;
}

function obtenerMovimientosPeon(tablero, fila, columna, colorPieza, movimientos) {
    const direccion = colorPieza === 'b' ? -1 : 1;
    if (tablero[fila + direccion][columna] === "-") {
        movimientos.push([fila + direccion, columna]);
        if ((colorPieza === 'b' && fila === 6) || (colorPieza === 'n' && fila === 1)) {
            if (tablero[fila + 2 * direccion][columna] === "-") {
                movimientos.push([fila + 2 * direccion, columna]);
            }
        }
    }
    if (columna > 0 && tablero[fila + direccion][columna - 1].charAt(1) !== colorPieza) {
        movimientos.push([fila + direccion, columna - 1]);
    }
    if (columna < 7 && tablero[fila + direccion][columna + 1].charAt(1) !== colorPieza) {
        movimientos.push([fila + direccion, columna + 1]);
    }
}

function obtenerMovimientosTorre(tablero, fila, columna, colorPieza, movimientos) {
    const direcciones = [[1, 0], [-1, 0], [0, 1], [0, -1]];
    for (const [dx, dy] of direcciones) {
        let nuevaFila = fila;
        let nuevaColumna = columna;
        while (true) {
            nuevaFila += dx;
            nuevaColumna += dy;
            if (nuevaFila < 0 || nuevaFila >= 8 || nuevaColumna < 0 || nuevaColumna >= 8) {
                break;
            }
            if (tablero[nuevaFila][nuevaColumna] === "-") {
                movimientos.push([nuevaFila, nuevaColumna]);
            } else {
                if (tablero[nuevaFila][nuevaColumna].charAt(1) !== colorPieza) {
                    movimientos.push([nuevaFila, nuevaColumna]);
                }
                break;
            }
        }
    }
}

function obtenerMovimientosCaballo(tablero, fila, columna, colorPieza, movimientos) {
    const direcciones = [[2, 1], [2, -1], [-2, 1], [-2, -1], [1, 2], [1, -2], [-1, 2], [-1, -2]];
    for (const [dx, dy] of direcciones) {
        const nuevaFila = fila + dx;
        const nuevaColumna = columna + dy;
        if (nuevaFila >= 0 && nuevaFila < 8 && nuevaColumna >= 0 && nuevaColumna < 8) {
            const destino = tablero[nuevaFila][nuevaColumna];
            if (destino === "-" || destino.charAt(1) !== colorPieza) {
                movimientos.push([nuevaFila, nuevaColumna]);
            }
        }
    }
}

function obtenerMovimientosAlfil(tablero, fila, columna, colorPieza, movimientos) {
    const direcciones = [[1, 1], [1, -1], [-1, 1], [-1, -1]];
    for (const [dx, dy] of direcciones) {
        let nuevaFila = fila;
        let nuevaColumna = columna;
        while (true) {
            nuevaFila += dx;
            nuevaColumna += dy;
            if (nuevaFila < 0 || nuevaFila >= 8 || nuevaColumna < 0 || nuevaColumna >= 8) {
                break;
            }
            if (tablero[nuevaFila][nuevaColumna] === "-") {
                movimientos.push([nuevaFila, nuevaColumna]);
            } else {
                if (tablero[nuevaFila][nuevaColumna].charAt(1) !== colorPieza) {
                    movimientos.push([nuevaFila, nuevaColumna]);
                }
                break;
            }
        }
    }
}

function obtenerMovimientosReina(tablero, fila, columna, colorPieza, movimientos) {
    obtenerMovimientosTorre(tablero, fila, columna, colorPieza, movimientos);
    obtenerMovimientosAlfil(tablero, fila, columna, colorPieza, movimientos);
}

function obtenerMovimientosRey(tablero, fila, columna, colorPieza, movimientos) {
    const direcciones = [[1, 0], [-1, 0], [0, 1], [0, -1], [1, 1], [1, -1], [-1, 1], [-1, -1]];
    for (const [dx, dy] of direcciones) {
        const nuevaFila = fila + dx;
        const nuevaColumna = columna + dy;
        if (nuevaFila >= 0 && nuevaFila < 8 && nuevaColumna >= 0 && nuevaColumna < 8) {
            const destino = tablero[nuevaFila][nuevaColumna];
            if (destino === "-" || destino.charAt(1) !== colorPieza) {
                movimientos.push([nuevaFila, nuevaColumna]);
            }
        }
    }
}

function estaEnJaque(tablero, colorRey) {
    const posicionRey = encontrarRey(tablero, colorRey);
    if (!posicionRey) {
        return false; // Si no hay rey en el tablero
    }
    const [filaRey, columnaRey] = posicionRey;
    const enemigo = colorRey === "b" ? "n" : "b";

    // Verificar amenazas de peones
    const direccionesPeon = colorRey === "b" ? [[-1, -1], [-1, 1]] : [[1, -1], [1, 1]];
    for (const [dx, dy] of direccionesPeon) {
        const fila = filaRey + dx;
        const columna = columnaRey + dy;
        if (fila >= 0 && fila < 8 && columna >= 0 && columna < 8 && tablero[fila][columna] === "P" + enemigo) {
            return true;
        }
    }

    // Verificar amenazas de torres y reinas (vertical y horizontal)
    const direccionesTorre = [[1, 0], [-1, 0], [0, 1], [0, -1]];
    for (const [dx, dy] of direccionesTorre) {
        let fila = filaRey;
        let columna = columnaRey;
        while (true) {
            fila += dx;
            columna += dy;
            if (fila < 0 || fila >= 8 || columna < 0 || columna >= 8) {
                break;
            }
            if (tablero[fila][columna] !== "-") {
                if (tablero[fila][columna].charAt(1) === enemigo && 
                   (tablero[fila][columna].charAt(0) === "T" || tablero[fila][columna].charAt(0) === "Q")) {
                    return true;
                }
                break;
            }
        }
    }

    // Verificar amenazas de alfiles y reinas (diagonales)
    const direccionesAlfil = [[1, 1], [1, -1], [-1, 1], [-1, -1]];
    for (const [dx, dy] of direccionesAlfil) {
        let fila = filaRey;
        let columna = columnaRey;
        while (true) {
            fila += dx;
            columna += dy;
            if (fila < 0 || fila >= 8 || columna < 0 || columna >= 8) {
                break;
            }
            if (tablero[fila][columna] !== "-") {
                if (tablero[fila][columna].charAt(1) === enemigo && 
                   (tablero[fila][columna].charAt(0) === "A" || tablero[fila][columna].charAt(0) === "Q")) {
                    return true;
                }
                break;
            }
        }
    }

    // Verificar amenazas de caballos
    const movimientosCaballo = [[2, 1], [2, -1], [-2, 1], [-2, -1], [1, 2], [1, -2], [-1, 2], [-1, -2]];
    for (const [dx, dy] of movimientosCaballo) {
        const fila = filaRey + dx;
        const columna = columnaRey + dy;
        if (fila >= 0 && fila < 8 && columna >= 0 && columna < 8 && tablero[fila][columna] === "C" + enemigo) {
            return true;
        }
    }

    // Verificar amenazas de rey enemigo
    const direccionesRey = [[1, 0], [-1, 0], [0, 1], [0, -1], [1, 1], [1, -1], [-1, 1], [-1, -1]];
    for (const [dx, dy] of direccionesRey) {
        const fila = filaRey + dx;
        const columna = columnaRey + dy;
        if (fila >= 0 && fila < 8 && columna >= 0 && columna < 8 && tablero[fila][columna] === "K" + enemigo) {
            return true;
        }
    }

    return false;
}

// Función para encontrar la posición del rey en el tablero
function encontrarRey(tablero, colorRey) {
    const rey = colorRey === "b" ? "Kb" : "Kn";
    for (let fila = 0; fila < 8; fila++) {
        for (let columna = 0; columna < 8; columna++) {
            if (tablero[fila][columna] === rey) {
                return [fila, columna];
            }
        }
    }
    return null; // No se encontró el rey
}