<?php
	include "session.php";
	include "postupdate.php";
?>
<div class="container">
	<div class="row">
		<form class="col-lg-5 col-md-5 col-sm-5" method = "post" >
			<h3 class="control-label" for="status">Post a new Update</h3>
			<textarea class="form-control" style="resize :none;" id="status" name="status"></textarea>
			<hr>
			<input type="submit" id="btn-status" name = "btn-status" class="btn btn-success" onclick = "success()" value="Post">
			<div id = "result"><?php echo $result;?></div>
		</form>
		<div class="col-lg-5 col-md-5 col-sm-5">
			<h3 class="control-label" for="updates">Updates from Friends</h3>
			<?php
				$friendString = "";
				$friendArray = array();
				$selectFriendsQuery = mysql_query("SELECT friends FROM users WHERE username='$user'");
				$friendRow = mysql_fetch_assoc($selectFriendsQuery);
				$friendString = $friendRow['friends'];
				if ($friendString != "") {
				   $friendArray = explode(",",$friendString);
				}
				$str = "";
				$size = count($friendArray);
				if($size != 0){
					for ($i = 0; $i < $size; $i++) {
						$value = $friendArray[$i];
						$str = $str."SELECT time, username, updates from status WHERE username = '$value' UNION ";
					}
					$str = $str."SELECT time, username, updates from status WHERE username = '$value' ORDER BY time DESC";
					//echo $str;
					$getposts = mysql_query($str, $conn);
					$count = 0;
					while ($row = mysql_fetch_assoc($getposts)) {	
						$count++;
						if($count > 20)
							break;
				?>
						<div >
							<h4> Update from <?php echo $row['username']; ?> <small> -- <?php echo date('Y-m-d H:i:s', strtotime($row['time'])); ?></small></h4>
							<p>
								<?php echo $row['updates']; ?>
							</p>
						</div>
						<hr>
				<?php
					}
				}
				else{
					?>
					<p>No Updates yet!!</p>
				<?php
				}
				?>
		</div>
	</div>
</div>
	

</body>
</html>