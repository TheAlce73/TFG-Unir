var Multijugador=-1;
function SacarDatosJugadoresA(){ 
	idUsr=$("#idUsr").val();
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
      	if(this.responseText=='Hay Un Fallo De Conesión Con la BD'){
          	window.alert(this.responseText);
      	}else{
        		datosJ=JSON.parse(this.responseText);
            var tamañoDatos=datosJ['nombres'].length;
            var tabla1="";
            var tabla2="";
            
            for(var i=0;i<tamañoDatos;i++){
              if (datosJ['turno'][i]==datosJ['marcaJ'][i]&&datosJ['victoria'][i]==0) {
                tabla1+= "<tr>";  
                tabla1+= "<td onclick='PartidaVsPlayer1("+i+")'>"+datosJ['nombres'][i]+"</td>";
                tabla1+= "</tr>";
              }
            }
            for(var i=0;i<tamañoDatos;i++){
              if (datosJ['victoria'][i]!=0) {
                tabla2+= "<tr>";  
                tabla2+= "<td onclick='PartidaVsPlayer1("+i+")'>"+datosJ['nombres'][i]+"</td>";
                tabla2+= "</tr>";
              }
            }
            if (tabla2!="") {
              $("#Historial").show();
              $("#PatidasAcabadas").html(tabla2);
            }else{
              $("#Historial").hide();
            }

            if (tabla1!="") {
              $('#PartidasIni').show();
              $("#PartidasTeToca").html(tabla1);
            }else{
              $('#PartidasIni').hide();
            }
            console.log("Tabla1 Actualizados");

      	}
    	}
  };
  xhttp.open("POST", "../resources/php/PartidasMP1.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("idUsr="+idUsr+"&Accion="+0); 
}

function CombertirTab2(tablero,colorJ){
  
  var tablero1=[
    ["-","-","-","-","-","-","-","-"],
    ["-","-","-","-","-","-","-","-"],
    ["-","-","-","-","-","-","-","-"],
    ["-","-","-","-","-","-","-","-"],
    ["-","-","-","-","-","-","-","-"],
    ["-","-","-","-","-","-","-","-"],
    ["-","-","-","-","-","-","-","-"],
    ["-","-","-","-","-","-","-","-"]
  ];
  if (colorJ=="b") {
    var x=0;
    var y=0;
    for (var i = 0; i < tablero.length; i++) {  
      if (y==8) {
        x++;
        y=0;
      }
      if(tablero[i]!='['&&tablero[i]!=']'&&tablero[i]!=','){ 
        if (tablero[i]=="P"||tablero[i]=="T"||tablero[i]=="C"||tablero[i]=="A"||tablero[i]=="Q"||tablero[i]=="K") {
          tablero1[x][y]=tablero[i]+tablero[i+1];
          i++;
        }
        y++;
      }
    }
  }else{
    var x=7;
    var y=7;
    for (var i = 0; i < tablero.length; i++) {
      if (y==-1) {
        x--;
        y=7;
      }
      if(tablero[i]!='['&&tablero[i]!=']'&&tablero[i]!=','){ 
        if (tablero[i]=="P"||tablero[i]=="T"||tablero[i]=="C"||tablero[i]=="A"||tablero[i]=="Q"||tablero[i]=="K") {
          tablero1[x][y]=tablero[i]+tablero[i+1];
          i++;
        }
        y--;
      }
    }

  }
  
  return tablero1;
}

function PartidaVsPlayer1(id){
  IDPActual=datosJ['idP'][id];
  colorJ=datosJ['marcaJ'][id];
  tablero=CombertirTab2(datosJ['tablero'][id],colorJ);
  LeToca="J";
  Multijugador=0;
  JugadorMp=datosJ['marcaJ'][id];
  LeTocaMp=datosJ['turno'][id];
  victoria=datosJ['victoria'][id]
  pintarTBAje(tablero);
  $('#Titulo').html("<h4>Partida VS "+datosJ['nombres'][id]+"</h4>");
  $("#Titulo").show();
  $("#tablero").show();
  $('#resultadoPartida').hide();
  $('#Partida').show();
}

function AjedrezPartidaJ(){
  var tipo=$('#tipos').val();
  if (tipo=='azar'){
    PartidaAlAzar1();
    $('#amigosMios').hide();
  }else if(tipo=='amigos'){
    window.alert("Elige al amigo con quien quieres jugar");
    PartidaConAmigo1();
  }
  SacarDatosJugadoresA();
}

