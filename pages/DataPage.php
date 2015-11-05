<?php
include_once "../includeFiles/header.php";
include "../includeFiles/accessControl.inc.php";
include_once "DatePicker.php";

$user = $_SESSION['userName'];

echo("


<h2>Welcome back $user Enter your activity below </h2>

<form method=\"post\" action=''>
    Date : <input type='text'  name='date' id='date'/><br>
	<p></p>
	Activity
			<select name='Activity'>
			
			<option value='%'> Show all </option> ");
			// Using the variable in the above form so the user doesn't have to re enter the good data.
			$selectString = 'SELECT DISTINCT catName FROM tblExerCategories ORDER BY catName';
			$result = mysqli_query($connection,$selectString);
			
			//getting the details/values by going through each row.
			while ($row = mysqli_fetch_row($result))
				{
				 
				 echo("<option value = '$row[0]' >$row[0] ");
				 
				}
				
	echo("</select> <br> <p></p>
	Time: <input type='text' name='time' value='' size='30'>
	
        </form>



");
?>