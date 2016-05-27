<?php
$competition = loadCompetition(array("Id"=>$data['Competition']));

$infoCourse = '';
$index = 0;
foreach (loadCourseCompetition($competition->getId_Competition()) as $course) {
  $infoCat ='';
  foreach (BDD::getInstance()->getManager("Categorie")->getList() as $cat) {
    $infoCat = $infoCat.'<option value="'.$cat["Id"].'" '.(($cat["Nom"]==$course->getCategorie()["Nom"])?('selected="selected"'):('')).'>'.$cat["Nom"].'</option>';
  }

  $infoSpe ='';
  foreach (BDD::getInstance()->getManager("Type_Specialite")->getList() as $spe) {
    $infoSpe = $infoSpe.'<option value="'.$spe["Id"].'" '.(($spe["Nom"]==$course->getCategorie()["Nom"])?('selected="selected"'):('')).'>'.$spe["Nom"].'</option>';
  }

  $infoCourse = $infoCourse .'<tr>
                                <td>
                                  <input type="text" name="distance" id="IdDistance_'.$index.'" value="'.$course->getDistance().'" />
                                </td>
                                <td>
                                  <select name="Categorie" id="IdCategorie_'.$index.'" readonly>
                                  '.
                                    $infoCat
                                  .'
                                  </select>
                                </td>
                                <td>
                                  <select name="Categorie" id="IdSpecialite_'.$index.'" readonly>
                                  '.
                                    $infoSpe
                                  .'
                                  </select>
                                </td>
                                <td>
                                  <input type="submit" name="Modifier" id="btnSaveCourse" module="SaveCourse;PageCompetition" regionSucess="#competition;#competition" regionError="#competition;#competition" donne="Competition;Course_'.$index.';Distance_'.$index.';Categorie_'.$index.';Specialite_'.$index.'" value="Modifier"/>
                                </td>
                                <td>
                                  <input type="submit" name="Supprimer" id="btnSupprimerCourse" module="SupprimerCourse;PageCompetition" regionSucess="#competition;#competition" regionError="#competition;#competition" donne="Competition;Course_'.$index.'" value="Modifier"/>
                                </td>
                              </tr>';
  $index++;
}

$infoCat ='';
foreach (BDD::getInstance()->getManager("Categorie")->getList() as $cat) {
  $infoCat = $infoCat.'<option value="'.$cat["Id"].'" >'.$cat["Nom"].'</option>';
}

$infoSpe ='';
foreach (BDD::getInstance()->getManager("Type_Specialite")->getList() as $spe) {
  $infoSpe = $infoSpe.'<option value="'.$spe["Id"].'">'.$spe["Nom"].'</option>';
}

$infoCourse = $infoCourse .'<tr>
                              <td>
                                <input type="text" name="distance" id="IdDistance_'.$index.'" value="" />
                              </td>
                              <td>
                                <select name="Categorie" id="IdCategorie_'.$index.'" readonly>
                                '.
                                  $infoCat
                                .'
                                </select>
                              </td>
                              <td>
                                <select name="Categorie" id="IdSpecialite_'.$index.'" readonly>
                                '.
                                  $infoSpe
                                .'
                                </select>
                              </td>
                              <td>
                                <input type="submit" name="Ajouter" id="btnAjouterCourse" module="AjouterCourse;PageCompetition" regionSucess="#competition;#competition" regionError="#competition;#competition" donne="Competition;Distance_'.$index.';Categorie_'.$index.';Specialite_'.$index.'" value="Ajouter"/>
                              </td>
                            </tr>';

$infoVoyage = '<tr><th>Informations Voyage</th>';
$voyage = loadVoyageCompetition($competition->getId_Competition());

