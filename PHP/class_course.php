<?php

require_once "BDD/class_bdd.php";

class Course{
    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */

    private $_Id_Course;

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


    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    public function setId_Course($IdCourse){
        $this->_Id_Course = $IdCourse;
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

function loadMessage($info){
    $course;

    if(isset($info['Id'])){
        $course = BDD::getInstance()->getManager("Course")->getId($info['Id']);
    }

    return $course;
}

?>
