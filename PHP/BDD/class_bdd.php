<?php

require_once "class_fabriqueManager.php";

/**
 * Singleton qui gère le lien entre Dynomonde et MySQL
 */ 
class BDD{

    private static $_instance;

    private $_Bdd;
    private $_Fabrique;
    private $_Manager;

    private HOST = "localhost";
    private LOGIN = "Fieldrain";
    private PASSWD = "maxou21@";
    private DBASENAME = "asptt_dijon";

    /**
	 *  Constructeur privé qui initialise les attributs
	 */
    private function __construct(){
        try {
            $this->_Bdd = new PDO("mysql:host=".HOST.";dbname=".DBASENAME, LOGIN,PASSWD);
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
    public function Bdd(){
        return $this->_Bdd;
    }

    public function Types(){
        return $this->_Fabrique->Types();
    }
    
    public function GetManager($Type){
        $manager = $this->_Manager[$Type];

        if(is_null($manager)){
            $manager = $this->_Fabrique->Construit($Type,$this->_Bdd);
            $this->_Manager[$Type] = $manager;
        }

        return $manager;
    }

}


?>
