<?php
include 'core/init.php';
// prevents and redirects logged in users from accessing this page.
logged_in_redirect();
if (empty($_POST) === false) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	
	if(empty($username) === true || empty($password) === true) {
		$errors[] = 'You need to enter a Username and Password.';
	} else if (user_exists($dbcon, $username) === false) {
		$errors[] = 'We can\'t find that Username. Have you registered?';
	} else if (user_active($dbcon, $username) === false) {
		$errors[] = 'You haven\'t activated your account!';
	} else {

		$login = login($dbcon, $username, $password);
		
		if ($login === false) {
			$errors[] = 'That username/password combination is incorrect';
		
		} else {
			// set the user session
			//die($login);
			$_SESSION['user_id'] = $login;

			// redirect user to home
			header('Location: index.php');
			
			echo $login;
			exit();
		}
	}

	//print_r($errors); 
} else {
	$errors[] = 'No data received.';
}
include 'includes/overall/header.php';
if(empty($errors) === false){
?>
	<h2>We tried to log you in, but...</h2>
<?php
echo output_errors($errors);
}
include 'includes/overall/footer.php';
?> 