<!doctype html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Création de compte : fin</title>
    </head>

    <body>
    <?php include 'includes/header.php' ;?>

	<div class="div_design">
		<?php

		if(isset($_POST['nom']) && isset($_POST['prenom']) )
		{
			$mail = $_POST['mail'];
			$pass = $_POST['pass'];

			$nom = $_POST['nom'];
			$prenom = $_POST['prenom'];

			if(isset($_POST['jour_user']) && isset($_POST['mois_user']) && isset($_POST['annee_user']))
			{
				$jour = $_POST['jour_user'];
				$mois = $_POST['mois_user'];
				$annee = $_POST['annee_user'];
				$date = $annee.'-'.$mois.'-'.$jour;
			}
			else
				$date= "0000-00-00";

			if(isset($_POST['adresse']))			
				$adresse = $_POST['adresse'];							
			else
				$adresse = "";

			if(isset($_POST['telephone']))
				$telephone = $_POST['telephone'];	
			else
				$telephone = "";			

			if(isset($_POST['sexe']))
			{
				$sexe = $_POST['sexe'];

				if($sexe=="1")
					$sexeF="femme";
				else
					$sexeF="homme";		
			}
			else
				$sexe="";
			
			//echo $nom.'-'.$prenom.'-'.$date.'-'.$adresse.'-'.$telephone.'-'.$sexe.'-'.$mail.'-'.$pass ;
			
		}

		else
		{
			echo'<h2>Erreur.</h2>
			<p>Erreur à la création du compte. Information(s) manquante(s). Veuillez recommencer.</p>
			
			<form method="post" action="connexion.php">
                <input type="submit" id="submit" value="Créer compte" />
            </form>
            ';
		}

		?>
	</div>

    </body>

</html>