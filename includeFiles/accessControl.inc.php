<?php
include "connect.inc.php";

if(isset($_SESSION['userID']))
	$userID=$_SESSION['userID'];
if(isset($_POST['userName']))
	$userName = strip_tags($_POST['userName']);
else if(isset($_SESSION['userName']))
	$userName = $_SESSION['userName'];

if(isset($_POST['passWord']))
	$userPassword = strip_tags($_POST['passWord']);


if(!isset($userName))
{
	//show login form
	$self = htmlentities($_SERVER['PHP_SELF']);
	
	echo("<div class='outerCont'>");
	echo("<form action='$self' method='POST'><fieldset>");
	echo("<div class='innerCont'>");
	echo("<h2>LogIn</h2>");
	echo("User Name<br /><input type='text' class='loginField' name='userName' value='' size='30'><br /><br />");
	echo("Password<br /><input type='password' class='loginField' name='passWord' value='' size='30'><br /><br />");
	echo("<input type='submit' name='submitted' value='LOGIN'>");
	echo("<a href='RegistrationPage.php'>Register Here</a>");
	echo("</div>");
	echo("</fieldset></form>");
	echo("</div>");
	
	exit;
}
else
{
	if(!isset($_SESSION['userName']))
	{
		$select = "SELECT * FROM tblUsers WHERE (userName LIKE '$userName')";
		$result = mysqli_query($connection, $select);
		
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_assoc($result);
			// Assuming that user names are unique
			
			//Hashing the password with its hash as the salt returns the same hash
			if(crypt($userPassword, $row['passWord']) === $row['passWord'])
			{
				$_SESSION['userName'] = $userName;
				$_SESSION['userID'] = $row['userID'];
				header('Location: Home.php');
				die();
			}
			header('Location: LogIn.php');
			die();
		}
		else
		{
			echo("<p>Illegal user name and password, access denied.</p>");
			exit;
		}
	}	
}
?>