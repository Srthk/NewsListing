<?php
include("header.php");
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
  <div class="login"> <!-- Login -->
    <h1>Login</h1>

    <form class="form" method="post" action="index.php">
      <p class="field">
        <input type="text" name="user" placeholder="Username"/>
        <i class="fa fa-user"></i>
      </p>

      <p class="field">
        <input type="password" name="password" placeholder="Password"/>
        <i class="fa fa-lock"></i>
      </p>
	 

      <p class="submit"><input type="submit" name="s" value="Login"></p>


      <p class="forgot">
        <a href="#" onclick="myfunction()">Help!</a>
      </p>

    </form>

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