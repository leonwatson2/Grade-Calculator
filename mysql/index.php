<?php 
	$server="localhost";
	$username="cl48-grdcalc";
	$pass="Bzs/FTF9r";
	$database="users";
	$link = mysqli_connect($server, $username, $pass, $username);
	if(mysqli_connect_error()){
		die("Sorry No");
	}

	$query = "SELECT `email` FROM `users` WHERE `name`='vlw2' LIMIT 0,10";
	if($result = mysqli_query($link, $query)){
		mysqli_num_rows($result);
		while($row = mysqli_fetch_array($result))

		print_r($row);

	} else echo "no";
	mysqli_query($link, "UPDATE `users` SET `NAME`='THAT GUY' WHERE `name`='Mike Gill'");
	// $add_query = "INSERT INTO `users` (`name`,`email`,`password`) VALUES('Mike Gill', 'mike@life.com', 'test2')";
	// mysqli_query($link,$add_query);
	$name = "Vernon L'eon watson";

	$update_query = "UPDATE `users` SET `email`='help@me.com' WHERE `id`=1";
	mysqli_query($link, $update_query);

	// Session Variables Store user Information
	$temp="Hello";
	//*****has to be first
	session_start();
	setcookie("me", "VLW2", time()+(60*60*24));
	
	echo $_SESSION["name"];

 ?>
 <html>
 	<head>
 		<title>My Sql</title>
 	</head>
	<body>
		<h1><?php echo mysqli_real_escape_string($link,$name); ?></h1>
		<h2><?php echo $_COOKIE["me"]; ?></h2>
		<a href="logged.php">Herererere.</a>
	</body>

 </html>