$("#ajout").hide();
$(document).ready(function() {
	$("input[name='ajout']").on('click',function(){
		$("#ajout").show();
		$("#inscription").hide();
	});
	
	$("input[name='retour']").on('click',function(){
		$("#ajout").hide();
		$("#inscription").show();
	});
	
	$("#valide_comp").on('click',function() {
		club = $("#club option:selected").val();
		date = $("input[name='date']").val();
		adresse = $("input[name='adresse']").val();
		console.log(club+" "+date+" "+adresse);
	});
	
	$("#valide_club").on('click',function() {
		nom = $("input[name='nom']").val();
		president = $("input[name='president']").val();
		console.log(nom+" "+president);
	});
});
