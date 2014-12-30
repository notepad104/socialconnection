<?php
	include "connect.php";
	session_start();
	if (!isset($_SESSION['user-login'])) {
		header("Location: index.php");
	}
	// Storing Session
	$user_check=$_SESSION['user-login'];
	// SQL Query To Fetch Complete Information Of User
	$ses_sql=mysql_query("SELECT username from users where username='$user_check'", $conn);
	$row = mysql_fetch_assoc($ses_sql);
	$login_session =$row['username'];
	if(!isset($login_session)){
		mysql_close($connection); // Closing Connection
		header('Location: index.php'); // Redirecting To Home Page
	}
	if (isset($_SESSION['user-login'])) {
		$user = $_SESSION["user-login"];
	}
	else {
		$user = "";
	}
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title><?php echo $user ?></title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src = "js/bootstrap.js"></script>
		<script type="text/javascript" src = "js/bootstrap.min.js"></script>
	</head>
	<body>
	<ul class="nav nav-pills nav-justified">
	  <li id="profile" class="active"><a href="profile.php"><?php echo $user ?></a></li>
	  <li id="friends"><a href="friends.php">Friends</a></li>
	  <li id="logout" ><a href="logout.php">Logout</a></li>
	</ul>
	<style>
	h1, h2, h3, h5,h6 {
	        text-align: center;
	}
	</style>
	<hr>
	<h1 class=""><?php echo "Welcome " . $user; ?> </h1> 