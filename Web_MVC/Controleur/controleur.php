<?php
$_SERVER["RACINE"] = $_SERVER["DOCUMENT_ROOT"]."/ProjetWeb/Web_MVC";

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

if(in_array("Visiteur",$droit)){
  foreach ($actions as $value) {

    include_once $_SERVER["RACINE"].$value;
  }
}else{
  $utilisateur = $_SESSION['UtilisateurCourant'];

  if($utilisateur->asDroit($droit) || $utilisateur->asDroit("Administrateurs")){
    foreach ($actions as $value) {
      include_once $_SERVER["RACINE"].$value;
    }
  }else{
    $response_array = array();
    $response_array['Status'] = "Error";
    $response_array['Type'] = "Alert";
    $response_array['Stop'] = "true";
    $response_array['Donne'] = 'Vous n&apos;avez pas les droits nécessaires pour accéder a cette page.';
    $response_array['Region'] = $_POST['regionError'];
  }

}

?>