<?php
include_once "../includeFiles/calHeader.php";
include "../includeFiles/accessControl.inc.php";
$user = $_SESSION['userName'];


echo("
<div class='outerCalCont'>
<h1> Welcome $user this is calendar Page </h1>
	<form><fieldset>
	<div class='innerCont'>
		<div id='calendar'></div>
	</div>
	</fieldset></form>
</div>
");

?>