<?php

$response_array = array();

$response_array['Status'] = "Success";
$response_array['Type'] = "Replace";
$response_array['Donne'] = '<div class="div_connexion_global">
                              <div class="div_connexion_connexion_inscription">

                                  <div id="DivConnexion" class="div_connexion_connexion">
                                      <h2>Connexion</h2>

                                          <label for="mail">Adresse mail:</label>
                                          <input type="email" placeholder="adresse mail." name="mail" id="IdMail" required/>

                                          <br/>

                                          <label for="pass">Mot de passe:</label>
                                          <input type="password" placeholder="mot de passe." name="pass" id="IdPassword" required/>

                                          </br>

                                          <input type="checkbox" name="saveCo" id="saveCo" /> <label for="saveCo">Se souvenir de moi.</label><br />

                                          </br>
                                          <input type="submit" id="btnConnexion" module="Connexion;Accueil;Header" regionSucess="#body;#body;#header" regionError="#DivConnexion;#body;#header" donne="Mail;Password" value="Connexion" />

                                  </div>
                                </div>
                                <div class="horizontal_separator"></div>
                              </div>';
$response_array['Stop'] = "false";
$response_array['Region'] = $_POST['regionSucess'];

header('Content-type: application/json');
echo json_encode($response_array);

/*echo

        <!--<div class="vertical_separator"></div>

        <div id="DivInscription" class="div_connexion_inscription">
            <h2>Inscription</h2>

            <!--<form>-->
                <label for="mail">Adresse mail:</label>
                <input type="email" placeholder="adresse mail." name="mail" id="mailIns" required/>

                <br/>

                <label for="pass">Mot de passe:</label>
                <input type="password" placeholder="entrez le mot de passe." name="pass1" id="pass1" required/>

                </br>

                <label for="pass">Mot de passe:</label>
                <input type="password" placeholder="entrez le même mot de passe." name="pass2" id="pass2" required/>

                </br></br>

                <input type="checkbox" name="termes" id="checkboxTerme" required/> <label for="termes">J	&apos;accepte les <a href="termes.php">termes d	&apos;utilisations</a> de l	&apos;&copy;ASPTT.</label><br />

                </br>

                <input type="checkbox" name="news" id="news" checked="checked"/> <label for="termes">J	&apos;accepte de reçevoir des news de l	&apos;&copy;ASPTT.</label><br />

                </br>

                <input type="submit" id="btnInscription" module="Inscription" value="Créer compte" />
                <p class="p_petit_texte">acceptez les termes pour créer le compte</p>
            <!--</form>-->

        </div>-->

    ;*/
 ?>
