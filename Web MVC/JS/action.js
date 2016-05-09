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
      data[donneARecup[i]] = $('#Id'+donneARecup[i]).val();
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
  console.log(data.Donne);
  
  if(data.Type == "Append")
    $(data.Region).append(data.Donne);
  else if(data.Type == "Replace"){
    $(data.Region).html(data.Donne);
  }

  if(data.Stop == "true"){
    CoupeChoix = true;
  }else if(data.Stop == "false"){
    CoupeChoix = false;
  }

}

function Connexion(evenement){
  //ajoute cookie
  if($('input[name=saveCo]').is(':checked')){
    setCookie("Mail",$('#mail').val(),365);
  }else{
    removeCookie("Mail");
  }

  Action(evenement);

}

function Inscription(evenement){

  if(!$('input[name=termes]').is(':checked')){
    $('#DivInscription').append("Valider conditions d'utilisation");

  }else if($('#pass1').val()!=$('#pass2').val()){
    $('#DivInscription').append("Les deux mot de passe doivent être identique");
    $('#pass2').val("");

  }else{
    Action(evenement);
  }


}


/*
function PageConnexion(evenement){

  $.post(
        'Controleur/controleur.php',
        {
            "module": $('#'+evenement.target.id).attr('module')
        },
        PageConnexionUpdate,
        'html'
      );
}




* Function update page

function UpdateBody(donne){
  $('#body').html(donne);
}

function ConnexionUpdate(donne){
    if(donne.Status == "ErrorMail" || donne.Status == "ErrorPass"){
      $('#DivConnexion').append(donne.Donne);
    }else if(donne.Status == "Success"){
      $('#DivConnexion').append(donne.Donne);

      //chargement profil
      $.post(
            'Controleur/controleur.php',
            {
                "module": "Profil"
            },
            UpdateBody,
            'html'
          );
    }
}

function PageConnexionUpdate(donne){

  $('#body').html(donne);
  //test si cookie
  var mail = getCookie("Mail");

  if(mail!=""){
    $('#mail').val(mail);
    $('#saveCo').prop('checked',true);
  }

}

function InscriptionUpdate(donne){
  if(donne.Status == "ErrorExist" ){
    $('#DivInscription').append(donne.Donne);

  }else if(donne.Status == "Success"){
    $('#DivInscription').append(donne.Donne);
  }

}*/
