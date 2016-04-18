<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerPalmares.php";

class ConstructeurManagerPalmares extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerPalmares($Bd);
    }

}

?>
