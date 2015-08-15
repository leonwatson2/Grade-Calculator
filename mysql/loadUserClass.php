<?php
	session_start();
	include("http://grdcalc.com/inc/functions.php");
	include("server.php");
	$link = mysqli_connect($server, $username, $passw, $username);
	
	$num = $_POST['num'];
	$query = "SELECT `Class".$num."`, `groups".$num."`, `assignments".$num."`, `final".$num."` FROM `saves` WHERE `id`='".$_SESSION['id']."'";
	if ($result = mysqli_query($link,$query)) {
		$row = mysqli_fetch_array($result);
		$Class = '';
		$Class = $Class . '{"Class":"'.$row['Class'.$num].'"';	
		$Class = $Class . ', "groups":'.$row['groups'.$num];
		$Class = $Class . ', "assignments":'.$row['assignments'.$num];
		$Class = $Class . ', "final":'.$row['final'.$num];
		$Class = $Class . '}';

		echo $Class;
	}else echo 0;

?>