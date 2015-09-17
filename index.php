<?php
header('Content-type: text/html; charset=utf-8');

include('config.php');
$conn = new mysqli(HOST,USER,PASSWORD,DATABASE);
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function favicon($url){
$doc = new DOMDocument();
$doc->strictErrorChecking = FALSE;
$doc->loadHTML(file_get_contents($url));
$xml = simplexml_import_dom($doc);
$arr = $xml->xpath('//link[@rel="shortcut icon"]');
return $arr[0]['href'];
}
?>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>


	<link href="style.css" rel="stylesheet">
	<script>
	function showCount(id) {
	        var xmlhttp = new XMLHttpRequest();
	        xmlhttp.onreadystatechange = function() {
	            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	                var str = xmlhttp.responseText.split(",");
	                if(str == ""){
	                	document.location = "login.php?submit=yes";
	                	return;
	                }
	                document.getElementById("upcount" + id).innerHTML = str[0];
	                if(str[1] == "up"){
					$('#upvote' + id).removeClass('down');
					$('#upvote' + id).addClass('up');
	                }	
	                else if(str[1] == "down"){
					$('#upvote' + id).removeClass('up');
					$('#upvote' + id).addClass('down');
	                }
	            }
	        }
	        xmlhttp.open("GET", "upvote_count.php?for=" + id, true);
	        xmlhttp.send();
	    }
	</script>
</head>
<body>
<div class="container-fluid">
<?php
if(isset($_POST['s'])){
	$username=$_POST['user'];
	echo $_SESSION['user']=$username;
	$pwd=$_POST['password'];
	$pwd=md5($pwd);
	echo $_SESSION['password']=$pwd;
	echo "<script>parent.location.href='index.php';</script>";
}

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
				echo "Incorrect Password";
				die();
			}
	}
	//UPVOTE COUNT
	/*
	if(isset($_GET['for'])){

		if($result = $conn->query("SELECT up_votes FROM user_table WHERE user_name = '$loginUser'")){
				$table_id = $_GET['for'];
				$row = mysqli_fetch_array($result);
				$posts = explode(",",$row[0]); //To fetch all posts upvoted by user

				if($row[0]==NULL){

					echo $query = "UPDATE user_table SET up_votes = '$table_id' WHERE user_name = '$loginUser'";
			        $result = $conn->query($query);

					echo $query = "UPDATE posts_table SET up_votes = up_votes + 1 WHERE ID = $table_id";
					$result = $conn->query($query);
				}
			else{
					$flag=0;
					foreach($posts as $x){
						if($x == $table_id){
							$flag = 1;
							break;
						}
					}
					if($flag==0){
						echo $query = "UPDATE user_table SET up_votes = concat(up_votes, ',$table_id') WHERE user_name = '$loginUser'";
						$result = $conn->query($query);
						if(!$result)
						echo $conn->error;

						echo $query = "UPDATE posts_table SET up_votes = up_votes + 1 WHERE ID = $table_id";
						$result = $conn->query($query);

						if(!$result)
						echo $conn->error;
					}
			}		
		}
	}*/
}
else{
	//echo "<a href='login.html'>Sign In / Sign Up</a>";
	//echo "</br>Namaste, Guest";
	if(isset($_GET['for'])){
	echo "<script>parent.location.href='login.php';</script>";
	}
}

include("header.php");
?>
<div id="content">

<table>
<?php

$posts_query = "SELECT * FROM posts_table ORDER BY ID DESC";
$posts_result = $conn->query($posts_query);

if(!$posts_query)
echo $conn->error;

$count=0;
while($posts_row = mysqli_fetch_array($posts_result)){
	if($count < 30){
	$link = $posts_row[2];
	$title = $posts_row[1];
	$id = $posts_row[0]; //ID of the post
	$votes = $posts_row[3];
	$time = $posts_row[4];
	$res = $conn->query("SELECT user_name FROM user_table WHERE id=" . $posts_row[5]); //To fetch username of creator of post
	$post_user = mysqli_fetch_array($res);

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
	else{

		echo "<td>"  . "<span id='upvote$id' class='down' onclick='showCount($id)'><i class='fa fa-caret-up'></i></span></td>"; 

	}
	$img = "<img src='http://www.google.com/s2/favicons?domain=" . $link . "' height='16'>";

	echo "<td rowspan='2'>" . $img . "</td><td><a href='" . $link . "' target='_BLANK'>" . $title . "</a></td></tr><tr style='height: 0;'><td colspan='2'></td><td><span class='points'><span id='upcount$id' class='points'>". $posts_row[3] . "</span> points | </span><span class='points'>shared by <a href='#' class='points'>" . $post_user[0] . "</a> | " . time_elapsed_string($time) . "</span></td></tr>"; 
	$count++;
	}
}
?>
</table>
</div>
