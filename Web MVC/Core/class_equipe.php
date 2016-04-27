<?php

require_once "class_competiteur.php";

class Equipe{

    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */
    private $_Id_Equipe;
    private $_Nom;
    private $_Membre; // tableau avec les id des competiteurs
    private $_CourseParticipe; //tableau avec les id des courses
    private $_TypeSpecialite;

    /*
    *----------------------------------------------------------------
    *CONSTRUCTEUR
    *----------------------------------------------------------------
    */

    //Constructeur qui initialisera l'equipe avec la fonction hydrate
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    /*
    *----------------------------------------------------------------
    *GETTER
    *----------------------------------------------------------------
    */

    public function getId_Equipe(){
        return $this->_Id_Equipe;
    }

    public function getNom(){
        return $this->_Nom;
    }

    public function getMembre(){
        return $this->_Membre;
    }

    public function getCourseParticipe(){
        return $this->_CourseParticipe;
    }

    public function getTypeSpecialite(){
        return $this->_TypeSpecialite;
    }

    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    public function setId_Equipe($IdEquipe){
        $this->_Id_Equipe = $IdEquipe;
    }

    public function setNom($Nom){
        $this->_Nom = htmlspecialchars($Nom);
    }

    public function setMembre($Membre){
        $this->_Membre = $Membre;
    }

    public function setCourseParticipe($Course){
        $this->_CourseParticipe = $Course;
    }

    public function setTypeSpecialite($Type){
        $this->_TypeSpecialite = $Type;
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
            BDD::getInstance()->getManager("Equipe")->update($this);
        }else{
            BDD::getInstance()->getManager("Equipe")->add($this);
        }
    }
}

function loadEquipe($info){
    $equipe;

    if(isset($info['Id'])){
        $equipe = BDD::getInstance()->getManager("Equipe")->getId($info['Id']);
    }

    //recupere le type le TypeSpecialite
    $equipe->setTypeSpecialite(BDD::getInstance()->getManager("Type_Specialite")->getId($equipe->getTypeSpecialite()));

    return $equipe;
}

?>
