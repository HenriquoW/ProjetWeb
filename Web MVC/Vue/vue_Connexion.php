<?php

  $response_array = array();

  if($_SESSION['Retour'] == "ErrorMail"){
    $response_array['Status'] = "Error";
    $response_array['Type'] = "Append";
    $response_array['Donne'] = "Mail Invalide";
    $response_array['Stop'] = "true";
    $response_array['Region'] = $_POST['regionError'];

  }else if($_SESSION['Retour'] == "ErrorPass"){
    $response_array['Status'] = "Error";
    $response_array['Type'] = "Append";
    $response_array['Donne'] = "Mot De Passe Invalide";
    $response_array['Stop'] = "true";
    $response_array['Region'] = $_POST['regionError'];

  }else if($_SESSION['Retour'] == "OK"){
    //Basculement de session
    $utilisateur = $_SESSION['Utilisateur'];

    session_destroy();
    setcookie("SessionVisiteur","", time() - 3600 , "/");

    session_name('SessionUtilisateur');
    session_start();

    setcookie("Connect", true, time() + 3600, '/');

    $_SESSION['UtilisateurCourant'] = $utilisateur;

    $response_array['Status'] = "Success";
    $response_array['Type'] = "Replace";
    $response_array['Donne'] = "";
    $response_array['Stop'] = "false";
    $response_array['Region'] = $_POST['regionSucess'];
  }

  header('Content-type: application/json');
  echo json_encode($response_array);

?>
