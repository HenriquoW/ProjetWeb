<?php

require_once "class_adherent.php";

class Competiteur extends Adherent{
    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */
    private $_Id_Competiteur;
    private $_Adherent;
    private $_Photo;
    private $_Specialite;
    private $_Categorie;
    private $_Objectif; //tableau avec id competition pour objectif
    private $_CourseParticipe; //tableau avec id course et statut validation dont il participe, id equipe si il participe en equipe
    private $_EquipeParticipe; //tableau avec id equipe dont il fait partit
    private $_Palmares;
    private $_VoyageParticipe;

    /*
    *----------------------------------------------------------------
    *CONSTRUCTEUR
    *----------------------------------------------------------------
    */
    public function __construct(Adherent $user,array $donnees)
    {
        //parent::__construct(null,null,$user);
        $this->_Adherent = $user;
        $this->hydrate($donnees);
    }

    /*
    *----------------------------------------------------------------
    *GETTER
    *----------------------------------------------------------------
    */

    public function getId_Competiteur(){
	return $this->_Id_Competiteur;
    }

    public function getAdherent(){
        return $this->_Adherent;
    }

    public function getPhoto(){
        return $this->_Photo;
    }

    public function getSpecialite(){
        return $this->_Specialite;
    }

    public function getCategorie(){
        return $this->_Categorie;
    }

    public function getObjectif(){
        return $this->_Objectif;
    }

    public function getCourseParticipe(){
        return $this->_CourseParticipe;
    }

    public function getCourseParticipeId($id){
      foreach ($this->_CourseParticipe as $course) {
        if($course['Id_Course'] == $id){
          return $course;
        }
      }
      return null;
    }

    public function getEquipeParticipe(){
        return $this->_EquipeParticipe;
    }

    public function getPalmares(){
        return $this->_Palmares;
    }

    public function getVoyagePArticipe(){
        return $this->_VoyageParticipe;
    }

    public function getNumeroLicence(){
        return $this->_Adherent->getNumeroLicence();
    }

    public function getDateInscription(){
        return $this->_Adherent->getDateInscription();
    }

    //Fonction qui renvoie l'id de l'utilisateur (en integer)
    public function getId_Utilisateur()
    {
        return $this->_Adherent->getId_Utilisateur();
    }

    //Fonction qui renvoie le nom de l'utilisateur (en string)
    public function getNom()
    {
        return $this->_Adherent->getNom();
    }

    //Fonction qui renvoie le prenom de l'utilisateur (en string)
    public function getPrenom()
    {
        return $this->_Adherent->getPrenom();
    }

    //Fonction qui renvoie le mail de l'utilisateur (en string)
    public function getMail()
    {
        return $this->_Adherent->getMail();
    }

    //Fonction qui renvoie le mot de passe de l'utilisateur (en string)
    public function getPassword()
    {
        return $this->_Adherent->getPassword();
    }

    public function getDateNaissance(){
        return $this->_Adherent->getDateNaissance();
    }

    public function getAdresse(){
        return $this->_Adherent->getAdresse();
    }

    public function getTelephone(){
        return $this->_Adherent->getTelephone();
    }

    public function getSexe(){
        return $this->_Adherent->getSexe();
    }

    public function getDroit(){
        return $this->_Adherent->getDroit();
    }

    public function getParente(){
        return $this->_Adherent->getParente();
    }

    public function getMessage(){
        return $this->_Adherent->getMessage();
    }

    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    public function setId_Competiteur($id){
	$this->_Id_Competiteur = $id;
    }

    public function setAdherent($Adherent){
        $this->_Adherent = $Adherent;
    }

    public function setPhoto($Photo){
        $this->_Photo = htmlspecialchars($Photo);
    }

    public function setSpecialite($Specialite){
        $this->_Specialite = $Specialite;
    }

    public function setCategorie($Categorie){
        $this->_Categorie = $Categorie;
    }

    public function setObjectif($Objectif){
        $this->_Objectif = $Objectif;
    }

    public function setCourseParticipe($Course){
        $this->_CourseParticipe = $Course;
    }

    public function setEquipeParticipe($Equipe){
        $this->_EquipeParticipe = $Equipe;
    }

    public function setPalmares($Palmares){
        $this->_Palmares = $Palmares;
    }

    public function setVoyageParticipe($Voyage){
        $this->_VoyageParticipe = $Voyage;
    }

    public function setNumeroLicence($Numero){
	$this->_Adherent->setNumeroLicence($Numero);
    }

