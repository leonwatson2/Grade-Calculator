<?php 
	session_start();

	// Store passwords securely 
	// 4 levels
	// level 2 hash -> md5
	echo md5("i like cheese");
	// LEVEL 3 salt
	$salt = "kwnejfo2919992((";
	echo md5($salt."i like cheese");
	// Level 4 unique $salt
	echo md5(md5($_SESSION["name"]), "i like cheese");


 ?>
 <html>
 	
 	<h1><?php echo $_SESSION["name"]; ?></h1>
 	<a href="/mysql/">Herere</a>
 </html>