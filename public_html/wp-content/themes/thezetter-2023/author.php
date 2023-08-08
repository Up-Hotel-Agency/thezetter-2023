<?php
// redirect author page so you can't find out the admin
header("HTTP/1.1 301 Moved Permanently");
header("Location: /");
?>