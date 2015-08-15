<?php 
/*Sign out php for user 
*
*/
	session_start();
	session_unset();
	//updated is a cookie that tells index.php to change classes saved in cookies
	setcookie("updated", false);
	header("Location:http://grdcalc.com");
 ?>
