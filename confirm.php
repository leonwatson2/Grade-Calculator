<?php
	include("mysql/server.php");
	$confirmkey = $_GET["confirmKey"];
	$link = mysqli_connect($server, $username, $passw, $username);
	if(mysqli_connect_error())
		echo "stupid";
	$query = "SELECT * FROM `temp_users` WHERE `confirmkey`='".$confirmkey."'";
	if($result = mysqli_query($link, $query)){
		$row = mysqli_fetch_array($result);
		
		$values = mysql_real_escape_string($row["name"])."','".mysql_real_escape_string(strtolower(trim($row["email"])))."','".md5(md5($row["email"]).trim($row["password"]));
		
		$query = "INSERT INTO `users` (`name`,`email`,`password`) VALUES('".$values."')";
		mysqli_query($link, $query);
		$query = "INSERT INTO `saves` (`id`) VALUES('NULL')";
		mysqli_query($link,$query);
		$del_query = "DELETE FROM `temp_users` WHERE `temp_users`.`email` = '".mysql_real_escape_string($row["email"])."'";
		mysqli_query($link,$del_query);
		
		header("Location:http://grdcalc.com");
	} else {
		include("inc/header.php");
?>
	<div id="error-panel" class="panel" style="display:block">
		<div class="panel-body">Seems something went wrong!
		</div>
		<h2><?php print_r($result = mysqli_query($link, $query)); ?></h2>
	</div><?php 
include("inc/footer.php");
} ?>