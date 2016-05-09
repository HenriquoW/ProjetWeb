<?php
$_SERVER["RACINE"] = $_SERVER["DOCUMENT_ROOT"]."/ProjetWeb/Web MVC";

require_once "../Core/XML/class_xml.php";
require_once "../Core/BDD/class_bdd.php";

if(isset($_COOKIE["Connect"])){
  session_name('SessionUtilisateur');
  session_start();
  session_regenerate_id();

}else{
  session_name('SessionVisiteur');
  session_start();
}

$data = json_decode($_POST['donne'],true);
$nomModule = $_POST['module'];
$xml = XML::getInstance();

$actions = $xml->getListeActions($nomModule);
$droit = $xml->getDroit($nomModule);

if($droit=="Visiteur"){
  foreach ($actions as $value) {
    include_once $value;
  }
}else{
  $utilisateur = $_SESSION['UtilisateurCourant'];

  $i = 0;
  $acces = false;
  $DroitUti = $utilisateur->getDroit();
  while(!$acces && $i!=count($DroitUti)){
    if($DroitUti[$i]["Nom"] == $droit)
      $acces = true;
    $i++;
  }

  if($acces){
    foreach ($actions as $value) {
      include_once $value;
    }
  }else{
    echo "error";
  }

}

?>
