<?php
session_start();
include '../includeFiles/connect.inc.php';

$userID = $_SESSION['userID'];
$selectString = "SELECT * FROM tblExerTimes INNER JOIN tblExerCategories on tblExerTimes.catID = tblExerCategories.catID WHERE userID = $userID";
$result = mysqli_query($connection, $selectString);
$events = array();
while($row = mysqli_fetch_assoc($result))
{
	$eventArray = array();
	$eventArray['title'] = $row['catName'];
	$eventArray['start'] = $row['date'];
	//code colour switch here
	switch ($row['catID']) {
		case "1":
			$color = "red";
			break;
		case "2":
			$color = "blue";
			break;
		case "3":
			$color = "green";
			break;
		case "4":
			$color = "yellow";
			break;
		case "5":
			$color = "purple";
			break;
		case "6":
			$color = "pink";
			break;
		case "7":
			$color = "black";
			break;
		case "8":
			$color = "gray";
			break;
		case "9":
			$color = "tan";
			break;
		case "10":
			$color = "brown";
			break;
		case "11":
			$color = "navy";
			break;
	}
	$eventArray['color'] = $color;
	$events[] = $eventArray;
}
echo json_encode($events);
?>