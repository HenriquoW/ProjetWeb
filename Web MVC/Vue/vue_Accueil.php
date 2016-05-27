<?php
$repAccueil = array();

if(isset($_COOKIE['Connect'])){
  $UtilisateurEnCours = $_SESSION['UtilisateurCourant'];
  $ClasseUtilisateur = get_class($UtilisateurEnCours);

  $infoPal = '<p>';

  if ($ClasseUtilisateur == 'Competiteur'){
    $idPalmaresTableau=$UtilisateurEnCours->getPalmares();
    $nbID = count($idPalmaresTableau);

    if($nbID>=1){
      $course = loadCourse(array("Id"=>$idPalmaresTableau[$nbID-1]['Id_Course']));

      $competition = loadCompetitions(array("Id"=>$course->getId_Competition()));

      $DernierPalmares;
      if($course->getIsEquipe()){
        $DernierPalmares = loadPalmares(array("Id_Course"=>$course->getId_Course(),"Id_Equipe"=>$idPalmaresTableau[$nbID-1]['Id_Equipe']));
      }else{
        $DernierPalmares = loadPalmares(array("Id_Course"=>$course->getId_Course(),"Id_Competiteur"=>$idPalmaresTableau[$nbID-1]['Id_Competiteur']));
      }

      $infoPal = $infoPal .'<label> Dernier resultat </label> </br>
      <input id="dernier_resultat" name="dernier_resultat" input="text" value="'.$DernierPalmares->getClassement().'" disabled/> </br>';

      $nbID=$nbID-1;
    }
    if($nbID>=1){
      $course = loadCourse(array("Id"=>$idPalmaresTableau[$nbID-1]['Id_Course']));

      $competition = loadCompetitions(array("Id"=>$course->getId_Competition()));

      $AvantDernierPalmares;
      if($course->getIsEquipe()){
        $AvantDernierPalmares = loadPalmares(array("Id_Course"=>$course->getId_Course(),"Id_Equipe"=>$idPalmaresTableau[$nbID-1]['Id_Equipe']));
      }else{
        $AvantDernierPalmares = loadPalmares(array("Id_Course"=>$course->getId_Course(),"Id_Competiteur"=>$idPalmaresTableau[$nbID-1]['Id_Competiteur']));
      }

      $infoPal = $infoPal .'<label> Avant-dernier </label> </br>
      <input id="avant_dernier_resultat" name="avant_dernier_resultat" input="text" value="'.$AvantDernierPalmares->getClassement().'" disabled /> </br>';

      $nbID=$nbID-1;
    }
    if($nbID>=1){
      $course = loadCourse(array("Id"=>$idPalmaresTableau[$nbID-1]['Id_Course']));

      $competition = loadCompetitions(array("Id"=>$course->getId_Competition()));

      $AvantAvantDernierPalmares;
      if($course->getIsEquipe()){
        $AvantAvantDernierPalmares = loadPalmares(array("Id_Course"=>$course->getId_Course(),"Id_Equipe"=>$idPalmaresTableau[$nbID-1]['Id_Equipe']));
      }else{
        $AvantAvantDernierPalmares = loadPalmares(array("Id_Course"=>$course->getId_Course(),"Id_Competiteur"=>$idPalmaresTableau[$nbID-1]['Id_Competiteur']));
      }

      $infoPal = $infoPal .'<label> Avant avant-dernier</label> </br>
      <input name="avant_avant_dernier_resultat" input="text" value="'.$AvantAvantDernierPalmares->getClassement().'" disabled/> </br>';
    }
    $infoPal = $infoPal .'<input type="submit" class="button" id="bntPagePalmares" module="PagePalmares" regionSucess="#Palmares" regionError="#Palmares" value="Afficher le palmarès complet"/>';

    $infoPal = $infoPal .'<div id="palmares"> </div></p>';
  }

  $infoObjectif = '';
  if($ClasseUtilisateur == 'Competiteur'){
    foreach ($UtilisateurEnCours->getObjectif() as $objectif) {
      $compet = loadCompetition(array("Id"=>$objectif));

      $infoObjectif = $infoObjectif . ''.$compet->getTypeCompetition()['Nom'].'-'.$compet->getAdresse().'/n';
    }
  }

  $infoParent = '<p>';

  if(getdate()['year'] - $UtilisateurEnCours->getDateNaissance()->format('Y') < '18'){
    $TableauResultat=$UtilisateurEnCours->getParente();
    $TableauParents=$TableauResultat['Parent'];
    $idParent=$TableauParents[0];
    $Parent=loadUtilisateur($idParent);
    $infoParent = $infoParent . '<label> Nom </label>
    <input id="nom_responsable" name="nom_responsable" value="'.$Parent->getNom().'" type="text" disabled/> </br>
    <label> Prenom </label>
    <input id="prenom_responsable" name="prenom_responsable" value="'.$Parent->getPrenom().'" type="text" disabled/> </br>
    <label> Coordonnees </label>
    <textarea id="coordonnees_responsable" name="coordonnees_responsable" value="'.$Parent->getTelephone().' '.$Parent->getAdresse().'" type="text" disabled> </textarea></p>';

  }

  $TableauResultat=$UtilisateurEnCours->getParente();
  $infoEnfant = '<p>';

  if(isset($TableauResultat['Enfant'])){
  	$TableauIDEnfant=$TableauResultat['Enfant'];
  	foreach($TableauIDEnfant as $IDEnfant){
  		$Enfant=loadUtilisateur($IDEnfant);
  		$infoEnfant = $infoEnfant.'<label> Enfant '.$NbEnfant.' </label> <br/>
  			<input id="nom_prenom_enfant" name="nom_prenom_enfant" value="'.$Enfant->getPrenom().' '.$Enfant->getNom().'" type="text" disabled/>
  	    <input type="hidden" name="id_enfant" id="IdEnfant" value="'.$IDEnfant.'">
  			<input type="submit" id="btnModifierProfil" module="ModifierProfil" regionSucess="#body" regionError="#body" donne="Enfant" value="Voir le profil"/>
  			<br/> <br/>';
  	}
    $infoEnfant = $infoEnfant.'</p>';
  }

  $repAccueil['Status'] = "Success";
  $repAccueil['Type'] = "Replace";
  $repAccueil['Donne'] = '
  <div class="div_profil_global">
      <div class="div_profil">
        <h2>Profil</h2>
          <p>

            '. (($ClasseUtilisateur == 'Competiteur') ? ('<p><img src="$UtilisateurEnCours->getPhoto()" alt="probleme affichage"/>
                                                        </br>
                                                        <label> Photo </label>
                                                        <input id="IdPhoto" name="photo" type="file" disabled/>
                                                        </br></p>')
                                                      : '')
            .'



            '.
              $infoParent
            .'

            <p>
              <label style="padding-left: 20px;"> Nom :</label>
          	      	<input id="IdNom" name="nom" value="'.$UtilisateurEnCours->getNom().'" type="text" disabled/> <br/>
          		<label> Prenom :</label>
          	      	<input id="IdPrenom" name="prenom" value="'.$UtilisateurEnCours->getPrenom().'" type="text" disabled/> <br/>
            '.
            (($UtilisateurEnCours->getSexe()['Type']=='F') ? ('<select name="Sexe" id="IdSexe" disabled>
                                                                <option value="Homme">Homme</option>
                                                                <option value="Femme" selected="selected" >Femme</option>
                                                              </select>')
                                                           : ('<select name="Sexe" id="IdSexe" disabled>
                                                               <option value="Homme" selected="selected">Homme</option>
                                                               <option value="Femme">Femme</option>
                                                             </select>  <br/>'))
            .'

              <label>Date de naissance :</label> <br/>
          		<label> Jour </label>
                <input id="IdJour" name="jour" type="number" min="1" max="31" value="'.$UtilisateurEnCours->getDateNaissance()->format('d').'" disabled/>
              <label> Mois </label>
                <input id="IdMois" name="mois" type="number" min="1" max="12" value="'.$UtilisateurEnCours->getDateNaissance()->format('m').'" disabled/>
              <label> Annee </label>
                <input id="IdAnnee" name="annee" type="number" min="1920" max="2016" value="'.$UtilisateurEnCours->getDateNaissance()->format('Y').'" disabled/> <br/>

            '.
            (($ClasseUtilisateur == 'Competiteur') ? ('<label> Categorie </label>
                                            	        <input id="categorie" name="categorie" type="text" disabled value="'.$UtilisateurEnCours->getCategorie().'"/>')
                                                   : (''))
            .'
            <br/>
        		<label style="padding-left: 15px;"> Email </label>
        	   <input id="IdMail" name="email" type="email" value="'.$UtilisateurEnCours->getMail().'" disabled/> <br/>
        		<label style="margin-left: -18px;"> Telephone </label>
        	   <input id="IdTelephone" name="telephone" type="tel" pattern="[0-9]{10}" value="'.$UtilisateurEnCours->getTelephone().'" disabled/> <br/>

        		<label>Adresse complete :</label> <br/>
        	   <textarea id="IdAdresse" name="adresse" rows="7" cols="50" disabled>'.$UtilisateurEnCours->getAdresse().'</textarea> <br/>
        		<br/>

            '.
            (($ClasseUtilisateur == 'Adherent' || $ClasseUtilisateur == 'Competiteur') ? ('<label> N° Licence </label>
        	                                                                                 <input id="IdNumLicence" name="num_licence" type="number" disabled="disabled" value="'.$UtilisateurEnCours->getNumeroLicence().'" disabled/> <br/>')
                                                                                       : (''))
            .'

            '.
            (($ClasseUtilisateur == 'Competiteur') ? ('<label> Specialite </label> </br>
        					                                    <label> Kayak </label>'.
                                                      (($UtilisateurEnCours->getSpecialite()== "Kayak") ? ('<select name="specialite" id="IdSpecialite" disabled>
                                                                                                              <option value="Kayak" selected="selected" >Kayak</option>
                                                                                                              <option value="Canoe">Canoe</option>
                                                                                                            </select></br>')
                                                                                                        : ('<select name="specialite" id="IdSpecialite" disabled>
                                                                                                            <option value="Kayak">Kayak</option>
                                                                                                            <option value="Canoe"  selected="selected" >Canoe</option>
                                                                                                          </select> </br>'))
                                                      .'<label> Objectif(s) :</label> </br>
        					                                      <textarea id="objectif" name="objectif" type="text" rows="3" cols="20" disabled>'.$infoObjectif.' </textarea> </br>')
                                                   : (''))
            .'

            </p>


            '.
              $infoPal
            .'



            '.
              $infoEnfant
            .'

          </p>
        </div>
      <div class="horizontal_separator"></div>
    </div>';
  $repAccueil['Stop'] = "false";
  $repAccueil['Region'] = $_POST['regionSucess'];

}else{
  $repAccueil['Status'] = "Error";
  $repAccueil['Type'] = "Replace";
  $repAccueil['Stop'] = "false";
  $repAccueil['Donne'] = '
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
          <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <img src="images/892-canoe-kayak-WallFizz.jpg" alt="wall">
          </div>

          <div class="item">
            <img src="images/ardeche-en-canoe.jpg" alt="ardeche">
          </div>

          <div class="item">
            <img src="images/Sea_Kayak.jpg" alt="kayak">
          </div>

          <div class="item">
            <img src="images/Club_France_Vitesse_Gerardmer_2015.jpg" alt="club">
          </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>

        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <div class="horizontal_separator"></div>


      <div class="div_header_content_global">
        <div class="div_header_content">
          <p>
            La section Canoë-Kayak est située sur la base nautique du Lac Kir de Dijon (quai des carrières blanches).
          </p>

          <p>
            Elle offre une pratique de loisir variée et de compétition en ligne.
          </p>

          <p>
            <b>L&apos;école de pagaie :</b>
            C&apos;est le groupe des débutants dans lequel vous apprendrez les manœuvres de base en canoë-kayak dans différentes embarcations. Au fur et à mesure de votre apprentissage vous aurez la possibilité de vous évaluer en passant les diplômes pagaies couleurs, véritable label d&apos;enseignements mis en place par la fédération française de canoë kayak. Le froid, la pluie, la neige…. pas de soucis une séance est prévue au club de canoë kayak de Dijon : sports collectifs, piscine, escalade, course d&apos;orientation…
          </p>

          <p>
            Les séances ont lieu de 14h à 17h le mercredi et le samedi.
          </p>

          <p>
            <b>Compétition :</b>
            Une fois les premiers coups de pagaies maitrisés, vous pourrez vous initier à la compétition. Tous les niveaux sont proposés : du départemental à l&apos;international… Des cadres qualifiés sont présents tous les soirs de la semaine pour vous aider à progresser, en plus du mercredi et samedi après midi.
          </p>

          <p>
            <b>Loisirs et fitness :</b>
            Amateur de balade ou de renforcement musculaire vous choisirez votre envie. Une fois que vous maitriserez votre embarcation vous pourrez pratiquer seul ou en groupe, encadré ou autonome. Des sorties sur des rivières à l&apos;extérieur de Dijon vous seront proposées au cours de l&apos;année.
          </p>

          <p>
            <b>Découverte :</b>
            Toute au long de l&apos;année, vous pouvez profiter de nos locations de canoë et de kayak en toute autonomie sur lac. Vous pouvez aussi découvrir d&apos;autres horizons en pagayant sur nos différents parcours  : "Kayak-Kir" et "Le traversée de Dijon en Canoë kayak". Pour plus d&apos;informations, n&apos;hésitez pas à nous contacter par mail ou téléphone.
          </p>
        </div>
      </div>

      <div class="horizontal_separator"></div>

      <div class="div_index_map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10816.973373988987!2d5.0936225!3d47.3291187!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd8df6970b2032d50!2sASPTT+DIJON!5e0!3m2!1sfr!2sfr!4v1453212325884" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
      </div>

      <div class="horizontal_separator"></div>
  ';
  $repAccueil['Region'] = $_POST['regionError'];
}

header('Content-type: application/json');
echo json_encode($repAccueil);

?>
