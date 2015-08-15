<?php 
 ?>
 <div class="modal fade" id="login-modal">
 	<div class="modal-dialog">
 		<div class="modal-content">
 			<div class="modal-header">
 				<button class="close" data-dismiss="modal">
 					<span>x</span> 
 					<span class="sr-only">Close</span></button>
 					<h3>Log In</h3>
 			</div>	
 			<div class="modal-body">
 				<form id="login-form" method="post">

 					<div class="form-group input-login">
 						<label for="user-name">Username or Email</label>
 						<input type="text" class="form-control" id="user-name" name="user" placeholder="Leon">
 					</div>
 					<div class="form-group input-login">
 						<label for="pass">Password</label>
 						<input type="password" class="form-control" id="pass" name="pass" placeholder="Duh">
 					</div>
 				</form>
 				<div id="login-message">This is a nice message! That is meaningful.
 					<div id="error-panel" class="panel">
						<div class="panel-body"></div>
					</div>
				</div>
 			</div>
 			<div class="modal-footer">
 				<button class="btn btn-primary" form="login-form" id="login">Log In</button>
 				<button class="btn btn-warning" data-dismiss="modal">Close</button>
 			</div>
 		</div>
 	</div>
 </div>