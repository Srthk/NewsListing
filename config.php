<?php
 

error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start(); 
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "root");    // The database username. 
define("PASSWORD", "qwerty");    // The database password. 
define("DATABASE", "News");    // The database name.


if(isset($_SESSION['user']) && isset($_SESSION['password'])){
	$loginUser=$_SESSION['user'];
	$loginPassword=$_SESSION['password'];
}

//$_SESSION['valid']="NO";
?>