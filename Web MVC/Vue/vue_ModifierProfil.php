<?php
$response_array = array();

if(isset($_COOKIE['Connect'])){

  if($_SESSION['UtilisateurCourant']->asDroit("Parent") && isset($_POST['Enfant'])){

    if($id = isCompetiteur($_POST['Enfant'])){
      $inf["Id"] = $id;
      $UtilisateurEnCours = loadCompetiteur($inf);
    }else if($id = isAdherent($_POST['Enfant'])){
      $inf["Id"] = $id;
      $UtilisateurEnCours = loadAdherent($inf);
    }else{
      $inf["Id"] = $_POST['Enfant'];
      $UtilisateurEnCours = loadUtilisateur($înf);
    }
  }else{
    $UtilisateurEnCours = $_SESSION['UtilisateurCourant'];
  }
  $ClasseUtilisateur = get_class($UtilisateurEnCours);

  $response_array['Status'] = "Success";
  $response_array['Type'] = "Replace";
  $response_array['Donne'] = '
  <input type="hidden" name="id_Utilisateur" id="IdUtilisateur" value="'.$UtilisateurEnCours->getId_Utilisateur().'">
  <p> //Paragraphe contenant l intégralité du formulaire
    <p> //CSS Sur la gauche de l écran sous l image actuelle du  profil
    '. (($ClasseUtilisateur == 'Competiteur') ? ('<img src="$UtilisateurEnCours->getPhoto()" alt="probleme affichage"/>
                                                </br>
                                                <label> Photo </label>
                                                <input id="IdPhoto" name="photo" type="file"/>
                                                </br>')
                                              : '')
    .'
    </p>

    <p>// Centré avec les valeurs actuelles des champs pré-rempli (utiliser value="")
      <label> Nom :</label>
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
    <label> Mot de passe</label>
     <input id="IdPassword1" name="mdp" type="text" value="" /> <br/>
    <label>Confirmer mot de passe</label>
     <input id="IdPassword2" name="mdp" type="text" value="" /> <br/>
    <label> Email </label>
     <input id="IdMail" name="email" type="email" value="'.$UtilisateurEnCours->getMail().'"/> <br/>
    <label> Telephone </label>
     <input id="IdTelephone" name="telephone" type="tel" pattern="[0-9]{10}" value="'.$UtilisateurEnCours->getTelephone().'"/> <br/>

    <!-- taille plus grande fixée en css (width et height) ?? (au lieu de rows & cols) && comment faire en sorter que l utilisateur ne puisse l agrandir avec les petites flèches ??-->

    <label>Adresse complete :</label> <br/>
     <textarea id="IdAdresse" name="adresse" rows="7" cols="50" >'.$UtilisateurEnCours->getAdresse().'</textarea> <br/>
    <br/>

    '.
    (($ClasseUtilisateur == 'Adherent' || $ClasseUtilisateur == 'Competiteur') ? ('<label> N° Licence </label>
                                                                                             <input id="IdNumLicence" name="num_licence" type="number" disabled="disabled" value="'.$UtilisateurEnCours->getNumeroLicence().'"/> <br/>')
                                                                                          : (''))
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
                                                <textarea id="objectif" name="objectif" type="text" rows="3" cols="20" >'.$UtilisateurEnCours->getObjectif().' </textarea> </br>')
                                           : (''))
    .'

    </P>

    <input type="submit" id="btnSaveProfil" module="SaveProfil;Accueil" regionSucess="#body;#body" regionError="#body;#body" donne="Utilisateur;Photo;Nom;Prenom;Sexe;Jour;Mois;Annee;Password1;Password2;Mail;Telephone;Adresse;NumLicence;Specialite" value="Sauvegarder les modifications"/>

  </p>
  ';
  $response_array['Stop'] = "false";
  $response_array['Region'] = $_POST['regionSucess'];
}

header('Content-type: application/json');
echo json_encode($response_array);

 ?>
