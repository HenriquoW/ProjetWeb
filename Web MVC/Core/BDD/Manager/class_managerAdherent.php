<?php
require_once "class_managerUtilisateur.php";
require_once "../class_Adherent.php";

class ManagerAdherent extends ManagerUtilisateur{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un adherent dans la BDD
    public function add($objet)
    {
        if($objet->getId_Utilisateur() == NULL){
            parent::add($objet);
        }else{
            parent::update($objet);
        }

        $requete = $this->getDb()->prepare('INSERT INTO Adherent (NumeroLicence,DateInscription,Id_Utilisateur) VALUES(:numeroLicence,:dateInscription,:id_Utilisateur)');

        $requete->execute(array('numeroLicence' => $objet->getNumeroLicence(),
                                'dateInscription' => $objet->getDateInscription(),
                                'id_Utilisateur' => $objet->getId_Utilisateur(),
                               ));

        //Recupere l'id de l'adherent genere par la base
        $requeteId_Adherent = $this->getDb()->query('SELECT Id_Adherent FROM Adherent WHERE Id_Utilisateur = '.$objet->getId_Utilisateur());
        $donneId_Adherent = $requeteId_Adherent->fetch(PDO::FETCH_ASSOC);

        $objet->setId_Adherent($donneId_Adherent['Id_Adherent']);

    }


    //Suppression d'un adherent dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Adherent WHERE Id_Adherent = '.$objet->getId_Adherent());
    }

    //Fonction qui retourne un adherent à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Adherent, NumeroLicence, DateInscription, Id_Utilisateur FROM Adherent WHERE Id_Adherent = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $user = parent::getId($donnees['Id_Utilisateur']);

        unset($donnees['Id_Utilisateur']);

        return new Adherent($user,$donnees);
    }

    public function getMail($mail){
        $requeteId = $this->getDb()->query('SELECT Id_Adherent FROM Adherent JOIN Utilisateur ON Adherent.Id_Utilisateur = Utilisateur.Id_Utilisateur WHERE Utilisateur.Mail = '.$mail);
        $donneId = $requeteId->fetch(PDO::FETCH_ASSOC);

        return $this->getId($donneId['Id_Adherent']);
    }

    //Fonction qui retourne la liste de tous les adherent présents dans la BDD
    public function getList()
    {
        $adherents = array();

        $requete = $this->getDb()->query('SELECT Id_Adherent FROM Adherent');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $adherents[] = $this->getId($donneId['Id_Adherent']);
        }

        return $adherents;
    }

    //Procédure qui met à jour un utilisateur donné en paramètre dans la BDD
    public function update($objet)
    {
        if($objet->getId_Utilisateur() == NULL){
            parent::add($objet);
        }else{
            parent::update($objet);
        }

        $requete = $this->getDb()->prepare('UPDATE Adherent SET NumeroLicence = :numeroLicence, DateInscription = :dateInscription, Id_Utilisateur = :id_Utilisateur WHERE Id_Adherent = :id_Adherent');

        $requete->execute(array('numeroLicence' => $objet->getNumeroLicence(),
                                'dateInscription' => $objet->getDateInscription(),
                                'id_Utilisateur' => $objet->getId_Utilisateur(),
                                'id_Adherent' => $objet->getId_Adherent(),
                               ));
    }

}
?>
