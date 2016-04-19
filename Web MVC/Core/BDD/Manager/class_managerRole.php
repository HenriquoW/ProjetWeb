<?php
require_once "class_manager.php";

class ManagerRole extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un role dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Role (Id_Role,Titre) VALUES(:id_Role,:titre)');

        $requete->execute(array('id_Role' => $objet['Id'],
                                'titre' => $objet['Titre'],
                               ));

    }


    //Suppression d'un role dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Role WHERE Id_Role = '.$objet['Id']);
    }

    //Fonction qui retourne un role à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Role, Titre FROM Role WHERE Id_Role = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $role['Id'] = $donnees['Id_Role'];
        $role['Titre'] = $donnees['Titre'];

        return $role;
    }

    //Fonction qui retourne la liste de tous les role présents dans la BDD
    public function getList()
    {
        $roles = array();

        $requete = $this->getDb()->query('SELECT Id_Role FROM Role');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $roles[] = $this->getId($donneId['Id_Role']);
        }

        return $roles;
    }

    //Procédure qui met à jour un role donné en paramètre dans la BDD
    public function update($objet)
    {

        $requete = $this->getDb()->prepare('UPDATE Role SET Titre = :titre WHERE Id_Role = :id_Role');

        $requete->execute(array('id_Role' => $objet['Id'],
                                'titre' => $objet['Titre'],
                               ));
    }

}
?>
