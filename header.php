<?php
$conn = new mysqli(HOST,USER,PASSWORD,DATABASE);
?>
<html>
<head>
	<script type="text/javascript">
		$(document).ready(function(){
		    //Handles menu drop down
		    $('.dropdown-menu').find('form').click(function (e) {
		        e.stopPropagation();
		    });
		});
	</script>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php" id="logo">
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
			echo "<li><b><p class='navbar-text'>Welcome, " . $loginUser . "</p></b></li>";
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
			?>
			<li class="divider-vertical"></li>
					<li class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown">Sign Up<strong class="caret"></strong></a>
						<div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
							<form method="post" action="signup.php" accept-charset="UTF-8">
								<input style="margin-bottom: 15px;" type="text" placeholder="Username" id="username" name="signupUser" size="30" required>
								<input style="margin-bottom: 15px;" type="password" placeholder="Password" id="password" name="signupPassword" size="30" required>
								<input style="margin-bottom: 15px;" type="password" placeholder="Re-enter Password" id="password" name="rePassword" size="30" required>
								<input class="btn btn-primary btn-block" type="submit" id="sign-in" name="s2" value="Sign Up">
								</form>

						</div>
					</li>
			<li class="divider-vertical"></li>
					<li class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown">Login<strong class="caret"></strong></a>
						<div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
							<form method="post" action="index.php" accept-charset="UTF-8">
								<input style="margin-bottom: 15px;" type="text" placeholder="Username" id="username" name="user" size="30" required>
								<input style="margin-bottom: 15px;" type="password" placeholder="Password" id="password" name="password" size="30" required>
								<input class="btn btn-primary btn-block" type="submit" id="sign-in" name="s" value="Login">
								<label style="text-align:center;margin-top:5px;margin-left:auto;margin-right:auto;display:block">OR</label>
                                <input class="btn btn-primary btn-block" type="button" id="sign-in-google" value="Sign Up" onclick="window.location='login.php';">
								</form>

						</div>
					</li>
			<?php
			echo "</ul>";
}
?>
 </div>

</nav>
<table class="tbmenu" name="posts" style="" width="100%">
	<tr><th>
		<div class="topmenu">
	<ul>
		<a href="index.php"><li>Home</li></a>
<?php
if(isset($loginUser) && isset($loginPassword)){
	echo "<a href='#' data-toggle='modal' data-target='#submitModal'><li>Submit</li></a>";
}
else{
	echo "<a href='#' data-toggle='modal' data-target='#loginModal'><li>Submit</li></a>";
}
?>
</ul>
</div></th>
	</tr>
</table>
