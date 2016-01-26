<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerAdherent.php";

class ConstructeurManagerAdherent extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerAdherent($Bd);
    }

}

?>
