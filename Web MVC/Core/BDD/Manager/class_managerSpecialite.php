<?php
require_once "class_manager.php";

class ManagerSpecialite extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute une specialite dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Specialite (Id_Specialite,Nom) VALUES(:id_Specialite,:nom)');

        $requete->execute(array('id_Specialite' => $objet['Id'],
                                'nom' => $objet['Nom'],
                               ));

    }


    //Suppression d'une specialite dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Specialite WHERE Id_Specialite = '.$objet['Id']);
    }

    //Fonction qui retourne une specialite à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Specialite, Nom FROM Specialite WHERE Id_Specialite = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $specialite['Id'] = $donnees['Id_Specialite'];
        $specialite['Nom'] = $donnees['Nom'];

        return $specialite;
    }

    //Fonction qui retourne la liste de toutes les specialite présents dans la BDD
    public function getList()
    {
        $specialites = array();

        $requete = $this->getDb()->query('SELECT Id_Specialite FROM Specialite');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $specialites[] = $this->getId($donneId['Id_Specialite']);
        }

        return $specialites;
    }

    //Procédure qui met à jour d'une specialite donné en paramètre dans la BDD
    public function update($objet)
    {

        $requete = $this->getDb()->prepare('UPDATE Specialite SET Nom = :nom WHERE Id_Specialite = :id_Specialite');

        $requete->execute(array('id_Specialite' => $objet['Id'],
                                'nom' => $objet['Nom'],
                               ));
    }

}
?>
