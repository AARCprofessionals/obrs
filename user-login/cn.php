<?php
$cn = mysql_connect('localhost', 'root', 'aaRC94@%') or
	die('Unable to connect. Something went wrong.');
mysql_select_db('rhondak', $cn) or
	die(mysql_error($cn));

?>
