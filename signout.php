<?php 
session_start();
	session_unset();
	setcookie("updated", false);
	header("Location:http://grdcalc.com");
 ?>