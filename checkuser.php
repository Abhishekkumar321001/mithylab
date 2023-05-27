<?php

require_once "functions.php";

if(isset($_GET['user']))
{

	$user = sanitizeString($_GET['user']);

	$result = mysqlQuery("SELECT * FROM members WHERE user='$user'");

	if($result->num_rows)
		echo "<span class='taken'> &#x2715;this username has already been taken</span>";
	else
		echo "<span class='available'> &check;this username is available</span>";

}

?>