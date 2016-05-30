<?php
$response_array = array();

if(isset($_COOKIE['Connect'])){

  if($_SESSION['UtilisateurCourant']->asDroit("Parent") && isset($data['Enfant'])){

    $id = isCompetiteurUtilisateur($data['Enfant']);
    if($id){
      $inf["Id"] = $id['Id_Competiteur'];
      $UtilisateurEnCours = loadCompetiteur($inf);
    }else{
	$id = isAdherentUtilisateur($data['Enfant']);
	if($id){
	      $inf["Id"] = $id['Id_Adherent'];
	      $UtilisateurEnCours = loadAdherent($inf);
	}else{
	      $inf["Id"] = $data['Enfant'];
	      $UtilisateurEnCours = loadUtilisateur($înf);
    	}
    }
  }else{
    $UtilisateurEnCours = $_SESSION['UtilisateurCourant'];
  }
  $ClasseUtilisateur = get_class($UtilisateurEnCours);

  $listObjectif = '';
  if($ClasseUtilisateur == 'Competiteur'){
    foreach ($UtilisateurEnCours->getObjectif() as $objectif) {
      $compet = loadCompetition(array("Id"=>$objectif));

      $listObjectif = $listObjectif . ''.$compet->getTypeCompetition()['Nom'].'-'.$compet->getAdresse().'';
    }
  }


  $objectif ='';
  if($ClasseUtilisateur == 'Competiteur'){
    $objectif = $objectif . '<label> Ajout Objectif(s) :</label>
                              <select name="Competition" id="IdNewObjectif" readonly>';

    $competitions = BDD::getInstance()->getManager("Competition")->getListEnCours();

    foreach($competitions as $competition){
      $objectif = $objectif . '<option value="'.$competition->getId_Competition().'">'.$competition->getTypeCompetition()['Nom'].'-'.$competition->getAdresse().'</option>';
    }

    $objectif = $objectif . '</select>
                              <input type="submit" id="btnAjouterObjectif" module="AddObjectif" regionSucess="#Objectif" regionError="#Objectif" donne="Utilisateur;NewObjectif" value="Ajouter Objectif"';
  }

  $response_array['Status'] = "Success";
  $response_array['Type'] = "Replace";
  $response_array['Donne'] = '
  <div class="div_modifierProfil_global">
      <div class="div_modifierProfil">
        <h2>Modifier votre profil</h2>
          <input type="hidden" name="id_Utilisateur" id="IdUtilisateur" value="'.$UtilisateurEnCours->getId_Utilisateur().'">
          <p>

            '. (($ClasseUtilisateur == 'Competiteur') ? ('<p><img src="'.$UtilisateurEnCours->getPhoto().'" alt="probleme affichage"/>
                                                        </br>
                                                        <label> Photo </label>
                                                        <input id="IdPhoto" name="photo" type="file"/>
                                                        </br></p>')
                                                      : '')
            .'

            <p>
              <label style="padding-left: 20px;"> Nom :</label>
                    <input id="IdNom" name="nom" value="'.$UtilisateurEnCours->getNom().'" type="text" /> <br/>
              <label> Prenom :</label>
                    <input id="IdPrenom" name="prenom" value="'.$UtilisateurEnCours->getPrenom().'" type="text" /> <br/>
            '.
            (($UtilisateurEnCours->getSexe()['Type']=='F') ? ('<select name="Sexe" id="IdSexe" readonly>
                                                                <option value="Homme">Homme</option>
                                                                <option value="Femme" selected="selected" >Femme</option>
                                                              </select>')
                                                           : ('<select name="Sexe" id="IdSexe" readonly>
                                                               <option value="Homme" selected="selected">Homme</option>
                                                               <option value="Femme">Femme</option>
                                                             </select>  <br/>'))
            .'

              <label>Date de naissance :</label> <br/>
              <label> Jour </label>
                <input id="IdJour" name="jour" type="number" min="1" max="31" value="'.$UtilisateurEnCours->getDateNaissance()->format('d').'"/>
              <label> Mois </label>
                <input id="IdMois" name="mois" type="number" min="1" max="12" value="'.$UtilisateurEnCours->getDateNaissance()->format('m').'"/>
              <label> Annee </label>
                <input id="IdAnnee" name="annee" type="number" min="1920" max="2016" value="'.$UtilisateurEnCours->getDateNaissance()->format('Y').'"/> <br/>

            <br/>
            <label style="margin-left: -41px;"> Mot de passe</label>
             <input id="IdPassword1" name="mdp" type="text" value="" /> <br/>
            <label style="margin-left: -115px;">Confirmer mot de passe</label>
             <input id="IdPassword2" name="mdp" type="text" value="" /> <br/>
            <label style="padding-left: 15px;"> Email </label>
             <input id="IdMail" name="email" type="email" value="'.$UtilisateurEnCours->getMail().'"/> <br/>
            <label style="margin-left: -18px;"> Telephone </label>
             <input id="IdTelephone" name="telephone" type="tel" pattern="[0-9]{10}" value="'.$UtilisateurEnCours->getTelephone().'"/> <br/>


            <label>Adresse complete :</label> <br/>
             <textarea id="IdAdresse" name="adresse" rows="7" cols="50" >'.$UtilisateurEnCours->getAdresse().'</textarea> <br/>
            <br/>

            '.
            (($ClasseUtilisateur == 'Adherent' || $ClasseUtilisateur == 'Competiteur') ? ('<label> N° Licence </label>
                                                                                                     <input id="IdNumLicence" name="num_licence" type="number"  value="'.$UtilisateurEnCours->getNumeroLicence().'"/> <br/>')
                                                                                                  : ('<label> N° Licence </label>
                                                                                                     <input id="IdNumLicence" name="num_licence" type="number"  value=""/> <br/>'))
            .'

            '.
            (($ClasseUtilisateur == 'Competiteur') ? ('<label> Specialite </label> </br>
                                                      <label> Kayak </label>'.
                                                      (($UtilisateurEnCours->getSpecialite()== "Kayak") ? ('<select name="specialite" id="IdSpecialite" readonly>
                                                                                                              <option value="Kayak" selected="selected" >Kayak</option>
                                                                                                              <option value="Canoe">Canoe</option>
                                                                                                            </select></br>')
                                                                                                        : ('<select name="specialite" id="IdSpecialite" readonly>
                                                                                                            <option value="Kayak">Kayak</option>
                                                                                                            <option value="Canoe"  selected="selected" >Canoe</option>
                                                                                                          </select> </br>'))
                                                      .'<label> Objectif(s) :</label> </br>
                                                        <textarea id="IdOjectif" name="objectif" type="text" rows="3" cols="20" disabled>'.$listObjectif.' </textarea> </br>
                                                        '.$objectif.'</br>')
                                                   : (''))
            .'

            </P>

            <input type="submit" id="btnSaveProfil" module="SaveProfil;Accueil" regionSucess="#body;#body" regionError="#body;#body" donne="Utilisateur;Photo;Nom;Prenom;Sexe;Jour;Mois;Annee;Password1;Password2;Mail;Telephone;Adresse;NumLicence;Specialite" value="Sauvegarder les modifications"/>

          </p>
        </div>
      <div class="horizontal_separator"></div>
    </div>
  ';
  $response_array['Stop'] = "false";
  $response_array['Region'] = $_POST['regionSucess'];
}

header('Content-type: application/json');
echo json_encode($response_array);

 ?>
