<?php

include('config.php');

// Create connection
$conn = new mysqli(HOST,USER,PASSWORD,DATABASE);

// Check connection
if (!$conn) {
    die("Connection failed: failed");
} 
else
    echo "";

if(isset($_GET['username'])){
		$verifyUserName = $_GET['username'];
		$query = "SELECT * from user_table where user_name = '$verifyUserName'";
		trim($query);
		$result = $conn->query($query);
		$row = mysqli_fetch_assoc($result);
	if(strlen($verifyUserName) < 4){
		echo "<span style='color:red'>Username too small.</span>";
	}
	else if($verifyUserName == $row['user_name']){
			echo "<span style='color:red'>Username already exists, please choose a different one.</span>";
			die();
	}
	else
		echo "<span style='color:green'>Username available.</span>";

}
if(isset($_POST['s2']))
{
$username=$_POST['signupUser'];
$_SESSION['user']=$username;
$pwd=$_POST['signupPassword'];
$pwd2=$_POST['rePassword'];


$_SESSION['password']=$pwd;

trim($pwd);
trim($username);
$query = "SELECT * from user_table where user_name='$username'";
trim($query);
$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if($row['user_name'] == $username){
	echo "Username already exists, please choose a different one.";
	session_destroy();
	echo "</br><a href='index.php'>Go Back</a>";
	die();
}
if($pwd==$pwd2)
		$pwd=md5($pwd);
	else{
			echo "Passwords Do not Match.";
			session_destroy();
			echo "</br><a href='index.php'>Go Back</a>";
			die();
	}
$query = "INSERT INTO user_table (ID, user_name, user_pass) VALUES (NULL,'$username','$pwd')";
trim($query);
$result = $conn->query($query);
if(!$result){
	echo $conn->error;
}
else
echo "<script>parent.location.href='index.php'</script>";
}
?>