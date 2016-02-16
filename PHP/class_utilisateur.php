<?php

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

    /*
    *----------------------------------------------------------------
    *CONSTRUCTEUR
    *----------------------------------------------------------------
    */

    //Constructeur qui initialisera le personnage avec la fonction hydrate
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function __construct(Utilisateur $user)
    {
        //Copie les valeurs

        //Detruit ancienne utilisateur
        unset($user);
    }

    /*
    *----------------------------------------------------------------
    *GETTER
    *----------------------------------------------------------------
    */

    //Fonction qui renvoie l'id de l'utilisateur (en integer)
    public function getIdUtilisateur()
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

    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    //Fonction qui fixe l'id de l'utilisateur
    public function setIdUtilisateur($IdUtilisateur)
    {
        if(!is_int($IdUtilisateur))
        {
            trigger_error("L'id doit être un entier",E_USER_WARNING);
        }else{
            $this->_IdUtilisateur = $IdUtilisateur;  
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

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    /**
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

}

?>
