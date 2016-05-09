<?php
  $mail = $data['Mail'];
  $pass = sha1(htmlspecialchars($data['Password']));

  $info["Mail"] = $mail;
  $utilisateur = loadUtilisateur($info);

  if(!isset($utilisateur)){
    $_SESSION['Retour'] = "ErrorMail";

  }else if($pass!=$utilisateur->getPassword()){
    $_SESSION['Retour'] = "ErrorPass";

  }else{
    $_SESSION['Retour'] = "OK";

    $_SESSION['Utilisateur'] = $utilisateur;
  }

 ?>
