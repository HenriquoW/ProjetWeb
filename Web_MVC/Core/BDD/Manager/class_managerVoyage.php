<?php
require_once "class_manager.php";
require_once $_SERVER["RACINE"]."/Core/class_voyage.php";

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
                                        'id_Role' => $charge['Role']['Id'],
                                        'id_Tache' => $charge['Tache']['Id'],
                                        ));
            }

        }
    }

    //Suppression d'un voyage dans la BDD
    public function remove($objet)
    {
        $this->removeCharge($objet->getId_Voyage());

        $this->removeParticipe($objet->getId_Voyage());

        $this->getDb()->exec('DELETE FROM Voyage WHERE Id_Voyage = '.$objet->getId_Voyage());
    }

    //enleve toutes les charges d'un voyage
    public function removeCharge($IdVoyage){
        $this->getDb()->exec('DELETE FROM Charge WHERE Id_Voyage = '.$IdVoyage);
    }

    //enleve tous les participants d'un voyage
    public function removeParticipe($IdVoyage){
        $this->getDb()->exec('DELETE FROM Participe_Voyage WHERE Id_Voyage = '.$IdVoyage);
    }

    //Fonction qui retourne un voyage à partir de son id
    public function getId($id)
    {
	error_log(print_r($id,true));
        $requete = $this->getDb()->query('SELECT Id_Voyage, Transport_Propose, Hebergement, Id_Competition FROM Voyage WHERE Id_Voyage = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $donnees['Charge'] = $this->getCharge($id);
        $donnees['Participe'] = $this->getParticipe($id);
	$donnees['Transport'] = $donnees['Transport_Propose'];

	unset($donnees['Transport_Propose']);

        return new Voyage($donnees);
    }

    //recupere les charge pour un voyage
    public function getCharge($id){
        $charges = array();

        $requeteCharge = $this->getDb()->query('SELECT Id_Utilisateur,Id_Role,Id_Tache FROM Charger WHERE Id_Voyage = '.$id);

	if($requeteCharge){
	  while ($donne = $requeteCharge->fetch(PDO::FETCH_ASSOC))
        {
            $donne['Role'] = $donne['Id_Role'];
            $donne['Tache'] = $donne['Id_Tache'];

            unset($donne['Id_Role']);
            unset($donne['Id_Tache']);

            $charges[] = $donne;
        }

	}
        

        return $charges;
    }

    //recupere les competiteur qui participe au voyage pour un voyage
    public function getParticipe($id){
        $participants = array();

        $requeteParticipe = $this->getDb()->query('SELECT Id_Competiteur,Autoriser,Id_Type_Voyage,Id_Utilisateur FROM Participe_Voyage WHERE Id_Voyage = '.$id);

	if($requeteParticipe){
	while ($donne = $requeteParticipe->fetch(PDO::FETCH_ASSOC))
        {

            $donne['Type_Voyage'] = $donne['Id_Type_Voyage'];
            unset($donne['Id_Type_Voyage']);

            $participants[] = $donne;
        }


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
            $voyage[] = loadVoyage(array("Id"=>$donneId['Id_Voyage']));
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
            $voyage[] = loadVoyage(array("Id"=>$donneId['Id_Voyage']));
        }

        return $voyage;
    }

    //recupere le voyage associer a une competition
    public function getVoyageCompetition($id)
    {
        $voyage;

        $requete = $this->getDb()->query('SELECT Id_Voyage FROM Voyage Where Id_Competition='.$id);
        $donneId = $requete->fetch(PDO::FETCH_ASSOC);

        return loadVoyage(array("Id"=>$donneId['Id_Voyage']));
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
        $this->removeCharge($objet);
        $this->addCharge($objet);
    }

}
?>
