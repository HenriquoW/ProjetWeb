<!doctype html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Création de compte</title>
    </head>

    <body>
    <?php include 'includes/header.php' ;?>

	<div class="div_design">
		<?php

		if(isset($_POST['mail']) && isset($_POST['pass1']) && isset($_POST['pass2']) && ($_POST['pass1'] == $_POST['pass2']) && isset($_POST['termes']))
		{
			$mail = $_POST['mail'];
			$pass = $_POST['pass1'];

			echo'
			<div class="div_connexion_inscription_global">
			<div class="div_connexion_inscription" style="text-align:center;margin:auto;">

			<h2>Il vous reste certaines informations à spécifier:</h2>

			<form method="post" action="traitementInscription2.php">
                
                <label for="mail">Nom:</label>
                <input type="text" placeholder="votre nom de famille." name="nom" id="nom" required/>

                <br/>

                <label for="mail">Prénom:</label>
                <input type="text" placeholder="votre prénom." name="prenom" id="prenom" required/>

                <br/>

                <p style="font-weight:bold;">Date de naissance:</p>
				<input type="number" placeholder="jour" name="jour_user" id="jour_user" min="1" max="31"/>
				<input type="number" placeholder="mois" name="mois_user" id="mois_user" min="1" max="12"/>
				<input type="number" placeholder="année" name="annee_user" id="annee_user" min="1950" max="'.date('Y').'"/>

				<br/>

				<label for="adresse">Adresse postale:</label>
                <input type="text" placeholder="votre adresse." name="adresse" id="adresse" />

                <br/>

                <label for="adresse">Téléphone:</label>
                <input type="text" placeholder="votre numéro." name="telephone" id="telephone" />

                <br/>

                <p style="font-weight:bold;">Sexe:</p>
				
				<input type="radio" class="input_align" name="sexe" value="1" id="femme" checked/> <label for="1">Femme</label>
       			<input type="radio" class="input_align" name="sexe" value="2" id="homme" /> <label for="2">Homme</label>

       			<br/>

       			<input type="HIDDEN" name="mail" id="mail" value="'.$mail.'"> 
       			<input type="HIDDEN" name="pass" id="pass" value="'.$pass.'"> 

                <input type="submit" id="submit" value="Valider" />

            </form>

            </div>
            ';

			/*if(checkMailUser($mail)==false)
			{
				addUser($mail,$pass);
			}
			else
			{
				echo '<h2>Echec.</h2>
				<p>L\'adresse mail existe déjà. Veuillez recommencer avec une adresse mail valide.</p>
				<form method="post" action="connexion.php">
	                <input type="submit" class="submit_index" value="Rejoindre &copy;BlacK\'RED" />
	            </form>';
	        }*/
		}

		else if(isset($_POST['mail']) && isset($_POST['pass1']) && isset($_POST['pass2']) && ($_POST['pass1'] != $_POST['pass2']) && isset($_POST['termes']))
		{
			echo '<h2>Echec.</h2>
			<p>Les mots de passe ne sont pas identiques. Veuillez recommencer.</p>
			
			<form method="post" action="connexion.php">
                <input type="submit" id="submit" value="Créer compte" />
            </form>
            ';
		}

		else
		{
			echo'<h2>Erreur.</h2>
			<p>Erreur à la création du compte. Information(s) manquante(s): acceptez les termes et entrez un mot de passe identique dans les deux champs "mot de passe". Veuillez recommencer.</p>
			
			<form method="post" action="connexion.php">
                <input type="submit" id="submit" value="Créer compte" />
            </form>
            ';
		}

		?>
	</div>

    </body>

</html>
