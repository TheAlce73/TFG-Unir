$(document).ready(function(){
	
	$('#Juego').hide()
	$('#tipos').show();
	$("#idUsr").hide();
	$("#Partida").hide();
	$('#BoJu').show();
	$('#PartidasIni').show();
	$('#amigosMios').hide();
	AjedrezPartidaJ();


	$("#BoJu").click(function(){
		AjedrezPartidaJ();
	});
	$("#modoMP").click(function(){
		$('#tipos').show();
		$('#BoJu').show();
		$("#Partida").hide();
		$('#amigosMios').show();
		AjedrezPartidaJ();
	});

		

	
});