    public function setDateInscription($Date){
	$this->_Adherent->setDateInscription($Date);
    }

//Fonction qui fixe l'id de l'utilisateur
    public function setId_Utilisateur($IdUtilisateur)
    {
        $this->_Adherent->setId_Utilisateur($IdUtilisateur);
    }

    //Fonction qui fixe le nom de l'utilisateur
    public function setNom($Nom)
    {
        $this->_Adherent->setNom($Nom);
    }

    //Fonction qui fixe le prenom de l'utilisateur
    public function setPrenom($Prenom)
    {
        $this->_Adherent->setPrenom($Prenom);
    }

    //Fonction qui fixe le mail de l'utilisateur
    public function setMail($Mail)
    {
        $this->_Adherent->setMail($Mail);
    }

    //Fonction qui fixe le mot de passe de l'utilisateur
    public function setPassword($Password)
    {
        $this->_Adherent->setPassword($Password);
    }

    public function setDateNaissance($Date){
        $this->_Adherent->setDateNaissance($Date);
    }

    public function setAdresse($Adresse){
        $this->_Adherent->setAdresse($Adresse);
    }

    public function setTelephone($Telephone){
        $this->_Adherent->setTelephone($Telephone);
    }

    public function setSexe($Sexe){
        $this->_Adherent->setSexe($Sexe);
    }

    public function setDroit($Droit){
        $this->_Adherent->setDroit($Droit);
    }

    public function setParente($Parente){
        $this->_Adherent->setParente($Parente);
    }

    public function setMessage($Message){
        $this->_Adherent->setMessage($Message);
    }

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function save($bupdate){
            if($bupdate){
                BDD::getInstance()->getManager("Competiteur")->update($this);

                //update palmares
                foreach($this->_Palmares as $palmares){
                    BDD::getInstance()->getManager("Palmares")->update($palmares);
                }

                //update message
                foreach($this->_Message['Envoyer'] as $message){
                    BDD::getInstance()->getManager("Message")->update($message);
                }

            }else{
                BDD::getInstance()->getManager("Competiteur")->add($this);

                //ajoute palmares
                foreach($this->_Palmares as $palmares){
                    BDD::getInstance()->getManager("Palmares")->add($palmares);
                }

                //ajoute message
                foreach($this->_Message['Envoyer'] as $message){
                    BDD::getInstance()->getManager("Message")->add($message);
                }
            }
        }

}

function loadCompetiteur($info){

    $competiteur = null;

    if(isset($info['Id'])){
        $competiteur = BDD::getInstance()->getManager("Competiteur")->getId($info['Id']);
    }else{
        $competiteur = BDD::getInstance()->getManager("Competiteur")->getMail($info['Mail']);
    }
if($competiteur!=null){
    //recupere specialite (id,nom)
    $competiteur->setSpecialite(BDD::getInstance()->getManager("Specialite")->getId($competiteur->getSpecialite()));

    //recupere categorie (id,nom)
    $competiteur->setCategorie(BDD::getInstance()->getManager("Categorie")->getId($competiteur->getCategorie()));

    //recupere types de voyages (id,nom)
    $voyages = array();
    foreach($competiteur->getVoyageParticipe() as $voyage){
        $voyage['Type_Voyage'] = BDD::getInstance()->getManager("Type_Voyage")->getId($voyage['Type_Voyage']);

        $voyages[] = $voyage;
    }
    $competiteur->setVoyageParticipe($voyages);

    //recupere palmares
    $palmares = array();
    foreach($competiteur->getEquipeParticipe() as $idEquipe){
      $palmares = BDD::getInstance()->getManager("Palmares")->getListEquipe($idEquipe);
    }
    $palmares = array_merge($palmares,BDD::getInstance()->getManager("Palmares")->getListCompetiteur($competiteur->getId_Competiteur()));
    
    $competiteur->setPalmares($palmares);

    //recupere message
    $competiteur->setMessage(BDD::getInstance()->getManager("Message")->getListUtilisateur($competiteur->getId_Utilisateur()));

    //recupere le sexe (id,type)
    $competiteur->setSexe(BDD::getInstance()->getManager("Sexe")->getId($competiteur->getSexe()));

    //recupere les droit (id,nom)
    $droits = array();
    foreach($competiteur->getDroit() as $droit){
        $droit = BDD::getInstance()->getManager("Droit_Acces")->getId($droit);

        $droits[] = $droit;
    }
    $competiteur->setDroit($droits);
}
    return $competiteur;
}

function isCompetiteurUtilisateur($id){
  return BDD::getInstance()->getManager("Competiteur")->isCompetiteurUtilisateur($id);
}

function isCompetiteurAdherent($id){
  return BDD::getInstance()->getManager("Competiteur")->isCompetiteurAdherent($id);
}



?>
