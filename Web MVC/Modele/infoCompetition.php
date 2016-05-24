<?php

$competition = loadCompetition(array("Id"=>$data['Competition']));

$infoCourse = '<input type="hidden" name="id_competition" id="IdCompetition" value="'.$data['Competition'].'" readonly/>';
$index = 0;
foreach (loadCourseCompetition($competition->getId_Competition()) as $course) {
  $infoCourse = $infoCourse .'<tr>
  <td>
  <input type="hidden" name="id_course" id="IdCourse.'.$index.'" value="'.$course->getId_Course().'" readonly/>
  <input type="text" name="distance" value="'.$course->getDistance().'" readonly/><br/>
  <input type="text" name="categorie" value="'.$course->getCategorie()['Nom'].'" readonly/><br/>
  <input type="text" name="typeEmbarcation" value="'.$course->getTypeSpecialite()['Nom'].'" readonly/><br/>
  </td>
  ';

  $courseParticipe = $_SESSION['UtilisateurCourant']->getCourseParticipeId($course->getId_Course());

  if($_SESSION['UtilisateurCourant']->asDroit(array("Competiteur","Parent"))){ // on regarde si l'utilisateur est un competiteur ou un parent

    if(!isset($courseParticipe)){// si le competiteur ne participe pas

      if($course->getIsEquipe()){ //si la course est en equipe

        if($_SESSION['UtilisateurCourant']->asDroit("Competiteur")){// si l'utilisateur est un competiteur
          $infoCourse = $infoCourse .'<th>Selection Equipe</th><tr>';

          $infoCourse = $infoCourse .'<td><select name="Equipe" id="IdEquipe.'.$index.'" onchange="if(this.selectedIndex == 0){$(".NewEquipe").show();}else{$(".NewEquipe").hide();}" readonly>
          <option value="New" selected="selected">Nouvelle Equipe</option>';

          foreach($_SESSION['UtilisateurCourant']->getEquipeParticipe() as $IdEquipe){ //prend les equipe du competiteur en cours
            $equipe = loadEquipe(array("Id"=>$IdEquipe));

            if($equipe->getTypeSpecialite() == $course->getTypeSpecialite())
            $infoCourse = $infoCourse .'<option value="'.$IdEquipe.'"> '.$equipe->getNom().'</option>';

            unset($equipe);
          }

          $infoCourse = $infoCourse .'</select></td>';

          $competiteurs = BDD::getInstance()->getManager("Competiteur")->getListCategorie($_SESSION['UtilisateurCourant']->getCategorie());

          for(int $i=1;$i<str_split($course->getTypeSpecialite()['Nom'])[1];$i++){ //on recupere le chiffre a la fin du type ex: K2 et on ajoute les combobox

            $infoCourse = $infoCourse .'<td><select class="NewEquipe" id="IdParticipant'.$i.'.'.$index.'"readonly>';

            foreach($competiteurs as $competiteur){// on remplit les combobox avec les competiteurs de la meme categorie
              $infoCourse = $infoCourse .'<option value="'.$competiteur->getId_Competiteur().'">'.$competiteur->getPrenom().' '.$competiteur->getNom().'</option>';
            }

            $infoCourse = $infoCourse .'</select></td>';
            unset($competiteurs);

            $infoCourse = $infoCourse .'<td><input type="input" name="Inscrit" id="btnInscritCourse" module="InscriptionCourse;PageCompetition" regionSucess="#competition" regionError="#competition" donne="Competition;Course.'.$index.';Equipe.'.$index.';Participant1.'.$index.';Participant2.'.$index.';Participant3.'.$index.'" value="Inscrire"/></td></tr>';

          }
        }

        if($_SESSION['UtilisateurCourant']->asDroit("Parent")){// si l'utilisateur est un parent
          $infoCourse = $infoCourse .'<th>Selection Equipe Enfant</th><tr>';

          $IdEnfants = $_SESSION['UtilisateurCourant']->getParente()['Enfant'];

          $infoCourse = $infoCourse .'<td><select name="Enfant" id="IdEnfant.'.$index.'" readonly>';

          foreach($IdEnfants as $IdEnfant){ // on prend tous ces enfants

            if($idComp = isCompetiteur($IdEnfant)){// on regarde si l'enfant est un competiteur
              $enfant = loadCompetiteur(array("Id"=>$idComp));

              $infoCourse = $infoCourse .'<option value="'.$enfant->getId_Competiteur().'">'.$enfant->getPrenom().' '.$enfant->getNom().'</option>';
            }

          }

          $infoCourse = $infoCourse .'</select></td>';

          $competiteurs = BDD::getInstance()->getManager("Competiteur")->getListMineur();

          for(int $i=1;$i<str_split($course->getTypeSpecialite()['Nom'])[1];$i++){ //on recupere le chiffre a la fin du type ex: K2 et on ajoute les combobox

            $infoCourse = $infoCourse .'<td><select class="NewEquipe" id="IdParticipantEnfant'.$i.'.'.$index.'"readonly>';

            foreach($competiteurs as $competiteur){// on remplit les combobox avec les competiteurs de la meme categorie
              $infoCourse = $infoCourse .'<option value="'.$competiteur->getId_Competiteur().'">'.$competiteur->getPrenom().' '.$competiteur->getNom().'</option>';
            }

            $infoCourse = $infoCourse .'</select></td>';
          }
          unset($competiteurs);

          $infoCourse = $infoCourse .'<td><input type="input" name="Inscrit" id="btnInscritCourse" module="InscriptionCourse;PageCompetition" regionSucess="#competition" regionError="#competition" donne="Competition;Course.'.$index.';Enfant.'.$index.';ParticipantEnfant1.'.$index.';ParticipantEnfant2.'.$index.';ParticipantEnfant3.'.$index.'" value="Inscrire"/></td></tr>';
        }

        if($_SESSION['UtilisateurCourant']->asDroit("Entraineur")){

          $infoCourse = $infoCourse .'<th>Validation Equipe</th><tr>';

          $i=0;
          foreach ($course->getParticipant() as $IdParticipant) {
            $equipe = loadEquipe(array("Id"=>$IdParticipant['Id_Equipe']));

            $infoCourse = $infoCourse .'<td>'.$equipe->getNom().'</td>';

            if(!$IdParticipant['Validation']){
              $infoCourse = $infoCourse .'<td><input type="hidden" name="id_equipeValider" id="IdEquipeValider'.$i.'.'.$index.'" value="'.$equipe->getId_Equipe().'" readonly/>';
              $infoCourse = $infoCourse .'<input type="input" name="Validation" id="btnValidationEquipe" module="ValidationEquipe;PageCompetition" regionSucess="#competition" regionError="#competition" donne="Competition;Course."'.$index.';EquipeValider'.$i.'.'.$index.'</td>';
            }else{
                $infoCourse = $infoCourse .'<td>Valider</td>';
            }

            $i++;
          }

          $infoCourse = $infoCourse .'</tr>';
        }

      }else{// si la course est en solo
        if($_SESSION['UtilisateurCourant']->asDroit("Parent")){ // si l'utilisateur est un parent
          $infoCourse = $infoCourse .'<th>Selection Enfant</th><tr>';

          $IdEnfants = $_SESSION['UtilisateurCourant']->getParente()['Enfant'];

          $infoCourse = $infoCourse .'<td><select name="Enfant" id="IdEnfant.'.$index.'" readonly>';

          foreach($IdEnfants as $IdEnfant){ // on prend tous ces enfants

            if($idComp = isCompetiteur($IdEnfant)){// on regarde si l'enfant est un competiteur
              $enfant = loadCompetiteur(array("Id"=>$idComp));

              $infoCourse = $infoCourse .'<option value="'.$enfant->getId_Competiteur().'">'.$enfant->getPrenom().' '.$enfant->getNom().'</option>';
            }

          }

          $infoCourse = $infoCourse .'</select></td>';

          $infoCourse = $infoCourse .'<td><input type="input" name="Inscrit" id="btnInscritCourse" module="InscriptionCourse;PageCompetition" regionSucess="#competition" regionError="#competition" donne="Competition;Course.'.$index.';Enfant.'.$index.'" value="Inscrire"/></td></tr>';

        }

        if($_SESSION['UtilisateurCourant']->asDroit("Competiteur")){
          $infoCourse = $infoCourse .'<td><input type="input" name="Inscrit" id="btnInscritCourse" module="InscriptionCourse;PageCompetition" regionSucess="#competition" regionError="#competition" donne="Competition;Course.'.$index.'" value="Inscrire"/></td>>';
        }

        if($_SESSION['UtilisateurCourant']->asDroit("Entraineur")){

          $infoCourse = $infoCourse .'<th>Validation Equipe</th><tr>';

          $i=0;
          foreach ($course->getParticipant() as $IdParticipant) {
            $comp = loadCompetiteur(array("Id"=>$IdParticipant['Id_Competiteur']));

            $infoCourse = $infoCourse .'<td>'.$comp->getNom().'</td>';

            if(!$IdParticipant['Validation']){
              $infoCourse = $infoCourse .'<td><input type="hidden" name="id_competiteureValider" id="IdCompetiteurValider'.$i.'.'.$index.'" value="'.$comp->getId_Competiteur().'" readonly/>';
              $infoCourse = $infoCourse .'<input type="input" name="Validation" id="btnValidationCompetiteur" module="ValidationCompetiteur;PageCompetition" regionSucess="#competition" regionError="#competition" donne="Competition;Course."'.$index.';CompetiteurValider'.$i.'.'.$index.'</td>';
            }else{
                $infoCourse = $infoCourse .'<td>Valider</td>';
            }
            $i++;
          }

          $infoCourse = $infoCourse .'</tr>';
        }
      }
    }else{
      $infoCourse = $infoCourse .'<td><input type="text" name="Inscrit" id="IdInscrit" value="'.$courseParticipe['Validation'].'" readonly/></td>';
    }
  }
  $infoCourse = $infoCourse .'</tr>';
  $index++;
}

