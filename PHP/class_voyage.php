<?php

require_once "BDD/class_bdd.php";

class Voyage{
    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */

    private $_Id_Voyage;

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

    public function getId_Voyage(){
        return $this->_Id_Voyage;
    }


    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    public function setId_Voyage($IdVoyage){
        $this->_Id_Voyage = $IdVoyage;
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
            BDD::getInstance()->getManager("Voyage")->update($this);

        }else{
            BDD::getInstance()->getManager("Voyage")->add($this);
        }
    }
}

function loadVoyage($info){
    $voyage;

    if(isset($info['Id'])){
        $voyage = BDD::getInstance()->getManager("Voyage")->getId($info['Id']);
    }

    return $voyage;
}

?>
