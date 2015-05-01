<form action="login.php" method="post">
	<div class="form-group">
    	<label for="username">Username</label>
		<input type="text" id="username" name="username" placeholder="Username" class="form-control" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" />
	</div>
	<div class="form-group">
    	<label for="password">Password</label>
		<input type="password" id="password" name="password" placeholder="Password" class="form-control">
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-default">Sign in</button>
	</div>
	<div class="form-group">
		Forgotten your <a href="recover.php?mode=username">Username</a> or <a href="recover.php?mode=password">Password</a>?
	</div>
</form>