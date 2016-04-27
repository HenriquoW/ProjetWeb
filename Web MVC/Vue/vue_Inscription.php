<?php
  $response_array = array();

  if($_SESSION['Retour'] == "ErrorExist"){
    $response_array['Status'] = "ErrorExist";
    $response_array['Donne'] = "Utilisateur déjà inscrit";
  }else if($_SESSION['Retour'] == "Ok"){
    $response_array['Status'] = "Success";
    $response_array['Donne'] = "Utilisateur inscrit";
  }

  header('Content-type: application/json');
  echo json_encode($response_array);
 ?>
