<?php
require_once "class_manager.php";

class ManagerTache extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute une tache dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Tache (Id_Tache,Nom) VALUES(:id_Tache,:nom)');

        $requete->execute(array('id_Tache' => $objet['Id'],
                                'nom' => $objet['Nom'],
                               ));

    }


    //Suppression d'une tache dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Tache WHERE Id_Tache = '.$objet['Id']);
    }

    //Fonction qui retourne une tache à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Tache, Nom FROM Tache WHERE Id_Tache = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $tache['Id'] = $donnees['Id_Tache'];
        $tache['Nom'] = $donnees['Nom'];

        return $tache;
    }

    //Fonction qui retourne la liste de toutes les tache présents dans la BDD
    public function getList()
    {
        $taches = array();

        $requete = $this->getDb()->query('SELECT Id_Tache FROM Tache');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $taches[] = $this->getId($donneId['Id_Tache']);
        }

        return $taches;
    }

    //Procédure qui met à jour d'une tache donné en paramètre dans la BDD
    public function update($objet)
    {

        $requete = $this->getDb()->prepare('UPDATE Tache SET Nom = :nom WHERE Id_Tache = :id_Tache');

        $requete->execute(array('id_Tache' => $objet['Id'],
                                'nom' => $objet['Nom'],
                               ));
    }

}
?>
