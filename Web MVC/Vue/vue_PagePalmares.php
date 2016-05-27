<?php

$index =0;
$tabPalmares = $_SESSION['UtilisateurCourant']->getPalmares();
$tabCourse = getCourse();
$res = "<h1>Palmares<h1><table>";

foreach($tabPalmares as $palma){
  $course = loadCourse(array("Id"=>$palma['Id_Course']));

  $competition = loadCompetitions(array("Id"=>$course->getId_Competition()));

  $palmares;
  if($course->getIsEquipe()){
    $palmares = loadPalmares(array("Id_Course"=>$course->getId_Course(),"Id_Equipe"=>$palma['Id_Equipe']));
  }else{
    $palmares = loadPalmares(array("Id_Course"=>$course->getId_Course(),"Id_Competiteur"=>$palma['Id_Competiteur']));
  }


  $res = $res .'<tr>
	                <td>
	                  <input type="hidden" name="id_course" id="IdCoursePalmares_'.$index.'" value="'.$palmares->getId_Course().'"/>
                    <input type="hidden" name="id_course" id="IdParticipantPalmares_'.$index.'" value="'.$palmares->getId_Participant().'"/>
	                </td>
	                <td>
	                  <input type="text" placeholder="" name="nom" id="IdNom" value="'.$competition->getTypeCompetition()['Nom'].'-'.$competition->getAdresse().'" readonly/>
	                </td>
	                <td>
	                  <input type="text" placeholder="" name="date" id="IdDate" value="'.$competition->getDateCompetition()->format("Y-m-d").'" readonly/>
	                </td>
                  <td>
	                  <input type="text" placeholder="" name="date" id="IdType" value="'.$course->getTypeSpecialite()['Nom'].'" readonly/>
	                </td>
                  <td>
	                  <input type="text" placeholder="" name="date" id="IdClassement_'.$index.'" value="'.$palmares->getClassement().'" />
	                </td>
                  <td>
                    <input type="submit" name="ModifierPalmares" id="btnSavePalmares" module="SavePalmares;PagePalmares" regionSucess="#palmares;#palmares" regionError="#palmares;#palmares" donne="ParticipantPalmares'.$index.';CoursePalmares'.$index.';Classement_'.$index.'" value="Ajouter"/>
                  </td>
                </tr>
                ';
                $index++;
}



$infoCompetition = '';

foreach($_SESSION['UtilisateurCourant']->getCourseParticipe() as $idcourse){
  $course = loadCourse(array("Id"=>$idcourse['Id_Course']));
  $competition = loadCompetition(array("Id"=>$course->getId_Competition()));
  $infoCompetition = $infoCompetition.'<option value="'.$competition->getId_Competition().'" >'.$competition->getTypeCompetition()['Nom'].'-'.$competition->getAdresse().'</option>';
}

$res = $res .'<tr>
                <td>
                  <select name="competition" id="IdCompetitionPalmares">
                  '.
                    $infoCompetition
                  .'
                  </select>
                </td>
                <td>
                  <input type="text" placeholder="" name="date" id="IdClassement_'.$index.'" value="" readonly/>
                </td>
                <td>
                  <input type="submit" name="AjouterPalmares" id="btnAjouterPalmares" module="AjouterPalmares;PagePalmares" regionSucess="#palmares;#palmares" regionError="#palmares;#palmares" donne="CompetitionPalmares;Classement_'.$index.'" value="Ajouter"/>
                </td>
              </tr>
              ';

$res = $res.'</table>';


$response_array = array();

$response_array['Status'] = "Success";
$response_array['Type'] = "Replace";
$response_array['Donne'] = $res;
$response_array['Stop'] = "false";
$response_array['Region'] = $_POST['regionSucess'];

header('Content-type: application/json');
echo json_encode($response_array);

 ?>
