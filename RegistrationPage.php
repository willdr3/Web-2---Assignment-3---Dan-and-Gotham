<?php
include_once "startHeader.php";
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
	echo("<div class='outerCont'>");
	echo("<form action='RegistrationPage.php' method='POST'><fieldset>");
	echo("<div class='innerCont'>");
	echo("<h2>Register</h2>");
	echo("First Name<br /><input type='text' class='loginField' name='FirstName' value='' size='30'><br /><br />");
	echo("Last Name<br /><input type='text' class='loginField' name='LastName' value='' size='30'><br /><br />");
	echo("Email<br /><input type='text' class='loginField' name='eMail' value='' size='30'><br /><br />");	
	echo("User Name<br /><input type='text' class='loginField' name='userName' value='' size='30'><br /><br />");
	echo("Password<br /><input type='password' class='loginField' name='userPassword' value='' size='30'><br /><br />");
	echo("Re enter Password<br /><input type='password' class='loginField' name='userRePassword' value='' size='30'><br /><br />");
	echo("Secret Pass Code<br /><input type='password' class='loginField' name='PassCode' value='' size='30'><br /><br />");
	echo("<input type='submit' name='submitted' value='SignUp'>");
	echo("</div>");
	echo("</fieldset></form>");
	echo("</div>");
	
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
			echo("Successfully created user. <a href='LogIn.php'>Click here to go to Login Page </a>");  
			  
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