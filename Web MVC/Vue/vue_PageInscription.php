<?php

$response_array = array();

$response_array['Status'] = "Success";
$response_array['Type'] = "Replace";
$response_array['Donne'] = '
<div id="DivInscription" class="div_connexion_inscription_global">
  <div class="div_connexion_inscription" style="text-align:center;margin:auto;">


      <label for="mail">Adresse mail:</label>
      <input type="email" placeholder="adresse mail." name="mail" id="IdMail" required/>

      <br/>

      <label for="pass">Mot de passe:</label>
      <input type="password" placeholder="entrez le mot de passe." name="pass1" id="IdPass1" required/>

      </br>

      <label for="pass">Confirmer mot de passe:</label>
      <input type="password" placeholder="entrez le même mot de passe." name="pass2" id="IdPass2" required/>

      <br/>

      <label for="mail">Nom:</label>
      <input type="text" placeholder="votre nom de famille." name="nom" id="IdNom" required/>

      <br/>

      <label for="mail">Prénom:</label>
      <input type="text" placeholder="votre prénom." name="prenom" id="IdPrenom" required/>

      <br/>

      <p style="font-weight:bold;">Date de naissance:</p>
      <input type="number" placeholder="jour" name="jour_user" id="IdJour" min="1" max="31"/>
      <input type="number" placeholder="mois" name="mois_user" id="IdMois" min="1" max="12"/>
      <input type="number" placeholder="année" name="annee_user" id="IdAnnee" min="1950" max="'.date('Y').'"/>

      <br/>

      <label for="adresse">Adresse postale:</label>
      <input type="text" placeholder="votre adresse." name="adresse" id="IdAdresse" />

      <br/>

      <label for="adresse">Téléphone:</label>
      <input type="text" placeholder="votre numéro." name="telephone" pattern="[0-9]{10}" id="IdTelephone" />

      <br/>

      <p style="font-weight:bold;">Sexe:</p>

      <select name="Sexe" id="IdSexe" readonly>
        <option value="Homme">Homme</option>
        <option value="Femme">Femme</option>
      </select>

      <br/>

      </br></br>

      <input type="checkbox" name="termes" id="IdTerme" required/> <label for="termes">J	&apos;accepte les <a href="termes.php">termes d	&apos;utilisations</a> de l	&apos;&copy;ASPTT.</label><br />

      </br>

      <input type="checkbox" name="news" id="IdNews" checked="checked"/> <label for="termes">J	&apos;accepte de reçevoir des news de l	&apos;&copy;ASPTT.</label><br />

      </br>

      <input type="submit" value="Valider" id="btnInscription" module="Inscription;Accueil" regionSucess="#body;#body" regionError="#DivInscription;#body" donne="Mail;Pass1;Pass2;Nom;Prenom;Jour;Mois;Annee;Adresse;Telephone;Sexe;Terme;News" />


  </div>
</div>
';
$response_array['Stop'] = "false";
$response_array['Region'] = $_POST['regionSucess'];

header('Content-type: application/json');
echo json_encode($response_array);







 ?>
