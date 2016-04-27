<?php
require_once "class_manager.php";

class ManagerSexe extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un sexe dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Sexe (Id_Sexe,Type) VALUES(:id_Sexe,:type)');

        $requete->execute(array('id_Sexe' => $objet['Id'],
                                'type' => $objet['Type'],
                               ));

    }


    //Suppression d'un sexe dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Sexe WHERE Id_Sexe = '.$objet['Id']);
    }

    //Fonction qui retourne un sexe à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Sexe, Type FROM Sexe WHERE Id_Sexe = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $sexe['Id'] = $donnees['Id_Sexe'];
        $sexe['Type'] = $donnees['Type'];

        return $sexe;
    }

    public function getType($type)
    {
        $requete = $this->getDb()->query('SELECT Id_Sexe, Type FROM Sexe WHERE Type = "'.$type.'"');
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $sexe['Id'] = $donnees['Id_Sexe'];
        $sexe['Type'] = $donnees['Type'];

        return $sexe;
    }

    //Fonction qui retourne la liste de tous les sexe présents dans la BDD
    public function getList()
    {
        $sexes = array();

        $requete = $this->getDb()->query('SELECT Id_Sexe FROM Sexe');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $sexes[] = $this->getId($donneId['Id_Sexe']);
        }

        return $sexes;
    }

    //Procédure qui met à jour un sexe donné en paramètre dans la BDD
    public function update($objet)
    {

        $requete = $this->getDb()->prepare('UPDATE Sexe SET Type = :type WHERE Id_Sexe = :id_Sexe');

        $requete->execute(array('id_Sexe' => $objet['Id'],
                                'type' => $objet['Type'],
                               ));
    }

}
?>
