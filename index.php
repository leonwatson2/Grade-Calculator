<?php 
session_start();
require_once ("inc/functions.php");




if($_SESSION["name"] && $_COOKIE["updated"]!=true){
	include("mysql/server.php");
	$link = mysqli_connect($server, $username, $passw, $username);
	if($_SESSION["userClasses"] = getClassNames($link)){
		$userClasses = $_SESSION["userClasses"];
		setcookie("userClasses", $userClasses, 	time() + 86400*25);
		setcookie("updated",true);
		setcookie("firstTime", false);
	} else {
		$hasError = true;
	}
} else 
	$userClasses = $_SESSION["userClasses"];
if(!$_COOKIE["firstTime"]){	
	$class = $ex_className;
	$groups = $ex_groups;
	$assignments = $ex_assignments;
	$final = $ex_final;

	
	}else {
		$class = $_COOKIE['className'];
		$groups = json_decode($_COOKIE['groups']);
		$assignments = json_decode($_COOKIE['assignments']) ;
		$final = json_decode($_COOKIE['final']);
	if (count($assignments) == 0) {
		$assignments = "";
	}
}
include("inc/header.php")
					?>

			<?php if(!$_SESSION['name']){ ?>		
			<div id="register-btns" class="btn-group">
				<button data-toggle="modal" data-target="#login-modal" class="btn-md btn btn-primary">Sign in</button>
				<div id="sign-up-btn" class="btn btn-warning">Sign Up</div>
			</div>
			<?php } ?>
			
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-tabs">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div id="notify-wrapper">
				<span id="notify" style="display:none">
					<span id="notify-msg"></span>
				</span>
			</div>
			<div id="spying-scroll" >
				<ul class="nav nav-tabs">
				<li><a href="#pg-list">Love</a></li>
				<li><a href="#pg-table">Life</a></li>
				<li><a href="#final-group">full</a></li>
				<li><a href="#clear-grades">ok?</a></li>
			</ul>
			</div>
			<h2 id="class-name"><input value="<?php echo $class;?>" placeholder="Algerbra"></input></h2>
			<div class="collapse navbar-collapse" id="top-tabs">
				<ul class="nav nav-tabs">
					<li id="group-tab" role="presentation" class="active"><a>Group List</a></li>
					<li id="grades-tab" role="presentation" class="active"><a>Grades</a></li>
					<li id="final-tab" role="presentation" class="active"><a>Final Grade</a></li>
					<?php if ($_SESSION["name"]) {
						?>
					<li class="dropdown active">
						<a class="dropdown-toggle" data-toggle="dropdown">
							Classes <span class="caret"></span>
						</a>
						<ul id="saves" class="dropdown-menu">
							<?php for($i = 1; $i <= $totalClasses; $i++){ ?>								
								<?php echo hasClass($userClasses,$i); ?>

							<?php } ?>
						</ul>

					</li>
						 <?php
					}  ?>
					<li class="divider"></li>
					<li id="add-group" role="presentation" class="pull-right"><a>Add Group</a></li>
				</ul>
			</div>
			<!-- Percent Group List -->
			<div id="pg-list" >
				<h3 >Percent Group List</h3>
				<table <?php if(!$_COOKIE["firstTime"]) echo $popovers["pg-list"]; ?>  class="sorted-table table">
						<thead>
							<tr>
								<th class="col-xs-6 col-sm-4">Name</th>
								<th class="hidden-xs col-sm-2">Points</th>
								<th class="hidden-xs col-sm-2">Total # of points</th>
								<th class="col-xs-6 col-sm-3">Percentage</th>
							</tr>
						</thead>
						<!-- <h2>Your Window Width: <span id="width">	</span></h2> -->
						<tbody id="p-groups">
							<tr>
								<td>
									<input id="group-name1" type="text" class="name form-control" value="<?php echo $groups[0][0]; ?>"placeholder="Homeworks">
								</td>
								<td class="hidden-xs">
									<input id="group-points1" type="number" class="points-top form-control" placeholder="90">
								</td>
								<td class="hidden-xs">
									<input id="group-outof1"type="number" class="points-bottom form-control" placeholder="100">
								</td>
								<td>
									<div class="input-group">
										<input id="group-percentage1" type="number" value="<?php echo $groups[0][1]; ?>" class="percentage form-control"><span class="input-group-addon">%</span>
									</div>
								</td>
							</tr>
							<?php addGroupTop($groups); ?>
						</tbody>
						<tfoot>
							<tr>
								<td ><input disabled type="text" class="form-control" value="Final Exam">
								</td>
								<td class="hidden-xs"><input type="number" class="points-top form-control" placeholder="90">
								</td>
								<td class="hidden-xs"><input type="number" class="points-bottom form-control" placeholder="100">
								</td>
								<td ><div class="input-group">
											<input type="number" value="<?php echo $final[0]; ?>" class="f-percentage percentage form-control"><span class="input-group-addon">%</span>
										</div>
								</td>
							</tr>
						</tfoot>
				</table>
				<div id="percent-alert" class="alert alert-warning pull-right col-xs-3" role="alert">
					<button class="close" data-dismiss="alert" aria-hidden="true">x</button>
					Percentage Over 115!

				</div>
			</div>
			<!-- Percent Group Tables -->
			<div id="pg-table">
				<h3>Percent Group Tables</h3>
				<table id="group1" class="col-md-6 col-xs-12 table grade-table" <?php if(!$_COOKIE["firstTime"]) echo $popovers["pg-table"]; ?> >
					<thead>
						<tr>
							<th class="col-sm-3 col-xs-5 nm">Homeworks</th>
							<th class="hidden-xs col-sm-3">Points</th>
							<th class="hidden-xs col-sm-3">Total # of points</th>
							<th class="col-sm-3 col-xs-5">Grade</th>
							<th class="percent-each col-sm-2 col-xs-5">20% each.</th>
						</tr>
					</thead>
					<tbody id="pg-assignments1">
						<?php firstAssignments($assignments); ?>
					</tbody>
				</table>
				<?php assignments($assignments); ?>
			</div>
			<table id="final-group" class="col-md-6 col-xs-12 table grade-table">
					<thead>
						<tr>
							<th class="col-sm-3 col-xs-5 nm">Final Exam</th>
							<th class="col-sm-3 col-xs-5">Grade</th>
							<th class="f-percent-each col-sm-2 col-xs-5">20% each.</th>
						</tr>
					</thead>
					<tbody id="final-exam-grade">
						<tr>
							<td class="col-sm-2 col-xs-5"><input type="text" class="form-control" value="Final Exam Grade" disabled></td>
							<td class="col-sm-1 col-xs-5">
								<div class="input-group">
									<input type="number" value="<?php echo $final[1];  ?>" class="percentage form-control"><span class="input-group-addon">%</span>
								</div>
							</td>
							<td class="btn-group col-sm-2 col-xs-2"> 
							</td>
						</tr>
					</tbody>
				</table>
			<div id="finals" class="col-xs-12">
				<div class="col-xs-12 col-sm-4">
					<h2>Your Final Grade Is <span id="final-grade">100</span></h2>
				</div>
				<div class="col-xs-12 col-sm-4">
					<h3>Grade Without Final <span id="final-grade-wo">100</span></h3>
				</div>
			</div>
			<!-- Contact Form -->
			<div id="contact" class="col-xs-12">
				<h3>Contact Me</h3>
				<form id="contact-me" action="sendMail.php" method="post" novalidate>
					<div class="form-group has-feedback">
						<label for="yName">Your Name!</label>
						<input type="text" class="form-control" name="yName" id="yName" placeholder="What's Your Name?">
						<span></span>
					</div>
					<div class="form-group has-feedback">
						<label for="ymail">Your Email! </label>
						<input type="email" class="form-control" name="email" id="ymail" placeholder="coolchick9<?php echo rand(0, 9); ?>@hotmail.com">
						<span></span>
					</div>
					<div class="form-group has-feedback">
						<label for="ymessage">Your Message To Me!</label>
						<textarea name="ymessage" class="form-control" id="ymessage" rows="3" placeholder="<?php echo $randmessage[rand(0,count($randmessage))]; ?>"></textarea>
						<span></span>
					</div>
					<input id="botStop" type="text" hidden>
					<div class="form-group">
						<button id="submit-btn" class="btn btn-primary" type="" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">Send it!</button>
					</div>
				</form>
			</div>
			<!-- Help Modal -->
			<?php require_once("inc/help_modal.html"); ?>
			<ul class="nav nav-hang">
				<li id="contact-form" class="pull-left"><a>Contact</a></li>
				<li id="clear-grades" class="pull-right active" role="presentation" <?php if(!$_COOKIE["firstTime"]) echo $popovers["clear-grades"]; ?> ><a>Clear Grades</a></li>
			</ul>
			<!-- <button id="clear-grades" class="btn btn-danger col-xs-offset-4 col-xs-4">Clear Grades</button> -->
			<!-- Login Modal -->
			<?php include("inc/loginModal.php"); ?>
			<?php include("inc/optionModal.php"); ?>
		</div>
		<div class="container">
		
			<?php if($_SESSION["name"]){ ?>
				<button id="sign-out" class="pull-left btn btn-lrg btn-danger"><a href="/signout.php">Sign Out</a></button>
				<?php } ?>
		</div>
		<div class="container"><button id="print" type="button" class="hidden-xs btn btn-primary btn-lrg"><span class="glyphicon glyphicon-print"></span></button></div>
		
	<?php include("inc/footer.php") ?>