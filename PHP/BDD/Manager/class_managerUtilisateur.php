<?php
require_once "class_manager.php";
require_once "../class_utilisateur.php";

class ManagerUtilisateur extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un utilisateur dans la BDD
    public function add($objet)
    {

        $this->addParente($objet);

        //Recupere l'id du sexe de l'utilisateur
        $requeteId_Sexe = $this->getDb()->query('SELECT Id_Sexe FROM Sexe WHERE Type = '.$objet->getSexe());
        $donneId_Sexe = $requeteId_Sexe->fetch(PDO::FETCH_ASSOC);

        $requete = $this->getDb()->prepare('INSERT INTO Utilisateur (Nom,Prenom,Password,DateNaissance,Adresse,Mail,Telephone,Id_Sexe) VALUES(:nom,:prenom,:password,:dateNaissance,:adresse,:mail,:telephone,:id_Sexe)');

        $requete->execute(array('nom' => $objet->getNom(),
                                'prenom' => $objet->getPrenom(),
                                'password' => $objet->getPassword(),
                                'dateNaissance' => $objet->getDateNaissance(),
                                'adresse' => $objet->getAdresse(),
                                'mail' => $objet->getMail(),
                                'telephone' => $objet->getTelephone(),
                                'id_Sexe' => $donneId_Sexe['Id_Sexe'],
                               ));

        //Recupere l'id de l'utilisateur genere par la base
        $requeteId_Utilisateur = $this->getDb()->query('SELECT Id_Utilisateur FROM Utilisateur WHERE Mail = '.$objet->getMail());
        $donneId_Utilisateur = $requeteId_Utilisateur->fetch(PDO::FETCH_ASSOC);

        $objet->setId_Utilisateur($donneId_Utilisateur['Id_Utilisateur']);

    }

    public function addParente($objet){

        $requeteEnfant = $this->getDb()->query('SELECT Id_Enfant FROM Parente WHERE Id_Parent = '.$objet->getId_Utilisateur());
        $donneEnfant = $requeteEnfant->fetch(PDO::FETCH_ASSOC);

        foreach($objet->getParente() as $enfant){

            if(!in_array($donneEnfant['Id_Enfant'],$enfant)){
                $requete = $this->getDb()->prepare('INSERT INTO Parente (Id_Parent,Id_Enfant) VALUES(:id_Parent,:id_Enfant)');

                $requete->execute(array('id_Parent' => $objet->GetId_Utilisateur(),
                                        'id_Enfant' => $enfant,
                                        ));
            }
        }
    }

    //Suppression d'un utilisateur dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Utilisateur WHERE Id_Utilisateur = '.$objet->getId_Utilisateur());
    }

    //Fonction qui retourne un utilisateur à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Utilisateur, Nom, Prenom, Password, DateNaissance, Adresse, Mail, Telephone, Id_Sexe FROM Utilisateur WHERE Id_Utilisateur = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        //Recupere le type du sexe de l'utilisateur
        $requeteType_Sexe = $this->getDb()->query('SELECT Type FROM Sexe WHERE Id_Sexe = '.$donnees['Id_Sexe']);
        $donneType_Sexe = $requeteType_Sexe->fetch(PDO::FETCH_ASSOC);

        $donnees['Sexe'] = $donneType_Sexe['Type'];
        unset($donnees['Id_Sexe']);

        return new Utilisateur($donnees);
    }

    public function getMail($mail){
        $requete = $this->getDb()->query('SELECT Id_Utilisateur, Nom, Prenom, Password, DateNaissance, Adresse, Mail, Telephone, Id_Sexe FROM Utilisateur WHERE Mail = '.$mail);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        //Recupere le type du sexe de l'utilisateur
        $requeteType_Sexe = $this->getDb()->query('SELECT Type FROM Sexe WHERE Id_Sexe = '.$donnees['Id_Sexe']);
        $donneType_Sexe = $requeteType_Sexe->fetch(PDO::FETCH_ASSOC);

        $donnees['Sexe'] = $donneType_Sexe['Type'];
        unset($donnees['Id_Sexe']);

        return new Utilisateur($donnees);
    }

    //Fonction qui retourne la liste de tous les utilisateur présents dans la BDD
    public function getList()
    {
        $utilisateurs = array();

        $requete = $this->getDb()->query('SELECT Id_Utilisateur, Nom, Prenom, Password, DateNaissance, Adresse, Mail, Telephone, Id_Sexe FROM Utilisateur');

        $i=0;
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
        {
            //Recupere le type du sexe de l'utilisateur
            $requeteType_Sexe = $this->getDb()->query('SELECT Type FROM Sexe WHERE Id_Sexe = '.$donnees['Id_Sexe']);
            $donneType_Sexe = $requeteType_Sexe->fetch(PDO::FETCH_ASSOC);

            $donnees['Sexe'] = $donneType_Sexe['Type'];
            unset($donnees['Id_Sexe']);

            $utilisateurs[] = new Utilisateur($donnees);
            $i++;
        }

        return $utilisateurs;
    }

    //Procédure qui met à jour un utilisateur donné en paramètre dans la BDD
    public function update($objet)
    {
        //Recupere l'id du sexe de l'utilisateur
        $requeteId_Sexe = $this->getDb()->query('SELECT Id_Sexe FROM Sexe WHERE Type = '.$objet->getSexe());
        $donneId_Sexe = $requeteId_Sexe->fetch(PDO::FETCH_ASSOC);

        $requete = $this->getDb()->prepare('UPDATE Utilisateur SET Nom = :nom, Prenom = :prenom, Password = :password, DateNaissance = :dateNaissance, Adresse = :adresse, Mail = :mail, Telephone = :telephone, Id_Sexe = :id_sexe WHERE Id_Utilisateur = :id_Utilisateur');

        $requete->execute(array('nom' => $objet->getNom(),
                                'prenom' => $objet->getPrenom(),
                                'password' => $objet->getPassword(),
                                'dateNaissance' => $objet->getDateNaissance(),
                                'adresse' => $objet->getAdresse(),
                                'mail' => $objet->getMail(),
                                'telephone' => $objet->getTelephone(),
                                'id_Sexe' => $donneId_Sexe['Id_Sexe'],
                                'id_Utilisateur' => $objet->getId_Utilisateur(),
                               ));
    }

}
?>
