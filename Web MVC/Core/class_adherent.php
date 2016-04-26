<?php

require_once "class_utilisateur.php";

class Adherent extends Utilisateur{
    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */
    private $_Utilisateur; // objet utilisateur
    private $_NumeroLicence;
    private $_DateInscription;
    /*
    *----------------------------------------------------------------
    *CONSTRUCTEUR
    *----------------------------------------------------------------
    */

    public function __construct(Adherent $user,Utilisateur $utili,array $donnees)
    {
        if(isset($user)){
          parent::__construct($user->getUtilisateur());

          $this->setUtilisateur($user->getUtilisateur());
          $this->setNumeroLicence($user->getNumeroLicence());
          $this->setDateInscription($user->getDateInscription());

          unset($user);
        }else{
          parent::__construct($user);
          $this->hydrate($donnees);
        }

    }

    /*
    *----------------------------------------------------------------
    *GETTER
    *----------------------------------------------------------------
    */

    public function getUtilisateur(){
        return $this->_Utilisateur;
    }

    public function getNumeroLicence(){
        return $this->_NumeroLicence;
    }

    public function getDateInscription(){
        return $this->_DateInscription;
    }

    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    public function setUtilisateur($Utilisateur){
        $this->_Utilisateur = $Utilisateur;
    }

    public function setNumeroLicence($Numero){
        $this->_NumeroLicence = htmlspecialchars($Numero);
    }

    public function setDateInscription($Date){
        $this->_DateInscription = $Date;
    }

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function save($bupdate){
        if($bupdate){
            BDD::getInstance()->getManager("Adherent")->update($this);

            //update message
            foreach($this->_Message['Envoyer'] as $message){
                BDD::getInstance()->getManager("Message")->update($message);
            }
        }else{
            BDD::getInstance()->getManager("Adherent")->add($this);

            //ajoute message
            foreach($this->_Message['Envoyer'] as $message){
                BDD::getInstance()->getManager("Message")->add($message);
            }
        }
    }

}

function loadAdherent($info){

    $adherent;

    if(isset($info['Id'])){
        $adherent = BDD::getInstance()->getManager("Adherent")->getId($info['Id']);
    }else{
        $adherent = BDD::getInstance()->getManager("Adherent")->getMail($info['Mail']);
    }

    //recupere message
    $adherent->setMessage(BDD::getInstance()->getManager("Message")->getListUtilisateur($competiteur->getId_Utilisateur()));


    return $adherent;
}

?>
