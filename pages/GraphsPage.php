<?php
include_once "../includeFiles/graphHeader.php";
include "../includeFiles/accessControl.inc.php";

$user = $_SESSION['userName'];
echo("

	<h1> Welcome $user this is Graphs Page </h1>
	<div id='chart_div' style='width: 1200px; height: 500px;'></div>
");
?>