function jugada(IDPActual,LeTocaMp,victoria,tablero){
  idUsr=$("#idUsr").val();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(this.responseText=='Hay Un Fallo De Conesión Con la BD'){
          window.alert(this.responseText);
        }else{
            datosJ=JSON.parse(this.responseText);
            var tamañoDatos=datosJ['nombres'].length;
            var tabla1="";
            var tabla2="";
            
            for(var i=0;i<tamañoDatos;i++){
              if (datosJ['turno'][i]==datosJ['marcaJ'][i]&&datosJ['victoria'][i]==0) {
                tabla1+= "<tr>";  
                tabla1+= "<td onclick='PartidaVsPlayer1("+i+")'>"+datosJ['nombres'][i]+"</td>";
                tabla1+= "</tr>";
              }
            }
            for(var i=0;i<tamañoDatos;i++){
              if (datosJ['victoria'][i]!=0) {
                tabla2+= "<tr>";  
                tabla2+= "<td onclick='PartidaVsPlayer1("+i+")'>"+datosJ['nombres'][i]+"</td>";
                tabla2+= "</tr>";
              }
            }
            if (tabla2!="") {
              $("#Historial").show();
              $("#PatidasAcabadas").html(tabla2);
            }else{
              $("#Historial").hide();
            }

            if (tabla1!="") {
              $('#PartidasIni').show();
              $("#PartidasTeToca").html(tabla1);
            }else{
              $('#PartidasIni').hide();
            }
            console.log("Tabla1 Actualizados");
        }
      }
  };
  xhttp.open("POST", "../resources/php/PartidasMP1.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("idUsr="+idUsr+"&IDPActual="+IDPActual+"&LeTocaMp="+LeTocaMp+"&victoria="+victoria+"&tablero="+tablero+"&Accion="+1); 
}

function PartidaAlAzar1(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(this.responseText=='Hay Un Fallo De Conesión Con la BD'){
          window.alert(this.responseText);
        }else{
          idUsr=$("#idUsr").val();
          var jugadoresPosibles=JSON.parse(this.responseText);
          numeroJ=jugadoresPosibles.length;
          var idContrario=idUsr;
          while(idContrario==idUsr){
            idContrario=Math.floor(Math.random() * numeroJ)+1;
          }

          AnadirPartida1(idUsr,idContrario);

        }
      }
  };
  xhttp.open("POST", "../resources/php/PartidasMP.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("idUsr="+idUsr+"&Accion="+2); 
}


function AnadirPartida1(idUsr,idContrario){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(this.responseText=='Hay Un Fallo De Conesión Con la BD'){
          window.alert(this.responseText);
        }else{
            SacarDatosJugadoresA();
            EmpezarPartida1(this.responseText);
        }
      }
  };
  xhttp.open("POST", "../resources/php/PartidasMP1.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("idUsr="+idUsr+"&idContrario="+idContrario+"&Accion="+2); 
}

function EmpezarPartida1(idPartida){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(this.responseText=='Hay Un Fallo De Conesión Con la BD'){
          window.alert(this.responseText);
        }else{
            IDPActual=idPartida;
            datosP=JSON.parse(this.responseText);
            JugadorMp="b";
            LeTocaMp="b";
            colorJ="b";
            LeToca="J";
            Multijugador=0;
            tablero=CombertirTab2(datosP['tablero'][0],colorJ);
            console.log(tablero);
            victoria=0;
            pintarTBAje(tablero);
            $('#Titulo').html("<h4>Partida VS "+datosP['Contrario'][1]+"</h4>");
            $("#Titulo").show();
            $("#tablero").show();
            $("#Marcadores").show();
            $('#resultadoPartida').hide();
            $('#Partida').show();
        }
      }
  };
  xhttp.open("POST", "../resources/php/PartidasMP1.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("idUsr="+idUsr+"&idPartida="+idPartida+"&Accion="+3); 
}
function PartidaConAmigo1(){
  var idUsr=$("#idUsr").val();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        var amigos= JSON.parse(this.responseText);
        amigos=JSON.stringify(amigos);
        Sacarid1(amigos);
            
    }};
    xhttp.open("POST", "../resources/php/Amigos.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+idUsr+"&casos="+1);
}
function Sacarid1(amigos){
  var idUsr=$("#idUsr").val();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        if(this.responseText=='Hay Un Fallo De Conesión Con la BD'){
          window.alert(this.responseText);
        }else{
          var idsContrarios=JSON.parse(this.responseText);
          var tablaAmigos="";
          amigos=JSON.parse(amigos);
          for (var i =0 ; i < idsContrarios.length; i++) {
            $('#amigosMios').show();
            console.log(idsContrarios[i]);
            tablaAmigos+= "<tr>";  
            tablaAmigos+= "<td onclick='AnadirPartida1("+idUsr+","+idsContrarios[i]+")'>"+amigos[i]+"</td>";
            tablaAmigos+= "</tr>";
            $("#PartidaVSAmigo").html(tablaAmigos);
          } 

        }
      }
  };
  xhttp.open("POST", "../resources/php/PartidasMP.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("idUsr="+idUsr+"&nombre="+amigos+"&Accion="+5); 
}