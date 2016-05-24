<?php

if($_SESSION['UtilisateurCourant']->asDroit("Entraineur")){

  BDD::getInstance()->getManager('Competiteur')->valideCourse($data['Course'],$data['CompetiteurValider'],true);

}

?>
