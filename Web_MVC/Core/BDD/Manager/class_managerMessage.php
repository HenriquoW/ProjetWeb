<?php
require_once "class_manager.php";
require_once $_SERVER["RACINE"]."/Core/class_message.php";

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

        $this->addEnvoie($objet);

        $this->addRecois($objet);

    }

    public function addEnvoie($objet){
        $requeteEnvoie = $this->getDb()->prepare('INSERT INTO Envoie (Id_Utilisateur,Id_Message) VALUES(:id_Utilisateur,:id_Message)');

        $requeteEnvoie->execute(array('id_Utilisateur' => $objet->getEnvoyeur(),
                                    'id_Message' => $objet->getId_Message(),
                                   ));
    }

    public function addRecois($objet){
        $requeteRecois = $this->getDb()->prepare('INSERT INTO Recois (Id_Utilisateur,Id_Message) VALUES(:id_Utilisateur,:id_Message)');

        $requeteRecois->execute(array('id_Utilisateur' => $objet->getDestinataire(),
                                    'id_Message' => $objet->getId_Message(),
                                   ));
    }


    //Suppression d'un message dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Envoie WHERE Id_Message = '.$objet->getId_Message());

        $this->getDb()->exec('DELETE FROM Recois WHERE Id_Message = '.$objet->getId_Message());

        $this->getDb()->exec('DELETE FROM Message WHERE Id_Message = '.$objet->getId_Message());

    }

    //Fonction qui retourne un message à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Message, Sujet, Corps FROM Message WHERE Id_Message = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $donnees['Destinataire'] = $this->getRecois($id);
        $donnees['Envoyeur'] = $this->getEnvoie($id);

        return new Message($donnees);
    }

    public function getEnvoie($id){
        $envoyeur;

        $requeteEnvoie = $this->getDb()->query('SELECT Id_Utilisateur FROM Envoie WHERE Id_Message = '.$id);

        while ($donne = $requeteEnvoie->fetch(PDO::FETCH_ASSOC))
        {
            $envoyeur[] = $donne;
        }

        return $envoyeur;
    }

    public function getRecois($id){
        $destinataire;

        $requeteRecois = $this->getDb()->query('SELECT Id_Utilisateur FROM Recois WHERE Id_Message = '.$id);

        while ($donne = $requeteRecois->fetch(PDO::FETCH_ASSOC))
        {
            $destinataire[] = $donne;
        }

        return $destinataire;
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


    //Fonction qui retourne tous les message envoyés et recus par un utilisateur
    public function getListUtilisateur($id)
    {
        $messages = array();

        $requeteEnvoie = $this->getDb()->query('SELECT Id_Message FROM Envoie WHERE Id_Utilisateur = '.$id);
        $messagesEnvoi = array();

	if($requeteEnvoie){
		while ($donneId = $requeteEnvoie->fetch(PDO::FETCH_ASSOC))
		{
		    $messagesEnvoi[] = $this->getId($donneId['Id_Message']);
		}
	}
        

        $requeteRecois = $this->getDb()->query('SELECT Id_Message FROM Recois WHERE Id_Utilisateur = '.$id);
        $messagesRecois = array();
        
	if($requeteRecois){
		while ($donneId = $requeteRecois->fetch(PDO::FETCH_ASSOC))
		{
		    $messagesRecois[] = $this->getId($donneId['Id_Message']);
		}
	}
        

        $messages['Envoyer'] = $messagesEnvoi;
        $messages['Recus'] = $messagesRecois;

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
