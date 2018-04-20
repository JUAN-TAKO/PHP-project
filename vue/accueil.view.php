<?php require_once('video.view.php'); ?>

<!DOCTYPE html>

<html>

  <head>
    <script>
      var current_user_name = "<?php echo $user->nom;?>";
      var current_user_id = <?php echo $user->id;?>;
      var is_subscribed = <?php echo (int)$subscribed;?>;
      var current_channel_id = <?php echo $current_channel->id;?>;
    </script>
    <!--Import Google Icon Font-->

    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--Import materialize.css-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

    <link rel="stylesheet" href="/vue/style.css">
    <!--Let browser know website is optimized for mobile-->

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  </head>


  <body>

    
    <?php include 'vue/navbar.view.php'; ?>

    <div class="row">

      <?php include 'vue/subscribtions.view.php'; ?>
      <div class="col s10" style="padding:0px;">
        <?php
          if($current_channel->id > 0){
            $cn = $current_channel->nom;
            echo '<div id="channel-banner" class="grey lighten-4">';
            echo "<h4 id=\"channel-title\">$cn</h4>";
            if($current_channel->id != $user->id)
              echo '<a class="btn" id="subscribe-button" onclick="subscribe()">S\'abonner</a>';
            echo '</div>';
          }
        ?>
        <div id="main-page">

          <?php
            foreach($videos as $vid){
              video($vid->title, '../img/' . $vid->id . '.jpg', $vid->id, $vid->channel_id, $vid->channel_name, $vid->views);
            }
          ?>
        </div>
      </div>
    </div>
  </body>
    <!--Import jQuery before materialize.js-->

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

    <script src="/vue/main.js"></script>
</html>