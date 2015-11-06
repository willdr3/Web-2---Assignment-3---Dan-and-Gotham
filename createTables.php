<?php
include 'connect.inc.php';

// Users table


$dropQuery = "DROP TABLE IF EXISTS tblExerTimes;";
$result = mysqli_query($connection, $dropQuery);
	
$dropQuery = "DROP TABLE IF EXISTS tblUsers;";
$result = mysqli_query($connection, $dropQuery);

$dropQuery = "DROP TABLE IF EXISTS tblExerCategories;";
$result = mysqli_query($connection, $dropQuery);


$createUserTblQuery = "CREATE TABLE tblUsers
(
	userID				INT(6)					NOT NULL		 AUTO_INCREMENT,
	firstName			VARCHAR(20)		NOT NULL,
	lastName			VARCHAR(20) 		NOT NULL,
	email				VARCHAR(50)		NOT NULL,
	userName		    VARCHAR(20)		NOT NULL,	
	passWord			VARCHAR(100)		NOT NULL,
	
	
	PRIMARY KEY(userID)
)";
$result = mysqli_query($connection, $createUserTblQuery);
if($result != 1)
{
	echo mysqli_error($connection);
	die();
}
else
{
	echo ("Users Table Created<br>");
}

// Screen categories table

	
$createCategoryTblQuery = "CREATE TABLE tblExerCategories
(
	catID			INT(6)					NOT NULL			AUTO_INCREMENT,
	catName		VARCHAR(30) 		NOT NULL,
	
	PRIMARY KEY(catID)
)";
$result = mysqli_query($connection, $createCategoryTblQuery);
if($result != 1)
{
	echo mysqli_error($connection);
	die();
}
else
{
	echo ("Categories Table Created <br>");
}
	function createCategoryRecord($category, $connection)
	 {
	  $insertQuery = "INSERT into tblExerCategories(catName) values ('$category')";
	  $result = mysqli_query($connection, $insertQuery);
		
	  	  
	}

	 createCategoryRecord('Running', $connection);
	 createCategoryRecord('Weights', $connection);
	 createCategoryRecord('Swimming', $connection);
	 createCategoryRecord('Yoga', $connection);
	 createCategoryRecord('Cycling', $connection);
	 createCategoryRecord('Cricket', $connection);
	 createCategoryRecord('Touch', $connection);
	 createCategoryRecord('Boxing', $connection);
	 createCategoryRecord('Hiking', $connection);
	
	  

// Screen time table


$createScreenTimesQuery = "CREATE TABLE tblExerTimes
(
	timeID			INT(6)				NOT NULL			AUTO_INCREMENT,
	userID			INT(6)				NOT NULL,
	catID			INT(6) 				NOT NULL,
	date				VARCHAR(10) 	NOT NULL,
	hours			INT(5)				NOT NULL,
	
	PRIMARY KEY(timeID),	
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