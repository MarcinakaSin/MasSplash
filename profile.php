<?php 
include 'core/init.php';
include 'includes/overall/header.php'; 


if(isset($_GET['username']) === true && empty($_GET['username']) === false){
	$username	= $_GET['username'];
	
	if(user_exists($dbcon, $username) === true){
	$user_id	= user_id_from_username($dbcon, $username);
	$profile_data	= user_data($dbcon, $user_id, 'first_name', 'last_name', 'email');
	?>


			
<h1><?php echo $profile_data['first_name'] ?>'s Profile</h1>
<p><?php echo $profile_data['email'] ?></p>


	<?php
	} else {
		echo 'Sorry, that user doesn\'t exist.';
	}
	//echo $username;
} else {
	header('Location: index.php');
	exit();
}
?>

		
<?php include 'includes/overall/footer.php'; ?>