<?php
header('Content-type: text/html; charset=utf-8');

include('config.php');
$conn = new mysqli(HOST,USER,PASSWORD,DATABASE);
mysqli_set_charset($conn,"utf8");
include('functions.php');
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" type="image/png" href="https://news.ycombinator.com/favicon.ico"/>


	<link href="style.css" rel="stylesheet">
	<script src="script.js"></script>
	<title>Sarthak's Hacker News</title>
</head>

<body>
<div class="container-fluid">
<?php
if(isset($_POST['s'])){
	$username=$_POST['user'];
	$_SESSION['user']=$username;
	$pwd=$_POST['password'];
	$pwd=md5($pwd);
	$_SESSION['password']=$pwd;
	echo "<script>parent.location.href='index.php';</script>";
}
if(isset($_GET['signup'])){
				$pwd=md5($_SESSION['password']);
				$_SESSION['password']=$pwd;
				$loginPassword=$pwd;
	}
if(isset($loginUser) && isset($loginPassword)){
	$query = "SELECT user_name, user_pass FROM user_table where user_name='$loginUser'";
	$result = $conn->query($query);

	if(!$result){
		echo $conn->error;
		echo "Incorrect username.";
		session_destroy();
		echo "</br><a href='index.php'>Go Back</a>";
		die();
	}
	else{

		$row = mysqli_fetch_assoc($result);

		if($row['user_pass'] == $loginPassword){
			//Succesful Login
			$_SESSION['valid'] = "YES";
			$valid = $_SESSION['valid'];

			}
		else 
			{	$_SESSION['valid'] = "No";
				echo "Incorrect Password or Username </br>";
				session_destroy(); //destroy the session
				echo "<a href='index.php'>Go Back</a>";
				die();
			}
	}

	//SUBMITTING POST
	if(isset($_POST['s_url'])){
		$url = $_POST['url'];
		$title = get_title($url);
		$id = fetchID($conn, $loginUser);
		$title = htmlentities($title);
		$query = "INSERT INTO posts_table (ID, Title, URL, time_stamp, by_user_id) VALUES (NULL,'$title','$url',NOW()," . $id . ")";
		$result = $conn->query($query);	
		if(!$result){
			echo $conn->error;
			echo "</br><a href='index.php'>Go Back</a>";
			die();
		}
	echo "<script>parent.location.href='index.php'</script>";
	}

	//To delete post by user
	if(isset($_GET['del'])){
		$del_id = $_GET['del'];
		$delQuery = $conn->query("SELECT by_user_id FROM posts_table WHERE id =" . $del_id);
		$delRes = mysqli_fetch_array($delQuery);
		if($delRes[0] == fetchID($conn, $loginUser)){
			$delQuery = $conn->query("DELETE FROM posts_table WHERE id = " . $del_id);
			if(!$delQuery){
				echo "Error while deleting.";
				echo "</br><a href='index.php'>Go Back</a>";
				die();
			}
		}
	}
}
else{
	if(isset($_GET['for'])){
	echo "<script>parent.location.href='login.php';</script>";
	}
}

include("header.php");
?>
<div id="content">

<table>
<?php

//Which posts to display
if(isset($_GET['postsby'])){
	$posts_by = fetchID($conn, $_GET['postsby']);
	$posts_query = "SELECT * FROM posts_table WHERE by_user_id = " . $posts_by . " ORDER BY ID DESC";
	echo "<p class='span7 text-center'>Posts by: " . $_GET['postsby'] . "</h2>";
	$count = 0;
}
else if(isset($_GET['page'])){
	$offset = 20 * $_GET['page'];
	$posts_query = "SELECT * FROM posts_table ORDER BY ID DESC" . " LIMIT $offset," . ($offset + 20);
	$count = $offset;
}
else {
	$posts_query = "SELECT * FROM posts_table ORDER BY ID DESC LIMIT 20";
	$count = 0;
}

$posts_result = $conn->query($posts_query);
	
mysqli_set_charset($conn,"utf8");

if(!$posts_query)
echo $conn->error;

