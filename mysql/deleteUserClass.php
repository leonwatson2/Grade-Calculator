<?php
	//Setting user class specified to null
	session_start();
	include("server.php");
	$num = $_POST['num'];

	$link = mysqli_connect($server, $username, $passw, $username);
	$query = "UPDATE `saves` SET `Class".$num."`='', `groups".$num."`='', `assignments".$num."`='', `final".$num."`='' WHERE `id`=".$_SESSION['id']."";
	if($result = mysqli_query($link, $query)){
		echo 1;
	} else echo "Query is " . $query;


?>
