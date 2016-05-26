<?php
$competition = loadCompetition(array("Id"=>$data['Competition']));

$infoCourse = '';
$index = 0;
foreach (loadCourseCompetition($competition->getId_Competition()) as $course) {
  $infoCat ='';
  foreach (BDD::getInstance()->getManager("Categorie")->getList() as $cat) {
    $infoCat = $infoCat.'<option value="'.$cat["Id"].'" '.(($cat["Nom"]==$course->getCategorie()["Nom"])?('selected="selected"'):('')).'>'.$cat["Nom"].'</option>';
  }

  $infoSpe ='';
  foreach (BDD::getInstance()->getManager("Type_Specialite")->getList() as $spe) {
    $infoSpe = $infoSpe.'<option value="'.$spe["Id"].'" '.(($spe["Nom"]==$course->getCategorie()["Nom"])?('selected="selected"'):('')).'>'.$spe["Nom"].'</option>';
  }

  $infoCourse = $infoCourse .'<tr>
                                <td>
                                  <input type="text" name="distance" id="IdDistance_'.$index.'" value="'.$course->getDistance().'" />
                                </td>
                                <td>
                                  <select name="Categorie" id="IdCategorie_'.$index.'" readonly>
                                  '.
                                    $infoCat
                                  .'
                                  </select>
                                </td>
                                <td>
                                  <select name="Categorie" id="IdSpecialite_'.$index.'" readonly>
                                  '.
                                    $infoSpe
                                  .'
                                  </select>
                                </td>
                                <td>
                                  <input type="input" name="Modifier" id="btnSaveCourse" module="SaveCourse;PageCompetition" regionSucess="#competition" regionError="#competition" donne="Competition;Course_'.$index.';Distance_'.$index.';Categorie_'.$index.';Specialite_'.$index.'" value="Modifier"/>
                                </td>
                                <td>
                                  <input type="input" name="Supprimer" id="btnSupprimerCourse" module="SupprimerCourse;PageCompetition" regionSucess="#competition" regionError="#competition" donne="Competition;Course_'.$index.'" value="Modifier"/>
                                </td>
                              </tr>';
  $index++;
}

$infoCat ='';
foreach (BDD::getInstance()->getManager("Categorie")->getList() as $cat) {
  $infoCat = $infoCat.'<option value="'.$cat["Id"].'" >'.$cat["Nom"].'</option>';
}

$infoSpe ='';
foreach (BDD::getInstance()->getManager("Type_Specialite")->getList() as $spe) {
  $infoSpe = $infoSpe.'<option value="'.$spe["Id"].'">'.$spe["Nom"].'</option>';
}

$infoCourse = $infoCourse .'<tr>
                              <td>
                                <input type="text" name="distance" id="IdDistance_'.$index.'" value="" />
                              </td>
                              <td>
                                <select name="Categorie" id="IdCategorie_'.$index.'" readonly>
                                '.
                                  $infoCat
                                .'
                                </select>
                              </td>
                              <td>
                                <select name="Categorie" id="IdSpecialite_'.$index.'" readonly>
                                '.
                                  $infoSpe
                                .'
                                </select>
                              </td>
                              <td>
                                <input type="input" name="Ajouter" id="btnAjouterCourse" module="AjouterCourse;PageCompetition" regionSucess="#competition" regionError="#competition" donne="Competition;Distance_'.$index.';Categorie_'.$index.';Specialite_'.$index.'" value="Ajouter"/>
                              </td>
                            </tr>';



$infoClub ='';
foreach (BDD::getInstance()->getManager("Club_Organisateur")->getList() as $club) {
  $infoClub = $infoClub.'<option value="'.$club->getId_Club_Organisateur().'" '.(($club==$competition->getClub())?('selected="selected"'):('')).'>'.$club->getNom().'</option>';
}

$infoType ='';
foreach (BDD::getInstance()->getManager("Type_Competition")->getList() as $type) {
  $infoType = $infoType.'<option value="'.$type['Id'].'" '.(($type['Nom']==$competition->getTypeCompetition()['Nom'])?('selected="selected"'):('')).'>'.$type['Nom'].'</option>';
}

$response_array = array();
$response_array['Status'] = "Success";
$response_array['Type'] = "Replace";
$response_array['Donne'] = '<input type="hidden" name="id_Competition" id="IdCompetition" value="'.$competition->getId_Competition().'">

                            <label>Adresse de la compétition</label> <input type="text" placeholder="" name="adresse" id="IdAdresse" value="'.$competition->getAdresse().'" /><br/>

                            <label>Date de la compétition</label> <input type="number" placeholder="jour" name="jour" id="IdJour" min="1" max="31" value="'.$competition->getDateCompetition()->format('d').'" />
                            <input type="number" placeholder="mois" name="mois" id="IdMois" min="1" max="12" value="'.$competition->getDateCompetition()->format('m').'" />
                            <input type="number" placeholder="année" name="annee" id="IdAnnee" min="1950" max="'.date('Y').'" value="'.$competition->getDateCompetition()->format('Y').'" /><br/>
                            <label>Nom du club organisateur</label> <select name="Club" id="IdClub" readonly>
                                                                    '.
                                                                    $infoClub
                                                                    .'
                                                                    </select></br>
                            <label>Type de competition</label> <select name="TypeCompetition" id="IdType" readonly>
                                                                    '.
                                                                    $infoType
                                                                    .'
                                                                    </select></br>
                            <input type="input" name="Modifier" id="btnSaveCompetition" module="SaveCompetition;PageCompetition" regionSucess="#competition" regionError="#competition" donne="Competition;Adresse;Jour;Mois;Annee;Club" value="Modifier"/>

                            <table name="InfoEpreuve">
                            '.
                              $infoCourse;
                            .'
                            </table>';
$response_array['Stop'] = "false";
$response_array['Region'] = $_POST['regionSucess'];

header('Content-type: application/json');
echo json_encode($response_array);


 ?>
