<?php
include('cn.php');
session_start(); 

$userUsername = $_POST['userUsername'];
$userPassword = $_POST['userPassword'];

// Protect against MySQL injection
$userUsername = mysql_real_escape_string(stripslashes($userUsername));
$userPassword = mysql_real_escape_string(stripslashes($userPassword));

$sql = "SELECT * FROM user
		WHERE
	user_username = '$userUsername' and
	user_password = '$userPassword'";
$result = mysql_query($sql, $cn) or
	die(mysql_error($cn));
	
// Check if the specified user was found in database
$numberOfUsersFound = mysql_num_rows($result);

if($numberOfUsersFound == 1) {
	echo '<p>Login successful. Go to your <a href="profile.php">profiles page</a>.</p>';
	
	$_SESSION['ethicsLoggedInUser'] = $userUsername;
} else {
	echo '<p>Wrong Username or Password. Return to <a href="login.php">login page</a>.</p>';
}
?>
