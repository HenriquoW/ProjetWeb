<form action="modifier_profil.php" method="post">
	<p> <!-- Paragraphe contenant l'intégralité du formulaire -->
		<?php
		#uniquement pour tester avant la mise en commun 
		class Competiteur{ 
		private $DDN; 
		public function get_DDN() { return $this->DDN; } 
		public function set_DDN($ddn) { $this->DDN = $ddn; }
		} 
		$UtilisateurEnCours = new Competiteur(); 
		$UtilisateurEnCours->set_DDN('12/04/2005');
		//$UtilisateurEnCours = $_SESSION['UtilisateurCourant'];
		#uniquement pour tester avant la mise en commun

		$ClasseUtilisateur = get_class($UtilisateurEnCours);
		?>
		<!-- Sur la gauche de l'écran sous l image actuelle du  profil -->
		<!-- /!\ Vérification si compétiteur -->
		<p> 
			<?php
				if ($ClasseUtilisateur == 'Competiteur')
        {
          # echo entier à supprimer
				  echo '
				    <img src="fee.jpeg" alt="probleme affichage"/>
				    </br>
				    <label> Photo </label>
				    <input name="photo" type="file"/></br>
				  ';
          #à décommenter pour tester avec 'vrai' utilisateur
          /*
          echo '
            <img src="$UtilisateurEnCours->getPhoto()" alt="probleme affichage"/>
				    </br>
				    <label> Photo </label>
				    <input name="photo" type="file"/></br>
				  ';
          */
        }
			?>
		</p>
		<!-- /!\ -->

		<!-- Sur la gauche de l ecran sous la partie photo-->
		<!-- /!\ Vérification si mineur -->
		<p>
		    <?php
          #$DDNUser = date_parse($UtilisateurEnCours->getDateNaissance());
			    $DDNUser = date_parse($UtilisateurEnCours->get_DDN()); # à supprimer
			    $YearUser = $DDNUser['year'];
			    $YearToday = getdate()['year'];
			    if( $YearToday - $YearUser < '18')
          {
          #echo entier à supprimer
			      echo '
			        <label> Nom </label>
			        <input name="nom_responsable" type="text" disabled/> </br>
			        <label> Prenom </label>
			        <input name="prenom_responsable" type="text" disabled/> </br>
			        <label> Coordonnees </label>
			        <textarea name="coordonnees_responsable" type="text" disabled> </textarea>
		    	      ';
            /*
            echo '
			        <label> Nom </label>
              ############################TO COMPLETE ##################################
              #getParent retourne un tableau avec l id des parents puis je pourrais utiliser la fonction load(avec l id en paramètre) pour créer un objet avce les infos du parent dedans
              <input name=" " type="text" disabled/> </br>
			        <label> Prenom </label>
              <input name="" type="text" disabled/> </br>
			        <label> Coordonnees </label>
              <textarea name="" type="text" disabled> </textarea>
		    	      ';
            */
              }
		    ?>
		</p>
		<!-- /!\-->

		<p> <!-- Centré avec les valeurs actuelles des champs pré-rempli (utiliser value="")-->
			<label> Nom :</label>
      <!-- <input name="$UtilisateurEnCours->getNom()" type="text" /> <br/>-->
			<input name="nom" type="text" /> <br/> <!--à supprimer-->
			<label> Prenom :</label>
      <!-- <input name="$UtilisateurEnCours->getPrenom()" type="text" /> <br/> -->
      
      <!--à supprimer-->
			<input name="prenom" type="text" /> <br/>
			<label> Sexe :</label> <br/>
      <label>F</label> 
			<input name="sexe" type="radio" value="F" />
			<label>M</label>
			<input name="sexe" type="radio" value="M"/>  <br/>
      <!--jusqu'ici-->  
      
      <?php
      /*
        $Sexe=$UtilisateurEnCours->getSexe()[type];
        if($Sexe == 'F')
          {
            echo'
                <label>F</label>
			          <input name="sexe" type="radio" value="F" checked="checked"/>
			          <label>M</label>
			          <input name="sexe" type="radio" value="M"/>  <br/>
              ';
          }
        else
          {
            echo '
             <label>F</label>
			       <input name="sexe" type="radio" value="F"/>
			       <label>M</label>
			       <input name="sexe" type="radio" value="M" checked="checked"/>  <br/>
            ';
          }
      */
      ?>
      
			<!-- Avec un calendrier ?? (a bit long) -->
			<label>Date de naissance :</label> <br/>
			<label> Jour </label>
      <!-- à supprimer -->
      <input name="jour" type="number" min="1" max="31"/>
			<label> Mois </label>
			<input name="mois" type="number" min="1" max="12"/>
			<label> Annee </label>
			<input name="annee" type="number" min="1920" max="2016"/> <br/>
      <!-- jusqu'ici-->
      
      <?php
        /*
        $DDNUser = date_parse($UtilisateurEnCours->getDateNaissance());
			  $YearUser = $DDNUser['year'];
			  $MonthUser = $DDNUser['month'];
        $DayUser = $DDNUser['day'];  
        echo '
          <input name="jour" type="number" min="1" max="31" value="$DayUser"/> 
			    <label> Mois </label>
			    <input name="mois" type="number" min="1" max="12" value="$MonthUser"/>
			    <label> Annee </label>
			    <input name="annee" type="number" min="1920" max="2016" value="$YearUser"/> <br/>
        ';
        */
      ?>
      
			<!-- /!\ Vérification si compétiteur -->
			<?php
				if ($ClasseUtilisateur == 'Competiteur')
        {
          #echo entier à supprimer
				  echo '
				    <label> Categorie </label>
				    <input name="categorie" type="text" disabled/>
				  ';
          /*
          echo '
				    <label> Categorie </label>
            <input name="categorie" type="text" disabled value="$UtilisateurEnCours->getCategorie()"/>
				  ';
          */
        }
		  ?>
			<!-- /!\ -->
      
			<br/>
			<label> Mot de passe</label>
      <!--<input name="mdp" type="text" value="$UtilisateurEnCours->getPassword()" /> <br/>-->
			<input name="mdp" type="text" /> <br/> <!--à supprimer-->
			<label> Email </label> 
      <!--<input name="email" type="email" value="$UtilisateurEnCours->getMail()"/> <br/>-->
			<input name="email" type="email"/> <br/> <!--à supprimer-->
			<label> Telephone </label>
      <!--<input name="telephone" type="tel" pattern="[0-9]{10}" value="$UtilisateurEnCours->getTelephone()"/> <br/>-->
			<input name="telephone" type="tel" pattern="[0-9]{10}"/> <br/> <!--à supprimer-->
			<!-- taille plus grande fixée en css (width et height) ?? (au lieu de rows & cols) && comment faire en sorter que l'utilisateur ne puisse l'agrandir avec les petites flèches ??-->
			<label>Adresse complete :</label> <br/>
      <!--<textarea name="adresse" rows="7" cols="50" value="$UtilisateurEnCours->getAdresse()"></textarea> <br/>	-->
			<textarea name="adresse" rows="7" cols="50"></textarea> <br/>	 <!--à supprimer-->
			<br/>
			<label> N° Licence </label>
      <!--<input name="num_licence" type="number" disabled="disabled" value="$UtilisateurEnCours->getNumeroLicence()"/> <br/>-->
			<input name="num_licence" type="number" disabled="disabled" /> <br/><!--à supprimer-->
      
			<!--/!\ Vérification si compétiteur -->
			<?php
				if ($ClasseUtilisateur == 'Competiteur')
        {
        #echo entier à supprimer
				  echo '
				    <label> Specialite </label> </br>
				    <label> Kayak </label>
				    <input name="specialite" type="radio" value="Kayak" />
				    <label> Canoe </label>
				    <input name="specialite" type="radio" value="Canoe"/> </br>		 
				    <label> Objectif(s) :</label> </br>
				    <textarea name="objectif" type="text" rows="3" cols="20"> </textarea> </br>
				  ';
          
          /*
           echo '
				    <label> Specialite </label> </br>
				    <label> Kayak </label>
            ';
            $Specialite = $UtilisateurEnCours->getSpecialite();
            if($Specialite == "Kayak")
            {
              echo '
				        <input name="specialite" type="radio" value="Kayak" checked="checked"/>
				        <label> Canoe </label>
				        <input name="specialite" type="radio" value="Canoe"/> </br>		
                ';
            }
            else
            {
              echo '
				        <input name="specialite" type="radio" value="Kayak"/>
				        <label> Canoe </label>
				        <input name="specialite" type="radio" value="Canoe checked="checked""/> </br>		
                ';
            }
            echo '
				      <label> Objectif(s) :</label> </br>
				      <textarea name="objectif" type="text" rows="3" cols="20" value="$UtilisateurEnCours->getObjectif()"> </textarea> </br>
				    ';
          */
        }
		    	?>
			<!--/!\ -->
		</p>
		<!--En haut à gauche de la page, dans un cadre -->
		<p>
			<!--/!\ Vérification si compétiteur -->
			<?php
				if ($ClasseUtilisateur == 'Competiteur')
        {
				  echo '
				    <label> Dernier resultat </label> </br>
				    <input name="dernier_resultat" input="text" disabled/> </br>
				    <label> Avant-dernier </label> </br>
				    <input name="avant_dernier_resultat" input="text" disabled /> </br>
				    <label> Avant avant-dernier</label> </br>
				    <input name="avant_avant_dernier_resultat" input="text" disabled/> </br>
				  ';
        }
		    	?>
			<!--/!\ -->		
		</p>
		<!-- Centré en bas de la page après tous les champs-->
		<input type="submit" value="Sauvegarder les modifications"/>
	</p>
</form>
























