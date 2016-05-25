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

    $adherent = null;

    if(isset($info['Id'])){
        $adherent = BDD::getInstance()->getManager("Adherent")->getId($info['Id']);
    }else{
        $adherent = BDD::getInstance()->getManager("Adherent")->getMail($info['Mail']);
    }
if($adherent!=null){
    //recupere message
    $adherent->setMessage(BDD::getInstance()->getManager("Message")->getListUtilisateur($adherent->getId_Utilisateur()));

    //recupere le sexe (id,type)
    $adherent->setSexe(BDD::getInstance()->getManager("Sexe")->getId($adherent->getSexe()));

    //recupere les droit (id,nom)
    $droits = array();
    foreach($adherent->getDroit() as $droit){
        $droit = BDD::getInstance()->getManager("Droit_Acces")->getId($droit);

        $droits[] = $droit;
    }
    $adherent->setDroit($droits);

}
    return $adherent;
}

function isAdherent($id){
  return BDD::getInstance()->getManager("Adherent")->isAdherent($id);
}

?>
