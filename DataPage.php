<?php
include_once "header.php";
include "accessControl.inc.php";
include_once "DatePicker.php";

$user = $_SESSION['userName'];

echo("


<h2>Welcome back $user Enter your activity below </h2>

<form method=\"post\" action=''>
    Date : <input type='text'  name='date' id='date'/><br>
	<p></p>
	Activity: <input type='text'  name='activity' value='' size='30'><br>
	<p></p>
	Time: <input type='text' name='time' value='' size='30'>
	
        </form>



");
?>