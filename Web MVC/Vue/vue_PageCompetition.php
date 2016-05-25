<?php

$competition = $_SESSION['Retour']['Competition'];

$response_array = array();
$response_array['Status'] = "Success";
$response_array['Type'] = "Replace";
$response_array['Donne'] = '<input type="hidden" name="id_Competition" id="IdCompetition" value="'.$competition->getId_Competition().'">
                            <label>Nom de la compétition</label> <input type="text" placeholder="" name="nom" id="IdNom" value="'.$competition->getTypeCompetition()['Nom'].'-'.$competition->getAdresse().'" readonly/><br/>
                            <label>Date de la compétition</label> <input type="number" placeholder="jour" name="jour" id="IdJour" min="1" max="31" value="'.$competition->getDateCompetition()->format('d').'" readonly/>
                            <input type="number" placeholder="mois" name="mois" id="IdMois" min="1" max="12" value="'.$competition->getDateCompetition()->format('m').'" readonly/>
                            <input type="number" placeholder="année" name="annee" id="IdAnnee" min="1950" max="'.date('Y').'" value="'.$competition->getDateCompetition()->format('Y').'" readonly/><br/>
                            <label>Nom du club organisateur</label> <input type="text" placeholder="" name="nomClub" id="IdNomClub" value="'.$competition->getClub()->getNom().'" readonly/><br/>

                            <table name="InfoEpreuve">
                            '.
                              $_SESSION['Retour']['Course']
                            .'
                            </table>

                            '.
                              (($_SESSION['UtilisateurCourant']->asDroit(array("Secrétaire","Entraineur")))?('<table name="InfoVoyage>"
                                                                                                                '.$_SESSION['Retour']['Voyage'].'
                                                                                                              </table>')
                                                                                                            :(''))
                            .'

                            ';
$response_array['Stop'] = "false";
$response_array['Region'] = $_POST['regionSucess'];

unset($_SESSION['Retour']);

header('Content-type: application/json');
echo json_encode($response_array);









 ?>
