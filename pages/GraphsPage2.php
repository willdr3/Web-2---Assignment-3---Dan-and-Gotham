<?php
include_once "../includeFiles/comparisonGraphsHeader.php";
include "../includeFiles/accessControl.inc.php";

$user = $_SESSION['userName'];
echo("
<div class='outerCalCont'>
<h1> Welcome $user this is Comparisons Page</h1>
	<form><fieldset>
	<div class='innerCont'>
		<div id='chartDiv'></div>
		<br><hr><br>
		<div id='chartDiv1'></div>
	</div>
	</fieldset></form>
<div>
");
?>