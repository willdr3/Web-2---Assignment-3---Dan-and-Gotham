<?php
include_once "../includeFiles/dataHeader.php";
include "../includeFiles/accessControl.inc.php";


if (isset($_POST['submitted']))
{
	addedForm($user, $userID, $connection);
}
else
{
	showForm($connection, $user, $userID);
}

function showForm($connection, $user, $userID, $dateErr='', $activityErr='', $timeErr='')
{
	echo("<div class='outerCont'>");
	echo("<form method='POST' action='DataPage.php'><fieldset>");
	echo("<div class='innerCont'>");
	echo("<h2>Welcome back $user.<br>Enter your activity below</h2>");
	echo("Date : <input type='text'  name='date' id='date'/><br><br>");
	echo("Activity:	<select name='activity'><option value='%'> Show all </option>");
	
	// Using the variable in the above form so the user doesn't have to re enter the good data.
	$selectString = 'SELECT DISTINCT catName, catID FROM tblExerCategories ORDER BY catName';
	$result = mysqli_query($connection, $selectString);

	//getting the details/values by going through each row.
	while ($row = mysqli_fetch_row($result))
	{
		echo("<option value = '$row[1]' >$row[0] ");
	}			
	echo("</select><span class='Span'>$activityErr</span><br><br>");
	echo("Time: <input type='text' name='minutes' value='' size='30'><span class='Span'>$timeErr</span><br>");
	
	echo("<input type='submit' name='submitted' value='Insert'><br /><br />");
	echo("</div>");
	echo("</fieldset></form>");
	echo("</div>");
}

function addedForm($user, $userID, $connection)
{
	$DateErr = '';
	$ActivityErr ='';
	$TimeErr = '';
	$catName = '';
	$dataTrue = true;
	
	//Regex Checking
	$minutesCheck = "^[0-9]{1,3}$";
	
	if(empty($_POST['date']))
	{
		  $DateErr = '*Date Required';
		  $dateTemp='';	
		  $dataTrue = false;
	}
	else
	{
		$dateInsert = cleanData($_POST['date']);	
	}	
	
	if(empty($_POST['activity']))
	{
		  $ActivityErr = '*Activity Required';
		  $activityInsert ='';	
		  $dataTrue = false;
	}
	else
	{
		$activityInsert = cleanData($_POST['activity']);
	}
	
	if(empty($_POST['minutes']))
	{
		  $TimeErr = '*Time Required';
		  $timeInsert ='';	
		  $dataTrue = false;
	}
	else 
	{ 
		$timeInsert = $_POST['minutes'];
		if (preg_match("/$minutesCheck/", $timeInsert))
		{
			$timeInsert = cleanData($_POST['minutes']);
		}
		else
		{
			$TimeErr = '*Please input numbers only';
			$timeInsert ='';	
			$dataTrue = false;
		}
	}
	
	$selectCatID = "SELECT DISTINCT catName from tblExerCategories WHERE catID LIKE '$activityInsert'";
	$result = mysqli_query($connection, $selectCatID);
	
	if(mysqli_num_rows($result) > 0)
	{
		$row = mysqli_fetch_assoc($result);
		$catID = $row['catName'];
	}
	
	if($dataTrue == true)
	{
		addActivity($userID, $dateInsert, $activityInsert, $timeInsert, $connection);
		
		echo("<form action='DataPage.php' method='POST'><fieldset><legend>Activity Inserted</legend>");
		
		echo("<h1>Success</h1>");
		echo("Nice job $user, you have logged $timeInsert minutes of $activityInsert for $dateInsert.<br>");
		echo("$dateInsert<br>");
		echo("$activityInsert<br>");
		echo("$catID<br>");
		echo("$timeInsert<br>");
		
		showTable($connection, $user, $userID);
		
		echo("</fieldset></form>");
	}
	else
	{
		showForm($connection, $user, $userID, $dateErr, $activityErr, $timeErr);
	}
}

function showTable($connection, $user, $userID)
{
	echo("
	<table>
	<tr><th>Date</th>");
	
	$selectString = 'SELECT DISTINCT catID, catName FROM tblExerCategories';
	$result = mysqli_query($connection,$selectString);
	
	$types = array();

	while($row = mysqli_fetch_assoc($result))
	{
		$types[] = $row['catID'];
		echo("<th>$row[catName]</th>");					
	}
	echo("</tr>");
	
	for	( $i =6; $i>= 0; $i--)
	{
		$datesearch = date("Y-m-d", strtotime("-$i day"));
		echo("<tr> <td>$datesearch </td>");
		
		for	($j=0; $j<count($types); $j++)
		{			
			$typesearch = $types[$j];
			$selectString= "SELECT * FROM tblExerTimes WHERE date = '$datesearch' AND catID = '$typesearch' AND userID = '$userID'";
			$result = mysqli_query($connection,$selectString);
			
			if (mysqli_num_rows($result) > 0)
			{
			$row = mysqli_fetch_assoc($result);
				echo (" <td>$row[minutes]</td>");
			}
			else
			{
				echo ("<td> 0 </td>");
			}
		}
		echo("</tr>");
	}
}

function addActivity($userID, $dateInsert, $activityInsert, $timeInsert, $connection)
{
	$insertQuery = "INSERT into tblExerTimes(userID, catID, date, minutes) VALUES ('$userID','$activityInsert','$dateInsert','$timeInsert')";
	
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