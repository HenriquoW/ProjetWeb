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
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function __construct(Utilisateur $user)
    {
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
    }

    /*
    *----------------------------------------------------------------
    *GETTER
    *----------------------------------------------------------------
    */

    //Fonction qui renvoie l'id de l'utilisateur (en integer)
    public function getId_Utilisateur()
    {
        return $this->_IdUtilisateur;
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
        return $this->_Sexe;
    }

    public function getAdresse(){
        return $this->_Sexe;
    }

    public function getTelephone(){
        return $this->_Sexe;
    }

    public function getSexe(){
        return $this->_Sexe;
    }

    public function getDroit(){
        return $this->_Sexe;
    }

    public function getParente(){
        return $this->_Sexe;
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
            trigger_error("L'id doit être un entier",E_USER_WARNING);
        }else{
            $this->_Id_Utilisateur = $IdUtilisateur;
        }
    }

    //Fonction qui fixe le nom de l'utilisateur
    public function setNom($Nom)
    {
        if(!is_string($Nom))
        {
            trigger_error('Le nom doit être une chaine de caractères',E_USER_WARNING);
        }else{
            $this->_Nom = htmlspecialchars($Nom);  
        }
    }

    //Fonction qui fixe le prenom de l'utilisateur
    public function setPrenom($Prenom)
    {
        if(!is_string($Prenom))
        {
            trigger_error('Le prenom doit être une chaine de caractères',E_USER_WARNING);
        }else{
            $this->_Prenom = htmlspecialchars($Prenom);  
        }
    }

    //Fonction qui fixe le mail de l'utilisateur
    public function setMail($Mail)
    {
        if(!is_string($Mail))
        {
            trigger_error('Le mail doit être une chaine de caractères',E_USER_WARNING);
        }else{
            $this->_Mail = htmlspecialchars($Mail);  
        }
    }

    //Fonction qui fixe le mot de passe de l'utilisateur
    public function setPassword($Password)
    {
        if(!is_string($Password))
        {
            trigger_error('Le mot de passe doit être une chaine de caractères',E_USER_WARNING);
        }else{
            $Password = sha1(htmlspecialchars($Password));
            $this->_Password = $Password;  
        }
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
        $newDroit;

        foreach($Droit as $d){
           $newDroit = htmlspecialchars($d);
        }

        $this->_Droit = $newDroit;
    }

    public function setParente($Parente){
        $newParente;

        foreach($Parente as $p){
            if(is_int($p)){
                $newParente = $p;
            }
        $this->_Parente = $newParente;
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
            foreach($this->_Message['Envoyer'] as $message){
                BDD::getInstance()->getManager("Message")->update($message);
            }
        }else{
            BDD::getInstance()->getManager("Utilisateur")->add($this);

            //ajoute message
            foreach($this->_Message['Envoyer'] as $message){
                BDD::getInstance()->getManager("Message")->add($message);
            }
        }
    }

}

function loadUtilisateur($info){
    $utilisateur;

    if(isset($info['Id'])){
        $utilisateur = BDD::getInstance()->getManager("Utilisateur")->getId($info['Id']);
    }else{
        $utilisateur = BDD::getInstance()->getManager("Utilisateur")->getMail($info['Mail']);
    }

    //recupere message
    $utilisateur->setMessage(BDD::getInstance()->getManager("Message")->getListUtilisateur($competiteur->getId_Utilisateur()));

    //recupere le sexe (id,type)
    $utilisateur->setSexe(BDD::getInstance()->getManager("Sexe")->getId($utilisateur->getSexe())

    //recupere les droit (id,nom)
    $droits;
    foreach($utilisateur->getDroit() as $droit){
        $droit = BDD::getInstance()->getManager("Droit")->getId($droit);

        $droits[] = $droit;
    }
    $utilisateur->setDroit($droits);

    return $utilisateur;
}

?>
