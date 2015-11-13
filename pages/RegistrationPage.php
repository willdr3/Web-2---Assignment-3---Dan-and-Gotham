<?php
$regTrue = true;
include_once "../includeFiles/startHeader.php";
include "../includeFiles/connect.inc.php";
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

function showform ($connection, $firstname='',$lastname='', $email='', $userName='', $firstNameErr ='', $lastNameErr='',$emailErr='', $userNameErr='', $passWdErr='', $rePassWdErr='',$codeErr='')
{
	echo("
	<div class='outerCont'>
		<form action='RegistrationPage.php' method='POST'><fieldset>
		<div class='innerCont'>
			<h2>Register</h2>
			First Name<br /><input type='text' class='loginField' name='FirstName' value='$firstname' size='30'><br />
			<span class='Span'> $firstNameErr </span> <br><br />
			
			Last Name<br /><input type='text' class='loginField' name='LastName' value='$lastname' size='30'><br />
			<span class='Span'> $lastNameErr </span> <br><br />
			
			Email<br /><input type='text' class='loginField' name='eMail' value='$email' size='30'><br />
			<span class='Span'>$emailErr </span> <br><br />
			
			User Name<br /><input type='text' class='loginField' name='userName' value='$userName' size='30'><br />
			<span class='Span'>$userNameErr </span> <br><br />
			
			Password<br /><input type='password' class='loginField' name='userPassword' value='' size='30'><br />
			<span class='Span'>$passWdErr </span> <br><br />
			
			Re enter Password<br /><input type='password' class='loginField' name='userRePassword' value='' size='30'><br />
			<span class='Span'>$rePassWdErr</span> <br><br />
			
			Secret Pass Code<br /><input type='password' class='loginField' name='PassCode' value='' size='30'><br />
			<span class='Span'>$codeErr</span> <br><br />
			
			<input type='submit' name='submitted' value='SignUp'>
		</div>
		</fieldset></form>
	</div>
	");
	
}

function cleanTheInput($data)
{
  $data = trim ($data);
  $data = stripcslashes($data);
  $data = htmlspecialchars($data);
  return $data;	  
}
	
function ProcessForm($connection)
{
	$dataCorrect = true;
	$SecretPassCode = "secret";
	$passCode ='';

	//Regex Checking
	$firstNamecheck = "^([A-Z][a-z]+(-[A-Z][a-z]+)?)$";
	$lastnamecheck = "^([A-Z][a-z]+(-[A-Z][a-z]+)?)$";

	$firstNameErr ='';
	$lastNameErr='';
	$emailErr='';
	$userNameErr='';
	$passWdErr='';
	$rePassWdErr='';
	$codeErr='';

	//Reading the firstname and cleaning it, if is empty display Error Message.	
	if (empty($_POST['FirstName']))
	 {
		$firstNameErr = '*First name required';
		$firstname = '';
		$dataCorrect = false;
	}
	else
	{
		$firstname = $_POST['FirstName'];
		if (preg_match("/$firstNamecheck/", $firstname))
		{
			$firstname = $_POST['FirstName'];
			cleanTheInput($firstname);
		}
		else
		{
			$firstNameErr = '*First name should start with Capital letter and must not contain Numbers, and can contain only "-"';
			$firstname = '';
			$dataCorrect = false;		
		} 
	}
	//Reading the last name and cleaning it, if is empty display Error Message.	
	if (strlen($_POST['LastName']) == 0)
	{
		$lastNameErr = '*Last name required';
		$lastname = '';
		$dataCorrect = false;
	}
	else
	{
		$lastname = $_POST['LastName'];
		if (preg_match("/$lastnamecheck/", $lastname))
		{
		$lastname = $_POST['LastName'];
		cleanTheInput($lastname);
		}
		else
		{
			$lastNameErr = 'Last name should start with Capital letter and must not contain Numbers, and can contain only "-"';
			$lastname = '';
			$dataCorrect = false;
		} 		
	}
	//Reading the email and cleaning it, if is empty display Error Message.	
	if (empty($_POST['eMail']))
	{
		$emailErr = '*Email required';
		$email = '';
		$dataCorrect = false;
	}
	else
	{
		$email = $_POST['eMail'];
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
		// valid address
			$email = $_POST['eMail'];
			cleanTheInput($email);
		}
		else
		{
			// invalid address
			$emailErr = 'Please input a valid email';
			$email = '';
			$dataCorrect = false;
		}
	}	
	//Reading the user name and cleaning it, if is empty display Error Message.	
	if (empty($_POST['userName']))
	{
		$userNameErr = '*User name required';
		$userName = '';
		$dataCorrect = false;
	}
	else
	{
		$userName = $_POST['userName'];
		cleanTheInput($userName);
	}	
	//Reading the password and cleaning it, if is empty display Error Message.	
	if (empty($_POST['userPassword']))
	{
		$passWdErr= '*Password required';
		$dataCorrect = false;
	}
	else
	{
		$firstPassword = $_POST['userPassword'];
		cleanTheInput($firstPassword);
	}	
	//Reading the Re entered password and cleaning it, if is empty display Error Message.	
	if (empty($_POST['userRePassword']))
	{
		$rePassWdErr= '*Password required';
		$dataCorrect = false;
	}
	else
	{
		$rePassword = $_POST['userRePassword'];
		cleanTheInput($rePassword);
	}	
	//Reading the Secret code and cleaning it, if is empty display Error Message.	
	if (empty($_POST['PassCode']))
	{
		$codeErr = '*Secret Code required';
		$dataCorrect = false;
	}
	else
	{
		$passCode = $_POST['PassCode'];
		cleanTheInput($passCode);
	}
	if ($dataCorrect == true)
	{
		if ($passCode == $SecretPassCode )
		{	
			if ($rePassword == $firstPassword)
			{
				//Salting and hashing password
				//Cost for salt
				$cost = 10;
				
				//Create a random salt
				$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
				// Prefix info about the hash so PHP knows how to verify it later.
				// "$2a$" Means we're using the Blowfish algorithm. The following 2 digits are the cost parameter.
				$salt = sprintf("$2a$%02d$", $cost) . $salt;
				//Insert into table hashed password with salt
				$securePassword=crypt($firstPassword, $salt);
				$insertQuery = "INSERT into tblUsers(firstName,lastName,email, userName, passWord) values ('$firstname','$lastname', '$email', '$userName','$securePassword')";
				$result = mysqli_query($connection, $insertQuery);
				echo("Successfully created user. <a href='LogIn.php'>Click here to go to Login Page </a>");  
			}
			else
			{
				showform($connection, $firstname,$lastname, $email, $userName, $firstNameErr, $lastNameErr,$emailErr, $userNameErr, $passWdErr, $rePassWdErr,$codeErr);
			}				
		}
		else
		{
			$codeErr='Incorrect Secret Code.';
			showform($connection, $firstname,$lastname, $email, $userName, $firstNameErr, $lastNameErr,$emailErr, $userNameErr, $passWdErr, $rePassWdErr,$codeErr);
		}
	}
	else
	{
		showform($connection, $firstname,$lastname, $email, $userName, $firstNameErr, $lastNameErr,$emailErr, $userNameErr, $passWdErr, $rePassWdErr,$codeErr);
	}
}
?>