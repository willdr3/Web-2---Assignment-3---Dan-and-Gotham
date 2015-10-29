<?php
include "connect.inc.php";

if(isset($_POST['userName']))
	$userName = strip_tags($_POST['userName']);
else if(isset($_SESSION['userName']))
	$userName = $_SESSION['userName'];

if(isset($_POST['userPassword']))
	$userPassword = strip_tags($_POST['userPassword']);

if(!isset($userName))
{
	//show login form
	$self = htmlentities($_SERVER['PHP_SELF']);
		
	echo("<form action='$self' method='POST'><fieldset>");
	
	echo("User Name: <input type='text' name='userName' value='' size='30'><br /><br />");
	echo("Password: <input type='text' name='userPassword' value='' size='30'><br /><br />");

	echo("<input type='submit' name='submitted' value='LOGIN'>");
	
	echo("</fieldset></form>");
	
	exit;
}
else
{
	 if(isset($_POST['submitted']))
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
			}
			else
			{	
				echo("<p>Illegal user name and password, access denied.</p>");
				exit;
			}
		}	
	}
}
?>
</body></html>