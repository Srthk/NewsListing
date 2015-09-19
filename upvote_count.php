<?php
include('config.php');
$conn = new mysqli(HOST,USER,PASSWORD,DATABASE);
if(isset($_GET['for']) && isset($loginUser)){

	$id = fetchID($conn, $loginUser);
	$table_id = $_GET['for']; //post to upvote in table
	$result = $conn->query("SELECT post_id FROM votes_table WHERE user_id = $id AND post_id  = $table_id");		
	$conn->error;
	$row = mysqli_fetch_array($result);

	if($row[0]==$table_id){
			$query = "DELETE FROM votes_table WHERE user_id = $id AND post_id  = $table_id";
			$result = $conn->query($query);
			$query = "UPDATE posts_table SET up_votes = up_votes - 1 WHERE ID = $table_id";
			$result = $conn->query($query);
			if(!$result)
			$conn->error;
			$flag="down";
		}
	else{
			$query = "INSERT INTO votes_table (user_id, post_id) VALUES ($id, $table_id)";
			$result = $conn->query($query);
			$query = "UPDATE posts_table SET up_votes = up_votes + 1 WHERE ID = $table_id";
			$result = $conn->query($query);
			if(!$result)
			$conn->error;
			$flag="up";			
	}
$posts_query = "SELECT up_votes FROM posts_table WHERE ID=" . $_GET['for'];
$posts_result = $conn->query($posts_query);
$posts_row = mysqli_fetch_array($posts_result);

if($posts_row[0] == 1)
	echo $posts_row[0] . " point," . $flag;
else
	echo $posts_row[0] . " points," . $flag;

}
?>