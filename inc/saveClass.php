<?php 
	session_start();
	include("../mysql/server.php");
	$link = mysqli_connect($server, $username, $passw, $username);
	if (mysqli_connect_error()) {
		echo "Server prob";
		die("Server Error");
	}
	$name = mysql_real_escape_string($_COOKIE['className']);
	$groups = mysql_real_escape_string($_COOKIE['groups']);
	$assignments = mysql_real_escape_string($_COOKIE['assignments']);
	$final = mysql_real_escape_string($_COOKIE['final']);
	$num = $_POST["num"];
	$id = $_SESSION["id"];
	$values = $name . "''" . $groups . "''" . $assignments . "''" . $final;
	$query = "UPDATE `saves` SET `Class". $num ."`='". $name .
					"', `groups". $num . "`='" . $groups .
					"', `assignments". $num . "`='". $assignments . 
					"', `final" . $num . "`='". $final .
					"' WHERE  `saves`.`id` =". $id;
	if($result = mysqli_query($link, $query)){
		echo "Worked!";
		}
	else echo "Error";
	
 ?>