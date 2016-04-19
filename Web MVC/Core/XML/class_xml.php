<?php

/**
*
*/
class Xml{
  private static $_instance;
  private $_data;

  private function __construct(){
    try {
      $this->_data = new SimpleXMLElement("../Xml/navigation.xml",0,true);
    }
    catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
  }

  private function __clone(){
  }

  /**
  * Fonction renvoyant l'instance de cette classe
  */
  public static function getInstance(){
    if (!(self::$_instance instanceof self)){
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function getListeActions($nomModule){
    $tableauAction;

    foreach ($this->_data->xpath("/navigation/module/nom[text()='".$nomModule."']/../action/text()") as $action) {
        $tableauAction[] = $action;
    }

    return $tableauAction;
  }

  public function getDroit($nomModule){
    return $this->_data->xpath("/navigation/module/nom[text()='".$nomModule."']/../@droit")[0];
  }
}



?>
