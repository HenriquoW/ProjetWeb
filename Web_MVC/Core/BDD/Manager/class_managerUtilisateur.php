<?php
require_once "class_manager.php";
require_once $_SERVER["RACINE"]."/Core/class_utilisateur.php";

class ManagerUtilisateur extends Manager{

    //Constructeur
    public function __construct($Db)
    {
        parent::__construct($Db);
	}

    //Procédure qui ajoute un utilisateur dans la BDD
    public function add($objet)
    {
        $requete = $this->getDb()->prepare('INSERT INTO Utilisateur (Nom,Prenom,Password,DateNaissance,Adresse,Mail,Telephone,Id_Sexe) VALUES(:nom,:prenom,:password,:dateNaissance,:adresse,:mail,:telephone,:id_Sexe)');

        $requete->execute(array('nom' => $objet->getNom(),
                                'prenom' => $objet->getPrenom(),
                                'password' => $objet->getPassword(),
                                'dateNaissance' => $objet->getDateNaissance()->format('Y-m-d'),
                                'adresse' => $objet->getAdresse(),
                                'mail' => $objet->getMail(),
                                'telephone' => $objet->getTelephone(),
                                'id_Sexe' => $objet->getSexe()['Id'],
                               ));

        //Recupere l'id de l'utilisateur genere par la base
        $requeteId_Utilisateur = $this->getDb()->query('SELECT Id_Utilisateur FROM Utilisateur WHERE Mail = "'.$objet->getMail().'"');
        $donneId_Utilisateur = $requeteId_Utilisateur->fetch(PDO::FETCH_ASSOC);

        $objet->setId_Utilisateur($donneId_Utilisateur['Id_Utilisateur']);

        $this->addParente($objet);

        $this->addDroits($objet);

    }

    public function addParente($objet){

        $donneEnfant = array();
        $requeteEnfant = $this->getDb()->query('SELECT Id_Enfant FROM Parente WHERE Id_Parent = '.$objet->getId_Utilisateur());

        if($requeteEnfant){
          $donneEnfant = $requeteEnfant->fetchAll(PDO::FETCH_ASSOC);
        }

        if($objet->getParente()!=null){
          foreach($objet->getParente() as $enfant){

              if(!in_array($donneEnfant['Id_Enfant'],$enfant["Enfant"])){
                  $requete = $this->getDb()->prepare('INSERT INTO Parente (Id_Parent,Id_Enfant) VALUES(:id_Parent,:id_Enfant)');

                  $requete->execute(array('id_Parent' => $objet->getId_Utilisateur(),
                                          'id_Enfant' => $enfant["Enfant"],
                                          ));
              }
          }
        }
    }

    //Ajoute les droits de l'adherent
    public function addDroits($objet){

        $donneDroits = array();
        //on recupere les droits de l'adherent deja dans la base
        $requeteDroits = $this->getDb()->query('SELECT Id_Droit_Access FROM Droits WHERE Id_Utilisateur = '.$objet->getId_Utilisateur());

        if($requeteDroits){
          $donneDroits = $requeteDroits->fetchAll(PDO::FETCH_ASSOC);
        }

        if($objet->getDroit()!=null){
          foreach($objet->getDroit() as $droit){

              if(!in_array($droit['Id'],$donneDroits)){
                  $requete = $this->getDb()->prepare('INSERT INTO Droits (Id_Droit_Acces,Id_Utilisateur) VALUES(:id_Droit_Acces,:id_Utilisateur)');

                  $requete->execute(array('id_Droit_Acces' => $droit['Id'],
                                          'id_Utilisateur' => $objet->getId_Utilisateur(),
                                          ));
              }

          }
        }
    }

    //Suppression d'un utilisateur dans la BDD
    public function remove($objet)
    {
        $this->removeDroits($objet->getId_Utilisateur());

        $this->removeParente($objet->getId_Utilisateur());

        $this->getDb()->exec('DELETE FROM Utilisateur WHERE Id_Utilisateur = '.$objet->getId_Utilisateur());
    }

    //Suppression de tous les droits de l'adherent
    public function removeDroits($IdUtilisateur){
        $this->getDb()->exec('DELETE FROM Droits WHERE Id_Utilisateur = '.$IdUtilisateur);
    }

    //Suppression de tous les droits de l'adherent
    public function removeParente($IdUtilisateur){
        $this->getDb()->exec('DELETE FROM Parente WHERE Id_Utilisateur = '.$IdUtilisateur);
    }

    //Fonction qui retourne un utilisateur à partir de son id
    public function getId($id)
    {
        $requete = $this->getDb()->query('SELECT Id_Utilisateur, Nom, Prenom, Password, DateNaissance, Adresse, Mail, Telephone, Id_Sexe FROM Utilisateur WHERE Id_Utilisateur = '.$id);

        if($requete){
          $donnees = $requete->fetch(PDO::FETCH_ASSOC);
          $donnees['DateNaissance'] = new datetime($donnees['DateNaissance']);
          $donnees['Sexe'] = $donnees['Id_Sexe'];
          $donnees['Droit'] = $this->getDroit($id);
	  
	  if(getdate()['year'] - $donnees['DateNaissance']->format('Y') < '18')
          	$donnees['Parente'] = $this->getParente($id,true);
	  else
		$donnees['Parente'] = $this->getParente($id,false);

          unset($donnees['Id_Sexe']);

          return new Utilisateur($donnees);
        }

        return null;
    }

