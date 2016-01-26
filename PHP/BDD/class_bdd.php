<?php
/**
 * Singleton qui gère le lien entre Dynomonde et MySQL
 */ 
class BDD{

	private static $_instance;
	
	private $_bdd;
	
    private HOST = "localhost";
    private LOGIN = "Fieldrain";
    private PASSWD = "maxou21@";
    private DBASENAME = "asptt_dijon";
    
	/**
	 *  Constructeur privé qui initialise les attributs
	 */
	private function __construct(){
		try {
			$this->_bdd = new PDO("mysql:host=".HOST.";dbname=".DBASENAME, LOGIN,PASSWD);
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
		return $this->_bdd;	
	}
    
    
    
}


?>