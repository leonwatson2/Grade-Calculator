<?php 
session_start();
$userId = $_SESSION["id"];
 if(strlen($_SESSION["name"]) > 3)
 	header("Location:http://grdcalc.com");

include("inc/header.php");
 ?>
		
		<!-- <div class="love col-xs-1">
			<div class=" dropdown-toggle"><span class="caret"></span></div>
		</div> -->
		<div class="col-xs-12 col-md-6 clear-left">
			<h2>Sign Up</h2>
			<div id="error-panel" class="panel">
				<div class="panel-body"></div>
			</div>
			<form class="" id="sign-up-form" action="login.php" method="post">
				
				<div class="form-group has-feedback">
					<label for="user">username</label>
					<input class ="form-control" type="text" id="yName" name="username" value="<?php echo addslashes($_POST['username']); ?>">
					<span></span>
				</div>
				
				<div class="form-group has-feedback">
					<label for="ymail">Email</label>
					<input class ="form-control" type="email" id="ymail" name="email" value="<?php echo addslashes($_POST['email']); ?>">
					<span></span>
				</div>
				
				<div class="form-group has-feedback">
					<label for="pass">Password</label>
					<input class ="form-control" type="password" id="pass" name="pass" value="<?php echo addslashes($_POST['pass']); ?>">
					<span></span>
				</div>
							
				<button class="btn btn-success submit-btn" id="signup" type="submit" name="submit" value="signup">Sign Up</button>
			</form>
			<div id="confirm-email" class="panel">
				<div class="panel-body">
					Thanks for signing up! We have sent you a confirmation email to activate your account!
					Due to our server being in the UK please allow 24 hours to recieve it! 
				</div>	
			</div>
		</div>
<?php 
include("inc/footer.php"); ?>