<?php
if($data['Voyage']!=""){
  $voyage = loadVoyage(array('Id' => $data['Voyage']));

  $voyage->setHebergement($data['Hebergement']);

  $voyage->setTransport($data['Transport']);

  $voyage->save(true);

}

 ?>
