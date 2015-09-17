<?php
  include("config.php");

?>
<html>
<head>

  <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <link href="style.css" rel="stylesheet">

  <meta charset="utf-8">
  <title>Login</title>
</head>


<body>
  <div class="container-fluid">
<?php
    include("header.php");
?>
  <?php
  if(isset($_GET['submit']) && !isset($loginUsername)){
    if($_GET['submit']=="yes"){
      echo "<h2 class=\"span7 text-center\">You need to be logged in to submit and upvote posts.</h2>";
    }
  }
  ?>
  <div class="col-md-4 col-md-offset-4">
  <div class="login-main"> <!-- Login -->
    <table class="sign-up">
      <th>Login</th>
      <th>Sign Up</th>

    <form class="form" method="post" action="index.php">
      <tr>
       <td><i class="fa fa-user"></i>
      <input type="text" name="user" placeholder="Username"/>
      </td>
    </tr>
    <tr>
      <td>
        <i class="fa fa-lock"></i>
        <input type="password" name="password" placeholder="Password"/>
      </td>
	   </tr>
     <tr>
      <td>
      <input type="submit" name="s" value="Login"></p>
    </td>
   </tr>
    </form>
  </table>
</div>
    <h1>Sign Up</h1>

    <form class="form" method="post" action="signup.php">
      <p class="field">
        <input type="text" name="signupUser" placeholder="Username"/>
        <i class="fa fa-user"></i>
      </p>

      <p class="field">
        <input type="password" name="signupPassword" placeholder="Password"/>
        <i class="fa fa-lock"></i>
      </p>

      <p class="field">
        <input type="password" name="rePassword" placeholder="Re-enter Password"/>
        <i class="fa fa-lock"></i>
      </p>

      <p class="submit"><input type="submit" name="s2" value="Login"></p>


      <p class="forgot">
        <a href="#" onclick="myfunction()">Help!</a>
      </p>
  </form>
</div>
<!--login modal-->
<a href="#" data-toggle="modal" data-target="#loginModal">Login</a>

<div id="loginModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
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
            </form>
            </div>
<div class="modal-header">
<h2 class="text-center">OR</h2>
  <h2 class="text-center">Register</h2>
</div>
      <div class="modal-body">
          <form class="form center-block" method="POST" action="signup.php">
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="signupUser" placeholder="Username">
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" name="signupPassword" placeholder="Password">
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" name="rePassword" placeholder="Re-enter Password">
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

