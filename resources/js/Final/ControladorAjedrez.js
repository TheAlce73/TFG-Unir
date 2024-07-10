$(document).ready(function(){
	
	$('#Juego').hide()
	$('#tipos').show();
	$("#idUsr").hide();
	$("#Partida").hide();
	$('#BoJu').show();
	$('#PartidasIni').show();
	$('#amigosMios').hide();

	$("#modoIAMinMax").click(function(){
		$('#tipos').hide();
		$('#BoJu').hide();
		AjedrezPartidaIAMinMax();
	});

	$("#modoIAStock").click(function(){
		$('#tipos').hide();
		$('#BoJu').hide();
		AjedrezPartidaIAStock();
	});

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