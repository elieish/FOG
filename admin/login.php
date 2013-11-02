<?php
/**
 * Project
 * 
 * @author Ralfe Poisson <ralfepoisson@gmail.com>
 * @version 1.0
 * @package Project
 */
 
# ===================================================
# SCRIPT SETTINGS
# ===================================================

# Start Session
session_start();

# Set Current Page
$cur_page = "login.php";

# Include Required Scripts
include_once ("../include/include.php");
include_once ("./include/include.inc.php");

# ===================================================
# DISPLAY FUNCTIONS
# ===================================================

function display() {
	# Global Variables
	global $_GLOBALS;
	
	?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html>
		<head>
			<title>CMS Login</title>
			<style>
				* {
					font-family: Arial, sans-serif;
				}
	
				body {
					background: #EDEFF1;
				}
				
				a {
					color: #555;
					font-size: 12px;
				}
				
				a:hover {
					color: #257dbc;
				}
				
				.login {
					width: 340px;
					padding: 10px 40px 40px; 
					font-size: 14px; 
					border: 1px solid #eee;
					background: #fff; 
					margin: 60px auto 0;
					
					-moz-border-radius: 12px;
					-webkit-border-radius: 12px;
					border-radius: 12px;
		
					-moz-box-shadow: 0 0 8px #ccc inset;
					-webkit-box-shadow: 0 0 8px #ccc inset;
					box-shadow: 0 0 8px #ccc inset;
				}
	
				
				h2 {
					color: #257dbc;
					margin-bottom: 20px;
				}
				
				.key {
					display: block;
					width: 24px;
					height: 27px;
					float: left;
					background: url(include/images/assets.png) -124px  -90px;
				}
				
				form {
					margin-bottom: 28px;
				}
				
				label {
					display: inline-block;
					font-size: 14px;
					color: #333;
					 	
				}
				
				input[type='text'],
				input[type='password'] {
					width: 95%;
					padding: 5px 4px;
					border: none;
					background: #fff;
					border: 1px solid #999;
					margin-bottom: 16px;
					font-size: 14px;
					
					-moz-border-radius: 2px;
					-webkit-border-radius: 2px;
					border-radius: 2px;
				}

			
				input[value='Login'] {
					display: block;
					width: 125px;
					padding: 8px 0;
					margin: 0 auto;
					background: #0C0;
					border: 1px solid #0C0;
					color: #fff;
					font-size: 21px;
					text-shadow: 0 0 1px #0C0;
					background-position: 0 0;
					cursor: pointer;
					cursor: hand;
					
					-moz-border-radius: 6px;
					-webkit-border-radius: 6px;
					border-radius: 6px;
				}
				
				input[value='Login']:hover {
					border: 1px solid #1d7d16;
					text-shadow: 0 0 3px #1d7d16;
					
					background: #01b501;
					background: -moz-linear-gradient(top, #00cc00 0%, #00af00 100%);
					background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#00cc00), color-stop(100%,#00af00));
					/*background: -webkit-linear-gradient(top, #00cc00 0%,#00af00 100%);*/
					background: -o-linear-gradient(top, #00cc00 0%,#00af00 100%);
					background: -ms-linear-gradient(top, #00cc00 0%,#00af00 100%);
					background: linear-gradient(top, #00cc00 0%,#00af00 100%);
				}
				
				input[value='Login']:active {
					-moz-box-shadow: 0 0 8px #0a800a inset;
					-webkit-box-shadow: 0 0 8px #0a800a inset;
					box-shadow: 0 0 8px #0a800a inset
				}
				
				.error {
					font-weight: bold;
					color; #FFDDDD;
				}
				
			</style>
		</head>
		<body>
		<div id='ajax_content'>
	        
			<div class='login'>
		
	    		<h2><span class='key'></span>Login</h2>
				
	    		<form method='POST' action='login.php?action=login'>
					<label>User Name</label>
					<br />
					<input type='text' name='username' />
					<br />
					<label>Password</label>
					<br />
	
					<input type='password' name='password' />
					<br />
					<input type='submit' value='Login' name='login' />
				</form>
	            <a href='mailto:admin@foundationofgrace.org.za'>Lost your password?</a>
			</div>
	        
	        
	        
		</div>
	    
	</body>
	</html><?php
}

# ===================================================
# PROCESSING FUNCTIONS
# ===================================================

function login() {
	# Global Variables
	global $cur_page, $_db, $_GLOBALS;
        
        # Check if user is attempting to be authenticated
	if (isset($_POST['login'])){
		# Get POST Data
		$username														= $_POST['username'];
		$password														= md5($_POST['password']);
		
		# Compare to database
		$query															= "	SELECT
																				COUNT(*)
																			FROM
																				`users`
																			WHERE
																				`username` = \"$username\"
																				AND `password` = \"$password\"";
		$result															= $_db->query($query);
		$row															= mysql_fetch_row($result);
		$auth															= $row[0];
		
		# Handle Comparison Result
		if ($auth){
			# Get User Details
			$result 													= $_db->query("	SELECT
																							* 
																						FROM
																							`users` 
																						WHERE
																							`username` = \"$username\" 
																							AND `password` = \"$password\"");
			$user 														= mysql_fetch_object($result);
			
			# Set SESSION Details
			$_SESSION['user_uid']										= $user->uid;
			$_SESSION['user_username']									= $user->username;
			
			# Log Activity
			//logg("Login : Login Successful. Username = `$username`.");
			
			# Redirect
			unset($_SESSION['login_error']);
			if (isset($_SESSION['accessing_page'])) {
				redirect($_SESSION['accessing_page']);
			}
			else {
				redirect("./");
			}
		}
		else {
			# Destroy SESSION Details
			session_destroy();
			
			# Display Error Message
			//logg ("Login : Authentication FAILED! Username = `$username`.", "ALERT");
			$_SESSION['login_error'] 									= "Login Failed. Please Try Aagain.";
			display();
		}
	}
}

# ===================================================
# ACTION HANDLER
# ===================================================

if (isset($_GET['action'])){
	$action = $_GET['action'];
	if ($action == "display"){
		display();
	}
	else if ($action == "login"){
		login();
	}
	else {
		print "<div class='error'><b>Error</b> : Invalid Action `$action`.</div>\n";
	}
}
else {
	display();
}

# ===================================================
# THE END
# ===================================================

?>