$infoVoyage = '<tr><th>Informations Voyage</th>';
$voyage = loadVoyageCompetition($competition->getId_Competition());

$infoVoyage = $infoVoyage .'<tr>
<td>'.$voyage->getTransport().'</td>
<td>'.$voyage->getHebergement().'</td>
</tr>';
$infoVoyage = $infoVoyage .'<th>Participants</th>';

foreach ($voyage->getParticipe() as $infoParticipant){
  $participant = loadCompetiteur(array('Id' => $infoParticipant["Id_Competiteur"]));

  $infoVoyage = $infoVoyage .'<tr>
  <td>'.$participant->getNom().' '.$participant->getPrenom().'</td>
  <td>'.$infoParticipant['Type_Voyage']['Nom'].'</td>';

  if($infoParticipant['Type_Voyage']['Nom']!="Club"){
    $uti = loadUtilisateur(array("Id" => $infoParticipant['Id_Utilisateur']));
    $infoVoyage = $infoVoyage .'<td>'.$uti->getNom().' '.$uti->getPrenom().'</td>';
  }

  if($participant->getDateNaissance()->diff(new DateTime())->format('Y')<18){
    $infoVoyage = $infoVoyage .'<td>'.$infoParticipant['Autoriser'].'</td>';
  }

  $infoVoyage = $infoVoyage .'</tr>';
}

$infoVoyage = $infoVoyage .'<th>Charge</th>';

foreach ($voyage->getCharge() as $infoCharge){
  $uti = loadUtilisateur(array('Id' => $infoCharge["Id_Utilisateur"]));

  $infoVoyage = $infoVoyage .'<tr>
  <td>'.$uti->getNom().' '.$uti->getPrenom().'</td>
  <td>'.$infoCharge['Role']['Nom'].'</td>
  <td>'.$infoCharge['Tache']['Nom'].'</td></tr>';
}


$res['Course'] = $infoCourse;
$res['Voyage'] = $infoVoyage;

$_SESSION['Retour'] = $res;

?>
