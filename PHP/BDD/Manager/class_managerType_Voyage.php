<?php
require_once "class_manager.php";

class ManagerType_Voyage extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un type_voyage dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Type_Voyage (Id_Type_Voyage,Nom) VALUES(:id_Type_Voyage,:nom)');

        $requete->execute(array('id_Type_Voyage' => $objet['Id'],
                                'nom' => $objet['Nom'],
                               ));

    }


    //Suppression d'un type_voyage dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Type_Voyage WHERE Id_Type_Voyage = '.$objet['Id']);
    }

    //Fonction qui retourne un type_voyage à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Type_Voyage, Nom FROM Type_Voyage WHERE Id_Type_Voyage = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $type_voyage['Id'] = $donnees['Id_Type_Voyage'];
        $type_voyage['Nom'] = $donnees['Nom'];

        return $type_voyage;
    }

    //Fonction qui retourne la liste de tous les type_voyage présents dans la BDD
    public function getList()
    {
        $type_voyages = array();

        $requete = $this->getDb()->query('SELECT Id_Type_Voyage FROM Type_Voyage');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $type_voyages[] = $this->getId($donneId['Id_Type_Voyage']);
        }

        return $type_voyages;
    }

    //Procédure qui met à jour un type_voyage donné en paramètre dans la BDD
    public function update($objet)
    {

        $requete = $this->getDb()->prepare('UPDATE Type_Voyage SET Nom = :nom WHERE Id_Type_Voyage = :id_Type_Voyage');

        $requete->execute(array('id_Type_Voyage' => $objet['Id'],
                                'nom' => $objet['Nom'],
                               ));
    }

}
?>
