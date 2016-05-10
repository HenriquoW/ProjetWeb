<?php
  $mail = $data['Mail'];
  $pass = sha1(htmlspecialchars($data['Password']));

  $info["Mail"] = $mail;
  $utilisateur = loadUtilisateur($info);

  if($data['Save']){
    setcookie("Mail",$data["Mail"], time() + 3600 , "/");
  }else{
    setcookie("Mail","", time() - 3600 , "/");
  }

  if(!isset($utilisateur)){
    $_SESSION['Retour'] = "ErrorMail";

  }else if($pass!=$utilisateur->getPassword()){
    $_SESSION['Retour'] = "ErrorPass";

  }else{
    $_SESSION['Retour'] = "OK";

    if($id = isCompetiteur($utilisateur->getId_Utilisateur())){
      $inf["Id"] = $id;
      $utilisateur = loadCompetiteur($inf);
    }else if($id = isAdherent($utilisateur->getId_Utilisateur())){
      $inf["Id"] = $id;
      $utilisateur = loadAdherent($inf);
    }
    
    $_SESSION['Utilisateur'] = $utilisateur;
  }

 ?>
