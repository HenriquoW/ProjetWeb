<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerSexe.php";

class ConstructeurManagerSexe extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerSexe($Bd);
    }

}

?>
