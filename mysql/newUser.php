<?php 
	/*Checks to make sure username and 
	*	email address is not taken already in database.
	*	if in database returns 3 if not sends confirmation email
	*
	*/
	
	include("server.php");
	$name = $_POST["username"];
	$email = $_POST["email"];
	$pass = $_POST["pass"];
	$err = 0;
	$link = mysqli_connect($server, $username, $passw, $username);
	$src_query = "SELECT `email`, `name` FROM `users` WHERE `email`='".mysqli_real_escape_string($link,$email)."' OR `name`='".mysqli_real_escape_string($link,$name)."'";
	if (($result = mysqli_query($link,$src_query))) {
			if(mysqli_num_rows($result) == 0){
				include("confirmEmail.php");
			} else echo 3;
		}else echo 1;
 ?>
