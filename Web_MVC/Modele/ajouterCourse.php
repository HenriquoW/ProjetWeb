<?php

$donnees = array();

$donnees['Distance'] = $data['Distance'];
$donnees['Id_Competition'] = $data['Competition'];
$donnees['Categorie'] = BDD::getInstance()->getManager("Categorie")->getId($data['Categorie']);
$donnees['TypeSpecialite'] = BDD::getInstance()->getManager("Type_Specialite")->getId($data['Specialite']);

if($donnees['TypeSpecialite']['Nom']=='C1' || $donnees['TypeSpecialite']['Nom']=='K1'){
  $donnees['IsEquipe'] = false;
}else{
  $donnees['IsEquipe'] = true;
}

$donnees['Participant'] = array();

$course = new Course($donnees);

$course->save(false);

unset($donnees);

 ?>
