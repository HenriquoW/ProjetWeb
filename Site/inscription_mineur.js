liste_competiteur = null;

$(document).ready(function() {
    $("input[name='taille']").on('change', function() {
		//alert( this.value ); // or $(this).val()
		if(this.value==4) {
		$(".e4").show();
		}
		else if(this.value<=2) {
			$(".e4").hide();
			if(this.value==1) 
				$(".e2").hide();
			else 
				$(".e2").show();
		}

	});
	
	$("input[type='submit']").on('click',function(){
		console.log("validation");
		competition = $("#competition option:selected").val();
		embarcation = $("input[name='type']:checked").val();
		taille = $("input[name='taille']:checked").val();
		e1 = $("#p1 option:selected").val();
		e2 = null;
		e3 = null;
		e4 = null;
		if(taille>1)
			e2 = $("#p2 option:selected").val();
		if(taille==4){
			e3 = $("#p3 option:selected").val();
			e4 = $("#p4 option:selected").val();
		}
		nomEquipe = $("input[name='nom']").val();
		console.log(competition+" "+embarcation+" "+taille+" "+e1+" "+e2+" "+e3+" "+e4);
	});
	getListe(); //initialise la liste des competiteur mineur
	loadListeCompetition(); //initialise la liste des competition mineur
});

function sendToPhp(competition, embarcation, taille, e1,e2,e3,e4) {
		$.ajax({
            type: 'GET',
            
            url: './ajout_comp_mineur_bdd.php',
            data: {
            	"competion":competition,
            	"embarcation":embarcation,
            	"taille":taille,
            	"nomEquipe":nomEquipe,
            	"e1":e1,
            	"e1":e2,
            	"e1":e3,
            	"e1":e4

            },
            timeout: 3000,
            success: function(data) {
                      
              
               },
            error: function() {
              alert('La requête n\'a pas abouti'); }
          });    
	}

function getListe() {
	 
	 $.ajax({
            type: 'GET',
            
            url: './liste_compet_mineur.php',
            timeout: 3000,
            success: function(data) {
              data=$.parseJSON(data);
              for(i=0; i < data.length;i++) {
              	compMineur = data[i];
              	var option = new Option(compMineur['nom'], compMineur['id']);
              	$('#p1').append(option);
              	
              }
              $('#p1 option').clone().appendTo('#p2');
              $('#p1 option').clone().appendTo('#p3');
              $('#p1 option').clone().appendTo('#p4');

               },
            error: function() {
              alert('La requête n\'a pas abouti'); }
          });    
}

function loadListeCompetition() {
	$.ajax({
            type: 'GET',
            
            url: './liste_compet.php',
            timeout: 3000,
            success: function(data) {
              data=$.parseJSON(data);
              for(i=0; i < data.length;i++) {
              	comp = data[i];
              	var option = new Option(comp['nom'], comp['id']);
              	$('#competition').append(option);
              	
              }

               },
            error: function() {
              alert('La requête n\'a pas abouti'); }
          });    

}