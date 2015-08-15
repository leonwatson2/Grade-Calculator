<?php 
	//Sending confirmation email to user using php mail function
	
	$uniqueKey = md5(uniqid(rand()));
	$headers = "From: ". strip_tags($email) ."\r\n";
	$headers = "Reply-to: " . strip_tags($email). "\r\n";
	$headers = "Content-Type: text/html\r\n";
	$values= $uniqueKey."','".mysqli_real_escape_string($link,$name)."','".mysqli_real_escape_string($link,strtolower(trim($email)))."','".$pass;
	
	$query = "INSERT INTO `temp_users` (`confirmkey`,`name`,`email`,`password`) VALUES('".$values."')";
	mysqli_query($link, $query);
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
			<h1 class="pull-left"><span class="firstTit">grade</span><span class="secondTit">calculator and '.htmlspecialchars($name).'</span></h1>
			<div class="col-xs-12">
			<h2>Thanks for signing up with Grade Calculator '. htmlspecialchars($name) .'</h2>
			<p>Easily confirm your email address by pressing th link below '. htmlspecialchars($email) .'</p>
			<h3>grdcalc.com/confirm.php?confirmKey='.$uniqueKey.'</h3>
			
			</div>

		</div>
	</body>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://grdcalc.com/js/jquery.cookie.js"></script>
	<script src="http://grdcalc.com/js/bootstrap.min.js"></script>
	<script src="http://grdcalc.com/js/gc_func.js"></script>
	<script src="http://grdcalc.com/js/gc.js"></script>
	</html>';
	if(!mail($email, "Grade Calculator Confirmation", $msg, $headers))
		echo "0";

 ?>
