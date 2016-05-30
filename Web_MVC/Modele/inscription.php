<?php

$info["Mail"] = $data["Mail"];
$utilisateur = loadUtilisateur($info);

//test si utilisateur existe
if(isset($utilisateur)){
  $_SESSION['Retour'] = "ErrorExist";

}else if($data["Pass1"]=="" || $data["Pass1"]!=$data["Pass2"]){
  $_SESSION['Retour'] = "ErrorPass";

}else if(!$data["Terme"]){
  $_SESSION['Retour'] = "ErrorTerme";

}else{
  $tab = array();
  $tab[] = BDD::getInstance()->getManager("Droit_Acces")->getNom("Visiteur");
  $tab[] = BDD::getInstance()->getManager("Droit_Acces")->getNom("Inscrit");

  $donnee = array();
  $donnee["Droit"] = $tab;
  $donnee["Password"] = sha1(htmlspecialchars($data["Pass1"]));
  $donnee["Mail"] = $data["Mail"];
  $donnee["Nom"] = $data["Nom"];
  $donnee["Prenom"] = $data["Prenom"];

  $date = $data["Annee"]."-".$data["Mois"]."-".$data["Jour"];

  $donnee["DateNaissance"] = new DateTime($date);
  $donnee["Adresse"] = $data["Adresse"];
  $donnee["Telephone"] = $data["Telephone"];


  if($data["Sexe"]=="Femme"){
      $donnee["Sexe"] = BDD::getInstance()->getManager("Sexe")->getType("F");
  }else{
      $donnee["Sexe"] = BDD::getInstance()->getManager("Sexe")->getType("M");
  }


  $utilisateur = new Utilisateur($donnee);

  $utilisateur->save(false);

  $_SESSION['Retour'] = "Ok";
}




?>
