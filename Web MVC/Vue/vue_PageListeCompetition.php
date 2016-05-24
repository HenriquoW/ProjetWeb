<?php

$response_array = array();
$response_array['Status'] = "Success";
$response_array['Type'] = "Replace";
$response_array['Donne'] = '<div id="listeCompetition" class="div_liste_competition">
                              <h1> Liste des compétitions </h1>
                              <table>
                                '.
                                  $_SESSION['Retour']
                                .'
                              </table>
                            </div>
                            <div id="competition">


                            </div>
                            ';
$response_array['Stop'] = "false";
$response_array['Region'] = $_POST['regionSucess'];

unset($_SESSION['Retour']);

header('Content-type: application/json');
echo json_encode($response_array);


?>
