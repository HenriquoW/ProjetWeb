<?php

$donnees=array();

if($data['Adresse']==""){
  $_SESSION['Retour'] = "ErrorAdresse";
}else{
  $donnees['Adresse'] = $data['Adresse'];
  if($data["Annee"]=="" || $data["Mois"]=="" || $data["Jour"]==""){
    $_SESSION['Retour'] = "ErrorDate";
  }else{
    $date = $data["Annee"]."-".$data["Mois"]."-".$data["Jour"];
    $donnees["DateCompetition"] = new DateTime($date);

    if($data["Club"]==""){
      $_SESSION['Retour'] = "ErrorClub";
    }else{
      if($data["Club"]=="New"){
        if($data["NomClub"]=="" || $data["NomPresident"]==""){
          $_SESSION['Retour'] = "ErrorNewClub";
        }else{
          $club = new Club(array("Nom"=>$data["NomClub"],"President"=>$data["NomPresident"]));
          $club->save(false);

          $donnees['Club'] = $club;
        }
      }else{
        $donnees['Club'] = loadClub(array("Id"=>$data["Club"]);
      }

      if($data["Type"]==""){
        $_SESSION['Retour'] = "ErrorType";
      }else{
        $donnees["TypeCompetition"] = BDD::getInstance()->getManager("Type_Competition")->getId($data['Type']);

        if($data['Sexe']!=""){
          $donnees["Sexe"] = BDD::getInstance()->getManager("Sexe")->getId($data['Sexe']);
        }

        $_SESSION['Retour'] = "Ok";
        $competition = new competition($donnees);

        $competition->save(false);
      }
    }
  }
}

unset($donnees);





?>
