<?php

$response_array = array();

$response_array['Status'] = "Success";
$response_array['Type'] = "Replace";
$response_array['Donne'] = $_SESSION['Retour']['InfoObjectif'];
$response_array['Stop'] = "false";
$response_array['Region'] = $_POST['regionSucess'];

header('Content-type: application/json');
echo json_encode($response_array);

unset($_SESSION['Retour']);

 ?>
