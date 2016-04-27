/*
* Function evenement clic
*/
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

function Connexion(evenement){
  //ajoute cookie
  if($('input[name=saveCo]').is(':checked')){
    setCookie("Mail",$('#mail').val(),365);
  }else{
    removeCookie("Mail");
  }

  $.post(
        'Controleur/controleur.php',
        {
            "module": $('#'+evenement.target.id).attr('module'),
            "Mail": $('#mail').val(),
            "Password": $('#pass').val(),
        },
        ConnexionUpdate,
        'json'
      );

}

function Inscription(evenement){

  if(!$('input[name=termes]').is(':checked')){
    $('#DivInscription').append("Valider conditions d'utilisation");

  }else if($('#pass1').val()!=$('#pass2').val()){
    $('#DivInscription').append("Les deux mot de passe doivent être identique");
    $('#pass2').val("");

  }else{
    $.post(
          'Controleur/controleur.php',
          {
              "module": $('#'+evenement.target.id).attr('module'),
              "Mail" : $('#mailIns').val(),
              "Password" : $('#pass1').val()
          },
          InscriptionUpdate,
          'json'
        );
  }


}

/*
* Function update page
*/
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

}
