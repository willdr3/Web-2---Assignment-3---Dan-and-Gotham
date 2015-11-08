<?php
include_once "../includeFiles/header.php";
include "../includeFiles/accessControl.inc.php";


if (isset($_POST['submitted']))
{
	addedForm($user, $userID, $connection);
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

function addedForm($user, $userID, $connection)
{
	$dateInsert = cleanData($_POST['date']);
	$activityInsert = cleanData($_POST['activity']);
	$timeInsert = cleanData($_POST['time']);
	
	$selectCatID = "SELECT DISTINCT catID from tblExerCategories WHERE catName LIKE '$activityInsert'";
	$result = mysqli_query($connection, $selectCatID);
	
	if(mysqli_num_rows($result) > 0)
	{
		$row = mysqli_fetch_assoc($result);
		$catID = $row['catID'];
	}
	
	addActivity($userID, $dateInsert, $catID, $timeInsert, $connection);
	
	echo("<form action='DataPage.php' method='POST'><fieldset><legend>Activity Inserted</legend>");
	
	echo("<h1>Success</h1>");
	echo("Nice job $user, you have logged $timeInsert hours of $activityInsert for $dateInsert.<br>");
	echo("$dateInsert<br>");
	echo("$activityInsert<br>");
	echo("$catID<br>");
	echo("$timeInsert<br>");
	
	echo("</fieldset></form>");
}

function addActivity($userID, $dateInsert, $catID, $timeInsert, $connection)
{
	$insertQuery = "INSERT into tblExerTimes(userID, catID, date, hours) VALUES ('$userID','$catID','$dateInsert','$timeInsert')";
	
	$result = mysqli_query($connection, $insertQuery);
	if($result != 1)
	{
		echo mysqli_error($connection);
		echo("There was a problem adding that Activity, please try again.");
		die();
	}
}

function cleanData($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>