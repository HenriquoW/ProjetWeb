<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerMessage.php";

class ConstructeurManagerMessage extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerMessage($Bd);
    }

}

?>
