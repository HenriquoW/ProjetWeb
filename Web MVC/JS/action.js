/*
* Function evenement clic
*/

var CoupeChoix = false;

function Action(evenement){
  var modules = [];
  var regionSucess = [];
  var regionError = [];
  var donneARecup = [];
  var data = {};

  if($('#'+evenement.target.id).attr('module')!=null)
    modules = $('#'+evenement.target.id).attr('module').split(';');

  if($('#'+evenement.target.id).attr('regionSucess')!=null)
    regionSucess = $('#'+evenement.target.id).attr('regionSucess').split(';');

  if($('#'+evenement.target.id).attr('regionError')!=null)
    regionError = $('#'+evenement.target.id).attr('regionError').split(';');

  if($('#'+evenement.target.id).attr('donne')!=null){
    donneARecup = $('#'+evenement.target.id).attr('donne').split(';');

    for(var i=0;i<donneARecup.length;i++){
      if(!$('#Id'+donneARecup[i]).is(':checkbox')){
        data[donneARecup[i].split('_')[0]] = $('#Id'+donneARecup[i]).val();
      }
      else {
        data[donneARecup[i].split('_')[0]] = $('#Id'+donneARecup[i]).is(':checked');
      }
    }
  }

  CoupeChoix = false;

  for(var i=0;i<modules.length; i++){
   
    (function(i){
        setTimeout(function(){
	if(!CoupeChoix){
            $.post(
                  'Controleur/controleur.php',
                  {
                      "module": modules[i],
                      "regionSucess": regionSucess[i],
                      "regionError": regionError[i],
                      "donne": JSON.stringify(data)
                  },
                  Update,
                  'json'
                );
		}
        }, 100 * i);
    }(i));
   
  }
}

function Update(data){

  if(data.Type == "Append")
    $(data.Region).append(data.Donne);
  else if(data.Type == "Replace"){
    $(data.Region).html(data.Donne);
  }else if(data.Type == "Alert"){
    alert(data.Donne);
  }

  if(data.Stop == "true"){
    CoupeChoix = true;
  }else if(data.Stop == "false"){
    CoupeChoix = false;
  }

}
