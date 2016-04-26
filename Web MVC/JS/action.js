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

function PageConnexionUpdate(donne){
    $('#body').html(donne);
}

function Connexion(evenement){
  $.post(
        'Controleur/controleur.php',
        {
            "module": $('#'+evenement.target.id).attr('module'),
            "Mail": $('#mail').val(),
            "Password": $('#pass').val()
        },
        ConnexionUpdate,
        'json'
      );
}

function PageConnexionUpdate(donne){
    $('#body').html(donne);
}

function ConnexionUpdate(donne){
    if(donne.Status == "ErrorMail" || donne.Status == "ErrorPass"){
      $('#DivConnexion').append(donne.Donne);
    }else if(donne.Status == "Success"){
      //$('#DivConnexion').append(donne.Donne);

      //chargement profil
      $.post(
            'Controleur/controleur.php',
            {
                "module": "Profil"
            },
            ProfilUpdate,
            'html'
          );
    }
}

function ProfilUpdate(donne){
  $('#body').html(donne);
}
