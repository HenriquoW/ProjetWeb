<?php

require_once "BDD/class_bdd.php";

class Message{
    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */

    private $_Id_Message;

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


    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    public function setId_Message($IdMessage){
        $this->_Id_Message = $IdMessage;
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
