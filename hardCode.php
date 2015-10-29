<?php
include 'connect.inc.php';

// Insert user
$insertQuery = "INSERT into tblScreenUsers(lastName, firstName, passWord, email, displayName) VALUES ('parsons','dale','test','dparsons@op.ac.nz','dpars')";
$result = mysqli_query($connection, $insertQuery);
if($result != 1)
{
	echo mysqli_error($connection);
	die();
}
else
{
	echo ("Creating user record #".mysqli_insert_id($connection)."<br />");
}

// Insert categories
function createCatRecord($catName, $connection)
{
	$insertQuery = "INSERT into tblScreenCategories(catName) VALUES ('$catName')";
	
	$result = mysqli_query($connection, $insertQuery);
	if($result != 1)
	{
		echo mysqli_error($connection);
		die();
	}
	else
	{
		echo ("Creating category record #".mysqli_insert_id($connection)."<br />");
	}
}

createCatRecord('Television', $connection);
createCatRecord('Computer (Gaming)', $connection);
createCatRecord('Computer (Study/Work)', $connection);
createCatRecord('Computer (Social Media)', $connection);
createCatRecord('Phone (Gaming)', $connection);
createCatRecord('Phone (Social Media)', $connection);

// Insert times
function createScreenRecord($userID, $catID, $date, $hours, $connection)
{
	$insertQuery = "INSERT into tblScreenTimes(userID, catID, date, hours) VALUES ('$userID','$catID','$date','$hours')";
	$result = mysqli_query($connection, $insertQuery);
	if($result != 1)
	{
		echo mysqli_error($connection);
		die();
	}
	else
	{
		echo ("Creating screen time record #".mysqli_insert_id($connection)."<br />");
	}
}

createScreenRecord('1', '1', '2015-10-04', '2', $connection);
createScreenRecord('1', '2', '2015-10-04', '3', $connection);
createScreenRecord('1', '3', '2015-10-04', '4', $connection);
createScreenRecord('1', '6', '2015-10-04', '1', $connection);
createScreenRecord('1', '3', '2015-10-05', '2', $connection);
createScreenRecord('1', '5', '2015-10-05', '5', $connection);



?>