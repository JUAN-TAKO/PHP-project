<div>
  <div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper red darken-1">
        <ul class="row">
          <li class="col s2" style="float:left;"><a href="." id="logo" class="brand-logo" style="padding-left:20px;"><i class="material-icons" id="logo-icon">play_circle_outline</i>OurTube</a></li>

          <ul id="dropdown-account" class="dropdown-content">
            <li><a class="dropdown-elem" href="/?channel=0"><i class="col s1 medium material-icons">videocam</i>Ma chaine</a></li>
            <li class="divider" tabindex="-1"></li>
            <li><a class="dropdown-elem" href="?act=login_page"><i class="col s1 medium material-icons">loop</i>Changer de compte</a></li>
            <li class="divider" tabindex="-1"></li>
            <li><a class="dropdown-elem" href="?act=logout"><i class="col s1 medium material-icons">power_settings_new</i>Se déconnecter</a></li>
          </ul>
          <?php
            if($user->id > 0){
              echo '<li id="account" class="dropdown-trigger" data-target="dropdown-account"><a>';
            }else{
              echo '<li id="account"><a href="?act=login_page">';
            }
          ?> 

            <div>
              <div id="uname"><?php if($user->id > 0) echo $user->nom; else Echo 'Compte'; ?></div>
              <i class="medium material-icons" style="float:right;">account_circle</i>          
            </div>
          </a></li>

          <li style="float:right;"><a href="?act=upload">
            <div class="row">
              <i class="col s1 medium material-icons">file_upload</i>
              <div class="col s8" style="margin-left:10px;">Publier</div>
            </div>
          </a></li>
          <li style="padding:0px; width:auto; float:none; display:block; position:relative; overflow:hidden;"><form method="GET" action="">
            <div class="input-field">
              <input name="q" id="search" type="search" placeholder="Rechercher...">
              <label class="label-icon" for="search"><i class="material-icons">search</i></label>
              <i class="material-icons">close</i>
            </div>
          </form></li>
        </ul>
      </div>
    </nav>
  </div>
</div>
    