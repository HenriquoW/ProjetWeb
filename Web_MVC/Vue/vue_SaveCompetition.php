<?php

$response_array = array();

if($_SESSION['Retour'] == "ErrorAdresse"){
  $response_array['Status'] = "Error";
  $response_array['Type'] = "Append";
  $response_array['Stop'] = "true";
  $response_array['Donne'] = '
      <h2>Echec.</h2>
      <p>Vous devez renseigner l&apos;adresse de la competition. Veuillez recommencer.</p>';
  $response_array['Region'] = $_POST['regionError'];

}else if($_SESSION['Retour'] == "ErrorDate"){
  $response_array['Status'] = "Error";
  $response_array['Type'] = "Append";
  $response_array['Donne'] = '
    <h2>Echec.</h2>
    <p>Vous devez renseigner la date de la compétition. Veuillez recommencer.</p>';
  $response_array['Stop'] = "true";
  $response_array['Region'] = $_POST['regionError'];

}else if($_SESSION['Retour'] == "ErrorClub"){
  $response_array['Status'] = "Error";
  $response_array['Type'] = "Append";
  $response_array['Donne'] = '
    <h2>Echec.</h2>
    <p>Veuillez sélectionner un club ou en créer un.</p>';
  $response_array['Stop'] = "true";
  $response_array['Region'] = $_POST['regionError'];

}else if($_SESSION['Retour'] == "ErrorNewClub"){
  $response_array['Status'] = "Error";
  $response_array['Type'] = "Append";
  $response_array['Donne'] = '
    <h2>Echec.</h2>
    <p>Veuillez donner le nom du club ainsi que le nom du président.</p>';
  $response_array['Stop'] = "true";
  $response_array['Region'] = $_POST['regionError'];

}else if($_SESSION['Retour'] == "ErrorType"){
  $response_array['Status'] = "Error";
  $response_array['Type'] = "Append";
  $response_array['Donne'] = '
    <h2>Echec.</h2>
    <p>Veuillez selectionner un type pour la compétition.</p>';
  $response_array['Stop'] = "true";
  $response_array['Region'] = $_POST['regionError'];

}else if($_SESSION['Retour'] == "Ok"){
  $response_array['Status'] = "Success";
  $response_array['Type'] = "Alert";
  $response_array['Donne'] = "Competition Ajouter";
  $response_array['Stop'] = "false";
  $response_array['Region'] = $_POST['regionSucess'];
}

header('Content-type: application/json');
echo json_encode($response_array);

 ?>
