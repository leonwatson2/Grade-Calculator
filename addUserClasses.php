<?php
session_start();
include("mysql/server.php");
include('inc/functions.php');
$link = mysqli_connect($server, $username, $passw, $username);


include('inc/header.php');
?>
<div class="panel"> 
	<h2><?php 
	$row = getClasses($link);
	if(hasClass($row,1))
		printClass($row,1);
	else echo "Save class";
	?></h2>
	
</div>


<?

include('inc/footer.php');

?>