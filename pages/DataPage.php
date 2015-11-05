<?php
include_once "../includeFiles/header.php";
include "../includeFiles/accessControl.inc.php";
$user = $_SESSION['userName'];

if (isset($_POST['submitted']))
{
	addedForm($connection);
}
else
{
	showForm($connection, $user);
}

function showForm($connection, $user)
{
	echo("
	<h2>Welcome back $user Enter your activity below </h2>

	<form method='POST' action='DataPage.php'>

	Date : <input type='text'  name='date' id='date'/><br><br>

	Activity:	<select name='Activity'><option value='%'> Show all </option> ");
	// Using the variable in the above form so the user doesn't have to re enter the good data.
	$selectString = 'SELECT DISTINCT catName FROM tblExerCategories ORDER BY catName';
	$result = mysqli_query($connection,$selectString);

	//getting the details/values by going through each row.
	while ($row = mysqli_fetch_row($result))
	{
		echo("<option value = '$row[0]' >$row[0] ");
	}			
	echo("</select><br><br>

	Time: <input type='time' name='time' value='' size='30'>



	</form>");
}

function addedForm($connection)
{
	$dateInsert = cleanData($_POST['cNameInsert']);
	$activityInsert = cleanData($_POST['cCodeInsert']);
	$timeInsert = cleanData($_POST['']);
	
	addActivity($cNameInsert, $cCodeInsert, $connection);
	
	echo("<form action='DataPage.php' method='POST'><fieldset><legend>Activity Inserted</legend>");
	
	echo("<h1>Success</h1>");
	
	echo("</fieldset></form>");
}

function addActivity($countryName, $shortCountry, $connection)
{
	$fileName = str_replace("\'", "", $countryName); //removes '
	$fileName = strtolower(str_replace(" ", "", $fileName)); //removes spaces
	$image = "flagImages\/$fileName.png";
	$insertQuery = "INSERT into tblCountries(countryName, shortCountry, countryFlag) VALUES ('$countryName','$shortCountry','$image')";
	
	$result = mysqli_query($connection, $insertQuery);
	if($result != 1)
	{
		echo mysqli_error($connection);
		echo("There was a problem adding that Country, please try again.");
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