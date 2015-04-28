<?php 
include 'core/init.php';
include 'includes/overall/header.php'; 
?>
			
<h1>Home</h1>
<p>Just a template.<br />
This site was built and costumized by Marcin Ufnairz.  
I have a repository for it on <a href="https://github.com/" target="_new">GitHub</a> and anyone is permited to copy this site 
and use it's code for any creative purposes.<br />
<a href="https://github.com/MarcinakaSin/MasSplash" target="_new">https://github.com/MarcinakaSin/MasSplash</a>
</p>


		
<?php 
if (logged_in() === true){  
	if (has_access($dbcon, $session_user_id, 1) === true){
		echo 'Admin';
	} else if (has_access($dbcon, $session_user_id, 2) === true){
		echo 'Moderator!';
	}
}




include 'includes/overall/footer.php'; ?>