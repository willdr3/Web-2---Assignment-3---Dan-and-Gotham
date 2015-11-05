<?php
include_once "../includeFiles/header.php";
include "../includeFiles/accessControl.inc.php";

$user = $_SESSION['userName'];
echo("

	<h1> Welcome $user this is Graphs Page </h1>

");
?>