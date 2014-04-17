<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Registration Complete</title>
</head>
<body>
<?php
include('cn.php');
	
$userUsername = $_POST['userUsername'];
$userPassword = $_POST['userPassword'];
$userPasswordConfirm = $_POST['userPasswordConfirm'];


// Prevent MySQL Injections
$userUsername = mysql_real_escape_string(stripslashes($userUsername));
$userPassword = mysql_real_escape_string(stripslashes($userPassword));
$userPasswordConfirm = mysql_real_escape_string(stripslashes($userPasswordConfirm));

// Get all users that exist in the user table 
$sql = "SELECT * FROM user";
$resultCount = mysql_query($sql, $cn) or
	die(mysql_error($cn));

// Check how many results returned in previous query for existing users
$num_users = mysql_num_rows($resultCount);
	

// Check each row to see if the user-selected username is in use
$row_count = -1;
while ($row_count < $num_users) {
	$data = mysql_fetch_object($resultCount);
	$row_count++;
	
	// If username is already in use alert user
	if ($data->user_username == $userUsername) {
		echo '<p>The username "' . $userUsername . '" is not available. Select another.</p>';
		$row_count = $num_users;
	} else if ($row_count == $num_users) {
		echo '<p>The username "' . $userUsername . '" has been selected.</p>';
		
		// Check the password fields match
		if ($userPassword != $userPasswordConfirm) {
			echo '<p>Passwords do not match. Try again.</p>';
			echo '<p><strong>New user has not been created.</strong></p>';
		} else {
			echo '<p>Passwords match!</p>';
			
			$userJoinDate = time();
			
			$sql = "INSERT INTO
					user
				(user_username,
				 user_password,
				 user_join_date)
					VALUES
				('" . $userUsername . "',
				 '" . $userPassword . "',
				 '" . $userJoinDate . "')";
			$result = mysql_query($sql, $cn) or
				die(mysql_error($cn));
			
			echo "<p><strong>The username '" . $userUsername . "' has been created. Please login <a href='login.php'>here</a>.</strong></p>";
		}
	}
}
?>
</body>
</html>
