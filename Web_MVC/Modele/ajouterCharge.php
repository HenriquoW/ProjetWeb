<?php

"Competition;Voyage;UtilisateurCharge_'.$index.';Tache'.$index.';Role_'.$index.'"

if($data['Voyage']!="" && $data['UtilisateurCharge']!="" && ($data['Role']!="" || $data['Tache']!="")){
  $voyage = loadVoyage(array("Id"=>$data['Voyage']));

  $newCharge = $voyage->getCharge();

  $charge['Id_Utilisateur'] = $data['UtilisateurCharge'];

  if($charge['Tache']!="")
    $charge['Tache'] = BDD::getInstance()->getManager("Tache")->getId($charge['Tache']);

  if($charge['Role']!="")
    $charge['Role'] = BDD::getInstance()->getManager("Role")->getId($charge['Role']);

  $newCharge[] = $charge;

  $voyage->setCharge($newCharge);

  $voyage->save(true);
}

?>
