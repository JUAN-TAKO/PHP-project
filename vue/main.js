$(document).ready(function(){
    $('.dropdown-trigger').dropdown({
      alignement: 'right',
      constrainWidth: false,
      coverTrigger: false
    });
    updateSubscribeButton();
});

function subscribe(){
  if(current_user_id > 0){
    if(is_subscribed){
      M.toast({html: 'Abonnement retiré'});
      is_subscribed = false;
    }else{
      M.toast({html: 'Abonnement ajouté'});
      is_subscribed = true;
    }
    $.post('controller/subscribe.php', {subscribed: is_subscribed, channel_id: current_channel_id});
    updateSubscribeButton();
  }
  else{
    M.toast({html: 'Vous devez être connecté'});
  }
}
function updateSubscribeButton(){
  $('#subscribe-button').removeClass('fake-disabled');
  if(current_user_id > 0){
    if(is_subscribed)
      $('#subscribe-button').html('Se désabonner');
    else
      $('#subscribe-button').html('S\'abonner');
  }
  else{
    $('#subscribe-button').html('S\'abonner');
    $('#subscribe-button').addClass('fake-disabled');
  }
}

