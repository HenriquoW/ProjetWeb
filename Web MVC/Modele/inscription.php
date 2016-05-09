<?php

$info["Mail"] = $_POST["Mail"];
$utilisateur = loadUtilisateur($info);

//test si utilisateur existe
if(isset($utilisateur)){
  $_SESSION['Retour'] = "Error";
}else{

  $tab = array();
  $tab[] = BDD::getInstance()->getManager("Droit_Acces")->getNom("Visiteur");
  $tab[] = BDD::getInstance()->getManager("Droit_Acces")->getNom("Inscrit");

  $donnée = array();
  $donnée["Droit"] = $tab;
  $donnée["Password"] = sha1(htmlspecialchars($_POST["Password"]));
  $donnée["Mail"] = $_POST["Mail"];
  $donnée["Sexe"] = BDD::getInstance()->getManager("Sexe")->getType("F");

  $utilisateur = new Utilisateur($donnée);

  $utilisateur->save(false);
  $_SESSION['Retour'] = "Ok";
}




?>
