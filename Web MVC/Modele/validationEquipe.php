<?php

if($_SESSION['UtilisateurCourant']->asDroit("Entraineur")){

  BDD::getInstance()->getManager('Equipe')->valideCourse($data['Course'],$data['EquipeValider'],true);

}

?>
