<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerType_Competition.php";

class ConstructeurManagerType_Competition extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerType_Competition($Bd);
    }

}

?>
