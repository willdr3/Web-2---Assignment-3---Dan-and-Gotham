<?php
include_once "header.php";
include "connect.inc.php";


?>

	
<?php

if (isset($_POST['submitted']))
{
	ProcessForm($connection);
}
else
{
showform($connection);
}

function showform ($connection)
{
	
 
	echo("<form action='RegistrationPage.php' method='POST'><fieldset>");
	echo("First Name: <input type='text' name='FirstName' value='' size='30'><br /><br />");
	echo("Last Name: <input type='text' name='LastName' value='' size='30'><br /><br />");
	echo("Email: <input type='text' name='eMail' value='' size='30'><br /><br />");	
	echo("User Name: <input type='text' name='userName' value='' size='30'><br /><br />");
	echo("Password: <input type='text' name='userPassword' value='' size='30'><br /><br />");
	echo("Re enter Password: <input type='text' name='userRePassword' value='' size='30'><br /><br />");
	echo("Secret Pass Code: <input type='text' name='PassCode' value='' size='30'><br /><br />");

	echo("<input type='submit' name='submitted' value='SignUp'>");
	
	echo("</fieldset></form>");
}
	
	function ProcessForm($connection)
	{
	$SecretPassCode = "secret";
	$firstName = $_POST['FirstName'];
	$lastname = $_POST['LastName'];
	$email    = $_POST['eMail'];
	$userName = $_POST['userName'];
	$firstPassword = $_POST['userPassword'];
	$rePassword = $_POST['userRePassword'];
	$passCode = $_POST['PassCode'];
	
	if ($passCode == $SecretPassCode )
	{	
	
		if ($rePassword == $firstPassword)
		{
			$securePassword=crypt($firstPassword, $_POST['userPassword']);
			$insertQuery = "INSERT into tblUsers(firstName,lastName,email, userName, passWord) values ('$firstName','$lastname', '$email', '$userName','$securePassword')";
			$result = mysqli_query($connection, $insertQuery);
			echo("Successfully created user. <a href='Home.php'>Click here to go to Home Page </a>");  
			  
		}
		else
		{
		 showform($connection);
		}
				
	}
	else
		{
		 showform($connection);
		}
	}

?>	