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
	
	<link rel='stylesheet' type='text/css' href='fullcalendar/fullcalendar/fullcalendar.css' />
	<link rel='stylesheet' type='text/css' href='fullcalendar/fullcalendar/fullcalendar.print.css' media='print' />

	<script type='text/javascript' src='../jquery-1.8.1.min.js'></script>
	<script type='text/javascript' src='../jquery-ui-1.8.23.custom.min.js'></script>

	<script type='text/javascript' src='fullcalendar/fullcalendar/fullcalendar.min.js'></script>

	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
	<script type="text/javascript">
		$(document).ready(function(){
		$('#calendar').fullCalendar({
			editable: false,
			events: "events.php"
		});
		});
	</script>
	<?php
		$user = $_SESSION['userName'];
		$userID = $_SESSION['userID'];
	?>
</head>
<body>	
	<div class="menu">
		<ul>
			<li> <a href="Home.php">Home</a></li>
			<li> <a href="DataPage.php">Check-In</a></li>
			<li> <a href="CalenderPage.php">Calender</a></li>
			<li> <a href="GraphsPage.php">Review</a></li>
			<li> <a href="GraphsPage2.php">Comparisons</a></li>
			<li> <a href="TotalsPage.php">Life Stats</a></li>
			<li> <a href="LogOut.php">Sign Out</a></li>
		</ul>
	</div>
	<div class="spacer">
	</div>