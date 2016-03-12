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

        $requeteId_Type_Comp = $this->getDb()->query('SELECT Id_Type_Competition FROM Objectif WHERE Nom = '.$objet->getType_Competition());
        $donneId_Type_Comp = $requeteId_Type_Comp->fetch(PDO::FETCH_ASSOC);

        $requeteId_Club = $this->getDb()->query('SELECT Id_Club_Organisateur FROM Club_Organisateur WHERE Nom = '.$objet->getClub());
        $donneId_Club = $requeteId_Club->fetch(PDO::FETCH_ASSOC);

        $requete = $this->getDb()->prepare('INSERT INTO Competition
        (Adresse,DateCompetition,Id_Sexe,Id_Type_Competition,Id_Club_Organisateur) VALUES(:adresse,:dateCompetition,:id_Sexe,:id_Type_Competition,id_Club_Organisateur)');

        $requete->execute(array('adresse' => $objet->getAdresse(),
                                'dateCompetition' => $objet->getDateCompetition(),
                                'id_Sexe' => $donneId_Sexe['Id_Sexe'],
                                'id_Type_Competition' => $donneId_Type_Comp['Id_Type_Competition'],
                                'id_Club_Organisateur' => $donneId_Club['Id_Club_Organisateur'],
                               ));

        //Recupere l'id de la competition genere par la base
        $requeteId_Competition = $this->getDb()->prepare('SELECT Id_Competition FROM Competition WHERE Adresse = :adresse AND DateCompetition = :dateCompetition AND Id_Sexe = :id_Sexe AND Id_Type_Competition = :id_Type_Competition AND Id_Club_Organisateur = :id_Club_Organisateur';

        $requeteId_Competition->execute(array('adresse' => $objet->getAdresse(),
                                                'dateCompetition' => $objet->getDateCompetition(),
                                                'id_Sexe' => $donneId_Sexe['Id_Sexe'],
                                                'id_Type_Competition' => $donneId_Type_Comp['Id_Type_Competition'],
                                                'id_Club_Organisateur' => $donneId_Club['Id_Club_Organisateur'],
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
        $requete = $this->getDb()->query('SELECT Id_Competition, Adresse, DateCompetition, Id_Sexe, Id_Type_Competition, Id_Club_Organisateur FROM Competition WHERE Id_Competition = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        //Recupere le type du sexe
        $requeteType_Sexe = $this->getDb()->query('SELECT Type FROM Sexe WHERE Id_Sexe = '.$donnees['Id_Sexe']);
        $donneType_Sexe = $requeteType_Sexe->fetch(PDO::FETCH_ASSOC);

        #Recupere le type de la competition
        $requeteType_Comp = $this->getDb()->query('SELECT Nom FROM Type_Competition WHERE Id_Type_Competition = '.$donnees['Id_Type_Competition']);
        $donneType_Comp = $requeteType_Comp->fetch(PDO::FETCH_ASSOC);

         $requete_Club = $this->getDb()->query('SELECT Nom FROM Club_Organisateur WHERE Id_Club_Organisateur = '.$donnees['Id_Club_Organisateur']);
        $donne_Club = $requete_Club->fetch(PDO::FETCH_ASSOC);

        $donnees['Sexe'] = $donneType_Sexe['Type'];
        $donnees['Type_Competition'] = $donneType_Comp['Nom'];
        $donnees['Club'] = $donne_Club['Nom'];

        unset($donnees['Id_Sexe']);
        unset($donnees['Id_Type_Competition']);
        unset($donnees['Id_Club_Organisateur']);

        return new Competition($donnees);
    }

    //Fonction qui retourne la liste de tous les competitions présentes dans la BDD
    public function getList()
    {
        $competitions= array();

        $requete = $this->getDb()->query('SELECT Id_Competition FROM Competition');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $competitions[] = $this->getId($donneId['Id_Competiteur']);
        }

        return $competitions;
    }

    //Procédure qui met à jour une competition donné en paramètre dans la BDD
    public function update($objet)
    {

        $requeteId_Sexe = $this->getDb()->query('SELECT Id_Sexe FROM Sexe WHERE Type = '.$objet->getSexe());
        $donneId_Sexe = $requeteId_Sexe->fetch(PDO::FETCH_ASSOC);

        $requeteId_Type_Comp = $this->getDb()->query('SELECT Id_Type_Competition FROM Objectif WHERE Nom = '.$objet->getType_Competition());
        $donneId_Type_Comp = $requeteId_Type_Comp->fetch(PDO::FETCH_ASSOC);

        $requeteId_Club = $this->getDb()->query('SELECT Id_Club_Organisateur FROM Club_Organisateur WHERE Nom = '.$objet->getClub());
        $donneId_Club = $requeteId_Club->fetch(PDO::FETCH_ASSOC);

        $requete = $this->getDb()->prepare('UPDATE Competition SET Adresse = :adresse, DateCompetition = :dateCompetition, Id_Sexe = :id_Sexe, Id_Type_Competition = :id_Type_Competition, Id_Club_Organisateur = :id_Club_Organisateur WHERE Id_Competition = :id_Competition');

        $requete->execute(array('adresse' => $objet->getAdresse(),
                                'dateCompetition' => $objet->getDateCompetition(),
                                'id_Sexe' => $donneId_Sexe['Id_Sexe'],
                                'id_Type_Competition' => $donneId_Type_Comp['Id_Type_Competition'],
                                'id_Club_Organisateur' => $donneId_Club['Id_Club_Organisateur'],
                                'id_Competition' => $objet->getId_Competition(),
                               ));
    }

}
?>
