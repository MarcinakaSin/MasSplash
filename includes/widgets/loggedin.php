<div class="row navbar-right">
	<div class="col-sm-12">
		<small class="white-text" style="margin:5px;">
		<?php
			$user_count	= user_count($dbcon);
			$suffix = ($user_count != 1) ? 's' : '';
		?>
		We currently have <?php echo user_count($dbcon); ?> registered user<?php echo $suffix; ?>.
		</small><br />
		<p class="pull-right" style="margin:5px;">
		<a href="logout.php">Log out</a>
		</p>
	</div>
</div>