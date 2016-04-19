<?php

require_once "BDD/class_bdd.php";

class Voyage{
    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */

    private $_Id_Voyage;
    private $_Id_Competition;
    private $_Transport;
    private $_Hebergement;
    private $_Charge; // tableau avec id utilisateur, role , tache
    private $_Participe; // tableau avec id competiteur, autoriser, type voyage, id utilisateur(si besoin)

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

    public function getId_Competition(){
        return $this->_Id_Competition;
    }

    public function getTransport(){
        return $this->_Transport;
    }

    public function getHebergement(){
        return $this->_Hebergement;
    }

    public function getCharge(){
        return $this->_Charge;
    }

    public function getParticipe(){
        return $this->_Participe;
    }


    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    public function setId_Voyage($IdVoyage){
        $this->_Id_Voyage = $IdVoyage;
    }

    public function setId_Competition($IdCompetition){
        $this->_Id_Competition = $IdCompetition;
    }

    public function setTransport($Transport){
        $this->_Transport= htmlspecialchars($Transport);
    }

    public function setHebergement($Hebergment){
        $this->_Hebergment = htmlspecialchars($Hebergment);
    }

    public function setCharge($Charge){
        $this->_Charge = $Charge;
    }

    public function setParticipe($Participe){
        $this->_Participe = $Participe;
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

    //recupere tache (id,nom) et role (id,titre)
    $charges;
    foreach($competiteur->getCharge() as $charge){
        $charge['Role'] = BDD::getInstance()->getManager("Role")->getId($charge['Role']);

        $charge['Tache'] = BDD::getInstance()->getManager("Tache")->getId($charge['Tache']);

        $charges[] = $charge;
    }
    $voyage->setCharge($charges);

    //recupere type de voyage (id,nom)
    $participes;
    foreach($competiteur->getParticipe() as $participe){
        $participe['Type_Voyage'] = BDD::getInstance()->getManager("Type_Voyage")->getId($participe['Type_Voyage']);

        $participes[] = $participe;
    }
    $voyage->setParticipe($participes);

    return $voyage;
}

?>
