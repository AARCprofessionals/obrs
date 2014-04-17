<?php
include('cn.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Ethics Course Registration Page</title>
</head>
<body>
<h1>Ethics Course Registration</h1>
<form action="commit_register.php" method="post">
	<p>Desired Username:</p>
	<input type="text" size="50" name="userUsername" />
	<p>Password:</p>
	<input type="password" size="50" name="userPassword" />
	<p>Re-type Password:</p>
	<input type="password" size="50" name="userPasswordConfirm" />
	<br />
	<input type="submit" value="register">
</form>
</body>
</html>
