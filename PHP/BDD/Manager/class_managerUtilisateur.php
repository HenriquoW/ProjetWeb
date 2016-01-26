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
        $requete = $this->getDb()->prepare('INSERT INTO Utilisateur SET nom = :nom, prenom = :prenom, mail = :mail, password = :password');

        $requete->execute(array('nom' => $objet->getNom(),
                                'prenom' => $entite->getPrenom(),
                                'mail' => $entite->getMail(),
                                'password' => $entite->getPassword(),
                               ));

    }

    //Suppression d'un utilisateur dans la BDD
    public function remove($objet)
    {
        $id = $objet->getId();
        $this->getDb()->exec('DELETE FROM Utilisateur WHERE IdUtilisateur = '.$id);
    }

    //Fonction qui retourne un utilisateur à partir de son mail
    public function get($objet)
    {
        $requete = $this->getDb()->query('SELECT IdUtilisateur, nom, prenom, mail, password FROM Utilisateur WHERE mail = '.$objet);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        return new Utilisateur($donnees);
    }

    //Fonction qui retourne la liste de tous les utilisateur présents dans la BDD
    public function getList()
    {
        $utilisateurs = array();

        $requete = $this->getDb()->query('SELECT IdUtilisateur, nom, prenom, mail, password FROM Utilisateur');

        $i=0;
        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $utilisateurs[] = new Utilisateur($donnees);
            $i++;
        }

        return $utilisateurs;
    }

    //Procédure qui met à jour un utilisateur donné en paramètre dans la BDD
    public function update($objet)
    {
        $requete = $this->getDb()->prepare('UPDATE Utilisateur SET nom = :nom, prenom = :prenom, mail = :mail, password = :password WHERE IdUtilisateur = :IdUtilisateur');

        $requete->execute(array('nom' => $objet->getNom(),
                                'prenom' => $objet->getPrenom(),
                                'mail' => $objet->getMail(),
                                'password' => $objet->getPassword(),
                                'IdUtilisateur' => $objet->getIdUtilisateur(),
                               ));
    }

}
?>
