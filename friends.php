<?php

/* --------Displays Friends(followers, followings and mutual)-------- */

require_once "header.php";

if(!$loggedin) die();

if(isset($_GET['view']))						// this GET collects url data
{

	$view = sanitizeString($_GET['view']);
	if($user == $view)							// if view is you
	{
		$name1 = "Your";
		$name2 = "You are";
	}
	else  							
	{
		$name1 = "$view's";
		$name2 = "$view is";
	}

}

if(isset($_GET['add'])) {

	$add = sanitizeString($_GET['add']);
	mysqlQuery("INSERT INTO friends VALUES('$user', '$add')");
}
elseif(isset($_GET['remove'])) {

	$remove = sanitizeString($_GET['remove']);
	mysqlQuery("DELETE FROM friends WHERE friend='$remove'");
}

$result = mysqlQuery("SELECT * FROM friends WHERE friend='$view'");		// query to select followers
$followers = array();													// array that will contain followers
$num = $result->num_rows;
for($j = 0; $j < $num; ++$j)
{

	$result->data_seek($j);
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$followers[$j] = $row['user'];

}

$result = mysqlQuery("SELECT * FROM friends WHERE user='$view'");		// query to select followings
$following = array();													// array that will contain followings
$num = $result->num_rows;
for($j = 0; $j < $num; ++$j)
{

	$result->data_seek($j);
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$following[$j] = $row['friend'];

}

$mutual = array_intersect($followers, $following);						// array_intersect() returns common members in two arrays
$following = array_diff($following, $mutual);							// array_diff() returns memebers unique to first array
$followers = array_diff($followers, $mutual);

echo "<div class='main'>";
$flag = false;
if(sizeof($mutual))														// if there are more than one mutual friends
{

	echo "<h3>$name1 mutual friends:</h3><ul>";
	foreach ($mutual as $friend)
	{
		echo "<li><a href='messages.php?view=$friend'>$friend</a>
		 [<a href='friends.php?remove=$friend&view=$user'>Unfollow</a>]</li>";
	}
	echo "</ul><br>";

	$flag = true;

}
 
if(sizeof($followers))													// if there are more than one followers
{

	echo "<h3>$name1 followers:</h3><ul>";
	foreach($followers as $friend)
	{
		echo "<li><a href='friends.php?view=$friend'>$friend</a>
		 [<a href='friends.php?add=$friend&view=$user'>Follow</a>]</li>";
	}
	echo "</ul><br>";

	$flag = true;

}

if(sizeof($following))													// if there are more than one followings
{

	echo "<h3>$name2 following:</h3><ul>";
	foreach($following as $friend)
	{
		echo "<li><a href='messages.php?view=$friend'>$friend</a>
		 [<a href='friends.php?remove=$friend&view=$user'>Unfollow</a>]</li>";
	}
	echo "</ul><br>";

	$flag = true;

}

if(!$flag) echo "You dont have any friends yet.<br><br>";

echo "<a class='button1' href='messages.php?view=$view'>View $name1 Messages</a>";

?>
</div>
</body></html>