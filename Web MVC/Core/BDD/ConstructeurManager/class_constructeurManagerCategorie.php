<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerCategorie.php";

class ConstructeurManagerCategorie extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerCategorie($Bd);
    }

}

?>
