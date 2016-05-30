<?php
$response_array = array();

$response_array['Status'] = "Success";
$response_array['Type'] = "Replace";
$response_array['Donne'] = '<div class="div_connexion_global">
                              <div class="div_connexion_connexion_inscription">

                                  <div id="DivConnexion" class="div_connexion_connexion">
                                      <h2>Connexion</h2>

                                          <label for="mail">Adresse mail:</label>
                                          <input type="email" placeholder="adresse mail." name="mail" id="IdMail" value="'. (isset($_COOKIE['Mail']) ? $_COOKIE['Mail'] : '') .'" required/>

                                          <br/>

                                          <label for="pass">Mot de passe:</label>
                                          <input type="password" placeholder="mot de passe." name="pass" id="IdPassword" required/>

                                          </br>

                                          <input type="checkbox" name="saveCo" id="IdSave" '. (isset($_COOKIE['Mail']) ? 'checked="checked"' : '') .'/> <label for="saveCo">Se souvenir de moi.</label><br />

                                          </br>
                                          <input type="submit" id="btnConnexion" module="Connexion;Accueil;Header" regionSucess="#body;#body;#header" regionError="#DivConnexion;#body;#header" donne="Mail;Password;Save" value="Connexion" />

                                  </div>
                                </div>
                                <div class="horizontal_separator"></div>
                              </div>';
$response_array['Stop'] = "false";
$response_array['Region'] = $_POST['regionSucess'];

header('Content-type: application/json');
echo json_encode($response_array);
 ?>
