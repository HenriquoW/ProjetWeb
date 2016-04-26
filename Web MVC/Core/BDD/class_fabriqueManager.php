<?php

// ca veut pas autrement donc c'est comme ca
require_once "ConstructeurManager/class_constructeurManagerAdherent.php";
require_once "ConstructeurManager/class_constructeurManagerCategorie.php";
require_once "ConstructeurManager/class_constructeurManagerClub_Organisateur.php";
require_once "ConstructeurManager/class_constructeurManagerCompetiteur.php";
require_once "ConstructeurManager/class_constructeurManagerCompetition.php";
require_once "ConstructeurManager/class_constructeurManagerCourse.php";
require_once "ConstructeurManager/class_constructeurManagerDroit_Acces.php";
require_once "ConstructeurManager/class_constructeurManagerEquipe.php";
require_once "ConstructeurManager/class_constructeurManagerMessage.php";
require_once "ConstructeurManager/class_constructeurManagerPalmares.php";
require_once "ConstructeurManager/class_constructeurManagerRole.php";
require_once "ConstructeurManager/class_constructeurManagerSexe.php";
require_once "ConstructeurManager/class_constructeurManagerSpecialite.php";
require_once "ConstructeurManager/class_constructeurManagerTache.php";
require_once "ConstructeurManager/class_constructeurManagerType_Competition.php";
require_once "ConstructeurManager/class_constructeurManagerType_Specialite.php";
require_once "ConstructeurManager/class_constructeurManagerType_Voyage.php";
require_once "ConstructeurManager/class_constructeurManagerUtilisateur.php";
require_once "ConstructeurManager/class_constructeurManagerVoyage.php";

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
        $tab = array();
        $tab["Adherent"] = new ConstructeurManagerAdherent();

        $tab["Categorie"] = new ConstructeurManagerCategorie();
        $tab["Club_Organisateur"] = new ConstructeurManagerClub_Organisateur();
        $tabs["Competiteur"] = new ConstructeurManagerCompetiteur();
        $tab["Competition"] = new ConstructeurManagerCompetition();
        $tab["Course"] = new ConstructeurManagerCourse();

        $tab["Droit_Acces"] = new ConstructeurManagerDroit_Acces();

        $tab["Equipe"] = new ConstructeurManagerEquipe();

        $tab["Message"] = new ConstructeurManagerMessage();

        $tab["Palmares"] = new ConstructeurManagerPalmares();

        $tab["Role"] = new ConstructeurManagerRole();

        $tab["Sexe"] = new ConstructeurManagerSexe();
        $tab["Specialite"] = new ConstructeurManagerSpecialite();

        $tab["Tache"] = new ConstructeurManagerTache();
        $tab["Type_Competition"] = new ConstructeurManagerType_Competition();
        $tab["Type_Specialite"] = new ConstructeurManagerType_Specialite();
        $tab["Type_Voyage"] = new ConstructeurManagerType_Voyage();

        $tab["Utilisateur"] = new ConstructeurManagerUtilisateur();

        $tab["Voyage"] = new ConstructeurManagerVoyage();

        $this->_Constructeurs = $tab;
	}

    public function Types(){
        $liste;

        foreach ($this->_Constructeurs as $key => $value) {
          $liste[] = $key;
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
