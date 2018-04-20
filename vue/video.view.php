<?php
function video(string $title, string $path, string $id, string $channel_id, string $channel, string $views){
  $views = number_format($views);
  echo "<div class=\"video\">\n";
  echo "\t<a href=\"/?v=$id\"><img class=\"responsive-img\" src=\"$path\"></a>\n";
  echo "\t<a class=\"video-title\" href=\"/?v=$id\">$title</a>\n";
  echo "\t<a class=\"video-channel\" href=\"/?channel=$channel_id\">$channel</a>\n";
  echo "\t<p class=\"video-views\">$views vues</p>\n";
  echo "</div>\n";
}

function video_small(string $title, string $path, string $id, string $channel_id, string $channel, string $views){
  $views = number_format($views);
  echo "<div class=\"video-small row\">\n";
  echo "\t<a href=\"/?v=$id\" class=\"col s6\"><img class=\"responsive-img\" src=\"$path\"></a>\n";
  echo "\t<div class=\"col s6\">\n";
  echo "\t\t<a class=\"video-title\" href=\"/?v=$id\">$title</a>\n";
  echo "\t\t<a class=\"video-channel\" href=\"/?channel=$channel_id\">$channel</a>\n";
  echo "\t\t<p class=\"video-views\">$views vues</p>\n";
  echo "\t</div>\n";
  echo "</div>\n";
}
?>