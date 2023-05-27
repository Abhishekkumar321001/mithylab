<?php

require_once "header.php";

if(isset($_GET['view']))
{

	$view = sanitizeString($_GET['view']);
	if($view == $user) $name = "You($user)";
	else 			   $name = $view; 

}

if(isset($_POST['message']))
{

	$message = sanitizeString($_POST['message']);
	if($message != "")
	{

		$pm   = sanitizeString($_POST['pm']);
		$time = time();

		mysqlQuery("INSERT INTO messages VALUES('$user', '$view', '$pm', '$time', '$message')"); 

	}

}

echo "<div class='main'>$name:<br><br>";
showProfile($view); echo "<br>";

if(strcmp($name, "You($user)"))
{

echo <<<_END

				<form method="post" action="messages.php?view=$view">
				<textarea name="message" cols="50" rows="5"></textarea><br>
				<input type="radio" name="pm" value="0">Public
				<input type="radio" name="pm" value="1" checked="">Private &nbsp;
				<input type="submit" value="Send Message" style="font-size: 100%">
				</form><br><br>

_END;

}

$result = mysqlQuery("SELECT * FROM messages");
$num	= $result->num_rows;
if(!$num) {

	echo "<span id='nomsg'>&#9762; There are no messages</span>";
}
else {

	for($j = 0; $j < $num; $j++) { 
		
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$auth = $row['auth']; $recip = $row['recip'];

		if((!strcmp($auth, $user) && !strcmp($recip, $view)) || (!strcmp($auth, $view) && (!strcmp($recip, $user))) || (!strcmp($user, $view) && (!strcmp($auth, $user) || !strcmp($recip, $user)))) {

			echo "At " . date('d-m-Y T H:i:s', $row['time']) . ": ";
			if($row['pm'] == '0') {

				echo "<a href='messages.php?view=$auth'>$auth</a> speaks to <a href='messages.php?view=$recip'>$recip</a> ";
			}
			else {

				echo "<a href='messages.php?view=$auth'>$auth</a> <span id='pm'>whispers</span> to <a href='messages.php?view=$recip'>$recip </a>";
			}

			echo '" ' . $row['message'] . ' "<br><br>';

		}
		elseif($row['pm'] == 0) {

			echo "At " . date('d-m-Y T H:i:s', $row['time']) . ": ";
			echo "<a href='messages.php?view=$auth'>$auth</a> speaks to <a href='messages.php?view=$recip'>$recip</a> ";
			echo '" ' . $row['message'] . ' "<br><br>';
		}

}

}
?>
</div>
</body>
</html>