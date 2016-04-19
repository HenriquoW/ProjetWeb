<?php
require_once "class_manager.php";
require_once "../class_competition.php";

class ManagerCompetition extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
    }

    //Procédure qui ajoute une competition dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Competition
        (Adresse,DateCompetition,Id_Sexe,Id_Type_Competition,Id_Club_Organisateur) VALUES(:adresse,:dateCompetition,:id_Sexe,:id_Type_Competition,id_Club_Organisateur)');

        $requete->execute(array('adresse' => $objet->getAdresse(),
                                'dateCompetition' => $objet->getDateCompetition(),
                                'id_Sexe' => $objet->getSexe()['Id'],
                                'id_Type_Competition' => $objet->getTypeCompetition()['Id'],
                                'id_Club_Organisateur' => $objet->getClub()->getId_Club_Organisateur(),
                               ));

        //Recupere l'id de la competition genere par la base
        $requeteId_Competition = $this->getDb()->prepare('SELECT Id_Competition FROM Competition WHERE Adresse = :adresse AND DateCompetition = :dateCompetition AND Id_Sexe = :id_Sexe AND Id_Type_Competition = :id_Type_Competition AND Id_Club_Organisateur = :id_Club_Organisateur');

        $requeteId_Competition->execute(array('adresse' => $objet->getAdresse(),
                                              'dateCompetition' => $objet->getDateCompetition(),
                                              'id_Sexe' => $objet->getSexe()['Id'],
                                              'id_Type_Competition' => $objet->getTypeCompetition()['Id'],
                                              'id_Club_Organisateur' => $objet->getClub()->getId_Club_Organisateur(),
                                             ));

        $donneId_Competition = $requeteId_Competition->fetch(PDO::FETCH_ASSOC);

        $objet->setId_Competition($donneId_Competition['Id_Competition']);

    }

    //Suppression d'une Competition dans la BDD
    public function remove($objet)
    {
        $this->removeObjectif($objet->getId_Competition());

        $this->removeCourse($objet->getId_Competition());

        $this->removeVoyage($objet->getId_Competition());

        $this->getDb()->exec('DELETE FROM Competition WHERE Id_Competition = '.$objet->getId_Competition());
    }


    public function removeObjectif($IdCompetition){
        $this->getDb()->exec('DELETE FROM Objectif WHERE Id_Competition = '.$IdCompetition);
    }

    public function removeCourse($IdCompetition){
        $requeteCour = $this->getDb()->query('SELECT Id_Course FROM Course WHERE Id_Competition = '.$IdCompetition);

        while($donne = $requeteCour->fetch(PDO::FETCH_ASSOC)){
            $this->getDb()->exec('DELETE FROM Participe_Competition_Solo WHERE Id_Course = '.$donne['Id_Course']);

            $this->getDb()->exec('DELETE FROM Participe_Competition_Equipe WHERE Id_Course = '.$donne['Id_Course']);

            $this->getDb()->exec('DELETE FROM Palmares_Equipe WHERE Id_Course = '.$donne['Id_Course']);

            $this->getDb()->exec('DELETE FROM Palmares_Competiteur WHERE Id_Course = '.$donne['Id_Course']);

            $this->getDb()->exec('DELETE FROM Course WHERE Id_Course = '.$donne['Id_Course']);
        }

    }

    public function removeVoyage($IdCompetition){
        $requeteVoyage = $this->getDb()->query('SELECT Id_Voyage FROM Voyage WHERE Id_Competition = '.$IdCompetition);

        while($donne = $requeteCour->fetch(PDO::FETCH_ASSOC)){
            $this->getDb()->exec('DELETE FROM Participe_Voyage WHERE Id_Voyage = '.$donne['Id_Voyage']);

            $this->getDb()->exec('DELETE FROM Charger WHERE Id_Voyage = '.$donne['Id_Voyage']);

            $this->getDb()->exec('DELETE FROM Voyage WHERE Id_Course = '.$donne['Id_Voyage']);
        }
    }

    //Fonction qui retourne une Competition à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Competition, Adresse, DateCompetition, Id_Sexe, Id_Type_Competition, Id_Club_Organisateur FROM Competition WHERE Id_Competition = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $donnees['Sexe'] = $donnees['Id_Sexe'];
        $donnees['TypeCompetition'] = $donnees['Id_Type_Competition'];
        $donnees['Club'] = $donnees['Id_Club_Organisateur'];
        $donnees['Courses'] = $this->getCourses($id);

        unset($donnees['Id_Sexe']);
        unset($donnees['Id_Type_Competition']);
        unset($donnees['Id_Club_Organisateur']);

        return new Competition($donnees);
    }

    public function getCourses($id){
        $courses= array();

        $requete = $this->getDb()->query('SELECT Id_Course FROM Course WHERE Id_Competition ='.$id);

        while ($donne = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $courses[] = $donne['Id_Course'];
        }

        return $courses;
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

        $requete = $this->getDb()->prepare('UPDATE Competition SET Adresse = :adresse, DateCompetition = :dateCompetition, Id_Sexe = :id_Sexe, Id_Type_Competition = :id_Type_Competition, Id_Club_Organisateur = :id_Club_Organisateur WHERE Id_Competition = :id_Competition');

        $requete->execute(array('adresse' => $objet->getAdresse(),
                                'dateCompetition' => $objet->getDateCompetition(),
                                'id_Sexe' => $objet->getSexe()['Id'],
                                'id_Type_Competition' => $objet->getTypeCompetition()['Id'],
                                'id_Club_Organisateur' => $objet->getClub()->getId_Club_Organisateur(),
                                'id_Competition' => $objet->getId_Competition(),
                               ));
    }

}
?>
