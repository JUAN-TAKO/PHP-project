<?php require_once('video.view.php'); require_once('comment.view.php'); ?>

<!DOCTYPE html>

<html>

  <head>
    <script>
      var current_video_id = <?php echo $video->id;?>;
      var current_user_name = "<?php echo $user->nom;?>";
      var current_user_id = <?php echo $user->id;?>;
      var is_subscribed = <?php echo (int)$subscribed;?>;
      var current_channel_id = <?php echo $video->channel_id;?>;
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
    
    <?php include 'vue/navbar.view.php' ?>

    <div id="main-play">
      <div id="center-play" class="row">
        <div id="video-comments" class="col s8">
          
          <video id="main-video" class="responsive-video" controls autoplay>
            <source src="/videos/<?php echo $video->id;?>.mp4" type="video/mp4">
          </video>
          <h5 id="main-video-title"><?php echo $video->title; ?></h5>
          <p id="main-video-views"><?php echo number_format($video->views); ?> vues</p>
          <div class="line-separator"></div>
          <a id="main-video-channel" href="/?channel=<?php echo $creator->id;?>"><?php echo $creator->nom;?></a>
          <?php 
          if($creator->id != $user->id)
            echo '<a class="btn" id="subscribe-button" onclick="subscribe()">S\'abonner</a>';
          ?>
          <p id="description">
            <?php echo make_links($video->description);?>
          </p>
          <div class="line-separator"></div>
          <h6 id="comment-title"> <?php echo number_format($nb_comments) ?> Commentaires</h6>
          
          <div id="write-comment">
          <?php
          if($user->id > 0){
          echo '
          
            <div id="comment-username">';echo $user->nom; echo'</div>
            
            <div class="row">
              <form class="col s12" action="controller/comment.php", method="POST">
                <div class="row" id="comment-text">
                  <div class="input-field col s11">
                    <textarea id="user-comment" class="materialize-textarea" name="comment"></textarea>
                    <label for="user-comment">Commentaire</label>
                  </div>
                  <a onclick="sendComment()"><i class="material-icons" id="send-icon">send</i></a>
                </div>
              </form>
            </div>
            ';}
            else{
              echo '<p>Vous devez être connecté pour laisser un commentaire</p>';
              echo '<a class="btn" href="/?act=login_page">Se connecter</a></br></br></br>';
            }  
            ?>
          </div>
          
          <div id="all-comments">

          </div>

        </div>
        <div id="recommendations" class="col s4">
        <?php
          foreach($videos as $vid){
            video_small($vid->title, '../img/' . $vid->id . '.jpg', $vid->id,$vid->channel_id, $vid->channel_name, $vid->views);
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
  <script src="/vue/play.js"></script>

</html>