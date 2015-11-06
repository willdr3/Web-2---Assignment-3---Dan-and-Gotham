<?php
session_start();
?>
<!doctype html>
<html>
<head>
	<title>Exercise Monitor</title>
	 <meta charset="UTF-8">
	 <link rel="stylesheet" href="Style13.css">
	 <link rel="stylesheet" href="../Style13.css">
	  <!-- Linking the font I chose to use -->
	 <link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
</head>
<body>	
	<div class="menu">
		<ul>
<<<<<<< HEAD
			<li> <a href="LogIn.php">Login</a></li>
			<li> <a href="RegistrationPage.php">Register</a></li>
=======
			<?php
			if(isset($logTrue) || isset($regTrue))
			{
				echo("<li> <a href='LogIn.php'>Login</a></li>");
				echo("<li> <a href='RegistrationPage.php'>Register</a></li>");
			}
			else
			{
				echo("<li> <a href='pages/LogIn.php'>Login</a></li>");
				echo("<li> <a href='pages/RegistrationPage.php'>Register</a></li>");
			}
			 ?>
>>>>>>> origin/master
		</ul>
	</div>
	<div class="spacer">
	</div>