<?php

require_once "class_constructeurManager.php";
require_once $_SERVER["RACINE"]."/Core/BDD/Manager/class_managerClub_Organisateur.php";

class ConstructeurManagerClub_Organisateur extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerClub_Organisateur($Bd);
    }

}

?>
