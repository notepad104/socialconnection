<?php
	include "session.php";
	include "postupdate.php";
?>
<div class="container" >
	<div class="row">
		<div class="col-md-3">
			<h3 class="control-label" for="status">Friend Requests</h3>
			<?php
			//Friend Array
				$friendString = "";
				$selectFriendsQuery = mysql_query("SELECT friends FROM users WHERE username='$user'");
				$friendRow = mysql_fetch_assoc($selectFriendsQuery);
				$friendString = $friendRow['friends'];
			
			//Sent Request Array
				$query = mysql_query("SELECT requests_sent from users WHERE username = '$user'", $conn);
				$requestsSent = mysql_fetch_assoc($query);
				$requestSentString = $requestsSent['requests_sent'];
				if($requestSentString != ""){
					$requestSentArray = explode(",", $requestSentString);
				
					for($i = 0; $i < count($requestSentArray); $i++){
						$mapFriends[$requestSentArray[$i]] = 1;
					}
				}

				//Request Array	
				$query = mysql_query("SELECT requests from users WHERE username = '$user'", $conn);
				$requestRow = mysql_fetch_assoc($query);
				$requestString = $requestRow['requests'];
				$requestArray = array();
				if ($requestString != "") {
				   $requestArray = explode(",",$requestString);
				}
				$requestSize = count($requestArray);
				for($i = 0; $i < $requestSize; $i++){
					$value = $requestArray[$i];
					$mapFriends[$value] = 1;
					echo "<form method='post' name='requestform'>";
					echo $value;
					echo "   <input type='submit' class = 'btn btn-sm btn-success' name='accept' value='Accept'>";
					echo "   <input type='submit' class = 'btn btn-sm btn-danger' name='reject' value='Reject'>";
					echo "<input type = 'hidden' name='requestname' value ='".$value."'>";
					echo "<br><br></form>";
				}
				if (isset($_POST['accept'])) {
					$requestname = $_POST['requestname'];
					//adding requested person to user friend list
					if($friendString != "")
						$friendString = $friendString.",".$requestname;
					else
						$friendString = $requestname;
					$query = mysql_query("UPDATE users SET friends = '$friendString' WHERE username = '$user'");

					//adding user to requested person friendlist
					$selectuserQuery = mysql_query("SELECT friends FROM users WHERE username='$requestname'");
					$userRow = mysql_fetch_assoc($selectuserQuery);
					$userString = $userRow['friends'];
					if($userString != "")
						$userString = $userString.",".$user;
					else
						$userString = $user;
					$query = mysql_query("UPDATE users SET friends = '$userString' WHERE username = '$requestname'");


					//removing requested person from users requests
					$new_string = "";
					for($i = 0; $i < $requestSize; $i++){
						if($requestArray[$i] != $requestname){
							$new_string = $new_string.$requestArray[$i].",";
						}
					}
					$new_string = substr($new_string, 0, sizeof($new_string) - 2);
					echo $new_string;
					$query = mysql_query("UPDATE users SET requests = '$new_string' WHERE username = '$user'");

					//removing user from requested person's request sent
					$query = mysql_query("SELECT requests_sent from users WHERE username = '$requestname'", $conn);
					$sentRequestRow = mysql_fetch_assoc($query);
					$sentRequestString = $sentRequestRow['requests_sent'];
					$sentRequestArray = array();
					if ($sentRequestString != "") {
					   $sentRequestArray = explode(",",$sentRequestString);
					   $sentRequestSize = count($sentRequestArray);
						$new_string = "";
						$new_string.substr(string, start);
						for($i = 0; $i < $sentRequestSize; $i++){
							if($sentRequestArray[$i] != $user){
									$new_string = $new_string.$sentRequestArray[$i].",";
							}
						}
						$new_string = substr($new_string, 0, sizeof($new_string) - 2);
						echo $new_string;
						$query = mysql_query("UPDATE users SET requests_sent = '$new_string' WHERE username = '$requestname'");
					}
					header("Location: friends.php");
				}

				if (isset($_POST['reject'])) {
					$requestname = $_POST['requestname'];
					$new_string = "";
					for($i = 0; $i < $requestSize; $i++){
						if($requestArray[$i] != $requestname){
								$new_string = $new_string.$requestArray[$i].",";
						}
					}
					$new_string = substr($new_string, 0, sizeof($new_string) - 2);
					echo $new_string;
					$query = mysql_query("UPDATE users SET requests = '$new_string' WHERE username = '$user'");

					//removing user from requested person's request sent
					$query = mysql_query("SELECT requests_sent from users WHERE username = '$requestname'", $conn);
					$sentRequestRow = mysql_fetch_assoc($query);
					$sentRequestString = $sentRequestRow['requests_sent'];
					$sentRequestArray = array();
					if ($sentRequestString != "") {
					   $sentRequestArray = explode(",",$sentRequestString);
					   $sentRequestSize = count($sentRequestArray);
						$new_string = "";
						for($i = 0; $i < $sentRequestSize; $i++){
							if($sentRequestArray[$i] != $user){
									$new_string = $new_string.$sentRequestArray[$i].",";
							}
						}
						$new_string = substr($new_string, 0, sizeof($new_string) - 2);
						echo $new_string;
						$query = mysql_query("UPDATE users SET requests_sent = '$new_string' WHERE username = '$requestname'");
					}
					header("Location: friends.php");
				}
			?>
		</div>
		<div class="col-md-3 col-md-offset-1">
			<h3 class="control-label" for="removingfriends">Friends</h3>
			<?php
				$friendArray = array();
				if ($friendString != "") {
				   $friendArray = explode(",",$friendString);
				}
				$size = count($friendArray);
				if($size != 0){
					for ($i = 0; $i < $size; $i++) {
						$value = $friendArray[$i];
						$mapFriends[$value] = 1;
			?>
					<form method="post" name="unfriendform">
					<?php echo $value; 
						echo "  <input type='submit' class = 'btn btn-sm btn-danger' name='remove' value='Unfriend'>";
						echo "<input type = 'hidden' name='friendname' value ='".$value."'>"
					?>
					<br><br>
					</form>
			<?php
					}
				}
			?>
		<?php
			if (isset($_POST['remove'])) {
				$friendname = $_POST['friendname'];
				// remove friend from user friendlist
				$new_string = "";
				if($friendString != ""){
					for($i = 0; $i < $size ; $i++){
						if($friendname != $friendArray[$i]){
								$new_string = $new_string.$friendArray[$i].",";
						}
						else{
							$mapFriends[$friendname] = NULL;
						}
					}
					$new_string = substr($new_string, 0, sizeof($new_string) - 2);
					$query = mysql_query("UPDATE users SET friends = '$new_string' WHERE username = '$user'", $conn);
				}
				// remove user from friend's friendlist
				$userString = "";
				$selectuserQuery = mysql_query("SELECT friends FROM users WHERE username='$friendname'");
				$userRow = mysql_fetch_assoc($selectuserQuery);
				$userString = $userRow['friends'];
				$userArray = array();
				$new_string = "";
				if ($userString != "") {
				   $friendArray = explode(",",$friendString);
				   $usersize = count($userArray);
					for($i = 0; $i < $usersize ; $i++){
						if($user != $userArray[$i]){
								$new_string = $new_string.$userArray[$i].",";
						}
					}
					$new_string = substr($new_string, 0, sizeof($new_string) - 2);
					$query = mysql_query("UPDATE users SET friends = '$new_string' WHERE username = '$friendname'", $conn);
				}

				header("Location: friends.php");
			}
		?>
		</div>
		<div class="col-md-3 col-md-offset-1">
			<h3 class="control-label" for="status">All Users</h3>
			<?php
				$query = mysql_query("SELECT username from users WHERE username != '$user'", $conn);
				while($get_users = mysql_fetch_assoc($query)){
					$username = $get_users['username'];
					$c = 0;
					if (!isset($mapFriends[$username])){
						if($c > 20)
							break;
						echo "<form method='post' name='addfriendform'>";
						echo $username; 
						echo "  <input type='submit' class = 'btn btn-sm btn-primary' name='add' value='Add'>";
						echo "<input type = 'hidden' name='addfriend' value ='".$username."'>";
						echo "<br><br></form>";
						$c++;
					}
				}
				if (isset($_POST['add'])) {
					$friendname = $_POST['addfriend'];
					$mapFriends[$friendname] = 1;
					$query = mysql_query("SELECT requests from users WHERE username = '$friendname'", $conn);
					if($query){
						$requests = mysql_fetch_assoc($query);
						$requestString = $requests['requests'];
					}
					if(strstr($requestString, $user)){
						$new_string = $requestString;
					}
					else if($requestString != "")
						$new_string = $requestString.",".$user;
					else
						$new_string = $user;	
					$query = mysql_query("UPDATE users SET requests = '$new_string' WHERE username = '$friendname'", $conn);

					
					$flag = 0;
					$new_string = "";
					for($i = 0; $i < count($requestSentArray); $i++){
						$value = $requestSentArray[$i];
						if($friendname == $value){
							$flag = 1;
							$new_string = $requestSentString;
							break;
						}
					}
					if($flag == 0){
						if($requestSentString != "")
								$new_string = $requestSentString.",".$friendname;
						else
							$new_string = $friendname;	
					}
					$query = mysql_query("UPDATE users SET requests_sent = '$new_string' WHERE username = '$user'", $conn);

					header("Location: friends.php");
				}
			?>
		</div>
	</div>
</div>
</body>
</html>