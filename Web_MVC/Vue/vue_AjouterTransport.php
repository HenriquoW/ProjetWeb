<?php

$response_array = array();
if($_SESSION['Retour']=="ErrorInfo"){
  $response_array['Status'] = "Error";
  $response_array['Type'] = "Alert";
  $response_array['Donne'] = "Information manquante";
  $response_array['Stop'] = "true";
  $response_array['Region'] = $_POST['regionError'];

}else if($_SESSION['Retour']=="Ok"){
  $response_array['Status'] = "Success";
  $response_array['Type'] = "Alert";
  $response_array['Donne'] = "Transport Ajouter";
  $response_array['Stop'] = "false";
  $response_array['Region'] = $_POST['regionSucess'];
}

header('Content-type: application/json');
echo json_encode($response_array);

 ?>
