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
	
	<script type='text/javascript' src='../jquery-1.8.1.min.js'></script>
	<script type='text/javascript' src='../jquery-ui-1.8.23.custom.min.js'></script>
	
	<script type="text/javascript">
			$(document).ready(function(){
			$("#date").datepicker({  maxDate: new Date, dateFormat: "yy-mm-dd" });
			
			var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();
			
			});
	</script>

	 <?php
			$user = $_SESSION['userName'];
			$userID = $_SESSION['userID'];
	 ?>
	 
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
  
	for	( $i =6; $i>= 0; $i--)
	{
		$datesearch = date("Y-m-d", strtotime("-$i day"));
		echo(",['$datesearch'");
		
		for	($j=0; $j<count($types); $j++)
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
	}?>]);

    var options = {
		title : 'Weekly Exercise data for <? echo("$user"); ?>.',
		vAxis: {title: 'Hours'},
		hAxis: {title: 'Exercise Time'},     
    };
	
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
    chart.draw(data, options);
	}
	</script> 
	 
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