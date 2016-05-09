<?php
$repAccueil = array();

if(isset($_COOKIE['Connect'])){
  $repAccueil['Status'] = "Success";
  $repAccueil['Type'] = "Replace";
  $repAccueil['Donne'] = 'Connecté';
  $repAccueil['Stop'] = "false";
  $repAccueil['Region'] = $_POST['regionSucess'];
}else{
  $repAccueil['Status'] = "Error";
  $repAccueil['Type'] = "Replace";
  $repAccueil['Stop'] = "false";
  $repAccueil['Donne'] = '
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
          <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <img src="images/892-canoe-kayak-WallFizz.jpg" alt="wall">
          </div>

          <div class="item">
            <img src="images/ardeche-en-canoe.jpg" alt="ardeche">
          </div>

          <div class="item">
            <img src="images/Sea_Kayak.jpg" alt="kayak">
          </div>

          <div class="item">
            <img src="images/Club_France_Vitesse_Gerardmer_2015.jpg" alt="club">
          </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>

        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <div class="horizontal_separator"></div>


      <div class="div_header_content_global">
        <div class="div_header_content">
          <p>
            La section Canoë-Kayak est située sur la base nautique du Lac Kir de Dijon (quai des carrières blanches).
          </p>

          <p>
            Elle offre une pratique de loisir variée et de compétition en ligne.
          </p>

          <p>
            <b>L&apos;école de pagaie :</b>
            C&apos;est le groupe des débutants dans lequel vous apprendrez les manœuvres de base en canoë-kayak dans différentes embarcations. Au fur et à mesure de votre apprentissage vous aurez la possibilité de vous évaluer en passant les diplômes pagaies couleurs, véritable label d&apos;enseignements mis en place par la fédération française de canoë kayak. Le froid, la pluie, la neige…. pas de soucis une séance est prévue au club de canoë kayak de Dijon : sports collectifs, piscine, escalade, course d&apos;orientation…
          </p>

          <p>
            Les séances ont lieu de 14h à 17h le mercredi et le samedi.
          </p>

          <p>
            <b>Compétition :</b>
            Une fois les premiers coups de pagaies maitrisés, vous pourrez vous initier à la compétition. Tous les niveaux sont proposés : du départemental à l&apos;international… Des cadres qualifiés sont présents tous les soirs de la semaine pour vous aider à progresser, en plus du mercredi et samedi après midi.
          </p>

          <p>
            <b>Loisirs et fitness :</b>
            Amateur de balade ou de renforcement musculaire vous choisirez votre envie. Une fois que vous maitriserez votre embarcation vous pourrez pratiquer seul ou en groupe, encadré ou autonome. Des sorties sur des rivières à l&apos;extérieur de Dijon vous seront proposées au cours de l&apos;année.
          </p>

          <p>
            <b>Découverte :</b>
            Toute au long de l&apos;année, vous pouvez profiter de nos locations de canoë et de kayak en toute autonomie sur lac. Vous pouvez aussi découvrir d&apos;autres horizons en pagayant sur nos différents parcours  : "Kayak-Kir" et "Le traversée de Dijon en Canoë kayak". Pour plus d&apos;informations, n&apos;hésitez pas à nous contacter par mail ou téléphone.
          </p>
        </div>
      </div>

      <div class="horizontal_separator"></div>

      <div class="div_index_map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10816.973373988987!2d5.0936225!3d47.3291187!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd8df6970b2032d50!2sASPTT+DIJON!5e0!3m2!1sfr!2sfr!4v1453212325884" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
      </div>

      <div class="horizontal_separator"></div>
  ';
  $repAccueil['Region'] = $_POST['regionError'];
}

header('Content-type: application/json');
echo json_encode($repAccueil);
?>
