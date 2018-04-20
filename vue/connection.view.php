<!DOCTYPE html>

<html>


<head>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
  <link rel="stylesheet" type="text/css" href="vue/style.css">
</head>

<body id="connection-body">
  <div class="section"></div>
  <main id="connection-main">
    <center>
      <div class="section"></div>

      <h5 class="red-text text-darken-1"><?php 
      if($isLog)
        echo 'Please, login into your account';
      else
        echo 'Create a new account'
      ?></h5>
      <div class="section"></div>

      <div class="container">
        <div class="z-depth-1 grey lighten-4 row" id="connection-container">

          <form class="col s12" action="controller/<?php if($isLog) echo 'login.php'; else echo 'register.php'; ?>" method="post">
            <div class='row'>
              <div class='col s12'>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type='text' name='username' id='email' />
                <label for='email'>Enter your name</label>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type='password' name='password' id='password' />
                <label for='password'>Enter your password</label>
              </div>
            </div>
            <div class="row">
                <input type="checkbox", id="remember", name="remember">
                <label for="remember"> Remember me </label>
            </div>
            <br />
            <center>
              <div class='row'>
                <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect red darken-1'> <?php if($isLog) echo 'Login'; else echo 'Create account'; ?></button>
              </div>
            </center>
          </form>
        </div>
      </div>
      <a 
      <?php
        if($isLog)
          echo 'href="?act=register_page"> Pas encore de compte ? Créer un compte';
        else
          echo 'href="?act=login_page"> Déjà un compte ? Se connecter';
      ?>
      </a>
    </center>

    <div class="section"></div>
    <div class="section"></div>
  </main>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
</body>

</html>