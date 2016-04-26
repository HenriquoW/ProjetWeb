<?php

	require("BDD/class_equipe.php");

	if (isset($_POST['competition'] && isset($_POST['embarcation'] && isset($_POST['taille'] && isset($_POST['nomEquipe'])

	{
		$Membre = array();
		
		if ($_POST['taille'] >= 1) {
			$Membre[] = $_POST['e1'];
		}
		if ($_POST['taille'] >= 2) {
			$Membre[] = $_POST['e2'];
		}
		
		if ($_POST['taille'] == 4) {
			$Membre[] = $_POST['e3'];
			$Membre[] = $_POST['e4'];
		}
		$Equipe = array('nom'=> $_POST['nomEquipe'], 'Membre'=> $Membre, 'competition'=> $_POST['competition'] );

		$monEquipage = new Equipe($Equipe);
		$monEquipage->save(false);

	}
	

?>