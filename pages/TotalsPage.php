<?php
include_once "../includeFiles/header.php";
include "../includeFiles/accessControl.inc.php";

$user = $_SESSION['userName'];

echo("<div class='outerHomeCont'>");
echo("<h1> Welcome $user this is Lifetime Statistics Page </h1>");
echo("<form><fieldset>");
echo("<div class='innerCont'>");
echo("<h3>Summed hours of each activity</h3>");
showTotals($connection, $user, $userID);
echo("<br><hr><br>");
echo("<h3>Total daily logged times</h3>");
showTable($connection, $user, $userID);
echo("</div>");
echo("</fieldset></form>");
echo("</div>");

function showTable($connection, $user, $userID)
{
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
	
	for($i = 0; $i < count($dates); $i++)
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