<?php

$response_array = array();

if($_SESSION['Retour'] == "ErrorExist"){
  $response_array['Status'] = "Error";
  $response_array['Type'] = "Append";
  $response_array['Stop'] = "true";
  $response_array['Donne'] = '
      <h2>Echec.</h2>
      <p>L&apos;adresse mail existe déjà. Veuillez recommencer avec une adresse mail valide.</p>';
  $response_array['Region'] = $_POST['regionError'];

}else if($_SESSION['Retour'] == "ErrorPass"){
  $response_array['Status'] = "Error";
  $response_array['Type'] = "Append";
  $response_array['Donne'] = '
    <h2>Echec.</h2>
    <p>Les mots de passe ne sont pas identiques. Veuillez recommencer.</p>';
  $response_array['Stop'] = "true";
  $response_array['Region'] = $_POST['regionError'];

}else if($_SESSION['Retour'] == "Ok"){
  $response_array['Status'] = "Success";
  $response_array['Type'] = "Alert";
  $response_array['Donne'] = "Informations mise à jour";
  $response_array['Stop'] = "false";
  $response_array['Region'] = $_POST['regionSucess'];
}

header('Content-type: application/json');
echo json_encode($response_array);




 ?>
