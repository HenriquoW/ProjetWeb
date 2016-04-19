function connexion(evenement){
  $.post(
        'Controleur/controleur.php',
        {
            "module": $('#'+evenement.target.id).attr('module')
        },
        connexionUpdate,
        'html'
      );
}

function connexionUpdate(donne){
    $('#btnConnexion').html(donne);
}
