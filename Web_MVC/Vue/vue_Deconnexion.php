<?php
$response_array = array();

session_destroy();

setcookie("Connect","", time() - 3600 , "/");
setcookie("SessionUtilisateur","", time() - 3600 , "/");

$response_array['Status'] = "Success";
$response_array['Type'] = "Replace";
$response_array['Donne'] = "Déconnexion";
$response_array['Stop'] = "false";
$response_array['Region'] = $_POST['regionSucess'];

header('Content-type: application/json');
echo json_encode($response_array);
?>
