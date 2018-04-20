<?php
    function comment(string $username, string $id, string $content){
        echo "<div class=\"comment\">\n";
        echo "\t<a href=\"/?channel=$id\" class=\"comment-username\">$username</a>\n";
        echo "\t<p class=\"comment-content\">$content</p>\n";
        echo "</div>\n";
    }
?>