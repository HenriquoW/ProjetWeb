<?php
$response_array = array();

if(isset($_COOKIE['Connect'])){
  $response_array['Status'] = "Success";
  $response_array['Type'] = "Replace";
  $response_array['Stop'] = "false";
  $response_array['Donne'] = '
  <ul id="menu">
                    <li>
                            <a id="btnAccueilConnecter" module="Accueil;Header" regionSucess="#body;#header" regionError="#body;#header">Profil</a>
                            <ul>
                                    <li><a id="btnHeaderModifierProfil" module="ModifierProfil" regionSucess="#body" regionError="#body" >Modifier Profil</a></li>
                            </ul>
                    </li>


                    '.

                    (($_SESSION["UtilisateurCourant"]->asDroit("Administrateurs"))?('<li>
                                                                                        <a>Administration</a>
                                                                                        <ul>
                                                                                            <li><a>Contenu Base</a></li>
                                                                                            <li><a>Droit Access</a></li>
                                                                                        </ul>
                                                                                    </li>')
                                                                                 :(''))


                    .'

                    '.
                    (($_SESSION["UtilisateurCourant"]->asDroit(array("Competiteur","Entraineur","Secretaire","Administrateurs")))?('<li>
                                                                                                                                        <a>Competitions</a>
                                                                                                                                        <ul>
                                                                                                                                    <li><a id="btnPageListeCompetitionConnecter" module="PageListeCompetition" regionSucess="#body" regionError="#body">Voir Competitions</a></li>')
                                                                                                                                   :(''))
                    .'

                    '.

                    (($_SESSION["UtilisateurCourant"]->asDroit(array("Entraineur","Administrateurs")))?('<li><a id="btnPageAjoutCompetition" module="PageAjoutCompetition" regionSucess="#body" regionError="#body"> Ajouter Compétitions</a></li>')
                                                                                                      :(''))


                    .'

		    '.
		    (($_SESSION["UtilisateurCourant"]->asDroit(array("Entraineur","Administrateurs","Secretaire","Competiteur")))?('</ul>
                    </li>')
                                                                                                      :(''))

		    .'

                    <li>

                            <a id="btnDeconnexion" module="Deconnexion;Accueil;Header" regionSucess="#body;#body;#header" regionError="#body;#body;#header">Deconnexion</a>

                    </li>

                </ul>

  ';
  $response_array['Region'] = $_POST['regionSucess'];
}else{
  $response_array['Status'] = "Error";
  $response_array['Type'] = "Replace";
  $response_array['Stop'] = "false";
  $response_array['Donne'] = '
  <ul id="menu">

                <li>
                        <a id="btnAccueil" module="Accueil;Header" regionSucess="#body;#header" regionError="#body;#header">ACCUEIL</a>
                </li>

                <li>
                        <a>PROFIL</a>
                        <ul>
                                <li><a id="btnPageConnexion" module="PageConnexion" regionSucess="#body">Connexion</a></li>
                                <li><a id="btnPageInscription" module="PageInscription" regionSucess="#body">Inscription</a></li>
                        </ul>
                </li>

                <li>
                        <a >LE CLUB</a>
                        <ul>
                            <li><a >Info</a></li>
                        </ul>
                </li>

                <li>
                        <a>COMPÉTITIONS</a>
                        <ul>
                            <li><a id="btnPageListeCompetition" module="PageListeCompetition" regionSucess="#body" regionError="#body">Competitions à venir</a></li>
                        </ul>
                </li>

            </ul>
  ';
  $response_array['Region'] = $_POST['regionError'];
}

header('Content-type: application/json');
echo json_encode($response_array);
?>