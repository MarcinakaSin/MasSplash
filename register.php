<?php
require_once 'core/init.php';
// prevents and redirects logged in users from accessing this page.
if($user->isLoggedIn()) {
	Redirect::to('index.php');
}
include 'includes/overall/header.php'; 

$errors = array();
if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new Validate();
		echo "<br /><br /><br /><br />Working";
		if(Input::get('group') === '2') {
			$validation = $validate->check($_POST, array(
				'org_name' => array(
					'rename' => 'Organization Name',
					'required' => true,
					//'nospace' => true,
					'min' => 2,
					'max' => 20,
					'unique' => 'users'
				),
				'password' => array(
					'rename' => 'Password',
					'required' => true,
					'min' => 6
				),
				'validate_password' => array(
					'rename' => 'Confirm Password',
					'required' => true,
					'matches' => 'password'
				),
				'email' => array(
					'rename' => 'E-mail',
					'required' => true,
					'format' => 'email',
					'unique' => 'users'
				),
				'group' => array(
					'required' => true,
					'min' => 1,
					'max' => 1
				)
			));
		} else {
			$validation = $validate->check($_POST, array(
				'first_name' => array(
					'rename' => 'First Name',
					'required' => true,
					//'nospace' => true,
					'min' => 2,
					'max' => 50
				),
				'last_name' => array(
					'rename' => 'Last Name',
					'required' => true,
					//'nospace' => true,
					'min' => 2,
					'max' => 50
				),
				'password' => array(
					'rename' => 'Password',
					'required' => true,
					'min' => 6
				),
				'validate_password' => array(
					'rename' => 'Confirm Password',
					'required' => true,
					'matches' => 'password'
				),
				'email' => array(
					'rename' => 'E-mail',
					'required' => true,
					'format' => 'email',
					'unique' => 'users'
				),
				'group' => array(
					'required' => true,
					'min' => 1,
					'max' => 1
				)
			));
		}	

		if($validation->passed()) {
			$user = new User();

			$salt = Hash::salt(32);

			try {

				if(Input::get('group') === '2') {
					$user->create(array(
						'org_name' => Input::get('org_name'),
						'password' => Hash::make(Input::get('password'), $salt),
						'salt' => $salt,
						'email' => Input::get('email'),
						'joined' => date('Y-m-d H:i:s'),
						'group' => 2
					));
				} else if(Input::get('group') === '1') {
					$user->create(array(
						'first_name' => Input::get('first_name'),
						'last_name' => Input::get('last_name'),
						'password' => Hash::make(Input::get('password'), $salt),
						'salt' => $salt,
						'email' => Input::get('email'),
						'joined' => date('Y-m-d H:i:s'),
						'group' => 1
					));
				}

			} catch(Exception $e) {
				die($e->getMessage());
			}


			Session::flash('success', 'You registered successfully!');
			//Redirect::to(404);
			header('Location: index.php');
		} else {
			$errors = $validation->errors();
		}
	}
} 
?>
		
<div class="row">
	<div class="page-header">
		<h3>Engage In Your Community!</h3>
	</div>
		<p class="lead">Connect with other volunteers and organizations throughout your community.</p>
</div>

<?php if($errors != null) { ?>
<div class="row">
	<div class="col-sm-8 col-sm-offset-2 alert alert-danger">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>
			<?php 	echo Validate::output_errors($errors);	/*output errors*/  ?>
		</strong>
	</div>
</div>
<?php }	?>
<div class="row">
	<div class="col-sm-6">
		<form action="" method="post">
			<div class="row">
				<div class="col-sm-6">
					<div class="radio">
						<label>
							<input id="group1" type="radio" name="group" <?php if(Input::exists()) { if(Input::get('group') === '1') { echo "checked='checked'"; }} ?> value="1" />
							Register as a User!
						</label>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="radio">
						<label>
							<input id="group2" type="radio" name="group" <?php if(Input::exists()) { if(Input::get('group') === '2') { echo "checked='checked'"; }} ?> value="2" />
							Register as an Organization!
						</label>
					</div>
				</div>
			</div>
			<div id="name-div">
		  		<div class="form-group">
			    	<label for="first_name">First Name</label>
					<input type="text" id="first_name" name="first_name" placeholder="First Name" class="form-control" value="<?php echo escape(Input::get('first_name')); ?>" />
				</div>
		  		<div class="form-group">
			    	<label for="last_name">Last Name</label>
					<input type="text" id="last_name" name="last_name" placeholder="Last Name" class="form-control" value="<?php echo escape(Input::get('last_name')); ?>" />
				</div>
			</div>
			<div id="reg-form">
				<div class="form-group" id="org-div">
			    	<label for="org_name">Organization Name</label>
					<input type="text" id="org_name" name="org_name" placeholder="Organization Name" class="form-control" value="<?php echo escape(Input::get('org_name')); ?>" />
				</div>
				<div class="form-group">
			    	<label for="password">Password</label>
					<input type="password" id="password" name="password" placeholder="Password" class="form-control" value="<?php if(isset($_POST['password'])) echo $_POST['password']; ?>" />
				</div>
				<div class="form-group">
			    	<label for="validate_password">Confirm Password</label>
					<input type="password" id="validate_password" name="validate_password" placeholder="Confirm Password" class="form-control" />
				</div>
				<div class="form-group">
			    	<label for="email">E-mail</label>
					<input type="text" id="email" name="email" placeholder="E-mail" class="form-control" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" />
				</div>
				<div class="form-group">
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
					<input type="submit" class="btn btn-default" value="Register" />
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">


	function displayRegisterSections() {
		if($("#group2").is(':checked')) {
			$("#name-div").css("display", "none");
			$("#org-div, #reg-form").css("display", "inline");
		} else if($("#group1").is(':checked')) {
			$("#name-div, #reg-form").css("display", "inline");
			$("#org-div").css("display", "none");
		} else {
			$("#org-div, #name-div, #reg-form").css("display", "none");
		}
	}

	$(document).ready(function(){
		displayRegisterSections();
	});
 
	$("#group1, #group2").click(function(){ 
		displayRegisterSections();
	});
</script>


<?php include 'includes/overall/footer.php'; ?>