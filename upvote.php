<?php
include('config.php');
$conn = new mysqli(HOST,USER,PASSWORD,DATABASE);

if(isset($_GET['for']) && isset($loginUser)){

	if($result = $conn->query("SELECT up_votes FROM user_table WHERE user_name = '$loginUser'")){
			$table_id = $_GET['for'];
			$row = mysqli_fetch_array($result);
			$posts = explode(",",$row[0]); //To fetch all posts upvoted by user

			if($row[0]==NULL){

				$query = "UPDATE user_table SET up_votes = '$table_id' WHERE user_name = '$loginUser'";
		        $result = $conn->query($query);

				$query = "UPDATE posts_table SET up_votes = up_votes + 1 WHERE ID = $table_id";
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
						$query = "UPDATE user_table SET up_votes = concat(up_votes, ',$table_id') WHERE user_name = '$loginUser'";
						$result = $conn->query($query);
						if(!$result)
						$conn->error;

						$query = "UPDATE posts_table SET up_votes = up_votes + 1 WHERE ID = $table_id";
						$result = $conn->query($query);

						if(!$result)
						$conn->error;
					}
			}		
	}
$posts_query = "SELECT up_votes FROM posts_table WHERE ID=" . $_GET['for'];
$posts_result = $conn->query($posts_query);
$posts_row = mysqli_fetch_array($posts_result);
echo $posts_row[0];
}
?>