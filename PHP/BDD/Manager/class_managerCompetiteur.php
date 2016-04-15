<?php
require_once "class_managerAdherent.php";
require_once "../class_Competiteur.php";

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

        $requete = $this->getDb()->prepare('INSERT INTO Competiteur (Photo,Id_Adherent,Id_Specialite,Id_Categorie) VALUES(:photo,:id_Adherent,:id_Specialite,:id_Categorie)');

        $requete->execute(array('photo' => $objet->getPhoto(),
                                'id_Adherent' => $objet->getId_Adherent(),
                                'id_Specialite' => $objet->getSpecialite()['Id'],
                                'id_Categorie' => $objet->getCategorie()['Id'],
                               ));

        $this->addObjectifs($objet);

        $this->addCompetiteurCourses($objet);

        $this->addCompetiteurEquipes($objet);

        $this->addCompetiteurVoyages($objet);

        //Recupere l'id du competiteur genere par la base
        $requeteId_Competiteur = $this->getDb()->query('SELECT Id_Competiteur FROM Competiteur WHERE Id_Adherent = '.$objet->getId_Adherent());
        $donneId_Competiteur = $requeteId_Competiteur->fetch(PDO::FETCH_ASSOC);

        $objet->setId_Competiteur($donneId_Competiteur['Id_Competiteur']);

    }

    //Ajoute les objectifs du Competiteur
    public function addObjectifs($objet){

        //on recupere les id des competition du Competiteur deja dans la base
        $requeteId_Comp = $this->getDb()->query('SELECT Id_Competition FROM Objectif WHERE Id_Competiteur = '.$objet->getId_Competiteur());

        $donneComp = array();
        while ($donne = $requeteId_Comp->fetch(PDO::FETCH_ASSOC))
        {
            $donneComp[] = $donne;
        }

        foreach($objet->getObjectif() as $objectif){

            if(!in_array($donneComp['Id_Competition'],$objectif)){
                $requete = $this->getDb()->prepare('INSERT INTO Objectif (Id_Competiteur,Id_Competition) VALUES(:id_Competiteur,:id_Competition)');

                $requete->execute(array('id_Competiteur' => $objet->getId_Competiteur(),
                                        'id_Competition' => $objectif,
                                       ));
            }

        }
    }

    // Ajoute un objectif au competiteur
    public function addObjectif($IdCompetiteur,$IdCompetition){
        $requete = $this->getDb()->prepare('INSERT INTO Objectif (Id_Competiteur,Id_Competition) VALUES(:id_Competiteur,:id_Competition)');

        $requete->execute(array('id_Competiteur' => $IdCompetiteur,
                                'id_Competition' => $IdCompetition,
                               ));
    }

    //Ajoute les courses du Competiteur
    public function addCompetiteurCourses($objet){

        $requeteId_Cour = $this->getDb()->query('SELECT Id_Course FROM Participant_Competition_Solo WHERE Id_Competiteur = '.$objet->getId_Competiteur());

        $donneCour = array();
        while ($donne = $requeteId_Cour->fetch(PDO::FETCH_ASSOC))
        {
            $donneCour[] = $donne;
        }


        foreach($objet->getCourseParticipe() as $course){
            if(!in_array($donneCour['Id_Course'],$course['Id_Course'])){

                $requete = $this->getDb()->prepare('INSERT INTO Participant_Competition_Solo (Id_Competiteur,Id_Course,Validation) VALUES(:id_Competiteur,:id_Course,:validation)');

                $requete->execute(array('id_Competiteur' => $objet->getId_Competiteur(),
                                        'id_Course' => $course['Id_Course'],
                                        'validation' => $course['Validation'],
                                       ));
            }
        }

    }

    //Ajoute une course au competiteur
    public function addCompetiteurCourse($IdCompetiteur,$IdCourse){

        $requete = $this->getDb()->prepare('INSERT INTO Participant_Competition_Solo (Id_Competiteur,Id_Course,Validation) VALUES(:id_Competiteur,:id_Course,:validation)');

        $requete->execute(array('id_Competiteur' => $IdCompetiteur,
                                'id_Course' => $IdCourse,
                                'validation' => false,
                               ));
    }

    //Ajoute les equipes du Competiteur
    public function addCompetiteurEquipes($objet){

        $requeteId_Equipe = $this->getDb()->query('SELECT Id_Equipe FROM Participant_Equipe WHERE Id_Competiteur = '.$objet->getId_Competiteur());

        $donneEquipe = array();
        while ($donne = $requeteId_Equipe->fetch(PDO::FETCH_ASSOC))
        {
            $donneEquipe[] = $donne;
        }


        foreach($objet->getEquipeParticipe() as $equipe){
            if(!in_array($donneEquipe['Id_Equipe'],$equipe)){

                $requete = $this->getDb()->prepare('INSERT INTO Participant_Equipe (Id_Equipe,Id_Competiteur) VALUES(:id_Equipe,:id_Competiteur)');

                $requete->execute(array('id_Competiteur' => $objet->getId_Competiteur(),
                                        'id_Equipe' => $equipe,
                                       ));
            }
        }

    }

    //Ajoute une equipe au competiteur
    public function addCompetiteurEquipe($IdCompetiteur,$IdEquipe){
        $requete = $this->getDb()->prepare('INSERT INTO Participant_Equipe (Id_Equipe,Id_Competiteur) VALUES(:id_Equipe,:id_Competiteur)');

        $requete->execute(array('id_Competiteur' => $IdCompetiteur,
                                'id_Equipe' => $IdEquipe,
                               ));
    }

    //ajoute tous les voyages du competiteur
    public function addCompetiteurVoyages($objet){
        $requeteVoyage = $this->getDb()->query('SELECT Id_Voyage FROM Participe_Voyage WHERE Id_Competiteur = '.$objet->getId_Competiteur());

        $donneVoyage = $requeteVoyage->fetchAll(PDO::FETCH_ASSOC);

        foreach($objet->getVoyageParticipe() as $voyage){
            if(!in_array($donneVoyage['Id_Voyage'],$voyage['Id_Voyage'])){

                $requete = $this->getDb()->prepare('INSERT INTO Participe_Voyage (Id_Voyage,Id_Competiteur,Autoriser,Id_Type_Voyage,Id_Utilisateur) VALUES(:id_Voyage,:id_Competiteur,:autoriser,:id_Type_Voyage,:id_Utilisateur)');

                $requete->execute(array('id_Voyage' => $voyage['Id_Voyage'],
                                        'id_Competiteur' => $objet->getId_Competiteur(),
                                        'autoriser' => $voyage['Autoriser'],
                                        'id_Type_Voyage' => $voyage['Type_Voyage']['Id'],
                                        'id_Utilisateur' => $voyage['Id_Utilisateur'],
                                       ));
            }
        }
    }

    //ajoute un voyage a un competiteur
    public function addCompetiteurVoyage($IdVoyage,$IdCompetiteur,$Validation,$Type,$IdUtilisateur){
        $requete = $this->getDb()->prepare('INSERT INTO Participe_Voyage (Id_Voyage,Id_Competiteur,Autoriser,Id_Type_Voyage,Id_Utilisateur) VALUES(:id_Voyage,:id_Competiteur,:autoriser,:id_Type_Voyage,:id_Utilisateur)');

        $requete->execute(array('id_Voyage' => $IdVoyage,
                                'id_Competiteur' => $IdCompetiteur,
                                'autoriser' => $Validation,
                                'id_Type_Voyage' => $Type['Id'],
                                'id_Utilisateur' => $IdUtilisateur,
                               ));
    }

    //Suppression d'un Competiteur dans la BDD
    public function remove($objet)
    {
        $this->removeObjectifs($objet->getId_Competiteur());
        $this->removeCompetiteurCourses($objet->getId_Competiteur());
        $this->removeCompetiteurEquipe($objet->getId_Competiteur());
        $this->removeCompetiteurVoyages($objet->getId_Competiteur());

        $this->getDb()->exec('DELETE FROM Competiteur WHERE Id_Competiteur = '.$objet->getId_Competiteur());
    }

    //Suppression d'un objectif du Competiteur
    public function removeObjectif($IdCompetiteur,$IdCompetition){
        $this->getDb()->exec('DELETE FROM Objectif WHERE Id_Competition = '.$IdCompetition.' AND Id_Competiteur ='.$IdCompetiteur);
    }

    //Suppression de tous les objectif du Competiteur
    public function removeObjectifs($IdCompetiteur){
        $this->getDb()->exec('DELETE FROM Objectif WHERE Id_Competiteur = '.$IdCompetiteur);
    }

    // Function qui enleve le competiteur d'une course
    public function removeCompetiteurCourse($IdCompetiteur,$IdCourse)
    {
        $this->getDb()->exec('DELETE FROM Participant_Competition_Solo WHERE Id_Course = '.$IdCourse.' AND Id_Competiteur ='.$IdCompetiteur);

    }

    // Function qui enleve le competiteur de toutes les courses
    public function removeCompetiteurCourses($IdCompetiteur)
    {
        $this->getDb()->exec('DELETE FROM Participant_Competition_Solo WHERE Id_Competiteur ='.$IdCompetiteur);

    }

    // Function qui enleve le competiteur d'une equipe
    public function removeCompetiteurEquipe($IdCompetiteur,$IdEquipe)
    {
        $this->getDb()->exec('DELETE FROM Participant_Equipe WHERE Id_Equipe = '.$IdEquipe.' AND Id_Competiteur ='.$IdCompetiteur);

    }

    // Function qui enleve le competiteur de toutes les equipe
    public function removeCompetiteurEquipes($IdCompetiteur)
    {
        $this->getDb()->exec('DELETE FROM Participant_Equipe WHERE Id_Competiteur ='.$IdCompetiteur);

    }

    // Function qui enleve le competiteur d'un voyage
    public function removeCompetiteurVoyage($IdCompetiteur,$IdVoyage){
        $this->getDb()->exec('DELETE FROM Participe_Voyage WHERE Id_Voyage = '.$IdVoyage.' AND Id_Competiteur ='.$IdCompetiteur);
    }

    // Function qui enleve le competiteur de toutes les voyages
    public function removeCompetiteurVoyages($IdCompetiteur){
        $this->getDb()->exec('DELETE FROM Participant_Equipe WHERE Id_Competiteur ='.$IdCompetiteur);
    }

    //Fonction qui retourne un Competiteur à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Competiteur, Photo, Id_Adherent, Id_Specialite, Id_Categorie FROM Competiteur WHERE Id_Competiteur = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $user = parent::getId($donnees['Id_Adherent']);

        unset($donnees['Id_Adherent']);

        $donnees['Specialite'] = $donnees['Id_Specialite'];
        $donnees['Categorie'] = $donnees['Id_Categorie'];
        $donnees['Objectif'] = $this->getObjectif($id);
        $donnees['CourseParticipe'] = $this->getCompetiteurCourse($id);
        $donnees['EquipeParticipe'] = $this->getCompetiteurEquipe($id);
        $donnees['VoyageParticipe'] = $this->getCompetiteurVoyage($id);

        unset($donnees['Id_Specialite']);
        unset($donnees['Id_Categorie']);

        return new Competiteur($user,$donnees);
    }

    public function getObjectif($id){
        $objectifs;

        $requeteObjectif = $this->getDb()->query('SELECT Id_Competition FROM Objectif WHERE Id_Competiteur = '.$id);

        while ($donne = $requeteObjectif->fetch(PDO::FETCH_ASSOC))
        {
            $objectifs[] = $donne['Id_Competition'];
        }

        return $objectifs;
    }

    public function getCompetiteurCourse($id){
        $courses;

        $requeteCourse = $this->getDb()->query('SELECT Id_Course,Validation FROM Participant_Competition_Solo WHERE Id_Competiteur = '.$id);

        while ($donne = $requeteCourse->fetch(PDO::FETCH_ASSOC))
        {
            $courses[] = $donne;
        }

        return $courses;
    }

    public function getCompetiteurVoyage($id){
        $voyages;

        $requeteVoyage= $this->getDb()->query('SELECT Id_Voyage,Id_Competiteur,Autoriser,Id_Type_Voyage,Id_Utilisateur FROM Participe_Voyage WHERE Id_Competiteur = '.$id);

        while ($donne = $requeteVoyage->fetch(PDO::FETCH_ASSOC))
        {
            $donne['Type_Voyage'] = $donne['Id_Type_Voyage'];
            unset($donne['Id_Type_Voyage']);

            $voyages[] = $donne;
        }

        return $voyages;
    }

    public function getCompetiteurEquipe($id){
        $equipes;

        $requeteEquipe = $this->getDb()->query('SELECT Id_Equipe FROM Participant_Equipe WHERE Id_Competiteur = '.$id);

        while ($donne = $requeteEquipe->fetch(PDO::FETCH_ASSOC))
        {
            $equipes[] = $donne['Id_Equipe'];
        }

        return $equipes;
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

    //Procédure qui met à jour un Competiteur donné en paramètre dans la BDD
    public function update($objet)
    {
        if($objet->getId_Adherent() == NULL){
            parent::add($objet);
        }else{
            parent::update($objet);
        }

        $requete = $this->getDb()->prepare('UPDATE Competiteur SET Photo =:photo, Id_Adherent = :id_Adherent, Id_Specialite = :id_Specialite, Id_Categorie = :id_Categorie WHERE Id_Competiteur = :id_Competiteur');

        $requete->execute(array('photo' => $objet->getPhoto(),
                                'id_Adherent' => $objet->getId_Adherent(),
                                'id_Specialite' => $objet->getSpecialite()['Id'],
                                'id_Categorie' => $objet->getCategorie()['Id'],
                                'id_Competiteur' => $objet->getId_Competiteur(),
                               ));
    }

    // met a jour tous les objectif du competiteur
    public function updateObjectif($objet){

        this->removeObjectif($objet->getId_Competiteur());
        this->addObjectif($objet);
    }

    // met a jour toutes les courses du competiteur
    public function updateCompetiteurCourse($objet){

        this->removeCompetiteurCourses($objet->getId_Competiteur());
        this->addCompetiteurCourse($objet);
    }

    // valide ou invalide la participation du competiteur a une course
    public function ValideCourse($IdCourse,$IdCompetiteur,$Validation){

        $requete = $this->getDb()->prepare('UPDATE Participant_Competition_Solo SET Validation =:validation WHERE Id_Competiteur = :id_Competiteur AND Id_Course = :id_Course');

        $requete->execute(array('validation' => $Validation,
                                'id_Competiteur' => $IdCompetiteur,
                                'id_Course' => $IdCourse,
                               ));
    }

    // valide ou invalide la participation du competiteur a un voyage
    public function ValideVoyage($IdVoyage,$IdCompetiteur,$Validation){
        $requete = $this->getDb()->prepare('UPDATE Participe_Voyage SET Autoriser =:autoriser WHERE Id_Competiteur = :id_Competiteur AND Id_Voyage = :id_Voyage');

        $requete->execute(array('autoriser' => $Validation,
                                'id_Competiteur' => $IdCompetiteur,
                                'id_Voyage' => $IdVoyage,
                               ));
    }

}
?>
