<?php
include_once "../includeFiles/graphHeader.php";
include "../includeFiles/accessControl.inc.php";

$user = $_SESSION['userName'];
echo("
<div class='outerCalCont'>
<h1> Welcome $user this is Graphs Page </h1>
	<form><fieldset>
	<div class='innerCont'>
		<div id='chartDiv'></div>
		<br><hr><br>
		<div id='pieChart'></div>
		<br><hr><br>
		<div id='chartDiv2'></div>
	</div>
	</fieldset></form>
<div>
");
?>