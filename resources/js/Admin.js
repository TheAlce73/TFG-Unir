function Eliminar(id) {
	var xhttp = new XMLHttpRequest();
 	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	var datos=JSON.parse(this.responseText);
	    	var html="<table class='table'>";
	       	for (var i = 0; i < datos['nombres'].length ; i++) {
	       		html+="<tr>";
	       		html+="<td>"+datos["nombres"][i]+"<td>";
	       		html+="<td><button class='btn btn-danger' onclick=Eliminar(\""+datos["id"][i]+"\")>Eliminar</button></td>";
	       		html+="</tr>";
	       	}
	       	html+="</table>";
	       	
	       	$("#UsuariosTotales").html(html);
	    }	
  	};
  	xhttp.open("POST", "../resources/php/Admin.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("casos="+0+"&id="+id);
}

function EliminarPT(id) {
	var xhttp = new XMLHttpRequest();
 	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	var datos=JSON.parse(this.responseText);
	    	var html="<table class='table'>";
	       	for (var i = 0; i < datos['id'].length ; i++) {
	       		html+="<tr>";
	       		html+="<td>"+datos["nombres1"][i]+" vs "+datos["nombres2"][i]+"<td>";
	       		html+="<td><button class='btn btn-danger' onclick=EliminarPT(\""+datos["id"][i]+"\")>Eliminar</button></td>";
	       		html+="</tr>";
	       	}
	       	html+="</table>";
	       	
	       	$("#PartidasTotales").html(html);
	    }	
  	};
  	xhttp.open("POST", "../resources/php/Admin.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("casos="+1+"&id="+id);
}
function EliminarPA(id) {
	var xhttp = new XMLHttpRequest();
 	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	    	var datos=JSON.parse(this.responseText);
	    	var html="<table class='table'>";
	       	for (var i = 0; i < datos['id'].length ; i++) {
	       		html+="<tr>";
	       		html+="<td>"+datos["nombres1"][i]+" vs "+datos["nombres2"][i]+"<td>";
	       		html+="<td><button class='btn btn-danger' onclick=EliminarPA(\""+datos["id"][i]+"\")>Eliminar</button></td>";
	       		html+="</tr>";
	       	}
	       	html+="</table>";
	       	
	       	$("#PartidasTotales1").html(html);
	    }	
  	};
  	xhttp.open("POST", "../resources/php/Admin.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xhttp.send("casos="+2+"&id="+id);
}