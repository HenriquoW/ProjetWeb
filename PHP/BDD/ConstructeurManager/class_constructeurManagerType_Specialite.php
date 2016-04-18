<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerType_Specialite.php";

class ConstructeurManagerType_Specialite extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerType_Specialite($Bd);
    }

}

?>
