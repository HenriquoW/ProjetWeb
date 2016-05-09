<?php
  $response_array = array();

  if($_SESSION['Retour'] == "ErrorExist"){
    $response_array['Status'] = "Error";
    $response_array['Type'] = "Append";
    $response_array['Stop'] = "true";
    $response_array['Donne'] = "Utilisateur déjà inscrit";
    $response_array['Region'] = $_POST['regionError'];

  }else if($_SESSION['Retour'] == "Ok"){
    $response_array['Status'] = "Success";
    $response_array['Type'] = "Replace";
    $response_array['Donne'] = "Utilisateur inscrit";
    $response_array['Stop'] = "false";
    $response_array['Region'] = $_POST['regionSucess'];
  }

  header('Content-type: application/json');
  echo json_encode($response_array);
 ?>
