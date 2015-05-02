<?php 
include 'core/init.php';
include 'includes/overall/header.php'; 


if(isset($_GET['username']) === true && empty($_GET['username']) === false){
	$username	= $_GET['username'];
	
	if(user_exists($dbcon, $username) === true){
	$user_id	= user_id_from_username($dbcon, $username);
	$profile_data	= user_data($dbcon, $user_id, 'first_name', 'last_name', 'email');
	?>


<div class="row">
	<div class="page-header">
		<h3><?php echo $profile_data['first_name'] ?>'s Profile</h3>
	</div>
</div>
<div class="row">
	<div>
		<p><?php echo $profile_data['email'] ?></p>
	</div>
</div>


<?php
	} else { 
?>

<div class="row">
	<div class="col-sm-8 col-sm-offset-2 alert alert-danger">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>
			Sorry, that user doesn\'t exist.
		</strong>
	</div>
</div>

<?php
	}
	//echo $username;
} else {
	header('Location: index.php');
	exit();
}
?>

		
<?php include 'includes/overall/footer.php'; ?>