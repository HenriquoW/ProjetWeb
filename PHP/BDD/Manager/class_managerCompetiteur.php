<?php
require_once "class_managerAdherent.php";
require_once "../class_competiteur.php";

class ManagerCompetiteur extends ManagerAdherent{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
    }

    //Procédure qui ajoute un Competiteur dans la BDD
    public function add($objet)
    {
        if($objet->getId_Adherent() == NULL){
            parent::add($objet);
        }else{
            parent::update($objet);
        }

        addObjectif($objet);

        $requeteId_Obj = $this->getDb()->query('SELECT Id_Objectif FROM Objectif WHERE Type = '.$objet->getObjectif());
        $donneId_Obj = $requeteId_Obj->fetch(PDO::FETCH_ASSOC);

        $requeteId_Specialite = $this->getDb()->query('SELECT Id_Specialite FROM Specialite WHERE Nom = '.$objet->getSpecialite());
        $donneId_Specialite = $requeteId_Specialite->fetch(PDO::FETCH_ASSOC);

        $requeteId_Categorie = $this->getDb()->query('SELECT Id_Categorie FROM Categorie WHERE Nom = '.$objet->getCategorie());
        $donneId_Categorie = $requeteId_Categorie->fetch(PDO::FETCH_ASSOC);

        $requete = $this->getDb()->prepare('INSERT INTO Competiteur (Id_Adherent,Id_Specialite,Id_Objectif,Id_Categorie) VALUES(:id_Adherent,:id_Specialite,:id_Objectif,:id_Categorie)');

        $requete->execute(array('id_Adherent' => $objet->getId_Adherent(),
                                'id_Specialite' => $donneId_Specialite['Id_Specialite'],
                                'id_Objectif' => $donneId_Obj['Id_Objectif'],
                                'id_Categorie' => $donneId_Categorie['Id_Categorie'],
                               ));

        //Recupere l'id du competiteur genere par la base
        $requeteId_Competiteur = $this->getDb()->query('SELECT Id_Competiteur FROM Competiteur WHERE Id_Adherent = '.$objet->getId_Adherent());
        $donneId_Competiteur = $requeteId_Competiteur->fetch(PDO::FETCH_ASSOC);

        $objet->setId_Competiteur($donneId_Competiteur['Id_Competiteur']);

    }

    //Ajoute les objectifs de l'Competiteur
    public function addObjectif($objet){
        //on recupere l'objectif du Competiteur deja dans la base
        $requeteId_Obj = $this->getDb()->query('SELECT Id_Objectif FROM Objectif WHERE Type = '.$objet->getObjectif());
        $donneId_Obj = $requeteId_Obj->fetch(PDO::FETCH_ASSOC);

        if($donneId_Obj['Id_Objectif'] == null){
            $requete = $this->getDb()->prepare('INSERT INTO Objectif (Type) VALUES(:type)');

            $requete->execute(array('type' => $objet->getObjectif(),
                                    ));
        }


    }

    //Suppression d'un Competiteur dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Competiteur WHERE Id_Competiteur = '.$objet->getId_Competiteur());

        $this->removeObjectif($objet);
    }

    //Suppression de tous les droits de l'Competiteur
    public function removeObjectif($objet){
        $requeteId_Obj = $this->getDb()->query('SELECT Id_Objectif FROM Competiteur WHERE Id_Competiteur = '.$objet->getId_Competiteur());
        $donneId_Obj = $requeteId_Obj->fetch(PDO::FETCH_ASSOC);

        $this->getDb()->exec('DELETE FROM Objectif WHERE Id_Objectif = '.$donneId_Obj['Id_Objectif']);
    }

    //Fonction qui retourne un Competiteur à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Competiteur, Id_Adherent, Id_Specialite, Id_Objectif, Id_Categorie FROM Competiteur WHERE Id_Competiteur = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $user = parent::getId($donnees['Id_Adherent']);

        unset($donnees['Id_Adherent']);

        //Recupere le nom de la specialite du competiteur
        $requeteNom_Spe = $this->getDb()->query('SELECT Nom FROM Specialite WHERE Id_Specialite = '.$donnees['Id_Specialite']);
        $donneNom_Spe = $requeteNom_Spe->fetch(PDO::FETCH_ASSOC);

        $requeteType_Obj = $this->getDb()->query('SELECT Type FROM Objectif WHERE Id_Objectif = '.$donnees['Id_Objectif']);
        $donneType_Obj = $requeteType_Obj->fetch(PDO::FETCH_ASSOC);

        $requeteNom_Cat = $this->getDb()->query('SELECT Nom FROM Categorie WHERE Id_Categorie = '.$donnees['Id_Categorie']);
        $donneNom_Cat = $requeteNom_Cat->fetch(PDO::FETCH_ASSOC);

        $donnees['Id_Specialite'] = $donneNom_Spe['Specialite'];
        $donnees['Id_Objectif'] = $donneType_Obj['Objectif'];
        $donnees['Id_Categorie'] = $donneNom_Cat['Categorie'];

        unset($donnees['Id_Specialite']);
        unset($donnees['Id_Objectif']);
        unset($donnees['Id_Categorie']);

        return new Competiteur($user,$donnees);
    }

    public function getMail($mail){
        $requeteId = $this->getDb()->query('SELECT Id_Competiteur FROM Competiteur JOIN Adherent ON Competiteur.Id_Adherent = Adherent.Id_Adherent JOIN Utilisateur ON Adherent.Id_Utilisateur = Utilisateur.Id_Utilisateur WHERE Utilisateur.Mail = '.$mail);
        $donneId = $requeteId->fetch(PDO::FETCH_ASSOC);

        return $this->getId($donneId['Id_Competiteur']);
    }

    //Fonction qui retourne la liste de tous les Competiteur présents dans la BDD
    public function getList()
    {
        $competiteurs = array();

        $requete = $this->getDb()->query('SELECT Id_Competiteur FROM Competiteur');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $competiteurs[] = $this->getId($donneId['Id_Competiteur']);
        }

        return $competiteurs;
    }

    //Procédure qui met à jour un Adherent donné en paramètre dans la BDD
    public function update($objet)
    {
        if($objet->getId_Adherent() == NULL){
            parent::add($objet);
        }else{
            parent::update($objet);
        }

        $this->addObjectif($objet);

        $requeteId_Obj = $this->getDb()->query('SELECT Id_Objectif FROM Objectif WHERE Type = '.$objet->getObjectif());
        $donneId_Obj = $requeteId_Obj->fetch(PDO::FETCH_ASSOC);

        $requeteId_Specialite = $this->getDb()->query('SELECT Id_Specialite FROM Specialite WHERE Nom = '.$objet->getSpecialite());
        $donneId_Specialite = $requeteId_Specialite->fetch(PDO::FETCH_ASSOC);

        $requeteId_Categorie = $this->getDb()->query('SELECT Id_Categorie FROM Categorie WHERE Nom = '.$objet->getCategorie());
        $donneId_Categorie = $requeteId_Categorie->fetch(PDO::FETCH_ASSOC);

        $requete = $this->getDb()->prepare('UPDATE Competiteur SET Id_Adherent = :id_Adherent, Id_Specialite = :id_Specialite, Id_Objectif = :id_Objectif, Id_Categorie = :id_Categorie WHERE Id_Competiteur = :id_Competiteur');

        $requete->execute(array('id_Adherent' => $objet->getId_Adherent(),
                                'id_Specialite' => $donneId_Specialite['Id_Specialite'],
                                'id_Objectif' => $donneId_Obj['Id_Objectif'],
                                'id_Categorie' => $donneId_Categorie['Id_Categorie'],
                                'id_Competiteur' => $objet->getId_Competiteur(),
                               ));
    }

}
?>