if($voyage!=null){
  $infoVoyage = $infoVoyage .'<tr>
  <td><input type="hidden" name="id_voyage" id="IdVoyage" value="'.$voyage->getId_Voyage().'" readonly/></td>
  <td><input type="text" name="voyageTransport" id="IdTransport" value="'.$voyage->getTransport().'" /></td>
  <td><input type="text" name="voyageHebergement" id="IdHebergement" value="'.$voyage->getHebergement().'" /></td>
  <td><input type="submit" name="SaveVoyage" id="btnSaveVoyage" module="SaveVoyage;PageCompetition" regionSucess="#competition;#competition" regionError="#competition;#competition" donne="Competition;Voyage;Transport;Hebergement" value="Modifier"/></td>
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

  $index = 0;

  $listTache = BDD::getInstance()->getManager("Tache")->getList();

  $listRole = BDD::getInstance()->getManager("Role")->getList();

  foreach ($voyage->getCharge() as $infoCharge){
    $uti = loadUtilisateur(array('Id' => $infoCharge["Id_Utilisateur"]));

    $charge = '<td><select name="role" id="IdRole_'.$index.'" disabled>';

    foreach($listRole as $role) {
      $charge = $charge . '<option value="'.$role['Id'].'" '.(($role['Nom']==$infoCharge['Role']['Nom'])?('selected="selected"'):('')).'>'.$role['Nom'].'</option>';
    }

    $charge = $charge .'</select></td>
    <td><input type="submit" name="SupprimerRole" id="btnSupprimerRole" module="SupprimeRole;PageCompetition" regionSucess="#competition;#competition" regionError="#competition;#competition" donne="Competition;Voyage;UtilisateurCharge_'.$index.';Role_'.$index.'" value="Supprimer"/></td>

    <td><select name="role" id="IdTache_'.$index.'" disabled>';

    foreach($listTache as $tache) {
      $charge = $charge . '<option value="'.$tache['Id'].'" '.(($tache['Nom']==$infoCharge['Tache']['Nom'])?('selected="selected"'):('')).'>'.$tache['Nom'].'</option>';
    }

    $charge = $charge .'</select></td>
    <td><input type="submit" name="SupprimerTache" id="btnSupprimerTache" module="SupprimeTache;PageCompetition" regionSucess="#competition;#competition" regionError="#competition;#competition" donne="Competition;Voyage;UtilisateurCharge_'.$index.';Tache'.$index.'" value="Supprimer"/></td>';

    $infoVoyage = $infoVoyage .'<tr>
    <td><input type="text" name="voyageHebergement" id="IdUtilisateurChargeNom" value="'.$uti->getNom().' '.$uti->getPrenom().'" /><input type="hidden" name="IdUtilisateurCharge" id="IdUtilisateurCharge_'.$index.'" value="'.$uti->getId_Utilisateur().'" /></td>
    '.
    $charge
    .'
    </tr>
    ';

    $index++;
  }

  $listUtilisateur = BDD::getInstance()->getManager("Utilisateur")->getListMajeur();

  $addCharge = '<td><select name="role" id="IdUtilisateurCharge_'.$index.'" readonly>';

  foreach($listUtilisateur as $ut){
    $addCharge = $addCharge . '<option value="'.$ut->getId_Utilisateur().'">'.$ut->getNom().' '.$ut->getPrenom().'</option>';
  }

  $addCharge = $addCharge .'</select></td>

  <td><select name="role" id="IdRole_'.$index.'" readonly>';

  foreach($listRole as $role) {
    $addCharge = $addCharge . '<option value="'.$role['Id'].'">'.$role['Nom'].'</option>';
  }

  $addCharge = $addCharge .'</select></td>

  <td><select name="role" id="IdTache_'.$index.'" readonly>';

  foreach($listTache as $tache) {
    $addCharge = $addCharge . '<option value="'.$tache['Id'].'">'.$tache['Nom'].'</option>';
  }

  $infoVoyage = $infoVoyage .'<tr>
                                '.
                                  $addCharge
                                .'
                                <td><input type="submit" name="AjouteCharge" id="btnAjouteCharge" module="AjouteCharge;PageCompetition" regionSucess="#competition;#competition" regionError="#competition;#competition" donne="Competition;Voyage;UtilisateurCharge_'.$index.';Tache'.$index.';Role_'.$index.'" value="Ajouter"/></td>
                              </tr>';

}



