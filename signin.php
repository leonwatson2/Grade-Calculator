<?php 
	
	/*Signin php that returns 1 or 2 if user info
	* does not match anything in database, returns
	* "ook" if user information is correct, and 
	*/
	include("mysql/server.php");
	session_start();
	$link = mysqli_connect($server, $username, $passw, $username);
	$email = mysqli_real_escape_string($link,$_POST["email"]);
	$email = strtolower(trim($email));
	$pass = mysqli_real_escape_string($link,$_POST["pass"]);
	$pass = strtolower(trim($pass));
	if(mysqli_connect_error()){
		
		die("1");
	}
	$query = "SELECT * FROM `users` WHERE (`email`='".$email."' OR `name`='".$email."') AND `password`='".md5(md5($email).$pass)."' LIMIT 1";
	if($results = mysqli_query($link, $query)){
		$row = mysqli_fetch_array($results);
		if($row){
			$_SESSION["name"] = $row["name"];
			$_SESSION["id"] = $row["id"];
			echo "ook";
		} else echo "2"; 
	} else echo "1";	

 ?>
