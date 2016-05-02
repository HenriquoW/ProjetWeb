<p> <!-- Paragraphe contenant l'intégralité du formulaire -->
	<p> <!-- Paragraphe contenant les informations du parent -->
		<!-- CSS à gauche de l'écran -->
		<?php
			$UtilisateurEnCours = $_SESSION['UtilisateurCourant'];
			$TableauResultat=$UtilisateurEnCours->getParente();
			$TableauIDEnfant=$TableauResultat['Enfant'];
		?>

		<label> Nom :</label>
		<input id="nom_parent" name="nom" value="$UtilisateurEnCours->getNom()" type="text" /> <br/>
		<label> Prenom :</label>
		<input id="prenom_parent" name="prenom" value="$UtilisateurEnCours->getPrenom()" type="text" /> <br/>
		<br/>
		<label> Telephone </label>
		<input id="telephone" name="telephone" type="tel" pattern="[0-9]{10}" value="$UtilisateurEnCours->getTelephone()"/> <br/>
		<label> Email </label> 
		<input id="email" name="email" type="email" value="$UtilisateurEnCours->getMail()"/> <br/>
		<label>Adresse complete :</label> <br/>
		<textarea id="adresse" name="adresse" rows="7" cols="50" value="$UtilisateurEnCours->getAdresse()"></textarea> <br/>
		<input type="submit" id="Bouton_Sauvegarder" value="Sauvegarder les modifications"/>
		<!--Appeler script_modifier_profil.php-->
	</p>

	<p> <!-- Paragraphe contenant les informations des enfants
		<!--CSS à droite de l'écran -->
		<?php
			$NbEnfant=0;
			foreach($TableauIDEnfant as $IDEnfant)
			{	
				$NbEnfant=$NbEnfant+1;
				$Enfant=loadUtilisateur($IDEnfant);
				echo '
					<label> Enfant $NbEnfant </label> <br/>
					<input id="nom_prenom_enfant" name="nom_prenom_enfant" value="$Enfant->getPrenom() $Enfant->getNom()" type="text" disabled/>
					<input type="submit" id="Bouton__Voir_Profil_Enfant" value="Voir le profil"/> <!--Appel modifier_profil.php-->
					<br/> <br/>
					<!-- SI le bouton est cliqué, dans la session, l'utilisateur courant passe à l'enfant (pour qu'on ai accès à ses valeurs dans le profil) -->
					<!-- une fois le parent sorti du profil de son enfant, dans la session l'utilisateur courant repasse à l'adulte -->
				';
			}
		?>
	</p>
</p>