$infoClub ='';
foreach (BDD::getInstance()->getManager("Club_Organisateur")->getList() as $club) {
  $infoClub = $infoClub.'<option value="'.$club->getId_Club_Organisateur().'" '.(($club==$competition->getClub())?('selected="selected"'):('')).'>'.$club->getNom().'</option>';
}

$infoType ='';
foreach (BDD::getInstance()->getManager("Type_Competition")->getList() as $type) {
  $infoType = $infoType.'<option value="'.$type['Id'].'" '.(($type['Nom']==$competition->getTypeCompetition()['Nom'])?('selected="selected"'):('')).'>'.$type['Nom'].'</option>';
}

$infoSexe ='';
foreach (BDD::getInstance()->getManager("Sexe")->getList() as $sexe) {
  $infoSexe = $infoSexe.'<option value="'.$sexe['Id'].'" '.(($sexe['Nom']==$competition->getSexe()['Nom'])?('selected="selected"'):('')).'>'.$sexe['Nom'].'</option>';
}

$response_array = array();
$response_array['Status'] = "Success";
$response_array['Type'] = "Replace";
$response_array['Donne'] = '<input type="hidden" name="id_Competition" id="IdCompetition" value="'.$competition->getId_Competition().'">

                            <label>Adresse de la compétition</label> <input type="text" placeholder="" name="adresse" id="IdAdresse" value="'.$competition->getAdresse().'" /><br/>

                            <label>Date de la compétition</label> <input type="number" placeholder="jour" name="jour" id="IdJour" min="1" max="31" value="'.$competition->getDateCompetition()->format('d').'" />
                            <input type="number" placeholder="mois" name="mois" id="IdMois" min="1" max="12" value="'.$competition->getDateCompetition()->format('m').'" />
                            <input type="number" placeholder="année" name="annee" id="IdAnnee" min="1950" max="'.date('Y').'" value="'.$competition->getDateCompetition()->format('Y').'" /><br/>
                            <label>Nom du club organisateur</label> <select name="Club" id="IdClub" onchange="if(this.selectedIndex == 0){$("#NewClub").show();}else{$("#NewClub").hide();}" readonly>
                                                                      <option value="New" selected="selected">Nouveau Club</option>
                                                                    '.
                                                                    $infoClub
                                                                    .'
                                                                    </select></br>
                            <div id="NewClub">
                              <label>Nom du club</label> <input type="text" placeholder="" name="nom" id="IdNomClub" value="" /><br/>
                              <label>Nom du President</label> <input type="text" placeholder="" name="president" id="IdNomPresident" value="" /><br/>
                            </div>
                            <label>Type de competition</label> <select name="TypeCompetition" id="IdType" readonly>
                                                                    '.
                                                                    $infoType
                                                                    .'
                                                                    </select></br>
                            <label>Limitation de sexe</label> <select name="limiteSexe" id="IdSexe" readonly>
                                                                  <option value="Aucune" selected="selected">Aucune</option>
                                                                    '.
                                                                    $infoSexe
                                                                    .'
                                                                    </select></br>

                            <input type="submit" name="Modifier" id="btnSaveCompetition" module="SaveCompetition;PageCompetition" regionSucess="#competition;#competition" regionError="#competition;#competition" donne="Competition;Adresse;Jour;Mois;Annee;Club;NomClub;NomPresident;Type;Sexe" value="Modifier"/>

                            <table name="InfoEpreuve">
                            '.
                              $infoCourse;
                            .'
                            </table>

                            <table name="InfoVoyage>"
                              '.$infoVoyage.'
                            </table>';
$response_array['Stop'] = "false";
$response_array['Region'] = $_POST['regionSucess'];

header('Content-type: application/json');
echo json_encode($response_array);


 ?>
