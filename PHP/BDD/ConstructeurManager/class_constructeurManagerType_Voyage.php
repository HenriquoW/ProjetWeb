<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerType_Voyage.php";

class ConstructeurManagerType_Voyage extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerType_Voyage($Bd);
    }

}

?>
