<?php
include 'includeFiles/connect.inc.php';

// Users table


$dropQuery = "DROP TABLE IF EXISTS tblTargets;";
$result = mysqli_query($connection, $dropQuery);

$createScreenTimesQuery = "CREATE TABLE tblTargets
(
	targetID		INT(6)				NOT NULL			AUTO_INCREMENT,
	userID			INT(6)				NOT NULL,
	catID			INT(6) 				NOT NULL,
	target			INT(10)	 	 		NOT NULL,
		
	PRIMARY KEY(targetID),	
	FOREIGN KEY (userID) references tblUsers(userID),
	FOREIGN KEY (catID) references tblExerCategories(catID)
)";
$result = mysqli_query($connection, $createScreenTimesQuery);
if($result != 1)
{
	echo mysqli_error($connection);
	die();
}
else
{
	echo ("Exercise Times Table Created");
}
?>
