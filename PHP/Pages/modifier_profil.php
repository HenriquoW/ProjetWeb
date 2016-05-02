<p> <!-- Paragraphe contenant l'intégralité du formulaire -->
	<?php 
    		$UtilisateurEnCours = $_SESSION['UtilisateurCourant'];
		$ClasseUtilisateur = get_class($UtilisateurEnCours);
	?>
	<!-- CSS Sur la gauche de l'écran sous l image actuelle du  profil -->
	<p> 
		<?php
			if ($ClasseUtilisateur == 'Competiteur')
			{
				echo '
					<img src="$UtilisateurEnCours->getPhoto()" alt="probleme affichage"/>
					</br>
					<label> Photo </label>
					<input id="photo" name="photo" type="file"/></br>
				';
			}
		?>
	</p>

	<!-- CSS Sur la gauche de l ecran sous la partie photo-->
	<p>
		<?php
	        	$DDNUser = date_parse($UtilisateurEnCours->getDateNaissance());
			$YearUser = $DDNUser['year'];
			$YearToday = getdate()['year'];
			if( $YearToday - $YearUser < '18')
			{
				$TableauResultat=$UtilisateurEnCours->getParente();
			        $TableauParents=$TableauResultat['Parent'];
			        $idParent=$TableauParents[0];
			        $Parent=loadUtilisateur($idParent);
			        echo '
					<label> Nom </label>
			                <input id="nom_responsable" name="nom_responsable" value="$Parent->getNom()" type="text" disabled/> </br>
					<label> Prenom </label>
			                <input id="prenom_responsable" name="prenom_responsable" value="$Parent->getPrenom()" type="text" disabled/> </br>
					<label> Coordonnees </label>
			                <textarea id="coordonnees_responsable" name="coordonnees_responsable" value="$Parent->getTelephone $Parent->getAdresse()" type="text" disabled> </textarea>
				';
			}
		?>
	</p>

	<p> <!-- CSS Centré avec les valeurs actuelles des champs pré-rempli (utiliser value="")-->
		<label> Nom :</label>
	      	<input id="nom" name="nom" value="$UtilisateurEnCours->getNom()" type="text" /> <br/>
		<label> Prenom :</label>
	      	<input id="prenom" name="prenom" value="$UtilisateurEnCours->getPrenom()" type="text" /> <br/>  
	      
	      	<?php
		        $Sexe=$UtilisateurEnCours->getSexe()[type];
		        if($Sexe == 'F')
		        {
		            echo'
		                <label>F</label>
				<input id="sexeF" name="sexe" type="radio" value="F" checked="checked"/>
				<label>M</label>
				<input id="sexeM" name="sexe" type="radio" value="M"/>  <br/>
		              ';
		        }
		        else
		        {
		            echo '
		             	<label>F</label>
				<input id="sexeF" name="sexe" type="radio" value="F"/>
				<label>M</label>
				<input id="sexeM" name="sexe" type="radio" value="M" checked="checked"/>  <br/>
		            ';
		        }
	      	?>
      
		<label>Date de naissance :</label> <br/>
		<label> Jour </label>
	      
	      	<?php
	        	$DDNUser = date_parse($UtilisateurEnCours->getDateNaissance());
			$YearUser = $DDNUser['year'];
			$MonthUser = $DDNUser['month'];
	        	$DayUser = $DDNUser['day'];  
	        	echo '
	        		 <input id="jour" name="jour" type="number" min="1" max="31" value="$DayUser"/> 
				 <label> Mois </label>
				 <input id="mois" name="mois" type="number" min="1" max="12" value="$MonthUser"/>
				 <label> Annee </label>
				 <input id="annee" name="annee" type="number" min="1920" max="2016" value="$YearUser"/> <br/>
	        	';
	      ?>
      
		<?php
			if ($ClasseUtilisateur == 'Competiteur')
	        	{
	          		echo '
					<label> Categorie </label>
	            			<input id="categorie" name="categorie" type="text" disabled value="$UtilisateurEnCours->getCategorie()"/>
				';
	        	}
		?>
      
		<br/>
		<label> Mot de passe</label>
	        <input id="mdp" name="mdp" type="text" value="$UtilisateurEnCours->getPassword()" /> <br/>
		<label> Email </label> 
	        <input id="email" name="email" type="email" value="$UtilisateurEnCours->getMail()"/> <br/>
		<label> Telephone </label>
	        <input id="telephone" name="telephone" type="tel" pattern="[0-9]{10}" value="$UtilisateurEnCours->getTelephone()"/> <br/>
		<!-- taille plus grande fixée en css (width et height) ?? (au lieu de rows & cols) && comment faire en sorter que l'utilisateur ne puisse l'agrandir avec les petites flèches ??-->
		<label>Adresse complete :</label> <br/>
	        <textarea id="adresse" name="adresse" rows="7" cols="50" value="$UtilisateurEnCours->getAdresse()"></textarea> <br/>
		<br/>
		<label> N° Licence </label>
	        <input id="numero_licence" name="num_licence" type="number" disabled="disabled" value="$UtilisateurEnCours->getNumeroLicence()"/> <br/>
	      
		<?php
			if ($ClasseUtilisateur == 'Competiteur')
	        	{
	           		echo '
					<label> Specialite </label> </br>
					<label> Kayak </label>
	            		';
	            		$Specialite = $UtilisateurEnCours->getSpecialite();
	            		if($Specialite == "Kayak")
	            		{
	        			echo '
						<input id="specialiteK" name="specialite" type="radio" value="Kayak" checked="checked"/>
						<label> Canoe </label>
						<input id="specialiteC" name="specialite" type="radio" value="Canoe"/> </br>		
		                	';
		            	}
		        	else
		            	{
		              		echo '
						<input id="specialiteK" name="specialite" type="radio" value="Kayak"/>
						<label> Canoe </label>
						<input id="specialiteC" name="specialite" type="radio" value="Canoe" checked="checked""/> </br>		
		                	';
		            	}
		            	echo '
					<label> Objectif(s) :</label> </br>
					<textarea id="objectif" name="objectif" type="text" rows="3" cols="20" value="$UtilisateurEnCours->getObjectif()"> </textarea> </br>
				';
	        	}
		?>
	</p>
    
		<!--CSS En haut à gauche de la page, dans un cadre -->
	<p>
		<?php
			if ($ClasseUtilisateur == 'Competiteur')
	        	{
	          		$idPalmaresTableau=$UtilisateurEnCours->getPalmares();
	          		$nbID = count($idPalmaresTableau);
	          		if($nbID>=1)
	          		{
	            			$idDernierPalmares=$idPalmaresTableau[$nbID-1];
	            			$DernierPalmares= loadPalmares($idDernierPalmares);
	            			echo '
						<label> Dernier resultat </label> </br>
						<input id="dernier_resultat" name="dernier_resultat" input="text" value="$DernierPalmares->getClassement()" disabled/> </br>
	              			';
	            			$nbID=$nbID-1;  
	          		}		
			        if($nbID>=1)
			        {
			        	$idAvantDernierPalmares=$idPalmaresTableau[$nbID-1];
			                $AvantDernierPalmares=loadPalmares($idAvantDernierPalmares);
			                echo '
						<label> Avant-dernier </label> </br>
						<input id="avant_dernier_resultat" name="avant_dernier_resultat" input="text" value="$AvantDernierPalmares->getClassement()" disabled /> </br>
			                ';
			                $nbID=$nbID-1;  
			        }
	          		if($nbID>=1)
	          		{
	            			$idAvantAvantDernierPalmares=$idPalmaresTableau[$nbID-1];
	            			$AvantAvantDernierPalmares=loadPalmares($idAvantAvantDernierPalmares);
					echo '
						<label> Avant avant-dernier</label> </br>
					        <input name="avant_avant_dernier_resultat" input="text" value="$AvantAvantDernierPalmares->getClassement()" disabled/> </br>
					';
	          		}
			      	echo '
	                		<input type="submit" class="button" id="Bouton_Afficher_Palmares" value="Afficher le palmarès complet"/>
	          		';
	          // Appeler la page palmares (T² vont la faire)
	        	}
		?>	
	</p>
	<!-- CSS Centré en bas de la page après tous les champs-->
	<input type="submit" id="Bouton_Sauvegarder" value="Sauvegarder les modifications"/>
    	<!--Appeler script_modifier_profil.php-->
</p>
























