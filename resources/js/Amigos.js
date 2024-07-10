function Amigos(nombre,id){
	var xhttp = new XMLHttpRequest();
 	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	        if(this.responseText=="Hay Un Fallo De Conesión Con la BD"){
	        	window.alert(this.responseText);
	        }else{
				AmigosConect(nombre,id);
				Solicitudes(nombre,id);
	        }
  	}};
  	xhttp.open("POST", "../resources/php/Amigos.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("nombre="+nombre+"&id="+id+"&casos="+0);
}
function AmigosConect(nombre,id){
	var xhttp = new XMLHttpRequest();
 	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	var amigosRelleno;
	        var amigos= JSON.parse(this.responseText);
	        if (amigos.length==0) {
	        	$("#TablaAmigosConectados").hide();
	        	amigosRelleno="";
	        }else{
	        	$("#TablaAmigosConectados").show();
	        	amigosRelleno="<h4>Amigos</h4>";
	        	amigosRelleno+="<table class='table' >";
	        	amigosRelleno+="<tr><td>Amigos</td><td>Conectados</td></tr>";
	        	for (var i = 0 ; amigos.length > i; i++) {
	        		amigosRelleno+="<tr align='center'><td>"+amigos[i]+"</td><td>Proximamente</td></tr>"
	        	}
	        	amigosRelleno+="</table>";
	        }
	    $("#TablaAmigosConectados").html(amigosRelleno);
  	}};
  	xhttp.open("POST", "../resources/php/Amigos.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("nombre="+nombre+"&id="+id+"&casos="+1);
}
function Solicitudes(nombre,id){
	var xhttp = new XMLHttpRequest();
 	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	var solicitudRelleno;
	        var solicitudes= JSON.parse(this.responseText);
	        console.log(solicitudes.length);
	        if (solicitudes.length==0) {
	        	$("#TablaSolicitudes").hide();
	        }else{
	        	$("#TablaSolicitudes").show();
	        	solicitudRelleno="<h4>Solicitudes</h4>";
	        	solicitudRelleno+="<table class='table' id='solicitudesN' value="+solicitudes.length+">";
	        	solicitudRelleno+="<tr ><td colspan='2' align='center'>Solicitudes</td></tr>";
	        	for (var i = 0 ; solicitudes.length > i; i++) {
	        		solicitudRelleno+="<tr><td align='center' >"+solicitudes[i]+"</td>";
	        		solicitudRelleno+="<td><button type='submit' id='000' onclick='Amigos(\""+solicitudes[i]+"\",\""+id+"\")'> Aceptar</button></td></tr>";
	        	}
	        	solicitudRelleno+="</table>";
	        }
	    $("#TablaSolicitudes").html(solicitudRelleno);
  	}};
  	xhttp.open("POST", "../resources/php/Amigos.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("nombre="+nombre+"&id="+id+"&casos="+2);
}
function AnadirAmigo(id){
	var idJugado=$('#NuevoAmigo').val();
	var xhttp = new XMLHttpRequest();
 	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	window.alert(this.responseText);
  	}};
  	xhttp.open("POST", "../resources/php/Amigos.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("idAgregar="+idJugado+"&id="+id+"&casos="+3);
}