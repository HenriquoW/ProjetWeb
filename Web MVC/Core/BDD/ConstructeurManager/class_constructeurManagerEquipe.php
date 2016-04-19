<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerEquipe.php";

class ConstructeurManagerEquipe extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerEquipe($Bd);
    }

}

?>
