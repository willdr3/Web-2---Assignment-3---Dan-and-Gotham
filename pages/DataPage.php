<?php
include_once "../includeFiles/dataHeader.php";
include "../includeFiles/accessControl.inc.php";

//button for submitting activity <input type='submit' name='newCategory' value='Add new category'>

if (isset($_POST['submitted']))
{
	addedForm($user, $userID, $connection);
}
else if(isset($_POST['newCategorySubmit']))
{
	processNewCategory($user, $userID, $connection);
}
else if(isset($_POST['newCategory']))
{
	showNewCategoryForm($user, $userID, $connection);
}
else
{
	showForm($connection, $user, $userID);
}

function showForm($connection, $user, $userID, $dateErr='', $activityErr='', $timeErr='')
{
	echo("<div class='outerHomeCont'>");
	echo("<h1>Welcome back $user.<br>Enter your activity below</h1>");
	echo("<form method='POST' action='DataPage.php'><fieldset>");
	echo("<div class='innerCont'>");
	echo("Date: <input type='text'  name='date' id='date'/><br><span class='Span'>$dateErr</span><br>");
	echo("Activity: <select name='activity'><option value='%'> Show all </option>");
	
	// Using the variable in the above form so the user doesn't have to re enter the good data.
	$selectString = 'SELECT DISTINCT catName, catID FROM tblExerCategories ORDER BY catName';
	$result = mysqli_query($connection, $selectString);

	//getting the details/values by going through each row.
	while ($row = mysqli_fetch_row($result))
	{
		echo("<option value = '$row[1]' >$row[0] ");
	}			
	echo("</select><span class='Span'>$activityErr</span><input type='submit' name='newCategory' value='Add new category'><br><br>");
	echo("Time: <input type='text' name='minutes' value='' size='30'><span class='Span'>$timeErr</span><br><br>");
	echo("<input type='submit' name='submitted' value='Insert'><br><br>");
	showTable($connection, $user, $userID);
	echo("</div>");
	echo("</fieldset></form>");
	echo("</div>");
}

function addedForm($user, $userID, $connection)
{
	$dateErr = '';
	$activityErr ='';
	$timeErr = '';
	$catName = '';
	$dataTrue = true;
	
	//Regex Checking
	$minutesCheck = "^[0-9]{1,3}$";
	
	if(empty($_POST['date']))
	{
		$dateErr = '*Date Required';
		$dateTemp='';	
		$dataTrue = false;
		header('Location: DataPage.php');
		die();
	}
	else
	{
		$dateInsert = cleanData($_POST['date']);	
	}	
	
	if(empty($_POST['activity']))
	{
		$activityErr = '*Activity Required';
		$activityInsert ='';	
		$dataTrue = false;
		header('Location: DataPage.php');
		die();
	}
	else
	{
		$activityInsert = cleanData($_POST['activity']);
		$selectActivity = "SELECT catID, minutes FROM tblExerTimes WHERE date = '$dateInsert' AND catID = '$activityInsert'";
		$result = mysqli_query($connection, $selectActivity);
		
		if(mysqli_num_rows($result) > 0)
		{
			$ActivityErr = '*You have already entered this activity for today.';
			$activityInsert ='';	
			$dataTrue = false;
		}
	}
	
	if(empty($_POST['minutes']))
	{
		  $timeErr = '*Time Required';
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
			$timeErr = '*Please input numbers only';
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
		
		echo("<div class='outerHomeCont'>");
		echo("<form action='DataPage.php' method='POST'><fieldset>");
		echo("<div class='innerCont'>");
		echo("<h1>Success</h1>");
		echo("<br><br>Nice job $user, you have logged $timeInsert minutes of $activityInsert for $dateInsert.<br><br>");
		
		showTable($connection, $user, $userID);
		echo("</div>");
		echo("</fieldset></form>");
		echo("</div>");
	}
	else
	{
		showForm($connection, $user, $userID, $dateErr, $activityErr, $timeErr);
	}
}

function showTable($connection, $user, $userID)
{
	echo("<h2>Here are your entries for the last 5 days</h2>");
	echo("
	<table>
	<tr><th>Date</th>");
	
	$dates = array();
	$selectDate = "SELECT DISTINCT date FROM tblExerTimes WHERE userID = '$userID' ORDER BY date DESC";
	$result = mysqli_query($connection, $selectDate);
	
	while($row = mysqli_fetch_assoc($result))
	{
		$dates[] = $row['date'];
	}
	
	$selectString = 'SELECT DISTINCT catID, catName FROM tblExerCategories';
	$result = mysqli_query($connection,$selectString);
	
	$types = array();

	while($row = mysqli_fetch_assoc($result))
	{
		$types[] = $row['catID'];
		echo("<th>$row[catName]</th>");					
	}
	echo("</tr>");
	
	for($i = 0; $i < 5; $i++)
	{
		echo("<tr><td>$dates[$i]</td>");
		
		for	($j=0; $j<count($types); $j++)
		{			
			$typesearch = $types[$j];
			$selectString= "SELECT * FROM tblExerTimes WHERE date = '$dates[$i]' AND catID = '$typesearch' AND userID = '$userID'";
			$result = mysqli_query($connection, $selectString);
			
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

function showNewCategoryForm($connection, $user, $userID, $nameErr='')
{
	echo("<div class='outerHomeCont'>");
	echo("<h1>Something new for you, $user.<br>Enter your activity below</h1>");
	echo("<form method='POST' action='DataPage.php'><fieldset>");
	echo("<div class='innerCont'>");
	echo("New Category Name <input type='text'  name='newCatName' value='' size='30'/><span class='Span'>$nameErr</span><br><br>");
	echo("<input type='submit' name='newCategorySubmit' value='Insert Category'><br><br>");
	echo("<input type='submit' name='back' value='Return'>");
	echo("</div>");
	echo("</fieldset></form>");
	echo("</div>");	
}

function processNewCategory($user, $userID, $connection)
{
	$correctData = true;
	$nameErr = '';
	$categoryName = '';
	$nameCheck = "^([A-Z][a-z]+(-[A-Z][a-z]+)?)";
	$categoryName = $_POST['newCatName'];
	$selectCategory ="SELECT catName FROM tblExerCategories WHERE catName ='$categoryName'";
	$result = mysqli_query($connection, $selectCategory);
	if(mysqli_num_rows($result) > 0)
	{
		$nameErr = '*activity already exists';
		$categoryName = '';
		$correctData = false;	
	}
	else if (empty($_POST['newCatName']))
	{
		$nameErr = '*category name required';
		$categoryName = '';
		$correctData = false;
	}
	else
	{
		$categoryName = $_POST['newCatName'];
		if (preg_match("/$nameCheck/", $categoryName))
		{		
			$categoryName = $_POST['newCatName'];
			cleanData($categoryName);			
		}
		else
		{
			$nameErr = '*activity should start with Capital letter and must not contain Numbers, and can contain only "-"';
			$categoryName = '';
			$correctData = false;		
		}
	}
	if ($correctData == true)
	{
		$insertIntoTable =  "INSERT into tblExerCategories(catName) values ('$categoryName')";
		$result = mysqli_query($connection, $insertIntoTable);
		echo("Congratulations you have added $categoryName as your new activity");
		showForm($connection, $user, $userID);
	 }
	 else
	 {
		echo("Please try again, something went wrong");
		showNewCategoryForm($connection,$nameErr);
	 }
}
?>













