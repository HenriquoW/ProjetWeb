<?php
require_once "class_manager.php";

class ManagerDroit_Acces extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un droit_acces dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Droit_Acces (Id_Droit_Acces,Nom) VALUES(:id_Droit_Acces,:nom)');

        $requete->execute(array('id_Droit_Acces' => $objet['Id'],
                                'nom' => $objet['Nom'],
                               ));

    }

    //Suppression d'un droit_acces dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Droit_Acces WHERE Id_Droit_Acces = '.$objet['Id']);
    }

    //Fonction qui retourne un droit_acces à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Droit_Acces, Nom FROM Droit_Acces WHERE Id_Droit_Acces = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $droit_acces['Id'] = $donnees['Id_Droit_Acces'];
        $droit_acces['Nom'] = $donnees['Nom'];

        return $droit_acces;
    }

    public function getNom($nom)
    {
        $requete = $this->getDb()->query('SELECT Id_Droit_Acces, Nom FROM Droit_Acces WHERE Nom = "'.$nom.'"');
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $droit_acces['Id'] = $donnees['Id_Droit_Acces'];
        $droit_acces['Nom'] = $donnees['Nom'];

        return $droit_acces;
    }

    //Fonction qui retourne la liste de tous les droit_acces présents dans la BDD
    public function getList()
    {
        $droit_acces = array();

        $requete = $this->getDb()->query('SELECT Id_Droit_Acces FROM Droit_Acces');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $droit_acces[] = $this->getId($donneId['Id_Droit_Acces']);
        }

        return $droit_acces;
    }

    //Procédure qui met à jour un droit_acces donné en paramètre dans la BDD
    public function update($objet)
    {

        $requete = $this->getDb()->prepare('UPDATE Droit_Acces SET Nom = :nom WHERE Id_Droit_Acces = :id_Droit_Acces');

        $requete->execute(array('id_Droit_Acces' => $objet['Id'],
                                'nom' => $objet['Nom'],
                               ));
    }

}
?>
