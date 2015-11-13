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
			<?php
			if(isset($logTrue) || isset($regTrue))
			{
				echo("<div class='menu'>");
					echo("<img src='../images/stick5.png' alt='stickIcon' class='titleImg' />");
					echo("<h1 class='title'>X-Track</h1>");
					echo("<ul>");
						echo("<li> <a href='LogIn.php'>Login</a></li>");
						echo("<li> <a href='RegistrationPage.php'>Register</a></li>");
					echo("</ul>");
				echo("</div>");
			}
			else
			{
				echo("<div class='menu'>");
					echo("<img src='images/stick5.png' alt='stickIcon' class='titleImg' />");
					echo("<h1 class='title'>X-Track</h1>");
					echo("<ul>");
						echo("<li> <a href='pages/LogIn.php'>Login</a></li>");
						echo("<li> <a href='pages/RegistrationPage.php'>Register</a></li>");
					echo("</ul>");
				echo("</div>");
			}
			?>
	<div class="spacer">
	</div>