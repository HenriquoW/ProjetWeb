<?php

echo '<div class="div_connexion_global">

    <div class="div_connexion_connexion_inscription">

        <div id="DivConnexion" class="div_connexion_connexion">
            <h2>Connexion</h2>

            <!--<form>-->
                <label for="mail">Adresse mail:</label>
                <input type="email" placeholder="adresse mail." name="mail" id="mail" required/>

                <br/>

                <label for="pass">Mot de passe:</label>
                <input type="password" placeholder="mot de passe." name="pass" id="pass" required/>

                </br>

                <input type="checkbox" name="saveCo" id="saveCo" /> <label for="saveCo">Se souvenir de moi.</label><br />

                </br>
                <input type="submit" id="btnConnexion" module="Connexion" value="Connexion" />
            <!--</form>-->

        </div>

        <!--<div class="vertical_separator"></div>-->

        <div id="DivInscription" class="div_connexion_inscription">
            <h2>Inscription</h2>

            <!--<form>-->
                <label for="mail">Adresse mail:</label>
                <input type="email" placeholder="adresse mail." name="mail" id="mail" required/>

                <br/>

                <label for="pass">Mot de passe:</label>
                <input type="password" placeholder="entrez le mot de passe." name="pass1" id="pass1" required/>

                </br>

                <label for="pass">Mot de passe:</label>
                <input type="password" placeholder="entrez le même mot de passe." name="pass2" id="pass2" required/>

                </br></br>

                <input type="checkbox" name="termes" id="checkbox" OnClick="checkboxValidator(&quot;checkbox&quot;,&quot;submit&quot;);" required/> <label for="termes">J	&apos;accepte les <a href="termes.php">termes d	&apos;utilisations</a> de l	&apos;&copy;ASPTT.</label><br />

                </br>

                <input type="checkbox" name="news" id="news" checked="checked"/> <label for="termes">J	&apos;accepte de reçevoir des news de l	&apos;&copy;ASPTT.</label><br />

                </br>

                <input type="submit" id="btnInscription" module="Inscription" value="Créer compte" disabled="disabled"/>
                <p class="p_petit_texte">acceptez les termes pour créer le compte</p>
            <!--</form>-->

        </div>

    </div>

    <div class="horizontal_separator"></div>
</div>';
 ?>
