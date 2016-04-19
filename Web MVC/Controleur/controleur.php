<?php

require_once "../Core/XML/class_xml.php";

$nomModule = $_POST['module'];
$xml = XML::getInstance();

$actions = $xml->getListeActions($nomModule);
$droit = $xml->getDroit($nomModule);

if($droit=="Visiteur"){
  foreach ($actions as $value) {
    include_once $value;
  }
}

?>
