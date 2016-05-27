<?php

require_once "class_adherent.php";

class Competiteur extends Adherent{
    /*
    *----------------------------------------------------------------
    *ATTRIBUT
    *----------------------------------------------------------------
    */
    private $_Adherent;
    private $_Photo;
    private $_Specialite;
    private $_Categorie;
    private $_Objectif; //tableau avec id competition pour objectif
    private $_CourseParticipe; //tableau avec id course et statut validation dont il participe, id equipe si il participe en equipe
    private $_EquipeParticipe; //tableau avec id equipe dont il fait partit
    private $_Palmares;
    private $_VoyageParticipe;

    /*
    *----------------------------------------------------------------
    *CONSTRUCTEUR
    *----------------------------------------------------------------
    */
    public function __construct(Adherent $user,array $donnees)
    {
        parent::__construct($user);
        $this->hydrate($donnees);
    }

    /*
    *----------------------------------------------------------------
    *GETTER
    *----------------------------------------------------------------
    */

    public function getAdherent(){
        return $this->_Adherent;
    }

    public function getPhoto(){
        return $this->_Photo;
    }

    public function getSpecialite(){
        return $this->_Specialite;
    }

    public function getCategorie(){
        return $this->_Categorie;
    }

    public function getObjectif(){
        return $this->_Objectif;
    }

    public function getCourseParticipe(){
        return $this->_CourseParticipe;
    }

    public function getCourseParticipeId($id){
      foreach ($this->_CourseParticipe as $course) {
        if($course['Id_Course'] == $id){
          return $course;
        }
      }
      return null;
    }

    public function getEquipeParticipe(){
        return $this->_EquipeParticipe;
    }

    public function getPalmares(){
        return $this->_Palmares;
    }

    public function getVoyagePArticipe(){
        return $this->_VoyageParticipe;
    }

    /*
    *----------------------------------------------------------------
    *SETTER
    *----------------------------------------------------------------
    */

    public function setAdherent($Adherent){
        $this->_Adherent = $Adherent;
    }

    public function setPhoto($Photo){
        $this->_Photo = htmlspecialchars($Photo);
    }

    public function setSpecialite($Specialite){
        $this->_Specialite = $Specialite;
    }

    public function setCategorie($Categorie){
        $this->_Categorie = $Categorie;
    }

    public function setObjectif($Objectif){
        $this->_Objectif = $Objectif;
    }

    public function setCourseParticipe($Course){
        $this->_CourseParticipe = $CourseParticipe;
    }

    public function setEquipeParticipe($Equipe){
        $this->_EquipeParticipe = $EquipeParticipe;
    }

    public function setPalmares($Palmares){
        $this->_Palmares = $Palmares;
    }

    public function setVoyageParticipe($Voyage){
        $this->_VoyageParticipe = $Voyage;
    }

    /*
    *----------------------------------------------------------------
    *BODY
    *----------------------------------------------------------------
    */

    public function save($bupdate){
            if($bupdate){
                BDD::getInstance()->getManager("Competiteur")->update($this);

                //update palmares
                foreach($this->_Palmares as $palmares){
                    BDD::getInstance()->getManager("Palmares")->update($palmares);
                }

                //update message
                foreach($this->_Message['Envoyer'] as $message){
                    BDD::getInstance()->getManager("Message")->update($message);
                }

            }else{
                BDD::getInstance()->getManager("Competiteur")->add($this);

                //ajoute palmares
                foreach($this->_Palmares as $palmares){
                    BDD::getInstance()->getManager("Palmares")->add($palmares);
                }

                //ajoute message
                foreach($this->_Message['Envoyer'] as $message){
                    BDD::getInstance()->getManager("Message")->add($message);
                }
            }
        }

}

function loadCompetiteur($info){

    $competiteur = null;

    if(isset($info['Id'])){
        $competiteur = BDD::getInstance()->getManager("Competiteur")->getId($info['Id']);
    }else{
        $competiteur = BDD::getInstance()->getManager("Competiteur")->getMail($info['Mail']);
    }
if($competiteur!=null){
    //recupere specialite (id,nom)
    $competiteur->setSpecialite(BDD::getInstance()->getManager("Specialite")->getId($competiteur->getSpecialite()));

    //recupere categorie (id,nom)
    $competiteur->setCategorie(BDD::getInstance()->getManager("Categorie")->getId($competiteur->getCategorie()));

    //recupere types de voyages (id,nom)
    $voyages;
    foreach($competiteur->getVoyageParticipe() as $voyage){
        $voyage['Type_Voyage'] = BDD::getInstance()->getManager("Type_Voyage")->getId($voyage['Type_Voyage']);

        $voyages[] = $voyage;
    }
    $competiteur->setVoyageParticipe($voyages);

    //recupere palmares
    $palmares;
    foreach($competiteur->getEquipeParticipe() as $idEquipe){
      $palmares = BDD::getInstance()->getManager("Palmares")->getListEquipe($idEquipe);
    }
    $palmares = array_merge($palmares,BDD::getInstance()->getManager("Palmares")->getListCompetiteur($competiteur->getId_Competiteur()));
    
    $competiteur->setPalmares($palmares);

    //recupere message
    $competiteur->setMessage(BDD::getInstance()->getManager("Message")->getListUtilisateur($competiteur->getId_Utilisateur()));

    //recupere le sexe (id,type)
    $competiteur->setSexe(BDD::getInstance()->getManager("Sexe")->getId($competiteur->getSexe()));

    //recupere les droit (id,nom)
    $droits = array();
    foreach($competiteur->getDroit() as $droit){
        $droit = BDD::getInstance()->getManager("Droit_Acces")->getId($droit);

        $droits[] = $droit;
    }
    $competiteur->setDroit($droits);
}
    return $competiteur;
}

function isCompetiteur($id){
  return BDD::getInstance()->getManager("Competiteur")->isCompetiteur($id);
}



?>
