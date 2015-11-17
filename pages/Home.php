<?php
include_once "../includeFiles/header.php";
include "../includeFiles/accessControl.inc.php";

$user = $_SESSION['userName'];

$selectDate = "SELECT DISTINCT date FROM tblExerTimes WHERE userID = '$userID' ORDER BY date DESC LIMIT 1";
$result = mysqli_query($connection, $selectDate);

$row = mysqli_fetch_assoc($result);
$lastDate = $row['date'];
$today = date("Y-m-d", strtotime("now"));


if($lastDate != 0)
{
	$diff = abs(strtotime($today) - strtotime($lastDate));
	
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months * 30*60*60*24) / (60*60*24));
	if($days == 0)
	{
		echo("<div class='outerHomeCont'>");
			echo("<div class='innerCont'>");
				echo("<h1> Welcome to X-Track $user</h1>");
				echo("<h2>You must be feeling fit today, you're back again</h2>");
				echo("<h3>While you're here, be sure to <a href='DataPage.php'>Check In</a></h3>");
	}
	else
	{
		echo("<div class='outerHomeCont'>");
			echo("<div class='innerCont'>");
				echo("<h1> Welcome to X-Track $user</h1>");
				echo("<h2>It's been $days days since your last check-in</h2>");
				echo("<h3>In saying that, you must be here to <a href='DataPage.php'>Check In</a></h3>");
	}
}
else
{
	echo("<div class='outerHomeCont'>");
		echo("<div class='innerCont'>");
			echo("<h1> Welcome to X-Track $user</h1>");
			echo("<h2>You have entered no data thus far. Try our <a href='DataPage.php'>Check In</a> page to enter some data</h2>");
}
echo("<br>");
echo("<div class='homeImgsDiv'>");
echo("<img src='../images/running.png' class='homeImgs' alt='running.png' /><img src='../images/cricket.png' class='homeImgs' alt='cricket.png' /><img src='../images/weights.png' class='homeImgs' alt='weights.png' /><img src='../images/bike.png' class='homeImgs' alt='bike.png' />");
echo("</div>");
echo("</div>");
echo("</div>");
?>