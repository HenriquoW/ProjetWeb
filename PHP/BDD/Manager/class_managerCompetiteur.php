<?php
require_once "class_managerAdherent.php";
require_once "../class_Competiteur.php";

class ManagerCompetiteur extends ManagerAdherent{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
    }

    //Procédure qui ajoute un Competiteur dans la BDD
    public function add($objet)
    {
        if($objet->getId_Adherent() == NULL){
            parent::add($objet);
        }else{
            parent::update($objet);
        }

        $requeteId_Specialite = $this->getDb()->query('SELECT Id_Specialite FROM Specialite WHERE Nom = '.$objet->getSpecialite());
        $donneId_Specialite = $requeteId_Specialite->fetch(PDO::FETCH_ASSOC);

        $requeteId_Categorie = $this->getDb()->query('SELECT Id_Categorie FROM Categorie WHERE Nom = '.$objet->getCategorie());
        $donneId_Categorie = $requeteId_Categorie->fetch(PDO::FETCH_ASSOC);

        $requete = $this->getDb()->prepare('INSERT INTO Competiteur (Photo,Id_Adherent,Id_Specialite,Id_Categorie) VALUES(:photo,:id_Adherent,:id_Specialite,:id_Categorie)');

        $requete->execute(array('photo' => $objet->getPhoto(),
                                'id_Adherent' => $objet->getId_Adherent(),
                                'id_Specialite' => $donneId_Specialite['Id_Specialite'],
                                'id_Categorie' => $donneId_Categorie['Id_Categorie'],
                               ));

        addObjectif($objet);

        //Recupere l'id du competiteur genere par la base
        $requeteId_Competiteur = $this->getDb()->query('SELECT Id_Competiteur FROM Competiteur WHERE Id_Adherent = '.$objet->getId_Adherent());
        $donneId_Competiteur = $requeteId_Competiteur->fetch(PDO::FETCH_ASSOC);

        $objet->setId_Competiteur($donneId_Competiteur['Id_Competiteur']);

    }

    //Ajoute les objectifs du Competiteur
    public function addObjectif($objet){

        //on recupere les id des competition du Competiteur deja dans la base
        $requeteId_Comp = $this->getDb()->query('SELECT Id_Competition FROM Objectif WHERE Id_Competiteur = '.$objet->getId_Competiteur());

        $donneComp = array();
        while ($donne = $requeteId_Comp->fetch(PDO::FETCH_ASSOC))
        {
            $donneComp[] = $donne;
        }

        foreach($objet->getObjectif() as $objectif){

            if(!in_array($donneComp['Id_Competition'],$objectif['Id_Competition'])){
                $requete = $this->getDb()->prepare('INSERT INTO Objectif (Id_Competiteur,Id_Competition) VALUES(:id_Competiteur,:id_Competition)');

                $requete->execute(array('id_Competiteur' => $objet->getId_Competiteur(),
                                        'id_Competition' => $objectif['Id_Competition'],
                                        ));
            }

        }
    }

    //Suppression d'un Competiteur dans la BDD
    public function remove($objet)
    {
        $this->removeObjectif($objet);

        $this->getDb()->exec('DELETE FROM Competiteur WHERE Id_Competiteur = '.$objet->getId_Competiteur());
    }

    //Suppression de tous les objectif du Competiteur
    public function removeObjectif($objet){
        $this->getDb()->exec('DELETE FROM Objectif WHERE Id_Competiteur = '.$objet->getId_Competiteur());
    }

    //Fonction qui retourne un Competiteur à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Competiteur, Photo, Id_Adherent, Id_Specialite, Id_Categorie FROM Competiteur WHERE Id_Competiteur = '.$id);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        $user = parent::getId($donnees['Id_Adherent']);

        unset($donnees['Id_Adherent']);

        //Recupere le nom de la specialite du competiteur
        $requeteNom_Spe = $this->getDb()->query('SELECT Nom FROM Specialite WHERE Id_Specialite = '.$donnees['Id_Specialite']);
        $donneNom_Spe = $requeteNom_Spe->fetch(PDO::FETCH_ASSOC);

        $requeteNom_Cat = $this->getDb()->query('SELECT Nom FROM Categorie WHERE Id_Categorie = '.$donnees['Id_Categorie']);
        $donneNom_Cat = $requeteNom_Cat->fetch(PDO::FETCH_ASSOC);

        $donnees['Specialite'] = $donneNom_Spe['Nom'];
        $donnees['Categorie'] = $donneNom_Cat['Nom'];
        $donnees['Objectif'] = $this->getObjectif($id);

        unset($donnees['Id_Specialite']);
        unset($donnees['Id_Categorie']);

        return new Competiteur($user,$donnees);
    }

    public function getObjectif($id){
        $objectifs

        $requeteObjectif = $this->getDb()->query('SELECT Id_Competition FROM Objectif WHERE Id_Competiteur = '.$id);

        while ($donne = $requeteObjectif->fetch(PDO::FETCH_ASSOC))
        {
            $objectifs[] = $donne;
        }

        return $objectifs;
    }

    public function getMail($mail){
        $requeteId = $this->getDb()->query('SELECT Id_Competiteur FROM Competiteur JOIN Adherent ON Competiteur.Id_Adherent = Adherent.Id_Adherent JOIN Utilisateur ON Adherent.Id_Utilisateur = Utilisateur.Id_Utilisateur WHERE Utilisateur.Mail = '.$mail);
        $donneId = $requeteId->fetch(PDO::FETCH_ASSOC);

        return $this->getId($donneId['Id_Competiteur']);
    }

    //Fonction qui retourne la liste de tous les Competiteur présents dans la BDD
    public function getList()
    {
        $competiteurs = array();

        $requete = $this->getDb()->query('SELECT Id_Competiteur FROM Competiteur');

        while ($donneId = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $competiteurs[] = $this->getId($donneId['Id_Competiteur']);
        }

        return $competiteurs;
    }

    //Procédure qui met à jour un Competiteur donné en paramètre dans la BDD
    public function update($objet)
    {
        if($objet->getId_Adherent() == NULL){
            parent::add($objet);
        }else{
            parent::update($objet);
        }

        $requeteId_Specialite = $this->getDb()->query('SELECT Id_Specialite FROM Specialite WHERE Nom = '.$objet->getSpecialite());
        $donneId_Specialite = $requeteId_Specialite->fetch(PDO::FETCH_ASSOC);

        $requeteId_Categorie = $this->getDb()->query('SELECT Id_Categorie FROM Categorie WHERE Nom = '.$objet->getCategorie());
        $donneId_Categorie = $requeteId_Categorie->fetch(PDO::FETCH_ASSOC);

        $requete = $this->getDb()->prepare('UPDATE Competiteur SET Photo =:photo, Id_Adherent = :id_Adherent, Id_Specialite = :id_Specialite, Id_Categorie = :id_Categorie WHERE Id_Competiteur = :id_Competiteur');

        $requete->execute(array('photo' => $objet->getPhoto(),
                                'id_Adherent' => $objet->getId_Adherent(),
                                'id_Specialite' => $donneId_Specialite['Id_Specialite'],
                                'id_Categorie' => $donneId_Categorie['Id_Categorie'],
                                'id_Competiteur' => $objet->getId_Competiteur(),
                               ));
    }

    public function updateObjectif($objet){
        this->removeObjectif($objet);
        this->addObjectif($objet);
    }

}
?>
