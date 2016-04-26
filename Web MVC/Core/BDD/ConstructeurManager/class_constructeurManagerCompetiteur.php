<?php

require_once "class_constructeurManager.php";
require_once $_SERVER["RACINE"]."/Core/BDD/Manager/class_managerCompetiteur.php";

class ConstructeurManagerCompetiteur extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerCompetiteur($Bd);
    }

}

?>
