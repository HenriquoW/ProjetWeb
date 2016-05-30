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

    public function __construct(array $donnees = null,Utilisateur $utili = null,Adherent $user = null)
    {
        if(isset($user)){
          //parent::__construct(null,$user->getUtilisateur());

	  $this->_Utilisateur = $user->getUtilisateur();
          $this->setNumeroLicence($user->getNumeroLicence());
          $this->setDateInscription($user->getDateInscription());

          //unset($user);
        }else if(isset($utili)){
          //parent::__construct(null,$utili);
	  $this->_Utilisateur = $utili;

	  if(isset($donnees))	
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

//Fonction qui renvoie l'id de l'utilisateur (en integer)
    public function getId_Utilisateur()
    {
        return $this->_Utilisateur->getId_Utilisateur();
    }

    //Fonction qui renvoie le nom de l'utilisateur (en string)
    public function getNom()
    {
        return $this->_Utilisateur->getNom();
    }

    //Fonction qui renvoie le prenom de l'utilisateur (en string)
    public function getPrenom()
    {
        return $this->_Utilisateur->getPrenom();
    }

    //Fonction qui renvoie le mail de l'utilisateur (en string)
    public function getMail()
    {
        return $this->_Utilisateur->getMail();
    }

    //Fonction qui renvoie le mot de passe de l'utilisateur (en string)
    public function getPassword()
    {
        return $this->_Utilisateur->getPassword();
    }

    public function getDateNaissance(){
        return $this->_Utilisateur->getDateNaissance();
    }

    public function getAdresse(){
        return $this->_Utilisateur->getAdresse();
    }

    public function getTelephone(){
        return $this->_Utilisateur->getTelephone();
    }

    public function getSexe(){
        return $this->_Utilisateur->getSexe();
    }

    public function getDroit(){
        return $this->_Utilisateur->getDroit();
    }

    public function getParente(){
        return $this->_Utilisateur->getParente();
    }

    public function getMessage(){
        return $this->_Utilisateur->getMessage();
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

//Fonction qui fixe l'id de l'utilisateur
    public function setId_Utilisateur($IdUtilisateur)
    {
        $this->_Utilisateur->setId_Utilisateur($IdUtilisateur);
    }

    //Fonction qui fixe le nom de l'utilisateur
    public function setNom($Nom)
    {
        $this->_Utilisateur->setNom($Nom);
    }

    //Fonction qui fixe le prenom de l'utilisateur
    public function setPrenom($Prenom)
    {
        $this->_Utilisateur->setPrenom($Prenom);
    }

    //Fonction qui fixe le mail de l'utilisateur
    public function setMail($Mail)
    {
        $this->_Utilisateur->setMail($Mail);
    }

    //Fonction qui fixe le mot de passe de l'utilisateur
    public function setPassword($Password)
    {
        $this->_Utilisateur->setPassword($Password);
    }

    public function setDateNaissance($Date){
        $this->_Utilisateur->setDateNaissance($Date);
    }

    public function setAdresse($Adresse){
        $this->_Utilisateur->setAdresse($Adresse);
    }

    public function setTelephone($Telephone){
        $this->_Utilisateur->setTelephone($Telephone);
    }

    public function setSexe($Sexe){
        $this->_Utilisateur->setSexe($Sexe);
    }

    public function setDroit($Droit){
        $this->_Utilisateur->setDroit($Droit);
    }

    public function setParente($Parente){
        $this->_Utilisateur->setParente($Parente);
    }

    public function setMessage($Message){
        $this->_Utilisateur->setMessage($Message);
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

function isAdherentUtilisateur($id){
  return BDD::getInstance()->getManager("Adherent")->isAdherentUtilisateur($id);
}

?>
