<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerDroit_Acces.php";

class ConstructeurManagerDroit_Acces extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerDroit_Acces($Bd);
    }

}

?>
