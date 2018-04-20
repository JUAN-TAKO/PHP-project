
<div class="col s2">
  <div class="col s2 grey lighten-4" id="list">
    <div id="list-content">
      <h5 id="subscribtions-title">Abonnements</h5>
      <ul>
      <?php
        foreach($subscribtions as $sub){
          echo '<li class="subscribtion"><a href="/?channel=' . $sub->id .'">' . $sub->nom;
          if($sub->new > 0) echo '<span class="new badge red darken-1">' . $sub->new . '</span>';
          echo '</a></li>';
        }
      ?>
      </ul>
    </div>
  </div>
</div>