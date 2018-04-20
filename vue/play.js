var last = 999999999999;
var nb = 5;
var finished = false;
var savedTime = 0;

$(document).ready(function(){
  loadComments();
});

function sendComment(){
  var com = $('textarea#user-comment').val();
  $.post('controller/comment.php',
    {
      comment: com,
      videoId: current_video_id
    },
    function(){
      $('#all-comments').prepend(getCommentHtml(current_user_name, current_user_id, linkify(escape_HTML(com))));
      $('textarea#user-comment').val('');
    }
  );
}

function getCommentHtml(username, id, content){
  return "<div class=\"comment\">\n" +
      `\t<a href="/?channel=${id}" class="comment-username">${username}</a>\n` +
      `\t<p class="comment-content">${content}</p>\n` +
      "</div>\n"
}
function loadComments(){
  savedTime = Date.now();
  $.get('controller/get_comments.php',{vid_id: current_video_id, last: last, nb: nb}, function(data, status){
    var comments = JSON.parse(data);
    if(comments.length > 0)
      last = comments[comments.length-1]["date"];
    finished = (comments.length < nb);
    for (var i = 0; i < comments.length; i++) {
      $("#all-comments").append(getCommentHtml(comments[i]["username"], comments['id'], comments[i]["comment"]));
    }
  });

}

function escape_HTML(html_str) {
  return html_str.replace(/[&<>"]/g, function (tag) {
  var chars_to_replace = {
          '&': '&amp',
          '<': '&lt',
          '>': '&gt',
          '"': '&quot',
          '\'': '&#39'
      };
  return chars_to_replace[tag] || tag;
});
}
function linkify(text) {
  var urlRegex =/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
  return text.replace(urlRegex, function(url) {
      return '<a href="' + url + '">' + url + '</a>';
  });
}


$(document).scroll(function () {
  var scrollDistanceToBottom = document.body.scrollHeight - window.innerHeight - window.scrollY;
  if (scrollDistanceToBottom < 300 && !finished && (Date.now() - savedTime) > 1000){
    loadComments();
  }
});
