<?php
$cn = mysql_connect('localhost', 'root', 'aaRC94@%') or
	die('Something went wrong. Check connection parameters.');

$sql = 'CREATE DATABASE IF NOT EXISTS rhondak';	
mysql_query($sql, $cn) or
	die(mysql_error($cn));
	
mysql_select_db('rhondak') or
	die(mysql_error($cn));

$sql = 'CREATE TABLE IF NOT EXISTS user (
		user_id				INTEGER	UNSIGNED		NOT NULL AUTO_INCREMENT,
		user_username		VARCHAR(80)				NOT NULL,
		user_password		VARCHAR(80)				NOT NULL,
		user_join_date		INTEGER UNSIGNED		NOT NULL,
				
		PRIMARY KEY (user_id)
	)
	ENGINE=MyISAM';
mysql_query($sql, $cn) or
	die(mysql_error($cn));
	
echo "The table 'user' has been successfully created in the database 'rhonda'. <br /><br /> Go to the <a href='login.php'>login page</a>.";
?>
