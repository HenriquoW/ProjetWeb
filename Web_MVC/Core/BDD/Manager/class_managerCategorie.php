<?php
require_once "class_manager.php";

class ManagerCategorie extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute une categorie dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Categorie (Id_Categorie,Nom) VALUES(:id_Categorie,:nom)');

        $requete->execute(array('id_Categorie' => $objet['Id'],
                                'nom' => $objet['Nom'],
                               ));

    }


    //Suppression d'une categorie dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Categorie WHERE Id_Categorie = '.$objet['Id']);
    }

    //Fonction qui retourne une categorie à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Categorie, Nom FROM Categorie WHERE Id_Categorie = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $categorie['Id'] = $donnees['Id_Categorie'];
        $categorie['Nom'] = $donnees['Nom'];

        return $categorie;
    }

    public function getNom($nom)
    {
        $requete = $this->getDb()->query('SELECT Id_Categorie, Nom FROM Categorie WHERE Nom = "'.$nom.'"');
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $categorie['Id'] = $donnees['Id_Categorie'];
        $categorie['Nom'] = $donnees['Nom'];

        return $categorie;
    }

    //Fonction qui retourne la liste de toutes les categorie présents dans la BDD
    public function getList()
    {
        $categories = array();

        $requete = $this->getDb()->query('SELECT Id_Categorie FROM Categorie');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $categories[] = $this->getId($donneId['Id_Categorie']);
        }

        return $categories;
    }

    //Procédure qui met à jour d'une categorie donné en paramètre dans la BDD
    public function update($objet)
    {

        $requete = $this->getDb()->prepare('UPDATE Categorie SET Nom = :nom WHERE Id_Categorie = :id_Categorie');

        $requete->execute(array('id_Categorie' => $objet['Id'],
                                'nom' => $objet['Nom'],
                               ));
    }

}
?>
