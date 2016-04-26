<?php
$_SERVER["RACINE"] = $_SERVER["DOCUMENT_ROOT"]."Web MVC";

require_once "../Core/XML/class_xml.php";
require_once "../Core/BDD/class_bdd.php";

session_name('SessionVisiteur');
session_start();

$nomModule = $_POST['module'];
$xml = XML::getInstance();

$actions = $xml->getListeActions($nomModule);
$droit = $xml->getDroit($nomModule);

if($droit=="Visiteur"){
  foreach ($actions as $value) {
    include_once $value;
  }
}else{
  session_write_close();

  session_name('SessionUtilisateur');
  session_start();
  session_regenerate_id();

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
