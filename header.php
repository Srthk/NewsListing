<?php
$conn = new mysqli(HOST,USER,PASSWORD,DATABASE);
?>
<html>
<head>
	
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" id="logo">
       <i class="fa fa-hacker-news fa-2x">&nbsp;Hacker News</i>
      </a>
    </div> 
<?php
if(isset($loginUser) && isset($loginPassword)){
	$query = "SELECT user_name, user_pass FROM user_table where user_name='$loginUser'";
	$result = $conn->query($query);

	if(!$result){
		echo $conn->error;
		echo "Incorrect username.";
		die();
	}
	else{

		$row = mysqli_fetch_assoc($result);

		if($row['user_pass'] == $loginPassword){
			$_SESSION['valid'] = "YES";
			$valid = $_SESSION['valid'];
			echo "<ul class='nav navbar-nav navbar-right'>";
			echo "<li><p class='navbar-text'>Namaste, " . $loginUser . "</p></li>";
			echo "<li><p class='navbar-text'><a href='logout.php'><button type='button' class='btn btn-default'>Sign Out</a></button></p></li>";
			echo "</ul>";
		}
		else
			{
				echo "Incorrect Password";
				die();
			}
	}
}
else{
			echo "<ul class='nav navbar-nav navbar-right'>";
			echo "<li><p class='navbar-text'>Namaste, Guest</p></li>";
			echo "<li><p class='navbar-text'><a href='login.php'>Sign In / Sign Up</a></p></li>";
			echo "</ul>";
}
?>
 </div>
</nav>
