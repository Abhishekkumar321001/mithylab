<?php

require_once "header.php";

echo "<div class='main'><br><br>";

if(!$loggedin)
{
	echo "<center><span id='mainline'>You need to log in to view this page</span></center><br><br>";
}

echo "<center style='font-size:30px'>Welcome to Honey Comb, you are$greet.</center>";

?>
</div>
</body>
</html>