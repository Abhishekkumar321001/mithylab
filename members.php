<?php

/* --------Displays all members-------- */

require_once "header.php";

if(!$loggedin) die();

echo "<div class='main'>";
if(isset($_GET['view']))											// GET method collects data sent through url
{

	$view = sanitizeString($_GET['view']);
	if($user == $view)												// if view is you
		$name = "Your's";
	else
		$name = "$view's";
	echo "<h3>$name profile</h3>";
	showProfile($view);
	echo "<a class='button1' href='messages.php?view=$view'>View $name Messages</a>";
	die("</div></body></html>");

}

if(isset($_GET['add']))												// add friend
{

	$add = sanitizeString($_GET['add']);
     mysqlQuery("INSERT INTO friends VALUES('$user', '$add')");

}
elseif(isset($_GET['remove']))										// remove friend
{

	$remove = sanitizeString($_GET['remove']);
	 mysqlQuery("DELETE FROM friends WHERE user='$user' AND friend='$remove'");

}

$result = mysqlQuery("SELECT user FROM members ORDER BY user");
$num    = $result->num_rows;

echo "<h3>Other members:</h3><ul>";

for($j = 0; $j < $num; $j++)
{

	$result->data_seek($j);
	$row = $result->fetch_array(MYSQLI_ASSOC);

	if($row['user'] == $user) continue;								// if cur member is you then continue
	$cur_user = $row['user'];

	echo "<li><a href='members.php?view=$cur_user'>$cur_user</a>";

	$result1 = mysqlQuery("SELECT * FROM friends WHERE user='$cur_user' AND friend='$user'");
	$t1      = $result1->num_rows;
	$result1 = mysqlQuery("SELECT * FROM friends WHERE user='$user' AND friend='$cur_user'");
	$t2 	 = $result1->num_rows;

	if($t1+$t2 > 1) echo " &harr; is a mutual friend";
	elseif($t2) echo " &larr; you are following";
	elseif($t1) echo " &rarr; is following you";

	if(!$t2) echo " [<a href='members.php?add=$cur_user'>Follow</a>]";
	else echo " [<a href='members.php?remove=$cur_user'>Unfollow</a>]";
	echo "</li>";

}

?>
</ul>
</div></body></html>