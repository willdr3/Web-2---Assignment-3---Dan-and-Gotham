<?php
session_start();
?>
<!doctype html>
<html>
<head>
	<title>Exercise Monitor</title>
	 <meta charset="UTF-8">
	 <link rel="stylesheet" href="../Style13.css">
	  <!-- Linking the font I chose to use -->
	 <link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
	 <script type="text/javascript" src="../jquery-1.7.1.min.js"></script>
	 <script type="text/javascript" src="../jquery-ui-1.8.17.custom.min.js"></script>
	 <link rel="stylesheet" type="text/css"
			 href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" />
	 <script type="text/javascript">
		    $(document).ready(function(){
			$("#date").datepicker({  maxDate: new Date });
		    });
	 </script>
</head>
<body>	
	<div class="menu">
		<ul>
			<li> <a href="Home.php">Home</a></li>
			<li> <a href="DataPage.php">Data</a></li>
			<li> <a href="GraphsPage.php">Graphs</a></li>
			<li> <a href="CalenderPage.php">Calender</a></li>
			<li> <a href="LogOut.php">Sign Out</a></li>
		</ul>
	</div>
	<div class="spacer">
	</div>