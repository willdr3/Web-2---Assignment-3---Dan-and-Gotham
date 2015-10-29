<?php
include "connect.inc.php";

if(isset($_POST['userName']))
	$userName = strip_tags($_POST['userName']);
else if(isset($_SESSION['userName']))
	$userName = $_SESSION['userName'];

if(isset($_POST['userPassword']))
	$userPassword = strip_tags($_POST['userPassword']);
else if(isset($_SESSION['userPassword']))
	$userPassword = $_SESSION['userPassword'];

if(!isset($userName))
{
	//show login form
	$self = htmlentities($_SERVER['PHP_SELF']);
	
	echo("<!doctype HTML>
	<html>
	<head>
		<title>Exercise Monitor</title>
		 <meta charset='UTF-8'>
		 <link rel='stylesheet' href='Style13.css'>
		  <!-- Linking the font I chose to use -->
		 <link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
		 <style type = 'text/css'>
	</head>
	<body>");
	
	echo("<form action='$self' method='POST'><fieldset>");
	
	echo("User Name: <input type='text' name='userName' value='' size='30'><br /><br />");
	echo("Password: <input type='text' name='userPassword' value='' size='30'><br /><br />");

	echo("<input type='submit' name='submitted' value='LOGIN'>");
	
	echo("</fieldset></form></body></html>");
	
	exit;
}
else
{
	$select = "SELECT * FROM tblUP WHERE (userName LIKE '$userName')";
	$result = mysqli_query($connection, $select);

	
	if(mysqli_num_rows($result) > 0)
	{
		$row = mysqli_fetch_assoc($result);
		// Assuming that user names are unique
		
		//Hashing the password with its hash as the salt returns the same hash
		if(crypt($userPassword, $row['userPword']) === $row['userPword'])
		{
			$_SESSION['userName'] = $userName;
				echo("<!doctype HTML>
				<html>
				<head>
					<title>Sessions 1</title>
					<link rel='stylesheet' href='style.css'>
					<meta charset='UTF-8'>
				</head><body>");
				echo("<p>Success!!!</p>");
				echo("</body></html>");
		}
	else
	{
		echo("<!doctype HTML>
		<html>
		<head>
			<title>Exercise Monitor</title>
			 <meta charset='UTF-8'>
			 <link rel='stylesheet' href='Style13.css'>
			  <!-- Linking the font I chose to use -->
			 <link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
			 <style type = 'text/css'>
		</head><body>");		
		echo("<p>Illegal user name and password, access denied.</p>");
		echo("</body></html>");
		exit;
	}
	}
}
?>