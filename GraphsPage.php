<?php
include_once "header.php";
include "accessControl.inc.php";

$user = $_SESSION['userName'];
echo("

	<h1> Welcome $user this is Graphs Page </h1>

");
?>