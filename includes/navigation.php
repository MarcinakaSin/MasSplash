<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <p class="navbar-brand ">MasSplash
  			<?php if ($user->isLoggedIn()){  ?>
  				<br /><small><small class="white-text">
            Hello, <a href="/MasSplash/<?php echo escape($user->data()->username); ?>">
            <?php echo escape($user->data()->username); ?>
            </a>
  				</small></small>
  			<?php } ?>
  		</p>

        <br />
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
  		    <li><a href="contact.php">Contact Us</a></li>
  		
      		<?php if ($user->isLoggedIn()){  ?>

      		<li><a href="downloads.php">Downloads</a></li>
      		<li><a href="forum.php">Forum</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">User Settings <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/MasSplash/<?php echo escape($user->data()->username); ?>">Profile</a></li>
                  <li><a href="changepassword.php">Change Password</a></li>
                  <li><a href="settings.php">Settings</a></li>
                  <!--<li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>-->
                </ul>
              </li>

      		<?php } else { ?>
          <li><a style="color:#fff;" href="register.php">Register Now!</a></li>
  		    <?php } ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
        <?php if (!$user->isLoggedIn()){ ?>
          <li><a href="login.php" style="color:#fff;">Login!</a> </li>
        <?php } else { ?>
          <li><a href="logout.php" style="color:#fff;">Logout</a> </li>
        <?php } ?>
          <li></li>
        </ul>

  		<?php // include 'includes/header_login_status.php'; ?>
      </div><!--/.navbar-collapse -->
    </div>
</nav>