<?php

$error = false;

if($data['Course']!=""){
  $course = loadCourse(arra("Id"=>$data['Course']));

  if($course->getIsEquipe()){
    if(isset($data['Enfant'])){//enfant

      $donnees['TypeSpecialite'] = $course->getTypeSpecialite();

      if($donnees['TypeSpecialite']['Nom']=="K2" || $donnees['TypeSpecialite']['Nom']=="C2"){//2place
        if($data['Participant1']!=""){
          $enfant = loadCompetiteur(array("Id"=>$data['Enfant']));

          $participant1 = loadCompetiteur(array("Id"=>$data['Participant1']));

          $donnees['Nom'] = $participant1->getNom().'/'.$enfant->getNom();

          $equipe = loadEquipe(array('Nom' => $donnees['Nom']));

          if($equipe!=null){//l'equipe existe
            BDD::getInstance()->getManager("Equipe")->addEquipeCourse($course->getId_Course(),$equipe->getId_Equipe(),false);

          }else{// on cree l'equipe
            $equipe = new Equipe($donnees);

            $equipe->save(false);

            BDD::getInstance()->getManager("Competiteur")->addCompetiteurEquipe($enfant->getId_Competiteur(),$equipe->getId_Equipe());
            BDD::getInstance()->getManager("Competiteur")->addCompetiteurEquipe($participant1->getId_Competiteur(),$equipe->getId_Equipe());

            BDD::getInstance()->getManager("Equipe")->addEquipeCourse($course->getId_Course(),$equipe->getId_Equipe(),false);

            $_SESSION['Retour'] = "Ok";
          }
        }else{
          $error=true;
        }
      }else{//4place
        if($data['Participant1']!="" && $data['Participant2']!="" && $data['Participant3']!=""){
          $enfant = loadCompetiteur(array("Id"=>$data['Enfant']));

          $participant1 = loadCompetiteur(array("Id"=>$data['Participant1']));

          $participant2 = loadCompetiteur(array("Id"=>$data['Participant2']));

          $participant3 = loadCompetiteur(array("Id"=>$data['Participant3']));

          $donnees['Nom'] = $participant1->getNom().'/'.$participant2->getNom().'/'.$participant3->getNom().'/'.$enfant->getNom();

          $equipe = loadEquipe(array('Nom' => $donnees['Nom']));

          if($equipe!=null){{//l'equipe existe
            BDD::getInstance()->getManager("Equipe")->addEquipeCourse($course->getId_Course(),$equipe->getId_Equipe(),false);

          }else{// on cree l'equipe
            $equipe = new Equipe($donnees);

            $equipe->save(false);
            BDD::getInstance()->getManager("Competiteur")->addCompetiteurEquipe($enfant->getId_Competiteur(),$equipe->getId_Equipe());
            BDD::getInstance()->getManager("Competiteur")->addCompetiteurEquipe($participant1->getId_Competiteur(),$equipe->getId_Equipe());
            BDD::getInstance()->getManager("Competiteur")->addCompetiteurEquipe($participant2->getId_Competiteur(),$equipe->getId_Equipe());
            BDD::getInstance()->getManager("Competiteur")->addCompetiteurEquipe($participant3->getId_Competiteur(),$equipe->getId_Equipe());

            BDD::getInstance()->getManager("Equipe")->addEquipeCourse($course->getId_Course(),$equipe->getId_Equipe(),false);

            $_SESSION['Retour'] = "Ok";
          }
        }else{
          $error=true;
        }
      }

    }else{//utilisateurCourant
      if($data['Equipe']!=""){
        if($data['Equipe']=="New"){//nouvelle equipe
          $donnees['TypeSpecialite'] = $course->getTypeSpecialite();

          if($donnees['TypeSpecialite']['Nom']=="K2" || $donnees['TypeSpecialite']['Nom']=="C2"){ //2place
              if($data['Participant1']!=""){
                $participant1 = loadCompetiteur(array("Id"=>$data['Participant1']));

                $donnees['Nom'] = $participant1->getNom().'/'.$_SESSION['UtilisateurCourant']->getNom();

                $equipe = new Equipe($donnees);

                $equipe->save(false);

                BDD::getInstance()->getManager("Competiteur")->addCompetiteurEquipe($_SESSION['UtilisateurCourant']->getId_Competiteur(),$equipe->getId_Equipe());
                BDD::getInstance()->getManager("Competiteur")->addCompetiteurEquipe($participant1->getId_Competiteur(),$equipe->getId_Equipe());

                BDD::getInstance()->getManager("Equipe")->addEquipeCourse($course->getId_Course(),$equipe->getId_Equipe(),false);

                $_SESSION['Retour'] = "Ok";
              }else{
                $error = true;
              }
          }else{//4place
            if($data['Participant1']!="" && $data['Participant2']!="" && $data['Participant3']!=""){
              $participant1 = loadCompetiteur(array("Id"=>$data['Participant1']));

              $participant2 = loadCompetiteur(array("Id"=>$data['Participant2']));

              $participant3 = loadCompetiteur(array("Id"=>$data['Participant3']));

              $donnees['Nom'] = $participant1->getNom().'/'.$participant2->getNom().'/'.$participant3->getNom().'/'.$_SESSION['UtilisateurCourant']->getNom();

              $equipe = new Equipe($donnees);

              $equipe->save(false);

              BDD::getInstance()->getManager("Competiteur")->addCompetiteurEquipe($_SESSION['UtilisateurCourant']->getId_Competiteur(),$equipe->getId_Equipe());
              BDD::getInstance()->getManager("Competiteur")->addCompetiteurEquipe($participant1->getId_Competiteur(),$equipe->getId_Equipe());
              BDD::getInstance()->getManager("Competiteur")->addCompetiteurEquipe($participant2->getId_Competiteur(),$equipe->getId_Equipe());
              BDD::getInstance()->getManager("Competiteur")->addCompetiteurEquipe($participant3->getId_Competiteur(),$equipe->getId_Equipe());

              BDD::getInstance()->getManager("Equipe")->addEquipeCourse($course->getId_Course(),$equipe->getId_Equipe(),false);

              $_SESSION['Retour'] = "Ok";

            }else{
              $error = true;
            }
          }
        }else{//equipe existante
          $equipe = loadEquipe(array("Id"=>$data['Equipe']));

          BDD::getInstance()->getManager("Equipe")->addEquipeCourse($course->getId_Course(),$equipe->getId_Equipe(),false);

          $_SESSION['Retour'] = "Ok";
        }
      }else{
        $error= true;
      }
    }
  }else{//course solo
    if(isset($data['Enfant'])){//enfant
      BDD::getInstance()->getManager("Competiteur")->addCompetiteurCourse($data['Enfant'],$course->getId_Course());

      $_SESSION['Retour'] = "Ok";

    }else{//utilisateurCourant
      BDD::getInstance()->getManager("Competiteur")->addCompetiteurCourse($_SESSION['UtilisateurCourant']->getId_Competiteur(),$course->getId_Course());
      $_SESSION['Retour'] = "Ok";
    }
  }


}

if($error){
  $_SESSION['Retour'] = "ErrorInfo";
}
 ?>
