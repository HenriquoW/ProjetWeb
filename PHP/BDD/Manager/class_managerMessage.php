<?php
require_once "class_manager.php";
require_once "../class_Message.php";

class ManagerMessage extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un message dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Message (Id_Message,Sujet,Corps) VALUES(:id_Message,:sujet,:corps)');

        $requete->execute(array('id_Message' => $objet->getId_Message(),
                                'sujet' => $objet->getSujet(),
                                'corps' => $objet->getCorps(),
                               ));

    }


    //Suppression d'un message dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Message WHERE Id_Message = '.$objet->getId_Message());
    }

    //Fonction qui retourne un message à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Message, Sujet, Corps FROM Message WHERE Id_Message = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        return new Message($donnees);
    }

    //Fonction qui retourne la liste de tous les message présents dans la BDD
    public function getList()
    {
        $messages = array();

        $requete = $this->getDb()->query('SELECT Id_Message FROM Message');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $messages[] = $this->getId($donneId['Id_Message']);
        }

        return $messages;
    }

    //Procédure qui met à jour un message donné en paramètre dans la BDD
    public function update($objet)
    {

        $requete = $this->getDb()->prepare('UPDATE Message SET Sujet = :sujet, Corps = :corps WHERE Id_Message = :id_Message');

        $requete->execute(array('id_Message' => $objet->getId_Message(),
                                'sujet' => $objet->getSujet(),
                                'corps' => $objet->getCorps(),
                               ));
    }

}
?>
