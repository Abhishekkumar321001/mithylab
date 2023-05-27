<?php

// header is the part of the website that is shared by all web pages

require_once "functions.php"; 

session_start(); 									 // this function starts the session

$user = ""; $greet = " (guest)"; $loggedin = false;  // $user will contain user name
if(isset($_SESSION['user']))						 // $greet will contain (user name)
{													 // $loggedin will contain bool value 				

	$user 	  = sanitizeString($_SESSION['user']);
	$greet 	  = " ($user)";
	$loggedin = true;

}

echo <<<_END

				<!DOCTYPE html>
				<html>
				<head>
				<title>Honey Comb</title>
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<link rel="stylesheet" href="styles.css">
				</head>
				<body>
				<canvas id="mycanvas" width="1230" height="220"></canvas>
				<script src="javascript.js"></script>
				<div id="greeting"><center>Honey Comb$greet</center></div>
				<div style="margin:20px"><center>

_END;

if($loggedin) // if logged in then show different navigation links 
{

echo <<<_END

				<a class="button" href="members.php?view=$user">Home</a>
				<a class="button" href="members.php">Members</a>
				<a class="button" href="friends.php?view=$user">Friends</a>
				<a class="button" href="messages.php?view=$user">Messages</a>
				<a class="button" href="edit.php">Edit Profile</a>
				<a class="button" href="logout.php">Log Out</a></center></div>

_END;

}

else  		  // if not logged in
{

echo <<<_END

				<a class="button" href="index.php">Home</a>
				<a class="button" href="signin.php">Sign Up</a>
				<a class="button" href="login.php">Log In</a><center></div>

_END;

}

?>