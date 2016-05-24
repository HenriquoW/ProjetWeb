<?php

require_once "BDD/class_bdd.php";

class Course{
    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */

    private $_Id_Course;
    private $_Id_Competition;
    private $_Distance;
    private $_IsEquipe;
    private $_Categorie;
    private $_TypeSpecialite;
    private $_Participant; //tableau avec comme cle (Id) participant et (Validation)


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

    public function getId_Competition(){
        return $this->_Id_Competition;
    }

    public function getDistance(){
        return $this->_Distance;
    }

    public function getIsEquipe(){
        return $this->_IsEquipe;
    }

    public function getCategorie(){
        return $this->_Categorie;
    }

    public function getTypeSpecialite(){
        return $this->_TypeSpecialite;
    }

    public function getParticipant(){
        return $this->_Participant;
    }

    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    public function setId_Course($IdCourse){
        $this->_Id_Course = $IdCourse;
    }

    public function setId_Competition($IdCompetition){
        $this->_Id_Competition = $IdCompetition;
    }

    public function setDistance($Distance){
        $this->_Distance = $Distance;
    }

    public function setIsEquipe($IsEquipe){
        $this->_IsEquipe = $IsEquipe;
    }

    public function setCategorie($Categorie){
        $this->_Categorie = $Categorie;
    }

    public function setTypeSpecialite($TypeSpecialite){
        $this->_TypeSpecialite = $TypeSpecialite;
    }

    public function setParticipant($Participant){
        $this->_Participant = $Participant;
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
            BDD::getInstance()->getManager("Course")->update($this);

        }else{
            BDD::getInstance()->getManager("Course")->add($this);
        }
    }
}

function loadCourse($info){
    $course;

    if(isset($info['Id'])){
        $course = BDD::getInstance()->getManager("Course")->getId($info['Id']);
    }

    //recupere categorie (id,nom)
    $course->setCategorie(BDD::getInstance()->getManager("Categorie")->getId($course->getCategorie()));

    //recupere type specialite (id,nom)
    $course->setTypeSpecialite(BDD::getInstance()->getManager("Type_Specialite")->getId($course->getTypeSpecialite()));

    return $course;
}

function loadCourseCompetition($id){
  return BDD::getInstance()->getManager("Course")->getList_Competition($id);
}

?>
