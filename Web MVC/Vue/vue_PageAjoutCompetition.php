<?php

$infoClub ='';
foreach (BDD::getInstance()->getManager("Club_Organisateur")->getList() as $club) {
  $infoClub = $infoClub.'<option value="'.$club->getId_Club_Organisateur().'" >'.$club->getNom().'</option>';
}

$infoType ='';
foreach (BDD::getInstance()->getManager("Type_Competition")->getList() as $type) {
  $infoType = $infoType.'<option value="'.$type['Id'].'" >'.$type['Nom'].'</option>';
}

$response_array = array();
$response_array['Status'] = "Success";
$response_array['Type'] = "Replace";
$response_array['Donne'] = '<label>Adresse de la compétition</label> <input type="text" placeholder="" name="adresse" id="IdAdresse" value="" /><br/>

                            <label>Date de la compétition</label> <input type="number" placeholder="jour" name="jour" id="IdJour" min="1" max="31" value="" />
                            <input type="number" placeholder="mois" name="mois" id="IdMois" min="1" max="12" value="" />
                            <input type="number" placeholder="année" name="annee" id="IdAnnee" min="1950" max="'.date('Y').'" value="" /><br/>

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

                            <label>Type de competition</label> <select name="TypeCompetition" id="IdType" onchange="if(this.selectedIndex == 0){$("#NewType").show();}else{$("#NewType").hide();}" readonly>
                                                                      <option value="New" selected="selected">Nouveau Club</option>
                                                                    '.
                                                                    $infoType
                                                                    .'
                                                                    </select></br>
                            <div id="NewType">
                              <label>Nom du Type</label> <input type="text" placeholder="" name="nom" id="IdNomType" value="" /><br/>
                              <label>La competition est-elle sélectif ?</label> <select name="selectif" id="IdSelectif" readonly/>
                                                                                  <option value="false">Non</option>
                                                                                  <option value="true">Oui</option>
                                                                                </select>
                            </div>

                            <input type="input" name="Modifier" id="btnAjouterCompetition" module="AjouterCompetition;PageListeCompetition" regionSucess="#competition" regionError="#competition" donne="Adresse;Jour;Mois;Annee;Club;NomClub;NomPresident;Type;NomType;Selectif" value="Modifier"/>';
$response_array['Stop'] = "false";
$response_array['Region'] = $_POST['regionSucess'];

header('Content-type: application/json');
echo json_encode($response_array);




 ?>
