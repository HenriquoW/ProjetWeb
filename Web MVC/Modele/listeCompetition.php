<?php

$res = '';

$competitions = loadListeCompetition(true);
$index =0;
foreach($competitions as $competition){

  $res = $res .'<tr>
                <td>
                  <input type="hidden" name="id_Competition" id="IdCompetition.'.$index.'" value="'.$competition->getId_Competition().'">
                </td>
                <td>
                  <input type="text" placeholder="" name="nom" id="IdNom" value="'.$competition->getTypeCompetition()['Nom'].'-'.$competition->getAdresse().'" readonly/>
                </td>
                <td>
                  <input type="number" placeholder="jour" name="jour" id="IdJour" min="1" max="31" value="'.$competition->getDateCompetition()->format('d').'" readonly/>
                  <input type="number" placeholder="mois" name="mois" id="IdMois" min="1" max="12" value="'.$competition->getDateCompetition()->format('m').'" readonly/>
                  <input type="number" placeholder="année" name="annee" id="IdAnnee" min="1950" max="'.date('Y').'" value="'.$competition->getDateCompetition()->format('Y').'" readonly/>
                </td>
                <td>
                  <input type="text" placeholder="" name="nomClub" id="IdNomClub" value="'.$competition->getClub()->getNom().'" readonly/>
                </td>
                <td>
                  <input type="submit" id="btnDetailCompetition" module="PageCompetition" regionSucess="#competition" regionError="#listeCompetition" donne="Competition.'.$index.'" value="Details"/>
                ';

  if($_SESSION['UtilisateurEnCours']->asDroit(array("Entraineur","Secretaire"))){
    $res = $res .'<input type="submit" id="btnModifierCompetition" module="ModifierCompetition" regionSucess="#competition" regionError="#listeCompetition" donne="Competition.'.$index.'" value="Modifier"/>';
  }

  $res = $res .'</td></tr>';
  $index++;
}

$_SESSION['Retour'] = $res;
 ?>
