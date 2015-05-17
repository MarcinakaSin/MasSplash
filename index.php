<?php 
include 'core/init.php';
include 'includes/overall/header.php'; 


?>
<div class="row">
	<div class="page-header">
		<h3>Home</h3>
	</div>
</div>

<?php if(Session::exists('home')) { ?>
<div class="row">
	<div class="col-sm-8 col-sm-offset-2 alert alert-success">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<strong>
			<?php echo Session::flash('home'); ?>
		</strong>
	</div>
</div>
<?php }	?>
<div class="row">
	<div class="col-md-6">
		<fieldset class="videos"><legend>The Wombats</legend>
		<iframe width="450" height="300" src="https://www.youtube.com/embed/TpxuaIYiHgs" frameborder="0" allowfullscreen></iframe>
		</fieldset>
	</div>
	<div class="col-md-6">
		<p>
			
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
			if($user->hasPermission('admin')) {
				echo "You have Administrator permissions!";
			}
		?>
	</div>
</div>



<?php 

/*$userUpdate = DB::getInstance()->update('users', 3, array(
	'password' 	=> 'newpassword',
	'name'		=> 'Dail xxx'

));

//DB::getInstance();
//echo Config::get('mysql/host'); // '127.0.0.1'
$user = DB::getInstance()->get('users', array('username', '=', 'marcin'));

if(!$user->count()){
	echo 'No user';
} else { 
	//echo $user->results()[0]->username;
	echo $user->first()->username;
}*/

include 'includes/overall/footer.php'; ?>