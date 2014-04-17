<?php
//include('../imis-connector.php');
// Connect to MSSQL
$link = mssql_connect('sqlserver.aarc.org:1433', 'sa', 'aaRc11');

if (!$link) 
	{
    die('Something went wrong while connecting to MSSQL');
	}
	
if (!mssql_select_db('iMIS', $link)) {
  	die('Unable to select database!');
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Ethics Course Login</title>
</head>
<body>
<form action="check_login.php" method="post">
	<p>Username:</p>
	<input type="text" name="userName" col="50" />
	<p>Password:</p>
	<input type="password" name="userPassword" col="50" />
	<br />
	<input type="submit" value="login" />
	<br /><br />
	<a href="register.php">Register</a>
</form>
</body>
</html>
