<!DOCTYPE html>

<html>

  <head>

    <!--Import Google Icon Font-->

    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--Import materialize.css-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  </head>


  <body>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
    
  <?php include 'navbar.view.php' ?>

    <div class="row">
      <div class="col s2 grey lighten-4" style="overflow-y:auto; min-height:calc( 100vh - 64px ); padding:0px;">

     <li class="no-padding">
          <ul class="collapsible collapsible-accordion" style="margin: 0px;">
            <li class="bold"><a class="collapsible-header waves-effect waves-teal" tabindex="0">Abonnements</a>
              <div class="collapsible-body" style="">
                <ul>
                  <li><a href="chaine.view.php">Chaine 1</a></li>
                  <li><a href="chaine.view.php">Chaine 2</a></li>
                  <li><a href="chaine.view.php">Chaine 3</a></li>
                  <li><a href="chaine.view.php">Chaine 4</a></li>
                  <li><a href="chaine.view.php">Chaine 5</a></li>
                  <li><a href="chaine.view.php">Chaine 6</a></li>
                  <li><a href="chaine.view.php">Chaine 7</a></li>
                </ul>
              </div>
            </li>

      </div>

       <div class="col s4" style="width: 246px; padding: 0px;">
  <!-- Promo Content 1 goes here -->
  <a href="video.view.php"> <img src="../img/walkthroughfire.jpg" alt=""></a>
  <p>WalkthroughFire</p>
</div>

<div class="col s4" style="width: 246px; padding: 0px;">
  <!-- Promo Content 2 goes here -->
  <a href="video.view.php"> <img src="img/EverybodyKnows.jpg" alt=""> </a>
  <p>EverybodyKnows</p>
</div>
    </div>

   

  </body>

</html>