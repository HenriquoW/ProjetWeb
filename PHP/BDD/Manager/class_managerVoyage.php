<?php
require_once "class_manager.php";
require_once "../class_Voyage.php";

class ManagerVoyage extends Manager{// -- a modifier --

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

    //ajoute toute les charges pour un voyage
    public function addCharge($objet){
        $requeteCharge = $this->getDb()->query('SELECT Id_Utilisateur,Id_Tache,Id_Role,Id_Voyage FROM Charger WHERE Id_Voyage = '.$objet->getId_Voyage());
        $donneCharge = $requeteCharge->fetchAll(PDO::FETCH_ASSOC);

        foreach($objet->getCharge() as $charge){
            if(!in_array($donneCharge['Id_Utilisateur'],$charge['Id_Utilisateur']) && !in_array($donneCharge['Id_Role'],$charge['Id_Role']) && !in_array($donneCharge['Id_Tache'],$charge['Id_Tache'])){

                $requete = $this->getDb()->prepare('INSERT INTO Charger (Id_Voyage,Id_Utilisateur,Id_Role,Id_Tache) VALUES(:id_Voyage,:id_Utilisateur,:id_Role,:id_Tache)');

                $requete->execute(array('id_Voyage' => $objet->getId_Voyage(),
                                        'id_Utilisateur' => $charge['Id_Utilisateur'],
                                        'id_Role' => $charge['Id_Role'],
                                        'id_Tache' => $charge['Id_Tache'],
                                        ));
            }

        }
    }

    //ajoute tous les participants
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

    //enleve toutes les charges d'un voyage
    public function removeCharge($objet){
        $this->getDb()->exec('DELETE FROM Charge WHERE Id_Voyage = '.$objet->getId_Voyage());
    }

    //enleve tous les participants d'un voyage
    public function removeParticipe($objet){
        $this->getDb()->exec('DELETE FROM Participe_Voyage WHERE Id_Voyage = '.$objet->getId_Voyage());
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

    //recupere les charge pour un voyage
    public function getCharge($id){
        $charge;

        $requeteCharge = $this->getDb()->query('SELECT Id_Utilisateur,Id_Role,Id_Tache FROM Charge WHERE Id_Voyage = '.$id);

        while ($donne = $requeteCharge->fetch(PDO::FETCH_ASSOC))
        {
            $charge[] = $donne;
        }

        return $charges;
    }

    //recupere les competiteur qui participe au voyage pour un voyage
    public function getParticipe($id){
        $participants;

        $requeteParticipe = $this->getDb()->query('SELECT Id_Competiteur,Autorise,Id_Type_Voyage,Id_Utilisateur FROM Participe_Voyage WHERE Id_Voyage = '.$id);

        while ($donne = $requeteParticipe->fetch(PDO::FETCH_ASSOC))
        {
            $participants[] = $donne;
        }

        return $participants;
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

    //recupere les voyage d'un competiteur
    public function getListCompetiteur($id)
    {
        $voyage = array();

        $requete = $this->getDb()->query('SELECT Id_Voyage FROM Participe_Voyage Where Id_Competiteur='.$id);

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $voyage[] = $this->getId($donneId['Id_Voyage']);
        }

        return $voyage;
    }

    //recupere le voyage associer a une competition
    public function getVoyageCompetition($id)
    {
        $voyage;

        $requete = $this->getDb()->query('SELECT Id_Voyage FROM Voyage Where Id_Competition='.$id);
        $donneId = $requete->fetch(PDO::FETCH_ASSOC))

        return $this->getID($donneId['id_Voyage']);
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
    }

    public function updateCharge($objet){
        this->removeCharge($objet);
        this->addCharge($objet);
    }

}
?>
