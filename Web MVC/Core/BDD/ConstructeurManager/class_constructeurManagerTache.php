<?php

require_once "class_constructeurManager.php";
require_once $_SERVER["RACINE"]."/Core/BDD/Manager/class_managerTache.php";

class ConstructeurManagerTache extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerTache($Bd);
    }

}

?>
