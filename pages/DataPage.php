<?php
include_once "../includeFiles/header.php";
include "../includeFiles/accessControl.inc.php";


if (isset($_POST['submitted']))
{
	addedForm($connection);
}
else
{
	showForm($connection, $user, $userID);
}

function showForm($connection, $user, $userID)
{
	echo("<h2>Welcome back $user Enter your activity below </h2>");
	echo("<form method='POST' action='DataPage.php'>");
	echo("Date : <input type='text'  name='date' id='date'/><br><br>");
	echo("Activity:	<select name='activity'><option value='%'> Show all </option>");
	
	// Using the variable in the above form so the user doesn't have to re enter the good data.
	$selectString = 'SELECT DISTINCT catName FROM tblExerCategories ORDER BY catName';
	$result = mysqli_query($connection, $selectString);

	//getting the details/values by going through each row.
	while ($row = mysqli_fetch_row($result))
	{
		echo("<option value = '$row[0]' >$row[0] ");
	}			
	echo("</select><br><br>");
	echo("Time: <input type='time' name='time' value='' size='30'><br>");
	
	echo("$user<br>");
	echo("$userID<br>");
	
	echo("<input type='submit' name='submitted' value='Insert'><br /><br />");
	echo("</form>");
}

function addedForm($connection)
{
	$dateTemp = cleanData($_POST['date']);
	$parts = explode("/", $dateTemp);
 	$year = $parts[2];
	$month = $parts[1];
	$day = $parts[0];
	$dateInsert = ("{$year}-{$month}-{$day}");
	$activityInsert = cleanData($_POST['activity']);
	$timeInsert = cleanData($_POST['time']);
	
	//addActivity($dateInsert, $activityInsert, $timeInsert, $connection);
	
	echo("<form action='DataPage.php' method='POST'><fieldset><legend>Activity Inserted</legend>");
	
	echo("<h1>Success</h1>");
	echo("$dateInsert");
	
	echo("</fieldset></form>");
}

function addActivity($countryName, $shortCountry, $connection)
{
	
	$insertQuery = "INSERT into tblExerTimes(countryName, shortCountry, countryFlag) VALUES ('$countryName','$shortCountry','$image')";
	
	$result = mysqli_query($connection, $insertQuery);
	if($result != 1)
	{
		echo mysqli_error($connection);
		echo("There was a problem adding that Activity, please try again.");
		die();
	}
	echo ("Country added succesfully!");
}

function cleanData($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>