<?php
include_once "../includeFiles/calHeader.php";
include "../includeFiles/accessControl.inc.php";
$user = $_SESSION['userName'];


echo("<h1> Welcome $user this is calender Page </h1>
<div id='calendar'></div>


");

?>