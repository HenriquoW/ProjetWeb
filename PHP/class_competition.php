<?php

require_once "class_epreuve.php";

class Competition{

    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */
	private $_Id_Competition;
	private $_Adresse;
    private $_DateCompetition;
	private $_TypeCompetition; //nom du type
	private $_Sexe; //chaine definisant le sexe
    private $_Club; //nom du club organisateur
	private $_Courses; //tableau avec id des courses
	
	/*
    *----------------------------------------------------------------
    *CONSTRUCTEUR
    *----------------------------------------------------------------
    */
    
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    /*
    *----------------------------------------------------------------
    *GETTER
    *----------------------------------------------------------------
    */
    
    public function getId_Competition(){
        return $this->_Id_Competition;
    }

    public function getAdresse(){
        return $this->_Adresse;
    }

    public function getDateCompetition(){
        return $this->_DateCompetition;
    }

    public function getTypeCompetition(){
        return $this->_Type_Competition;
    }

    public function getSexe(){
        return $this->_Sexe;
    }

    public function getClub(){
        return $this->_Club;
    }

    public function getCourses(){
        return $this->_Courses;
    }

    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */
    
    public function setId_Competition($IdCompetition){
        $this->_Id_Competition = $IdCompetition;
    }

    public function setAdresse($Adresse){
        $this->_Adresse = $Adresse;
    }

    public function setDateCompetition($DateCompetition){
        $this->_DateCompetition = $DateCompetition;
    }

    public function setTypeCompetition($TypeCompetition){
        $this->_TypeCompetition = $TypeCompetition;
    }

    public function setSexe($Sexe){
        $this->_Sexe = $Sexe;
    }

    public function setClub($Club){
        $this->_Club = $Club;
    }

    public function setCourses($Courses){
        $this->_Courses = $Courses;
    }

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */
	
    /*
    * Fonction qui initialise tous les attributs à partir de variables données en paramètres sous la forme d'un tableau
    */
    public function hydrate(array $donnees)
    {
        foreach($donnees as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if(method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

    public function save($bupdate){
        if($bupdate){
            BDD::getInstance()->getManager("Competition")->update($this);

        }else{
            BDD::getInstance()->getManager("Competition")->add($this);

        }
    }
}

function loadCompetition($info){
    $competition;

    if(isset($info['Id'])){
        $competition = BDD::getInstance()->getManager("Competition")->getId($info['Id']);
    }

    return $competition;
}


?>
