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
        $this->_Constructeurs["Utilisateur"] = new ConstructeurManagerUtilisateur();
        $this->_Constructeurs["Adherent"] = new ConstructeurManagerAdherent();
        $this->_Constructeurs["Competiteur"] = new ConstructeurManagerCompetiteur();
        $this->_Constructeurs["Equipe"] = new ConstructeurManagerEquipe();
        $this->_Constructeurs["Epreuve"] = new ConstructeurManagerEpreuve();
        $this->_Constructeurs["Competition"] = new ConstructeurManagerCompetition();
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
