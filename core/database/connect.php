<?php
$connect_error = 'Sorry, we\'re experiencing connection problems.';
// hostname, username, password
//mysql_connect("localhost","root","") or die($connection_error);
//pick database
//mysql_select_db("users") or die($connection_error);
// hostname, username, password, database
$dbname = "users";
$dbuser = "root";
$dbpass = "";
$dbhost = "localhost";
$dbcon = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die($connect_error);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//mysqli_close($dbcon);
?>
