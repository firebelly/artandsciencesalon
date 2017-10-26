<?php
// Redirect to popup on stylist page
header("HTTP/1.1 301 Moved Permanently");
header("Location: ".get_bloginfo('url').'/stylists/#'.($post->post_name));
exit();
?>