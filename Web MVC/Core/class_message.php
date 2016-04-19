<?php

require_once "BDD/class_bdd.php";

class Message{
    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */

    private $_Id_Message;
    private $_Sujet;
    private $_Corps;
    private $_Envoyeur; //id utilisateur qui envoie
    private $_Destinataire; //id utilisateur qui recois

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

    public function getId_Message(){
        return $this->_Id_Message;
    }

    public function getSujet(){
        return $this->_Sujet;
    }

    public function getCorps(){
        return $this->_Corps;
    }

    public function getEnvoyeur(){
        return $this->_Envoyeur;
    }

    public function getDestinataire(){
        return $this->_Destinataire;
    }


    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    public function setId_Message($IdMessage){
        $this->_Id_Message = $IdMessage;
    }

    public function setSujet($Sujet){
        $this->_Sujet = htmlspecialchars($Sujet);
    }

    public function setCorps($Corps){
        $this->_Corps = htmlspecialchars($Corps);
    }

    public function setEnvoyeur($Envoyeur){
        $this->_Envoyeur = $Envoyeur;
    }

    public function setDestinataire($Destinataire){
        $this->_Destinataire = $Destinataire;
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
            BDD::getInstance()->getManager("Message")->update($this);

        }else{
            BDD::getInstance()->getManager("Message")->add($this);
        }
    }
}

function loadMessage($info){
    $message;

    if(isset($info['Id'])){
        $message = BDD::getInstance()->getManager("Message")->getId($info['Id']);
    }

    return $message;
}

?>
