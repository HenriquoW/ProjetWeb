<?php

$response_array = array();

  $response_array['Status'] = "Success";
  $response_array['Type'] = "Alert";
  $response_array['Donne'] = "Voyage modifier";
  $response_array['Stop'] = "false";
  $response_array['Region'] = $_POST['regionSucess'];


header('Content-type: application/json');
echo json_encode($response_array);


 ?>
