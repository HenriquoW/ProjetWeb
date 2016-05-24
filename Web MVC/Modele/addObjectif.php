<?php

$Utilisateur;
if($data['Utilisateur']!=$_SESSION['UtilisateurCourant']->getId_Utilisateur()){

  if($id = isCompetiteur($data['Utilisateur'])){
    $inf["Id"] = $id;
    $Utilisateur = loadCompetiteur($inf);
  }else if($id = isAdherent($data['Utilisateur'])){
    $inf["Id"] = $id;
    $Utilisateur = loadAdherent($inf);
  }else{
    $inf["Id"] = $data['Utilisateur'];
    $Utilisateur = loadUtilisateur($înf);
  }
}else{
  $Utilisateur = $_SESSION['UtilisateurCourant'];
}

if(get_class($Utilisateur)=="Competiteur"){
  $objectif = $Utilisateur->getObjectif();

  $objectif[] = $data['NewObjectif'];

  $Utilisateur->setObjectif($objectif);

  $Utilisateur->save(true);

  $infoObjectif = '';
  foreach ($UtilisateurEnCours->getObjectif() as $objectif) {
    $compet = loadCompetition(array("Id"=>$objectif));

    $infoObjectif = $infoObjectif . ''.$compet->getTypeCompetition()['Nom'].'-'.$compet->getAdresse().'/n';
  }

  $retour['InfoObjectif'] = $infoObjectif;
  $_SESSION['Retour'] = $retour;
}




?>
