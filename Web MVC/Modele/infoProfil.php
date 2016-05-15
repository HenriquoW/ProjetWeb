<?php

$UtilisateurEnCours = $_SESSION['UtilisateurCourant'];
$ClasseUtilisateur = get_class($UtilisateurEnCours);

$infoPal = '';

if ($ClasseUtilisateur == 'Competiteur'){
  $idPalmaresTableau=$UtilisateurEnCours->getPalmares();
  $nbID = count($idPalmaresTableau);

  if($nbID>=1){
    $idDernierPalmares=$idPalmaresTableau[$nbID-1];
    $DernierPalmares= loadPalmares($idDernierPalmares);

    $infoPal = $infoPal .'<label> Dernier resultat </label> </br>
    <input id="dernier_resultat" name="dernier_resultat" input="text" value="'.$DernierPalmares->getClassement().'" disabled/> </br>';

    $nbID=$nbID-1;
  }
  if($nbID>=1){
    $idAvantDernierPalmares=$idPalmaresTableau[$nbID-1];
    $AvantDernierPalmares=loadPalmares($idAvantDernierPalmares);

    $infoPal = $infoPal .'<label> Avant-dernier </label> </br>
    <input id="avant_dernier_resultat" name="avant_dernier_resultat" input="text" value="'.$AvantDernierPalmares->getClassement().'" disabled /> </br>';

    $nbID=$nbID-1;
  }
  if($nbID>=1){
    $idAvantAvantDernierPalmares=$idPalmaresTableau[$nbID-1];
    $AvantAvantDernierPalmares=loadPalmares($idAvantAvantDernierPalmares);
    $infoPal = $infoPal .'<label> Avant avant-dernier</label> </br>
    <input name="avant_avant_dernier_resultat" input="text" value="'.$AvantAvantDernierPalmares->getClassement().'" disabled/> </br>';
  }
  $infoPal = $infoPal .'<input type="submit" class="button" id="bntPagePalmares" module="PagePalmares" regionSucess="#body" regionError="#body" value="Afficher le palmarès complet"/>';
  // Appeler la page palmares (T² vont la faire)
}

$infoParent = '';

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
  <textarea id="coordonnees_responsable" name="coordonnees_responsable" value="'.$Parent->getTelephone().' '.$Parent->getAdresse().'" type="text" disabled> </textarea>';

}

$TableauResultat=$UtilisateurEnCours->getParente();
$TableauIDEnfant=$TableauResultat['Enfant'];

$infoEnfant = '';
$NbEnfant=0;
foreach($TableauIDEnfant as $IDEnfant)
{
	$NbEnfant=$NbEnfant+1;
	$Enfant=loadUtilisateur($IDEnfant);
	$infoEnfant = $infoEnfant.'<label> Enfant '.$NbEnfant.' </label> <br/>
		<input id="nom_prenom_enfant" name="nom_prenom_enfant" value="'.$Enfant->getPrenom().' '.$Enfant->getNom().'" type="text" disabled/>
    <input type="hidden" name="id_enfant" id="IdEnfant" value="'.$IDEnfant.'">
		<input type="submit" id="btnModifierProfil" module="ModifierProfil" regionSucess="#body" regionError="#body" donne="Enfant" value="Voir le profil"/>
		<br/> <br/>
		<!-- SI le bouton est cliqué, dans la session, l utilisateur courant passe à l enfant (pour qu on ai accès à ses valeurs dans le profil) -->
		<!-- une fois le parent sorti du profil de son enfant, dans la session l utilisateur courant repasse à l adulte -->
	';
}


$retour['InfoPalmares'] = $infoPal;
$retour['InfoParent'] = $infoParent;
$retour['InfoEnfant'] = $infoEnfant;

$_SESSION['Retour'] = $retour;


?>
