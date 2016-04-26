<?php
require_once "class_manager.php";
require_once $_SERVER["RACINE"]."/Core/class_palmares.php";

class ManagerPalmares extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un palmares dans la BDD
    public function add($objet)
    {
        if($objet->getIsEquipe()){
            $requete = $this->getDb()->prepare('INSERT INTO Palmares_Equipe (Id_Equipe,Classement,Id_Course) VALUES (:id_Equipe,:classement,:id_Course)');

            $requete->execute(array('id_Equipe' => $objet->getId_Equipe(),
                                    'classement' => $objet->getClassement(),
                                    'id_Course' => $objet->getId_Course(),
                                    ));
        }else{
            $requete = $this->getDb()->prepare('INSERT INTO Palmares_Competiteur (Id_Competiteur,Classement,Id_Course) VALUES (:id_Competiteur,:classement,:id_Course)');

            $requete->execute(array('id_Competiteur' => $objet->getId_Competiteur(),
                                    'classement' => $objet->getClassement(),
                                    'id_Course' => $objet->getId_Course(),
                                    ));
        }
    }



    //Suppression d'un palmares dans la BDD
    public function remove($objet)
    {
        if($objet->getIsEquipe()){
            $requete = $this->getDb()->prepare('DELETE FROM Palmares_Equipe WHERE Id_Equipe = :id_Equipe AND Id_Course = :id_Course');

            $requete->execute(array('id_Equipe' => $objet->getId_Equipe(),
                                    'id_Course' => $objet->getId_Course(),
                                    ));
        }else{
            $requete = $this->getDb()->prepare('DELETE FROM Palmares_Competiteur WHERE Id_Competiteur = :id_Competiteur AND Id_Course = :id_Course');

            $requete->execute(array('id_Competiteur' => $objet->getId_Competiteur(),
                                    'id_Course' => $objet->getId_Course(),
                                    ));
        }
    }


    //Fonction qui retourne un plamares en fonction de l'id de la course et du competiteur/equipe
    public function getId($id)
    {
        $requeteIsEquipe = $this->getDb()->query('SELECT Equipe FROM Course WHERE Id_Course = '.$id['Id_Course']);
        $donneIsEquipe = $requeteIsEquipe->fetch(PDO::FETCH_ASSOC);

        $donnees;

        if($donneIsEquipe['Equipe']){
            $requete = $this->getDb()->query('SELECT Id_Equipe, Classement, Id_Course  FROM Palamares_Equipe WHERE Id_Equipe = '.$id['Id_Equipe'].'AND Id_Course ='.$id['Id_Course']);
            $donnees = $requete->fetch(PDO::FETCH_ASSOC);

            $donnees['Id_Participant'] = $donnees['Id_Equipe'];
            unset($donnees['Id_Equipe']);
        }else{
            $requete = $this->getDb()->query('SELECT Id_Competiteur, Classement, Id_Course FROM Palamares_Competiteur WHERE Id_Competiteur = '.$id['Id_Competiteur'].'AND Id_Course ='.$id['Id_Course']);
            $donnees = $requete->fetch(PDO::FETCH_ASSOC);

            $donnees['Id_Participant'] = $donnees['Id_Competiteur'];
            unset($donnees['Id_Competiteur']);
        }

        $donnees['IsEquipe'] = $donneIsEquipe['Equipe'];

        return new Palmares($donnees);
    }

    //Fonction qui retourne la liste de tous les palamares présents dans la BDD
    public function getList()
    {
        $palmares = array();

        $requeteEquipe = $this->getDb()->query('SELECT Id_Course,Id_Equipe FROM Palamares_Equipe');

        $palmaresEquipe;
        while ($donneId = $requeteEquipe->fetch(PDO::FETCH_ASSOC))
        {
            $palmaresEquipe[] = $this->getId($donneId);
        }

        $requeteCompetiteur = $this->getDb()->query('SELECT Id_Course,Id_Competiteur FROM Palamares_Competiteur');

        $palmaresCompetiteur;
        while ($donneId = $requeteCompetiteur->fetch(PDO::FETCH_ASSOC))
        {
            $palmaresCompetiteur[] = $this->getId($donneId);
        }

        $palmares['Equipe'] = $palmaresEquipe;
        $palmares['Competiteur'] = $palmaresCompetiteur;

        return $palmares;
    }

    public function getListCompetiteur($id)
    {
        $palmares = array();

        $requeteCompetiteur = $this->getDb()->query('SELECT Id_Course,Id_Competiteur FROM Palamares_Competiteur WHERE Id_Competiteur = '.$id);

        while ($donneId = $requeteCompetiteur->fetch(PDO::FETCH_ASSOC))
        {
            $palmares[] = $this->getId($donneId);
        }

        return $palmares;
    }

    public function getListEquipe($id)
    {
        $palmares = array();

        $requeteEquipe = $this->getDb()->query('SELECT Id_Course,Id_Equipe FROM Palamares_Equipe WHERE Id_Equipe ='.$id);

        while ($donneId = $requeteEquipe->fetch(PDO::FETCH_ASSOC))
        {
            $palmares[] = $this->getId($donneId);
        }


        return $palmares;
    }

    //Procédure qui met à jour d'un palmares donné en paramètre dans la BDD
    public function update($objet)
    {
        if($objet->getIsEquipe()){
            $requete = $this->getDb()->prepare('UPDATE Palmares_Equipe SET Classement = :classement WHERE Id_Course =:idCourse AND Id_Equipe = :id_Equipe');

            $requete->execute(array('id_Equipe' => $objet->getId_Equipe(),
                                    'classement' => $objet->getClassement(),
                                    'id_Course' => $objet->getId_Course(),
                                    ));
        }else{
            $requete = $this->getDb()->prepare('UPDATE Palmares_Competiteur SET Classement = :classement WHERE Id_Course =:idCourse AND Id_Competiteur = :id_Competiteur');

            $requete->execute(array('id_Competiteur' => $objet->getId_Competiteur(),
                                    'classement' => $objet->getClassement(),
                                    'id_Course' => $objet->getId_Course(),
                                    ));
        }
    }

}
?>
