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
	                  <input type="hidden"  id="IdCoursePalmares_'.$index.'" value="'.$palmares->getId_Course().'"/>
                    <input type="hidden"  id="IdParticipantPalmares_'.$index.'" value="'.$palmares->getId_Participant().'"/>
                    <input type="hidden"  id="IdEquipePalmares_'.$index.'" value="'.$palmares->getIsEquipe().'"/>
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
                    <input type="submit" name="ModifierPalmares" id="btnSavePalmares_'.$index.'" module="SavePalmares;PagePalmares" regionSucess="#palmares;#palmares" regionError="#palmares;#palmares" donne="ParticipantPalmares'.$index.';CoursePalmares'.$index.';Classement_'.$index.';EquipePalmares_'.$index.'" value="Ajouter" onclick="Action(btnSavePalmares_'.$index.')"/>
                  </td>
                </tr>
                ';
                $index++;
}



$infoCompetition = '';

foreach($_SESSION['UtilisateurCourant']->getCourseParticipe() as $idcourse){
  $course = loadCourse(array("Id"=>$idcourse['Id_Course']));
  $competition = loadCompetition(array("Id"=>$course->getId_Competition()));
  $infoCompetition = $infoCompetition.'<option value="'.$course->getId_Course().'" >'.$competition->getTypeCompetition()['Nom'].'-'.$competition->getAdresse().'/'.$course->getDistance().'-'.$course->getTypeSpecialite()['Nom'].'</option>';
}

$res = $res .'<tr>
                <td>
                  <select name="competition" id="IdCoursePalmares">
                  '.
                    $infoCompetition
                  .'
                  </select>
                </td>
                <td>
                  <input type="text" placeholder="" name="date" id="IdNewClassement" value="" readonly/>
                </td>
                <td>
                  <input type="submit" name="AjouterPalmares" id="btnAjouterPalmares" module="AjouterPalmares;PagePalmares" regionSucess="#palmares;#palmares" regionError="#palmares;#palmares" donne="CoursePalmares;NewClassement" value="Ajouter"/>
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
