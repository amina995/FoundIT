<?php 
	$host = 'localhost';
	$DBUser = "username";
	$DBPassword = 'password';
	$db = 'foundit';

	$conn = mysqli_connect($host,$DBUser, $DBPassword, $db);
	
	if(!$conn)
	{
		die(mysqli_error());
	}
	
?>