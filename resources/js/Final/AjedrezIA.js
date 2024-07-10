var lugar=[0,0];

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////Inicialización Ajedrez vs MinMax/////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function AjedrezPartidaIAMinMax(){
	var xhttp = new XMLHttpRequest();
 	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	console.log("Respuesta server")
	        tablero=JSON.parse(this.responseText);        
	        $("#Partida").show();
			var htmlMarca="<h4>Marcador VS Inteligencia (Global)</h4>";
			htmlMarca+="<table border='1' width='400' style='margin: 0 auto;'>";
			htmlMarca+="<tr><td>Yo</td><td>Inteligencia Artificial</td></tr>";
			htmlMarca+="<tr><td id='MarcadorX'>"+0+"</td><td id='MarcadorY'>"+0+"</td></tr>";
			htmlMarca+="</table>";
			htmlMarca+="</br>";
			htmlMarca+="</br>";
			$("#Titulo").html(htmlMarca);
			$("#Consejos").html("Elije una ficha");
			var hazar=Math.random(0,1);
			console.log(hazar);
			Multijugador=1;
			if (hazar<=0.5) {
				tablero=tablero[0];
				LeToca="J";
				colorJ="b";
				colorIA="n";
			}else{
				tablero=tablero[1];
				LeToca="IA";
				colorJ="n";
				colorIA="b";
				MovimientoIA();
			}
			pintarTBAje(tablero);
	    }
  	};
  	xhttp.open("POST", "../resources/php/Ajedrez1.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("numero="+0);
}
/*
function AjedrezPartidaIAStock(){
	var xhttp = new XMLHttpRequest();
 	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	console.log("Respuesta server")
	        tablero=JSON.parse(this.responseText);        
	        $("#Partida").show();
			var htmlMarca="<h4>Marcador VS Inteligencia (Global)</h4>";
			htmlMarca+="<table border='1' width='400' style='margin: 0 auto;'>";
			htmlMarca+="<tr><td>Yo</td><td>Inteligencia Artificial</td></tr>";
			htmlMarca+="<tr><td id='MarcadorX'>"+0+"</td><td id='MarcadorY'>"+0+"</td></tr>";
			htmlMarca+="</table>";
			htmlMarca+="</br>";
			htmlMarca+="</br>";
			$("#Titulo").html(htmlMarca);
			$("#Consejos").html("Elije una ficha");
			var hazar=Math.random(0,1);
			console.log(hazar);
			Multijugador=2;
			if (hazar<=0.5) {
				tablero=tablero[0];
				LeToca="J";
				colorJ="b";
				colorIA="n";
			}else{
				tablero=tablero[1];
				LeToca="IA";
				colorJ="n";
				colorIA="b";

				MovimientoIAStock();
			}
			pintarTBAje(tablero);
	    }
  	};
  	xhttp.open("POST", "../resources/php/Ajedrez1.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("numero="+0);
}*/


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////Sacar mov Ia////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function MovimientoIA(){
	tablero1=JSON.stringify(tablero);
	var xhttp = new XMLHttpRequest();
 	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	console.log(this.responseText);
	    	console.log(JSON.parse(this.responseText));
	    	tablero=JSON.parse(this.responseText);
	    	
	    	console.log("Esta en jaque:"+estaEnJaque(tablero,colorJ));
	    	console.log("Esta en jaque mate:"+esJaqueMate(tablero, colorJ));
	    	console.log("Esta en jaque IA:"+estaEnJaque(tablero,colorIA));
	    	comprobarIAGana();
	    }else{
	    	console.log("Cargando respuesta de La IA");
	    }
  	};
  	xhttp.open("POST", "../resources/php/Ajedrez1.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("numero="+2+"&tablero="+tablero1+"&colorIA="+colorIA+"&colorJ="+colorJ);
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////Comprobar si con el mov IA gana o ya se da por venciada///////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function comprobarIAGana(){
	if(esJaqueMate(tablero, colorJ)){
        	 	$("#Consejos").html("Gana la IA.");
                for (var i = 0; i < 8; i++) {
                    for (var j = 0; j < 8; j++) {
                        $("#" + i + "" + j).attr('onclick', "");
                    }
            	}
            }
            if(estaEnJaque(tablero, colorIA)){
        	 	$("#Consejos").html("Gana el Jugador ya que la IA se ha dado por vencida.");
                for (var i = 0; i < 8; i++) {
                    for (var j = 0; j < 8; j++) {
                        $("#" + i + "" + j).attr('onclick', "");
                    }
            	}
            }else{
            	pintarTBAje(tablero);
            }
	    	LeToca="J";
}