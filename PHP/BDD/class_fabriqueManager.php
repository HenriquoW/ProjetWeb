<?php

foreach (glob("ConstructeurManager/*.php") as $filename)
{
    require_once $filename;
}

class FabriqueManager{

    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */
    private $_Constructeurs;

    /*
    *----------------------------------------------------------------
    *CONSTRUCTEUR
    *----------------------------------------------------------------
    */

    //Constructeur qui initialise la liste de constructeur
    public function __construct()
    {
        $this->_Constructeurs["Adherent"] = new ConstructeurManagerAdherent();

        $this->_Constructeurs["Categorie"] = new ConstructeurManagerCategorie();
        $this->_Constructeurs["Club_Organisateur"] = new ConstructeurManagerClub_Organisateur();
        $this->_Constructeurs["Competiteur"] = new ConstructeurManagerCompetiteur();
        $this->_Constructeurs["Competition"] = new ConstructeurManagerCompetition();
        $this->_Constructeurs["Course"] = new ConstructeurManagerCourse();

        $this->_Constructeurs["Droit_Acces"] = new ConstructeurManagerDroit_Acces();

        $this->_Constructeurs["Equipe"] = new ConstructeurManagerEquipe();

        $this->_Constructeurs["Message"] = new ConstructeurManagerMessage();

        $this->_Constructeurs["Palmares"] = new ConstructeurManagerPalmares();

        $this->_Constructeurs["Role"] = new ConstructeurManagerRole();

        $this->_Constructeurs["Sexe"] = new ConstructeurManagerSexe();
        $this->_Constructeurs["Specialite"] = new ConstructeurManagerSpecialite();

        $this->_Constructeurs["Tache"] = new ConstructeurManagerTache();
        $this->_Constructeurs["Type_Competition"] = new ConstructeurManagerType_Competition();
        $this->_Constructeurs["Type_Specialite"] = new ConstructeurManagerType_Specialite();
        $this->_Constructeurs["Type_Voyage"] = new ConstructeurManagerType_Voyage();

        $this->_Constructeurs["Utilisateur"] = new ConstructeurManagerUtilisateur();

        $this->_Constructeurs["Voyage"] = new ConstructeurManagerVoyage();
	}

    public function Types(){
        $liste[]= array();
        foreach($this->_Constructeurs as $nom){
            $liste[] = $nom;
        }
        return $liste;
    }

    public function Construit($Type,$Bd){

        if(!is_string($Type))
        {
            trigger_error('Le type doit être une chaine de caractères',E_USER_WARNING);
        }else{
            return $this->_Constructeurs[$Type]->Cree($Bd);
        }
    }
}

?>
