<?php
require_once "class_manager.php";
require_once "../class_course.php";

class ManagerCourse extends Manager{ // -- a modifier --

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
    }

    //Procédure qui ajoute une course dans la BDD
    public function add($objet)
    {
        $requeteId_Type_Spe = $this->getDb()->query('SELECT Id_Type_Specialite FROM Type_Specialite WHERE Nom = '.$objet->getTypeSpecialite());
        $donneId_Type_Spe = $requeteId_Type_Spe->fetch(PDO::FETCH_ASSOC);

        $requeteId_Categorie = $this->getDb()->query('SELECT Id_Categorie FROM Categorie WHERE Nom = '.$objet->getCategorie());
        $donneId_Categorie = $requeteId_Categorie->fetch(PDO::FETCH_ASSOC);

        $requete = $this->getDb()->prepare('INSERT INTO Course
        (Distance,Equipe,Id_Categorie,Id_Competition,Id_Type_Specialite) VALUES(:distance,:equipe,:id_Categorie,:id_Competition,:id_Type_Specialite)');

        $requete->execute(array('distance' => $objet->getDistance(),
                                'equipe' => $objet->getIsEquipe(),
                                'id_Categorie' => $donneId_Categorie['Id_Categorie'],
                                'id_Competition' => $objet->getId_Competition(),
                                'id_Type_Specialite' => $donneId_Type_Spe['Id_Type_Specialite'],
                               ));

        //Recupere l'id de la course genere par la base
        $requeteId_Course = $this->getDb()->prepare('SELECT Id_Course FROM Course WHERE Distance = :distance AND Equipe = :equipe AND Id_Categorie = :id_Categorie AND Id_Competition = :id_Competition AND Id_Type_Specialite = :id_Type_Specialite');

        $requeteId_Course->execute(array('distance' => $objet->getDistance(),
                                         'equipe' => $objet->getIsEquipe(),
                                         'id_Categorie' => $donneId_Categorie['Id_Categorie'],
                                         'id_Competition' => $objet->getId_Competition(),
                                         'id_Type_Specialite' => $donneId_Type_Spe['Id_Type_Specialite'],
                                        ));

        $donneId_Course = $requeteId_Course->fetch(PDO::FETCH_ASSOC);

        $objet->setId_Course($donneId_Course['Id_Course']);

    }

    //Suppression d'une Course dans la BDD
    public function remove($objet)
    {
        $this->removeParticipant($objet);

        $this->removePalmares($objet);

        $this->getDb()->exec('DELETE FROM Course WHERE Id_Course = '.$objet->getId_Course());

    }

    public function removeParticipant($objet)
    {
        if($objet->getIsEquipe()){
            $this->getDb()->exec('DELETE FROM Participant_Competition_Equipe WHERE Id_Course = '.$objet->getId_Course());
        }else{
            $this->getDb()->exec('DELETE FROM Participant_Competition_Solo WHERE Id_Course = '.$objet->getId_Course());
        }

    }

    public function removePalmares($objet){
        if($objet->getIsEquipe()){
            $this->getDb()->exec('DELETE FROM Palmares_Equipe WHERE Id_Course = '.$objet->getId_Course());
        }else{
            $this->getDb()->exec('DELETE FROM Palmares_Competiteur WHERE Id_Course = '.$objet->getId_Course());
        }
    }

    //Fonction qui retourne une course à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Course, Distance, Equipe, Id_Categorie, Id_Competition, Id_Type_Specialite, FROM Course WHERE Id_Course = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        //Recupere le nom de la categorie
        $requeteCat = $this->getDb()->query('SELECT Nom FROM Categorie WHERE Id_Categorie = '.$donnees['Id_Categorie']);
        $donneCat = $requeteCat->fetch(PDO::FETCH_ASSOC);

        #Recupere le type de la specialite
        $requeteType_Spe = $this->getDb()->query('SELECT Nom FROM Type_Specialite WHERE Id_Type_Specialite = '.$donnees['Id_Type_Specialite']);
        $donneType_Spe = $requeteType_Spe->fetch(PDO::FETCH_ASSOC);

        $donnees['Categorie'] = $donneCat['Nom'];
        $donnees['TypeSpecialite'] = $donneType_Spe['Nom'];
        $donnees['IsEquipe'] = $donnees['Equipe'];
        $donnees['Participant'] = $this->getParticipant($id,$donnees['Equipe'])

        unset($donnees['Id_Sexe']);
        unset($donnees['Id_Type_Specialite']);
        unset($donnees['Equipe']);

        return new Course($donnees);
    }

    public function getParticipant($id,$isEquipe){
        $participants;

        if($isEquipe){
            $requete = $this->getDb()->query('SELECT Id_Equipe,Validation FROM Participant_Competition_Equipe WHERE Id_Course = '.$id);
            $donne = $requete->fetch(PDO::FETCH_ASSOC);

            while ($donne = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $participant['Id'] = $donne['Id_Equipe'];
                $participant['Validation'] = $donne['Validation'];
                $participants[] = $participant;
            }
        }else{
            $requete = $this->getDb()->query('SELECT Id_Competiteur,Validation FROM Participant_Competition_Solo WHERE Id_Course = '.$id);

            while ($donne = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $participant['Id'] = $donne['Id_Competiteur'];
                $participant['Validation'] = $donne['Validation'];
                $participants[] = $participant;
            }

        }

        return $participants;
    }

    //Fonction qui retourne la liste de tous les courses présentes dans la BDD
    public function getList()
    {
        $courses= array();

        $requete = $this->getDb()->query('SELECT Id_Course FROM Course');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $courses[] = $this->getId($donneId['Id_Course']);
        }

        return $courses;
    }

    //Fonction qui retourne la liste de tous les courses d'une competition présentes dans la BDD
    public function getList_Competition($objet)
    {
        $courses= array();

        $requete = $this->getDb()->query('SELECT Id_Course FROM Course WHERE Id_Competition ='.$objet->getId_Competition());

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $courses[] = $this->getId($donneId['Id_Course']);
        }

        return $courses;
    }

    //Procédure qui met à jour une course donné en paramètre dans la BDD
    public function update($objet)
    {

        $requeteId_Type_Spe = $this->getDb()->query('SELECT Id_Type_Specialite FROM Type_Specialite WHERE Nom = '.$objet->getTypeSpecialite());
        $donneId_Type_Spe = $requeteId_Type_Spe->fetch(PDO::FETCH_ASSOC);

        $requeteId_Categorie = $this->getDb()->query('SELECT Id_Categorie FROM Categorie WHERE Nom = '.$objet->getCategorie());
        $donneId_Categorie = $requeteId_Categorie->fetch(PDO::FETCH_ASSOC);

        $requete = $this->getDb()->prepare('UPDATE Course SET Distance = :distance, Equipe = :equipe, Id_Categorie = :id_Categorie, Id_Competition = :id_Competition, Id_Type_Specialite = :id_Type_Specialite WHERE Id_Course = :id_Course');

        $requete->execute(array('distance' => $objet->getDistance(),
                                'equipe' => $objet->getIsEquipe(),
                                'id_Categorie' => $donneId_Categorie['Id_Categorie'],
                                'id_Competition' => $objet->getId_Competition(),
                                'id_Type_Specialite' => $donneId_Type_Spe['Id_Type_Specialite'],
                               ));
    }


}
?>
