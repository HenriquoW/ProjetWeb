<!doctype html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Connexion</title>
    </head>

    <body>
    	<?php include 'includes/header.php' ;?>

        <div class="div_connexion_global">

            <div class="div_connexion_connexion_inscription">

                <div class="div_connexion_connexion">
                    <h2>Connexion</h2>

                    <form method="post" action="traitementConnexion.php">
                        <label for="mail">Adresse mail:</label>
                        <input type="email" placeholder="adresse mail." name="mail" id="mail" required/>

                        <br/>

                        <label for="pass">Mot de passe:</label>
                        <input type="password" placeholder="mot de passe." name="pass" id="pass" required/>

                        </br>

                        <input type="checkbox" name="saveCo" id="saveCo" /> <label for="saveCo">Se souvenir de moi.</label><br />

                        </br>
                        <input type="submit" value="Connexion" />
                    </form>

                </div>

                <!--<div class="vertical_separator"></div>-->

                <div class="div_connexion_inscription">
                    <h2>Inscription</h2>

                    <form method="post" action="traitementInscription.php">
                        <label for="mail">Adresse mail:</label>
                        <input type="email" placeholder="adresse mail." name="mail" id="mail" required/>

                        <br/>

                        <label for="pass1">Mot de passe:</label>
                        <input type="password" placeholder="entrez le mot de passe." name="pass1" id="pass1" required/>

                        </br>

                        <label for="pass2">Mot de passe:</label>
                        <input type="password" placeholder="entrez le même mot de passe." name="pass2" id="pass2" required/>

                        </br></br>

                        <input type="checkbox" name="termes" id="checkbox" OnClick="checkboxValidator('checkbox','submit');" required/> <label for="termes">J'accepte les <a href="termes.php">termes d'utilisations</a> de l'&copy;ASPTT.</label><br />

                        </br>

                        <input type="checkbox" name="news" id="news" checked="checked"/> <label for="termes">J'accepte de reçevoir des news de l'&copy;ASPTT.</label><br />

                        </br>

                        <input type="submit" id="submit" value="Créer compte" disabled="disabled"/>
                        <p class="p_petit_texte">acceptez les termes pour créer le compte</p>
                    </form>

                </div>

            </div>

            <div class="horizontal_separator"></div>
        </div>

        <!--<?php include 'includes/footer.php' ;?>-->
    </body>

</html>

<script type="text/javascript" src="js/checkboxValidator.js"></script>
