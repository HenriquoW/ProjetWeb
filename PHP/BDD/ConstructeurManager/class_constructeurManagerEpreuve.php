<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerEpreuve.php";

class ConstructeurManagerEpreuve extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerEpreuve($Bd);
    }

}

?>
