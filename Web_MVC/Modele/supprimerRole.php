<?php

if($data['Voyage']!="" && $data['UtilisateurCharge']!="" && $data['Role']!=""){
  $voyage = loadVoyage(array("Id"=>$data['Voyage']));

  $newCharge = array();
  foreach($voyage->getCharge() as $charge){
    if($charge['Id_Utilisateur']!=$data['UtilisateurCharge'] && $charge['Role']['Id']!=$data['Role'] ){
      $newCharge[] = $charge;
    }
  }

  $voyage->setCharge($newCharge);

  $voyage->save(true);
}


 ?>
