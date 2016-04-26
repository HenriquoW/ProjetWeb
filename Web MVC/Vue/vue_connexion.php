<?php

  $response_array = array();

  if($_SESSION['Retour'] == "ErrorMail"){
    $response_array['Status'] = "ErrorMail";
    $response_array['Donne'] = "Mail Invalide";

  }else if($_SESSION['Retour'] == "ErrorPass"){
    $response_array['Status'] = "ErrorMail";
    $response_array['Donne'] = "Mot De Passe Invalide";

  }else if($_SESSION['Retour'] == "OK"){
    //Basculement de session
    $utilisateur = $_SESSION['Utilisateur'];

    session_write_close();

    session_name('SessionUtilisateur');
    session_start();
    $_SESSION['UtilisateurCourant'] = $utilisateur;

    $response_array['Status'] = "Success";
    $response_array['Donne'] = "Connection en cours";
  }

  header('Content-type: application/json');
  echo json_encode($response_array);

?>
