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

if(isset($_POST['s2']))
{
$username=$_POST['signupUser'];
$_SESSION['user']=$username;
$pwd=$_POST['signupPassword'];
$pwd2=$_POST['rePassword'];
if($pwd==$pwd2)
$pwd=md5($pwd);
else
echo "Passwords Do not Match.";

$_SESSION['password']=$pwd;

trim($pwd);
trim($username);
$query = "SELECT * from user_table where user_name='$username'";
trim($query);
$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if($row['user_name'] == $username){
	echo "Username already exists, please choose a different one.";
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