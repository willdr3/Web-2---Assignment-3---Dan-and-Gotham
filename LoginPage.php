<!doctype html>
<html>

<head>
	
	<title>Exercise Monitor</title>
	 <meta charset="UTF-8">
	 <link rel="stylesheet" href="Style13.css">
	  <!-- Linking the font I chose to use -->
	 <link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
	 <style type = "text/css">
	
	 </style>
	</head>
	<body>	
	
	<div class="menu">
	<ul>
	<li> <a href="LoginPage.php">Login </a></li>
	<li> <a href="RegistrationPage.php">Registration</a></li>
	
	</ul>
	</div>
	
<?php

/***************************************************
 * Connecting to mySql by including connect page   *
 ***************************************************/
 
 	include 'connect.inc.php';
	
	$db = mysqli_select_db($connection, $database ) or die("Couldn't select database");
	

?>	