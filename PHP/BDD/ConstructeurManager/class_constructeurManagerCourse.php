<?php

require_once "class_constructeurManager.php";
require_once "../Manager/class_managerCourse.php";

class ConstructeurManagerCourse extends ConstructeurManager{

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function Cree($Bd){
        return new ManagerCourse($Bd);
    }

}

?>
