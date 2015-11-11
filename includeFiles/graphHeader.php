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
	<!-- Linking the fonts I chose to use -->
	<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>

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
			

	}
			  ?>
	
	]);

    var options = {
      title : 'Weekly Exercise data for <? echo("$user"); ?>',
      vAxis: {title: 'Hours'},
      hAxis: {title: 'Exercise Time'},     
    };
	
	var chart = new google.visualization.ColumnChart(document.getElementById('chartDiv'));
    chart.draw(data, options);
	
	var data1 = google.visualization.arrayToDataTable([
		<?php
			echo("['Exercise category', 'Total minutes']");
			
			$selectString = 'SELECT DISTINCT catID, catName FROM tblExerCategories';
			$result = mysqli_query($connection,$selectString);
			
			$types1 = array();

			while($row = mysqli_fetch_assoc($result))
			{
				$types1[] = $row['catName'];
			}
			for	($i =0; $i<count($types); $i++)
			{
				$totalMinutes = 0;
				echo(",['$types1[$i]',");
				$cat = $types1[$i];
				
				$selectCatID = "SELECT DISTINCT catID from tblExerCategories WHERE catName LIKE '$types1[$i]'";
				$result = mysqli_query($connection, $selectCatID);
				
				if(mysqli_num_rows($result) > 0)
				{
					$row = mysqli_fetch_assoc($result);
					$catID = $row['catID'];
				}
				
				$selectString= "SELECT minutes FROM tblExerTimes WHERE catID = '$catID' AND userID = '$userID'";
				$result = mysqli_query($connection,$selectString);
				
				while($row = mysqli_fetch_assoc($result))
				{	
					$totalMinutes =	$totalMinutes + $row['minutes'];			
				}
				echo("$totalMinutes]");
			}
			echo("  ]);");
		?>
		var options1 = {
			title: 'Weekly Exercise percentages for <? echo("$user"); ?>',
			is3D: true,
        };
			var chart = new google.visualization.PieChart(document.getElementById('pieChart'));
			chart.draw(data1, options1);
		}
	</script>
	 
</head>
<body>	
	<div class="menu">
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