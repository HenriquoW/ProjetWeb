<?php
require_once "class_manager.php";
require_once $_SERVER["RACINE"]."/Core/class_equipe.php";

class ManagerEquipe extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
    }

    //Procédure qui ajoute une equipe dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Equipe(Nom,Id_Type_Specialite) VALUES (:nom,:id_Type_Specialite)');

        $requete->execute(array('nom' => $objet->getNom(),
                                'id_Type_Specialite' => $objet->getTypeSpecialite()['Id'],
                               ));

        //Recupere l'id de l'equipe genere par la base
        $requeteId_Equipe = $this->getDb()->query('SELECT Id_Equipe FROM Equipe WHERE Nom = '.$objet->getNom());
        $donneId_Equipe = $requeteId_Equipe->fetch(PDO::FETCH_ASSOC);

        $objet->setId_Equipe($donneId_Equipe['Id_Equipe']);

    }

    public function addEquipeCourses($objet){
        $requeteCour = $this->getDb()->query('SELECT Id_Course FROM Participe_Competition_Equipe WHERE Id_Equipe = '.$objet->getId_Equipe());

        $donneCour = $requeteCour->fetchAll(PDO::FETCH_ASSOC);

        foreach($objet->getCourseParticipe() as $course){

            if(!in_array($donneCour['Id_Course'],$course['Id_Course'])){

                $requete = $this->getDb()->prepare('INSERT INTO Participe_Competition_Equipe (Id_Equipe,Id_Course,Validation) VALUES(:id_Equipe,:id_Course,:validation)');

                $requete->execute(array('id_Equipe' => $objet->getId_Equipe(),
                                        'id_Course' => $course['Id_Course'],
                                        'validation' => $course['Validation'],
                                       ));
            }
        }
    }

    // Function qui ajoute UNE Equipe a une course
    public function addEquipeCourse($IdCourse,$IdEquipe,$Validation){

        $requete = $this->getDb()->prepare('INSERT INTO Participe_Competition_Equipe (Id_Equipe,Id_Course,Validation) VALUES(:id_Equipe,:id_Course,:validation)');

        $requete->execute(array('id_Equipe' => $IdEquipe,
                                'id_Course' => $IdCourse,
                                'validation' => $Validation,
                                ));
    }


    //Suppression d'une equipe dans la BDD
    public function remove($objet){
        $this->removeMembre($objet);
        $this->removeEquipeCourses($objet);

        $this->getDb()->exec('DELETE FROM Equipe WHERE Id_Equipe = '.$objet->getId_Equipe());
    }

    public function removeMembre($objet){
        $this->getDb()->exec('DELETE FROM Participant_Equipe WHERE Id_Equipe = '.$objet->getId_Equipe());
    }

    // Function qui enleve UNE Equipe a une course
    public function removeEquipeCourse($IdCourse,$IdEquipe)
    {
        $this->getDb()->exec('DELETE FROM Participe_Competition_Equipe WHERE Id_Course = '.$IdCourse.' AND Id_Equipe = '.$IdEquipe);
    }

    // Function qui enleve toutes les course de l'equipe
    public function removeEquipeCourses($objet)
    {
        $this->getDb()->exec('DELETE FROM Participe_Competition_Equipe WHERE Id_Equipe = '.$objet->getId_Equipe());

    }

    //Fonction qui retourne une equipe à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Equipe, Nom, Id_Type_Specialite FROM Equipe WHERE Id_Equipe = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $donnees['Membre'] = $this->getMembre($id);
        $donnees['TypeSpecialite'] = $donnees['Id_Type_Specialite'];
        $donnees['CourseParticipe'] = $this->getEquipeCourse($id);

        unset($donnees['Id_Type_Specialite']);

        return new Equipe($donnees);
    }

    public function getNom($nom)
    {
        $requete = $this->getDb()->query('SELECT Id_Equipe FROM Equipe WHERE Nom = "'.$nom.'"');
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        return loadEquipe(array("Id"=>$donnees['Id_Equipe']));
    }

    public function getMembre($id){
        $membre;

        $requeteMembre = $this->getDb()->query('SELECT Id_Competiteur FROM Participant_Equipe WHERE Id_Equipe = '.$id);

        while ($donne = $requeteMembre->fetch(PDO::FETCH_ASSOC))
        {
            $membre[] = $donne['Id_Competiteur'];
        }

        return $membre;
    }

    public function getEquipeCourse($id){
        $courses;

        $requeteCourse = $this->getDb()->query('SELECT Id_Course,Validation FROM Participe_Competition_Equipe WHERE Id_Equipe = '.$id);

        while ($donne = $requeteCourse->fetch(PDO::FETCH_ASSOC))
        {
            $courses[] = $donne;
        }

        return $courses;
    }

    //Fonction qui retourne la liste de toutes les equipes présents dans la BDD
    public function getList(){

        $equipe = array();

        $requete = $this->getDb()->query('SELECT Id_Equipe FROM Equipe');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $equipe[] = loadEquipe(array("Id"=>$donneId['Id_Equipe']));
        }

        return $equipe;
    }

    public function getListSpecialite($specialite){

        $equipe = array();

        $requete = $this->getDb()->query('SELECT Id_Equipe FROM Equipe WHERE Id_Type_Specialite='.$specialite['Id']);

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $equipe[] = loadEquipe(array("Id"=>$donneId['Id_Equipe']));
        }

        return $equipe;
    }

    //Procédure qui met à jour une equipe donné en paramètre dans la BDD
    public function update($objet){

        $requete = $this->getDb()->prepare('UPDATE Equipe SET Nom = :nom, Id_Type_Specialite = :id_Type_Specialite WHERE Id_Equipe = :id_Equipe');

        $requete->execute(array('nom' => $objet->getNom(),
                                'id_Type_Specialite' => $objet->getTypeSpecialite()['Id'],
                                'id_Equipe' => $objet->getId_Equipe(),
                               ));
    }

    // met a jour toutes les courses de l'equipe
    public function updateEquipeCourse($objet){

        $this->removeEquipeCourses($objet);
        $this->addEquipeCourses($objet);
    }

    // valide ou invalide la participation de l'equipe a une course
    public function valideCourse($IdCourse,$IdEquipe,$Validation){

        $requete = $this->getDb()->prepare('UPDATE Participe_Competition_Equipe SET Validation =:validation WHERE Id_Equipe = :id_Equipe AND Id_Course = :id_Course');

        $requete->execute(array('validation' => $Validation,
                                'id_Equipe' => $IdEquipe,
                                'id_Course' => $IdCourse,
                               ));
    }

}
?>
