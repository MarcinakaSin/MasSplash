<?php 
require_once 'core/init.php';
//logged_in_redirect();
include 'includes/overall/header.php'; 
?>
<div class="row">
	<div class="page-header">
		<h3>Recover</h3>
	</div>
</div>
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
?>

<div class="row">
	<div class="col-sm-8 col-sm-offset-2 alert alert-danger">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>
			<?php	echo 'Oops, we couldn\'t find that e-mail address.'; ?>
		</strong>
	</div>
</div>

<?php
			}
		}
?>

<div class="row">
	<div class="col-sm-4">
		<form action="" method="post">
			<div class="form-group">
		    	<label for="email">Please enter your e-mail address.*</label>
				<input type="text" id="email" name="email" placeholder="E-mail" class="form-control" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required />
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-default" value="Recover" />
			</div>
		</form>
	</div>
</div>
	<?php
	} else {
		header('Location: index.php');
		exit();
	}
}
?>
		
<?php include 'includes/overall/footer.php'; ?>