<?php

$erreur = false;

$competition = loadCompetition(array("Id"=>$data['Competition']));

if($data["Adresse"]!=""){
    $competition->setAdresse($data["Adresse"]);
}else{
    $_SESSION['Retour'] = "ErrorAdresse";
    $erreur = true;
  }
if($data["Annee"]!="" && $data["Mois"]!="" && $data["Jour"]!=""){
  $date = $data["Annee"]."-".$data["Mois"]."-".$data["Jour"];
  $competition->setDateCompetition(new DateTime($date));
}else{
  $_SESSION['Retour'] = "ErrorDate";
  $erreur = true;
}

if($data['Club']!=""){
  if($data["Club"]=="New"){
    if($data["NomClub"]=="" || $data["NomPresident"]==""){
      $_SESSION['Retour'] = "ErrorNewClub";
      $erreur = true;
    }else{
      $club = new Club(array("Nom"=>$data["NomClub"],"President"=>$data["NomPresident"]));
      $club->save(false);

      $competition->setClub($club);
    }
  }else{
    $competition->setClub(loadClub(array("Id"=>$data["Club"]));
  }
}else{
  $_SESSION['Retour'] = "ErrorClub";
  $erreur = true;
}

if($data['Type']!=""){
  $competition->setTypeCompetition(BDD::getInstance()->getManager('Type_Competition')->getId($data['Type']));
}else{
  $_SESSION['Retour'] = "ErrorType";
  $erreur = true;
}

if($data['Sexe']!=""){
  if($data['Sexe']=="Auncune"){
    $competition->setSexe(null);
  }else{
    $competition->setSexe(BDD::getInstance()->getManager('Type_Competition')->getId($data['Type']));
  }
}

if(!$erreur){
  $competition->save(true);
  $_SESSION['Retour'] = "Ok";
}

?>
