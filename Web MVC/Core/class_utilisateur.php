<?php
require_once "BDD/class_bdd.php";

class Utilisateur{

    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */

    private $_Id_Utilisateur;
    private $_Nom;
    private $_Prenom;
    private $_Mail;
    private $_Password;
    private $_DateNaissance;
    private $_Adresse;
    private $_Telephone;
    private $_Sexe;
    private $_Droit; // tableau de nom des droits
    private $_Parente; // tableau d'id enfant
    private $_Message; // tableau de message

    /*
    *----------------------------------------------------------------
    *CONSTRUCTEUR
    *----------------------------------------------------------------
    */

    //Constructeur qui initialisera l'utilisateur avec la fonction hydrate
    public function __construct(array $donnees,Utilisateur $user = null)
    {
        if(isset($user)){
          //Copie les valeurs
          $this->setId_Utilisateur($user->getId_Utilisateur());
          $this->setNom($user->getNom());
          $this->setPrenom($user->getPrenom());
          $this->setMail($user->getMail());
          $this->setPassword($user->getPassword());
          $this->setDateNaissance($user->getDateNaissance());
          $this->setAdresse($user->getAdresse());
          $this->setTelephone($user->getTelephone());
          $this->setSexe($user->getSexe());
          $this->setDroit($user->getDroit());
          $this->setParente($user->getParente());


          //Detruit ancienne utilisateur
          unset($user);
        }else{
          $this->hydrate($donnees);
        }

    }

    /*
    *----------------------------------------------------------------
    *GETTER
    *----------------------------------------------------------------
    */

    //Fonction qui renvoie l'id de l'utilisateur (en integer)
    public function getId_Utilisateur()
    {
        return $this->_Id_Utilisateur;
    }

    //Fonction qui renvoie le nom de l'utilisateur (en string)
    public function getNom()
    {
        return $this->_Nom;
    }

    //Fonction qui renvoie le prenom de l'utilisateur (en string)
    public function getPrenom()
    {
        return $this->_Prenom;
    }

    //Fonction qui renvoie le mail de l'utilisateur (en string)
    public function getMail()
    {
        return $this->_Mail;
    }

    //Fonction qui renvoie le mot de passe de l'utilisateur (en string)
    public function getPassword()
    {
        return $this->_Password;
    }

    public function getDateNaissance(){
        return $this->_DateNaissance;
    }

    public function getAdresse(){
        return $this->_Adresse;
    }

    public function getTelephone(){
        return $this->_Telephone;
    }

    public function getSexe(){
        return $this->_Sexe;
    }

    public function getDroit(){
        return $this->_Droit;
    }

    public function getParente(){
        return $this->_Parente;
    }

    public function getMessage(){
        return $this->_Message;
    }


    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    //Fonction qui fixe l'id de l'utilisateur
    public function setId_Utilisateur($IdUtilisateur)
    {
        if(!is_int($IdUtilisateur))
        {
            $this->_Id_Utilisateur = intval($IdUtilisateur);
        }else{
            $this->_Id_Utilisateur = $IdUtilisateur;
        }
    }

    //Fonction qui fixe le nom de l'utilisateur
    public function setNom($Nom)
    {
        $this->_Nom = htmlspecialchars($Nom);
    }

    //Fonction qui fixe le prenom de l'utilisateur
    public function setPrenom($Prenom)
    {
        $this->_Prenom = htmlspecialchars($Prenom);
    }

    //Fonction qui fixe le mail de l'utilisateur
    public function setMail($Mail)
    {
        $this->_Mail = htmlspecialchars($Mail);
    }

    //Fonction qui fixe le mot de passe de l'utilisateur
    public function setPassword($Password)
    {
        $this->_Password = $Password;
    }

    public function setDateNaissance($Date){
        $this->_DateNaissance = $Date;
    }

    public function setAdresse($Adresse){
        $this->_Adresse = htmlspecialchars($Adresse);
    }

    public function setTelephone($Telephone){
        $this->_Telephone = htmlspecialchars($Telephone);
    }

    public function setSexe($Sexe){
        $this->_Sexe = $Sexe;
    }

    public function setDroit($Droit){
        $this->_Droit = $Droit;
    }

    public function setParente($Parente){
        $this->_Parente = $Parente;
    }

    public function setMessage($Message){
        $this->_Message = $Message;
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
            BDD::getInstance()->getManager("Utilisateur")->update($this);

            //update message
            if($this->_Message['Envoyer']!=null){
              foreach($this->_Message['Envoyer'] as $message){
                  BDD::getInstance()->getManager("Message")->update($message);
              }
            }
        }else{
            BDD::getInstance()->getManager("Utilisateur")->add($this);

            //ajoute message
            if($this->_Message['Envoyer']!=null){
              foreach($this->_Message['Envoyer'] as $message){
                  BDD::getInstance()->getManager("Message")->add($message);
              }
            }
        }
    }

}

function loadUtilisateur($info){
    $utilisateur = null;

    if(isset($info['Id'])){
        $utilisateur = BDD::getInstance()->getManager("Utilisateur")->getId($info['Id']);
    }else{
        $utilisateur = BDD::getInstance()->getManager("Utilisateur")->getMail($info['Mail']);
    }

    if(isset($utilisateur)){
      //recupere message
      $utilisateur->setMessage(BDD::getInstance()->getManager("Message")->getListUtilisateur($utilisateur->getId_Utilisateur()));

      //recupere le sexe (id,type)
      $utilisateur->setSexe(BDD::getInstance()->getManager("Sexe")->getId($utilisateur->getSexe()));

      //recupere les droit (id,nom)
      $droits = array();
      foreach($utilisateur->getDroit() as $droit){
          $droit = BDD::getInstance()->getManager("Droit_Acces")->getId($droit);

          $droits[] = $droit;
      }
      $utilisateur->setDroit($droits);
    }


    return $utilisateur;
}

//function qui permet de savoir si l'id correspond a un utilisateur dans la base
function isUtilisateur($id){
  return BDD::getInstance()->getManager("Utilisateur")->isUtilisateur($id);
}

?>
