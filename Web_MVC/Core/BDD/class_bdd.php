<?php

require_once "class_fabriqueManager.php";

/**
 * Singleton qui gère le lien entre Dynomonde et MySQL
 */
class BDD{

    private static $_instance;

    private $_Bdd;
    private $_Fabrique;
    private $_Manager = array();

    private static $_HOST = "localhost";
    private static $_LOGIN = "web";
    private static $_PASSWD = "maxou21@";
    private static $_DBASENAME = "asptt_dijon";

    /**
	 *  Constructeur privé qui initialise les attributs
	 */
    private function __construct(){
        try {
            $this->_Bdd = new PDO("mysql:host=".self::$_HOST.";dbname=".self::$_DBASENAME, self::$_LOGIN,self::$_PASSWD);
            $this->_Fabrique = new FabriqueManager();

        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    private function __clone(){}

    /**
	 * Fonction renvoyant l'instance de cette classe
	 */
    public static function getInstance(){
        if (!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
	 *  Fonction qui retourne l'attribut contenant le lien servant à accerder à la BDD
	 */
    public function bdd(){
        return $this->_Bdd;
    }

    /**
	 *  Fonction qui retourne tous les types des managers
	 */
    public function types(){
        return $this->_Fabrique->Types();
    }

    /**
	 *  Fonction qui retourne le manager en fonction du type passer en parametre
	 */
    public function getManager($Type){
        $manager;

        if(array_key_exists($Type,$this->_Manager)){
          $manager = $this->_Manager[$Type];
          
        }else{
          $manager = $this->_Fabrique->Construit($Type,$this->_Bdd);
          $this->_Manager[$Type] = $manager;
        }

        return $manager;
    }

}


?>