    public function getDroit($id){
        $droits = array();

        $requeteDroits = $this->getDb()->query('SELECT Id_Droit_Acces FROM Droits WHERE Id_Utilisateur = '.$id);

        while ($donne = $requeteDroits->fetch(PDO::FETCH_ASSOC))
        {
            $droits[] = $donne['Id_Droit_Acces'];
        }
        return $droits;
    }

    public function getParente($id,$isEnfant){
        $enfant = array();

	if(!$isEnfant){
		$requeteEnfants = $this->getDb()->query('SELECT Id_Enfant FROM Parente WHERE Id_Parent = '.$id);

		$enfant["Enfant"] = array();

		while ($donne = $requeteEnfants->fetch(PDO::FETCH_ASSOC))
		{
		    $enfant["Enfant"][] = $donne['Id_Enfant'];

		}

	}else{
		$requeteEnfants = $this->getDb()->query('SELECT Id_Parent FROM Parente WHERE Id_Enfant = '.$id);

		$enfant["Parent"] = array();

		while ($donne = $requeteEnfants->fetch(PDO::FETCH_ASSOC))
		{
		    $enfant["Parent"][] = $donne['Id_Parent'];

		}
	}
        

        return $enfant;
    }

    public function getMail($mail){
        $requete = $this->getDb()->query('SELECT Id_Utilisateur FROM Utilisateur WHERE Mail = "'.$mail.'"');
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);

        return $this->getId($donnees['Id_Utilisateur']);
    }

    //Fonction qui retourne la liste de tous les utilisateur présents dans la BDD
    public function getList()
    {
        $utilisateurs = array();

        $requete = $this->getDb()->query('SELECT Id_Utilisateur FROM Utilisateur');

        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $utilisateurs[] = loadUtilisateur(array("Id" => $donnees['Id_Utilisateur']));
        }

        return $utilisateurs;
    }

    public function getListMajeur()
    {
        $utilisateurs = array();

        $requete = $this->getDb()->query('SELECT Id_Utilisateur FROM Utilisateur WHERE DATEDIFF(Utilisateur.DateNaissance,CURRENT_DATE)>18*365');

        while ($donnees = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $utilisateurs[] = loadUtilisateur(array("Id" => $donnees['Id_Utilisateur']));
        }

        return $utilisateurs;
    }

    //Procédure qui met à jour un utilisateur donné en paramètre dans la BDD
    public function update($objet)
    {

        $this->updateDroits($objet);

        $this->updateParente($objet);

        $requete = $this->getDb()->prepare('UPDATE Utilisateur SET Nom = :nom, Prenom = :prenom, Password = :password, DateNaissance = :dateNaissance, Adresse = :adresse, Mail = :mail, Telephone = :telephone, Id_Sexe = :id_sexe WHERE Id_Utilisateur = :id_Utilisateur');

        $requete->execute(array('nom' => $objet->getNom(),
                                'prenom' => $objet->getPrenom(),
                                'password' => $objet->getPassword(),
                                'dateNaissance' => $objet->getDateNaissance()->format('Y-m-d'),
                                'adresse' => $objet->getAdresse(),
                                'mail' => $objet->getMail(),
                                'telephone' => $objet->getTelephone(),
                                'id_Sexe' => $objet->getSexe()['Id'],
                                'id_Utilisateur' => $objet->getId_Utilisateur(),
                               ));
    }

    public function updateDroit($objet){
        $this->removeDroits($objet);
        $this->addDroits($objet);
    }

    public function updateParente($objet){
        $this->removeParente($objet);
        $this->addParente($objet);
    }

    public function isUtilisateur($id){
        /*$requete = $this->getDb()->query('SELECT Id_Utilisateur
                                          FROM Utilisateur
                                          WHERE Id_Utilisateur='.$id);

        $requeteAd = $this->getDb()->query('SELECT Id_Utilisateur
                                            FROM Adherent
                                            WHERE Id_Adherent='.$id);*/

        $requeteComp = $this->getDb()->query('SELECT Id_Utilisateur
                                              FROM Competiteur JOIN Adherent ON Competiteur.Id_Adherent = Adherent.Id_Adherent JOIN Utilisateur ON Adherent.Id_Utilisateur = Utilisateur.Id_Utilisateur
                                              WHERE Competiteur.Id_Competiteur='.$id);

        /*$res = $requete->fetch(PDO::FETCH_ASSOC);
        //error_log(print_r($res,true));

        $resAd = $requeteAd->fetch(PDO::FETCH_ASSOC);
        //error_log(print_r($resAd,true));/*

        $resComp = $requeteComp->fetch(PDO::FETCH_ASSOC);
        //error_log(print_r($resComp,true));

        /*if($res!=null){
          return $res;

        }else if($resAd!=null){

          return $resAd;
        }else */if($resComp!=null){

          return $resComp;
        }else{
          return false;
        }
    }

}
?>