<?php
	//session_start();
	if (!isset($_SESSION['user-login'])) {
		header("Location: index.php");
	}
	$result="";
	if (isset($_POST['btn-status'])) {
		if (empty($_POST['status']) ) {
			$error = "Post Empty!!";
		}
		else
		{
			$status=$_POST['status'];
			$user = $_SESSION['user-login'];
			include "connect.php";
		// SQL query to fetch information of registerd users and finds user match.
			$query = mysql_query("INSERT INTO status (username, updates) VALUES ('$user', '$status')", $conn);
			$result = "Post Updated!!";
		}
	}
		//header("Location: profile.php"); // Redirecting To Other Page
?>