<?php

if($data['Voyage']!="" && $data['UtilisateurCharge']!="" && $data['Tache']!=""){
  $voyage = loadVoyage(array("Id"=>$data['Voyage']));

  $newCharge = array();
  foreach($voyage->getCharge() as $charge){
    if($charge['Id_Utilisateur']!=$data['UtilisateurCharge'] && $charge['Tache']['Id']!=$data['Tache'] ){
      $newCharge[] = $charge;
    }
  }

  $voyage->setCharge($newCharge);

  $voyage->save(true);
}


 ?>
