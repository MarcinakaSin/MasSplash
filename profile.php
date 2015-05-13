<?php 
require_once 'core/init.php';
include 'includes/overall/header.php'; 
//if(!isset($_GET['username']) === true && !empty($_GET['username']) === false){
if(!$username = Input::get('username')) {
	Redirect::to('index.php');
} else {
	$username	= $_GET['username'];
	$user = new User($username);
	if(!$user->exists()) {
		Redirect::to(404);
	} else {
		$data = $user->data();
	}
}
?>


<div class="row">
	<div class="page-header">
		<h3><?php echo escape($data->username); ?>'s Profile</h3>
	</div>
</div>
<div class="row">
	<div>
		<p><?php echo escape($data->name); ?></p>
	</div>
</div>
		
<?php include 'includes/overall/footer.php'; ?>