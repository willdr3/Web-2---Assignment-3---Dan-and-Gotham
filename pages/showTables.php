<?php
include_once "../includeFiles/header.php";
include "../includeFiles/accessControl.inc.php";

echo("<h1> Welcome this is Show Tables Page </h1>");
echo("<div class='outerHomeCont'>");
echo("<form><fieldset>");
echo("<div class='innerCont'>");
echo("<h2>Users Table</h2>");
showUsersTable($connection);
echo("<hr><h2>CategoriesTable</h2>");
showCategoriesTable($connection);
echo("<hr><h2>Exercise Times Table</h2>");
showTimesTable($connection);
echo("</div>");
echo("</fieldset></form>");
echo("</div>");

function showUsersTable($connection)
{
	$selectString = "SELECT * FROM tblUsers";
	$result = mysqli_query($connection, $selectString);
	
	echo("<table>");
	echo("<tr>
				<th>User ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>eMail</th>
				<th>User Name</th>
				<th>PassWord (encrypted)</th>
			</tr>
			");
	while($row = mysqli_fetch_assoc($result))
	{
		echo("<tr>");
		foreach($row as $index => $value)
		{
			if($index == 'passWord')
			{
				echo("<td>****password****</td>");
			}
			else
			{
				echo("<td>$value</td>");
			}
		}
		echo("</tr>");
	}
	echo("</table>");
}

function showCategoriesTable($connection)
{
	$selectString = "SELECT * FROM tblExerCategories";
	$result = mysqli_query($connection, $selectString);
	
	echo("<table>");
	echo("<tr>
				<th>Category ID</th>
				<th>Category Name</th>
			</tr>
			");
	while($row = mysqli_fetch_assoc($result))
	{
		echo("<tr>");
		foreach($row as $index => $value)
		{
			echo("<td>$value</td>");
		}
		echo("</tr>");
	}
	echo("</table>");
}

function showTimesTable($connection)
{
	$selectString = "SELECT * FROM tblExerTimes";
	$result = mysqli_query($connection, $selectString);
	
	echo("<table>");
	echo("<tr>
				<th>Time ID</th>
				<th>User ID</th>
				<th>Category ID</th>
				<th>Date</th>
				<th>Minutes</th>
			</tr>
			");
	while($row = mysqli_fetch_assoc($result))
	{
		echo("<tr>");
		foreach($row as $index => $value)
		{
			echo("<td>$value</td>");
		}
		echo("</tr>");
	}
	echo("</table>");
}
?>