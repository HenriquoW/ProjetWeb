<?php

$erreur = false;

if($data['Voyage']!="" && $data['TypeTransport']){
  $type = BDD::getInstance()->getManager("Type_Voyage")->getId($data['TypeTransport']);
  $uti = null;
  if($type['Nom']!="Club"){
    if($data['UtilisateurTransport']!=""){
      $uti = $data['UtilisateurTransport'];
    }else{
      $_SESSION['Retour'] = "ErrorInfo";
      $erreur = true;
    }
  }

  if(!$erreur){
    BDD::getInstance()->getManager("Competiteur")->addCompetiteurVoyage($data['Voyage'],$_SESSION['UtilisateurCourant']->getId_Competiteur(),false,$type,$uti);
    $_SESSION['Retour'] = "Ok";
  }
}else{
  $_SESSION['Retour'] = "ErrorInfo";
}



 ?>
