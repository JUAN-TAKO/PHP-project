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
    

    <nav>
      <div class="nav-wrapper red darken-1">
        <a href="index.php" class="brand-logo" style="color:yellow;">OurTube</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li>
            <form action="resultat.php" method="GET">
            <input type="text" placeholder="Search..">
            
            </form>
          </li>
          
          
          <li><a href="">Mettre en ligne</a></li>
          <li><a href="?act=login_page"><?php if($GLOBALS['uid'] > 0) echo $GLOBALS['uname']; else Echo 'Compte'; ?></a></li>
          <li><i class="medium material-icons">account_circle</i></li>
        </ul>
      </div>
    </nav>
    <div class="row">
      <div class="col s2 grey lighten-4" style="position:absolute; overflow-y:auto; min-height:calc( 100vh - 64px );">

      </div>
    </div>
  </body>

</html>