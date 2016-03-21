<?php
require_once "class_manager.php";
require_once "../class_Equipe.php";

class ManagerEquipe extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute une equipe dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Equipe(Nom) VALUES (:nom)');

        $requete->execute(array('nom' => $objet->getNom(),
                               ));

        //Recupere l'id de l'equipe genere par la base
        $requeteId_Equipe = $this->getDb()->query('SELECT Id_Equipe FROM Equipe WHERE Nom = '.$objet->getNom());
        $donneId_Equipe = $requeteId_Equipe->fetch(PDO::FETCH_ASSOC);

        $objet->setId_Equipe($donneId_Equipe['Id_Equipe']);


        $this->addMembre($objet);

    }


    public function addMembre($objet){
        foreach($objet->getMembre() as $membre){
            $requeteMembre = $this->getDb()->query('SELECT Id_Competiteur FROM Participant_Equipe WHERE Id_Equipe = '.$objet->getId_Equipe());
            $donneMembre = $requeteMembre->fetch(PDO::FETCH_ASSOC);

            if(!in_array($donneMembre['Id_Competiteur'],$membre)){
                $requete = $this->getDb()->prepare('INSERT INTO Participant_Equipe (Id_Equipe,Id_Competiteur) VALUES(:id_Equipe,:id_Competiteur)');

                $requete->execute(array('id_Equipe' => $objet->getId_Equipe(),
                                        'id_Competiteur' => $membre,
                                        ));
            }

        }
    }

    //Suppression d'une equipe dans la BDD
    public function remove($objet)
    {
        $this->getDb()->exec('DELETE FROM Equipe WHERE Id_Equipe = '.$objet->getId_Equipe());
    }

    public function removeMembre($objet){
        $this->getDb()->exec('DELETE FROM Participant_Equipe WHERE Id_Equipe = '.$objet->getId_Equipe());
    }

    //Fonction qui retourne une equipe à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Equipe, Nom FROM Equipe WHERE Id_Equipe = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $donnees['Membre'] = $this->getMembre($id);

        return new Equipe($donnees);
    }

    public function getMembre($id){
        $membre

        $requeteMembre = $this->getDb()->query('SELECT Id_Competiteur FROM Participant_Equipe WHERE Id_Equipe = '.$id);

        while ($donne = $requeteMembre->fetch(PDO::FETCH_ASSOC))
        {
            $membre[] = $donne;
        }

        return $membre;
    }

    //Fonction qui retourne la liste de toutes les equipes présents dans la BDD
    public function getList()
    {
        $equipe = array();

        $requete = $this->getDb()->query('SELECT Id_Equipe FROM Equipe');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $equipe[] = $this->getId($donneId['Id_Equipe']);
        }

        return $equipe;
    }

    public function getListCompetiteur($id)
    {
        $equipe = array();

        $requete = $this->getDb()->query('SELECT Id_Equipe FROM Participant_Equipe Where Id_Competiteur='.$id);

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $equipe[] = $this->getId($donneId['Id_Equipe']);
        }

        return $equipe;
    }

    //Procédure qui met à jour une equipe donné en paramètre dans la BDD
    public function update($objet)
    {
        $requete = $this->getDb()->prepare('UPDATE Equipe SET Nom = :nom WHERE Id_Equipe = :id_Equipe');

        $requete->execute(array('nom' => $objet->getNom(),
                                'id_Equipe' => $objet->getId_Equipe(),
                               ));

        $this->updateMembre($objet);
    }

    public function updateMembre($objet){
        this->removeMembre($objet);
        this->addMembre($objet);
    }

}
?>
