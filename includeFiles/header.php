<?php
session_start();
include "connect.inc.php";
?>
<!doctype html>
<html>
<head>
	<title>Exercise Monitor</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../Style13.css">
	<!-- Linking the font I chose to use -->
	<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>

	 <?php
			$user = $_SESSION['userName'];
			$userID = $_SESSION['userID'];
	 ?>
</head>
<body>	
	<div class="menu">
	<img src='../images/stick5.png' alt='stickIcon' class='titleImg' />
	<h1 class='title'>X-Track</h1>
		<ul>
			<li> <a href="Home.php">Home</a></li>
			<li> <a href="DataPage.php">Check-In</a></li>
			<li> <a href="CalendarPage.php">Calendar</a></li>
			<li> <a href="GraphsPage.php">Review</a></li>
			<li> <a href="GraphsPage2.php">Comparisons</a></li>
			<li> <a href="TotalsPage.php">Life Stats</a></li>
			<li> <a href="LogOut.php">Sign Out</a></li>
		</ul>
	</div>
	<div class="spacer">
	</div>