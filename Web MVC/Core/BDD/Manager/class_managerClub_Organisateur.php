<?php
require_once "class_manager.php";
require_once $_SERVER["RACINE"]."/Core/class_club_Organisateur.php";

class ManagerClub_Organisateur extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un club_organisateur dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Club_Organisateur (Id_Club_Organisateur,Nom,President) VALUES(:id_Club_Organisateur,:nom,:president)');

        $requete->execute(array('id_Club_Organisateur' => $objet->getId_Club_Organisateur(),
                                'nom' => $objet->getNom(),
                                'president' => $objet->getPresident(),
                               ));

    }


    //Suppression d'un club_organisateur dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Club_Organisateur WHERE Id_Club_Organisateur = '.$objet->getId_Club_Organisateur());
    }

    //Fonction qui retourne un club_organisateur à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Club_Organisateur, Nom, President FROM Club_Organisateur WHERE Id_Club_Organisateur = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        return new Club_Organisateur($donnees);
    }

    public function getNom($nom){
        $requete = $this->getDb()->query('SELECT Id_Club_Organisateur WHERE Nom = '.$nom);
        $donne = $requete->fetch(PDO::FETCH_ASSOC);

        return $this->getId($donne['Id_Club_Organisateur']);
    }

    //Fonction qui retourne la liste de tous les club_organisateur présents dans la BDD
    public function getList()
    {
        $club_organisateurs = array();

        $requete = $this->getDb()->query('SELECT Id_Club_Organisateur FROM Club_Organisateur');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $club_organisateurs[] = loadClub(array("Id"=>$donneId['Id_Club_Organisateur']));
        }

        return $club_organisateurs;
    }

    //Procédure qui met à jour un club_organisateur donné en paramètre dans la BDD
    public function update($objet)
    {

        $requete = $this->getDb()->prepare('UPDATE Club_Organisateur SET Nom = :nom, President = :president WHERE Id_Club_Organisateur = :id_Club_Organisateur');

        $requete->execute(array('id_Club_Organisateur' => $objet->getId_Club_Organisateur(),
                                'nom' => $objet->getNom(),
                                'president' => $objet->getPresident(),
                               ));
    }

}
?>
