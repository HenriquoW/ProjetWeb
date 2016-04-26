<?php

require_once "class_constructeurManager.php";
require_once $_SERVER["RACINE"]."/Core/BDD/Manager/class_managerCompetition.php";

class ConstructeurManagerCompetition extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerCompetition($Bd);
    }

}

?>
