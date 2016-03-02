<?php
require_once "class_manager.php";
require_once "../class_competition.php";

class ManagerCompetition extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
    }

    //Procédure qui ajoute un Competiteur dans la BDD
    public function add($objet)
    {
        $requeteId_Sexe = $this->getDb()->query('SELECT Id_Sexe FROM Sexe WHERE Type = '.$objet->getSexe());
        $donneId_Sexe = $requeteId_Sexe->fetch(PDO::FETCH_ASSOC);

        $requeteId_Type_Comp = $this->getDb()->query('SELECT Id_Type_Competition FROM Objectif WHERE Nom = '.$objet->getType_Competition);
        $donneId_Type_Comp = $requeteId_Type_Comp->fetch(PDO::FETCH_ASSOC);

        $requeteId_Categorie = $this->getDb()->query('SELECT Id_Categorie FROM Categorie WHERE Nom = '.$objet->getCategorie());
        $donneId_Categorie = $requeteId_Categorie->fetch(PDO::FETCH_ASSOC);

        $requeteId_Type_Specialite = $this->getDb()->query('SELECT Id_Type_Specialite FROM Type_Specialite WHERE Nom = '.$objet->getType_Specialite());
        $donneId_Type_Specialite = $requeteId_Type_Specialite->fetch(PDO::FETCH_ASSOC);

        $requeteId_Club = $this->getDb()->query('SELECT Id_Club_Organisateur FROM Club_Organisateur WHERE Nom = '.$objet->getClub());
        $donneId_Club = $requeteId_Club->fetch(PDO::FETCH_ASSOC);

        $requete = $this->getDb()->prepare('INSERT INTO Competition
        (Adresse,DateCompetition,Id_Sexe,Id_Type_Competition,Id_Categorie,Id_Type_Specialite,Id_Club_Organisateur) VALUES(:adresse,:dateCompetition,:id_Sexe,:id_Type_Competition,id_Categorie,id_Type_Specialite,id_Club_Organisateur)');

        $requete->execute(array('adresse' => $objet->getAdresse(),
                                'dateCompetition' => $objet->getDate(),
                                'id_Sexe' => $donneId_Sexe['Id_Sexe'],
                                'id_Type_Competition' => $donneId_Type_Comp['Id_Type_Competition'],
                                'id_Categorie' => $donneId_Categorie['Id_Categorie'],
                                'id_Type_Specialite' => $donneId_Type_Specialite['Id_Type_Specialite'],
                                'id_Club_Organisateur' => $donneId_Club['Id_Club_Organisateur'],
                               ));

        //Recupere l'id de la competition genere par la base
        $requeteId_Competition = $this->getDb()->prepare('SELECT Id_Competition FROM Competition WHERE Adresse = :adresse AND DateCompetition = :dateCompetition AND Id_Sexe = :id_Sexe AND Id_Type_Competition = :id_Type_Competition AND Id_Categorie = :id_Categorie AND Id_Type_Specialite = :id_Type_Specialite AND Id_Club_Organisateur = :id_Club_Organisateur';

        $requeteId_Competition->execute(array('adresse' => $objet->getId_Adherent(),
                                'dateCompetition' => $donneId_Specialite['Id_Specialite'],
                                'id_Sexe' => $donneId_Obj['Id_Objectif'],
                                'id_Type_Competition' => $donneId_Categorie['Id_Categorie'],
                                'id_Categorie' => $donneId_Categorie['Id_Categorie'],
                                'id_Type_Specialite' => $donneId_Categorie['Id_Categorie'],
                                'id_Club_Organisateur' => $donneId_Categorie['Id_Categorie'],
                               ));

        $donneId_Competition = $requeteId_Competition->fetch(PDO::FETCH_ASSOC);

        $objet->setId_Competition($donneId_Competition['Id_Competition']);

    }

    //Suppression d'une Competition dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Competition WHERE Id_Competition = '.$objet->getId_Competition());

        $this->removeObjectif($objet);
    }

    //Fonction qui retourne une Competition à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Competition, Adresse, DateCompetition, Id_Sexe, Id_Type_Competition, Id_Categorie, Id_Type_Specialite, Id_Club_Organisateur FROM Competition WHERE Id_Competition = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        //Recupere le type du sexe
        $requeteType_Sexe = $this->getDb()->query('SELECT Type FROM Sexe WHERE Id_Sexe = '.$donnees['Id_Sexe']);
        $donneType_Sexe = $requeteType_Sexe->fetch(PDO::FETCH_ASSOC);

        #Recupere le type de la competition
        $requeteType_Comp = $this->getDb()->query('SELECT Nom FROM Type_Competition WHERE Id_Type_Competition = '.$donnees['Id_Type_Competition']);
        $donneType_Comp = $requeteType_Comp->fetch(PDO::FETCH_ASSOC);

        $requeteNom_Cat = $this->getDb()->query('SELECT Nom FROM Categorie WHERE Id_Categorie = '.$donnees['Id_Categorie']);
        $donneNom_Cat = $requeteNom_Cat->fetch(PDO::FETCH_ASSOC);

        #Recupere le type de la specialite
        $requeteType_Spe = $this->getDb()->query('SELECT Nom FROM Type_Specialite WHERE Id_Type_Specialite = '.$donnees['Id_Type_Specialite']);
        $donneType_Spe = $requeteType_Spe->fetch(PDO::FETCH_ASSOC);

        $requeteNom_Spe = $this->getDb()->query('SELECT Nom FROM Specialite WHERE Id_Specialite = '.$donnees['Id_Specialite']);
        $donneNom_Spe = $requeteNom_Spe->fetch(PDO::FETCH_ASSOC);

        $donnees['Sexe'] = $donneType_Sexe['Type'];
        $donnees['Id_Specialite'] = $donneNom_Spe['Specialite'];
        $donnees['Id_Objectif'] = $donneType_Obj['Objectif'];
        $donnees['Id_Categorie'] = $donneNom_Cat['Categorie'];

        unset($donnees['Id_Sexe']);
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
