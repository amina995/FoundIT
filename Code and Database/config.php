<?php 
	$host = 'localhost';
	$DBUser = "root";
	$DBPassword = 'aminas';
	$db = 'foundit';

	$conn = mysqli_connect($host,$DBUser, $DBPassword, $db);
	
	if(!$conn)
	{
		die(mysqli_error());
	}
	
?>