<?php
require_once "class_manager.php";

class ManagerType_Competition extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un type_competition dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Type_Competition (Id_Type_Competition,Nom,Selectif) VALUES(:id_Type_Competition,:nom,:selectif)');

        $requete->execute(array('id_Type_Competition' => $objet['Id'],
                                'nom' => $objet['Nom'],
                                'selectif' => $objet['Selectif'],
                               ));

    }


    //Suppression d'un type_competition dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Type_Competition WHERE Id_Type_Competition = '.$objet['Id']);
    }

    //Fonction qui retourne un type_competition à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Type_Competition, Nom, Selectif FROM Type_Competition WHERE Id_Type_Competition = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $type_competition['Id'] = $donnees['Id_Type_Competition'];
        $type_competition['Nom'] = $donnees['Nom'];
        $type_competition['Selectif'] = $donnees['Selectif'];

        return $type_competition;
    }

    //Fonction qui retourne la liste de tous les type_competition présents dans la BDD
    public function getList()
    {
        $type_competitions = array();

        $requete = $this->getDb()->query('SELECT Id_Type_Competition FROM Type_Competition');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $type_competitions[] = $this->getId($donneId['Id_Type_Competition']);
        }

        return $type_competitions;
    }

    //Procédure qui met à jour un type_competition donné en paramètre dans la BDD
    public function update($objet)
    {

        $requete = $this->getDb()->prepare('UPDATE Type_Competition SET Nom = :nom, Selectif = :selectif WHERE Id_Type_Competition = :id_Type_Competition');

        $requete->execute(array('id_Type_Competition' => $objet['Id'],
                                'nom' => $objet['Nom'],
                                'selectif' => $objet['Selectif'],
                               ));
    }

}
?>
