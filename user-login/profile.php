<?php
include('cn.php');
session_start();

$userUsername = $_SESSION['ethicsLoggedInUser'];

// Select Profile-specific info for user
$sql = "SELECT * FROM user WHERE
	user_username = '" . $userUsername . "'";
$result = mysql_query($sql, $cn) or
	die(mysql_error($cn));
$row = mysql_fetch_assoc($result);

$userJoinDateLinux = $row['user_join_date'];

// convert user join date time from linux to readable format
// F = full month, j = date, s = suffix for date, y = year
$userJoinDate = date("F jS, Y", $userJoinDateLinux);

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $userUsername; ?>'s Profile</title>
</head>
<body>
<h1>Your Profile</h1>
<h2>Welcome <?php echo $userUsername; ?></h2>
<h3><a href="logout.php">[LOGOUT]</a></h3>
<br />
<br />
<h3>Registration status:</h3>
<p>Membership active since <?php echo $userJoinDate; ?>.</p>
</body>
</html>
