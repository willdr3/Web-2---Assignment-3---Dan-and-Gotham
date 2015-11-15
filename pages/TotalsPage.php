<?php
include_once "../includeFiles/header.php";
include "../includeFiles/accessControl.inc.php";

$user = $_SESSION['userName'];

if(isset($_POST['submitted']) && isset($_POST['modField']))
{
	modPage($connection, $user, $userID);	
}
else
{
	if(isset($_POST['confirmed']))
	{
		donePage($connection, $user, $userID);
		if(isset($_POST['finished']))
		{
			header('Location: TotalsPage.php');
			die();
		}
	}
	else
	{
		totalsPage($connection, $user, $userID);
	}
}

function modPage($connection, $user, $userID)
{
	echo("<div class='outerHomeCont'>");
	echo("<h1> Welcome $user this is Modify Statistics Page </h1>");
	echo("<form action='TotalsPage.php' method='POST'><fieldset>");
	echo("<div class='innerCont'>");
	echo("<h3>Modify your data</h3>");
	showMod($connection, $user, $userID);
	echo("<input type='submit' name='confirmed' value='Confirm Change'><input type='submit' name='' value='Return'>");
	echo("</div>");
	echo("</fieldset></form>");
	echo("</div>");
}

function donePage($connection, $user, $userID)
{
	echo("<div class='outerHomeCont'>");
	echo("<h1> Welcome $user this is Modify Statistics Page </h1>");
	echo("<form action='TotalsPage.php' method='POST'><fieldset>");
	echo("<div class='innerCont'>");
	echo("<h3>Modification complete</h3>");
	echo("<input type='submit' name='finished' value='Return to Life Stats'>");
	echo("</div>");
	echo("</fieldset></form>");
	echo("</div>");
}

function totalsPage($connection, $user, $userID)
{
	echo("<div class='outerHomeCont'>");
	echo("<h1> Welcome $user this is Lifetime Statistics Page </h1>");
	echo("<form action='TotalsPage.php' method='POST'><fieldset>");
	echo("<div class='innerCont'>");
	echo("<h3>Summed hours of each activity</h3>");
	showTotals($connection, $user, $userID);
	echo("<br>");
	echo("<br><hr><br>");
	echo("<h3>Total daily logged times</h3>");
	showTable($connection, $user, $userID);
	echo("<input type='submit' name='submitted' value='Modify'>");
	echo("</div>");
	echo("</fieldset></form>");
	echo("</div>");
}

function showMod($connection, $user, $userID)
{	
	echo("
	<table>
	<tr>
	<th>Date</th>
	");
	
	$selectString = 'SELECT DISTINCT catID, catName FROM tblExerCategories';
	$result = mysqli_query($connection,$selectString);
	
	$types = array();

	while($row = mysqli_fetch_assoc($result))
	{
		$types[] = $row['catID'];
		echo("<th>$row[catName]</th>");					
	}
	echo("</tr>");
	
	$toMod = $_POST['modField'];
	$selectField = "SELECT * FROM tblExerTimes WHERE date = '$toMod'";
	$result = mysqli_query($connection, $selectField);
	$row = mysqli_fetch_assoc($result);
	$tempDate = $row['date'];
	echo("<tr><td>$tempDate</td>");
	
	for($i=0; $i < count($types); $i++)
	{
		
		$typeSearch = $types[$i];
		$selectField = "SELECT * FROM tblExerTimes WHERE catID = '$typeSearch' and date = '$toMod'";
		$result = mysqli_query($connection, $selectField);
		
		if (mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_assoc($result);
			echo ("<td><input type='text' size='10' value='$row[minutes]'><></td>");
		}
		else
		{
			echo ("<td>0</td>");
		}
	}
	echo("</tr></table>");
}

function showTable($connection, $user, $userID)
{
	echo("
	<table>
	<tr>
	<th>Date</th>");
	
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
	echo("<th>CheckBox</th>");
	echo("</tr>");
	
	for($i = 0; $i < count($dates); $i++)
	{
		echo("<tr>");
		echo("<td>$dates[$i]</td>");
		
		for	($j=0; $j < count($types); $j++)
		{			
			$typeSearch = $types[$j];
			$selectString= "SELECT * FROM tblExerTimes WHERE date = '$dates[$i]' AND catID = '$typeSearch' AND userID = '$userID'";
			$result = mysqli_query($connection, $selectString);
			
			if (mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_assoc($result);
				echo ("<td>$row[minutes]</td>");
			}
			else
			{
				echo ("<td>0</td>");
			}
		}
		$checkTime = $dates[$i];
		echo("<td><input type='radio' name='modField' value='$checkTime'></td>");
		echo("</tr>");
	}
	echo("</table>");
}

function showTotals($connection,$user, $userID)
{
	echo("
	<table>
		<tr>
			<th>Activity</th>
			<th> Life Time totals</th>");
			
			$selectString = 'SELECT DISTINCT catID, catName FROM tblExerCategories';
			$result = mysqli_query($connection,$selectString);
			
			$types = array();
			$TypeNames = array();

			while($row = mysqli_fetch_assoc($result))
			{
				$types[] = $row['catID'];
				$TypeNames[] = $row['catName'];								
			}
			echo("
		</tr>");
		for	( $i =0; $i<count($TypeNames); $i++)
		{
			$totalMinutes =0;
			echo("<tr><td>$TypeNames[$i]</td>");
		
			$typesearch = $types[$i];
			$selectString= "SELECT minutes FROM tblExerTimes WHERE catID = '$typesearch' AND userID = '$userID'";
			$result = mysqli_query($connection,$selectString);
			
			while($row = mysqli_fetch_assoc($result))
			{	
				$totalMinutes =	$totalMinutes + $row['minutes'];			
			}
			echo("<td>$totalMinutes</td>");
			echo("</tr>");
		}				
		echo("
	</table>");
}
?>