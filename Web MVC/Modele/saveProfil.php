<?php

$UtilisateurEnCours;
$error = false;

if($id = isCompetiteur($data['Utilisateur'])){
  $inf["Id"] = $id;
  $UtilisateurEnCours = loadCompetiteur($inf);
}else if($id = isAdherent($data['Utilisateur'])){
  $inf["Id"] = $id;
  $UtilisateurEnCours = loadAdherent($inf);
}else{
  $inf["Id"] = $data['Utilisateur'];
  $UtilisateurEnCours = loadUtilisateur($inf);
}

$ClasseUtilisateur = get_class($UtilisateurEnCours);

if($ClasseUtilisateur=='Adherent' || $ClasseUtilisateur=='Competiteur'){
  $UtilisateurEnCours->setNumeroLicence($data['NumLicence']);

}else if(isset($data['NumLicence']) && $data['NumLicence']!=""){
  $donneesAd['NumeroLicence'] = $data['NumLicence'];
  $UtilisateurEnCours = new Adherent(null,$UtilisateurEnCours,$donneesAd);
}

if($ClasseUtilisateur=='Competiteur'){
  $UtilisateurEnCours->setPhoto($data['Photo']);
  $UtilisateurEnCours->setSpecialite($data['Specialite']);

}else if($ClasseUtilisateur='Adherent'){
  if(isset($data['Photo']) && isset($data['Specialite'])){
    $donneesComp['Photo'] = $data['Photo'];
    $donneesComp['Specialite'] = $data['Specialite'];

    $AgeUser = $UtilisateurEnCours->getDateNaissance()->diff(new DateTime())->format('Y');
    $categorie;

    if ($AgeUser <= 9 || $AgeUser = 10){
      $categorie = BDD::getInstance()->getManager("Categorie")->getNom("Poussin");
    }
    else if ($AgeUser = 11 || $AgeUser= 12){
      $categorie = BDD::getInstance()->getManager("Categorie")->getNom("Benjamin");
    }
    else if ($AgeUser = 13 || $AgeUser = 14){
      $categorie = BDD::getInstance()->getManager("Categorie")->getNom("Minime");
    }
    else if ($AgeUser = 15 || $AgeUser = 16){
      $categorie = BDD::getInstance()->getManager("Categorie")->getNom("Cadet");
    }
    else if ($AgeUser = 17 || $AgeUser = 18){
      $categorie = BDD::getInstance()->getManager("Categorie")->getNom("Junior");
    }
    else if($AgeUser >= 19 && $AgeUser <= 34){
      $categorie = BDD::getInstance()->getManager("Categorie")->getNom("Senior");
    }
    else if($AgeUser >= 35){
      $categorie = BDD::getInstance()->getManager("Categorie")->getNom("Veteran");
    }

    $donneesComp['Categorie'] = $categorie;
    
    $UtilisateurEnCours = new Competiteur($UtilisateurEnCours,$donneesComp);
  }else{
      $error = true;
      $_SESSION['Retour'] = "ErrorComp";
  }
}else{
  $error = true;
  $_SESSION['Retour'] = "ErrorAdherent";
}

$UtilisateurEnCours->setNom($data['Nom']);

$UtilisateurEnCours->setPrenom($data['Prenom']);

$UtilisateurEnCours->setSexe($data['Sexe']);

$UtilisateurEnCours->setTelephone($data['Telephone']);

$UtilisateurEnCours->setAdresse($data['Adresse']);

$date = $data["Annee"]."-".$data["Mois"]."-".$data["Jour"];

$UtilisateurEnCours->setDateNaissance(new DateTime($date));

if($data['Mail']!=$UtilisateurEnCours->getMail()){
  $info["Mail"] = $data['Mail'];
  $utilisateur = loadUtilisateur($info);

  if(isset($utilisateur)){
    $_SESSION['Retour'] = "ErrorExist";
    $error = true;
  }else{
    $UtilisateurEnCours->setMail($data['Mail']);
  }
}

if(isset($data["Password1"])){
  if(isset($data["Password2"])){
    if($data["Password1"]!=$data["Password2"]){
      $_SESSION['Retour'] = "ErrorPass";
      $error = true;
    }else{
      $UtilisateurEnCours->setPassword(sha1(htmlspecialchars($data['Password1'])));
    }
  }else{
      $_SESSION['Retour'] = "ErrorPass";
      $error = true;
  }
}

if(!$error){
  $UtilisateurEnCours->save(true);
}

?>
