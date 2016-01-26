<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerUtilisateur.php";

class ConstructeurManagerUtilisateur extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerUtilisateur($Bd);
    }

}

?>
