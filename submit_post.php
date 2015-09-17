<?php
//header('Content-type: text/html; charset=utf-8');

include('config.php');

$conn = new mysqli(HOST,USER,PASSWORD,DATABASE);

function get_title($url){
  $str = file_get_contents($url);
  if(strlen($str)>0){
    $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
    preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
    return $title[1];
  }
}
//Example:
//echo get_title("http://www.washingtontimes.com/");
?>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link href="style.css" rel="stylesheet">

</head>
<body>
	<div class="container-fluid">
<?php
include("header.php");

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
			//echo "Login Succesful.";
			$_SESSION['valid'] = "YES";
			$valid = $_SESSION['valid'];
			//echo "</br>Namaste, " . $loginUser;
			//echo "</br><a href='logout.php'>Sign Out</a>";
		}
		else
			{	$_SESSION['valid'] = "No";
				echo "Incorrect Login Session.";
				die();
			}
?>

		<h2>### SUBMIT NEWS URL ###</h2>
			<form class="form" method="post" action="submit_post.php">
			      <p class="field">
			        <input type="text" name="url" placeholder="Enter URL here"/>
			        <i class="fa fa-user"></i>
			      </p>

			      <p class="submit"><input type="submit" name="s_url" value="Submit"></p>
<?php
	}
if(isset($_POST['s_url'])){
		$url = $_POST['url'];
		$title = get_title($url);
		$id = fetchID();
		$query = "INSERT INTO posts_table (ID, Title, URL, time_stamp, by_user_id) VALUES (NULL,'$title','$url',NOW()," . $id . ")";
		$result = $conn->query($query);	
		if(!$result){
			echo $conn->error;
		}
	}
}
else
{
	echo "You have to be logged in to submit. Redirecting...";
	sleep(10);
	echo "<script>parent.location.href='login.php?submit=yes'</script>";

}
?>