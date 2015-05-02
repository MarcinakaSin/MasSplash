<?php 
include 'core/init.php';
include 'includes/overall/header.php'; 
?>
<div class="row">
	<div class="page-header">
		<h3>Home</h3>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<p>
			Just a template.<br />
			This site was built and costumized by Marcin Ufnairz.  
			I have a repository for it on <a href="https://github.com/" target="_new">GitHub</a> and anyone is permited to copy this site 
			and use it's code for any creative purposes.<br />
			<a href="https://github.com/MarcinakaSin/MasSplash" target="_new">https://github.com/MarcinakaSin/MasSplash</a>
		</p>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<?php 
			if (logged_in() === true){  
				if (has_access($dbcon, $session_user_id, 1) === true){
					echo 'Admin';
				} else if (has_access($dbcon, $session_user_id, 2) === true){
					echo 'Moderator!';
				}
			} 
		?>
	</div>
</div>



<?php include 'includes/overall/footer.php'; ?>