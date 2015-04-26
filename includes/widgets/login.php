<form class="navbar-form navbar-right" action="login.php" method="post">
	<div class="row">
		<div class="col-sm-12 margin-right">
			<div class="form-group">
				<input type="text" name="username" placeholder="Username" class="form-control">
			</div>
			<div class="form-group">
				<input type="password" name="password" placeholder="Password" class="form-control">
			</div>
			<button type="submit" class="btn btn-success" style="margin-right: 5px;">Sign in</button>
		</div>
	</div>
	<div class="row white-text">
		<div class="col-sm-9">
		Forgotten your <a href="recover.php?mode=username">Username</a> or <a href="recover.php?mode=password">Password</a>?
		</div>
		<div class="col-sm-3">
			<a href="register.php">Register</a>
		</div>
	</div>
</form>