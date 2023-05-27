<?php

require_once "header.php";

if(!$loggedin) die();

sessionDestroy();

echo "<br><br><br><center style='font-size:30px'>You are successfully logged out <a href='index.php'>click here</a> to continue.</center>";

?>