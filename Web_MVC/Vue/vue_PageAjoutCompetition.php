<?php

$infoClub ='';
foreach (BDD::getInstance()->getManager("Club_Organisateur")->getList() as $club) {
  $infoClub = $infoClub.'<option value="'.$club->getId_Club_Organisateur().'" >'.$club->getNom().'</option>';
}

$infoType ='';
foreach (BDD::getInstance()->getManager("Type_Competition")->getList() as $type) {
  $infoType = $infoType.'<option value="'.$type['Id'].'" >'.$type['Nom'].'</option>';
}

$infoSexe ='';
foreach (BDD::getInstance()->getManager("Sexe")->getList() as $sexe) {
  $infoSexe = $infoSexe.'<option value="'.$sexe['Id'].'" >'.$sexe['Type'].'</option>';
}

$response_array = array();
$response_array['Status'] = "Success";
$response_array['Type'] = "Replace";
$response_array['Donne'] = '<div class="div_AjoutCompetition_global">
                            <div class="div_AjoutCompetition">
			    <h2>Ajout d&apos;une compétition</h2>
                            <label>Adresse de la compétition</label> <input type="text" placeholder="" name="adresse" id="IdAdresse" value="" /><br/>

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

                            <label>Type de competition</label> <select name="TypeCompetition" id="IdType" readonly>
                                                                      <option value="New" selected="selected">Nouveau Type de compétition</option>
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

                            <input type="submit" name="Ajouter" id="btnAjouterCompetition" module="AjouterCompetition;PageListeCompetition" regionSucess="#competition;#body" regionError="#competition;#body" donne="Adresse;Jour;Mois;Annee;Club;NomClub;NomPresident;Type;Sexe" value="Ajouter"/>
                            </div>
                            <div class="horizontal_separator"></div>
                            </div>';
$response_array['Stop'] = "false";
$response_array['Region'] = $_POST['regionSucess'];

header('Content-type: application/json');
echo json_encode($response_array);




 ?>