//DISPLAYING POSTS
while($posts_row = mysqli_fetch_array($posts_result)){
	if($count < 30){
	$link = $posts_row[2];
	$title = $posts_row[1];
	$title = html_entity_decode($title);
	$id = $posts_row[0]; //ID of the post
	$votes = $posts_row[3];
	$time = $posts_row[4];

	if($votes == 1){
		$votes = $votes . " point";
	}
	else 
		$votes = $votes . " points";

	$res = $conn->query("SELECT user_name FROM user_table WHERE id=" . $posts_row[5]); //To fetch username of creator of post
	
	$post_user = mysqli_fetch_array($res);
	
	mysqli_set_charset($conn,"utf8");

	if(isset($loginUser)){
		$loginID = fetchID($conn, $loginUser);
		$result = $conn->query("SELECT post_id FROM votes_table WHERE user_id = $loginID AND post_id  = $id");		
		$conn->error;
		$row = mysqli_fetch_array($result);
	}
	echo "<tr><td>" . ($count + 1) . ".</td>"; 

	if(isset($loginID) && $row[0] == $id){

		echo "<td>"  . "<span id='upvote$id' class='up' onclick='showCount($id)'><i class='fa fa-caret-up'></i></span></td>"; 

	}
	else if(isset($loginID)){
			if($post_user[0] == $loginUser){
				echo "<td style='color:orange;'>" . "--" . "</td>"; //Disable upvote button if post is by same user as logged in
			}
			else 
				echo "<td>"  . "<span id='upvote$id' class='down' onclick='showCount($id)'><i class='fa fa-caret-up'></i></span></td>"; 
	}
	else{
		echo "<td>"  . "<a href='#' data-toggle='modal' data-target='#loginModal' class='down'><span id='upvote$id' class='down'><i class='fa fa-caret-up'></i></span></a></td>"; 

	}
	$img = "<img src='http://www.google.com/s2/favicons?domain=" . $link . "' height='16'>";

	echo "<td rowspan='2'>" . $img . "</td><td><a href='" . $link . "' target='_BLANK'>" . $title . "</a></td></tr><tr style='height: 0;'><td colspan='2'></td><td><span id='upcount$id' class='points'>". $votes . " </span><span class='points'>| shared by <a href='index.php?postsby=" . $post_user[0] . "' class='points'>" . $post_user[0] . "</a> | " . time_elapsed_string($time) . "</span>"; 
	if(isset($loginUser)){
		if($post_user[0] == $loginUser){
		echo "<span class='points'> | <a href='index.php?del=" . $id . "' class='points' >Delete</a></span></td></tr>";
		}
	}
	else
		echo "</tr>";
	$count++;
	}
}

//List 20 posts at a time

if(isset($_GET['page'])){
	$page = $_GET['page'] + 1;
}
else
	$page = 1;

$res=$conn->query("SELECT COUNT(*) FROM posts_table");
$row=mysqli_fetch_array($res); //Total number of posts

if($row[0] > ($page * 20) ){
echo "<tr><td colspan='4' class='next'><a class='back-next' href='index.php?page=" . ($page - 1) . "'>< Back </a>";
echo "&nbsp;<a href='index.php?page=" . $page . "' class='back-next'>Next ></a></td></tr>";
}
else{
echo "<tr><td colspan='4' class='next'><a class='back-next' href='index.php?page=" . ($page - 2). "'>< Back </a>";
echo "&nbsp;<a class='back-next' href='index.php?page=0'>Next ></a></tr>";
}
?>
</table>
</div>

<!--LOGIN / SIGN UP POPUP-->

<div id="loginModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display:none">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h2 class="text-center">Login</h2>
      </div>
      <div class="modal-body">
          <form class="form center-block" method="POST" action="index.php">
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="user" placeholder="Username">
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" name="password" placeholder="Password">
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-lg btn-block" type="submit" name="s">Sign In</button>
            </div>
           </form>
       </div>
<div class="modal-header">
<h2 class="text-center" id="or"></h2>
  <h2 class="text-center">Register</h2>
</div>
      <div class="modal-body">
          <form class="form center-block" method="POST" action="signup.php">
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="signupUser" id='signupUser' placeholder="Username" onchange="verifyUserName(this.value)" required>
              <p id='userValidation'></p>
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" id="signupPassword" name="signupPassword" placeholder="Password" onchange="checkPassword();" required>
              <p id="divCheckPassword"></p>
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" id="rePassword" name="rePassword" placeholder="Re-enter Password" onchange="checkPasswordMatch();" required>
              <p id="divCheckPasswordMatch"></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-lg btn-block" type="submit" name="s2">Sign Up</button>

            </div>
          </form>
      </div>
      <div class="modal-footer">
          <div class="col-md-12">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
      </div>  
      </div>
  </div>
  </div>
</div>

<!--SUBMIT POPUP-->

<div id="submitModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display:none">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h2 class="text-center">SUBMIT POST</h2>
      </div>
      <div class="modal-body">
          <form class="form center-block" method="POST" action="index.php" onsubmit="return validation();">
            <div class="form-group">
              <input type="url" class="form-control input-lg" name="url" placeholder="Enter URL here" required>
            *Please prepend URLs with protocols. (example - http://www.facebook.com)            
            </div>
            <div class="form-group">
              <button id='s_post' class="btn btn-primary btn-lg btn-block" type="submit" name="s_url">Submit</button>
              <span id='waiting' style='display:none;' class='text-center'><img src="http://62.50.72.82/UCIBWS/Content/Images/loading.gif" height='50'>Processing...</span>
            </div>
           </form>
       </div>
  </div>
  </div>
</div>
    <br>

<div class="panel panel-default">
    <div class="panel-footer">Copyright &copy; Sarthak Singhal | Hacker News 2015 | <a href="https://twitter.com/sarthak003" target="_BLANK">Follow Me</a></div>
  </div>
</body>
</html>
