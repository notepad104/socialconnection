<?php
	session_start();
	if(isset($_SESSION['user-login'])){
		header("Location: profile.php");
	}
	$error='';
	include "connect.php";

	if (isset($_POST['btn-login'])) {
		if (empty($_POST['username']) || empty($_POST['password'])) {
			$error = "Username or Password is invalid";
		}
		else
		{
			$user=$_POST['username'];
			$pass=$_POST['password'];
			$pass = md5($pass);
		// SQL query to fetch information of registerd users and finds user match.
			$query = mysql_query("SELECT username FROM users WHERE username='$user' AND password='$pass'", $conn);
			$rows = mysql_num_rows($query);
			if ($rows == 0) {
				$error = "Username or Password is invalid";
			} 
			else {
				$_SESSION['user-login'] = $user; // Initializing Session
				header("Location: profile.php"); // Redirecting To Other Page
			}
			mysql_close($conn); // Closing Connection
		}
	}
	else if(isset($_POST["btn-signup"])){
			$user=$_POST['username'];
			$pass=$_POST['password'];
			$pass = md5($pass);
					$insert = "INSERT INTO users ".
					       "(username, password) ".
					       "VALUES('$user','$pass')";
					$retval = mysql_query( $insert, $conn );
					mysql_close($conn);
					header("Location: index.php");
			}
?>
