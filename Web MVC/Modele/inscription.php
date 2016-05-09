<?php

$info["Mail"] = $data["Mail"];
$utilisateur = loadUtilisateur($info);

//test si utilisateur existe
if(isset($utilisateur)){
  $_SESSION['Retour'] = "ErrorExist";

}else if($data["Pass1"]!=$data["Pass2"]){
  $_SESSION['Retour'] = "ErrorPass";

}else if(!$data["Terme"]){
  $_SESSION['Retour'] = "ErrorTerme";

}else{
  $tab = array();
  $tab[] = BDD::getInstance()->getManager("Droit_Acces")->getNom("Visiteur");
  $tab[] = BDD::getInstance()->getManager("Droit_Acces")->getNom("Inscrit");

  $donnée = array();
  $donnée["Droit"] = $tab;
  $donnée["Password"] = sha1(htmlspecialchars($data["Pass1"]));
  $donnée["Mail"] = $data["Mail"];
  $donnée["Nom"] = $data["Nom"];
  $donnée["Prenom"] = $data["Prenom"];
  $donnée["DateNaissance"] = new DateTime($data["Annee"]+"-"+$data["Mois"]+"-"+$data["Jour"]);
  $donnée["Adresse"] = $data["Adresse"];
  $donnée["Telephone"] = $data["Telephone"];


  if($data["Sexe"]=="Femme"){
      $donnée["Sexe"] = BDD::getInstance()->getManager("Sexe")->getType("F");
  }else{
      $donnée["Sexe"] = BDD::getInstance()->getManager("Sexe")->getType("M");
  }

  $utilisateur = new Utilisateur($donnée);

  $utilisateur->save(false);

  $_SESSION['Retour'] = "Ok";
}




?>
