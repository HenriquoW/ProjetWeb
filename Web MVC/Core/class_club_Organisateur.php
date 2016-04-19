<?php

require_once "BDD/class_bdd.php";

class Club_Organisateur{
    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */

    private $_Id_Club_Organisateur;
    private $_Nom;
    private $_President;

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

    public function getId_Club_Organisateur(){
        return $this->_Id_Club_Organisateur;
    }

    public function getNom(){
        return $this->_Nom;
    }

    public function getPresident(){
        return $this->_President;
    }

    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    public function setId_Club_Organisateur($IdClub){
        $this->_Id_Club_Organisateur = $IdClub;
    }

    public function setNom($Nom){
        $this->_Nom = htmlspecialchars($Nom);
    }

    public function setPresident($President){
        $this->_President = htmlspecialchars($President);
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
            BDD::getInstance()->getManager("Club_Organisateur")->update($this);

        }else{
            BDD::getInstance()->getManager("Club_Organisateur")->add($this);
        }
    }
}

function loadClub($info){
    $club;

    if(isset($info['Id'])){
        $club = BDD::getInstance()->getManager("Club_Organisateur")->getId($info['Id']);
    }else{
        $club = BDD::getInstance()->getManager("Club_Organisateur")->getNom($info['Nom']);
    }

    return $club;
}

?>
