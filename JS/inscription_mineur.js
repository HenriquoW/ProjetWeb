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
		console.log(competition+" "+embarcation+" "+taille+" "+e1+" "+e2+" "+e3+" "+e4);
	});
});

function getListe() {
	
}

function loadListe() {

}