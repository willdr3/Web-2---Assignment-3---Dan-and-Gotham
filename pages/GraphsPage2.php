<?php
include_once "../includeFiles/comparisonGraphsHeader.php";
include "../includeFiles/accessControl.inc.php";

$user = $_SESSION['userName'];
echo("
<div class='outer2GraphCont'>
<h1> Welcome $user this is Comparisons Page</h1>
	<form><fieldset>
	<div class='innerCont'>
		<div id='chartDivA'></div><div id='chartDivB'></div>
	</div>
	</fieldset></form>
<div>
");
?>