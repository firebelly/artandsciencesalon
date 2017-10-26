<?php
// Redirect to section on location page
header("HTTP/1.1 301 Moved Permanently");
header("Location: ".get_bloginfo('url').'/locations/#'.($post->post_name));
exit();
?>