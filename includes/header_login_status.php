<?php 
	if ($user->isLoggedIn()){
		include 'includes/widgets/loggedin.php'; 
	} else {
		include 'includes/widgets/login.php'; 
	}
?>