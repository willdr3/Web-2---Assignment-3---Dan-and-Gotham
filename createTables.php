<?php
include 'connect.inc.php';

// Users table
$dropQuery = "DROP TABLE IF EXISTS tblScreenUsers;";
$result = mysqli_query($connection, $dropQuery);

$createUserTblQuery = "CREATE TABLE tblScreenUsers
(
	userID				INT(6)					NOT NULL		 AUTO_INCREMENT,
	lastName			VARCHAR(20) 		NOT NULL,
	firstName			VARCHAR(20)		NOT NULL,
	passWord			VARCHAR(100)		NOT NULL,
	email				VARCHAR(50)		NOT NULL,
	displayName		VARCHAR(20)		NOT NULL,
	
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
	echo ("Users Table Created");
}

// Screen categories table
$dropQuery = "DROP TABLE IF EXISTS tblScreenCategories;";
$result = mysqli_query($connection, $dropQuery);	
	
$createCategoryTblQuery = "CREATE TABLE tblScreenCategories
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
	echo ("Categories Table Created");
}


// Screen time table
$dropQuery = "DROP TABLE IF EXISTS tblScreenTimes;";
$result = mysqli_query($connection, $dropQuery);

$createScreenTimesQuery = "CREATE TABLE tblScreenTimes
(
	timeID			INT(6)					NOT NULL			AUTO_INCREMENT,
	userID			INT(6)					NOT NULL,
	catID			VARCHAR(30) 		NOT NULL,
	date				VARCHAR(10)		NOT NULL,
	hours			INT(5)					NOT NULL,
	
	PRIMARY KEY(timeID)
)";
$result = mysqli_query($connection, $createScreenTimesQuery);
if($result != 1)
{
	echo mysqli_error($connection);
	die();
}
else
{
	echo ("Screen Times Table Created");
}
?>