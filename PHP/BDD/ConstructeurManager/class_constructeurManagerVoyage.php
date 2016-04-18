<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerVoyage.php";

class ConstructeurManagerVoyage extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerVoyage($Bd);
    }

}

?>
