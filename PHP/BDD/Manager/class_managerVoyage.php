<?php
require_once "class_manager.php";
require_once "../class_Voyage.php";

class ManagerVoyage extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un voyage dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Voyage(Transport_Propose,Hebergement,Id_Competition) VALUES (:transport,:hebergement,:id_Competition)');

        $requete->execute(array('transport' => $objet->getTransport(),
                                'hebergement' => $objet->getHebergement(),
                                'id_Competition' => $objet->getId_Competition(),
                               ));

        //Recupere l'id du voyage genere par la base
        $requeteId_Voyage = $this->getDb()->query('SELECT Id_Voyage FROM Voyage WHERE Id_Competition = '.$objet->getId_Competition());
        $donneId_Voyage = $requeteId_Voyage->fetch(PDO::FETCH_ASSOC);

        $objet->setId_Voyage($donneId_Voyage['Id_Voyage']);


        $this->addCharge($objet);
        $this->addParticipe($objet);
    }

    //-----A FAIRE ------
    public function addCharge($objet){
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

    //-----A FAIRE ------
    public function addParticipe($objet){
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

    //Suppression d'un voyage dans la BDD
    public function remove($objet)
    {
        $this->removeCharge($objet);

        $this->removeParticipe($objet);

        $this->getDb()->exec('DELETE FROM Voyage WHERE Id_Voyage = '.$objet->getId_Voyage());
    }

    //-----A FAIRE ------
    public function removeCharge($objet){
        $this->getDb()->exec('DELETE FROM Participant_Equipe WHERE Id_Equipe = '.$objet->getId_Equipe());
    }

    //-----A FAIRE ------
    public function removeParticipe($objet){
        $this->getDb()->exec('DELETE FROM Participant_Equipe WHERE Id_Equipe = '.$objet->getId_Equipe());
    }

    //Fonction qui retourne un voyage à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Voyage, Transport_Propose, Hebergement, Id_Competition FROM Voyage WHERE Id_Voyage = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $donnees['Charge'] = $this->getCharge($id);
        $donnees['Participe'] = $this->getParticipe($id);

        return new Equipe($donnees);
    }

    //-----A FAIRE ------
    public function getCharge($id){
        $membre

        $requeteMembre = $this->getDb()->query('SELECT Id_Competiteur FROM Participant_Equipe WHERE Id_Equipe = '.$id);

        while ($donne = $requeteMembre->fetch(PDO::FETCH_ASSOC))
        {
            $membre[] = $donne;
        }

        return $membre;
    }

    //-----A FAIRE ------
    public function getParticipe($id){
        $membre

        $requeteMembre = $this->getDb()->query('SELECT Id_Competiteur FROM Participant_Equipe WHERE Id_Equipe = '.$id);

        while ($donne = $requeteMembre->fetch(PDO::FETCH_ASSOC))
        {
            $membre[] = $donne;
        }

        return $membre;
    }

    //Fonction qui retourne la liste de tous les voyages présents dans la BDD
    public function getList()
    {
        $voyage = array();

        $requete = $this->getDb()->query('SELECT Id_Voyage FROM Voyage');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $voyage[] = $this->getId($donneId['Id_Voyage']);
        }

        return $voyage;
    }

    //-----A FAIRE ------
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

    //-----A FAIRE ------
    public function getListCompetition($id)
    {
        $equipe = array();

        $requete = $this->getDb()->query('SELECT Id_Equipe FROM Participant_Equipe Where Id_Competiteur='.$id);

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $equipe[] = $this->getId($donneId['Id_Equipe']);
        }

        return $equipe;
    }

    //Procédure qui met à jour un voyage donné en paramètre dans la BDD
    public function update($objet)
    {
        $requete = $this->getDb()->prepare('UPDATE Voyage SET Transport_Propose = :transport, Hebergement = :hebergement, Id_Competition = :id_Competition WHERE Id_Voyage = :id_Voyage');

        $requete->execute(array('transport' => $objet->getTransport(),
                                'hebergement' => $objet->getHebergement(),
                                'id_Competition' => $objet->getId_Competition(),
                                'id_Voyage' => $objet->getId_Voyage(),
                               ));

        $this->updateCharge($objet);
        $this->updateParticipe($objet);
    }

    public function updateCharge($objet){
        this->removeCharge($objet);
        this->addCharge($objet);
    }

    public function updateParticipe($objet){
        this->removeParticipe($objet);
        this->addParticipe($objet);
    }

}
?>
