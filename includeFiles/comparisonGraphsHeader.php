<?php
session_start();
include "connect.inc.php";

if (isset($_SESSION['userID']))
{
	$userID = $_SESSION['userID'];
	$user = $_SESSION['userName'];
}

?>
<!doctype html>
<html>
<head>
	<title>Exercise Monitor</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../Style13.css">
	<!-- Linking the fonts I chose to use -->
	<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawVisualization);

	function drawVisualization() {
	// Some raw data (not necessarily accurate)
	var data = google.visualization.arrayToDataTable([<?php
	echo("['Dates'");

	$selectString = 'SELECT DISTINCT catID, catName FROM tblExerCategories';
	$result = mysqli_query($connection,$selectString);
	
	$types = array();

	while($row = mysqli_fetch_assoc($result))
	{
		$types[] = $row['catID'];
		echo(",'$row[catName]'");					
	}
	echo("]");				
  
	for( $i =6; $i>= 0; $i--)
	{
		$datesearch = date("Y-m-d", strtotime("-$i day"));
		echo(",['$datesearch'");
		
		for($j=0; $j<count($types); $j++)
		{			
			$typesearch = $types[$j];
			$selectString= "SELECT * FROM tblExerTimes WHERE date = '$datesearch' AND catID = '$typesearch' AND userID = '$userID'";
			$result = mysqli_query($connection,$selectString);
			
			if (mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_assoc($result);
				echo (", $row[minutes]");
			}
			else
			{
				echo (", 0");
			}
		}
		echo("]");
	}
	?>
	]);

    var options = {
      title : 'Weekly Exercise data for <? echo("$user"); ?>',
      vAxis: {title: 'Minutes'},
      hAxis: {title: 'Exercise Time'},     
    };
	
	var chart = new google.visualization.ColumnChart(document.getElementById('chartDivA'));
    chart.draw(data, options);
	
	<?
	$selectUser = "SELECT DISTINCT userID FROM tblExerTimes WHERE userID != '$userID' ORDER BY RAND() LIMIT 0,1 ";
	$result = mysqli_query($connection,$selectUser);
			
	$row = mysqli_fetch_assoc($result);
	$randomUser = $row['userID'];
	?>
	
	//Second Graph     
    var data1 = google.visualization.arrayToDataTable([<?php
	echo("['Dates'");
	
	$selectString = 'SELECT DISTINCT catID, catName FROM tblExerCategories';
	$result = mysqli_query($connection,$selectString);
			
	$types = array();

	while($row = mysqli_fetch_assoc($result))
	{
		$types[] = $row['catID'];
		echo(",'$row[catName]'");					
	}
	echo("]");				
  
	for( $i =6; $i>= 0; $i--)
	{
		$datesearch = date("Y-m-d", strtotime("-$i day"));
		echo(",['$datesearch'");
		
		for	($j=0; $j<count($types); $j++)
		{			
			$typesearch = $types[$j];
			$selectString= "SELECT * FROM tblExerTimes WHERE date = '$datesearch' AND catID = '$typesearch' AND userID = '$randomUser'";
			$result = mysqli_query($connection,$selectString);
			
			if (mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_assoc($result);
				echo (", $row[minutes]");
			}
			else
			{
				echo (", 0");
			}
		}
		echo("]");
	}
	?>
	]);

    var options1 = {
      title : 'Weekly Exercise data for Random User',
      vAxis: {title: 'Minutes'},
      hAxis: {title: 'Exercise Time'},     
    };
	
	var chart = new google.visualization.ColumnChart(document.getElementById('chartDivB'));
    chart.draw(data1, options1);
	}
	</script>
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