<?php

abstract class Manager{
    
    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */
    
    private $_db; // connexion à la BDD
		
    /*
    *----------------------------------------------------------------
    *CONSTRUCTEUR
    *----------------------------------------------------------------
    */
    
	//Constructeur qui fixe l'attribut
    public function __construct($db)
    {
        $this->setDb($db);
	}
    
    /*
    *----------------------------------------------------------------
    *GETTER
    *----------------------------------------------------------------
    */
    
    //Fonction qui renvoie l'attribut _db
    public function getDb()
    {
        return $this->_db;
    }
    
    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */
    
    //Fonction qui fixe l'attribut _db
    public function setDb(PDO $db)
	{
		$this->_db = $db;
	}
    
    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */
    
    //Fonction abstraite qui ajoutera dans la BDD
    abstract public function add($objet);
    
    //Fonction abstraite qui supprimera dans la BDD
    abstract public function remove($objet);
    
    //Fonction abstraite qui mettra a jour dans la BDD
    abstract public function update($objet);
    
    //Fonction abstraite qui renverra un objet à partir de la BDD
    abstract public function get($objet);
    
    //Fonction abstraite qui retournera plusieur objet présentes dans la BDD
    abstract public function getList();
}



?>