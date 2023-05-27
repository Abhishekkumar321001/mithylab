<?php

/* this document contains all function definations and database accessing code */

// <------IMPORTANT------> please run setup.php to create tables in database

$hostname = "localhost";			// host name
$username = "";				// user name (change it to your user name) 
$password = "";	// password (change it to your password)
$database = "db_honeycomb";			// database name

$connection = new mysqli($hostname, $username, $password, $database) or die($connection->connect_error); /** this statement connects site to 																											* the database */ 

function mysqlQuery($query)        // it lets you execute a sql query
{

	global $connection;

	$result = $connection->query($query) or die($connection->error);
	return $result;

}

function createTable($name, $query) // it lets you create a table
{

	$result = mysqlQuery("CREATE TABLE IF NOT EXISTS $name($query)");
	echo "Table is created or already exists";

}

function sessionDestroy()		   // it lets a user destroy his/her session (log out)
{

	$_SESSION = array();
	if(session_id() != "" || isset($_COOKIE[session_name()]))
		setcookie(session_name(), "", time() - 24*3600, "/");

	session_destroy();

}

function sanitizeString($str)	 // it lets you sanitize a string
{

	global $connection;

	$str = strip_tags($str);
	$str = htmlentities($str);
	$str = stripslashes($str);
	$str = $connection->real_escape_string($str);

	return $str;

}

function showProfile($user)     // it displays user profile
{

	if(file_exists("profile_pics/$user.jpg"))
		echo "<img src='profile_pics/$user.jpg' style='float: left'>";

	$result = mysqlQuery("SELECT * FROM profiles WHERE user='$user'");

	if($result->num_rows) {

		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo "<span style='font-style:italic;font-weight:bold'>" . stripcslashes("&nbsp;" . $row['about']) . "</span>";

	}

	echo "<br style='clear: left'><br>";

}

?>