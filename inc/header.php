<?php 
	session_start();
	$_HOST = "http://grdcalc.com";
 ?>

<html lang="en">

	<head>
		<link rel="icon" type="img/x-icon" href="img/favicon.ico">
		<title>Grade Calculator | Check what your grade is!</title>
		<link href='http://fonts.googleapis.com/css?family=Asap:400,700|Varela+Round&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Just+Another+Hand|Fredericka+the+Great|Cabin+Sketch|Yanone+Kaffeesatz|Special+Elite' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="<?php echo $_HOST; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $_HOST; ?>/css/bootstrap-tour.min.css">
		<link rel="stylesheet" href="<?php echo $_HOST; ?>/css/gc.css">
		<link rel="stylesheet" href="<?php echo $_HOST; ?>/css/print.css" type="text/css" media="print">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="description" content="Grade calculator that helps college students calculate their grade with ease adding group list and assignments to each group.">
		<link rel="canonical" href="<?php echo $_HOST; ?>" />
	</head>
	<body data-spy="scroll" data-target="#">
				<div id="container" class="container">

			<h1 class="pull-left"><span class="firstTit">grade</span><span class="secondTit">calculator<span id='current-user'> <?php if($_SESSION["name"]){ echo "and ".$_SESSION["name"]; ?>  <img style="display:none" src="img/monkey.gif"><?} ?></span></span></h1>