<?php
require_once 'core/init.php';
// prevents and redirects logged in users from accessing this page.
if($user->isLoggedIn()) {
	Redirect::to('index.php');
}

$errors = array();
if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'rename' => 'Username',
				'required' => true
			),
			'password' => array(
				'rename' => 'Password',
				'required' => true
			)
		));

		if($validation->passed()) {
			//$user = new User();

			$remember = (Input::get('remember') === 'on') ? true : false;
			$login = $user->login(Input::get('username'), Input::get('password'), $remember);

			if($login) {
				Session::flash('home', 'You have successfully logged in.');
				Redirect::to('index.php');
			} else {
				$errors[] = "Sorry, logging in failed.";
			}
		} else {
			$errors = $validation->errors();
		}
	}
}

/*if(!isset($_GET['new']) && empty($_GET['new'])){
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
				$errors[] = 'That Username/Password combination is incorrect.';
			
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
}*/
include 'includes/overall/header.php';
?>
<div class="row">
	<div class="page-header">
		<h3>Login!</h3>
	</div>
</div>
<?php if($errors){ ?>
<div class="row">
	<div class="col-sm-8 col-sm-offset-2 alert alert-danger">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<?php echo Validate::output_errors($errors); ?>
	</div>
</div>
<?php } ?>
<div class="row">
	<div class="col-sm-4 col-sm-offset-4">
		<?php include 'includes/widgets/plogin_form.php'; ?> 
	</div>
</div>

<?php include 'includes/overall/footer.php'; ?> 