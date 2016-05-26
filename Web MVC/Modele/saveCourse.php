<?php

$course = loadCourse(array("Id"=>$data['Course']));

$course->setDistance($data['Distance']);

$course->setCategorie(BDD::getInstance()->getManager("Categorie")->getId($data['Categorie']));
$course->setTypeSpecialite(BDD::getInstance()->getManager("Type_Specialite")->getId($data['Specialite']));

if($course->getTypeSpecialite()['Nom']=='C1' || $course->getTypeSpecialite()['Nom']=='K1'){
  $course->setIsEquipe(false);
}else{
  $course->setIsEquipe(true);
}

$course->save(true);

 ?>
