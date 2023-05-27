<?php

/* --------Log in page-------- */

require_once "header.php";

$error = "";echo "<br>";
if(isset($_POST['phone']))									
{

	$phone = sanitizeString($_POST['phone']);
	$pass  = sanitizeString($_POST['pass']);

	if($phone == "" || $pass == "")									// if phone or password field is empty
		$error = "Incomplete phone number/password field(s)"; 
	else
	{

		$result = mysqlQuery("SELECT * FROM members WHERE phone='$phone' AND pass='$pass'");
		if($result->num_rows)										// if this record already exists
		{
			$row 			  = $result->fetch_array(MYSQLI_ASSOC);
			$_SESSION['user'] = $row['user'];
			$_SESSION['pass'] = $pass;
			die("<center style='font-size:30px'>You have Successfully logged in<br><br><a id='imglink' href='index.php'><img src='honeycomb.jpg' title='go to main page'></a></center>");
		}
		else 														// if record doesn't exist 
		{
			$error = "Please check your phone number/password or sign up if you have not created account";
		}

	}

}

echo "<div class='main'><h3>Fill following fields:</h3>";

echo <<<_END

				$error<form method="post" action="login.php">
				<span class="fieldname">Phone No.</span>
				<input type="text" name="phone" maxlength="16"><br>
				<span class="fieldname">Password</span>
				<input type="password" name="pass" maxlength="16"><br>
				<span class="fieldname">&nbsp;</span> <input type="submit" value="Log In">
				</form>

_END;

?>