<?php 
include 'core/init.php';
logged_in_redirect();
include 'includes/overall/header.php'; 
?>
			
<h1>Recover</h1>
<p>Just a template.</p>
<?php
if(isset($_GET['success'])){

} else {
	$mode_allowed = array('username', 'password');
	if(isset($_GET['mode']) === true && in_array($_GET['mode'], $mode_allowed) === true){
		if(isset($_POST['email']) === true && empty($_POST['email']) === false){
			if(email_exists($dbcon, $_POST['email']) === true){
				recover($dbcon, $_GET['mode'], $_POST['email']);
				header('Location: recover.php?success');
				exit();
			} else {
				echo '<p>Oops, we couldn\'t find that email address.';
			}
		}
	?>

		<form action="" method="post">
			<ul>
				<li>
					Please enter your email address.<br />
					<input type="text" name="email">
				</li>
				<li>
					<input type="submit" value="Recover">
				</li>
			</ul>
		</form>
	<?php
	} else {
		header('Location: index.php');
		exit();
	}
}
?>
		
<?php include 'includes/overall/footer.php'; ?>