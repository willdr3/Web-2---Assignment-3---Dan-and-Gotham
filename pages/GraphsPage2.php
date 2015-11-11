<?php
include_once "../includeFiles/graphHeader.php";
include "../includeFiles/accessControl.inc.php";

$user = $_SESSION['userName'];
echo("

	<h1> Welcome $user this is Comparisons Page </h1>

");
?>