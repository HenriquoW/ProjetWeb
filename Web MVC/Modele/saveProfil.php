<?php

$UtilisateurEnCours;

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

if($ClasseUtilisateur='Competiteur'){
  $UtilisateurEnCours->setPhoto($_POST['Photo']);
  $UtilisateurEnCours->setSpecialite($_POST['Specialite']);
}

if($ClasseUtilisateur='Adherent' || $ClasseUtilisateur='Competiteur'){
  $UtilisateurEnCours->setNumeroLicence($_POST['NumLicence']);
}

$UtilisateurEnCours->setNom($_POST['Nom']);

$UtilisateurEnCours->setPrenom($_POST['Prenom']);

$UtilisateurEnCours->setSexe($_POST['Sexe']);

$UtilisateurEnCours->setTelephone($_POST['Telephone']);

$UtilisateurEnCours->setAdresse($_POST['Adresse']);

$date = $data["Annee"]."-".$data["Mois"]."-".$data["Jour"];

$UtilisateurEnCours->setDateNaissance(new DateTime($date));

$error = false;

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
