<?php

$UtilisateurEnCours;
$error = false;

if($id = isCompetiteur($_POST['Utilisateur'])){
  $inf["Id"] = $id;
  $UtilisateurEnCours = loadCompetiteur($inf);
}else if($id = isAdherent($_POST['Utilisateur'])){
  $inf["Id"] = $id;
  $UtilisateurEnCours = loadAdherent($inf);
}else{
  $inf["Id"] = $_POST['Utilisateur'];
  $UtilisateurEnCours = loadUtilisateur($înf);
}

$ClasseUtilisateur = get_class($UtilisateurEnCours);

if($ClasseUtilisateur=='Adherent' || $ClasseUtilisateur=='Competiteur'){
  $UtilisateurEnCours->setNumeroLicence($_POST['NumLicence']);

}else if(isset($_POST['NumLicence'])){
  $donneesAd['NumeroLicence'] = $_POST['NumLicence'];
  $UtilisateurEnCours = new Adherent(null,$UtilisateurEnCours,$donneesAd);
}

if($ClasseUtilisateur=='Competiteur'){
  $UtilisateurEnCours->setPhoto($_POST['Photo']);
  $UtilisateurEnCours->setSpecialite($_POST['Specialite']);

}else if($ClasseUtilisateur='Adherent'){
  if(isset($_POST['Photo']) && isset($_POST['Specialite'])){
    $donneesComp['Photo'] = $_POST['Photo'];
    $donneesComp['Specialite'] = $_POST['Specialite'];

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

$UtilisateurEnCours->setNom($_POST['Nom']);

$UtilisateurEnCours->setPrenom($_POST['Prenom']);

$UtilisateurEnCours->setSexe($_POST['Sexe']);

$UtilisateurEnCours->setTelephone($_POST['Telephone']);

$UtilisateurEnCours->setAdresse($_POST['Adresse']);

$date = $data["Annee"]."-".$data["Mois"]."-".$data["Jour"];

$UtilisateurEnCours->setDateNaissance(new DateTime($date));

if($_POST['Mail']!=$UtilisateurEnCours->getMail()){
  $info["Mail"] = $_POST['Mail'];
  $utilisateur = loadUtilisateur($info);

  if(isset($utilisateur)){
    $_SESSION['Retour'] = "ErrorExist";
    $error = true;
  }else{
    $UtilisateurEnCours->setMail($_POST['Mail']);
  }
}

if(isset($_POST["Password1"])){
  if(isset($_POST["Password2"]){
    if($_POST["Password1"]!=$_POST["Password2"]){
      $_SESSION['Retour'] = "ErrorPass";
      $error = true;
    }else{
      $UtilisateurEnCours->setPassword(sha1(htmlspecialchars($_POST['Password1'])));
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
