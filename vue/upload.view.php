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
    
      <?php include 'vue/subscribtions.view.php'; ?>

      <div class="col s10" id="upload-main-page">
        <div class="row" id="form-container">
          <?php 
          if($user->id > 0)
          echo '
          <h4 id="form-title" class="col s6">Mettre en ligne une vidéo</h4>
          <div class="line-separator col s6"></div>
          
          <form class="col s6" action="controller/upload.php" method="POST" enctype="multipart/form-data">
            
            <div class="file-field input-field">
              <div class="btn file-btn">
                <span>Vidéo</span>
                <input name="video-file" type="file" accept=".mp4">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
            </div>

            <div class="file-field input-field">
              <div class="btn file-btn">
                <span>Miniature</span>
                <input name="thumbnail-file" type="file" accept=".jpg,.jpeg,.png">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
              </div>
            </div>
            
            <div class="input-field">
              <input name="video-title" id="video-title" type="text">
              <label for="video-title">Titre</label>
            </div>

            <div class="input-field">
              <textarea name="video-description" id="video-description" class="materialize-textarea"></textarea>
              <label for="video-description">Description</label>
            </div>

            <button type="submit" id="form-submit" name="submit" class="btn-large">Mettre en ligne</textarea>

          </form>
          ';
          else
            echo '
            <h4 id="form-title" class="col s6">Vous devez être connecté pour poster une vidéo</h4>
            <a href="/?act=login_page" class="btn-large col s4" id="form-submit">Se connecter</a>
            ';
          ?>
        </div>
      </div>
  </body>
    <!--Import jQuery before materialize.js-->

    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

    <script src="/vue/main.js"></script>
</html>