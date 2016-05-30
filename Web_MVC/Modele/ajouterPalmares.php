<?php

if($data['CoursePalmares']!="" && $data['NewClassement']!=""){
  $course = loadCourse(array("Id"=>$data['CoursePalmares']));

  $palmares = $_SESSION['UtilisateurCourant']->getPalmares();

  $donnee['Id_Course'] = $course->getId_Course();
  $donnee['Id_Participant'] = $_SESSION['UtilisateurCourant']->getId_Competiteur();
  $donnee['Classement'] = $data['NewClassement'];
  $donnee['IsEquipe'] = $course->getIsEquipe();

  $newPalmares = new Palmares($donnee);

  $newPalmares->save(false);

  $palmares[] = $newPalmares;

  $_SESSION['UtilisateurCourant']->setPalmares($palmares);

  $_SESSION['UtilisateurCourant']->save(true);

  $_SESSION['Retour'] = "Ok";

}else{
  $_SESSION['Retour'] = "ErrorInfo";
}


?>
