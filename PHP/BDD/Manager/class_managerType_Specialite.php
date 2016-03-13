<?php
require_once "class_manager.php";

class ManagerType_Specialite extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un type_specialite dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Type_Specialite (Id_Type_Specialite,Nom) VALUES(:id_Type_Specialite,:nom)');

        $requete->execute(array('id_Type_Specialite' => $objet['Id'],
                                'nom' => $objet['Nom'],
                               ));

    }


    //Suppression d'un type_specialite dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Type_Specialite WHERE Id_Type_Specialite = '.$objet['Id']);
    }

    //Fonction qui retourne un type_specialite à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Type_Specialite, Nom FROM Type_Specialite WHERE Id_Type_Specialite = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $type_specialite['Id'] = $donnees['Id_Type_Specialite'];
        $type_specialite['Nom'] = $donnees['Nom'];

        return $type_specialite;
    }

    //Fonction qui retourne la liste de tous les type_specialite présents dans la BDD
    public function getList()
    {
        $type_specialites = array();

        $requete = $this->getDb()->query('SELECT Id_Type_Specialite FROM Type_Specialite');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $type_specialites[] = $this->getId($donneId['Id_Type_Specialite']);
        }

        return $type_specialites;
    }

    //Procédure qui met à jour un type_specialite donné en paramètre dans la BDD
    public function update($objet)
    {

        $requete = $this->getDb()->prepare('UPDATE Type_Specialite SET Nom = :nom WHERE Id_Type_Specialite = :id_Type_Specialite');

        $requete->execute(array('id_Type_Specialite' => $objet['Id'],
                                'nom' => $objet['Nom'],
                               ));
    }

}
?>
