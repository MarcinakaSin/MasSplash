<?php 
	if (logged_in()){
		include 'includes/widgets/loggedin.php'; 
	} else {
		include 'includes/widgets/login.php'; 
	}
?>