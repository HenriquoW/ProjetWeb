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
	
	$.ajax({
		type: 'GET',
		url: 'liste_club.php',
		timeout: 3000,
		success: function(data) {
			for(i=0; i < data.length; i++) {
				club = data[i];
				$('#club').append($('<option>', {
					value: club['id'],
					text: data['nom']
				}));
			}
		}
    });   
});

function getClub() {
	 
}