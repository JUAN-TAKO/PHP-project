<?php require_once('video.view.php')?>

<!DOCTYPE html>

<html>

  <head>

    <!--Import Google Icon Font-->

    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--Import materialize.css-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

    <link rel="stylesheet" href="/vue/style.css">
    <!--Let browser know website is optimized for mobile-->

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  </head>


  <body>

    
  <?php include 'vue/navbar.view.php' ?>

    <div class="row">
      <div class="col s2">
        <div class="col s2 grey lighten-4" id="list">
          <div id="list-content">
            <h5 id="subscribtions-title">Abonnements</h5>
            <ul>
            <?php
              for($i = 0; $i < 10; $i++){
                echo "<li class=\"subscribtion\"><a href=\"\">Abonnement $i</a></li>";
              }
            ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="col s10" id="main-page">
        <?php
          video('ON FILME DES CADAVRES CA TOURNE MAL ?!!', '../img/logan.jpeg', '1', 'LoganPaulVlogs', '6,870,064');
          video('>> Jackspedicey <<', '../img/pdp.jpeg', '2', 'PewDiePie', '2,423,492');
          video('ON FILME DES CADAVRES CA TOURNE MAL ?!!', '../img/logan.jpeg', '1', 'LoganPaulVlogs', '6,870,064');
          video('>> Jackspedicey <<', '../img/pdp.jpeg', '2', 'PewDiePie', '2,423,492');
          video('ON FILME DES CADAVRES CA TOURNE MAL ?!!', '../img/logan.jpeg', '1', 'LoganPaulVlogs', '6,870,064');
          video('ON FILME DES CADAVRES CA TOURNE MAL ?!!', '../img/logan.jpeg', '1', 'LoganPaulVlogs', '6,870,064');
          video('>> Jackspedicey <<', '../img/pdp.jpeg', '2', 'PewDiePie', '2,423,492');
          video('ON FILME DES CADAVRES CA TOURNE MAL ?!!', '../img/logan.jpeg', '1', 'LoganPaulVlogs', '6,870,064');
          video('>> Jackspedicey <<', '../img/pdp.jpeg', '2', 'PewDiePie', '2,423,492');
          video('ON FILME DES CADAVRES CA TOURNE MAL ?!!', '../img/logan.jpeg', '1', 'LoganPaulVlogs', '6,870,064');
          video('ON FILME DES CADAVRES CA TOURNE MAL ?!!', '../img/logan.jpeg', '1', 'LoganPaulVlogs', '6,870,064');
          video('>> Jackspedicey <<', '../img/pdp.jpeg', '2', 'PewDiePie', '2,423,492');
          video('ON FILME DES CADAVRES CA TOURNE MAL ?!!', '../img/logan.jpeg', '1', 'LoganPaulVlogs', '6,870,064');
          video('>> Jackspedicey <<', '../img/pdp.jpeg', '2', 'PewDiePie', '2,423,492');
          video('ON FILME DES CADAVRES CA TOURNE MAL ?!!', '../img/logan.jpeg', '1', 'LoganPaulVlogs', '6,870,064');
          video('ON FILME DES CADAVRES CA TOURNE MAL ?!!', '../img/logan.jpeg', '1', 'LoganPaulVlogs', '6,870,064');
          video('>> Jackspedicey <<', '../img/pdp.jpeg', '2', 'PewDiePie', '2,423,492');
          video('ON FILME DES CADAVRES CA TOURNE MAL ?!!', '../img/logan.jpeg', '1', 'LoganPaulVlogs', '6,870,064');
          video('>> Jackspedicey <<', '../img/pdp.jpeg', '2', 'PewDiePie', '2,423,492');
          video('ON FILME DES CADAVRES CA TOURNE MAL ?!!', '../img/logan.jpeg', '1', 'LoganPaulVlogs', '6,870,064');
        ?>
      </div>
    </div>
  </body>
    <!--Import jQuery before materialize.js-->

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

    <script src="/vue/accueil.js"></script>
</html>