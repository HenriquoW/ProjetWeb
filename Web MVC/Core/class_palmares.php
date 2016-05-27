<?php

class Palmares{
    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */

    private $_Id_Course;
    private $_Id_Participant;
    private $_Classement;
    private $_IsEquipe;

    /*
    *----------------------------------------------------------------
    *CONSTRUCTEUR
    *----------------------------------------------------------------
    */

    //Constructeur qui initialisera l'utilisateur avec la fonction hydrate
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    /*
    *----------------------------------------------------------------
    *GETTER
    *----------------------------------------------------------------
    */

    public function getId_Course(){
        return $this->_Id_Course;
    }

    public function getId_Participant(){
        return $this->_Id_Participant;
    }

    public function getClassement(){
        return $this->_Classement;
    }

    public function getIsEquipe(){
        return $this->_IsEquipe;
    }

    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    public function setId_Course($IdCourse){
        $this->_Id_Course = $IdCourse;
    }

    public function setId_Participant($IdParticipant){
        $this->_Id_Participant = $IdParticipant;
    }

    public function setClassement($Classement){
        $this->_Classement = $Classement;
    }

    public function setIsEquipe($isequipe){
        $this->_IsEquipe = $isequipe;
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
            BDD::getInstance()->getManager("Palmares")->update($this);

        }else{
            BDD::getInstance()->getManager("Palmares")->add($this);
        }
    }
}

function loadPalmares($info){
    $palmares = null;

    if(isset($info['Id_Course']) && (isset($info['Id_Equipe'])||isset($info['Id_Competiteur']))){
        $palmares = BDD::getInstance()->getManager("Palmares")->getId($info);
    }

    return $palmares;
}

?>
