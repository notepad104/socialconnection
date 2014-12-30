<?php
include "check.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Social Connection</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src = "js/bootstrap.js"></script>
	<script type="text/javascript" src = "js/bootstrap.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
	    $('#btn-signup').attr('disabled', true);
	    $('#btn-login').attr('disabled', true);
	    $('#username').keyup(function(){ // Keyup function for check the user action in input
	        var Username = $(this).val(); // Get the username textbox using $(this) or you can use directly $('#username')
	        var UsernameAvailResult = $('#username_avail_result'); // Get the ID of the result where we gonna display the results
	        if(Username.length > 2) { // check if greater than 2 (minimum 3)
	        	console.log(Username);	
	            UsernameAvailResult.html('Loading..'); // Preloader, use can use loading animation here
	            var UrlToPass = 'action=username_availability&username='+Username;
	            $.ajax({ // Send the username val to another check.php using Ajax in POST menthod
	            type : 'POST',
	            data : UrlToPass,
	            url  : 'checker.php',
	            success: function(responseText){ // Get the result and asign to each cases
	                if(responseText == 0){
	                    UsernameAvailResult.html('<span >Username name available</span>');
	                    $('#btn-signup').attr('disabled', false);
	                    $('#btn-login').attr('disabled', true);
   				 	}	
	                else if(responseText > 0){
	                    UsernameAvailResult.html('<span class="form-control">Username already taken</span>');
	                    $('#btn-signup').attr('disabled', true);
	                    $('#btn-login').attr('disabled', false);
	                }
	                else{
	                    alert('Problem with sql query');
	                    $('#btn-signup').attr('disabled', true);
	                    $('#btn-login').attr('disabled', true);
	                }
	            }
	            });
	        }else{
	            UsernameAvailResult.html('Enter atleast 3 characters');
	            $('#btn-signup').attr('disabled', true);
	        }
	        if(Username.length == 0) {
	            UsernameAvailResult.html('');
	        }
	        $('#btn-signup').attr('disabled', true);
	    });
	     
	    $('#password, #username').keydown(function(e) { // Dont allow users to enter spaces for their username and passwords
	        if (e.which == 32) {
	            return false;
	        }
	    });
	});
	</script>
</head>
<body>
<section id="login">
    <div class="container">
    	<div class="row">
    	    <div class="col-xs-12">
        	    <div class="form-wrap">
                <h1>Log in/ Sign up</h1>
                    <form role="form" method="post" action = "" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <input type="text" name="username" id="username" class="form-control username" placeholder="Username">
                        	<div class="username_avail_result" id="username_avail_result"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control password" placeholder="Password">
                        </div>
                        <center>
                        <input type="submit" id="btn-login" name = "btn-login" class="btn btn-default" value="Log in">
                        <input type="submit" id="btn-signup" name = "btn-signup" class="btn btn-default" value="Sign Up" disabled="true">
                        </center>
                        <span><?php echo $error; ?></span>
                    </form>
                    <hr>
        	    </div>
    		</div> <!-- /.col-xs-12 -->
    	</div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

</body>
</html>
</html>