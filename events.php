<?php
include '../connect.inc.php';

$selectString = "SELECT * FROM tblScreenTimes INNER JOIN tblScreenCategories on tblScreenTimes.catID = tblScreenCategories.catID WHERE userID = 1";
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
	}
	$eventArray['color'] = $color;
	$events[] = $eventArray;
}
echo json_encode($events);
?>