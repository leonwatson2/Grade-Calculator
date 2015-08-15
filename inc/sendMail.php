<?php 
	$name = $_POST["yName"];
	$email = $_POST["email"];
	$msg = $_POST["ymessage"];
	$headers = "From: ". strip_tags($email) ."\r\n";
	$headers = "Reply-to: " . strip_tags($email). "\r\n";
	$headers = "Content-Type: text/html\r\n";
	$msg = '
	<html lang="en">
	<head>
		<link rel="icon" type="img/x-icon" href="img/favicon.ico">
		<title>Grade Calculator | Check what your grade is!</title>
		<link href="http://fonts.googleapis.com/css?family=Asap:400,700|Varela+Round&subset=latin,latin-ext" rel="stylesheet" type="text/css">
		<link href="http://fonts.googleapis.com/css?family=Just+Another+Hand|Fredericka+the+Great|Cabin+Sketch|Yanone+Kaffeesatz|Special+Elite" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="http://grdcalc.com/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://grdcalc.com/css/gc.css">
		
	</head>
	<body>
		<div id="container" class="container">
			<h1 class="pull-left"><span class="firstTit">grade</span><span class="secondTit">calculator</span></h1>
			<div class="col-xs-12">
			<h2>From: '. htmlspecialchars($name) .'</h2>
			<h3>There email is '. htmlspecialchars($email) .'</h3>
			<h2>There message to you.</h2>
			<p>'. htmlspecialchars($msg) .'</p>
			</div>

		</div>
	</body>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://grdcalc.com/js/jquery.cookie.js"></script>
	<script src="http://grdcalc.com/js/bootstrap.min.js"></script>
	<script src="http://grdcalc.com/js/gc_func.js"></script>
	<script src="http://grdcalc.com/js/gc.js"></script>
	</html>';
	if(!mail("leon@vlw2.com", "Grade Calculator User", $msg, $headers))
		return false;
	return true;

 ?>